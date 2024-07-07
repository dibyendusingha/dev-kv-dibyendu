<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription\Subscribed;
use App\Models\Subscription\Subscription;
use Carbon\Carbon;
use DateTime;

use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionNotification;
use Illuminate\Support\Facades\DB;
use App\Models\sms;

class SubscribedNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribed:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribed Notification 3 days from End Date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscribe_details = Subscribed::where('status',1)->get();

        $currentDate   = new DateTime();

        $last_three_day_formate = $currentDate->modify('+3 days');
        $last_three_day         = $last_three_day_formate->format('Y-m-d');

        $last_two_day_formate   = $last_three_day_formate->modify('-1 days');
        $last_two_day           = $last_two_day_formate->format('Y-m-d');

        $last_one_day_formate   = $last_two_day_formate->modify('-1 days');
        $last_one_day           = $last_one_day_formate->format('Y-m-d');

        $today_formate  = Carbon::now();
        $today1         = date_create($today_formate);
        $today          = date_format($today1,"Y-m-d");


        foreach($subscribe_details as $subscribed){
            $end_date_db      = $subscribed->end_date;
            $end_date_formate = date_create($end_date_db);
            $end_date         = date_format($end_date_formate,"Y-m-d");

            $user_id = $subscribed->user_id;
            $subscription_id = $subscribed->subscription_id;
            $mobile = DB::table('user')->where(['id'=>$user_id])->value('mobile');
        //  \Log::info($end_date);

            if($end_date == $last_three_day){
                $user_details = DB::table('user')->where('id',$user_id)->first();
                $user_name = $user_details->name;
                $subscription_details = Subscription::where('id', $subscription_id)->first();
                $subscription_name = $subscription_details->name;

                
               sms::subscription_day_left($mobile,$user_name,$subscription_name,'3-days');

               \Log::info('notification get 3 days');

            }
            else if($end_date == $last_two_day){
                $user_details = DB::table('user')->where('id',$user_id)->first();
                $user_name = $user_details->name;
                $subscription_details = Subscription::where('id', $subscription_id)->first();
                $subscription_name = $subscription_details->name;

                sms::subscription_day_left($mobile,$user_name,$subscription_name,'2-days');
                \Log::info('notification get 2 days');

            }
            else if($end_date == $last_one_day){
                $user_details = DB::table('user')->where('id',$user_id)->first();
                $user_name = $user_details->name;
                $subscription_details = Subscription::where('id', $subscription_id)->first();
                $subscription_name = $subscription_details->name;

                sms::subscription_day_left($mobile,$user_name,$subscription_name,'1-days');
                \Log::info('notification get 1 days'); 
            }
            else if($end_date == $today){
                $user_details = DB::table('user')->where('id',$user_id)->first();
                $user_name = $user_details->name;
                $subscription_details = Subscription::where('id', $subscription_id)->first();
                $subscription_name = $subscription_details->name;

                sms::expiry_plan($mobile,$user_name,$subscription_name);
                \Log::info('notification get today'); 
            }
        }
    }
}
