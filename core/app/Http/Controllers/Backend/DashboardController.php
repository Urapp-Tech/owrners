<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_job = JobPost::whereHas('job_creator')->count();
        $total_client = User::where('user_type',1)->count();
        $total_freelancer = User::where('user_type',2)->count();
        $total_revenue = Order::where('status',3)->sum('commission_amount');

        $orders = Order::whereHas('user')->whereHas('freelancer')->latest()->take(10)->get();

        // Get earnings by month for this year
        $earnings_by_month = Order::selectRaw('MONTH(created_at) as month, SUM(commission_amount) as total')
           ->where('status', 3)
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
          $monthly_income = array_values($earnings_by_month_data);
  
  
        // Get earnings by month for this year
        $last_earnings_by_month = Order::selectRaw('MONTH(created_at) as month, SUM(commission_amount) as total')
           ->where('status', 3)
           ->whereYear('created_at', Carbon::now()->subYear()->year)
           ->groupBy('month')
           ->pluck('total', 'month');
  
          // Initialize the earnings array with 0s for all months
          $last_earnings_by_month_data = array_fill(1, 12, 0);
  
          // Populate the earnings array with actual totals
          foreach ($last_earnings_by_month as $month => $total) {
              $last_earnings_by_month_data[$month] = $total;
          }
  
          // Convert to array values to ensure zero-indexed array for JavaScript
          $last_year_monthly_income = array_values($last_earnings_by_month_data);

        return view('backend.pages.dashboard.dashboard',compact([
            'total_job',
            'total_client',
            'total_freelancer',
            'total_revenue',
            'orders',
            'monthly_income',
            'last_year_monthly_income',
        ]));
    }
}
