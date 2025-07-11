<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobPost;
use App\Models\JobProposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Modules\Subscription\Entities\Subscription;
use Modules\Subscription\Entities\UserSubscription;

class JobDetailsController extends Controller
{
    public function job_details($username = null , $slug = null)
    {
        $job_details = JobPost::with(['job_creator','job_skills','job_proposals'])->where('slug',$slug)->first();
        if(!empty($job_details)){
            $user = User::with('user_country')->where('id',$job_details->user_id)->first();
            return  view('frontend.pages.job-details.job-details',compact('job_details','user'));
        }
        return back();
    }

    //job proposal
    public function job_proposal_send(Request $request)
    {
        $isOnSubscription = moduleExists('Subscription');
        if (Auth::guard('web')->user()->is_suspend) {
            abort(403, 'You are suspended from the platform.'); 
        }

        $request->validate([
            'client_id'=>'required',
            'amount'=>'required|numeric|gt:0',
            'duration'=>'required',
            'revision'=>'required|min:0|max:100',
            'cover_letter'=>'required|min:10|max:1000',
        ]);

        $freelancer_id = Auth::guard('web')->user()->id;
        $total_limit = UserSubscription::where('user_id',$freelancer_id)->where('payment_status','complete')->whereDate('expire_date', '>', Carbon::now())->sum('limit');

        // Check if the freelancer has reached the daily limit of 10 proposals
        $daily_proposals_count = JobProposal::where('freelancer_id', $freelancer_id)
        ->whereDate('created_at', Carbon::today())
        ->count();

        if ($daily_proposals_count >= 10 && !$isOnSubscription) {
            return back()->with(toastr_warning(__('You have reached the daily limit of 10 proposals.')));
        }

        $freelancer_subscription = UserSubscription::select(['id','user_id','limit','expire_date','created_at'])
            ->where('payment_status','complete')
            ->where('status',1)
            ->where('user_id',$freelancer_id)
            ->where("limit", '>=', get_static_option('limit_settings'))
            ->whereDate('expire_date', '>', Carbon::now())->first();

        $check_freelancer_proposal = JobProposal::where('freelancer_id',$freelancer_id)->where('job_id',$request->job_id)->first();
        if($check_freelancer_proposal && $isOnSubscription){
            return back()->with(toastr_warning(__('You can not send one more proposal.')));
        }

        if(($total_limit >= get_static_option('limit_settings') ?? 2 && !empty($freelancer_subscription) ) || !$isOnSubscription){
            $attachment_name = '';
            if ($attachment = $request->file('attachment')) {
                $request->validate([
                    'attachment'=>'required|mimes:png,jpg,jpeg,bmp,gif,tiff,svg,csv,txt,xlx,xls,pdf|max:2048',
                ]);
                $attachment_name = time().'-'.uniqid().'.'.$attachment->getClientOriginalExtension();
                $extensions = array('png','jpg','jpeg','bmp','gif','tiff','svg');

                if(in_array($attachment->getClientOriginalExtension(), $extensions)){
                    $resize_full_image = Image::make($request->attachment)
                        ->resize(1000, 600);
                    $resize_full_image->save('assets/uploads/jobs/proposal' .'/'. $attachment_name);
                }else{
                $attachment->move('assets/uploads/jobs/proposal', $attachment_name);
                }

            }
            $proposal = JobProposal::create([
                'job_id'=>$request->job_id,
                'freelancer_id'=>auth()->user()->id,
                'client_id'=>$request->client_id,
                'amount'=>$request->amount,
                'duration'=>$request->duration,
                'revision'=>$request->revision,
                'cover_letter'=>$request->cover_letter,
                'attachment'=>$attachment_name,
            ]);
            client_notification($proposal->id,$request->client_id,'Proposal', __('You have a new job proposal'));

            if($isOnSubscription) {

                UserSubscription::where('id',$freelancer_subscription->id)->update([
                    'limit' => $freelancer_subscription->limit - (get_static_option('limit_settings') ?? 2)
                ]);
            }

            return back()->with(toastr_success(__('Proposal successfully send')));
        }
        return back()->with(toastr_warning(__('You have not enough connect to apply.')));

    }
}
