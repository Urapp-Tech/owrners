<?php

namespace App\Http\Controllers\Frontend\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserEarning;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserSkill;
use App\Models\UserWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Entities\WalletHistory;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user_id = Auth::guard('web')->user()->id;
        $wallet_balance = Wallet::where('user_id',$user_id)->first();
        $total_wallet_balance = $wallet_balance->balance ?? 0;
        $total_project = Project::where('user_id',$user_id)->count();
        $complete_order = Order::where('status',3)->whereHas('user')->where('freelancer_id',$user_id)->count();
        $active_order = Order::where('status',1)->whereHas('user')->where('freelancer_id',$user_id)->count();

        if(get_static_option('project_enable_disable') != 'disable'){
            $latest_orders = Order::where('freelancer_id',$user_id)->whereHas('user')->where('payment_status','complete')->latest()->take(5)->get();
        }else{
            $latest_orders = Order::where('freelancer_id',$user_id)->where('is_project_job', '!=', 'project')->whereHas('user')->where('payment_status','complete')->latest()->take(5)->get();
        }
        $my_projects = Project::select('id','title','slug')->where('user_id',$user_id)->latest()->take(5)->get();

        return view('frontend.user.freelancer.dashboard.dashboard',compact(['total_wallet_balance','total_project','complete_order','active_order','latest_orders','my_projects']));
    }

    public function seller_dashboard() {
        $user = Auth::guard('web')->user();
        $username = $user->username;

        $freelancer_id = $user->id;

       if($user){
            $user_work =  UserWork::where('user_id',$user->id)->first();
            $total_earning =  UserEarning::where('user_id',$user->id)->first();
            $complete_orders = Order::select('id','identity','status','freelancer_id')->whereHas('user')->whereHas('rating')->where('freelancer_id',$user->id)->where('status',3)->latest()->get();
            $active_orders_count = Order::where('freelancer_id',$user->id)->whereHas('user')->where('status',1)->count();
            $skills_according_to_category = isset($user_work) ? Skill::select(['id','skill'])->where('category_id',$user_work->category_id)->get() : '';

            $skills =  UserSkill::select('skill')->where('user_id',$user->id)->first()->skill ?? '';
            $portfolios = Portfolio::where('username',$user->username)->latest()->get();
            $educations = UserEducation::where('user_id',$user->id)->latest()->get();
            $experiences = UserExperience::where('user_id',$user->id)->latest()->get();
            $projects = Project::with('project_history')->where('user_id',$user->id)->withCount('orders')->latest()->get();
            $active_projects_count = Project::where('user_id',$user->id)->where('status', 1)->count();

            if(get_static_option('project_enable_disable') != 'disable'){
                $orders = Order::where('freelancer_id',$freelancer_id)->whereHas('user')->where('payment_status','complete')->where('status',1)->latest()->paginate(10);
                $all_orders = Order::where('freelancer_id',$freelancer_id)->whereHas('user')->where('payment_status','complete')->count();
                $queue_orders =  Order::where('freelancer_id',$freelancer_id)->whereHas('user')->where('payment_status','complete')->where('status',0)->count();
                $active_orders =  Order::where('freelancer_id',$freelancer_id)->whereHas('user')->where('payment_status','complete')->where('status',1)->count();
                $complete_orders = Order::where('freelancer_id',$freelancer_id)->whereHas('user')->where('payment_status','complete')->where('status',3)->count();
                $cancel_orders = Order::where('freelancer_id',$freelancer_id)->whereHas('user')->where('payment_status','complete')->where('status',4)->count();
            }else{
                $orders = Order::where('freelancer_id',$freelancer_id)->where('is_project_job', '!=', 'project')->whereHas('user')->where('payment_status','complete')->where('status',1)->latest()->paginate(10);
                $all_orders = Order::where('freelancer_id',$freelancer_id)->where('is_project_job', '!=', 'project')->whereHas('user')->where('payment_status','complete')->count();
                $queue_orders =  Order::where('freelancer_id',$freelancer_id)->where('is_project_job', '!=', 'project')->whereHas('user')->where('payment_status','complete')->where('status',0)->count();
                $active_orders =  Order::where('freelancer_id',$freelancer_id)->where('is_project_job', '!=', 'project')->whereHas('user')->where('payment_status','complete')->where('status',1)->count();
                $complete_orders = Order::where('freelancer_id',$freelancer_id)->where('is_project_job', '!=', 'project')->whereHas('user')->where('payment_status','complete')->where('status',3)->count();
                $cancel_orders = Order::where('freelancer_id',$freelancer_id)->where('is_project_job', '!=', 'project')->whereHas('user')->where('payment_status','complete')->where('status',4)->count();
            }
    

            return view('frontend.user.freelancer.dashboard.dashboard-v2', compact(
                'skills_according_to_category',
                'portfolios',
                'skills',
                'educations',
                'experiences',
                'projects',
                'user',
                'username',
                'total_earning',
                'complete_orders',
                'active_orders_count',
                'active_projects_count',
                // Orders
                'orders',
                'queue_orders',
                'active_orders',
                'complete_orders',
                'cancel_orders',
                'all_orders'
            ));
       }
       else {
        return back();
       }

    }

    // pagination
    public function order_pagination(Request $request)
    {
        if($request->ajax()){
            $freelancer_id = Auth::guard('web')->user()->id;
            $query = Order::where('freelancer_id',$freelancer_id)->whereHas('user')->where('payment_status','complete');

            if($request->has('sort_by')) {
                if($request->sort_by == 'priority'){
                    $query = $query->orderBy('delivery_time') ;
                }
                else if($request->sort_by == 'latest') {
                    $query = $query->latest();
                    
                }
                else if($request->sort_by == 'budget') {
                    $query = $query->orderByDesc('price') ;
                }
            }
            
            if($request->has('search')) {
                $query = $query->whereHas('project', function ($q) use ($request) {
                    $q->where('title', 'LIKE', '%'. $request->search. '%');
                });
            }

            if($request->order_type == 'all')
            {
                $orders = $query->paginate(10);
            }
            if($request->order_type == 'active')
            {
                $orders = $query->where('status',1)->paginate(10);
            }
            if($request->order_type == 'queue')
            {
                $orders = $query->where('status',0)->paginate(10);
            }
            if($request->order_type == 'cancel')
            {
                $orders = $query->where('status',4)->paginate(10);
            }
            if($request->order_type == 'complete')
            {
                $orders = $query->where('status',3)->paginate(10);
            }
            return view('frontend.user.freelancer.dashboard.dashboard-search-result', compact('orders'))->render();
        }
    }
}
