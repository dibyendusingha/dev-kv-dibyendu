<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use DateInterval;

class WeatherController extends Controller
{
    /** Not Required */
    public function weatherReportDays(Request $request){
        //dd($request->all());
  
        // $pincode = $request->session()->get('pincode');
        
        $pindata = DB::table('city')->where(['pincode'=>$request->pincode])->first();
        $lat     = $pindata->latitude;
        $lon     = $pindata->longitude;
        

       // $lat             = $request->latitude;
       // $lon             = $request->longitude;
        // $googleApiUrl    = "api.openweathermap.org/data/2.5/forecast?zip=94040,us&units=metric&appid=6e006453cdb5c4702c7a13de664cd001";
 
 
       // $googleApiUrl    = "api.openweathermap.org/data/2.5/forecast?lat=22.572645&lon=88.363892&units=metric&appid=6e006453cdb5c4702c7a13de664cd001";
        $googleApiUrl    = "api.openweathermap.org/data/2.5/forecast?lat=".$lat."&lon=".$lon."&units=metric&appid=6e006453cdb5c4702c7a13de664cd001";
         $ch =curl_init();
         curl_setopt($ch , CURLOPT_HEADER ,0);
         curl_setopt($ch , CURLOPT_RETURNTRANSFER ,1);
         curl_setopt($ch , CURLOPT_URL ,$googleApiUrl);
         curl_setopt($ch , CURLOPT_FOLLOWLOCATION ,1);
         curl_setopt($ch , CURLOPT_VERBOSE ,0);
         curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);
         $response = curl_exec($ch);
         curl_close($ch);
         $data = json_decode($response);
 
        //dd($data);
 
        $googleApiUrl1 = "https://api.openweathermap.org/data/3.0/onecall?lat=15.2214&lon=78.2231&exclude=minutely,daily&units=metric&appid=2e7f7484c357cc255e76a2835475297d";
        //$googleApiUrl1 = "https://api.openweathermap.org/data/3.0/onecall?lat=".$lat."&lon=".$lon."&exclude=minutely,daily&units=metric&appid=2e7f7484c357cc255e76a2835475297d";
 
         $ch1 =curl_init();
         curl_setopt($ch1 , CURLOPT_HEADER ,0);
         curl_setopt($ch1 , CURLOPT_RETURNTRANSFER ,1);
         curl_setopt($ch1 , CURLOPT_URL ,$googleApiUrl1);
         curl_setopt($ch1 , CURLOPT_FOLLOWLOCATION ,1);
         curl_setopt($ch1 , CURLOPT_VERBOSE ,0);
         curl_setopt($ch1 , CURLOPT_SSL_VERIFYPEER , false);
         $response1 = curl_exec($ch1);
         curl_close($ch1);
         $data1 = json_decode($response1);
 
        //dd($data1);
 
        $var  = Carbon::now('Asia/Kolkata');
        $time = $var->toTimeString();
 
        //dd($time);
        $weather = array();
 
        $weather['city_name'] = $data->city->name;
 
        foreach($data->list as $key => $days){
        
            foreach($days->weather as $key2=> $w){
                //dd($key2);
                if($key <  10){

                $data = array();
                $data = ['temp'=>$days->main->temp , 'temp_min' =>$days->main->temp_min ,
                'temp_max'  => $days->main->temp_max , 'feel-like' => $days->main->feels_like ,
                'weather' => $w->main ,  'description' => $w->description];

                    //print_r($data);
                    // dd($data);


                    // $weather['temp'][$key]         = $days->main->temp;
                    // $weather['temp_min'][$key]     = $days->main->temp_min;
                    // $weather['temp_max'][$key]     = $days->main->temp_max;
                    // $weather['feel-like'][$key]    = $days->main->feels_like;
                    // $weather['weather'][$key]      = $w->main;
                    // $weather['description'][$key]  = $w->description;

                    $weather['days'][$key] = $data;
                }    
            }  
        }
 
        $hourTime = array();

        foreach($data1->hourly as $key => $h){
            foreach($h->weather as $key2 => $w){
                if($key < 24){
                    $time    = $h->dt;
                    $timeCal =  date ( 'H' , $time );

                    if($timeCal < 25){
                        $hour = array();
                        $hour = ['hours'=>$timeCal,'temp' =>$h->temp , 'feels_like' =>$h->feels_like, 'main' =>$w->main , 'description' =>$w->description ];
    
                        $hourTime['hours'][$key] = $hour;

                    }

                    //dd($timeCal);
                // print_r($h);
                }
            }
        }
 
 
        // dd($hourTime);
 
        
        $now      = Carbon::now()->format('Y-m-d');
        $tomorrow = Carbon::now()->tomorrow()->format('Y-m-d');
        
