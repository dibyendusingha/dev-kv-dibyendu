<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminEnd;

class EnglishCorn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'english:corn';

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
        info("English Cron job running at ". now());
        \Log::info("Cron job is running correctly!");
        
        $id = [];
        $data = [];
        //AdminEnd::push_notification_send();
            
            $english_content = DB::table('push_notification')->orderBy('id','desc')->where(['language_id'=>1])->first();
            
        DB::table('user')->select('id','firebase_token')->whereIn('mobile',[9123096629,8116597309,7980711876,7063166412])->where('status',1)->where('lamguage',1)->chunkById(1, function ($chunk) use (&$id) {
            foreach ($chunk as $user) {
                $id = $user->firebase_token;
        
        info("All IDS ". $id);
        \Log::info($id);
        
        
        // $user = DB::table('user')->whereIn('mobile',[9123096629])->get();
        // foreach ($user as $val) {
        //     $id = $val->firebase_token;
        
        //$id1 = implode (',',$id1);
        
        //\Log::info([$hindi]);
        
        //$id=['fZIzWMBDROi4iamGr5Jnxr:APA91bH1PRMASX0GA6NHqy8Xp_NFn24NkuFhRqScpxnU2i4MJaVsXHCnjXD3ThcWU-16rlVQANPqPYuDDR6vfF_KimFyt0UoC6R61GmMUI7mPzMVwtA5P32naa01zlirzz31Q3VmBrKZ'];
        //$id=[$id1];
        $english_content = DB::table('push_notification')->orderBy('id','desc')->where(['language_id'=>1])->first();
            $url = 'https://fcm.googleapis.com/fcm/send';
            
            $fields = array (
                'registration_ids' => array (
                        $id
                ),
                'notification' => [
                    'title' => $english_content->tiltle,
                    'body' => $english_content->deception,
                    'image' => $english_content->img,
                    'page' => 'notification'
                ],
                // 'fcm_options' => [
                //     'link' => 'https://my-server/some-page',
                // ],
                // 'data' => array (
                //         'click_action'=> 'OPEN_SPECIFIC_PAGE',
                //         'url'=> '/NotificationsPage'
                // )
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
             \Log::info($result);
            curl_close ( $ch );
        }
        });
    }
}
