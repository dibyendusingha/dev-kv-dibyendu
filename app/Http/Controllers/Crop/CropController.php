<?php

namespace App\Http\Controllers\Crop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Redirect;
use App\Models\Subscription\Subscription;
use App\Models\Crops\CropSubscription;
use App\Models\Crops\CropSubscriptionFeatures;
use App\Models\Crops\Crops;
use App\Models\Crops\CropsBoost;
use App\Models\Crops\CropsBanner;
use App\Models\Crops\CropsSubscribed;
use App\Models\Crops\CropsSMS;
use DateTime;

class CropController extends Controller
{
    # CROPS ADD PAGE
    public function addCropPage()
    {
        return view('admin.Crops.add_crop_post');
    }

    # CROPS SUBSCRIBED POST ADD PAGE
    public function addSubscribedCropPage($crops_subscribed_id)
    {
        $crop_subscribed_post = DB::table('cropsSubscribedView')->where('subscribed_id', $crops_subscribed_id)->first();
        $crops_category   = DB::table('crops_category')->where('status', 1)->get();
        return view('admin.Crops.add-subscribed-crops-post', [
            'crop_subscribed_post' => $crop_subscribed_post,
            'crops_category' => $crops_category
        ]);
    }

    # CROPS AND BANNER POST 
    public function addCropBannerPage($crops_subscribed_id)
    {
        $crops_count = DB::table('crops')->where('crops_subscribed_id', $crops_subscribed_id)->count();
        $banner_count = DB::table('crops_banners')->where('crop_subscribed_id', $crops_subscribed_id)->count();

        $subscription_id = CropsSubscribed::where('id', $crops_subscribed_id)->value('subscription_id');
        $subscription_feature = CropSubscriptionFeatures::where('crops_subscription_id', $subscription_id)->first();
        return view('admin.Crops.add-crop-banner-boost-post', [
            'crops_count' => $crops_count, 'banner_count' => $banner_count,
            'subscription_feature' => $subscription_feature
        ]);
    }

    public function editCropPage()
    {
        return view('admin.Crops.edit_crop_post');
    }

    # CROPS SUBSCRIPTION USER
    public function cropListPage()
    {
        $crop_subscribed_count = DB::table('crops_subscribeds')->count();
        $crop_subscribed_details = DB::table('cropsSubscribedView')->get();
        if ($crop_subscribed_count > 0) {
            $active_user = DB::table('crops_subscribeds')->where('status', 1)->count();
            $expiry_user = DB::table('crops_subscribeds')->where('status', 5)->count();
        } else {
            $active_user = 0;
            $expiry_user = 0;
        }

        return view('admin.Crops.crops-post-list', [
            'active_user' => $active_user, 'expiry_user' => $expiry_user,
            'crop_subscribed_count' => $crop_subscribed_count, 'crop_subscribed_details' => $crop_subscribed_details
        ]);
    }

    # CROPS LIST
    public function cropsPostList()
    {
        $active_crops   = DB::table('crops')->where('status', 1)->count();
        $inactive_crops = DB::table('crops')->where('status', 5)->count();
        $pending_crops  = DB::table('crops')->where('status', 0)->count();
        $reject_crops   = DB::table('crops')->where('status', 2)->count();
        $crops_count    = DB::table('crops')->count();

        $crop_list = DB::table('crops')
            ->select(
                'user.name',
                'user.mobile',
                'user.user_type_id',
                'crops_category.crops_cat_name',
                'crops.status as crop_status',
                'crops.crops_subscribed_id as crop_crops_subscribed_id',
                'crops.id as crops_id',
                'crops.created_at as crops_created_at',
                'csv.crop_subscriptions_name'
            )
            ->leftJoin('user', 'crops.user_id', '=', 'user.id')
            ->leftJoin('crops_category', 'crops.crops_category_id', '=', 'crops_category.id')
            ->leftJoin('cropsSubscribedView as csv', 'crops.crops_subscribed_id', '=', 'csv.subscribed_id')
            ->orderBy('crops.id', 'desc')
            ->get();

        return view('admin.Crops.crops_post_list', [
            'pending_crops' => $pending_crops, 'active_crops' => $active_crops, 'inactive_crops' => $inactive_crops,
            'reject_crops' => $reject_crops, 'crops_count' => $crops_count, 'crop_list' => $crop_list
        ]);
    }

    # CROPS OTP - PAGE
    public function cropOtpPage()
    {
        return view('admin.Crops.otp-verify');
    }

    # CROPS DETAILS PAGE
    public function cropPostDetailsPage($crops_id)
    {
        $subscribed_id   = DB::table('crops')->where('id', $crops_id)->value('crops_subscribed_id');
        $subscription_id = DB::table('crops_subscribeds')->where('id', $subscribed_id)->value('subscription_id');

        $subscription_feature = DB::table('crop_subscription_features')->where('crops_subscription_id', $subscription_id)->first();

        $crop_details = DB::table('crops')
            ->select(
                'crops.*',
                'cc.crops_cat_name',
                'user.name as username',
                'user.user_type_id',
                'user.mobile as usermobile',
                'state.state_name',
                'district.district_name',
                'city.city_name'
            )
            ->leftJoin('crops_category as cc', 'cc.id', '=', 'crops.crops_category_id')
            ->leftJoin('user', 'user.id', '=', 'crops.user_id')
            ->leftJoin('state', 'state.id', '=', 'crops.state_id')
            ->leftJoin('district', 'district.id', '=', 'crops.district_id')
            ->leftJoin('city', 'city.id', '=', 'crops.city_id')
            ->where('crops.id', $crops_id)
            ->first();


        $lead_online = DB::table('seller_leads as s')
            ->select('u.name', 'u.user_type_id', 'u.mobile', 'u.zipcode', 's.user_id', 's.status', 's.id as seller_id', 's.created_at')
            ->leftJoin('user as u', 'u.id', '=', 's.user_id')
            ->where(['s.category_id' => 12, 's.post_id' => $crops_id])
            ->get();

        $lead_offline = DB::table('offline_leads')->where(['category_id' => 12, 'post_id' => $crops_id])->get();
        $uniqueData = [];
        if ($lead_online != null) {
            $seenIds = [];
            foreach ($lead_online as $item) {
                if (!in_array($item->user_id, $seenIds)) {
                    $uniqueData[] = $item;
                    $seenIds[] = $item->user_id;
                }
            }
        } else {
            $uniqueData = [];
        }

        $crops_boost_count = CropsBoost::where(['crop_id' => $crops_id, 'status' => 1])->count();

        $subscribed_crops_boost_count = CropsBoost::where(['crop_subscribed_id' => $subscribed_id])->count();

        return view('admin.Crops.crop-post-details', [
            'crop_details' => $crop_details, 'lead_online' => $uniqueData, 'offline_data' => $lead_offline,
            'subscription_feature' => $subscription_feature, 'subscribed_id' => $subscribed_id, 'crops_boost_count' => $crops_boost_count,
            'subscribed_crops_boost_count' => $subscribed_crops_boost_count
        ]);
    }

    # CROPS INVOICE PAGE
    public function cropInvoicesPage($crops_subscribed_id)
    {
        $crops_subscribed_details = DB::table('cropsSubscribedView')->where('subscribed_id', $crops_subscribed_id)->first();

        if (!empty($crops_subscribed_details->username)) {
            $user_name = $crops_subscribed_details->username;
        } else {
            $user_name = "";
        }

        if (!empty($crops_subscribed_details->user_mobile)) {
            $user_mobile = $crops_subscribed_details->user_mobile;
        } else {
            $user_mobile = "";
        }

        if (!empty($crops_subscribed_details->user_zipcode)) {
            $user_zipcode = $crops_subscribed_details->user_zipcode;
        } else {
            $user_zipcode = '700029';
        }

        $crops              = CropsSubscribed::where('id', $crops_subscribed_id)->first();
        $user_id            = $crops->user_id;
        $user               = DB::table('user')->where('id', $user_id)->first();

        if (!empty($user->state_id)) {
            $user_state_name    = DB::table('state')->where('id', $user->state_id)->value('state_name');
        } else {
            $user_state_name = "WestBengal";
        }

        if (!empty($user->district_id)) {
            $user_district_name = DB::table('district')->where('id', $user->district_id)->value('district_name');
        } else {
            $user_district_name = "Kolkata";
        }

        if (!empty($user->city_id)) {
            $user_city_name     = DB::table('city')->where('id', $user->city_id)->value('city_name');
        } else {
            $user_city_name = "Kolkata";
        }

        $invoice_no         = $crops_subscribed_details->invoice_no;
        $invoice_start_date = $crops_subscribed_details->start_date;
        $invoice_end_date   = $crops_subscribed_details->end_date;

        $dateString_start = $invoice_start_date;
        $timestamp_start  = strtotime($dateString_start);
        $start_date       = date("d F Y", $timestamp_start);

        $dateString_end = $invoice_end_date;
        $timestamp_end  = strtotime($dateString_end);
        $end_date       = date("d F Y", $timestamp_end);

        $plane_name         = $crops_subscribed_details->crop_subscriptions_name;
        $plane_price        = $crops_subscribed_details->subscription_price;


        if (!empty($crops_subscribed_details->gst)) {
            $gst = $crops_subscribed_details->gst;
        } else {
            $gst = 0;
        }

        if (!empty($crops_subscribed_details->sgst)) {
            $sgst = $crops_subscribed_details->sgst;
        } else {
            $sgst = 0;
        }

        if (!empty($crops_subscribed_details->cgst)) {
            $cgst = $crops_subscribed_details->cgst;
        } else {
            $cgst = 0;
        }

        if (!empty($crops_subscribed_details->igst)) {
            $igst = $crops_subscribed_details->igst;
        } else {
            $igst = 0;
        }

        if (!empty($crops_subscribed_details->discount)) {
            $discount = $crops_subscribed_details->discount;
        } else {
            $discount = 0;
        }

        $total_price = $crops_subscribed_details->purchased_price;

        return view('admin.Crops.crops_invoice', [
            'user_name' => $user_name, 'user_mobile' => $user_mobile, 'user_zipcode' => $user_zipcode,
            'user_state_name' => $user_state_name, 'user_district_name' => $user_district_name, 'user_city_name' => $user_city_name, 'invoice_no' => $invoice_no,
            'invoice_start_date' => $start_date, 'invoice_end_date' => $end_date, 'plane_name' => $plane_name, 'plane_price' => $plane_price,
            'gst' => $gst, 'sgst' => $sgst, 'cgst' => $cgst, 'igst' => $igst, 'discount' => $discount, 'total_price' => $total_price
        ]);
    }

