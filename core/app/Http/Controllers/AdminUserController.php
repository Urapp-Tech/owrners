<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\CountryManage\Entities\City;
use Modules\CountryManage\Entities\State;
use Modules\Service\Entities\CategoryType;
use Modules\Service\Entities\SubCategory;

class AdminUserController extends Controller
{
    // get state
    public function get_country_state(Request $request)
    {
        $states = State::where('country_id', $request->country)->where('status', 1)->get();
        return response()->json([
            'status' => 'success',
            'states' => $states,
        ]);
    }

    // get city
    public function get_state_city(Request $request)
    {
        $cities = City::where('state_id', $request->state)->where('status', 1)->get();
        return response()->json([
            'status' => 'success',
            'cities' => $cities,
        ]);
    }

    // get subcategory
    public function get_subcategory(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category)->where('status', 1)->get();
        return response()->json([
            'status' => 'success',
            'subcategories' => $subcategories,
        ]);
    }

    public function get_category_type(Request $request)
    {
        $category_types = CategoryType::where('category_id', $request->category)->where('status', 1)->get();
        return response()->json([
            'status' => 'success',
            'category_types' => $category_types,
        ]);
    }

    public function get_skills(Request $request) {
        $search =  $request->skill;
        $skills = Skill::where('skill','LIKE',"%$search%")->where('status', 1)->take(10)->get();
        return response()->json([
           'status' =>'success',
           'skills' => $skills,
        ]);
    }

    public function get_suggested_skills(Request $request) {
        $search = $request->skill_ids;
    
        $skills = Skill::whereIn('id', $search)->where('status', 1)->inRandomOrder()->take(10)->get();
        
        if ($skills->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'suggested' => []
            ]);
        }
        
        // $grouped = $skills->groupBy('category_id');
        
        // $maxGroup = $grouped->inRandomOrder(function($group) {
        //     return $group->count();
        // })->first();
        
        // $categoryId = $maxGroup->first()->category_id;
        $categoryId = $skills->first()->category_id;
        
        $suggested = Skill::where('category_id', $categoryId)->where('status', 1)->inRandomOrder()->take(5)->get();
        
        return response()->json([
            'status' => 'success',
            'suggested' => $suggested
        ]);
    }

    public function renderNotification() {
        $notifications = [];
        $notifications_unreed_count = 0;
        $lastPage = 0;

        if(Auth::guard('web')->user()->user_type == 1) {
            $notifications_unreed_count = \App\Models\ClientNotification::where('is_read', 'unread')
                ->where('client_id', Auth::guard('web')->user()->id)
                ->latest()
                ->get();
            $notifications = \App\Models\ClientNotification::where('client_id', Auth::guard('web')->user()->id)
                ->latest() 
                ->paginate(10);
        }

        if(Auth::guard('web')->user()->user_type == 2) {
            $notifications_unreed_count = \App\Models\FreelancerNotification::where('is_read', 'unread')
                ->where('freelancer_id', Auth::guard('web')->user()->id)
                ->get();
            $notifications = \App\Models\FreelancerNotification::where('freelancer_id', Auth::guard('web')->user()->id)
                ->latest()
                ->paginate(10);
        }

        $lastPage = $notifications->lastPage();

        return response()->json([
            'status' => 'success',
            'notifications_unreed_count' => $notifications_unreed_count,
            'lastPage' => $lastPage,
            'view' => view('frontend.layout.partials.auth-partials._notifications',compact('notifications','notifications_unreed_count'))->render(),
        ]);
    }


}