        $date      = new DateTime($tomorrow);
        $nextDate  = $date->add(new DateInterval("P1D"));
        $n1        = $nextDate->format('Y-m-d');
        $day       =  Carbon::parse($n1);
        $dayName1  = $day->format('l');

        $date      = new DateTime($now);
        $nextDate  = $date->add(new DateInterval("P3D"));
        $n2        = $nextDate->format('Y-m-d');
        $day       =  Carbon::parse($n2);
        $dayName2  = $day->format('l');

        $date     = new DateTime($now);
        $nextDate = $date->add(new DateInterval("P4D"));
        $n3       = $nextDate->format('Y-m-d');
        $day      =  Carbon::parse($n3);
        $dayName3 = $day->format('l');

        $date     = new DateTime($now);
        $nextDate = $date->add(new DateInterval("P5D"));
        $n4       = $nextDate->format('Y-m-d');
        $day      =  Carbon::parse($n4);
        $dayName4 = $day->format('l');

        $date     = new DateTime($now);
        $nextDate = $date->add(new DateInterval("P6D"));
        $n5       = $nextDate->format('Y-m-d');$date = new DateTime($now);
        $day      =  Carbon::parse($n5);
        $dayName5 = $day->format('l');

        $date     = new DateTime($now);
        $nextDate = $date->add(new DateInterval("P7D"));
        $n6       = $nextDate->format('Y-m-d');$date = new DateTime($now);
        $day      =  Carbon::parse($n6);
        $dayName6 = $day->format('l');

        $date     = new DateTime($now);
        $nextDate = $date->add(new DateInterval("P8D"));
        $n7       = $nextDate->format('Y-m-d');$date = new DateTime($now);
        $day      =  Carbon::parse($n7);
        $dayName7 = $day->format('l');

        $date     = new DateTime($now);
        $nextDate = $date->add(new DateInterval("P9D"));
        $n8       = $nextDate->format('Y-m-d');$date = new DateTime($now);
        $day      =  Carbon::parse($n8);
        $dayName8 = $day->format('l');


        $date1     = Carbon::parse($tomorrow);
        $nextDate  = $date1->addDay();
        $nextDay   = $nextDate->format('Y-m-d');

        //dd($nextDay);

        $weather['today']    = $now;
        $weather['tomorrow'] = $tomorrow;

        $weather[$dayName1]  = $nextDay;
        $weather[$dayName2]  = $n2;
        $weather[$dayName3]  = $n3;
        $weather[$dayName4]  = $n4;
        $weather[$dayName5]  = $n5;
        $weather[$dayName6]  = $n6;
        $weather[$dayName7]  = $n7;
        $weather[$dayName8]  = $n8;
 
        // dd($nextDay);
       // dd($weather);

       $all = array();
       $all['weather'] = $weather;
       $all['hourTime'] = $hourTime;

       //dd($all);
 
