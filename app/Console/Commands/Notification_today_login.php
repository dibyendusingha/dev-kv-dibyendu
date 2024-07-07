<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription\notification_function as NS;
use DB;
use carbon\Carbon;

class Notification_today_login extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification_today_login';

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
        //
        
        $current = now()->format('Y-m-d H:i:s');
        $yesterday = now()->subDay()->format('Y-m-d H:i:s');

        $active_banner = DB::table('ads_banners')->where('status', 1)->get();

        $current_users = DB::table('app_open as a')
            ->select('a.user_id', 'u.user_type_id', 'u.state_id', 'u.district_id', 'u.city_id', 'u.zipcode', 'u.lat', 'u.long')
            ->leftJoin('user as u', 'u.id', '=', 'a.user_id')
            ->where('a.created_at', '>=', $yesterday)
            ->groupBy('a.user_id')
            ->get();

        $data = NS::n_banner_todays_login($current_users,$active_banner);
        \Log::info("Notification Today Login Cron job running at ". now());
    }
}
