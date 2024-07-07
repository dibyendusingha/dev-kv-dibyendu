<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\LaraEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Tyre;

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

class TyreController extends Controller
{
    //
    public function tyre_add (Request $request) {
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
        $type = $request->type;
        $brand_id = $request->brand_id;
        $model_id = $request->model_id;
        $title = $request->title;
        $position = $request->position;
        $price = $request->price;
        $description = $request->description;
        $is_negotiable = $request->is_negotiable;
        $image1 = $request->image1;
        $image2 = $request->image2;
        $image3 = $request->image3;
        
        
        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $district_id = $request->district_id;
        $city_id = $request->city_id;
        $pincode = $request->pincode;
        $latlong = $request->latlong;
        
        
        $Autn = DB::table('user')->where('id', $user_id)->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }else {
            $mobile = DB::table('user')->where('id', $user_id)->value('mobile');
        }
        
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'type' => 'required',
            'brand_id' => 'required|integer',
            'model_id' => 'required|integer',
            'price' => 'required|integer',
            //'is_negotiable' => 'required',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'district_id' => 'required|integer',
            'pincode' => 'required|digits:6',
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = $validator->messages();
        } else {
            
            if ($image1 = $request->file('image1')) {
                $name = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1')->getClientOriginalName();
                $ext = $request->file('image1')->getClientOriginalExtension();
                $request->file('image1')->storeAs('public/tyre', $name);
                
            }else {
                $name='';
            }
            if ($image2 = $request->file('image2')) {
                $name1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2')->getClientOriginalName();
                $ext = $request->file('image2')->getClientOriginalExtension();
                $request->file('image2')->storeAs('public/tyre', $name1);
                
            }else {
                $name1='';
            }
            if ($image3 = $request->file('image3')) {
                $name2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3')->getClientOriginalName();
                $ext = $request->file('image3')->getClientOriginalExtension();
                $request->file('image3')->storeAs('public/tyre', $name2);
                
            }else {
                $name2='';
            }
            
            $insert = DB::table('tyres')->insertGetId(['category_id'=>$category_id,'user_id'=>$user_id,'type'=>$type,'brand_id'=>$brand_id,'model_id'=>$model_id,
            'position'=>$position,'price'=>$price,'is_negotiable'=>$is_negotiable,'title'=>$title,
            'description'=>$description,'image1'=>$name,'image2'=>$name1,'image3'=>$name2,
            'country_id'=>$country_id,'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,'pincode'=>$pincode,'latlong'=>$latlong,'status'=>0,'created_at'=>date('Y-m-d H:i:s')]);

            if(isset(auth()->user()->id)) {
                $user_id = auth()->user()->id;
                $user_details = DB::table('user')->where(['id'=>$user_id])->first();
                $user_type = $user_details->user_type_id;
            }else {
                $user_details = DB::table('user')->where(['id'=>$user_id])->first();
                $user_type = $user_details->user_type_id;
            }

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

            if ($insert>0) {
                sms::post_pending($mobile,$category_id);
                                
                $output['response']=true;
                $output['last_id']=$insert;
                $output['message']='Data Added Successfully';
                $output['data'] = '';
                $output['error'] = "";
            } else {
               $output['response']=true;
                $output['message']='Something wend wrong';
                $output['data'] = '';
                $output['error'] = ""; 
            }
        }
    }
    return $output;
    }
    
    public function tyre (Request $request) {
        $output=[];
        $data=[];
        $new = [];
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
            
            $count = DB::table('tyres')->orderBy('id','desc')->where(['pincode'=>$zipcode,'status'=>1])->count();
            if ($count>0) {
            $same_pincode = DB::table('tyres')->orderBy('id','desc')->where(['pincode'=>$zipcode,'status'=>1])->get();
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
                $data['photo'] = asset("storage/photo/$user_details->photo");
                }
                
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
                
                $data['position'] = $val->position;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/tyre/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/tyre/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/tyre/$val->image3"); 
                }
                
                $data['is_negotiable'] = $val->is_negotiable;
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>7,'item_id'=>$val->id])->count();
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $new[] = $data;
                
            }
            }
            $arr = [];
            $same_district = DB::table('tyres')->orderBy('id','desc')->where(['district_id'=>$district_id,'status'=>1])->where('pincode','!=',$zipcode)->skip($skip)->take($take)->get();
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
            $same_district_nearest = DB::table('tyres')->where(['id'=>$key])->get();    
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
                $data['photo'] = asset("storage/photo/$user_details->photo");
                }
                
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
                
                $data['position'] = $val->position;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/tyre/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/tyre/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/tyre/$val->image3"); 
                }
                
                $data['is_negotiable'] = $val->is_negotiable;
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>7,'item_id'=>$val->id])->count();
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
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
    
    public function tyre_other_district (Request $request) {
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
           $count_data += DB::table('tyres')->orderBy('id','desc')->where(['district_id'=>$key,'status'=>1])->count();
           if ($count_data<20) {
           $seeds_data = DB::table('tyres')->orderBy('id','desc')->where(['district_id'=>$key,'status'=>1])->skip($skip)->take($take)->get();
            foreach ($seeds_data as $val) {
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
                $data['photo'] = asset("storage/photo/$user_details->photo");
                }
                
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
                
                $data['position'] = $val->position;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/tyre/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/tyre/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/tyre/$val->image3"); 
                }
                
                $data['is_negotiable'] = $val->is_negotiable;
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>7,'item_id'=>$val->id])->count();
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $new[] = $data;
                
            }
            
           }
            
           }
           if ($i==0) {
               $seeds_data = DB::table('tyres')->orderBy('id','desc')->where(['district_id'=>$key,'status'=>1])->skip($skip)->take($take)->get();
            foreach ($seeds_data as $val) {
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
                $data['photo'] = asset("storage/photo/$user_details->photo");
                }
                
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
                
                $data['position'] = $val->position;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/tyre/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/tyre/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/tyre/$val->image3"); 
                }
                
                $data['is_negotiable'] = $val->is_negotiable;
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>7,'item_id'=>$val->id])->count();
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
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
    
    public function tyre_by_id (Request $request) {
        $output=[];
        $data=[];
        $new=[];
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
            $count = DB::table('tyres')->where(['id'=>$id])->count();
            if ($count>0) {
            
            $val = DB::table('tyres')->where(['id'=>$id])->first();
            
                
                
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
                $data['photo'] = asset("storage/photo/$user_details->photo");
                }
                
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
                
                
                $data['position'] = $val->position;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/tyre/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/tyre/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/tyre/$val->image3"); 
                }
                
                $data['is_negotiable'] = $val->is_negotiable;
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>7,'item_id'=>$val->id])->count();
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
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
    
    public function tyre_data (Request $request) {
        
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
            
       
            $new = Tyre::tyre_data($user_id,$type,$pincode,$district,$state,$app_section,$skip,$take);
        
            $output['response']=true;
            $output['message']='Tyre Data';
            $output['data'] = $new;
            $output['error'] = "";
         
            
        }
        return $output;
    
    
    }
    
    public function tyre_update (Request $request) {
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
        
        $userAuth = DB::table('tyres')->where(['user_id'=>$user_id,'id'=>$item_id])->count();
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
            
            $tyres_data = DB::table('tyres')->where(['id'=>$item_id])->first();
            $tyres_id = $tyres_data->id;
            $tyre_userid = $tyres_data->user_id;
                
            if ($image1 = $request->file('image1')) {
                $image1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1')->getClientOriginalName();
                $ext = $request->file('image1')->getClientOriginalExtension();
                $request->file('image1')->storeAs('public/tyre', $image1);
            }else {
                $image1=$tyres_data->image1;
            }
            
            if ($image2 = $request->file('image2')) {
                $image2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2')->getClientOriginalName();
                $ext = $request->file('image2')->getClientOriginalExtension();
                $request->file('image2')->storeAs('public/tyre', $image2);
            }else {
                $image2=$tyres_data->image2;
            }
            
            if ($image3 = $request->file('image3')) {
                $image3 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3')->getClientOriginalName();
                $ext = $request->file('image3')->getClientOriginalExtension();
                $request->file('image3')->storeAs('public/tyre', $image3);
            }else {
                $image3=$tyres_data->image3;
            }
            
            $type = $request->type ? $request->type : $tyres_data->type;
            $brand_id  = $request->brand_id ? $request->brand_id : $tyres_data->brand_id;
            $model_id  = $request->model_id ? $request->model_id : $tyres_data->model_id;
            $category_id  = $request->category_id ? $request->category_id : $tyres_data->category_id;

            $country_id  = $request->country_id ? $request->country_id : $tyres_data->country_id;
            $state_id   = $request->state_id ? $request->state_id : $tyres_data->state_id;
            $district_id   = $request->district_id ? $request->district_id : $tyres_data->district_id;
            $city_id   = $request->city_id ? $request->city_id : $tyres_data->city_id;
            $pincode   = $request->pincode ? $request->pincode : $tyres_data->pincode;
            $year_of_purchase   = $request->year_of_purchase ? $request->year_of_purchase : $tyres_data->year_of_purchase;

            $position = $request->position ? $request->position : $tyres_data->position;
            $price = $request->price ? $request->price : $tyres_data->price;
            $description = $request->description ? $request->description : $tyres_data->description;
            $is_negotiable = ($request->is_negotiable == "0") ? 0 : (($request->is_negotiable == "1") ? 1 : $fer_data->is_negotiable);

            $updateTyre = [
                'type'=>$type,
                'brand_id'=>$brand_id,
                'model_id'=>$model_id,
                'category_id'=>$category_id,
                'country_id'=>$country_id,
                'state_id'=>$state_id,
                'district_id'=>$district_id,
                'city_id'=>$city_id,
                'pincode'=>$pincode,
                'year_of_purchase'=>$year_of_purchase,
                'position'=>$position,
                'price'=>$price,
                'is_negotiable'=>$is_negotiable,
                'description'=>$description,
                'image1'=>$image1,
                'image2'=>$image2,
                'image3'=>$image3,
                'status'=>0,
                'updated_at'=>date('Y-m-d H:i:s')
            ];      
            
            $insert = DB::table('tyres')->where(['id'=>$item_id])->update($updateTyre);
            if ($insert>0) {
                if (isset(auth()->user()->id)) {
                    $user_id = auth()->user()->id;
                }
                
                $mobile = DB::table('user')->where('id',$user_id)->value('mobile');
                sms::post_pending($mobile,7);

                $output['response']=true;
                $output['last_id']=$tyres_id; //inserted Tyre id
                $output['message']='Data Updated Successfully';
                $output['data'] = '';
                $output['error'] = "";
            } else {
               $output['response']=false;
                $output['message']='Something wend wrong';
                $output['data'] = '';
                $output['error'] = ""; 
            }
           
        }
        return $output;
        
    
    }

    /** Tyre View All */
    public function tyreDistance1(Request $request){
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
        else if($type == 'old'){

            $sql = DB::table('tyresView')
            ->select('*'
            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
            * cos(radians(tyresView.latitude))
            * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
            + sin(radians(" .$latitude. "))
            * sin(radians(tyresView.latitude))) AS distance"))
            ->where('type','old')
            ->orderBy('distance', 'ASC')
            ->whereIn('status',[1,4])
            ->limit($take)
            ->offset($skip)
            ->get();
        }
        else if($type == 'new'){
            $sql = DB::table('tyresView')
            ->select('*'
            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
            * cos(radians(tyresView.latitude))
            * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
            + sin(radians(" .$latitude. "))
            * sin(radians(tyresView.latitude))) AS distance"))
            ->where('type','new')
            ->orderBy('distance', 'ASC')
            ->whereIn('status',[1,4])
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
                $data['photo'] = asset("storage/photo/$user_details->photo");
                }
            }

            $data['type']       = $val->type;  
            $data['brand_id']   = $val->brand_id;
            $data['model_id']   = $val->model_id;
            $data['title']      = $val->title;

            $data['brand_name'] = $val->brand_name;
            $data['model_name'] = $val->model_name;

            $data['position']    = $val->position;
            $data['price']       = $val->price;
            $data['description'] = $val->description;

            if ($val->image1=='' || $val->image1=='NULL') { 
                $data['image1'] = '';
            } else {
                $data['image1'] = asset("storage/tyre/$val->image1"); 
            }
            if ($val->image2=='' || $val->image2=='NULL') { 
                $data['image2'] = '';
            } else {
                $data['image2'] = asset("storage/tyre/$val->image2"); 
            }
            if ($val->image3=='' || $val->image3=='NULL') { 
                $data['image3'] = '';
            } else {
                $data['image3'] = asset("storage/tyre/$val->image3"); 
            }

            $data['is_negotiable'] = $val->is_negotiable;
            $data['country_id']    = $val->country_id;
            $data['state_id']      = $val->state_id;
            $data['district_id']   = $val->district_id;
            $data['city_id']       = $val->city_id;

            $data['state_name']    = $val->state_name;
            $data['district_name'] = $val->district_name;
            $data['city_name']     = $val->city_name;

            $wishlist_status = DB::select("SELECT COUNT(*) as count FROM wishlist
                            WHERE user_id = :user_id
                            AND category_id = 7
                            AND item_id = :item_id", ['user_id' => $user_id, 'item_id' => $val->id]);

            $data['wishlist_status'] = $wishlist_status[0]->count;
            $data['pincode']         = $val->pincode;
            $data['latlong']         = $val->latlong;
            $data['is_featured']     = $val->is_featured;
            $data['valid_till']      = $val->valid_till;
            $data['ad_report']       = $val->ad_report;
            $data['status']          = $val->status;
            $data['created_at']      = date("d-m-Y", strtotime($val->created_at));
            $data['updated_at']      = $val->updated_at;

            $view_lead               = DB::select("SELECT COUNT(*) as count FROM leads_views WHERE category_id = 7 AND post_id = :post_id", ['post_id' => $val->id]);
            $data['view_lead']       = $view_lead[0]->count;

            $call_lead               = DB::select("SELECT COUNT(*) as count FROM seller_leads WHERE category_id = 7 AND post_id = :post_id AND calls_status = 1 ", ['post_id' => $val->id]);
            $data['call_lead']       = $call_lead[0]->count;

            $msg_lead                = DB::select("SELECT COUNT(*) as count FROM seller_leads WHERE category_id = 7 AND post_id = :post_id AND messages_status = 1 ",  ['post_id' => $val->id]);
            $data['msg_lead']        = $msg_lead[0]->count;

            $new[] = $data;

            $output['response']       = true;
            $output['message']        = 'Tyres Data';
            $output['data']           = $new;
            $output['error']          = "";
        }

        if(!empty($data)){
            return $output;
        }else {
            return ['message' => 'No Data Available','data' =>[]];
        } 
    }

    public function tyreDistance(Request $request){
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

        if (Cache::has('tyre_viewall-'.$type.'-'.$user_id.'-'.$skip.'-'.$take)) {
            $new = Cache::get('tyre_viewall-'.$type.'-'.$user_id.'-'.$skip.'-'.$take);
            return [
                'response' => true,
                'message' => 'Tyre Data',
                'data' => $new,
                'data_on' => 'Cache',
                'status_code'=>200,
                'error' => '',
            ];

        } else {
            
            if($type == 'old'){

            $sql = DB::table('tyresView')
            ->select('*'
            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
            * cos(radians(tyresView.latitude))
            * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
            + sin(radians(" .$latitude. "))
            * sin(radians(tyresView.latitude))) AS distance"))
            ->where('type','old')
            ->orderBy('distance', 'ASC')
            ->whereIn('status',[1,4])
            ->limit($take)
            ->offset($skip)
            ->get();
        }
        else if($type == 'new'){
            $sql = DB::table('tyresView')
            ->select('*'
            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
            * cos(radians(tyresView.latitude))
            * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
            + sin(radians(" .$latitude. "))
            * sin(radians(tyresView.latitude))) AS distance"))
            ->where('type','new')
            ->orderBy('distance', 'ASC')
            ->whereIn('status',[1,4])
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

            $boosted = Subscribed_boost::view_all_boosted_products(7,$val->id);
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
                $data['photo'] = asset("storage/photo/$user_details->photo");
                }
            }

            $data['type']       = $val->type;  
            $data['brand_id']   = $val->brand_id;
            $data['model_id']   = $val->model_id;
            $data['title']      = $val->title;

            $data['brand_name'] = $val->brand_name;
            $data['model_name'] = $val->model_name;

            $data['position']    = $val->position;
            $data['price']       = $val->price;
            $data['description'] = $val->description;

            if ($val->image1=='' || $val->image1=='NULL') { 
                $data['image1'] = '';
            } else {
                $data['image1'] = asset("storage/tyre/$val->image1"); 
            }
            if ($val->image2=='' || $val->image2=='NULL') { 
                $data['image2'] = '';
            } else {
                $data['image2'] = asset("storage/tyre/$val->image2"); 
            }
            if ($val->image3=='' || $val->image3=='NULL') { 
                $data['image3'] = '';
            } else {
                $data['image3'] = asset("storage/tyre/$val->image3"); 
            }

            $data['is_negotiable'] = $val->is_negotiable;
            $data['country_id']    = $val->country_id;
            $data['state_id']      = $val->state_id;
            $data['district_id']   = $val->district_id;
            $data['city_id']       = $val->city_id;

            $data['state_name']    = $val->state_name;
            $data['district_name'] = $val->district_name;
            $data['city_name']     = $val->city_name;

            $wishlist_status = DB::select("SELECT COUNT(*) as count FROM wishlist
                            WHERE user_id = :user_id
                            AND category_id = 7
                            AND item_id = :item_id", ['user_id' => $user_id, 'item_id' => $val->id]);

            $data['wishlist_status'] = $wishlist_status[0]->count;
            $data['pincode']         = $val->pincode;
            $data['latlong']         = $val->latlong;
            $data['is_featured']     = $val->is_featured;
            $data['valid_till']      = $val->valid_till;
            $data['ad_report']       = $val->ad_report;
            $data['status']          = $val->status;
            // $data['created_at']      = date("d-m-Y", strtotime($val->created_at));
            $data['created_at']      = $val->created_at;
            $data['updated_at']      = $val->updated_at;

            $view_lead               = DB::select("SELECT COUNT(*) as count FROM leads_views WHERE category_id = 7 AND post_id = :post_id", ['post_id' => $val->id]);
            $data['view_lead']       = $view_lead[0]->count;

            $call_lead               = DB::select("SELECT COUNT(*) as count FROM seller_leads WHERE category_id = 7 AND post_id = :post_id AND calls_status = 1 ", ['post_id' => $val->id]);
            $data['call_lead']       = $call_lead[0]->count;

            $msg_lead                = DB::select("SELECT COUNT(*) as count FROM seller_leads WHERE category_id = 7 AND post_id = :post_id AND messages_status = 1 ",  ['post_id' => $val->id]);
            $data['msg_lead']        = $msg_lead[0]->count;

            $new[] = $data;
        
        }
        Cache::put('tyre_viewall-'.$type.'-'.$user_id.'-'.$skip.'-'.$take, $new, 86400);
        return [
                    'response' => true,
                    'message' => 'Tyre Data',
                    'data' => $new,
                    'data_on' => 'Database',
                    'status_code'=>200,
                    'error' => '',
                ];
        }

    }


}
