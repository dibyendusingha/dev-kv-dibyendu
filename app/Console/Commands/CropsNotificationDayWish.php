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
use DateTime;

class CropsNotificationDayWish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crops:notification-day-wish';

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
        $currentDate   = new DateTime();

        $last_three_day_formate = $currentDate->modify('+3 days');
        $last_three_day         = $last_three_day_formate->format('Y-m-d');

        $last_two_day_formate   = $last_three_day_formate->modify('-1 days');
        $last_two_day           = $last_two_day_formate->format('Y-m-d');

        $last_one_day_formate   = $last_two_day_formate->modify('-1 days');
        $last_one_day           = $last_one_day_formate->format('Y-m-d');

        $all_crops_subscribed = CropsSubscribed::where('status',1)->get();

       // dd($last_one_day);
        # CROPS SUBSCRIPTION EXPIRY IN 3,2,1 DAYS
        foreach( $all_crops_subscribed as $key=> $crops_subscribed){

            $formate = strtotime($crops_subscribed->end_date);
            $end_data = date('Y-m-d', $formate);
           // dd($end_data);

            if($last_three_day == $end_data){
                $user_id = $crops_subscribed->user_id;
                $subscription_id = $crops_subscribed->subscription_id;
                $crop_notification = CropsSMS::subscription_day_left($user_id,$subscription_id ,3);

                \Log::info('CROPS NOTIFICATION FOR 3 DAYS');
            }
            else if($last_two_day == $end_data){
                $user_id = $crops_subscribed->user_id;
                $subscription_id = $crops_subscribed->subscription_id;
                $crop_notification = CropsSMS::subscription_day_left($user_id,$subscription_id,2);

                \Log::info('CROPS NOTIFICATION FOR 2 DAYS');
            }
            else if($last_one_day == $end_data){
               // dd("hi");
                $user_id = $crops_subscribed->user_id;
                $subscription_id = $crops_subscribed->subscription_id;
                $crop_notification = CropsSMS::subscription_day_left($user_id,$subscription_id,1);

                \Log::info('CROPS NOTIFICATION FOR 1 DAYS');
            }
        }
    }
}
