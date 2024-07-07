<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Mail\LaraEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Api_model;
use App\Models\user;
use App\Models\Tractor;
use App\Models\Rent_tractor;
use App\Models\Goods_vehicle;
use App\Models\Harvester;
use App\Models\Implement;
use App\Models\Tyre;
use App\Models\Seed;
use App\Models\pesticides;
use App\Models\fertilizers;



class FilterBKController extends Controller
{
    //

    public function tractor_filter (Request $request) {
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $set = $request->set;
        $type = $request->type;
        $state = $request->state;
        $district = $request->district;
        $brand = $request->brand;
        $model = $request->model;
        $purchase_year = $request->purchase_year;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        
        //$price_filter = $request->price_filter;
        //$order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
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
            
            
            $where_type = $type;
            $where_state = $state;
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            $purchase = $purchase_year;
            //print_r($where_district);
            $data = Tractor::get_filter_data_by_where($user_id,$set,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price_start,$price_end,$skip,$take);
            //$data['count'] = count($data);
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    }
    
    public function rent_tractor_filter (Request $request) {
        $output = [];
        $data=[];
        $new=[];
        
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $set = $request->set;
        $type = $request->type;
        $state = $request->state;
        $district[] = $request->district;
        $brand[] = $request->brand;
        $model[] = $request->model;
        $purchase_year[] = $request->purchase_year;
        $price[] = $request->price;
        $skip = $request->skip;
        $take = $request->take;
        
        $price_filter = $request->price_filter;
        $order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
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
            
            $where_type = ['type'=>$type];
            $where_state = ['state_id'=>$state];
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            $purchase = $purchase_year;
            $price = $price;
            //print_r($where_district);
            $data = Rent_tractor::get_filter_data_by_where($user_id,$set,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price,$skip,$take,$price_filter,$order_filter);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    }
    
    public function goods_vehicle_filter (Request $request) {
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $set = $request->set;
        $type = $request->type;
        $state = $request->state;
        $district = $request->district;
        $brand = $request->brand;
        $model = $request->model;
        $purchase_year = $request->purchase_year;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        
        //$price_filter = $request->price_filter;
        //$order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
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
            
            $where_type = $type;
            $where_state = $state;
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            $purchase = $purchase_year;
            //print_r($where_district);
            $data = Goods_vehicle::get_filter_data_by_where($user_id,$set,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    }
    
    public function harvester_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $set = $request->set;
        $type = $request->type;
        $state = $request->state;
        $district = $request->district;
        $brand = $request->brand;
        $model = $request->model;
        $purchase_year = $request->purchase_year;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        //$price_filter = $request->price_filter;
        //$order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
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
            
            $where_type = $type;
            $where_state = $state;
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            $purchase = $purchase_year;
            //print_r($where_district);
            $data = Harvester::get_filter_data_by_where($user_id,$set,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    public function implements_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $set = $request->set;
        $type = $request->type;
        $state = $request->state;
        $district = $request->district;
        $brand = $request->brand;
        $model = $request->model;
        $purchase_year = $request->purchase_year;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        
        //$price_filter = $request->price_filter;
        //$order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
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
            
            $where_type = $type;
            $where_state = $state;
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            $purchase = $purchase_year;
            //print_r($where_district);
            $data = Implement::get_filter_data_by_where($user_id,$set,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$purchase,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    public function tyre_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $type = $request->type;
        $state = $request->state;
        $district = $request->district;
        $brand = $request->brand;
        $model = $request->model;
        //$purchase_year = $request->purchase_year;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        
        //$price_filter = $request->price_filter;
        //$order_filter = $request->order_filter;
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
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
            
            $where_type = $type;
            $where_state = $state;
            $where_district = $district;
            $where_brand = $brand;
            $where_model = $model;
            //$purchase = $purchase_year;
            //print_r($where_district);
            $data = Tyre::get_filter_data_by_where($user_id,$type,$where_type,$where_state,$where_district,$where_brand,$where_model,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    public function seed_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $state = $request->state;
        $district = $request->district;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
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
            
            $where_state = $state;
            $where_district = $district;
            //print_r($where_district);
            $data = Seed::get_filter_data_by_where($user_id,$where_state,$where_district,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    public function pesticides_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $state = $request->state;
        $district = $request->district;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
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
            
            $where_state = $state;
            $where_district = $district;
            //print_r($where_district);
            $data = pesticides::get_filter_data_by_where($user_id,$where_state,$where_district,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }
    
    public function fertilizers_filter (Request $request) {
        
        $output = [];
        $data=[];
        $new=[];
        $district=[];
   
        $user_id = $request->user_id;
        $user_token = $request->user_token; 
        $state = $request->state;
        $district = $request->district;
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $skip = $request->skip;
        $take = $request->take;
        
        
        $Autn = Userss::where(['id'=>$user_id,'token'=>$user_token])->count();
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
            
            $where_state = $state;
            $where_district = $district;
            //print_r($where_district);
            $data = fertilizers::get_filter_data_by_where($user_id,$where_state,$where_district,$price_start,$price_end,$skip,$take);
            
        }
       
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $data;
            $output['error'] = "";
       
        
        return $output;
    
    }



}