    # CROPS BOOST PAGE
    public function cropsBoostPage($crops_subscribed_id, $crop_id)
    {
        $crop_subscribed = DB::table('cropsSubscribedView')->where('subscribed_id', $crops_subscribed_id)->first();
        $crop_details = DB::table('crops as c')
            ->select('cc.crops_cat_name', 'cc.id as crops_category_id', 'c.id as crop_id')
            ->leftJoin('crops_category as cc', 'c.crops_category_id', '=', 'cc.id')
            ->where('crops_subscribed_id', $crops_subscribed_id)
            ->where('c.id', $crop_id)
            ->first();

        return view('admin.Crops.crop-boost', ['crop_subscribed' => $crop_subscribed, 'crop_details' => $crop_details]);
    }

    # CROPS BANNER PAGE
    public function cropsBannerPage()
    {
        $state = DB::table('state')->select('state.id', 'state.state_name')->get();
        return view('admin.Crops.crop-banner', ['state' => $state]);
    }

    # CROPS BANNER LIST PAGE
    public function cropsBannerListPage()
    {
        $crop_banner_list = DB::table('crops_banners as cb')
            ->select('csv.*', 'cb.status as banner_status', 'cb.image as banner_image', 'cb.id as crop_banner_id')
            ->leftJoin('cropsSubscribedView as csv', 'csv.subscribed_id', '=', 'cb.crop_subscribed_id')
            ->orderBy('cb.id', 'desc')
            ->get();

        $active_banner  = DB::table('crops_banners')->where('status', 1)->count();
        $expiry_banner  = DB::table('crops_banners')->where('status', 5)->count();
        $pending_banner = DB::table('crops_banners')->where('status', 0)->count();
        $reject_banner  = DB::table('crops_banners')->where('status', 2)->count();

        return view('admin.Crops.crop-banner-list', [
            'crop_banner_list' => $crop_banner_list,
            'active_banner' => $active_banner, 'expiry_banner' => $expiry_banner, 'pending_banner' => $pending_banner,
            'reject_banner' => $reject_banner
        ]);
    }

    # CROPS BANNER DETAILS PAGE
    public function cropsBannerDetailsPage($crops_banner_id)
    {
        $crops_subscribed_id = DB::table('crops_banners')->where('id', $crops_banner_id)->value('crop_subscribed_id');
        $banner_details = DB::table('cropsSubscribedView')->where('subscribed_id', $crops_subscribed_id)->first();
        $banner_lead_list = DB::table('crops_banner_leads as bl')
            ->select('u.name', 'u.mobile', 'u.user_type_id', 'u.zipcode', 'bl.status', 'bl.id as banner_lead_id')
            ->leftJoin('user as u', 'u.id', '=', 'bl.lead_user_id')
            ->where('bl.crops_banner_id', $crops_banner_id)
            ->get();

        $crops_state_id = DB::table('crops_banners')->where('id', $crops_banner_id)->value('state_id');
        $banner_state_id = json_decode($crops_state_id, true);
        $state = [];
        foreach ($banner_state_id as $key => $state_id) {
            $state = DB::table('state')->where('id', $state_id)->first()->state_name;
            $state_name[] = $state;
        }

        $crops_banner = DB::table('crops_banners')->where('id', $crops_banner_id)->first();
        $crop_id = DB::table('crops_banners')->where('id', $crops_banner_id)->value('crop_id');

        $crop_details = DB::table('crops')->where('id', $crop_id)->first();
        //dd($crop_details);
        $user_name        = DB::table('user')->where('id', $crop_details->user_id)->value('name');
        $user_mobile      = DB::table('user')->where('id', $crop_details->user_id)->value('mobile');
        $user_zipcode     = DB::table('user')->where('id', $crop_details->user_id)->value('zipcode');
        $user_state_name  = DB::table('state')->where('id', $crop_details->state_id)->value('state_name');
        $district_name    = DB::table('district')->where('id', $crop_details->district_id)->value('district_name');
        $city_name        = DB::table('city')->where('id', $crop_details->city_id)->value('city_name');

        return view('admin.Crops.crop-banner-details', [
            'banner_details' => $banner_details, 'state_name' => $state_name,
            'crops_banner' => $crops_banner, 'crop_banner_lead_list' => $banner_lead_list, 'user_name' => $user_name, 'user_mobile' => $user_mobile,
            'user_state_name' => $user_state_name, 'district_name' => $district_name, 'city_name' => $city_name, 'user_zipcode' => $user_zipcode
        ]);
    }

    # CROPS UPDATE BANNER LEAD
    public function update_crops_banner_lead(Request $request, $banner_lead_id)
    {
        $update = DB::table('crops_banner_leads')->where('id', $banner_lead_id)->update(['status' => $request->lead_status]);
        return redirect()->back()->with('success', 'Lead status changed successfully.');
    }

    # CROPS BOOST LIST PAGE
    public function cropsBoostListPage()
    {
        $crop_boost_list = DB::table('crops_boosts as cb')
            ->select('csv.*', 'cb.status as boost_status', 'cc.crops_cat_name', 'cb.crop_id')
            ->leftJoin('cropsSubscribedView as csv', 'csv.subscribed_id', '=', 'cb.crop_subscribed_id')
            ->leftJoin('crops_category as cc', 'cc.id', '=', 'cb.crop_category_id')
            ->orderBy('cb.id', 'desc')
            ->get();
        $active_boost   = DB::table('crops_boosts')->where('status', 1)->count();
        $inactive_boost = DB::table('crops_boosts')->where('status', 2)->count();

        return view('admin.Crops.crop-boost-list', [
            'crop_boost_list' => $crop_boost_list, 'inactive_boost' => $inactive_boost,
            'active_boost' => $active_boost
        ]);
    }

    # CROPS CATEGORY LIST PAGE
    public function cropsCategoryListPage()
    {
        $crops_category_list = DB::table('crops_category')->where('status', 1)->get();
        return view('admin.Crops.crop-category-list', ['crops_category_list' => $crops_category_list]);
    }

    # CROPS CATEGORY ID WISH PRODUCT LIST 
    public function cropsCategoryWishProductPage($crops_category_id)
    {
        $crops_id     = DB::table('crops')->where('crops_category_id', $crops_category_id)->value('id');
        $crop_subscribed_count   = DB::table('crops_subscribeds')->count();

        $crop_subscribed_details  = DB::table('crops')
            ->select(
                'user.name',
                'user.user_type_id',
                'user.user_type_id',
                'user.mobile',
                'crops.created_at as crops_created_at',
                'crops.status as crops_status',
                'crops.crops_subscribed_id',
                'crop_subscriptions_name',
                'crops.id as crops_id',
                'cc.crops_cat_name',
                'crops.id as crop_id'
            )
            ->leftJoin('user', 'crops.user_id', '=', 'user.id')
            ->leftJoin('cropsSubscribedView as csv', 'crops.crops_subscribed_id', '=', 'csv.subscribed_id')
            ->leftJoin('crops_category as cc', 'cc.id', '=', 'crops.crops_category_id')
            ->where('crops.crops_category_id', $crops_category_id)
            ->orderBy('crops.id', 'desc')
            ->get();


        $active_crop  = DB::table('crops')->where('crops_category_id', $crops_category_id)->where('status', 1)->count();
        $expiry_crop  = DB::table('crops')->where('crops_category_id', $crops_category_id)->where('status', 2)->count();
        $pending_crop = DB::table('crops')->where('crops_category_id', $crops_category_id)->where('status', 0)->count();
        $reject_crop  = DB::table('crops')->where('crops_category_id', $crops_category_id)->where('status', 3)->count();


        return view('admin.Crops.crops-category-wish-product', [
            'active_crop' => $active_crop, 'expiry_crop' => $expiry_crop, 'pending_crop' => $pending_crop, 'reject_crop' => $reject_crop,
            'crop_subscribed_count' => $crop_subscribed_count, 'crop_subscribed_details' => $crop_subscribed_details,
            'crops_id' => $crops_id
        ]);
    }

