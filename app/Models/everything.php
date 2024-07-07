<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class everything extends Model
{
    use HasFactory;

    protected function pincode ($pincode) {
        $response=[];
        $count = DB::table('city')->where(['pincode'=>$pincode])->count();
        if ($count>0) {
        $data = DB::table('city')->where(['pincode'=>$pincode])->first();
        $city_id    = $data->id;
        $city_name  = $data->city_name;
        $country_id = $data->country_id;
        $state_id   = $data->state_id;
        $district_id = $data->district_id;
        $latitude   = $data->latitude;
        $longitude  = $data->longitude;
        $state      = DB::table('state')->where(['id'=>$state_id])->first();
        $state_name = $state->state_name;
        $district   = DB::table('district')->where(['id'=>$district_id])->first();
        $district_name = $district->district_name;
        $country    = DB::table('country')->where(['id'=>$country_id])->first();
        $country_name = $country->country_name;

        $response = array('country_id'=>$country_id,'country_name'=>$country_name,'state_id'=>$state_id,'state_name'=>$state_name,
        'district_id'=>$district_id,'district_name'=>$district_name,'city_id'=>$city_id,'city_name'=>$city_name,
        'latitude'=>$latitude,'longitude'=>$longitude);
        } else {
            $response  = array();
        }
        return $response;
    }
}
