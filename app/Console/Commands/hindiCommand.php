<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminEnd;

class hindiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hindi:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        info("Hindi Cron job running at ". now());
        \Log::info("Cron job is running correctly!");
        
        $id = [];
        $data = [];
        $current_date = date('Y-m-d');
        $current_hour = date('H');
        //AdminEnd::push_notification_send();
            $count = DB::table('push_notification')->where(['status'=>0,'date'=>$current_date,'hour'=>$current_hour,'language_id'=>2])->count();
            
            if ($count>0) {
                
            $hindi_content = DB::table('push_notification')->orderBy('id','desc')->where(['status'=>0,'date'=>$current_date,'hour'=>$current_hour,'language_id'=>2])->first();
            $cid  = $hindi_content->id;
            $tiltle  = $hindi_content->tiltle;
            $deception  = $hindi_content->deception;
            $img  = $hindi_content->img;
            $language_id  = $hindi_content->language_id;
            $status  = $hindi_content->status;
            $date_time  = $hindi_content->date_time;
            $date  = $hindi_content->date;
            $time  = $hindi_content->time;
            DB::table('push_notification')->where(['id'=>$cid])->update(['status'=>1]);
            
        DB::table('user')->select('id','firebase_token')->where('status',1)->where('lamguage',2)->chunkById(100, function ($chunk) use (&$id) {
            foreach ($chunk as $user) {
                $id = $user->firebase_token;
        
        $current_date = date('Y-m-d');
        $current_hour = date('H');
        $hindi_content = DB::table('push_notification')->orderBy('id','desc')->where(['status'=>1,'date'=>$current_date,'hour'=>$current_hour,'language_id'=>2])->first();
            $url = 'https://fcm.googleapis.com/fcm/send';
            
            $fields = array (
                'registration_ids' => array (
                        $id
                ),
                'notification' => [
                    'title' => $hindi_content->tiltle,
                    'body' => $hindi_content->deception,
                    'image' => $hindi_content->img,
                    
                ],
                // 'fcm_options' => [
                //     'link' => 'https://my-server/some-page',
                // ],
                // 'data' => array (
                //         'click_action'=> 'OPEN_SPECIFIC_PAGE',
                //         'url'=> '/NotificationsPage'
                // )
                'data' => array (
                    'title' => $hindi_content->tiltle,
                    'body' => $hindi_content->deception,
                    'sound' => $sound, 'badge' => '1', 'vibrate'=> 1,
                    'image' => $hindi_content->img,
                    
                        'notification_id'=>$hindi_content->id,
                        'click_action'=> 'OPEN_SPECIFIC_PAGE',
                        'url'=> '/NotificationsPage',
                        'sound' => $sound, 
                        'badge' => '1', 
                        'vibrate'=> 1,
                        'image' => $hindi_content->img,
                        'importance' => 'Max'
                )
            );
            
            
            $fields = json_encode ( $fields );
            
            $headers = array (
                'Authorization: key=' . "AAAAggkuf0U:APA91bFBX11jYY_-0wGkxNL1D1CDlsFStOwl_1XP6W9P7nGzGKCvQPuiw7gYxJTGIl979OnB7puZ8msM4pPz7TslSjZysTyG0pZwTWH8PhriZO3sGt-a8u5UFiNJfyRh2M1h0f05jZl4",
                'Content-Type: application/json'
            );
            
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
            
            $result = curl_exec ( $ch );
             \Log::info('Hindi'.$result.' ftkn-'.$id);
            curl_close ( $ch );
        }
        });
        
        //end of hour
            } else {
             
            \Log::info('Failed! Hindi Notification Not Found');
            
            }
    }
}
