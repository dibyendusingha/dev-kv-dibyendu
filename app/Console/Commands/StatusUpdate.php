<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription\Subscribed;
use Carbon\Carbon;
use App\Models\sms;

class StatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribe:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe Status Update';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $subscribed_details = Subscribed::where('status',1)->get();
        foreach($subscribed_details as $subscribed){
            if($subscribed->end_date < $today){
                Subscribed::where('id',$subscribed->id)->update(['status'=>0]);

                $expired = sms::subcription_expiry($subscribed->id);
                \Log::info(" Subcription Expiry");
            }
        }
    }
}