    # SEARCH USER 
    public function searchCropUserMobile(Request $request)
    {
        //dd($request->all());
        $validatedData = $request->validate([
            'mobile_no' => 'required|regex:/[0-9]{10}/',
        ], [
            'mobile_no.required' => 'Please enter mobile number'
        ]);


        $userData = DB::table('user')->where('mobile', $request->mobile_no)->first();

        $packageName    = CropSubscription::where('status', 1)->get();
        $crops_category = DB::table('crops_category')->where(['category_id' => 12, 'status' => '1'])->get();
        //dd($crops_category);
        if (!empty($userData) && $userData != null) {
            if ($userData->user_type_id == 3 || $userData->user_type_id == 4 || $userData->user_type_id == 2) {
                return view('admin.Crops.add_crop_post', ['userData' => $userData, 'packageName' => $packageName, 'crops_category' => $crops_category]);
            } else {
                return redirect('add-krishi-crops-post')->with('message', 'Only Dealer , Exchager , Seller can use.');
            }
        } else {
            return redirect('add-krishi-crops-post')->with('message', 'Mobile number not exist.');
        }
    }

    # PACKAGE DETAILS
    public function package_details(Request $request)
    {
        $package_id = $request->package_id;
        $pack_details = CropSubscriptionFeatures::where('id', $package_id)->where('status', 1)->first();
        $days  = $pack_details->days;
        $price = $pack_details->price;

        $dateData   =  Carbon::now();
        $start_date = date("d-m-Y ", strtotime($dateData));

        $eDate       = $dateData->addDays($days);
        $dateDatas   = $eDate->format('d-m-Y');
        $end_date    = date("d-m-Y", strtotime($dateDatas));

        return response()->json(['package_days' => $days, 'price' => $price, 'start_date' => $start_date, 'end_date' => $end_date]);
    }

    # ZIPCODE WISH ADDRESS DETAILS
    public function address_details(Request $request)
    {
        $zipcode = $request->zipcode;
        $dataLength = strlen($request->zipcode);
        //  dd($dataLength);
        if ($dataLength == 6) {
            $city_count = DB::table('city')->where('pincode', $zipcode)->count();
            // dd($city_count);
            if ($city_count > 0) {
                $address = DB::table('city')
                    ->select('city.id as city_id', 'city.city_name', 'city.state_id', 'state.state_name', 'city.district_id', 'district.district_name')
                    ->leftJoin('state', 'state.id', '=', 'city.state_id')
                    ->leftJoin('district', 'district.id', '=', 'city.district_id')
                    ->where('pincode', $zipcode)
                    ->first();

                $state_id      = $address->state_id;
                $state_name    = $address->state_name;
                $district_id   = $address->district_id;
                $district_name = $address->district_name;
                $city_id       = $address->city_id;
                $city_name     = $address->city_name;
            } else {
                $state_id      = 37;
                $state_name    = 'West Bengal';
                $district_id   = 730;
                $district_name = 'Kolkata';
                $city_id       = 18032;
                $city_name     = 'Kolkata';
            }

            return response()->json([
                'state_id' => $state_id, 'state_name' => $state_name, 'district_id' => $district_id,
                'district_name' => $district_name, 'city_id' => $city_id, 'city_name' => $city_name
            ]);
        }
    }

    # GST CALCULATION
    public function total_price(Request $request)
    {
        //dd($request->all());
        $package_price = $request->package_price;
        $type          = $request->type;

        if (!empty($request->discount)) {
            $discount = $request->discount;
            if ($type == 'GST') {
                $cost           = $package_price * (18 / 100);
                $total          = $package_price + $cost;
                $total_discount = ($total * $discount) / 100;
            } else if ($type == 'CGST' || $type == 'SGST') {
                $cost           = $package_price * (9 / 100);
                $total          = $package_price + $cost;
                $total_discount = ($total * $discount) / 100;
            } else if ($type == 'IGST') {
                $cost           = $package_price * (18 / 100);
                $total          = $package_price + $cost;
                $total_discount = ($total * $discount) / 100;
            }
            $totalAmount = ($total - $total_discount);
        } else if (empty($request->discount)) {
            if ($type == 'GST') {
                $cost  = $package_price * (18 / 100);
                $totalAmount = $package_price + $cost;
            } else if ($type == 'CGST' || $type == 'SGST') {
                $cost  = $package_price * (9 / 100);
                $totalAmount = $package_price + $cost;
            } else if ($type == 'IGST') {
                $cost  = $package_price * (18 / 100);
                $totalAmount = $package_price + $cost;
            }
        }

        $total_payment = number_format($totalAmount, 2, '.', '');

        return response()->json(['total_amount' => $total_payment]);
    }

    # ADD CROPS RESEND OTP
    public function resend_otp(Request $request)
    {

        $crops_subscribed_all = json_decode($request->crops_subscribed_all, true);
        // dd($crops_subscribed_all);

        $user_id = $crops_subscribed_all['user_id'];

        $mobile = DB::table('user')->where('id', $user_id)->value('mobile');
        //dd($mobile);

        $otp = rand(1000, 9999);
        $sms_code = $otp . '.';
        $message = 'Your Krishi Vikas Udyog verification code is ' . $sms_code . ' Please enter it in the required space to process your sign-up. | Krishi Vikas';
        //$message = 'Your OTP for offline product boost on Krishi Vikas is ' . $sms_code . ' Please enter the OTP in the required space to process further.';
        $encoded_message = urlencode($message);

        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $mobile . '&message=' . $encoded_message . '&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            echo "Error: " . $error_message;
        } else {
            $response = json_decode($res, true);
            curl_close($ch);
        }

        session()->put('OTP', $otp);

