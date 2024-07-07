<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Validator,Redirect,Response;

class PincodeController extends Controller
{
    /** Edit Page Pincode Page */
    public function editPinCodePage($cityId){
        $cityDetails   = DB::table('city')->orderBy('id','desc')->where('status',1)->paginate(10);
        $state         = DB::table('state')->where('country_id',1)->get();
        $editCity      = DB::table('city')->where('id',$cityId)->first();
        
        $countryId     =  $editCity->country_id;
        $country_name  = DB::table('country')->where('id',$countryId)->first()->country_name;

        $stateId     =  $editCity->state_id;
        $state_name  = DB::table('state')->where('id',$stateId)->first()->state_name;

        $districtId    =  $editCity->district_id;
        $district_name = DB::table('district')->where('id',$districtId)->first()->district_name;

        $city_name     =  $editCity->city_name;

        return view('admin.pin_update.pin_edit',['state'=>$state , 'city'=>$cityDetails ,'editCity'=>$editCity , 'country_name' => $country_name, 'state_name' => $state_name, 'district_name' => $district_name , 'city_name' => $city_name]);
    }

    /** Add PinCode Page */
    public function addPinCode(Request $request){
      //  dd($request->all());
        $country_id  = $request->country_id;
        $state_id    = $request->state_id;
        $district_id = $request->district_id;
        $city_name   = $request->city_name;
        $pincode     = $request->pincode;
        $lattitude   = $request->lattitude;
        $longitude   = $request->longitude;
       
        $state = DB::table('state')->where('country_id',1)->get();
        $cityDetails = DB::table('city')->orderBy('id','desc')->where('status',1)->paginate(10);
        $pincode_count = DB::table('city')->where('pincode',$request->pincode)->count();
       // dd($pincode_count);

        if($pincode_count == 0){
            $insert = DB::table('city')->insert([
                'pincode'      => $pincode,
                'city_name'    => $city_name,
                'region_id'    => 1,
                'country_id'   => $country_id,
                'state_id'     => $state_id,
                'district_id'  => $district_id,
                'latitude'     => $lattitude , 
                'longitude'    => $longitude,
                'status'       => 1,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now()
           ]);

           return view("admin.pin_update.pin_update" , ['message' => 'Successfully' ,'state'=>$state , 'city'=>$cityDetails]);
        }
        else {
            return view("admin.pin_update.pin_update" , ['message' => 'Successfully', 'state'=>$state , 'city'=>$cityDetails]);

        }


       //return Redirect::to("krishi-add-pincode");

    }


    /** Update PinCode Page */
    public function updatePinCode(Request $request , $cityId){
        //dd($request->all());
        
        $pincode      = $request->pincode;
        $lattitude    = $request->lattitude;
        $longitude    = $request->longitude;

        $state = DB::table('state')->where('country_id',1)->get();
        $cityDetails = DB::table('city')->orderBy('id','desc')->where('status',1)->paginate(10);

        $update = DB::table('city')->where('id',$cityId)->update([
            'pincode'      => $pincode,
            'latitude'     => $lattitude , 
            'longitude'    => $longitude,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now()
        ]);

       return Redirect::to("krishi-add-pincode");
    }

    /** Delete Pincode  */
    public function deletePincode($cityId){
        //dd($cityId);
        $state = DB::table('state')->where('country_id',1)->get();
        $cityDetails = DB::table('city')->orderBy('id','desc')->where('status',1)->paginate(10);
        $city_count = DB::table('city')->where('id',$cityId)->count(); 
        //dd( $city_count);
        
        if($city_count > 0){
            $city = DB::table('city')->where('id',$cityId)->first();
            $status = $city->status;
            //dd($status);

            $update = DB::table('city')->where('id',$cityId)->update([
                'status'    => 0,
            ]);

        
        }
        return Redirect::to("krishi-add-pincode");

    }


    /** District Name in Add Pin code Page */
    public function getDistrictName(Request $request){
       // echo "hi";
        $state_id = $request->state_id;
         
        $district = DB::table('district')->where('state_id',$request->state_id)->where('status',1)->get();
        $data =[];
        foreach($district as $key => $d){
            $data[$key] = ['id' =>$d->id ,'district_name' =>$d->district_name];
        }
       
        return $data;

    }

    /** city Name in Add Pin code Page */
    public function getCityName(Request $request){
        $district_id = $request->district_id;
         
        $city = DB::table('city')->where('district_id',$request->district_id)->where('status',1)->get();
        $data =[];
        foreach($city as $key => $c){
            $data[$key] = ['id' =>$c->id ,'city_name' => $c->city_name];
        }
        
        return $data;
    }
}
