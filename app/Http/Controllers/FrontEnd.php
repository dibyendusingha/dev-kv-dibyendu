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
use App\Models\pesticides;
use App\Models\fertilizers;
use App\Models\Tyre;
use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\User as Userss;
use App\Models\everything as e;
use Image;


class FrontEnd extends Controller
{
    //
    
    public function __construct () {
        
        $this->middleware(function ($request, $next) {
        $this->location_data = $request->attributes->get('location_data');
        
        $regionName = $this->location_data->regionName;
        $cityName = $this->location_data->cityName;
        $pincode_ip = $this->location_data->zipCode;
    
        if ($request->session()->has('pincode')) {
        $pincode = $request->session()->get('pincode');
        } else {
        $pincode = $pincode_ip;
        $request->session()->put('pincode',$pincode_ip);
        }


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
        } else {
            $pincode_ip = '700029';
            $pincode = '700029';
            $request->session()->put('pincode',$pincode_ip);
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
        return $next($request);
    });
    
    }
    
    public function ipget ($request) {
        
    }
    
    public function  test_get_location () {
        return view('front.test.index');
    }

    public function index () {
        return view('front.index');
    }
    
    public function contact (Request $request) {
        $location_data = $this->location_data;
        //print_r($location_data);
        return view('front.development.contact',['location_data'=>$location_data]);
    }
    
    public function privacy_policy (Request $request) {
        $location_data = $this->location_data;
        return view('front.privacy_policy');
    }

    public function terms_condition (Request $request) {
        $location_data = $this->location_data;
        return view('front.terms_condition',['location_data'=>$location_data]);
    }

    public function about_us (Request $request) {
        $location_data = $this->location_data;
            return view('front.about_us',['location_data'=>$location_data]);
    }

    public function data_privacy (Request $request) {
        $location_data = $this->location_data;
        return view('front.data_privacy',['location_data'=>$location_data]);
    }

    public function valid_pincode(Request $request){
       // dd($request->all());
       $pincode = $request->pincode;
       $dataLength = strlen($pincode);

        if($dataLength == 6){
            $city_pincode = DB::table('city')->where('pincode',$request->pincode)->count();
            if($city_pincode > 0){
                return response()->json(['messsage' => '<p class="text-success">Pincode valid</p>']);
            }else{
                return response()->json(['messsage' => '<p class="text-danger">Pincode invalid</p>']);
            }
        }else{
            return response()->json(['messsage' => '<p class="text-danger">Pincode  must be 6 characters</p>']);

        }
    }
    public function pincode_put (Request $request) {
        $pincode = $request->pincode;
        
        $count = DB::table('city')->where(['pincode'=>$pincode])->count();
        if ($count>0) {
            $pindata = DB::table('city')->where(['pincode'=>$pincode])->first();
            $id = $pindata->id;
            $city_name = $pindata->city_name;
            $country_id = $pindata->country_id;
            $c = DB::table('country')->where(['id'=>$country_id])->first();
            $country_name = $c->country_name;
            $request->session()->put('pincode',$pincode);
            $response = array(
                'status' => 'success',
                'pincode'=> $pincode,
                'messsage' => 'Pincode successfully',
            );

        } else {
            $response = array(
                'status' => 'failed',
                'pincode'=> $pincode,
                'messsage' => 'No Data Found',
            );
        }
        return response()->json($response);
    }

    /*
    public function get_location1(Request $request) {
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        //if latitude and longitude are submitted
        if(!empty($latitude) && !empty($longitude)){
            //send request and receive json data by latitude and longitude
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false';
            $json = @file_get_contents($url);
            $data = json_decode($json);
            return $data;
            $status = $data->status;
            //echo $status;
            //if request status is successful
            if($status == "OK"){
                //get address from json data
                $location = $data->results[0]->formatted_address;
                $response = array('location' => $location);
            }else{
                $location =  '';
                $response =array('location' => '');
            }

            return response()->json($response);
            //echo $location;
        }

    //     $response = array(
    //       'latitude' => $request->latitude,
    //       'longitude' => $request->longitude,
    //   );
    //  return response()->json($response);



    }

    public function get_location(Request $request) {
        $latitude = '22.418318'; //'22.5816962';//$request->latitude;
        $longitude = '88.282930';//'88.4304141';//$request->longitude;

        //if latitude and longitude are submitted
        if(!empty($latitude) && !empty($longitude)){
            //send request and receive json data by latitude and longitude
            $geolocation = $latitude.','.$longitude;
        $response = \Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => $geolocation,
            'key' => 'AIzaSyCtbMU1SPyoFXHh9u2W8MLjA9_YVhsdAsE',
            'sensor'    =>  true
        ]);
        $json_decode = json_decode($response);
        if(isset($json_decode->results[0])) {
            $response = array();
            foreach($json_decode->results[0]->address_components as $addressComponet) {
                $response[] = $addressComponet->long_name;
            }
            //dd($response);
        }

         return response()->json($response);
        }


    }
*/
    public function index_test(Request $request)
    {
        //echo $user_ip_address=$request->ip();
        //$myIp = getHostByName(getHostName());
        //echo $myIp;
        $ip = '202.142.105.197';//\Request::ip();//'202.142.105.197';//
        $location_data = \Location::get($ip);
        //print_r($location_data);


    $regionName = $location_data->regionName;
    $cityName = $location_data->cityName;
    $pincode_ip = $location_data->zipCode;

    if ($request->session()->has('pincode')) {
        $pincode = $request->session()->get('pincode');
    } else {
        $pincode = $pincode_ip;
        $request->session()->put('pincode',$pincode_ip);
    }


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
    } else {
        $pincode_ip = '700029';
        $pincode = '700029';
        $request->session()->put('pincode',$pincode_ip);
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
     
    /** Dibyendu Change 22.09.2023 */
    $tractor_sell_new     = Tractor::tractor_new('new',$pincode);
    $tractor_sell_old     = Tractor::tractor_old('old',$pincode);
    $tractor_rent         = Tractor::tractor_rent('rent',$pincode);

    $gv_sell_new          = Goods_vehicle::good_vehicle_new('new',$pincode);
    $gv_sell_old          = Goods_vehicle::good_vehicle_old('old',$pincode);
    $gv_rent              = Goods_vehicle::good_vehicle_rent('rent',$pincode);

    $seed                 = Seed::seed_new('new',$pincode);
    $pesticides           = pesticides::pesticide_new('new',$pincode);
    $fertilizers          = fertilizers::fertilizer_new('new',$pincode);

    $harvester_sell_new   = Harvester::harvester_new('new',$pincode);
    $harvester_sell_old   = Harvester::harvester_old('old',$pincode);
    $harvester_rent       = Harvester::harvester_rent('rent',$pincode);

    $implements_sell_new  = Implement::implement_new('new',$pincode);
    $implements_sell_old  = Implement::implement_old('old',$pincode);
    $implements_rent      = Implement::implement_rent('rent',$pincode);

    $tyre_new             = Tyre::tyre_new('new',$pincode);
    $tyre_old             = Tyre::tyre_old('old',$pincode);

    //$tractor_sell_new = Tractor::tractor_data(0,'new',$pincode,$district,$state,'dashboard',0,20);
    //$tractor_sell_old = Tractor::tractor_data(0,'old',$pincode,$district,$state,'dashboard',0,20);
   // $tractor_rent = Tractor::tractor_data_rent(0,'rent',$pincode,$district,$state,'dashboard',0,20);

    //$gv_sell_new = Goods_vehicle::gv_data(0,'new',$pincode,$district,$state,'dashboard',0,20);
   // $gv_sell_old = Goods_vehicle::gv_data(0,'old',$pincode,$district,$state,'dashboard',0,20);
   // $gv_rent = Goods_vehicle::gv_data_rent(0,'rent',$pincode,$district,$state,'dashboard',0,20);

   // $harvester_sell_new = Harvester::harvester_data(0,'new',$pincode,$district,$state,'dashboard',0,20);
   // $harvester_sell_old = Harvester::harvester_data(0,'old',$pincode,$district,$state,'dashboard',0,20);
   // $harvester_rent = Harvester::harvester_data_rent(0,'rent',$pincode,$district,$state,'dashboard',0,20);

   // $implements_sell_new = Implement::implement_data(0,'new',$pincode,$district,$state,'dashboard',0,20);
    //$implements_sell_old = Implement::implement_data(0,'old',$pincode,$district,$state,'dashboard',0,20);
    //$implements_rent = Implement::implement_data_rent(0,'rent',$pincode,$district,$state,'dashboard',0,20);

    //$seed = Seed::seeds_data(0,$pincode,$district,$state,'dashboard',0,20);
    //$pesticides = pesticides::pesticides_data(0,$pincode,$district,$state,'dashboard',0,20);
    //$fertilizers = fertilizers::fertilizers_data(0,$pincode,$district,$state,'dashboard',0,20);

    // $tyre_new = Tyre::tyre_data(0,'new',$pincode,$district,$state,'dashboard',0,20);
    // $tyre_old = Tyre::tyre_data(0,'old',$pincode,$district,$state,'dashboard',0,20);

    /** Dibyendu Change 22.09.2023 */
    $data = array();

    $data['tractor_new']      = DB::table('company')->where('category',1)->where('status',1)->get();
    $data['gv_new']           = DB::table('company')->where('category',3)->where('status',1)->get();
    $data['harvester_new']    = DB::table('company')->where('category',4)->where('status',1)->get();
    $data['implement_new']    = DB::table('company')->where('category',5)->where('status',1)->get();
    $data['seed_new']         = DB::table('company')->where('category',6)->where('status',1)->get();
    $data['tyre_new']         = DB::table('company')->where('category',7)->where('status',1)->get();
    $data['pesticides_new']   = DB::table('company')->where('category',8)->where('status',1)->get();
    $data['fertilizers_new']  = DB::table('company')->where('category',9)->where('status',1)->get();

    $data['tractor']      = DB::table('brand')->where('category_id',1)->where('popular',1)->get();
    $data['gv']           = DB::table('brand')->where('category_id',3)->where('popular',1)->get();
    $data['harvester']    = DB::table('brand')->where('category_id',4)->where('popular',1)->get();
    $data['implement']    = DB::table('brand')->where('category_id',5)->where('popular',1)->get();
    $data['seed']         = DB::table('brand')->where('category_id',6)->where('popular',1)->get();
    $data['tyre']         = DB::table('brand')->where('category_id',7)->where('popular',1)->get();
    $data['pesticides']   = DB::table('brand')->where('category_id',8)->where('popular',1)->get();
    $data['fertilizers']  = DB::table('brand')->where('category_id',9)->where('popular',1)->get();

    $brands      = DB::table('brand')->where('status',1)->orderBy('popular','DESC')->get();
   // dd($brands);


//print_r($tyre_old); exit;
    return view('front.development.index',['location_data'=>$location_data,'tractor_sell_new'=>$tractor_sell_new,'tractor_sell_old'=>$tractor_sell_old,'tractor_rent'=>$tractor_rent,
    'gv_sell_new'=>$gv_sell_new,'gv_sell_old'=>$gv_sell_old,'gv_rent'=>$gv_rent,
    'harvester_sell_new'=>$harvester_sell_new,'harvester_sell_old'=>$harvester_sell_old,'harvester_rent'=>$harvester_rent,
    'implements_sell_new'=>$implements_sell_new,'implements_sell_old'=>$implements_sell_old,'implements_rent'=>$implements_rent,
    'seed'=>$seed,'pesticides'=>$pesticides,'fertilizers'=>$fertilizers,'tyre_new'=>$tyre_new,'tyre_old'=>$tyre_old ,'data'=>$data, 'brands'=>$brands
    ]);
    }

/** Dibyendu Change 02.09.2023 */
    public function iffco_dealer_page_show(){
        return view('front.development.iffco-dealer');
    }

/** Dibyendu Change 02.09.2023 */
    public function iffco_product_page_show(){
        $getProduct = DB::table('iffco_product')->get();
        return view('front.development.iffco-product',compact('getProduct'));
    }

    public function login_user (Request $request) {
        $mobile = $request->mobile_login;

        $rand = rand (100000,999999);
        $sms_code = $rand.'.';
	    $message = 'Your Krishi Vikas Udyog verification code is '.$sms_code.' Please enter it in the required space to process your sign-up. | Krishi Vikas';
    	$encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$mobile.'&message='.$encode_message.'&format=json';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        $request->session()->put('KVMobile1',$mobile);
        $request->session()->put('KVOtp',$rand);
        $response = array(
            'status' => 'success',
            'messsage' => 'Otp Successfully Sent',
        );
        return response()->json($response);
    }

    public function otp_check (Request $request) {
        $ajaxotp = $request->otp;
        $pincode = $request->session()->get('pincode');
        $pincodecount = DB::table('city')->where(['pincode'=>$pincode])->count();
        if ($pincodecount>0) {
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

        $mobile = $request->session()->get('KVMobile1');
        $otp = $request->session()->get('KVOtp');
        if ($otp==$ajaxotp) {
            $count = DB::table('user')->where(['mobile'=>$mobile])->count();
            if ($count>0) {
                //existing login user

            } else {
                //new login user
                $token = Str::random(100);
                $insert = DB::table('user')->insert(['mobile'=>$mobile,'token'=>$token,'country_id'=>$country,'state_id'=>$state,'district_id'=>$district,'city_id'=>$city_id,
                'lat'=>$latitude,'long'=>$longitude,'zipcode'=>$pincode,'phone_verified'=>1,'status'=>1]);

            }
            $get = DB::table('user')->where(['mobile'=>$mobile])->first();
            $request->session()->put('KVMobile',$mobile);
            $request->session()->put('kvuser_type',$get->user_type_id);
            $request->session()->forget('KVOtp');
            $response = array(
                'status' => 'success',
                'messsage' => 'Login Successfully',
                'KVMobile' => session()->get('KVMobile'),
                'kvuser_type' => session()->get('kvuser_type')
            );
        } else {
            $request->session()->forget('KVMobile1');
            $request->session()->forget('KVOtp');
            $response = array(
                'status' => 'failed',
                'messsage' => 'Otp Not Match',
                'KVMobile' => session()->get('KVMobile'),
                'kvuser_type' => session()->get('kvuser_type')
            );
        }
        return response()->json($response);
    }

    public function logout () {
        session()->flush();
        return redirect('index');
    }

    public function pincode_state_city_district (Request $request) {
        $pincode = $request->pincode;
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

        $response = array('status' => 'success',
        'country_id'=>$country_id,'country_name'=>$country_name,'state_id'=>$state_id,'state_name'=>$state_name,
        'district_id'=>$district_id,'district_name'=>$district_name,'city_id'=>$city_id,'city_name'=>$city_name,
        'latitude'=>$latitude,'longitude'=>$longitude,'messsage' => 'Register Successfully');
        } else {
            $response = array('status' => 'failed','messsage' => '');
        }
        return response()->json($response);
    }

    public function register_sendotp (Request $request) {
        $mobile = $request->reg_phno;

        $rand = rand (100000,999999);
        $sms_code = $rand.'.';
	    $message = 'Your Krishi Vikas Udyog verification code is '.$sms_code.' Please enter it in the required space to process your sign-up. | Krishi Vikas';
    	$encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$mobile.'&message='.$encode_message.'&format=json';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        $request->session()->put('KVMobile_sms',$mobile);
        $request->session()->put('KVOtp',$rand);
    }

