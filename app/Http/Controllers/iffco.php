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
use App\Models\Tyre;
use App\Models\pesticides;
use App\Models\fertilizers;

use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\User as Userss;
use Image;
use Carbon\Carbon;

class iffco extends Controller
{
      /** Dibyendu Change 02.09.2023 */
      public function iffco_dealer_page_show(){
        return view('front.development.iffco-dealer');
    }

    /** Dibyendu Change 02.09.2023 */
    public function iffco_product_page_show(){
        $getProduct = DB::table('iffco_product')->get();
        return view('front.development.iffco-product',compact('getProduct'));
    }

    public function app_status_check () {
        $status = DB::table('settings')->where(['name'=>'iffco'])->value('value');
        if ($status==1) {
            $output['response']=true;
            $output['message']='Iffco module Show';
            $output['image']=asset("storage/iffco/iffco_banner-app.jpg");
            $output['error'] = "";
        } else {
            $output['response']=false;
            $output['message']='Iffco module Hide';
            $output['image']='';
            $output['error'] = "";
        }
        return $output;
    }

    public function iffco_product () {
        $array = DB::table('iffco_product')->where(['status'=>1])->get();
        foreach ($array as $val) {
            $id = $val->id;
            $product_image = asset("storage/iffco/products/".$val->product_image);
            $product_name = $val->product_name;
            $description = $val->description;

            $new[] = ['id'=>$id,'product_image'=>$product_image,'product_name'=>$product_name,'description'=>$description, 'company_id'=>1];
        }
            $output['response']=true;
            $output['message']='Iffco products';
            $output['data'] = $new;
            $output['error'] = "";

            return $output;

    }

    public function iffco_counter (Request $request) {
        $new = [];
        $company_id      = $request->company_id;
        $pincode         = $request->pincode;
        // $lat             = $request->lat;
        // $long            = $request->long;
        $pincode_details = DB::table('city')->where(['pincode'=>$pincode,'status'=>1])->first();
        $state_id        = $pincode_details->state_id;
        $district_id     = $pincode_details->district_id;
        $latitude        = $pincode_details->latitude;
        $longitude       = $pincode_details->longitude;

        $skip        = $request->skip;
        $take        = $request->take;
        
        $get = DB::table('user')->select('*',
                DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(user.lat))
                        * cos(radians(user.long) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(user.lat))) AS distance"))
                        ->orderBy('distance','asc')
                        ->limit($take)
                        ->offset($skip)
                        ->where(['company_id'=>1])
                        ->where(['status'=>1])
                        ->get();
        
        //$get = DB::table('iffco_counter')->where(['status'=>1])->get();
        foreach ($get as $val) {
            $distance     = round($val->distance);
            $id           = $val->id;
            $name         = $val->name;
            $company_name = $val->company_name;
            $gst_no       = $val->gst_no;
            $mobile       = $val->mobile;
            $email        = $val->email;
            $address      = $val->address;
            $country_id   = $val->country_id;
            $state_id     = $val->state_id;
            $district_id  = $val->district_id;
            $city_id      = $val->city_id;
            $zipcode      = $val->zipcode;
            $lat          = $val->lat;
            $long         = $val->long;
            
            
            $new[] = ['distance'=>$distance,'id'=>$id,'name'=>$name,'company_name'=>$company_name,'gst_no'=>$gst_no,'mobile'=>$mobile,'email'=>$email,'address'=>$address,'state_id'=>$state_id,'district_id'=>$district_id,
            'city_id'=>$city_id,'zipcode'=>$zipcode,'lat'=>$lat,'long'=>$long];
        }
        
            $output['response']=true;
            $output['message']='Iffco Counters';
            $output['data'] = $new;
            $output['error'] = "";
            
