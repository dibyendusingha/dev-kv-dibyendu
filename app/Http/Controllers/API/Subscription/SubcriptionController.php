<?php

namespace App\Http\Controllers\API\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Subscription\Subscription;
use App\Models\Subscription\SubscriptionFeatures;
use App\Models\Subscription\Subscribed;
use App\Models\Subscription\AdsBanner;
use App\Models\Subscription\Coupon;
use App\Models\Subscription\Subscription_boost;
use App\Models\sms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DateTime;
use Razorpay\Api\Api;

use App\Models\MyLeadList;


class SubcriptionController extends Controller
{
    use AuthorizesRequests;

    public function subscription_interest_record (Request $request) 
    {
        $user_id = auth()->user()->id;
        $status = $request->status;

        if ($status==1) {
            $count = DB::table('subscription_interest')->where(['user_id'=>$user_id])->count();
            if ($count>0) {
                $action = DB::table('subscription_interest')->where(['user_id'=>$user_id])->update(['updated_at'=>date('Y-m-d H:i:s')]);
            } else {
                $action = DB::table('subscription_interest')->insert(['user_id'=>$user_id,'status'=>1,'created_at'=>date('Y-m-d H:i:s')]);
            }
           
        } else {
            $action = DB::table('subscription_interest')->insert(['user_id'=>$user_id,'status'=>1,'created_at'=>date('Y-m-d H:i:s')]);
        }
        
        $output['response'] = true;
        $output['message'] = 'Interest Captured';
        $output['status_code'] = 200;
        $output['error'] = '';
        return $output;
    }

