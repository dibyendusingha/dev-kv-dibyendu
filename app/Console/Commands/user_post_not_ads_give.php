<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification_save;
use Illuminate\Support\Facades\DB;

class user_post_not_ads_give extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user_post:not_ads_give';

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
        # Boost
        $user_post_all = DB::table('user')
        ->select('user.id as user_id')
        ->where('user_post_count','>',0)
        ->whereIn('user_type_id', [2, 3, 4])->get();

        # Banner
        $user_post_all1 = DB::table('user')
        ->select('subscribeds.user_id')
        ->leftJoin('subscribeds', 'user.id', '=', 'subscribeds.user_id')
        ->where('user.user_post_count','>',0)
        ->where('subscribeds.status',1)
        ->whereIn('user.user_type_id', [3, 4])->get();
        

        $user_boost_all = DB::table('subscribed_boosts')
        ->select('subscribed_boosts.user_id')
        ->where('status',1)
        ->get();

        $user_banner_all = DB::table('ads_banners')
        ->select('ads_banners.user_id')
        ->get();

        //dd($user_banner_all);

        $userPostIds   = $user_post_all->pluck('user_id');
        $userPostIds1  = $user_post_all1->pluck('user_id');
        //dd($userPostIds1);

        $userBoostIds  = $user_boost_all->pluck('user_id');
        $userBannerIds = $user_banner_all->pluck('user_id');

        # Boost
        $diff = $userPostIds->diff($userBoostIds);
        $diffArray  = $diff->all();
        foreach ($diffArray as $userId) {
            $user_id_all[] = $userId;
        }

        # Banner
        $diff1 = $userPostIds1->diff($userBannerIds);
        $diffArray1 = $diff1->all();
        foreach ($diffArray1 as $userId1) {
            $user_id_all1[] = $userId1;
        }

       // dd($user_id_all1);
       
        # Boost User
        foreach ($user_id_all as $key => $user){
            $user_post_all = DB::table('user')->where('id',$user)->first();

            $data[$key] = ['id' => $user_post_all->id ,'mobile'=>$user_post_all->mobile,'language' => $user_post_all->lamguage,
            'firebase_token' => $user_post_all->firebase_token];
        }
        $output = ['data' => $data ,'user_ids'=>$user_id_all];
        foreach($output['data'] as $key => $user_all_details){
            //dd($user_all_details['language']);

            if ($user_all_details['language']==1) {
                $title = "Level up with Banner Ads!";
                $body = "Consider adding a banner ad , and see the magic of sales boost! Tap to learn more.";
            } elseif ($user_all_details['language']==2) {
                $title = 'नहीं मिलेगा ये मौका!';
                $body = 'अधिक ग्राहक का अर्थ है अधिक लाभ! आज ही बैनर विज्ञापन पोस्ट करें और बड़ी संख्या में दर्शकों तक आसानी से पहुंचें।';
            } elseif ($user_all_details['language']==3) {
                $title = 'এ সুযোগ পাবে না আর!';
                $body = 'বেশী পরিমানে খদ্দের অর্থাৎ বেশী মুনাফা! আজই ব্যানার অ্যাড পোস্ট করুন এবং অনায়াসে বিপুল সংখ্যক দর্শকের কাছে পৌঁছান।';
            }

            $id = DB::table('user')->where(['mobile'=>$user_all_details['mobile']])->value('id');
            $firebase_token = DB::table('user')->where(['mobile'=>$user_all_details['mobile']])->value('firebase_token');
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
           
            curl_close ( $ch );

        }
        $ids_str = implode(',',$output['user_ids']);
      //  dd($ids_str);
        Notification_save::insert([
            'ids'=>$ids_str,
            'title' => $title,
            'body' => $body,
            'status' => 1,
            'app_url'=>'/Home',
            'created_at' => now()
        ]);


        # Banner User
        foreach ($user_id_all1 as $key => $user){
            $user_post_all = DB::table('user')->where('id',$user)->first();
            
            $data[$key] = ['id' => $user_post_all->id ,'mobile'=>$user_post_all->mobile,'language' => $user_post_all->lamguage,
            'firebase_token' => $user_post_all->firebase_token];
        }
        $output1 = ['data' => $data ,'user_ids'=>$user_id_all1];
        foreach($output1['data'] as $key => $user_all_details){
        // dd($user_all_details);

            if ($user_all_details['language']==1) {
                $title = "Level up with Banner Ads!";
                $body = "Consider adding a banner ad , and see the magic of sales boost! Tap to learn more.";
            } elseif ($user_all_details['language']==2) {
                $title = 'नहीं मिलेगा ये मौका!';
                $body = 'अधिक ग्राहक का अर्थ है अधिक लाभ! आज ही बैनर विज्ञापन पोस्ट करें और बड़ी संख्या में दर्शकों तक आसानी से पहुंचें।';
            } elseif ($user_all_details['language']==3) {
                $title = 'এ সুযোগ পাবে না আর!';
                $body = 'বেশী পরিমানে খদ্দের অর্থাৎ বেশী মুনাফা! আজই ব্যানার অ্যাড পোস্ট করুন এবং অনায়াসে বিপুল সংখ্যক দর্শকের কাছে পৌঁছান।';
            }

            
            $id = DB::table('user')->where(['mobile'=>$user_all_details['mobile']])->value('id');
            $firebase_token = DB::table('user')->where(['mobile'=>$user_all_details['mobile']])->value('firebase_token');
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
        $ids_str = implode(',',$output1['user_ids']);
        //dd($ids_str);
        Notification_save::insert([
            'ids'=>$ids_str,
            'title' => $title,
            'body' => $body,
            'status' => 1,
            'app_url'=>'/Home',
            'created_at' => now()
        ]);

        \Log::info('Seller not Giving Ads--'.$result.' ftkn-'.$firebase_token);
    }
}
