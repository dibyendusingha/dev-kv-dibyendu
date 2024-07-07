<?php

namespace App\Models\Crops;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CropsSubscribed extends Model
{
    use HasFactory;

    # ADD CROPS SUBSCRIBED
    protected function addCropsSubscribed($crops_subscribed){
        //dd($crops_subscribed);
        $add_crops_subscribed_id = DB::table('crops_subscribeds')->insertGetId($crops_subscribed);

        $crops_subscribed_details = DB::table('crops_subscribeds')->where('id',$add_crops_subscribed_id)->first();
       
        $user_id          = $crops_subscribed_details->user_id;
        $subscription_id  = $crops_subscribed_details->subscription_id;

        $crops_verification_tag   = DB::table('crop_subscription_features')->where('crops_subscription_id',$subscription_id)
        ->value('verification_tag');
     
        $user_update = DB::table('user')->where('id',$user_id)->update(['crops_verify_tag' =>$crops_verification_tag]);
        return true;
    }
}
