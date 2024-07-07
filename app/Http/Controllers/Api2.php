<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\LaraEmail;
use carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Tractor;
use App\Models\Rent_tractor;
use App\Models\Goods_vehicle;
use App\Models\Harvester;
use App\Models\Implement;
use App\Models\Seed;
use App\Models\Tyre;
use App\Models\pesticides;
use App\Models\fertilizers;

use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\Search as Search;
use App\Models\User as Userss;
use App\Models\Subscription\Subscription;
use Image;
use App\Models\Subscription\Subscribed_boost;

class Api2 extends Controller
{
    //
    
    public function user_token_update (Request $request) {
        $id = $request->id;
        $updated_device_id = $request->updated_device_id;
        $updated_token = $request->updated_token;
        
        $payload = ['id'=>$id,'updated_device_id'=>$updated_device_id,'updated_token'=>$updated_token];
        
        $count = DB::table('user')->where(['id'=>$id,'firebase_token'=>$updated_token])->count();
        if ($count==0) {
        $arr = DB::table('user')->where(['id'=>$id])->update(['firebase_token'=>$updated_token]);
            if($arr) {
            $output['response']=true;
            $output['message']='Usertoken updated successfully';
            $output['data'] = $arr;
            $output['error'] = "";
            } else {
            $output['response']=false;
            $output['message']='failed';
            $output['data'] = $payload;
            $output['error'] = "";
            
            }
        } else {
        $output['response']=false;
        $output['message']='Same Data Already Updated';
        $output['data'] = $payload;
        $output['error'] = "";
            
        }
        return $output;
    }

    public function maintenance () {
        $maintenance = DB::table('settings')->where(['name'=>'maintenance'])->value('value');
        if ($maintenance==0) {
            $output['response']=false;
            $output['message']='App is Live';
            $output['error'] = "";
        } else {
            $output['response']=true;
            $output['message']='App is Live';
            $output['error'] = "";
        }
        return $output;
       }
        
        public function get_lat_long (Request $request) {
            $output=[];
            $data=[];
            $user_id = $request->user_id;
            $user_token = $request->user_token;
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $latlong = $latitude.','.$longitude;
             $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
            if ($Autn==0) {
                $output['response']=false;
                $output['message']='Authentication Failed';
                $output['data'] = $data;
                $output['error'] = "";
                return $output;
                exit;
            } else {
                
                $update = DB::table('user')->where(['id'=>$user_id])->update(['latlong'=>$latlong]);
                if ($update) {
                    $output['response']=true;
                    $output['message']='Location Updated';
                    $output['data'] = $data;
                    $output['error'] = "";
                } else {
                    $output['response']=false;
                    $output['message']='Something Went Wrong';
                    $output['data'] = '';
                    $output['error'] = "";
                }
                
            }
            return $output;
        }

    public function pincode_check (Request $request) {
        $output=[];
        $data=[];
        $pincode = $request->pincode;
        
        $count = DB::table('city')->where(['pincode'=>$pincode])->count();
        if ($count>0) {
        $pindata = DB::table('city')->where(['pincode'=>$pincode])->first();
        $id = $pindata->id;
        $city_name = $pindata->city_name;
        $country_id = $pindata->country_id;
        $c = DB::table('country')->where(['id'=>$country_id])->first();
        $country_name = $c->country_name;
        
        $state_id = $pindata->state_id;
        $s = DB::table('state')->where(['id'=>$state_id])->first();
        $state_name = $s->state_name;
        
        $district_id = $pindata->district_id;
        $d = DB::table('district')->where(['id'=>$district_id])->first();
        $district_name = $d->district_name;
        
        $latitude = $pindata->latitude;
        $longitude = $pindata->longitude;
        
        $data[] = ['country_id'=>$country_id,'country_name'=>$country_name,'state_id'=>$state_id,'state_name'=>$state_name,'district_id'=>$district_id,'district_name'=>$district_name,
        'city_id'=>$id,'city_name'=>$city_name,'latitude'=>$latitude,'longitude'=>$longitude];
        
        $output['response']=true;
        $output['message']='Data';
        $output['data'] = $data;
        $output['error'] = "";
        } else {
        $output['response']=false;
        $output['message']='Something Went Wrong';
        $output['data'] = '';
        $output['error'] = "";   
        }
        return $output;
    }
    
    public function pincode_multiplecity (Request $request) {
        $output=[];
        $data=[];
        $pincode = $request->pincode;
        
        $count = DB::table('city')->where(['pincode'=>$pincode])->count();
        if ($count>0) {
        $pindata_arr = DB::table('city')->where(['pincode'=>$pincode])->get();
        foreach ($pindata_arr as $pindata) {
        $id = $pindata->id;
        $city_name = $pindata->city_name;
        $country_id = $pindata->country_id;
        $c = DB::table('country')->where(['id'=>$country_id])->first();
        $country_name = $c->country_name;
        
        $state_id = $pindata->state_id;
        $s = DB::table('state')->where(['id'=>$state_id])->first();
        $state_name = $s->state_name;
        
        $district_id = $pindata->district_id;
        $d = DB::table('district')->where(['id'=>$district_id])->first();
        $district_name = $d->district_name;
        
        $latitude = $pindata->latitude;
        $longitude = $pindata->longitude;
        
        $data[] = ['country_id'=>$country_id,'country_name'=>$country_name,'state_id'=>$state_id,'state_name'=>$state_name,'district_id'=>$district_id,'district_name'=>$district_name,
        'city_id'=>$id,'city_name'=>$city_name,'latitude'=>$latitude,'longitude'=>$longitude];
        }
        $output['response']=true;
        $output['message']='Data';
        $output['data'] = $data;
        $output['error'] = "";
        } else {
        $output['response']=false;
        $output['message']='Something Went Wrong';
        $output['data'] = '';
        $output['error'] = "";   
        }
        return $output;
    
    }

