<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
USE Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Mail\LaraEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Tractor;
use App\Models\user;
use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\Search as Search;
use App\Models\User as Userss;
use Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Models\sms;
use App\Models\Crop;
use App\Models\Subscription;
use App\Models\Subscription\Coupon;
use DateTime;
use App\Models\Subscription\Subscribed_boost;

# DIBYENDU CHANGE
use App\Models\Crops\CropsBanner;
use App\Models\Crops\Crops;
use App\Models\Crops\CropsSMS;

class CropController extends Controller
{
    // Get crops category
    public function getCropsCategory(Request $request){
       $data = [];
       $user_id = auth()->user()->id;
       $userData = Crop::getUserCount($user_id);
       if($userData ==0){
            return response([
                    'response' => false,
                    'data' => 'Unauthorized Access',
                    'message' => 'Failed'
                ], 404);
       }
        $rules = [
            'crops_category_id' => 'required',
        ];
        $data = array();  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'response'=> false, 
                'error_message' => $validator->errors()->first(),
            ], 422);
        } else {
           // $data = Crop::getAllCropsCategory($request->crops_category_id);

            $crops_category_data = DB::table('crops_category')
                 ->select('id','category_id','crops_cat_name','logo','ln_bn','ln_hn','status','created_at', 'updated_at')
                ->where('category_id','=', $request->crops_category_id)
                ->where('status','=', '1')
                ->get();

            foreach($crops_category_data as $category_name){
                $cropsDataCount  =  DB::table('cropsView')->where('crops_category_id',$category_name->id)->whereIn('status',[1,4])->count();
                $id               = $category_name->id;
                $category_id      = $category_name->category_id;
                $crops_cat_name   = $category_name->crops_cat_name;
                $logo             = $category_name->logo;
                $ln_bn            = $category_name->ln_bn;
                $ln_hn            = $category_name->ln_hn;
                $status           = $category_name->status;
                $item_count       = $cropsDataCount;
                $created_at       = $category_name->created_at;
                $updated_at       = $category_name->updated_at;

                $data[]  = ['id'=>$id,'category_id'=>$category_id , 'crops_cat_name' => $crops_cat_name ,'logo' => $logo, 'ln_bn' => $ln_bn, 'ln_hn' => $ln_hn, 'status' => $status, 'item_count' => $item_count, 'created_at' => $created_at, 'updated_at' => $updated_at];  
            }

            if($data){
                return response([
                    'response' => true,
                    'data' => $data,
                    'message' => 'Success'
                ], 200);
            } else {
                return response([
                    'response' => false,
                    'data' => 'Data not found!',
                    'message' => 'Failed'
                ], 404);
            }
        }
    }

    // Get crops sub category
    public function getCropsSubCategory(Request $request){
        $rules = [
            'category_id' => 'required',
            'crops_category_id' => 'required',
        ];
        $data = array();  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'response'=> false, 
                'error_message' => $validator->errors()->first(),
            ], 422);
        } else {
            $data = Crop::getAllCropsSubCategory($request->category_id, $request->crops_category_id);
            if($data){
                return response([
                    'response' => true,
                    'data' => $data,
                    'message' => 'Success'
                ], 200);
            } else {
                return response([
                    'response' => false,
                    'data' => 'Data not found!',
                    'message' => 'Failed'
                ], 404);
            }
            
        }
    }
    // Get crops boosts [Basic, Intermediate, Premium]
     public function getCropPackages (Request $request) {
        $user_id = auth()->user()->id;
        $data = [];

        $basic_plane_image        = 'https://krishivikas.com/storage/banner_ads/Bronze_plan_banner.jpg';
        $intermediate_plane_image = 'https://krishivikas.com/storage/banner_ads/Silver_plan_banner.jpg';
        $premium_plane_image      = 'https://krishivikas.com/storage/banner_ads/Golden_plan_banner.jpg';
        
       // $get = DB::table('subscription_boosts')->where(['status'=>1])->get();
        $data = array();  
        $get = Crop::getAllCropBoosts();
        foreach ($get as $val) {
           
            $data['id'] = $val->id;
            $data['name'] = $val->name;
            $data['days'] = $val->days;
            $data['price'] = $val->price;
            $data['plane_image'] = $val->plane_image;
            $data['number_of_crops'] = $val->number_of_crops;
            $data['features']['website'] = $val->website;
            $data['features']['mobile'] = $val->mobile;
            $data['features']['category'] = $val->category;
            $data['features']['category_view_all'] = $val->category_view_all;
            $data['features']['notification'] = $val->notification;
           // $data['features']['crop_boost'] = $val->crop_boost;
           // $data['features']['crop_boosts'] = $val->number_crop_boost;
          //  $data['features']['crop_banner'] = $val->crop_banner;
           // $data['features']['crop_banners'] = $val->number_crop_banner;
           // $data['features']['gst_as_applicable'] = $val->gst_as_applicable;
            $data['features']['no_of_boosts'] = $val->number_crop_boost;
            $data['features']['no_of_banners'] = $val->number_crop_banner;
            $data['features']['verification_tag'] = env('IMAGE_PATH_CROPS').$val->verification_tag;
            $data['status'] = $val->status;
            $data['created_at'] = $val->created_at;
            $data['updated_at'] = $val->updated_at;
            $new[] = $data;
        }

        $output['response']=true;
        $output['message']='List Of Boost Plans';
        $output['data'] = $new;
        $output['status_code'] = 200;
        $output['error'] = '';
        return $output;
    }
   /* public function getCropBoosts(Request $request){
        $data = array();  
        $data = Crop::getAllCropBoosts();
        if($data){
            return response([
                    'response' => true,
                    'data' => $data,
                    'message' => 'Success'
                ], 200);
        } else {
            return response([
                    'response' => false,
                    'data' => 'Data not found!',
                    'message' => 'Failed'
                ], 404);
        }
    }*/
    // Insert crops data
    public function postCrops(Request $request){
        $user_id = auth()->user()->id;
        $rules = [
            'crops_subscribed_id' => 'required|integer',
            'category_id' => 'required|integer',
            'type' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'crops_category_id' => 'required|integer',
            //'image1' => 'required',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'district_id' => 'required|integer',
            'city_id' => 'required|integer',
            'zipcode' => 'required|digits:6'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'response'=> false, 
                'error_message' => $validator->errors()->first(),
            ], 422);
        }
        $imageNameOne ="";
        $imageNameTwo ="";
        $imageNameThree ="";
        if ($request->hasFile('image1')) {
            if ($request->file('image1')) {
                $imageNameOne = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image1')->getClientOriginalName();
                $request->file('image1')->storeAs('public/crops', $imageNameOne);
            }
            if ($request->file('image2')) {
                $imageNameTwo = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image2')->getClientOriginalName();
                $request->file('image2')->storeAs('public/crops', $imageNameTwo);
            }
            if ($request->file('image3')) {
                $imageNameThree = date('Y-m-d-H-i-s').rand(1000,9999).$request->file('image3')->getClientOriginalName();
                $request->file('image3')->storeAs('public/crops', $imageNameThree);
            }
        } 
        /*else {
            return response([
                    'response' => false,
                    'data' => 'Please upload at least one picture',
                    'message' => 'No file uploaded!'
                ]);
        }*/

        $tillDate = $request->valid_till;
        $date1 =  Carbon::now();
        $start_date = date("Y-m-d H:i:s", strtotime($date1));

        $futureDate = $date1->addDays($tillDate);
        $date2      = $futureDate->format('Y-m-d H:i:s');
        $validDate   = date("Y-m-d H:i:s", strtotime($date2));

        $latlong = DB::table('user')->where('id', $user_id)->first();
        $userLatlong = $latlong->lat.','.$latlong->long;



        $data = array(
            'crops_subscribed_id' => $request->crops_subscribed_id,
            'category_id' => $request->category_id,
            'user_id' => $user_id,
            'type'=> $request->type,
            'title' => $request->title,
            'price' => $request->price,
            'quantity'=> $request->quantity,
            'expiry_date'=> $request->expiry_date,
            'valid_till'=> $validDate,
            'crops_category_id' => $request->crops_category_id,
            'image1' => $imageNameOne,
            'image2' => $imageNameTwo,
            'image3' => $imageNameThree,
            'is_negotiable'=> $request->is_negotiable,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'district_id' => $request->district_id,
            'city_id' => $request->city_id,
            'pincode' => $request->zipcode,
            'latlong' => $userLatlong,
            'description' =>$request->description,
            'created_at'=>date('Y-m-d H:i:s')                      
        );

      //  dd($data);

        $dataInsert = Crop::saveCrops($data);
        
        if($dataInsert){
             $userData = Crop::getUserdata($user_id);
             CropsSMS::pending_crops($user_id);
            // CropsSMS::add_crops($user_id);
             return response([
                    'response' => true,
                    'data' => 'Data Added Successfully',
                    'message' => 'Success'
                ]);
        } else {
             return response([
                    'response' => false,
                    'data' => 'Sorry! some problem is there. Please try again',
                    'message' => 'Failed'
                ]);
        }
    }

    // Update crops data
    public function updateCrops(Request $request){

        $user_id = auth()->user()->id;
        if (!empty($request->crops_id)) {
            $crops_id = $request->crops_id;
            $corps_boosts_count = DB::table('crops_boosts')->where('crop_id',$crops_id)->where('status',1)->count();
            if($corps_boosts_count == 0){
                
           
            //dd($corps_boosts_count);
                $crops_count = Crop::where('id', $crops_id)->where('user_id', $user_id)->whereIn('status',[0,1,2])->count();
                //dd($crops_count);
    
                if ($crops_count > 0) {
    
                    $crop_details = Crop::where('id', $crops_id)->first();
                   // dd($crop_details);
    
                    $category_id = $request->category_id?$request->category_id:$crop_details->category_id;
                    $title = $request->title?$request->title:$crop_details->title;
                    $price = $request->price?$request->price:$crop_details->price;
                    $crops_category_id = $request->crops_category_id?$request->crops_category_id:$crop_details->crops_category_id;
                    $country_id = $request->country_id?$request->country_id:$crop_details->country_id;
                    $state_id = $request->state_id?$request->state_id:$crop_details->state_id;
                    $district_id = $request->district_id?$request->district_id:$crop_details->district_id;
                    $city_id = $request->city_id?$request->city_id:$crop_details->city_id;
                    $zipcode = $request->zipcode?$request->zipcode:$crop_details->pincode;
                    $description = $request->description?$request->description:$crop_details->description;
                    $type = $request->type?$request->type:$crop_details->type;
                    $quantity = $request->quantity?$request->quantity:$crop_details->quantity;
                    //dd($request->is_negotiable);
       
                    //$is_negotiable = $request->is_negotiable?$request->is_negotiable:$crop_details->is_negotiable;
                    $is_negotiable = $request->is_negotiable;
                   // dd($is_negotiable);
                    $expiry_date = $request->expiry_date?$request->expiry_date:$crop_details->expiry_date;
                    $crops_subscribed_id = $request->crops_subscribed_id?$request->crops_subscribed_id:$crop_details->crops_subscribed_id;
    
                    $image1 = $request->image1 ? $request->image1:$crop_details->image1;
                    $image2 = $request->image2 ? $request->image2:$crop_details->image2;
                    $image3 = $request->image3 ? $request->image3:$crop_details->image3;
    
    
                    $crops_image1 = asset('storage/crops' . $crop_details->image1);
                    if (!empty($request->image1)) {
                        Storage::delete($crops_image1);
    
                        $image1 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image1')->getClientOriginalName();
                        $ext = $request->file('image1')->getClientOriginalExtension();
                        $request->file('image1')->storeAs('public/crops', $image1);
                    } else {
                        $image1 = $image1;
                    }
    
                    $crops_image2 = asset('storage/crops' . $crop_details->image2);
                    if (!empty($request->image2)) {
                        Storage::delete($crops_image2);
    
                        $image2 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image2')->getClientOriginalName();
                        $ext = $request->file('image2')->getClientOriginalExtension();
                        $request->file('image2')->storeAs('public/crops', $image2);
                    } else {
                        $image2 = $image2;
                    }
    
                    $crops_image3 = asset('storage/crops' . $crop_details->image3);
                    if (!empty($request->image3)) {
                        Storage::delete($crops_image3);
    
                        $image3 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image3')->getClientOriginalName();
                        $ext = $request->file('image3')->getClientOriginalExtension();
                        $request->file('image3')->storeAs('public/crops', $image3);
                    } else {
                        $image3 = $image3;
                    }
    
                    $tillDate = $request->valid_till?$request->valid_till:$crop_details->valid_till;
                    $date1 =  Carbon::now();
                    $start_date = date("Y-m-d H:i:s", strtotime($date1));
    
                    $futureDate = $date1->addDays($tillDate);
                    $date2      = $futureDate->format('Y-m-d H:i:s');
                    $validDate   = date("Y-m-d H:i:s", strtotime($date2));
    
                    $latlong = DB::table('user')->where('id', $user_id)->first();
                    $userLatlong = $latlong->lat.','.$latlong->long;
    
    
                    $data = array(
                        'crops_subscribed_id' => $crops_subscribed_id,
                        'category_id' => $category_id,
                        'user_id' => $user_id,
                        'type'=> $type,
                        'title' => $title,
                        'price' => $price,
                        'quantity'=> $quantity,
                        'expiry_date'=> $expiry_date,
                        'valid_till'=> $validDate,
                        'crops_category_id' => $crops_category_id,
                        'image1' => $image1,
                        'image2' => $image2,
                        'image3' => $image3,
                        'is_negotiable'=> $is_negotiable,
                        'country_id' => $country_id,
                        'state_id' => $state_id,
                        'district_id' => $district_id,
                        'city_id' => $city_id,
                        'pincode' => $zipcode,
                        'latlong' => $userLatlong,
                        'description' =>$description,
                        'status' => 0,
                        'created_at'=>date('Y-m-d H:i:s')                      
                    );
                   // dd($data);
                    
                       $cropsData = DB::table('crops')
                       ->where('id',$crops_id)
                       ->update($data);
                 
                        $output['response'] = true;
                        $output['message']  = 'Your crops update successfully';
                        $output['data']     = $cropsData;
                        $output['error']    = "";
                    
                } else {
                    $output['response'] = false;
                    $output['message']  = 'No data available';
                    $output['data']     = [];
                    $output['error']    = "";
                }
            } else {
                $output['response'] = false;
                $output['message']  = 'Boosted product can not edited';
                $output['data']     = [];
                $output['error']    = "";
            }
        }else{
            $output['response'] = false;
            $output['message']  = 'please select crops id';
            $output['data']     = [];
            $output['error']    = "";

        }
        return $output;
    }
    // Get subscription data
    public function getSubscription(Request $request){
        $rules = [
            'subscription_id' => 'required',
        ];
        $data = array();  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'response'=> false, 
                'error_message' => $validator->errors()->first(),
            ], 422);
        } else {
            $data = Crop::getSubscription($request->subscription_id);
            if($data){
                return response([
                    'response' => true,
                    'data' => $data,
                    'message' => 'Success'
                ], 200);
            } else {
                return response([
                    'response' => false,
                    'data' => 'Data not found!',
                    'message' => 'Failed'
                ], 404);
            }
            
        }
    }

    // Crops subscription payment
    public function cropSubscriptionPayment(Request $request){
        $user_id = auth()->user()->id;
        $output = [];
        $rules = [
            'subscription_id' => 'required',
            'category_id' => 'required',
            'crops_category_id' => 'required',
            'purchase_amount' => 'required',
            'order_id' => 'required',
            'transaction_id' => 'required',
        ];
        $data = array();  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'response'=> false, 
                'error_message' => $validator->errors()->first(),
            ], 422);
        } else {
           // $data = Crop::getSubscription($request->subscription_id);
            /////////////////////////////////////////////////////////////

        $output = [];
        $subscription_id = $request->subscription_id;
        $user_id = $user_id;
        $category_id = $request->category_id;
        $crops_category_id = $request->crops_category_id;
        $coupon_id                = $request->coupon_id;
        $coupon_code              = $request->coupon_code;
        $purchase_amount          = $request->purchase_amount;
        $order_id                 = $request->order_id;
        $transaction_id           = $request->transaction_id;

        $subs_count = DB::table('crops_subscribeds')->where('user_id', $user_id)->where('subscription_feature_id', $request->subscription_id)->count();
        $days =0;
      //  if ($subs_count == 0) {
                $subscriptionsCount = Crop::getSubscription($subscription_id)->count();
               
                if ($subscriptionsCount > 0) {
                    $subscriptionsData = Crop::getSubscription($subscription_id)->first();
                    $id              = $subscriptionsData->id;
                    $subscription_id = $subscriptionsData->crops_subscription_id;
                    $name            = $subscriptionsData->name;
                    $days            = $subscriptionsData->days;
                    $price           = $subscriptionsData->price;
                }

                $currentDate =  Carbon::now();
                $start_date = date("Y-m-d H:i:s", strtotime($currentDate));
                
                if ($days == '30') {
                    $futureDate = $currentDate->addDays(30);
                    $startDate      = $futureDate->format('Y-m-d H:i:s');
                    $endDate   = date("Y-m-d H:i:s", strtotime($startDate));
                } 
               

                $financialYear = Crop::getFinancialYear($start_date, "y"); 
                $getId = 0;
                $getId = DB::select("SELECT 
            LPAD(
                MAX(
                    CAST(
                        SUBSTRING(invoice_no, LENGTH('AECPL/') + 1) AS UNSIGNED
                    )
                ),
                LENGTH(MAX(CAST(SUBSTRING(invoice_no, LENGTH('AECPL/') + 1) AS UNSIGNED))), '0'
            ) AS max_invoice_number
                FROM (
                    SELECT invoice_no FROM subscribed_boosts
                    UNION ALL
                    SELECT invoice_no FROM subscribeds
                    UNION ALL
                    SELECT invoice_no FROM crops_subscribeds
                ) AS combined_tables");

                $invoiceId = $getId[0]->max_invoice_number + 1; #new id for Invoice

                $package_price = $request->package_price;
               

                $data = [
                    'subscription_id' => $subscription_id,
                    'subscription_feature_id' => $subscription_id,
                    'user_id' => $user_id,
                    'category_id' => $category_id,
                    'crops_category_id' => $crops_category_id,
                    'price' => $price,
                    'start_date' => $start_date,
                    'end_date' => $endDate,
                    'coupon_code_id' => $coupon_id,
                    'coupon_code' => $coupon_code,
                    'purchased_price' => $purchase_amount,
                    'order_id' => $order_id,
                    'transaction_id' => $transaction_id,
                    'gst' => $request->gst,
                    'sgst' => $request->sgst,
                    'cgst' => $request->cgst,
                    'igst' => $request->igst,
                    'invoice_no' => "AECPL/" . str_pad($invoiceId, 5, "0", STR_PAD_LEFT) . "/" . $financialYear,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                //dd($data);
                $cropSubscribedId = Crop::saveCropSubscriptionPayment($data);
                if($cropSubscribedId){
                    $crops_verification_tag   = DB::table('crop_subscription_features')->where('crops_subscription_id',$subscription_id)
                    ->value('verification_tag');
                    $dataVerifyTag = [
                        'subscription_id' => $subscription_id,
                        'user_id' => $user_id,
                        'crops_verify_tag' => $crops_verification_tag,
                        'status' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    DB::table('user_crops_verify_tag')->insert($dataVerifyTag);
                }
                //$cropSubscribedId = 32;
                if ($coupon_id != '') {
                    $coupon_used_increment  = Coupon::where('id', $coupon_id)->where('status', 1)->first();
                    if (!empty($coupon_used_increment)) {
                        $usability = $coupon_used_increment->usability;
                        $used      = $coupon_used_increment->used;

                        if ($usability > $used) {
                            $used_increment = $used + 1;
                            $coupon_details_in = Coupon::where('id', $coupon_id)->where('status', 1)->first();
                            $coupon_details_in->used = $used_increment;
                            $coupon_details_in->update();
                        }
                    }
                }

            $subscribedData= Crop::getSubscribedData($cropSubscribedId);
            $sms = sms::subscriptionPaymentForCrops($subscribedData->mobile, $subscribedData->name, $subscribedData->subscribtion_name, $subscribedData->transaction_id, $subscribedData->invoice_no, $subscribedData->purchased_price, $subscribedData->end_date);
            CropsSMS::add_subscription($user_id, $subscription_id);

            /////////////////////////////////////////////////////////
            if($subscribedData){
                return response([
                    'response' => true,
                    'data' => $subscribedData,
                    'message' => 'Success'
                ], 200);
            } else {
                return response([
                    'response' => false,
                    'data' => 'Data not found!',
                    'message' => 'Failed'
                ], 404);
            }
        } 
      /*  else {
            return response([
                    'response' => false,
                    'data' => 'This User Already Have Same Subscription',
                    'message' => 'Failed'
                ], 404);
        }
    }*/
    }
    // Crops invoice details
    public function getCropInvoiceDetails(Request $request){
        $rules = [
            'subscribed_id' => 'required',
        ];
        $data = array();  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'response'=> false, 
                'error_message' => $validator->errors()->first(),
            ], 422);
        } else {
            $data = Crop::getInvoiceDetails($request->subscribed_id);
            if($data){
                return response([
                    'response' => true,
                    'data' => $data,
                    'message' => 'Success'
                ], 200);
            } else {
                return response([
                    'response' => false,
                    'data' => 'Data not found!',
                    'message' => 'Failed'
                ], 404);
            }
            
        }
    }

    // My crops list page
    public function getMyCrops(Request $request){

        $output = [];
        $data   = [];
        $new    = [];

        $user_id     = auth()->user()->id;
      //  dd($user_id);
        $type        = $request->type;

        $Autn = DB::table('user')->where('id',$user_id)->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }

        $sql = DB::table('cropsView')
                ->orderBy('id', 'DESC')
                 ->whereIn('status',[0,1,4,2,5,3])
                ->where('user_id', $user_id)
                ->get();
                
      //  dd($sql);

        foreach($sql as $val){
            $data['id']          = $val->id;
            $data['category_id'] = $val->category_id;
            $data['user_id']     = $val->user_id;
          
            $user_count = DB::table('user')->where('id',$val->user_id)->count();

            if($user_count > 0){
                $user_details = DB::table('user')->where('id',$val->user_id)->first();
                $data['user_type_id']      = $user_details->user_type_id;
                $data['role_id']           = $user_details->role_id;
                $data['name']              = $user_details->name;
                $data['company_name']      = $user_details->company_name;
                $data['mobile']            = $user_details->mobile;
                $data['email']             = $user_details->email;
                $data['gender']            = $user_details->gender;
                $data['address']           = $user_details->address;
                $data['zipcode']           = $user_details->zipcode;
                $data['verify_tag']        = $user_details->verify_tag;
                $data['device_id']         = $user_details->device_id;
                $data['firebase_token']    = $user_details->firebase_token;
                $data['created_at_user']   = date("d-m-Y", strtotime($user_details->created_at));
    
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/".$user_details->photo);
                }
            }

            $data['title']       = $val->title;
            $data['price']       = $val->price;
            $data['description'] = $val->description;
            $data['crops_category_id'] = $val->crops_category_id;
            if(!empty($val->crops_category_id)  && $val->crops_category_id != 13){
                $crop_category_name = DB::table('crops_category')->where('id',$val->crops_category_id)->value('crops_cat_name');
                //dd($crop_category_name);
                $data['crop_category_name'] = $crop_category_name;
            }else{
                $data['crop_category_name'] = "";
            }
            
            if ($val->image1=='' || $val->image1=='NULL') { 
                $data['image1'] = '';
            } else {
                $data['image1'] = asset("storage/crops/".$val->image1); 
            }
            if ($val->image2=='' || $val->image2=='NULL') { 
                $data['image2'] = '';
            } else {
                $data['image2'] = asset("storage/crops/".$val->image2); 
            }
            if ($val->image3=='' || $val->image3=='NULL') { 
                $data['image3'] = '';
            } else {
                $data['image3'] = asset("storage/crops/".$val->image3); 
            }
            
            $data['is_negotiable'] = $val->is_negotiable;
            $data['country_id']    = $val->country_id;
            $data['state_id']      = $val->state_id;
            $data['district_id']   = $val->district_id;
            $data['city_id']       = $val->city_id;

            $data['state_name']    = $val->state_name;
            $data['district_name'] = $val->district_name;
            $data['city_name']     = $val->city_name;

            $wishlist_status = DB::select("SELECT COUNT(*) as count FROM wishlist
                            WHERE user_id = :user_id
                            AND category_id = 12
                            AND item_id = :item_id", ['user_id' => $user_id, 'item_id' => $val->id]);

            $data['wishlist_status'] = $wishlist_status[0]->count;
            $data['pincode']         = $val->pincode;
            $data['latlong']         = $val->latlong;
            $data['is_featured']     = $val->is_featured;
            $data['valid_till']      = $val->valid_till;
            $data['ad_report']       = $val->ad_report;
            $data['status']          = $val->status;
            $data['created_at']      = $val->created_at;
            $data['updated_at']      = $val->updated_at;
            $data['type']            = $val->type;
            $data['quantity']        = $val->quantity;
            $data['expiry_date']     = $val->expiry_date;

            $boosted = Subscribed_boost::viewAllCropsProduct(12, $val->id);
            $data['is_boosted'] = (bool) $boosted;

            $product_id = $val->id;
            $category_id = 12;
            // $data['boosted'] = DB::table('crops_subscribeds')
            //     ->where(['category_id' => $category_id, 'crops_id' => $product_id])
            //     ->latest()
            //     ->first();
            $data['boosted'] = DB::table('crops_boosts')
                ->where(['category_id' => $category_id, 'crop_id' => $product_id])
                ->latest()
                ->first();

            $new[] = $data;
        }

       // Cache::put('crops_viewall-'.$type.'-'.$user_id, $new, 60*60*60*1);
            return [
                        'response' => true,
                        'message' => 'My Crops',
                        'data' => $new,
                        'data_on' => 'Database',
                        'status_code'=>200,
                        'error' => '',
                    ];
            
       // }


       //  $userId = auth()->user()->id;
       // // dd($userId);
       // // $data = Crop::getMyCropsAllData($userId);
       //  //$data = Crop::getMyCropsData($userId);
       //  if($data){
       //      return response([
       //          'response' => true,
       //          'data' => $data,
       //          'message' => 'Success'
       //      ], 200);
       //  } else {
       //      return response([
       //          'response' => false,
       //          'data' => 'Data not found!',
       //          'message' => 'Failed'
       //      ], 404);
       //  }
    }

    //Get crops details particular id
    public function getMyCropDetails(Request $request){
        $rules = [
            'crops_id' => 'required',
        ];
        $data = array();  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'response'=> false, 
                'error_message' => $validator->errors()->first(),
            ], 422);
        } else {
            $data = Crop::getCropsDetails($request->crops_id);
            if($data){
                return response([
                    'response' => true,
                    'data' => $data,
                    'message' => 'Success'
                ], 200);
            } else {
                return response([
                    'response' => false,
                    'data' => 'Data not found!',
                    'message' => 'Failed'
                ], 404);
            }
            
        }
    }

    // My crops list page
    public function getAllCrops(Request $request){
        $data = Crop::getCropsAllData();
        //dd($data);
        if($data){
            return response([
                'response' => true,
                'data' => $data,
                'message' => 'Success'
            ], 200);
        } else {
            return response([
                'response' => false,
                'data' => 'Data not found!',
                'message' => 'Failed'
            ], 404);
        }
    }

    // View all crops
    public function cropsDistance(Request $request){
        $output = [];
        $data   = [];
        $new    = [];

        $user_id = auth()->user()->id;
        $type        = $request->type; //new , used, rent
        $skip        = $request->skip;
        $take        = $request->take;
        $pincode     = $request->pincode;
        $app_section = $request->app_section;

        $pindata     = DB::table('city')->where(['pincode'=>$request->pincode])->first();
        $latitude    = $pindata->latitude;
        $longitude   = $pindata->longitude;

        $Autn = DB::table('user')->where('id',$user_id)->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }

        if (Cache::has('crops_viewall-'.$type.'-'.$user_id.'-'.$skip.'-'.$take)) {
            $new = Cache::get('crops_viewall-'.$type.'-'.$user_id.'-'.$skip.'-'.$take);
            return [
                'response' => true,
                'message' => 'Crops Data',
                'data' => $new,
                'data_on' => 'Cache',
                'status_code'=>200,
                'error' => '',
            ];

        } else {

        $sql = DB::table('cropsView')
                ->select('*'
                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                * cos(radians(cropsView.latitude))
                * cos(radians(cropsView.longitude) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. "))
                * sin(radians(cropsView.latitude))) AS distance"))
                ->orderBy('distance', 'ASC')
                ->whereIn('status',[1,4])
                ->limit($take)
               ->offset($skip)
                ->get();
        //dd($sql);

        foreach($sql as $val){

            if($val->distance == null){
                $data['distance'] = 0;
            }else{
                $data['distance']    = round($val->distance);
            }

            $boosted = Subscribed_boost::viewAllCropsProduct(12,$val->id);
            if($boosted == 0){
                $data['is_boosted']  = false;
            }else if($boosted == 1){
                $data['is_boosted']  = true;
            }
           
            $data['id']          = $val->id;
            $data['category_id'] = $val->category_id;
            $data['user_id']     = $val->user_id;
          
            $user_count = DB::table('user')->where('id',$val->user_id)->count();
            if($user_count > 0){
                $user_details = DB::table('user')->where('id',$val->user_id)->first();
                $data['user_type_id']      = $user_details->user_type_id;
                $data['role_id']           = $user_details->role_id;
                $data['name']              = $user_details->name;
                $data['company_name']      = $user_details->company_name;
                $data['mobile']            = $user_details->mobile;
                $data['email']             = $user_details->email;
                $data['gender']            = $user_details->gender;
                $data['address']           = $user_details->address;
                $data['zipcode']           = $user_details->zipcode;
                $data['verify_tag']        = $user_details->verify_tag;
                $data['device_id']         = $user_details->device_id;
                $data['firebase_token']    = $user_details->firebase_token;
                $data['created_at_user']   = date("d-m-Y", strtotime($user_details->created_at));
    
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/".$user_details->photo);
                }

            }
           

            $data['title']       = $val->title;
            $data['price']       = $val->price;
            $data['description'] = $val->description;
            if ($val->image1=='' || $val->image1=='NULL') { 
                $data['image1'] = '';
            } else {
                $data['image1'] = asset("storage/crops/".$val->image1); 
            }
            if ($val->image2=='' || $val->image2=='NULL') { 
                $data['image2'] = '';
            } else {
                $data['image2'] = asset("storage/crops/".$val->image2); 
            }
            if ($val->image3=='' || $val->image3=='NULL') { 
                $data['image3'] = '';
            } else {
                $data['image3'] = asset("storage/crops/".$val->image3); 
            }
            
            $data['is_negotiable'] = $val->is_negotiable;
            $data['country_id']    = $val->country_id;
            $data['state_id']      = $val->state_id;
            $data['district_id']   = $val->district_id;
            $data['city_id']       = $val->city_id;

            $data['state_name']    = $val->state_name;
            $data['district_name'] = $val->district_name;
            $data['city_name']     = $val->city_name;

            $wishlist_status = DB::select("SELECT COUNT(*) as count FROM wishlist
                            WHERE user_id = :user_id
                            AND category_id = 12
                            AND item_id = :item_id", ['user_id' => $user_id, 'item_id' => $val->id]);

            $data['wishlist_status'] = $wishlist_status[0]->count;
            $data['pincode']         = $val->pincode;
            $data['latlong']         = $val->latlong;
            $data['is_featured']     = $val->is_featured;
            $data['valid_till']      = $val->valid_till;
            $data['ad_report']       = $val->ad_report;
            $data['status']          = $val->status;
            $data['created_at']      = $val->created_at;
            $data['updated_at']      = $val->updated_at;
            $data['type']            = $val->type;
            $data['quantity']        = $val->quantity;
            $data['expiry_date']     = $val->expiry_date;
            $data['crop_category_id']     = $val->crops_category_id;
            $crops_category_name = DB::table('crops_category')->where('id',$val->crops_category_id)->first();

          //  dd($crops_category_name);
            $data['crop_category_name']     = $crops_category_name->crops_cat_name;
            

            $view_lead               = DB::select("SELECT COUNT(*) as count FROM leads_views WHERE category_id = 12 AND post_id = :post_id", ['post_id' => $val->id]);
            $data['view_lead']       = $view_lead[0]->count;

            $call_lead               = DB::select("SELECT COUNT(*) as count FROM seller_leads WHERE category_id = 12 AND post_id = :post_id AND calls_status = 1 ", ['post_id' => $val->id]);
            $data['call_lead']       = $call_lead[0]->count;

            $msg_lead                = DB::select("SELECT COUNT(*) as count FROM seller_leads WHERE category_id = 12 AND post_id = :post_id AND messages_status = 1 ",  ['post_id' => $val->id]);
            $data['msg_lead']        = $msg_lead[0]->count;

            $new[] = $data;
        
        }

        Cache::put('crops_viewall-'.$type.'-'.$user_id.'-'.$skip.'-'.$take, $new, 86400);
            return [
                        'response' => true,
                        'message' => 'Crops Data',
                        'data' => $new,
                        'data_on' => 'Database',
                        'status_code'=>200,
                        'error' => '',
                    ];
            
        }
    }

    // view crops by id
    public function cropsById (Request $request) {
        $output=[];
        $data=[];
        $new=[];
        $user_id = auth()->user()->id;
       // dd($user_id);
        $id = $request->last_id;
        
        $Autn = DB::table('user')->where('id',$user_id)->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            'last_id' => 'required',
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            $count = DB::table('crops')->where(['id'=>$id])->count();
            if ($count>0) {
            
            $val = DB::table('crops')->where(['id'=>$id])->first();
           
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
                $data['created_at_user'] = $user_details->created_at;
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/".$user_details->photo);
                }
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/crops/".$val->image1); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/crops/".$val->image2); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/crops/".$val->image3); 
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
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>12,'item_id'=>$val->id])->count();
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = $val->created_at;
                $data['updated_at'] = $val->updated_at;
                
                $new[] = $data;
                
                
            $output['response']=true;
            $output['message']='Data Get';
            $output['data'] = $new;
            $output['error'] = "";
            
            } else {
                $output['response']=false;
                $output['message']='No Crops Found';
                $output['data'] = '';
                $output['error'] = ""; 
            }
            
        }
        return $output;
    }

    # My Crops Subscriptions
    public function myCropsSubscription(Request $request)
    {
        $user_id = auth()->user()->id;
       // dd($user_id);
        $data = [];
        $coupon = [];
        $subscriped = [];
        $promotionData = [];

        $subscribedId = DB::table('crops_subscribeds')->where('user_id',$user_id)->where('status',1)->value('id');


       // dd($subscribedId);
        if($subscribedId == null){
            $subscribedId =0;
        }

       //dd($subscribedId);
   
        $subscriped = DB::table('crops_subscribeds as cs')
            ->select(
                'cs.*',
                'csf.crops_subscription_id',
                'csf.name',
                'csf.days',
                'csf.price',
                'csf.number_of_crops',
                'csf.website',
                'csf.mobile',
                'csf.category',
                'csf.category_view_all',
                'csf.notification',
                'csf.crop_boost',
                'csf.number_crop_boost',
                'csf.crop_banner',
                'csf.number_crop_banner',
                'csf.gst_as_applicable',
                'csf.verification_tag',
                DB::raw('CONCAT("'.url('/').'/invoice/subscription_boots/'.$subscribedId.'") as invoice_id'))
            
            ->leftJoin('crop_subscription_features as csf', 'csf.id', '=', 'cs.subscription_feature_id')
            ->leftJoin('crop_subscriptions as css', 'css.id', '=', 'csf.crops_subscription_id')
            ->where(['cs.user_id' => $user_id])
            ->where('cs.status',1)
            ->get();

        //dd($subscriped);
            

            $boostsCount =  DB::table('crops_boosts')
                            ->where('user_id',$user_id)
                            ->where('status',1)
                            ->count();
                            
            $userPostCount =  DB::table('user')
                            ->select('limit_count','user_post_count')
                            ->where('id',$user_id)
                            ->where('status',1)
                            ->first();

        if(count($subscriped)>0){
            foreach ($subscriped as $key => $val) {

                $subscriped_data['id'] = $val->id;
                $subscriped_data['crops_subscription_id'] = $val->crops_subscription_id;
                // $subscriped_data['subscription_feature_id'] = $val->subscription_feature_id;
                $subscriped_data['user_id'] = $val->user_id;
                $subscriped_data['price'] = $val->price;
                $subscriped_data['start_date'] = $val->start_date;
                $subscriped_data['end_date'] = $val->end_date;
                $subscriped_data['coupon_code_id'] = $val->coupon_code_id;
                $subscriped_data['coupon_code'] = $val->coupon_code;
                $subscriped_data['purchased_price'] = $val->purchased_price;
                $subscriped_data['status'] = $val->status;
                $subscriped_data['created_at'] = $val->created_at;
                $subscriped_data['updated_at'] = $val->updated_at;
                $subscriped_data['name'] = $val->name;
                $subscriped_data['days'] = $val->days;
                $subscriped_data['verification_tag'] = $val->verification_tag;
                $subscriped_data['invoice_id'] = $val->invoice_id;

                $features['number_of_crops']          = $val->number_of_crops;
                $features['website']                  = $val->website;
                $features['mobile']                   = $val->mobile;
                $features['category']                 = $val->category;
                $features['category']                 = $val->category;
                $features['category_view_all']        = $val->category_view_all;
                $features['notification']             = $val->notification;
                $features['crop_boost']               = $val->crop_boost;
                $features['number_crop_boost']        = $val->number_crop_boost;
                $features['crop_banner']              = $val->crop_banner;
                $features['creatives']                = $val->number_crop_banner;

                $ads_data = DB::table('crops_banners as cb')
                    ->select('cb.*')
                    ->where(['crop_subscribed_id' => $val->id])->get();

              //  dd($ads_data);
                    
                $ads_data_count = DB::table('crops_banners as cb')->where(['crop_subscribed_id' => $val->id])->count();
              //dd($ads_data_count);

                if($ads_data_count > 0){
                    foreach($ads_data as $key=> $banner){
                        $banner_img = asset('storage/crops/banner/'.$banner->image);
    
                        $b_data[] = ['id'=>$banner->id ,'crops_subscription_id'=>$banner->crop_subscriptions_id,'subscribed_id'=>$banner->crop_subscribed_id,
                        'user_id'=>$banner->user_id,'campaign_name'=>$banner->title,'campaign_banner'=>$banner_img,'campaign_state'=>$banner->state_id,
                        'campaign_category'=>12,'status'=>$banner->status,'created_at'=>$banner->created_at,'updated_at'=>$banner->updated_at];
                }
                    $creative_count = DB::table('crops_banners')->where(['crop_subscribed_id' => $val->id])->count();
                }else{
                     //dd("empty");
                   $b_data = [];
                   $creative_count = 0;
                }
                
                //dd($b_data);
                // $creative_count = DB::table('crops_banners')->where(['crop_subscribed_id' => $val->id])->count();
                $boost_count = DB::table('crops_boosts')->where(['crop_subscribed_id'=>$val->id,'user_id'=>$user_id])->count();
                $crop_count  = DB::table('crops')->where(['crops_subscribed_id'=>$val->id,'user_id'=>$user_id])->count();
                
                $data[] = ['s_data' => $subscriped_data, 'creative_count' => $creative_count,'boost_count'=>$boost_count,'crop_count'=>$crop_count, 
                'features' => $features, 'ads_id' => $b_data];
            }


            $output['response'] = true;
            $output['message'] = 'My Subscription List';
            $output['data'] = $data;
            $output['coupon'] = [];
            $output['status_code'] = 200;
            $output['error'] = '';
        } else {
            $output['response'] = true;
            $output['message'] = 'Failed';
            $output['data'] = [];
            $output['coupon'] = [];
            $output['status_code'] = 200;
            $output['error'] = 'No subscription available';
        }

        return $output;
    }

    ##Crops boosts
    public function cropsBoosts(Request $request)
    {
        $crop_subscribed_id       = $request->crop_subscribed_id;
        $category_id              = $request->category_id;
        $crop_id                  = $request->crop_id;
        $crop_subscriptions_id    = $request->crop_subscriptions_id;
        $crop_category_id         = $request->crop_category_id;
        $user_id                  = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'crop_subscribed_id' => 'required|integer',
            'category_id'=> 'required|integer',
            'crop_id'=>'required|integer',
            'crop_subscriptions_id'=>'required|integer',
            'crop_category_id'=>'required|integer',
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = $validator->messages();
        } else {

            $crops_subscribed_details = DB::table('crops_subscribeds')->where('id', $crop_subscribed_id)->first();
            $data = [
                'crop_subscribed_id'     => $crop_subscribed_id,
                'category_id'            => $category_id,
                'crop_id'                => $crop_id,
                'crop_subscriptions_id'  => $crop_subscriptions_id,
                'crop_category_id'       => $crop_category_id,
                'user_id'                => $user_id,
                'start_date'             => $crops_subscribed_details->start_date,
                'end_date'               => $crops_subscribed_details->end_date,
                'status'                 => 1,
                'created_at'             => Carbon::now(),
                'updated_at'             => Carbon::now()
            ];

            $getSubscribedBoostId = DB::table('crops_boosts')->insertGetId($data);
            $subscribedBoostsData = DB::table('crops_boosts')->where('id',$getSubscribedBoostId)->where('status',1)->orderBy('id','DESC')->first();
            CropsSMS::add_boost($user_id);
          

            //dd($subscribedBoostsData);

            if ($subscribedBoostsData) {
                $output['response']=true;
                $output['message']='Your product boosts successfully';
                $output['data'] = $subscribedBoostsData;
                $output['error'] = "";
            } else {
                $output['response']=false;
                $output['message']='Something Went Wrong';
                $output['data'] = '';
                $output['error'] = "Database Error";
            }
        }
        return $output;
    }

    ## Crops boosts list
    public function cropsBoostsList(Request $request)
    {
        $output = [];
        $data   = [];
        $new    = [];

        $user_id                  = auth()->user()->id;

       $datas = DB::table('crops_boosts as cb')
                ->select('csv.*','cb.status', 'cb.crop_id')
                ->leftJoin('cropsSubscribedView as csv','csv.subscribed_id','=','cb.crop_subscribed_id')
                ->where(['csv.user_id' => $user_id])
                ->orderBy('cb.id','desc')
                ->where('cb.status',1)->get();


        foreach ($datas as $data) {
            $data->product = Subscribed_boost::getBoostedProduct($data->category_id, $data->crop_id, $user_id);
        }

        $output['response'] = true;
        $output['message'] = 'Crops boosts list';
        $output['data'] = $datas;
        $output['status_code'] = 200;
        $output['error'] = '';
        return $output;
    }

    ## Add crops banner
   /* public function addCropsBanner(Request $request)
    {
        $user_id = auth()->user()->id;
        $crop_subscribed_id       = $request->crop_subscribed_id;
        $category_id              = $request->category_id;
        $crop_id                  = $request->crop_id;
        $crop_subscriptions_id    = $request->crop_subscriptions_id;
        $title                    = $request->title;
        $description              = $request->description;
        $image                    = $request->image;
        $state_id                 = $request->state_id;

        $validator = Validator::make($request->all(), [
            'crop_subscribed_id' => 'required|integer',
            'category_id'=> 'required',
            //'crop_id'=>'required|integer',
            'crop_subscriptions_id'=>'required|integer',
            'title'=>'required',
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = $validator->messages();
        } else {
            if (!empty($request->banner_img)) {
                $banner_img = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('banner_img')->getClientOriginalName();
                $ext = $request->file('banner_img')->getClientOriginalExtension();
                $request->file('banner_img')->storeAs('public/crops/banner', $banner_img);
            } else {
                $banner_img = "";
            }

            $crops_subscribed_details = DB::table('crops_subscribeds')->where('id', $crop_subscribed_id)->first();


            $crop_data = [
                'crop_subscribed_id'    => $crop_subscribed_id,
                'category_id'           => $category_id,
                //'crop_id'               => $crop_id,
                'crop_subscriptions_id' => $crop_subscriptions_id,
                'user_id'               => $user_id,
                'start_date'            => $crops_subscribed_details->start_date,
                'end_date'              => $crops_subscribed_details->end_date,
                'title'                 => $title,
                //'description'           => $description,
                'image'                 => $banner_img,
                'state_id'              => $state_id,
                'status'                => 0,
                'created_at'             => Carbon::now(),
                'updated_at'             => Carbon::now()
            ];
           // dd($crop_data);

            $getId = DB::table('crops_banners')->insertGetId($crop_data);
            $cropsBannerData = DB::table('crops_banners')->where('id',$getId)->where('status',1)->orderBy('id','DESC')->first();
            //dd($subscribedBoostsData);
            CropsSMS::pending_banner($user_id);

            if ($cropsBannerData) {
                $output['response']=true;
                $output['message']='Your banner added successfully';
                $output['data'] = $cropsBannerData;
                $output['error'] = "";
            } else {
                $output['response']=false;
                $output['message']='Something Went Wrong';
                $output['data'] = '';
                $output['error'] = "Database Error";
            }
        }
        return $output;
    }*/
    
        public function addCropsBanner(Request $request)
    {
        $user_id = auth()->user()->id;
        $crop_subscribed_id       = $request->crop_subscribed_id;
        $category_id              = $request->category_id;
        $crop_id                  = $request->crop_id;
        $crop_subscriptions_id    = $request->crop_subscriptions_id;
        $title                    = $request->title;
        $description              = $request->description;
        $image                    = $request->image;
        $state_id                 = $request->state_id;

        $validator = Validator::make($request->all(), [
            'crop_subscribed_id' => 'required|integer',
            'category_id'=> 'required',
            //'crop_id'=>'required|integer',
            'crop_subscriptions_id'=>'required|integer',
            'title'=>'required',
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = $validator->messages();
        } else {


            // $countTotalPremiumBanner = DB::table('crops_subscribeds')
            //                 ->where('subscription_feature_id', 3)
            //                 ->where('category_id', 12)
            //                 ->where('user_id', $user_id)
            //                 ->where('status', 1)
            //                 ->count();

            // $countUploadedBanner = DB::table('crops_banners')
            //                 ->where('user_id', $user_id)
            //               // ->where('status', 1)
            //                 ->count();

        // echo  $countTotalPremiumBanner;
        // echo "<br />";    
        // echo  $countUploadedBanner;  
    

           // if($countTotalPremiumBanner>$countUploadedBanner){
           $countUploadedBanner = DB::table('crops_banners')
                            ->where('user_id', $user_id)
                            ->where('crop_subscribed_id', $request->crop_subscribed_id)
                            ->where('crop_subscriptions_id', 3)
                            ->count();
        if($countUploadedBanner ==0){
            if (!empty($request->banner_img)) {
                $banner_img = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('banner_img')->getClientOriginalName();
                $ext = $request->file('banner_img')->getClientOriginalExtension();
                $request->file('banner_img')->storeAs('public/crops/banner', $banner_img);
            } else {
                $banner_img = "";
            }

            $crops_subscribed_details = DB::table('crops_subscribeds')->where('id', $crop_subscribed_id)->first();


            $crop_data = [
                'crop_subscribed_id'    => $crop_subscribed_id,
                'category_id'           => $category_id,
                //'crop_id'               => $crop_id,
                'crop_subscriptions_id' => $crop_subscriptions_id,
                'user_id'               => $user_id,
                'start_date'            => $crops_subscribed_details->start_date,
                'end_date'              => $crops_subscribed_details->end_date,
                'title'                 => $title,
                //'description'           => $description,
                'image'                 => $banner_img,
                'state_id'              => $state_id,
                'status'                => 0,
                'created_at'             => Carbon::now(),
                'updated_at'             => Carbon::now()
            ];
           // dd($crop_data);

            $getId = DB::table('crops_banners')->insertGetId($crop_data);
           // dd($getId);
            $cropsBannerData = DB::table('crops_banners')->where('id',$getId)->where('status',0)->orderBy('id','DESC')->first();
            //dd($subscribedBoostsData);
            CropsSMS::pending_banner($user_id);

            if ($cropsBannerData) {
                $output['response']=true;
                $output['message']='Your banner added successfully';
                $output['data'] = $cropsBannerData;
                $output['error'] = "";
            } else {
                $output['response']=false;
                $output['message']='Something Went Wrong';
                $output['data'] = '';
                $output['error'] = "Database Error";
            }
        } else{
                $output['response']=true;
                $output['message']='No banner left';
                $output['data'] = "";
                $output['error'] = "No banner left";
        }
        }
        return $output;
    }

    ## Crops banner list
    public function cropsBannerList(Request $request)
    {
        $data = [];
        $user_id = auth()->user()->id;
        $data = DB::table('crops_banners as a')
            ->select(
                'a.*',
                'b.subscription_id',
                'b.subscription_feature_id',
                'b.crops_category_id',
                'b.price',
                'b.user_id',
              //  'b.category_id',
                'b.start_date',
                'b.end_date',
                'b.coupon_code_id',
                'b.purchased_price',
                'b.transaction_id',
                'b.order_id',
                'b.invoice_no',
                'b.status as banner_status',
                'c.name as subscription_feature_name',
                'c.days',
                'c.website',
                'c.mobile',
                'c.category',
                'c.category_view_all',
                'c.notification',
                'e.discount_percentage',
                'e.discount_flat',
                DB::raw('GROUP_CONCAT(s.state_name) AS campaign_state_names'),
                DB::raw("CONCAT('".env('IMAGE_PATH_CROPS_BANNER')."', a.image) as campaign_banner_image")
            )
            ->leftJoin('crops_subscribeds as b', 'b.id', '=', 'a.crop_subscribed_id')
            ->leftJoin('crop_subscription_features as c', 'c.id', '=', 'b.subscription_feature_id')
            ->leftJoin('crop_subscriptions as css', 'css.id', '=', 'c.crops_subscription_id')
            ->leftJoin('coupons as e', 'e.id', '=', 'b.coupon_code_id')
            ->leftJoin('state as s', function ($join) {
                $join->whereRaw("FIND_IN_SET(s.id, a.state_id)");
            })
            ->where('a.user_id', '=', $user_id)
            ->where('a.status', '<>', 5)
            ->groupBy('a.id')
            ->get();

            //dd($data);

            if (count($data)) {
                $output['response'] = true;
                $output['message'] = 'Data';
                $output['data'] = $data;
                $output['status_code'] = 200;
                $output['error'] = '';
            } else {
                $output['response'] = false;
                $output['message'] = 'No Data Found';
                $output['data'] = $data;
                $output['status_code'] = 404;
                $output['error'] = '';
            }
            return $output;
    }
  
    # Dibyendu change
    # TOTAL CROPS PRODUCT LEAD
    public function total_crops_product_leads(Request $request)
    {
        $user_id = auth()->user()->id;
        //dd($user_id);

        if (!empty($request->skip)) {
            $skip = $request->skip;
        } else {
            $skip = 0;
        }

        if (!empty($request->take)) {
            $take = $request->take;
        } else {
            $take = 100;
        }

        if (!empty($request->start_date)) {
            $date1 = date_create($request->start_date);
            $start_date = date_format($date1, "Y-m-d H:i:s");
        } else {
            $start_date = '2000-02-07 11:43:41';
        }
        //  dd($start_date);

        if (!empty($request->end_date)) {
            $end_date = $request->end_date;
            //$end_date = date_format($end_date1, "Y-m-d H:i:s");
        } else {
            $now = Carbon::now()->format('Y-m-d H:i:s');

            $end_date = $now;
        }

        $online_crops_leads   = Crops::my_lead_product_list($user_id, $skip, $take, $start_date, $end_date);
        //dd($online_crops_leads);
        $offline_crops_lead   = Crops::my_lead_product_offline_list($user_id, $skip, $take, $start_date, $end_date);
        // dd($offline_lead_details);


        $uniqueData = [];

        if ($online_crops_leads != null) {
            $seenIds = [];
            foreach ($online_crops_leads as $item) {
                if (!in_array($item->seller_leads_user_id, $seenIds)) {
                    $uniqueData[] = $item;
                    $seenIds[] = $item->seller_leads_user_id;
                }
            }
        }


        $output = array();
        $countUniqueonlineLead = count($uniqueData);

        if ($offline_crops_lead === null && $countUniqueonlineLead === 0) {
            $mergedArray = [];
        } else if ($offline_crops_lead !== null && $countUniqueonlineLead === 0) {
            $mergedArray = $offline_crops_lead;
        } else if ($offline_crops_lead === null && $countUniqueonlineLead > 0) {
            $mergedArray = $uniqueData;
        } else if ($offline_crops_lead !== null && $countUniqueonlineLead > 0) {
            $mergedArray = array_merge($uniqueData, $offline_crops_lead);
        }

        if (!empty($mergedArray)) {
            $output['response'] = true;
            $output['message']  = 'My crops product user lead ';
            $output['data']     = $mergedArray;
            $output['error']    = "";
        } else {
            $output['response'] = true;
            $output['message']  = 'No Data Available';
            $output['data']     = [];
            $output['error']    = "";
        }

        return $output;
    }
    
    # TOTAL CROPS BANNER LEAD
    public function total_crops_banner_leads(Request $request)
    {
        $user_id = auth()->user()->id;
        //dd($user_id);

        if (!empty($request->skip)) {
            $skip = $request->skip;
        } else {
            $skip = 0;
        }

        if (!empty($request->take)) {
            $take = $request->take;
        } else {
            $take = 100;
        }

        if (!empty($request->start_date)) {
            $date1 = date_create($request->start_date);
            $start_date = date_format($date1, "Y-m-d H:i:s");
        } else {
            $start_date = '2000-01-01 00:00:00';
        }

        if (!empty($request->end_date)) {
            $end_date = $request->end_date;
        } else {
            $now = Carbon::now()->format("Y-m-d H:i:s");
            $end_date = $now;
        }

        $online_crops_banner_leads   = Crops::my_lead_banner_list($user_id, $skip, $take, $start_date, $end_date);

        $uniqueData = [];

        if ($online_crops_banner_leads != null) {
            $seenIds = [];
            foreach ($online_crops_banner_leads as $item) {
                if (!in_array($item->lead_user_id, $seenIds)) {
                    $uniqueData[] = $item;
                    $seenIds[] = $item->lead_user_id;
                }
            }
        }

        if($online_crops_banner_leads == false){
            $output['response'] = false;
            $output['message']  = 'No Data Available';
            $output['data']     = [];
            $output['error']    = "";
        }else{
            $output['response'] = true;
            $output['message']  = 'My crops banner user lead';
            $output['data']     = $uniqueData;
            $output['error']    = "";
        }
        
        return $output;
    }
    
    
    # TOTAL CROPS BANNER ID BY LEAD
    public function crops_banner_id_by_lead(Request $request)
    {
        $data = [];
        $user_id = auth()->user()->id;
        //dd($user_id);
        $crop_banner_id = $request->crop_banner_id;
        if (!empty($crop_banner_id)) {
            $crop_banner_count   = DB::table('crops_banner_leads')->where(['crops_banner_id' => $crop_banner_id, 'category_id' => 12])->count();
            //dd($crop_banner_count);
            if ($crop_banner_count > 0) {
                $crop_banner_details = CropsBanner::where('id', $crop_banner_id)->first();
                // dd($crop_banner_details);
                $crop_banner_id           = $crop_banner_details->id;
                $crop_banner_title        = $crop_banner_details->title;
                $crop_banner_description  = $crop_banner_details->description;
                $crop_banner_image        = asset("storage/crops/banner/" . $crop_banner_details->image);
                $crop_banner_status      = $crop_banner_details->status;

                $crop_banner_details = DB::table('crops_banner_leads as cbl')
                    ->select('user.id', 'user.name', 'user.mobile', 'user.email', 'user.company_name', 'cbl.status as banner_lead_status')
                    ->leftJoin('user', 'user.id', '=', 'cbl.lead_user_id')
                    ->where('cbl.crops_banner_id', $crop_banner_id)
                    ->get();
                //dd($crop_banner_details );
                foreach ($crop_banner_details as $key => $crop_banner) {
                    $data[$key] = [
                        'banner_id' => $crop_banner_id, 'campaign_name' => $crop_banner_title, 'crop_banner_description' => $crop_banner_description,
                        'campaign_banner' => $crop_banner_image, 'crop_banner_status' => $crop_banner_status, 'user_id' => $crop_banner->id, 'name' => $crop_banner->name,
                        'mobile' => $crop_banner->mobile, 'email' => $crop_banner->email, 'company_name' => $crop_banner->company_name,
                        'banner_status' => $crop_banner->banner_lead_status
                    ];
                }

                $uniqueData = [];
                $seenIds = [];
                foreach ($data as $item) {
                    if (!in_array($item['user_id'], $seenIds)) {
                        $uniqueData[] = $item;
                        $seenIds[] = $item['user_id'];
                    }
                }

                if (!empty($data)) {
                    $output['response']            = true;
                    $output['message']             = 'Total crops banner leads';
                    $output['banner_leads_count']  = $crop_banner_count;
                    $output['data']                = $uniqueData;
                    $output['error']               =  "";
                }
            } else {
                $output['response']            = false;
                $output['message']             = 'No data available';
                $output['banner_leads_count']  = "";
                $output['data']                = [];
                $output['error']               =  "";
            }
        } else {
            $output['response']            = false;
            $output['message']             = 'Please enter banner ID';
            $output['banner_leads_count']  = "";
            $output['data']                = [];
            $output['error']               =  "";
        }

        return $output;
    }
    
      # CROPS BANNER DELETED BY BANNER ID
    public function crops_banner_delete(Request $request)
    {
        $user_id = auth()->user()->id;
        $crops_banner_id = $request->crops_banner_id;

        $crops_banner_count = CropsBanner::where(['user_id' => $user_id, 'id' => $crops_banner_id])->whereIn('status', [0, 1, 2, 3])->count();
        if ($crops_banner_count > 0) {
            CropsBanner::where(['user_id' => $user_id, 'id' => $crops_banner_id])->update(['status' => 5]);
            $output['response'] = true;
            $output['message']  = 'Crops banner deleted successfully';
            $output['error']    = "";
        } else {
            $output['response'] = false;
            $output['message']  = 'No data available';
            $output['error']    = "";
        }

        return $output;
    }


    # CROPS BANNER UPDATE 
    public function crop_banner_update(Request $request)
    {
        $user_id = auth()->user()->id;

        if (!empty($request->crops_banner_id)) {
            $crops_banner_id = $request->crops_banner_id;
            
           // $banner_count = CropsBanner::where('id', $crops_banner_id)->where('user_id', $user_id)->whereIn('status',[1,2,3])->count();
           $banner_count = CropsBanner::where('id', $crops_banner_id)->where('user_id', $user_id)->whereIn('status',[0,2])->count();
          //  dd($banner_count);

            if ($banner_count > 0) {

                $banner_details = CropsBanner::where('id', $crops_banner_id)->first();

                if (!empty($request->crop_subscribed_id)) {
                    $crop_subscribed_id       = $request->crop_subscribed_id;
                } else {
                    $crop_subscribed_id       = $banner_details->crop_subscribed_id;
                }

                if (!empty($request->category_id)) {
                    $category_id  = $request->category_id;
                } else {
                    $category_id  = $banner_details->category_id;
                }

               // dd($category_id);

                if (!empty($request->crop_subscriptions_id)) {
                    $crop_subscriptions_id  = $request->crop_subscriptions_id;
                } else {
                    $crop_subscriptions_id  = $banner_details->crop_subscriptions_id;
                }

                if (!empty($request->title)) {
                    $title  = $request->title;
                } else {
                    $title  = $banner_details->title;
                }

                if (!empty($request->state_id)) {
                    $state_id  = $request->state_id;
                } else {
                    $state_id  = $banner_details->state_id;
                }


                $image = CropsBanner::where('id', $crops_banner_id)->value('image');
                $crops_banner_image = asset('storage/crops/banner/' . $image);


                if (!empty($request->banner_img)) {
                    Storage::delete($crops_banner_image);

                    $banner_img = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('banner_img')->getClientOriginalName();
                    $ext = $request->file('banner_img')->getClientOriginalExtension();
                    $request->file('banner_img')->storeAs('public/crops/banner', $banner_img);
                } else {
                    $banner_img = $image;
                }

                $crops_banner_data = [
                    'crop_subscribed_id'    => $crop_subscribed_id,
                    'category_id'           => $category_id,
                    'crop_id'               => $banner_details->crop_id,
                    'crop_subscriptions_id' => $crop_subscriptions_id,
                    'user_id'               => $banner_details->user_id,
                    'start_date'            => $banner_details->start_date,
                    'end_date'              => $banner_details->end_date,
                    'title'                 => $title,
                    'description'           => $banner_details->description,
                    'image'                 => $banner_img,
                    'state_id'              => $state_id,
                    'status'                => 0,
                    'created_at'            => $banner_details->created_at,
                    'updated_at'            => Carbon::now(),
                ];
                

              //  dd($crops_banner_data);

                   $cropsBannerData = DB::table('crops_banners')
                   ->where('id',$crops_banner_id)
                   ->update($crops_banner_data);
             
                    $output['response'] = true;
                    $output['message']  = 'Your banner update successfully';
                    $output['data']     = $cropsBannerData;
                    $output['error']    = "";
                
            } else {
                $output['response'] = false;
                $output['message']  = 'No data available';
                $output['data']     = [];
                $output['error']    = "";
            }
        }else{
            $output['response'] = false;
            $output['message']  = 'please select crops banner id';
            $output['data']     = [];
            $output['error']    = "";

        }

        return $output;
    }
    

    #Update limit count
    public function updateLimitCount(Request $request){
        //dd("This is test");
        // Define the date limit
        $dateLimit = Carbon::parse('2024-04-13 00:00:00');

        // Subquery for tractors
        $subQuery1 = DB::table('tractor')
            ->select('user_id', DB::raw('COUNT(id) AS count'))
            ->where('created_at', '<', $dateLimit)
            ->groupBy('user_id');

        // Subquery for goods_vehicle
        $subQuery2 = DB::table('goods_vehicle')
            ->select('user_id', DB::raw('COUNT(id) AS count'))
            ->where('created_at', '<', $dateLimit)
            ->groupBy('user_id')
            ->unionAll($subQuery1);

        // Subquery for harvester
        $subQuery3 = DB::table('harvester')
            ->select('user_id', DB::raw('COUNT(id) AS count'))
            ->where('created_at', '<', $dateLimit)
            ->groupBy('user_id')
            ->unionAll($subQuery2);

        // Subquery for implements
        $subQuery4 = DB::table('implements')
            ->select('user_id', DB::raw('COUNT(id) AS count'))
            ->where('created_at', '<', $dateLimit)
            ->groupBy('user_id')
            ->unionAll($subQuery3);

        // Subquery for seeds
        $subQuery5 = DB::table('seeds')
            ->select('user_id', DB::raw('COUNT(id) AS count'))
            ->where('created_at', '<', $dateLimit)
            ->groupBy('user_id')
            ->unionAll($subQuery4);

        // Subquery for pesticides
        $subQuery6 = DB::table('pesticides')
            ->select('user_id', DB::raw('COUNT(id) AS count'))
            ->where('created_at', '<', $dateLimit)
            ->groupBy('user_id')
            ->unionAll($subQuery5);

        // Subquery for fertilizers
        $subQuery7 = DB::table('fertilizers')
            ->select('user_id', DB::raw('COUNT(id) AS count'))
            ->where('created_at', '<', $dateLimit)
            ->groupBy('user_id')
            ->unionAll($subQuery6);

        // Subquery for tyres
        $subQuery8 = DB::table('tyres')
            ->select('user_id', DB::raw('COUNT(id) AS count'))
            ->where('created_at', '<', $dateLimit)
            ->groupBy('user_id')
            ->unionAll($subQuery7);

        // Combine all subqueries and aggregate the results
        $result = DB::table(DB::raw("({$subQuery8->toSql()}) as combined_counts"))
            ->mergeBindings($subQuery8)
            ->select('user_id', DB::raw('SUM(count) AS total_count'))
            ->groupBy('user_id')
            ->get();

            if(count($result)>0){
                 foreach ($result as $val) {

                    $updateLimit = DB::table('user')->where('id', $val->user_id)->update(['limit_count' => $val->total_count]);
  
                 }
            }
            $output['response'] = true;
            $output['message']  = 'Data updated successfully';
            $output['data']     = [];
            $output['error']    = "";
    }
    
}
