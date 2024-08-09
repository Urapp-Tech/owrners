<?php

namespace App\Http\Services;

use App\Http\Contracts\ProjectServiceContract;
use App\Models\ProjectImpression;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProjectService implements ProjectServiceContract {

    public function logProjectImpression(array $project_ids){
        $user = Auth::guard('web')->user();
        if($user){
            $new_impression_records = [];
            foreach($project_ids as $project_id){
                $new_impression_records[] = [
                    'user_id' => $user->id, 
                    'project_id' => $project_id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            ProjectImpression::insert($new_impression_records);
        }
    }
}