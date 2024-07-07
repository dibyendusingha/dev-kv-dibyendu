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
use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\User as Userss;
use App\Models\Subscription\notification_function as NS;
use App\Models\sms;
use App\Models\Crop;

class Leadapi extends Controller
{
    //

    public function app_open(Request $request)
    {
        //same call on profile2 API...
        $new = [];
        $login_data = $request->user();
        $id = $login_data['id'];
        $current = Carbon::now()->format('Y-m-d H:i:s');
        $insert = DB::table('app_open')->insert(['user_id' => $id, 'created_at' => $current]);
        if ($insert) {
            $output['response'] = true;
            $output['message'] = 'App Open Activity Save';
            $output['data'] = $insert;
            $output['error'] = "";
        } else {
            $output['response'] = false;
            $output['message'] = 'Failed';
            $output['data'] = "";
            $output['error'] = "";
        }
        return $output;
    }

    public function page_time_spend(Request $request)
    {
        $new = [];
        $login_data = $request->user();
        $id = $login_data['id'];
        $page_name = $request->page_name;
        $total_time = $request->total_time;
        $current = Carbon::now()->format('Y-m-d H:i:s');
        $insert = DB::table('app_page_time')->insert(['user_id' => $id, 'page_name' => $page_name, 'total_time' => $total_time, 'created_at' => $current]);
        if ($insert) {
            $output['response'] = true;
            $output['message'] = 'App Page Time Activity Save';
            $output['data'] = $insert;
            $output['error'] = "";
        } else {
            $output['response'] = false;
            $output['message'] = 'Failed';
            $output['data'] = "";
            $output['error'] = "";
        }
        return $output;
    }

    public function lead_view_all(Request $request)
    {
        $output = [];
        $data = [];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $category_id = $request->category_id;
        $type = $request->type;
        $section = $request->section;

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
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {

            //App\Flight::create(['name' => 'Flight 10']);
            $insert = DB::table('leads_view_all')->insert(['user_id' => $user_id, 'category_id' => $category_id, 'type' => $type, 'section' => $section, 'created_at' => date('Y-m-d H:i:s')]);
            if ($insert) {

                $output['response'] = true;
                $output['message'] = 'Lead Generate Successfully';
                $output['data'] = $insert;
                $output['error'] = "";

            } else {
                $output['response'] = false;
                $output['message'] = 'Already Done';
                $output['data'] = '';
                $output['error'] = "";
            }
        }
        return $output;
    }

