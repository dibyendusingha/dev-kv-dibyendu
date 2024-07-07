<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
use Carbon\Carbon;

class LoginAPI extends Controller
{
    //
    public function login_check(Request $request)
    {
        $output = [];
        $mobile = $request->mobile;

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:10'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = '';
            $output['error'] = "Validation error!";
        } else {

            //user disabled 
            $disabled = DB::table('user')->where(['mobile' => $mobile, 'status' => 0])->count();
            if ($disabled == 1) {
                $output['response'] = true;
                $output['flag'] = 'disabled';
                $output['message'] = 'User is Disabled';
                $output['data'] = 0;
                $output['error'] = "";
            } else {
                //user status
                $count = DB::table('user')->where(['mobile' => $mobile, 'status' => 1])->count();
                $output['response'] = true;
                $output['flag'] = 'zipcode';
                $output['message'] = 'Data';
                $output['data'] = $count;
                $output['error'] = "";
            }
        }
        return  $output;
    }

    public function otp(Request $request)
    {
        $output = [];
        $mobile = $request->mobile;

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:10',
        ]);

        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = '';
            $output['error'] = "Validation error!";
        } else {

            $rand = rand(100000, 999999);
            $sms_code = $rand . '.';
            $message = 'Your Krishi Vikas Udyog verification code is ' . $sms_code . ' Please enter it in the required space to process your sign-up. | Krishi Vikas';
            $encode_message = urlencode($message);
            $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $mobile . '&message=' . $encode_message . '&format=json';


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $res = curl_exec($ch);

            $output['response'] = true;
            $output['message'] = 'OTP sent successfully';
            $output['otp'] = $rand;
            $output['error'] = "";
        }

        return $output;
    }

    public function login(Request $request)
    {
        $mobile         = $request->mobile;
        $referral_code  = $request->referral_code;
        $email          = $request->email;
        $facebook_id    = $request->facebook_id;
        $google_id      = $request->google_id;
        $device_id      = $request->device_id;
        $firebase_token = $request->firebase_token;
        $phone_verified = $request->phone_verified;
        if (!empty($request->country_id)) {
            $country_id   = $request->country_id;
        } else {
            $country_id = 1;
        }

        $state_id       = $request->state_id;
        $district_id    = $request->district_id;
        $city_id        = $request->city_id;
        $lat            = $request->lat;
        $long           = $request->long;
        $zipcode        = $request->zipcode;
        $status         = $request->status;

        $name              = $request->name;
        $company_name      = $request->company_name;
        $gst_no            = $request->gst_no;

        if ($request->user_type_id == null || $request->user_type_id == "") {
            $user_type_id = 1;
        } else if ($request->user_type_id != null) {
            $user_type_id = $request->user_type_id;
        }


        $output = [];
        $data = [];
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|size:10',
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = $validator->errors();
            return $output;
            exit;
        } else {

            if ($mobile != '') {
                $count = DB::table('user')->where(['mobile' => $mobile])->count();
            } else {
                $count = 0;
            }

            //dd($count);
            if ($count > 0) {
                //login

                //$token = Str::random(100);
                DB::table('user')->where(['mobile' => $mobile, 'status' => 1])->update(['firebase_token' => $firebase_token]);

                /* -- remove
                'country_id'=>$country_id,'state_id'=>$state_id,'district_id'=>$district_id,'city_id'=>$city_id,'zipcode'=>$zipcode,'lat'=>$lat,
                'long'=>$long,'latlong'=>$lat.','.$long,
                */

                if ($count > 0) {
                    $log = Userss::where(['mobile' => $mobile])->first();
                   // dd($log);
                }

                $data['user_id']        = $log->id;
                $data['user_type_id']   = $log->user_type_id;
                $data['role_id']        = $log->role_id;
                $data['name']           = $log->name;
                $data['company_name']   = $log->company_name;
                $data['gst_no']         = $log->gst_no;
                $data['mobile']         = $log->mobile;
                $data['facebook_id']    = $log->facebook_id;
                $data['google_id']      = $log->google_id;
                $data['email']          = $log->email;
                $data['gender']         = $log->gender;

                $data['country_id']     = $log->country_id;
                $c = DB::table('country')->where(['id' => $log->country_id])->first();
                $data['country_name']   = $c->country_name;

                $data['state_id']       = $log->state_id;
                $s = DB::table('state')->where(['id' => $log->state_id])->first();
                $data['state_name']     = $s->state_name;

                $data['district_id']    = $log->district_id;
                $d = DB::table('district')->where(['id' => $log->district_id])->first();
                $data['district_name']  = $d->district_name;

                $data['city_id']        = $log->city_id;
                $ci = DB::table('city')->where(['id' => $log->city_id])->first();
                $data['city_name']      = $ci->city_name;

                $data['zipcode']        = $log->zipcode;
                $data['lat']            = $log->lat;
                $data['long']           = $log->long;


                $data['device_id']      = $log->device_id;
                $data['firebase_token'] = $log->firebase_token;
                $data['token']          = $log->token;
                $data['profile_update'] = $log->profile_update;
                if ($log->photo == '' || $log->photo == NULL) {
                    $data['photo'] = '';
                } else {
                    $data['photo'] = asset("storage/photo/$log->photo");
                }
                $data['lamguage'] = $log->lamguage;

                //$user = Users::where(['name'=>$mobile])->firstOrFail();

                $token = $log->createToken('auth_token')->plainTextToken;

                $wm = DB::table('settings')->where(['name' => 'kv-watermark', 'status' => 1])->value('value');

                $output['response'] = true;
                $output['message'] = 'Login Successfully';
                $output['data'] = $data;
                $output['watermark'] = $wm;
                $output['token_type'] = 'Bearer';
                $output['access_token'] = $token;
                $output['error'] = "";
            } else {
                //reg


                $mobileNumber  = $request->mobile;
                $firstDigits = substr($mobileNumber, 0, 1);

                if ($firstDigits == 9 || $firstDigits == 8 || $firstDigits == 7 || $firstDigits == 6) {
                    $maual_token = Str::random(100);

                    $reg_id = DB::table('user')->insertGetId([
                        'mobile' => $mobile, 'referral_code' => $referral_code, 'login_via' => 'APP', 'email' => $email, 'facebook_id' => $facebook_id, 'google_id' => $google_id, 'country_id' => 1, 'state_id' => $state_id, 'district_id' => $district_id, 'city_id' => $city_id,
                        'lat' => $lat, 'long' => $long, 'zipcode' => $zipcode, 'device_id' => $device_id, 'firebase_token' => $firebase_token, 'token' => $maual_token, 'phone_verified' => $phone_verified, 'status' => 1, 'name' => $name, 'gst_no' => $gst_no, 'company_name' => $company_name, 'user_type_id' => $user_type_id, 'created_at'=> Carbon::now(),
                            'updated_at'=>Carbon::now()
                    ]);
                    
                  //  dd($reg_id);


                    if ($reg_id) {
                        $log = Userss::where(['id' => $reg_id])->first();

                        $data['user_id']        = $log->id;
                        $data['user_type_id']   = $log->user_type_id;
                        $data['role_id']        = $log->role_id;
                        $data['name']           = $log->name;
                        $data['company_name']   = $log->company_name;
                        $data['gst_no']         = $log->gst_no;
                        $data['mobile']         = $log->mobile;
                        $data['facebook_id']    = $log->facebook_id;
                        $data['google_id']      = $log->google_id;
                        $data['email']          = $log->email;
                        $data['gender']         = $log->gender;

                        $data['country_id']     = $log->country_id;
                        $c = DB::table('country')->where(['id' => $log->country_id])->first();
                        $data['country_name']   = $c->country_name;

                        $data['state_id']       = $log->state_id;
                        $s = DB::table('state')->where(['id' => $log->state_id])->first();
                        $data['state_name']     = $s->state_name;

                        $data['district_id']    = $log->district_id;
                        $d = DB::table('district')->where(['id' => $log->district_id])->first();
                        $data['district_name']  = $d->district_name;

                        $data['city_id']        = $log->city_id;
                        $ci = DB::table('city')->where(['id' => $log->city_id])->first();
                        $data['city_name']      = $ci->city_name;

                        $data['zipcode']        = $log->zipcode;
                        $data['lat']            = $log->lat;
                        $data['long']           = $log->long;


                        $data['device_id']      = $log->device_id;
                        $data['firebase_token'] = $log->firebase_token;
                        $data['token']          = $log->token;
                        $data['profile_update'] = $log->profile_update;
                        if ($log->photo == '' || $log->photo == NULL) {
                            $data['photo'] = '';
                        } else {
                            $data['photo'] = asset("storage/photo/$log->photo");
                        }
                        $data['lamguage'] = $log->lamguage;

                        //$user = Users::where(['name'=>$mobile])->firstOrFail();

                        $token = $log->createToken('auth_token')->plainTextToken;

                        $wm = DB::table('settings')->where(['name' => 'kv-watermark', 'status' => 1])->value('value');

                        $output['response'] = true;
                        $output['message'] = 'New Registration Successfully';
                        $output['data'] = $data;
                        $output['watermark'] = $wm;
                        $output['token_type'] = 'Bearer';
                        $output['access_token'] = $token;
                        $output['error'] = "";
                    }
                } else {
                    $output['response'] = false;
                    $output['message'] = 'This is not be indian number';
                    $output['data'] = [];
                    $output['watermark'] = "";
                    $output['token_type'] = '';
                    $output['access_token'] = '';
                    $output['error'] = "";
                }
            }

            return $output;
        }
    }



    public function login_test(Request $request)
    {

        $mobile = $request->mobile;
        $referral_code = $request->referral_code;
        $email  = $request->email;
        $facebook_id = $request->facebook_id;
        $google_id   = $request->google_id;
        $device_id   = $request->device_id;
        $firebase_token   = $request->firebase_token;
        $phone_verified   = $request->phone_verified;
        $country_id   = $request->country_id;
        $state_id   = $request->state_id;
        $district_id = $request->district_id;
        $city_id    = $request->city_id;
        $lat        = $request->lat;
        $long       = $request->long;
        $zipcode    = $request->zipcode;
        $status    = $request->status;

        $output = [];
        $data = [];
        $validator = Validator::make($request->all(), [
            'mobile' => '',
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {

            if ($mobile != '') {
                $count = DB::table('user')->where(['mobile' => $mobile])->count();
            } else {
                $count = 0;
            }
            if ($email != '') {
                $count2 = DB::table('user')->where(['email' => $email])->count();
            } else {
                $count2 = 0;
            }
            if ($facebook_id != '') {
                $count3 = DB::table('user')->where(['facebook_id' => $facebook_id])->count();
            } else {
                $count3 = 0;
            }
            if ($google_id != '') {
                $count4 = DB::table('user')->where(['google_id' => $google_id])->count();
            } else {
                $count4 = 0;
            }



            if ($count > 0 || $count2 > 0 || $count3 > 0 || $count4 > 0) {
                //login

                $rand = rand(100000, 999999);
                $sms_code = $rand . '.';
                $message = 'Your Krishi Vikas Udyog verification code is ' . $sms_code . ' Please enter it in the required space to process your sign-up. | Krishi Vikas';
                $encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $mobile . '&message=' . $encode_message . '&format=json';


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                $res = curl_exec($ch);

                //$token = Str::random(100);
                DB::table('user')->where(['mobile' => $mobile, 'status' => 1])->update([
                    'country_id' => $country_id, 'state_id' => $state_id, 'district_id' => $district_id, 'city_id' => $city_id, 'zipcode' => $zipcode, 'lat' => $lat,
                    'long' => $long, 'latlong' => $lat . ',' . $long, 'firebase_token' => $firebase_token
                ]);

                if ($count > 0) {
                    $log = DB::table('user')->where(['mobile' => $mobile])->first();
                }
                if ($count2 > 0) {
                    $log = DB::table('user')->where(['email' => $email])->first();
                }
                if ($count3 > 0) {
                    $log = DB::table('user')->where(['facebook_id' => $facebook_id])->first();
                }
                if ($count4 > 0) {
                    $log = DB::table('user')->where(['google_id' => $google_id])->first();
                }

                $data['user_id'] = $log->id;
                $data['user_type_id'] = $log->user_type_id;
                $data['role_id'] = $log->role_id;
                $data['name'] = $log->name;
                $data['company_name'] = $log->company_name;
                $data['gst_no'] = $log->gst_no;
                $data['mobile'] = $log->mobile;
                $data['facebook_id'] = $log->facebook_id;
                $data['google_id'] = $log->google_id;
                $data['email'] = $log->email;
                $data['gender'] = $log->gender;

                $data['country_id'] = $log->country_id;
                $c = DB::table('country')->where(['id' => $log->country_id])->first();
                $data['country_name'] = $c->country_name;

                $data['state_id'] = $log->state_id;
                $s = DB::table('state')->where(['id' => $log->state_id])->first();
                $data['state_name'] = $s->state_name;

                $data['district_id'] = $log->district_id;
                $d = DB::table('district')->where(['id' => $log->district_id])->first();
                $data['district_name'] = $d->district_name;

                $data['city_id'] = $log->city_id;
                $ci = DB::table('city')->where(['id' => $log->city_id])->first();
                $data['city_name'] = $ci->city_name;

                $data['zipcode'] = $log->zipcode;
                $data['lat'] = $log->lat;
                $data['long'] = $log->long;


                $data['device_id'] = $log->device_id;
                $data['firebase_token'] = $log->firebase_token;
                $data['token'] = $log->token;
                $data['profile_update'] = $log->profile_update;
                if ($log->photo == '' || $log->photo == NULL) {
                    $data['photo'] = '';
                } else {
                    $data['photo'] = asset("storage/photo/$log->photo");
                }
                $data['lamguage'] = $log->lamguage;



                $wm = DB::table('settings')->where(['name' => 'kv-watermark', 'status' => 1])->value('value');

                $output['response'] = true;
                $output['message'] = 'Login Successfully';
                $output['data'] = $data;
                $output['watermark'] = $wm;
                $output['otp'] = $rand;
                $output['error'] = "";
            } else {
                //reg

                $rand = rand(100000, 999999);
                $sms_code = $rand . '.';
                $message = 'Your Krishi Vikas Udyog verification code is ' . $sms_code . ' Please enter it in the required space to process your sign-up. | Krishi Vikas';
                $encode_message = urlencode($message);
                $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $mobile . '&message=' . $encode_message . '&format=json';


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                $res = curl_exec($ch);

                $token = Str::random(100);

                $reg_id = DB::table('user')->insertGetId([
                    'mobile' => $mobile, 'referral_code' => $referral_code, 'login_via' => 'APP', 'email' => $email, 'facebook_id' => $facebook_id, 'google_id' => $google_id, 'country_id' => $country_id, 'state_id' => $state_id, 'district_id' => $district_id, 'city_id' => $city_id,
                    'lat' => $lat, 'long' => $long, 'zipcode' => $zipcode, 'device_id' => $device_id, 'firebase_token' => $firebase_token, 'token' => $token, 'phone_verified' => $phone_verified, 'status' => $status
                ]);
                if ($reg_id) {

                    $log = DB::table('user')->where(['id' => $reg_id])->first();
                    $data['user_id'] = $log->id;
                    $data['user_type_id'] = $log->user_type_id;
                    $data['role_id'] = $log->role_id;
                    $data['name'] = $log->name;
                    $data['company_name'] = $log->company_name;
                    $data['gst_no'] = $log->gst_no;
                    $data['mobile'] = $log->mobile;
                    $data['facebook_id'] = $log->facebook_id;
                    $data['google_id'] = $log->google_id;
                    $data['email'] = $log->email;
                    $data['gender'] = $log->gender;

                    $data['country_id'] = $log->country_id;
                    $c = DB::table('country')->where(['id' => $log->country_id])->first();
                    $data['country_name'] = $c->country_name;

                    $data['state_id'] = $log->state_id;
                    $s = DB::table('state')->where(['id' => $log->state_id])->first();
                    $data['state_name'] = $s->state_name;

                    $data['district_id'] = $log->district_id;
                    $d = DB::table('district')->where(['id' => $log->district_id])->first();
                    $data['district_name'] = $d->district_name;

                    $data['city_id'] = $log->city_id;
                    $ci = DB::table('city')->where(['id' => $log->city_id])->first();
                    $data['city_name'] = $ci->city_name;
                    $data['zipcode'] = $log->zipcode;
                    $data['lat'] = $log->lat;
                    $data['long'] = $log->long;

                    $data['device_id'] = $log->device_id;
                    $data['firebase_token'] = $log->firebase_token;
                    $data['token'] = $log->token;
                    $data['profile_update'] = $log->profile_update;
                    $data['photo'] = asset("storage/photo/$log->photo");
                    $data['lamguage'] = $log->lamguage;

                    $output['response'] = true;
                    $output['message'] = 'New Registration Successfully';
                    $output['data'] = $data;
                    $output['error'] = "";
                }
            }

            return $output;
        }
    }

    public function regdata(Request $request)
    {
        $output = [];
        $user_id = $request->user_id;
        $user_type_id = $request->user_type_id;
        $name = $request->name;
        $email  = $request->email;
        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $district_id = $request->district_id;
        $city_id   = $request->city_id;
        $address   = $request->address;
        $zipcode   = $request->zipcode;
        $dob   = $request->dob;
        $latlong   = $request->latlong;
        $mobile   = $request->mobile;
        $company_name   = $request->company_name;
        $gst_no   = $request->gst_no;
        $language   = $request->language;
        $exp = explode(',', $latlong);
        $lat = $exp[0];
        $long = $exp[1];


        if ($photo = $request->file('photo')) {
            $photo = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('photo')->getClientOriginalName();
            $ext = $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('public/photo', $photo);
        } else {
            $dp = DB::table('user')->where(['id' => $user_id])->value('photo');
            $photo = $dp;
        }



        $update = DB::table('user')->where(['id' => $user_id])->update([
            'name' => $name, 'user_type_id' => $user_type_id, 'email' => $email, 'country_id' => $country_id,
            'state_id' => $state_id, 'district_id' => $district_id, 'city_id' => $city_id, 'address' => $address, 'zipcode' => $zipcode, 'dob' => $dob, 'lat' => $lat, 'long' => $long, 'company_name' => $company_name, 'gst_no' => $gst_no,
            'photo' => $photo, 'mobile' => $mobile, 'profile_update' => 1, 'updated_at' => date('y-m-d H:i:s'), 'user_disabled_date' => ''
        ]);
        if ($update) {

            $rand = rand(100000, 999999);
            $sms_code = $rand . '.';
            $message = 'Congratulations! You are successfully registered with Krishi Vikas Udyog. Now, BUY, Sell, Rent and grow with us! | Krishi Vikas';
            $encode_message = urlencode($message);
            $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $mobile . '&message=' . $encode_message . '&format=json';


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $res = curl_exec($ch);

            $data = DB::table('user')->where(['id' => $user_id])->get();
            $output['response'] = true;
            $output['message'] = 'Data Updated Successfully';
            $output['data'] = '';
            $output['error'] = "";
        } else {
            $data = DB::table('user')->where(['id' => $user_id])->get();
            $output['response'] = true;
            $output['message'] = 'Data';
            $output['data'] = '';
            $output['error'] = "";
        }





        return $output;
    }

    public function user_disabled(Request $request)
    {
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $data = [];
        $Autn = DB::table('user')->where(['id' => $user_id, 'token' => $user_token])->count();
        if ($Autn == 0) {
            $output['response'] = false;
            $output['message'] = 'Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }

        $validator = Validator::make($request->all(), [
            //'category_id' => 'required',
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $update = DB::table('user')->where(['id' => $user_id, 'token' => $user_token])->update(['status' => 0, 'user_disabled_date' => date('Y-m-d')]);
            if ($update) {
                $output['response'] = true;
                $output['message'] = 'User Disabled Successfully';
                $output['data'] = '';
                $output['error'] = "";
            }
        }
        return $output;
    }

    public function user_enable(Request $request)
    {
        $number = $request->number;
        $data = [];
        $Autn = DB::table('user')->where(['mobile' => $number])->count();
        if ($Autn == 0) {
            $output['response'] = false;
            $output['message'] = 'Authentication Failed';
            $output['data'] = '';
            $output['error'] = "";
            return $output;
            exit;
        }

        $validator = Validator::make($request->all(), [
            'number' => 'required',
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $update = DB::table('user')->where(['mobile' => $number])->update(['status' => 1, 'user_disabled_date' => NULL]);
            if ($update) {
                $output['response'] = true;
                $output['message'] = 'User Enabled Successfully';
                $output['data'] = '';
                $output['error'] = "";
            } else {
                $output['response'] = false;
                $output['message'] = 'User Activeted';
                $output['data'] = '';
                $output['error'] = "User Activeted";
            }
        }
        return $output;
    }

    /** Dibyendu Add Lat & Log function */

 /*   public function update_lat_log_login(Request $request)
    {
        $output = [];
        $data = [];
        $lat      = $request->lat;
        $long     = $request->long;
        $zipcode  = $request->zipcode;
        $user_id  = auth()->user()->id;
        if(!empty($request->lat) && !empty($request->long) && !empty($request->zipcode)){
            $user_count = DB::table('user')->where('id',$user_id)->count();
            if($user_count > 0){
                 $city_count = DB::table('city')->where('pincode',$zipcode)->where('status',1)->count();
                if($city_count == 0){
                    $cityId = DB::table('city')->insertGetId(['pincode'=>$request->zipcode,'city_name'=>'Kolkata' ,'region_id'=>1 ,'country_id'=>1,
                    'state_id'=>37 ,'district_id'=>730 ,'latitude'=>$request->lat ,'longitude'=>$request->long , 'status'=>1]);
                    $user_update = DB::table('user')
                            ->where('id',$user_id)->where('status',1)
                            ->update([
                                'lat'=>$lat ,
                                'long'=>$long ,
                                'zipcode'=>$zipcode,
                                'pincode'=>$request->zipcode,
                                'city_id'=>$cityId ,
                                'country_id'=>1,
                                'state_id'=>37,
                                'district_id'=>730 
                            ]);
                } else {
                    $cityData = DB::table('city')->where('pincode',$zipcode)->where('status',1)->first();
                    $user_update = DB::table('user')
                            ->where('id',$user_id)->where('status',1)
                            ->update([
                                'lat'=>$lat ,
                                'long'=>$long ,
                                'zipcode'=>$zipcode,
                                'pincode'=>$request->zipcode,
                                'city_id'=>$cityData->id ,
                                'country_id'=>1,
                                'state_id'=>$cityData->state_id,
                                'district_id'=>$cityData->district_id 
                            ]);
        if (!empty($request->lat) && !empty($request->long) && !empty($request->zipcode)) {
            $user_count = DB::table('user')->where('id', $user_id)->count();
            if ($user_count > 0) {
                $city_count = DB::table('city')->where('pincode', $zipcode)->where('status', 1)->count();
                if ($city_count == 0) {
                    $cityId = DB::table('city')->insertGetId([
                        'pincode' => $request->zipcode, 'city_name' => 'Kolkata', 'region_id' => 1, 'country_id' => 1,
                        'state_id' => 37, 'district_id' => 730, 'latitude' => $request->lat, 'longitude' => $request->long, 'status' => 1
                    ]);
                    $user_update = DB::table('user')
                        ->where('id', $user_id)->where('status', 1)
                        ->update([
                            'lat' => $lat,
                            'long' => $long,
                            'zipcode' => $request->zipcode,
                            'city_id' => $cityId,
                            'country_id' => 1,
                            'state_id' => 37,
                            'district_id' => 730,
                            'updated_at'=>carbon::now()
                        ]);
                } else {
                    $cityData = DB::table('city')->where('pincode', $zipcode)->where('status', 1)->first();
                    $user_update = DB::table('user')
                        ->where('id', $user_id)->where('status', 1)
                        ->update([
                            'lat' => $lat,
                            'long' => $long,
                            'zipcode' => $request->zipcode,
                            'city_id' => $cityData->id,
                            'country_id' => 1,
                            'state_id' => $cityData->state_id,
                            'district_id' => $cityData->district_id,
                            'updated_at'=>carbon::now()
                        ]);
                }
                $output['response'] = true;
                $output['message']  = 'User Lat and Long Updated';
                $output['error']    = "";
            } else {
                $output['response'] = false;
                $output['message']  = 'Lat and Long Not Updated';
                $output['error']    = "";
            }
        } else {
            $output['response'] = false;
            $output['message']  = 'Please Select Lat ,Long & Pincode';
            $output['error']    = "";
        }
        return $output;
    }*/
    public function update_lat_log_login(Request $request)
    {
        $output = [];
        $data = [];
        $lat      = $request->lat;
        $long     = $request->long;
        $zipcode  = $request->zipcode;
        $user_id  = auth()->user()->id;
      //  if (!empty($request->lat) && !empty($request->long) && !empty($request->zipcode)) {
          if (!empty($request->lat) && $request->lat!="null"  && !empty($request->long) && $request->long!="null" && !empty($request->zipcode) && $request->zipcode!="null") {
            $user_count = DB::table('user')->where('id', $user_id)->count();
            if ($user_count > 0) {
                $city_count = DB::table('city')->where('pincode', $zipcode)->where('status', 1)->count();
                if ($city_count == 0) {
                    $cityId = DB::table('city')->insertGetId([
                        'pincode' => $request->zipcode, 'city_name' => 'Kolkata', 'region_id' => 1, 'country_id' => 1,
                        'state_id' => 37, 'district_id' => 730, 'latitude' => $request->lat, 'longitude' => $request->long, 'status' => 1
                    ]);
                    $user_update = DB::table('user')
                        ->where('id', $user_id)->where('status', 1)
                        ->update([
                            'lat' => $lat,
                            'long' => $long,
                            'zipcode' => $request->zipcode,
                            'city_id' => $cityId,
                            'country_id' => 1,
                            'state_id' => 37,
                            'district_id' => 730,
                            'updated_at'=>carbon::now()
                        ]);
                } else {
                    $cityData = DB::table('city')->where('pincode', $zipcode)->where('status', 1)->first();
                    $user_update = DB::table('user')
                        ->where('id', $user_id)->where('status', 1)
                        ->update([
                            'lat' => $lat,
                            'long' => $long,
                            'zipcode' => $request->zipcode,
                            'city_id' => $cityData->id,
                            'country_id' => 1,
                            'state_id' => $cityData->state_id,
                            'district_id' => $cityData->district_id,
                            'updated_at'=>carbon::now()
                        ]);
                }
                $output['response'] = true;
                $output['message']  = 'User Lat and Long Updated';
                $output['error']    = "";
            } else {
                $output['response'] = false;
                $output['message']  = 'Lat and Long Not Updated';
                $output['error']    = "";
            }
        } else {
            $output['response'] = false;
            $output['message']  = 'Please Select Lat ,Long & Pincode';
            $output['error']    = "";
        }
        return $output;
    }
}
