<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use App\Models\sms;

class OfflineMembershipBufferDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offline-membership:bufferDays';

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
        $promotion_coupons = DB::table('promotion_coupons')->get();
       // dd($promotion_coupons);

        $currentDate   = new DateTime();

        $last_three_day_formate = $currentDate->modify('+3 days');
        $last_three_day         = $last_three_day_formate->format('Y-m-d');
       

        $last_two_day_formate   = $last_three_day_formate->modify('-1 days');
        $last_two_day           = $last_two_day_formate->format('Y-m-d');

        $last_one_day_formate   = $last_two_day_formate->modify('-1 days');
        $last_one_day           = $last_one_day_formate->format('Y-m-d');
       

        foreach($promotion_coupons as $pc){

           // dd($pc);
            $user_id          = $pc->user_id;
            $end_date_db      = $pc->buffer_days_end_day;
           // dd($end_date_db);
            $end_date_formate = date_create($end_date_db);
            $end_date         = date_format($end_date_formate,"Y-m-d");
           // dd($end_date);

            if($end_date == $last_three_day){
                //dd("3 days");
                $user_details = DB::table('user')->where('id',$user_id)->first();
                $lamguage         = $user_details->lamguage;
                $firebase_token   = $user_details->firebase_token;
                $mobile           = $user_details->mobile;
                
               sms::offlineMembershipBufferDays($lamguage,$firebase_token,'3',$user_id, $mobile);

               \Log::info('notification get 3 days');

            }
            else if($end_date == $last_two_day){
                $user_details = DB::table('user')->where('id',$user_id)->first();
                
                $lamguage         = $user_details->lamguage;
                $firebase_token   = $user_details->firebase_token;
                $mobile           = $user_details->mobile;
                
               sms::offlineMembershipBufferDays($lamguage,$firebase_token,'2',$user_id,$mobile);

               \Log::info('notification get 2 days');

            }
            else if($end_date == $last_one_day){
                $user_details = DB::table('user')->where('id',$user_id)->first();
                
                $lamguage         = $user_details->lamguage;
                $firebase_token   = $user_details->firebase_token;
                $mobile           = $user_details->mobile;
                
               sms::offlineMembershipBufferDays($lamguage,$firebase_token,'1',$user_id,$mobile);

               \Log::info('notification get 1 days');

            }

        }
        
    }
}
