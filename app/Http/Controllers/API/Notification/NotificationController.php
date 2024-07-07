<?php

namespace App\Http\Controllers\API\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription\notification_function as NF;
use App\Models\Subscription\Subscription_boost;
use App\Models\sms;
use Carbon\Carbon;



class NotificationController extends Controller
{
    public function notification(Request $request) {
        $new=[];
        //now()->subMonths(2);
        $user_id = auth()->user()->id;

        // $data = DB::table('notification_saves')->orderBy('id','desc')->where(['status'=>1])->whereRaw('FIND_IN_SET(?, ids)', [$user_id])
        // ->Where('created_at', '>=', now()->subMonths(2))->get();

        $data = DB::table('notification_saves')
        ->orderBy('id', 'desc')
        ->where('status', 1)
        ->whereRaw('FIND_IN_SET(?, ids)', [$user_id])
        ->cursor();
    
        foreach ($data as $val) {
            $id         = $val->id;
            $title      = $val->title;
            $body       = $val->body;
            $status     = $val->status;
            $app_url    = $val->app_url;
            $banner_id  = $val->banner_id;
            $category_id = $val->category_id;
            $post_id    = $val->post_id;
            $image      = $val->image;
            $created_at = $val->created_at;
            $updated_at = $val->updated_at;

            $new[] = ['id'=>$id,'title'=>$title,'body'=>$body,'app_url'=>$app_url,'banner_id'=>$banner_id,
                    'category_id'=>$category_id,'post_id'=>$post_id,'image'=>$image,'created_at'=>$created_at,'updated_at'=>$updated_at];
        }  
        $output['response'] = true;
        $output['message'] = 'Notification';
        $output['data'] = $new;
        $output['status_code'] = 200;
        $output['error'] = '';
        return $output;
    }

    //schedule for NOtification_today_login...
    public function n_banner_todays_login (Request $request) {

        $current = Carbon::now()->format('Y-m-d H:i:s');
        //active user, who open the app in 20 days;
        $active_banner = DB::table('ads_banners')->where(['status'=>1])->get();
        //$current_users = DB::select('SELECT user_id FROM app_open WHERE created_at >= CURDATE() - INTERVAL 1 DAY Group By user_id;');
        
        $current_users = DB::table('app_open as a')
            ->select('a.user_id','u.user_type_id','u.state_id','u.district_id','u.city_id','u.zipcode','u.lat','u.long')
            ->leftJoin('user as u','u.id','=','a.user_id')
            ->where('a.created_at', '>=', DB::raw('CURDATE() - INTERVAL 1 DAY'))
            ->groupBy('user_id')
            ->get();

            NF::n_banner_todays_login($current_users,$active_banner);
    }

    public function n_banner_state_user(Request $request) {
        $receiver_ids = [];
        $active_banners = DB::table('ads_banners')->where('status', 1)->get();
    
        foreach ($active_banners as $banner) {
            $campaign_state = $banner->campaign_state;
            $array_state = explode(',', $campaign_state);
    
            foreach ($array_state as $state_id) {
                $receiver_ids = [];

                $users = DB::table('user')
                            ->orderBy(DB::raw('RAND()'))
                            ->where(['state_id' => $state_id, 'status' => 1])
                            ->take(10)
                            ->get();
    
                foreach ($users as $user) {
                    $count = DB::table('n_banner_state_user')
                                ->where(['banner_id' => $banner->id])
                                ->whereRaw("FIND_IN_SET($user->id, receiver_id)")
                                ->count();
    
                    if ($count == 0) {
                        $receiver_ids[] = $user->id;
                        // Insert into n_banner_state_user table
                        
                    }
                }
                $receiver_id_str = implode(',',$receiver_ids);
                if ($receiver_id_str!='') {
                    DB::table('n_banner_state_user')->insert([
                        'banner_id' => $banner->id,
                        'receiver_id' => $receiver_id_str,
                        'state_id' => $state_id,
                        'status'=>0
                    ]);
                }
                
            }
        }
        
        // Do something with $receiver_ids if needed
    }

