<?php

namespace Modules\Service\Http\Controllers\Backend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Service\Entities\CategoryType;

class CategoryTypeController extends Controller
{
    // add subcategory
    public function all_category_type(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'name'=> 'required|unique:category_types|max:191',
                'short_description'=> 'required|max:191',
                'slug' => 'nullable|unique:category_types|max:191',

            ]);

            $slug = !empty($request->slug) ? $request->slug : $request->name;
            CategoryType::create([
                'name' => $request->name,
                'short_description' => $request->short_description,
                'slug' => Str::slug(purify_html($slug),'-',null),
                'category_id' => $request->category,
                'status' => $request->status,
                'image' => $request->image,
            ]);
            toastr_success(__('New Category Type Successfully Added'));
        }
        $all_categories_type = CategoryType::with('category')->latest()->paginate(10);
        return view('service::category_type.all-category-type',compact('all_categories_type'));
    }

    // edit subcategory
    public function edit_category_type(Request $request)
    {
        $request->validate([
            'edit_name'=> 'required|max:191|unique:category_types,name,'.$request->edit_category_type_id,
            'edit_short_description'=> 'required|max:191',
            'edit_slug'=> 'required|max:191|unique:category_types,slug,'.$request->edit_category_type_id,
        ]);

        $slug = !empty($request->edit_slug) ? $request->edit_slug : $request->edit_name;
        CategoryType::where('id',$request->edit_category_type_id)->update([
            'name'=>$request->edit_name,
            'short_description'=>$request->edit_short_description,
            'slug' => Str::slug(purify_html($slug),'-',null),
            'category_id'=>$request->edit_category,
            'image' => $request->image,
        ]);
        return redirect()->back()->with(toastr_success(__('Category Type Successfully Updated')));
    }

    // change status
    public function change_status($id)
    {
        $subcategory = CategoryType::select('status')->where('id',$id)->first();
        $subcategory->status==1 ? $status=0 : $status=1;
        CategoryType::where('id',$id)->update(['status'=>$status]);
        return redirect()->back()->with(toastr_success(__('Status Successfully Changed')));
    }

    // delete subcategory
    public function delete_category_type($id)
    {
        $subcategory = CategoryType::find($id);
        $job_count = $subcategory->jobs?->count();
        $project_count = $subcategory->projects?->count();
        $skill_count = $subcategory->skills?->count();
        return $this->filter_and_delete_category_type($subcategory,$job_count,$project_count,$skill_count);
    }

    // bulk action subcategory
    public function bulk_action_category_type(Request $request){
        foreach($request->ids as $subcategory_id){
            $subcategory = CategoryType::find($subcategory_id);
            $job_count = $subcategory->jobs?->count();
            $project_count = $subcategory->projects?->count();
            $skill_count = $subcategory->skills?->count();
            $this->filter_and_delete_subcategory($subcategory,$job_count,$project_count,$skill_count);
        }
        return redirect()->back()->with(toastr_error(__('Selected Category Type Successfully Deleted')));
    }

    // pagination
    function pagination(Request $request)
    {
        if($request->ajax()){
            $all_categories_type = CategoryType::latest()->paginate(10);
            return view('service::category_type.search-result', compact('all_categories_type'))->render();
        }
    }

    public function search_category_type(Request $request)
    {
        $all_categories_type = CategoryType::where('name', 'LIKE', "%". strip_tags($request->string_search) ."%") ->paginate(10);
        return $all_categories_type->total() >= 1 ? view('service::category_type.search-result', compact('all_categories_type'))->render() : response()->json(['status'=>__('nothing')]);

    }

    private function filter_and_delete_category_type($subcategory,$job_count,$project_count,$skill_count)
    {
        if($job_count > 0){
            return back()->with(toastr_error(__('Category Type is not deletable because it is related to jobs')));
        }elseif($project_count > 0){
            return back()->with(toastr_error(__('Category Type is not deletable because it is related to projects')));
        }elseif($skill_count > 0){
            return back()->with(toastr_error(__('Category Type is not deletable because it is related to skills')));
        }else{
            $subcategory->delete();
            return redirect()->back()->with(toastr_error(__('Category Type Successfully Deleted')));
        }
    }
}