    public function pincode_track(Request $request) {
        $pincode = $request->pincode;
        $pin2 = substr($pincode, 0, 2);
        $pin3 = substr($pincode, 0, 3);
        $validator = Validator::make($request->all(), [
            'pincode' => 'required|size:6',
        ]);
        
        if ($validator->fails()) {
            $output['response']=false;
            $output['error_code']=403;
            $output['message']='Validation error!';
            $output['data'] = '';
            $output['error'] = $validator->errors();
        } else {
            $pin2_count = DB::table('pincode_tracking')->where(['code'=>$pin2])->count();
            if ($pin2_count>0) {
                $pin2_data = DB::table('pincode_tracking')->where(['code'=>$pin2])->first();
                $pin2_id  = $pin2_data->id;
                $code       = $pin2_data->code;
                $state_id   = $pin2_data->state_id;
                $state_data = DB::table('state')->where(['id'=>$state_id])->first();
                $arr = ['state_data'=>$state_data];
            } else {
                $pin3_count = DB::table('pincode_tracking')->where(['code'=>$pin3])->count();
                if ($pin3_count>0) {
                $pin3_data = DB::table('pincode_tracking')->where(['code'=>$pin3])->first();
                $pin3_id  = $pin3_data->id;
                $code       = $pin3_data->code;
                $state_id   = $pin3_data->state_id;
                $state_data = DB::table('state')->where(['id'=>$state_id])->first();
                $arr = ['state_data'=>$state_data];
            }
            }
            $output['response']=true;
            $output['error_code']=200;
            $output['message']='';
            $output['data'] = $arr;
            $output['error'] = $validator->errors();
        }
        return $output;
    }

    public function watermark () {
        $data = [];
        $data['wm'] = DB::table('settings')->where(['name'=>'kv-watermark','status'=>1])->value('value');
        $data['bb'] = DB::table('settings')->where(['name'=>'banner-backgroud','status'=>1])->value('value');
        
        $output['response']=true;
        $output['message']='Watermake Data';
        $output['data'] = $data;
        $output['error'] = "";
                
        return $output;
    }

    public function banner(Request $request) {
       // dd("hi");
        $lang_id = $request->lang_id;
       // dd($lang_id);
        if ($lang_id==1) {
            $col = 'slider_en';
        }else if ($lang_id==2) {
            $col = 'slider_hn';
        }else if ($lang_id==3) {
            $col = 'slider_bn';
        } else if ($lang_id ===null){
            $col = 'slider_en';
        }
      //  dd($col);
        $data = DB::table('settings')->orderBy('name_sequence','asc')->where(['name'=>$col,'status'=>1])->get();
        
        $output['response']=true;
        $output['message']='Watermake Data';
        $output['data'] = $data;
        $output['error'] = "";
                
        return $output;
    }

    public function settings (Request $request) {
        $output=[];
        $data=[];
        
        $array = DB::table('settings')->get();
        foreach ($array as $val) {
            $data['name'] = $val->name;
            $data['value'] = $val->value;
            $data['status'] = $val->status;
            
            $new[] = $data; 
        }
        
                $output['response']=true;
                $output['message']='Settings Data';
                $output['data'] = $new;
                $output['error'] = "";
                
                return $output;
        
    }
    
    
    
