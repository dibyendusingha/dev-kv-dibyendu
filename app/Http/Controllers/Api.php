<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\LaraEmail;
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
use Image;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Models\sms;
use Carbon\Carbon;

use App\Models\Crops\Crops;

class Api extends Controller
{
    
    
    
    
    public function category (Request $request) {
       $output=[];
       $data=[];
       //$get = DB::table('category')->where(['status'=>1])->get();
       $get = DB::table('category')->orderBy('sequence','asc')->where(['status'=>1])->get();
       //print_r($get);
       foreach ($get as $val) {
           $id = $val->id;
           $sequence = $val->sequence;
           $category = $val->category;
           $icon = asset("storage/category/$val->icon");
           $status = $val->status;
           $ln_bn = $val->ln_bn;
           $ln_hn = $val->ln_hn;
           $created_at = $val->created_at;
           $updated_at = $val->updated_at;
           
           $data[] = ['id'=>$id,'sequence'=>$sequence,'category'=>$category,'icon'=>$icon,'status'=>$status,'ln_bn'=>$ln_bn,'ln_hn'=>$ln_hn,'created_at'=>$created_at,'updated_at'=>$updated_at];
       }
                $output['response']=true;
                $output['message']='Category Data';
                $output['data'] = $data;
                $output['error'] = ""; 
       return $output;
        
    }
    
    public function state (Request $request) {
       $output=[];
       $data=[];
       $get = DB::table('state')->get();
       //print_r($get);
       foreach ($get as $val) {
           $id = $val->id;
           $country_id = $val->country_id;
           $state_name = $val->state_name;
           
           $tractor_count = DB::table('tractor')->where(['state_id'=>$id,'status'=>1])->count();
           $goods_vehicle_count = DB::table('goods_vehicle')->where(['state_id'=>$id,'status'=>1])->count();
           $harvester_count = DB::table('harvester')->where(['state_id'=>$id,'status'=>1])->count();
           $implements_count = DB::table('implements')->where(['state_id'=>$id,'status'=>1])->count();
           $tyres_count = DB::table('tyres')->where(['state_id'=>$id,'status'=>1])->count();
           $seeds_count = DB::table('seeds')->where(['state_id'=>$id,'status'=>1])->count();
           $pesticides_count = DB::table('pesticides')->where(['state_id'=>$id,'status'=>1])->count();
           $fertilizers_count = DB::table('fertilizers')->where(['state_id'=>$id,'status'=>1])->count();
           
           $status = $val->status;
           $created_at = $val->created_at;
           $updated_at = $val->updated_at;
           
           $data[] = ['id'=>$id,'country_id'=>$country_id,'state_name'=>$state_name,'status'=>$status,'created_at'=>$created_at,'updated_at'=>$updated_at,
           'tractor_count'=>$tractor_count,'goods_vehicle_count'=>$goods_vehicle_count,'harvester_count'=>$harvester_count,'implements_count'=>$implements_count,'tyres_count'=>$tyres_count,
           'seeds_count'=>$seeds_count,'pesticides_count'=>$pesticides_count,'fertilizers_count'=>$fertilizers_count];
       }
                $output['response']=true;
                $output['message']='State Data';
                $output['data'] = $data;
                $output['error'] = ""; 
       return $output;
        
    }
    
