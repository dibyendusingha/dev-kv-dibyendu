<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\LaraEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Goods_vehicle;

use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\Search as Search;
use App\Models\User as Userss;
use Image;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Models\sms;
use Cache;
use App\Models\Subscription\Subscribed_boost;

class GVController extends Controller
{
    //
    public function gv_add (Request $request) {
        $output=[];
        $data=[];
        $user_id = auth()->user()->id;
        $userData = DB::table('user')->where('id', $user_id)->first();
         if($userData->limit_count <= $userData->user_post_count){
                $output['response']=false;
                $output['message']='You exceed your limit';
                $output['data'] = '';
                $output['error'] = "You exceed your limit";
                 return $output;
        } else {
        $category_id = $request->category_id;
        $set = $request->set;
        $type = $request->type;
        $brand_id = $request->brand_id;
        $model_id = $request->model_id;
        $title = $request->title;
        $year_of_purchase = $request->year_of_purchase;
        $rc_available = $request->rc_available;
        $noc_available = $request->noc_available;
        $registration_no = $request->registration_no;
        $description = $request->description;
        $left_image = $request->left_image;
        $right_image = $request->right_image;
        $front_image = $request->front_image;
        $back_image = $request->back_image;
        $meter_image = $request->meter_image;
        $tyre_image = $request->tyre_image;
        $price = $request->price;
        $rent_type = $request->rent_type;
        $is_negotiable = $request->is_negotiable;
        $pincode = $request->pincode;
        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $district_id = $request->district_id;
        $city_id = $request->city_id;
        $latlong = $request->latlong;
        
        $Autn = DB::table('user')->where('id', $user_id)->count();
        if ($Autn==0) {
            $mobile = DB::table('user')->where('id', $user_id)->value('mobile');
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        } else {
            $mobile = DB::table('user')->where('id', $user_id)->value('mobile');
        }
        
        $validator = Validator::make($request->all(), [
            'set'           =>'required',
            'type'          => 'required',
            'category_id'   => 'required|integer',
            'brand_id'      => 'required|integer',
            'model_id'      => 'required|integer',
            'year_of_purchase'=>'required',
            //'rc_available'  =>'required',
            //'noc_available' =>'required',
            'price'         =>'required|integer',
            //'is_negotiable' =>'required|integer',
            'pincode'       =>'required|digits:6',
            'country_id'    =>'required|integer',
            'state_id'      =>'required|integer',
            'district_id'   =>'required|integer',
            
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = $validator->messages();
        } else {
            
            /*$user_data = DB::table('user')->where(['id'=>$user_id])->first();
            $state_id = $user_data->state_id;
            $city_id  = $user_data->city_id;
           */
           
            if ($left_image = $request->file('left_image')) {
                $name = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('left_image')->getClientOriginalName();
                $ext = $request->file('left_image')->getClientOriginalExtension();
                $request->file('left_image')->storeAs('public/goods_vehicle', $name);
                
                
            }else {
                $name='';
            }
            if ($right_image = $request->file('right_image')) {
                $name1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('right_image')->getClientOriginalName();
                $ext = $request->file('right_image')->getClientOriginalExtension();
                $request->file('right_image')->storeAs('public/goods_vehicle', $name1);
                
                
            }else {
                $name1='';
            }
            if ($front_image = $request->file('front_image')) {
                $name2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('front_image')->getClientOriginalName();
                $ext = $request->file('front_image')->getClientOriginalExtension();
                $request->file('front_image')->storeAs('public/goods_vehicle', $name2);
                
                
            }else {
                $name2='';
            }
            if ($back_image = $request->file('back_image')) {
                $name3 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('back_image')->getClientOriginalName();
                $ext = $request->file('back_image')->getClientOriginalExtension();
                $request->file('back_image')->storeAs('public/goods_vehicle', $name3);
                
                
            }else {
                $name3='';
            }
            if ($meter_image = $request->file('meter_image')) {
                $name4 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('meter_image')->getClientOriginalName();
                $ext = $request->file('meter_image')->getClientOriginalExtension();
                $request->file('meter_image')->storeAs('public/goods_vehicle', $name4);
                
                
            }else {
                $name4='';
            }
            if ($tyre_image = $request->file('tyre_image')) {
                $name5 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('tyre_image')->getClientOriginalName();
                $ext = $request->file('tyre_image')->getClientOriginalExtension();
                $request->file('tyre_image')->storeAs('public/goods_vehicle', $name5);
                
                
            }else {
                $name5='';
            }
            
            
            $insert = DB::table('goods_vehicle')->insertGetId(['category_id'=>$category_id,'user_id'=>$user_id,'set'=>$set,'type'=>$type,'brand_id'=>$brand_id,'model_id'=>$model_id,'year_of_purchase'=>$year_of_purchase,
            'rc_available'=>$rc_available,'noc_available'=>$noc_available,'registration_no'=>$registration_no,'description'=>$description,'left_image'=>$name,'right_image'=>$name1,
            'front_image'=>$name2,'back_image'=>$name3,'meter_image'=>$name4,'tyre_image'=>$name5,'price'=>$price,'rent_type'=>$rent_type,'is_negotiable'=>$is_negotiable,'pincode'=>$pincode,'country_id'=>$country_id,
            'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,'latlong'=>$latlong,'title'=>$title,
            'status'=>0,'created_at'=>date('Y-m-d H:i:s')]);

            if (isset(auth()->user()->id)) {
                $user_id = auth()->user()->id;
                $user_details = DB::table('user')->where(['id'=>$user_id])->first();
                $user_type = $user_details->user_type_id;
            } else {
                $user_details = DB::table('user')->where(['id'=>$user_id])->first();
                $user_type = $user_details->user_type_id;
            }

            $user_id = auth()->user()->id;
            $user_details = DB::table('user')->where(['id'=>$user_id])->first();
            $user_type = $user_details->user_type_id;

          
            if($user_type == 1){
                $type_id = 2;
                $update = DB::table('user')->where(['id'=>$user_id])->update(['user_type_id' =>$type_id]);
            }

            $user_details = DB::table('user')->where('id',$user_id)->first();
            if($user_details->user_post_count > 0){
                $user_post_count = $user_details->user_post_count;
                $total_user_post_count = $user_post_count + 1;

                $user_update  = DB::table('user')->where('id',$user_id)->update(['user_post_count'=>$total_user_post_count]);
            }else if($user_details->user_post_count == 0){
                $total_user_post_count =  1;
                $user_update  = DB::table('user')->where('id',$user_id)->update(['user_post_count'=>$total_user_post_count]);
            }
            
            if ($insert) {
                sms::post_pending($mobile,$category_id);
                                
                $output['response']=true;
                $output['message']='Data Added Successfully';
                $output['last_id']=$insert; //inserted goods_vehicle id
                $output['data'] = '';
                $output['error'] = "";
            } else {
               $output['response']=false;
                $output['message']='Something wend wrong';
                $output['data'] = '';
                $output['error'] = ""; 
            }
        }
        }
        return $output;
  }
    
    public function gv (Request $request) {
        $output=[];
        $data=[];
        $new=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $skip = $request->skip;
        $take = $request->take;
        
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
            //'category_id' => 'required',
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $user_data = DB::table('user')->where(['id'=>$user_id])->first();
            $state_id = $user_data->state_id;
            $district_id = $user_data->district_id;
            $city_id  = $user_data->city_id;
            $zipcode  = $user_data->zipcode;
            $latitude1  = $user_data->lat;
            $longitude1  = $user_data->long;
            
            $count = DB::table('goods_vehicle')->orderBy('id','desc')->where(['pincode'=>$zipcode,'status'=>1])->count();
            if ($count>0) {
            $same_pincode = DB::table('goods_vehicle')->orderBy('id','desc')->where(['pincode'=>$zipcode,'status'=>1])->get();
            foreach ($same_pincode as $val) {
                
                $data['id'] = $val->id;
                $data['category_id'] = $val->category_id;
                $data['user_id'] = $val->user_id;
                
                $user_details = DB::table('user')->where(['id'=>$val->user_id])->first();
                $data['user_type_id'] = $user_details->user_type_id;
                $data['role_id'] = $user_details->role_id;
                $data['name'] = $user_details->name;
                $data['company_name'] = $user_details->company_name;
                $data['mobile'] = $user_details->mobile;
                $data['email'] = $user_details->email;
                $data['gender'] = $user_details->gender;
                $data['address'] = $user_details->address;
                $data['zipcode'] = $user_details->zipcode;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/".$user_details->photo);
                }
                
                $data['set'] = $val->set;
                $data['type'] = $val->type;
                $data['brand_id'] = $val->brand_id;
                $data['model_id'] = $val->model_id;
                $data['title'] = $val->title;
                
                $brand_o_n = DB::table('brand')->where(['id'=>$val->brand_id])->value('name');
                if ($brand_o_n=='Others') {
                    //$brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                    $data['brand_name'] = $val->title;
                    //$model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                    $data['model_name'] = '';
                } else {
                $brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                $data['brand_name'] = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                $data['model_name'] = $model_arr_data->model_name;
                }
                
                $specification=[];
                $spec_count = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->count();
                if ($spec_count>0) {
                $specification_arr = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->get();
                foreach ($specification_arr as $val_s) {
                    $spec_name = $val_s->spec_name;
                    $spec_value = $val_s->value;
                    
                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                }
                $data['specification'] = $specification;
                } else {
                $data['specification'] = '';
                } 
                
                $data['year_of_purchase'] = $val->year_of_purchase;
                $data['rc_available'] = $val->rc_available;
                $data['noc_available'] = $val->noc_available;
                $data['registration_no'] = $val->registration_no;
                $data['description'] = $val->description;
                if ($val->left_image=='' || $val->left_image=='NULL') { 
                    $data['left_image'] = '';
                } else {
                    $data['left_image'] = asset("storage/goods_vehicle/$val->left_image"); 
                }
                if ($val->right_image=='' || $val->right_image=='NULL') { 
                    $data['right_image'] = '';
                } else {
                    $data['right_image'] = asset("storage/goods_vehicle/$val->right_image"); 
                }
                if ($val->front_image=='' || $val->front_image=='NULL') { 
                    $data['front_image'] = '';
                } else {
                    $data['front_image'] = asset("storage/goods_vehicle/$val->front_image"); 
                }
                if ($val->back_image=='' || $val->back_image=='NULL') { 
                    $data['back_image'] = '';
                } else {
                    $data['back_image'] = asset("storage/goods_vehicle/$val->back_image"); 
                }
                if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                    $data['meter_image'] = '';
                } else {
                    $data['meter_image'] = asset("storage/goods_vehicle/$val->meter_image"); 
                }
                if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                    $data['tyre_image'] = '';
                } else {
                    $data['tyre_image'] = asset("storage/goods_vehicle/$val->tyre_image"); 
                }
                $data['price'] = $val->price;
                $data['rent_type'] = $val->rent_type;
                $data['is_negotiable'] = $val->is_negotiable;
                $data['pincode'] = $val->pincode;
                $data['country_id'] = $val->country_id;
                $data['state_id'] = $val->state_id;
                $data['district_id'] = $val->district_id;
                $data['city_id'] = $val->city_id;
                
                if($val->state_id!='' || $val->state_id!=NULL) {
                $state_arr_data = DB::table('state')->where(['id'=>$val->state_id])->first();
                
                $data['state_name'] = $state_arr_data->state_name;
                }
                
                if($val->district_id!='' || $val->district_id!=NULL) {
                $state_arr_data = DB::table('district')->where(['id'=>$val->district_id])->first();
                
                $data['district_name'] = $state_arr_data->district_name;
                }
                
                if($val->city_id!='' || $val->city_id!=NULL) {
                $city_arr_data = DB::table('city')->where(['id'=>$val->city_id])->first();
                $data['city_name'] = $city_arr_data->city_name;
                }
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>3,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $new[] = $data;
            
            }
            }
            $arr = [];
            $same_district = DB::table('goods_vehicle')->orderBy('id','desc')->where(['district_id'=>$district_id,'status'=>1])->where('pincode','!=',$zipcode)->skip($skip)->take($take)->get();
            foreach ($same_district as $val) {
                
                $nearest_goods_vehicle_id = $val->id;
                $latlong = $val->latlong;
                $exp = explode(',',$latlong);
                $latitude2 = $exp[0];
                $longitude2 = $exp[1];
               
                $theta = $longitude1 - $longitude2;
                $distance = sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta));
            
                $distance = acos($distance); 
                $distance = rad2deg($distance); 
                $distance = $distance * 60 * 1.1515;
            
                $arr[$nearest_goods_vehicle_id] = (round($distance,2)); 
            }   
            asort($arr);
            foreach ($arr as $key=>$val12) {
            $same_district_nearest = DB::table('goods_vehicle')->where(['id'=>$key])->get();    
            foreach ($same_district_nearest as $val) {
                $data['id'] = $val->id;
                $data['category_id'] = $val->category_id;
                $data['user_id'] = $val->user_id;
                
                $user_details = DB::table('user')->where(['id'=>$val->user_id])->first();
                $data['user_type_id'] = $user_details->user_type_id;
                $data['role_id'] = $user_details->role_id;
                $data['name'] = $user_details->name;
                $data['company_name'] = $user_details->company_name;
                $data['mobile'] = $user_details->mobile;
                $data['email'] = $user_details->email;
                $data['gender'] = $user_details->gender;
                $data['address'] = $user_details->address;
                $data['zipcode'] = $user_details->zipcode;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/".$user_details->photo);
                }
                
                $data['set'] = $val->set;
                $data['type'] = $val->type;
                $data['brand_id'] = $val->brand_id;
                $data['model_id'] = $val->model_id;
                $data['title'] = $val->title;
                
                $brand_o_n = DB::table('brand')->where(['id'=>$val->brand_id])->value('name');
                if ($brand_o_n=='Others') {
                    //$brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                    $data['brand_name'] = $val->title;
                    //$model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                    $data['model_name'] = '';
                } else {
                $brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                $data['brand_name'] = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                $data['model_name'] = $model_arr_data->model_name;
                }
                
                $specification=[];
                $spec_count = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->count();
                if ($spec_count>0) {
                $specification_arr = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->get();
                foreach ($specification_arr as $val_s) {
                    $spec_name = $val_s->spec_name;
                    $spec_value = $val_s->value;
                    
                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                }
                $data['specification'] = $specification;
                } else {
                $data['specification'] = '';
                } 
                
                $data['year_of_purchase'] = $val->year_of_purchase;
                $data['rc_available'] = $val->rc_available;
                $data['noc_available'] = $val->noc_available;
                $data['registration_no'] = $val->registration_no;
                $data['description'] = $val->description;
                if ($val->left_image=='' || $val->left_image=='NULL') { 
                    $data['left_image'] = '';
                } else {
                    $data['left_image'] = asset("storage/goods_vehicle/$val->left_image"); 
                }
                if ($val->right_image=='' || $val->right_image=='NULL') { 
                    $data['right_image'] = '';
                } else {
                    $data['right_image'] = asset("storage/goods_vehicle/$val->right_image"); 
                }
                if ($val->front_image=='' || $val->front_image=='NULL') { 
                    $data['front_image'] = '';
                } else {
                    $data['front_image'] = asset("storage/goods_vehicle/$val->front_image"); 
                }
                if ($val->back_image=='' || $val->back_image=='NULL') { 
                    $data['back_image'] = '';
                } else {
                    $data['back_image'] = asset("storage/goods_vehicle/$val->back_image"); 
                }
                if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                    $data['meter_image'] = '';
                } else {
                    $data['meter_image'] = asset("storage/goods_vehicle/$val->meter_image"); 
                }
                if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                    $data['tyre_image'] = '';
                } else {
                    $data['tyre_image'] = asset("storage/goods_vehicle/$val->tyre_image"); 
                }
                $data['price'] = $val->price;
                $data['rent_type'] = $val->rent_type;
                $data['is_negotiable'] = $val->is_negotiable;
                $data['pincode'] = $val->pincode;
                $data['country_id'] = $val->country_id;
                $data['state_id'] = $val->state_id;
                $data['district_id'] = $val->district_id;
                $data['city_id'] = $val->city_id;
                
                if($val->state_id!='' || $val->state_id!=NULL) {
                $state_arr_data = DB::table('state')->where(['id'=>$val->state_id])->first();
                
                $data['state_name'] = $state_arr_data->state_name;
                }
                
                if($val->district_id!='' || $val->district_id!=NULL) {
                $state_arr_data = DB::table('district')->where(['id'=>$val->district_id])->first();
                
                $data['district_name'] = $state_arr_data->district_name;
                }
                
                if($val->city_id!='' || $val->city_id!=NULL) {
                $city_arr_data = DB::table('city')->where(['id'=>$val->city_id])->first();
                $data['city_name'] = $city_arr_data->city_name;
                }
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>3,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $new[] = $data;
            
            }
            }
           
            
            $output['response']=true;
            $output['message']='Data Get';
            $output['data'] = $new;
            $output['error'] = "";
            
        }
        return $output;
        
    }
    
    public function gv_other_district (Request $request) {
        $i=0;
        $output=[];
        $data=[];
        $new=[];
        $count_data = 0;
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $skip = $request->skip;
        $take = $request->take;
        
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
            //'category_id' => 'required',
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $user_data = DB::table('user')->where(['id'=>$user_id])->first();
            $state_id = $user_data->state_id;
            $district_id = $user_data->district_id;
            $city_id  = $user_data->city_id;
            $zipcode  = $user_data->zipcode;
            $latitude1  = $user_data->lat;
            $longitude1  = $user_data->long;
            
            
            $dist = DB::table('district')->where(['status'=>1])->where('id','!=',$district_id)->get();
            foreach ($dist as $val_dist) {
                $dist_id = $val_dist->id;
                $district_name = $val_dist->district_name;
                $state_id = $val_dist->state_id;
                $latitude2 = $val_dist->latitude;
                $longitude2 = $val_dist->longitude;
                
                $theta = $longitude1 - $longitude2;
                $distance = sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta));
            
                $distance = acos($distance); 
                $distance = rad2deg($distance); 
                $distance = $distance * 60 * 1.1515;
            
                $arr[$dist_id] = (round($distance,2));
            }
            asort($arr);
            //$nearest_id = array_search(min($arr),$arr);
           //print_r($arr);
           foreach ($arr as $key=>$val_distance) {
           $count_data += DB::table('goods_vehicle')->orderBy('id','desc')->where(['district_id'=>$key,'status'=>1])->count();
           if ($count_data<20) {
           $goods_vehicle_data = DB::table('goods_vehicle')->orderBy('id','desc')->where(['district_id'=>$key,'status'=>1])->skip($skip)->take($take)->get();
            foreach ($goods_vehicle_data as $val) {
                $i++;
                $data['id'] = $val->id;
                $data['category_id'] = $val->category_id;
                $data['user_id'] = $val->user_id;
                
                $user_details = DB::table('user')->where(['id'=>$val->user_id])->first();
                $data['user_type_id'] = $user_details->user_type_id;
                $data['role_id'] = $user_details->role_id;
                $data['name'] = $user_details->name;
                $data['company_name'] = $user_details->company_name;
                $data['mobile'] = $user_details->mobile;
                $data['email'] = $user_details->email;
                $data['gender'] = $user_details->gender;
                $data['address'] = $user_details->address;
                $data['zipcode'] = $user_details->zipcode;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/".$user_details->photo);
                }
                
                $data['set'] = $val->set;
                $data['type'] = $val->type;
                $data['brand_id'] = $val->brand_id;
                $data['model_id'] = $val->model_id;
                $data['title'] = $val->title;
                
                $brand_o_n = DB::table('brand')->where(['id'=>$val->brand_id])->value('name');
                if ($brand_o_n=='Others') {
                    //$brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                    $data['brand_name'] = $val->title;
                    //$model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                    $data['model_name'] = '';
                } else {
                $brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                $data['brand_name'] = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                $data['model_name'] = $model_arr_data->model_name;
                }
                
                $specification=[];
                $spec_count = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->count();
                if ($spec_count>0) {
                $specification_arr = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->get();
                foreach ($specification_arr as $val_s) {
                    $spec_name = $val_s->spec_name;
                    $spec_value = $val_s->value;
                    
                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                }
                $data['specification'] = $specification;
                } else {
                $data['specification'] = '';
                } 
                
                $data['year_of_purchase'] = $val->year_of_purchase;
                $data['rc_available'] = $val->rc_available;
                $data['noc_available'] = $val->noc_available;
                $data['registration_no'] = $val->registration_no;
                $data['description'] = $val->description;
                if ($val->left_image=='' || $val->left_image=='NULL') { 
                    $data['left_image'] = '';
                } else {
                    $data['left_image'] = asset("storage/goods_vehicle/".$val->left_image); 
                }
                if ($val->right_image=='' || $val->right_image=='NULL') { 
                    $data['right_image'] = '';
                } else {
                    $data['right_image'] = asset("storage/goods_vehicle/".$val->right_image); 
                }
                if ($val->front_image=='' || $val->front_image=='NULL') { 
                    $data['front_image'] = '';
                } else {
                    $data['front_image'] = asset("storage/goods_vehicle/".$val->front_image); 
                }
                if ($val->back_image=='' || $val->back_image=='NULL') { 
                    $data['back_image'] = '';
                } else {
                    $data['back_image'] = asset("storage/goods_vehicle/".$val->back_image); 
                }
                if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                    $data['meter_image'] = '';
                } else {
                    $data['meter_image'] = asset("storage/goods_vehicle/".$val->meter_image); 
                }
                if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                    $data['tyre_image'] = '';
                } else {
                    $data['tyre_image'] = asset("storage/goods_vehicle/".$val->tyre_image); 
                }
                $data['price'] = $val->price;
                $data['rent_type'] = $val->rent_type;
                $data['is_negotiable'] = $val->is_negotiable;
                $data['pincode'] = $val->pincode;
                $data['country_id'] = $val->country_id;
                $data['state_id'] = $val->state_id;
                $data['district_id'] = $val->district_id;
                $data['city_id'] = $val->city_id;
                
                if($val->state_id!='' || $val->state_id!=NULL) {
                $state_arr_data = DB::table('state')->where(['id'=>$val->state_id])->first();
                
                $data['state_name'] = $state_arr_data->state_name;
                }
                
                if($val->district_id!='' || $val->district_id!=NULL) {
                $state_arr_data = DB::table('district')->where(['id'=>$val->district_id])->first();
                
                $data['district_name'] = $state_arr_data->district_name;
                }
                
                if($val->city_id!='' || $val->city_id!=NULL) {
                $city_arr_data = DB::table('city')->where(['id'=>$val->city_id])->first();
                $data['city_name'] = $city_arr_data->city_name;
                }
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>3,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $new[] = $data;
            
            }
            
           }
            
           }
           
           if ($i==0) {
               $goods_vehicle_data = DB::table('goods_vehicle')->where(['status'=>1])->skip(0)->take(50)->get();
           
            foreach ($goods_vehicle_data as $val) {
                $data['id'] = $val->id;
                $data['category_id'] = $val->category_id;
                $data['user_id'] = $val->user_id;
                
                $user_details = DB::table('user')->where(['id'=>$val->user_id])->first();
                $data['user_type_id'] = $user_details->user_type_id;
                $data['role_id'] = $user_details->role_id;
                $data['name'] = $user_details->name;
                $data['company_name'] = $user_details->company_name;
                $data['mobile'] = $user_details->mobile;
                $data['email'] = $user_details->email;
                $data['gender'] = $user_details->gender;
                $data['address'] = $user_details->address;
                $data['zipcode'] = $user_details->zipcode;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/".$user_details->photo);
                }
                
                $data['set'] = $val->set;
                $data['type'] = $val->type;
                $data['brand_id'] = $val->brand_id;
                $data['model_id'] = $val->model_id;
                $data['title'] = $val->title;
                
                $brand_o_n = DB::table('brand')->where(['id'=>$val->brand_id])->value('name');
                if ($brand_o_n=='Others') {
                    //$brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                    $data['brand_name'] = $val->title;
                    //$model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                    $data['model_name'] = '';
                } else {
                $brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                $data['brand_name'] = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                $data['model_name'] = $model_arr_data->model_name;
                }
                
                $specification=[];
                $spec_count = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->count();
                if ($spec_count>0) {
                $specification_arr = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->get();
                foreach ($specification_arr as $val_s) {
                    $spec_name = $val_s->spec_name;
                    $spec_value = $val_s->value;
                    
                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                }
                $data['specification'] = $specification;
                } else {
                $data['specification'] = '';
                } 
                
                $data['year_of_purchase'] = $val->year_of_purchase;
                $data['rc_available'] = $val->rc_available;
                $data['noc_available'] = $val->noc_available;
                $data['registration_no'] = $val->registration_no;
                $data['description'] = $val->description;
                if ($val->left_image=='' || $val->left_image=='NULL') { 
                    $data['left_image'] = '';
                } else {
                    $data['left_image'] = asset("storage/goods_vehicle/".$val->left_image); 
                }
                if ($val->right_image=='' || $val->right_image=='NULL') { 
                    $data['right_image'] = '';
                } else {
                    $data['right_image'] = asset("storage/goods_vehicle/".$val->right_image); 
                }
                if ($val->front_image=='' || $val->front_image=='NULL') { 
                    $data['front_image'] = '';
                } else {
                    $data['front_image'] = asset("storage/goods_vehicle/".$val->front_image); 
                }
                if ($val->back_image=='' || $val->back_image=='NULL') { 
                    $data['back_image'] = '';
                } else {
                    $data['back_image'] = asset("storage/goods_vehicle/".$val->back_image); 
                }
                if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                    $data['meter_image'] = '';
                } else {
                    $data['meter_image'] = asset("storage/goods_vehicle/".$val->meter_image); 
                }
                if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                    $data['tyre_image'] = '';
                } else {
                    $data['tyre_image'] = asset("storage/goods_vehicle/".$val->tyre_image); 
                }
                $data['price'] = $val->price;
                $data['rent_type'] = $val->rent_type;
                $data['is_negotiable'] = $val->is_negotiable;
                $data['pincode'] = $val->pincode;
                $data['country_id'] = $val->country_id;
                $data['state_id'] = $val->state_id;
                $data['district_id'] = $val->district_id;
                $data['city_id'] = $val->city_id;
                
                if($val->state_id!='' || $val->state_id!=NULL) {
                $state_arr_data = DB::table('state')->where(['id'=>$val->state_id])->first();
                
                $data['state_name'] = $state_arr_data->state_name;
                }
                
                if($val->district_id!='' || $val->district_id!=NULL) {
                $state_arr_data = DB::table('district')->where(['id'=>$val->district_id])->first();
                
                $data['district_name'] = $state_arr_data->district_name;
                }
                
                if($val->city_id!='' || $val->city_id!=NULL) {
                $city_arr_data = DB::table('city')->where(['id'=>$val->city_id])->first();
                $data['city_name'] = $city_arr_data->city_name;
                }
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>3,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $new[] = $data;
            
            }
           }
           
           
            $output['response']=true;
            $output['message']='Data Get';
            $output['data'] = $new;
            $output['error'] = "";
            
        }
        return $output;
        
    }
    
    public function gv_by_id (Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $id = $request->last_id;
        
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
            //'category_id' => 'required',
            'user_id' => 'required',
            'user_token' => 'required',
            'last_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('goods_vehicle')->where(['id'=>$id])->count();
            if ($count>0) {
            
            $val = DB::table('goods_vehicle')->where(['id'=>$id])->first();
            
                $data['id'] = $val->id;
                $data['category_id'] = $val->category_id;
                $data['user_id'] = $val->user_id;
                
                $user_details = DB::table('user')->where(['id'=>$val->user_id])->first();
                $data['user_type_id'] = $user_details->user_type_id;
                $data['role_id'] = $user_details->role_id;
                $data['name'] = $user_details->name;
                $data['company_name'] = $user_details->company_name;
                $data['mobile'] = $user_details->mobile;
                $data['email'] = $user_details->email;
                $data['gender'] = $user_details->gender;
                $data['address'] = $user_details->address;
                $data['zipcode'] = $user_details->zipcode;
                $data['created_at_user'] = $user_details->created_at;
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/".$user_details->photo);
                }
                
                $data['set'] = $val->set;
                $data['type'] = $val->type;
                $data['brand_id'] = $val->brand_id;
                $data['model_id'] = $val->model_id;
                $data['title'] = $val->title;
                
                $spec_count = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->count();
                if ($spec_count>0) {
                $specification_arr = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->get();
                foreach ($specification_arr as $val_s) {
                    $spec_name = $val_s->spec_name;
                    $spec_value = $val_s->value;
                    
                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                }
                $data['specification'] = $specification;
                } else {
                $data['specification'] = '';
                } 
                
                $brand_o_n = DB::table('brand')->where(['id'=>$val->brand_id])->value('name');
                if ($brand_o_n=='Others') {
                    //$brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                    $data['brand_name'] = $val->title;
                    //$model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                    $data['model_name'] = '';
                } else {
                $brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                $data['brand_name'] = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                $data['model_name'] = $model_arr_data->model_name;
                }
                
                
                $data['year_of_purchase'] = $val->year_of_purchase;
                $data['rc_available'] = $val->rc_available;
                $data['noc_available'] = $val->noc_available;
                $data['registration_no'] = $val->registration_no;
                $data['description'] = $val->description;
                if ($val->left_image=='' || $val->left_image=='NULL') { 
                    $data['left_image'] = '';
                } else {
                    $data['left_image'] = asset("storage/goods_vehicle/".$val->left_image); 
                }
                if ($val->right_image=='' || $val->right_image=='NULL') { 
                    $data['right_image'] = '';
                } else {
                    $data['right_image'] = asset("storage/goods_vehicle/".$val->right_image); 
                }
                if ($val->front_image=='' || $val->front_image=='NULL') { 
                    $data['front_image'] = '';
                } else {
                    $data['front_image'] = asset("storage/goods_vehicle/".$val->front_image); 
                }
                if ($val->back_image=='' || $val->back_image=='NULL') { 
                    $data['back_image'] = '';
                } else {
                    $data['back_image'] = asset("storage/goods_vehicle/".$val->back_image); 
                }
                if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                    $data['meter_image'] = '';
                } else {
                    $data['meter_image'] = asset("storage/goods_vehicle/".$val->meter_image); 
                }
                if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                    $data['tyre_image'] = '';
                } else {
                    $data['tyre_image'] = asset("storage/goods_vehicle/".$val->tyre_image); 
                }
                $data['price'] = $val->price;
                $data['rent_type'] = $val->rent_type;
                $data['is_negotiable'] = $val->is_negotiable;
                $data['pincode'] = $val->pincode;
                $data['country_id'] = $val->country_id;
                $data['state_id'] = $val->state_id;
                $data['district_id'] = $val->district_id;
                $data['city_id'] = $val->city_id;
                
                if($val->state_id!='' || $val->state_id!=NULL) {
                $state_arr_data = DB::table('state')->where(['id'=>$val->state_id])->first();
                
                $data['state_name'] = $state_arr_data->state_name;
                }
                
                if($val->district_id!='' || $val->district_id!=NULL) {
                $state_arr_data = DB::table('district')->where(['id'=>$val->district_id])->first();
                
                $data['district_name'] = $state_arr_data->district_name;
                }
                
                if($val->city_id!='' || $val->city_id!=NULL) {
                $city_arr_data = DB::table('city')->where(['id'=>$val->city_id])->first();
                $data['city_name'] = $city_arr_data->city_name;
                }
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>3,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = $val->created_at;
                $data['updated_at'] = $val->updated_at;
                
                $new[] = $data;
            
            $output['response']=true;
            $output['message']='Data Get';
            $output['data'] = $new;
            $output['error'] = "";
            
            } else {
                $output['response']=false;
                $output['message']='No goods_vehicle Found';
                $output['data'] = '';
                $output['error'] = ""; 
            }
            
        }
        return $output;
    }
    
    public function gv_data (Request $request) {
        //for dashboard new,used,rent data and this run also on view details page.
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $type = $request->type; //new , used, rent
        $skip = $request->skip;
        $take = $request->take;
        $pincode = $request->pincode;
        $app_section = $request->app_section;
        
        $count = DB::table('city')->where(['pincode'=>$pincode])->count();
        if ($count>0) {
        $pindata = DB::table('city')->where(['pincode'=>$pincode])->first();
        $city_id = $pindata->id;
        $city_name = $pindata->city_name;
        
        $country = $pindata->country_id;
        $c = DB::table('country')->where(['id'=>$country])->first();
        $country_name = $c->country_name;
        
        $state = $pindata->state_id;
        $s = DB::table('state')->where(['id'=>$state])->first();
        $state_name = $s->state_name;
        
        $district = $pindata->district_id;
        $d = DB::table('district')->where(['id'=>$district])->first();
        $district_name = $d->district_name;
        
        $latitude = $pindata->latitude;
        $longitude = $pindata->longitude;
        
        }
        
        
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
            //'category_id' => 'required',
            'user_id' => 'required',
            'user_token' => 'required',
            'type'=> 'required',
            'pincode'=>'required|digits:6',
            'skip'=>'required|integer',
            'take'=>'required|integer',
            'app_section'=>'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = $validator->messages();
        } else {
         
        if ($type=='rent') {
            $new = Goods_vehicle::gv_data_rent($user_id,$type,$pincode,$district,$state,$app_section,$skip,$take);
        } else {
            $new = Goods_vehicle::gv_data($user_id,$type,$pincode,$district,$state,$app_section,$skip,$take);
        }
            $output['response']=true;
            $output['message']='Good Vahicle Data';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         }
          return $output;  
        
    }
    
    public function gv_update (Request $request) {
        $output=[];
        $data=[];
        $user_id = auth()->user()->id;
        $item_id = $request->id;
        
        
        $Autn = DB::table('user')->where('id', $user_id)->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $userAuth = DB::table('goods_vehicle')->where(['user_id'=>$user_id,'id'=>$item_id])->count();
        if ($userAuth==0) {
            $output['response']=false;
            $output['message']='User not match';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = $validator->messages();
        } else {
            
            
            $gv_data = DB::table('goods_vehicle')->where(['id'=>$item_id])->first();
            $gv_id = $gv_data->id;
            $gv_userid = $gv_data->user_id;
            
            if ($left_image = $request->file('left_image')) {
                $left_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('left_image')->getClientOriginalName();
                $ext = $request->file('left_image')->getClientOriginalExtension();
                $request->file('left_image')->storeAs('public/goods_vehicle', $left_image);
            }else {
                $left_image=$gv_data->left_image;
            }
            
            if ($right_image = $request->file('right_image')) {
                $right_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('right_image')->getClientOriginalName();
                $ext = $request->file('right_image')->getClientOriginalExtension();
                $request->file('right_image')->storeAs('public/goods_vehicle', $right_image);
            }else {
                $right_image=$gv_data->right_image;
            }
            
            if ($front_image = $request->file('front_image')) {
                $front_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('front_image')->getClientOriginalName();
                $ext = $request->file('front_image')->getClientOriginalExtension();
                $request->file('front_image')->storeAs('public/goods_vehicle', $front_image);
            }else {
                $front_image=$gv_data->front_image;
            }
            
            if ($back_image = $request->file('back_image')) {
                $back_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('back_image')->getClientOriginalName();
                $ext = $request->file('back_image')->getClientOriginalExtension();
                $request->file('back_image')->storeAs('public/goods_vehicle', $back_image);
            }else {
                $back_image=$gv_data->back_image;
            }
            
            if ($meter_image = $request->file('meter_image')) {
                $meter_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('meter_image')->getClientOriginalName();
                $ext = $request->file('meter_image')->getClientOriginalExtension();
                $request->file('meter_image')->storeAs('public/goods_vehicle', $meter_image);
            }else {
                $meter_image=$gv_data->meter_image;
            }
            
            if ($tyre_image = $request->file('tyre_image')) {
                $tyre_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('tyre_image')->getClientOriginalName();
                $ext = $request->file('tyre_image')->getClientOriginalExtension();
                $request->file('tyre_image')->storeAs('public/goods_vehicle', $tyre_image);
            }else {
                $tyre_image=$gv_data->tyre_image;
            }

            $set = $request->set ? $request->set : $gv_data->set;
            $type = $request->type ? $request->type : $gv_data->type;
            $price = $request->price ? $request->price : $gv_data->price;
            $rent_type = $request->rent_type ? $request->rent_type : $gv_data->rent_type;
            //$rc_available = $request->rc_available;
            //$is_negotiable = $request->is_negotiable;
            $rc_available = ($request->rc_available == "0") ? 0 : (($request->rc_available == "1") ? 1 : $gv_data->rc_available);
            $is_negotiable = ($request->is_negotiable == "0") ? 0 : (($request->is_negotiable == "1") ? 1 : $gv_data->is_negotiable);
            $year_of_purchase = $request->year_of_purchase ? $request->year_of_purchase : $gv_data->year_of_purchase;
            $description = $request->description ? $request->description : $gv_data->description;

            $updateData = [
                'set'=>$set,
                'type'=>$type,
                'year_of_purchase'=>$year_of_purchase,
                'rc_available'=>$rc_available,
                'description'=>$description,
                'left_image'=>$left_image,
                'right_image'=>$right_image,
                'front_image'=>$front_image,
                'back_image'=>$back_image,
                'meter_image'=>$meter_image,
                'tyre_image'=>$tyre_image,
                'rent_type'=>$rent_type,
                'price'=>$price,
                'is_negotiable'=>$is_negotiable,
                'status'=>0,
                'updated_at'=>date('Y-m-d H:i:s')
            ];
            
            $update = DB::table('goods_vehicle')->where('id',$item_id)->update($updateData);
            if ($update===true || $update==1) {

                if (isset(auth()->user()->id)) {
                    $user_id = auth()->user()->id;
                }
                
                $mobile = DB::table('user')->where('id',$user_id)->value('mobile');
                sms::post_pending($mobile,3);

                $output['response']=true;
                $output['last_id']=$gv_id; //inserted gv id
                $output['message']='Data Updated Successfully';
                $output['data'] = '';
                $output['error'] = "";
            } else {
               $output['response']=false;
                $output['message']='Something went wrong';
                $output['data'] = '';
                $output['error'] = ""; 
            }
            
        
            
            
        }
        return $output;
    }

    /** Good Vehicle View All */
    public function goodVehicleDistance1(Request $request){
        $output = [];
        $data   = [];
        $new    = [];

        $user_id     = $request->user_id;
        $user_token  = $request->user_token;
        $type        = $request->type; //new , used, rent
        $skip        = $request->skip;
        $take        = $request->take;
        $pincode     = $request->pincode;
        $app_section = $request->app_section;

        $pindata     = DB::table('city')->where(['pincode'=>$request->pincode])->first();
        $latitude    = $pindata->latitude;
        $longitude   = $pindata->longitude;

        // $Autn = DB::table('user')->where(['id'=>$user_id])->count();
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        else if($type == 'rent'){

            $sql = DB::table('goodVehicleView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(goodVehicleView.latitude))
                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(goodVehicleView.latitude))) AS distance"))
                ->orderBy('distance', 'ASC')
                ->where('set','rent')
                ->whereIn('status',[1,4])
                ->limit($take)
                ->offset($skip)
                ->get();
        }
        else if($type == 'old'){

            $sql = DB::table('goodVehicleView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(goodVehicleView.latitude))
                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(goodVehicleView.latitude))) AS distance"))
                ->orderBy('distance', 'ASC')
                ->whereIn('status',[1,4])
                ->where('set','sell')
                ->where('type','old')
                ->limit($take)
                ->offset($skip)
                ->get();
        }
        else if($type == 'new'){ 
            $sql = DB::table('goodVehicleView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(goodVehicleView.latitude))
                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(goodVehicleView.latitude))) AS distance"))
                ->orderBy('distance', 'ASC')
                ->whereIn('status',[1,4])
                ->where('set','sell')
                ->where('type','new')
                ->limit($take)
                ->offset($skip)
                ->get();
        }

        foreach($sql as $val){
            if($val->distance == null){
                $data['distance'] = 0;
            }else{
                $data['distance']    = round($val->distance);
            }
           
            $data['id']          = $val->id;
            $data['category_id'] = $val->category_id;
            $data['user_id']     = $val->user_id;
            
            $user_count = DB::table('user')->where('id',$val->user_id)->count();
            if($user_count > 0){
                $user_details = DB::table('user')->where('id',$val->user_id)->first();
                $data['user_type_id']      = $user_details->user_type_id;
                $data['role_id']           = $user_details->role_id;
                $data['name']              = $user_details->name;
                $data['company_name']      = $user_details->company_name;
                $data['mobile']            = $user_details->mobile;
                $data['email']             = $user_details->email;
                $data['gender']            = $user_details->gender;
                $data['address']           = $user_details->address;
                $data['zipcode']           = $user_details->zipcode;
                $data['device_id']         = $user_details->device_id;
                $data['firebase_token']    = $user_details->firebase_token;
                $data['created_at_user']   = date("d-m-Y", strtotime($user_details->created_at));

                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/".$user_details->photo);
                }
            }
            

            $data['set']        = $val->set;
            $data['type']       = $val->type;
            $data['brand_id']   = $val->brand_id;
            $data['model_id']   = $val->model_id;
            $data['title']      = $val->title;
            $data['brand_name'] = $val->brand_name;
            $data['model_name'] = $val->model_name;

            $specification=[];

            $spec_count = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->count();
            if ($spec_count>0) {
                $specification_arr = DB::table('specifications')
                    ->join('goodVehicleView', 'specifications.model_id', '=', 'goodVehicleView.model_id')
                    ->where('specifications.model_id', $val->model_id)
                    ->where('specifications.status', 1)
                    ->select('specifications.*', 'goodVehicleView.model_id')
                    ->get();

                foreach ($specification_arr as $val_s) {
                    $spec_name  = $val_s->spec_name;
                    $spec_value = $val_s->value;
                    
                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                }
                $data['specification'] = $specification;
            }
            else {
                $data['specification'] = '';
            } 

            $data['year_of_purchase'] = $val->year_of_purchase;
            $data['rc_available']     = $val->rc_available;
            $data['noc_available']    = $val->noc_available;
            $data['registration_no']  = $val->registration_no;
            $data['description']      = $val->description;

            if ($val->left_image=='' || $val->left_image=='NULL') { 
                $data['left_image'] = '';
            } else {
                $data['left_image'] = asset("storage/goods_vehicle/".$val->left_image); 
            }
            if ($val->right_image=='' || $val->right_image=='NULL') { 
                $data['right_image'] = '';
            } else {
                $data['right_image'] = asset("storage/goods_vehicle/".$val->right_image); 
            }
            if ($val->front_image=='' || $val->front_image=='NULL') { 
                $data['front_image'] = '';
            } else {
                $data['front_image'] = asset("storage/goods_vehicle/".$val->front_image); 
            }
            if ($val->back_image=='' || $val->back_image=='NULL') { 
                $data['back_image'] = '';
            } else {
                $data['back_image'] = asset("storage/goods_vehicle/".$val->back_image); 
            }
            if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                $data['meter_image'] = '';
            } else {
                $data['meter_image'] = asset("storage/goods_vehicle/".$val->meter_image); 
            }
            if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                $data['tyre_image'] = '';
            } else {
                $data['tyre_image'] = asset("storage/goods_vehicle/".$val->tyre_image); 
            }
            $data['price']         = $val->price;
            $data['rent_type']     = $val->rent_type;
            $data['is_negotiable'] = $val->is_negotiable;
            $data['pincode']       = $val->pincode;
            $data['country_id']    = $val->country_id;
            $data['state_id']      = $val->state_id;
            $data['district_id']   = $val->district_id;
            $data['city_id']       = $val->city_id;

            $data['state_name']    = $val->state_name;
            $data['district_name'] = $val->district_name;
            $data['city_name']     = $val->city_name;

            $wishlist_status = DB::select("SELECT COUNT(*) as count FROM wishlist
                            WHERE user_id = :user_id
                            AND category_id = 3
                            AND item_id = :item_id", ['user_id' => $user_id, 'item_id' => $val->id]);

            $data['wishlist_status'] = $wishlist_status[0]->count;
            // $data['latlong']         = $val->latlong;
            $data['ad_report']       = $val->ad_report;
            $data['status']          = $val->status;
            $data['created_at']      = date("d-m-Y", strtotime($val->created_at));
            $data['updated_at']      = $val->updated_at;

            $view_lead         = DB::select("SELECT COUNT(*) as count FROM leads_views WHERE category_id = 3 AND post_id = :post_id", ['post_id' => $val->id]);
            $data['view_lead'] = $view_lead[0]->count;

            $call_lead          = DB::select("SELECT COUNT(*) as count FROM seller_leads WHERE category_id = 3 AND post_id = :post_id AND calls_status = 1 ", ['post_id' => $val->id]);
            $data['call_lead']  = $call_lead[0]->count;

            $msg_lead          = DB::select("SELECT COUNT(*) as count FROM seller_leads WHERE category_id = 3 AND post_id = :post_id AND messages_status = 1 ",  ['post_id' => $val->id]);
            $data['msg_lead']  = $msg_lead[0]->count;

            $new[] = $data;

            $output['response']       = true;
            $output['message']        = 'Good-Vehicle Data';
            $output['data']           = $new;
            $output['error']          = "";
        }

        if(!empty($data)){
            return $output;
        }else {
            return ['message' => 'No Data Available','data' =>[]];
        } 
    }

    public function goodVehicleDistance(Request $request){
        $output = [];
        $data   = [];
        $new    = [];

        $user_id     = $request->user_id;
        $user_token  = $request->user_token;
        $type        = $request->type; //new , used, rent
        $skip        = $request->skip;
        $take        = $request->take;
        $pincode     = $request->pincode;
        $app_section = $request->app_section;

        $pindata     = DB::table('city')->where(['pincode'=>$request->pincode])->first();
        $latitude    = $pindata->latitude;
        $longitude   = $pindata->longitude;

        // $Autn = DB::table('user')->where(['id'=>$user_id])->count();
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }

        if (Cache::has('gv_viewall-'.$type.'-'.$user_id.'-'.$skip.'-'.$take)) {
            $new = Cache::get('gv_viewall-'.$type.'-'.$user_id.'-'.$skip.'-'.$take);
            return [
                'response' => true,
                'message' => 'GV Data',
                'data' => $new,
                'data_on' => 'Cache',
                'status_code'=>200,
                'error' => '',
            ];

        } else {

        if($type == 'rent'){

            $sql = DB::table('goodVehicleView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(goodVehicleView.latitude))
                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(goodVehicleView.latitude))) AS distance"))
                ->orderBy('distance', 'ASC')
                ->where('set','rent')
                ->whereIn('status',[1,4])
                ->limit($take)
                ->offset($skip)
                ->get();
        }
        else if($type == 'old'){

            $sql = DB::table('goodVehicleView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(goodVehicleView.latitude))
                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(goodVehicleView.latitude))) AS distance"))
                ->orderBy('distance', 'ASC')
                ->whereIn('status',[1,4])
                ->where('set','sell')
                ->where('type','old')
                ->limit($take)
                ->offset($skip)
                ->get();
        }
        else if($type == 'new'){ 
            $sql = DB::table('goodVehicleView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(goodVehicleView.latitude))
                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(goodVehicleView.latitude))) AS distance"))
                ->orderBy('distance', 'ASC')
                ->whereIn('status',[1,4])
                ->where('set','sell')
                ->where('type','new')
                ->limit($take)
                ->offset($skip)
                ->get();
        }

        foreach($sql as $val){
            if($val->distance == null){
                $data['distance'] = 0;
            }else{
                $data['distance']    = round($val->distance);
            }

            $boosted = Subscribed_boost::view_all_boosted_products(3,$val->id);
            if($boosted == 0){
                $data['is_boosted']  = false;
            }else if($boosted == 1){
                $data['is_boosted']  = true;
            }
           
            $data['id']          = $val->id;
            $data['category_id'] = $val->category_id;
            $data['user_id']     = $val->user_id;
            
            $user_count = DB::table('user')->where('id',$val->user_id)->count();
            if($user_count > 0){
                $user_details = DB::table('user')->where('id',$val->user_id)->first();
                $data['user_type_id']      = $user_details->user_type_id;
                $data['role_id']           = $user_details->role_id;
                $data['name']              = $user_details->name;
                $data['company_name']      = $user_details->company_name;
                $data['mobile']            = $user_details->mobile;
                $data['email']             = $user_details->email;
                $data['gender']            = $user_details->gender;
                $data['address']           = $user_details->address;
                $data['zipcode']           = $user_details->zipcode;
                $data['device_id']         = $user_details->device_id;
                $data['firebase_token']    = $user_details->firebase_token;
                $data['created_at_user']   = date("d-m-Y", strtotime($user_details->created_at));

                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/".$user_details->photo);
                }
            }
            
            $data['set']        = $val->set;
            $data['type']       = $val->type;
            $data['brand_id']   = $val->brand_id;
            $data['model_id']   = $val->model_id;
            $data['title']      = $val->title;
            $data['brand_name'] = $val->brand_name;
            $data['model_name'] = $val->model_name;

            $specification=[];

            $data['specification']=[];
            $spec_count = DB::table('specifications')->where(['model_id'=>$val->model_id,'status'=>1])->count();
            if ($spec_count>0) {

                    $specification = DB::table('specifications')
                    ->select('spec_name as spec_name','value as spec_value')
                    ->where(['model_id'=>$val->model_id,'status'=>1])->get();
                   
                $data['specification'] = $specification;
            }
            else {
                $data['specification'] = '';
            } 

            $data['year_of_purchase'] = $val->year_of_purchase;
            $data['rc_available']     = $val->rc_available;
            $data['noc_available']    = $val->noc_available;
            $data['registration_no']  = $val->registration_no;
            $data['description']      = $val->description;

            if ($val->left_image=='' || $val->left_image=='NULL') { 
                $data['left_image'] = '';
            } else {
                $data['left_image'] = asset("storage/goods_vehicle/$val->left_image"); 
            }
            if ($val->right_image=='' || $val->right_image=='NULL') { 
                $data['right_image'] = '';
            } else {
                $data['right_image'] = asset("storage/goods_vehicle/$val->right_image"); 
            }
            if ($val->front_image=='' || $val->front_image=='NULL') { 
                $data['front_image'] = '';
            } else {
                $data['front_image'] = asset("storage/goods_vehicle/$val->front_image"); 
            }
            if ($val->back_image=='' || $val->back_image=='NULL') { 
                $data['back_image'] = '';
            } else {
                $data['back_image'] = asset("storage/goods_vehicle/$val->back_image"); 
            }
            if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                $data['meter_image'] = '';
            } else {
                $data['meter_image'] = asset("storage/goods_vehicle/$val->meter_image"); 
            }
            if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                $data['tyre_image'] = '';
            } else {
                $data['tyre_image'] = asset("storage/goods_vehicle/$val->tyre_image"); 
            }
            $data['price']         = $val->price;
            $data['rent_type']     = $val->rent_type;
            $data['is_negotiable'] = $val->is_negotiable;
            $data['pincode']       = $val->pincode;
            $data['country_id']    = $val->country_id;
            $data['state_id']      = $val->state_id;
            $data['district_id']   = $val->district_id;
            $data['city_id']       = $val->city_id;

            $data['state_name']    = $val->state_name;
            $data['district_name'] = $val->district_name;
            $data['city_name']     = $val->city_name;

            $wishlist_status = DB::select("SELECT COUNT(*) as count FROM wishlist
                            WHERE user_id = :user_id
                            AND category_id = 3
                            AND item_id = :item_id", ['user_id' => $user_id, 'item_id' => $val->id]);

            $data['wishlist_status'] = $wishlist_status[0]->count;
            // $data['latlong']         = $val->latlong;
            $data['ad_report']       = $val->ad_report;
            $data['status']          = $val->status;
            // $data['created_at']      = date("d-m-Y", strtotime($val->created_at));
            $data['created_at']      = $val->created_at;
            $data['updated_at']      = $val->updated_at;

            $view_lead         = DB::select("SELECT COUNT(*) as count FROM leads_views WHERE category_id = 3 AND post_id = :post_id", ['post_id' => $val->id]);
            $data['view_lead'] = $view_lead[0]->count;

            $call_lead          = DB::select("SELECT COUNT(*) as count FROM seller_leads WHERE category_id = 3 AND post_id = :post_id AND calls_status = 1 ", ['post_id' => $val->id]);
            $data['call_lead']  = $call_lead[0]->count;

            $msg_lead          = DB::select("SELECT COUNT(*) as count FROM seller_leads WHERE category_id = 3 AND post_id = :post_id AND messages_status = 1 ",  ['post_id' => $val->id]);
            $data['msg_lead']  = $msg_lead[0]->count;

            $new[] = $data;

        }

        Cache::put('gv_viewall-'.$type.'-'.$user_id.'-'.$skip.'-'.$take, $new, 86400);
        return [
            'response' => true,
            'message' => 'GV Data',
            'data' => $new,
            'data_on' => 'Database',
            'status_code'=>200,
            'error' => '',
        ];
        }

    }

}
