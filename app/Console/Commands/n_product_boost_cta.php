<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class n_product_boost_cta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'n_product_boost_cta:data_save';

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
        $subscribed_boosts_details = DB::table('subscribed_boosts as sb')
        ->select('sb.id as boost_id','sb.category_id', 'sb.product_id','u.state_id')
        ->leftJoin('user as u', 'sb.user_id', '=', 'u.id')
        ->get();

       //dd($subscribed_boosts_details);

        foreach($subscribed_boosts_details as $key1=> $boots){
            $boost_id    = $boots->boost_id;
            $category_id = $boots->category_id;
            $state_id    = $boots->state_id;
            $product_id  = $boots->product_id;

            $receiver_id = [];

            $product_boost_cta = DB::table('prefered_user')->where(['category_cta'=>$category_id ,'user_state_id'=>$state_id ])->get();

            foreach($product_boost_cta as $key => $cta){

                $data_count =  DB::table('n_product_boost_cta')->first();

                $receiver_id[] = $cta->user_id;
            }
            
            $rec_id = implode(",",$receiver_id);
            // print_r(implode("," ,$receiver_id));
            // exit;

           $data_count =  DB::table('n_product_boost_cta')->where(['receiver_id'=>$rec_id])->count();
             // if($data_count == 0){

                if(!empty($rec_id)){
                    $sql[$key1] = DB::table('n_product_boost_cta')->insert([
                        'boost_id'        => $boost_id,
                        'receiver_id'     => $rec_id,
                        'status'          => 0,
                        'created_at'      => carbon::now(),
                        'updated_at'      => carbon::now()
                    ]);
                }else{
                    $sql[$key1] = DB::table('n_product_boost_cta')->insert([
                        'boost_id'        => $boost_id,
                        'receiver_id'     => 13,
                        'status'          => 0,
                        'created_at'      => carbon::now(),
                        'updated_at'      => carbon::now(),
                    ]);
                }

                
             // }
            // else if($data_count == 1){
            //     $sql[$key1] = DB::table('n_product_boost_cta')->where(['receiver_id'=>$rec_id])->update([
            //         'boost_id'        => $boost_id,
            //         'receiver_id'     => $rec_id,
            //         'status'          => 0,
            //         'created_at'      => carbon::now(),
            //         'updated_at'      => carbon::now()
            //     ]);
            // }
        }

        \Log::info("n_product_boost Data Saved Successfully");
    }
}
