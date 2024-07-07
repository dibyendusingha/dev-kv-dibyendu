<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Notification_sent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification_sent';

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
        $data = DB::table('n_banner_today_login as a')
        ->select('a.banner_id', 'a.receiver_id','a.id', DB::raw('"n_banner_today_login" as table_name'), DB::raw("CONCAT('".env('IMAGE_PATH_SPONSER')."', b.campaign_banner) as campaign_banner"))
        ->leftJoin('ads_banners as b', 'b.id', '=', 'a.banner_id')
        ->where('a.status', '=', 0)
        ->skip(0)
        ->take(3);
    
        $subQuery = DB::table('n_banner_state_user as a')
        ->select('a.banner_id', 'a.receiver_id','a.id', DB::raw('"n_banner_state_user" as table_name'), DB::raw("CONCAT('".env('IMAGE_PATH_SPONSER')."', b.campaign_banner) as campaign_banner"))
        ->leftJoin('ads_banners as b', 'b.id', '=', 'a.banner_id')
        ->where('a.status', 0)
        ->skip(0)
        ->take(3);
 
        $data_all = $data->union($subQuery)->get();

        foreach ($data_all as $val) {
            $db_id = $val->id;
            $banner_id = $val->banner_id;
            $receiver_ids = $val->receiver_id;
            $table = $val->table_name;
            
            $banner_img = DB::table('ads_banners')->where(['id'=>$banner_id])->value('campaign_banner');


        $receiver_id_arr = explode(',',$receiver_ids);
         

        foreach ($receiver_id_arr as $user_id) {
            $user = DB::table('user')->select('id','name','lamguage','firebase_token')->where(['id'=>$user_id])->first();
            $id = $user->id;
            $name = $user->name;
            $lamguage = $user->lamguage;
            $firebase_token = $user->firebase_token;

            if ($table=='subscription_interest') {
                $title = 'What are you waiting for?';
                $body = 'Attract a pool of buyers from our platform. Subscribe for banner ads and watch your sales grow!';
            } else {

                if ($lamguage==1) {
                    $title = 'Dear User, There’s a banner ad from your area.';
                    $body = 'Enjoy buying products from your backyard market. Tap to learn more.';
                } else if ($lamguage==2) {
                    $title = 'देखिए देखिए!! आपके दरवाजे पर बैनर!';
                    $body = 'बस कुछ ही दूरी पर है यह बैनर! सुविधाओं का आनंद लेने के लिए बैनर पर टैप करें।';
                } else if ($lamguage==3) {
                    $title = 'নিকটবর্তী ব্যানারগুলি এখুনি দেখুন!';
                    $body = 'আপনারই নিকটবর্তী এলাকায় ব্যানার পোস্ট করা হয়েছে । বিশদে জানতে এখানে ক্লিক করুন।';
                }
                
            }
                
            $url = 'https://fcm.googleapis.com/fcm/send';

    
            $fields = array (
                'registration_ids' => array (
                    $firebase_token
                ),
                'data' => array (
                    'title' => $title,
                    'body' => $body,
                    'image' => asset("storage/sponser/".$banner_img),
                    'notification_id'=>rand(1000,9999).strtotime('Y-m-d H:i:s'),
                    'click_action'=> 'OPEN_SPECIFIC_PAGE',
                    'url'=> '/banner_page',
                    'banner_id'=>$banner_id,
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
        
        DB::table($table)->where(['id'=>$db_id])->update(['status'=>1]);
        DB::table('notification_saves')->insert(['ids'=>$receiver_ids,'title'=>$title,'body'=>$body,'status'=>1,
            'app_url'=>'/banner_page','banner_id'=>$banner_id,'image'=>asset("storage/sponser/".$banner_img),
            'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        }
                   
    }

}