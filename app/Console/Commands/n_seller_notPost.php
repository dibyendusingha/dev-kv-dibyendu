<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification_save;
use DB;

class n_seller_notPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:n_seller_not-post';

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
        $ids=[];
        
        $users = DB::table('user')
                ->leftJoin('tractor', 'user.id', '=', 'tractor.user_id')
                ->leftJoin('goods_vehicle', 'user.id', '=', 'goods_vehicle.user_id')
                ->leftJoin('harvester', 'user.id', '=', 'harvester.user_id')
                ->leftJoin('implements', 'user.id', '=', 'implements.user_id')
                ->leftJoin('seeds', 'user.id', '=', 'seeds.user_id')
                ->leftJoin('pesticides', 'user.id', '=', 'pesticides.user_id')
                ->leftJoin('fertilizers', 'user.id', '=', 'fertilizers.user_id')
                ->leftJoin('tyres', 'user.id', '=', 'tyres.user_id')
                ->whereNull('tractor.user_id')
                ->whereNull('goods_vehicle.user_id')
                ->whereNull('harvester.user_id')
                ->whereNull('implements.user_id')
                ->whereNull('seeds.user_id')
                ->whereNull('pesticides.user_id')
                ->whereNull('fertilizers.user_id')
                ->whereNull('tyres.user_id')
                ->whereIn('user.user_type_id', [2, 3, 4])
                ->select('user.id', 'user.name','user.mobile', 'user.lamguage' , 'user.firebase_token')
                ->inRandomOrder()
                ->limit(500)
                ->chunkById(100, function ($chunk) use (&$id, &$firebase_token,&$lamguage, &$title, &$body) {

            foreach($chunk as $val) {
                $id = $val->id;
                //dd($id);
                $ids[] = $id;
                $lamguage = $val->lamguage;
                //dd($lamguage);
                
                if ($lamguage==1) {
                    $title = "Level up with Boost!";
                    $body = "Have you considered giving your products a boost? With our Boost feature, you can increase your visibility and reach a larger audience effortlessly. Don't miss out on the chance to supercharge your sales.";
                } elseif ($lamguage==2) {
                    $title = 'नहीं मिलेगा ये मौका!';
                    $body = 'अधिक ग्राहक का अर्थ है अधिक लाभ! अपने पोस्ट किए गए उत्पादों को तुरंत बूस्ट करें और बड़ी संख्या में दर्शकों तक आसानी से पहुंचें।';
                } elseif ($lamguage==3) {
                    $title = 'এ সুযোগ পাবে না আর!';
                    $body = 'বেশী পরিমানে খদ্দের অর্থাৎ বেশী মুনাফা! এখুনি পোস্ট করা পণ্য বুস্ট করুন এবং অনায়াসে বিপুল সংখ্যক দর্শকের কাছে পৌঁছান।';
                }
                
                $firebase_token = $val->firebase_token;

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
                        'url'=> '/create_post',
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
                \Log::info('Seller not Post--'.$result.' ftkn-'.$firebase_token);
                curl_close ( $ch );
            }
            $ids_str = implode(',',$ids);
            //dd($title);
            Notification_save::insert([
                'ids'=>$ids_str,
                'title' => $title,
                'body' => $body,
                'status' => 1,
                'app_url'=>'/create_post',
                'created_at' => now()
            ]);
        });
        

    }
}
