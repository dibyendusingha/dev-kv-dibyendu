<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Subscription\Subscription_boost;
use App\Models\sms;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class subscribed_boosts_expiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribed_boosts:expiry';

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
        $today = Carbon::now()->format('Y-m-d H:i:s');
      //  dd($today);
        $subscribed_boost_details = DB::table('subscribed_boosts')->where('status',1)->get();
        //dd($subscribed_boost_details);
        foreach($subscribed_boost_details as $subscribed){
            if($subscribed->end_date < $today){

                DB::table('subscribed_boosts')->where('id',$subscribed->id)->update(['status' => 3]);

                $expired = sms::subscribed_boosts_expiry($subscribed->id);
                \Log::info("Subscribed Boosts Expiry");
            }
        }
    }
}