    public function district (Request $request) {
        $output=[];
        $data=[];
       
        $state_id = $request->state_id;
        
          $validator = Validator::make($request->all(), [
            'state_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
        
       $get = DB::table('district')->where(['state_id'=>$state_id])->get();
       //print_r($get);
       foreach ($get as $val) {
           $id = $val->id;
           
           $tractor_count = DB::table('tractor')->where(['district_id'=>$id,'status'=>1])->count();
           $goods_vehicle_count = DB::table('goods_vehicle')->where(['district_id'=>$id,'status'=>1])->count();
           $harvester_count = DB::table('harvester')->where(['district_id'=>$id,'status'=>1])->count();
           $implements_count = DB::table('implements')->where(['district_id'=>$id,'status'=>1])->count();
           $tyres_count = DB::table('tyres')->where(['district_id'=>$id,'status'=>1])->count();
           $seeds_count = DB::table('seeds')->where(['district_id'=>$id,'status'=>1])->count();
           $pesticides_count = DB::table('pesticides')->where(['district_id'=>$id,'status'=>1])->count();
           $fertilizers_count = DB::table('fertilizers')->where(['district_id'=>$id,'status'=>1])->count();
           
           
           $district_name = $val->district_name;
           $latitude = $val->latitude;
           $longitude = $val->longitude;
           
           $data[] = ['id'=>$id,'district_name'=>$district_name,'latitude'=>$latitude,'longitude'=>$longitude,
           'tractor_count'=>$tractor_count,'goods_vehicle_count'=>$goods_vehicle_count,'harvester_count'=>$harvester_count,'implements_count'=>$implements_count,'tyres_count'=>$tyres_count,
           'seeds_count'=>$seeds_count,'pesticides_count'=>$pesticides_count,'fertilizers_count'=>$fertilizers_count];
       }
                $output['response']=true;
                $output['message']='District Data';
                $output['data'] = $data;
                $output['error'] = ""; 
        }
       return $output;
        
    }
    
    public function price_counter (Request $request) {
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $type = $request->type;
        
            if ($type == 'new') {
                $set = 'sell'; $type='new';
            } else if ($type == 'old') {
                $set = 'sell'; $type='old';
            } else if ($type == 'rent') {
                $set = 'rent'; $type='old';
            } else {
                $set = ''; $type='';
            }
            
           $tractor_count = DB::table('tractor')->where(['status'=>1])->whereBetween('price', [$price_start,$price_end])->where(['set'=>$set,'type'=>$type])->count();
           $goods_vehicle_count = DB::table('goods_vehicle')->where(['status'=>1])->whereBetween('price', [$price_start,$price_end])->where(['set'=>$set,'type'=>$type])->count();
           $harvester_count = DB::table('harvester')->where(['status'=>1])->whereBetween('price', [$price_start,$price_end])->where(['set'=>$set,'type'=>$type])->count();
           $implements_count = DB::table('implements')->where(['status'=>1])->whereBetween('price', [$price_start,$price_end])->where(['set'=>$set,'type'=>$type])->count();
           $tyres_count = DB::table('tyres')->where(['status'=>1])->whereBetween('price', [$price_start,$price_end])->where(['type'=>$type])->count();
           $seeds_count = DB::table('seeds')->where(['status'=>1])->whereBetween('price', [$price_start,$price_end])->count();
           $pesticides_count = DB::table('pesticides')->where(['status'=>1])->whereBetween('price', [$price_start,$price_end])->count();
           $fertilizers_count = DB::table('fertilizers')->where(['status'=>1])->whereBetween('price', [$price_start,$price_end])->count();
        
            $data[] = ['tractor_count'=>$tractor_count,'goods_vehicle_count'=>$goods_vehicle_count,'harvester_count'=>$harvester_count,'implements_count'=>$implements_count,'tyres_count'=>$tyres_count,
           'seeds_count'=>$seeds_count,'pesticides_count'=>$pesticides_count,'fertilizers_count'=>$fertilizers_count];
       
                $output['response']=true;
                $output['message']='Count Data';
                $output['data'] = $data;
                $output['error'] = ""; 
        
       return $output;
    }
    
    public function city (Request $request) {
        $output=[];
        $data=[];
       
        $district_id = $request->district_id;
        
          $validator = Validator::make($request->all(), [
            'district_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
        
       $get = DB::table('city')->where(['district_id'=>$district_id])->get();
       //print_r($get);
       foreach ($get as $val) {
           $id = $val->id;
           $pincode = $val->pincode;
           $city_name = $val->city_name;
           $country_id = $val->country_id;
           $state_id  = $val->state_id;
           $latitude = $val->latitude;
           $longitude = $val->longitude;
           
           $data[] = ['id'=>$id,'pincode'=>$pincode,'city_name'=>$city_name,'country_id'=>$country_id,'state_id'=>$state_id,'latitude'=>$latitude,'longitude'=>$longitude];
       }
                $output['response']=true;
                $output['message']='City Data';
                $output['data'] = $data;
                $output['error'] = ""; 
        }
       return $output;
        
    }
    
    
    public function master_brand (Request $request) {
        $output=[];
        $data=[];
        $count = DB::table('brand_master')->where(['status'=>1,'display'=>1])->count();
        if ($count>0) {
        $get = DB::table('brand_master')->where(['status'=>1,'display'=>1])->get();
        foreach ($get as $val) {
            $id = $val->id;
            $brand_id = $val->brand_id;
            $brand_name = $val->brand_name;
            $brand_image = asset("storage/images/brands/$val->brand_image");
            
            $new[] = ['id'=>$id,'brand_id'=>$brand_id,'brand_name'=>$brand_name,'brand_image'=>$brand_image];
        }
        $output['response']=true;
        $output['message']='Master Brand Data';
        $output['data'] = $new;
        $output['error'] = ""; 
        
        } else {
            $output['response']=false;
            $output['message']='No data Found';
            $output['data'] = '';
            $output['error'] = ""; 
        }
       
        return $output;
    }
    
    public function master_brand_view_all (Request $request) {
        $output=[];
        $data=[];
        
        $count = DB::table('brand_master')->where(['status'=>1])->count();
        if ($count>0) {
        $get = DB::table('brand_master')->where(['status'=>1])->get();
        foreach ($get as $val) {
            $id = $val->id;
            $brand_id = $val->brand_id;
            $brand_name = $val->brand_name;
            $brand_image = asset("storage/images/brands/$val->brand_image");
            
            $new[] = ['id'=>$id,'brand_id'=>$brand_id,'brand_name'=>$brand_name,'brand_image'=>$brand_image];
        }
        $output['response']=true;
        $output['message']='Master Brand Data';
        $output['data'] = $new;
        $output['error'] = ""; 
        } else {
            $output['response']=false;
            $output['message']='No data Found';
            $output['data'] = '';
            $output['error'] = "";  
        }
        return $output;
    }
    
    public function master_brand_data (Request $request) {
        $output=[];
        $data=[];
        
        $master_brand_id = $request->master_brand_id;
        $district_id = $request->district;
        
        $get = DB::table('brand_master')->where(['id'=>$master_brand_id])->first();
            $id = $get->id;
            $brand_id = $get->brand_id;
            $brand_name = $get->brand_name;
            
            $exp = explode (',',$brand_id);
            foreach ($exp as $val1) {
              
                
                $count = DB::table('tractor')->where(['brand_id'=>$val1,'district_id'=>$district_id,'status'=>1])->count();
                if ($count>0) {
                    $get = DB::table('tractor')->where(['brand_id'=>$val1,'district_id'=>$district_id,'status'=>1])->get();
                    foreach ($get as $val) {
                        
                
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
                $data['created_at'] = date("d-m-Y", strtotime($user_details->created_at));
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
                    $data['left_image'] = asset("storage/tractor/$val->left_image");
                }
                if ($val->right_image=='' || $val->right_image=='NULL') { 
                    $data['right_image'] = '';
                } else {
                    $data['right_image'] = asset("storage/tractor/$val->right_image"); 
                }
                if ($val->front_image=='' || $val->front_image=='NULL') { 
                    $data['front_image'] = '';
                } else {
                    $data['front_image'] = asset("storage/tractor/$val->front_image"); 
                }
                if ($val->back_image=='' || $val->back_image=='NULL') { 
                    $data['back_image'] = '';
                } else {
                    $data['back_image'] = asset("storage/tractor/$val->back_image"); 
                }
                if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                    $data['meter_image'] = '';
                } else {
                    $data['meter_image'] = asset("storage/tractor/$val->meter_image"); 
                }
                if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                    $data['tyre_image'] = '';
                } else {
                    $data['tyre_image'] = asset("storage/tractor/$val->tyre_image"); 
                }
                $data['price'] = $val->price;
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
                
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $new[] = $data;
            
            
                    }
                }
                
                
                $count1 = DB::table('rent_tractor')->where(['brand_id'=>$val1,'district_id'=>$district_id,'status'=>1])->count();
                if ($count1>0) {
                    $get = DB::table('rent_tractor')->where(['brand_id'=>$val1,'district_id'=>$district_id,'status'=>1])->get();
                    foreach ($get as $val) {
                
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
                $data['created_at'] = date("d-m-Y", strtotime($user_details->created_at));
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
                
                $brand_arr_data = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                $data['brand_name'] = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id'=>$val->model_id])->first();
                $data['model_name'] = $model_arr_data->model_name;
                
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
                $data['description'] = $val->description;
                $data['spec_id'] = $val->spec_id;
                if ($val->left_image=='' || $val->left_image=='NULL') { 
                    $data['left_image'] = '';
                } else {
                    $data['left_image'] = asset("storage/tractor/$val->left_image"); 
                }
                if ($val->right_image=='' || $val->right_image=='NULL') { 
                    $data['right_image'] = '';
                } else {
                    $data['right_image'] = asset("storage/tractor/$val->right_image"); 
                }
                if ($val->front_image=='' || $val->front_image=='NULL') { 
                    $data['front_image'] = '';
                } else {
                    $data['front_image'] = asset("storage/tractor/$val->front_image"); 
                }
                if ($val->back_image=='' || $val->back_image=='NULL') { 
                    $data['back_image'] = '';
                } else {
                    $data['back_image'] = asset("storage/tractor/$val->back_image"); 
                }
                if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                    $data['meter_image'] = '';
                } else {
                    $data['meter_image'] = asset("storage/tractor/$val->meter_image"); 
                }
                if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                    $data['tyre_image'] = '';
                } else {
                    $data['tyre_image'] = asset("storage/tractor/$val->tyre_image"); 
                }
                $data['rent_type'] = $val->rent_type;
                $data['price'] = $val->price;
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
                
                $count2 = DB::table('goods_vehicle')->where(['brand_id'=>$val1,'district_id'=>$district_id,'status'=>1])->count();
                if ($count2>0) {
                    $get = DB::table('goods_vehicle')->where(['brand_id'=>$val1,'district_id'=>$district_id,'status'=>1])->get();
                    foreach ($get as $val) {
                
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
                $data['created_at'] = date("d-m-Y", strtotime($user_details->created_at));
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
                
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $new[] = $data;
            
            }
                }
                
            }
            
            $output['response']=true;
            $output['message']='Master Brand Data';
            $output['data'] = $new;
            $output['error'] = ""; 
           
