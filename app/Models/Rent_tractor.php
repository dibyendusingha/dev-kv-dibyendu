<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\Tractor;
use App\Models\Goods_vehicle;
use App\Models\Harvester;
use App\Models\User as Userss;

class Rent_tractor extends Model
{
    
    use HasFactory;
    protected $table = 'rent_tractor';
    
    protected $fillable = [
        'id',
        'category_id',
        'user_id',
        'type',
        'brand_id',
        'model_id',
        'year_of_purchase',
        'rc_available',
        'description',
        'spec_id',
        'left_image',
        'right_image',
        'front_image',
        'back_image',
        'meter_image',
        'tyre_image',
        'rent_type',
        'price',
        'is_negotiable',
        'pincode',
        'country_id',
        'state_id',
        'district_id',
        'city_id',
        'latlong',
        'is_featured',
        'valid_till',
        'ad_report',
        'status',
        'created_at',
        'updated_at',
        'reason_for_rejection',
        'rejected_by',
        'rejected_at',
        'approved_by',
        'approved_at'
        ];
    
    protected function get_data_by_where ($where) {
        $array_rent_tractor_model = DB::table('rent_tractor')->orderBy('id','desc')->where($where)->get();
            foreach ($array_rent_tractor_model as $val) {
                
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
                $data['photo'] = env('APP_URL')."storage/photo/$user_details->photo";
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
                    $data['left_image'] = env('APP_URL')."/storage/tractor/$val->left_image"; 
                }
                if ($val->right_image=='' || $val->right_image=='NULL') { 
                    $data['right_image'] = '';
                } else {
                    $data['right_image'] = env('APP_URL')."/storage/tractor/$val->right_image"; 
                }
                if ($val->front_image=='' || $val->front_image=='NULL') { 
                    $data['front_image'] = '';
                } else {
                    $data['front_image'] = env('APP_URL')."/storage/tractor/$val->front_image"; 
                }
                if ($val->back_image=='' || $val->back_image=='NULL') { 
                    $data['back_image'] = '';
                } else {
                    $data['back_image'] = env('APP_URL')."/storage/tractor/$val->back_image"; 
                }
                if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                    $data['meter_image'] = '';
                } else {
                    $data['meter_image'] = env('APP_URL')."/storage/tractor/$val->meter_image"; 
                }
                if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                    $data['tyre_image'] = '';
                } else {
                    $data['tyre_image'] = env('APP_URL')."/storage/tractor/$val->tyre_image"; 
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
                $data['created_at'] = $val->created_at;
                $data['updated_at'] = $val->updated_at;
                
                
                $data['view_lead'] = Leads_view::where(['category_id'=>1,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $new[] = $data;
            
            }
            
            return $new;
    }
    
    
    protected function get_notification_data_by_where ($where,$user_id_db) {
        $array_rent_tractor_model = DB::table('rent_tractor')->orderBy('id','desc')->where($where)->get();
            foreach ($array_rent_tractor_model as $val) {
                
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
                $data['photo'] = env('APP_URL')."storage/photo/$user_details->photo";
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
                    $data['left_image'] = env('APP_URL')."/storage/tractor/$val->left_image"; 
                }
                if ($val->right_image=='' || $val->right_image=='NULL') { 
                    $data['right_image'] = '';
                } else {
                    $data['right_image'] = env('APP_URL')."/storage/tractor/$val->right_image"; 
                }
                if ($val->front_image=='' || $val->front_image=='NULL') { 
                    $data['front_image'] = '';
                } else {
                    $data['front_image'] = env('APP_URL')."/storage/tractor/$val->front_image"; 
                }
                if ($val->back_image=='' || $val->back_image=='NULL') { 
                    $data['back_image'] = '';
                } else {
                    $data['back_image'] = env('APP_URL')."/storage/tractor/$val->back_image"; 
                }
                if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                    $data['meter_image'] = '';
                } else {
                    $data['meter_image'] = env('APP_URL')."/storage/tractor/$val->meter_image"; 
                }
                if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                    $data['tyre_image'] = '';
                } else {
                    $data['tyre_image'] = env('APP_URL')."/storage/tractor/$val->tyre_image"; 
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
                $data['created_at'] = $val->created_at;
                $data['updated_at'] = $val->updated_at;
                
                
                $data['view_lead'] = Leads_view::where(['category_id'=>2,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>2,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>2,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $u_data = Userss::where(['id'=>$user_id_db,'status'=>1])->first();
                $data['lead_name'] = $u_data->name;
                $data['lead_mobile'] = $u_data->mobile;
                $data['lead_email'] = $u_data->email;
                //$new[] = $data;
            
            }
            //print_r($data);
            return $data;
    }
    
     protected function get_filter_data_by_where ($user_id,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price_start,$price_end,$skip,$take,$price_filter,$order_filter) 
     {
        $new=[];
        
            $array_tractor_model = DB::table('rent_tractor')
                                    ->orderBy('id',$order_filter)
                                    ->orderBy('price',$price_filter)
                                    ->where($where_type)
                                    ->where($where_state)
                                    ->orwhereIn('district_id',$where_district)
                                    ->orwhereIn('brand_id',$where_brand)
                                    ->orwhereIn('model_id',$where_model)
                                    ->orwhereIn('year_of_purchase',$purchase)
                                    ->whereBetween('price',[$price_start,$price_end])
                                    ->skip($skip)
                                    ->take($take)
                                    ->get();
            foreach ($array_tractor_model as $val) {
                
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
                $data['photo'] = env('APP_URL')."storage/photo/$user_details->photo";
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
                    $data['left_image'] = env('APP_URL')."/storage/tractor/$val->left_image"; 
                }
                if ($val->right_image=='' || $val->right_image=='NULL') { 
                    $data['right_image'] = '';
                } else {
                    $data['right_image'] = env('APP_URL')."/storage/tractor/$val->right_image"; 
                }
                if ($val->front_image=='' || $val->front_image=='NULL') { 
                    $data['front_image'] = '';
                } else {
                    $data['front_image'] = env('APP_URL')."/storage/tractor/$val->front_image"; 
                }
                if ($val->back_image=='' || $val->back_image=='NULL') { 
                    $data['back_image'] = '';
                } else {
                    $data['back_image'] = env('APP_URL')."/storage/tractor/$val->back_image"; 
                }
                if ($val->meter_image=='' || $val->meter_image=='NULL') { 
                    $data['meter_image'] = '';
                } else {
                    $data['meter_image'] = env('APP_URL')."/storage/tractor/$val->meter_image"; 
                }
                if ($val->tyre_image=='' || $val->tyre_image=='NULL') { 
                    $data['tyre_image'] = '';
                } else {
                    $data['tyre_image'] = env('APP_URL')."/storage/tractor/$val->tyre_image"; 
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
                $data['created_at'] = $val->created_at;
                $data['updated_at'] = $val->updated_at;
                
                
                $data['view_lead'] = Leads_view::where(['category_id'=>1,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $data['view_lead'] = Leads_view::where(['category_id'=>1,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $u_data = Userss::where(['id'=>$user_id_db,'status'=>1])->first();
                $data['lead_name'] = $u_data->name;
                $data['lead_mobile'] = $u_data->mobile;
                $data['lead_email'] = $u_data->email;
                $new[] = $data;
            
            }
           return $new; 
        
    }

}
