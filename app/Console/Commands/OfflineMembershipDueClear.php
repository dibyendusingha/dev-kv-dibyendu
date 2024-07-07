<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use App\Models\sms;

class OfflineMembershipDueClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offline-membership:due-clear';

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
        $date  = Carbon::now();
        $today = $date->format('Y-m-d h:i:s');

        //dd($today);
        $promotion_coupons = DB::table('promotion_coupons')->where('due_amount','>',0)->get();

        foreach($promotion_coupons as $pc)
        {
            $user_id                = $pc->user_id;
            $total_days_end_day     = $pc->total_days_end_day;
            $package_id             = $pc->package_id;


            $user = DB::table('user')->where('id',$user_id)->first();
            $language       = $user->lamguage;
            $firebase_token = $user->firebase_token;
            $mobile         = $user->mobile;
         
           // dd($today);
            if($today > $total_days_end_day ){
                //dd("hi");
                sms::offlineMembershipDueClear($language, $firebase_token,$user_id ,$mobile);
            }
        }
    }
}