            return $output;
        
    }
    
    public function brand (Request $request) {
        $output=[];
        $data=[];
        
        $category = $request->category;
       
       $get = DB::table('brand')->where(['category_id'=>$category])->get();
       //print_r($get);
       foreach ($get as $val) {
           $id = $val->id;
           $name = $val->name;
           $popular = $val->popular;
           $logo = asset("storage/images/brands/$val->logo");
           $status = $val->status;
           $created_at = $val->created_at;
           $updated_at = $val->updated_at;
           
           $data[] = ['id'=>$id,'name'=>$name,'logo'=>$logo,'popular'=>$popular,'status'=>$status,'created_at'=>$created_at,'updated_at'=>$updated_at];
       }  
        $output['response']=true;
        $output['message']='Brand Data';
        $output['data'] = $data;
        $output['error'] = ""; 
       
        return $output;
    }
    
    public function model (Request $request) {
        $output=[];
        $data=[];
       
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        
          $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
        
       $get = DB::table('model')->where(['company_id'=>$category_id,'brand_id'=>$brand_id])->get();
       //print_r($get);
       foreach ($get as $val) {
           $id = $val->id;
           $model_name = $val->model_name;
           $icon = asset("storage/images/model/".$val->icon);
           $status = $val->status;
           $created_at  = $val->created_at;
           $updated_at = $val->updated_at;
           
           $data[] = ['id'=>$id,'model_name'=>$model_name,'icon'=>$icon,'status'=>$status,'created_at'=>$created_at,'updated_at'=>$updated_at];
            }
                $output['response']=true;
                $output['message']='Model Data';
                $output['data'] = $data;
                $output['error'] = ""; 
        }
       return $output;
        
    
    }
    
    public function state_counter (Request $request) {
       $output=[];
       $data=[];
       $type = $request->type;
       if ($type == 'new') {
                $set = 'sell'; $type='new';
            } else if ($type == 'old') {
                $set = 'sell'; $type='old';
            } else if ($type == 'rent') {
                $set = 'rent'; $type='old';
            } else {
                $set = ''; $type='';
            }
            
       $get = DB::table('state')->get();
       //print_r($get);
       foreach ($get as $val) {
           $id = $val->id;
           $country_id = $val->country_id;
           $state_name = $val->state_name;
           
           $tractor_count = DB::table('tractor')->where(['state_id'=>$id,'set'=>$set,'type'=>$type,'status'=>1])->count();
           $goods_vehicle_count = DB::table('goods_vehicle')->where(['state_id'=>$id,'set'=>$set,'type'=>$type,'status'=>1])->count();
           $harvester_count = DB::table('harvester')->where(['state_id'=>$id,'set'=>$set,'type'=>$type,'status'=>1])->count();
           $implements_count = DB::table('implements')->where(['state_id'=>$id,'set'=>$set,'type'=>$type,'status'=>1])->count();
           $tyres_count = DB::table('tyres')->where(['state_id'=>$id,'type'=>$type,'status'=>1])->count();
           $seeds_count = DB::table('seeds')->where(['state_id'=>$id,'status'=>1])->count();
           $pesticides_count = DB::table('pesticides')->where(['state_id'=>$id,'status'=>1])->count();
           $fertilizers_count = DB::table('fertilizers')->where(['state_id'=>$id,'status'=>1])->count();
           
           $status = $val->status;
           $created_at = $val->created_at;
           $updated_at = $val->updated_at;
           
           $data[] = ['id'=>$id,'country_id'=>$country_id,'state_name'=>$state_name,'status'=>$status,'created_at'=>$created_at,'updated_at'=>$updated_at,
           'tractor_count'=>$tractor_count,'goods_vehicle_count'=>$goods_vehicle_count,'harvester_count'=>$harvester_count,'implements_count'=>$implements_count,'tyres_count'=>$tyres_count,
           'seeds_count'=>$seeds_count,'pesticides_count'=>$pesticides_count,'fertilizers_count'=>$fertilizers_count];
       }
                $output['response']=true;
                $output['message']='State Data';
                $output['data'] = $data;
                $output['error'] = ""; 
       return $output;
        
    }
    
    public function state_district (Request $request) {
        $output=[];
        $data=[];
       
        $state = $request->state;
        $type = $request->type;
        
          $validator = Validator::make($request->all(), [
            'state' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            if ($type == 'new') {
                $set = 'sell'; $type='new';
            } else if ($type == 'old') {
                $set = 'sell'; $type='old';
            } else if ($type == 'rent') {
                $set = 'rent'; $type='old';
            } else {
                $set = ''; $type='';
            }
            
      $state_arr = explode(',',$state);
       foreach ($state_arr as $state_id) {
       $get = DB::table('district')->where(['state_id'=>$state_id])->get();
       //print_r($get);
       foreach ($get as $val) {
           $id = $val->id;
           
           $tractor_count = DB::table('tractor')->where(['district_id'=>$id,'set'=>$set,'type'=>$type,'status'=>1])->count();
           $goods_vehicle_count = DB::table('goods_vehicle')->where(['district_id'=>$id,'set'=>$set,'type'=>$type,'status'=>1])->count();
           $harvester_count = DB::table('harvester')->where(['district_id'=>$id,'set'=>$set,'type'=>$type,'status'=>1])->count();
           $implements_count = DB::table('implements')->where(['district_id'=>$id,'set'=>$set,'type'=>$type,'status'=>1])->count();
           $tyres_count = DB::table('tyres')->where(['district_id'=>$id,'type'=>$type,'status'=>1])->count();
           $seeds_count = DB::table('seeds')->where(['district_id'=>$id,'status'=>1])->count();
           $pesticides_count = DB::table('pesticides')->where(['district_id'=>$id,'status'=>1])->count();
           $fertilizers_count = DB::table('fertilizers')->where(['district_id'=>$id,'status'=>1])->count();
           
           
           $district_name = $val->district_name;
           $latitude = $val->latitude;
           $longitude = $val->longitude;
           
           $data[] = ['id'=>$id,'district_name'=>$district_name,'latitude'=>$latitude,'longitude'=>$longitude,
           'tractor_count'=>$tractor_count,'goods_vehicle_count'=>$goods_vehicle_count,'harvester_count'=>$harvester_count,'implements_count'=>$implements_count,'tyres_count'=>$tyres_count,
           'seeds_count'=>$seeds_count,'pesticides_count'=>$pesticides_count,'fertilizers_count'=>$fertilizers_count];
       }
       }
                $output['response']=true;
                $output['message']='District Data';
                $output['data'] = $data;
                $output['error'] = ""; 
        }
       return $output;
        
    }
    
    
    
    public function home_data (Request $request) {
        //for dashboard new,used,rent data and this run also on view details page.
        $new=[];
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $type = $request->type; //new , used, rent
        $skip = $request->skip;
        $take = $request->take;
        $pincode = $request->pincode;
        //$district = $request->district;
        //$state = $request->state;
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
            
        $tractor_sell_new = Tractor::tractor_data($user_id,'new',$pincode,$district,$state,'dashboard',$skip,$take);
        $tractor_sell_old = Tractor::tractor_data($user_id,'old',$pincode,$district,$state,'dashboard',$skip,$take);
        $tractor_rent = Tractor::tractor_data_rent($user_id,'rent',$pincode,$district,$state,'dashboard',$skip,$take);

        $gv_sell_new = Goods_vehicle::gv_data($user_id,'new',$pincode,$district,$state,'dashboard',$skip,$take);
        $gv_sell_old = Goods_vehicle::gv_data($user_id,'old',$pincode,$district,$state,'dashboard',$skip,$take);
        $gv_rent = Goods_vehicle::gv_data_rent($user_id,'rent',$pincode,$district,$state,'dashboard',$skip,$take);

        $harvester_sell_new = Harvester::harvester_data($user_id,'new',$pincode,$district,$state,'dashboard',$skip,$take);
        $harvester_sell_old = Harvester::harvester_data($user_id,'old',$pincode,$district,$state,'dashboard',$skip,$take);
        $harvester_rent = Harvester::harvester_data_rent($user_id,'rent',$pincode,$district,$state,'dashboard',$skip,$take);

        $implements_sell_new = Implement::implement_data($user_id,'new',$pincode,$district,$state,'dashboard',$skip,$take);
        $implements_sell_old = Implement::implement_data($user_id,'old',$pincode,$district,$state,'dashboard',$skip,$take);
        $implements_rent = Implement::implement_data_rent($user_id,'rent',$pincode,$district,$state,'dashboard',$skip,$take);

        $seed = Seed::seeds_data($user_id,$pincode,$district,$state,'dashboard',$skip,$take);
        $pesticides = pesticides::pesticides_data($user_id,$pincode,$district,$state,'dashboard',$skip,$take);
        $fertilizers = fertilizers::fertilizers_data($user_id,$pincode,$district,$state,'dashboard',$skip,$take);

        $tyre_new = Tyre::tyre_data($user_id,'new',$pincode,$district,$state,'dashboard',$skip,$take);
        $tyre_old = Tyre::tyre_data($user_id,'old',$pincode,$district,$state,'dashboard',$skip,$take);
        $new[] = ['tractor_sell_new'=>$tractor_sell_new,'tractor_sell_old'=>$tractor_sell_old,'tractor_rent'=>$tractor_rent,'gv_sell_new'=>$gv_sell_new,'gv_sell_old'=>$gv_sell_old,'gv_rent'=>$gv_rent,
        'harvester_sell_new'=>$harvester_sell_new,'harvester_sell_old'=>$harvester_sell_old,'harvester_rent'=>$harvester_rent,'implements_sell_new'=>$implements_sell_new,'implements_sell_old'=>$implements_sell_old,
        'implements_rent'=>$implements_rent,'seed'=>$seed,'pesticides'=>$pesticides,'fertilizers'=>$fertilizers,'tyre_new'=>$tyre_new,'tyre_old'=>$tyre_old];
        
        // if ($type=='rent') {
        //     $new = Tractor::tractor_data_rent($user_id,$type,$pincode,$district,$state,$app_section,$skip,$take);
        // } else {
        //     $new = Tractor::tractor_data($user_id,$type,$pincode,$district,$state,$app_section,$skip,$take);
        // }
            $output['response']=true;
            $output['message']='Home Data';
            $output['data'] = $new;
            $output['error'] = "";
         
         
         
         }
          return $output;  
        
    }
    
    
    
    
    public function mark_as_sold (Request $request) {
        $category_id = $request->category_id;
        $item_id = $request->item_id;
        
        if ($category_id==1) {
            $update = DB::table('tractor')->where(['id'=>$item_id])->update(['status'=>4]);
        } else if ($category_id==3) {
            $update = DB::table('goods_vehicle')->where(['id'=>$item_id])->update(['status'=>4]);
        } else if ($category_id==4) {
            $update = DB::table('harvester')->where(['id'=>$item_id])->update(['status'=>4]);
        } else if ($category_id==5) {
            $update = DB::table('implements')->where(['id'=>$item_id])->update(['status'=>4]);
        } else if ($category_id==6) {
            $update = DB::table('seeds')->where(['id'=>$item_id])->update(['status'=>4]);
        } else if ($category_id==8) {
            $update = DB::table('pesticides')->where(['id'=>$item_id])->update(['status'=>4]);
        } else if ($category_id==9) {
            $update = DB::table('fertilizers')->where(['id'=>$item_id])->update(['status'=>4]);
        } else if ($category_id==7) {
            $update = DB::table('tyres')->where(['id'=>$item_id])->update(['status'=>4]);
        }
        
        if ($update) {
            $output['response']=true;
            $output['message']='Mark as sold Successfully';
            $output['data'] = '';
            $output['error'] = "";
        } else {
           $output['response']=false;
            $output['message']='Something wend wrong';
            $output['data'] = '';
            $output['error'] = ""; 
        }
            
        return $output;
        
    }
    
    public function post_disabled (Request $request) {
        
        $category_id = $request->category_id;
        $item_id = $request->item_id;
        
        if ($category_id==1) {
            $update = DB::table('tractor')->where(['id'=>$item_id])->update(['status'=>3]);
        } else if ($category_id==3) {
            $update = DB::table('goods_vehicle')->where(['id'=>$item_id])->update(['status'=>3]);
        } else if ($category_id==4) {
            $update = DB::table('harvester')->where(['id'=>$item_id])->update(['status'=>3]);
        } else if ($category_id==5) {
            $update = DB::table('implements')->where(['id'=>$item_id])->update(['status'=>3]);
        } else if ($category_id==6) {
            $update = DB::table('seeds')->where(['id'=>$item_id])->update(['status'=>3]);
        } else if ($category_id==8) {
            $update = DB::table('pesticides')->where(['id'=>$item_id])->update(['status'=>3]);
        } else if ($category_id==9) {
            $update = DB::table('fertilizers')->where(['id'=>$item_id])->update(['status'=>3]);
        } else if ($category_id==7) {
            $update = DB::table('tyres')->where(['id'=>$item_id])->update(['status'=>3]);
        }
        
        if ($update) {
            $output['response']=true;
            $output['message']='Post Disabled Successfully';
            $output['data'] = '';
            $output['error'] = "";
        } else {
           $output['response']=false;
            $output['message']='Something wend wrong';
            $output['data'] = '';
            $output['error'] = ""; 
        }
            
        return $output;
        
    
    }
    
    
    /************ End fertilizers *************/
    
    public function profile (Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
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
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            $count = DB::table('user')->where(['id'=>$user_id])->count();
            if ($count>0) {
            
            $data_arr = DB::table('user')->where(['id'=>$user_id])->get();
            foreach ($data_arr as $val) {
                $data['user_type_id'] = $val->user_type_id;
                $data['role_id'] = $val->role_id;
                $data['name'] = $val->name;
                $data['company_name'] = $val->company_name;
                $data['gst_no'] = $val->gst_no;
                $data['mobile'] = $val->mobile;
                $data['email'] = $val->email;
                $data['facebook_id'] = $val->facebook_id;
                $data['google_id'] = $val->google_id;
                $data['gender'] = $val->gender;
                $data['address'] = $val->address;
                $data['state_id'] = $val->state_id;
                
                $data['state_name'] = DB::table('state')->where(['id'=>$val->state_id])->first();
                
                $data['district_id'] = $val->district_id;
                $data['district_name'] = DB::table('district')->where(['id'=>$val->district_id])->first();
                
                $data['city_id'] = $val->city_id;
                $data['city_name'] = DB::table('city')->where(['id'=>$val->city_id])->first();
                
                $data['country_id'] = $val->country_id;
                $data['zipcode'] = $val->zipcode;
                $data['latlong'] = $val->lat.','.$val->long;
                
                $data['device_id']  = $val->device_id;
                $data['firebase_token']  = $val->firebase_token;
                if ($val->photo=='NULL' || $val->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/$val->photo");
                }
                $data['dob'] = $val->dob;
                $data['phone_verified'] = $val->phone_verified;
                $data['email_verified'] = $val->email_verified;
                $data['whatsapp_optin'] = $val->whatsapp_optin;
                $data['newsletter_optin'] = $val->newsletter_optin;
                $data['sms_optin'] = $val->sms_optin;
                $data['marketing_optin'] = $val->marketing_optin;
                $data['kyc'] = $val->kyc;
                $data['ip_address'] = $val->ip_address;
                $data['device_id'] = $val->device_id;
                $data['firebase_token'] = $val->firebase_token;
                $data['user_source'] = $val->user_source;
                $data['reference_id'] = $val->reference_id;
                $data['converted_seller'] = $val->converted_seller;
                $data['paid_or_free'] = $val->paid_or_free;
                $data['token'] = $val->token;
                $data['status'] = $val->status; //status = 0(pending) , 1(approved) , 2(reject)
                $data['profile_update'] = $val->profile_update;
                $data['email_newslatter'] = $val->email_newslatter;
                $data['whatsapp_notification'] = $val->whatsapp_notification;
                $data['promotin'] = $val->promotin;
                $data['marketing_communication'] = $val->marketing_communication;
                $data['social_media_promotion'] = $val->social_media_promotion;
                $data['last_activity'] = $val->last_activity;
                $data['last_login'] = $val->last_login;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                $data['lamguage'] = $val->lamguage;
                
                
            }
            
                $output['response']=true;
                $output['message']='Data';
                $output['data'] = $data;
                $output['error'] = "";
            
            } else {
                $output['response']=false;
                $output['message']='No Data fount';
                $output['data'] = '';
                $output['error'] = "";
            }
        }
        return $output;
    }

    
    
    public function wishlist_add (Request $request) {
        $output=[];
        $data=[];
        $new=[];
      //  $user_id = $request->user_id;
        $user_token = $request->user_token;
        $category_id = $request->category_id;
        $item_id = $request->item_id;
        $user_id = auth()->user()->id;

        if($category_id == 1){
            $post_user_id = DB::table('tractor')->where('id',$item_id)->value('user_id');
        }else if($category_id == 3){
            $post_user_id = DB::table('goods_vehicle')->where('id',$item_id)->value('user_id');
        }if($category_id == 4){
            $post_user_id = DB::table('harvester')->where('id',$item_id)->value('user_id');
        }if($category_id == 5){
            $post_user_id = DB::table('implements')->where('id',$item_id)->value('user_id');
        }if($category_id == 6){
            $post_user_id = DB::table('seeds')->where('id',$item_id)->value('user_id');
        }if($category_id == 7){
            $post_user_id = DB::table('tyres')->where('id',$item_id)->value('user_id');
        }if($category_id == 8){
            $post_user_id = DB::table('pesticides')->where('id',$item_id)->value('user_id');
        }if($category_id == 9){
            $post_user_id = DB::table('fertilizers')->where('id',$item_id)->value('user_id');
        }if($category_id == 12){
            $post_user_id = DB::table('crops')->where('id',$item_id)->value('user_id');
           // dd($post_user_id);
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
            'category_id' => 'required',
            'item_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            
            // $count = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>$category_id,'item_id'=>$item_id])->count();
            $count = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>$category_id,'item_id'=>$item_id])->count();
            if ($count>0) {
                    $output['response']=false;
                    $output['message']='Already Added To Wishlist';
                    $output['data'] = '';
                    $output['error'] = "Already have the item";
            } else {
            
                $insert = DB::table('wishlist')->insert(['user_id'=>$user_id,'category_id'=>$category_id,'item_id'=>$item_id]);
                $insert_seller = DB::table('seller_leads')->insert(['user_id'=>$user_id,'post_user_id'=>$post_user_id,'category_id'=>$category_id,'post_id'=>$item_id,
                        'calls_status'=> 0,'messages_status'=> 0 , 'sms'=> 0,'wishlist'=>1,'share'=> 0 , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
                if ($insert===true || $insert==1) {
                    
                    if ($category_id==1) {
                        $where = ['id'=>$item_id];
                        $data = Tractor::get_data_by_where($where);
                    } else if ($category_id==3) {
                        $where = ['id'=>$item_id];
                        $data = Goods_vehicle::get_data_by_where($where);
                    } else if ($category_id==4) {
                        $where = ['id'=>$item_id];
                        $data = Harvester::get_data_by_where($where);
                    } else if ($category_id==5) {
                        $where = ['id'=>$item_id];
                        $data = Implement::get_data_by_where($where);
                    } else if ($category_id==6) {
                        $where = ['id'=>$item_id];
                        $data = Seed::get_data_by_where($where);
                    } else if ($category_id==7) {
                        $where = ['id'=>$item_id];
                        $data = Tyre::get_data_by_where($where);
                    } else if ($category_id==8) {
                        $where = ['id'=>$item_id];
                        $data = pesticides::get_data_by_where($where);
                    } else if ($category_id==9) {
                        $where = ['id'=>$item_id];
                        $data = fertilizers::get_data_by_where($where);
                    }
                    else if ($category_id == 12) {
                        $where = ['id'=>$item_id];
                        $data = Crops::get_data_by_where($where);
                    }

                    $sms = sms::product_lead($post_user_id);
                    
                    $output['response']=true;
                    $output['message']='Wishlist added Successfully';
                    $output['data'] = $data;
                    $output['error'] = "";
                } else {
                    $output['response']=false;
                    $output['message']='Something Went Wrong';
                    $output['data'] = '';
                    $output['error'] = "Not Insert";
                }
                
            }
            
        }
        
        return $output;
    }
    
    public function wishlist (Request $request) {
        $output=[];
        $data=[];
        $new=[];
        $user_id = $request->user_id;
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
            
            $count = DB::table('wishlist')->where(['user_id'=>$user_id])->count();
           // dd($count);
            if ($count>0) {
            
            $data_arr = DB::table('wishlist')->orderBy('id','desc')->where(['user_id'=>$user_id])->get();
            foreach ($data_arr as $val_dt) {
                $db_id = $val_dt->id;
                $category_id = $val_dt->category_id;
                $item_id = $val_dt->item_id;
                
                if ($category_id==1) {
                    $data = Tractor::tractor_single($item_id,$user_id);
                } else if ($category_id==3) {
                    $data = Goods_vehicle::gv_single($item_id,$user_id);
                } else if ($category_id==4) {
                    $data = Harvester::harvester_single($item_id,$user_id);
                } else if ($category_id==5) {
                    $data = Implement::implement_single($item_id,$user_id);
                } else if ($category_id==6) {
                    $data = Seed::seed_single($item_id,$user_id);
                } else if ($category_id==7) {
                    $data = Tyre::tyre_single($item_id,$user_id);
                } else if ($category_id==8) {
                    $data = pesticides::pesticides_single($item_id,$user_id);
                } else if ($category_id==9) {
                    $data = fertilizers::fertilizers_single($item_id,$user_id);
                } else if ($category_id==12) {
                    $data = Crops::crops_single($item_id,$user_id);
                }
                
               $new[] = $data; 
            }
            
                $output['response']=true;
                $output['message']='Data';
                $output['data'] = $new;
                $output['error'] = "";
            
            } else {
                $output['response']=false;
                $output['message']='No Data fount';
                $output['data'] = '';
                $output['error'] = "";
            }
        }
        return $output;
    }
    
    public function delete_wishlist (Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $category_id = $request->category_id;
        $item_id = $request->item_id;
        
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
            
            $del = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>$category_id,'item_id'=>$item_id])->delete();
            if ($del===true || $del==1) {
                $output['response']=true;
                $output['message']='Wishlist Deleted Successfully';
                $output['data'] = '';
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
    
    
    /******** settings ***************/
    
    
    
    /********** Search *******/
    public function search (Request $request) {
        $data = [];
        $new = [];
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $keyword = $request->keyword;
        $skip = $request->skip;
        $take = $request->take;
        if ($keyword=='') {
            
        $count = DB::table('search_store')->where(['user_id'=>$user_id])->count();
        if ($count>0) {
        $data = DB::table('search_store')->where(['user_id'=>$user_id])->orderBy('id','desc')->skip(0)->take(5)->get();
            foreach ($data as $val1) {
                        $id = $val1->id;
                        $search_id = $val1->search_id;
                        $string_id = $val1->string_id;
                        $keyword = $val1->keyword; 
                        $new[] = ['id'=>$id,'search_id'=>$search_id,'string_id'=>$string_id,'keyword'=>$keyword,'history'=>true];
                    }
        }
            
        $popular_brand = DB::table('brand')->where(['category_id'=>$category_id,'popular'=>1])->skip(0)->take(10)->get();
                foreach ($popular_brand as $val) {
                    $keyword = $val->name;
                    $data = DB::table('search_engine')->where(['category_id'=>$category_id])->where('keyword','like', '%'.$keyword.'%')->get();
                    foreach ($data as $val1) {
                         $id = $val1->id;
                        $search_id = $val1->search_id;
                        $string_id = $val1->string_id;
                        $keyword = $val1->keyword; 
                        $new[] = ['id'=>$id,'search_id'=>$search_id,'string_id'=>$string_id,'keyword'=>$keyword,'history'=>false];
                    }
                }
        } else {
        $query = DB::table('search_engine')->where('keyword','like', '%'.$keyword.'%')->get();
        foreach ($query as $val) {
            if ($val->category_id==$category_id) {
                    $id = $val->id;
                    $search_id = $val->search_id;
                    $string_id = $val->string_id;
                    $keyword = $val->keyword; 
                    $new[] = ['id'=>$id,'search_id'=>$search_id,'string_id'=>$string_id,'keyword'=>$keyword,'history'=>false];
                } 
            else if ($val->category_id==NULL || $val->category_id=='') {
                    $id = $val->id;
                    $search_id = $val->search_id;
                    $string_id = $val->string_id;
                    $keyword = $val->keyword; 
                    $new[] = ['id'=>$id,'search_id'=>$search_id,'string_id'=>$string_id,'keyword'=>$keyword,'history'=>false];
            }
        }
            
        }
        $output['response']=true;
        $output['message']='Data';
        $output['data'] = $new;
        $output['error'] = "";
        
        return $output;
        
    }
    
    public function search_result (Request $request) {
        $output = [];
        $new = [];
        $category_id = $request->category_id;
        $id = $request->id;
        $keyword = $request->keyword;
        //$skip = $request->skip;
        //$take = $request->take;
        
        if ($id!=0) {
        $data = DB::table('search_engine')->where(['id'=>$id])->first();
        $search_id = $data->search_id;
        $string_id = $data->string_id;
        $keyword = $data->keyword;
        } else {
            $search_id='';
            $string_id ='';
        }

        if ($search_id==1) {
            //brand
            $brand = DB::table('brand')->where(['id'=>$string_id])->first();
            $brand_id = $brand->id;
            $new = Search::search_by_brand($category_id,$brand_id,$keyword);
        } else if ($search_id==2) {
            //model
            $model = DB::table('model')->where(['id'=>$string_id])->first();
            $model_id = $model->id;
            $new = Search::search_by_model($category_id,$model_id,$keyword);
        } else if ($search_id==3) {
            //state
            $state = DB::table('state')->where(['id'=>$string_id])->first();
            $state_id = $state->id;
            $new = Search::search_by_state($category_id,$state_id,$keyword);
        } else if ($search_id==4) {
            //district
            $district = DB::table('district')->where(['id'=>$string_id])->first();
            $district_id = $district->id;
            $new = Search::search_by_district($category_id,$district_id,$keyword);
        } else {
            
            $new = Search::empty_search($category_id,$keyword);
            
        }
        
        $output['response']=true;
        $output['message']='Data';
        $output['data'] = $new;
        $output['error'] = "";
        
        return $output;
        
    } 
    
    public function search_store (Request $request) {
        $output = []; $data=[];
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $search_id = $request->search_id;
        $string_id = $request->string_id;
        $keyword = $request->keyword;
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'keyword' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
        $insert = DB::table('search_store')->insert(['user_id'=>$user_id,'category_id'=>$category_id,'search_id'=>$search_id,'string_id'=>$string_id,'keyword'=>$keyword]);
        $output['response']=true;
        $output['message']='Search Track';
        $output['data'] = '';
        $output['error'] = "";
        }
        return $output;
    }
    
    public function search_history(Request $request) {
        $output= []; $new=[];
        $user_id = $request->user_id;
        $data=[];
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $data = DB::table('search_store')->where(['user_id'=>$user_id])->orderBy('id','desc')->skip(0)->take(5)->get();
            // foreach ($data as $val) {
            //     $id = $val->id;
            //     $category_id = $val->category_id;
            //     $search_id = $val->search_id;
            //     $string_id = $val->string_id;
            //     $keyword = $val->keyword;
                
            //     $new[] = ['id'=>$id,'category_id'=>$category_id,'search_id'=>$search_id,'string_id'=>$string_id,'keyword'=>$keyword]; 
            // }
            $output['response']=true;
            $output['message']='Search History Data';
            $output['data'] = $data;
            $output['error'] = "";
        }
        
        
        return $output;
    }
    
    /*********** push notification ***********/
    public function push_notification_list (Request $request) {
        $output=[];$data=[];
        $user_id = $request->user_id;
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
            $user_data = DB::table('user')->where(['id'=>$user_id])->first();
            $lamguage = $user_data->lamguage;
            
            $data = DB::table('push_notification')->orderBy('id','desc')->where(['language_id'=>$lamguage,'status'=>1])->get();
            
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
           
        }
         return $output;
    }
    
    
    /********** 29-08-2023 subhabrata ********/
    
    
    /********** 31/08/2023 **************/
    public function season (Request $request) {
        $new = [];
        $season = DB::table('season_table')->where(['status'=>1])->get();
        foreach ($season as $val) {
            $id = $val->id;
            $name = $val->name;
            $image = $val->image;
            $status = $val->status;
            $created_at = $val->created_at;
            $updated_at = $val->updated_at;
            
            $new[] = ['db_id'=>$id,'name'=>$name,'image'=>$image,'status'=>$status,'created_at'=>$created_at,'updated_at'=>$updated_at];
            
        }
        
            $output['response']=true;
            $output['message']='Data Season';
            $output['data'] = $new;
            $output['error'] = "";
        return $output;
    }
    
    
    public function season_crop (Request $request) {
        $season_id = $request->season_id;
        
        $db = DB::table('season_crop_table')->where(['season_id'=>$season_id])->get();
        foreach ($db as $val) {
            $id = $val->id;
            $season_id = $val->season_id;
            $cropName = $val->cropName;
            $image = $val->image;
            $status = $val->status;
            $created_at = $val->created_at;
            $updated_at = $val->updated_at;
            
            $new[] = ['id'=>$id,'season_id'=>$season_id,'cropName'=>$cropName,'image'=>$image,'status'=>$status,'created_at'=>$created_at,'updated_at'=>$updated_at];
            
        }
            $output['response']=true;
            $output['message']='Data Season Crop';
            $output['data'] = $new;
            $output['error'] = "";
        return $output;
    }
    
    
    /********** company ***********/
    public function company (Request $request) {
        
        $tractor = DB::table('company')->where('category',1)->orderBy('sequence','desc')->where('status',1)->get();
        $good_vehicle = DB::table('company')->where('category',3)->orderBy('sequence','desc')->where('status',1)->get();
        $harvester = DB::table('company')->where('category',4)->orderBy('sequence','desc')->where('status',1)->get();
        $implements = DB::table('company')->where('category',5)->orderBy('sequence','desc')->where('status',1)->get();
        $seeds = DB::table('company')->where('category',6)->orderBy('sequence','desc')->where('status',1)->get();
        $pesticides = DB::table('company')->where('category',8)->orderBy('sequence','desc')->where('status',1)->get();
        $fertilizer = DB::table('company')->where('category',9)->orderBy('sequence','desc')->where('status',1)->get();
        $tyres = DB::table('company')->where('category',7)->orderBy('sequence','desc')->where('status',1)->get();
        
        $new[] = ['Tractor'=>$tractor,'Good Vehicle'=>$good_vehicle,'Harvester'=>$harvester,'Implements'=>$implements,'seeds'=>$seeds,'pesticides'=>$pesticides,'fertilizer'=>$fertilizer,
        'Tyres'=>$tyres];
        
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $new;
            $output['error'] = "";
        return $output;
    }
    
    public function company_products (Request $request) {
        $new=[];
        $company_id = $request->company_id;
        
        $validator = Validator::make($request->all(), [
            'company_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = '';
            $output['error'] = "Validation error!";
        } else {
            $get = DB::table('company_product')->where(['company_id'=>$company_id,'status'=>1])->get();
            foreach ($get as $val) {
                $id = $val->id;
                $category_id = $val->category_id;
                $company_logo = asset('storage/company/'.DB::table('company')->where(['id'=>$company_id])->value('logo'));
                if ($company_id==1 || $company_id==11 || $company_id==12) {
                    $product_image = asset('storage/iffco/products/'.$val->product_image);
                } else {
                    $product_image = asset('storage/company/products/'.$val->product_image);
                }
                $product_name = $val->product_name;
                $description = $val->description;
                $price = $val->price;
                $status = $val->status;
                $type = $val->type;
                $subtype = $val->subtype;
                $company_id = $val->company_id;
                $main_company_id = DB::table('company')->where(['id'=>$company_id])->value('company_id');
                $company_id = $val->company_id;
                
                $new[] = ['id'=>$id,'category_id'=>$category_id,'company_logo'=>$company_logo,'product_image'=>$product_image,'product_name'=>$product_name,'description'=>$description,
                'price'=>$price,'type'=>$type,'subtype'=>$subtype,'company_id'=>$company_id,'main_company_id'=>$main_company_id];
            }
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $new;
            $output['error'] = "";
        
        }
        return $output;
    }
    
    public function company_tracking (Request $request) {
        $company_id = $request->company_id;
        $user_id = $request->user_id;
        $call_status = $request->call_status;
        $dealership_id = $request->dealership_id;
        $product_id = $request->product_id;
        
        $insert = DB::table('company_leads')->insert(['company_id'=>$company_id,'user_id'=>$user_id,'call_status'=>$call_status,'dealership_id'=>$dealership_id,'product_id'=>$product_id]);
        if ($insert) {
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $insert;
            $output['error'] = "";
        }
        return $output;
    }
    
    public function products_category_id (Request $request) {
        $new=[];
        $category_id = $request->category_id;
        
        $validator = Validator::make($request->all(), [
            'category_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = '';
            $output['error'] = "Validation error!";
        } else {
            $get = DB::table('company_product')->where(['category_id'=>$category_id,'status'=>1])->orderByRaw("RAND()")->get();
            foreach ($get as $val) {
                $id = $val->id;
                $category_id = $val->category_id;
                
                $product_name = $val->product_name;
                $description = $val->description;
                $price = $val->price;
                $status = $val->status;
                $type = $val->type;
                $subtype = $val->subtype;
                $company_id = $val->company_id;
                $main_company_id = DB::table('company')->where(['id'=>$company_id])->value('company_id');
                
                $company_logo = asset('storage/company/'.DB::table('company')->where(['id'=>$company_id])->value('logo'));
                if ($company_id==1 || $company_id==11 ||$company_id==12) {
                    $product_image = asset('storage/iffco/products/'.$val->product_image);
                } else {
                    $product_image = asset('storage/company/products/'.$val->product_image);
                }
                
                $new[] = ['id'=>$id,'category_id'=>$category_id,'product_image'=>$product_image,'product_name'=>$product_name,'description'=>$description,'price'=>$price,'type'=>$type,'subtype'=>$subtype,
                'main_company_id'=>$main_company_id,'company_id'=>$company_id,'company_logo'=>$company_logo];
            }
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $new;
            $output['error'] = "";
        
        }
        return $output;
    }
    
    public function company_dealer (Request $request) {
        $new=[];
        $company_id = $request->company_id;
        
        $validator = Validator::make($request->all(), [
            'company_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = '';
            $output['error'] = "Validation error!";
        } else {
            $get = DB::table('user')->where(['company_id'=>$company_id,'status'=>1])->get();
            foreach ($get as $val) {
                $id = $val->id;
                $name = $val->name;
                $company_name = $val->company_name;
                $gst_no = $val->gst_no;
                $mobile = $val->mobile;
                $email = $val->email;
                $address = $val->address;
                $country_id = $val->country_id;
                $state_id = $val->state_id;
                $district_id = $val->district_id;
                $city_id = $val->city_id;
                $zipcode = $val->zipcode;
                $lat = $val->lat;
                $long = $val->long;
                
                
                
                $new[] = ['id'=>$id,'name'=>$name,'company_name'=>$company_name,'gst_no'=>$gst_no,'mobile'=>$mobile,'email'=>$email,'address'=>$address,'state_id'=>$state_id,'district_id'=>$district_id,
                'city_id'=>$city_id,'zipcode'=>$zipcode,'lat'=>$lat,'long'=>$long];
            }
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $new;
            $output['error'] = "";
        
        }
        return $output;
    }
    
    
    public function notification_counter (Request $request) {
        $output=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $params = $request->params;
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = '';
            $output['error'] = "Validation error!";
        } else {
            
         $autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        
        if ($autn>0) {
                
                if ($params=='add') {
                DB::table('user')->where(['id'=>$user_id])->update(['notification_counter' => \DB::raw('notification_counter+1')]);
                $output['response']=true;
                $output['message']='Notification Added Successfully';
                $output['data'] = DB::table('user')->where(['id'=>$user_id])->value('notification_counter');
                $output['error'] = "";
            } else if ($params=='clear') {
                DB::table('user')->where(['id'=>$user_id])->update(['notification_counter' => 0]);
                $output['response']=true;
                $output['message']='Notification Clear Successfully';
                $output['data'] = DB::table('user')->where(['id'=>$user_id])->value('notification_counter');
                $output['error'] = "";
            } else {
                $output['response']=true;
                $output['message']='Get Notification';
                $output['data'] = DB::table('user')->where(['id'=>$user_id])->value('notification_counter');
                $output['error'] = ""; 
            }
        
        } else {
        
        
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = '';
            $output['error'] = "";
            
        }
        
    }
    return $output;
    }
    
    public function notification_open_count(Request $request) {
        $output=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $notification_id = $request->notification_id;
        
        $validator = Validator::make($request->all(), [
            //'user_id' => 'required',
            //'user_token' => 'required'
            'notification_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = '';
            $output['error'] = "Validation error!";
        } else {
            
            $count = DB::table('push_notification')->where(['id'=>$notification_id])->update(['open_count'=>\DB::raw('open_count+1')]);
            $output['response']=true;
            $output['message']='Get Count';
            $output['data'] = DB::table('push_notification')->where(['id'=>$notification_id])->value('open_count');
            $output['error'] = ""; 
            
        }
        return $output;
    }
    
    //Dibyendu Change
    public function filterByCategory(Request $request){
      //print_r($request->all());
        $stateId       = $request->stateId;
        $districtId    = $request->districtId;
        $yom           = $request->yom;
        $brandId       = $request->brandId;
        $userId        = $request->userId;
        $categoryId    = $request->categoryId;

        if(empty($request->type) || $request->type == null){
            $type = "new";
        }else{
          $type   = $request->type;
        }

        $min_price    = $request->min_price;
        $max_price    = $request->max_price;
        $skip         = $request->skip;
        $take         = $request->take;


        $state_length      = count($stateId);
        $district_length   = count($districtId);
        // $min_length        = count($min_price);
        // $max_length        = count($max_price);
        $year_of_perches   = count($yom);
        $brand_length      = count($brandId);

        
        if($state_length > 0 || $district_length > 0 || $year_of_perches > 0 || $brand_length > 0) {
        
            $stateId        = $request->stateId;
            $districtId     = $request->districtId;
            $yom            = $request->yom;
            $min_price      = $request->min_price;
            $max_price      = $request->max_price;
            $brandId        = $request->brandId;
            $userId         = $request->userId;

            if($categoryId == 1){
                if($type == 'rent'){
                    $sql = DB::table('tractorView')->orderBy('id','desc')->whereIn('status',[1,4]);
                }else{
                    $sql = DB::table('tractorView')->where('set','sell')->orderBy('id','desc')->whereIn('status',[1,4]);
                }
            }
            if($categoryId == 3){
                if($type == 'rent'){
                    $sql = DB::table('goodVehicleView')->orderBy('id','desc')->whereIn('status',[1,4]);
                }else{
                    $sql = DB::table('goodVehicleView')->where('set','sell')->orderBy('id','desc')->whereIn('status',[1,4]);
                }
            }
            if($categoryId == 4){
                if($type == 'rent'){
                    $sql = DB::table('harvesterView')->orderBy('id','desc')->whereIn('status',[1,4]);
                }else{
                    $sql = DB::table('harvesterView')->where('set','sell')->orderBy('id','desc')->whereIn('status',[1,4]);
                }
            }
            if($categoryId == 5){
                if($type == 'rent'){
                    $sql = DB::table('implementView')->orderBy('id','desc')->whereIn('status',[1,4]);
                }else{
                    $sql = DB::table('implementView')->where('set','sell')->orderBy('id','desc')->whereIn('status',[1,4]);
                }

            }
            if($categoryId == 6){
                $sql = DB::table('seedView')->orderBy('id','desc')->whereIn('status',[1,4]);
            }
            if($categoryId == 7){
                $sql = DB::table('tyresView')->orderBy('id','desc')->whereIn('status',[1,4]);
            }
            if($categoryId == 8){
                $sql = DB::table('pesticidesView')->orderBy('id','desc')->whereIn('status',[1,4]);
            }
            if($categoryId == 9){
                $sql = DB::table('fertilizerView')->orderBy('id','desc')->whereIn('status',[1,4]);
            }

        
            if (isset($request->stateId)) {
                $state          = $request->stateId;
                $state_length   = count($state);
                if($state_length > 0){
                    $sql->whereIn('state_id', $request->stateId);
                }
            }
            if (isset($request->districtId)) {
                $district          = $request->districtId;
                $district_length   = count($district);
                if($district_length > 0){
                    $sql->whereIn('district_id', $request->districtId);
                }
            }
            if ($min_price && $max_price){

                $min          = $request->min_price;
                $max          = $request->max_price;
                // $min_length   = count($min);
                // $max_length   = count($max);

                $sql->whereBetween('price', [$min,$max]); 
            }
            if (isset($request->yom)) {
                $length          = $request->yom;
                $year_of_perches = count($length);

                if($year_of_perches == 1){
                    $year = [2016,2015,2014,2013,2012,2011,2010,2009,2008,2007,2006,2005,2004,2003,2002,2001,2000,1999,1998,1997,1996,1995,1994,1993,1992,1991,1990];
                    $sql->whereIn('year_of_purchase', $year);
                }
                else if($year_of_perches > 1){
                    $sql->whereIn('year_of_purchase', $request->yom);
                }
            }
            if (isset($request->brandId)) {
                if($categoryId == 1 || $categoryId == 3 || $categoryId == 4 || $categoryId == 5 || $categoryId == 7){
                    $brand          = $request->brandId;
                    $brand_length   = count($brand);
                    if($brand_length > 0){
                        $sql->whereIn('brand_id', $request->brandId);
                    }
                }
            }

            if($type == 'rent'){
                $sql->where('set', $type);
            }
            if($type == 'old' || $type == 'new'){
                $sql->where('type', $type);
            }
            if(isset($skip)){
                $sql->skip($skip);
            }
            if(isset($take)){
                $sql->take($take);
            }

            $sql1 = $sql->get();

            return $sql1;
        }else{

            $userId = $request->userId; 
            $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
            //$userPinCode    = 700026;
            $pindata    = DB::table('city')->where(['pincode'=>$userPinCode])->first();
            $latitude   = $pindata->latitude;
            $longitude  = $pindata->longitude;

            if($categoryId == 1){
                if($type == 'rent'){
                //  $sql = DB::table('tractorView')->where('pincode',$pincode)->orderBy('id','desc')->whereIn('status',[1,4]);
                    $sql = DB::table('tractorView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(tractorView.latitude))
                            * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(tractorView.latitude))) AS distance"))
                            ->whereIn('status',[1,4]);
                }else{
                //  echo $type;
                    $sql = DB::table('tractorView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tractorView.latitude))
                        * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tractorView.latitude))) AS distance"))
                        ->where('set','sell')
                        ->whereIn('status',[1,4]);
                    }
            }
            else if($categoryId == 3){
                if($type == 'rent'){
                    $sql = DB::table('goodVehicleView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(goodVehicleView.latitude))
                            * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(goodVehicleView.latitude))) AS distance"))
                            ->whereIn('status',[1,4]);
                }else{
                    $sql = DB::table('goodVehicleView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(goodVehicleView.latitude))
                            * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(goodVehicleView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->whereIn('status',[1,4]);
                }
            }
            else if($categoryId == 4){
                if($type == 'rent'){
                    //$sql = DB::table('harvesterView')->where('pincode',$pincode)->orderBy('id','desc')->whereIn('status',[1,4]);
                    $sql = DB::table('harvesterView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(harvesterView.latitude))
                            * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(harvesterView.latitude))) AS distance"))
                            ->whereIn('status',[1,4]);
                }else{
                    $sql = DB::table('harvesterView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(harvesterView.latitude))
                            * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(harvesterView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->whereIn('status',[1,4]);
                }
            }
            else if($categoryId == 5){
                if($type == 'rent'){
                    $sql = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4]);
                }else{
                    $sql = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->where('set','sell')
                        ->whereIn('status',[1,4]);

                }
            }
            else if($categoryId == 6){
                $sql = DB::table('seedView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(seedView.latitude))
                        * cos(radians(seedView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(seedView.latitude))) AS distance"))
                        ->whereIn('status',[1,4]);
            }
            else if($categoryId == 7){
                //$sql = DB::table('tyresView')->where('pincode',$pincode)->orderBy('id','desc')->whereIn('status',[1,4]);
                $sql = DB::table('tyresView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tyresView.latitude))
                        * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tyresView.latitude))) AS distance"))
                        ->whereIn('status',[1,4]);
            }
            else if($categoryId == 8){
                $sql = DB::table('pesticidesView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(pesticidesView.latitude))
                        * cos(radians(pesticidesView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(pesticidesView.latitude))) AS distance"))
                        ->whereIn('status',[1,4]);
            }
            else if($categoryId == 9){
                $sql = DB::table('fertilizerView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(fertilizerView.latitude))
                        * cos(radians(fertilizerView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(fertilizerView.latitude))) AS distance"))
                        ->whereIn('status',[1,4]);
            }

            if($type == 'rent'){
                $sql->where('set', $type);
            }
            if($type == 'old' || $type == 'new'){
                $sql->where('type', $type);
            }
            if(isset($skip)){
                $sql->skip($skip);
            }
            if(isset($take)){
                $sql->take($take);
            }

            $sql1 = $sql->get();

            return $sql1;

        }
    }
    
    
    public function choose_user_type (Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $user_type = $request->user_type;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        } else {
            
            $count = DB::table('user')->where(['id'=>$user_id,'user_type_id'=>$user_type])->count();
            if ($count>0) {
                $output['response']=false;
                $output['message']='Data Already Updated';
                $output['data'] = '';
                $output['error'] = ""; 
            } else {
                $update = DB::table('user')->where(['id'=>$user_id])->update(['user_type_id'=>$user_type]);
                if ($update) {
                    $output['response']=true;
                    $output['message']='Data Updated';
                    $output['data'] = $update;
                    $output['error'] = ""; 
                }
            }
            
        }
        return $output;
    }
    
    public function app_open_record (Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        } else {
            
            $date=date('Y-m-d');
            $time=date('H:i:s');
            $datetime = date('Y-m-d H:i:s');
            $insert = DB::table('login_activity')->insert(['user_id'=>$user_id,'date'=>$date,'time'=>$time,'datetime'=>$datetime]);
            $update = DB::table('user')->where(['id'=>$user_id])->update(['last_activity'=>$datetime]);
            
            if ($update) {
                $output['response']=true;
                $output['message']='Activity For Home Page';
                $output['data'] = $insert;
                $output['error'] = "";
            }
            
        }
        return $output;
        
    }
    
    
}
