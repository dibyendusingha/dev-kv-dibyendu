<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class sms_sent_n_product_boost_user extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Sms_Sent:Prefer_User';

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
        $n_product_details = DB::table('n_product_boost_cta')->where('status',0)->get();
       // dd($n_product_details);

        foreach($n_product_details as $key => $boost){
            $id = $boost->id;
            $receiver_id = $boost->receiver_id;
            $boost_id    = $boost->boost_id;

            $subscribed_boosts = DB::table('subscribed_boosts')->where('id',$boost_id)->first();

            $category_id = $subscribed_boosts->category_id;
            $product_id = $subscribed_boosts->product_id;

            if($category_id == 1){
                $product_details = DB::table('tractor')->where('id', $product_id)->first();
                $product_image   = asset("storage/tractor/".$product_details->front_image);
                $product_name    = "tractor";
            }else if($category_id == 3){
                $product_details = DB::table('goods_vehicle')->where('id', $product_id)->first();
                $product_image   = asset("storage/goods_vehicle/".$product_details->front_image);
                $product_name    = "goods_vehicle";

            }else if($category_id == 4){
                $product_details = DB::table('harvester')->where('id', $product_id)->first();
                $product_image   = asset("storage/harvester/".$product_details->front_image);
                $product_name    = "harvester";

            }else if($category_id == 5){
                $product_details = DB::table('implements')->where('id', $product_id)->first();
                $product_image   = asset("storage/implements/".$product_details->front_image);
                $product_name    = "implements";
            }else if($category_id == 6){
                $product_details = DB::table('seeds')->where('id', $product_id)->first();
                $product_image   = asset("storage/seeds/".$product_details->image1);
                $product_name    = "seeds";
            }else if($category_id == 7){
                $product_details = DB::table('tyres')->where('id', $product_id)->first();
                $product_image   = asset("storage/tyre/".$product_details->image1);
                $product_name    = "tyres";
            }else if($category_id == 8){
                $product_details = DB::table('pesticides')->where('id', $product_id)->first();
                $product_image   = asset("storage/pesticides/".$product_details->image1);
                $product_name    = "pesticides";
            }else if($category_id == 9){
                $product_details = DB::table('fertilizers')->where('id', $product_id)->first();
                $product_image   = asset("storage/fertilizers/".$product_details->image1);
                $product_name    = "fertilizers";
            }

           // dd(explode(",",$receiver_id));

            $receiver_id_arr = explode(',',$receiver_id);

            foreach ($receiver_id_arr as $user_id) {
                $user = DB::table('user')->where(['id'=>$user_id])->first();
                $firebase_token = $user->firebase_token;
                $language_id = $user->lamguage;

                $user_district_id = $user->district_id;
                $district_name = DB::table('district')->where('id',$user_district_id)->first()->district_name;

                if($language_id == 1 ){
                    $title = 'You may like this!!';
                    $body = 'Someone from '.$district_name.' posted '.$product_name.' check out nearby products here!';
                }else if($language_id == 2){
                    $title = 'पसंदीदा प्रोडक्ट देखें यही पर।';
                    $body = 'आपके इलाके के पास एक'.$product_name.' पोस्ट किया गया है। बिना देर किये इसे जल्द ही खरीद लें।';
                }else if($language_id == 3){
                    $title = 'আপনার পছন্দসই প্রোডাক্ট দেখুন এখানে!!';
                    $body = 'আপনার এলাকার কাছাকাছি একটি'.$product_name.'পোস্ট করা হয়েছে। আর দেরী না করে তাড়াতাড়ি কিনে ফেলুন।';
                }
            
                $url = 'https://fcm.googleapis.com/fcm/send';

                //$firebase_token = 'cJRSI7I7T-q_-nx1IkHzPH:APA91bHFtS8ioG1Xl-qF3Nwxv9w_Z28g3zAyjXRMJPRnHVyobsQDdsV49bnt5xtOC8IHyZ6dwpxFJOpZLTxs6aWqyDbzG-OmrbUa3f-5OE6bJdgLT2R-Ldt4tX_Z5wszSPKcpWc8EwPo';

                $fields = array (
                    'registration_ids' => array (
                        $firebase_token
                    ),
                    'data' => array (
                        'title' => $title,
                        'body' => $body,
                        'image' => $product_image,
                        'notification_id'=>rand(1000,9999).strtotime('Y-m-d H:i:s'),
                        'click_action'=> 'OPEN_SPECIFIC_PAGE',
                        'url'=> '/product_details',
                        'post_id'=>$product_id,
                        'category_id'=>$category_id,
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

            DB::table('n_product_boost_cta')->where(['id'=>$id])->update(['status'=>1]);
             DB::table('notification_saves')
                ->insert([
                    'ids'=>$receiver_id,
                    'title'=>$title,
                    'body'=>$body,
                    'status'=>1 ,
                    'app_url'=>'/product_details',
                    'banner_id' =>'',
                    'category_id'=>'',
                    'post_id' =>'',
                    'image' =>$product_image,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
            ]);
            // DB::table('notification_saves')
            //     ->insert([
            //         'ids'=>$receiver_id,
            //         'title'=>$title,
            //         'body'=>$body,
            //         'status'=>1 ,
            //         'category_id'=>$category_id,
            //         'post_id' =>$product_id,
            //         'app_url'=>'/product_details',
            //         'created_at'=>date('Y-m-d H:i:s'),
            //         'updated_at'=>date('Y-m-d H:i:s')
            // ]);
        }

        \Log::info("Sms Send N Product boost ");
    }
}
