<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\Tractor;
use App\Models\Rent_tractor;
use App\Models\Goods_vehicle;
use App\Models\User as Userss;

class Seed extends Model
{
    use HasFactory;
     protected $table = 'seeds';
     
     protected $fillable = [
        'id',
        'category_id',
        'user_id',
        'title',
        'description',
        'price',
        'is_negotiable',
        'image1',
        'image2',
        'image3',
        'country_id',
        'state_id',
        'district_id',
        'city_id',
        'pincode',
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
         $new = [];
        $count = DB::table('seeds')->orderBy('id','desc')->where($where)->count();
        if ($count>0) {
        $array_seed_model = DB::table('seeds')->orderBy('id','desc')->where($where)->get();
            foreach ($array_seed_model as $val) {
                
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
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/seeds/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/seeds/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/seeds/$val->image3"); 
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
                
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $data['view_lead'] = Leads_view::where(['category_id'=>6,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>6,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>6,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $new[] = $data;
                
                
            }
        }
            return $new;
    }

    # For My Post List
    protected function get_data_by_where_my_post ($where) {
        $new = [];
        $count = DB::table('seeds')->orderBy('id','desc')->where('id',$where)->count();
        if ($count>0) {
        $array_seed_model = DB::table('seeds')->orderBy('id','desc')->where('id',$where)->get();
           foreach ($array_seed_model as $val) {
               
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
                    // $data['photo'] = env('APP_URL')."storage/photo/$user_details->photo";
                    $data['photo'] = asset("storage/photo/$user_details->photo");
                }
               
               $data['title'] = $val->title;
               $data['price'] = $val->price;
               $data['description'] = $val->description;
               if ($val->image1=='' || $val->image1=='NULL') { 
                   $data['left_image'] = '';
               } else {
                   $data['left_image'] = asset("storage/seeds/$val->image1"); 
               }
               if ($val->image2=='' || $val->image2=='NULL') { 
                   $data['right_image'] = '';
               } else {
                   $data['right_image'] = asset("storage/seeds/$val->image2"); 
               }
               if ($val->image3=='' || $val->image3=='NULL') { 
                   $data['front_image'] = '';
               } else {
                   $data['front_image'] = asset("storage/seeds/$val->image3"); 
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
               
               $data['pincode'] = $val->pincode;
               $data['latlong'] = $val->latlong;
               $data['is_featured'] = $val->is_featured;
               $data['valid_till'] = $val->valid_till;
               $data['ad_report'] = $val->ad_report;
               $data['status'] = $val->status;
               $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
               $data['updated_at'] = $val->updated_at;
               
               $data['view_lead'] = Leads_view::where(['category_id'=>6,'post_id'=>$val->id])->count();
               $data['call_lead'] = Lead::where(['category_id'=>6,'post_id'=>$val->id,'calls_status'=>1])->count();
               $data['msg_lead'] = Lead::where(['category_id'=>6,'post_id'=>$val->id,'messages_status'=>1])->count();
               
               $new[] = $data;
               
               
           }
        }
        return $new;
    }
    
    protected function get_notification_data_by_where ($where,$user_id_db) {
        $data=[];
        $count = DB::table('seeds')->orderBy('id','desc')->where('status',1)->where($where)->count();
        if ($count>0) {
        $array_seed_model = DB::table('seeds')->orderBy('id','desc')->where('status',1)->where($where)->get();
            foreach ($array_seed_model as $val) {
                
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
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/seeds/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/seeds/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/seeds/$val->image3"); 
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id_db,'category_id'=>6,'item_id'=>$val->id])->count();
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                
                $data['view_lead'] = Leads_view::where(['category_id'=>6,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>6,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>6,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                
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
        $data=[];
        $count = DB::table('seeds')->orderBy('id','desc')->where('status',1)->where($where)->count();
        if ($count>0) {
        $array_seed_model = DB::table('seeds')->orderBy('id','desc')->where('status',1)->where($where)->get();
            foreach ($array_seed_model as $val) {
                
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
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/seeds/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/seeds/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/seeds/$val->image3"); 
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id_db,'category_id'=>6,'item_id'=>$val->id])->count();
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                
                $data['view_lead'] = Leads_view::where(['category_id'=>6,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>6,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>6,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                
                $u_data = Userss::where(['id'=>$viewed_user_id,'status'=>1])->first();
                $data['lead_name'] = $u_data->name;
                $data['lead_mobile'] = $u_data->mobile;
                $data['lead_email'] = $u_data->email;
                
                //$new[] = $data;
                
                
            }
        }
            return $data;
    }
     
     protected function get_filter_data_by_where ($user_id,$where_state,$where_district,$price_start,$price_end,$skip,$take) {
        $new=[];
        $data = [];
        
        
        if ($price_start=='' || $price_start==NULL) {$orwhereBetween = 'orwhereBetween';$price_start=0; $price_end=0;} else {$orwhereBetween = 'whereBetween';$price_start=$price_start; $price_end=$price_end;}
        
       
            /*$array_model = DB::table('seeds')
                                    ->where('state_id',$where_state)
                                    ->where('district_id',$where_district)
                                    ->$orwhereBetween('price',[$price_start,$price_end])
                                    ->skip($skip)
                                    ->take($take)
                                    ->get();
            */
            $query = DB::table('seeds')->orderBy('id','desc')->where('status',1);
            $state_array = explode (',',$where_state);
            if ($where_state!='') {
                $query->whereIn('state_id', $state_array);
            }
            $district_array = explode (',',$where_district);
            if ($where_district!='') {
                $query->whereIn('district_id', $district_array);
            }
            if ($price_start && $price_end) {
                $query->whereBetween('price', [$price_start,$price_end]);
            }
            $array_model = $query->skip($skip)->take($take)->get();
            //$new['count'] =count($array_model);                  
            foreach ($array_model as $val) {
                
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
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/seeds/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/seeds/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/seeds/$val->image3"); 
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>6,'item_id'=>$val->id])->count();
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
           return $new; 
        
    }
    
    protected function seed_single ($id,$user_id) {
            $count = DB::table('seeds')->where(['id'=>$id])->count();
            if ($count>0) {
            
            $val = DB::table('seeds')->where(['id'=>$id])->first();
            
                
                
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
                
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/seeds/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/seeds/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/seeds/$val->image3"); 
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>6,'item_id'=>$val->id])->count();
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                // $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['created_at'] = $val->created_at;
                $data['updated_at'] = $val->updated_at;
            }
            return $data;
        
        
    }
        
    
    protected function seeds_data ($user_id,$pincode,$district,$state,$app_section,$skip,$take) {
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
        
        
        $q1 = DB::table('seedView')
                    ->select('*'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude1. "))
                    * cos(radians(seedView.latitude))
                    * cos(radians(seedView.longitude) - radians(" .$longitude1. "))
                    + sin(radians(" .$latitude1. "))
                    * sin(radians(seedView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('distance','asc')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();
                    
        foreach ($q1 as $val) {
                $data['distance'] = round($val->distance);
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
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/seeds/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/seeds/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/seeds/$val->image3"); 
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
                
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>6,'item_id'=>$val->id])->count();
                
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $data['view_lead'] = Leads_view::where(['category_id'=>6,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>6,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>6,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $new[] = $data;
                
                
            }
                    
                    
        
            
           return $new;
    }
    
    protected function seeds_category_page () {
        $array=[];
        $banner_d = DB::table('settings')->where(['status'=>'seed_category_page_banner'])->get();
        foreach ($banner_d as $val) {
            $db_id = $val->id;
            $name = $val->name;
            $value = $val->value;
            $status = $val->status;
            $banner[] = ['db_id'=>$db_id,'name'=>$name,'banner'=>$value,'status'=>$status];
        }
        
        $icons_d = DB::table('settings')->where(['status'=>'seed_category_page_icon'])->get();
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
    
    protected function search_seed_brand ($keyword) {
            $count = DB::table('seeds')->orderBy('id','desc')->where('status',1)->orwhere('title','like', '%'.$keyword.'%')->count();
            if ($count>0) {
            $seed = DB::table('seeds')->orderBy('id','desc')->where('status',1)->orwhere('title','like', '%'.$keyword.'%')->get();
            foreach ($seed as $val) {
                
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
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/seeds/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/seeds/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/seeds/$val->image3"); 
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
            return $new;
            }
    }
    
    protected function search_seed_model ($keyword) {
            $count = DB::table('seeds')->orderBy('id','desc')->where('status',1)->orwhere('title','like', '%'.$keyword.'%')->count();
            if ($count>0) {
            $seed = DB::table('seeds')->orderBy('id','desc')->where('status',1)->orwhere('title','like', '%'.$keyword.'%')->get();
            foreach ($seed as $val) {
                
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
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/seeds/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/seeds/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/seeds/$val->image3"); 
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
            return $new;
            }
    }
    
    protected function search_seed_state ($state_id,$keyword) {
            $count = DB::table('seeds')->orderBy('id','desc')->where('status',1)->where(['state_id'=>$state_id])->orwhere('title','like', '%'.$keyword.'%')->count();
            if ($count>0) {
            $seed = DB::table('seeds')->orderBy('id','desc')->where('status',1)->where(['state_id'=>$state_id])->orwhere('title','like', '%'.$keyword.'%')->get();
            foreach ($seed as $val) {
                
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
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/seeds/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/seeds/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/seeds/$val->image3"); 
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
            return $new;
            }
    }
    
    protected function search_seed_district ($district_id,$keyword) {
            $count = DB::table('seeds')->orderBy('id','desc')->where('status',1)->where(['district_id'=>$district_id])->orwhere('title','like', '%'.$keyword.'%')->count();
            if ($count>0) {
            $seed = DB::table('seeds')->orderBy('id','desc')->where('status',1)->where(['district_id'=>$district_id])->orwhere('title','like', '%'.$keyword.'%')->get();
            foreach ($seed as $val) {
                
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
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/seeds/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/seeds/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/seeds/$val->image3"); 
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
            return $new;
            }
    }

    /** Dibyendu Change 21.09.2023 */
    protected function seed_new($type ,$pincode){
        $pinDataCity  = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude1    = $pinDataCity->latitude;
        $longitude1   = $pinDataCity->longitude;

        $seed_new = DB::table('seedView')
                    ->select('*'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude1. "))
                    * cos(radians(seedView.latitude))
                    * cos(radians(seedView.longitude) - radians(" .$longitude1. "))
                    + sin(radians(" .$latitude1. "))
                    * sin(radians(seedView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('distance','asc')
                    ->paginate(5);

        return $seed_new;


    }
    
    
}
