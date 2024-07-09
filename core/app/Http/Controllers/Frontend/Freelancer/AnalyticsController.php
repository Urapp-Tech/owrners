<?php

namespace App\Http\Controllers\Frontend\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserEarning;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index() {
        $user = Auth::guard('web')->user();
        $total_earning = Order::where('freelancer_id', $user->id)
            ->where('status', 3)
            ->sum('payable_amount');
        // $total_earning =  UserEarning::where('user_id',$user->id)->first();
        $completed_orders  = Order::where('status', 3)->where('freelancer_id', $user->id)->count();
        $avg_selling_price  = Order::where('status', 3)->where('freelancer_id', $user->id)->get()->avg('payable_amount');
        $current_month_orders  = Order::where('status', 3)->where('freelancer_id', $user->id)->whereMonth('created_at', Carbon::now()->month)->sum('payable_amount');

        // Get earnings by month for last year
        $orders_by_month_last_year = Order::selectRaw('MONTH(created_at) as month, SUM(payable_amount) as total')
           ->where('status', 3)
           ->where('freelancer_id', $user->id)
           ->whereYear('created_at', Carbon::now()->subYear()->year)
           ->groupBy('month')
           ->pluck('count', 'month');

       // Initialize the orders array with 0s for all months
       $earning_by_last_year_month_data = array_fill(1, 12, 0);

       // Populate the orders array with actual counts
       foreach ($orders_by_month_last_year as $month => $count) {
           $earning_by_last_year_month_data[$month] = $count;
       }

       $earning_by_last_year_month_data=  array_values($earning_by_last_year_month_data);

         // Get earnings by month for this year
         $earnings_by_month = Order::selectRaw('MONTH(created_at) as month, SUM(payable_amount) as total')
         ->where('status', 3)
         ->where('freelancer_id', $user->id)
         ->whereYear('created_at', Carbon::now()->year)
         ->groupBy('month')
         ->pluck('total', 'month');

        // Initialize the earnings array with 0s for all months
        $earnings_by_month_data = array_fill(1, 12, 0);

        // Populate the earnings array with actual totals
        foreach ($earnings_by_month as $month => $total) {
            $earnings_by_month_data[$month] = $total;
        }

        // Convert to array values to ensure zero-indexed array for JavaScript
        $earnings_by_month_data = array_values($earnings_by_month_data);


        // Calculate repeat business metrics
        $repeat_buyers_count = Order::where('freelancer_id', $user->id)
            ->where('status', 3)
            ->select('user_id')
            ->distinct()
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->count();

        $total_customers = Order::where('freelancer_id', $user->id)
            ->where('status', 3)
            ->distinct('user_id')
            ->count();

        $repeat_buyers_percentage = $total_customers > 0 ? ($repeat_buyers_count / $total_customers) * 100 : 0;

        $earning_from_repeat_buyers = Order::where('freelancer_id', $user->id)
            ->where('status', 3)
            ->whereIn('user_id', function ($query) use ($user) {
                $query->select('user_id')
                    ->from('orders')
                    ->where('freelancer_id', $user->id)
                    ->where('status', 3)
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(*) > 1');
            })
            ->sum('payable_amount');

        $earning_from_repeat_buyers_percentage = $total_earning > 0 ? ($earning_from_repeat_buyers / $total_earning) * 100 : 0;

        
        return view('frontend.user.freelancer.analytic.overview', compact(
            'total_earning', 
            'completed_orders', 
            'avg_selling_price', 
            'current_month_orders', 
            'earning_by_last_year_month_data', 
            'earnings_by_month_data',
            'repeat_buyers_count',
            'repeat_buyers_percentage',
            'earning_from_repeat_buyers',
            'earning_from_repeat_buyers_percentage'
        ));
    }

}