    public function coupon(Request $request)
    {
        $data = [];
        $date = Carbon::now();
        $user_id = auth()->user()->id;
        // $date = $dt->format('Y-m-d');
        $coupon_code = $request->coupon_code;
        $subscription_features_id = $request->subscription_features_id;
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = [];
            $output['status_code'] = 401;
            $output['error'] = $validator->errors();
        } else {
            
            $data = DB::table('coupons')->where(['code' => $coupon_code])->where('manufacture_date', '<', $date)->where('expiry_date', '>', $date)
                ->where('usability', '>', 'used')
                ->where('status', 1)->first();

            $subscribeds = DB::table('subscribeds')->where(['coupon_code'=>$coupon_code,'user_id'=>$user_id])->count();
            $subscribed_boosts = DB::table('subscribed_boosts')->where(['coupon_code'=>$coupon_code,'user_id'=>$user_id])->count();
            $used = $subscribeds+$subscribed_boosts;

            if (!empty($data) && $used==0) {
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
                $output['error'] = 'Something Went Worng!';
            }
        }
        return $output;
    }

    public function subscriptionDetails()
    {
        $data = [];
        $output = [];

        $basic_plane_image        = 'https://krishivikas.com/storage/banner_ads/Bronze_plan_banner.jpg';
        $intermediate_plane_image = 'https://krishivikas.com/storage/banner_ads/Silver_plan_banner.jpg';
        $premium_plane_image      = 'https://krishivikas.com/storage/banner_ads/Golden_plan_banner.jpg';

        $subscription_details   = Subscription::get();

        foreach ($subscription_details as $key => $sub) {
            $sub_id     = $sub->id;
            $sub_name   = $sub->name;
            $sub_status = $sub->status;
            if ($sub_name == "Basic") {
                $plane_image = $basic_plane_image;
            } else if ($sub_name == "Intermediate") {
                $plane_image = $intermediate_plane_image;
            } else if ($sub_name == "Premium") {
                $plane_image = $premium_plane_image;
            } else {
                $plane_image = $premium_plane_image;
            }


            $subscription_features_details = SubscriptionFeatures::where('subscription_id', $sub->id)->get();

            foreach ($subscription_features_details as $key1 => $sub_feature) {
                $sub_fea_id      = $sub_feature->id;
                $subscription_id = $sub_feature->subscription_id;
                $name            = $sub_feature->name;
                $days            = $sub_feature->days;
                $price           = $sub_feature->price;
                $website         = $sub_feature->website;
                $mobile          = $sub_feature->mobile;
                $sub_category    = $sub_feature->sub_category;
                $category        = $sub_feature->category;
                $listing         = $sub_feature->listing;
                $creatives       = $sub_feature->creatives;
                $state           = $sub_feature->state;
                $created_at      = $sub_feature->created_at;
                $updated_at      = $sub_feature->updated_at;

                $specification = [
                    'website' => $website, 'mobile' => $mobile, 'sub_category' => $sub_category, 'category' => $category, 'listing' => $listing,
                    'creatives' => $creatives, 'state' => $state
                ];

                $features[$key1] = [
                    'id' => $sub_fea_id, 'subscription_id' => $subscription_id, 'name' => $name, 'days' => $days, 'price' => $price,
                    'created_at' => $created_at, 'updated_at' => $updated_at
                ];
            }

            $data[$key] = [
                'id' => $sub_id, 'name' => $sub_name, 'plane_image' => $plane_image, 'status' => $sub_status, 'specification' => $specification, 'feature' => $features
            ];
        }
        if (!empty($data)) {
            $output['response']       = true;
            $output['message']        = 'Subscription Data';
            $output['data']           = $data;
            $output['error']          = "";
        } else {
            $output['response']       = false;
            $output['message']        = 'No Data Available';
            $output['data']           = [];
        }

        return $output;
    }

    /** Add Subscribed */
    public function payment_subscription(Request $request)
    {
        $output = [];
        $subscriptions_feature_id = $request->subscriptions_feature_id;
        $coupon_id                = $request->coupon_id;
        $coupon_code              = $request->coupon_code;
        $purchase_amount          = $request->purchase_amount;
        $order_id                 = $request->order_id;
        $transaction_id           = $request->transaction_id;

        $sub_f_id = intval($subscriptions_feature_id);

        $user_id = auth()->user()->id;


        $subs_count = DB::table('subscribeds')->where('user_id', $user_id)->where('subscription_feature_id', $request->subscriptions_feature_id)->count();
        if ($subs_count == 0) {
            try {
                DB::beginTransaction();
                $subscriptions_feature_count = SubscriptionFeatures::where('id', $subscriptions_feature_id)->where('status', 1)->count();
                if ($subscriptions_feature_count > 0) {
                    $subscriptions_feature_details = SubscriptionFeatures::where('id', $subscriptions_feature_id)->where('status', 1)->first();

                    $id              = $subscriptions_feature_details->id;
                    $subscription_id = $subscriptions_feature_details->subscription_id;
                    $name            = $subscriptions_feature_details->name;
                    $days            = $subscriptions_feature_details->days;
                    $price           = $subscriptions_feature_details->price;
                }

                $date1 =  Carbon::now();
                $start_date = date("Y-m-d H:i:s", strtotime($date1));

                if ($days == '90') {
                    $futureDate = $date1->addDays(90);
                    $date2      = $futureDate->format('Y-m-d H:i:s');
                    $end_date   = date("Y-m-d H:i:s", strtotime($date2));
                } else if ($days == '180') {
                    $futureDate = $date1->addDays(180);
                    $date2      = $futureDate->format('Y-m-d H:i:s');
                    $end_date   = date("Y-m-d H:i:s", strtotime($date2));
                } else if ($days == '360') {
                    $futureDate = $date1->addDays(360);
                    $date2      = $futureDate->format('Y-m-d H:i:s');
                    $end_date   = date("Y-m-d H:i:s", strtotime($date2));
                }

                $financialYear = Subscription::getFinancialYear($start_date, "y"); //21-22 

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
                ) AS combined_tables");

                $invoiceId = $getId[0]->max_invoice_number + 1; #new id for Invoice

                $subscribed = new Subscribed;
                $subscribed->subscription_id         = $subscription_id;
                $subscribed->subscription_feature_id = $id;
                $subscribed->user_id                 = $user_id;
                $subscribed->price                   = $price;
                $subscribed->start_date              = $start_date;
                $subscribed->end_date                = $end_date;
                $subscribed->coupon_code_id          = $coupon_id;
                $subscribed->coupon_code             = $coupon_code;
                $subscribed->purchased_price         = $purchase_amount;
                $subscribed->transaction_id          = $transaction_id;
                $subscribed->order_id                = $order_id;
                $subscribed->gst                     = $request->gst;     
                $subscribed->sgst                    = $request->sgst; 
                $subscribed->cgst                    = $request->cgst;  
                $subscribed->igst                    = $request->igst;  
                $subscribed->invoice_no              = "AECPL/" . str_pad($invoiceId, 5, "0", STR_PAD_LEFT) . "/" . $financialYear;
                $subscribed->status                  = 1;
                $subscribed->created_at              = Carbon::now();
                $subscribed->updated_at              = Carbon::now();

                $subscribed->save();

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

                $subscribed_details   = Subscribed::where('id', $subscribed->id)->where('status', 1)->first();
                $subscription_details = Subscription::where('id', $subscription_id)->where('status', 1)->first();
                if ($coupon_id != '') {
                    $coupon_details       = Coupon::where('id', $coupon_id)->where('status', 1)->first();

                    if ($coupon_details->discount_percentage == null) {
                        $discount_percentage = 'null';
                    } else {
                        $discount_percentage = $coupon_details->discount_percentage;
                    }

                    if ($coupon_details->discount_flat == null) {
                        $discount_flat = 'null';
                    } else {
                        $discount_flat = $coupon_details->discount_flat;
                    }
                }

                # GST
                if($subscribed_details->gst == null){
                    $gst = 'null';
                }else{
                    $gst = $subscribed_details->gst;
                }

                # SGST
                if($subscribed_details->sgst == null){
                    $sgst = 'null';
                }else{
                    $sgst = $subscribed_details->sgst;
                }

                # CGST
                if($subscribed_details->cgst == null){
                    $cgst = 'null';
                }else{
                    $cgst = $subscribed_details->cgst;
                }

                # IGST
                if($subscribed_details->igst == null){
                    $igst = 'null';
                }else{
                    $igst = $subscribed_details->igst;
                }


                $user_details = DB::table('user')->where('id', $user_id)->first();

                $data = [
                    'subscribed_id' => $subscribed_details->id,
                    'user_id' => $user_details->id, 'user_type_id' => $user_details->user_type_id, 'name' => $user_details->name,
                    'subscription_id' => $subscribed_details->subscription_id, 'subscription_name' => $subscription_details->name,
                    'price' => $subscribed_details->price, 'start_date' => $subscribed_details->start_date, 'end_date' => $subscribed_details->end_date,
                    'coupon_code_id' => $subscribed_details->coupon_code_id, 'coupon_code' => $subscribed_details->coupon_code,
                    'purchased_price' => $subscribed_details->purchased_price, 'transaction_id' => $subscribed_details->transaction_id, 'order_id' => $subscribed_details->order_id,
                    'gst'=>$gst, 'sgst'=>$sgst,'cgst'=>$cgst, 'igst'=>$igst,
                    'invoice_no' => $subscribed_details->invoice_no, 'status' => $subscribed_details->status,
                ];
                DB::commit();
                $sms = sms::subscription_payment($user_details->mobile, $data['name'], $data['subscription_name'], $data['transaction_id'], $data['invoice_no'], $data['purchased_price'], $data['end_date']);
                //print_r($sms);
                DB::table('subscription_interest')->where(['user_id'=>$user_details->id])->delete();
                

                $output['response']       = true;
                $output['message']        = 'subscribed Data saved';
                $output['data']           = $data;
                $output['error']          = "";
            } catch (\Exception $e) {
                DB::rollBack();
                $output['response']       = false;
                $output['message']        = $e;
            }
        } else if ($subs_count > 0) {
            $output['response']       = false;
            $output['message']        = 'This User Already Have Same Subscription';
            $output['data']           = [];
            $output['error']          = "";
        }

        return $output;
    }

    # My Subscriptions
    public function my_subscriptions(Request $request)
    {
        $user_id = auth()->user()->id;
       // dd($user_id);
        $data = [];
        $coupon = [];
        $subscriped = [];
        $promotionData = [];

        $subscribedId = DB::table('subscribeds')->where('user_id',$user_id)->where('status',1)->value('id');
        if($subscribedId == null){
            $subscribedId =0;
        }

   
        $subscriped = DB::table('subscribeds as a')
            ->select(
                'a.*',
                'b.name',
                'b.days',
                'b.website',
                'b.mobile',
                'b.sub_category',
                'b.category',
                'b.listing',
                'b.creatives',
                'b.state',
                'c.name',
                'pp.package_name',
                'pp.no_of_products',
                'pp.seller_tag_id',
                'pp.subscription_featue_id',
                'pp.subscription_boosts_id',
                'pp.no_of_boots as no_of_boosts',
                'pp.customer_service',
                'pp.leads',
                'pp.duration',
                'pp.package_price',
                'pt.name as tag_name',
                //'inv.id as invoice_id',
                DB::raw("CONCAT('".env('TAGS_IMAGE_PATH')."', pt.tag_image) as tag_image"),          
                DB::raw('CONCAT("'.env('IMAGE_PATH').'invoice/subscription/'.$subscribedId.'") as invoice_id')
            )
            ->leftJoin('subscription_features as b', 'b.id', '=', 'a.subscription_feature_id')
            ->leftJoin('promotion_package as pp', 'pp.id', '=', 'a.package_id')
            ->leftJoin('promotion_tags as pt', 'pt.id', '=', 'pp.seller_tag_id')
            ->leftJoin('subscriptions as c', 'c.id', '=', 'a.subscription_id')
           // ->leftJoin('invoice as inv', 'inv.user_id', '=', 'a.user_id')
           // ->where('inv.invoice_type', 'promotion_boosts_admin')
            ->where(['a.user_id' => $user_id])
            ->where('a.status',1)
            ->get();
            
           // dd($subscriped);



            $boostsCount =  DB::table('subscribed_boosts')
                            ->where('user_id',$user_id)
                            ->where('status',1)
                            ->count();
            $userPostCount =  DB::table('user')
                            ->select('limit_count','user_post_count')
                            ->where('id',$user_id)
                            ->where('status',1)
                            ->first();

          //  dd($userPostCount);

//dd($subscriped);

        if(count($subscriped)>0){
            foreach ($subscriped as $key => $val) {

               

               // echo "limit_count".$userPostCount->limit_count;
               // echo "user_post_count".$userPostCount->user_post_count;

                $subscriped_data['id'] = $val->id;
                $subscriped_data['subscription_id'] = $val->subscription_id;
                $subscriped_data['subscription_feature_id'] = $val->subscription_feature_id;
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
                $subscriped_data['invoice_id'] = $val->invoice_id;
               
                

                $features['website'] = $val->website;
                $features['mobile'] = $val->mobile;
                $s_data['sub_category'] = $val->sub_category;
                $features['category'] = $val->category;
                $features['listing'] = $val->listing;
                $features['creatives'] = $val->creatives;

                $promotion_data['package_name'] = $val->package_name;
               // $promotion_data['no_of_products'] = $val->no_of_products;
                $promotion_data['no_of_products'] =  $userPostCount->limit_count-$userPostCount->user_post_count;
                $promotion_data['seller_tag_id'] = $val->seller_tag_id;
                $promotion_data['seller_tag_name'] = $val->tag_name;
                $promotion_data['seller_tag_image'] = $val->tag_image;
                $promotion_data['subscription_featue_id'] = $val->subscription_featue_id;
                $promotion_data['subscription_boosts_id'] = $val->subscription_boosts_id;
                $promotion_data['no_of_boosts'] = $val->no_of_boosts-$boostsCount;
                $promotion_data['customer_service'] = $val->customer_service;
                $promotion_data['leads'] = $val->leads;
                $promotion_data['duration'] = $val->duration;
                $promotion_data['package_price'] = $val->package_price;

                $ads_data = DB::table('ads_banners')
                    ->select('ads_banners.*', DB::raw("CONCAT('".env('IMAGE_PATH_SPONSER')."',ads_banners.campaign_banner) as campaign_banner"))
                    ->where(['subscribed_id' => $val->id])->get();
                $data[] = ['s_data' => $subscriped_data, 'creative_count' => count($ads_data), 'features' => $features, 'ads_id' => $ads_data, 'promotion_data' => $promotion_data];
            }
            //$couponData =  DB::table('couponView')->where('user_id',$user_id)->where('status',1)->first();

            //dd(env('TAGS_IMAGE_PATH'));

            $couponData =  DB::table('couponView as cv')
                          ->select('cv.*','pp.package_name','pp.no_of_products','pp.no_of_boots as no_of_boosts','pp.customer_service','pp.leads','pp.duration','pp.package_price','pt.name as tag_name',DB::raw("CONCAT('".env('TAGS_IMAGE_PATH')."', pt.tag_image) as tags_image"))
                          ->leftJoin('promotion_package as pp', 'pp.id', '=', 'cv.package_id')
                          ->leftJoin('promotion_tags as pt', 'pt.id', '=', 'cv.seller_tag_id')
                          ->where('cv.user_id',$user_id)
                          ->where('cv.status',1)
                          ->first();

            //   dd($couponData);

            if(!empty($couponData)){

                if($couponData->subscription_featue_id==1){
                    $bannerAd = "Basic";
                } else if($couponData->subscription_featue_id==2){
                    $bannerAd = "Basic";
                } else if($couponData->subscription_featue_id==3){
                    $bannerAd = "Basic";
                } else if($couponData->subscription_featue_id==4){
                    $bannerAd = "Intermediate";
                } else if($couponData->subscription_featue_id==5){
                    $bannerAd = "Intermediate";
                } else if($couponData->subscription_featue_id==6){
                    $bannerAd = "Intermediate";
                }else if($couponData->subscription_featue_id==7){
                    $bannerAd = "Premium";
                }else if($couponData->subscription_featue_id==8){
                    $bannerAd = "Premium";
                }else if($couponData->subscription_featue_id==9){
                    $bannerAd = "Premium";
                }

                if($couponData->subscription_boosts_id ==1){
                    $boostsAd = "Basic";
                } else if($couponData->subscription_boosts_id ==2){
                    $boostsAd = "Intermediate";
                } else if($couponData->subscription_boosts_id ==3){
                    $boostsAd = "Premium";
                } 

                if($couponData->customer_service=='Y'){
                    $customerService= 'Yes';
                } else {
                    $customerService= 'No';
                }

                if($couponData->leads=='Y'){
                    $leadsData= 'Yes';
                } else {
                    $leadsData= 'No';
                }

                $boostsCount =  DB::table('subscribed_boosts')
                            ->where('user_id',$user_id)
                            ->where('status',1)
                            ->count();

                $userPostCount =  DB::table('user')
                            ->select('limit_count','user_post_count')
                            ->where('id',$user_id)
                            ->where('status',1)
                            ->first();
               // echo $couponData->no_of_boosts;
               // dd($boostsCount);

                $coupon_data['coupon_data'] = $couponData->total_days;
                $coupon_data['seller_tag_image'] = $couponData->tags_image;
                $coupon_data['package_name'] = $couponData->package_name;
                $coupon_data['package_price'] = $couponData->package_price;
                $coupon_data['subscription_featue_id'] = $couponData->subscription_featue_id;
                $coupon_data['subscription_boosts_id'] = $couponData->subscription_boosts_id;
                $coupon_data['certified_seller_tag'] = $couponData->tag_name;

                $coupon_data['total_days_start_day'] = $couponData->total_days_start_day;
                $coupon_data['total_days_end_day'] = $couponData->total_days_end_day;
                $coupon_data['buffer_days_start_day'] = $couponData->buffer_days_start_day;
                $coupon_data['buffer_days_end_day'] = $couponData->buffer_days_end_day;


                //$promotion_datas['no_of_products'] = $couponData->no_of_products-$boostsCount;
                $promotion_datas['no_of_products'] = $userPostCount->limit_count-$userPostCount->user_post_count;
                $promotion_datas['banner_ad'] = $bannerAd;
                $promotion_datas['boost_ad'] = $boostsAd;
                $promotion_datas['no_of_boosts'] = $couponData->no_of_boosts-$boostsCount;
                $promotion_datas['24x7_customer_service'] = $customerService;
                $promotion_datas['leads'] = $leadsData;
                $promotion_datas['duration'] = $couponData->duration;
              
                $promotionData[] = ['coupon_data' =>$coupon_data, 'promotion_data' => $promotion_datas];
            }

            $output['response'] = true;
            $output['message'] = 'My Subscription List';
            $output['data'] = $data;
            $output['coupon'] = $promotionData;
            $output['status_code'] = 200;
            $output['error'] = '';
        } else {
            $output['response'] = false;
            $output['message'] = 'Failed';
            $output['data'] = [];
            $output['coupon'] = [];
            $output['status_code'] = 500;
            $output['error'] = 'Internal Server Error';
        }

        return $output;
    }

    # Invoice
    public function invoice(Request $request)
    {
        $user_id = auth()->user()->id;
        $subscriped_id    = $request->subscriped_id;

        $subscription_data = DB::table('subscribeds')->select(['subscription_id', 'subscription_feature_id'])->where(['id' => $subscriped_id])->first();

        $subscription_id = $subscription_data->subscription_id;
        $subscription_feature_id = $subscription_data->subscription_feature_id;

        $validator = Validator::make($request->all(), [
            'subscriped_id' => 'required',
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = [];
            $output['status_code'] = 401;
            $output['error'] = $validator->errors();
        } else {

            $data = DB::table('subscribeds as a')
                ->select(
                    'a.*',
                    'b.name as subscribtion_feature_name',
                    'b.days as subscribtion_feature_days',
                    'c.name as subscribtion_name',
                    'd.discount_type',
                    'd.discount_percentage',
                    'd.discount_flat'
                )
                ->leftJoin('subscription_features as b', 'b.id', '=', 'a.subscription_feature_id')
                ->leftJoin('subscriptions as c', 'c.id', '=', 'a.subscription_id')
                ->leftJoin('coupons as d', 'd.id', '=', 'a.coupon_code_id')
                ->where(['a.id' => $subscriped_id])
                ->first();

            if ($data) {

                $output['response'] = true;
                $output['message'] = 'Invoice';
                $output['data'] = $data;
                $output['status_code'] = 200;
                $output['error'] = '';
            } else {
                $output['response'] = false;
                $output['message'] = 'Failed';
                $output['data'] = [];
                $output['status_code'] = 500;
                $output['error'] = 'Internal Server Error';
            }
        }
        return $output;
    }

    # Invoice Page 
    public function invoice_page(Request $request, $type, $subscribedId)
    {
          //dd($type);

        if ($type == 'subscription' || $type == 'subscription_boots' || $type == 'crops_subscription') {
            if ($type == 'subscription') {
                $subscribe_details             = Subscribed::where('id', $subscribedId)->first();
                $subscription_details          = Subscription::where('id', $subscribe_details->subscription_id)->first();
                $subscription_features_details = SubscriptionFeatures::where('id', $subscribe_details->subscription_feature_id)->first();
                $user_details                  = DB::table('user')->where('id', $subscribe_details->user_id)->first();
                $state_name                    = DB::table('state')->where('id', $user_details->state_id)->first()->state_name;
                $district_name                 = DB::table('district')->where('id', $user_details->district_id)->first()->district_name;

                $date1 = date_create($subscribe_details->created_at);
                $date  = date_format($date1, "d/m/Y");
                $time  = date_format($date1, "H:i:s");

                $gst = 0;

                $coupon_count = Coupon::where('id', $subscribe_details->coupon_code_id)->count();
                if ($coupon_count > 0) {
                    $coupon_details = Coupon::where('id', $subscribe_details->coupon_code_id)->first();
                    $discount_percentage = $coupon_details->discount_percentage;
                    $discount_flat       = $coupon_details->discount_flat;
                    if ($discount_flat == null) {
                        $discount = ($subscription_features_details->price * $coupon_details->discount_percentage) / 100;
                    } else {
                        $discount =  $discount_flat;
                    }
                } else {
                    $discount = 0;
                }

                return view('front.development.invoice', [
                    'subscribe_details' => $subscribe_details, 'subscription_details' => $subscription_details,
                    'subscription_features_details' => $subscription_features_details, 'user_details' => $user_details,
                    'date' => $date, 'time' => $time, 'gst' => $gst, 'state_name' => $state_name, 'district_name' => $district_name, 'discount' => $discount
                ]);
            } else if ($type == 'subscription_boots') {
                $subscribe_details             = DB::table('subscribed_boosts')->where('id', $subscribedId)->first();
                $subscription_details          = DB::table('subscription_boosts')->where('id', $subscribe_details->subscription_boosts_id)->first();
                $subscription_features_details = DB::table('subscription_boosts')->where('id', $subscribe_details->subscription_boosts_id)->first();
                $user_details                  = DB::table('user')->where('id', $subscribe_details->user_id)->first();
                $state_name                    = DB::table('state')->where('id', $user_details->state_id)->first()->state_name;
                $district_name                 = DB::table('district')->where('id', $user_details->district_id)->first()->district_name;

                $date1 = date_create($subscribe_details->created_at);
                $date  = date_format($date1, "d/m/Y");
                $time  = date_format($date1, "H:i:s");

                $gst = 0;

                $coupon_count = Coupon::where('id', $subscribe_details->coupon_code_id)->count();
                if ($coupon_count > 0) {
                    $coupon_details = Coupon::where('id', $subscribe_details->coupon_code_id)->first();
                    $discount_percentage = $coupon_details->discount_percentage;
                    $discount_flat       = $coupon_details->discount_flat;
                    if ($discount_flat == null) {
                        $discount = ($subscription_features_details->price * $coupon_details->discount_percentage) / 100;
                    } else {
                        $discount =  $discount_flat;
                    }
                } else {
                    $discount = 0;
                }
            } else if($type == 'crops_subscription'){
                $subscribe_details             = DB::table('crops_subscribeds')->where('id', $subscribedId)->first();
                $subscription_features_details = DB::table('crop_subscription_features')->where('id', $subscribe_details->subscription_feature_id)->first();
                $subscription_details = DB::table('crop_subscriptions')->where('id', $subscription_features_details->crops_subscription_id)->first();
                $userId = $subscribe_details->user_id;
     
                $user_details                  = DB::table('user')->where('id', $subscribe_details->user_id)->first();
              //  dd($user_details);
                $state_name                    = DB::table('state')->where('id', $user_details->state_id)->first()->state_name;
                $district_name                 = DB::table('district')->where('id', $user_details->district_id)->first()->district_name;

                $date1 = date_create($subscribe_details->created_at);
                $date  = date_format($date1, "d/m/Y");
                $time  = date_format($date1, "H:i:s");

                $gst = 0;

                $coupon_count = Coupon::where('id', $subscribe_details->coupon_code_id)->count();
                if ($coupon_count > 0) {
                    $coupon_details = Coupon::where('id', $subscribe_details->coupon_code_id)->first();
                    $discount_percentage = $coupon_details->discount_percentage;
                    $discount_flat       = $coupon_details->discount_flat;
                    if ($discount_flat == null) {
                        $discount = ($subscription_features_details->price * $coupon_details->discount_percentage) / 100;
                    } else {
                        $discount =  $discount_flat;
                    }
                } else {
                    $discount = 0;
                }

               // dd($subscription_details);
                return view('front.development.crop_invoice', [
                    'subscribe_details' => $subscribe_details, 'subscription_details' => $subscription_details,
                    'subscription_features_details' => $subscription_features_details, 'user_details' => $user_details,
                    'date' => $date, 'time' => $time, 'gst' => $gst, 'state_name' => $state_name, 'district_name' => $district_name, 'discount' => $discount
                ]);
            }

            return view('front.development.invoice', [
                'subscribe_details' => $subscribe_details, 'subscription_details' => $subscription_details,
                'subscription_features_details' => $subscription_features_details, 'user_details' => $user_details,
                'date' => $date, 'time' => $time, 'gst' => $gst, 'state_name' => $state_name, 'district_name' => $district_name, 'discount' => $discount
            ]);
        }
    }

    # Subscription Renewal
    public function subscription_renew(Request $request)
    {
        $output = [];
        $user_id            = auth()->user()->id;
        $old_subscribed_id  = $request->old_subscribed_id;
        $coupon_id          = $request->coupon_id;
        $coupon_code        = $request->coupon_code;
        $purchase_amount    = $request->purchase_amount;
        $order_id           = $request->order_id;
        $transaction_id     = $request->transaction_id;

        $subs_count = DB::table('subscribeds')->where('user_id', $user_id)->where('id', $old_subscribed_id)->whereIn('status', [1,0])->count();
        if ($subs_count > 0) {
            try {
                $subscribe_count = Subscribed::where(['id' => $old_subscribed_id, 'user_id' => $user_id])->count();
                if ($subscribe_count == 1) {
                    $subscribe_details  = DB::table('subscribeds')->where(['id' => $old_subscribed_id, 'user_id' => $user_id])->first();

                    $subscription_id         = $subscribe_details->subscription_id;
                    $subscription_feature_id = $subscribe_details->subscription_feature_id;
                    $price                   = $subscribe_details->price;
                    // $date1                   = $subscribe_details->start_date;
                    $date2                   = $subscribe_details->end_date;

                    $cal = Carbon::now();
                    $cal_date1 = Carbon::now()->format('Y/m/d H:i:s'); //new DateTime($date1);
                    //dd($cal_date1);
                    $cal_date2 = new DateTime($date2);

                    if ($cal_date2 > $cal_date1) {

                        $interval = $cal_date2->diff($cal);
                    } else {
                        $interval = 0;
                    }

                    $cal_days = $interval->days;
                    // dd($cal_days);

                    $subscriptions_feature_count = SubscriptionFeatures::where('id', $subscribe_details->subscription_feature_id)->where('status', 1)->count();
                    if ($subscriptions_feature_count > 0) {
                        $subscriptions_feature_details = SubscriptionFeatures::where('id', $subscribe_details->subscription_feature_id)->where('status', 1)->first();

                        $subscription_id = $subscriptions_feature_details->subscription_id;
                        $days            = $subscriptions_feature_details->days;
                    }

                    $date1 =  Carbon::now();
                    $start_date = date("Y-m-d H:i:s", strtotime($date1));

                    if ($days == '90') {
                        $total_days = $cal_days + 90;
                        $futureDate = $date1->addDays($total_days);
                        $date2      = $futureDate->format('Y-m-d H:i:s');
                        $end_date   = date("Y-m-d H:i:s", strtotime($date2));
                    } else if ($days == '180') {
                        $total_days = $cal_days + 180;
                        $futureDate = $date1->addDays($total_days);
                        $date2      = $futureDate->format('Y-m-d H:i:s');
                        $end_date   = date("Y-m-d H:i:s", strtotime($date2));
                    } else if ($days == '360') {
                        $total_days = $cal_days + 360;
                        $futureDate = $date1->addDays($total_days);
                        $date2      = $futureDate->format('Y-m-d H:i:s');
                        $end_date   = date("Y-m-d H:i:s", strtotime($date2));
                    }

                    $financialYear = Subscription::getFinancialYear($start_date, "y"); //21-22 

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
                        ) AS combined_tables");

                    $invoiceId = $getId[0]->max_invoice_number + 1; #new id for Invoice

                    $subscribed = new Subscribed;
                    $subscribed->subscription_id         = $subscription_id;
                    $subscribed->subscription_feature_id = $subscription_feature_id;
                    $subscribed->user_id                 = $user_id;
                    $subscribed->price                   = $price;
                    $subscribed->start_date              = $start_date;
                    $subscribed->end_date                = $end_date;
                    $subscribed->coupon_code_id          = $coupon_id;
                    $subscribed->coupon_code             = $coupon_code;
                    $subscribed->purchased_price         = $purchase_amount;
                    $subscribed->transaction_id          = $transaction_id;
                    $subscribed->order_id                = $order_id;
                    $subscribed->gst                     = $request->gst;     
                    $subscribed->sgst                    = $request->sgst; 
                    $subscribed->cgst                    = $request->cgst;  
                    $subscribed->igst                    = $request->igst;  
                    $subscribed->invoice_no              = "AECPL/" . str_pad($invoiceId, 5, "0", STR_PAD_LEFT) . "/" . $financialYear;
                    $subscribed->status                  = 1;
                    $subscribed->created_at              = Carbon::now();
                    $subscribed->updated_at              = Carbon::now();

                    $subscribed->save();

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

                    $subscribed_update = Subscribed::where('id', $request->old_subscribed_id)->where('status', 1)->first();
                    $subscribed_update->status = 3;
                    $subscribed_update->update();

                    $sql = AdsBanner::where([
                        'subscription_id'         => $subscription_id,
                        'subscription_features_id' => $subscription_feature_id,
                        'user_id'                 => $user_id,
                        'subscribed_id'           => $old_subscribed_id,
                    ]);

                    $banner_count   = $sql->count();
                    $banner_details = $sql->get();

                    if ($banner_count > 0) {
                        foreach ($banner_details as $ban) {
                            $ban->subscribed_id = $subscribed->id;
                            $ban->update();
                        }
                    }

                    $subscribed_details = DB::table('subscribeds as subs')
                        ->select('subs.*', 'subs.id as subId', 'a.name as subscription_name', 'u.id', 'u.user_type_id', 'u.name', 'u.mobile')
                        ->leftJoin('subscriptions as a', 'a.id', '=', 'subs.subscription_id')
                        ->leftJoin('user as u', 'u.id', '=', 'subs.user_id')
                        ->where('subs.id', $subscribed->id)
                        ->where(['subs.status' => 1])
                        ->first();

                    if ($coupon_id != '') {
                        $coupon_details  = Coupon::where('id', $coupon_id)->where('status', 1)->first();
                        if ($coupon_details->discount_percentage == null) {
                            $discount_percentage = 'null';
                        } else {
                            $discount_percentage = $coupon_details->discount_percentage;
                        }
                        if ($coupon_details->discount_flat == null) {
                            $discount_flat = 'null';
                        } else {
                            $discount_flat = $coupon_details->discount_flat;
                        }
                    }

                    # GST
                    if($subscribed_details->gst == null){
                        $gst = 'null';
                    }else{
                        $gst = $subscribed_details->gst;
                    }

                    # SGST
                    if($subscribed_details->sgst == null){
                        $sgst = 'null';
                    }else{
                        $sgst = $subscribed_details->sgst;
                    }

                    # CGST
                    if($subscribed_details->cgst == null){
                        $cgst = 'null';
                    }else{
                        $cgst = $subscribed_details->cgst;
                    }

                    # IGST
                    if($subscribed_details->igst == null){
                        $igst = 'null';
                    }else{
                        $igst = $subscribed_details->igst;
                    }

                    $data = [
                        'subscribed_id'     => $subscribed_details->subId,
                        'user_id'           => $subscribed_details->user_id,
                        'user_type_id'      => $subscribed_details->user_type_id,
                        'name'              => $subscribed_details->name,
                        'subscription_id'   => $subscribed_details->subscription_id,
                        'subscription_name' => $subscribed_details->subscription_name,
                        'price'             => $subscribed_details->price,
                        'start_date'        => $subscribed_details->start_date,
                        'end_date'          => $subscribed_details->end_date,
                        'coupon_code_id'    => $subscribed_details->coupon_code_id,
                        'coupon_code'       => $subscribed_details->coupon_code,
                        'purchased_price'   => $subscribed_details->purchased_price,
                        'transaction_id'    => $subscribed_details->transaction_id,
                        'order_id'          => $subscribed_details->order_id,
                        'gst'               => $gst, 
                        'sgst'              => $sgst,
                        'cgst'              => $cgst, 
                        'igst'              => $igst,
                        'invoice_no'        => $subscribed_details->invoice_no,
                        'status'            => $subscribed_details->status,
                    ];
                    DB::commit();
                    $sms = sms::subscription_payment($subscribed_details->mobile, $data['name'], $data['subscription_name'], $data['transaction_id'], $data['invoice_no'], $data['purchased_price'], $data['end_date']);
                    DB::table('subscription_interest')->where(['user_id'=>$subscribed_details->id])->delete();

                    

                    $output['response']   = true;
                    $output['message']    = 'subscribed Renewal';
                    $output['data']       = $data;
                    $output['status']     = 200;
                    $output['error']      = "";
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $output['response']  = false;
                $output['message']   = 'No Data Available';
                $output['data']      = [];
                $output['status']    = 500;
                $output['error']     = "";
            }
        } else if ($subs_count == 0) {
            $output['response']  = false;
            $output['message']   = 'This old subscribed id already used';
            $output['data']      = [];
            $output['status']    = 500;
            $output['error']     = "";
        }

        return $output;
    }


    /** Subscription Upgrade  */
    public function subscription_upgrade(Request $request)
    {
        $output = [];
        $user_id                  = auth()->user()->id;
        $old_subscribed_id        = $request->old_subscribed_id;
        $subscription_feature_id  = $request->subscription_feature_id;
        $coupon_id                = $request->coupon_id;
        $coupon_code              = $request->coupon_code;
        $purchase_amount          = $request->purchase_amount;
        $order_id                 = $request->order_id;
        $transaction_id           = $request->transaction_id;

        $subs_count = DB::table('subscribeds')->where('user_id', $user_id)->where('id', $old_subscribed_id)->where('status', 1)->count();

        if ($subs_count > 0) {
            $subs_subscription_feature_id = DB::table('subscribeds')->where('user_id', $user_id)
                ->where('id', $old_subscribed_id)->where('status', 1)->first()->subscription_feature_id;

            if ($subs_subscription_feature_id == $subscription_feature_id) {
                $output['response']  = false;
                $output['message']   = 'This subscribed Can not Upgarde & Only Renewal';
                $output['data']      = [];
                $output['status']    = 500;
                $output['error']     = "";
            } else {
                try {
                    $subscribe_count = Subscribed::where(['id' => $old_subscribed_id, 'user_id' => $user_id])->count();
                    if ($subscribe_count == 1) {
                        $subscribe_details  = DB::table('subscribeds')->where(['id' => $old_subscribed_id, 'user_id' => $user_id])->first();

                        $subscription_id  = $subscribe_details->subscription_id;
                        $price            = $subscribe_details->price;

                        $date1     = $subscribe_details->start_date;
                        $date2     = $subscribe_details->end_date;

                        // $cal = Carbon::now();
                        // $cal_date1 =  Carbon::now()->format('Y/m/d H:i:s'); //new DateTime($date1);
                        $cal_date1 =  Carbon::now();
                        $cal_date2 = new DateTime($date2);

                        if ($cal_date2 > $cal_date1) {
                            $interval = $cal_date2->diff($cal_date1);
                        } else {
                            $interval = 0;
                        }
                        $cal_days = $interval->days;

                        $subscriptions_feature_count = SubscriptionFeatures::where('id', $subscribe_details->subscription_feature_id)->where('status', 1)->count();
                        if ($subscriptions_feature_count > 0) {
                            $subscriptions_feature_details = SubscriptionFeatures::where('id', $subscribe_details->subscription_feature_id)->where('status', 1)->first();

                            $subscription_id = $subscriptions_feature_details->subscription_id;
                            $days            = $subscriptions_feature_details->days;
                        }

                        $date1 =  Carbon::now();
                        $start_date = date("Y-m-d H:i:s", strtotime($date1));

                        if ($days == '90') {
                            $total_days = $cal_days + 90;
                            $futureDate = $date1->addDays($total_days);
                            $date2      = $futureDate->format('Y-m-d H:i:s');
                            $end_date   = date("Y-m-d H:i:s", strtotime($date2));
                        } else if ($days == '180') {
                            $total_days = $cal_days + 180;
                            $futureDate = $date1->addDays($total_days);
                            $date2      = $futureDate->format('Y-m-d H:i:s');
                            $end_date   = date("Y-m-d H:i:s", strtotime($date2));
                        } else if ($days == '360') {
                            $total_days = $cal_days + 360;
                            $futureDate = $date1->addDays($total_days);
                            $date2      = $futureDate->format('Y-m-d H:i:s');
                            $end_date   = date("Y-m-d H:i:s", strtotime($date2));
                        }
                        $financialYear = Subscription::getFinancialYear($start_date, "y"); //21-22 


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
                            ) AS combined_tables");

                        $invoiceId = $getId[0]->max_invoice_number + 1; #new id for Invoice

                        $subscriptions_feature_update = SubscriptionFeatures::where('id', $request->subscription_feature_id)->where('status', 1)->first();

                        $subscribed = new Subscribed;
                        $subscribed->subscription_id         = $subscriptions_feature_update->subscription_id;
                        $subscribed->subscription_feature_id = $request->subscription_feature_id;
                        $subscribed->user_id                 = $user_id;
                        $subscribed->price                   = $subscriptions_feature_update->price;
                        $subscribed->start_date              = $start_date;
                        $subscribed->end_date                = $end_date;
                        $subscribed->coupon_code_id          = $coupon_id;
                        $subscribed->coupon_code             = $coupon_code;
                        $subscribed->purchased_price         = $purchase_amount;
                        $subscribed->transaction_id          = $transaction_id;
                        $subscribed->order_id                = $order_id;
                        $subscribed->gst                     = $request->gst;     
                        $subscribed->sgst                    = $request->sgst; 
                        $subscribed->cgst                    = $request->cgst;  
                        $subscribed->igst                    = $request->igst; 
                        $subscribed->invoice_no              = "AECPL/" . str_pad($invoiceId, 5, "0", STR_PAD_LEFT) . "/" . $financialYear;
                        $subscribed->status                  = 1;
                        $subscribed->created_at              = Carbon::now();
                        $subscribed->updated_at              = Carbon::now();

                        $subscribed->save();

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

                        $subscribed_update = Subscribed::where(['id' => $request->old_subscribed_id])->first();
                        $subscribed_update->subscription_id         = $subscribed->subscription_id;
                        $subscribed_update->subscription_feature_id = $subscribed->subscription_feature_id;
                        $subscribed_update->status = 5;
                        $subscribed_update->update();

                        $sql = AdsBanner::where([
                            'user_id'                 => $user_id,
                            'subscribed_id'           => $old_subscribed_id,
                        ]);

                        $banner_count   = $sql->count();
                        $banner_details = $sql->get();

                        if ($banner_count > 0) {
                            foreach ($banner_details as $ban) {
                                $ban->subscribed_id = $subscribed->id;
                                $ban->update();
                            }
                        }


                        $subscribed_details = DB::table('subscribeds as subs')
                            ->select('subs.*', 'a.name as subscription_name', 'u.id as userId', 'u.user_type_id', 'u.name', 'u.mobile')
                            ->leftJoin('subscriptions as a', 'a.id', '=', 'subs.subscription_id')
                            ->leftJoin('user as u', 'u.id', '=', 'subs.user_id')
                            ->where('subs.id', $subscribed->id)
                            ->where(['subs.status' => 1])
                            ->first();

                        # GST
                        if($subscribed_details->gst == null){
                            $gst = 'null';
                        }else{
                            $gst = $subscribed_details->gst;

                        }

                        # SGST
                        if($subscribed_details->sgst == null){
                            $sgst = 'null';
                        }else{
                            $sgst = $subscribed_details->sgst;
                        }

                        # CGST
                        if($subscribed_details->cgst == null){
                            $cgst = 'null';
                        }else{
                            $cgst = $subscribed_details->cgst;
                        }

                        # IGST
                        if($subscribed_details->igst == null){
                            $igst = 'null';
                        }else{
                            $igst = $subscribed_details->igst;
                        }

                        $data = [
                            'subscribed_id'     => $subscribed->id,
                            'user_id'           => $subscribed_details->userId,
                            'user_type_id'      => $subscribed_details->user_type_id,
                            'name'              => $subscribed_details->name,
                            'subscription_id'   => $subscribed_details->subscription_id,
                            'subscription_name' => $subscribed_details->subscription_name,
                            'price'             => $subscribed_details->price,
                            'start_date'        => $subscribed_details->start_date,
                            'end_date'          => $subscribed_details->end_date,
                            'coupon_code_id'    => $subscribed_details->coupon_code_id,
                            'coupon_code'       => $subscribed_details->coupon_code,
                            'purchased_price'   => $subscribed_details->purchased_price,
                            'transaction_id'    => $subscribed_details->transaction_id,
                            'order_id'          => $subscribed_details->order_id,
                            'gst'               => $gst, 
                            'sgst'              => $sgst,
                            'cgst'              => $cgst, 
                            'igst'              => $igst,
                            'invoice_no'        => $subscribed_details->invoice_no,
                            'status'            => $subscribed_details->status,
                        ];

                        
                        DB::commit();
                        $sms = sms::subscription_payment($subscribed_details->mobile, $data['name'], $data['subscription_name'], $data['transaction_id'], $data['invoice_no'], $data['purchased_price'], $data['end_date']);
                        DB::table('subscription_interest')->where(['user_id'=>$subscribed_details->id])->delete();

                        $output['response']   = true;
                        $output['message']    = 'subscribed Upgrade';
                        $output['data']       = $data;
                        $output['status']     = 200;
                        $output['error']      = "";
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    $output['response']  = false;
                    $output['message']   = 'No Data Available';
                    $output['data']      = [];
                    $output['status']    = 500;
                    $output['error']     = "";
                }
            }
        } else {
            $output['response']  = false;
            $output['message']   = 'This old subscribed id already used';
            $output['data']      = [];
            $output['status']    = 500;
            $output['error']     = "";
        }


        return $output;
    }

    /** Razor Payment Order-id Generate  */
    public function generate_order_id(Request $request)
    {
       
        //echo $request->all();
        $url = url('/');
        $key = '';
        $value = '';
       // dd($url);

        if($url=='http://127.0.0.1:8000'){
            $key = 'rzp_test_GwHRJMGrMgQai7';
            $value = 'xbg7aSNwyz7mOZz8yiVN6R2A';
        } else if ($url=='https://kv.businessenquiry.co.in') {
            $key = 'rzp_test_GwHRJMGrMgQai7';
            $value = 'xbg7aSNwyz7mOZz8yiVN6R2A';
        } else if ($url=='https://krishivikas.com') {
            $key = 'rzp_live_P8FSPnk2ZVE4Qc';
            $value = '5qaIEherXo0itGtx3WHdTmWj';
        } 

        $amount = $request->amount;
        $api = new Api($key, $value);
       // $api = new Api('rzp_live_P8FSPnk2ZVE4Qc', '5qaIEherXo0itGtx3WHdTmWj');

        $order = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100, 'currency' => 'INR'));
        $orderId = $order['id'];

        $output['response']   = true;
        $output['message']    = 'Order Id generated';
        $output['order_id']   = $orderId;
        $output['amount']     = $amount;
        $output['status']     = 200;
        $output['error']      = "";

        return $output;
    }

    # My Product Lead User List
    public function my_product_lead_user_list(Request $request)
    {


        $user_id = auth()->user()->id;


       // dd($user_id);

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
        //dd($end_date);
        $product_lead_details = MyLeadList::my_lead_product_list($user_id, $skip, $take, $start_date, $end_date);



       // dd($product_lead_details);

         $offline_lead_details = MyLeadList::my_lead_product_offline_list($user_id, $skip, $take, $start_date, $end_date);
       // dd($offline_lead_details);
        
        
         
        $uniqueData = [];

        if($product_lead_details != null){
            $seenIds = [];
            foreach ($product_lead_details as $item) {
                if (!in_array($item->seller_leads_user_id, $seenIds)) {
                    $uniqueData[] = $item;
                    $seenIds[] = $item->seller_leads_user_id;
                }
            }
        }


        $output = array();
        $countUniqueonlineLead = count($uniqueData);

        if($offline_lead_details === null && $countUniqueonlineLead ===0){
           $mergedArray = []; 
        } else if($offline_lead_details !== null && $countUniqueonlineLead ===0){
            $mergedArray = $offline_lead_details; 
        } else if($offline_lead_details === null && $countUniqueonlineLead>0){
            $mergedArray = $uniqueData; 
        } else if($offline_lead_details !== null && $countUniqueonlineLead>0){
            $mergedArray = array_merge($uniqueData, $offline_lead_details);
        } 

        if (!empty($mergedArray)) {
            $output['response'] = true;
            $output['message']  = 'My Product Lead user list';
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

    # My Banner Lead User List
    public function my_banner_lead_user_list(Request $request)
    {
        //dd($request->all());
        $user_id = auth()->user()->id;
        // dd($user_id);
        //$user_id = 40;
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
            // $date2=date_create($request->end_date);
            // $end_date = date_format($date2,"Y-m-d H:i:s");
            $end_date = $request->end_date;
            // dd($end_date);
        } else {
            $now = Carbon::now()->format("Y-m-d H:i:s");
            $end_date = $now;
        }


        $banner_lead_details  = MyLeadList::my_lead_banner_list($user_id, $skip, $take, $start_date, $end_date);
        //dd($banner_lead_details);
        if(!empty($banner_lead_details) && $banner_lead_details!==null){
        $uniqueData = [];
        $seenIds = [];
        foreach ($banner_lead_details as $item) {
            if (!in_array($item->banner_leads_user_id, $seenIds)) {
                $uniqueData[] = $item;
                $seenIds[] = $item->banner_leads_user_id;
            }
        }

       // dd($uniqueData);
        if (!empty($banner_lead_details)) {
            foreach ($uniqueData as $key => $banner) {

                $banner_lead_id = $banner->banner_leads_user_id;
                //dd($banner_lead_id);
               // print_r($banner_lead_id) ;


                $lead_user_details = DB::table('user as u')
                    ->select('u.*', 's.state_name', 'd.district_name', 'bn.created_at as seller_lead_created_at', 'bn.status as hot_lead_status')
                    ->leftJoin('state as s', 's.id', '=', 'u.state_id')
                    ->leftJoin('district as d', 'd.id', '=', 'u.district_id')
                    //->leftJoin('seller_leads as sell', 'sell.post_user_id', '=', 'u.id')
                    ->leftJoin('banner_leads as bn', 'bn.user_id', '=', 'u.id')
                    //->where('bn.user_id', $banner_lead_id)
                    ->where('bn.user_id', $banner_lead_id)
                    ->where('bn.banner_id', $banner->id)
                    ->first();
                   // print '<pre>';
                   // print_r($lead_user_details);

                   // echo $lead_user_details->toSql();

                $user_details = [
                    'lead_user_id' => $lead_user_details->id, 'lead_user_type_id' => $lead_user_details->user_type_id, 'lead_user_name' => $lead_user_details->name, 'hot_lead_status' => $lead_user_details->hot_lead_status,
                    'lead_user_mobile' => $lead_user_details->mobile, 'lead_user_company_name' => $lead_user_details->company_name, 'lead_user_gst_no' => $lead_user_details->gst_no,
                    'lead_user_zipcode' => $lead_user_details->zipcode, 'lead_user_status' => $lead_user_details->status, 'seller_lead_created_at' => $banner->banner_leads_created_at,
                    'state_name' => $lead_user_details->state_name, 'district_name' => $lead_user_details->district_name,
                ];
                // dd($lead_user_details);                    

                $data[$key] = [
                    'id' => $banner->id, 'subscription_id' => $banner->subscription_id, 'subscription_features_id' => $banner->subscription_features_id,
                    'subscribed_id' => $banner->subscribed_id, 'user_id' => $banner->user_id, 'campaign_name' => $banner->campaign_name, 'campaign_state' => $banner->campaign_state, 'campaign_banner' => $banner->campaign_banner,
                    'status' => $banner->status, 'created_at' => $banner->created_at, 'updated_at' => $banner->updated_at, 'price' => $banner->price, 'start_date' => $banner->start_date,
                    'end_date' => $banner->end_date, 'coupon_code_id' => $banner->coupon_code_id, 'coupon_code' => $banner->coupon_code, 'purchased_price' => $banner->purchased_price,
                    'transaction_id' => $banner->transaction_id, 'order_id' => $banner->order_id, 'invoice_no' => $banner->invoice_no, 'subscribtion_feature_name' => $banner->subscribtion_feature_name,
                    'days' => $banner->days, 'website' => $banner->website, 'mobile' => $banner->mobile, 'sub_category' => $banner->sub_category, 'listing' => $banner->listing,
                    'creatives' => $banner->creatives, 'no_of_state' => $banner->no_of_state, 'subscribtion_name' => $banner->subscribtion_name, 'discount_percentage' => $banner->discount_percentage,
                    'banner_leads_id' => $banner->banner_leads_id, 'banner_leads_user_id' => $banner->banner_leads_user_id, 'banner_leads_created_at' => $banner->banner_leads_created_at,  'user_name' => $banner->user_name,
                    'user_gst_no' => $banner->user_gst_no, 'user_company_name' => $banner->user_company_name, 'user_mobile' => $banner->user_mobile, 'lead_user_details' => $user_details
                ];
            }
        }
        //dd($data);

        $output = array();

        if (!empty($data)) {
            $output['response'] = true;
            $output['message']  = 'My Banner Lead User List';
            $output['data']     =  $data;
            $output['error']    = "";
        } else {
            $output['response'] = false;
            $output['message']  = 'No Data Available';
            $output['data']     = [];
            $output['error']    = "";
        }
    } else {
            $output['response'] = false;
            $output['message']  = 'No Data Available';
            $output['data']     = [];
            $output['error']    = "";
    }

        return $output;
    
    }

    # My Enquiry Category Product
    public function my_enquiry(Request $request)
    {
        $user_id = auth()->user()->id;

       // dd($user_id);

        if (!empty($request->category_id)) {
            $category_id = $request->category_id;
        } else {
            $category_id = 0;
        }
//dd($category_id);
        if (!empty($request->skip)) {
            $skip = $request->skip;
        } else {
            $skip = 0;
        }

        if (!empty($request->take)) {
            $take = $request->take;
        } else {
            $take = 10;
        }

        $my_enquiry_list  = MyLeadList::my_enquiry_product_list($user_id, $category_id, $skip, $take);

       // dd( $my_enquiry_list );
       // dd(count($my_enquiry_list));
        $uniqueData = [];
        $seenIds = [];
        $output = array();
        
        if($my_enquiry_list!==null && count($my_enquiry_list)>0){
            foreach ($my_enquiry_list as $item) {
                // Using 'id' as a unique identifier
                if ($user_id!=$item->user_id) {
                    if (!in_array($item->user_id, $seenIds)) {
                        $uniqueData[] = $item;
                        $seenIds[] = $item->user_id;
                    }
                }
            }
            $output['response'] = true;
            $output['message']  = 'My Enquiry Product List';
            $output['data']     =  $uniqueData;
            $output['error']    = "";
        } else {
            $output['response'] = false;
            $output['message']  = 'No Data Available';
            $output['data']     = [];
            $output['error']    = "";
        }

        return $output;
    }

    public function get_user_list(Request $request){
        $user_details = DB::table('user')->where('id',$request->id)->first();

        $data = array();
        $data['user_id'] = $user_details->user_id;
        $data['user_type_id ']  = $user_details->user_type_id;
        $data['role_id ']       = $user_details->role_id;
        $data['name']           = $user_details->name;
        $data['company_name']   = $user_details->company_name;
        $data['gst_no']         = $user_details->gst_no;
        $data['mobile']         = $user_details->mobile;
        $data['email']          = $user_details->email;
        $data['facebook_id']    = $user_details->facebook_id;
        $data['google_id']      = $user_details->google_id;
        $data['gender']         = $user_details->gender;
        $data['address']        = $user_details->address;
        $data['country_id']     = $user_details->country_id;
        $data['state_id']       = $user_details->state_id;
        $data['district_id']    = $user_details->district_id;

    }
}
