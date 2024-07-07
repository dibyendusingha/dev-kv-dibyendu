<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\sms;
use Illuminate\Support\Facades\DB;

class mahindra_notification_lead_reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mahindra_notification:lead_reminder';

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
        $timestamp = strtotime("-3 days");
        $three_days_date = date('Y-m-d', $timestamp);
       // dd($three_days_date);

        $mahindra_enquiry_details = DB::table('mahindra_enquiry')->get();
        foreach($mahindra_enquiry_details as $mahindra_enquiry){
            $user_id = $mahindra_enquiry->user_id;
            $mobile     = $mahindra_enquiry->mobile;
            $created_at = $mahindra_enquiry->created_at;

            $today         = date_create($created_at);
            $current_date  = date_format($today,"Y-m-d");
           // dd($current_date);

            if($three_days_date == $current_date){
                //dd("enter");
                $mahindra_reminder_notification = sms::mahindra_enquiry($user_id);
            }else{
                \Log::info('Mahindra Notification not sent');
            }
        }
    }
}
