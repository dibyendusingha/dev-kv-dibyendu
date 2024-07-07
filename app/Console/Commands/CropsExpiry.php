<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription\Subscription;
use App\Models\Crops\CropSubscription;
use App\Models\Crops\CropSubscriptionFeatures;
use App\Models\Crops\Crops;
use App\Models\Crops\CropsBoost;
use App\Models\Crops\CropsBanner;
use App\Models\Crops\CropsSubscribed;
use App\Models\Crops\CropsSMS;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CropsExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crops:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();
        $all_crops_subscribed = CropsSubscribed::where('status',1)->get();
       

        # EXPIRY CROPS SUBSCRIBED
        foreach( $all_crops_subscribed as $key=> $crops_subscribed){
            if($today > $crops_subscribed->end_date ){
                $user_id = $crops_subscribed->user_id;
                $subscription_id = $crops_subscribed->subscription_id;

                $crop_notification = CropsSMS::expiry_crops_plan($user_id,$subscription_id);

                $update_subscribed = CropsSubscribed::where('id',$crops_subscribed->id)->update(['status' => 2]);

                $user = DB::table('users')->where('id',$user_id)->update(['crops_verify_tag' => ""]);

                # EXPIRY CROPS BOOST
                $all_crops_boost = CropsBoost::where(['crop_subscribed_id'=>$crops_subscribed->id,'status'=>1])->get();
                foreach( $all_crops_boost as $key=> $crops_boost){
                    $update_boost = CropsBoost::where('id',$crops_boost->id)->update(['status' => 2]);
                }

                # EXPIRY CROPS BANNER
                $all_crops_banner = CropsBanner::where(['crop_subscribed_id'=>$crops_subscribed->id,'status'=>1])->get();
                foreach( $all_crops_banner as $key=> $crops_banner){
                    $update_banner = CropsBanner::where('id',$crops_banner->id)->update(['status' => 2]);
                }

                # EXPIRY CROPS POST
                $all_crops_post = Crops::where(['crops_subscribed_id'=>$crops_subscribed->id,'status'=>1])->get();
                foreach( $all_crops_post as $key=> $crops){
                    $update_banner = Crops::where('id',$crops->id)->update(['status' => 2]);
                }
            }
        }

        \Log::info('CROPS SUBSCRIPTION EXPIRY');
    }
}
