<?php

namespace App\Http\Controllers\Frontend\Client;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Order;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Service\Entities\Category;
use Modules\Wallet\Entities\Wallet;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user_id = Auth::guard('web')->user()->id;
        $wallet_balance = Wallet::where('user_id',$user_id)->first();
        $total_wallet_balance = $wallet_balance->balance ?? 0;
        $total_orders = Order::where('user_id',$user_id)->where('payment_status', 'complete')->count();
        $complete_order = Order::where('status',3)->whereHas('freelancer')->where('user_id',$user_id)->count();
        $active_order = Order::where('status',1)->whereHas('freelancer')->where('user_id',$user_id)->count();

        if(get_static_option('project_enable_disable') != 'disable'){
            $latest_orders = Order::whereHas('freelancer')
                ->where(function ($query) use ($user_id) {
                    $query->where(function ($query) {
                        $query->where('payment_status', 'complete');
                    })->orWhere(function ($query) {
                        $query->where("payment_gateway", "manual_payment")
                            ->whereIn("payment_status", ["pending", "complete"]);
                    });
                })
                ->where('user_id', $user_id)
                ->latest()
                ->take(5)
                ->get();
        }else{
            $latest_orders = Order::where('user_id', $user_id)
                ->where('is_project_job', '!=', 'project')
                ->where(function ($query) {
                    $query->whereHas('freelancer', function ($q) {
                        $q->where('payment_status', 'complete');
                    })
                        ->orWhere(function ($query) {
                            $query->where('payment_gateway', 'manual_payment')
                                ->whereIn('payment_status', ['pending', 'complete']);
                        });
                })
                ->latest()
                ->take(5)
                ->get();
        }
        $my_jobs = JobPost::select('id','title','slug')->where('user_id',$user_id)->latest()->take(5)->get();

        return view('frontend.user.client.dashboard.dashboard',compact(['total_wallet_balance','total_orders','complete_order','active_order','latest_orders','my_jobs']));
    }

    public function buyer_dashboard() {

        $popularCategoriesIds = Order::select('categories.id as category_id', DB::raw('count(*) as total'))
        ->join('projects', 'orders.identity', '=', 'projects.id')
        ->join('categories', 'projects.category_id', '=', 'categories.id')
        ->where('orders.is_project_job', 'project')
        ->groupBy('categories.id')
        ->orderBy('total', 'desc')
        ->take(4)
        ->get();

        $popularCategoriesIdsOnly  = $popularCategoriesIds->pluck('category_id')->toArray();

        if($popularCategoriesIds->count() < 4) {
            $remainingCategoriesIds = Category::select('id')
                ->whereNotIn('id', $popularCategoriesIdsOnly)
                ->whereHas('projects')
                ->whereHas('projects.project_creator')
                ->take(4 - $popularCategoriesIds->count())
                ->get();

            $popularCategoriesIdsOnly = array_merge($popularCategoriesIdsOnly, $remainingCategoriesIds->pluck('id')->toArray());
        }
        $popularCategories = Category::with(['projects', 'projects.project_creator'])->whereIn('id', $popularCategoriesIdsOnly)->get();

        // dd($popularCategories);

        return view('frontend.user.client.dashboard.dashboard-v2', compact('popularCategories'));
    }
}