        return $all;
         
    }

    /** Weather Report */
    public function getWeather(Request $request){
      //echo "hi";
        $time    = $request->time;
        $lat     = $request->latitude;
        $lon     = $request->longitude;

        $pindata = DB::table('city')->where(['pincode'=>$request->pincode])->first();
        // $lat     = $pindata->latitude;
        // $lon     = $pindata->longitude;

        $googleApiUrl    = "api.openweathermap.org/data/2.5/forecast?lat=".$lat."&lon=".$lon."&units=metric&appid=6e006453cdb5c4702c7a13de664cd001";
        $ch =curl_init();
        curl_setopt($ch , CURLOPT_HEADER ,0);
        curl_setopt($ch , CURLOPT_RETURNTRANSFER ,1);
        curl_setopt($ch , CURLOPT_URL ,$googleApiUrl);
        curl_setopt($ch , CURLOPT_FOLLOWLOCATION ,1);
        curl_setopt($ch , CURLOPT_VERBOSE ,0);
        curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        $googleApiUrl1 = "https://api.openweathermap.org/data/3.0/onecall?lat=".$lat."&lon=".$lon."&exclude=minutely,daily&units=metric&appid=2e7f7484c357cc255e76a2835475297d";
 
        $ch1 =curl_init();
        curl_setopt($ch1 , CURLOPT_HEADER ,0);
        curl_setopt($ch1 , CURLOPT_RETURNTRANSFER ,1);
        curl_setopt($ch1 , CURLOPT_URL ,$googleApiUrl1);
        curl_setopt($ch1 , CURLOPT_FOLLOWLOCATION ,1);
        curl_setopt($ch1 , CURLOPT_VERBOSE ,0);
        curl_setopt($ch1 , CURLOPT_SSL_VERIFYPEER , false);
        $response1 = curl_exec($ch1);
        curl_close($ch1);
        $data1 = json_decode($response1);

        // $googleApiUrl2    = "https://api.openweathermap.org/data/3.0/onecall?lat=15.2214&lon=78.2231&exclude=minutely,daily,hourly&units=metric&appid=2e7f7484c357cc255e76a2835475297d";
        $googleApiUrl2    = "https://api.openweathermap.org/data/3.0/onecall?lat=".$lat."&lon=".$lon."&exclude=minutely,daily,hourly&units=metric&appid=2e7f7484c357cc255e76a2835475297d";
        $ch2 =curl_init();
        curl_setopt($ch2 , CURLOPT_HEADER ,0);
        curl_setopt($ch2 , CURLOPT_RETURNTRANSFER ,1);
        curl_setopt($ch2 , CURLOPT_URL ,$googleApiUrl2);
        curl_setopt($ch2 , CURLOPT_FOLLOWLOCATION ,1);
        curl_setopt($ch2 , CURLOPT_VERBOSE ,0);
        curl_setopt($ch2 , CURLOPT_SSL_VERIFYPEER , false);
        $response2 = curl_exec($ch2);
        curl_close($ch2);
        $data2 = json_decode($response2);

        $weather = [];

        $sunrise_time1 = $data2->current->sunrise;
        $sunset_time1  = $data2->current->sunset;
        date_default_timezone_set('Asia/Kolkata');
        $sunrise_time = date("h:i:s A", $sunrise_time1);
        $sunset_time  = date("h:i:s A",  $sunset_time1);

        $bar_pressure =  $data2->current->pressure / 1000;

     //  echo $data2->current->weather[0]->description;

       $background_image = null;
       $icon             = null;
       $card_image       = null;
       
       // Night for Current weather
       if($time == '00' || $time == '01' || $time == '02' || $time == '03' || $time == '04' || $time == '19' || $time == '20' || $time == '21' || $time == '22' || $time == '23' || $time == '00' ){
            if($data2->current->weather[0]->description == 'broken clouds'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_Night.gif';
                $background_image  = asset('storage/video/Broken_Clouds_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'clear sky'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/clear+sky_Night.gif';
                $background_image  = asset('storage/video/Clear_Sky_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/Clear_Sky_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'few clouds'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/few+clouds_Night.gif';
                $background_image  = asset('storage/video/Few_Clouds_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/few_clouds_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'mist'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/mist_Night.gif';
                $background_image  = asset('storage/video/Mist_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/mist_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'rain'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/rain_Night.gif';
                $background_image  = asset('storage/video/Rain_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/rain_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'scattered clouds'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/scattered+cloud_n.gif';
                $background_image  = asset('storage/video/Scattered_Cloud_N.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/scattered_clouds_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'shower rain'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/shower+rain_Night.gif';
                $background_image  =  asset('storage/video/Shower_Rain_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/snow_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'snow'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/snow_Night.gif';
                $background_image  =  asset('storage/video/Snow_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/shower_rain_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'thunderstorm'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/thunderstorm_Night.gif';
                $background_image  =  asset('storage/video/Thunderstorm_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/thunderstorm_nghit.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'mist'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/mist_Night.gif';
                $background_image  =  asset('storage/video/Mist_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/mist_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'overcast clouds'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_Night.gif';
                $background_image  =  asset('storage/video/Broken_Clouds_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else if($data2->current->weather[0]->description == 'haze'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_Night.gif';
                $background_image  =  asset('storage/video/Broken_Clouds_Night.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_night.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
            else {
                $background_image  = null;
                $icon              = null;
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
            }
        }
        // Day for Current weather
        else if($time == '05' || $time == '06' || $time == '07' || $time == '08' || $time == '09' || $time == '10' || $time == '11' || $time == '12' || $time == '13' || $time == '14' || $time == '15' || $time == '16' || $time == '17' || $time == '18' ){
            if($data2->current->weather[0]->description == 'broken clouds'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_day.gif';
                $background_image  = asset('storage/video/Broken_Clouds_Day.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else if($data2->current->weather[0]->description == 'clear sky'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/clear+sky_Day.gif';
                $background_image  = asset('storage/video/Clear_Sky_Day.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/Clear_Sky_Day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else if($data2->current->weather[0]->description == 'few clouds'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/few+clouds_day.gif';
                $background_image  = asset('storage/video/Few_Clouds_Day.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/few_clouds_day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else if($data2->current->weather[0]->description == 'mist'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/mist_day.gif';
                $background_image  = asset('storage/video/Mist_Day.mp4'); 
                $icon              = 'https://krishivikas.com/storage/weather/icon/mist_day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else if($data2->current->weather[0]->description == 'rain'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/rain_day.gif';
                $background_image  = asset('storage/video/Rain_Day.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/rain_day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else if($data2->current->weather[0]->description == 'scattered clouds'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/scattered+cloud.gif';
                $background_image  = asset('storage/video/Scattered_Cloud.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/scattered_clouds_day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else if($data2->current->weather[0]->description == 'shower rain'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/shower+rain_day.gif';
                $background_image  = asset('storage/video/Shower_Rain_Day.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/shower_rain_day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else if($data2->current->weather[0]->description == 'snow'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/snow_day.gif';
                $background_image  = asset('storage/video/Snow_Day.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/snow_day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else if($data2->current->weather[0]->description == 'thunderstorm'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/thunderstorm_day.gif';
                $background_image  = asset('storage/video/Thunderstorm_Day.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/thunderstorm_day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else if($data2->current->weather[0]->description == 'overcast clouds'){
                // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_day.gif';
                $background_image  = asset('storage/video/Broken_Clouds_Day.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else if($data2->current->weather[0]->description == 'haze'){
                $background_image  = asset('storage/video/Broken_Clouds_Day.mp4');
                $icon              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_day.png';
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
            else {
                $background_image  = null;
                $icon              = null;
                $card_image        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
            }
        }

        /** Current Data */
        $weather['current'][] =[
                'sunrise'           =>  $sunrise_time, 
                'sunset'            =>  $sunset_time, 
                'temp'              =>  round($data2->current->temp), 
                'feels_like'        =>  round($data2->current->feels_like), 
                'pressure'          =>  $bar_pressure.""."bar", 
                'humidity'          =>  $data2->current->humidity.""."%",
                'wind_speed'        =>  round($data2->current->wind_speed).""."km/h",
                'main'              =>  $data2->current->weather[0]->main, 
                'description'       =>  $data2->current->weather[0]->description,
                'card_image'        =>  $card_image,
                'icon'              =>  $icon,
                "background_image"  =>  $background_image    
        ];
        

        /** 10 Days Data */
        foreach($data->list as $key => $days){
            foreach($days->weather as $key2=> $w){
                if($key <  10){

                   // echo $w->description;
                    // 10 Day for weather
                    $background_image1 = null;
                    $icon1             = null;
                    $card_image1       = null;


                    if( $w->description == 'broken clouds'){
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_day.gif';
                        $background_image1  = asset('storage/video/Broken_Clouds_Day.mp4');
                        $icon1               = 'https://krishivikas.com/storage/weather/icon/broken_clouds_day.png';
                        $card_image1         = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }
                    else if( $w->description == 'clear sky'){
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/clear+sky_Day.gif';
                        $background_image1  = asset('storage/video/Clear_Sky_Day.mp4');
                        $icon1              = 'https://krishivikas.com/storage/weather/icon/Clear_Sky_Day.png';
                        $card_image1        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }
                    else if( $w->description == 'few clouds'){
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/few+clouds_day.gif';
                        $background_image1  = asset('storage/video/Few_Clouds_Day.mp4');
                        $icon1              = 'https://krishivikas.com/storage/weather/icon/few_clouds_day.png';
                        $card_image1        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }
                    else if( $w->description == 'mist'){
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/mist_day.gif';
                        $background_image1  = asset('storage/video/Mist_Day.mp4');
                        $icon1              = 'https://krishivikas.com/storage/weather/icon/mist_day.png';
                        $card_image1        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }
                    else if( $w->description == 'rain'){
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/rain_day.gif';
                        $background_image1  = asset('storage/video/Rain_Day.mp4');
                        $icon1              = 'https://krishivikas.com/storage/weather/icon/rain_day.png';
                        $card_image1        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }
                    else if( $w->description == 'scattered clouds'){
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/scattered+cloud.gif';
                        $background_image1  = asset('storage/video/Scattered_Cloud.mp4');
                        $icon1              = 'https://krishivikas.com/storage/weather/icon/scattered_clouds_day.png';
                        $card_image1        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }
                    else if( $w->description == 'shower rain'){
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/shower+rain_day.gif';
                        $background_image1  = asset('storage/video/Shower_Rain_Day.mp4'); 
                        $icon1              = 'https://krishivikas.com/storage/weather/icon/shower_rain_day.png';
                        $card_image1        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }
                    else if( $w->description == 'snow'){
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/snow_day.gif';
                        $background_image1  = asset('storage/video/Snow_Day.mp4');
                        $icon1              = 'https://krishivikas.com/storage/weather/icon/snow_day.png';
                        $card_image1        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }
                    else if( $w->description == 'thunderstorm'){
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/thunderstorm_day.gif';
                        $background_image1  = asset('storage/video/Thunderstorm_Day.mp4');
                        $icon1              = 'https://krishivikas.com/storage/weather/icon/thunderstorm_day.png';
                        $card_image1        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }
                    else if( $w->description == 'overcast clouds'){
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_day.gif';
                        $background_image1  = asset('storage/video/Broken_Clouds_Day.mp4');
                        $icon1               = 'https://krishivikas.com/storage/weather/icon/broken_clouds_day.png';
                        $card_image1         = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }else {
                        // $background_image1  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_day.gif';
                        $background_image1  = asset('storage/video/Broken_Clouds_Day.mp4');
                        $icon1               = 'https://krishivikas.com/storage/weather/icon/broken_clouds_day.png';
                        $card_image1         = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                    }
                    
                    $data = [
                        'temp'            => round($days->main->temp), 
                        'temp_min'        => round($days->main->temp_min) ,
                        'temp_max'        => round($days->main->temp_max),
                        'feel-like'       => round($days->main->feels_like),
                        'weather'         => $w->main , 
                        'description'     => $w->description,
                        "card_image"      => $card_image1,
                        "icon"            => $icon1,
                        "background_image"=> $background_image1
                    ];
                    $weather['days'][] = $data;
                }    
            } 
        }
   
        /** Hourly Data */
        foreach($data1->hourly as $key => $h){
            foreach($h->weather as $key2 => $w){
                if($key < 24){
                    
                    $background_image2 = null;
                    $icon2             = null;
                    $card_image2       = null;

                    $time    = $h->dt;
                    $timeCal =  date ( 'H' , $time );

                    // Night for Current weather
                    if( $timeCal == '00' ||  $timeCal == '01' ||  $timeCal == '02' ||  $timeCal == '03' ||  $timeCal == '04' ||  $timeCal == '19' ||  $timeCal == '20' ||  $timeCal == '21' ||  $timeCal == '22' ||  $timeCal == '23' ||  $timeCal == '00' ){
                        if($w->description == 'broken clouds'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_Night.gif';
                            $background_image2  = asset('storage/video/Broken_Clouds_Night.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_night.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                        else if($w->description == 'clear sky'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/clear+sky_Night.gif';
                            $background_image2  = asset('storage/video/Clear_Sky_Night.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/Clear_Sky_night.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                        else if($w->description == 'few clouds'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/few+clouds_Night.gif';
                            $background_image2  = asset('storage/video/Few_Clouds_Night.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/few_clouds_night.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                        else if($w->description == 'mist'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/mist_Night.gif';
                            $background_image2  = asset('storage/video/Mist_Night.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/mist_night.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                        else if($w->description == 'rain'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/rain_Night.gif';
                            $background_image2  = asset('storage/video/Rain_Night.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/rain_night.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                        else if($w->description == 'scattered clouds'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/scattered+cloud_n.gif';
                            $background_image2  = asset('storage/video/Scattered_Cloud_N.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/scattered_clouds_night.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                        else if($w->description == 'shower rain'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/shower+rain_Night.gif';
                            $background_image2  = asset('storage/video/Shower_Rain_Night.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/snow_night.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                        else if($w->description == 'snow'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/snow_Night.gif';
                            $background_image2  = asset('storage/video/Snow_Night.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/shower_rain_night.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                        else if($w->description == 'thunderstorm'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/thunderstorm_Night.gif';
                            $background_image2  = asset('storage/video/Thunderstorm_Night.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/thunderstorm_nghit.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                        else if($w->description == 'mist'){
                            // $background_image  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/mist_Night.gif';
                            $background_image2  = asset('storage/video/Mist_Night.mp4');
                            $icon2             = 'https://krishivikas.com/storage/weather/icon/mist_night.png';
                            $card_image2       = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                        else if($w->description == 'overcast clouds'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_Night.gif';
                            $background_image2  = asset('storage/video/Broken_Clouds_Night.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_night.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }else{
                            $background_image2  = asset('storage/video/Broken_Clouds_Night.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_night.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_night.png';
                        }
                    }

                    // Day for Current weather
                    else if( $timeCal == '05' ||  $timeCal == '06' ||  $timeCal == '07' ||  $timeCal == '08' ||  $timeCal == '09' ||  $timeCal == '10' ||  $timeCal == '11' ||  $timeCal == '12' ||  $timeCal == '13' ||  $timeCal == '14' ||  $timeCal == '15' ||  $timeCal == '16' ||  $timeCal == '17' ||  $timeCal == '18' ){
                        if($w->description == 'broken clouds'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_day.gif';
                            $background_image2  = asset('storage/video/Broken_Clouds_Day.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_day.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }
                        else if($w->description == 'clear sky'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/clear+sky_Day.gif';
                            $background_image2  = asset('storage/video/Clear_Sky_Day.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/Clear_Sky_Day.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }
                        else if($w->description == 'few clouds'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/few+clouds_day.gif';
                            $background_image2   = asset('storage/video/Few_Clouds_Day.mp4');
                            $icon2               = 'https://krishivikas.com/storage/weather/icon/few_clouds_day.png';
                            $card_image2         = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }
                        else if($w->description == 'mist'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/mist_day.gif';
                            $background_image2  = asset('storage/video/Mist_Day.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/mist_day.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }
                        else if($w->description == 'rain'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/rain_day.gif';
                            $background_image2  = asset('storage/video/Rain_Day.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/rain_day.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }
                        else if($w->description == 'scattered clouds'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/scattered+cloud.gif';
                            $background_image2  = asset('storage/video/Scattered_Cloud.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/scattered_clouds_day.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }
                        else if($w->description == 'shower rain'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/shower+rain_day.gif';
                            $background_image2  = asset('storage/video/Shower_Rain_Day.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/shower_rain_day.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }
                        else if($w->description == 'snow'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/snow_day.gif';
                            $background_image2  = asset('storage/video/Snow_Day.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/snow_day.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }
                        else if($w->description == 'thunderstorm'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/thunderstorm_day.gif';
                            $background_image2  = asset('storage/video/Thunderstorm_Day.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/thunderstorm_day.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }
                        else if($w->description == 'overcast clouds'){
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_day.gif';
                            $background_image2  = asset('storage/video/Broken_Clouds_Day.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_day.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }else{
                            // $background_image2  = 'https://assets--images.s3.ap-south-1.amazonaws.com/weather-assets/broken+clouds_day.gif';
                            $background_image2  = asset('storage/video/Broken_Clouds_Day.mp4');
                            $icon2              = 'https://krishivikas.com/storage/weather/icon/broken_clouds_day.png';
                            $card_image2        = 'https://krishivikas.com/storage/weather/card/weather_card_day.png';
                        }
                    }

                    if($timeCal < 25){
                        $hour = array();
                        $currentTime = date($timeCal.':1');
                        $convertedTime = date('h:s a', strtotime($currentTime));
                        //echo $timeCal;
                        $hour = [
                            'hours'           =>  $timeCal.":"."00".":"."00" ,
                            'temp'            => round($h->temp), 
                            'feels_like'      => round($h->feels_like), 
                            'main'            => $w->main , 
                            'description'     => $w->description ,
                            "card_image"      => $card_image2,
                            "icon"            => $icon2,
                            "background_image"=> $background_image2
                        ];
                        //$hourTime['hours'][$key] = $hour;
                      $weather['hours'][] = $hour;
                    }
                }
            }
        }

        /** Week Data */
        $startDate = Carbon::now();
        $tenDays = [];
    
        for ($i = 0; $i < 10; $i++) {
            $day = $startDate->copy()->addDays($i);
            $tenDays[] = [
                'date' => $day->toDateString(),
                'day_name' => $day->format('l'),
            ];
        }
        $weather['week'] =  $tenDays;


        $data[] = $weather;
    
        $output['response']       = true;
        $output['message']        = 'Weather Data';
        $output['show_data']      = 'Current , 10Days , 24Hrs , 10 Days with Date Data';
        $output['city_name']      =  $pindata->city_name;
        $output['data']           =  $weather;
        $output['error']          = "";

        if(!empty($output)){
            return $output;

        }else{
            return ['message' => 'No Data Available','data' =>[]];
        }
    }
}
