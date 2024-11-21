<?php

namespace App\Traits;

use App\Models\GigRankingAlgorithm;
use Carbon\Carbon;

trait HasDynamicSorting
{
    /**
     * Scope function to apply dynamic sorting based on active algorithm.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApplyDynamicSorting($query)
    {
        // Fetch the active algorithm
        $activeAlgorithm = GigRankingAlgorithm::where('is_active', true)->first();

        // If no active algorithm, return the query as is
        if (!$activeAlgorithm) {
            return $query;
        }

        // Apply sorting based on the active algorithm
        switch ($activeAlgorithm->name) {
            case 'Completion Rate':
                return $query->sortByCompletionRate();

            case 'Reviews and Ratings':
                return $query->sortByAvgRatings();

            case 'Order Completion':
                return $query->sortByCompletedOrders();

            case 'Gig Performance':
                return $query->sortByPerformanceAlgorithm();

            default:
                return $query; // Fallback to default query
        }
    }

    public function scopeSortByPerformanceAlgorithm($query)
    {
        return $query->addSelect(['gig_performance_score' => function ($subQuery) {
            $subQuery
                ->selectRaw("
                    COALESCE(
                        (SUM(CASE WHEN project_clicks.id IS NOT NULL THEN 1 ELSE 0 END)) * 0.4
                        +
                        (SUM(CASE WHEN orders.status = 3 THEN 1 ELSE 0 END)) * 0.5
                        +
                        (SUM(CASE WHEN impressions.project_id IS NOT NULL THEN 1 ELSE 0 END)) * 0.1,
                        0
                    )
                ")
                ->from('project_clicks')
                ->leftJoin('orders', 'project_clicks.project_id', '=', 'orders.identity')
                ->leftJoin('project_impressions as impressions', 'project_clicks.project_id', '=', 'impressions.project_id')
                ->whereColumn('project_clicks.project_id', 'projects.id') // Links subquery to main query
                ->whereBetween('project_clicks.created_at', [Carbon::now()->subDays(300), Carbon::now()]);
        }])
            ->orderBy('gig_performance_score', 'desc');
    }

    public function scopeSortByCompletionRate($query)
    {
        return $query->addSelect([
            'total_complete_orders' => function ($subQuery) {
                $subQuery
                    ->selectRaw("COUNT(*)")
                    ->from('orders')
                    ->whereColumn('orders.identity', 'projects.id')
                    ->where('orders.status', 3) // Completed orders
                    ->where('orders.is_project_job', 'project');
            },

            'total_orders_count' => function ($subQuery) {
                $subQuery
                    ->selectRaw("COUNT(*)")
                    ->from('orders')
                    ->whereColumn('orders.identity', 'projects.id')
                    ->where('orders.is_project_job', 'project');
            },

            'completion_rate' => function ($subQuery) {
                $subQuery
                    ->selectRaw("
                    COALESCE(
                        (SUM(CASE WHEN orders.status = 3 THEN 1 ELSE 0 END)) / NULLIF(COUNT(orders.id), 0),
                        0
                    )
                ")
                    ->from('orders')
                    ->whereColumn('orders.identity', 'projects.id')
                    ->where('orders.is_project_job', 'project');
            },
        ])
            ->orderByDesc('completion_rate');  // Orders by the completion rate in descending order
    }

    public function scopeSortByAvgRatings($query) {
        return $query->withAvg(['ratings as custom_avg_ratings' => function ($query){
                $query->where('sender_type', 1);
            }],'rating')
            ->orderBy('custom_avg_ratings','Desc');
    }

    public function scopeSortByCompletedOrders ($query) {
        return $query->withCount('complete_orders as completed_orders_total')
            ->orderBy('completed_orders_total','Desc');
    }
}
