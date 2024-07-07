<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;

class banner_pending implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $userId; // Define userId as a class property
    /**
     * Create a new job instance.
     */
    public function __construct($userId)
    {
        
        $this->userId = $userId;


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $receiver_id_arr = DB::table('user')->where('id',$this->userId)->first();
        DB::table('jobs')->insert([
            'queue' => $this->userId,
            'payload' => now(),
            'attempts'=>'',
            'reserved_at'=>'',
            'created_at'=>date('Y-m-d H:i:s')
        ]);
                
            $url = 'https://fcm.googleapis.com/fcm/send';
            $firebase_token = 'dbgzuOw3TH2q8AJTBUJ-4z:APA91bEuoh7O_TayZFgZKy4DvIFRRSAgm-6Hx5XXRaqvE2mjI1TQVq7YXERuITttqVdtAkwjMzrN8E-gJo1adEkNNm8mp6LlPlKAlcHo7FW0UaQ2BNFJ0NPyK6MyzkbvzS1JVhaHFT8z';
            $fields = array (
                'registration_ids' => array (
                    $firebase_token
                    ),
                
                'data' => array (
                    'title' => 'Title',
                    'body' => 'Deception',
                    'image' => 'https://www.krishivikas.com/storage/sponser/2024-02-01-19-34-501197image.jpg',
                    //$val->campaign_banner,
                    
                        'notification_id'=>rand(1000,9999).strtotime('Y-m-d H:i:s'),
                        'click_action'=> 'OPEN_SPECIFIC_PAGE',
                        'url'=> '/my_ads',
                        'banner_id'=>2,//$banner_id,
                        //'sound' => $sound, 
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
             \Log::info('Today Notification--'.$result.' ftkn-'.$firebase_token);
            curl_close ( $ch );
        }


    
}