    public function register_user (Request $request) {
        //$response['a'] = $request->all();
        //dd($request->all());

        $user_type = $request->user_type;
        if ($user_type==2) {
            $c_name = $request->c_name;
            $gst_no = $request->gst_no;
        } else {
            $c_name = '';
            $gst_no = '';
        }
        $reg_name = $request->reg_name;
        $reg_phno = $request->reg_phno;
        $reg_email = $request->reg_email;
        $reg_dob = $request->reg_dob;
        $reg_pincode = $request->reg_pincode;
        $reg_state = $request->reg_state;
        $reg_city = $request->reg_city;
        $reg_address = $request->reg_address;

        $reg_first = $request->reg_first;
        $reg_second = $request->reg_second;
        $reg_third = $request->reg_third;
        $reg_fourth = $request->reg_fourth;
        $reg_fifth = $request->reg_fifth;
        $reg_sixth = $request->reg_sixth;
        $otp = $reg_first.$reg_second.$reg_third.$reg_fourth.$reg_fifth.$reg_sixth;

        $kvMobile = $request->session()->get('KVMobile_sms');
        $kvOtp = $request->session()->get('KVOtp');
        if ($kvOtp==$otp) {

            if ($photo = $request->file('reg_image')) {
                $photo = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('reg_image')->getClientOriginalName();
                $ext = $request->file('reg_image')->getClientOriginalExtension();
                $request->file('reg_image')->storeAs('public/photo', $photo);
            }

            $city_s = DB::table('city')->where(['pincode'=>$reg_pincode])->first();
            $country_id = $city_s->country_id;
            $state_id = $city_s->state_id;
            $district_id = $city_s->district_id;
            $city_id = $city_s->id;
            $latitude = $city_s->latitude;
            $longitude = $city_s->longitude;

            $token = Str::random(100);
            $login_count = DB::table('user')->where(['mobile'=>$kvMobile,'profile_update'=>0])->count();
            $regtr_count = DB::table('user')->where(['mobile'=>$kvMobile,'profile_update'=>1])->count();


            if ($login_count==0 && $regtr_count==0) {
                $reg = DB::table('user')->insert(['user_type_id'=>$user_type,'name'=>$reg_name,'company_name'=>$c_name,'gst_no'=>$gst_no,
                    'mobile'=>$kvMobile,'email'=>$reg_email,'address'=>$reg_address,'dob'=>$reg_dob,
                    'country_id'=>$country_id,'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,
                    'lat'=>$latitude,'long'=>$longitude,'zipcode'=>$reg_pincode,'token'=>$token,'phone_verified'=>1,
                    'status'=>1,'profile_update'=>1,'photo'=>$photo]);


                    $message = 'Congratulations! You are successfully registered with Krishi Vikas Udyog. Now, BUY, Sell, Rent and grow with us! | Krishi Vikas';
                    $encode_message = urlencode($message);
                    $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$kvMobile.'&message='.$encode_message.'&format=json';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $res = curl_exec($ch);

                    $request->session()->put('KVMobile',$kvMobile); //login session
                    $request->session()->forget('KVMobile_sms');      //unset session
                    $request->session()->forget('KVOtp');             //unset session
                if ($reg) {
                    $response = array('status' => 'success','messsage' => 'New Registration Successfully');
                } else {
                    $response = array('status' => 'failed','messsage' => 'Data Not Get');
                }
                $response = array('status' => 'success','messsage' => 'Register Successfully');
            } else if ($regtr_count==0 && $login_count==1) {
                $reg = DB::table('user')->where(['mobile'=>$kvMobile])->update(['user_type_id'=>$user_type,'name'=>$reg_name,'company_name'=>$c_name,'gst_no'=>$gst_no,
                    'email'=>$reg_email,'address'=>$reg_address,'dob'=>$reg_dob,
                    'country_id'=>$country_id,'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,
                    'lat'=>$latitude,'long'=>$longitude,'zipcode'=>$reg_pincode,'token'=>$token,'phone_verified'=>1,
                    'status'=>1,'profile_update'=>1,'photo'=>$photo]);

                    $message = 'Congratulations! You are successfully registered with Krishi Vikas Udyog. Now, BUY, Sell, Rent and grow with us! | Krishi Vikas';
                    $encode_message = urlencode($message);
                    $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$kvMobile.'&message='.$encode_message.'&format=json';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $res = curl_exec($ch);

                    $request->session()->put('KVMobile',$kvMobile); //login session
                    $request->session()->forget('KVMobile_sms');      //unset session
                    $request->session()->forget('KVOtp');             //unset session


                if ($reg) {
                    $response = array('status' => 'success','messsage' => 'Register Successfully');
                } else {
                    $response = array('status' => 'failed','messsage' => 'Data Not Get');
                }
                $response = array('status' => 'success','messsage' => 'Registration Successfully');

            } else if ($regtr_count==1 && $login_count==0) {
                $response = array('status' => 'failed','messsage' => 'You Already Registered! Please Login.');
                $request->session()->forget('KVMobile_sms');      //unset session
                $request->session()->forget('KVOtp');             //unset session
            } else {
                $response = array('status' => 'failed','messsage' => 'Something Went Wrong.');
                    $request->session()->forget('KVMobile_sms');      //unset session
                    $request->session()->forget('KVOtp');             //unset session
            }
        } else {
            $response = array('status' => 'failed','messsage' => 'Otp Not Match');
                $request->session()->forget('KVMobile_sms');      //unset session
                $request->session()->forget('KVOtp');             //unset session
        }


        return response()->json($response);
    }

    public function profile () {
        $data=[];
        $mobile = session()->get('KVMobile');
        $data = DB::table('user')->where(['mobile'=>$mobile])->first();
        $zipcode = $data->zipcode;
        $data->location = e::pincode($zipcode); //location

        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $my_p_tractor = DB::table('tractor')->where(['user_id'=>$user_id])->count();
        $my_p_goods_vehicle = DB::table('goods_vehicle')->where(['user_id'=>$user_id])->count();
        $my_p_harvester = DB::table('harvester')->where(['user_id'=>$user_id])->count();
        $my_p_implements = DB::table('implements')->where(['user_id'=>$user_id])->count();
        $my_p_seeds = DB::table('seeds')->where(['user_id'=>$user_id])->count();
        $my_p_pesticides = DB::table('pesticides')->where(['user_id'=>$user_id])->count();
        $my_p_fertilizers = DB::table('fertilizers')->where(['user_id'=>$user_id])->count();
        $my_p_tyres = DB::table('tyres')->where(['user_id'=>$user_id])->count();

        return view('front.development.profile',['data'=>$data,'my_p_tractor'=>$my_p_tractor,'my_p_goods_vehicle'=>$my_p_goods_vehicle,
        'my_p_harvester'=>$my_p_harvester,'my_p_implements'=>$my_p_implements,'my_p_seeds'=>$my_p_seeds,
        'my_p_pesticides'=>$my_p_pesticides,'my_p_fertilizers'=>$my_p_fertilizers,'my_p_tyres'=>$my_p_tyres
    ]);
    }

    public function profileSettings_update (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $email_newslatter = $request->email_newslatter;
        $whatsapp_notification = $request->whatsapp_notification;
        $promotion = $request->promotion;
        $marketing = $request->marketing;
        $social_media = $request->social_media;

        $insert = DB::table('user')->where(['id'=>$user_id])->update(['email_newslatter'=>$email_newslatter,'whatsapp_notification'=>$whatsapp_notification,'promotin'=>$promotion,'marketing_communication'=>$marketing,
        'social_media_promotion'=>$social_media]);
        if ($insert) {
            return redirect('profile');
        } else {
            return redirect('profile');
        }

    }

    public function my_tractor (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $my_p_count = DB::table('tractor')->where(['user_id'=>$user_id])->count();
        $my_p_tractor = DB::table('tractor')->where(['user_id'=>$user_id])->get();
        return view('front.development.post-list',['my_p_count'=>$my_p_count,'my_p_tractor'=>$my_p_tractor]);
    }

    public function my_goods_vehicle (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $my_p_count = DB::table('goods_vehicle')->where(['user_id'=>$user_id])->count();
        $my_p_gv = DB::table('goods_vehicle')->where(['user_id'=>$user_id])->get();
        return view('front.development.post-list',['my_p_count'=>$my_p_count,'my_p_gv'=>$my_p_gv]);
    }

    public function my_harvester (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $my_p_count = DB::table('harvester')->where(['user_id'=>$user_id])->count();
        $my_p_har = DB::table('harvester')->where(['user_id'=>$user_id])->get();
        return view('front.development.post-list',['my_p_count'=>$my_p_count,'my_p_har'=>$my_p_har]);
    }

    public function my_implements (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $my_p_count = DB::table('implements')->where(['user_id'=>$user_id])->count();
        $my_p_imp = DB::table('implements')->where(['user_id'=>$user_id])->get();
        return view('front.development.post-list',['my_p_count'=>$my_p_count,'my_p_imp'=>$my_p_imp]);
    }
    public function my_seeds (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $my_p_count = DB::table('seeds')->where(['user_id'=>$user_id])->count();
        $my_p_seeds = DB::table('seeds')->where(['user_id'=>$user_id])->get();
        return view('front.development.post-list',['my_p_count'=>$my_p_count,'my_p_seed'=>$my_p_seeds]);
    }

    public function my_pesticides (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $my_p_count = DB::table('pesticides')->where(['user_id'=>$user_id])->count();
        $my_p_pest = DB::table('pesticides')->where(['user_id'=>$user_id])->get();
        return view('front.development.post-list',['my_p_count'=>$my_p_count,'my_p_pest'=>$my_p_pest]);
    }

    public function my_fertilizers (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $my_p_count = DB::table('fertilizers')->where(['user_id'=>$user_id])->count();
        $my_p_fert = DB::table('fertilizers')->where(['user_id'=>$user_id])->get();
        return view('front.development.post-list',['my_p_count'=>$my_p_count,'my_p_fert'=>$my_p_fert]);
    }

    public function my_tyres (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $my_p_count = DB::table('tyres')->where(['user_id'=>$user_id])->count();
        $my_p_tyre = DB::table('tyres')->where(['user_id'=>$user_id])->get();
        return view('front.development.post-list',['my_p_count'=>$my_p_count,'my_p_tyre'=>$my_p_tyre]);
    }

