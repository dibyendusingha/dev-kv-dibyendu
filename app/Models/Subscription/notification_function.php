<?php

namespace App\Models\Subscription;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class notification_function extends Model
{
    use HasFactory;

    protected function n_banner_todays_login ($current_users,$active_banner) {
        $current = Carbon::now()->format('Y-m-d H:i:s');
        $receiver_ids = [];
        foreach ($active_banner as $ban) {
            $sender_id = $ban->user_id;
            $campaign_state = $ban->campaign_state;
            $arr_campaign_state = explode(',',$campaign_state);
            

            foreach ($current_users as $user) {
                //$user_state = DB::table('user')->select('state_id')->where('id', $user['user_id'])->first();
                
                if (in_array($user->state_id, $arr_campaign_state)) {
                    $count = DB::table('n_banner_today_login')->where(['banner_id' => $ban->id])->whereRaw("FIND_IN_SET($user->user_id,receiver_id)")->count();
                    if ($count == 0) {
                        $receiver_ids[] = $user->user_id;
                    }
                }
                if (count($receiver_ids) >= 10) {
                    break; // Break the loop if more than 10 receiver IDs are found
                }
            }
            $receiver_id_str = implode(',',$receiver_ids);
            if ($receiver_id_str!='') {
                DB::table('n_banner_today_login')->insert(['sender_id'=>$sender_id,'banner_id'=>$ban->id,'receiver_id'=>$receiver_id_str,'created_at'=>$current]);
                return $receiver_ids;    
            }
            
        }
    }

    # Call to Action User Wish Category Count
    protected function call_action_user_wish_category_count($user_id){
        $seller_user = DB::table('seller_leads')->where('user_id',$user_id)->get();
        if(!empty($seller_user)){
            $seller_tractor_count = DB::table('seller_leads')->where('user_id',$user_id)->where('category_id',1)->count();
            $seller_gv_count      = DB::table('seller_leads')->where('user_id',$user_id)->where('category_id',3)->count();
            $seller_har_count     = DB::table('seller_leads')->where('user_id',$user_id)->where('category_id',4)->count();
            $seller_imp_count     = DB::table('seller_leads')->where('user_id',$user_id)->where('category_id',5)->count();
            $seller_seed_count    = DB::table('seller_leads')->where('user_id',$user_id)->where('category_id',6)->count();
            $seller_tyre_count    = DB::table('seller_leads')->where('user_id',$user_id)->where('category_id',7)->count();
            $seller_pes_count     = DB::table('seller_leads')->where('user_id',$user_id)->where('category_id',8)->count();
            $seller_fer_count     = DB::table('seller_leads')->where('user_id',$user_id)->where('category_id',9)->count();

            $wish_tractor_count   = DB::table('wishlist')->where('user_id',$user_id)->where('category_id',1)->count();
            $wish_gv_count        = DB::table('wishlist')->where('user_id',$user_id)->where('category_id',3)->count();
            $wish_har_count       = DB::table('wishlist')->where('user_id',$user_id)->where('category_id',4)->count();
            $wish_imp_count       = DB::table('wishlist')->where('user_id',$user_id)->where('category_id',5)->count();
            $wish_seed_count      = DB::table('wishlist')->where('user_id',$user_id)->where('category_id',6)->count();
            $wish_tyre_count      = DB::table('wishlist')->where('user_id',$user_id)->where('category_id',7)->count();
            $wish_pes_count       = DB::table('wishlist')->where('user_id',$user_id)->where('category_id',8)->count();
            $wish_fer_count       = DB::table('wishlist')->where('user_id',$user_id)->where('category_id',9)->count();

            $data = array();

            $data['tractor']    = ($seller_tractor_count + $wish_tractor_count);
            $data['gv']         = ($seller_gv_count + $wish_gv_count);
            $data['harvester']  = ($seller_har_count +$wish_har_count);
            $data['implement']  = ($seller_imp_count + $wish_imp_count);
            $data['seed']       = ($seller_seed_count + $wish_seed_count);
            $data['tyre']       = ($seller_tyre_count + $wish_tyre_count);
            $data['pesticides'] = ($seller_pes_count + $wish_pes_count);
            $data['fertilizer'] = ($seller_fer_count + $wish_fer_count);

           // dd($data);

            $max = max($data);

            if($max == $data['tractor'] ){
                $category = 1;
            }else if($max == $data['gv'] ){
                $category = 3;
            }else if($max == $data['harvester'] ){
                $category = 4;
            }else if($max == $data['implement'] ){
                $category = 5;
            }else if($max == $data['seed'] ){
                $category = 6;
            }else if($max == $data['tyre'] ){
                $category = 7;
            }else if($max == $data['pesticides'] ){
                $category = 8;
            }else if($max == $data['fertilizer'] ){
                $category = 9;
            }
          //  dd($max);

            if(!empty($data)){
                return $category;
            } 
        }
    }

    # Click to Action User Wish Category Count
    protected function click_action_user_wish_category_count($user_id){
        $lead_view_details = DB::table('leads_view_all')->where('user_id',$user_id)->get();
        if(!empty($lead_view_details)){
            $lead_tractor_count = DB::table('leads_view_all')->where('user_id',$user_id)->where('category_id',1)->count();
            $lead_gv_count      = DB::table('leads_view_all')->where('user_id',$user_id)->where('category_id',3)->count();
            $lead_har_count     = DB::table('leads_view_all')->where('user_id',$user_id)->where('category_id',4)->count();
            $lead_imp_count     = DB::table('leads_view_all')->where('user_id',$user_id)->where('category_id',5)->count();
            $lead_seed_count    = DB::table('leads_view_all')->where('user_id',$user_id)->where('category_id',6)->count();
            $lead_tyre_count    = DB::table('leads_view_all')->where('user_id',$user_id)->where('category_id',7)->count();
            $lead_pes_count     = DB::table('leads_view_all')->where('user_id',$user_id)->where('category_id',8)->count();
            $lead_fer_count     = DB::table('leads_view_all')->where('user_id',$user_id)->where('category_id',9)->count();

            $data = array();

            $data['tractor']    = $lead_tractor_count;
            $data['gv']         = $lead_gv_count;
            $data['harvester']  = $lead_har_count;
            $data['implement']  = $lead_imp_count;
            $data['seed']       = $lead_seed_count;
            $data['tyre']       = $lead_tyre_count;
            $data['pesticides'] = $lead_pes_count;
            $data['fertilizer'] = $lead_fer_count;

            $max = max($data);
           // dd($data);

           // dd($max);
            if($max == $data['tractor'] ){
                $category = 1;
            }else if($max == $data['gv'] ){
                $category = 3;
            }else if($max == $data['harvester'] ){
                $category = 4;
            }else if($max == $data['implement'] ){
                $category = 5;
            }else if($max == $data['seed'] ){
                $category = 6;
            }else if($max == $data['tyre'] ){
                $category = 7;
            }else if($max == $data['pesticides'] ){
                $category = 8;
            }else if($max == $data['fertilizer'] ){
                $category = 9;
            }

            if(!empty($data)){
                return $category;
            }
        }
    }


    

    




}