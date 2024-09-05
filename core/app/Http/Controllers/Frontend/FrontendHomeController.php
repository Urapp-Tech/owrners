<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Contracts\ProjectServiceContract;
use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Project;
use App\Models\Search;
use App\Models\SearchCount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Auth;
use Modules\Service\Entities\Category;
use Modules\Service\Entities\CategoryType;
use Modules\Service\Entities\SubCategory;

class FrontendHomeController extends Controller
{
    public function project_or_job_search(Request $request)
    {
        $search_type = $request->search_type ?? '';
        if($search_type == 'project')
        {
            $projects_or_jobs = Project::with('project_creator')
                ->select(['id','title','slug','user_id','basic_regular_charge','image'])
                ->where('project_on_off','1')
                ->unsuspendCreator()
                ->where('status','1')
                ->latest()
                ->where('title','LIKE','%'.strip_tags($request->job_search_string).'%')->get();
        }else if($search_type == 'job'){
            $projects_or_jobs = JobPost::with('job_creator','job_skills')
                ->select('id','title','slug','user_id','budget')
                ->where('on_off','1')
                ->unsuspendCreator()
                ->where('status','1')
                ->where('job_approve_request','1')
                ->latest()
                ->where('title','LIKE','%'.strip_tags($request->job_search_string).'%')->get();
        }else{
            $projects_or_jobs =  User::with('user_introduction')
                ->select('id', 'username','first_name','last_name','image','country_id','state_id')
                ->where('user_type','2')
                ->where('is_email_verified',1)
                ->where('is_suspend',0)
                ->whereHas('user_introduction', function($q) use ($request){
                $q->where('title', 'LIKE', '%'.strip_tags($request->job_search_string).'%');
            })->get();
        }
        return view('frontend.pages.frontend-home-job-search-result',compact(['projects_or_jobs','search_type']))->render();
    }

    public function search_by_keyword(Request $request) {
        $search_value = strip_tags($request->search_string ?? '') ;
        $user = Auth::guard('web')->user();
        $old_searches = [];

        if($user) {
            $old_searches  = Search::where('user_id', $user->id)->where('search_term', 'LIKE','%' .  $search_value . '%')->latest()->take(3)->get();
        }

        $search_terms = SearchCount::where('search_term','LIKE','%' .  $search_value . '%')->orderByDesc('count')->get();

        $subcategories = SubCategory::where('sub_category', 'LIKE', '%' . $search_value . '%')->take(10)->get()->pluck('sub_category')->all();

        $categories = Category::where('category', 'LIKE', '%' . $search_value . '%')->take(10)->get()->pluck('category')->all();
        
        $categoryType = CategoryType::where('name', 'LIKE', '%' . $search_value . '%')->take(10)->get()->pluck('name')->all();

        $services = array_unique( array_merge($subcategories, $categories, $categoryType));

        
        return view('frontend.pages.frontend-home-keyword-search-result',compact(['search_terms', 'services', 'old_searches']))->render();
    }