    public function n_banner_nearest_user (Request $request) {
        $receiver_ids = [];
        $active_banners = DB::table('ads_banners')->where('status', 1)->get();
        foreach ($active_banners as $val) {
            $recever_ids=[];
            $banner_id = $val->id;
            $area = 30;
            $data_banner = $this->banner_id_wish_user_send_notification($banner_id,$area);
            $recever_ids = implode(',',$data_banner['recever_id']);
            if (count($receiver_ids) >= 10) {
                break; // Break the loop if more than 10 receiver IDs are found
            }
            DB::table('n_banner_state_user')->insert(['banner_id'=>$banner_id,'receiver_id'=>$recever_ids]);
        }

    }
    
    public function n_direct_lead (Request $request) {
        echo $previousDate = Carbon::now()->subDays(2);
        $data = DB::table('banner_leads')->where('created_at','<=',$previousDate)->get();
        foreach ($data as $val) {
            $banner_id = $val->banner_id;
            echo $user_id = $val->user_id;

        }
    }


    /* area wise user notification */
    public function user_send_notification(Request $request , $area){
        // $area = $request->area;
        $banner_details = DB::table('ads_banners')->where('status',1)->get();
        foreach($banner_details as $key=> $banner){
            $user_details = DB::table('user')->where('id',$banner->user_id)->first();
            $user_district_id = $user_details->district_id;
            $user_zipcode = $user_details->zipcode;

            $pindata_count   = DB::table('city')->where(['pincode'=>$user_zipcode])->count();

            if($pindata_count > 0){
                $user_zipcode = $user_details->zipcode;
                $pindata      = DB::table('city')->where(['pincode'=>$user_zipcode])->first();

                $latitude     = $pindata->latitude;
                $longitude    = $pindata->longitude;
            }else if($pindata_count == 0){
                $user_zipcode = '700029';
                $pindata     = DB::table('city')->where(['pincode'=>$user_zipcode])->first();
                $latitude    = $pindata->latitude;
                $longitude   = $pindata->longitude;

            }
           
            $all_user = DB::table('userView')
                    ->select('*'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(userView.latitude))
                    * cos(radians(userView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(userView.latitude))) AS distance"))
                    ->orderBy('distance','asc')
                    ->where('status',1)
                    ->get();
                    // ->paginate(100);

            foreach($all_user as $key1 => $u){

                if($u->distance  < $area){

                    $data[$key1] = ['distance'=>$u->distance,'name'=>$u->name];
                }
            }

            $data_banner[$key] = ['banner_id'=>$banner->id, 'campaign_name'=>$banner->campaign_name, 'user'=>$data];
        }
          
        return $data_banner;
    }


