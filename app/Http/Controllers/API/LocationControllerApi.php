<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LocationControllerApi extends Controller
{
    //
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

    /** PinCode Wish State, District & City Get  */
    public function pincode_wish_data_show(Request $request){
        $pincode = $request->pincode;
        $pin1 = substr($pincode, 0, 2);
        $pin2 = substr($pincode, 0, 3);
        
        $pincode_two_count   = DB::table('pincode_tracking')->where('code',$pin1)->count();
        $pincode_three_count = DB::table('pincode_tracking')->where('code',$pin2)->count();
        $data= [];

        $validator = Validator::make($request->all(), [
            'pincode' => 'required|size:6',
        ]);

        if ($validator->fails()) {
            $output['response']=false;
            $output['error_code']=403;
            $output['message']='Validation error!';
            $output['data'] = '';
            $output['error'] = $validator->errors();
        }
        else if($pincode_two_count > 0 || $pincode_three_count > 0){
            if($pincode_two_count > 0){
                $pincode_details = DB::table('pincode_tracking')->where('code',$pin1)->first();
                $state_id = $pincode_details->state_id;
    
                $state_details = DB::table('state')->where('id',$state_id)->first();
                $state_name = $state_details->state_name;
    
                $district_details = DB::table('district')->where('state_id',$state_id)->where('status',1)->get();
                foreach($district_details as $key =>$district){
                    $district_id    =  $district->id;
                    $district_name  = $district->district_name;
                    $state_id       =  $district->state_id;

                    $city_details  = DB::table('city')->where('state_id',$state_id)->where('district_id',$district->id)->where('status',1)->get();
                    foreach($city_details as $key1=> $city){
                        $city_id   = $city->id;
                        $city_name = $city->city_name;
            
                        $city_data[$key1]    = ['city_id'=>$city_id ,'city_name'=>$city_name];
                        $district_data[$key] = ['district_id' => $district_id,'district_name'=>$district_name,'city'=>$city_data];
                    }
                }
                $data = ['pincode'=> $request->pincode , 'state_id'=>$state_id , 'state_name'=>$state_name , 'district'=>$district_data];
                
                if(!empty($data)){
                    $output['response'] = true;
                    $output['message']  = 'Pincode Wish State,District';
                    $output['data']     = $data;
                    $output['error']    = "";
                }
            }
            else if($pincode_three_count > 0){
                $pincode_details = DB::table('pincode_tracking')->where('code',$pin2)->first();
                $state_id = $pincode_details->state_id;
    
                $state_details = DB::table('state')->where('id',$state_id)->first();
                $state_name = $state_details->state_name;
    
                $district_details = DB::table('district')->where('state_id',$state_id)->get();
                foreach($district_details as $key =>$district){
                    $district_id    =  $district->id;
                    $district_name  = $district->district_name;
                    $state_id       =  $district->state_id;

                    $city_details  = DB::table('city')->where('state_id',$state_id)->where('district_id',$district->id)->get();
                    foreach($city_details as $key1=> $city){
                        $city_id   = $city->id;
                        $city_name = $city->city_name;
            
                        $city_data[$key1]    = ['city_id'=>$city_id ,'city_name'=>$city_name];
                        $district_data[$key] = ['district_id' => $district_id,'district_name'=>$district_name,'city'=>$city_data];
                    }
                }
                $data = ['pincode'=> $request->pincode , 'state_id'=>$state_id , 'state_name'=>$state_name , 'district'=>$district_data];
                
                if(!empty($data)){
                    $output['response'] = true;
                    $output['message']  = 'Pincode Wish State,District';
                    $output['data']     = $data;
                    $output['error']    = "";
                }
            }
            else{
                $output['response'] = false;
                $output['message']  = 'Invalid Pincode';
                $output['data']     = [];
                $output['error']    = "";
            }
            // return $output;
        }else{
            $output['response'] = false;
            $output['message']  = 'Invalid Pincode';
            $output['data']     = [];
            $output['error']    = "";

        }

        return $output;
        
    }

    /** Add Pincode With Login */
    public function add_pincode_with_login(Request $request){

        $pincode     = $request->pincode;
        $city_name   = $request->city_name;
        $district_id = $request->district_id;
        $state_id    = $request->state_id;
        $latitude    = $request->latitude;
        $longitude   = $request->longitude;

        $city_count = DB::table('city')->where('pincode',$request->pincode)->count();
        if($city_count == 0){
            $insert=  DB::table('city')->insert(
                array(
                    'pincode'     => $request->pincode,
                    'city_name'   => $request->city_name,
                    'region_id'   => 1,
                    'country_id'  => 1,
                    'state_id'    => $state_id,
                    'district_id' => $district_id,
                    'latitude'    => $latitude,
                    'longitude'   => $longitude,
                    'status'      => 1,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now()
                )
            );

            if($insert){
                return array('response'=> true ,'message'=>'Successfully Added');
            }else{
                return array('response'=> false ,'message'=>'Unsuccessfully');
            }
        }else{
            return array('response'=> false ,'message'=>'Already Have Pincode');
        }
    }

}