        return response()->json(['response' => 'success']);
    }

    # VERIFY SUBSCRIBED DATA
    public function verifyCropsData(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'user_id'          => 'required',
            'package_name'     => 'required',
            'type'             => 'required',
            'mode_transaction' => 'required',
            'total_payment'    => 'required',
            'down_payment'     => 'required',

        ]);


        $dateData =  Carbon::now();
        $startDate = date("Y-m-d H:i:s", strtotime($dateData));

        $eDate       = $dateData->addDays($request->package_days);
        $dateDatas   = $eDate->format('Y-m-d H:i:s');
        $endDate     = date("Y-m-d H:i:s", strtotime($dateDatas));

        if (!empty($request->transaction_id)) {
            $transaction_id = $request->transaction_id;
        } else {
            $transaction_id = "";
        }

        if (!empty($request->order_id)) {
            $order_id = $request->order_id;
        } else {
            $order_id = "";
        }

        $package_price = $request->package_price;
        $type = $request->type;
        if ($type == 'GST') {
            $gst = $package_price * (18 / 100);
        } else {
            $gst = null;
        }
        if ($type == 'SGST') {
            $sgst = $package_price * (9 / 100);
        } else {
            $sgst = null;
        }
        if ($type == 'CGST') {
            $cgst = $package_price * (9 / 100);
        } else {
            $cgst = null;
        }
        if ($type == 'IGST') {
            $igst = $package_price * (18 / 100);
        } else {
            $igst = null;
        }

        $date1 =  Carbon::now();
        $start_date = date("Y-m-d H:i:s", strtotime($date1));
        $financialYear = Subscription::getFinancialYear($start_date, "y"); //21-22 


        $getId = 0;
        $getId = DB::select("SELECT 
            LPAD(
                MAX(
                    CAST(
                        SUBSTRING(invoice_no, LENGTH('AECPL/OS-') + 1) AS UNSIGNED
                    )
                ),
                LENGTH(MAX(CAST(SUBSTRING(invoice_no, LENGTH('AECPL/OS-') + 1) AS UNSIGNED))), '0'
            ) AS max_invoice_number
                FROM (
                    SELECT invoice_no FROM promotion_coupons
                ) AS combined_tables");

        $invoiceId = $getId[0]->max_invoice_number + 1;

        if (!empty($request->down_payment)) {
            $down_payment = $request->down_payment;
        }

        $subscription_feature = CropSubscriptionFeatures::where('crops_subscription_id', $request->package_name)->first();
        $subscription_feature_id = $subscription_feature->id;
        $price                   = $subscription_feature->price;

        $crops_subscribed = [
            'subscription_id'         => $request->package_name,
            'subscription_feature_id' => $subscription_feature_id,
            'crops_category_id'       => null,
            'price'                   => $price,
            'user_id'                 => $request->user_id,
            'category_id'             => 12,
            'start_date'              => $startDate,
            'end_date'                => $endDate,
            'coupon_code_id'          => null,
            'coupon_code'             => null,
            'purchased_price'         => $request->total_payment,
            'transaction_id'          => $transaction_id,
            'order_id'                => $order_id,
            'gst'                     => $gst,
            'sgst'                    => $sgst,
            'cgst'                    => $cgst,
            'igst'                    => $igst,
            'invoice_no'              => "AECPL/" . str_pad($invoiceId, 5, "0", STR_PAD_LEFT) . "/" . $financialYear,
            'downpayment'             => $request->down_payment,
            'status'                  => 1,
            'created_at'              => Carbon::now(),
            'updated_at'              => Carbon::now()
        ];

        $mobile =  $request->phone_no;
        $otp = rand(1000, 9999);
        $sms_code = $otp . '.';
        $message = 'Your Krishi Vikas Udyog verification code is ' . $sms_code . ' Please enter it in the required space to process your sign-up. | Krishi Vikas';
        //$message = 'Your OTP for offline product boost on Krishi Vikas is ' . $sms_code . ' Please enter the OTP in the required space to process further.';
        $encoded_message = urlencode($message);

        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $mobile . '&message=' . $encoded_message . '&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            echo "Error: " . $error_message;
        } else {
            $response = json_decode($res, true);
            curl_close($ch);
        }

        session()->put('OTP', $otp);

        return view('admin.Crops.otp-verify', ['crops_subscribed' => $crops_subscribed]);
    }

    # ADD CROPS SUBSCRIBED 
    public function addCropsPost(Request $request)
    {
        $first = $request->first;
        $second = $request->second;
        $third = $request->third;
        $forth = $request->forth;

        $crops_otp = $first . $second . $third . $forth;

        $otp = session()->get('OTP');
        // dd($otp);
        $sentOtp = strval($otp);

        $crop_subscribed_data = json_decode($request->cropsSubscribedData, true);

        if ($crops_otp == $sentOtp) {
            $crops_subscribed = [
                'subscription_id'         => $crop_subscribed_data['subscription_id'],
                'subscription_feature_id' => $crop_subscribed_data['subscription_feature_id'],
                'crops_category_id'       => $crop_subscribed_data['crops_category_id'],
                'price'                   => $crop_subscribed_data['price'],
                'user_id'                 => $crop_subscribed_data['user_id'],
                'category_id'             => 12,
                'start_date'              => $crop_subscribed_data['start_date'],
                'end_date'                => $crop_subscribed_data['end_date'],
                'coupon_code_id'          => $crop_subscribed_data['coupon_code_id'],
                'coupon_code'             => $crop_subscribed_data['coupon_code'],
                'purchased_price'         => $crop_subscribed_data['purchased_price'],
                'transaction_id'          => $crop_subscribed_data['transaction_id'],
                'order_id'                => $crop_subscribed_data['order_id'],
                'gst'                     => $crop_subscribed_data['gst'],
                'sgst'                    => $crop_subscribed_data['sgst'],
                'cgst'                    => $crop_subscribed_data['cgst'],
                'igst'                    => $crop_subscribed_data['igst'],
                'invoice_no'              => $crop_subscribed_data['invoice_no'],
                'downpayment'             => $crop_subscribed_data['downpayment'],
                'status'                  => 1,
                'created_at'              => $crop_subscribed_data['created_at'],
                'updated_at'              => $crop_subscribed_data['updated_at']
            ];

            $add_crops_subscribed = CropsSubscribed::addCropsSubscribed($crops_subscribed);

            if ($add_crops_subscribed == true) {
                //dd("hi");
                CropsSMS::add_subscription($crop_subscribed_data['user_id'], $crop_subscribed_data['subscription_id']);
                return response()->json(['response' => 'success']);
            }
        } else {
            return response()->json(['response' => 'failed']);
        }
    }

    # CROPS SUBSCRIBE CROPS DATA
    public function verifySubscribedCropsData(Request $request, $crops_subscribed_id)
    {
        //dd($crops_subscribed_id);
        $request->validate([
            'user_id'        => 'required',
            'zipcode'        => 'required',
        ]);

        $dateData =  Carbon::now();
        $startDate = date("Y-m-d H:i:s", strtotime($dateData));

        $eDate       = $dateData->addDays($request->package_days);
        $dateDatas   = $eDate->format('Y-m-d H:i:s');
        $endDate     = date("Y-m-d H:i:s", strtotime($dateDatas));

        if (!empty($request->title)) {
            $title = $request->title;
        } else {
            $title = "";
        }

        // dd($startDate);

        if (!empty($request->image1)) {
            $image1 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image1')->getClientOriginalName();
            $ext = $request->file('image1')->getClientOriginalExtension();
            $request->file('image1')->storeAs('public/crops', $image1);
        } else {
            $image1 = "";
        }

        if (!empty($request->image2)) {
            $image2 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image2')->getClientOriginalName();
            $ext = $request->file('image2')->getClientOriginalExtension();
            $request->file('image2')->storeAs('public/crops', $image2);
        } else {
            $image2 = "";
        }

        if (!empty($request->image3)) {
            $image3 = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('image3')->getClientOriginalName();
            $ext = $request->file('image3')->getClientOriginalExtension();
            $request->file('image3')->storeAs('public/crops', $image3);
        } else {
            $image3 = "";
        }

        $package_price = $request->package_price;

        $date1 =  Carbon::now();
        $start_date = date("Y-m-d H:i:s", strtotime($date1));
        $financialYear = Subscription::getFinancialYear($start_date, "y"); //21-22 

        $getId = 0;
        $getId = DB::select("SELECT 
            LPAD(
                MAX(
                    CAST(
                        SUBSTRING(invoice_no, LENGTH('AECPL/OS-') + 1) AS UNSIGNED
                    )
                ),
                LENGTH(MAX(CAST(SUBSTRING(invoice_no, LENGTH('AECPL/OS-') + 1) AS UNSIGNED))), '0'
            ) AS max_invoice_number
                FROM (
                    SELECT invoice_no FROM promotion_coupons
                ) AS combined_tables");

        $invoiceId = $getId[0]->max_invoice_number + 1;

        if (!empty($request->down_payment)) {
            $down_payment = $request->down_payment;
        }


        $crop_data = [
            'crops_subscribed_id'   => $crops_subscribed_id,
            'category_id'           => 12,
            'user_id'               => $request->user_id,
            'type'                  => $request->crop_type,
            'title'                 => $request->title,
            'price'                 => $request->crop_price,
            'quantity'              => $request->quantity,
            'expiry_date'           => null,
            'valid_till'            => null,
            'crops_category_id'     => $request->crop_category_name,
            'image1'                => $image1,
            'image2'                => $image2,
            'image3'                => $image3,
            'is_negotiable'         => $request->is_negotiable,
            'country_id'            => 1,
            'state_id'              => $request->state_id,
            'district_id'           => $request->district_id,
            'city_id'               => $request->city_id,
            'pincode'               => $request->zipcode,
            'latlong'               => null,
            'description'           => $request->description,
            'is_featured'           => null,
            'ad_report'             => null,
            'status'                => 1,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
            'reason_for_rejection'  => null,
            'rejected_by'           => null,
            'rejected_at'           => null,
            'approved_by'           => 'Admin',
            'approved_at'           => Carbon::now()

        ];

        //dd($crop_data);

        $mobile =  $request->phone_no;
        $otp = rand(1000, 9999);
        $sms_code = $otp . '.';
        $message = 'Your Krishi Vikas Udyog verification code is ' . $sms_code . ' Please enter it in the required space to process your sign-up. | Krishi Vikas';
        //$message = 'Your OTP for offline product boost on Krishi Vikas is ' . $sms_code . ' Please enter the OTP in the required space to process further.';
        $encoded_message = urlencode($message);

        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $mobile . '&message=' . $encoded_message . '&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            echo "Error: " . $error_message;
        } else {
            $response = json_decode($res, true);
            curl_close($ch);
        }

        session()->put('OTP', $otp);

        return view('admin.Crops.subscribed-crops-otp-verify', ['subscribed_crops_data' => $crop_data]);
    }

    # CROPS POST
    public function addSubscribedCropsPost(Request $request)
    {
        $crops_subscribed_id = $request->crops_subscribed_id;

        $first = $request->first;
        $second = $request->second;
        $third = $request->third;
        $forth = $request->forth;

        $crops_otp = $first . $second . $third . $forth;

        $otp = session()->get('OTP');
        $sentOtp = strval($otp);

        $crop_data = json_decode($request->crops_data, true);

        if ($crops_otp == $sentOtp) {
            $crop_data = [
                'crops_subscribed_id'   => $crop_data['crops_subscribed_id'],
                'category_id'           => $crop_data['category_id'],
                'user_id'               => $crop_data['user_id'],
                'type'                  => $crop_data['type'],
                'title'                 => $crop_data['title'],
                'price'                 => $crop_data['price'],
                'quantity'              => $crop_data['quantity'],
                'expiry_date'           => $crop_data['expiry_date'],
                'valid_till'            => $crop_data['valid_till'],
                'crops_category_id'     => $crop_data['crops_category_id'],
                'image1'                => $crop_data['image1'],
                'image2'                => $crop_data['image2'],
                'image3'                => $crop_data['image3'],
                'is_negotiable'         => $crop_data['is_negotiable'],
                'country_id'            => 1,
                'state_id'              => $crop_data['state_id'],
                'district_id'           => $crop_data['district_id'],
                'city_id'               => $crop_data['city_id'],
                'pincode'               => $crop_data['pincode'],
                'latlong'               => $crop_data['latlong'],
                'description'           => $crop_data['description'],
                'is_featured'           => $crop_data['is_featured'],
                'ad_report'             => $crop_data['ad_report'],
                'status'                => 1,
                'created_at'            => $crop_data['created_at'],
                'updated_at'            => $crop_data['updated_at'],
                'reason_for_rejection'  => $crop_data['reason_for_rejection'],
                'rejected_by'           => $crop_data['rejected_by'],
                'rejected_at'           => $crop_data['rejected_at'],
                'approved_by'           => 'Admin',
                'approved_at'           => $crop_data['approved_at']

            ];

            $add_crops = Crops::addCrops($crop_data);

            if ($add_crops == true) {
                CropsSMS::add_crops($crop_data['user_id']);
                return response()->json(['response' => 'success']);
            }
        } else {
            return response()->json(['response' => 'failed']);
        }
    }

    # CROPS BOOST OR BANNER OTP SEND
    public function cropBoostOtpSend(Request $request)
    {
        // dd($request->all());
        $user_id = $request->user_id;
        $user    = DB::table('user')->where('id', $user_id)->first();
        $mobile  = $user->mobile;

        $rand = rand(1000, 9999);
        $sms_code = $rand . '.';
        $message = 'Your Krishi Vikas Udyog verification code is ' . $sms_code . ' Please enter it in the required space to process your sign-up. | Krishi Vikas';
        $encode_message = urlencode($message);
        $url = 'http://sms.osdigital.in/V2/http-api.php?apikey=T6g6MD0t57gQ6auG&senderid=KRVIKS&number=' . $mobile . '&message=' . $encode_message . '&format=json';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            // Handle the error appropriately, such as logging or returning an error response
            echo "Error: " . $error_message;
        } else {
            // Check the response from the API if needed
            $response = json_decode($res, true);
            // Process the response as required
            curl_close($ch);
        }

        session()->put('OTP', $rand);

        //dd($res);

        return $res;

        // $crops_boost_otp_send = CropsBoost::cropBoostOtp($mobile);
        // return $crops_boost_otp_send;
    }

    # ADD CROPS BOOST
    public function addCropBoost(Request $request, $crops_subscribed_id)
    {
        $first = $request->first;
        $second = $request->second;
        $third = $request->third;
        $forth = $request->forth;

        $crops_otp = $first . $second . $third . $forth;

        $otp = session()->get('OTP');
        //dd($otp);
        $sentOtp = strval($otp);
        if ($crops_otp == $sentOtp) {

            $crop_id = DB::table('crops')->where('crops_subscribed_id', $crops_subscribed_id)->value('id');

            $crop_data = [
                'crop_subscribed_id'    => $crops_subscribed_id,
                'category_id'           => 12,
                'crop_id'               => $request->crop_id,
                'crop_subscriptions_id' => $request->crop_subscription_id,
                'crop_category_id'      => $request->crops_category_id,
                'user_id'               => $request->user_id,
                'start_date'            => $request->start_date,
                'end_date'              => $request->end_date,
                'status'                => 1
            ];

            $crops_boost_product = CropsBoost::addCropBoost($crop_data);
            if ($crops_boost_product == true) {
                CropsSMS::add_boost($request->user_id);
                return Redirect::to('crops-post-details/' . $crop_id);
            }
        } else {
            return Redirect::to('crops-boost/' . $crops_subscribed_id)->with(['message' => 'OTP not matching']);
        }
    }

    # ADD CROPS BANNER
    public function addCropBanner(Request $request, $crops_subscribed_id)
    {
        //dd($request->all());
        $first = $request->first;
        $second = $request->second;
        $third = $request->third;
        $forth = $request->forth;

        $crops_otp = $first . $second . $third . $forth;

        $otp = session()->get('OTP');
        //dd($otp);
        $sentOtp = strval($otp);
        if ($crops_otp == $sentOtp) {

            $crop_id = DB::table('crops')->where('crops_subscribed_id', $crops_subscribed_id)->value('id');

            if (!empty($request->banner_img)) {
                //  dd($request->banner_img);
                $banner_img = date('Y-m-d-H-i-s') . rand(1000, 9999) . $request->file('banner_img')->getClientOriginalName();
                $ext = $request->file('banner_img')->getClientOriginalExtension();
                $request->file('banner_img')->storeAs('public/crops/banner', $banner_img);
            } else {
                $banner_img = "";
            }

            $state_id = json_encode($request->crops_state);

            $crop_data = [
                'crop_subscribed_id'    => $crops_subscribed_id,
                'category_id'           => 12,
                'crop_id'               => $crop_id,
                'crop_subscriptions_id' => $request->crop_subscription_id,
                'user_id'               => $request->user_id,
                'start_date'            => $request->start_date,
                'end_date'              => $request->end_date,
                'title'                 => $request->crops_title,
                'description'           => $request->crops_description,
                'image'                 => $banner_img,
                'state_id'              => $state_id,
                'status'                => 1
            ];

            $crops_boost_product = CropsBanner::addCropBanner($crop_data);
            if ($crops_boost_product == true) {
                CropsSMS::add_banner($request->user_id);
                return Redirect::to('krishi-crops-banner-post/' . $crops_subscribed_id);
            }
        } else {
            return Redirect::to('krishi-crops-banner-post/' . $crops_subscribed_id)->with(['message' => 'OTP not matching']);
        }
    }

    # CROPS BANNER LIST WISH SUBSCRIBED ID
    public function cropsBannerListWishSubscribedId($subscribed_id)
    {
        // dd($subscribed_id);
        $crop_banner_list = DB::table('crops_banners as cb')
            ->select('csv.*', 'cb.status as banner_status', 'cb.image as banner_image', 'cb.id as crop_banner_id')
            ->leftJoin('cropsSubscribedView as csv', 'csv.subscribed_id', '=', 'cb.crop_subscribed_id')
            ->orderBy('cb.id', 'desc')
            ->where('cb.crop_subscribed_id', $subscribed_id)
            ->orderByDesc('cb.id')
            ->get();

        $active_banner  = DB::table('crops_banners')->where('status', 1)->where('crop_subscribed_id', $subscribed_id)->count();
        $expiry_banner  = DB::table('crops_banners')->where('status', 2)->where('crop_subscribed_id', $subscribed_id)->count();
        $pending_banner = DB::table('crops_banners')->where('status', 0)->where('crop_subscribed_id', $subscribed_id)->count();
        $reject_banner  = DB::table('crops_banners')->where('status', 3)->where('crop_subscribed_id', $subscribed_id)->count();

        return view('admin.Crops.Banner.crop-banner-list', [
            'crop_banner_list' => $crop_banner_list,
            'active_banner' => $active_banner, 'expiry_banner' => $expiry_banner, 'pending_banner' => $pending_banner, 'reject_banner' => $reject_banner
        ]);
    }

    # CROPS LIST
    public function cropsPostListWishSubscribedId($subscribed_id)
    {
        $active_crops    = DB::table('crops')->where('status', 1)->where('crops_subscribed_id', $subscribed_id)->count();
        $inactive_crops  = DB::table('crops')->where('status', 2)->where('crops_subscribed_id', $subscribed_id)->count();
        $pending_crops   = DB::table('crops')->where('status', 0)->where('crops_subscribed_id', $subscribed_id)->count();
        $reject_crops    = DB::table('crops')->where('status', 3)->where('crops_subscribed_id', $subscribed_id)->count();
        $crops_count     = DB::table('crops')->count();

        $crop_list = DB::table('crops')
            ->select(
                'user.name',
                'user.mobile',
                'user.user_type_id',
                'crops_category.crops_cat_name',
                'crops.status as crop_status',
                'crops.crops_subscribed_id as crop_crops_subscribed_id',
                'crops.id as crops_id',
                'crops.created_at as crops_created_at',
                'csv.crop_subscriptions_name',
                'crops.id as crops_id'
            )
            ->leftJoin('user', 'crops.user_id', '=', 'user.id')
            ->leftJoin('crops_category', 'crops.crops_category_id', '=', 'crops_category.id')
            ->leftJoin('cropsSubscribedView as csv', 'crops.crops_subscribed_id', '=', 'csv.subscribed_id')
            ->where('crops.crops_subscribed_id', $subscribed_id)
            ->orderBy('crops.id', 'desc')
            ->get();

        // dd($crop_list);
        return view('admin.Crops.CropsPost.crops_post_list', [
            'active_crops' => $active_crops, 'inactive_crops' => $inactive_crops,
            'pending_crops' => $pending_crops, 'reject_crops' => $reject_crops, 'crops_count' => $crops_count, 'crop_list' => $crop_list
        ]);
    }

    # CROPS POST STATUS UPDATE
    public function cropsPostStatusUpdate(Request $request)
    {
        //dd($request->all());
        $user_id =  Crops::where('id', $request->crop_id)->value('user_id');
        if ($request->status == 1) {
            CropsSMS::add_crops($user_id);
            $crops_status_update = Crops::where('id', $request->crop_id)->update(['status' => $request->status]);
        } else {
            CropsSMS::reject_crops($user_id);
            $crops_status_update = Crops::where('id', $request->crop_id)->update(['status' => $request->status]);
        }
       
        return response()->json(['response' => 'success']);
    }

    # CROPS BANNER STATUS UPDATE
    public function cropsBannerStatusUpdate(Request $request)
    {
        //dd($request->all());

        $user_id =  DB::table('crops_banners')->where('id', $request->crops_banner_id)->value('user_id');
        if ($request->status == 1) {
            CropsSMS::add_banner($user_id);
            $crops_status_update = CropsBanner::where('id', $request->crops_banner_id)->update(['status' => $request->status]);
        } else if($request->status == 2) {
            CropsSMS::reject_banner($user_id);
            $crops_status_update = CropsBanner::where('id', $request->crops_banner_id)->update(['status' => $request->status]);
        }else{
            CropsSMS::reject_banner($user_id);
            $crops_status_update = CropsBanner::where('id', $request->crops_banner_id)->update(['status' => $request->status]);
        }
        // $crops_status_update = Crops::where('id', $request->crop_id)->update(['status' => $request->status]);
        return response()->json(['response' => 'success']);
    }

    # CROPS SUBSCRIBED LIST 
    public function cropSubscribedList(Request $request)
    {
        // dd($request->all());
        $status = $request->status;
        if ($status == 1 || $status == 5) {
            $sql = DB::table('cropsSubscribedView')->where('crops_subscribed_status', $status);
            $crop_subscribed_details = $sql->paginate(200);
            $crop_subscribed_details_count = $sql->count();
        } else if ($status == 0) {
            $sql = DB::table('cropsSubscribedView');
            $crop_subscribed_details = $sql->paginate(200);
            $crop_subscribed_details_count = $sql->count();
        }

        //dd($crop_subscribed_details_count);
        if (!empty($crop_subscribed_details_count > 0)) {
            // dd("hi");
            foreach ($crop_subscribed_details as $key => $cs) { ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $cs->username; ?></td>
                    <td>
                        <span class="badge rounded-pill alert-<?php if ($cs->user_type_id == 2) {
                                                                    echo 'success';
                                                                } else if ($cs->user_type_id == 3) {
                                                                    echo 'warning';
                                                                } else if ($cs->user_type_id == 4) {
                                                                    echo 'secondary';
                                                                } else {
                                                                    echo 'danger';
                                                                } ?>">
                            <?php if ($cs->user_type_id == 2) {
                                echo 'Seller';
                            } else if ($cs->user_type_id == 3) {
                                echo 'Dealer';
                            } else if ($cs->user_type_id == 4) {
                                echo 'Exchanger';
                            } ?>
                        </span>
                    </td>
                    <td><?= $cs->user_mobile; ?></td>
                    <td><?= $cs->crop_subscriptions_name; ?></td>

                    <td>
                        <?php
                        $created_at = $cs->crops_subscribed_created_at;
                        $date = new DateTime($created_at);
                        echo $date = $date->format('d-m-Y');
                        ?>
                    </td>
                    <td>
                        <?php if ($cs->crops_subscribed_status == 1) { ?>
                            <span class="badge rounded-pill alert-success">Active </span>
                        <?php } else { ?>
                            <span class="badge rounded-pill alert-danger">Expiry </span>
                        <?php  } ?>
                    </td>
                    <td class="text-end">
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" target="_blank" href="<?= url('crops-invoice/' . $cs->subscribed_id) ?>">Download Invoice</a>
                                <a class="dropdown-item" href="<?= url('krishi-crops-banner-post/' . $cs->subscribed_id) ?>">View Post</a>
                            </div>
                        </div>
                        <!-- dropdown //end -->
                    </td>
                <?php }
        } else { ?>
                <tr>
                    <td colspan="13" class="text-center fw-bold py-5 text-danger fs-1">
                        No Data found
                    </td>
                </tr>
                <?php }
        }

        # CROPS CATEGORY WISH SUBSCRIBE LIST

        public function cropCategorySubscribedList(Request $request)
        {
            // dd($request->all());
            $status = $request->status;
            $crops_category_id = $request->crops_category_id;
            if ($status == 1 || $status == 2 || $status == 0 || $status == 3) {
                $sql = DB::table('crops')
                    ->select(
                        'user.name',
                        'user.user_type_id',
                        'user.user_type_id',
                        'user.mobile',
                        'crops.created_at as crops_created_at',
                        'crops.status as crops_status',
                        'crops.crops_subscribed_id',
                        'crop_subscriptions_name',
                        'crops.id as crops_id',
                        'cc.crops_cat_name',
                        'crops.id as crop_id'
                    )
                    ->leftJoin('user', 'crops.user_id', '=', 'user.id')
                    ->leftJoin('cropsSubscribedView as csv', 'crops.crops_subscribed_id', '=', 'csv.subscribed_id')
                    ->leftJoin('crops_category as cc', 'cc.id', '=', 'crops.crops_category_id')
                    ->where('crops.crops_category_id', $crops_category_id)
                    ->orderBy('crops.id', 'desc')
                    ->where('crops.status', $request->status);

                $crop_subscribed_details = $sql->paginate(200);
                $crop_subscribed_details_count = $sql->count();
            } else if ($status == 4) {
                $sql = DB::table('crops')
                    ->select(
                        'user.name',
                        'user.user_type_id',
                        'user.user_type_id',
                        'user.mobile',
                        'crops.created_at as crops_created_at',
                        'crops.status as crops_status',
                        'crops.crops_subscribed_id',
                        'crop_subscriptions_name',
                        'crops.id as crops_id',
                        'cc.crops_cat_name',
                        'crops.id as crop_id'
                    )
                    ->leftJoin('user', 'crops.user_id', '=', 'user.id')
                    ->leftJoin('cropsSubscribedView as csv', 'crops.crops_subscribed_id', '=', 'csv.subscribed_id')
                    ->leftJoin('crops_category as cc', 'cc.id', '=', 'crops.crops_category_id')
                    ->where('crops.crops_category_id', $crops_category_id)
                    ->orderBy('crops.id', 'desc');

                $crop_subscribed_details = $sql->paginate(200);
                $crop_subscribed_details_count = $sql->count();
            }

            //dd($crop_subscribed_details_count);
            if (!empty($crop_subscribed_details_count > 0)) {
                // dd("hi");
                foreach ($crop_subscribed_details as $key => $cs) { ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $cs->name; ?></td>
                        <td>
                            <span class="badge rounded-pill alert-<?php if ($cs->user_type_id == 2) {
                                                                        echo 'success';
                                                                    } else if ($cs->user_type_id == 3) {
                                                                        echo 'warning';
                                                                    } else if ($cs->user_type_id == 4) {
                                                                        echo 'secondary';
                                                                    } else {
                                                                        echo 'danger';
                                                                    } ?>">
                                <?php if ($cs->user_type_id == 2) {
                                    echo 'Seller';
                                } else if ($cs->user_type_id == 3) {
                                    echo 'Dealer';
                                } else if ($cs->user_type_id == 4) {
                                    echo 'Exchanger';
                                } ?>
                            </span>
                        </td>
                        <td><?= $cs->mobile; ?></td>
                        <td><?= $cs->crop_subscriptions_name; ?></td>
                        <td><?= $cs->crops_cat_name; ?></td>
                        <td>
                            <?php
                            $created_at = $cs->crops_created_at;
                            $date = new DateTime($created_at);
                            echo $date = $date->format('d-m-Y');
                            ?>
                        </td>
                        <td>
                            <?php $boost_count = DB::table('crops_boosts')->where('crop_id', $cs->crops_id)->where('status', 1)->count();
                            if ($boost_count > 0) { ?>
                                <span class="badge rounded-pill alert-success">BOOST</span>
                            <?php } else { ?>
                                <span class="badge rounded-pill alert-danger">NO BOOST</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($cs->crops_status == 1) { ?>
                                <span class="d-inline-block bg-success text-white  text-center rounded" style="width: 100px">Active</span>
                            <?php } else if ($cs->crops_status == 2) { ?>
                                <span class="d-inline-block bg-danger text-white text-center  rounded" style="width: 100px">Expiry</span>
                            <?php } else if ($cs->crops_status == 0) { ?>
                                <span class="d-inline-block bg-warning text-white text-center  rounded" style="width: 100px">Pending</span>
                            <?php } else if ($cs->crops_status == 3) { ?>
                                <span class="d-inline-block bg-dark text-white text-center  rounded" style="width: 100px">Reject</span>
                            <?php } ?>
                        </td>
                        <td class="text-end">
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?= url('crops-post-details/' . $cs->crops_id) ?>">View Post</a>
                                </div>
                            </div>
                            <!-- dropdown //end -->
                        </td>
                    <?php }
            } else { ?>
                    <tr>
                        <td colspan="13" class="text-center fw-bold py-5 text-danger fs-1">
                            No Data found
                        </td>
                    </tr>
                    <?php }
            }


            # CROPS BANNER LIST
            public function cropBannerList(Request $request)
            {
                //dd($request->all());
                $status = $request->status;
                if ($status == 1 || $status == 2 || $status == 0 || $status == 3 || $status == 5) {
                    $sql = DB::table('crops_banners as cb')
                        ->select('csv.*', 'cb.status as banner_status', 'cb.image as banner_image', 'cb.id as crop_banner_id')
                        ->leftJoin('cropsSubscribedView as csv', 'csv.subscribed_id', '=', 'cb.crop_subscribed_id')
                        ->orderBy('cb.id', 'desc')
                        ->where('cb.status', $status);
                    // ->get();
                    $crop_banner_list = $sql->get();
                    $crop_banner_count = $sql->count();
                } else if ($status == 4) {
                    $sql = DB::table('crops_banners as cb')
                        ->select('csv.*', 'cb.status as banner_status', 'cb.image as banner_image', 'cb.id as crop_banner_id')
                        ->leftJoin('cropsSubscribedView as csv', 'csv.subscribed_id', '=', 'cb.crop_subscribed_id')
                        ->orderBy('cb.id', 'desc');
                    // ->get();
                    $crop_banner_list = $sql->get();
                    $crop_banner_count = $sql->count();
                }

                // dd($crop_banner_list);
                //dd($crop_subscribed_details_count);
                if (!empty($crop_banner_count > 0)) {
                    // dd("hi");
                    foreach ($crop_banner_list as $key => $crop) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td>
                                <img width="100" src="<?= asset('storage/crops/banner/' . $crop->banner_image) ?>" />
                            </td>
                            <<td><?= $crop->username ?></td>
                                <td><?= $crop->crop_subscriptions_name ?></td>
                                <td><?= $crop->invoice_no ?></td>
                                <td>
                                    <?php if ($crop->banner_status == 1) { ?>
                                        <span class="bg-success rounded p-1 text-white">Approve</span>
                                    <?php } else if ($crop->banner_status == 0) { ?>
                                        <span class="bg-warning rounded p-1 text-white">Pending</span>
                                    <?php } else if ($crop->banner_status == 2) { ?>
                                        <span class="bg-light rounded p-1 text-white">Reject</span>
                                    <?php } else if ($crop->banner_status == 4) { ?>
                                        <span class="bg-warning rounded p-1 text-white">Sold</span>
                                    <?php } else if ($crop->banner_status == 3) { ?>
                                        <span class="bg-warning rounded p-1 text-white">Disable</span>
                                    <?php } else { ?>
                                        <span class="bg-danger rounded p-1 text-white">Expiry</span>
                                    <?php } ?>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                        <div class="dropdown-menu ">
                                            <a class="dropdown-item" href="<?= url('crops-banner-details/' . $crop->crop_banner_id) ?>">View Details</a>
                                        </div>
                                    </div>
                                </td>
                            <?php }
                    } else { ?>
                        <tr>
                            <td colspan="13" class="text-center fw-bold py-5 text-danger fs-1">
                                No Data found
                            </td>
                        </tr>
                        <?php }
                }

                # CROPS BOOST LIST
                public function cropBoostList(Request $request)
                {
                    //dd($request->all());
                    $status = $request->status;
                    if ($status == 1 || $status == 2) {
                        $sql = DB::table('crops_boosts as cb')
                            ->select('csv.*', 'cb.status as boost_status')
                            ->leftJoin('cropsSubscribedView as csv', 'csv.subscribed_id', '=', 'cb.crop_subscribed_id')
                            ->orderBy('cb.id', 'desc')
                            ->where('cb.status', $status);
                        $crop_boost_list  = $sql->get();
                        $crop_boost_count = $sql->count();
                    } else if ($status == 0) {
                        $sql = DB::table('crops_boosts as cb')
                            ->select('csv.*', 'cb.status as boost_status')
                            ->leftJoin('cropsSubscribedView as csv', 'csv.subscribed_id', '=', 'cb.crop_subscribed_id')
                            ->orderBy('cb.id', 'desc');

                        $crop_boost_list  = $sql->get();
                        $crop_boost_count = $sql->count();
                    }

                    if (!empty($crop_boost_count > 0)) {

                        foreach ($crop_boost_list as $key => $crop) { ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <<td><?= $crop->username ?></td>
                                    <td><?= $crop->crops_cat_name ?></td>
                                    <td><?= $crop->crop_subscriptions_name ?></td>
                                    <td><?= $crop->invoice_no ?></td>
                                    <td>
                                        <?php if ($crop->boost_status == 1) { ?>
                                            <span class="bg-success rounded p-1 text-white">Active</span>
                                        <?php } else { ?>
                                            <span class="bg-danger rounded p-1 text-white">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu ">
                                                <a class="dropdown-item" href="<?= url('crops-post-details/' . $crop->subscribed_id) ?>">View Details</a>
                                            </div>
                                        </div>
                                    </td>
                                <?php }
                        } else { ?>
                            <tr>
                                <td colspan="13" class="text-center fw-bold py-5 text-danger fs-1">
                                    No Data found
                                </td>
                            </tr>
                            <?php }
                    }

                    # CROPS POST LIST
                    public function cropPostList(Request $request)
                    {
                        // dd($request->all());
                        $status = $request->status;
                        if ($status == 1 || $status == 2 || $status == 0 || $status == 3 || $status == 5) {

                            $sql = DB::table('crops')
                                ->select(
                                    'user.name',
                                    'user.mobile',
                                    'user.user_type_id',
                                    'crops_category.crops_cat_name',
                                    'crops.status as crop_status',
                                    'crops.crops_subscribed_id as crop_crops_subscribed_id',
                                    'crops.id as crops_id',
                                    'crops.created_at as crops_created_at',
                                    'csv.crop_subscriptions_name'
                                )
                                ->leftJoin('user', 'crops.user_id', '=', 'user.id')
                                ->leftJoin('crops_category', 'crops.crops_category_id', '=', 'crops_category.id')
                                ->leftJoin('cropsSubscribedView as csv', 'crops.crops_subscribed_id', '=', 'csv.subscribed_id')
                                ->where('crops.status', $status);

                            $crop_list  = $sql->get();
                            $crop_list_count = $sql->count();
                        } else if ($status == 4) {
                            $sql = DB::table('crops')
                                ->select(
                                    'user.name',
                                    'user.mobile',
                                    'user.user_type_id',
                                    'crops_category.crops_cat_name',
                                    'crops.status as crop_status',
                                    'crops.crops_subscribed_id as crop_crops_subscribed_id',
                                    'crops.id as crops_id',
                                    'crops.created_at as crops_created_at',
                                    'csv.crop_subscriptions_name'
                                )
                                ->leftJoin('user', 'crops.user_id', '=', 'user.id')
                                ->leftJoin('crops_category', 'crops.crops_category_id', '=', 'crops_category.id')
                                ->leftJoin('cropsSubscribedView as csv', 'crops.crops_subscribed_id', '=', 'csv.subscribed_id');

                            $crop_list  = $sql->get();
                            $crop_list_count = $sql->count();
                        }

                        if (!empty($crop_list_count > 0)) {

                            foreach ($crop_list as $key => $crop) { ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <<td><?= $crop->name ?></td>
                                        <td><span class="badge rounded-pill alert-<?php if ($crop->user_type_id == 2) {
                                                                                        echo 'success';
                                                                                    } else if ($crop->user_type_id == 3) {
                                                                                        echo 'warning';
                                                                                    } else if ($crop->user_type_id == 4) {
                                                                                        echo 'secondary';
                                                                                    } else {
                                                                                        echo 'danger';
                                                                                    } ?>">
                                                <?php if ($crop->user_type_id == 2) {
                                                    echo 'Seller';
                                                } else if ($crop->user_type_id == 3) {
                                                    echo 'Dealer';
                                                } else if ($crop->user_type_id == 4) {
                                                    echo 'Exchanger';
                                                } ?>
                                            </span>
                                        </td>
                                        <td><?= $crop->mobile ?></td>
                                        <td><?= $crop->crop_subscriptions_name ?></td>
                                        <td><?= $crop->crops_cat_name ?></td>
                                        <td>
                                            <?php
                                            $created_at = $crop->crops_created_at;
                                            $date = new DateTime($created_at);
                                            $date = $date->format('d-m-Y');
                                            ?>
                                            <?= $date ?>
                                        </td>

                                        <td>
                                            <?php $boost_count = DB::table('crops_boosts')->where('crop_id', $crop->crops_id)->where('status', 1)->count();
                                            if ($boost_count > 0) { ?>
                                                <span class="badge rounded-pill alert-success">BOOST</span>
                                            <?php } else { ?>
                                                <span class="badge rounded-pill alert-danger">NO BOOST</span>
                                            <?php } ?>
                                        </td>

                                        <td>
                                            <?php if ($crop->crop_status == 1) { ?>
                                                <span class="d-inline-block bg-success text-white  text-center rounded" style="width: 100px">Approve</span>
                                            <?php } else if ($crop->crop_status == 2) { ?>
                                                <span class="d-inline-block bg-danger text-white text-center  rounded" style="width: 100px">Reject</span>
                                            <?php } else if ($crop->crop_status == 0) { ?>
                                                <span class="d-inline-block bg-warning text-white text-center  rounded" style="width: 100px">Pending</span>
                                            <?php } else if ($crop->crop_status == 5) { ?>
                                                <span class="d-inline-block bg-dark text-white text-center  rounded" style="width: 100px">Expiry</span>
                                            <?php } else if ($crop->crop_status == 4) { ?>
                                                <span class="d-inline-block bg-warning text-white text-center  rounded" style="width: 100px">Sold</span>
                                            <?php } else if ($crop->crop_status == 3) { ?>
                                                <span class="d-inline-block bg-warning text-white text-center  rounded" style="width: 100px">Disable</span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                <div class="dropdown-menu ">
                                                    <a class="dropdown-item" href="<?= url('crops-post-details/' . $crop->crops_id) ?>">View Details</a>
                                                </div>
                                            </div>
                                        </td>
                                    <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="13" class="text-center fw-bold py-5 text-danger fs-1">
                                        No Data found
                                    </td>
                                </tr>
                                <?php }
                        }

                        # CROPS BANNER LIST WISH SUBSCRIBED ID
                        public function cropBannerListWishSubscribedId(Request $request)
                        {
                            //dd($request->all());
                            $status = $request->status;
                            $crops_subscribed_id = $request->crops_subscribed_id;
                            if ($status == 1 || $status == 2 || $status == 3 || $status == 0 || $status == 5) {
                                $sql = DB::table('crops_banners as cb')
                                    ->select('csv.*', 'cb.status as banner_status', 'cb.image as banner_image', 'cb.id as crop_banner_id')
                                    ->leftJoin('cropsSubscribedView as csv', 'csv.subscribed_id', '=', 'cb.crop_subscribed_id')
                                    ->orderBy('cb.id', 'desc')
                                    ->where('cb.status', $status)
                                    ->where('cb.crop_subscribed_id', $crops_subscribed_id)
                                    ->orderBy('cb.id', 'desc');
                                // ->get();
                                $crop_banner_list = $sql->get();
                                $crop_banner_count = $sql->count();
                            } else if ($status == 4) {
                                $sql = DB::table('crops_banners as cb')
                                    ->select('csv.*', 'cb.status as banner_status', 'cb.image as banner_image', 'cb.id as crop_banner_id')
                                    ->leftJoin('cropsSubscribedView as csv', 'csv.subscribed_id', '=', 'cb.crop_subscribed_id')
                                    ->orderBy('cb.id', 'desc')
                                    ->where('cb.crop_subscribed_id', $crops_subscribed_id)
                                    ->orderBy('cb.id', 'desc');
                                // ->get();
                                $crop_banner_list = $sql->get();
                                $crop_banner_count = $sql->count();
                            }

                            // dd($crop_banner_list);
                            //dd($crop_subscribed_details_count);
                            if (!empty($crop_banner_count > 0)) {
                                // dd("hi");
                                foreach ($crop_banner_list as $key => $crop) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td>
                                            <img width="100" src="<?= asset('storage/crops/banner/' . $crop->banner_image) ?>" />
                                        </td>
                                        <<td><?= $crop->username ?></td>
                                            <td><?= $crop->crop_subscriptions_name ?></td>
                                            <td><?= $crop->invoice_no ?></td>
                                            <td>
                                                <?php if ($crop->banner_status == 1) { ?>
                                                    <span class="bg-success rounded p-1 text-white">Approve</span>
                                                <?php }else if($crop->banner_status == 0){ ?>
                                                    <span class="bg-warning rounded p-1 text-white">Pending</span>
                                                <?php }else if($crop->banner_status == 2){ ?>
                                                    <span class="bg-light rounded p-1 text-white">Reject</span>
                                                <?php }else if($crop->banner_status == 4){ ?>
                                                    <span class="bg-warning rounded p-1 text-white">Sold</span>
                                                <?php }else if($crop->banner_status == 3){ ?>
                                                    <span class="bg-warning rounded p-1 text-white">Disable</span>
                                                <?php } else { ?>
                                                    <span class="bg-danger rounded p-1 text-white">Expiry</span>
                                                <?php } ?>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                    <div class="dropdown-menu ">
                                                        <a class="dropdown-item" href="<?= url('crops-banner-details/' . $crop->crop_banner_id) ?>">View Details</a>
                                                    </div>
                                                </div>
                                            </td>
                                        <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="13" class="text-center fw-bold py-5 text-danger fs-1">
                                            No Data found
                                        </td>
                                    </tr>
                                    <?php }
                            }

                            # CROPS POST LIST WISH SUBSCRIBED ID
                            public function cropPostListWishSubscribedId(Request $request)
                            {
                                // dd($request->all());
                                $status = $request->status;
                                $crops_subscribed_id = $request->crops_subscribed_id;
                                if ($status == 1 || $status == 2 || $status == 0 || $status == 3 || $status == 5) {

                                    $sql = DB::table('crops')
                                        ->select(
                                            'user.name',
                                            'user.mobile',
                                            'user.user_type_id',
                                            'crops_category.crops_cat_name',
                                            'crops.status as crop_status',
                                            'crops.crops_subscribed_id as crop_crops_subscribed_id',
                                            'crops.id as crops_id',
                                            'crops.created_at as crops_created_at',
                                            'csv.crop_subscriptions_name'
                                        )
                                        ->leftJoin('user', 'crops.user_id', '=', 'user.id')
                                        ->leftJoin('crops_category', 'crops.crops_category_id', '=', 'crops_category.id')
                                        ->leftJoin('cropsSubscribedView as csv', 'crops.crops_subscribed_id', '=', 'csv.subscribed_id')
                                        ->where('crops.status', $status)
                                        ->where('crops.crops_subscribed_id', $crops_subscribed_id);

                                    $crop_list  = $sql->get();
                                    $crop_list_count = $sql->count();
                                } else if ($status == 4) {
                                    $sql = DB::table('crops')
                                        ->select(
                                            'user.name',
                                            'user.mobile',
                                            'user.user_type_id',
                                            'crops_category.crops_cat_name',
                                            'crops.status as crop_status',
                                            'crops.crops_subscribed_id as crop_crops_subscribed_id',
                                            'crops.id as crops_id',
                                            'crops.created_at as crops_created_at',
                                            'csv.crop_subscriptions_name'
                                        )
                                        ->leftJoin('user', 'crops.user_id', '=', 'user.id')
                                        ->leftJoin('crops_category', 'crops.crops_category_id', '=', 'crops_category.id')
                                        ->leftJoin('cropsSubscribedView as csv', 'crops.crops_subscribed_id', '=', 'csv.subscribed_id')
                                        ->where('crops.crops_subscribed_id', $crops_subscribed_id);

                                    $crop_list  = $sql->get();
                                    $crop_list_count = $sql->count();
                                }

                                if (!empty($crop_list_count > 0)) {

                                    foreach ($crop_list as $key => $crop) { ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <<td><?= $crop->name ?></td>
                                                <td><span class="badge rounded-pill alert-<?php if ($crop->user_type_id == 2) {
                                                                                                echo 'success';
                                                                                            } else if ($crop->user_type_id == 3) {
                                                                                                echo 'warning';
                                                                                            } else if ($crop->user_type_id == 4) {
                                                                                                echo 'secondary';
                                                                                            } else {
                                                                                                echo 'danger';
                                                                                            } ?>">
                                                        <?php if ($crop->user_type_id == 2) {
                                                            echo 'Seller';
                                                        } else if ($crop->user_type_id == 3) {
                                                            echo 'Dealer';
                                                        } else if ($crop->user_type_id == 4) {
                                                            echo 'Exchanger';
                                                        } ?>
                                                    </span>
                                                </td>
                                                <td><?= $crop->mobile ?></td>
                                                <td><?= $crop->crop_subscriptions_name ?></td>
                                                <td><?= $crop->crops_cat_name ?></td>
                                                <td>
                                                    <?php
                                                    $created_at = $crop->crops_created_at;
                                                    $date = new DateTime($created_at);
                                                    $date = $date->format('d-m-Y');
                                                    ?>
                                                    <?= $date ?>
                                                </td>
                                                <td>
                                                    <?php $boost_count = DB::table('crops_boosts')->where('crop_id', $crop->crops_id)->where('status', 1)->count();
                                                    if ($boost_count > 0) { ?>
                                                        <span class="badge rounded-pill alert-success">BOOST</span>
                                                    <?php } else { ?>
                                                        <span class="badge rounded-pill alert-danger">NO BOOST</span>
                                                    <?php } ?>
                                                <td>
                                                    <?php if ($crop->crop_status == 1) { ?>
                                                        <span class="d-inline-block bg-success text-white  text-center rounded" style="width: 100px">Approve</span>
                                                    <?php } else if ($crop->crop_status == 2) { ?>
                                                        <span class="d-inline-block bg-danger text-white text-center  rounded" style="width: 100px">Reject</span>
                                                    <?php } else if ($crop->crop_status == 0) { ?>
                                                        <span class="d-inline-block bg-warning text-white text-center  rounded" style="width: 100px">Pending</span>
                                                    <?php } else if ($crop->crop_status == 5) { ?>
                                                        <span class="d-inline-block bg-dark text-white text-center  rounded" style="width: 100px">Expiry</span>
                                                    <?php } else if ($crop->crop_status == 4) { ?>
                                                        <span class="d-inline-block bg-warning text-white text-center  rounded" style="width: 100px">Sold</span>
                                                    <?php } else if ($crop->crop_status == 3) { ?>
                                                        <span class="d-inline-block bg-warning text-white text-center  rounded" style="width: 100px">Disable</span>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu ">
                                                            <a class="dropdown-item" href="<?= url('crops-post-details/' . $crop->crops_id) ?>">View Details</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="13" class="text-center fw-bold py-5 text-danger fs-1">
                                                No Data found
                                            </td>
                                        </tr>
                            <?php }
                                }
                            }