    # Banner Id User send notification
    public function banner_id_wish_user_send_notification($banner_id,$area){
        //dd($request->banner_id);
        //$banner_id = $request->banner_id;
        //$area      = $request->area;
        $banner_details = DB::table('ads_banners')->where('id',$banner_id)->where('status',1)->first();

        $user_count = DB::table('user')->where('id',$banner_details->user_id)->count();
        if($user_count > 0){
            $user_details = DB::table('user')->where('id',$banner_details->user_id)->first();
            $user_district_id = $user_details->district_id;
            $user_zipcode = $user_details->zipcode;

            $pindata_count   = DB::table('city')->where(['pincode'=>$user_zipcode])->count();
            if($pindata_count > 0){
                $user_zipcode = $user_details->zipcode;
                $pindata      = DB::table('city')->where(['pincode'=>$user_zipcode])->first();

                $latitude     = $pindata->latitude;
                $longitude    = $pindata->longitude;
            }else if($pindata_count == 0){
                $user_zipcode = '700029';
                $pindata     = DB::table('city')->where(['pincode'=>$user_zipcode])->first();
                $latitude    = $pindata->latitude;
                $longitude   = $pindata->longitude;
            }

            $all_user = DB::table('userView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(userView.latitude))
                * cos(radians(userView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(userView.latitude))) AS distance"))
                ->orderBy('distance','asc')
                ->orderBy(DB::raw('RAND()'))
                ->where('status',1)
                ->get();
                // ->paginate(10);

                
            foreach($all_user as $key => $u){
                
                if($u->distance  < $area){

                    $count = DB::table('n_banner_state_user')
                                ->where(['banner_id' => $banner_details->id])
                                ->whereRaw("FIND_IN_SET($u->id, receiver_id)")
                                ->count();
    
                    if ($count == 0) {
                        $receiver_ids[] = $u->id;
                        // Insert into n_banner_state_user table
                        
                    }

                    $recever_id[] = $u->id;
                    //$data[$key] = ['distance'=>$u->distance,'name'=>$u->name,'id'=>$u->id,'firebase_token'=>$u->firebase_token];
                }
            }

            $data_banner = ['banner_id'=>$banner_details->id, 'campaign_name'=>$banner_details->campaign_name, 'recever_id'=>$recever_id];
        }

        return $data_banner;
    }


    # Product Boost Wish Product Id User send notification
    public function boost_product_wish_user_send_notification1(Request $request){
        $product_id = $request->product_id;
        $area = $request->area;

        $product_boost = DB::table('subscribed_boosts')
                        ->select('subscribed_boosts.*' , 'subscription_boosts.name as subscription_boosts_name',
                        'subscription_boosts.days as subscription_boosts_days','subscription_boosts.price as subscription_boosts_price')
                        ->leftJoin('subscription_boosts', 'subscription_boosts.id', '=', 'subscribed_boosts.subscription_boosts_id')
                        ->where('subscribed_boosts.product_id' ,$product_id )
                        ->where('subscribed_boosts.status',1)
                        ->first();
                        
        $user_id = $product_boost->user_id;

        $user_count = DB::table('user')->where('id',$user_id)->count();
        if($user_count > 0){
            $user_details = DB::table('user')->where('id',$user_id)->first();
            $user_zipcode = $user_details->zipcode;

            $pindata_count   = DB::table('city')->where(['pincode'=>$user_zipcode])->count();
            if($pindata_count > 0){
                $user_zipcode = $user_details->zipcode;
                $pindata      = DB::table('city')->where(['pincode'=>$user_zipcode])->first();

                $latitude     = $pindata->latitude;
                $longitude    = $pindata->longitude;
            }else if($pindata_count == 0){
                $user_zipcode = '700029';
                $pindata     = DB::table('city')->where(['pincode'=>$user_zipcode])->first();
                $latitude    = $pindata->latitude;
                $longitude   = $pindata->longitude;
            }

            $all_user = DB::table('userView')
                    ->select('*'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(userView.latitude))
                    * cos(radians(userView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(userView.latitude))) AS distance"))
                    ->orderBy('distance','asc')
                    ->where('status',1)
                    ->get();

            foreach($all_user as $key => $u){
                if($u->distance  < $area){
                    $data[$key] = ['distance'=>$u->distance,'name'=>$u->name];
                }
            }

            //$data_banner = ['subscription_boosts_name'=>$banner_details->id, 'campaign_name'=>$banner_details->campaign_name, 'user'=>$data];





        }




    }

    # Call to Action User Wish Category Count
    public function action_user_wish_category_count(Request $request)
    {
        $user_id = $request->user_id;
      //  dd($user_id);

        $output = array();
        $seller_user_count       = DB::table('seller_leads')->where('user_id',$user_id)->count();
        //dd($seller_user_count);
        $lead_view_count = DB::table('leads_view_all')->where('user_id',$user_id)->count();

        if($seller_user_count > 0)
        {
            $seller_details     = NF::call_action_user_wish_category_count($user_id);
            $output['response'] = true;
            $output['message']  = 'User call to action';
            $output['data']     =  $seller_details;
            $output['error']    = "";
        }
        else if($lead_view_count > 0)
        {
            $lead_all_view_details = NF::click_action_user_wish_category_count($user_id);
            $output['response']    = true;
            $output['message']     = 'User click to action';
            $output['data']        =  $lead_all_view_details;
            $output['error']       = "";
        }
        else if($seller_user_count == 0 && $lead_view_count == 0)
        {
            $output['response'] = false;
            $output['message']  = 'No Data Available With User';
            $output['data']     = [];
            $output['error']    = "";
        }
       
        return $output;
    }


    # User Cron Job Prefered_user
    public function action_user_wish_category_count1(Request $request)
    {
        $product_boost_details = DB::table('subscribed_boosts')->where('status',1)->get();
        foreach($product_boost_details as $boost){
            $user_id     = $boost->user_id;
            $product_id  = $boost->product_id;
            $category_id = $boost->category_id;

            $seller_lead_user_count = DB::table('seller_leads')->where('post_id',$product_id)->where('category_id',$category_id)->count();
          //  dd($seller_lead_user_count);
            if($seller_lead_user_count > 0){
                $seller_lead_user_details = DB::table('seller_leads')->where('post_id',$product_id)->where('category_id',$category_id)->get();

                foreach($seller_lead_user_details as $key => $lead_user){

                    $seller_category_cta   = NF::call_action_user_wish_category_count($lead_user->user_id);
                    $seller_category_click = NF::click_action_user_wish_category_count($lead_user->user_id);

                    $user_state_count = DB::table('user')->where('id',$lead_user->user_id)->count();
                    if($user_state_count > 0){
                        $user_state_id = DB::table('user')->where('id',$lead_user->user_id)->first()->state_id;
                    }else{
                        $user_state_id = 5; 
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
            }
        }

        $output['response'] = true;
        $output['message']  = 'Data saved';
        $output['error']    = "";
      
        return $output;
    }

    public function get_data(Request $request){

        $subscribed_boosts_details = DB::table('subscribed_boosts as sb')
        ->select('sb.id as boost_id','sb.category_id', 'sb.product_id','u.state_id')
        ->leftJoin('user as u', 'sb.user_id', '=', 'u.id')
        ->get();

       //dd($subscribed_boosts_details);

        foreach($subscribed_boosts_details as $key1=> $boots){
            $boost_id    = $boots->boost_id;
            $category_id = $boots->category_id;
            $state_id    = $boots->state_id;

            $receiver_id = [];

            $product_boost_cta = DB::table('prefered_user')->where(['category_cta'=>$category_id ,'user_state_id'=>$state_id ])->get();

            foreach($product_boost_cta as $key => $cta){

                $data_count =  DB::table('n_product_boost_cta')->first();
            //     $rec_user_id = $data_count->receiver_id;
            //   //  dd($data_count->receiver_id);
            //     if(in_array($cta->user_id, $rec_user_id)){

            //     }else{
            //         $receiver_id[] = $cta->user_id;
            //     }

                $receiver_id[] = $cta->user_id;
            }
            
            $rec_id = json_encode($receiver_id);
            // print_r(implode("," ,$receiver_id));
            // exit;

           $data_count =  DB::table('n_product_boost_cta')->where(['receiver_id'=>$rec_id])->count();
            // if($data_count == 0){

                $sql[$key1] = DB::table('n_product_boost_cta')->insert([
                    'boost_id'        => $boost_id,
                    'receiver_id'     => $rec_id,
                    'status'          => 0,
                    'created_at'      => carbon::now(),
                    'updated_at'      => carbon::now()
                ]);
            // }
        }

        $output['response'] = true;
        $output['message']  = 'Data saved';
        $output['error']    = "";

        return $output;

        


    }

    public function expiry_boost_product(Request $request){
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $subscribed_boost_details = DB::table('subscribed_boosts')->where('status',1)->get();
        foreach($subscribed_boost_details as $subscribed){
            if($subscribed->end_date < $today){
                Subscription_boost::where('id',$subscribed->id)->update(['status'=>0]);

                $expired = sms::subcription_expiry($subscribed->id);
                \Log::info(" Subcription Expiry");
            }
        }

    }

    public function user_send_email(){
        $email = DB::table('n_product_boost_cta')->first();
        $receiver_id = $email->receiver_id;
        $a = explode(',',$receiver_id);
        //dd();
        foreach($a as $key =>$r){
           echo $r."<br>";
        }
        
       // return $data;
        
    }



}
