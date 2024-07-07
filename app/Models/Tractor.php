<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\Rent_tractor;
use App\Models\Goods_vehicle;
use App\Models\Harvester;
use App\Models\User as Userss;


class Tractor extends Model
{
    use HasFactory;
    protected $table = 'tractor';
    
    protected $fillable = [
        'id',
        'category_id',
        'user_id',
        'set',
        'type',
        'brand_id',
        'model_id',
        'title',
        'year_of_purchase',
        'rc_available',
        'noc_available',
        'registration_no',
        'description',
        'left_image',
        'right_image',
        'front_image',
        'back_image',
        'meter_image',
        'tyre_image',
        'price',
        'is_negotiable',
        'country_id',
        'state_id',
        'district_id',
        'city_id',
        'pincode',
        'latlong',
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
        //dd($where);
        $new=[];
        $count = DB::table('tractor')->orderBy('id','desc')->where($where)->count();
        if ($count>0) {
            $array_tractor_model = DB::table('tractor')->orderBy('id','desc')->where($where)->get();
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
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {

                    // $data['photo'] = env('APP_URL')."storage/photo/$user_details->photo";
                    $data['photo'] = asset("storage/photo/$user_details->photo");

                $data['photo'] = asset("storage/photo/$user_details->photo");

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
                //$data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id_db,'category_id'=>1,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                // foreach ($datas as $data) {
                //     $data->boosted=[];
                //     $product_id = $data->id;
                //     $data->boosted = DB::table('subscribed_boosts')
                //                     ->where(['product_id'=>$product_id])->first();
                // }
                
                
                $data['view_lead'] = Leads_view::where(['category_id'=>1,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $new[] = $data;
            
            }
        }
        return $new; 
    }

    protected function get_data_by_where_my_post ($where) {
        $new=[];
        $count = DB::table('tractor')->orderBy('id','desc')->where('id',$where)->count();
        if ($count>0) {
            $array_tractor_model = DB::table('tractor as t')
                                       ->select('t.id','t.*')
                                       ->join('user as u','u.id','=','t.user_id')
                                       ->join('state as s','s.id','=','t.state_id')
                                       ->join('district as d','d.id','=','t.district_id')
                                       ->join('city as c','c.id','=','t.city_id')
                                       ->orderBy('t.id','desc')
                                       ->where('t.user_id',$where)
                                       ->get();

            //dd($array_tractor_model);

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
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                    // $data['photo'] = env('APP_URL')."storage/photo/$user_details->photo";
                    $data['photo'] = asset("storage/photo/$user_details->photo");

                $data['photo'] = asset("storage/photo/$user_details->photo");

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
                //$data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id_db,'category_id'=>1,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                
                
                $data['view_lead'] = Leads_view::where(['category_id'=>1,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $new[] = $data;
            
            }
        }
        return $new; 
    }
    
    
    protected function get_notification_data_by_where ($where,$user_id_db) {
        $new=[];
        $data=[];
        $count = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where($where)->count();
        if ($count>0) {
            $array_tractor_model = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where($where)->get();
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
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/$user_details->photo");
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id_db,'category_id'=>1,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $data['view_lead'] = Leads_view::where(['category_id'=>1,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $u_data = Userss::where(['id'=>$user_id_db,'status'=>1])->first();
                $data['lead_name'] = $u_data->name;
                $data['lead_mobile'] = $u_data->mobile;
                $data['lead_email'] = $u_data->email;
                
                //$new[] = $data;
            
            }
        }
           return $data; 
        
    }
    
    protected function get_notification_data_by_where1 ($where,$user_id_db,$viewed_user_id) {
        $new=[];
        $data=[];
        $count = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where($where)->count();
        if ($count>0) {
            $array_tractor_model = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where($where)->get();
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
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/$user_details->photo");
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id_db,'category_id'=>1,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $data['view_lead'] = Leads_view::where(['category_id'=>1,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $u_data = Userss::where(['id'=>$viewed_user_id,'status'=>1])->first();
                $data['lead_name'] = $u_data->name;
                $data['lead_mobile'] = $u_data->mobile;
                $data['lead_email'] = $u_data->email;
                
                //$new[] = $data;
            
            }
        }
           return $data; 
        
    }
    
    protected function get_filter_data_by_where ($user_id,$set,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price_start,$price_end,$skip,$take) {
        $new=[];
        $data = [];
        //if ($price_filter=='' || $price_filter==NULL) {$var_x = 'id'; $var_y = $order_filter; $build='->';} else {$var_x = 'price'; $var_y = $price_filter;$build='->';}
        
      /*  if ($set=='' || $set==NULL) {$var_set = 'whereIn'; $var_set_col='set'; $where_set=['sell','rent'];} else {$var_set='where'; $var_set_col='set'; $where_set=$set;}
        if ($type=='' || $type==NULL) {$var_type = 'whereIn'; $var_type_col='type'; $where_type=['old','new'];} else {$var_type='where'; $var_type_col='type'; $where_type=$where_type;}
        
        if ($where_brand=='' || $where_brand==NULL) { $var_brand = 'orwhere'; } else {$var_brand='where';}
        if ($where_model=='' || $where_model==NULL) { $var_model = 'orwhere'; } else {$var_model='where';}
        if ($purchase=='' || $purchase==NULL) { $var_purchase = 'orwhere'; } else {$var_purchase='where';}
       // if ($price_start=='' || $price_start==NULL) {$orwhereBetween = 'orwhereBetween';$price_start=0; $price_end=0;} else {$orwhereBetween = 'whereBetween';$price_start=$price_start; $price_end=$price_end;}
        
        
            $array_tractor_model = DB::table('tractor')
                                    ->where('state_id',$where_state)
                                    ->where('district_id',$where_district)
                                    ->$var_set($var_set_col,$where_set)
                                    ->$var_type($var_type_col,$where_type)
                                    ->$var_brand('brand_id',$where_brand)
                                    ->$var_model('model_id',$where_model)
                                    ->$var_purchase('year_of_purchase',$purchase)
                                    ->$orwhereBetween('price',[$price_start,$price_end])
                                    ->skip($skip)
                                    ->take($take)
                                    ->where('status',1)
                                    ->get();
             */
             
            $query = DB::table('tractor')->orderBy('id','desc')->where('status',1);
            $state_array = explode (',',$where_state);
            if ($where_state!='') {
                $query->whereIn('state_id', $state_array);
            }
            $district_array = explode (',',$where_district);
            if ($where_district!='') {
                $query->whereIn('district_id', $district_array);
            }
            //$set_array = explode (',',$set);
            //if ($set=='buy') {array_push($set_array,"sell");}
            //else if ($set_array[1]=='buy') {array_push($set_array,"sell");}
            //print_r($set_array);
            if ($set!='') {
                if ($set=='buy') {$set='sell';}
                //$query->whereIn('set', $set_array);
                $query->where('set', $set);
            }
            $type_array = explode (',',$type);
            if ($type!='') {
                $query->whereIn('type', $type_array);
            }
            $brand_array = explode (',',$where_brand);
            if ($where_brand!='') {
                $query->whereIn('brand_id', $brand_array);
            }
            $model_array = explode (',',$where_model);
            if ($where_model!='') {
                $query->whereIn('model_id', $model_array);
            }
            $purchase_array = explode (',',$purchase);
            if ($purchase!='') {
                $query->whereIn('year_of_purchase', $purchase_array);
            }
            if ($price_start && $price_end) {
                $query->whereBetween('price', [$price_start,$price_end]);
            }
            
            $array_tractor_model = $query->skip($skip)->take($take)->get();
            //$new['count'] = count($array_tractor_model);
                                    
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
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/$user_details->photo");
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
                
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $data['view_lead'] = Leads_view::where(['category_id'=>1,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>1,'item_id'=>$val->id])->count();
                
                $new[] = $data;
            
            }
           return $new; 
        
    }
    
    protected function tractor_single ($id,$user_id) {
        $data=[];
            $count = DB::table('tractor')->where(['id'=>$id])->count();
            if ($count>0) {
            
            $val = DB::table('tractor')->where(['id'=>$id])->first();
            
                $data['id'] = $val->id;
                $data['category_id'] = $val->category_id;
                $data['user_id'] = $val->user_id;
                $user_count = DB::table('user')->where(['id'=>$val->user_id])->count();
                if($user_count > 0){
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

                }
                
                $data['set'] = $val->set;
                $data['type'] = $val->type;
                $data['brand_id'] = $val->brand_id;
                $data['model_id'] = $val->model_id;
                $data['title'] = $val->title;

                
                $specification=[];
                $spec_count = DB::table('specifications')->where(['model_id'=>$val->model_id])->count();
                if ($spec_count>0) {
                
                $specification_arr = DB::table('specifications')->where(['model_id'=>$val->model_id])->get();
                foreach ($specification_arr as $val_s) {
                    $spec_name = $val_s->spec_name;
                    $spec_value = $val_s->value;
                    
                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                }
                $data['specification'] = $specification;
                } else {
                $data['specification'] = [];
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>1,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                // $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['created_at'] = $val->created_at;
                $data['updated_at'] = $val->updated_at;
                
            
            }
            return $data;
    }
     
    protected function tractor_data ($user_id,$type,$pincode,$district,$state,$app_section,$skip,$take) {
        $where_pincode = ['pincode'=>$pincode];
        $where_district = ['district_id'=>$district];
        $where_state = ['state_id'=>$state];
        $city_array = $first = DB::table('city')->where(['pincode'=>$pincode])->first();
        $cityid  = $city_array->id;
        $latitude1  = $city_array->latitude;
        $longitude1 = $city_array->longitude;
        $district_id_u = $city_array->district_id;
        
        if ($app_section=='viewall') {
            $offset = $skip;
            $limit = $take;
        } else {
            $offset = $skip;
            $limit = $take;
        }
        
        $new=[];
            
            $q1 = DB::table('tractorView')
                    ->select('*'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude1. "))
                    * cos(radians(tractorView.latitude))
                    * cos(radians(tractorView.longitude) - radians(" .$longitude1. "))
                    + sin(radians(" .$latitude1. "))
                    * sin(radians(tractorView.latitude))) AS distance"))
                    ->where('set','sell')
                    ->where('type',$type)
                    ->whereIn('status',[1,4])
                    ->orderBy('distance','asc')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();
            foreach ($q1 as $val) {
                $data['distance'] = $val->distance;
                $data['id'] = $val->id;
                $data['category_id'] = $val->category_id;
                $data['user_id'] = $val->user_id;
                
                $user_details = DB::table('user')->where(['id'=>$val->user_id])->first();
               // dd($user_details);
              //  $user_type_id = $user_details->user_type_id;
                //dd($user_type_id);
              //   $data['user_type_id'] = $user_type_id;
                // $data['role_id'] = $user_details->role_id;
                // $data['name'] = $user_details->name;
                // $data['company_name'] = $user_details->company_name;
                // $data['mobile'] = $user_details->mobile;
                // $data['email'] = $user_details->email;
                // $data['gender'] = $user_details->gender;
                // $data['address'] = $user_details->address;
                // $data['zipcode'] = $user_details->zipcode;
                // $data['device_id']  = $user_details->device_id;
                // $data['firebase_token']  = $user_details->firebase_token;
                // $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                // if ($user_details->photo=='NULL' || $user_details->photo=='') {
                //     $data['photo']='';
                // } else {
                // $data['photo'] = asset("storage/photo/$user_details->photo";
                // }

                
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>1,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->tractor_latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                
                
                $data['view_lead'] = Leads_view::where(['category_id'=>1,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $new[] = $data;
            
            }
            
            
            
            
           return $new; 
               
           
    }
    
    protected function tractor_data_rent ($user_id,$type,$pincode,$district,$state,$app_section,$skip,$take) {
        
        $where_pincode = ['pincode'=>$pincode];
        $where_district = ['district_id'=>$district];
        $where_state = ['state_id'=>$state];
        $city_array = $first = DB::table('city')->where(['pincode'=>$pincode])->first();
        $cityid  = $city_array->id;
        $latitude1  = $city_array->latitude;
        $longitude1 = $city_array->longitude;
        $district_id_u = $city_array->district_id;
        
        if ($app_section=='viewall') {
            $offset = $skip;
            $limit = $take;
        } else {
            $offset = $skip;
            $limit = $take;
        }
        
        $new=[];
            $q1 = DB::table('tractorView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude1. "))
                * cos(radians(tractorView.latitude))
                * cos(radians(tractorView.longitude) - radians(" .$longitude1. "))
                + sin(radians(" .$latitude1. "))
                * sin(radians(tractorView.latitude))) AS distance"))
                ->where('set',$type)
                ->whereIn('status',[1,4])
                ->orderBy('distance','asc')
                ->offset($offset)
                ->limit($limit)
                ->paginate(100);
                // echo $q1->count();
            foreach ($q1 as $val) {
                $data['distance'] = $val->distance;
                $data['id'] = $val->id;
                $data['category_id'] = $val->category_id;
                $data['user_id'] = $val->user_id;
               // dd($val->user_id);
            
                $user_details = DB::table('user')->where('id',$val->user_id)->first();
               // dd($user_details->user_type_id);
                // $data['user_type_id'] = $user_details->user_type_id;
                // $data['role_id'] = $user_details->role_id;
                // $data['name'] = $user_details->name;
                // $data['company_name'] = $user_details->company_name;
                // $data['mobile'] = $user_details->mobile;
                // $data['email'] = $user_details->email;
                // $data['gender'] = $user_details->gender;
                // $data['address'] = $user_details->address;
                // $data['zipcode'] = $user_details->zipcode;
                // $data['device_id']  = $user_details->device_id;
                // $data['firebase_token']  = $user_details->firebase_token;
                // $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                // if ($user_details->photo=='NULL' || $user_details->photo=='') {
                //     $data['photo']='';
                // } else {
                // $data['photo'] = asset("storage/photo/$user_details->photo";
                // }
                
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>1,'item_id'=>$val->id])->count();
                $data['latlong'] = $val->tractor_latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                
                $data['view_lead'] = Leads_view::where(['category_id'=>1,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>1,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $new[] = $data;
            
            }
            
            
           return $new; 
               
           
    
    }
    
    protected function tractor_category_page () {
        $array=[];
        $banner_d = DB::table('settings')->where(['status'=>'tractor_category_page_banner'])->get();
        foreach ($banner_d as $val) {
            $db_id = $val->id;
            $name = $val->name;
            $value = $val->value;
            $status = $val->status;
            $banner[] = ['db_id'=>$db_id,'name'=>$name,'banner'=>$value,'status'=>$status];
        }
        
        $icons_d = DB::table('settings')->where(['status'=>'tractor_category_page_icon'])->get();
        foreach ($icons_d as $val) {
            $db_id = $val->id;
            $name = $val->name;
            $value = $val->value;
            $status = $val->status;
           $icons[] = ['db_id'=>$db_id,'name'=>$name,'icons'=>$value,'status'=>$status];
        }
         
        $array['banner'] = $banner;
        $array['icons'] = $icons;
        return $array;
    }
    
    protected function search_tractor_brand ($brand_id,$keyword) {
            
            $count = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where(['brand_id'=>$brand_id])->orWhere('title','like', '%'.$keyword.'%')->count();
            if ($count>0) {
            $tractor = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where(['brand_id'=>$brand_id])->orWhere('title','like', '%'.$keyword.'%')->get();
            foreach ($tractor as $val) {
                
                $data['id'] = $val->id;
                $data['category_id'] = $val->category_id;
                $data['user_id'] = $val->user_id;
                $user_count = DB::table('user')->where(['id'=>$val->user_id])->count();
                if( $user_count > 0){
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
                    $data['device_id']  = $user_details->device_id;
                    $data['firebase_token']  = $user_details->firebase_token;
                    $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                    if ($user_details->photo=='NULL' || $user_details->photo=='') {
                        $data['photo']='';
                    } else {
                    $data['photo'] = asset("storage/photo/$user_details->photo");
                    }
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
                
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                
                $new[] = $data;
            
            }
            return $new; 
            }
    }
    
    protected function search_tractor_model ($brand_id,$model_id,$keyword) {
            $count = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where(['model_id'=>$model_id])->orWhere(['brand_id'=>$brand_id])->orWhere('title','like', '%'.$keyword.'%')->count();
            if ($count>0) {
            $tractor = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where(['model_id'=>$model_id])->orWhere(['brand_id'=>$brand_id])->orWhere('title','like', '%'.$keyword.'%')->get();
            foreach ($tractor as $val) {
                
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
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/$user_details->photo");
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
                
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                
                $new[] = $data;
            
            }
            
            return $new; 
            }
    }
    
    protected function search_tractor_state ($state_id,$keyword) {
            $count = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where(['state_id'=>$state_id])->orWhere('title','like', '%'.$keyword.'%')->count();
            if ($count>0) {
            $tractor = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where(['state_id'=>$state_id])->orWhere('title','like', '%'.$keyword.'%')->get();
            foreach ($tractor as $val) {
                
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
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/$user_details->photo");
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
                
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                
                $new[] = $data;
            
            }
            
            return $new; 
            }
    }
    
    protected function search_tractor_district ($district_id,$keyword) {
            $count = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where(['district_id'=>$district_id])->orWhere('title','like', '%'.$keyword.'%')->count();
            if ($count>0) {
            $tractor = DB::table('tractor')->orderBy('id','desc')->where('status',1)->where(['district_id'=>$district_id])->orWhere('title','like', '%'.$keyword.'%')->get();
            foreach ($tractor as $val) {
                
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
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/$user_details->photo");
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
                
                $data['latlong'] = $val->latlong;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                
                $new[] = $data;
            
            }
            
            return $new; 
            }
    }


    
    /** Dibyendu Change 22.09.2023 */
    protected function tractor_new($type ,$pincode){
        $pinDataCity  = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude1    = $pinDataCity->latitude;
        $longitude1   = $pinDataCity->longitude;
        //dd($type);
        $tractor_sell_new = DB::table('tractorView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude1. "))
                            * cos(radians(tractorView.latitude))
                            * cos(radians(tractorView.longitude) - radians(" .$longitude1. "))
                            + sin(radians(" .$latitude1. "))
                            * sin(radians(tractorView.latitude))) AS distance"))
                            ->orderBy('distance','asc')
                            ->whereIn('status',[1,4])
                            ->where('set','sell')
                            ->where('type','new')
                            ->paginate(5);

      //  dd($tractor_sell_new);

        return $tractor_sell_new;

    }

    /** Dibyendu Change 22.09.2023 */
    protected function tractor_old($type ,$pincode){
        $pinDataCity  = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude1    = $pinDataCity->latitude;
        $longitude1   = $pinDataCity->longitude;
        //dd($type);
        $tractor_sell_old = DB::table('tractorView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude1. "))
                            * cos(radians(tractorView.latitude))
                            * cos(radians(tractorView.longitude) - radians(" .$longitude1. "))
                            + sin(radians(" .$latitude1. "))
                            * sin(radians(tractorView.latitude))) AS distance"))
                            ->orderBy('distance','asc')
                            ->whereIn('status',[1,4])
                            ->where('set','sell')
                            ->where('type','old')
                            ->paginate(5);

      //  dd($tractor_sell_new);

        return $tractor_sell_old;

    }

     /** Dibyendu Change 22.09.2023 */
    protected function tractor_rent($type ,$pincode){
        $pinDataCity  = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude1    = $pinDataCity->latitude;
        $longitude1   = $pinDataCity->longitude;
        //dd($type);
        $tractor_sell_rent = DB::table('tractorView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude1. "))
                            * cos(radians(tractorView.latitude))
                            * cos(radians(tractorView.longitude) - radians(" .$longitude1. "))
                            + sin(radians(" .$latitude1. "))
                            * sin(radians(tractorView.latitude))) AS distance"))
                            ->orderBy('distance','asc')
                            ->whereIn('status',[1,4])
                            ->where('set','rent')
                            ->paginate(5);

      //  dd($tractor_sell_new);

        return $tractor_sell_rent;

    }
    
    
}