    public function lead_view(Request $request)
    {
        $output = [];
        $data = [];
        $user_id = $request->user_id;
        $post_user_id = $request->post_user_id;
        $category_id = $request->category_id;
        $post_id = $request->post_id;
        $user_token = $request->user_token;

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
            'user_id' => 'required',
            'post_user_id' => 'required',
            'category_id' => 'required',
            'post_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {

            //App\Flight::create(['name' => 'Flight 10']);
            //   $count = Leads_view::where(['user_id'=>$user_id,'post_user_id'=>$post_user_id,'category_id'=>$category_id,'post_id'=>$post_id])->count();
            //   if ($count==0) {

            $data = Api_model::create(['user_id' => $user_id, 'post_user_id' => $post_user_id, 'category_id' => $category_id, 'post_id' => $post_id, 'calls_status' => 0,
                'messages_status' => 0]);
            //echo $data;
            //   if ($data['id']>0) {
            $output['response'] = true;
            $output['message'] = 'Lead Generate Successfully';
            $output['data'] = $data;
            $output['error'] = "";
            //   }


            //   } else {
            //         $output['response']=false;
            //         $output['message']='Already Done';
            //         $output['data'] = '';
            //         $output['error'] = "";
            //   }
            //print_r($data);

        }
        return $output;
    }

    # Product Lead Generate
    public function lead_generate(Request $request)
    {
        $output = [];
        $data = [];
        $user_details = auth()->user();
        $user_id    = $user_details->id;
        $user_token = $user_details->token;

        if(!empty($request->post_user_id)){
            $post_user_id = $request->post_user_id;
        }else{
            if($request->category_id == 1){
                $post_user_id = DB::table('tractor')->where('id',$request->post_id)->first()->user_id;
            }else if($request->category_id == 3){
                $post_user_id = DB::table('goods_vehicle')->where('id',$request->post_id)->first()->user_id;
            }else if($request->category_id == 4){
                $post_user_id = DB::table('harvester')->where('id',$request->post_id)->first()->user_id;
            }else if($request->category_id == 5){
                $post_user_id = DB::table('implements')->where('id',$request->post_id)->first()->user_id;
            }else if($request->category_id == 6){
                $post_user_id = DB::table('seeds')->where('id',$request->post_id)->first()->user_id;
            }else if($request->category_id == 7){
                $post_user_id = DB::table('tyres')->where('id',$request->post_id)->first()->user_id;
            }else if($request->category_id == 8){
                $post_user_id = DB::table('pesticides')->where('id',$request->post_id)->first()->user_id;
            }else if($request->category_id == 9){
                $post_user_id = DB::table('fertilizers')->where('id',$request->post_id)->first()->user_id;
            }
        }

        $category_id = $request->category_id;
        $post_id = $request->post_id;

        if(!empty($request->calls_status)){
            $calls_status = $request->calls_status;
        }else{
            $calls_status = 0;
        }

        if(!empty($request->messages_status)){
            $messages_status = $request->messages_status;
        }else{
            $messages_status = 0;
        }

        if(!empty($request->sms)){
            $sms = $request->sms;
        }else{
            $sms = 0;
        }

        if(!empty($request->wishlist)){
            $wishlist = $request->wishlist;
        }else{
            $wishlist = 0;
        }

        if(!empty($request->share)){
            $share = $request->share;
        }else{
            $share = 0;
        }

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
            'category_id' => 'required',
            'post_id' => 'required',
            'calls_status' => 'required',
            'messages_status' => 'required',
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            if($user_id != $post_user_id) {

                $data = Api_model::create(['user_id' => $user_id, 'post_user_id' => $post_user_id, 'category_id' => $category_id, 'post_id' => $post_id, 'calls_status' => $calls_status,
                'messages_status' => $messages_status, 'sms' => $sms,'wishlist'=>$wishlist,'share'=>$share]);


                $getDataClickCount = DB::table('seller_leads')
                            ->where(['user_id' => $user_id, 'post_user_id' => $post_user_id, 'category_id' => $category_id, 'post_id' => $post_id])->orderBy('id', 'DESC')
                            ->first();
                $postClickIncrement = $getDataClickCount->post_click_count+1;
                $postClickUpdate = DB::table('seller_leads')
                                    ->where(['user_id' => $user_id, 'post_user_id' => $post_user_id, 'category_id' => $category_id, 'post_id' => $post_id])
                                    ->update(['post_click_count'=>$postClickIncrement]);

                if($data->send_notification_status == 0){
                  if($data->calls_status ==1 || $data->messages_status ==1 || $data->sms ==1 || $data->wishlist ==1 || $data->share ==1 || $postClickIncrement ==3){
                        $sms = sms::product_lead($post_user_id);
                        $update = DB::table('seller_leads')->where(['user_id' => $user_id, 'post_user_id' => $post_user_id, 'category_id' => $category_id, 'post_id' => $post_id])->update(['send_notification_status'=>1]);
                  }   
                }
                

                $output['response'] = true;
                $output['message'] = 'Lead Generate Successfully';
                $output['data'] = $data;
                $output['error'] = "";
            } else {
                $output['response'] = false;
                $output['message'] = 'Lead Not Generate as Same user';
                $output['data'] = [];
                $output['error'] = "";
            }
        }
        return $output;
    }

    public function account_counter(Request $request)
    {
        $output = [];
        $data = [];

        $user_id = $request->user_id;
        $user_token = $request->user_token;

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
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $tractor = DB::table('category')->where(['id' => 1])->first();
            //$rent_tractor = DB::table('category')->where(['id'=>2])->first();
            $gd = DB::table('category')->where(['id' => 3])->first();
            $harvestor = DB::table('category')->where(['id' => 4])->first();
            $implements = DB::table('category')->where(['id' => 5])->first();
            $seeds = DB::table('category')->where(['id' => 6])->first();
            $tyre = DB::table('category')->where(['id' => 7])->first();
            $pesticides = DB::table('category')->where(['id' => 8])->first();
            $fertilizers = DB::table('category')->where(['id' => 9])->first();

            $mypost1['category_id'] = 1;
            $mypost1['name'] = $tractor->category;
            $mypost1['ln_bn'] = $tractor->ln_bn;
            $mypost1['ln_hn'] = $tractor->ln_hn;
            $mypost1['count'] = Tractor::where(['user_id' => $user_id])->count();
            $mypost1['image'] = asset("storage/images/category/" . $tractor->icon);

            /*$mypost2['category_id'] = 2;
            $mypost2['name'] = $rent_tractor->category;
            $mypost2['count'] = Rent_tractor::where(['user_id'=>$user_id])->count();
            $mypost2['image'] = env('APP_URL')."storage/images/category/".$rent_tractor->icon;
            */
            $mypost3['category_id'] = 3;
            $mypost3['name'] = $gd->category;
            $mypost3['ln_bn'] = $gd->ln_bn;
            $mypost3['ln_hn'] = $gd->ln_hn;
            $mypost3['count'] = Goods_vehicle::where(['user_id' => $user_id])->count();
            $mypost3['image'] = asset("storage/images/category/" . $gd->icon);

            $mypost4['category_id'] = 4;
            $mypost4['name'] = $harvestor->category;
            $mypost4['ln_bn'] = $harvestor->ln_bn;
            $mypost4['ln_hn'] = $harvestor->ln_hn;
            $mypost4['count'] = Harvester::where(['user_id' => $user_id])->count();
            $mypost4['image'] = asset("storage/images/category/" . $harvestor->icon);

            $mypost5['category_id'] = 5;
            $mypost5['name'] = $implements->category;
            $mypost5['ln_bn'] = $implements->ln_bn;
            $mypost5['ln_hn'] = $implements->ln_hn;
            $mypost5['count'] = Implement::where(['user_id' => $user_id])->count();
            $mypost5['image'] = asset("storage/images/category/" . $implements->icon);

            $mypost6['category_id'] = 6;
            $mypost6['name'] = $seeds->category;
            $mypost6['ln_bn'] = $seeds->ln_bn;
            $mypost6['ln_hn'] = $seeds->ln_hn;
            $mypost6['count'] = Seed::where(['user_id' => $user_id])->count();
            $mypost6['image'] = asset("storage/images/category/" . $seeds->icon);

            $mypost7['category_id'] = 7;
            $mypost7['name'] = $tyre->category;
            $mypost7['ln_bn'] = $tyre->ln_bn;
            $mypost7['ln_hn'] = $tyre->ln_hn;
            $mypost7['count'] = Tyre::where(['user_id' => $user_id])->count();
            $mypost7['image'] = asset("storage/images/category/" . $tyre->icon);

            $mypost8['category_id'] = 8;
            $mypost8['name'] = $pesticides->category;
            $mypost8['ln_bn'] = $pesticides->ln_bn;
            $mypost8['ln_hn'] = $pesticides->ln_hn;
            $mypost8['count'] = pesticides::where(['user_id' => $user_id])->count();
            $mypost8['image'] = asset("storage/images/category/" . $pesticides->icon);

            $mypost9['category_id'] = 9;
            $mypost9['name'] = $fertilizers->category;
            $mypost9['ln_bn'] = $fertilizers->ln_bn;
            $mypost9['ln_hn'] = $fertilizers->ln_hn;
            $mypost9['count'] = fertilizers::where(['user_id' => $user_id])->count();
            $mypost9['image'] = asset("storage/images/category/" . $fertilizers->icon);

            $mypost[] = [$mypost1, $mypost3, $mypost4, $mypost5, $mypost6, $mypost7, $mypost8, $mypost9];

            $mylead1['category_id'] = 1;
            $mylead1['name'] = $tractor->category;
            $mylead1['ln_bn'] = $tractor->ln_bn;
            $mylead1['ln_hn'] = $tractor->ln_hn;
            $mylead1['count'] = Lead::leadfunction($user_id, '1');
            $mylead1['image'] = asset("storage/images/category/" . $tractor->icon);

            /*$mylead2['category_id'] = 2;
            $mylead2['name'] = $rent_tractor->category;
            $mylead2['count'] = Lead::where(['post_user_id'=>$user_id,'category_id'=>2])->count();
            $mylead2['image'] = env('APP_URL')."storage/images/category/".$rent_tractor->icon;
            */
            $mylead3['category_id'] = 3;
            $mylead3['name'] = $gd->category;
            $mylead3['ln_bn'] = $gd->ln_bn;
            $mylead3['ln_hn'] = $gd->ln_hn;
            $mylead3['count'] = Lead::leadfunction($user_id, '3');
            $mylead3['image'] = asset("storage/images/category/" . $gd->icon);

            $mylead4['category_id'] = 4;
            $mylead4['name'] = $harvestor->category;
            $mylead4['ln_bn'] = $harvestor->ln_bn;
            $mylead4['ln_hn'] = $harvestor->ln_hn;
            $mylead4['count'] = Lead::leadfunction($user_id, '4');
            $mylead4['image'] = asset("storage/images/category/" . $harvestor->icon);

            $mylead5['category_id'] = 5;
            $mylead5['name'] = $implements->category;
            $mylead5['ln_bn'] = $implements->ln_bn;
            $mylead5['ln_hn'] = $implements->ln_hn;
            $mylead5['count'] = Lead::leadfunction($user_id, '5');
            $mylead5['image'] = asset("storage/images/category/" . $implements->icon);

            $mylead6['category_id'] = 6;
            $mylead6['name'] = $seeds->category;
            $mylead6['ln_bn'] = $seeds->ln_bn;
            $mylead6['ln_hn'] = $seeds->ln_hn;
            $mylead6['count'] = Lead::leadfunction($user_id, '6');
            $mylead6['image'] = asset("storage/images/category/" . $seeds->icon);

            $mylead7['category_id'] = 7;
            $mylead7['name'] = $tyre->category;
            $mylead7['ln_bn'] = $tyre->ln_bn;
            $mylead7['ln_hn'] = $tyre->ln_hn;
            $mylead7['count'] = Lead::leadfunction($user_id, '7');
            $mylead7['image'] = asset("storage/images/category/" . $tyre->icon);

            $mylead8['category_id'] = 8;
            $mylead8['name'] = $pesticides->category;
            $mylead8['ln_bn'] = $pesticides->ln_bn;
            $mylead8['ln_hn'] = $pesticides->ln_hn;
            $mylead8['count'] = Lead::leadfunction($user_id, '8');
            $mylead8['image'] = asset("storage/images/category/" . $pesticides->icon);

            $mylead9['category_id'] = 9;
            $mylead9['name'] = $fertilizers->category;
            $mylead9['ln_bn'] = $fertilizers->ln_bn;
            $mylead9['ln_hn'] = $fertilizers->ln_hn;
            $mylead9['count'] = Lead::leadfunction($user_id, '9');
            $mylead9['image'] = asset("storage/images/category/" . $fertilizers->icon);

            $mylead[] = [$mylead1, $mylead3, $mylead4, $mylead5, $mylead6, $mylead7, $mylead8, $mylead9];

            $enquiry1['category_id'] = 1;
            $enquiry1['name'] = $tractor->category;
            $enquiry1['ln_bn'] = $tractor->ln_bn;
            $enquiry1['ln_hn'] = $tractor->ln_hn;
            $enquiry1['count'] = Lead::enquiryfunction($user_id, '1');
            $enquiry1['image'] = asset("storage/images/category/" . $tractor->icon);

            /*$enquiry2['category_id'] = 2;
            $enquiry2['name'] = $rent_tractor->category;
            $enquiry2['count'] = Lead::where(['user_id'=>$user_id,'category_id'=>2])->count();
            $enquiry2['image'] = env('APP_URL')."storage/images/category/".$rent_tractor->icon;
            */
            $enquiry3['category_id'] = 3;
            $enquiry3['name'] = $gd->category;
            $enquiry3['ln_bn'] = $gd->ln_bn;
            $enquiry3['ln_hn'] = $gd->ln_hn;
            $enquiry3['count'] = Lead::enquiryfunction($user_id, '3');
            $enquiry3['image'] = asset("storage/images/category/" . $gd->icon);

            $enquiry4['category_id'] = 4;
            $enquiry4['name'] = $harvestor->category;
            $enquiry4['ln_bn'] = $harvestor->ln_bn;
            $enquiry4['ln_hn'] = $harvestor->ln_hn;
            $enquiry4['count'] = Lead::enquiryfunction($user_id, '4');
            $enquiry4['image'] = asset("storage/images/category/" . $harvestor->icon);

            $enquiry5['category_id'] = 5;
            $enquiry5['name'] = $implements->category;
            $enquiry5['ln_bn'] = $implements->ln_bn;
            $enquiry5['ln_hn'] = $implements->ln_hn;
            $enquiry5['count'] = Lead::enquiryfunction($user_id, '5');
            $enquiry5['image'] = asset("storage/images/category/" . $implements->icon);

            $enquiry6['category_id'] = 6;
            $enquiry6['name'] = $seeds->category;
            $enquiry6['ln_bn'] = $seeds->ln_bn;
            $enquiry6['ln_hn'] = $seeds->ln_hn;
            $enquiry6['count'] = Lead::enquiryfunction($user_id, '6');
            $enquiry6['image'] = asset("storage/images/category/" . $seeds->icon);

            $enquiry7['category_id'] = 7;
            $enquiry7['name'] = $tyre->category;
            $enquiry7['ln_bn'] = $tyre->ln_bn;
            $enquiry7['ln_hn'] = $tyre->ln_hn;
            $enquiry7['count'] = Lead::enquiryfunction($user_id, '7');
            $enquiry7['image'] = asset("storage/images/category/" . $tyre->icon);

            $enquiry8['category_id'] = 8;
            $enquiry8['name'] = $pesticides->category;
            $enquiry8['ln_bn'] = $pesticides->ln_bn;
            $enquiry8['ln_hn'] = $pesticides->ln_hn;
            $enquiry8['count'] = Lead::enquiryfunction($user_id, '8');
            $enquiry8['image'] = asset("storage/images/category/" . $pesticides->icon);

            $enquiry9['category_id'] = 9;
            $enquiry9['name'] = $fertilizers->category;
            $enquiry9['ln_bn'] = $fertilizers->ln_bn;
            $enquiry9['ln_hn'] = $fertilizers->ln_hn;
            $enquiry9['count'] = Lead::enquiryfunction($user_id, '9');
            $enquiry9['image'] = asset("storage/images/category/" . $fertilizers->icon);

            $enquiry[] = [$enquiry1, $enquiry3, $enquiry4, $enquiry5, $enquiry6, $enquiry7, $enquiry8, $enquiry9];

            $new[] = ['mypost' => $mypost, 'mylead' => $mylead, 'enquiry' => $enquiry];

            $output['response'] = true;
            $output['message'] = 'Account counter';
            $output['data'] = $new;
            $output['error'] = "";
        }
        return $output;
    }


    public function my_post(Request $request)
    {
        $output = [];
        $data = [];
        $new = [];
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $user_token = $request->user_token;

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
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {

            /*$tractor_data =  Tractor::where(['user_id'=>$user_id])->get();
            foreach ($tractor_data as $val) {
                
            }*/
            $where = ['user_id' => $user_id];

            if ($category_id == 1) {
                $count = Tractor::where($where)->count();
                if ($count > 0) {
                    $new = Tractor::get_data_by_where($where);

                    $output['response'] = true;
                    $output['message'] = 'Data Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Data Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }

            }

            /*if ($category_id==2) {
            $count = Rent_tractor::where($where)->count();
            if ($count>0) {
            $new = Rent_tractor::get_data_by_where($where);
            
                $output['response']=true;
                $output['message']='Data Found';
                $output['data'] = $new;
                $output['error'] = "";
                
            } else {
                $output['response']=false;
                $output['message']='No Data Found';
                $output['data'] = '';
                $output['error'] = "";
            }
            
            }*/

            if ($category_id == 3) {
                $count = Goods_vehicle::where($where)->count();
                if ($count > 0) {
                    $new = Goods_vehicle::get_data_by_where($where);

                    $output['response'] = true;
                    $output['message'] = 'Data Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Data Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }

            }

            if ($category_id == 4) {
                $count = Harvester::where($where)->count();
                if ($count > 0) {
                    $new = Harvester::get_data_by_where($where);

                    $output['response'] = true;
                    $output['message'] = 'Data Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Data Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }

            }

            if ($category_id == 5) {
                $count = Implement::where($where)->count();
                if ($count > 0) {
                    $new = Implement::get_data_by_where($where);

                    $output['response'] = true;
                    $output['message'] = 'Data Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Data Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }

            }

            if ($category_id == 6) {
                $count = Seed::where($where)->count();
                if ($count > 0) {
                    $new = Seed::get_data_by_where($where);

                    $output['response'] = true;
                    $output['message'] = 'Data Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Data Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }

            }

            if ($category_id == 7) {
                $count = Tyre::where($where)->count();
                if ($count > 0) {
                    $new = Tyre::get_data_by_where($where);

                    $output['response'] = true;
                    $output['message'] = 'Data Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Data Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }

            }

            if ($category_id == 8) {
                $count = pesticides::where($where)->count();
                if ($count > 0) {
                    $new = pesticides::get_data_by_where($where);

                    $output['response'] = true;
                    $output['message'] = 'Data Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Data Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }

            }

            if ($category_id == 9) {
                $count = fertilizers::where($where)->count();
                if ($count > 0) {
                    $new = fertilizers::get_data_by_where($where);

                    $output['response'] = true;
                    $output['message'] = 'Data Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Data Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }

            }

            /*else {
                $output['response']=false;
                $output['message']='Category Mistmatch';
                $output['data'] = '';
                $output['error'] = "";
            }*/

        }

        return $output;
    }

    public function my_lead(Request $request)
    {
        $output = [];
        $data = [];
        $count = 0;
        $new = [];

        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $user_token = $request->user_token;

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
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {


            if ($category_id == 1) {
                $count = Lead::leadfunction($user_id, $category_id);
                if ($count > 0) {
                    $new = Lead::leadfunction_get_array($user_id, $category_id);
                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";
                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            }
            else if ($category_id == 3) {
                $count = Lead::leadfunction($user_id, $category_id);
                if ($count > 0) {

                    $new = Lead::leadfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";



                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 4) {
                $count = Lead::leadfunction($user_id, $category_id);
                if ($count > 0) {

                    $new = Lead::leadfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";



                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 5) {
                $count = Lead::leadfunction($user_id, $category_id);
                if ($count > 0) {

                    $new = Lead::leadfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";



                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 6) {
                $count = Lead::leadfunction($user_id, $category_id);
                if ($count > 0) {

                    $new = Lead::leadfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";



                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 7) {
                $count = Lead::leadfunction($user_id, $category_id);
                if ($count > 0) {

                    $new = Lead::leadfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";



                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 8) {
                $count = Lead::leadfunction($user_id, $category_id);
                if ($count > 0) {

                    $new = Lead::leadfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";



                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 9) {
                $count = Lead::leadfunction($user_id, $category_id);
                if ($count > 0) {

                    $new = Lead::leadfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";



                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            }

        }

        return $output;
    }

    public function my_enquery(Request $request)
    {

        $output = [];
        $data = [];
        $new = [];
        $count = 0;

        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $user_token = $request->user_token;

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
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {


            if ($category_id == 1) {
                $count = Lead::enquiryfunction($user_id, $category_id);
                if ($count > 0) {
                    $new = Lead::enquiryfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 3) {
                $count = Lead::enquiryfunction($user_id, $category_id);
                if ($count > 0) {
                    $new = Lead::enquiryfunction_get_array($user_id, $category_id);
                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";
                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 4) {
                $count = Lead::enquiryfunction($user_id, $category_id);
                if ($count > 0) {
                    $new = Lead::enquiryfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 5) {
                $count = Lead::enquiryfunction($user_id, $category_id);
                if ($count > 0) {
                    $new = Lead::enquiryfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 6) {
                $count = Lead::enquiryfunction($user_id, $category_id);
                if ($count > 0) {
                    $new = Lead::enquiryfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 7) {
                $count = Lead::enquiryfunction($user_id, $category_id);
                if ($count > 0) {
                    $new = Lead::enquiryfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";



                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 8) {
                $count = Lead::enquiryfunction($user_id, $category_id);
                if ($count > 0) {
                    $new = Lead::enquiryfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            } else if ($category_id == 9) {
                $count = Lead::enquiryfunction($user_id, $category_id);
                if ($count > 0) {
                    $new = Lead::enquiryfunction_get_array($user_id, $category_id);

                    $output['response'] = true;
                    $output['message'] = 'Leads Found';
                    $output['data'] = $new;
                    $output['error'] = "";

                } else {
                    $output['response'] = false;
                    $output['message'] = 'No Leads Found';
                    $output['data'] = '';
                    $output['error'] = "";
                }
            }

        }

        return $output;

    }

    public function notification(Request $request)
    {
        $output = [];
        $data = [];
        $new = [];

        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $user_token = $request->user_token;

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
            'user_id' => 'required',
            'user_token' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {

            $count = Lead::where(['post_user_id' => $user_id])->count();
            if ($count > 0) {
                $lead_arr = Lead::orderBy('id', 'desc')->where(['post_user_id' => $user_id])->get();
                foreach ($lead_arr as $val_lead) {
                    $id = $val_lead->id;
                    $user_id_db = $val_lead->user_id;
                    $post_user_id = $val_lead->post_user_id;
                    $category_id = $val_lead->category_id;
                    $post_id = $val_lead->post_id;


                    if ($category_id == 1) {
                        $where = ['id' => $post_id];
                        $data = Tractor::get_notification_data_by_where($where, $user_id_db);
                    }

                    /*if ($category_id==2) {
                    $where = ['id'=>$post_id];
                    $data = Rent_tractor::get_notification_data_by_where($where,$user_id_db);    
                    } */

                    if ($category_id == 3) {
                        $where = ['id' => $post_id];
                        $data = Goods_vehicle::get_notification_data_by_where($where, $user_id_db);
                    }

                    if ($category_id == 4) {
                        $where = ['id' => $post_id];
                        $data = Harvester::get_notification_data_by_where($where, $user_id_db);
                    }

                    if ($category_id == 5) {
                        $where = ['id' => $post_id];
                        $data = Implement::get_notification_data_by_where($where, $user_id_db);
                    }

                    if ($category_id == 6) {
                        $where = ['id' => $post_id];
                        $data = Seed::get_notification_data_by_where($where, $user_id_db);
                    }

                    if ($category_id == 7) {
                        $where = ['id' => $post_id];
                        $data = Tyre::get_notification_data_by_where($where, $user_id_db);
                    }

                    if ($category_id == 8) {
                        $where = ['id' => $post_id];
                        $data = pesticides::get_notification_data_by_where($where, $user_id_db);
                    }

                    if ($category_id == 9) {
                        $where = ['id' => $post_id];
                        $data = fertilizers::get_notification_data_by_where($where, $user_id_db);
                    }
                    
                    if ($category_id == 12) {
                        $where = ['id' => $post_id];
                        $data = Crop::get_notification_data_by_where($where, $user_id_db);
                    }


                    $new[] = $data;
                }
                $output['response'] = true;
                $output['message'] = 'Notification Found';
                $output['data'] = $new;
                $output['error'] = "";

            } else {
                $output['response'] = false;
                $output['message'] = 'No Notification Found';
                $output['data'] = '';
                $output['error'] = "";
            }

        }
        return $output;
    }

    public function banner_click_lead(Request $request)
    {
        $output = [];
        $data = [];
        $array = [];
        $image_url = [];
        $login_data = $request->user();
        $user_id = $login_data['id'];

        $banner_id = $request->banner_id;
        $banner_user_id = DB::table('sponser')->where(['id' => $banner_id])->value('user_id');
        $banner_ad_category = DB::table('sponser')->where(['id' => $banner_id])->value('ad_category');
        $insert = DB::table('sponser_lead')->insert(['user_id' => $user_id, 'ad_user_id' => $banner_user_id, 'ad_id' => $banner_id,
            'ad_category' => $banner_ad_category, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

        if ($insert) {
            $output['response'] = true;
            $output['message'] = 'Banner Data Inserted';
            $output['data'] = $insert;
            $output['error'] = "";
        } else {
            $output['response'] = false;
            $output['message'] = 'Something Went Wrong';
            $output['data'] = '';
            $output['error'] = "";
        }
        return $output;
    }

    public function ad_leads(Request $request)
    {
        $output = [];
        $data = [];

        $validator = Validator::make($request->all(), [
            'ad_id' => '',
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $ad_id = $request->ad_id;
            $data['image_url'] = asset('storage/sponser/');
            $data['data'] = DB::table('sponser_lead as s')
                ->join('user as u', 'u.id', '=', 's.user_id')
                ->join('sponser as sp','sp.id','=','s.ad_id')
                ->join('state','u.state_id','=','state.id')
                ->join('district','u.district_id','=','district.id')
                ->join('city','u.city_id','=','city.id')
                ->select('s.id as s_id','s.ad_user_id as ad_user_id','s.ad_category as ad_category','s.created_at as created_at',
                    'sp.image as ad_image','sp.ad_name as ad_name',
                'u.id as id','u.name as name','u.user_type_id as user_type_id','u.company_name as company_name',
                'u.gst_no as gst_no','u.mobile as mobile','u.email as email','u.address as address','u.state_id','u.state_id as state_id',
                'u.city_id as city_id','u.zipcode as zipcode','u.latlong as latlong',
                'state.state_name','district.district_name','city.city_name',
                )
                ->where(['ad_id' => $ad_id])
                ->get();

            $output['response'] = true;
            $output['message'] = 'Leads';
            $output['data'] = $data;
            $output['error'] = "";
        }
        return $output;
    }


    /** Dibyendu Add My Product Lead View */
    public function my_product_lead_view(Request $request){
        $output = [];
        $data = [];

        $user_id     = auth()->user()->id;
       // $user_id     = 39;
        $category_id = $request->category_id;
        $post_id     = $request->post_id;

        if(!empty($request->category_id) && !empty($request->post_id)){
            $seller_count = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->count();
           // dd($seller_count);
            
            if($seller_count > 0){
                $seller_only_user_id = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->first()->user_id;

                if($request->category_id == 1){
                    $seller_details = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->get();

                   // dd($seller_details);
                    foreach($seller_details as $key=> $seller){
                        $post_id = $seller->post_id;
                        $seller_user_id = $seller->user_id;

                        $tractor_details = DB::table('tractor')->where('id',$post_id)->first();
                        $font_image = asset("storage/tractor/".$tractor_details->front_image);
                        $user_count  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->first();
    
                            if($user_details->id != null){
                                $userId = $user_details->id;
                            }

                            if($user_details->name != null){
                                $user_name = $user_details->name;
                            }else if($user_details->name == null){
                                $user_name = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_mobile = $user_details->mobile;
                            }else{
                                $user_mobile = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_email = $user_details->email;
                            }else{
                                $user_email = null;
                            }
                        }else{
                            $user_name = null;
                            $user_mobile = null;
                            $user_email = null;
                        }
                       
                        $data[$key] = [
                            'seller_lead_id'=>$seller->id,
                            'post_id'=>$seller->post_id,
                            'seller_lead_status' => $seller->status,
                            'font_image'=>$font_image,
                            'user_id'=>$userId,
                            'user_name' => $user_name,
                            'user_mobile'=>$user_mobile,
                            'user_email'=>$user_email
                        ];
                    }

                    $seller_count   =  DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->count();
                }
                else if($request->category_id == 3){

                    $seller_details = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->get();
                    foreach($seller_details as $key=> $seller){
                        $post_id = $seller->post_id;
                        $seller_user_id = $seller->user_id;
                       // $seller_lead_status = $seller->status;

                        $tractor_details = DB::table('goods_vehicle')->where('id',$post_id)->first();
                        $font_image = asset("storage/goods_vehicle/".$tractor_details->front_image);
                        $user_count  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->first();
    
                            if($user_details->id != null){
                                $userId = $user_details->id;
                            }

                            if($user_details->name != null){
                                $user_name = $user_details->name;
                            }else if($user_details->name == null){
                                $user_name = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_mobile = $user_details->mobile;
                            }else{
                                $user_mobile = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_email = $user_details->email;
                            }else{
                                $user_email = null;
                            }

                        }else{
                            $user_name = null;
                            $user_mobile = null;
                            $user_email = null;
                        }

                        $data[$key] = [
                            'seller_lead_id'=>$seller->id,
                            'post_id'=>$seller->post_id,
                            'seller_lead_status' => $seller->status,
                            'font_image'=>$font_image,
                            'user_id'=>$userId,
                            'user_name' => $user_name,
                            'user_mobile'=>$user_mobile,
                            'user_email'=>$user_email
                        ];
                    }

                    $seller_count   =  DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->count();
                }
                else if($request->category_id == 4){
                    $seller_details = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->get();
                    foreach($seller_details as $key=> $seller){
                        $post_id = $seller->post_id;
                        $seller_user_id = $seller->user_id;

                        $tractor_details = DB::table('harvester')->where('id',$post_id)->first();
                        $font_image = asset("storage/harvester/".$tractor_details->front_image);
                        $user_count  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->first();
    
                            if($user_details->id != null){
                                $userId = $user_details->id;
                            }

                            if($user_details->name != null){
                                $user_name = $user_details->name;
                            }else if($user_details->name == null){
                                $user_name = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_mobile = $user_details->mobile;
                            }else{
                                $user_mobile = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_email = $user_details->email;
                            }else{
                                $user_email = null;
                            }

                        }else{
                            $user_name = null;
                            $user_mobile = null;
                            $user_email = null;
                        }

                       $data[$key] = [
                            'seller_lead_id'=>$seller->id,
                            'post_id'=>$seller->post_id,
                            'seller_lead_status' => $seller->status,
                            'font_image'=>$font_image,
                            'user_id'=>$userId,
                            'user_name' => $user_name,
                            'user_mobile'=>$user_mobile,
                            'user_email'=>$user_email
                        ];
                    }

                    $seller_count   =  DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->count();
                }
                else if($request->category_id == 5){
                    $seller_details = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->get();
                    foreach($seller_details as $key=> $seller){
                        $post_id        = $seller->post_id;
                        $seller_user_id = $seller->user_id;

                        $tractor_details = DB::table('implements')->where('id',$post_id)->first();
                        $font_image      = asset("storage/implements/".$tractor_details->front_image);
                        $user_count  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->first();

                            if($user_details->id != null){
                                $userId = $user_details->id;
                            }
    
                            if($user_details->name != null){
                                $user_name = $user_details->name;
                            }else if($user_details->name == null){
                                $user_name = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_mobile = $user_details->mobile;
                            }else{
                                $user_mobile = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_email = $user_details->email;
                            }else{
                                $user_email = null;
                            }

                        }else{
                            $user_name = null;
                            $user_mobile = null;
                            $user_email = null;
                        }

                       $data[$key] = [
                            'seller_lead_id'=>$seller->id,
                            'post_id'=>$seller->post_id,
                            'seller_lead_status' => $seller->status,
                            'font_image'=>$font_image,
                            'user_id'=>$userId,
                            'user_name' => $user_name,
                            'user_mobile'=>$user_mobile,
                            'user_email'=>$user_email
                        ];
                    }
                    $seller_count   =  DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->count();
                } 
                else if($request->category_id == 6){
                    $seller_details = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->get();
                    foreach($seller_details as $key=> $seller){
                        $post_id        = $seller->post_id;
                        $seller_user_id = $seller->user_id;

                        $tractor_details = DB::table('seeds')->where('id',$post_id)->first();
                        $font_image      = asset("storage/seeds/".$tractor_details->image1);
                        $user_count  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->first();
    
                            if($user_details->id != null){
                                $userId = $user_details->id;
                            }

                            if($user_details->name != null){
                                $user_name = $user_details->name;
                            }else if($user_details->name == null){
                                $user_name = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_mobile = $user_details->mobile;
                            }else{
                                $user_mobile = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_email = $user_details->email;
                            }else{
                                $user_email = null;
                            }

                        }else{
                            $user_name = null;
                            $user_mobile = null;
                            $user_email = null;
                        }

                        $data[$key] = [
                            'seller_lead_id'=>$seller->id,
                            'post_id'=>$seller->post_id,
                            'seller_lead_status' => $seller->status,
                            'font_image'=>$font_image,
                            'user_id'=>$userId,
                            'user_name' => $user_name,
                            'user_mobile'=>$user_mobile,
                            'user_email'=>$user_email
                        ];
                    }
                    $seller_count   =  DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->count();
                }
                else if($request->category_id == 7){
                    $seller_details = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->get();
                    foreach($seller_details as $key=> $seller){
                        $post_id        = $seller->post_id;
                        $seller_user_id = $seller->user_id;

                        $tractor_details = DB::table('tyres')->where('id',$post_id)->first();
                        $font_image      = asset("storage/tyre/".$tractor_details->image1);
                        $user_count  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->first();
                            if($user_details->id != null){
                                $userId = $user_details->id;
                            }
    
                            if($user_details->name != null){
                                $user_name = $user_details->name;
                            }else if($user_details->name == null){
                                $user_name = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_mobile = $user_details->mobile;
                            }else{
                                $user_mobile = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_email = $user_details->email;
                            }else{
                                $user_email = null;
                            }

                        }else{
                            $user_name = null;
                            $user_mobile = null;
                            $user_email = null;
                        }

                       $data[$key] = [
                            'seller_lead_id'=>$seller->id,
                            'post_id'=>$seller->post_id,
                            'seller_lead_status' => $seller->status,
                            'font_image'=>$font_image,
                            'user_id'=>$userId,
                            'user_name' => $user_name,
                            'user_mobile'=>$user_mobile,
                            'user_email'=>$user_email
                        ];
                    }
                    $seller_count   =  DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->count();
                }
                else if($request->category_id == 8){
                    $seller_details = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->get();
                    foreach($seller_details as $key=> $seller){
                        $post_id        = $seller->post_id;
                        $seller_user_id = $seller->user_id;

                        $tractor_details = DB::table('pesticides')->where('id',$post_id)->first();
                        $font_image      = asset("storage/pesticides/".$tractor_details->image1);
                        $user_count  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->first();

                            if($user_details->id != null){
                                $userId = $user_details->id;
                            }
    
                            if($user_details->name != null){
                                $user_name = $user_details->name;
                            }else if($user_details->name == null){
                                $user_name = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_mobile = $user_details->mobile;
                            }else{
                                $user_mobile = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_email = $user_details->email;
                            }else{
                                $user_email = null;
                            }

                        }else{
                            $user_name = null;
                            $user_mobile = null;
                            $user_email = null;
                        }

                        $data[$key] = [
                            'seller_lead_id'=>$seller->id,
                            'post_id'=>$seller->post_id,
                            'seller_lead_status' => $seller->status,
                            'font_image'=>$font_image,
                            'user_id'=>$userId,
                            'user_name' => $user_name,
                            'user_mobile'=>$user_mobile,
                            'user_email'=>$user_email
                        ];
                    }
                    $seller_count   =  DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->count();
                }
                else if($request->category_id == 9){
                    $seller_details = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->get();
                    foreach($seller_details as $key=> $seller){
                        $post_id        = $seller->post_id;
                        $seller_user_id = $seller->user_id;

                        $tractor_details = DB::table('fertilizers')->where('id',$post_id)->first();
                        $font_image      = asset("storage/fertilizers/".$tractor_details->image1);
                        $user_count  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->first();

                            if($user_details->id != null){
                                $userId = $user_details->id;
                            }
    
                            if($user_details->name != null){
                                $user_name = $user_details->name;
                            }else if($user_details->name == null){
                                $user_name = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_mobile = $user_details->mobile;
                            }else{
                                $user_mobile = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_email = $user_details->email;
                            }else{
                                $user_email = null;
                            }

                        }else{
                            $user_name = null;
                            $user_mobile = null;
                            $user_email = null;
                        }

                       $data[$key] = [
                            'seller_lead_id'=>$seller->id,
                            'post_id'=>$seller->post_id,
                            'seller_lead_status' => $seller->status,
                            'font_image'=>$font_image,
                            'user_id'=>$userId,
                            'user_name' => $user_name,
                            'user_mobile'=>$user_mobile,
                            'user_email'=>$user_email
                        ];
                    }
                    $seller_count   =  DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->count();
                }
                else if($request->category_id == 12){
                   // dd($user_id);
                    $seller_details = DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->get();
                   // dd($seller_details);
                    foreach($seller_details as $key=> $seller){
                        $post_id        = $seller->post_id;
                        $seller_user_id = $seller->user_id;

                        $tractor_details = DB::table('crops')->where('id',$post_id)->first();
                        $font_image      = asset("storage/crops/".$tractor_details->image1);
                        $user_count  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where('id',$seller_user_id)->where('status',1)->first();

                            if($user_details->id != null){
                                $userId = $user_details->id;
                            }
    
                            if($user_details->name != null){
                                $user_name = $user_details->name;
                            }else if($user_details->name == null){
                                $user_name = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_mobile = $user_details->mobile;
                            }else{
                                $user_mobile = null;
                            }
    
                            if($user_details->mobile != null){
                                $user_email = $user_details->email;
                            }else{
                                $user_email = null;
                            }

                        }else{
                            $user_name = null;
                            $user_mobile = null;
                            $user_email = null;
                        }

                       $data[$key] = [
                            'seller_lead_id'     => $seller->id,
                            'post_id'            => $seller->post_id,
                            'seller_lead_status' => $seller->status,
                            'font_image'         => $font_image,
                            'user_id'            => $userId,
                            'user_name'          => $user_name,
                            'user_mobile'        => $user_mobile,
                            'user_email'         => $user_email
                        ];
                    }
                    $seller_count   =  DB::table('seller_leads')->where('post_id',$post_id)->where('category_id',$category_id)->where('post_user_id',$user_id)->count();
                }
                
                $uniqueData = [];
                $seenIds = [];

                foreach ($data as $item) {
                    if (!in_array($item['user_id'], $seenIds)) {
                        $uniqueData[] = $item;
                        $seenIds[] = $item['user_id'];
                    }
                }

                if($seller_only_user_id != $user_id ){
                   // $boost_lead = sms::lead_boost($post_id,$category_id,$user_id);
                }

                $output['response']    = true;
                $output['message']     = 'Seller Lead View Successfully';
                $output['lead_count']  = $seller_count;
                $output['data']        = $uniqueData;
                $output['error']       = "";
            }else{
                $output['response'] = true;
                $output['message']  = 'No data found';
                $output['data']     = [];
                $output['error']    = "";
            }

        }else{
            $output['response'] = false;
            $output['message']  = 'please select category-id & post-id';
            $output['data']     = [];
            $output['error']    = "";
        }

        return $output;
    }
}
