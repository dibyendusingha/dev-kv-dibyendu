<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification_save;
use App\Models\sms;
use DB;

class n_sellerPost_not_Ads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:n_seller-post_not_-ads';

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
        $ids=[];
        
        $users = DB::table('user')
                ->leftJoin('subscribeds', 'user.id', '=', 'subscribeds.user_id')
                ->leftJoin('subscribed_boosts', 'user.id', '=', 'subscribed_boosts.user_id')
                ->whereNull('subscribeds.user_id')
                ->whereNull('subscribed_boosts.user_id')
                ->whereIn('user.user_type_id', [2, 3, 4])
                ->where('user.user_post_count','>' ,0)
                // ->where('user.id','subscribeds.user_id')
                // ->orWhere('user.id','subscribed_boosts.user_id')
                  
                ->select('user.id', 'user.mobile', 'user.lamguage' ,'user.firebase_token')
                ->inRandomOrder()
                ->limit(500)
                ->chunkById(100, function ($chunk) use (&$id, &$firebase_token, &$lamguage, &$title, &$body) {

            foreach($chunk as $val) {
                $id = $val->id;
                $ids[] = $id;
                $firebase_token = $val->firebase_token;
                $mobile = $val->mobile;
                $lamguage = $val->lamguage;

                if ($lamguage==1) {
                    $title = "Level up with Banner Ads!";
                    $body  = "Consider adding a banner ad , and see the magic of sales boost! Tap to learn more.";
                } elseif ($lamguage==2) {
                    $title = 'नहीं मिलेगा ये मौका!';
                    $body = 'अधिक ग्राहक का अर्थ है अधिक लाभ! आज ही बैनर विज्ञापन पोस्ट करें और बड़ी संख्या में दर्शकों तक आसानी से पहुंचें।';
                } elseif ($lamguage==3) {
                    $title = 'এ সুযোগ পাবে না আর!';
                    $body = 'বেশী পরিমানে খদ্দের অর্থাৎ বেশী মুনাফা! আজই ব্যানার অ্যাড পোস্ট করুন এবং অনায়াসে বিপুল সংখ্যক দর্শকের কাছে পৌঁছান।';
                }

                $id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
                $firebase_token = DB::table('user')->where(['mobile'=>$mobile])->value('firebase_token');
                $url = 'https://fcm.googleapis.com/fcm/send';
                
                $fields = array (
                    'registration_ids' => array (
                        $firebase_token,
                        //'eVu89QAOSximp0wRi4WQpN:APA91bE1xN5n6wwL-7p7ME4UrgFEf3UZyyWNNacGiVCP9w9ia4dNVGfQo-GA5SyVk_mdg-Vip4fR5W8lF1LLcvLSjjyPXY4P5AcwS0D1olmod33tXUM3YQ6ZWntVc131KvO-nh89FFoi'
                        ),
                    'data' => array (
                        'title' => $title,
                        'body' => $body,
                        'image' => '',
                        'notification_id'=>rand(1000,9999).strtotime('Y-m-d H:i:s'),
                        'click_action'=> 'OPEN_SPECIFIC_PAGE',
                        'url'=> '/Home',
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
                \Log::info('Seller not Giving Ads--'.$result.' ftkn-'.$firebase_token);
                curl_close ( $ch );
            }

            $ids_str = implode(',',$ids);
            Notification_save::insert([
                'ids'=>$ids_str,
                'title' => $title,
                'body' => $body,
                'status' => 1,
                'app_url'=>'/Home',
                'created_at' => now()
            ]);
        });
        
    }
}