    public function query_keywords_project (Request $request, ProjectServiceContract $projectService) {
        $search_query =  strip_tags( $request->input('query') ?? '');
        $user = Auth::guard('web')->user();

        if($user) {
            $already_searched =  Search::where('user_id', $user->id)->where('search_term', $search_query)->exists();
            if(!$already_searched) {
                Search::create([
                    'user_id' => $user->id,
                    'search_term' => $search_query,
                ]);
            }
        }

        $searchCount = SearchCount::firstOrCreate(['search_term' => $search_query]);
        $searchCount->increment('count');

        $category  = Category::where('category', $search_query)->first();
        $sub_category  = SubCategory::where('sub_category', $search_query)->first();
        $category_type  = CategoryType::where('name', $search_query)->first();

        $category_ids = [];
        
        if($category) {
            $category_ids[] = $category->id;
        }
        if($sub_category) {
            $category_ids[] = $sub_category->category_id;
        }
        if($category_type) {
            $category_ids[] = $category_type->category_id;
        }

        $projects = Project::with('project_creator')
                    ->where(function ($q) use ($search_query){
                        $q->unsuspendCreator()
                        ->where('status','1')
                        ->where('title' , 'LIKE','%'. $search_query . '%')
                        ->where('project_on_off','1');
                    })
                    ->withCount('complete_orders')
                    ->withAvg(['ratings' => function ($query){
                        $query->where('sender_type', 1);
                    }],'rating')
                    ->orWhere(function ($q) use($category_ids) {
                        $q->orWhereIn('category_id',$category_ids)
                        ->unsuspendCreator()
                        ->where('status','1')
                        ->where('project_on_off','1');
                    });

        if (isset($request->country) && !empty($request->country)) {
            $projects = $projects->WhereHas('project_creator', function ($q) use ($request) {
                $q->where('country_id', $request->country);
            });
        }

        if (isset($request->level) && !empty($request->level)) {
            $projects = $projects->WhereHas('project_creator', function ($q) use ($request) {
                $q->where('experience_level', $request->level);
            });
        }

        if (isset($request->search) && !empty($request->search)) {
            $projects = $projects->where('title', 'LIKE','%' . $request->search . '%');
        }

        if(!empty($request->rating)){
            $projects = $projects
                ->having('ratings_avg_rating',">", $request->rating -1)
                ->having('ratings_avg_rating',"<=", $request->rating);
        }

        $projects = $projects
                    ->orderBy('complete_orders_count','Desc')
                    ->orderBy('ratings_avg_rating','Desc')
                    ->paginate(10);

        $projectService->logProjectImpression($projects->pluck('id')->toArray());
                    
        return view('frontend.pages.search-projects.projects',compact('projects', 'search_query'));
    }

    public function query_keywords_project_filter (Request $request, ProjectServiceContract $projectService) {
        $search_query =  strip_tags( $request->input('query') ?? '');
        $user = Auth::guard('web')->user();

        $category  = Category::where('category', $search_query)->first();
        $sub_category  = SubCategory::where('sub_category', $search_query)->first();
        $category_type  = CategoryType::where('name', $search_query)->first();

        $category_ids = [];
        
        if($category) {
            $category_ids[] = $category->id;
        }
        if($sub_category) {
            $category_ids[] = $sub_category->category_id;
        }
        if($category_type) {
            $category_ids[] = $category_type->category_id;
        }

        $projects = Project::with('project_creator')
        ->where(function ($q) use ($search_query){
            $q->unsuspendCreator()
            ->where('status','1')
            ->where('title' , 'LIKE','%'. $search_query . '%')
            ->where('project_on_off','1');
        })
        ->withCount('complete_orders')
        ->withAvg(['ratings' => function ($query){
            $query->where('sender_type', 1);
        }],'rating')
        ->orWhere(function ($q) use($category_ids) {
            $q->orWhereIn('category_id',$category_ids)
            ->unsuspendCreator()
            ->where('status','1')
            ->where('project_on_off','1');
        });


        if (isset($request->country) && !empty($request->country)) {
            $projects = $projects->WhereHas('project_creator', function ($q) use ($request) {
                $q->where('country_id', $request->country);
            });
        }

        if (isset($request->level) && !empty($request->level)) {
            $projects = $projects->WhereHas('project_creator', function ($q) use ($request) {
                $q->where('experience_level', $request->level);
            });
        }

        if (isset($request->search) && !empty($request->search)) {
            $projects = $projects->where('title', 'LIKE','%' . $request->search . '%');
        }

        if(!empty($request->rating)){
            $projects = $projects
                ->having('ratings_avg_rating',">", $request->rating -1)
                ->having('ratings_avg_rating',"<=", $request->rating);
        }

        $projects = $projects
                    ->orderBy('complete_orders_count','Desc')
                    ->orderBy('ratings_avg_rating','Desc')
                    ->paginate(10);

        $projectService->logProjectImpression($projects->pluck('id')->toArray());
                    
        return $projects->total() >= 1 ? view('frontend.pages.search-projects.search-keywords-result',compact('projects'))->render() : response()->json(['status'=>__('nothing')]);
    }

}
