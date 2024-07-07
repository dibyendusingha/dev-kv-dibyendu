<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PostBoost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:boost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post Boost Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $count = DB::table('sponser')->where(['ad_category'=>3,'status'=>0])->count();
        if ($count>0) {
            $data = DB::table('sponser')->where(['ad_category'=>3,'status'=>0])->get();
            foreach ($data as $val) {
                $id = $val->id;
                $user_id = $val->user_id;
                $ad_category = $val->ad_category;
                $date1 = $val->date1;
                $date2 = $val->date2;
                $category = $val->category;
                $post_id = $val->post_id;
            }
            
        }
    }
}
