<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Notification_interest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification_interest';

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
        
        $data = DB::table('subscription_interest')->cursor();
        foreach ($data as $val) {
            $user_id = $val->user_id;
            $status = $val->status;
            $created_at = $val->created_at;
            $updated_at = $val->updated_at;

            $user = DB::table('user')->where(['id'=>$user_id])->first();
            $firebase_token = $user->firebase_token;

            $lamguage = $user->lamguage;
            //dd($lamguage);

            if ($lamguage==1) {
                $title = 'What are you waiting for?';
                $body = "Dear user, you haven't finished the payment for subscription yet! Finish your payment and explore instantly!";
            } elseif ($lamguage==2) {
                $title = 'किसका है यह तुमको इंतजार?';
                $body = 'प्रिय ग्राहक,  सब्सक्रिप्शन के लिए आपने पेमेंट पुरा नहीं किया है। अभी पेमेंट पुरा करें और एप्प का लाभ उठाएं!';
            } elseif ($lamguage==3) {
                $title = 'আর কীসের অপেক্ষা?';
                $body = 'প্রিয় গ্রাহক, সাবস্ক্রিপশানের জন্য আপনি এখনও পেমেন্ট করেননি। আজই পেমেন্ট করুন এবং অ্যাপের সুবিধা উপভোগ করুন!';
            }
                
            $url = 'https://fcm.googleapis.com/fcm/send';

            //$firebase_token = 'fu80aOeIR3Wi5Ox1ftPZ0G:APA91bFaFb5Xnn562vx2wU1xG4NOMj7rZDlRrZp0TrTMxeMGBTslmaJp0tviI6HZo79DXa6rnCegcTAIPpc7z883LPy37R_guvRLvDgovZql8Q11MJ7GgOwbL0rPqyb4U74s4M-33s8H';

            $fields = array (
                'registration_ids' => array (
                    $firebase_token
                ),
                'data' => array (
                    'title' => $title,
                    'body' => $body,
                    'image' => '',
                    'notification_id'=>rand(1000,9999).strtotime('Y-m-d H:i:s'),
                    'click_action'=> 'OPEN_SPECIFIC_PAGE',
                    'url'=> '/Home',
                    'banner_id'=>'',
                    'badge' => '1', 
                    'vibrate'=> 1,
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
             \Log::info('Banner Notification Send and Save--'.$result.' ftkn-'.$firebase_token);
            curl_close ( $ch );


        }
    }
}