    public function language_save (Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $language_id = $request->language_id; //lang : 1->english , 2->hindi , 3->bengali
        $user_token = $request->user_token;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
        $data = DB::table('user')->where(['id'=>$user_id])->update(['lamguage'=>$language_id]);
        
        $output['response']=true;
        $output['message']='Language Update';
        $output['data'] = $data;
        $output['error'] = "";
        }
        return $output;
    }
    
    public function settings_promotion (Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $email_newslatter = $request->email_newslatter;
        $whatsapp_notification = $request->whatsapp_notification;
        $promotin = $request->promotin;
        $marketing_communication = $request->marketing_communication;
        $social_media_promotion = $request->social_media_promotion;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $update = Userss::where(['id'=>$user_id])
            ->update(['email_newslatter'=>$email_newslatter,'whatsapp_notification'=>$whatsapp_notification,'promotin'=>$promotin,'marketing_communication'=>$marketing_communication,'social_media_promotion'=>$social_media_promotion]);
            if ($update) {
                $output['response']=true;
                $output['message']='Update Successfully';
                $output['data'] = $update;
                $output['error'] = "";
            } else {
                $output['response']=false;
                $output['message']='Something Went Wrong';
                $output['data'] = '';
                $output['error'] = "Database Error";
            }
        }
        return $output;
    } 
    
    // public function user_token_update (Request $request) {
    //     $id = $request->id;
    //     $updated_device_id = $request->updated_device_id;
    //     $updated_token = $request->updated_token;
        
    //     $payload = ['id'=>$id,'updated_device_id'=>$updated_device_id,'updated_token'=>$updated_token];
        
    //     $count = DB::table('user')->where(['id'=>$id,'firebase_token'=>$updated_token])->count();
    //     if ($count>0) {
    //     $arr = DB::table('user')->where(['id'=>$id])->update(['firebase_token'=>$updated_token]);
    //     if($arr) {
    //     $output['response']=true;
    //     $output['message']='Usertoken updated successfully';
    //     $output['data'] = $arr;
    //     $output['error'] = "";
    //     } else {
    //     $output['response']=false;
    //     $output['message']='failed';
    //     $output['data'] = $payload;
    //     $output['error'] = "";
        
    //     }
    //     } else {
    //     $output['response']=false;
    //     $output['message']='Same Data Already Updated';
    //     $output['data'] = $payload;
    //     $output['error'] = "";
            
    //     }
    //     return $output;
    // }
    
    public function product_sharing (Request $request) {
        $output=[];
        $data=[];
        
        //$user_id = $request->user_id;
        //$user_token = $request->user_token;
        $category_id = $request->category_id;
        $item_id = $request->item_id;
        
        /*$Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }*/
        
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            //'user_id' => 'required',
            //'user_token' => 'required',
            'item_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = $validator->messages();
        } else {
            $where = ['id'=>$item_id];
            if ($category_id==1) {
                $data = Tractor::get_data_by_where($where);
            } else if ($category_id==3) {
                $data = Goods_vehicle::get_data_by_where($where);
            } else if ($category_id==4) {
                $data = Harvester::get_data_by_where($where);
            } else if ($category_id==5) {
                $data = Implement::get_data_by_where($where);
            } else if ($category_id==6) {
                $data = Seed::get_data_by_where($where);
            } else if ($category_id==7) {
                $data = Tyre::get_data_by_where($where);
            } else if ($category_id==8) {
                 $data = pesticides::get_data_by_where($where);
            } else if ($category_id==9) {
                $data = fertilizers::get_data_by_where($where);
            }
            //print_r($data); exit;
            if (sizeof($data)>0) {
                $output['response']=true;
                $output['message']='Data Get';
                $output['data'] = $data;
                $output['error'] = "";
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = $data;
                $output['error'] = "";  
            }
        }
        return $output;
        
    }

    # Profile 2
    public function profile (Request $request) {
        $output=[];
        $data=[];

        $login_data = $request->user();
        $user_id = $login_data['id'];
        $userId = auth()->user()->id;

      /*  $data = DB::table('user as u')
                        ->select('u.id','u.user_type_id','u.role_id','u.name','u.company_name','u.gst_no',
                        'u.mobile','u.email','u.facebook_id','u.google_id','u.gender','u.address','u.country_id',
                        'u.state_id','u.district_id','u.city_id','u.zipcode','u.lat','u.long','u.photo',
                        'u.dob','u.latlong','u.referral_code','u.firebase_token','u.token','u.status','u.created_at','u.verify_tag','ucvt.crops_verify_tag',
                        's.state_name','d.district_name','c.city_name','u.lamguage as language_id',  DB::raw('CASE WHEN u.promotion_offers = 1 THEN true ELSE false END AS promotion_offers'))
                        ->join('state as s','s.id','=','u.state_id')
                        ->join('district as d','d.id','=','u.district_id')
                        ->join('city as c','c.id','=','u.city_id')
                        ->join('user_crops_verify_tag as ucvt','ucvt.user_id','=','u.id')
                        ->where(['u.id'=>$user_id])
                        ->get();*/

        $data = DB::table('user as u')
        ->select('u.id', 'u.user_type_id', 'u.role_id', 'u.name', 'u.company_name', 'u.gst_no', 'u.mobile', 'u.email',
                    'u.facebook_id', 'u.google_id', 'u.gender', 'u.address', 'u.country_id', 'u.state_id', 'u.district_id',
                    'u.city_id', 'u.zipcode', 'u.lat', 'u.long', 'u.photo', 'u.dob', 'u.latlong', 'u.referral_code',
                    'u.firebase_token', 'u.token', 'u.status', 'u.created_at', 'u.verify_tag', 
                    'ucvt.crops_verify_tag', 's.state_name', 'd.district_name', 'c.city_name', 
                    'u.lamguage as lamguage_id', 
                    DB::raw('CASE WHEN u.promotion_offers = 1 THEN true ELSE false END AS promotion_offers'),
                    DB::raw('MAX(ucvt.subscription_id) as max_subscription_id')) // Add MAX aggregate function for subscription_id
        ->join('state as s', 's.id', '=', 'u.state_id')
        ->join('district as d', 'd.id', '=', 'u.district_id')
        ->join('city as c', 'c.id', '=', 'u.city_id')
        ->leftJoin('user_crops_verify_tag as ucvt', 'ucvt.user_id', '=', 'u.id')
        ->where('u.id', $user_id)
        ->groupBy('u.id', 'u.user_type_id', 'u.role_id', 'u.name', 'u.company_name', 'u.gst_no', 'u.mobile', 'u.email', 
                    'u.facebook_id', 'u.google_id', 'u.gender', 'u.address', 'u.country_id', 'u.state_id', 'u.district_id',
                    'u.city_id', 'u.zipcode', 'u.lat', 'u.long', 'u.photo', 'u.dob', 'u.latlong', 'u.referral_code', 
                    'u.firebase_token', 'u.token', 'u.status', 'u.created_at', 'u.verify_tag', 's.state_name', 'd.district_name',
                    'c.city_name', 'u.lamguage', 'ucvt.crops_verify_tag')
        ->orderByDesc('max_subscription_id') // Order by the max subscription_id
        ->limit(1)
        ->get();


        $userId = auth()->user()->id;
        //dd($userId);
        $tra_count     = DB::table('tractorView')->where('user_id',$userId)->count();
        $gv_count      = DB::table('goodVehicleView')->where('user_id',$userId)->count();
        $har_count     = DB::table('harvesterView')->where('user_id',$userId)->count();
        $imp_count     = DB::table('implementView')->where('user_id',$userId)->count();
        $seed_count    = DB::table('seedView')->where('user_id',$userId)->count();
        $pes_count     = DB::table('pesticidesView')->where('user_id',$userId)->count();
        $fer_count     = DB::table('fertilizerView')->where('user_id',$userId)->count();
        $ty_count      = DB::table('tyresView')->where('user_id',$userId)->count();

        
        $user_post_count = ( $tra_count +$gv_count+$har_count+$imp_count+$seed_count+$pes_count+$fer_count+$ty_count );
        $user_limit_count = DB::table('subscribeds')->where('user_id',$userId)->where('status',1)->count();
        //dd($user_limit_details);
        if($user_limit_count > 0){
            $user_limit_details = DB::table('subscribeds')->where('user_id',$userId)->where('status',1)->get();
            $limit_count = 0;
            foreach($user_limit_details as $userLimit){
                $subscription_feature_id = $userLimit->subscription_feature_id;
                $subscription_details = DB::table('subscription_features')->where('id',$subscription_feature_id)->first();
                $creatives = $subscription_details->creatives;
                $limit_count = $limit_count + $creatives;
            }
        }else if($user_limit_count == 0){
            $limit_count = 1;

        }

        $user_update = DB::table('user')->where('id',$userId)->update(['user_post_count'=>$user_post_count]);
        $user_limit_count = DB::table('user')->where('id',$userId)->first()->limit_count;
        

        //today's login history save.. for notification purpose...
        $current = Carbon::now()->format('Y-m-d H:i:s');
        $insert = DB::table('app_open')->insert(['user_id' => $userId, 'created_at' => $current]);
        $url = url('/');

        $output['response']        = true;
        $output['message']         = 'Data';
        $output['user_post_count'] = $user_post_count;
        $output['limit_count']     = $user_limit_count;
        $output['data']            = $data;
        if($url=='http://127.0.0.1:8000'){
            $output['razor_pay_key'] = 'rzp_test_GwHRJMGrMgQai7';
        } else if ($url=='https://kv.businessenquiry.co.in') {
            $output['razor_pay_key'] = 'rzp_test_GwHRJMGrMgQai7';
        } else if ($url=='https://www.krishivikas.com') {
            $output['razor_pay_key'] = 'rzp_live_P8FSPnk2ZVE4Qc.';
        } 
        $output['error']           = '';


        return $output;
    }

    #Update promotional status
    public function updatePromotionalStatus(Request $request) {
        $output=[];
        $data=[];
        $userId = auth()->user()->id;

      //  dd($userId);
        $promotionalStatus = $request->promotional_status;
         $validator = Validator::make($request->all(), [
            'promotional_status' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $update = DB::table('user')->where('id',$userId)->update(['promotion_offers'=>$promotionalStatus]);

            //dd($update);

            if ($update) {
                $output['response']=true;
                $output['message']='Update Successfully';
                $output['data'] = $update;
                $output['error'] = "";
            } else {
                $output['response']=false;
                $output['message']='Something Went Wrong';
                $output['data'] = '';
                $output['error'] = "Database Error";
            }
        }
        return $output;
    }
    #check coupon code exist or not
    public function checkCoupon(Request $request) {
        $output=[];
        $data=[];
        $userId = auth()->user()->id;

       // dd($userId);
        $couponCode = $request->coupon_code;
         $validator = Validator::make($request->all(), [
            'coupon_code' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $couponCount = DB::table('promotion_coupons')->where('coupon_code',$couponCode)->count();

            //dd($update);

            if ($couponCount) {
                $output['response']=true;
                $output['message']='Coupon code exist';
                $output['data'] = 'Coupon code exist';
                $output['error'] = "";
            } else {
                $output['response']=false;
                $output['message']='Something Went Wrong';
                $output['data'] = '';
                $output['error'] = "Database Error";
            }
        }
        return $output;
    }


    #Boosts coupon product
    public function boostsCouponProduct(Request $request) {
        $output=[];
        $data=[];
        $userId = auth()->user()->id;

        $couponCode = $request->coupon_code;
         $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'post_id' => 'required',
            'subscription_boosts_id' => 'required',
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $boostsCount =  DB::table('subscribed_boosts')
                            ->where('user_id',$userId)
                            ->where('status',1)
                            ->count();

           // $boostsCount = 3;
            
           // $packageData = DB::table('promotion_package')->where('subscription_boosts_id',$request->subscription_boosts_id)->first();

           $packageData = DB::table('subscribeds as sd')
                          ->select('sd.*', 'pp.package_name', 'pp.no_of_boots', 'pp.no_of_products','pp.package_price')
                          ->leftJoin('promotion_package as pp','pp.id','=','sd.package_id')
                          ->where('sd.coupon_type','promotion')
                          ->where('sd.user_id',$userId)
                          ->first();


            // echo $boostsCount;
            // echo "<br>".$packageData->no_of_boots;
            // dd($packageData);
            if($packageData->no_of_boots <= $boostsCount){
                $output['response']=false;
                $output['message']='You exceed your limit';
                $output['data'] = '';
                $output['error'] = "You exceed your limit";
                 return $output;
            } else {

                $couponData = DB::table('promotion_coupons')
                            ->where('user_id',$userId)
                            ->where('status',1)
                            ->first();
                $date1 =  Carbon::now();
                $start_date = date("Y-m-d H:i:s", strtotime($date1));
                

                $financialYear = Subscription::getFinancialYear($start_date,"y");//21-22 
               // dd($couponData);
                $getId = 0;
                $getId = DB::select("SELECT 
                LPAD(
                    MAX(
                        CAST(
                            SUBSTRING(invoice_no, LENGTH('AECPL/') + 1) AS UNSIGNED
                        )
                    ),
                    LENGTH(MAX(CAST(SUBSTRING(invoice_no, LENGTH('AECPL/') + 1) AS UNSIGNED))), '0'
                ) AS max_invoice_number
                    FROM (
                        SELECT invoice_no FROM subscribed_boosts
                        UNION ALL
                        SELECT invoice_no FROM subscribeds
                    ) AS combined_tables");


                $invoiceId = $getId[0]->max_invoice_number+1; #new id for Invoice
                    
                $subscribedBoostsData = [
                    'subscription_boosts_id'=>$request->subscription_boosts_id,
                    'invoice_no'=>"AECPL/".str_pad($invoiceId,5,"0", STR_PAD_LEFT)."/".$financialYear,
                    'user_id'=>$userId,
                    'category_id'=>$request->category_id,
                    'product_id'=>$request->post_id,
                    'price'=>$packageData->package_price,
                    'start_date'=>$couponData->start_date,
                    'end_date'=>$couponData->end_date,
                    'purchased_price'=>$packageData->package_price,
                    'gst'=>$couponData->gst,
                    'sgst'=>$couponData->sgst,
                    'cgst'=>$couponData->cgst,
                    'igst'=>$couponData->igst,
                    'status'=>1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

               // dd($subscribedBoostsData);
                //$insertSubscribedBoostsData = DB::table('subscribed_boosts')->insert($subscribedBoostsData);
                $getSubscribedBoostId = DB::table('subscribed_boosts')->insertGetId($subscribedBoostsData);
                $subscribedBoostsData = DB::table('subscribed_boosts')->where('id',$getSubscribedBoostId)->where('status',1)->orderBy('id','DESC')->first();

                //Start script for insert data into invoice table
                $dataInvoice = [
                    'invoice_type'=>'product_boosts_admin',
                    'invoice_name'=>$subscribedBoostsData->invoice_no,
                    'user_id' => $subscribedBoostsData->user_id,
                    'invoice_amount' => $subscribedBoostsData->price,
                    'start_date' => $subscribedBoostsData->start_date,
                    'end_date' => $subscribedBoostsData->end_date,
                    'gst' => $subscribedBoostsData->gst,
                    'cgst' => $subscribedBoostsData->cgst,
                    'sgst' => $subscribedBoostsData->sgst,
                    'igst' => $subscribedBoostsData->igst,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $insertInvoice = DB::table('invoice')->insert($dataInvoice);
                //End script for insert data into invoice table
            
                if ($insertInvoice) {
                    $output['response']=true;
                    $output['message']='Your product boosts successfully';
                    $output['data'] = 'Your product boosts successfully';
                    $output['error'] = "";
                } else {
                    $output['response']=false;
                    $output['message']='Something Went Wrong';
                    $output['data'] = '';
                    $output['error'] = "Database Error";
                }
            }

        }
        return $output;
    }

    // Get invoice
   /* public function getInvoiceData(Request $request, $invoiceId) {

        $output=[];
        $data=[];
       // $userId = auth()->user()->id;
        $userId  = DB::table('invoice')->where('id',$invoiceId)->first()->user_id;
       // dd($userId);

        if(!empty($invoiceId) && $invoiceId!="0"){

        $invoiceData  = DB::table('invoice as inv')
                        ->select('inv.*', 'u.name as user_name', 's.state_name', 'd.district_name', 'c.city_name', 'c.pincode')
                        ->leftJoin('user as u', 'u.id','=','inv.user_id')
                        ->leftJoin('state as s', 's.id','=','u.state_id')
                        ->leftJoin('district as d', 'd.id','=','u.district_id')
                        ->leftJoin('city as c', 'c.id','=','u.city_id')
                        ->where('inv.id', $invoiceId)
                        ->first();

        if ($invoiceData) {
            $output['response']=true;
            $output['message']='Invoice data';
            $output['data'] = $invoiceData;
             $output['error'] = "";
        } else {
            $output['response']=false;
            $output['message']='Invoice id not exist';
            $output['data'] = '';
            $output['error'] = "Database Error";
        }
    } else {
            $output['response']=false;
            $output['message']='Invoice id not exist';
            $output['data'] = '';
            $output['error'] = "Database Error";
    }
         return $output;

    }*/



    public function sponserer_profile(Request $request) {
        $output = []; $data=[];
        $login_data = $request->user();
        $user_id = $login_data['id'];
        $sponserer_id = $request->sponserer_id;

        $validator = Validator::make($request->all(), [
            'sponserer_id' => 'required',
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = $validator->errors();
        } else {

            $row['user_data'] = DB::table('user as u')
            ->select('u.id','u.user_type_id','u.role_id','u.name',
            'u.company_name','u.gst_no','u.mobile','u.email','u.address','u.country_id','u.state_id','u.district_id','u.city_id',
            'u.zipcode','u.lat','u.long','u.photo','s.state_name','d.district_name','c.city_name')
            ->join('state as s','s.id','=','u.state_id')
            ->join('district as d','d.id','=','u.district_id')
            ->join('city as c','c.id','=','u.city_id')
            ->where(['u.id'=>$sponserer_id])->first();
            $row['path'] = [
                'tractor'=>asset('public/storage/tractor/'),
                'gv'=>asset('public/storage/goods_vehicle/'),
                'har'=>asset('public/storage/harvester/'),
                'imp'=>asset('public/storage/implements/'),
                'seed' =>asset('public/storage/seeds/'),
                'pesti'=>asset('public/storage/pesticides/'),
                'ferti'=>asset('public/storage/fertilizers/'),
                'tyre' =>asset('public/storage/tyre/'),
            ];

            $row['data'] = DB::select('SELECT
            user.ID AS USER_ID,
            tractor.category_id,
            tractor.ID AS post_id,
            tractor.brand_id,
            brand.name AS brand_name,
            tractor.model_id,
            model.model_name AS model_name,
            tractor.front_image,
            tractor.price,
            tractor.title
        FROM
            user
        JOIN
            tractor ON tractor.USER_ID = user.ID
        LEFT JOIN
            brand ON tractor.brand_id = brand.id AND brand.category_id = 1    
        LEFT JOIN
            model ON tractor.model_id = model.id AND model.company_id = 1
        WHERE
            user.id = "'.$sponserer_id.'" and tractor.status=1
        
        UNION ALL
        
        SELECT
            user.ID AS USER_ID,
            goods_vehicle.category_id,
            goods_vehicle.ID AS post_id,
            goods_vehicle.brand_id,
            brand.name AS brand_name,
            goods_vehicle.model_id,
            model.model_name AS model_name,
            goods_vehicle.front_image,
            goods_vehicle.price,
            goods_vehicle.title
        FROM
            user
        JOIN
            goods_vehicle ON goods_vehicle.USER_ID = user.ID
        LEFT JOIN
            brand ON goods_vehicle.brand_id = brand.id AND brand.category_id = 3    
        LEFT JOIN
            model ON goods_vehicle.model_id = model.id AND model.company_id = 3
        WHERE
            user.id = "'.$sponserer_id.'" and goods_vehicle.status=1
        UNION ALL
        
        SELECT
            user.ID AS USER_ID,
            harvester.category_id,
            harvester.ID AS post_id,
            harvester.brand_id,
            brand.name AS brand_name,
            harvester.model_id,
            model.model_name AS model_name,
            harvester.front_image,
            harvester.price,
            harvester.title
        FROM
            user
        JOIN
            harvester ON harvester.USER_ID = user.ID
        LEFT JOIN
            brand ON harvester.brand_id = brand.id AND brand.category_id = 4     
        LEFT JOIN
            model ON harvester.model_id = model.id AND model.company_id = 4
        WHERE
            user.id = "'.$sponserer_id.'" and harvester.status=1
        UNION ALL
        
        SELECT
            user.ID AS USER_ID,
            implements.category_id,
            implements.ID AS post_id,
            implements.brand_id,
            brand.name AS brand_name,
            implements.model_id,
            model.model_name AS model_name,
            implements.front_image,
            implements.price,
            implements.title
        FROM
            user
        JOIN
            implements ON implements.USER_ID = user.ID
        LEFT JOIN
            brand ON implements.brand_id = brand.id AND brand.category_id = 5         
        LEFT JOIN
            model ON implements.model_id = model.id AND model.company_id = 5
        WHERE
            user.id = "'.$sponserer_id.'" and implements.status=1
        
        UNION ALL
        
        SELECT
            user.ID AS USER_ID,
            tyres.category_id,
            tyres.ID AS post_id,
            tyres.brand_id,
            brand.name AS brand_name,
            tyres.model_id,
            model.model_name AS model_name,
            tyres.image1,
            tyres.price,
            tyres.title
        FROM
            user
        JOIN
            tyres ON tyres.USER_ID = user.ID
        LEFT JOIN
            brand ON tyres.brand_id = brand.id AND brand.category_id = 7 
        LEFT JOIN
            model ON tyres.model_id = model.id AND model.company_id = 7
        WHERE
            user.id = "'.$sponserer_id.'" and tyres.status=1
        
        UNION ALL
        
        SELECT
            user.ID AS USER_ID,
            seeds.category_id,
            seeds.ID AS post_id,
            null as brand_id,
            null AS brand_name,
            NULL AS model_id, 
            null AS model_name,
            seeds.image1,
            seeds.price,
            seeds.title
        FROM
            user
        JOIN
            seeds ON seeds.USER_ID = user.ID
        
        WHERE
            user.id = "'.$sponserer_id.'" and seeds.status=1
            
        UNION ALL
        
        SELECT
            user.ID AS USER_ID,
            pesticides.category_id,
            pesticides.ID AS post_id,
            null as brand_id,
            null AS brand_name,
            NULL AS model_id, 
            null AS model_name,
            pesticides.image1,
            pesticides.price,
            pesticides.title
        FROM
            user
        JOIN
            pesticides ON pesticides.USER_ID = user.ID
        WHERE
            user.id = "'.$sponserer_id.'" and pesticides.status=1
        
        UNION ALL
        
        SELECT
            user.ID AS USER_ID,
            fertilizers.category_id,
            fertilizers.ID AS post_id,
            null as brand_id,
            null AS brand_name,
            NULL AS model_id, 
            null AS model_name,
            fertilizers.image1,
            fertilizers.price,
            fertilizers.title
        FROM
            user
        JOIN
            fertilizers ON fertilizers.USER_ID = user.ID
        WHERE
            user.id = "'.$sponserer_id.'" and fertilizers.status=1'
            
        );

            //print_r($row);
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $row;
            $output['error'] = '';

        }
        return $output;
    }

    public function user_posts (Request $request) {
        $user_id = auth()->user()->id;

        $datas = DB::select(
            "SELECT 
            NULL as distance,
            t.id,
            t.category_id,
            t.user_id,
                user.name,
                user.user_type_id,
                user.role_id,
                user.company_name,
                user.mobile,
                user.email,
                user.gender,
                user.address,
                user.zipcode,
                user.firebase_token,
                user.created_at as created_at_user,
                user.photo,
            t.set,
            t.type,
            t.brand_id,
            t.model_id,
            t.title,
            brand.name AS brand_name,
            model.model_name AS model_name,

            t.year_of_purchase,
            t.rc_available,
            t.noc_available,
            t.registration_no,
            t.description,
            t.is_negotiable,
            t.crop_type,
            t.cutting_with,
            t.power_source,
            t.position,

            t.front_image,
            t.left_image,
            t.right_image,
            t.back_image,
            t.meter_image,
            t.tyre_image,
            t.image1,
            t.image2,
            t.image3,
            t.price,
            t.rent_type,
            
            t.country_id,
            t.state_id,
            t.district_id,
            t.pincode,
            t.city_id,
            state.state_name AS state_name,
            district.district_name AS district_name,
            city.city_name AS city_name,
            t.latlong,
            t.ad_report,
            t.created_at,
            t.updated_at,
            t.status
            
            
        FROM (
            SELECT
                'tractor' AS category,
                id,
                category_id,
                user_id,
                `set`,
                `type`,
                brand_id,
                model_id,
                title,
                year_of_purchase,
                rc_available,
                noc_available,
                registration_no,
                `description`,
                is_negotiable,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', front_image) as front_image,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', left_image) as left_image,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', right_image) as right_image,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', back_image) as back_image,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', meter_image) as meter_image,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', tyre_image) as tyre_image,
                NULL as image1,
                NULL as image2,
                NULL as image3,
                price,
                rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,
                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM
                tractor
            WHERE
                user_id = $user_id
        
            UNION ALL
        
            SELECT
                'goods_vehicle',
                id,
                category_id,
                user_id,
                `set`,
                `type`,
                brand_id,
                model_id,
                title,

                year_of_purchase,
                rc_available,
                noc_available,
                registration_no,
                `description`,
                is_negotiable,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,

                CONCAT('" . env('IMAGE_PATH_GV') . "',front_image) as front_image,
                CONCAT('" . env('IMAGE_PATH_GV') . "',left_image) as left_image,
                CONCAT('" . env('IMAGE_PATH_GV') . "',right_image) as right_image,
                CONCAT('" . env('IMAGE_PATH_GV') . "',back_image) as back_image,
                CONCAT('" . env('IMAGE_PATH_GV') . "',meter_image) as meter_image,
                CONCAT('" . env('IMAGE_PATH_GV') . "',tyre_image) as tyre_image,
                NULL as image1,
                NULL as image2,
                NULL as image3,
                
                price,
                rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM goods_vehicle
            WHERE user_id = $user_id
        
            UNION ALL
        
            SELECT
               'harvester',
                id,
                category_id,
                user_id,
                `set`,
                `type`,
                brand_id,
                model_id,
                title,

                year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                is_negotiable,
                crop_type,
                cutting_with,
                power_source,
                NULL as position,

                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as front_image,
                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',left_image) as left_image,
                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',right_image) as right_image,
                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',back_image) as back_image,
                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as meter_image,
                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as tyre_image,
                NULL as image1,
                NULL as image2,
                NULL as image3,
                
                price,
                rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                NULL as latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM harvester
            WHERE user_id = $user_id
        
            UNION ALL
        
            SELECT
                'implements',
                id,
                category_id,
                user_id,
                `set`,
                `type`,
                brand_id,
                model_id,
                title,

                year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                is_negotiable,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,

                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as front_image,
                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',left_image) as left_image,
                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',right_image) as right_image,
                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',back_image) as back_image,
                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as meter_image,
                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as tyre_image,
                NULL as image1,
                NULL as image2,
                NULL as image3,
                
                price,
                rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM implements
            WHERE user_id = $user_id
        
            UNION ALL
        
            SELECT
                'seeds',
                id,
                category_id,
                user_id,
                NULL as `set`,
                NULL as `type`,
                NULL as brand_id,
                NULL as model_id,
                title,

                NULL as year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                `is_negotiable`,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,

                NULL as front_image,
                NULL as left_image,
                NULL as right_image,
                NULL as back_image,
                NULL as meter_image,
                NULL as tyre_image,
                CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image1) as image1,
                CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image2) as image2,
                CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image3) as image3,
                
                price,
                NULL as rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM seeds
            WHERE user_id = $user_id
        
            UNION ALL
        
            SELECT
                'pesticides',
                id,
                category_id,
                user_id,
                NULL as `set`,
                NULL as `type`,
                NULL as brand_id,
                NULL as model_id,
                title,

                NULL as year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                `is_negotiable`,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,

                NULL as front_image,
                NULL as left_image,
                NULL as right_image,
                NULL as back_image,
                NULL as meter_image,
                NULL as tyre_image,
                CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image1) as image1,
                CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image2) as image2,
                CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image3) as image3,
                
                price,
                NULL as rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM pesticides
            WHERE user_id = $user_id
        
            UNION ALL
        
            SELECT
             ' fertilizers',
                id,
                category_id,
                user_id,
                NULL as `set`,
                NULL as `type`,
                NULL as brand_id,
                NULL as model_id,
                title,

                NULL as year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                `is_negotiable`,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,

                NULL as front_image,
                NULL as left_image,
                NULL as right_image,
                NULL as back_image,
                NULL as meter_image,
                NULL as tyre_image,
                CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image1) as image1,
                CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image2) as image2,
                CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image3) as image3,
                
                price,
                NULL as rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM fertilizers
            WHERE user_id = $user_id
        
            UNION ALL
        
            SELECT
            'tyres',
                id,
                category_id,
                user_id,
                NULL as `set`,
                `type`,
                brand_id,
                model_id,
                title,

                NULL as year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                `is_negotiable`,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                `position`,

                NULL as front_image,
                NULL as left_image,
                NULL as right_image,
                NULL as back_image,
                NULL as meter_image,
                NULL as tyre_image,
                CONCAT('" . env('IMAGE_PATH_TYRE') . "',image1) as image1,
                CONCAT('" . env('IMAGE_PATH_TYRE') . "',image2) as image2,
                CONCAT('" . env('IMAGE_PATH_TYRE') . "',image3) as image3,
                
                price,
                NULL as rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM tyres
            WHERE user_id = $user_id
        
        ) AS t
        LEFT JOIN brand ON t.brand_id = brand.id
        LEFT JOIN model ON t.model_id = model.id
        LEFT JOIN state ON t.state_id = state.id
        LEFT JOIN district ON t.district_id = district.id
        LEFT JOIN city ON t.city_id = city.id
        LEFT JOIN user on t.user_id = user.id");


        foreach ($datas as $data) {
            
            $boost_data = Subscribed_boost::view_all_boosted_products($data->category_id,$data->id);
            if($boost_data == 0){
                $data->is_boosted  = false;
            }else if($boost_data == 1){
                $data->is_boosted  = true;
            }

            $data->boosted=[];
            $product_id = $data->id;
            $category_id = $data->category_id;
            $data->boosted = DB::table('subscribed_boosts')->where(['category_id'=>$category_id,'product_id'=>$product_id])->latest()->first();

            //$boosted = DB::table('subscribed_boosts')->where(['category_id'=>$category_id,'product_id'=>$product_id])->latest()->first();
            ///dd($boosted);
        }

        foreach ($datas as $data) {
            $data->specification=[];
            $model_id = $data->model_id;
            $data->specification = DB::table('specifications')
                            ->where(['model_id'=>$model_id,'status'=>1])->get();
        }

        $output['response']=true;
        $output['message']='Data';
        $output['data'] = $datas;
        $output['status_code'] = 200;
        $output['error'] = '';

        return $output;
    }

  //////////////////
    public function getNewBoosts(Request $request) {
        $user_id = auth()->user()->id;

        $datas = DB::select(
            "SELECT 
            NULL as distance,
            t.id,
            t.category_id,
            t.user_id,
                user.name,
                user.user_type_id,
                user.role_id,
                user.company_name,
                user.mobile,
                user.email,
                user.gender,
                user.address,
                user.zipcode,
                user.firebase_token,
                user.created_at as created_at_user,
                user.photo,
            t.set,
            t.type,
            t.brand_id,
            t.model_id,
            t.title,
            brand.name AS brand_name,
            model.model_name AS model_name,

            t.year_of_purchase,
            t.rc_available,
            t.noc_available,
            t.registration_no,
            t.description,
            t.is_negotiable,
            t.crop_type,
            t.cutting_with,
            t.power_source,
            t.position,

            t.front_image,
            t.left_image,
            t.right_image,
            t.back_image,
            t.meter_image,
            t.tyre_image,
            t.image1,
            t.image2,
            t.image3,
            t.price,
            t.rent_type,
            
            t.country_id,
            t.state_id,
            t.district_id,
            t.pincode,
            t.city_id,
            state.state_name AS state_name,
            district.district_name AS district_name,
            city.city_name AS city_name,
            t.latlong,
            t.ad_report,
            t.created_at,
            t.updated_at,
            t.status
            
            
        FROM (
            SELECT
                'tractor' AS category,
                id,
                category_id,
                user_id,
                `set`,
                `type`,
                brand_id,
                model_id,
                title,
                year_of_purchase,
                rc_available,
                noc_available,
                registration_no,
                `description`,
                is_negotiable,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', front_image) as front_image,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', left_image) as left_image,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', right_image) as right_image,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', back_image) as back_image,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', meter_image) as meter_image,
                CONCAT('" . env('IMAGE_PATH_TRACTOR') . "', tyre_image) as tyre_image,
                NULL as image1,
                NULL as image2,
                NULL as image3,
                price,
                rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,
                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM
                tractor
            WHERE
                user_id = $user_id AND `set`='sell' AND `type`='old' AND `status`=1
        
            UNION ALL
        
            SELECT
                'goods_vehicle',
                id,
                category_id,
                user_id,
                `set`,
                `type`,
                brand_id,
                model_id,
                title,

                year_of_purchase,
                rc_available,
                noc_available,
                registration_no,
                `description`,
                is_negotiable,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,

                CONCAT('" . env('IMAGE_PATH_GV') . "',front_image) as front_image,
                CONCAT('" . env('IMAGE_PATH_GV') . "',left_image) as left_image,
                CONCAT('" . env('IMAGE_PATH_GV') . "',right_image) as right_image,
                CONCAT('" . env('IMAGE_PATH_GV') . "',back_image) as back_image,
                CONCAT('" . env('IMAGE_PATH_GV') . "',meter_image) as meter_image,
                CONCAT('" . env('IMAGE_PATH_GV') . "',tyre_image) as tyre_image,
                NULL as image1,
                NULL as image2,
                NULL as image3,
                
                price,
                rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM goods_vehicle
            WHERE user_id = $user_id AND `set`='sell' AND `type`='old' AND `status`=1
        
            UNION ALL
        
            SELECT
               'harvester',
                id,
                category_id,
                user_id,
                `set`,
                `type`,
                brand_id,
                model_id,
                title,

                year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                is_negotiable,
                crop_type,
                cutting_with,
                power_source,
                NULL as position,

                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as front_image,
                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',left_image) as left_image,
                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',right_image) as right_image,
                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',back_image) as back_image,
                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as meter_image,
                CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as tyre_image,
                NULL as image1,
                NULL as image2,
                NULL as image3,
                
                price,
                rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                NULL as latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM harvester
            WHERE user_id = $user_id AND `set`='sell' AND `type`='old' AND `status`=1
        
            UNION ALL
        
            SELECT
                'implements',
                id,
                category_id,
                user_id,
                `set`,
                `type`,
                brand_id,
                model_id,
                title,

                year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                is_negotiable,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,

                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as front_image,
                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',left_image) as left_image,
                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',right_image) as right_image,
                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',back_image) as back_image,
                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as meter_image,
                CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as tyre_image,
                NULL as image1,
                NULL as image2,
                NULL as image3,
                
                price,
                rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM implements
            WHERE user_id = $user_id AND `set`='sell' AND `type`='old' AND `status`=1
        
            UNION ALL
        
            SELECT
                'seeds',
                id,
                category_id,
                user_id,
                NULL as `set`,
                NULL as `type`,
                NULL as brand_id,
                NULL as model_id,
                title,

                NULL as year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                `is_negotiable`,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,

                NULL as front_image,
                NULL as left_image,
                NULL as right_image,
                NULL as back_image,
                NULL as meter_image,
                NULL as tyre_image,
                CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image1) as image1,
                CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image2) as image2,
                CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image3) as image3,
                
                price,
                NULL as rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM seeds
            WHERE user_id = $user_id AND `status`=1
        
            UNION ALL
        
            SELECT
                'pesticides',
                id,
                category_id,
                user_id,
                NULL as `set`,
                NULL as `type`,
                NULL as brand_id,
                NULL as model_id,
                title,

                NULL as year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                `is_negotiable`,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,

                NULL as front_image,
                NULL as left_image,
                NULL as right_image,
                NULL as back_image,
                NULL as meter_image,
                NULL as tyre_image,
                CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image1) as image1,
                CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image2) as image2,
                CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image3) as image3,
                
                price,
                NULL as rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM pesticides
            WHERE user_id = $user_id AND `status`=1
        
            UNION ALL
        
            SELECT
             ' fertilizers',
                id,
                category_id,
                user_id,
                NULL as `set`,
                NULL as `type`,
                NULL as brand_id,
                NULL as model_id,
                title,

                NULL as year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                `is_negotiable`,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                NULL as position,

                NULL as front_image,
                NULL as left_image,
                NULL as right_image,
                NULL as back_image,
                NULL as meter_image,
                NULL as tyre_image,
                CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image1) as image1,
                CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image2) as image2,
                CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image3) as image3,
                
                price,
                NULL as rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM fertilizers
            WHERE user_id = $user_id AND `status`=1
        
            UNION ALL
        
            SELECT
            'tyres',
                id,
                category_id,
                user_id,
                NULL as `set`,
                `type`,
                brand_id,
                model_id,
                title,

                NULL as year_of_purchase,
                NULL as rc_available,
                NULL as noc_available,
                NULL as registration_no,
                `description`,
                `is_negotiable`,
                NULL as crop_type,
                NULL as cutting_with,
                NULL as power_source,
                `position`,

                NULL as front_image,
                NULL as left_image,
                NULL as right_image,
                NULL as back_image,
                NULL as meter_image,
                NULL as tyre_image,
                CONCAT('" . env('IMAGE_PATH_TYRE') . "',image1) as image1,
                CONCAT('" . env('IMAGE_PATH_TYRE') . "',image2) as image2,
                CONCAT('" . env('IMAGE_PATH_TYRE') . "',image3) as image3,
                
                price,
                NULL as rent_type,
                country_id,
                state_id,
                district_id,
                city_id,
                pincode,

                latlong,
                ad_report,
                created_at,
                updated_at,
                `status`
            FROM tyres
            WHERE user_id = $user_id AND `type`='old' AND `status`=1
        
        ) AS t
        LEFT JOIN brand ON t.brand_id = brand.id
        LEFT JOIN model ON t.model_id = model.id
        LEFT JOIN state ON t.state_id = state.id
        LEFT JOIN district ON t.district_id = district.id
        LEFT JOIN city ON t.city_id = city.id
        LEFT JOIN user on t.user_id = user.id");


        foreach ($datas as $data) {
            $boost_data = Subscribed_boost::view_all_boosted_products($data->category_id,$data->id);
            if($boost_data == 0){
                $data->is_boosted  = false;
            }else if($boost_data == 1){
                $data->is_boosted  = true;
            }

            $data->boosted=[];
            $product_id = $data->id;
            $category_id = $data->category_id;
            $data->boosted = DB::table('subscribed_boosts')->where(['category_id'=>$category_id,'product_id'=>$product_id])->latest()->first();
        }

        foreach ($datas as $data) {
            $data->specification=[];
            $model_id = $data->model_id;
            $data->specification = DB::table('specifications')
                            ->where(['model_id'=>$model_id,'status'=>1])->get();
        }

        $output['response']=true;
        $output['message']='Data';
        $output['data'] = $datas;
        $output['status_code'] = 200;
        $output['error'] = '';

        return $output;
    }
  ////////////////  
    
    
}
