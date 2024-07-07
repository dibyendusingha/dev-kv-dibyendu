<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use App\Models\Subscription\notification_function as NF;
use Carbon\Carbon;

class Prefered_user extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Prefered:user_save';

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
        
        $seller_lead_user_details = DB::table('seller_leads')->get();

        foreach($seller_lead_user_details as $key => $lead_user){
            // dd($lead_user->user_id);

            $seller_category_cta   = NF::call_action_user_wish_category_count($lead_user->user_id);
            $seller_category_click = NF::click_action_user_wish_category_count($lead_user->user_id);


            $user_state_count = DB::table('user')->where('id',$lead_user->user_id)->count();
            if($user_state_count > 0){
                $user_state_id = DB::table('user')->where('id',$lead_user->user_id)->first()->state_id;
            }else{
                $user_state_id = 37; 
            }
            
            $prefered_user_count = DB::table('prefered_user')->where('user_id',$lead_user->user_id)->count();
            if($prefered_user_count == 0){
                
                $sql[$key] = DB::table('prefered_user')->insert([
                    'user_id'         => $lead_user->user_id,
                    'user_state_id'   => $user_state_id,
                    'category_cta'    => $seller_category_cta,
                    'category_click'  => $seller_category_click,
                    'created_at'      => carbon::now(),
                    'updated_at'      => carbon::now()
                ]);

            }
        }
        
        \Log::info("Preferred Data Saved Successfully");

    }
}
