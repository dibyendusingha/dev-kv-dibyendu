<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use App\Models\sms;

class OfflineMembershipExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offline-membership:expire';

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
        $date = Carbon::now();
        $today = $date->format('Y-m-d h:i:s');

        $promotion_coupons = DB::table('promotion_coupons')->where('status',1)->get();
    
        foreach($promotion_coupons as $pc)
        {
            $user_id          = $pc->user_id;
            $end_date         = $pc->end_date;
            $package_id       = $pc->package_id;
           
            $package_name = DB::table('promotion_package')->where('id',$package_id)->first()->package_name;
           // dd($package_name);

            $user = DB::table('user')->where('id',$user_id)->first();
            $language       = $user->lamguage;
            $firebase_token = $user->firebase_token;
            $mobile         = $user->mobile;
         
           // dd($end_date);
           // dd($today);
            if($today > $end_date ){
                sms::offlineMembershipExpired($language, $firebase_token,$user_id ,$mobile,$package_name);
            }
        }
    }
}
