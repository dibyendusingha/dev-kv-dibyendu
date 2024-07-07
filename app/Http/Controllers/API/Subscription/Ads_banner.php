<?php

namespace App\Http\Controllers\API\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Models\subscription\AdsBanner;
use App\Models\Subscription\Subscription;
use App\Models\Subscription\SubscriptionFeatures;
use App\Models\Subscription\Subscribed;
use App\Models\Subscription\Coupon;
use App\Models\BannerLead;
use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\CategoryWishProductBoots;

use App\Models\sms;
use App\Jobs\banner_pending as JBP;


class Ads_banner extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        //dd($user_id);
        $subscriped_id          = $request->subscriped_id;
        $campaign_name          = $request->campaign_name;
        $campaign_banner        = $request->campaign_banner;
        $campaign_state         = $request->campaign_state;
        $campaign_category      = $request->campaign_category;

        $date = Carbon::now()->format('Y-m-d');

        $subscription_count = DB::table('subscribeds')->select(['subscription_id', 'subscription_feature_id'])->where(['id' => $subscriped_id])->where('end_date', '>', $date)->where('status', 1)->count();
        if ($subscription_count > 0) {
            $subscription_data = DB::table('subscribeds')->select(['subscription_id', 'subscription_feature_id'])->where(['id' => $subscriped_id])->where('status', 1)->first();
            $subscription_id = $subscription_data->subscription_id;
            $subscription_feature_id = $subscription_data->subscription_feature_id;

            $subscription_creatives = SubscriptionFeatures::where('id', $subscription_feature_id)->where('status', 1)->first()->creatives;

            $adsBanner_count = DB::table('ads_banners')->where('user_id', $user_id)->where('subscription_features_id', $subscription_feature_id)->whereIn('status', [0, 1, 2])->count();
            if ($adsBanner_count != $subscription_creatives) {
                $validator = Validator::make($request->all(), [
                    'campaign_banner' => 'required',
                    'subscriped_id'   => 'required',
                    'campaign_name'  => 'required'
                ]);
                if ($validator->fails()) {
                    $output['response'] = false;
                    $output['message'] = 'Validation error!';
                    $output['data'] = [];
                    $output['status_code'] = 401;
                    $output['error'] = $validator->errors();
                } else {
                    if ($image = $request->file('campaign_banner')) {
                        $image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('campaign_banner')->getClientOriginalName();
                        $ext = $request->file('campaign_banner')->getClientOriginalExtension();
                        $request->file('campaign_banner')->storeAs('public/sponser', $image);
                    }

                    $insert = DB::table('ads_banners')->insertGetId([
                        'subscription_id'          => $subscription_id,
                        'subscription_features_id' => $subscription_feature_id,
                        'subscribed_id'            => $subscriped_id,
                        'user_id'                  => $user_id,
                        'campaign_name'            => $campaign_name,
                        'campaign_banner'          => $image,
                        'campaign_state'           => $campaign_state,
                        'campaign_category'        => $campaign_category,
                        'status' => 0,
                        'created_at' => Carbon::now()
                    ]);
                    if ($insert) {
                        $data = DB::table('ads_banners as a')
                            ->select(
                                'a.id as ads_banner_id',
                                'a.subscription_id',
                                'd.name as subscription_name',
                                'a.subscription_features_id',
                                'c.name as subscription_features_name',
                                'c.days as subscription_features_days',
                                'a.subscribed_id',
                                'b.price',
                                'b.start_date',
                                'b.end_date',
                                'b.coupon_code_id',
                                'b.coupon_code',
                                'b.purchased_price',
                                'b.transaction_id',
                                'b.order_id',
                                'b.invoice_no',
                                'a.user_id',
                                'a.campaign_name',
                                'a.campaign_state',
                                'e.discount_type',
                                'e.discount_percentage',
                                'e.discount_flat',
                                DB::raw('GROUP_CONCAT(s.state_name) AS campaign_state_names'),
                                DB::raw("CONCAT('".env('IMAGE_PATH_SPONSER')."',a.campaign_banner) as campaign_banner_image")
                            )
                            ->leftJoin('subscribeds as b', 'b.id', '=', 'a.subscribed_id')
                            ->leftJoin('subscription_features as c', 'c.id', '=', 'a.subscription_features_id')
                            ->leftJoin('subscriptions as d', 'd.id', '=', 'a.subscription_id')
                            ->leftJoin('coupons as e', 'e.id', '=', 'b.coupon_code_id')
                            ->leftJoin('state as s', function ($join) {
                                //$join->on(DB::raw("find_in_set(s.id, a.campaign_state)">0));
                                $join->whereRaw("find_in_set(s.id, a.campaign_state)");
                            })
                            ->where(['a.id' => $insert])
                            ->groupBy(
                                'a.id',
                                'a.subscription_id',
                                'a.subscription_features_id',
                                'a.subscribed_id',
                                'a.user_id',
                                'a.campaign_name',
                                'b.price',
                                'b.start_date',
                                'b.end_date',
                                'b.coupon_code_id',
                                'b.coupon_code',
                                'b.purchased_price',
                                'b.transaction_id',
                                'b.order_id',
                                'b.invoice_no',
                                'b.status',
                                'c.name',
                                'c.days',
                                'c.website',
                                'c.mobile',
                                'c.sub_category',
                                'c.category',
                                'c.listing',
                                'c.creatives',
                                'c.state',
                                'd.name',
                                'e.discount_percentage',
                                'e.discount_percentage',
                                'e.discount_flat'
                            )
                            ->first();

                        //banner pending API run here
                        $sms = sms::pending_banner($data->ads_banner_id , $data->user_id );
                        //print_r($sms);
                        //dispatch(new JBP($data->user_id));
                        //JBP::dispatch($data->user_id);

                        $output['response'] = true;
                        $output['message'] = 'Banner Ads. Inserted Successfully';
                        $output['data'] = $data;
                        $output['status_code'] = 201;
                        $output['error'] = '';
                    } else {
                        $output['response'] = false;
                        $output['message'] = 'Failed';
                        $output['data'] = [];
                        $output['status_code'] = 500;
                        $output['error'] = 'Internal Server Error';
                    }
                }
            } else if ($adsBanner_count == $subscription_creatives) {
                $output['response'] = false;
                $output['message'] = 'You are not allowed Banner Post';
                $output['data'] = [];
                $output['status_code'] = 500;
                $output['error'] = 'Internal Server Error';
            }
        } else {
            $output['response'] = false;
            $output['message'] = 'Do Not Have Subscriptions';
            $output['data'] = [];
            $output['status_code'] = 500;
            $output['error'] = 'Internal Server Error';
        }

        return $output;
    }

    /** Get Banner List */
    public function get_banner_list()
    {
        $user_id = auth()->user()->id;
        $user_details = DB::table('user')->where('id', $user_id)->first();
        $zipcode = $user_details->zipcode;

        $city_count = DB::table('city')->where(['pincode' => $zipcode])->count();
        if ($city_count > 0) {
            $pindata  = DB::table('city')->where(['pincode' => $zipcode])->first();
            $state_id = $pindata->state_id;

            $state_details = DB::table('state')->where(['id' => $state_id])->first();
            $state_name    = $state_details->id;
            $state_id_str  = strval($state_name);

            $output = [];
            $data  = array();

            $sql = DB::table('ads_banners')->whereRaw('FIND_IN_SET(?, campaign_state)', [$state_id_str])->where('status', 1);
            $all_banner_list = $sql->get();
            $banner_count    = $sql->count();

            if ($banner_count > 0) {
                foreach ($all_banner_list as $key => $ban) {
                    $user_count    = DB::table('user')->where('id', $ban->user_id)->count();
                    if ($user_count > 0) {
                        $user_details    = DB::table('user')->where('id', $ban->user_id)->first();
                        $user_type_id    = $user_details->user_type_id;
                        $role_id         = $user_details->role_id;
                        $name            = $user_details->name;
                        $company_name    = $user_details->company_name;
                        $mobile          = $user_details->mobile;
                        $email           = $user_details->email;
                        $gender          = $user_details->gender;
                        $address         = $user_details->address;
                        $pincode         = $user_details->zipcode;
                        $device_id       = $user_details->device_id;
                        $firebase_token  = $user_details->firebase_token;
                        $created_at_user = date("d-m-Y", strtotime($user_details->created_at));
                        if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                            $photo = '';
                        } else {
                            $photo = asset('storage/photo/' . $user_details->photo);
                        }
                    }

                    $banner_img =  asset('storage/sponser/' . $ban->campaign_banner);

                    $subscription_details = Subscription::where('id', $ban->subscription_id)->first();
                    $subscription_name    = $subscription_details->name;

                    $subscribed_details = Subscribed::where('id', $ban->subscribed_id)->first();

                    $data[$key] = [
                        'banner_id' => $ban->id, 'subscription_id' => $ban->subscription_id, 'subscription_name' => $subscription_name, 'subscription_features_id' => $ban->subscription_features_id, 'subscribed_id' => $ban->subscribed_id,
                        'start_date' => $subscribed_details->start_date, 'end_date' => $subscribed_details->end_date,
                        'user_id' => $ban->user_id,
                        'user_type_id' => $user_type_id, 'role_id' => $role_id, 'name' => $name, 'company_name' => $company_name,
                        'mobile' => $mobile, 'email' => $email, 'gender' => $gender, 'address' => $address, 'pincode' => $pincode, 'device_id' => $device_id,
                        'firebase_token' => $firebase_token, 'created_at' => $created_at_user, 'photo' => $photo,
                        'campaign_banner' => $banner_img, 'campaign_state' => $ban->campaign_state , 'campaign_category' => $ban->campaign_category
                    ];
                }
            } else {
                $data = [];
            }

            if (!empty($data)) {
                $output['response']  = true;
                $output['message']   = 'Banner List';
                $output['data']      = $data;
                $output['error']     = "";

                return $output;
            } else {
                $output['response']  = true;
                $output['message']   = 'No Data Available';
                $output['data']      = [];

                return $output;
            }
        }
    }

    public function state_name_get()
    {
        $dataString = "1";
        $dataArray = explode(",", $dataString);

        foreach ($dataArray as $key => $value) {
            echo $value . "\n";

            $state_details = DB::table('state')->where('id', $value)->first();

            $data[] = $state_details->state_name;
        }
        // print_r($data);

        $data1 = implode(",", $data);
       // print_r($data1);

    }

    /** Banner Position */
    public function bannerPosition(Request $request)
    {
        $banner_list = [];
        $company_product = [];
        $output = [];
        $category_id = $request->category_id;

        if (!empty($category_id)) {
            $category_id = $request->category_id;

            $banner_list =  DB::table('ads_banners')->where('status', 1)->get();
            $b_count     =  DB::table('ads_banners')->where('status', 1)->count();

            $company_product = DB::table('company_product')->where('category_id', $category_id)->where('status', 1)->get();
            $c_count = DB::table('company_product')->where('category_id', $category_id)->where('status', 1)->count();

            $subscribed_boost_count = DB::table('subscribed_boosts')->where('category_id', $category_id)->where('status', 1)->count();

            $data = [];

            if ($b_count > 0 && $c_count > 0 && $subscribed_boost_count > 0) {
                foreach ($company_product as $key => $company) {
                    foreach ($banner_list as $key1 => $ban) {

                        $banner_img    = asset('storage/sponser/' . $ban->campaign_banner);
                        $product_image = asset('storage/company/' . $company->product_image);

                        $user_count  = DB::table('user')->where(['id' => $ban->user_id])->count();
                        if ($user_count > 0) {
                            $user_details  = DB::table('user')->where(['id' => $ban->user_id])->first();
                            if(!empty($user_details->name)){
                                $name          = $user_details->name;
                            }else{
                                $name = null;
                            }

                            if(!empty($user_details->company_name)){
                                $company_name  = $user_details->company_name;
                            }else{
                                $company_name = null;
                            }

                            if(!empty($user_details->mobile)){
                                $mobile        = $user_details->mobile;
                            }else{
                                $mobile = null;
                            }

                            if(!empty($user_details->email)){
                                $email         = $user_details->email;
                            }else{
                                $email = null;
                            }
                            
                        }else{
                            $name = null;
                            $company_name = null;
                            $mobile = null;
                            $email = null;
                        }
    

                        $id              = $company->id;
                        $category_id     = $company->category_id;
                        $product_name    = $company->product_name;
                        $description     = $company->description;
                        $price           = $company->price;
                        $status          = $company->status;
                        $type            = $company->type;
                        $subtype         = $company->subtype;
                        $company_id      = $company->company_id;
                        $main_company_id = DB::table('company')->where(['id' => $company_id])->value('company_id');

                        $company_logo = asset('storage/company/' . DB::table('company')->where(['id' => $company_id])->value('logo'));
                        if ($company_id == 1 || $company_id == 11 || $company_id == 12) {
                            $product_image = asset('storage/iffco/products/' . $company->product_image);
                        } else {
                            $product_image = asset('storage/company/products/' . $company->product_image);
                        }

                        $data1[$key1] = [
                            'id' => $ban->id, 'banner_image' => $banner_img, 'user_id' => $ban->user_id, 'name' => $name,
                            'company_name' => $company_name, 'mobile' => $mobile, 'email' => $email, 'status' => $ban->status
                        ];

                        $data2[$key] = [
                            'id' => $id, 'category_id' => $category_id, 'product_image' => $product_image, 'product_name' => $product_name, 'description' => $description, 'price' => $price, 'type' => $type, 'subtype' => $subtype,
                            'main_company_id' => $main_company_id, 'company_id' => $company_id, 'company_logo' => $company_logo
                        ];

                        $data3 = CategoryWishProductBoots::category_wish_product_list($category_id);


                        /** 0 To 3 index Value */
                        if (!empty(array_slice($data1, 0, 3))) {
                            $data['1']['ad_type_id'] = 1;
                            $data['1']['data'] = array_slice($data1, 0, 3);
                        }
                        if (!empty(array_slice($data2, 0, 1))) {
                            $data['2']['ad_type_id'] = 2;
                            $data['2']['data'] = array_slice($data2, 0, 1);
                        }
                        if (!empty(array_slice($data2, 1, 1))) {
                            $data['3']['ad_type_id'] = 2;
                            $data['3']['data'] = array_slice($data2, 1, 1);
                        }
                        if (!empty(array_slice($data3, 0, 5))) {
                            $data['4']['ad_type_id'] = 3;
                            $data['4']['data'] = array_slice($data3, 0, 5);
                        }

                        /** 4 To 7 index Value  */
                        if (!empty(array_slice($data1, 3, 3))) {
                            $data['5']['ad_type_id'] = 1;
                            $data['5']['data']  = array_slice($data1, 3, 3);
                        }
                        if (!empty(array_slice($data2, 3, 1))) {
                            $data['6']['ad_type_id'] = 2;
                            $data['6']['data'] = array_slice($data2, 3, 1);
                        }
                        if (!empty(array_slice($data2, 4, 1))) {
                            $data['7']['ad_type_id'] = 2;
                            $data['7']['data'] = array_slice($data2, 4, 1);
                        }
                        if (!empty(array_slice($data3, 6, 10))) {
                            $data['8']['ad_type_id'] = 3;
                            $data['8']['data'] = array_slice($data3, 6, 10);
                        }

                        /** 8 To 11 index Value  */
                        if (!empty(array_slice($data1, 6, 3))) {
                            $data['9']['ad_type_id'] = 1;
                            $data['9']['data'] = array_slice($data1, 6, 3);
                        }
                        if (!empty(array_slice($data2, 6, 1))) {
                            $data['10']['ad_type_id'] = 2;
                            $data['10']['data'] = array_slice($data2, 6, 1);
                        }
                        if (!empty(array_slice($data2, 7, 1))) {
                            $data['11']['ad_type_id'] = 2;
                            $data['11']['data'] = array_slice($data2, 7, 1);
                        }
                        if (!empty(array_slice($data3, 11, 15))) {
                            $data['12']['ad_type_id'] = 3;
                            $data['12']['data'] = array_slice($data3, 11, 15);
                        }

                        /** 12 To 15 index Value  */
                        if (!empty(array_slice($data1, 9, 3))) {
                            $data['13']['ad_type_id'] = 1;
                            $data['13']['data'] = array_slice($data1, 9, 3);
                        }
                        if (!empty(array_slice($data2, 9, 1))) {
                            $data['14']['ad_type_id'] = 2;
                            $data['14']['data'] = array_slice($data2, 9, 1);
                        }
                        if (!empty(array_slice($data2, 10, 1))) {
                            $data['15']['ad_type_id'] = 2;
                            $data['15']['data'] = array_slice($data2, 10, 1);
                        }
                        if (!empty(array_slice($data3, 16, 20))) {
                            $data['16']['ad_type_id'] = 3;
                            $data['16']['data'] = array_slice($data3, 16, 20);
                        }

                        /** 16 To 19 index Value  */
                        if (!empty(array_slice($data1, 12, 3))) {
                            $data['17']['ad_type_id'] = 1;
                            $data['17']['data'] = array_slice($data1, 12, 3);
                        }
                        if (!empty(array_slice($data2, 12, 1))) {
                            $data['18']['ad_type_id'] = 2;
                            $data['18']['data'] = array_slice($data2, 12, 1);
                        }
                        if (!empty(array_slice($data2, 13, 1))) {
                            $data['19']['ad_type_id'] = 2;
                            $data['19']['data'] = array_slice($data2, 13, 1);
                        }
                        if (!empty(array_slice($data3, 21, 25))) {
                            $data['20']['ad_type_id'] = 3;
                            $data['20']['data'] = array_slice($data3, 21, 25);
                        }

                        /** 20  index Value  */
                        if (!empty(array_slice($data1, 15, 3))) {
                            $data['21']['ad_type_id'] = 1;
                            $data['21']['data'] = array_slice($data1, 15, 3);
                        }
                        // }
                    }
                }
            } else if ($b_count == 0 && $c_count > 0 && $subscribed_boost_count > 0) {
                foreach ($company_product as $key => $company) {

                    $id              = $company->id;
                    $category_id     = $company->category_id;
                    $product_name    = $company->product_name;
                    $description     = $company->description;
                    $price           = $company->price;
                    $status          = $company->status;
                    $type            = $company->type;
                    $subtype         = $company->subtype;
                    $company_id      = $company->company_id;
                    $main_company_id = DB::table('company')->where(['id' => $company_id])->value('company_id');

                    $company_logo = asset('storage/company/' . DB::table('company')->where(['id' => $company_id])->value('logo'));
                    if ($company_id == 1 || $company_id == 11 || $company_id == 12) {
                        $product_image = asset('storage/iffco/products/' . $company->product_image);
                    } else {
                        $product_image = asset('storage/company/products/' . $company->product_image);
                    }

                    $data2[$key] = [
                        'id' => $company->id, 'category_id' => $company->category_id, 'product_image' => $product_image, 'product_name' => $company->product_name,
                        'description' => $company->description, 'price' => $company->price, 'status' => $company->status, 'type' => $company->type, 'subtype' => $company->subtype,
                        'company_id' => $company->company_id
                    ];

                    $data3 = CategoryWishProductBoots::category_wish_product_list($category_id);

                    /** 0 To 3 index Value */
                    if (!empty(array_slice($data2, 0, 1))) {
                        $data['2']['ad_type_id'] = 2;
                        $data['2']['data'] = array_slice($data2, 0, 1);
                    }
                    if (!empty(array_slice($data2, 1, 1))) {
                        $data['3']['ad_type_id'] = 2;
                        $data['3']['data'] = array_slice($data2, 1, 1);
                    }
                    if (!empty(array_slice($data3, 0, 5))) {
                        $data['4']['ad_type_id'] = 3;
                        $data['4']['data'] = array_slice($data3, 0, 5);
                    }

                    /** 4 To 7 index Value  */
                    if (!empty(array_slice($data2, 3, 1))) {
                        $data['6']['ad_type_id'] = 2;
                        $data['6']['data'] = array_slice($data2, 3, 1);
                    }
                    if (!empty(array_slice($data2, 4, 1))) {
                        $data['7']['ad_type_id'] = 2;
                        $data['7']['data'] = array_slice($data2, 4, 1);
                    }
                    if (!empty(array_slice($data3, 6, 10))) {
                        $data['8']['ad_type_id'] = 3;
                        $data['8']['data'] = array_slice($data3, 6, 10);
                    }

                    /** 8 To 11 index Value  */
                    if (!empty(array_slice($data2, 6, 1))) {
                        $data['10']['ad_type_id'] = 2;
                        $data['10']['data'] = array_slice($data2, 6, 1);
                    }
                    if (!empty(array_slice($data2, 7, 1))) {
                        $data['11']['ad_type_id'] = 2;
                        $data['11']['data'] = array_slice($data2, 7, 1);
                    }
                    if (!empty(array_slice($data3, 11, 15))) {
                        $data['12']['ad_type_id'] = 3;
                        $data['12']['data'] = array_slice($data3, 11, 15);
                    }

                    /** 12 To 15 index Value  */
                    if (!empty(array_slice($data2, 9, 1))) {
                        $data['14']['ad_type_id'] = 2;
                        $data['14']['data'] = array_slice($data2, 9, 1);
                    }
                    if (!empty(array_slice($data2, 10, 1))) {
                        $data['15']['ad_type_id'] = 2;
                        $data['15']['data'] = array_slice($data2, 10, 1);
                    }
                    if (!empty(array_slice($data3, 16, 20))) {
                        $data['16']['ad_type_id'] = 3;
                        $data['16']['data'] = array_slice($data3, 16, 20);
                    }

                    /** 16 To 19 index Value  */
                    if (!empty(array_slice($data2, 12, 1))) {
                        $data['18']['ad_type_id'] = 2;
                        $data['18']['data'] = array_slice($data2, 12, 1);
                    }
                    if (!empty(array_slice($data2, 13, 1))) {
                        $data['19']['ad_type_id'] = 2;
                        $data['19']['data'] = array_slice($data2, 13, 1);
                    }
                    if (!empty(array_slice($data3, 21, 25))) {
                        $data['20']['ad_type_id'] = 3;
                        $data['20']['data'] = array_slice($data3, 21, 25);
                    }
                }
            } else if ($b_count > 0 && $c_count == 0 && $subscribed_boost_count > 0) {
                foreach ($banner_list as $key1 => $ban) {
                    $banner_img = asset('storage/sponser/' . $ban->campaign_banner);

                    $user_count  = DB::table('user')->where(['id' => $ban->user_id])->count();
                    if ($user_count > 0) {
                        $user_details  = DB::table('user')->where(['id' => $ban->user_id])->first();
                        if(!empty($user_details->name)){
                            $name          = $user_details->name;
                        }else{
                            $name = null;
                        }

                        if(!empty($user_details->company_name)){
                            $company_name  = $user_details->company_name;
                        }else{
                            $company_name = null;
                        }

                        if(!empty($user_details->mobile)){
                            $mobile        = $user_details->mobile;
                        }else{
                            $mobile = null;
                        }

                        if(!empty($user_details->email)){
                            $email         = $user_details->email;
                        }else{
                            $email = null;
                        }
                    }else{
                        $name = null;
                        $company_name = null;
                        $mobile = null;
                        $email = null;
                    }



                    $data1[$key1] = [
                        'id' => $ban->id, 'banner_image' => $banner_img, 'user_id' => $ban->user_id, 'name' => $name,
                        'company_name' => $company_name, 'mobile' => $mobile, 'email' => $email, 'status' => $ban->status
                    ];

                    $data3 = CategoryWishProductBoots::category_wish_product_list($category_id);

                    /** 0 To 3 index Value */
                    if (!empty(array_slice($data1, 0, 3))) {
                        $data['1']['ad_type_id'] = 1;
                        $data['1']['data'] = array_slice($data1, 0, 3);
                    }
                    if (!empty(array_slice($data3, 0, 5))) {
                        $data['4']['ad_type_id'] = 3;
                        $data['4']['data'] = array_slice($data3, 0, 5);
                    }

                    /** 4 To 7 index Value  */
                    if (!empty(array_slice($data1, 3, 3))) {
                        $data['5']['ad_type_id'] = 1;
                        $data['5']['data']  = array_slice($data1, 3, 3);
                    }
                    if (!empty(array_slice($data3, 6, 10))) {
                        $data['8']['ad_type_id'] = 3;
                        $data['8']['data'] = array_slice($data3, 6, 10);
                    }


                    /** 8 To 11 index Value  */
                    if (!empty(array_slice($data1, 6, 3))) {
                        $data['9']['ad_type_id'] = 1;
                        $data['9']['data']  = array_slice($data1, 6, 3);
                    }
                    if (!empty(array_slice($data3, 11, 15))) {
                        $data['12']['ad_type_id'] = 3;
                        $data['12']['data'] = array_slice($data3, 11, 15);
                    }


                    /** 12 To 15 index Value  */
                    if (!empty(array_slice($data1, 9, 3))) {
                        $data['13']['ad_type_id'] = 1;
                        $data['13']['data'] = array_slice($data1, 9, 3);
                    }
                    if (!empty(array_slice($data3, 16, 20))) {
                        $data['16']['ad_type_id'] = 3;
                        $data['16']['data'] = array_slice($data3, 16, 20);
                    }


                    /** 16 To 19 index Value  */
                    if (!empty(array_slice($data1, 12, 3))) {
                        $data['17']['ad_type_id'] = 1;
                        $data['17']['data'] = array_slice($data1, 12, 3);
                    }
                    if (!empty(array_slice($data3, 21, 25))) {
                        $data['20']['ad_type_id'] = 3;
                        $data['20']['data'] = array_slice($data3, 21, 25);
                    }


                    /** 20  index Value  */
                    if (!empty(array_slice($data1, 15, 3))) {
                        $data['21']['ad_type_id'] = 1;
                        $data['21']['data'] = array_slice($data1, 15, 3);
                    }
                }
            } else if ($b_count == 0 && $c_count == 0 && $subscribed_boost_count > 0) {

                $data3 = CategoryWishProductBoots::category_wish_product_list($category_id);

                /** 0 To 3 index Value */
                if (!empty(array_slice($data3, 0, 5))) {
                    $data['4']['ad_type_id'] = 3;
                    $data['4']['data'] = array_slice($data3, 0, 5);
                }

                /** 4 To 7 index Value  */
                if (!empty(array_slice($data3, 6, 10))) {
                    $data['8']['ad_type_id'] = 3;
                    $data['8']['data'] = array_slice($data3, 6, 10);
                }

                /** 8 To 11 index Value  */
                if (!empty(array_slice($data3, 11, 15))) {
                    $data['12']['ad_type_id'] = 3;
                    $data['12']['data'] = array_slice($data3, 11, 15);
                }

                /** 12 To 15 index Value  */
                if (!empty(array_slice($data3, 16, 20))) {
                    $data['16']['ad_type_id'] = 3;
                    $data['16']['data'] = array_slice($data3, 16, 20);
                }

                /** 16 To 19 index Value  */
                if (!empty(array_slice($data3, 21, 25))) {
                    $data['20']['ad_type_id'] = 3;
                    $data['20']['data'] = array_slice($data3, 21, 25);
                }
            } else if ($b_count == 0 && $c_count > 0 && $subscribed_boost_count == 0) {
                foreach ($company_product as $key => $company) {

                    $id              = $company->id;
                    $category_id     = $company->category_id;
                    $product_name    = $company->product_name;
                    $description     = $company->description;
                    $price           = $company->price;
                    $status          = $company->status;
                    $type            = $company->type;
                    $subtype         = $company->subtype;
                    $company_id      = $company->company_id;
                    $main_company_id = DB::table('company')->where(['id' => $company_id])->value('company_id');

                    $company_logo = asset('storage/company/' . DB::table('company')->where(['id' => $company_id])->value('logo'));
                    if ($company_id == 1 || $company_id == 11 || $company_id == 12) {
                        $product_image = asset('storage/iffco/products/' . $company->product_image);
                    } else {
                        $product_image = asset('storage/company/products/' . $company->product_image);
                    }

                    // $data2[$key] = ['id'=>$id,'category_id'=>$category_id,'product_image'=>$product_image,'product_name'=>$product_name,'description'=>$description,'price'=>$price,'type'=>$type,'subtype'=>$subtype,
                    // 'main_company_id'=>$main_company_id,'company_id'=>$company_id,'company_logo'=>$company_logo];

                    // $product_image = asset('storage/company/'.$company->campaign_banner);

                    $data2[$key] = [
                        'id' => $company->id, 'category_id' => $company->category_id, 'product_image' => $product_image, 'product_name' => $company->product_name,
                        'description' => $company->description, 'price' => $company->price, 'status' => $company->status, 'type' => $company->type, 'subtype' => $company->subtype,
                        'company_id' => $company->company_id
                    ];

                    /** 0 To 3 index Value */
                    if (!empty(array_slice($data2, 0, 1))) {
                        $data['2']['ad_type_id'] = 2;
                        $data['2']['data'] = array_slice($data2, 0, 1);
                    }
                    if (!empty(array_slice($data2, 1, 1))) {
                        $data['3']['ad_type_id'] = 2;
                        $data['3']['data'] = array_slice($data2, 1, 1);
                    }
                    if (!empty(array_slice($data2, 2, 1))) {
                        $data['4']['ad_type_id'] = 2;
                        $data['4']['data'] = array_slice($data2, 2, 1);
                    }

                    /** 4 To 7 index Value  */
                    if (!empty(array_slice($data2, 3, 1))) {
                        $data['6']['ad_type_id'] = 2;
                        $data['6']['data'] = array_slice($data2, 3, 1);
                    }
                    if (!empty(array_slice($data2, 4, 1))) {
                        $data['7']['ad_type_id'] = 2;
                        $data['7']['data'] = array_slice($data2, 4, 1);
                    }
                    if (!empty(array_slice($data2, 5, 1))) {
                        $data['8']['ad_type_id'] = 2;
                        $data['8']['data'] = array_slice($data2, 5, 1);
                    }

                    /** 8 To 11 index Value  */
                    if (!empty(array_slice($data2, 6, 1))) {
                        $data['10']['ad_type_id'] = 2;
                        $data['10']['data'] = array_slice($data2, 6, 1);
                    }
                    if (!empty(array_slice($data2, 7, 1))) {
                        $data['11']['ad_type_id'] = 2;
                        $data['11']['data'] = array_slice($data2, 7, 1);
                    }
                    if (!empty(array_slice($data2, 8, 1))) {
                        $data['12']['ad_type_id'] = 2;
                        $data['12']['data'] = array_slice($data2, 8, 1);
                    }

                    /** 12 To 15 index Value  */
                    if (!empty(array_slice($data2, 9, 1))) {
                        $data['14']['ad_type_id'] = 2;
                        $data['14']['data'] = array_slice($data2, 9, 1);
                    }
                    if (!empty(array_slice($data2, 10, 1))) {
                        $data['15']['ad_type_id'] = 2;
                        $data['15']['data'] = array_slice($data2, 10, 1);
                    }
                    if (!empty(array_slice($data2, 11, 1))) {
                        $data['16']['ad_type_id'] = 2;
                        $data['16']['data'] = array_slice($data2, 11, 1);
                    }

                    /** 16 To 19 index Value  */
                    if (!empty(array_slice($data2, 12, 1))) {
                        $data['18']['ad_type_id'] = 2;
                        $data['18']['data'] = array_slice($data2, 12, 1);
                    }
                    if (!empty(array_slice($data2, 13, 1))) {
                        $data['19']['ad_type_id'] = 2;
                        $data['19']['data'] = array_slice($data2, 13, 1);
                    }
                    if (!empty(array_slice($data2, 14, 1))) {
                        $data['20']['ad_type_id'] = 2;
                        $data['20']['data'] = array_slice($data2, 14, 1);
                    }
                }
            } else if ($b_count > 0 && $c_count == 0 && $subscribed_boost_count == 0) {
                foreach ($banner_list as $key1 => $ban) {
                    $banner_img = asset('storage/sponser/' . $ban->campaign_banner);

                    $user_count  = DB::table('user')->where(['id' => $ban->user_id])->count();
                    if ($user_count > 0) {
                        $user_details  = DB::table('user')->where(['id' => $ban->user_id])->first();
                        if(!empty($user_details->name)){
                            $name          = $user_details->name;
                        }else{
                            $name = null;
                        }

                        if(!empty($user_details->company_name)){
                            $company_name  = $user_details->company_name;
                        }else{
                            $company_name = null;
                        }

                        if(!empty($user_details->mobile)){
                            $mobile        = $user_details->mobile;
                        }else{
                            $mobile = null;
                        }

                        if(!empty($user_details->email)){
                            $email         = $user_details->email;
                        }else{
                            $email = null;
                        }
                    }else{
                        $name = null;
                        $company_name = null;
                        $mobile = null;
                        $email = null;
                    }


                    $data1[$key1] = [
                        'id' => $ban->id, 'banner_image' => $banner_img, 'user_id' => $ban->user_id, 'name' => $name,
                        'company_name' => $company_name, 'mobile' => $mobile, 'email' => $email, 'status' => $ban->status
                    ];

                    /** 0 To 3 index Value */
                    if (!empty(array_slice($data1, 0, 3))) {
                        $data['1']['ad_type_id'] = 1;
                        $data['1']['data'] = array_slice($data1, 0, 3);
                    }
                    /** 4 To 7 index Value  */
                    if (!empty(array_slice($data1, 3, 3))) {
                        $data['5']['ad_type_id'] = 1;
                        $data['5']['data']  = array_slice($data1, 3, 3);
                    }
                    /** 8 To 11 index Value  */
                    if (!empty(array_slice($data1, 6, 3))) {
                        $data['9']['ad_type_id'] = 1;
                        $data['9']['data']  = array_slice($data1, 6, 3);
                    }
                    /** 12 To 15 index Value  */
                    if (!empty(array_slice($data1, 9, 3))) {
                        $data['13']['ad_type_id'] = 1;
                        $data['13']['data'] = array_slice($data1, 9, 3);
                    }
                    /** 16 To 19 index Value  */
                    if (!empty(array_slice($data1, 12, 3))) {
                        $data['17']['ad_type_id'] = 1;
                        $data['17']['data'] = array_slice($data1, 12, 3);
                    }
                    /** 20  index Value  */
                    if (!empty(array_slice($data1, 15, 3))) {
                        $data['21']['ad_type_id'] = 1;
                        $data['21']['data'] = array_slice($data1, 15, 3);
                    }
                }
            }
            else if ($b_count > 0 && $c_count > 0 && $subscribed_boost_count == 0) {
                foreach ($company_product as $key => $company) {
                    foreach ($banner_list as $key1 => $ban) {
                        // foreach($subscription_boost_product_details as $key2=> $boots){

                        $banner_img    = asset('storage/sponser/' . $ban->campaign_banner);
                        $product_image = asset('storage/company/' . $company->product_image);


                        $user_count  = DB::table('user')->where(['id' => $ban->user_id])->count();
                        if ($user_count > 0) {
                            $user_details  = DB::table('user')->where(['id' => $ban->user_id])->first();
                            if(!empty($user_details->name)){
                                $name          = $user_details->name;
                            }else{
                                $name = null;
                            }

                            if(!empty($user_details->company_name)){
                                $company_name  = $user_details->company_name;
                            }else{
                                $company_name = null;
                            }

                            if(!empty($user_details->mobile)){
                                $mobile        = $user_details->mobile;
                            }else{
                                $mobile = null;
                            }

                            if(!empty($user_details->email)){
                                $email         = $user_details->email;
                            }else{
                                $email = null;
                            }
                            
                        }else{
                            $name = null;
                            $company_name = null;
                            $mobile = null;
                            $email = null;
                        }
    

                        $id              = $company->id;
                        $category_id     = $company->category_id;
                        $product_name    = $company->product_name;
                        $description     = $company->description;
                        $price           = $company->price;
                        $status          = $company->status;
                        $type            = $company->type;
                        $subtype         = $company->subtype;
                        $company_id      = $company->company_id;
                        $main_company_id = DB::table('company')->where(['id' => $company_id])->value('company_id');

                        $company_logo = asset('storage/company/' . DB::table('company')->where(['id' => $company_id])->value('logo'));
                        if ($company_id == 1 || $company_id == 11 || $company_id == 12) {
                            $product_image = asset('storage/iffco/products/' . $company->product_image);
                        } else {
                            $product_image = asset('storage/company/products/' . $company->product_image);
                        }

                        $data1[$key1] = [
                            'id' => $ban->id, 'banner_image' => $banner_img, 'user_id' => $ban->user_id, 'name' => $name,
                            'company_name' => $company_name, 'mobile' => $mobile, 'email' => $email, 'status' => $ban->status
                        ];

                        $data2[$key] = [
                            'id' => $id, 'category_id' => $category_id, 'product_image' => $product_image, 'product_name' => $product_name, 'description' => $description, 'price' => $price, 'type' => $type, 'subtype' => $subtype,
                            'main_company_id' => $main_company_id, 'company_id' => $company_id, 'company_logo' => $company_logo
                        ];

                        // $data3 = CategoryWishProductBoots::category_wish_product_list($category_id);


                        /** 0 To 3 index Value */
                        if (!empty(array_slice($data1, 0, 3))) {
                            $data['1']['ad_type_id'] = 1;
                            $data['1']['data'] = array_slice($data1, 0, 3);
                        }
                        if (!empty(array_slice($data2, 0, 1))) {
                            $data['2']['ad_type_id'] = 2;
                            $data['2']['data'] = array_slice($data2, 0, 1);
                        }
                        if (!empty(array_slice($data2, 1, 1))) {
                            $data['3']['ad_type_id'] = 2;
                            $data['3']['data'] = array_slice($data2, 1, 1);
                        }
                        // if (!empty(array_slice($data3, 0, 5))) {
                        //     $data['4']['ad_type_id'] = 3;
                        //     $data['4']['data'] = array_slice($data3, 0, 5);
                        // }

                        /** 4 To 7 index Value  */
                        if (!empty(array_slice($data1, 3, 3))) {
                            $data['5']['ad_type_id'] = 1;
                            $data['5']['data']  = array_slice($data1, 3, 3);
                        }
                        if (!empty(array_slice($data2, 3, 1))) {
                            $data['6']['ad_type_id'] = 2;
                            $data['6']['data'] = array_slice($data2, 3, 1);
                        }
                        if (!empty(array_slice($data2, 4, 1))) {
                            $data['7']['ad_type_id'] = 2;
                            $data['7']['data'] = array_slice($data2, 4, 1);
                        }
                        // if (!empty(array_slice($data3, 6, 10))) {
                        //     $data['8']['ad_type_id'] = 3;
                        //     $data['8']['data'] = array_slice($data3, 6, 10);
                        // }

                        /** 8 To 11 index Value  */
                        if (!empty(array_slice($data1, 6, 3))) {
                            $data['9']['ad_type_id'] = 1;
                            $data['9']['data'] = array_slice($data1, 6, 3);
                        }
                        if (!empty(array_slice($data2, 6, 1))) {
                            $data['10']['ad_type_id'] = 2;
                            $data['10']['data'] = array_slice($data2, 6, 1);
                        }
                        if (!empty(array_slice($data2, 7, 1))) {
                            $data['11']['ad_type_id'] = 2;
                            $data['11']['data'] = array_slice($data2, 7, 1);
                        }
                        // if (!empty(array_slice($data3, 11, 15))) {
                        //     $data['12']['ad_type_id'] = 3;
                        //     $data['12']['data'] = array_slice($data3, 11, 15);
                        // }

                        /** 12 To 15 index Value  */
                        if (!empty(array_slice($data1, 9, 3))) {
                            $data['13']['ad_type_id'] = 1;
                            $data['13']['data'] = array_slice($data1, 9, 3);
                        }
                        if (!empty(array_slice($data2, 9, 1))) {
                            $data['14']['ad_type_id'] = 2;
                            $data['14']['data'] = array_slice($data2, 9, 1);
                        }
                        if (!empty(array_slice($data2, 10, 1))) {
                            $data['15']['ad_type_id'] = 2;
                            $data['15']['data'] = array_slice($data2, 10, 1);
                        }
                        // if (!empty(array_slice($data3, 16, 20))) {
                        //     $data['16']['ad_type_id'] = 3;
                        //     $data['16']['data'] = array_slice($data3, 16, 20);
                        // }

                        /** 16 To 19 index Value  */
                        if (!empty(array_slice($data1, 12, 3))) {
                            $data['17']['ad_type_id'] = 1;
                            $data['17']['data'] = array_slice($data1, 12, 3);
                        }
                        if (!empty(array_slice($data2, 12, 1))) {
                            $data['18']['ad_type_id'] = 2;
                            $data['18']['data'] = array_slice($data2, 12, 1);
                        }
                        if (!empty(array_slice($data2, 13, 1))) {
                            $data['19']['ad_type_id'] = 2;
                            $data['19']['data'] = array_slice($data2, 13, 1);
                        }
                        // if (!empty(array_slice($data3, 21, 25))) {
                        //     $data['20']['ad_type_id'] = 3;
                        //     $data['20']['data'] = array_slice($data3, 21, 25);
                        // }

                        /** 20  index Value  */
                        if (!empty(array_slice($data1, 15, 3))) {
                            $data['21']['ad_type_id'] = 1;
                            $data['21']['data'] = array_slice($data1, 15, 3);
                        }
                        // }
                    }
                }
            }
            



            if (!empty($data)) {
                $output['response'] = true;
                $output['message']         = 'Banner Positions';
                $output['Banner_count']    = $b_count;
                $output['company_counrt']  = $c_count;
                $output['boost_counrt']    = $subscribed_boost_count;
                $output['data']            = $data;
                $output['error']           = "";
            } else {
                $output['response'] = false;
                $output['message']  = 'No Data Available';
                $output['data']     = [];
            }

            return $output;
        } else {
            return ['message' => 'Please Select Category Id', 'data' => []];
        }
    }

    /** Banner Lead */
    public function banner_lead(Request $request)
    {
        $output = [];
        $banner_id = $request->banner_id;
        $user_id   = auth()->user()->id;
       
        $banner_count = DB::table('ads_banners')->where('id', $banner_id)->count();

        if ($banner_count > 0) {
            $banner_details = DB::table('ads_banners')->where('id', $banner_id)->first();
            $banner_post_user_id = $banner_details->user_id;

            if($user_id != $banner_post_user_id){
                if (!empty($banner_id)) {
                    try {
                        DB::beginTransaction();
                        $banner_lead = new BannerLead;
                        $banner_lead->user_id             = $user_id;
                        $banner_lead->banner_id           = $request->banner_id;
                        $banner_lead->banner_post_user_id = $banner_post_user_id;
    
                        $banner_lead->save();
    
                        DB::commit();
    
                        $sms = sms::lead_banner($banner_id);
    
                        $output['response'] = true;
                        $output['message']  = 'Banner Lead successfully';
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $output['response'] = false;
                        $output['message']  = $e;
                    }
                    return $output;
                } else {
                    return ['message' => 'Please Select Banner Id'];
                }
            }else{
                return ['message' => 'Do not Lead User also Same'];
            }
        } else {
            return ['message' => 'Please Select Right Banner Id'];
        }
    }

    /** Total Banner Lead */
    public function total_banner_lead(Request $request)
    {
        $banner_id = $request->banner_id;
        if (!empty($banner_id)) {
            $banner_count   = DB::table('banner_leads')->where('banner_id', $banner_id)->count();
            $banner_details = BannerLead::where('banner_id', $banner_id)->get();

            if ($banner_count > 0) {
                foreach ($banner_details as $key => $banner) {
                    $user_count  = DB::table('user')->where(['id' => $banner->user_id])->count();
                    if ($user_count > 0) {
                        $banner_details = DB::table('ads_banners')->where(['id' => $banner_id])->first();
                        $banner_image = asset('storage/sponser/' . $banner_details->campaign_banner);

                        $user_details  = DB::table('user')->where(['id' => $banner->user_id])->first();

                        $data[$key] = [
                            'banner_id' => $banner_details->id, 'campaign_name' => $banner_details->campaign_name,
                            'campaign_banner' => $banner_image, 'user_id' => $user_details->id, 'name' => $user_details->name, 'mobile' => $user_details->mobile,
                            'email' => $user_details->email, 'company_name' => $user_details->company_name,'banner_status' => $banner->status
                        ];
                    }

                    //dd($data);
                    $uniqueData = [];
                    $seenIds = [];
                    foreach ( $data as $item) {
                        //dd($item);
                        if (!in_array($item['user_id'], $seenIds)) {
                            $uniqueData[] = $item;
                            $seenIds[] = $item['user_id'];
                        }
                    }

                    if (!empty($data)) {
                        $output['response']            = true;
                        $output['message']             = 'Total Banner Leads';
                        $output['banner_leads_count']  = $banner_count;
                        $output['data']                =  $uniqueData;
                        $output['error']               =  "";
                    }
                }
                if (!empty($data)) {
                    return $output;
                } else {
                    return ['message' => 'No Data Available', 'data' => []];
                }
            } else {
                return ['message' => 'No Data Available', 'data' => []];
            }
        }
    }

    /** Total Banner Lead */
    public function total_user_lead(Request $request)
    {

        $user_id = auth()->user()->id;
        if (!empty($user_id)) {
            $banner_count   = DB::table('banner_leads')->where('banner_post_user_id', $user_id)->count();
            $banner_details = BannerLead::where('banner_post_user_id', $user_id)->get();

            if ($banner_count > 0) {
                foreach ($banner_details as $key => $banner) {
                    $user_count  = DB::table('user')->where(['id' => $banner->user_id])->count();
                    if ($user_count > 0) {
                        $banner_details = DB::table('ads_banners')->where(['id' => $banner->banner_id])->first();
                        $banner_image = asset('storage/sponser/' . $banner_details->campaign_banner);

                        $user_details  = DB::table('user')->where(['id' => $banner->user_id])->first();

                        $data[$key] = [
                            'banner_id' => $banner_details->id, 'campaign_name' => $banner_details->campaign_name,
                            'campaign_banner' => $banner_image, 'user_id' => $user_details->id, 'name' => $user_details->name, 'mobile' => $user_details->mobile,
                            'email' => $user_details->email, 'company_name' => $user_details->company_name
                        ];
                    }
                    if (!empty($data)) {
                        $output['response']            = true;
                        $output['message']             = 'Total User Leads';
                        $output['banner_user_count']  =  $banner_count;
                        $output['data']                =  $data;
                        $output['error']               =  "";
                    }
                }
                if (!empty($data)) {
                    return $output;
                } else {
                    return ['message' => 'No Data Available', 'data' => []];
                }
            } else {
                return ['message' => 'No Data Available', 'data' => []];
            }
        }
    }

    public function my_banner(Request $request)
    {
        $data = [];
        $user_id = auth()->user()->id;

        $data = DB::table('ads_banners as a')
            ->select(
                'a.*',
                'b.price',
                'b.start_date',
                'b.end_date',
                'b.coupon_code_id',
                'b.coupon_code',
                'b.purchased_price',
                'b.transaction_id',
                'b.order_id',
                'b.invoice_no',
                'b.status as banner_status',
                'c.name as subscribtion_feature_name',
                'c.days',
                'c.website',
                'c.mobile',
                'c.sub_category',
                'c.category',
                'c.listing',
                'c.creatives',
                'c.state as no_of_state',
                'd.name as subscribtion_name',
                'e.discount_percentage',
                'e.discount_percentage',
                'e.discount_flat',
                DB::raw('GROUP_CONCAT(s.state_name) AS campaign_state_names'),
                DB::raw("CONCAT('".env('IMAGE_PATH_SPONSER')."',a.campaign_banner) as campaign_banner_image")
            )
            ->leftJoin('subscribeds as b', 'b.id', '=', 'a.subscribed_id')
            ->leftJoin('subscription_features as c', 'c.id', '=', 'a.subscription_features_id')
            ->leftJoin('subscriptions as d', 'd.id', '=', 'a.subscription_id')
            ->leftJoin('coupons as e', 'e.id', '=', 'b.coupon_code_id')
            ->leftJoin('state as s', function ($join) {
                //$join->on(DB::raw("find_in_set(s.id, a.campaign_state)">0));
                $join->whereRaw("find_in_set(s.id, a.campaign_state)");
            })
            ->where('a.user_id', '=', $user_id)
            ->groupBy(
                'a.id',
                'a.subscription_id',
                'a.subscription_features_id',
                'a.subscribed_id',
                'a.user_id',
                'a.campaign_name',
                'b.price',
                'b.start_date',
                'b.end_date',
                'b.coupon_code_id',
                'b.coupon_code',
                'b.purchased_price',
                'b.transaction_id',
                'b.order_id',
                'b.invoice_no',
                'b.status',
                'c.name',
                'c.days',
                'c.website',
                'c.mobile',
                'c.sub_category',
                'c.category',
                'c.listing',
                'c.creatives',
                'c.state',
                'd.name',
                'e.discount_percentage',
                'e.discount_percentage',
                'e.discount_flat'
            )
            ->get();

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

    public function banner_update(Request $request)
    {
        $data = [];
        $user_id = auth()->user()->id;
        $ads_banner_id = $request->ads_banner_id;
        $campaign_name = $request->campaign_name;
        $campaign_banner = $request->campaign_banner;
        $campaign_state = $request->campaign_state;
        $campaign_category      = $request->campaign_category;

        $validator = Validator::make($request->all(), [
            'ads_banner_id' => 'required|integer',
            'campaign_banner' => '',
            'campaign_name'  => 'required',
            'campaign_state' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = [];
            $output['status_code'] = 401;
            $output['error'] = $validator->errors();
        } else {
            $campaign_banner = DB::table('ads_banners')->where(['id' => $ads_banner_id])->value('campaign_banner');
            if ($image = $request->file('campaign_banner')) {
                $image = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('campaign_banner')->getClientOriginalName();
                $ext = $request->file('campaign_banner')->getClientOriginalExtension();
                $request->file('campaign_banner')->storeAs('public/sponser', $image);
            } else {
                $image = $campaign_banner;
            }

            $update = DB::table('ads_banners')->where(['id' => $ads_banner_id])->update([
                'campaign_name' => $campaign_name,
                'campaign_banner' => $image,
                'campaign_state' => $campaign_state,
                'campaign_category'=>$campaign_category,
                'status'           => 0,
                'updated_at' => Carbon::now()
            ]);

            if ($update) {

                $data = DB::table('ads_banners as a')
                    ->select(
                        'a.id as ads_banner_id',
                        'a.subscription_id',
                        'd.name as subscription_name',
                        'a.subscription_features_id',
                        'c.name as subscription_features_name',
                        'c.days as subscription_features_days',
                        'a.subscribed_id',
                        'b.price',
                        'b.start_date',
                        'b.end_date',
                        'b.coupon_code_id',
                        'b.coupon_code',
                        'b.purchased_price',
                        'b.transaction_id',
                        'b.order_id',
                        'b.invoice_no',
                        'a.user_id',
                        'a.campaign_name',
                        'a.campaign_state',
                        'e.discount_type',
                        'e.discount_percentage',
                        'e.discount_flat',
                        DB::raw('GROUP_CONCAT(s.state_name) AS campaign_state_names'),
                        DB::raw("CONCAT('".env('IMAGE_PATH_SPONSER')."',a.campaign_banner) as campaign_banner_image")
                    )
                    ->leftJoin('subscribeds as b', 'b.id', '=', 'a.subscribed_id')
                    ->leftJoin('subscription_features as c', 'c.id', '=', 'a.subscription_features_id')
                    ->leftJoin('subscriptions as d', 'd.id', '=', 'a.subscription_id')
                    ->leftJoin('coupons as e', 'e.id', '=', 'b.coupon_code_id')
                    ->leftJoin('state as s', function ($join) {
                        //$join->on(DB::raw("find_in_set(s.id, a.campaign_state)">0));
                        $join->whereRaw("find_in_set(s.id, a.campaign_state)");
                    })
                    ->where(['a.id' => $ads_banner_id])
                    ->groupBy(
                        'a.id',
                        'a.subscription_id',
                        'a.subscription_features_id',
                        'a.subscribed_id',
                        'a.user_id',
                        'a.campaign_name',
                        'b.price',
                        'b.start_date',
                        'b.end_date',
                        'b.coupon_code_id',
                        'b.coupon_code',
                        'b.purchased_price',
                        'b.transaction_id',
                        'b.order_id',
                        'b.invoice_no',
                        'b.status',
                        'c.name',
                        'c.days',
                        'c.website',
                        'c.mobile',
                        'c.sub_category',
                        'c.category',
                        'c.listing',
                        'c.creatives',
                        'c.state',
                        'd.name',
                        'e.discount_percentage',
                        'e.discount_percentage',
                        'e.discount_flat'
                    )
                    ->first();

                //BANNER PENDING SMS RUNNING....

                $sms = sms::pending_banner($data->ads_banner_id , $data->user_id );
                //$sms = sms::banner_pending($data->user_id,$data->id);

                $output['response'] = true;
                $output['message'] = 'Update Successfully';
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

    public function banner_delete(Request $request)
    {
        $data = [];
        $user_id = auth()->user()->id;
        $ads_banner_id = $request->ads_banner_id;

        $validator = Validator::make($request->all(), [
            'ads_banner_id' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response'] = false;
            $output['message'] = 'Validation error!';
            $output['data'] = [];
            $output['status_code'] = 401;
            $output['error'] = $validator->errors();
        } else {
            $campaign_banner = DB::table('ads_banners')->where(['id' => $ads_banner_id])->value('campaign_banner');
            $image_path = assert('storage/sponser/') . $campaign_banner;  // Value is not URL but directory file path
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $del = DB::table('ads_banners')->delete(['id' => $ads_banner_id]);
            if ($del) {
                $output['response'] = true;
                $output['message'] = 'Banner Deleted Successfully';
                $output['data'] = [];
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

    public function ads_banner_counter(Request $request)
    {
        $user_id = auth()->user()->id;
        $count = DB::table('subscribeds')->where(['user_id' => $user_id])->count();

        $output['response'] = true;
        $output['message'] = 'Count';
        $output['data'] = $count;
        $output['status_code'] = 200;
        $output['error'] = '';
        return $output;
    }

    public function pop_checker(Request $request)
    {
        $user_id = auth()->user()->id;
        $count1 = DB::table('subscribeds')->where(['user_id' => $user_id])->count();
        $count2 = DB::table('subscribed_boosts')->where(['user_id' => $user_id])->count();
        if ($count1 > 0 || $count2 > 0) {
            $flag = true;
        } else {
            $flag = false;
        }
        $output['response'] = true;
        $output['message'] = 'Count';
        $output['data'] = $flag;
        $output['status_code'] = 200;
        $output['error'] = '';
        return $output;
    }

    /** Lead User Post details With banner Id  */
    public function lead_user_all_product_post_details(Request $request)
    {
        $output = [];
        $data = [];

        $banner_id = $request->banner_id;
        $sponser_user_count = DB::table('ads_banners')->where('id', $request->banner_id)->where('status', 1)->count();

        if ($sponser_user_count > 0) {

            $banner_user_id = DB::table('ads_banners')->where('id', $request->banner_id)->where('status', 1)->first();
            $banner_image = asset("storage/sponser/".$banner_user_id->campaign_banner);
            $campaign_name = $banner_user_id->campaign_name;
            $user_id = $banner_user_id->user_id;

            $user_count = DB::table('user')->where('id', $user_id)->count();
            if ($user_count > 0) {
                $userPinCode = DB::table('user')->where('id', $user_id)->first()->zipcode;
                $pindata     = DB::table('city')->where(['pincode' => $userPinCode])->first();
                $latitude    = $pindata->latitude;
                $longitude   = $pindata->longitude;
            } else {
                $latitude    = "23.3202";
                $longitude   = "86.8426";
            }

            /** Tractor post */
            $sql_tractor = DB::table('tractorView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                    * cos(radians(tractorView.latitude))
                    * cos(radians(tractorView.longitude) - radians(" . $longitude . "))
                    + sin(radians(" . $latitude . "))
                    * sin(radians(tractorView.latitude))) AS distance")
                )
                ->where('status', 1)
                ->where('user_id', $banner_user_id->user_id);

            $tractor_count = $sql_tractor->count();
            $tractor_list  = $sql_tractor->get();

            /** Gv Post */
            $sql_gv = DB::table('goodVehicleView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                    * cos(radians(goodVehicleView.latitude))
                    * cos(radians(goodVehicleView.longitude) - radians(" . $longitude . "))
                    + sin(radians(" . $latitude . "))
                    * sin(radians(goodVehicleView.latitude))) AS distance")
                )
                ->where('status', 1)
                ->where('user_id', $banner_user_id->user_id);

            $gv_count = $sql_gv->count();
            $gv_list  = $sql_gv->get();

            /** Harvester Post */
            $sql_har = DB::table('harvesterView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                    * cos(radians(harvesterView.latitude))
                    * cos(radians(harvesterView.longitude) - radians(" . $longitude . "))
                    + sin(radians(" . $latitude . "))
                    * sin(radians(harvesterView.latitude))) AS distance")
                )
                ->where('status', 1)
                ->where('user_id', $banner_user_id->user_id);

            $har_count = $sql_har->count();
            $har_list  = $sql_har->get();

            /** Implement Post */
            $sql_imp  = DB::table('implementView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" . $longitude . "))
                        + sin(radians(" . $latitude . "))
                        * sin(radians(implementView.latitude))) AS distance")
                )
                ->where('status', 1)
                ->where('user_id', $banner_user_id->user_id);

            $imp_count = $sql_imp->count();
            $imp_list  = $sql_imp->get();

            /** Seeds Post */
            $sql_seeds = DB::table('seedView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                        * cos(radians(seedView.latitude))
                        * cos(radians(seedView.longitude) - radians(" . $longitude . "))
                        + sin(radians(" . $latitude . "))
                        * sin(radians(seedView.latitude))) AS distance")
                )
                ->where('status', 1)
                ->where('user_id', $banner_user_id->user_id);

            $seeds_count = $sql_seeds->count();
            $seeds_list  = $sql_seeds->get();

            /** Tyres Post */
            $sql_tyres = DB::table('tyresView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                        * cos(radians(tyresView.latitude))
                        * cos(radians(tyresView.longitude) - radians(" . $longitude . "))
                        + sin(radians(" . $latitude . "))
                        * sin(radians(tyresView.latitude))) AS distance")
                )
                ->where('status', 1)
                ->where('user_id', $banner_user_id->user_id);

            $tyres_count = $sql_tyres->count();
            $tyres_list  = $sql_tyres->get();

            $sql_fer   = DB::table('fertilizerView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                        * cos(radians(fertilizerView.latitude))
                        * cos(radians(fertilizerView.longitude) - radians(" . $longitude . "))
                        + sin(radians(" . $latitude . "))
                        * sin(radians(fertilizerView.latitude))) AS distance")
                )
                ->where('status', 1)
                ->where('user_id', $banner_user_id->user_id);

            $fer_count = $sql_fer->count();
            $fer_list  = $sql_fer->get();

            $sql_pes   = DB::table('pesticidesView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                        * cos(radians(pesticidesView.latitude))
                        * cos(radians(pesticidesView.longitude) - radians(" . $longitude . "))
                        + sin(radians(" . $latitude . "))
                        * sin(radians(pesticidesView.latitude))) AS distance")
                )
                ->where('status', 1)
                ->where('user_id', $banner_user_id->user_id);
            $pes_count = $sql_pes->count();
            $pes_list  = $sql_pes->get();

            /** Tractor Category Post */
            $tractor_array = array();
            if ($tractor_count > 0) {
                foreach ($tractor_list as $key => $tr) {

                    /** Image of goods vehicle*/
                    $left_image  = asset('storage/tractor/' . $tr->left_image);
                    $right_image = asset('storage/tractor/' . $tr->right_image);
                    $front_image = asset('storage/tractor/' . $tr->front_image);
                    $back_image  = asset('storage/tractor/' . $tr->back_image);
                    $meter_image = asset('storage/tractor/' . $tr->meter_image);
                    $tyre_image  = asset('storage/tractor/' . $tr->tyre_image);

                    /** Date of Create at */
                    $create     = $tr->created_at;
                    $newtime    = strtotime($create);
                    $created_at = date('M d, Y', $newtime);

                    /** Date of Update at */
                    $update      = $tr->updated_at;
                    $newtime1    = strtotime($update);
                    $updated_at  = date('M d, Y', $newtime1);

                    /** Brand Name And Model Name */
                    $brand_o_n = DB::table('brand')->where(['id' => $tr->brand_id])->value('name');
                    if ($brand_o_n == 'Others') {
                        $brand_name = $tr->title;
                        $model_name = $tr->description;
                    } else {
                        $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                        $brand_name     = $brand_arr_data->name;
                        $model_arr_data = DB::table('model')->where(['id' => $tr->model_id])->first();
                        $model_name     = $model_arr_data->model_name;
                    }

                    /** Distance Show */
                    $d = round($tr->distance);
                    if ($d == null) {
                        $distance = 0;
                    } else {
                        $distance = $d;
                    }

                    $state_name    = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;
                    $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;

                    $tractor_array = array();
                    $tractor_array['distance']           = $distance;

                    $user_count  = DB::table('user')->where(['id' => $banner_user_id->user_id])->count();
                    if ($user_count > 0) {
                        $user_details                     = DB::table('user')->where(['id' => $banner_user_id->user_id])->first();
                        $tractor_array['user_id']         = $user_details->id;
                        $tractor_array['user_type_id']    = $user_details->user_type_id;
                        $tractor_array['role_id']         = $user_details->role_id;
                        $tractor_array['name']            = $user_details->name;
                        $tractor_array['company_name']    = $user_details->company_name;
                        $tractor_array['mobile']          = $user_details->mobile;
                        $tractor_array['email']           = $user_details->email;
                        $tractor_array['gender']          = $user_details->gender;
                        $tractor_array['address']         = $user_details->address;
                        $tractor_array['zipcode']         = $user_details->zipcode;
                        $tractor_array['device_id']       = $user_details->device_id;
                        $tractor_array['firebase_token']  = $user_details->firebase_token;
                        $tractor_array['created_at_user'] = $user_details->created_at;
                        if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                            $tractor_array['photo'] = '';
                        } else {
                            $tractor_array['photo'] = env('APP_URL') . "storage/photo/$user_details->photo";
                        }
                    }

                    $specification = [];
                    $spec_count = DB::table('specifications')->where(['model_id' => $tr->model_id, 'status' => 1])->count();
                    if ($spec_count > 0) {
                        $specification_arr = DB::table('specifications')->where(['model_id' => $tr->model_id, 'status' => 1])->get();
                        foreach ($specification_arr as $val_s) {
                            $spec_name = $val_s->spec_name;
                            $spec_value = $val_s->value;
                            $specification[] = ['spec_name' => $spec_name, 'spec_value' => $spec_value];
                        }
                        $tractor_array['specification'] = $specification;
                    } else {
                        $tractor_array['specification'] = '';
                    }

                    $tractor_array['id']                =  $tr->id;
                    $tractor_array['city_name']         =  $tr->city_name;
                    $tractor_array['category_id']       =  $tr->category_id;
                    $tractor_array['user_id']           =  $tr->user_id;
                    $tractor_array['set']               =  $tr->set;
                    $tractor_array['type']              =  $tr->type;
                    $tractor_array['brand_id']          =  $tr->brand_id;
                    $tractor_array['model_id']          =  $tr->model_id;
                    $tractor_array['year_of_purchase']  =  $tr->year_of_purchase;
                    $tractor_array['title']             =  $tr->title;
                    $tractor_array['rc_available']      =  $tr->rc_available;
                    $tractor_array['noc_available']     =  $tr->noc_available;
                    $tractor_array['registration_no']   =  $tr->registration_no;
                    $tractor_array['description']       =  $tr->description;

                    if (!empty($tr->front_image)) {
                        $tractor_array['front_image'] =  $front_image;
                    }

                    if (!empty($tr->left_image)) {
                        $tractor_array['left_image'] =  $left_image;
                    }
                    if (!empty($tr->right_image)) {
                        $tractor_array['right_image'] =  $right_image;
                    }
                    if (!empty($tr->back_image)) {
                        $tractor_array['back_image'] =  $back_image;
                    }
                    if (!empty($tr->meter_image)) {
                        $tractor_array['meter_image'] =  $meter_image;
                    }
                    if (!empty($tr->tyre_image)) {
                        $tractor_array['tyre_image'] =  $tyre_image;
                    }

                    $tractor_array['price']                =  $tr->price;
                    $tractor_array['rent_type']            =  $tr->rent_type;
                    $tractor_array['is_negotiable']        =  $tr->is_negotiable;
                    $tractor_array['country_id']           =  $tr->country_id;
                    $tractor_array['state_id']             =  $tr->state_id;
                    $tractor_array['district_id']          =  $tr->district_id;
                    $tractor_array['city_id']              =  $tr->city_id;
                    $tractor_array['pincode']              =  $tr->pincode;
                    $tractor_array['tractor_latlong']      =  $tr->tractor_latlong;
                    $tractor_array['ad_report']            =  $tr->ad_report;
                    $tractor_array['status']               =  $tr->status;
                    $tractor_array['created_at']           =  $tr->created_at;
                    $tractor_array['updated_at']           =  $updated_at;
                    $tractor_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                    $tractor_array['rejected_by']          =  $tr->rejected_by;
                    $tractor_array['rejected_at']          =  $tr->rejected_at;
                    $tractor_array['approved_by']          =  $tr->approved_by;
                    $tractor_array['approved_at']          =  $tr->approved_at;
                    $tractor_array['district_name']        =  $district_name;
                    $tractor_array['brand_name']           =  $brand_name;
                    $tractor_array['model_name']           =  $model_name;
                    $tractor_array['approved_at']          =  $tr->approved_at;

                    $tractor_array['state_name']           =  $state_name;
                    $tractor_array['wishlist_status']      = DB::table('wishlist')->where(['user_id' => $tr->user_id, 'category_id' => 1, 'item_id' => $tr->id])->count();
                    $tractor_array['view_lead']            = Leads_view::where(['category_id' => 1, 'post_id' => $tr->id])->count();
                    $tractor_array['call_lead']            = Lead::where(['category_id' => 1, 'post_id' => $tr->id, 'calls_status' => 1])->count();
                    $tractor_array['msg_lead']             = Lead::where(['category_id' => 1, 'post_id' => $tr->id, 'messages_status' => 1])->count();

                    $data['1'][$key] = $tractor_array;
                }
            } else if ($tractor_count == 0) {
                $data['1'] = [];
            }

            /** Gv Category Post */
            if ($gv_count > 0) {
                foreach ($gv_list as $key => $tr) {

                    /** Image of goods vehicle*/
                    $left_image  = asset('storage/goods_vehicle/' . $tr->left_image);
                    $right_image = asset('storage/goods_vehicle/' . $tr->right_image);
                    $front_image = asset('storage/goods_vehicle/' . $tr->front_image);
                    $back_image  = asset('storage/goods_vehicle/' . $tr->back_image);
                    $meter_image = asset('storage/goods_vehicle/' . $tr->meter_image);
                    $tyre_image  = asset('storage/goods_vehicle/' . $tr->tyre_image);

                    /** Date of Create at */
                    $create     = $tr->created_at;
                    $newtime    = strtotime($create);
                    $created_at = date('M d, Y', $newtime);

                    /** Date of Update at */
                    $update      = $tr->updated_at;
                    $newtime1    = strtotime($update);
                    $updated_at  = date('M d, Y', $newtime1);

                    /** Brand Name And Model Name */
                    $brand_o_n = DB::table('brand')->where(['id' => $tr->brand_id])->value('name');
                    if ($brand_o_n == 'Others') {
                        $brand_name = $tr->title;
                        $model_name = $tr->description;
                    } else {
                        $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                        $brand_name     = $brand_arr_data->name;
                        $model_arr_data = DB::table('model')->where(['id' => $tr->model_id])->first();
                        $model_name     = $model_arr_data->model_name;
                    }

                    /** Distance Show */
                    $d = round($tr->distance);
                    if ($d == null) {
                        $distance = 0;
                    } else {
                        $distance = $d;
                    }

                    $state_name    = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;
                    $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;

                    $gv_array = array();
                    $gv_array['distance']        =  $distance;

                    $user_count  = DB::table('user')->where(['id' => $banner_user_id->user_id])->count();
                    if ($user_count > 0) {
                        $user_details                = DB::table('user')->where(['id' => $tr->user_id])->first();
                        $gv_array['user_id']         = $user_details->id;
                        $gv_array['user_type_id']    = $user_details->user_type_id;
                        $gv_array['role_id']         = $user_details->role_id;
                        $gv_array['name']            = $user_details->name;
                        $gv_array['company_name']    = $user_details->company_name;
                        $gv_array['mobile']          = $user_details->mobile;
                        $gv_array['email']           = $user_details->email;
                        $gv_array['gender']          = $user_details->gender;
                        $gv_array['address']         = $user_details->address;
                        $gv_array['zipcode']         = $user_details->zipcode;
                        $gv_array['device_id']       = $user_details->device_id;
                        $gv_array['firebase_token']  = $user_details->firebase_token;
                        $gv_array['created_at_user'] = $user_details->created_at;
                        if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                            $gv_array['photo'] = '';
                        } else {
                            $gv_array['photo'] = env('APP_URL') . "storage/photo/$user_details->photo";
                        }
                    }

                    $specification = [];
                    $spec_count = DB::table('specifications')->where(['model_id' => $tr->model_id, 'status' => 1])->count();
                    if ($spec_count > 0) {
                        $specification_arr = DB::table('specifications')->where(['model_id' => $tr->model_id, 'status' => 1])->get();
                        foreach ($specification_arr as $val_s) {
                            $spec_name = $val_s->spec_name;
                            $spec_value = $val_s->value;
                            $specification[] = ['spec_name' => $spec_name, 'spec_value' => $spec_value];
                        }
                        $gv_array['specification'] = $specification;
                    } else {
                        $gv_array['specification'] = '';
                    }

                    $gv_array['id']                =  $tr->id;
                    $gv_array['city_name']         =  $tr->city_name;
                    $gv_array['category_id']       =  $tr->category_id;
                    $gv_array['user_id']           =  $tr->user_id;
                    $gv_array['set']               =  $tr->set;
                    $gv_array['type']              =  $tr->type;
                    $gv_array['brand_id']          =  $tr->brand_id;
                    $gv_array['model_id']          =  $tr->model_id;
                    $gv_array['year_of_purchase']  =  $tr->year_of_purchase;
                    $gv_array['title']             =  $tr->title;
                    $gv_array['rc_available']      =  $tr->rc_available;
                    $gv_array['noc_available']     =  $tr->noc_available;
                    $gv_array['registration_no']   =  $tr->registration_no;
                    $gv_array['description']       =  $tr->description;

                    if (!empty($tr->front_image)) {
                        $gv_array['front_image'] =  $front_image;
                    }
                    if (!empty($tr->left_image)) {
                        $gv_array['left_image'] =  $left_image;
                    }
                    if (!empty($tr->right_image)) {
                        $gv_array['right_image'] =  $right_image;
                    }
                    if (!empty($tr->back_image)) {
                        $gv_array['back_image'] =  $back_image;
                    }
                    if (!empty($tr->meter_image)) {
                        $gv_array['meter_image'] =  $meter_image;
                    }
                    if (!empty($tr->tyre_image)) {
                        $gv_array['tyre_image'] =  $tyre_image;
                    }

                    $gv_array['price']                =  $tr->price;
                    $gv_array['rent_type']            =  $tr->rent_type;
                    $gv_array['is_negotiable']        =  $tr->is_negotiable;
                    $gv_array['country_id']           =  $tr->country_id;
                    $gv_array['state_id']             =  $tr->state_id;
                    $gv_array['district_id']          =  $tr->district_id;
                    $gv_array['city_id']              =  $tr->city_id;
                    $gv_array['pincode']              =  $tr->pincode;
                    $gv_array['gv_latlong']           =  $tr->latlong;
                    $gv_array['ad_report']            =  $tr->ad_report;
                    $gv_array['status']               =  $tr->status;
                    $gv_array['created_at']           =  $tr->created_at;
                    $gv_array['updated_at']           =  $updated_at;
                    $gv_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                    $gv_array['rejected_by']          =  $tr->rejected_by;
                    $gv_array['rejected_at']          =  $tr->rejected_at;
                    $gv_array['approved_by']          =  $tr->approved_by;
                    $gv_array['approved_at']          =  $tr->approved_at;
                    $gv_array['district_name']        =  $district_name;
                    $gv_array['brand_name']           =  $brand_name;
                    $gv_array['model_name']           =  $model_name;
                    $gv_array['approved_at']          =  $tr->approved_at;
                    $gv_array['state_name']           =  $state_name;

                    $gv_array['wishlist_status']      = DB::table('wishlist')->where(['user_id' => $tr->user_id, 'category_id' => 3, 'item_id' => $tr->id])->count();
                    $gv_array['view_lead']            = Leads_view::where(['category_id' => 3, 'post_id' => $tr->id])->count();
                    $gv_array['call_lead']            = Lead::where(['category_id' => 3, 'post_id' => $tr->id, 'calls_status' => 1])->count();
                    $gv_array['msg_lead']             = Lead::where(['category_id' => 3, 'post_id' => $tr->id, 'messages_status' => 1])->count();

                    $data['3'][$key] = $gv_array;
                }
            } else if ($gv_count == 0) {
                $data['3'] =  [];
            }

            /** Harvester Post*/
            if ($har_count > 0) {
                foreach ($har_list as $key => $tr) {
                    $output = [];

                    /** Image of Harvester */
                    $left_image  = asset('storage/harvester/' . $tr->left_image);
                    $right_image = asset('storage/harvester/' . $tr->right_image);
                    $front_image = asset('storage/harvester/' . $tr->front_image);
                    $back_image  = asset('storage/harvester/' . $tr->back_image);


                    /** Date of Create at */
                    $create     = $tr->created_at;
                    $newtime    = strtotime($create);
                    $created_at = date('M d, Y', $newtime);

                    /** Date of Update at */
                    $update      = $tr->updated_at;
                    $newtime1    = strtotime($update);
                    $updated_at  = date('M d, Y', $newtime1);

                    /** Brand Name And Model Name */
                    $brand_o_n = DB::table('brand')->where(['id' => $tr->brand_id])->value('name');
                    if ($brand_o_n == 'Others') {
                        $brand_name = $tr->title;
                        $model_name = $tr->description;
                    } else {
                        $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                        $brand_name     = $brand_arr_data->name;
                        $model_arr_data = DB::table('model')->where(['id' => $tr->model_id])->first();
                        $model_name     = $model_arr_data->model_name;
                    }

                    /** Distance Show */
                    $d = round($tr->distance);
                    if ($d == null) {
                        $distance = 0;
                    } else {
                        $distance = $d;
                    }

                    /** District Name */
                    $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;
                    $state_name    = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

                    $hr_array = array();

                    $hr_array['distance']        =  $distance;

                    $user_count                  = DB::table('user')->where(['id' => $tr->user_id])->count();
                    if ($user_count > 0) {
                        $user_details                = DB::table('user')->where(['id' => $tr->user_id])->first();
                        $hr_array['user_id']         = $user_details->id;
                        $hr_array['user_type_id']    = $user_details->user_type_id;
                        $hr_array['role_id']         = $user_details->role_id;
                        $hr_array['name']            = $user_details->name;
                        $hr_array['company_name']    = $user_details->company_name;
                        $hr_array['mobile']          = $user_details->mobile;
                        $hr_array['email']           = $user_details->email;
                        $hr_array['gender']          = $user_details->gender;
                        $hr_array['address']         = $user_details->address;
                        $hr_array['zipcode']         = $user_details->zipcode;
                        $hr_array['device_id']       = $user_details->device_id;
                        $hr_array['firebase_token']  = $user_details->firebase_token;
                        $hr_array['created_at_user'] = $user_details->created_at;
                        if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                            $hr_array['photo'] = '';
                        } else {
                            $hr_array['photo'] = env('APP_URL') . "storage/photo/$user_details->photo";
                        }
                    }

                    $specification = [];
                    $spec_count = DB::table('specifications')->where(['model_id' => $tr->model_id, 'status' => 1])->count();
                    if ($spec_count > 0) {
                        $specification_arr = DB::table('specifications')->where(['model_id' => $tr->model_id, 'status' => 1])->get();
                        foreach ($specification_arr as $val_s) {
                            $spec_name = $val_s->spec_name;
                            $spec_value = $val_s->value;
                            $specification[] = ['spec_name' => $spec_name, 'spec_value' => $spec_value];
                        }
                        $hr_array['specification'] = $specification;
                    } else {
                        $hr_array['specification'] = '';
                    }
                    $hr_array['id']                =  $tr->id;
                    $hr_array['city_name']         =  $tr->city_name;
                    $hr_array['category_id']       =  $tr->category_id;
                    $hr_array['user_id']           =  $tr->user_id;
                    $hr_array['set']               =  $tr->set;
                    $hr_array['type']              =  $tr->type;
                    $hr_array['brand_id']          =  $tr->brand_id;
                    $hr_array['model_id']          =  $tr->model_id;
                    $hr_array['year_of_purchase']  =  $tr->year_of_purchase;
                    $hr_array['title']             =  $tr->title;
                    $hr_array['crop_type']         =  $tr->crop_type;
                    $hr_array['cutting_with']      =  $tr->cutting_with;
                    $hr_array['power_source']      =  $tr->power_source;
                    $hr_array['spec_id']           =  $tr->spec_id;

                    if (!empty($tr->front_image)) {
                        $hr_array['front_image'] =  $front_image;
                    }
                    if (!empty($tr->left_image)) {
                        $hr_array['left_image'] =  $left_image;
                    }
                    if (!empty($tr->right_image)) {
                        $hr_array['right_image'] =  $right_image;
                    }

                    if (!empty($tr->back_image)) {
                        $hr_array['back_image'] =  $back_image;
                    }

                    $hr_array['description']          =  $tr->description;
                    $hr_array['price']                =  $tr->price;
                    $hr_array['rent_type']            =  $tr->rent_type;
                    $hr_array['is_negotiable']        =  $tr->is_negotiable;
                    $hr_array['country_id']           =  $tr->country_id;
                    $hr_array['state_id']             =  $tr->state_id;
                    $hr_array['district_id']          =  $tr->district_id;
                    $hr_array['city_id']              =  $tr->city_id;
                    $hr_array['pincode']              =  $tr->pincode;
                    $hr_array['latlong']              =  $tr->latlong;
                    $hr_array['is_featured']          =  $tr->is_featured;
                    $hr_array['valid_till']           =  $tr->valid_till;
                    $hr_array['ad_report']            =  $tr->ad_report;
                    $hr_array['status']               =  $tr->status;
                    $hr_array['created_at']           =  $tr->created_at;
                    $hr_array['updated_at']           =  $updated_at;
                    $hr_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                    $hr_array['rejected_by']          =  $tr->rejected_by;
                    $hr_array['rejected_at']          =  $tr->rejected_at;
                    $hr_array['approved_by']          =  $tr->approved_by;
                    $hr_array['approved_at']          =  $tr->approved_at;
                    $hr_array['district_name']        =  $district_name;
                    $hr_array['brand_name']           =  $brand_name;
                    $hr_array['model_name']           =  $model_name;
                    $hr_array['approved_at']          =  $tr->approved_at;
                    $hr_array['state_name']           =  $state_name;

                    $hr_array['wishlist_status']      = DB::table('wishlist')->where(['user_id' => $tr->user_id, 'category_id' => 4, 'item_id' => $tr->id])->count();
                    $hr_array['view_lead']            = Leads_view::where(['category_id' => 4, 'post_id' => $tr->id])->count();
                    $hr_array['call_lead']            = Lead::where(['category_id' => 4, 'post_id' => $tr->id, 'calls_status' => 1])->count();
                    $hr_array['msg_lead']             = Lead::where(['category_id' => 4, 'post_id' => $tr->id, 'messages_status' => 1])->count();

                    $data['4'][$key] = $hr_array;
                }
            } else if ($har_count == 0) {
                $data['4'] = [];
            }

            /** Implements Post */
            if ($imp_count > 0) {
                foreach ($imp_list as $key => $tr) {
                    $output = [];

                    /** Image of Implement */
                    $left_image  = asset('storage/implements/' . $tr->left_image);
                    $right_image = asset('storage/implements/' . $tr->right_image);
                    $front_image = asset('storage/implements/' . $tr->front_image);
                    $back_image  = asset('storage/implements/' . $tr->back_image);

                    /** Date of Create at */
                    $create     = $tr->created_at;
                    $newtime    = strtotime($create);
                    $created_at = date('M d, Y', $newtime);

                    /** Date of Update at */
                    $update      = $tr->updated_at;
                    $newtime1    = strtotime($update);
                    $updated_at  = date('M d, Y', $newtime1);

                    /** Brand Name And Model Name */
                    $brand_o_n = DB::table('brand')->where(['id' => $tr->brand_id])->value('name');
                    if ($brand_o_n == 'Others') {
                        $brand_name = $tr->title;
                        $model_name = $tr->description;
                    } else {
                        $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                        $brand_name     = $brand_arr_data->name;
                        $model_arr_data = DB::table('model')->where(['id' => $tr->model_id])->first();
                        $model_name     = $model_arr_data->model_name;
                    }

                    /** Distance Show */
                    $d = round($tr->distance);
                    if ($d == null) {
                        $distance = 0;
                    } else {
                        $distance = $d;
                    }

                    /** District Name */
                    $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;
                    $state_name    = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

                    $imp_array = array();

                    $imp_array['distance']        =  $distance;

                    $user_count                   = DB::table('user')->where(['id' => $tr->user_id])->count();
                    if ($user_count > 0) {
                        $user_details                 = DB::table('user')->where(['id' => $tr->user_id])->first();
                        $imp_array['user_id']         = $user_details->id;
                        $imp_array['user_type_id']    = $user_details->user_type_id;
                        $imp_array['role_id']         = $user_details->role_id;
                        $imp_array['name']            = $user_details->name;
                        $imp_array['company_name']    = $user_details->company_name;
                        $imp_array['mobile']          = $user_details->mobile;
                        $imp_array['email']           = $user_details->email;
                        $imp_array['gender']          = $user_details->gender;
                        $imp_array['address']         = $user_details->address;
                        $imp_array['zipcode']         = $user_details->zipcode;
                        $imp_array['device_id']       = $user_details->device_id;
                        $imp_array['firebase_token']  = $user_details->firebase_token;
                        $imp_array['created_at_user'] = $user_details->created_at;
                        if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                            $imp_array['photo'] = '';
                        } else {
                            $imp_array['photo'] = env('APP_URL') . "storage/photo/$user_details->photo";
                        }
                    }

                    $specification = [];
                    $spec_count = DB::table('specifications')->where(['model_id' => $tr->model_id, 'status' => 1])->count();
                    if ($spec_count > 0) {
                        $specification_arr = DB::table('specifications')->where(['model_id' => $tr->model_id, 'status' => 1])->get();
                        foreach ($specification_arr as $val_s) {
                            $spec_name = $val_s->spec_name;
                            $spec_value = $val_s->value;
                            $specification[] = ['spec_name' => $spec_name, 'spec_value' => $spec_value];
                        }
                        $imp_array['specification'] = $specification;
                    } else {
                        $imp_array['specification'] = '';
                    }
                    $imp_array['id']                =  $tr->id;
                    $imp_array['city_name']         =  $tr->city_name;
                    $imp_array['category_id']       =  $tr->category_id;
                    $imp_array['user_id']           =  $tr->user_id;
                    $imp_array['set']               =  $tr->set;
                    $imp_array['type']              =  $tr->type;
                    $imp_array['brand_id']          =  $tr->brand_id;
                    $imp_array['model_id']          =  $tr->model_id;
                    $imp_array['year_of_purchase']  =  $tr->year_of_purchase;
                    $imp_array['title']             =  $tr->title;

                    if (!empty($tr->front_image)) {
                        $imp_array['front_image'] =  $front_image;
                    }
                    if (!empty($tr->left_image)) {
                        $imp_array['left_image'] =  $left_image;
                    }
                    if (!empty($tr->right_image)) {
                        $imp_array['right_image'] =  $right_image;
                    }
                    if (!empty($tr->back_image)) {
                        $imp_array['back_image'] =  $back_image;
                    }

                    $imp_array['spec_id']              =  $tr->spec_id;
                    $imp_array['description']          =  $tr->description;
                    $imp_array['price']                =  $tr->price;
                    $imp_array['rent_type']            =  $tr->rent_type;
                    $imp_array['is_negotiable']        =  $tr->is_negotiable;
                    $imp_array['country_id']           =  $tr->country_id;
                    $imp_array['state_id']             =  $tr->state_id;
                    $imp_array['district_id']          =  $tr->district_id;
                    $imp_array['city_id']              =  $tr->city_id;
                    $imp_array['pincode']              =  $tr->pincode;
                    $imp_array['latlong']              =  $tr->latlong;
                    $imp_array['is_featured']          =  $tr->is_featured;
                    $imp_array['valid_till']           =  $tr->valid_till;
                    $imp_array['ad_report']            =  $tr->ad_report;
                    $imp_array['status']               =  $tr->status;
                    $imp_array['created_at']           =  $tr->created_at;
                    $imp_array['updated_at']           =  $updated_at;
                    $imp_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                    $imp_array['rejected_by']          =  $tr->rejected_by;
                    $imp_array['approved_by']          =  $tr->approved_by;
                    $imp_array['approved_at']          =  $tr->approved_at;
                    $imp_array['district_name']        =  $district_name;
                    $imp_array['brand_name']           =  $brand_name;
                    $imp_array['model_name']           =  $model_name;
                    $imp_array['approved_at']          =  $tr->approved_at;
                    $imp_array['state_name']           =  $state_name;

                    $imp_array['wishlist_status']      = DB::table('wishlist')->where(['user_id' => $tr->user_id, 'category_id' => 5, 'item_id' => $tr->id])->count();
                    $imp_array['view_lead']            = Leads_view::where(['category_id' => 5, 'post_id' => $tr->id])->count();
                    $imp_array['call_lead']            = Lead::where(['category_id' => 5, 'post_id' => $tr->id, 'calls_status' => 1])->count();
                    $imp_array['msg_lead']             = Lead::where(['category_id' => 5, 'post_id' => $tr->id, 'messages_status' => 1])->count();

                    $data['5'][$key] = $imp_array;
                }
            } else if ($imp_count == 0) {
                $data['5'] = [];
            }

            /** Seeds Post */
            if ($seeds_count > 0) {
                foreach ($seeds_list as $key => $tr) {
                    $output = [];

                    /** Image of Seeds */
                    $image1  = asset('storage/seeds/' . $tr->image1);
                    $image2 = asset('storage/seeds/' . $tr->image2);
                    $image3 = asset('storage/seeds/' . $tr->image3);

                    /** Date of Create at */
                    $create     = $tr->created_at;
                    $newtime    = strtotime($create);
                    $created_at = date('M d, Y', $newtime);

                    /** Date of Update at */
                    $update      = $tr->updated_at;
                    $newtime1    = strtotime($update);
                    $updated_at  = date('M d, Y', $newtime1);

                    /** Distance Show */
                    $d = round($tr->distance);
                    if ($d == null) {
                        $distance = 0;
                    } else {
                        $distance = $d;
                    }

                    /** District Name */
                    $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;
                    $state_name    = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

                    $seed_array = array();
                    $seed_array['distance']         =  $distance;

                    $user_count                     = DB::table('user')->where(['id' => $tr->user_id])->count();
                    if ($user_count > 0) {
                        $user_details  = DB::table('user')->where(['id' => $tr->user_id])->first();
                        $seed_array['user_id']         = $user_details->id;
                        $seed_array['user_type_id']    = $user_details->user_type_id;
                        $seed_array['role_id']         = $user_details->role_id;
                        $seed_array['name']            = $user_details->name;
                        $seed_array['company_name']    = $user_details->company_name;
                        $seed_array['mobile']          = $user_details->mobile;
                        $seed_array['email']           = $user_details->email;
                        $seed_array['gender']          = $user_details->gender;
                        $seed_array['address']         = $user_details->address;
                        $seed_array['zipcode']         = $user_details->zipcode;
                        $seed_array['device_id']       = $user_details->device_id;
                        $seed_array['firebase_token']  = $user_details->firebase_token;
                        $seed_array['created_at_user'] = $user_details->created_at;
                        if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                            $seed_array['photo'] = '';
                        } else {
                            $seed_array['photo'] = env('APP_URL') . "storage/photo/$user_details->photo";
                        }
                    }

                    $seed_array['id']            =  $tr->id;
                    $seed_array['city_name']     =  $tr->city_name;
                    $seed_array['category_id']   =  $tr->category_id;
                    $seed_array['user_id']       =  $tr->user_id;
                    $seed_array['title']         =  $tr->title;
                    $seed_array['description']   =  $tr->description;
                    $seed_array['price']         =  $tr->price;
                    $seed_array['is_negotiable'] =  $tr->is_negotiable;

                    if (!empty($tr->image1)) {
                        $seed_array['image1'] =  $image1;
                    }
                    if (!empty($tr->image2)) {
                        $seed_array['image2'] =  $image2;
                    }
                    if (!empty($tr->image3)) {
                        $seed_array['image3'] =  $image3;
                    }

                    $seed_array['country_id']           =  $tr->country_id;
                    $seed_array['state_id']             =  $tr->state_id;
                    $seed_array['district_id']          =  $tr->district_id;
                    $seed_array['city_id']              =  $tr->city_id;
                    $seed_array['pincode']              =  $tr->pincode;
                    $seed_array['latlong']              =  $tr->latlong;
                    $seed_array['is_featured']          =  $tr->is_featured;
                    $seed_array['valid_till']           =  $tr->valid_till;
                    $seed_array['ad_report']            =  $tr->ad_report;
                    $seed_array['status']               =  $tr->status;
                    $seed_array['created_at']           =  $tr->created_at;
                    $seed_array['updated_at']           =  $updated_at;
                    $seed_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                    $seed_array['rejected_by']          =  $tr->rejected_by;
                    $seed_array['rejected_at']          =  $tr->rejected_at;
                    $seed_array['approved_by']          =  $tr->approved_by;
                    $seed_array['approved_at']          =  $tr->approved_at;
                    $seed_array['district_name']        =  $district_name;

                    $seed_array['state_name']           =  $state_name;
                    $seed_array['wishlist_status']      = DB::table('wishlist')->where(['user_id' => $tr->user_id, 'category_id' => 6, 'item_id' => $tr->id])->count();
                    $seed_array['view_lead']            = Leads_view::where(['category_id' => 6, 'post_id' => $tr->id])->count();
                    $seed_array['call_lead']            = Lead::where(['category_id' => 6, 'post_id' => $tr->id, 'calls_status' => 1])->count();
                    $seed_array['msg_lead']             = Lead::where(['category_id' => 6, 'post_id' => $tr->id, 'messages_status' => 1])->count();

                    $data['6'][$key] = $seed_array;
                }
            } else if ($seeds_count == 0) {
                $data['6'] = [];
            }

            /** Tyres Post */
            if ($tyres_count > 0) {
                foreach ($tyres_list as $key => $tr) {
                    $output = [];

                    /** Image of Tyres */
                    $image1  = asset('storage/tyre/' . $tr->image1);
                    $image2 = asset('storage/tyre/' . $tr->image2);
                    $image3 = asset('storage/tyre/' . $tr->image3);

                    /** Date of Create at */
                    $create     = $tr->created_at;
                    $newtime    = strtotime($create);
                    $created_at = date('M d, Y', $newtime);

                    /** Date of Update at */
                    $update      = $tr->updated_at;
                    $newtime1    = strtotime($update);
                    $updated_at  = date('M d, Y', $newtime1);

                    /** Brand Name And Model Name */
                    $brand_o_n = DB::table('brand')->where(['id' => $tr->brand_id])->value('name');
                    if ($brand_o_n == 'Others') {
                        $brand_name = $tr->title;
                        $model_name = $tr->description;
                    } else {
                        $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                        $brand_name     = $brand_arr_data->name;
                        $model_arr_data = DB::table('model')->where(['id' => $tr->model_id])->first();
                        $model_name     = $model_arr_data->model_name;
                    }

                    /** Distance Show */
                    $d = round($tr->distance);
                    if ($d == null) {
                        $distance = 0;
                    } else {
                        $distance = $d;
                    }

                    /** District Name */
                    $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;
                    $state_name    = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

                    $tyre_array = array();

                    $tyre_array['distance']        =  $distance;

                    $user_count                    = DB::table('user')->where(['id' => $tr->user_id])->count();
                    if ($user_count > 0) {
                        $user_details                  = DB::table('user')->where(['id' => $tr->user_id])->first();
                        $tyre_array['user_id']         = $user_details->id;
                        $tyre_array['user_type_id']    = $user_details->user_type_id;
                        $tyre_array['role_id']         = $user_details->role_id;
                        $tyre_array['name']            = $user_details->name;
                        $tyre_array['company_name']    = $user_details->company_name;
                        $tyre_array['mobile']          = $user_details->mobile;
                        $tyre_array['email']           = $user_details->email;
                        $tyre_array['gender']          = $user_details->gender;
                        $tyre_array['address']         = $user_details->address;
                        $tyre_array['zipcode']         = $user_details->zipcode;
                        $tyre_array['device_id']       = $user_details->device_id;
                        $tyre_array['firebase_token']  = $user_details->firebase_token;
                        $tyre_array['created_at_user'] = $user_details->created_at;
                        if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                            $tyre_array['photo'] = '';
                        } else {
                            $tyre_array['photo'] = env('APP_URL') . "storage/photo/$user_details->photo";
                        }
                    }

                    $specification = [];
                    $spec_count = DB::table('specifications')->where(['model_id' => $tr->model_id, 'status' => 1])->count();
                    if ($spec_count > 0) {
                        $specification_arr = DB::table('specifications')->where(['model_id' => $tr->model_id, 'status' => 1])->get();
                        foreach ($specification_arr as $val_s) {
                            $spec_name = $val_s->spec_name;
                            $spec_value = $val_s->value;
                            $specification[] = ['spec_name' => $spec_name, 'spec_value' => $spec_value];
                        }
                        $tyre_array['specification'] = $specification;
                    } else {
                        $tyre_array['specification'] = '';
                    }
                    $tyre_array['id']                =  $tr->id;
                    $tyre_array['city_name']         =  $tr->city_name;
                    $tyre_array['category_id']       =  $tr->category_id;
                    $tyre_array['user_id']           =  $tr->user_id;
                    $tyre_array['type']              =  $tr->type;
                    $tyre_array['brand_id']          =  $tr->brand_id;
                    $tyre_array['model_id']          =  $tr->model_id;
                    $tyre_array['year_of_purchase']  =  $tr->year_of_purchase;
                    $tyre_array['title']             =  $tr->title;
                    $tyre_array['position']          =  $tr->position;
                    $tyre_array['price']             =  $tr->price;
                    $tyre_array['description']       =  $tr->description;

                    if (!empty($tr->image1)) {
                        $tyre_array['image1'] =  $image1;
                    }
                    if (!empty($tr->image2)) {
                        $tyre_array['image2'] =  $image2;
                    }
                    if (!empty($tr->image3)) {
                        $tyre_array['image3'] =  $image3;
                    }

                    $tyre_array['is_negotiable']        =  $tr->is_negotiable;
                    $tyre_array['country_id']           =  $tr->country_id;
                    $tyre_array['state_id']             =  $tr->state_id;
                    $tyre_array['district_id']          =  $tr->district_id;
                    $tyre_array['city_id']              =  $tr->city_id;
                    $tyre_array['pincode']              =  $tr->pincode;
                    $tyre_array['latlong']              =  $tr->latlong;
                    $tyre_array['is_featured']          =  $tr->is_featured;
                    $tyre_array['valid_till']           =  $tr->valid_till;
                    $tyre_array['ad_report']            =  $tr->ad_report;
                    $tyre_array['status']               =  $tr->status;
                    $tyre_array['created_at']           =  $tr->created_at;
                    $tyre_array['updated_at']           =  $updated_at;
                    $tyre_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                    $tyre_array['rejected_by']          =  $tr->rejected_by;
                    $tyre_array['rejected_at']          =  $tr->rejected_at;
                    $tyre_array['approved_by']          =  $tr->approved_by;
                    $tyre_array['approved_at']          =  $tr->approved_at;
                    $tyre_array['district_name']        =  $district_name;
                    $tyre_array['brand_name']           =  $brand_name;
                    $tyre_array['model_name']           =  $model_name;
                    $tyre_array['approved_at']          =  $tr->approved_at;

                    $tyre_array['state_name']           =  $state_name;
                    $tyre_array['wishlist_status']      = DB::table('wishlist')->where(['user_id' => $tr->user_id, 'category_id' => 7, 'item_id' => $tr->id])->count();
                    $tyre_array['view_lead']            = Leads_view::where(['category_id' => 7, 'post_id' => $tr->id])->count();
                    $tyre_array['call_lead']            = Lead::where(['category_id' => 7, 'post_id' => $tr->id, 'calls_status' => 1])->count();
                    $tyre_array['msg_lead']             = Lead::where(['category_id' => 7, 'post_id' => $tr->id, 'messages_status' => 1])->count();

                    $data['7'][$key] = $tyre_array;
                }
            } else if ($tyres_count == 0) {
                $data['7'] = [];
            }

            /** Pesticides Post */
            if ($pes_count > 0) {
                foreach ($pes_list as $key => $tr) {
                    $output = [];

                    /** Image of Tyres */
                    $image1 = asset('storage/pesticides/' . $tr->image1);
                    $image2 = asset('storage/pesticides/' . $tr->image2);
                    $image3 = asset('storage/pesticides/' . $tr->image3);

                    /** Date of Create at */
                    $create     = $tr->created_at;
                    $newtime    = strtotime($create);
                    $created_at = date('M d, Y', $newtime);

                    /** Date of Update at */
                    $update      = $tr->updated_at;
                    $newtime1    = strtotime($update);
                    $updated_at  = date('M d, Y', $newtime1);

                    /** Distance Show */
                    $d = round($tr->distance);
                    if ($d == null) {
                        $distance = 0;
                    } else {
                        $distance = $d;
                    }

                    /** District Name */
                    $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;
                    $state_name    = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

                    $pesticide_array = array();

                    $pesticide_array['distance']          =  $distance;

                    $user_count                     = DB::table('user')->where(['id' => $tr->user_id])->count();
                    if ($user_count > 0) {
                        $user_details  = DB::table('user')->where(['id' => $tr->user_id])->first();
                        $pesticide_array['user_id']         = $user_details->id;
                        $pesticide_array['user_type_id']    = $user_details->user_type_id;
                        $pesticide_array['role_id']         = $user_details->role_id;
                        $pesticide_array['name']            = $user_details->name;
                        $pesticide_array['company_name']    = $user_details->company_name;
                        $pesticide_array['mobile']          = $user_details->mobile;
                        $pesticide_array['email']           = $user_details->email;
                        $pesticide_array['gender']          = $user_details->gender;
                        $pesticide_array['address']         = $user_details->address;
                        $pesticide_array['zipcode']         = $user_details->zipcode;
                        $pesticide_array['device_id']       = $user_details->device_id;
                        $pesticide_array['firebase_token']  = $user_details->firebase_token;
                        $pesticide_array['created_at_user'] = $user_details->created_at;
                        if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                            $pesticide_array['photo'] = '';
                        } else {
                            $pesticide_array['photo'] = env('APP_URL') . "storage/photo/$user_details->photo";
                        }
                    }

                    $pesticide_array['id']                =  $tr->id;
                    $pesticide_array['city_name']         =  $tr->city_name;
                    $pesticide_array['category_id']       =  $tr->category_id;
                    $pesticide_array['user_id']           =  $tr->user_id;
                    $pesticide_array['title']             =  $tr->title;
                    $pesticide_array['description']       =  $tr->description;
                    $pesticide_array['price']             =  $tr->price;
                    $pesticide_array['is_negotiable']     =  $tr->is_negotiable;

                    if (!empty($tr->image1)) {
                        $pesticide_array['image1'] =  $image1;
                    }
                    if (!empty($tr->image2)) {
                        $pesticide_array['image2'] =  $image2;
                    }
                    if (!empty($tr->image3)) {
                        $pesticide_array['image3'] =  $image3;
                    }

                    $pesticide_array['country_id']           =  $tr->country_id;
                    $pesticide_array['state_id']             =  $tr->state_id;
                    $pesticide_array['district_id']          =  $tr->district_id;
                    $pesticide_array['city_id']              =  $tr->city_id;
                    $pesticide_array['pincode']              =  $tr->pincode;
                    $pesticide_array['latlong']              =  $tr->latlong;
                    $pesticide_array['is_featured']          =  $tr->is_featured;
                    $pesticide_array['valid_till']           =  $tr->valid_till;
                    $pesticide_array['ad_report']            =  $tr->ad_report;
                    $pesticide_array['status']               =  $tr->status;
                    $pesticide_array['created_at']           =  $tr->created_at;
                    $pesticide_array['updated_at']           =  $updated_at;
                    $pesticide_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                    $pesticide_array['rejected_by']          =  $tr->rejected_by;
                    $pesticide_array['rejected_at']          =  $tr->rejected_at;
                    $pesticide_array['approved_by']          =  $tr->approved_by;
                    $pesticide_array['approved_at']          =  $tr->approved_at;
                    $pesticide_array['district_name']        =  $district_name;

                    $pesticide_array['state_name']           =  $state_name;
                    $pesticide_array['wishlist_status']      = DB::table('wishlist')->where(['user_id' => $tr->user_id, 'category_id' => 8, 'item_id' => $tr->id])->count();
                    $pesticide_array['view_lead']            = Leads_view::where(['category_id' => 8, 'post_id' => $tr->id])->count();
                    $pesticide_array['call_lead']            = Lead::where(['category_id' => 8, 'post_id' => $tr->id, 'calls_status' => 1])->count();
                    $pesticide_array['msg_lead']             = Lead::where(['category_id' => 8, 'post_id' => $tr->id, 'messages_status' => 1])->count();

                    $data['8'][$key] = $pesticide_array;
                }
            } else if ($pes_count == 0) {
                $data['8'] = [];
            }

            /** Fertilizer Post */
            if ($fer_count > 0) {
                foreach ($fer_list as $key => $tr) {
                    $output = [];

                    /** Image of Tyres */
                    $image1 = asset('storage/fertilizers/' . $tr->image1);
                    $image2 = asset('storage/fertilizers/' . $tr->image2);
                    $image3 = asset('storage/fertilizers/' . $tr->image3);

                    /** Date of Create at */
                    $create     = $tr->created_at;
                    $newtime    = strtotime($create);
                    $created_at = date('M d, Y', $newtime);

                    /** Date of Update at */
                    $update      = $tr->updated_at;
                    $newtime1    = strtotime($update);
                    $updated_at  = date('M d, Y', $newtime1);

                    /** Distance Show */
                    $d = round($tr->distance);
                    if ($d == null) {
                        $distance = 0;
                    } else {
                        $distance = $d;
                    }

                    /** District Name */
                    $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;
                    $state_name    = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

                    $fertilizers_array = array();

                    $fertilizers_array['distance']          =  $distance;

                    $user_count                             = DB::table('user')->where(['id' => $tr->user_id])->count();
                    if ($user_count > 0) {
                        $user_details  = DB::table('user')->where(['id' => $tr->user_id])->first();
                        $fertilizers_array['user_id']         = $user_details->id;
                        $fertilizers_array['user_type_id']    = $user_details->user_type_id;
                        $fertilizers_array['role_id']         = $user_details->role_id;
                        $fertilizers_array['name']            = $user_details->name;
                        $fertilizers_array['company_name']    = $user_details->company_name;
                        $fertilizers_array['mobile']          = $user_details->mobile;
                        $fertilizers_array['email']           = $user_details->email;
                        $fertilizers_array['gender']          = $user_details->gender;
                        $fertilizers_array['address']         = $user_details->address;
                        $fertilizers_array['zipcode']         = $user_details->zipcode;
                        $fertilizers_array['device_id']       = $user_details->device_id;
                        $fertilizers_array['firebase_token']  = $user_details->firebase_token;
                        $fertilizers_array['created_at_user'] = $user_details->created_at;
                        if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                            $fertilizers_array['photo'] = '';
                        } else {
                            $fertilizers_array['photo'] = env('APP_URL') . "storage/photo/$user_details->photo";
                        }
                    }

                    $fertilizers_array['id']                =  $tr->id;
                    $fertilizers_array['city_name']         =  $tr->city_name;
                    $fertilizers_array['category_id']       =  $tr->category_id;
                    $fertilizers_array['user_id']           =  $tr->user_id;
                    $fertilizers_array['title']             =  $tr->title;
                    $fertilizers_array['description']       =  $tr->description;
                    $fertilizers_array['price']             =  $tr->price;
                    $fertilizers_array['is_negotiable']     =  $tr->is_negotiable;

                    if (!empty($tr->image1)) {
                        $fertilizers_array['image1'] =  $image1;
                    }
                    if (!empty($tr->image2)) {
                        $fertilizers_array['image2'] =  $image2;
                    }
                    if (!empty($tr->image3)) {
                        $fertilizers_array['image3'] =  $image3;
                    }

                    $fertilizers_array['country_id']           =  $tr->country_id;
                    $fertilizers_array['state_id']             =  $tr->state_id;
                    $fertilizers_array['district_id']          =  $tr->district_id;
                    $fertilizers_array['city_id']              =  $tr->city_id;
                    $fertilizers_array['pincode']              =  $tr->pincode;
                    $fertilizers_array['latlong']              =  $tr->latlong;
                    $fertilizers_array['is_featured']          =  $tr->is_featured;
                    $fertilizers_array['valid_till']           =  $tr->valid_till;
                    $fertilizers_array['ad_report']            =  $tr->ad_report;
                    $fertilizers_array['status']               =  $tr->status;
                    $fertilizers_array['created_at']           =  $tr->created_at;
                    $fertilizers_array['updated_at']           =  $updated_at;
                    $fertilizers_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                    $fertilizers_array['rejected_by']          =  $tr->rejected_by;
                    $fertilizers_array['rejected_at']          =  $tr->rejected_at;
                    $fertilizers_array['approved_by']          =  $tr->approved_by;
                    $fertilizers_array['approved_at']          =  $tr->approved_at;
                    $fertilizers_array['district_name']        =  $district_name;

                    $fertilizers_array['state_name']           =  $state_name;
                    $fertilizers_array['wishlist_status']      = DB::table('wishlist')->where(['user_id' => $tr->user_id, 'category_id' => 9, 'item_id' => $tr->id])->count();
                    $fertilizers_array['view_lead']            = Leads_view::where(['category_id' => 9, 'post_id' => $tr->id])->count();
                    $fertilizers_array['call_lead']            = Lead::where(['category_id' => 9, 'post_id' => $tr->id, 'calls_status' => 1])->count();
                    $fertilizers_array['msg_lead']             = Lead::where(['category_id' => 9, 'post_id' => $tr->id, 'messages_status' => 1])->count();

                    $data['9'][$key] = $fertilizers_array;
                }
            } else if ($fer_count == 0) {
                $data['9'] = [];
            }


            $user_array = array();
            $user_count  = DB::table('user')->where(['id' => $banner_user_id->user_id])->count();
            if ($user_count > 0) {
                $user_details                  = DB::table('user')->where(['id' => $banner_user_id->user_id])->first();
                $user_array['banner_image']    = $banner_image;
                $user_array['banner_name']     = $campaign_name;
                $user_array['user_id']         = $user_details->id;
                $user_array['user_type_id']    = $user_details->user_type_id;
                $user_array['role_id']         = $user_details->role_id;
                $user_array['name']            = $user_details->name;
                $user_array['company_name']    = $user_details->company_name;
                $user_array['mobile']          = $user_details->mobile;
                $user_array['email']           = $user_details->email;
                $user_array['gender']          = $user_details->gender;
                $user_array['address']         = $user_details->address;
                $user_array['zipcode']         = $user_details->zipcode;
                $user_array['device_id']       = $user_details->device_id;
                $user_array['firebase_token']  = $user_details->firebase_token;
                $user_array['created_at_user'] = $user_details->created_at;
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $user_array['photo'] = '';
                } else {
                    $user_array['photo'] = env('APP_URL') . "storage/photo/$user_details->photo";
                }
                $user_array['user_token'] = $user_details->token;
            }

            if (!empty($data)) {
                $output['response']           = true;
                $output['message']            = 'Lead User All Product Post Details';
                $output['data']               = $data;
                $output['banner_post_user']   = $user_array;
                $output['error']              = "";
            } else {
                $output['response']       = false;
                $output['message']        = 'No Data Available';
                $output['data']           = [];
            }
        } else {
            $output['response']       = false;
            $output['message']        = 'No Data Available';
            $output['data']           = [];
        }

        return $output;
    }
}