    public function item_wishlist (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $db_id = $request->db_id;
        $item_id = $request->item_id;
        if ($db_id=='tractor') { $cat =1;
        }else if ($db_id=='gv') { $cat =3;
        }else if ($db_id=='harvester') {$cat =4;
        }else if ($db_id=='implements') { $cat =5;
        }else if ($db_id=='seed') { $cat =6;
        }else if ($db_id=='pesticides') { $cat =8;
        }else if ($db_id=='fertilizer') { $cat =9;
        }else if ($db_id=='tyre') { $cat =7;
        }

        $count = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>$cat,'item_id'=>$item_id])->count();
            if ($count>0) {
                $delete = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>$cat,'item_id'=>$item_id])->delete();
            } else {
                $insert = DB::table('wishlist')->insert(['user_id'=>$user_id,'category_id'=>$cat,'item_id'=>$item_id]);
            }

        if ($insert) {
            $response = array(
                'status' => 'success',
                'messsage' => 'Wishlist Added Successfully',
            );
        } else {
            $response = array(
                'status' => 'failed',
                'messsage' => 'Wishlist Deleted Successfully',
            );
        }
        return response()->json($response);
    }

    public function wishlist (Request $request) {
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $count = DB::table('wishlist')->where(['user_id'=>$user_id])->count();
        $wishlistarr = DB::table('wishlist')->where(['user_id'=>$user_id])->get();
        return view('front.development.wishlist',['wishlistarr'=>$wishlistarr,'count'=>$count,'user_id'=>$user_id]);
    }

    public function profile_update (Request $request) {
        $mobile = $request->session()->get('KVMobile');
        $id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $name = $request->name;
        if ($request->has('company_name')) {
            $company_name = $request->company_name;
        } else {
            $company_name = '';
        }
        if ($request->has('gst_no')) {
            $gst_no = $request->gst_no;
        } else {
            $gst_no = '';
        }
        $email = $request->email;
        $pincode = $request->pincode;
        $address = $request->address;
        $dob = $request->dob;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=>'required|email',
            'pincode'=>'required|digit:6',
        ]);

        $location = e::pincode($pincode);
        $country_id = $location['country_id'];
        $state_id = $location['state_id'];
        $district_id = $location['district_id'];
        $city_id = $location['city_id'];

        $update = DB::table('user')->where(['id'=>$id])->update(['name'=>$name,'email'=>$email,'zipcode'=>$pincode,
        'address'=>$address,'dob'=>$dob,'country_id'=>$country_id,'state_id'=>$state_id,'district_id'=>$district_id,
        'city_id'=>$city_id,'company_name'=>$company_name,'gst_no'=>$gst_no,'profile_update'=>1]);
        if ($update) {
            $message = 'Congratulations! Your profile is updated successfully | Krishi Vikas';
            $encode_message = urlencode($message);
            $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$mobile.'&message='.$encode_message.'&format=json';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $res = curl_exec($ch);
            return redirect('profile')->with(['response'=>'success','message'=>'User Updated Successfully']);
        } else {
            return redirect('profile')->with(['response'=>'failed','message'=>'Failed']);
        }
    }

    public function image_update (Request $request) {
        $image = $request->image;

        //$image = $request->name;
        if ($image = $request->file('image')) {
            $image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image')->getClientOriginalName();
            $ext = $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/photo', $image);
        }
        $return = ['status'=>1,'message'=>'message','image'=>$image];
        return response()->json($return);
    }

    public function brand_to_model (Request $request) {
        $brand_id = $request->brand_id;
        $model_arr = DB::table('model')->where(['brand_id'=>$brand_id])->get();
        // foreach ($model_arr as $val)  {
        //     $data.= "<option value=".$val->id.">".$val->model_name."</option>";
        // }
        return response()->json($model_arr);
    }

    public function state_to_district1 (Request $request) {
        $state_id = $request->state_id;
        $state_arr = DB::table('district')->where(['state_id'=>$state_id])->get();
        // foreach ($model_arr as $val)  {
        //     $data.= "<option value=".$val->id.">".$val->model_name."</option>";
        // }
        return response()->json($state_arr);
    }
    
    /** Dibyendu Change */
    public function state_to_district (Request $request) {
        //dd($request->all());
        $array = $request->state_id;
       // dd($array);
        $x = array_slice($array,3);
       // dd($x);
        $state_id = $request->state_id;
        // $state_arr = DB::table('district')->whereIn(['state_id'=>$x])->get();whereIn('year_of_purchase', $yop)
        $state_arr1 = DB::table('district')->whereIn('state_id', $x)->get();
        $set = $array[1];
        //dd($set);
        $type = $array[2];
        //dd($type);
        $category = $array[0];
        $state_arr = array();
        foreach($state_arr1 as $key=> $dis){
            if($category == 'tractor'){
                if($set == 'rent'){
                    // $disCount = DB::table('tractorview')->where('district_id',$dis->id)->where('set',$set)->whereIn('status',[1,4])->count();
                    $disCount = DB::table('tractorview')->where('district_id',$dis->id)->where('set',$set)->whereIn('status',[1,4])->count();
                    if($disCount >= 1){
                        $state_arr['district_count'][$key] = $disCount;
                    }
                }else{
                    // $disName  = DB::table('tractorview')->where('district_id',$dis->id)->where('set',$set)->where('type',$type)->whereIn('status',[1,4])->first();
                    $disCount = DB::table('tractorview')->where('district_id',$dis->id)->where('set',$set)->where('type',$type)->whereIn('status',[1,4])->count();
                    if($disCount >= 1){
                        $state_arr['district_count'][$key] = $disCount;
                        // $state_arr['district_id'][$key]    = $disName->disId;
                        // $state_arr['state_id']             = $x;
                        // $state_arr['districtName'][$key]   = $disName->district_name;
                    }
                }
            }
            else if($category == 'goodvehicle'){
                if($set == 'rent'){
                    $disCount = DB::table('goodVehicleView')->where('district_id',$dis->id)->where('set',$set)->whereIn('status',[1,4])->count();
                    if($disCount >= 1){
                        $state_arr['district_count'][$key] = $disCount;
                    }
                }else{
                    // $disName  = DB::table('tractorview')->where('district_id',$dis->id)->where('set',$set)->where('type',$type)->whereIn('status',[1,4])->first();
                    $disCount = DB::table('goodVehicleView')->where('district_id',$dis->id)->where('set',$set)->where('type',$type)->whereIn('status',[1,4])->count();
                    if($disCount >= 1){
                        $state_arr['district_count'][$key] = $disCount;
                    }
                }

            }
            else if($category == 'harvester'){
                if($set == 'rent'){
                    $disCount = DB::table('harvesterView')->where('district_id',$dis->id)->where('set',$set)->whereIn('status',[1,4])->count();
                    if($disCount >= 1){
                        $state_arr['district_count'][$key] = $disCount;
                    }
                }else{
                    // $disName  = DB::table('tractorview')->where('district_id',$dis->id)->where('set',$set)->where('type',$type)->whereIn('status',[1,4])->first();
                    $disCount = DB::table('harvesterView')->where('district_id',$dis->id)->where('set',$set)->where('type',$type)->whereIn('status',[1,4])->count();
                    if($disCount >= 1){
                        $state_arr['district_count'][$key] = $disCount;
                    }
                }

            }
            else if($category == 'implement'){
                if($set == 'rent'){
                    $disCount = DB::table('implementView')->where('district_id',$dis->id)->where('set',$set)->whereIn('status',[1,4])->count();
                    if($disCount >= 1){
                        $state_arr['district_count'][$key] = $disCount;
                    }
                }else{
                    // $disName  = DB::table('tractorview')->where('district_id',$dis->id)->where('set',$set)->where('type',$type)->whereIn('status',[1,4])->first();
                    $disCount = DB::table('implementView')->where('district_id',$dis->id)->where('set',$set)->where('type',$type)->whereIn('status',[1,4])->count();
                    if($disCount >= 1){
                        $state_arr['district_count'][$key] = $disCount;
                    }
                }

            }
            else if($category == 'tyre'){
                if($set == 'old'){
                    $disCount = DB::table('tyresView')->where('district_id',$dis->id)->where('type','old')->whereIn('status',[1,4])->count();
                    if($disCount >= 1){
                        $state_arr['district_count'][$key] = $disCount;
                    }
                }else{
                    $disCount = DB::table('tyresView')->where('district_id',$dis->id)->where('type','new')->whereIn('status',[1,4])->count();
                    if($disCount >= 1){
                        $state_arr['district_count'][$key] = $disCount;
                    }
                }
            }
            else if($category == 'seed'){
                $disCount = DB::table('seedView')->where('district_id',$dis->id)->whereIn('status',[1,4])->count();
                if($disCount >= 1){
                    $state_arr['district_count'][$key] = $disCount;
                }
            }
            else if($category == 'pesticide'){
                $disCount = DB::table('pesticidesView')->where('district_id',$dis->id)->whereIn('status',[1,4])->count();
                if($disCount >= 1){
                    $state_arr['district_count'][$key] = $disCount;
                }
            }
            else if($category == 'fertilizer'){
                $disCount = DB::table('fertilizerView')->where('district_id',$dis->id)->whereIn('status',[1,4])->count();
                if($disCount >= 1){
                    $state_arr['district_count'][$key] = $disCount;
                }
            }
        }
    // dd($state_arr['district_id']);

    // $dis = $state_arr['district_id'];
        $state_arr['district'] = $state_arr1;

        return response()->json($state_arr);
        
    }

    public function tractor_post () {
        $brand = DB::table('brand')->where(['status'=>1,'category_id'=>1])->get();
        $model = DB::table('model')->where(['status'=>1])->get();
        return view('front.development.tractor-post',['brand'=>$brand,'model'=>$model]);
    }

    public function tractor_posting (Request $request) {
        $set = $request->set;
        $type = $request->type;
        $brand_id = $request->brand_id;
        $model_id = $request->model_id;
        $year_of_purchase = $request->yop;
        $rc_available = $request->rc_available;
        $noc_available = $request->noc_available;
        $registration_number = $request->registration_number;
        $price = $request->price;
        $is_negotiable = $request->is_negotiable;
        $pincode = $request->pincode;
        $description = $request->description;
        $rent_type = $request->rent_type;

        $city_s = DB::table('city')->where(['pincode'=>$pincode])->first();
            $country_id = 1;
            $state_id = $city_s->state_id;
            $district_id = $city_s->district_id;
            $city_id = $city_s->id;
            $latitude = $city_s->latitude;
            $longitude = $city_s->longitude;

        $session = $request->session()->get('KVMobile');
        $user = DB::table('user')->where(['mobile'=>$session])->first();

        if ($front_image = $request->file('front_image1')) {
            $front_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('front_image1')->getClientOriginalName();
            $ext = $request->file('front_image1')->getClientOriginalExtension();

            $request->file('front_image1')->storeAs('public/tractor', $front_image);

        } else {
            $front_image='';
        }
        if ($front_image = $request->file('front_image2')) {
            $front_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('front_image2')->getClientOriginalName();
            $ext = $request->file('front_image2')->getClientOriginalExtension();

            $request->file('front_image2')->storeAs('public/tractor', $front_image);

        }else {
            $front_image='';
        }
        if ($back_image = $request->file('back_image1')) {
            $back_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('back_image1')->getClientOriginalName();
            $ext = $request->file('back_image1')->getClientOriginalExtension();
            $request->file('back_image1')->storeAs('public/tractor', $back_image);

        }else {
            $back_image='';
        }
        if ($back_image = $request->file('back_image2')) {
            $back_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('back_image2')->getClientOriginalName();
            $ext = $request->file('back_image2')->getClientOriginalExtension();
            $request->file('back_image2')->storeAs('public/tractor', $back_image);

        }else {
            $back_image='';
        }
        if ($left_image = $request->file('left_image1')) {
            $left_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('left_image1')->getClientOriginalName();
            $ext = $request->file('left_image1')->getClientOriginalExtension();
            $request->file('left_image1')->storeAs('public/tractor', $left_image);

        }else {
            $left_image='';
        }
        if ($left_image = $request->file('left_image2')) {
            $left_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('left_image2')->getClientOriginalName();
            $ext = $request->file('left_image2')->getClientOriginalExtension();
            $request->file('left_image2')->storeAs('public/tractor', $left_image);

        }else {
            $left_image='';
        }
        if ($right_image = $request->file('right_image1')) {
            $right_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('right_image1')->getClientOriginalName();
            $ext = $request->file('right_image1')->getClientOriginalExtension();
            $request->file('right_image1')->storeAs('public/tractor', $right_image);

        }else {
            $right_image='';
        }
        if ($right_image = $request->file('right_image2')) {
            $right_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('right_image2')->getClientOriginalName();
            $ext = $request->file('right_image2')->getClientOriginalExtension();
            $request->file('right_image2')->storeAs('public/tractor', $right_image);

        }else {
            $right_image='';
        }
        if ($meter_image = $request->file('meter_image1')) {
            $meter_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('meter_image1')->getClientOriginalName();
            $ext = $request->file('meter_image1')->getClientOriginalExtension();
            $request->file('meter_image1')->storeAs('public/tractor', $meter_image);

        }else {
            $meter_image='';
        }
        if ($meter_image = $request->file('meter_image2')) {
            $meter_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('meter_image2')->getClientOriginalName();
            $ext = $request->file('meter_image2')->getClientOriginalExtension();
            $request->file('meter_image2')->storeAs('public/tractor', $meter_image);

        }else {
            $meter_image='';
        }
        if ($tyre_image = $request->file('tyre_image1')) {
            $tyre_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('tyre_image1')->getClientOriginalName();
            $ext = $request->file('tyre_image1')->getClientOriginalExtension();
            $request->file('tyre_image1')->storeAs('public/tractor', $tyre_image);

        }else {
            $tyre_image='';
        }
        if ($tyre_image = $request->file('tyre_image2')) {
            $tyre_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('tyre_image2')->getClientOriginalName();
            $ext = $request->file('tyre_image2')->getClientOriginalExtension();
            $request->file('tyre_image2')->storeAs('public/tractor', $tyre_image);

        }else {
            $tyre_image='';
        }

        if(!empty($user->id)){
            $post = DB::table('user')->where('id',$user->id)->first();

            if($post->tractor_post == 0){
                //dd();
                $tractor_count = 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['tractor_post'=>$tractor_count]);
            }else{
                $tractor_count = $post->tractor_post + 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['tractor_post'=>$tractor_count]);
            }
        }

        $insert = DB::table('tractor')->insertGetId(['category_id'=>1,'user_id'=>$user->id,'set'=>$set,'type'=>$type,'brand_id'=>$brand_id,'model_id'=>$model_id,'year_of_purchase'=>$year_of_purchase,
            'rc_available'=>$rc_available,'noc_available'=>$noc_available,'registration_no'=>$registration_number,'description'=>$description,'left_image'=>$left_image,'right_image'=>$right_image,
            'front_image'=>$front_image,'back_image'=>$back_image,'meter_image'=>$meter_image,'tyre_image'=>$tyre_image,'price'=>$price,'rent_type'=>$rent_type,'is_negotiable'=>$is_negotiable,'pincode'=>$pincode,'country_id'=>$country_id,
            'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,
            'status'=>0,'created_at'=>date('Y-m-d H:i:s')]);
            if ($insert) {

        	     $message = 'Your post has been successfully submitted and is now pending for approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
            	 $encode_message = urlencode($message);
                 $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$session.'&message='.$encode_message.'&format=json';
                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt($ch, CURLOPT_URL, $url);
                 $res = curl_exec($ch);
            }
            return redirect ('tractor/'.$insert);

    }

    public function tractor_product (Request $request) {
        $tractor_id = $request->id;
        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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


        $data = Tractor::tractor_single($tractor_id,$user_id);
        $set = $data['set'];
        $type = $data['type'];
        if ($set=='rent') {
            $related_product = Tractor::tractor_data_rent($user_id,$set,$pincode,$district,$state,'related_item',0,100);
        } else {
            if ($type=='new') {$set = 'new';}
            else if ($type=='old') {$set = 'old';}
            $related_product = Tractor::tractor_data($user_id,$set,$pincode,$district,$state,'related_item',0,100);
        }

        return view('front.development.tractor-product',['data'=>$data,'pincode'=>$pincode,'user_id'=>$user_id,'related_product'=>$related_product]);
    }

    public function gv_product (Request $request) {
        $gv_id = $request->id;
        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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


        $data = Goods_vehicle::gv_single($gv_id,$user_id);
        $set = $data['set'];
        $type = $data['type'];
        if ($set=='rent') {
            $related_product = Goods_vehicle::gv_data_rent($user_id,$set,$pincode,$district,$state,'related_item',0,100);
        } else {
            if ($type=='new') {$set = 'new';}
            else if ($type=='old') {$set = 'old';}
            $related_product = Goods_vehicle::gv_data($user_id,$set,$pincode,$district,$state,'related_item',0,100);
        }

        //print_r($data);
        return view('front.development.gv-product',['data'=>$data,'pincode'=>$pincode,'user_id'=>$user_id,'related_product'=>$related_product]);
    }

    public function good_vahicle_post () {
        $brand = DB::table('brand')->where(['status'=>1,'category_id'=>3])->get();
        $model = DB::table('model')->where(['status'=>1])->get();
        return view('front.development.good-vehicle-post',['brand'=>$brand,'model'=>$model]);
    }

    public function good_vahicle_posting (Request $request) {
        $set = $request->set;
        $type = $request->type;
        $brand_id = $request->brand_id;
        $model_id = $request->model_id;
        $year_of_purchase = $request->yop;
        $rc_available = $request->rc_available;
        $noc_available = $request->noc_available;
        $registration_number = $request->registration_number;
        $price = $request->price;
        $is_negotiable = $request->is_negotiable;
        $pincode = $request->pincode;
        $description = $request->description;
        $rent_type = $request->rent_type;

        $city_s = DB::table('city')->where(['pincode'=>$pincode])->first();
        $country_id = $city_s->country_id;
        $state_id = $city_s->state_id;
        $district_id = $city_s->district_id;
        $city_id = $city_s->id;
        $latitude = $city_s->latitude;
        $longitude = $city_s->longitude;

        $session = $request->session()->get('KVMobile');
        $user = DB::table('user')->where(['mobile'=>$session])->first();

        if ($front_image = $request->file('front_image1')) {
            $front_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('front_image1')->getClientOriginalName();
            $ext = $request->file('front_image1')->getClientOriginalExtension();

            $request->file('front_image1')->storeAs('public/goods_vehicle', $front_image);

        } else {
            $front_image='';
        }
        if ($front_image = $request->file('front_image2')) {
            $front_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('front_image2')->getClientOriginalName();
            $ext = $request->file('front_image2')->getClientOriginalExtension();

            $request->file('front_image2')->storeAs('public/goods_vehicle', $front_image);

        }else {
            $front_image='';
        }
        if ($back_image = $request->file('back_image1')) {
            $back_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('back_image1')->getClientOriginalName();
            $ext = $request->file('back_image1')->getClientOriginalExtension();
            $request->file('back_image1')->storeAs('public/goods_vehicle', $back_image);

        }else {
            $back_image='';
        }
        if ($back_image = $request->file('back_image2')) {
            $back_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('back_image2')->getClientOriginalName();
            $ext = $request->file('back_image2')->getClientOriginalExtension();
            $request->file('back_image2')->storeAs('public/goods_vehicle', $back_image);

        }else {
            $back_image='';
        }
        if ($left_image = $request->file('left_image1')) {
            $left_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('left_image1')->getClientOriginalName();
            $ext = $request->file('left_image1')->getClientOriginalExtension();
            $request->file('left_image1')->storeAs('public/goods_vehicle', $left_image);

        }else {
            $left_image='';
        }
        if ($left_image = $request->file('left_image2')) {
            $left_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('left_image2')->getClientOriginalName();
            $ext = $request->file('left_image2')->getClientOriginalExtension();
            $request->file('left_image2')->storeAs('public/goods_vehicle', $left_image);

        }else {
            $left_image='';
        }
        if ($right_image = $request->file('right_image1')) {
            $right_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('right_image1')->getClientOriginalName();
            $ext = $request->file('right_image1')->getClientOriginalExtension();
            $request->file('right_image1')->storeAs('public/goods_vehicle', $right_image);

        }else {
            $right_image='';
        }
        if ($right_image = $request->file('right_image2')) {
            $right_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('right_image2')->getClientOriginalName();
            $ext = $request->file('right_image2')->getClientOriginalExtension();
            $request->file('right_image2')->storeAs('public/goods_vehicle', $right_image);

        }else {
            $right_image='';
        }
        if ($meter_image = $request->file('meter_image1')) {
            $meter_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('meter_image1')->getClientOriginalName();
            $ext = $request->file('meter_image1')->getClientOriginalExtension();
            $request->file('meter_image1')->storeAs('public/goods_vehicle', $meter_image);

        }else {
            $meter_image='';
        }
        if ($meter_image = $request->file('meter_image2')) {
            $meter_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('meter_image2')->getClientOriginalName();
            $ext = $request->file('meter_image2')->getClientOriginalExtension();
            $request->file('meter_image2')->storeAs('public/goods_vehicle', $meter_image);

        }else {
            $meter_image='';
        }
        if ($tyre_image = $request->file('tyre_image1')) {
            $tyre_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('tyre_image1')->getClientOriginalName();
            $ext = $request->file('tyre_image1')->getClientOriginalExtension();
            $request->file('tyre_image1')->storeAs('public/goods_vehicle', $tyre_image);

        }else {
            $tyre_image='';
        }
        if ($tyre_image = $request->file('tyre_image2')) {
            $tyre_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('tyre_image2')->getClientOriginalName();
            $ext = $request->file('tyre_image2')->getClientOriginalExtension();
            $request->file('tyre_image2')->storeAs('public/goods_vehicle', $tyre_image);

        }else {
            $tyre_image='';
        }

        if(!empty($user->id)){
            $post = DB::table('user')->where('id',$user->id)->first();
            //dd($post->gv_post);
            if($post->gv_post == 0){
                //dd();
                $gv_count = 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['gv_post'=>$gv_count]);
            }else{
                $gv_count = $post->gv_post + 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['gv_post'=>$gv_count]);
            }
        }

        $insert = DB::table('goods_vehicle')->insertGetId(['category_id'=>3,'set'=>$set,'user_id'=>$user->id,'type'=>$type,'brand_id'=>$brand_id,'model_id'=>$model_id,'year_of_purchase'=>$year_of_purchase,
            'rc_available'=>$rc_available,'noc_available'=>$noc_available,'registration_no'=>$registration_number,'description'=>$description,'left_image'=>$left_image,'right_image'=>$right_image,
            'front_image'=>$front_image,'back_image'=>$back_image,'meter_image'=>$meter_image,'tyre_image'=>$tyre_image,'price'=>$price,'rent_type'=>$rent_type,'is_negotiable'=>$is_negotiable,'pincode'=>$pincode,'country_id'=>$country_id,
            'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,
            'status'=>0,'created_at'=>date('Y-m-d H:i:s')]);
            if ($insert) {

        	    $message = 'Your post has been successfully submitted and is now pending for approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
            	 $encode_message = urlencode($message);
                 $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$session.'&message='.$encode_message.'&format=json';
                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt($ch, CURLOPT_URL, $url);
                 $res = curl_exec($ch);
            }
        return redirect ('good-vahicle/'.$insert);

    }

    public function harvester_post () {
        $brand = DB::table('brand')->where(['status'=>1,'category_id'=>4])->get();
        $model = DB::table('model')->where(['status'=>1])->get();
        return view('front.development.harvestor-post',['brand'=>$brand,'model'=>$model]);
    }

    public function harvester_posting (Request $request) {
        $set = $request->set;
        $type = $request->type;
        $brand_id = $request->brand_id;
        $model_id = $request->model_id;
        $year_of_purchase = $request->yop;
        $crop_type = $request->crop_type;
        $cutting_with = $request->cutting_with;
        $power_source = $request->power_source;
        $price = $request->price;
        $is_negotiable = $request->is_negotiable;
        $pincode = $request->pincode;
        $description = $request->description;
        $rent_type = $request->rent_type;

        $city_s = DB::table('city')->where(['pincode'=>$pincode])->first();
        $country_id = $city_s->country_id;
        $state_id = $city_s->state_id;
        $district_id = $city_s->district_id;
        $city_id = $city_s->id;
        $latitude = $city_s->latitude;
        $longitude = $city_s->longitude;

        $session = $request->session()->get('KVMobile');
        $user = DB::table('user')->where(['mobile'=>$session])->first();

        if ($front_image = $request->file('front_image1')) {
            $front_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('front_image1')->getClientOriginalName();
            $ext = $request->file('front_image1')->getClientOriginalExtension();

            $request->file('front_image1')->storeAs('public/harvester', $front_image);

        } else {
            $front_image='';
        }
        if ($front_image = $request->file('front_image2')) {
            $front_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('front_image2')->getClientOriginalName();
            $ext = $request->file('front_image2')->getClientOriginalExtension();

            $request->file('front_image2')->storeAs('public/harvester', $front_image);

        }else {
            $front_image='';
        }
        if ($back_image = $request->file('back_image1')) {
            $back_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('back_image1')->getClientOriginalName();
            $ext = $request->file('back_image1')->getClientOriginalExtension();
            $request->file('back_image1')->storeAs('public/harvester', $back_image);

        }else {
            $back_image='';
        }
        if ($back_image = $request->file('back_image2')) {
            $back_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('back_image2')->getClientOriginalName();
            $ext = $request->file('back_image2')->getClientOriginalExtension();
            $request->file('back_image2')->storeAs('public/harvester', $back_image);

        }else {
            $back_image='';
        }
        if ($left_image = $request->file('left_image1')) {
            $left_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('left_image1')->getClientOriginalName();
            $ext = $request->file('left_image1')->getClientOriginalExtension();
            $request->file('left_image1')->storeAs('public/harvester', $left_image);

        }else {
            $left_image='';
        }
        if ($left_image = $request->file('left_image2')) {
            $left_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('left_image2')->getClientOriginalName();
            $ext = $request->file('left_image2')->getClientOriginalExtension();
            $request->file('left_image2')->storeAs('public/harvester', $left_image);

        }else {
            $left_image='';
        }
        if ($right_image = $request->file('right_image1')) {
            $right_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('right_image1')->getClientOriginalName();
            $ext = $request->file('right_image1')->getClientOriginalExtension();
            $request->file('right_image1')->storeAs('public/harvester', $right_image);

        }else {
            $right_image='';
        }
        if ($right_image = $request->file('right_image2')) {
            $right_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('right_image2')->getClientOriginalName();
            $ext = $request->file('right_image2')->getClientOriginalExtension();
            $request->file('right_image2')->storeAs('public/harvester', $right_image);

        }else {
            $right_image='';
        }

        if(!empty($user->id)){
            $post = DB::table('user')->where('id',$user->id)->first();

            if($post->harvester_post == 0){
                //dd();
                $harvester_count = 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['harvester_post'=>$harvester_count]);
            }else{
                $harvester_count = $post->harvester_post + 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['harvester_post'=>$harvester_count]);
            }
        }


        $insert = DB::table('harvester')->insertGetId(['category_id'=>4,'set'=>$set,'user_id'=>$user->id,'type'=>$type,'brand_id'=>$brand_id,'model_id'=>$model_id,'year_of_purchase'=>$year_of_purchase,
            'crop_type'=>$crop_type,'cutting_with'=>$cutting_with,'power_source'=>$power_source,'description'=>$description,'left_image'=>$left_image,'right_image'=>$right_image,
            'front_image'=>$front_image,'back_image'=>$back_image,'price'=>$price,'rent_type'=>$rent_type,'is_negotiable'=>$is_negotiable,'pincode'=>$pincode,'country_id'=>$country_id,
            'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,
            'status'=>0,'created_at'=>date('Y-m-d H:i:s')]);
            if ($insert) {

        	    $message = 'Your post has been successfully submitted and is now pending for approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
            	 $encode_message = urlencode($message);
                 $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$session.'&message='.$encode_message.'&format=json';
                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt($ch, CURLOPT_URL, $url);
                 $res = curl_exec($ch);
            }
            return redirect ('harvester/'.$insert);

    }

    public function harvester_product (Request $request) {
        $harvester_id = $request->id;
        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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


        $data = Harvester::harvester_single($harvester_id,$user_id);
        $set = $data['set'];
        $type = $data['type'];
        if ($set=='rent') {
            $related_product = Harvester::harvester_data_rent($user_id,$set,$pincode,$district,$state,'related_item',0,100);
        } else {
            if ($type=='new') {$set = 'new';}
            else if ($type=='old') {$set = 'old';}
            $related_product = Harvester::harvester_data($user_id,$set,$pincode,$district,$state,'related_item',0,100);
        }

        //print_r($data);
        return view('front.development.harvester-product',['data'=>$data,'pincode'=>$pincode,'user_id'=>$user_id,'related_product'=>$related_product]);
    }

    public function implements_post () {
        $brand = DB::table('brand')->where(['status'=>1,'category_id'=>5])->get();
        $model = DB::table('model')->where(['status'=>1])->get();
        return view('front.development.implement-post',['brand'=>$brand,'model'=>$model]);
    }

    public function implements_posting (Request $request) {
         $set = $request->set;
         $type = $request->type;
         $brand_id = $request->brand_id;
         $model_id = $request->model_id;
         $year_of_purchase = $request->yop;
         $price = $request->price;
         $is_negotiable = $request->is_negotiable;
         $pincode = $request->pincode;
         $description = $request->description;


        $city_s = DB::table('city')->where(['pincode'=>$pincode])->first();
            $country_id = $city_s->country_id;
            $state_id = $city_s->state_id;
            $district_id = $city_s->district_id;
            $city_id = $city_s->id;
            $latitude = $city_s->latitude;
            $longitude = $city_s->longitude;

        $session = $request->session()->get('KVMobile');
        $user = DB::table('user')->where(['mobile'=>$session])->first();

        if ($front_image = $request->file('front_image1')) {
            $front_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('front_image1')->getClientOriginalName();
            $ext = $request->file('front_image1')->getClientOriginalExtension();

            $request->file('front_image1')->storeAs('public/implements', $front_image);

        } else {
            $front_image='';
        }
        if ($front_image = $request->file('front_image2')) {
            $front_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('front_image2')->getClientOriginalName();
            $ext = $request->file('front_image2')->getClientOriginalExtension();

            $request->file('front_image2')->storeAs('public/implements', $front_image);

        }else {
            $front_image='';
        }
        if ($back_image = $request->file('back_image1')) {
            $back_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('back_image1')->getClientOriginalName();
            $ext = $request->file('back_image1')->getClientOriginalExtension();
            $request->file('back_image1')->storeAs('public/implements', $back_image);

        }else {
            $back_image='';
        }
        if ($back_image = $request->file('back_image2')) {
            $back_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('back_image2')->getClientOriginalName();
            $ext = $request->file('back_image2')->getClientOriginalExtension();
            $request->file('back_image2')->storeAs('public/implements', $back_image);

        }else {
            $back_image='';
        }
        if ($left_image = $request->file('left_image1')) {
            $left_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('left_image1')->getClientOriginalName();
            $ext = $request->file('left_image1')->getClientOriginalExtension();
            $request->file('left_image1')->storeAs('public/implements', $left_image);

        }else {
            $left_image='';
        }
        if ($left_image = $request->file('left_image2')) {
            $left_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('left_image2')->getClientOriginalName();
            $ext = $request->file('left_image2')->getClientOriginalExtension();
            $request->file('left_image2')->storeAs('public/implements', $left_image);

        }else {
            $left_image='';
        }
        if ($right_image = $request->file('right_image1')) {
            $right_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('right_image1')->getClientOriginalName();
            $ext = $request->file('right_image1')->getClientOriginalExtension();
            $request->file('right_image1')->storeAs('public/implements', $right_image);

        }else {
            $right_image='';
        }
        if ($right_image = $request->file('right_image2')) {
            $right_image = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('right_image2')->getClientOriginalName();
            $ext = $request->file('right_image2')->getClientOriginalExtension();
            $request->file('right_image2')->storeAs('public/implements', $right_image);

        }else {
            $right_image='';
        }

        if(!empty($user->id)){
            $post = DB::table('user')->where('id',$user->id)->first();

            if($post->implement_post == 0){
                $implement_count = 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['implement_post'=>$implement_count]);
            }else{
                $implement_count = $post->implement_post + 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['implement_post'=>$implement_count]);
            }
        }


        $insert = DB::table('implements')->insertGetId(['category_id'=>5,'set'=>$set,'user_id'=>$user->id,'type'=>$type,'brand_id'=>$brand_id,'model_id'=>$model_id,'year_of_purchase'=>$year_of_purchase,
            'description'=>$description,'left_image'=>$left_image,'right_image'=>$right_image,
            'front_image'=>$front_image,'back_image'=>$back_image,'price'=>$price,'is_negotiable'=>$is_negotiable,'pincode'=>$pincode,'country_id'=>$country_id,
            'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,
            'status'=>0,'created_at'=>date('Y-m-d H:i:s')]);
            if ($insert) {

        	    $message = 'Your post has been successfully submitted and is now pending for approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
                $encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$session.'&message='.$encode_message.'&format=json';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                $res = curl_exec($ch);
            }
        return redirect ('implements/'.$insert);

    }

    public function implements_product (Request $request) {
        $implements_id = $request->id;
        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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


        $data = Implement::implement_single($implements_id,$user_id);
        $set = $data['set'];
        $type = $data['type'];
        if ($set=='rent') {
            $related_product = Implement::implement_data_rent($user_id,$set,$pincode,$district,$state,'related_item',0,100);
        } else {
            if ($type=='new') {$set = 'new';}
            else if ($type=='old') {$set = 'old';}
            $related_product = Implement::implement_data($user_id,$set,$pincode,$district,$state,'related_item',0,100);
        }
        $data = Implement::implement_single($implements_id,0);
        //print_r($data);
        return view('front.development.implements-product',['data'=>$data,'pincode'=>$pincode,'user_id'=>$user_id,'related_product'=>$related_product]);
    }

    public function seeds_post () {
        $brand = DB::table('brand')->where(['status'=>1,'category_id'=>6])->get();
        $model = DB::table('model')->where(['status'=>1])->get();
        return view('front.development.seeds-post',['brand'=>$brand,'model'=>$model]);
    }

    public function seeds_posting (Request $request) {
        $title = $request->title;
        $price = $request->price;
        $is_negotiable = $request->is_negotiable;
        $pincode = $request->pincode;
        $description = $request->description;

        $city_s = DB::table('city')->where(['pincode'=>$pincode])->first();
            $country_id = $city_s->country_id;
            $state_id = $city_s->state_id;
            $district_id = $city_s->district_id;
            $city_id = $city_s->id;
            $latitude = $city_s->latitude;
            $longitude = $city_s->longitude;

        $session = $request->session()->get('KVMobile');
        $user = DB::table('user')->where(['mobile'=>$session])->first();

        if ($image1 = $request->file('image1_1')) {
            $image1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1_1')->getClientOriginalName();
            $ext = $request->file('image1_1')->getClientOriginalExtension();

            $request->file('image1_1')->storeAs('public/seeds', $image1);

        } else {
            $image1='';
        }
        if ($image1 = $request->file('image1_2')) {
            $image1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1_2')->getClientOriginalName();
            $ext = $request->file('image1_2')->getClientOriginalExtension();

            $request->file('image1_2')->storeAs('public/seeds', $image1);

        }else {
            $image1='';
        }
        if ($image2 = $request->file('image2_1')) {
            $image2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2_1')->getClientOriginalName();
            $ext = $request->file('image2_1')->getClientOriginalExtension();
            $request->file('image2_1')->storeAs('public/seeds', $image2);

        }else {
            $image2='';
        }
        if ($image2 = $request->file('image2_2')) {
            $image2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2_2')->getClientOriginalName();
            $ext = $request->file('image2_2')->getClientOriginalExtension();
            $request->file('image2_2')->storeAs('public/seeds', $image2);

        }else {
            $image2='';
        }
        if ($image3 = $request->file('image3_1')) {
            $image3 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3_1')->getClientOriginalName();
            $ext = $request->file('image3_1')->getClientOriginalExtension();
            $request->file('image3_1')->storeAs('public/seeds', $image3);

        }else {
            $image3='';
        }
        if ($image3 = $request->file('image3_2')) {
            $image3 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3_2')->getClientOriginalName();
            $ext = $request->file('image3_2')->getClientOriginalExtension();
            $request->file('image3_2')->storeAs('public/seeds', $image3);

        }else {
            $image3='';
        }

        if(!empty($user->id)){
            $post = DB::table('user')->where('id',$user->id)->first();

            if($post->seed_post == 0){
                //dd();
                $seed_count = 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['seed_post'=>$seed_count]);
            }else{
                $seed_count = $post->seed_post + 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['seed_post'=>$seed_count]);
            }
        }


        $insert = DB::table('seeds')->insertGetId(['category_id'=>6,'title'=>$title,'user_id'=>$user->id,
            'description'=>$description,'image1'=>$image1,'image2'=>$image2,
            'image3'=>$image3,'price'=>$price,'is_negotiable'=>$is_negotiable,'pincode'=>$pincode,'country_id'=>$country_id,
            'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,'status'=>0,'created_at'=>date('Y-m-d H:i:s')]);
            if ($insert) {

        	    $message = 'Your post has been successfully submitted and is now pending for approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
            	 $encode_message = urlencode($message);
                 $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$session.'&message='.$encode_message.'&format=json';
                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt($ch, CURLOPT_URL, $url);
                 $res = curl_exec($ch);
            }
            return redirect ('seed/'.$insert);
    }

    public function seed_product (Request $request) {
        $seed_id = $request->id;
        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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


        $data = Seed::seed_single($seed_id,$user_id);
        $related_product = Seed::seeds_data($user_id,$pincode,$district,$state,'related_item',0,20);


        //print_r($data);
        return view('front.development.seed-product',['data'=>$data,'pincode'=>$pincode,'user_id'=>$user_id,'related_product'=>$related_product]);
    }

    public function pesticide_post () {
        $brand = DB::table('brand')->where(['status'=>1])->get();
        $model = DB::table('model')->where(['status'=>1])->get();
        return view('front.development.pesticide-post',['brand'=>$brand,'model'=>$model]);
    }

    public function pesticide_posting (Request $request) {
        $title = $request->title;
        $price = $request->price;
        $is_negotiable = $request->is_negotiable;
        $pincode = $request->pincode;
        $description = $request->description;

        $city_s = DB::table('city')->where(['pincode'=>$pincode])->first();
            $country_id = $city_s->country_id;
            $state_id = $city_s->state_id;
            $district_id = $city_s->district_id;
            $city_id = $city_s->id;
            $latitude = $city_s->latitude;
            $longitude = $city_s->longitude;

        $session = $request->session()->get('KVMobile');
        $user = DB::table('user')->where(['mobile'=>$session])->first();

        if ($image1 = $request->file('image1_1')) {
            $image1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1_1')->getClientOriginalName();
            $ext = $request->file('image1_1')->getClientOriginalExtension();

            $request->file('image1_1')->storeAs('public/pesticides', $image1);

        } else {
            $image1='';
        }
        if ($image1 = $request->file('image1_2')) {
            $image1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1_2')->getClientOriginalName();
            $ext = $request->file('image1_2')->getClientOriginalExtension();

            $request->file('image1_2')->storeAs('public/pesticides', $image1);

        }else {
            $image1='';
        }
        if ($image2 = $request->file('image2_1')) {
            $image2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2_1')->getClientOriginalName();
            $ext = $request->file('image2_1')->getClientOriginalExtension();
            $request->file('image2_1')->storeAs('public/pesticides', $image2);

        }else {
            $image2='';
        }
        if ($image2 = $request->file('image2_2')) {
            $image2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2_2')->getClientOriginalName();
            $ext = $request->file('image2_2')->getClientOriginalExtension();
            $request->file('image2_2')->storeAs('public/pesticides', $image2);

        }else {
            $image2='';
        }
        if ($image3 = $request->file('image3_1')) {
            $image3 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3_1')->getClientOriginalName();
            $ext = $request->file('image3_1')->getClientOriginalExtension();
            $request->file('image3_1')->storeAs('public/pesticides', $image3);

        }else {
            $image3='';
        }
        if ($image3 = $request->file('image3_2')) {
            $image3 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3_2')->getClientOriginalName();
            $ext = $request->file('image3_2')->getClientOriginalExtension();
            $request->file('image3_2')->storeAs('public/pesticides', $image3);

        }else {
            $image3='';
        }

        if(!empty($user->id)){
            $post = DB::table('user')->where('id',$user->id)->first();

            if($post->pesticides_post == 0){
                $pesticides_count = 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['pesticides_post'=>$pesticides_count]);
            }else{
                $pesticides_count = $post->pesticides_post + 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['pesticides_post'=>$pesticides_count]);
            }
        }

        $insert = DB::table('pesticides')->insertGetId(['category_id'=>8,'title'=>$title,'user_id'=>$user->id,
            'description'=>$description,'image1'=>$image1,'image2'=>$image2,
            'image3'=>$image3,'price'=>$price,'is_negotiable'=>$is_negotiable,'pincode'=>$pincode,'country_id'=>$country_id,
            'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,'status'=>0,'created_at'=>date('Y-m-d H:i:s')]);
            if ($insert) {

        	    $message = 'Your post has been successfully submitted and is now pending for approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
                $encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$session.'&message='.$encode_message.'&format=json';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                $res = curl_exec($ch);
            }
        return redirect ('pesticides/'.$insert);
    }

    public function pesticides_product (Request $request) {
        $pesticides_id = $request->id;
        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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


        $data = pesticides::pesticides_single($pesticides_id,$user_id);
        $related_product = pesticides::pesticides_data($user_id,$pincode,$district,$state,'related_item',0,100);

        //print_r($data);
        return view('front.development.pesticides-product',['data'=>$data,'pincode'=>$pincode,'user_id'=>$user_id,'related_product'=>$related_product]);
    }

    public function fertilizer_post() {
        $brand = DB::table('brand')->where(['status'=>1])->get();
        $model = DB::table('model')->where(['status'=>1])->get();
        return view('front.development.fertilizer-post',['brand'=>$brand,'model'=>$model]);
    }

    public function fertilizer_posting (Request $request) {
        $title = $request->title;
        $price = $request->price;
        $is_negotiable = $request->is_negotiable;
        $pincode = $request->pincode;
        $description = $request->description;

        $city_s = DB::table('city')->where(['pincode'=>$pincode])->first();
        $country_id = $city_s->country_id;
        $state_id = $city_s->state_id;
        $district_id = $city_s->district_id;
        $city_id = $city_s->id;
        $latitude = $city_s->latitude;
        $longitude = $city_s->longitude;

        $session = $request->session()->get('KVMobile');
        $user = DB::table('user')->where(['mobile'=>$session])->first();

        if ($image1 = $request->file('image1_1')) {
            $image1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1_1')->getClientOriginalName();
            $ext = $request->file('image1_1')->getClientOriginalExtension();

            $request->file('image1_1')->storeAs('public/fertilizers', $image1);

        } else {
            $image1='';
        }
        if ($image1 = $request->file('image1_2')) {
            $image1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1_2')->getClientOriginalName();
            $ext = $request->file('image1_2')->getClientOriginalExtension();

            $request->file('image1_2')->storeAs('public/fertilizers', $image1);

        }else {
            $image1='';
        }
        if ($image2 = $request->file('image2_1')) {
            $image2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2_1')->getClientOriginalName();
            $ext = $request->file('image2_1')->getClientOriginalExtension();
            $request->file('image2_1')->storeAs('public/fertilizers', $image2);

        }else {
            $image2='';
        }
        if ($image2 = $request->file('image2_2')) {
            $image2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2_2')->getClientOriginalName();
            $ext = $request->file('image2_2')->getClientOriginalExtension();
            $request->file('image2_2')->storeAs('public/fertilizers', $image2);

        }else {
            $image2='';
        }
        if ($image3 = $request->file('image3_1')) {
            $image3 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3_1')->getClientOriginalName();
            $ext = $request->file('image3_1')->getClientOriginalExtension();
            $request->file('image3_1')->storeAs('public/fertilizers', $image3);

        }else {
            $image3='';
        }
        if ($image3 = $request->file('image3_2')) {
            $image3 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3_2')->getClientOriginalName();
            $ext = $request->file('image3_2')->getClientOriginalExtension();
            $request->file('image3_2')->storeAs('public/fertilizers', $image3);

        }else {
            $image3='';
        }

        if(!empty($user->id)){
            $post = DB::table('user')->where('id',$user->id)->first();

            if($post->fertilizer_post == 0){
                //dd();
                $fertilizer_count = 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['fertilizer_post'=>$fertilizer_count]);
            }else{
                $fertilizer_count = $post->fertilizer_post + 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['fertilizer_post'=>$fertilizer_count]);
            }
        }


        $insert = DB::table('fertilizers')->insertGetId(['category_id'=>9,'title'=>$title,'user_id'=>$user->id,
            'description'=>$description,'image1'=>$image1,'image2'=>$image2,
            'image3'=>$image3,'price'=>$price,'is_negotiable'=>$is_negotiable,'pincode'=>$pincode,'country_id'=>$country_id,
            'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,'status'=>0,'created_at'=>date('Y-m-d H:i:s')]);
            if ($insert) {

        	     $message = 'Your post has been successfully submitted and is now pending for approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
            	 $encode_message = urlencode($message);
                 $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$session.'&message='.$encode_message.'&format=json';
                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt($ch, CURLOPT_URL, $url);
                 $res = curl_exec($ch);
            }
            return redirect ('fertilizers/'.$insert);

    }

    public function fertilizers_product (Request $request) {
        $fertilizer_id = $request->id;
        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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


        $data = fertilizers::fertilizers_single($fertilizer_id,$user_id);
        $related_product = fertilizers::fertilizers_data($user_id,$pincode,$district,$state,'related_item',0,100);

        //print_r($data);
        return view('front.development.fertilizers-product',['data'=>$data,'pincode'=>$pincode,'user_id'=>$user_id,'related_product'=>$related_product]);
    }

    public function tyre_post () {
        $brand = DB::table('brand')->where(['status'=>1,'category_id'=>7])->get();
        $model = DB::table('model')->where(['status'=>1])->get();
        return view('front.development.tyre-post',['brand'=>$brand,'model'=>$model]);
    }

    public function tyre_posting (Request $request) {
        $type = $request->type;
        $brand_id = $request->brand_id;
        $model_id = $request->model_id;
        $year_of_purchase = $request->yop;
        $position = $request->position;
        $price = $request->price;
        $is_negotiable = $request->is_negotiable;
        $pincode = $request->pincode;
        $description = $request->description;

        $city_s = DB::table('city')->where(['pincode'=>$pincode])->first();
            $country_id = $city_s->country_id;
            $state_id = $city_s->state_id;
            $district_id = $city_s->district_id;
            $city_id = $city_s->id;
            $latitude = $city_s->latitude;
            $longitude = $city_s->longitude;

        $session = $request->session()->get('KVMobile');
        $user = DB::table('user')->where(['mobile'=>$session])->first();

        if ($image1 = $request->file('image1_1')) {
            $image1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1_1')->getClientOriginalName();
            $ext = $request->file('image1_1')->getClientOriginalExtension();

            $request->file('image1_1')->storeAs('public/tyre', $image1);

        }else {
            $image1='';
        }
        if ($image1 = $request->file('image1_2')) {
            $image1 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1_2')->getClientOriginalName();
            $ext = $request->file('image1_2')->getClientOriginalExtension();
            $request->file('image1_2')->storeAs('public/tyre', $image1);

        }else {
            $image1='';
        }
        if ($image2 = $request->file('image2_1')) {
            $image2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2_1')->getClientOriginalName();
            $ext = $request->file('image2_1')->getClientOriginalExtension();
            $request->file('image2_1')->storeAs('public/tyre', $image2);

        }else {
            $image2='';
        }
        if ($image2 = $request->file('image2_2')) {
            $image2 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2_2')->getClientOriginalName();
            $ext = $request->file('image2_2')->getClientOriginalExtension();
            $request->file('image2_2')->storeAs('public/tyre', $image2);

        }else {
            $image2='';
        }
        if ($image3 = $request->file('image3_1')) {
            $image3 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3_1')->getClientOriginalName();
            $ext = $request->file('image3_1')->getClientOriginalExtension();
            $request->file('image3_1')->storeAs('public/tyre', $image3);

        }else {
            $image3='';
        }
        if ($image3 = $request->file('image3_2')) {
            $image3 = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3_2')->getClientOriginalName();
            $ext = $request->file('image3_2')->getClientOriginalExtension();
            $request->file('image3_2')->storeAs('public/tyre', $image3);

        }else {
            $image3='';
        }

        if(!empty($user->id)){
            $post = DB::table('user')->where('id',$user->id)->first();

            if($post->tyre_post == 0){
                $tyre_count = 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['tyre_post'=>$tyre_count]);
            }else{
                $tyre_count = $post->tyre_post + 1;
                $update = DB::table('user')->where(['id'=>$user->id])->update(['tyre_post'=>$tyre_count]);
            }
        }

        $insert = DB::table('tyres')->insertGetId(['category_id'=>7,'type'=>$type,'user_id'=>$user->id,'brand_id'=>$brand_id,'model_id'=>$model_id,'year_of_purchase'=>$year_of_purchase,
            'description'=>$description,'position'=>$position,'image1'=>$image1,'image2'=>$image2,
            'image3'=>$image3,'price'=>$price,'is_negotiable'=>$is_negotiable,'pincode'=>$pincode,'country_id'=>$country_id,
            'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,
            'status'=>0,'created_at'=>date('Y-m-d H:i:s')]);
            if ($insert) {

        	     $message = 'Your post has been successfully submitted and is now pending for approval from Krishi Vikas Udyog. Stay tuned for updates! | Krishi Vikas';
            	 $encode_message = urlencode($message);
                 $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number='.$session.'&message='.$encode_message.'&format=json';
                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt($ch, CURLOPT_URL, $url);
                 $res = curl_exec($ch);
            }
            return redirect ('tyre/'.$insert);

    }

    public function tyre_product (Request $request) {
        $tyre_id = $request->id;
        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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


        $data = Tyre::tyre_single($tyre_id,$user_id);
        $type = $data['type'];
        $related_product = Tyre::tyre_data($user_id,$type,$pincode,$district,$state,'related_item',0,100);

        //print_r($data);
        return view('front.development.tyre-product',['data'=>$data,'pincode'=>$pincode,'user_id'=>$user_id,'related_product'=>$related_product]);
    }

    public function tractor_list (Request $request) {
        if(Session()->has('type')) { Session()->forget('type'); }
        if(Session()->has('condition')) { Session()->forget('condition'); }
        if(Session()->has('state')) { Session()->forget('state'); }
        if(Session()->has('district')) { Session()->forget('district'); }
        if(Session()->has('yop')) { Session()->forget('yop'); }
        if(Session()->has('min_price')) { Session()->forget('min_price'); }
        if(Session()->has('max_price')) { Session()->forget('max_price'); }

        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

            $latitude  = $pindata->latitude;
            $longitude = $pindata->longitude;
        }

        $type = $request->type;
        $app_section = 'viewall';
        if ($type=='rent') {
            $new = [];
          //  $new = Tractor::tractor_data_rent($user_id,$type,$pincode,$district,$state,$app_section,0,0);
        } else {
            $new = Tractor::tractor_data($user_id,$type,$pincode,$district,$state,$app_section,0,0);
        }

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();
        $brand_name   = DB::table('brand')->where('category_id',1)->where('popular',1)->get();
        
       // dd($type);
        /** Dibyendu Change 29.08.2023 */
        if($type=='rent'){
           // dd("rent");
          //  echo $type;
            //$tr_rent = Tractor::where('type','rent')->paginate(10);
            $tr_rent = DB::table('tractorView')
                        ->select('tractorView.id','tractorView.city_name','tractorView.brand_id','tractorView.model_id','tractorView.district_id','tractorView.state_id','tractorView.country_id','tractorView.state_id','tractorView.country_id','tractorView.pincode'
                        ,'tractorView.front_image','tractorView.left_image','tractorView.right_image','tractorView.back_image','tractorView.price','tractorView.set','tractorView.rent_type','tractorView.status'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tractorView.latitude))
                        * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tractorView.latitude))) AS distance"))
                        ->orderBy('distance','asc')
                        ->whereIn('status',[1,4])
                        ->where('set','rent')
                         ->paginate(12);
                       // ->get();
                       // dd($tr_rent);
        }else if($type=='old'){
        // $tr_rent = Tractor::where('type','old')->paginate(10);
           $tr_rent = DB::table('tractorView')
                    ->select('tractorView.id','tractorView.city_name','tractorView.brand_id','tractorView.model_id','tractorView.district_id','tractorView.state_id','tractorView.country_id','tractorView.state_id','tractorView.country_id','tractorView.pincode'
                    ,'tractorView.front_image','tractorView.left_image','tractorView.right_image','tractorView.back_image','tractorView.price','tractorView.set','tractorView.rent_type','tractorView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(tractorView.latitude))
                    * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(tractorView.latitude))) AS distance"))
                    ->where('set','sell')
                    ->where('type','old')
                    ->whereIn('status',[1,4])
                    ->orderBy('distance','asc')
                    ->paginate(12);


        }else if($type=='new'){
            //$tr_rent = Tractor::where('type','new')->paginate(10);
            $tr_rent = DB::table('tractorView')
                        ->select('tractorView.id','tractorView.city_name','tractorView.brand_id','tractorView.model_id','tractorView.district_id','tractorView.state_id','tractorView.country_id','tractorView.state_id','tractorView.country_id','tractorView.pincode'
                        ,'tractorView.front_image','tractorView.left_image','tractorView.right_image','tractorView.back_image','tractorView.price','tractorView.set','tractorView.rent_type','tractorView.status'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tractorView.latitude))
                        * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tractorView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->where('set','sell')
                        ->where('type','new')
                        ->paginate(12);

            // $tr_rent = DB::table('tractorView as t')
            //             ->select('*', DB::raw('6371 * ACOS(
            //                 COS(RADIANS('.$latitude.')) * COS(RADIANS(t.latitude)) * COS(RADIANS(t.longitude) - RADIANS('.$longitude.')) +
            //                 SIN(RADIANS('.$latitude.')) * SIN(RADIANS(t.latitude))
            //             ) as distance'))
            //             ->where('t.set', '=', 'sell')
            //             ->where('t.type', '=', 'new')
            //             ->whereIn('t.status', [1, 4])
            //             ->orderBy('distance', 'ASC')
            //             ->join('user as u', 'u.id', '=', 't.user_id')
            //             ->paginate(12);
        }

        // return view('front.development.tractor-list-grid',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        //             'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

        /** Dibyendu Change 29.08.2023 */
        return view('front.development.tractor-list-grid',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
                    'district_arr'=>$district_arr,'district'=>$district,'brand_name' => $brand_name,'pincode'=>$pincode,'tr_rent'=> $tr_rent]);
    }

    public function tractor_filter1 (Request $request) {
        if(Session()->has('type')) { Session()->forget('type'); }
        if(Session()->has('condition')) { Session()->forget('condition'); }
        if(Session()->has('state')) { Session()->forget('state'); }
        if(Session()->has('district')) { Session()->forget('district'); }
        if(Session()->has('yop')) { Session()->forget('yop'); }
        if(Session()->has('min_price')) { Session()->forget('min_price'); }
        if(Session()->has('max_price')) { Session()->forget('max_price'); }

        $type = $request->type;
        $condition = $request->condition;
        $state = $request->state;
        $district = $request->district;
        $yop = $request->yop;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        session()->put('type',$type);
        session()->put('condition',$condition);
        session()->put('state',$state);
        session()->put('district',$district);
        session()->put('yop',$yop);
        session()->put('min_price',$min_price);
        session()->put('max_price',$max_price);

        $query = DB::table('tractor')->orderBy('id','desc')->where('status',1);
            //$state_array = explode (',',$state);
            if (isset($type)) {
                $type1 = implode(',',$type);
                $query->whereIn('set', $type);
            }
            if (isset($condition)) {
                $condition1 = implode(',',$condition);
                $query->whereIn('type', $condition);
            }
            if ($state!='') {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if (isset($yop)) {
                $yop1 = implode(',',$yop);
               $query->whereIn('year_of_purchase', $yop);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);


            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $type = $request->type;
            $app_section = 'viewall';

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.tractor-list-grid',['data12'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }

    /** Dibyendu Change 26.09.2023 */
    public function tractor_filter (Request $request) {

        if(Session()->has('type')) { Session()->forget('type'); }
        if(Session()->has('condition')) { Session()->forget('condition'); }
        if(Session()->has('state')) { Session()->forget('state'); }
        if(Session()->has('district')) { Session()->forget('district'); }
        if(Session()->has('yop')) { Session()->forget('yop'); }
        if(Session()->has('min_price')) { Session()->forget('min_price'); }
        if(Session()->has('max_price')) { Session()->forget('max_price'); }

        $type = $request->type;
        $condition = $request->condition;
        $state = $request->state;
        $district = $request->district;
        $yop = $request->yop;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $brand_name = $request->brand;

        $state1 = implode(', ', $state);

        session()->put('type',$type);
        session()->put('condition',$condition);
        session()->put('state',$state);
        session()->put('district',$district);
        session()->put('yop',$yop);
        session()->put('min_price',$min_price);
        session()->put('max_price',$max_price);

        //dd($condition);

        $pincode   = $request->session()->get('pincode');
        $pindata   = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude  = $pindata->latitude;
        $longitude = $pindata->longitude;
        //dd($pincode);

      //  $query = DB::table('tractor')->orderBy('id','desc')->where('status',1);
        $query = DB::table('tractorView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(tractorView.latitude))
                * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(tractorView.latitude))) AS distance"))
                ->whereIn('status',[1,4]);

            //$state_array = explode (',',$state);
            if (isset($type)) {
                $type1 = implode(',',$type);
                $query->whereIn('set', $type);
            }
            if (isset($condition)) {
                $condition1 = implode(',',$condition);
                $query->whereIn('type', $condition);
            }
            if ($state!='') {
                $query->whereIn('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if (isset($yop)) {
                $yop1 = implode(',',$yop);
            $query->whereIn('year_of_purchase', $yop);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            if (isset($brand_name)) {
            $query->whereIn('brand_id', $brand_name);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);

            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $type = $request->type;
            $app_section = 'viewall';

            $state_arr    = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();
            $brandName    = DB::table('brand')->where('category_id',1)->get();

        return view('front.development.tractor-list-grid',['data12'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'brandName'=>$brandName,'district'=>$district,'pincode'=>$pincode,'state1'=>$state1]);
    }
    
    //not required
    public function tractor_filter_Sort () {
        $type = session()->get('type');
        $condition = session()->get('condition');
        $state = session()->get('state');
        $district = session()->get('district');
        $yop = session()->get('yop');
        $min_price = session()->get('min_price');
        $max_price = session()->get('max_price');

        $query = DB::table('tractor')->orderBy('id','desc')->where('status',1);

            //$state_array = explode (',',$state);
            if (isset($type)) {
                $type1 = implode(',',$type);
                $query->whereIn('set', $type);
            }
            if (isset($condition)) {
                $condition1 = implode(',',$condition);
                $query->whereIn('type', $condition);
            }
            if ($state!='') {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if (isset($yop)) {
                $yop1 = implode(',',$yop);
               $query->whereIn('year_of_purchase', $yop);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);


            if (session()->has('users_id')) {
                $user_id = session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if (session()->has('pincode')) {
                $pincode = session()->get('pincode');
            //}
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

            //$type = $request->type;
            $app_section = 'viewall';

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

            /** Dibyendu Change 28.08.2023 */
            $tr_rent = Tractor::whereBetween('price',['0','100000'])->paginate(10);
          //  dd($tr_rent);


        return view('front.development.tractor-list-grid',['data12'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode,'tr_rent'=>$tr_rent]);

    }
    
    public function tractorFilterData(Request $request ,$sort,$type){
        $d         = session()->has('type');
        $pincode   = $request->session()->get('pincode');
        $pindata   = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude  = $pindata->latitude;
        $longitude = $pindata->longitude;

        if($sort == 'plh'){
            if($type == 'new' || $type == 'old'){
                $query = DB::table('tractorView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tractorView.latitude))
                        * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tractorView.latitude))) AS distance"))
                        ->orderBy('price','asc')
                        ->where('status',1)
                        ->where('type',$type)
                        ->where('set','sell')
                        ->whereBetween('price',[0,100000000])->paginate(12);
            }
            else if($type == 'rent'){
                $query =DB::table('tractorView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tractorView.latitude))
                        * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tractorView.latitude))) AS distance"))
                       ->orderBy('price','asc')
                       ->where('status',1)
                       ->where('set','rent')
                       ->whereBetween('price',[0,100000000])
                       ->paginate(12);
            }
        }
        if($sort == 'phl'){
            if($type == 'new' || $type == 'old'){
                $query = DB::table('tractorView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tractorView.latitude))
                        * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tractorView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('set','sell')
                        ->where('type',$type)
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }else if($type == 'rent'){
                $query = DB::table('tractorView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tractorView.latitude))
                        * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tractorView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('set','rent')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
        }
        if($sort == 'nf'){
            if($type == 'new' || $type == 'old'){
                $query = DB::table('tractorView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tractorView.latitude))
                        * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tractorView.latitude))) AS distance"))
                        ->orderBy('id','desc')
                        ->whereIn('status',[1,4])
                        ->where('set','sell')
                        ->where('type',$type)
                        ->paginate(12);
            }
            else if($type == 'rent'){
                $query = DB::table('tractorView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tractorView.latitude))
                        * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tractorView.latitude))) AS distance"))
                        ->orderBy('id','desc')
                        ->where('set','rent')
                        ->whereIn('status',[1,4])
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
        }

        if (session()->has('users_id')) {
            $user_id = session()->get('users_id');
        } else {
            $user_id = 0;
        }

        $pincode = session()->get('pincode');

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

        //$type = $request->type;
        $app_section = 'viewall';

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();
        $brand_name   = DB::table('brand')->where('category_id',1)->where('popular',1)->get();

        return view('front.development.tractor-list-grid',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode ,'brand_name'=>$brand_name]);

    }

    public function good_vehicle_list (Request $request) {
        if(Session()->has('type')) { Session()->forget('type'); }
        if(Session()->has('condition')) { Session()->forget('condition'); }
        if(Session()->has('state')) { Session()->forget('state'); }
        if(Session()->has('district')) { Session()->forget('district'); }
        if(Session()->has('yop')) { Session()->forget('yop'); }
        if(Session()->has('min_price')) { Session()->forget('min_price'); }
        if(Session()->has('max_price')) { Session()->forget('max_price'); }

        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

        $type = $request->type;
        $app_section = 'viewall';
        if ($type=='rent') {
            $new = Goods_vehicle::gv_data_rent($user_id,$type,$pincode,$district,$state,$app_section,0,0);
        } else {
            $new = Goods_vehicle::gv_data($user_id,$type,$pincode,$district,$state,$app_section,0,0);
        }

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        /** Dibyendu Change 29.08.2023 */
        //dd($state);
        if($type=='rent'){
            //$gv_rent = Goods_vehicle::where('type','rent')->paginate(10);
            $gv_rent = DB::table('goodVehicleView')
                ->select('goodVehicleView.id','goodVehicleView.city_name','goodVehicleView.brand_id','goodVehicleView.model_id','goodVehicleView.district_id','goodVehicleView.state_id','goodVehicleView.country_id','goodVehicleView.state_id','goodVehicleView.country_id','goodVehicleView.pincode'
                ,'goodVehicleView.front_image','goodVehicleView.left_image','goodVehicleView.right_image','goodVehicleView.back_image','goodVehicleView.price','goodVehicleView.set','goodVehicleView.rent_type','goodVehicleView.status'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(goodVehicleView.latitude))
                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(goodVehicleView.latitude))) AS distance"))
                ->whereIn('status',[1,4])
                ->orderBy('distance','asc')
                ->where('set','rent')
                ->paginate(12);

           // dd($gv_rent);
        }else if($type=='old'){
           // $gv_rent = Goods_vehicle::where('type','old')->paginate(10);
           $gv_rent = DB::table('goodVehicleView')
                    ->select('goodVehicleView.id','goodVehicleView.city_name','goodVehicleView.brand_id','goodVehicleView.model_id','goodVehicleView.district_id','goodVehicleView.state_id','goodVehicleView.country_id','goodVehicleView.state_id','goodVehicleView.country_id','goodVehicleView.pincode'
                    ,'goodVehicleView.front_image','goodVehicleView.left_image','goodVehicleView.right_image','goodVehicleView.back_image','goodVehicleView.price','goodVehicleView.set','goodVehicleView.rent_type','goodVehicleView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(goodVehicleView.latitude))
                    * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(goodVehicleView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('distance','asc')
                    ->where('set','sell')
                    ->where('type','old')
                    ->paginate(12);

        }else if($type=='new'){
            //$gv_rent = Goods_vehicle::where('type','new')->paginate(10);
            $gv_rent = DB::table('goodVehicleView')
                    ->select('goodVehicleView.id','goodVehicleView.city_name','goodVehicleView.brand_id','goodVehicleView.model_id','goodVehicleView.district_id','goodVehicleView.state_id','goodVehicleView.country_id','goodVehicleView.state_id','goodVehicleView.country_id','goodVehicleView.pincode'
                    ,'goodVehicleView.front_image','goodVehicleView.left_image','goodVehicleView.right_image','goodVehicleView.back_image','goodVehicleView.price','goodVehicleView.set','goodVehicleView.rent_type','goodVehicleView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(goodVehicleView.latitude))
                    * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(goodVehicleView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('distance','asc')
                    ->where('set','sell')
                    ->where('type','new')
                    ->paginate(12);
        }

        /** Dibyendu Change 29.08.2023 */
        return view('front.development.good-vehicle-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode,'gv_rent'=>$gv_rent]);

        // return view('front.development.good-vehicle-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        // 'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode , 'gv_rent'=>$gv_rent,'user_id'=>$user_id,'type'=>$type,
        // 'pincode'=>$pincode,'district'=>$district,'state'=>$state,'app_section'=>$app_section]);
    }

    public function good_vehicle_filter (Request $request) {
        $type = $request->type;
        $condition = $request->condition;
        $state = $request->state;
        $district = $request->district;
        $yop = $request->yop;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $request->session()->put('type',$type);
        $request->session()->put('condition',$condition);
        $request->session()->put('state',$state);
        $request->session()->put('district',$district);
        $request->session()->put('yop',$yop);
        $request->session()->put('min_price',$min_price);
        $request->session()->put('max_price',$max_price);

        $query = DB::table('goods_vehicle')->orderBy('id','desc')->where('status',1);

            if (isset($type)) {
                $type1 = implode(',',$type);
                $query->whereIn('set', $type);
            }
            if (isset($condition)) {
                $condition1 = implode(',',$condition);
                $query->whereIn('type', $condition);
            }
            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if (isset($yop)) {
                $yop1 = implode(',',$yop);
               $query->whereIn('year_of_purchase', $yop);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);


            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

            // if($type=='plh'){
            //     $gv_rent = Goods_vehicle::where('type','rent')->paginate(20);
            // }else if($type=='old'){
            //     $gv_rent = Goods_vehicle::where('type','old')->paginate(20);
            // }else if($type=='new'){
            //     $gv_rent = Goods_vehicle::where('type','new')->paginate(20);
            // }
           //$gv_rent= Goods_vehicle::orderBy('id','desc')->paginate(10);
          // dd($gv_rent);
          


        // return view('front.development.good-vehicle-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        // 'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

        return view('front.development.good-vehicle-list',['data12'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode ]);

    }

    //not required
    public function good_vehicle_filter_sort (Request $request) {
        $type = session()->get('type');
        $condition = session()->get('condition');
        $state = session()->get('state');
        $district = session()->get('district');
        $yop = session()->get('yop');
        $min_price = session()->get('min_price');
        $max_price = session()->get('max_price');

        $query = DB::table('goods_vehicle')->orderBy('id','desc')->where('status',1);

            if (isset($type)) {
                $type1 = implode(',',$type);
                $query->whereIn('set', $type);
            }
            if (isset($condition)) {
                $condition1 = implode(',',$condition);
                $query->whereIn('type', $condition);
            }
            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if (isset($yop)) {
                $yop1 = implode(',',$yop);
               $query->whereIn('year_of_purchase', $yop);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();

            //print_r($query);
            //$new['count'] = count($array_tractor_model);

            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
           // }
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

            /** Dibyendu 28.08.2023 */
            $gv_rent= Goods_vehicle::orderBy('id','desc')->paginate(20);
            //dd($gv_rent);

            // return view('front.development.good-vehicle-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
            // 'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

            /** Dibyendu Change 28.08.2023 */

        return view('front.development.good-vehicle-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode ,'gv_rent'=>$gv_rent]);

    }
    
    public function good_vehicle_filter_data(Request $request,$sort,$type){

        $pincode   = $request->session()->get('pincode');
        $pindata   = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude  = $pindata->latitude;
        $longitude = $pindata->longitude;

        if($sort == 'plh'){
            if($type == 'new'){
                $query = DB::table('goodVehicleView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(goodVehicleView.latitude))
                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                        ->orderBy('price','asc')
                        ->where('status',1)
                        ->where('type','new')
                        ->where('set','sell')
                        ->whereBetween('price',[0,10000000000])
                        ->paginate(12);
            }
            if($type == 'old'){
                $query = DB::table('goodVehicleView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(goodVehicleView.latitude))
                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                        ->orderBy('price','asc')
                        ->where('status',1)
                        ->where('type','old')
                        ->where('set','sell')
                        ->whereBetween('price',[0,10000000000])
                        ->paginate(12);
            }
            if($type == 'rent'){
                $query = DB::table('goodVehicleView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(goodVehicleView.latitude))
                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                        ->orderBy('price','asc')
                        ->where('status',1)
                        ->where('set','rent')
                        ->whereBetween('price',[0,10000000000])
                        ->paginate(12);
            }
        }

        if($sort == 'phl'){
            if($type == 'new'){
                $query = DB::table('goodVehicleView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(goodVehicleView.latitude))
                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('set','sell')
                        ->where('type','new')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
            if($type == 'old'){
                $query = DB::table('goodVehicleView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(goodVehicleView.latitude))
                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('set','sell')
                        ->where('type','old')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
            if($type == 'rent'){
                $query = DB::table('goodVehicleView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(goodVehicleView.latitude))
                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('set','rent')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
        }
        if($sort == 'nf'){
            if($type == 'new'){
                $query = DB::table('goodVehicleView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(goodVehicleView.latitude))
                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('status',1)
                        ->where('set','sell')
                        ->where('type','new')
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
            if($type == 'old'){
                $query = DB::table('goodVehicleView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(goodVehicleView.latitude))
                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('status',1)
                        ->where('set','sell')
                        ->where('type','old')
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
            if($type == 'rent'){
                $query = DB::table('goodVehicleView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(goodVehicleView.latitude))
                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('set','rent')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
        }

        if (session()->has('users_id')) {
            $user_id = session()->get('users_id');
        } else {
            $user_id = 0;
        }

        $pincode = session()->get('pincode');

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

        $app_section = 'viewall';

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.good-vehicle-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }

    public function harvester_list (Request $request) {
        if(Session()->has('type')) { Session()->forget('type'); }
        if(Session()->has('condition')) { Session()->forget('condition'); }
        if(Session()->has('state')) { Session()->forget('state'); }
        if(Session()->has('district')) { Session()->forget('district'); }
        if(Session()->has('yop')) { Session()->forget('yop'); }
        if(Session()->has('min_price')) { Session()->forget('min_price'); }
        if(Session()->has('max_price')) { Session()->forget('max_price'); }


        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

        $type = $request->type;
        $app_section = 'viewall';
        if ($type=='rent') {
            $new = Harvester::harvester_data_rent($user_id,$type,$pincode,$district,$state,$app_section,0,0);
        } else {
            $new = Harvester::harvester_data($user_id,$type,$pincode,$district,$state,$app_section,0,0);
        }

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        /** Dibyendu Change 28.08.2023 */
        //dd($pincode);

       $latitude = DB::table('city')->where('pincode',$pincode)->first()->latitude;
       $latitude = DB::table('city')->where('pincode',$pincode)->first()->latitude;

       $city = DB::table('city')->where('pincode',$pincode)->first()->id;

       $test = DB::table('harvester')->where('pincode',$pincode)->get();
      // dd($test);

    //    $data = DB::table(' harvesterview ')
    //    ->select(' harvesterview .city_name'
    //    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
    //    * cos(radians( harvesterview .latitude))
    //    * cos(radians( harvesterview .longitude) - radians(" .$longitude. "))
    //    + sin(radians(" .$latitude. "))
    //    * sin(radians( harvesterview .latitude))) AS distance"))
    //    ->orderBy('distance','asc')
    //    ->where('type','new')
    //    ->get();

       //dd($data);

       if($type=='new'){
            $har_type = DB::table('harvesterView')
                        ->select('harvesterView.id','harvesterView.city_name','harvesterView.brand_id','harvesterView.model_id','harvesterView.district_id','harvesterView.state_id','harvesterView.country_id','harvesterView.state_id','harvesterView.country_id','harvesterView.pincode'
                        ,'harvesterView.front_image','harvesterView.left_image','harvesterView.right_image','harvesterView.back_image','harvesterView.price','harvesterView.set','harvesterView.rent_type','harvesterView.status'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->where('set','sell')
                        ->where('type','new')
                        ->paginate(12);
       }
       else if($type=='old'){
            $har_type = DB::table('harvesterView')
                        ->select('harvesterView.id','harvesterView.city_name','harvesterView.brand_id','harvesterView.model_id','harvesterView.district_id','harvesterView.state_id','harvesterView.country_id','harvesterView.state_id','harvesterView.country_id','harvesterView.pincode'
                        ,'harvesterView.front_image','harvesterView.left_image','harvesterView.right_image','harvesterView.back_image','harvesterView.price','harvesterView.set','harvesterView.rent_type','harvesterView.status'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->where('set','sell')
                        ->where('type','old')
                        ->paginate(12);
        }
        else if($type=='rent'){
            $har_type = DB::table('harvesterView')
                        ->select('harvesterView.id','harvesterView.city_name','harvesterView.brand_id','harvesterView.model_id','harvesterView.district_id','harvesterView.state_id','harvesterView.country_id','harvesterView.state_id','harvesterView.country_id','harvesterView.pincode'
                        ,'harvesterView.front_image','harvesterView.left_image','harvesterView.right_image','harvesterView.back_image','harvesterView.price','harvesterView.set','harvesterView.rent_type','harvesterView.status'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->where('set','rent')
                        ->paginate(12);
        }

        // return view('front.development.harvester-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        // 'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

        /** Dibyendu Change 28.08.2023 */
        return view('front.development.harvester-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode,'har_type' =>$har_type]);
    }

    public function harvester_filter (Request $request) {
        $type      = $request->type;
        $condition = $request->condition;
        $state     = $request->state;
        $district  = $request->district;
        $yop       = $request->yop;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $request->session()->put('type',$type);
        $request->session()->put('condition',$condition);
        $request->session()->put('state',$state);
        $request->session()->put('district',$district);
        $request->session()->put('yop',$yop);
        $request->session()->put('min_price',$min_price);
        $request->session()->put('max_price',$max_price);

        $query = DB::table('harvester')->orderBy('id','desc')->where('status',1);

            if (isset($type)) {
                $type1 = implode(',',$type);
                $query->whereIn('set', $type);
            }
            if (isset($condition)) {
                $condition1 = implode(',',$condition);
                $query->whereIn('type', $condition);
            }
            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if (isset($yop)) {
                $yop1 = implode(',',$yop);
               $query->whereIn('year_of_purchase', $yop);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);



            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.harvester-list',['data12'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }

    //not required
    public function harvester_filter_sort (Request $request) {
        $type = session()->get('type');
        $condition = session()->get('condition');
        $state = session()->get('state');
        $district = session()->get('district');
        $yop = session()->get('yop');
        $min_price = session()->get('min_price');
        $max_price = session()->get('max_price');

        $query = DB::table('harvester')->orderBy('id','desc')->where('status',1);

            if (isset($type)) {
                $type1 = implode(',',$type);
                $query->whereIn('set', $type);
            }
            if (isset($condition)) {
                $condition1 = implode(',',$condition);
                $query->whereIn('type', $condition);
            }
            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if (isset($yop)) {
                $yop1 = implode(',',$yop);
               $query->whereIn('year_of_purchase', $yop);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

           $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);





            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

            $har_type = Harvester::whereBetween('price',['0','100000'])->paginate(7);

        // return view('front.development.harvester-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        // 'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

        return view('front.development.harvester-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode,'har_type'=>$har_type]);
    }
    
    public function harvesterFilterData(Request $request,$sort,$type){

        $pincode      = $request->session()->get('pincode');
        $pindata      = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude     = $pindata->latitude;
        $longitude    = $pindata->longitude;

        if($sort == 'plh'){
            if($type == 'new'){
                $query = DB::table('harvesterView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->orderBy('price','asc')
                        ->where('status',1)
                        ->where('type','new')
                        ->where('set','sell')
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
            if($type == 'old'){
                $query = DB::table('harvesterView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->orderBy('price','asc')
                        ->where('status',1)
                        ->where('type','old')
                        ->where('set','sell')
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
            if($type == 'rent'){
                $query =  DB::table('harvesterView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->orderBy('price','asc')
                        ->where('set','rent')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
        }
        if($sort == 'phl'){
            if($type == 'new'){
                $query = DB::table('harvesterView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('set','sell')
                        ->where('type','new')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
            if($type == 'old'){
                $query =  DB::table('harvesterView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('set','sell')
                        ->where('type','old')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
            if($type == 'rent'){
                $query =  DB::table('harvesterView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->orderBy('price','desc')
                        ->where('set','rent')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
        }
        if($sort == 'nf'){
            if($type == 'new'){
                $query =  DB::table('harvesterView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(harvesterView.latitude))
                * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(harvesterView.latitude))) AS distance"))
                ->orderBy('user_id','desc')
                ->where('set','sell')
                ->where('type','new')
                ->where('status',1)
                ->whereBetween('price',[0,100000000])
                ->paginate(12);
            }
            if($type == 'old'){
                $query =  DB::table('harvesterView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->orderBy('user_id','desc')
                        ->where('set','sell')
                        ->where('type','old')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
            if($type == 'rent'){
                $query =  DB::table('harvesterView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->orderBy('user_id','desc')
                        ->where('set','rent')
                        ->where('status',1)
                        ->whereBetween('price',[0,100000000])
                        ->paginate(12);
            }
        }

        if (session()->has('users_id')) {
            $user_id = session()->get('users_id');
        } else {
            $user_id = 0;
        }

        $pincode = session()->get('pincode');

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

        //$type = $request->type;
        $app_section = 'viewall';

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.harvester-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }

    public function implements_list (Request $request) {
        if(Session()->has('type')) { Session()->forget('type'); }
        if(Session()->has('condition')) { Session()->forget('condition'); }
        if(Session()->has('state')) { Session()->forget('state'); }
        if(Session()->has('district')) { Session()->forget('district'); }
        if(Session()->has('yop')) { Session()->forget('yop'); }
        if(Session()->has('min_price')) { Session()->forget('min_price'); }
        if(Session()->has('max_price')) { Session()->forget('max_price'); }

        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

        $type = $request->type;
        $app_section = 'viewall';
        if ($type=='rent') {
            $new = Implement::implement_data_rent($user_id,$type,$pincode,$district,$state,$app_section,0,0);
        } else {
            $new = Implement::implement_data($user_id,$type,$pincode,$district,$state,$app_section,0,0);
        }

        $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        /** Dibyendu Change 28.08.2023 */

        if($type=='rent'){
            $imp_type = DB::table('implementView')
                        ->select('implementView.id','implementView.city_name','implementView.brand_id','implementView.model_id','implementView.district_id','implementView.state_id','implementView.country_id','implementView.state_id','implementView.country_id','implementView.pincode'
                        ,'implementView.front_image','implementView.left_image','implementView.right_image','implementView.back_image','implementView.price','implementView.set','implementView.rent_type','implementView.status'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->where('set','rent')
                        ->paginate(12);
        }
        else if($type=='old'){
            $imp_type = DB::table('implementView')
                        ->select('implementView.id','implementView.city_name','implementView.brand_id','implementView.model_id','implementView.district_id','implementView.state_id','implementView.country_id','implementView.state_id','implementView.country_id','implementView.pincode'
                        ,'implementView.front_image','implementView.left_image','implementView.right_image','implementView.back_image','implementView.price','implementView.set','implementView.rent_type','implementView.status'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->where('set','sell')
                        ->where('type','old')
                        ->paginate(12);
        }
        else if($type=='new'){
            $imp_type = DB::table('implementView')
                        ->select('implementView.id','implementView.city_name','implementView.brand_id','implementView.model_id','implementView.district_id','implementView.state_id','implementView.country_id','implementView.state_id','implementView.country_id','implementView.pincode'
                        ,'implementView.front_image','implementView.left_image','implementView.right_image','implementView.back_image','implementView.price','implementView.set','implementView.rent_type','implementView.status'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->where('set','sell')
                        ->where('type','new')
                        ->paginate(12);
        }

        // return view('front.development.implements-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        // 'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

        return view('front.development.implements-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode,'imp_type'=>$imp_type]);
    }

    public function implemets_filter (Request $request) {
        $type = $request->type;
        $condition = $request->condition;
        $state = $request->state;
        $district = $request->district;
        $yop = $request->yop;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $request->session()->put('type',$type);
        $request->session()->put('condition',$condition);
        $request->session()->put('state',$state);
        $request->session()->put('district',$district);
        $request->session()->put('yop',$yop);
        $request->session()->put('min_price',$min_price);
        $request->session()->put('max_price',$max_price);

        $query = DB::table('implements')->orderBy('id','desc')->where('status',1);

            if (isset($type)) {
                $type1 = implode(',',$type);
                $query->whereIn('set', $type);
            }
            if (isset($condition)) {
                $condition1 = implode(',',$condition);
                $query->whereIn('type', $condition);
            }
            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if (isset($yop)) {
                $yop1 = implode(',',$yop);
               $query->whereIn('year_of_purchase', $yop);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);


            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.implements-list',['data12'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }
    
    //not required
    public function implemets_filter_sort (Request $request) {
        $type = session()->get('type');
        $condition = session()->get('condition');
        $state = session()->get('state');
        $district = session()->get('district');
        $yop = session()->get('yop');
        $min_price = session()->get('min_price');
        $max_price = session()->get('max_price');

        $query = DB::table('implements')->orderBy('id','desc')->where('status',1);

            if (isset($type)) {
                $type1 = implode(',',$type);
                $query->whereIn('set', $type);
            }
            if (isset($condition)) {
                $condition1 = implode(',',$condition);
                $query->whereIn('type', $condition);
            }
            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if (isset($yop)) {
                $yop1 = implode(',',$yop);
               $query->whereIn('year_of_purchase', $yop);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);





            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.implements-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);
    }
    
    public function implementsFilterData(Request $request,$sort,$type){
        $pincode = $request->session()->get('pincode');
        $pindata = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude     = $pindata->latitude;
        $longitude    = $pindata->longitude;

        //dd($type);
        if($sort == 'plh'){
            if($type == 'new'){
                $query = DB::table('implementView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(implementView.latitude))
                            * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(implementView.latitude))) AS distance"))
                            ->whereIn('status',[1,4])
                            ->orderBy('price','asc')
                            ->where('set','sell')
                            ->where('type','new')
                            ->paginate(12);
            }
            if($type == 'old'){
                $query = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('price','asc')
                        ->where('set','sell')
                        ->where('type','old')
                        ->paginate(12);
            }
            if($type == 'rent'){
                $query = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('price','asc')
                        ->where('set','rent')
                        ->paginate(12);
            }
        }
        if($sort == 'phl'){
            if($type == 'new'){
                $query = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('price','desc')
                        ->where('set','sell')
                        ->where('type','new')
                        ->paginate(12);
            }
            if($type == 'old'){
                $query = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('price','desc')
                        ->where('set','sell')
                        ->where('type','old')
                        ->paginate(12);
            }
            if($type == 'rent'){
                $query = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('price','desc')
                        ->where('set','rent')
                        ->paginate(12);
            }
        }
        if($sort == 'nf'){
            if($type == 'new'){
                $query = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('user_id','desc')
                        ->where('set','sell')
                        ->where('type','new')
                        ->paginate(12);
            }
            if($type == 'old'){
                $query = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('user_id','desc')
                        ->where('set','sell')
                        ->where('type','old')
                        ->paginate(12);
            }
            if($type == 'rent'){
                $query = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('user_id','desc')
                        ->where('set','rent')
                        ->paginate(12);
            }
        }

        if (session()->has('users_id')) {
            $user_id = session()->get('users_id');
        } else {
            $user_id = 0;
        }

        $pincode = session()->get('pincode');

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

        //$type = $request->type;
        $app_section = 'viewall';

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.implements-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);
    }

    public function seeds_list (Request $request) {
        if(Session()->has('state')) { Session()->forget('state'); }
        if(Session()->has('district')) { Session()->forget('district'); }
        if(Session()->has('min_price')) { Session()->forget('min_price'); }
        if(Session()->has('max_price')) { Session()->forget('max_price'); }

        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

        //$type = $request->type;
        $app_section = 'viewall';
        $new = Seed::seeds_data($user_id,$pincode,$district,$state,$app_section,0,0);

        $state_arr    = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        /** Dibyendu Change 28.08.2023 */
        $seed_buy = DB::table('seedView')
                    ->select('seedView.id','seedView.city_name','seedView.district_id','seedView.state_id','seedView.country_id','seedView.state_id','seedView.country_id','seedView.pincode'
                    ,'seedView.image1','seedView.image2','seedView.image3','seedView.price','seedView.title','seedView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(seedView.latitude))
                    * cos(radians(seedView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(seedView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('distance','asc')
                    ->paginate(12);

        // return view('front.development.seed-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        // 'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

        return view('front.development.seed-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode,'seed_buy'=>$seed_buy]);
    }

    public function seed_filter (Request $request) {
        $state = $request->state;
        $district = $request->district;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $request->session()->put('state',$state);
        $request->session()->put('district',$district);
        $request->session()->put('min_price',$min_price);
        $request->session()->put('max_price',$max_price);

        $query = DB::table('seeds')->orderBy('id','desc')->where('status',1);

            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);


            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.seed-list',['data12'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }
    
    //not required
    public function seed_filter_sort (Request $request) {
        $state = session()->get('state');
        $district = session()->get('district');
        $min_price = session()->get('min_price');
        $max_price = session()->get('max_price');

        $query = DB::table('seeds')->orderBy('id','desc')->where('status',1);

            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);

            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.seed-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);
    }
    
    public function seedsFilterData(Request $request ,$sort){
        $pincode    = $request->session()->get('pincode');
        $pindata    = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude   = $pindata->latitude;
        $longitude  = $pindata->longitude;

        if($sort == 'plh' ){
            $query = DB::table('seedView')
                    ->select('seedView.id','seedView.city_name','seedView.district_id','seedView.state_id','seedView.country_id','seedView.state_id','seedView.country_id','seedView.pincode'
                    ,'seedView.image1','seedView.image2','seedView.image3','seedView.price','seedView.title','seedView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(seedView.latitude))
                    * cos(radians(seedView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(seedView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('price','asc')
                    ->paginate(12);
        }
        if($sort == 'phl' ){
            $query = DB::table('seedView')
                    ->select('seedView.id','seedView.city_name','seedView.district_id','seedView.state_id','seedView.country_id','seedView.state_id','seedView.country_id','seedView.pincode'
                    ,'seedView.image1','seedView.image2','seedView.image3','seedView.price','seedView.title','seedView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(seedView.latitude))
                    * cos(radians(seedView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(seedView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('price','desc')
                    ->paginate(12);
        }
        if($sort == 'nf' ){
            $query = DB::table('seedView')
                    ->select('seedView.id','seedView.city_name','seedView.district_id','seedView.state_id','seedView.country_id','seedView.state_id','seedView.country_id','seedView.pincode'
                    ,'seedView.image1','seedView.image2','seedView.image3','seedView.price','seedView.title','seedView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(seedView.latitude))
                    * cos(radians(seedView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(seedView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('user_id','desc')
                    ->paginate(12);
        }

        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

        $state_arr    = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

    return view('front.development.seed-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
    'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }

    public function pesticides_list (Request $request) {
        if(Session()->has('state')) { Session()->forget('state'); }
        if(Session()->has('district')) { Session()->forget('district'); }
        if(Session()->has('min_price')) { Session()->forget('min_price'); }
        if(Session()->has('max_price')) { Session()->forget('max_price'); }

        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

        $type = $request->type;
        $app_section = 'viewall';
        $new = pesticides::pesticides_data($user_id,$pincode,$district,$state,$app_section,0,0);
        $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        // Dibyendu Change 28.08.2023
        $pes_buy = DB::table('pesticidesView')
                    ->select('pesticidesView.id','pesticidesView.city_name','pesticidesView.district_id','pesticidesView.state_id','pesticidesView.country_id','pesticidesView.state_id','pesticidesView.country_id','pesticidesView.pincode'
                    ,'pesticidesView.image1','pesticidesView.image2','pesticidesView.image3','pesticidesView.price','pesticidesView.title','pesticidesView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(pesticidesView.latitude))
                    * cos(radians(pesticidesView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(pesticidesView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('distance','asc')
                    ->paginate(12);

        // return view('front.development.pesticides-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        // 'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

        /** Dibyendu change 28.08.2023 */
        return view('front.development.pesticides-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode,'pes_buy'=>$pes_buy]);
    }

    public function pesticides_filter (Request $request) {
        $state = $request->state;
        $district = $request->district;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $request->session()->put('state',$state);
        $request->session()->put('district',$district);
        $request->session()->put('min_price',$min_price);
        $request->session()->put('max_price',$max_price);

        $query = DB::table('pesticides')->orderBy('id','desc')->where('status',1);

            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);





            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.pesticides-list',['data12'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }
    
    //not required
    public function pesticides_filter_sort (Request $request) {
        $state = session()->get('state');
        $district = session()->get('district');
        $min_price = session()->get('min_price');
        $max_price = session()->get('max_price');

        $query = DB::table('pesticides')->orderBy('id','desc')->where('status',1);

            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);





            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.pesticides-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }
    
    public function pesticidesFilterData(Request $request ,$sort){
        $pincode    = $request->session()->get('pincode');
        $pindata    = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude   = $pindata->latitude;
        $longitude  = $pindata->longitude;

        //dd($sort);
        if($sort == 'plh' ){
            $query = DB::table('pesticidesView')
                    ->select('pesticidesView.id','pesticidesView.city_name','pesticidesView.district_id','pesticidesView.state_id','pesticidesView.country_id','pesticidesView.state_id','pesticidesView.country_id','pesticidesView.pincode'
                    ,'pesticidesView.image1','pesticidesView.image2','pesticidesView.image3','pesticidesView.price','pesticidesView.title','pesticidesView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(pesticidesView.latitude))
                    * cos(radians(pesticidesView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(pesticidesView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('price','asc')
                    ->paginate(12);
        }
        if($sort == 'phl' ){
            $query = DB::table('pesticidesView')
                    ->select('pesticidesView.id','pesticidesView.city_name','pesticidesView.district_id','pesticidesView.state_id','pesticidesView.country_id','pesticidesView.state_id','pesticidesView.country_id','pesticidesView.pincode'
                    ,'pesticidesView.image1','pesticidesView.image2','pesticidesView.image3','pesticidesView.price','pesticidesView.title','pesticidesView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(pesticidesView.latitude))
                    * cos(radians(pesticidesView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(pesticidesView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('price','desc')
                    ->paginate(12);
        }
        if($sort == 'nf' ){
            $query = DB::table('pesticidesView')
                    ->select('pesticidesView.id','pesticidesView.city_name','pesticidesView.district_id','pesticidesView.state_id','pesticidesView.country_id','pesticidesView.state_id','pesticidesView.country_id','pesticidesView.pincode'
                    ,'pesticidesView.image1','pesticidesView.image2','pesticidesView.image3','pesticidesView.price','pesticidesView.title','pesticidesView.status'
                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(pesticidesView.latitude))
                    * cos(radians(pesticidesView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(pesticidesView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('user_id','desc')
                    ->paginate(12);
        }

        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

    return view('front.development.pesticides-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
    'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }

    public function fertilizer_list (Request $request) {
        if(Session()->has('state')) { Session()->forget('state'); }
        if(Session()->has('district')) { Session()->forget('district'); }
        if(Session()->has('min_price')) { Session()->forget('min_price'); }
        if(Session()->has('max_price')) { Session()->forget('max_price'); }

        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

        $type = $request->type;
        $app_section = 'viewall';
        $new = fertilizers::fertilizers_data($user_id,$pincode,$district,$state,$app_section,0,0);

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        /** Dibyendu Change 28.08.2023 */
        $fer_buy = DB::table('fertilizerView')
                    ->select('*', DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(fertilizerView.latitude))
                    * cos(radians(fertilizerView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(fertilizerView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('distance','asc')
                    ->paginate(12);

        // return view('front.development.fertilizers-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        // 'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

        return view('front.development.fertilizers-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode,'fer_buy'=>$fer_buy]);
    }

    public function fertilizer_filter (Request $request) {
        $state = $request->state;
        $district = $request->district;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $request->session()->put('state',$state);
        $request->session()->put('district',$district);
        $request->session()->put('min_price',$min_price);
        $request->session()->put('max_price',$max_price);

        $query = DB::table('fertilizers')->orderBy('id','desc')->where('status',1);

            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);

            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.fertilizers-list',['data12'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }
    
    //not required
    public function fertilizer_filter_sort (Request $request) {
        $state = session()->get('state');
        $district = session()->get('district');
        $min_price = session()->get('min_price');
        $max_price = session()->get('max_price');

        $query = DB::table('fertilizers')->orderBy('id','desc')->where('status',1);

            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);





            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.fertilizers-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }
    
    public function fertilizerFilterData(Request $request ,$sort){
        $pincode    = $request->session()->get('pincode');
        $pindata    = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude   = $pindata->latitude;
        $longitude  = $pindata->longitude;

        if($sort == 'plh' ){
            $query = DB::table('fertilizerView')
                        ->select('*', DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(fertilizerView.latitude))
                        * cos(radians(fertilizerView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(fertilizerView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('price','asc')
                        ->paginate(12);
        }
        if($sort == 'phl' ){
            $query = DB::table('fertilizerView')
                    ->select('*', DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(fertilizerView.latitude))
                    * cos(radians(fertilizerView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(fertilizerView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('price','desc')
                    ->paginate(12);
        }
        if($sort == 'nf' ){
            $query = DB::table('fertilizerView')
                    ->select('*', DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                    * cos(radians(fertilizerView.latitude))
                    * cos(radians(fertilizerView.longitude) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. "))
                    * sin(radians(fertilizerView.latitude))) AS distance"))
                    ->whereIn('status',[1,4])
                    ->orderBy('user_id','desc')
                    ->paginate(12);
        }

        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.fertilizers-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }

    public function tyre_list (Request $request) {
        if(Session()->has('state')) { Session()->forget('state'); }
        if(Session()->has('district')) { Session()->forget('district'); }
        if(Session()->has('min_price')) { Session()->forget('min_price'); }
        if(Session()->has('max_price')) { Session()->forget('max_price'); }

        if ($request->session()->has('users_id')) {
            $user_id = $request->session()->get('users_id');
        } else {
            $user_id = 0;
        }
        //if ($request->session()->has('pincode')) {
            $pincode = $request->session()->get('pincode');
        //}
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

        $type = $request->type;
        $app_section = 'viewall';
        $new = Tyre::tyre_data($user_id,$type,$pincode,$district,$state,$app_section,0,0);

        $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        /** Dibyendu Change 28.08.2023 */
        if($type == 'new'){
           $tr_type = DB::table('tyresView')
                        ->select('tyresView.id','tyresView.city_name','tyresView.brand_id','tyresView.model_id','tyresView.district_id','tyresView.state_id','tyresView.country_id','tyresView.state_id','tyresView.country_id','tyresView.pincode'
                        ,'tyresView.image1','tyresView.image2','tyresView.image3','tyresView.price','tyresView.type','tyresView.title','tyresView.status'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tyresView.latitude))
                        * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tyresView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->where('type','new')
                        ->paginate(12);
        }
        if($type == 'old'){
            $tr_type = DB::table('tyresView')
                        ->select('tyresView.id','tyresView.city_name','tyresView.brand_id','tyresView.model_id','tyresView.district_id','tyresView.state_id','tyresView.country_id','tyresView.state_id','tyresView.country_id','tyresView.pincode'
                        ,'tyresView.image1','tyresView.image2','tyresView.image3','tyresView.price','tyresView.type','tyresView.title','tyresView.status'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tyresView.latitude))
                        * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tyresView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->where('type','old')
                        ->paginate(12);
        }

        /** Dibyendu Change 28.08.2023 */
        return view('front.development.tyre-list',['data'=>$new,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode,'tr_type'=>$tr_type]);
    }

    public function tyre_filter (Request $request) {
        $state = $request->state;
        $district = $request->district;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $request->session()->put('state',$state);
        $request->session()->put('district',$district);
        $request->session()->put('min_price',$min_price);
        $request->session()->put('max_price',$max_price);

        $query = DB::table('tyres')->orderBy('id','desc')->where('status',1);

            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);





            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.tyre-list',['data12'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);

    }
    
    //not required
    public function tyre_filter_sort (Request $request) {
        $state = session()->get('state');
        $district = session()->get('district');
        $min_price = session()->get('min_price');
        $max_price = session()->get('max_price');

        $query = DB::table('tyres')->orderBy('id','desc')->where('status',1);

            if (isset($state)) {
                $query->where('state_id', $state);
            }
            //$district_array = explode (',',$district);
            if (isset($district)) {
                $district1 = implode(',',$district);
                $dist = [$district1];
                //print_r($dist);
                $query->whereIn('district_id', $district);
                //$query->whereIn('district_id', [$district1]);
            }

            if ($min_price && $max_price) {
                $query->whereBetween('price', [$min_price,$max_price]);
            }

            $query = $query->get();
            //print_r($query);
            //$new['count'] = count($array_tractor_model);


            if ($request->session()->has('users_id')) {
                $user_id = $request->session()->get('users_id');
            } else {
                $user_id = 0;
            }
            //if ($request->session()->has('pincode')) {
                $pincode = $request->session()->get('pincode');
            //}
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

            $state_arr = DB::table('state')->where(['status'=>1])->get();
            $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.tyre-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);
    }
    
    public function tyreFilterData(Request $request, $sort, $type){
        $pincode    = $request->session()->get('pincode');
        $pindata    = DB::table('city')->where(['pincode'=>$pincode])->first();
        $latitude   = $pindata->latitude;
        $longitude  = $pindata->longitude;

       // dd($type);
        if($sort == 'plh'){
            //dd($type);
            if($type == 'new'){
                $query = DB::table('tyresView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tyresView.latitude))
                        * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tyresView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('price','asc')
                        ->where('type','new')
                        ->paginate(12);
            }
            if($type == 'old'){
                $query = DB::table('tyresView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tyresView.latitude))
                        * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tyresView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('price','asc')
                        ->where('type','old')
                        ->paginate(12);
            }
        }

        if($sort == 'phl'){
            if($type == 'new'){
                $query = DB::table('tyresView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tyresView.latitude))
                        * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tyresView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('price','desc')
                        ->where('type','new')
                        ->paginate(12);
            }
            if($type == 'old'){
                $query = DB::table('tyresView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tyresView.latitude))
                        * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tyresView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('price','desc')
                        ->where('type','old')
                        ->paginate(12);
            }
        }

        if($sort == 'nf'){
            //dd($type);
            if($type == 'new'){
                $query = DB::table('tyresView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tyresView.latitude))
                        * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tyresView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('user_id','desc')
                        ->where('type','new')
                        ->paginate(12);
            }
            if($type == 'old'){
                $query = DB::table('tyresView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tyresView.latitude))
                        * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tyresView.latitude))) AS distance"))
                        ->whereIn('status',[1,4])
                        ->orderBy('user_id','desc')
                        ->where('type','old')
                        ->paginate(12);
            }
        }

        if (session()->has('users_id')) {
            $user_id = session()->get('users_id');
        } else {
            $user_id = 0;
        }

        $pincode = session()->get('pincode');

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

        //$type = $request->type;
        $app_section = 'viewall';

        $state_arr = DB::table('state')->where(['status'=>1])->get();
        $district_arr = DB::table('district')->where(['state_id'=>$state])->get();

        return view('front.development.tyre-list',['data1'=>$query,'state_arr'=>$state_arr,'state'=>$state,
        'district_arr'=>$district_arr,'district'=>$district,'pincode'=>$pincode]);
    }

    public function tractorpost (Request $request) {
        return view('front.development.post-list');
    }

    public function en_lang () {
        if (session()->has('hn')) {
            session()->forget('hn');
        }
        if (session()->has('bn')) {
            session()->forget('bn');
        }
        $en = session()->put('en','en');
        return redirect()->back();
    }

    public function hn_lang () {
        if (session()->has('en')) {
            session()->forget('en');
        }
        if (session()->has('bn')) {
            session()->forget('bn');
        }
        $hn = session()->put('hn','hn');
        return redirect()->back();
    }
    public function bn_lang () {
        if (session()->has('en')) {
            session()->forget('en');
        }
        if (session()->has('hn')) {
            session()->forget('hn');
        }
        $bn = session()->put('bn','bn');
        return redirect()->back();
    }

    public function iffcoProductPage(){
        return view('front.development.iffco-product');
    }

}
