<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response;

use App\Models\sms;

class AdsBannerCotroller extends Controller
{
    public function get_all_ads_banner(){
        $data = DB::table('ads_banners as a')
            ->select('a.id as ads_banner_id','a.subscription_id','d.name as subscription_name','a.subscription_features_id', 'a.campaign_banner as banner_img', 
            'a.status' ,'c.name as subscription_features_name','c.days as subscription_features_days',
            'a.subscribed_id','b.price','b.start_date','b.end_date','b.coupon_code_id','b.coupon_code',
            'b.purchased_price','b.transaction_id','b.order_id','b.invoice_no',
            'a.user_id','a.campaign_name','a.campaign_state','e.discount_type','e.discount_percentage','a.campaign_category',
            'e.discount_flat',
            DB::raw('GROUP_CONCAT(DISTINCT s.state_name) AS campaign_state_names'),
            DB::raw('GROUP_CONCAT(DISTINCT cat.category) AS campaign_category_names'),
            DB::raw("CONCAT('".env('IMAGE_PATH_SPONSER')."',a.campaign_banner) as campaign_banner_image")
            )
            ->leftJoin('subscribeds as b','b.id','=','a.subscribed_id')
            ->leftJoin('subscription_features as c','c.id','=','a.subscription_features_id')
            ->leftJoin('subscriptions as d','d.id','=','a.subscription_id')
            ->leftJoin('coupons as e','e.id','=','b.coupon_code_id')
            //->leftJoin('category as cat','cat.id','=','a.campaign_category')
            //->whereRaw("find_in_set(s.id, a.campaign_state)")

            ->leftJoin('state as s', function($join){
                //$join->on(DB::raw("find_in_set(s.id, a.campaign_state)">0));
                $join->whereRaw("find_in_set(s.id, a.campaign_state)");
                })
            // ->leftJoin('category as cat', function($join1){
            //     //$join->on(DB::raw("find_in_set(s.id, a.campaign_state)">0));
            //     $join1->whereRaw("find_in_set(cat.id, a.campaign_category)");
            // })
            ->leftJoin('category as cat', function($join1) {
                $join1->whereRaw("FIND_IN_SET(cat.id, a.campaign_category)");
            })
            ->groupBy('a.id','a.subscription_id','a.subscription_features_id',
            'a.subscribed_id','a.user_id','a.campaign_name','b.price','b.start_date','b.end_date','b.coupon_code_id','b.coupon_code',
            'b.purchased_price','b.transaction_id','b.order_id','b.invoice_no','b.status',
            'c.name','c.days','c.website','c.mobile','c.sub_category','c.category','c.listing','c.creatives',
            'c.state','d.name','e.discount_percentage','e.discount_percentage',
            'e.discount_flat')
            ->get();
// print_r($data);
        return view('admin.ads_manager.ads_list',['ads_banner'=>$data]);


    }

    public function update_ads_banner_status($type,$banner_id){
        $banner_update = DB::table('ads_banners')->where('id',$banner_id)->first();
        $campaign_banner = $banner_update->campaign_banner;
      
        if($type == 'approve'){
            $banner_status = DB::table('ads_banners')->where('id',$banner_id)->update(['status' => 1]);

            $banner_approve = sms::approve_banner($banner_id,$campaign_banner);

        }else if($type == 'pending'){
            $banner_status = DB::table('ads_banners')->where('id',$banner_id)->update(['status' => 0]);
            $banner_pending = sms::pending_banner($banner_id,$campaign_banner);  

        }else if($type == 'reject'){
           // dd($campaign_banner);
            $banner_status = DB::table('ads_banners')->where('id',$banner_id)->update(['status' => 2]);
            $banner_reject = sms::reject_banner($banner_id,$campaign_banner);
        }

        return Redirect::to("ads-banner-list");
    }

    public function get_banner_details_page($banner_id){
        $data = DB::table('ads_banners as a')
            ->select('a.id as ads_banner_id','a.subscription_id','a.subscribed_id as subscribedId','d.name as subscription_name','a.subscription_features_id', 'a.campaign_banner as banner_img', 
            'a.status' ,'c.name as subscription_features_name','c.days as subscription_features_days',
            'a.subscribed_id','b.price','b.start_date','b.end_date','b.coupon_code_id','b.coupon_code',
            'b.purchased_price','b.transaction_id','b.order_id','b.invoice_no',
            'a.user_id','a.campaign_name','a.campaign_state','e.discount_type','e.discount_percentage',
            'e.discount_flat',DB::raw('GROUP_CONCAT(s.state_name) AS campaign_state_names'),
            DB::raw("CONCAT('".env('IMAGE_PATH_SPONSER')."',a.campaign_banner) as campaign_banner_image")
            )
            ->leftJoin('subscribeds as b','b.id','=','a.subscribed_id')
            ->leftJoin('subscription_features as c','c.id','=','a.subscription_features_id')
            ->leftJoin('subscriptions as d','d.id','=','a.subscription_id')
            ->leftJoin('coupons as e','e.id','=','b.coupon_code_id')
            ->leftJoin('state as s', function($join){
                //$join->on(DB::raw("find_in_set(s.id, a.campaign_state)">0));
                $join->whereRaw("find_in_set(s.id, a.campaign_state)");
                })
            ->groupBy('a.id','a.subscription_id','a.subscription_features_id',
            'a.subscribed_id','a.user_id','a.campaign_name','b.price','b.start_date','b.end_date','b.coupon_code_id','b.coupon_code',
            'b.purchased_price','b.transaction_id','b.order_id','b.invoice_no','b.status',
            'c.name','c.days','c.website','c.mobile','c.sub_category','c.category','c.listing','c.creatives',
            'c.state','d.name','e.discount_percentage','e.discount_percentage',
            'e.discount_flat')
            ->where('a.id',$banner_id)
            ->first();


            $banner_lead_details = DB::table('banner_leads')->where('banner_id',$banner_id)->get();
            $subscribed_id = DB::table('ads_banners')->where('id',$banner_id)->first()->subscribed_id;
            $payment_count = DB::table('subscribeds')->where('id',$subscribed_id)->count();
            if($payment_count > 0){
                $payment_details = DB::table('subscribeds')->where('id',$subscribed_id)->first();
                $purchased_price = $payment_details->purchased_price;
                $transaction_id  = $payment_details->transaction_id;
                $order_id        = $payment_details->order_id;
                $invoice_no      = $payment_details->invoice_no;
                $payment_date    = $payment_details->created_at;
                $end_date        = $payment_details->end_date;
            }else{
                $purchased_price = "N/A";
                $transaction_id  = "N/A";
                $order_id        = "N/A";
                $invoice_no      = "N/A";
                $payment_date    = "N/A";
                $end_date        = "N/A";
            }

            

        return view('admin.ad_banner_detail',['data'=>$data,'banner_lead_details'=>$banner_lead_details, 
        'purchased_price'=>$purchased_price,'transaction_id'=>$transaction_id,'order_id'=>$order_id,
        'invoice_no'=>$invoice_no,'payment_date'=>$payment_date,'end_date'=>$end_date]);

    }

    public function get_subscription_boost_page(){
        return view();
    }

    public function updateBannerStatus(Request $request, $leadId){
       // dd($request->lead_status);
        $update = DB::table('banner_leads')->where('id',$leadId)->update(['status'=>$request->lead_status]);
        return redirect()->back()->with('success','Lead status changed successfully.');
    }
}
