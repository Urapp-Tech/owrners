<?php

namespace Database\Seeders;

use App\Models\GigRankingAlgorithm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GigRankingAlgorithmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $algorithms = [
            ['name' => 'Completion Rate', 'description' => 'Percentage of successfully completed orders', 'is_active' => true],
            ['name' => 'Reviews and Ratings', 'description' => 'Impact of positive reviews and high ratings', 'is_active' => false],
            ['name' => 'Order Completion', 'description' => 'Influence of the total number of completed orders', 'is_active' => false],
            ['name' => 'Gig Performance', 'description' => 'Metrics like click-through and conversion rates', 'is_active' => false],
        ];

        foreach ($algorithms as $algorithm) {
            GigRankingAlgorithm::firstOrCreate(
                ['name' => $algorithm['name']], // Check by name
                [
                    'description' => $algorithm['description'],
                    'is_active' => $algorithm['is_active'],
                ]
            );
        }
    }
}