            return $output;
        
    }

    /** Dibyendu Change 02.09.2023 */
    public function iffco_counter1 (Request $request) {

        $pincode = $request->session()->get('pincode');
        //dd($pincode);
        $new = [];
        // $company_id = $request->company_id;
        $company_id = 1;
        //$pincode = $request->pincode;
        // $lat = $request->lat;
        // $long = $request->long;
        $pincode_details = DB::table('city')->where(['pincode'=>$pincode,'status'=>1])->first();
        //dd($pincode_details);
        $state_id    = $pincode_details->state_id;
        $district_id = $pincode_details->district_id;
        $latitude    = $pincode_details->latitude;
        $longitude   = $pincode_details->longitude;

        // $get = DB::table('iffcodealerview')->select('iffcodealerview.name','iffcodealerview.id'
        // , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
        //                 * cos(radians(iffcodealerview.latitude))
        //                 * cos(radians(iffcodealerview.latitude) - radians(" .$longitude. "))
        //                 + sin(radians(" .$latitude. "))
        //                 * sin(radians(iffcodealerview.latitude))) AS distance"))
        //                 ->orderBy('distance','asc')
                        
        // ->get();

        $get = DB::table('iffcoDealerView')
            ->select('*'
            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
            * cos(radians(iffcoDealerView.latitude))
            * cos(radians(iffcoDealerView.longitude) - radians(" .$longitude. "))
            + sin(radians(" .$latitude. "))
            * sin(radians(iffcoDealerView.latitude))) AS distance"))
            ->where('status', 1)
            ->orderBy('distance','asc')
            ->paginate(20);

        //dd($get);

        //$get = DB::table('iffco_counter')->where(['status'=>1])->get();
        // foreach ($get as $val) {
        //     $id           = $val->id;
        //     $name         = $val->name;
        //     $company_name = $val->company_name;
        //     $gst_no       = $val->gst_no;
        //     $mobile       = $val->mobile;
        //     $email        = $val->email;
        //     $address      = $val->address;
        //     $country_id   = $val->country_id;
        //     $state_id     = $val->state_id;
        //     $district_id  = $val->district_id;
        //     $city_id      = $val->city_id;
        //     $zipcode      = $val->zipcode;
        //     $lat          = $val->lat;
        //     $long         = $val->long;


        //     $new[] = ['id'=>$id,'name'=>$name,'company_name'=>$company_name,'gst_no'=>$gst_no,'mobile'=>$mobile,'email'=>$email,'address'=>$address,'state_id'=>$state_id,'district_id'=>$district_id,
        //     'city_id'=>$city_id,'zipcode'=>$zipcode,'lat'=>$lat,'long'=>$long];
        // }

            $output['response'] = true;
            $output['message']  = 'Iffco Counters';
            // $output['data']  = $new;
            $output['get']      = $get;
            $output['error']    = "";

           //return $output;
            return view('front.development.iffco-dealer',compact('output'));

    }

    /********** Iffco Tracking **********/
    public function iffco_tracking (Request $request) {
        $output = []; $data=[];
        $user_id = $request->user_id;
        $call_status = $request->call_status;
        $dealership_id = $request->dealership_id;
        $product_id = $request->product_id;

        $db = DB::table('iffco_leads')->insert(['user_id'=>$user_id,'call_status'=>$call_status,'dealership_id'=>$dealership_id,'product_id'=>$product_id
        ,'created_at'=>date('Y-m-d'),'updated_at'=>date('Y-m-d')]);
        if ($db) {
            $output['response']=true;
            $output['message']='Data';
            $output['data'] = $db;
            $output['error'] = "";
        } else {
            $output['response']=false;
            $output['message']='Failed';
            $output['data'] = '';
            $output['error'] = "";
        }
        return $output;
    }

    /** Dibyendu Change 16.09.2023 */
    public function iffco_dealer_tracking(Request $request,$call,$dealerId){
        // dd($dealerId);
        
         $pincode = $request->session()->get('pincode');
         $new = [];
         $company_id = 1;
         $pincode_details = DB::table('city')->where(['pincode'=>$pincode,'status'=>1])->first();
 
         $state_id    = $pincode_details->state_id;
         $district_id = $pincode_details->district_id;
         $latitude    = $pincode_details->latitude;
         $longitude   = $pincode_details->longitude;
 
         $get = DB::table('iffcoDealerView')
             ->select('*'
             , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
             * cos(radians(iffcoDealerView.latitude))
             * cos(radians(iffcoDealerView.longitude) - radians(" .$longitude. "))
             + sin(radians(" .$latitude. "))
             * sin(radians(iffcoDealerView.latitude))) AS distance"))
             ->where('status', 1)
             ->orderBy('distance','asc')
             ->paginate(10);
 
         
         $output['response']=true;
         $output['message']='Iffco Counters';
         $output['get'] = $get;
         $output['error'] = "";
 
 
         if (session()->has('KVMobile')) {
             $mobile = session()->get('KVMobile');
             $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
             $mytime = Carbon::now();
             $date = $mytime->toDateTimeString();
             
             $values = array('user_id' => $user_id ,'call_status' =>1,'dealership_id'=>$dealerId,'product_id'=>null,'created_at'=>$date,'updated_at'=>$date);
             DB::table('iffco_leads')->insert($values);
             
         }
 
         //dd($pincode);
 
        return view('front.development.iffco-dealer',compact('output'));
        // return redirect('ifco-dealer-page/iffco/2');
    }

}
