<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;



class Notification_state_user extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification_state_user';

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
        $receiver_ids = [];
        $active_banners = DB::table('ads_banners')->where('status', 1)->get();
    
        foreach ($active_banners as $banner) {
            $sender_id = $banner->user_id;
            $campaign_state = $banner->campaign_state;
            $array_state = explode(',', $campaign_state);
    
            foreach ($array_state as $state_id) {
                $receiver_ids = [];

                $users = DB::table('user')
                            ->orderBy(DB::raw('RAND()'))
                            ->where(['state_id' => $state_id, 'status' => 1])
                            ->limit(10)
                            ->get();

                foreach ($users as $user) {
                    $count = DB::table('n_banner_state_user')
                                ->where(['banner_id' => $banner->id])
                                ->whereRaw("FIND_IN_SET($user->id, receiver_id)")
                                ->count();
    
                    if ($count == 0) {
                        $receiver_ids[] = $user->id;
                        // Insert into n_banner_state_user table
                        
                    }
                }
                $receiver_id_str = implode(',',$receiver_ids);
                if ($receiver_id_str!='') {
                    DB::table('n_banner_state_user')->insert([
                        'sender_id'   => $sender_id,
                        'banner_id'   => $banner->id,
                        'receiver_id' => $receiver_id_str,
                        'state_id'    => $state_id,
                        'status'      => 0,
                        'created_at'  => date('Y-m-d H:i:s')
                    ]);
                }
                \Log::info("Notification banner state-user cron job run ". now());
            }
        }
        
        // Do something with $receiver_ids if needed
    }
}
