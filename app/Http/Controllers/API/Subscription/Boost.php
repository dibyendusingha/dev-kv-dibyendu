<?php

namespace App\Http\Controllers\API\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
USE Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Subscription\Coupon;
use App\Models\Subscription\Subscription_boost;
use App\Models\Subscription\Subscribed_boost;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Subscription\Subscription;
USE App\Models\sms;

class Boost extends Controller
{
    use AuthorizesRequests;
    //
    public function boostDetails (Request $request) {
        $user_id = auth()->user()->id;
        $data = [];

        $basic_plane_image        = 'https://krishivikas.com/storage/banner_ads/Bronze_plan_banner.jpg';
        $intermediate_plane_image = 'https://krishivikas.com/storage/banner_ads/Silver_plan_banner.jpg';
        $premium_plane_image      = 'https://krishivikas.com/storage/banner_ads/Golden_plan_banner.jpg';
        
        $get = DB::table('subscription_boosts')->where(['status'=>1])->get();
        foreach ($get as $val) {
            if($val->name == "Basic"){
                $plane_image = $basic_plane_image;
            }else if($val->name == "Intermediate"){
                $plane_image = $intermediate_plane_image;
            }else if($val->name == "Premium"){
                $plane_image = $premium_plane_image;
            }else{
                $plane_image = $premium_plane_image;
            }
            $data['id'] = $val->id;
            $data['name'] = $val->name;
            $data['plane_image'] = $plane_image;
            $data['days'] = $val->days;
            $data['price'] = $val->price;
            $data['features']['website'] = $val->website;
            $data['features']['mobile'] = $val->mobile;
            $data['features']['home_screen'] = $val->home_screen;
            $data['features']['sub_category'] = $val->sub_category;
            $data['features']['recomended'] = $val->recomended;
            $data['features']['filter'] = $val->filter;
            $data['features']['notification'] = $val->notification;
            $data['features']['state'] = $val->state;
            $data['features']['product'] = $val->product;
            $data['features']['cross_category'] = $val->cross_category;
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

     
    # Boost Payment 
    public function boost_payment (Request $request) {
        $output = [];
        $subscription_boosts_id = $request->subscription_boosts_id;
        $category_id            = $request->category_id;
        $product_id             = $request->post_id;
        $coupon_id              = $request->coupon_id;
        $coupon_code            = $request->coupon_code;
        $purchase_amount        = $request->purchase_amount;
        $order_id               = $request->order_id;
        $transaction_id         = $request->transaction_id;

        $s_b_id = intval($subscription_boosts_id);

        $user_id = auth()->user()->id;

        // try{
            DB::beginTransaction();
            $subscriptions_boost_count = Subscription_boost::where('id',$s_b_id)->where('status',1)->count();
            if($subscriptions_boost_count > 0){
                $subscriptions_boost_details = Subscription_boost::where('id',$s_b_id)->where('status',1)->first();

                $id              = $subscriptions_boost_details->id;
                $name            = $subscriptions_boost_details->name;
                $days            = $subscriptions_boost_details->days;
                $price           = $subscriptions_boost_details->price;
            }

            $date1 =  Carbon::now();
            $start_date = date("Y-m-d H:i:s", strtotime($date1));
            
            $futureDate = $date1->addDays($days);
            $date2      = $futureDate->format('Y-m-d H:i:s');
            $end_date   = date("Y-m-d H:i:s", strtotime($date2));

            $financialYear = Subscription::getFinancialYear($start_date,"y");//21-22 
           
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


            $invoiceId = $getId[0]->max_invoice_number+1; #new id for Invoice

            $boost = new Subscribed_boost;
            $boost->subscription_boosts_id  = $s_b_id;
            $boost->user_id                 = $user_id;
            $boost->category_id             = $category_id;
            $boost->product_id              = $product_id;
            $boost->price                   = $price;
            $boost->start_date              = $start_date;
            $boost->end_date                = $end_date;
            $boost->coupon_code_id          = $coupon_id;
            $boost->coupon_code             = $coupon_code;
            $boost->purchased_price         = $purchase_amount;
            $boost->transaction_id          = $transaction_id;
            $boost->order_id                = $order_id;
            $boost->gst                     = $request->gst;     
            $boost->sgst                    = $request->sgst; 
            $boost->cgst                    = $request->cgst;  
            $boost->igst                    = $request->igst;  
            $boost->invoice_no              = "AECPL/".str_pad($invoiceId,5,"0", STR_PAD_LEFT)."/".$financialYear;
            $boost->status                  = 1;
            $boost->created_at              = Carbon::now();
            $boost->updated_at              = Carbon::now();

            $boost->save();

            if ($coupon_id!='') {
                $coupon_used_increment  = Coupon::where('id',$coupon_id)->where('status',1)->first();
                if(!empty($coupon_used_increment)){
                    $usability = $coupon_used_increment->usability;
                    $used      = $coupon_used_increment->used;

                    if($usability > $used ){
                        $used_increment = $used + 1;
                        $coupon_details_in = Coupon::where('id',$coupon_id)->where('status',1)->first();
                        $coupon_details_in->used = $used_increment;
                        $coupon_details_in->update();
                    }
                }
            }

            # Dibyendu Change
            $old_subscribed_boosts_count = DB::table('subscribed_boosts')
            ->where(['product_id'=>$product_id,'category_id'=>$category_id,'user_id'=>$user_id,'status'=>3])
            ->count();

            if($old_subscribed_boosts_count > 0){
                $old_subscribed_boosts= DB::table('subscribed_boosts')
                ->where(['product_id'=>$product_id,'category_id'=>$category_id,'user_id'=>$user_id,'status'=>3])
                ->first();
                
                $subscription_boost_update = DB::table('subscribed_boosts')->where('id',$old_subscribed_boosts->id)->where('status', 3)
                ->update(['status'=>4]);
            }
            

            $data = DB::table('subscribed_boosts as a')
                    ->select('a.*','b.*','a.id as id','b.id as boost_subscription_id','a.product_id as post_id')
                    ->leftJoin('subscription_boosts as b','b.id','=','a.subscription_boosts_id')
                    ->where(['a.id'=>$boost->id])
                    ->first();

            $data->product = Subscribed_boost::getBoostedProduct($data->category_id, $data->product_id, $user_id);
            
            $user_details = DB::table('user')->where(['id'=>$user_id])->first();
            $category = DB::table('category')->where(['id'=>$data->category_id])->value('category');
            $mobile = DB::table('user')->where(['id'=>$user_details->id])->value('mobile');
            

            if(!empty($data->product->brand_name)){
                $sms = sms::boost_sms($mobile,$user_details->name,$data->product->brand_name,$category,$data->name,$data->end_date, $data->product->front_image, $data->product_id);
            }else{
                $sms = sms::boost_sms($mobile,$user_details->name,'null',$category,$data->name,$data->end_date, $data->product->front_image , $data->product_id);
            }
            //print_r($sms);
            
            DB::commit();
            

            $output['response']=true;
            $output['message']='Product Boosted Successfully';
            $output['data'] = $data;
            $output['status_code'] = 201;
            $output['error'] = '';

       // }
        // catch(\Exception $e){
        //     DB::rollBack();
        //     $output['response']=false;
        //     $output['message']='Something Went Wrong!';
        //     $output['data'] = '';
        //     $output['status_code'] = 500;
        //     $output['error'] = $e;
        // }
        return $output;

    }

    
    # Subscription Boost All Products
    public function boost_all_product (Request $request) {
        $user_id = auth()->user()->id;
      //  dd($user_id);

        $subscribedId = DB::table('subscribed_boosts')->where('user_id',$user_id)->where('status',1)->value('id');

            $datas = DB::table('subscribed_boosts as a')
                ->select('a.*',
                //'b.*',
                'b.id as subscription_boost_id','b.name as subscription_boosts_name','b.days as subscription_boosts_days','b.price as subscription_boosts_price',
                'b.website as subscription_boosts_website','b.mobile as subscription_boosts_mobile','b.home_screen as subscription_boosts_home_screen','b.sub_category as subscription_boosts_sub_category',
                'b.recomended as subscription_boosts_recomended','b.filter as subscription_boosts_filter','b.notification as subscription_boosts_notification','b.state as subscription_boosts_state',
                'b.product as subscription_boosts_product','b.cross_category as subscription_boosts_cross_category','b.status as subscription_boosts_status',
                  DB::raw('CONCAT("'.url('/').'/invoice/subscription_boots/'.$subscribedId.'") as invoice_id'))
                ->leftJoin('subscription_boosts as b', 'b.id', '=', 'a.subscription_boosts_id')
                //->leftJoin('invoice as inv', 'inv.user_id', '=', 'a.user_id')
               // ->where('inv.invoice_type', 'product_boosts_online')
                ->where(['a.user_id' => $user_id])
                ->whereIn('a.status' , [1,3])
                ->get();

            //dd($datas);
        
            // foreach($datas as $key => $data){
            //     $subscription_boosts_details = DB::table('subscription_boosts')->where('id',$data->subscription_boosts_id)->first();
                
            //     $data->boosted = $subscription_boosts_details;

            // }

        foreach ($datas as $data) {
            $data->product = Subscribed_boost::getBoostedProduct($data->category_id, $data->product_id, $user_id);
        }

        $output['response'] = true;
        $output['message'] = 'Boosted Products';
        $output['data'] = $datas;
        $output['status_code'] = 200;
        $output['error'] = '';

        return $output;

    }

    public function boost_invoice (Request $request) {
        $data =[];
        $user_id = auth()->user()->id;
        $subscribed_boost_id = $request->subscribed_boost_id;

        $count = DB::table('subscribed_boosts')->where(['id'=>$subscribed_boost_id])->count();
        if ($count>0) {
            $data = DB::table('subscribed_boosts as a')
                ->select('a.*','b.*')
                ->leftJoin('subscription_boosts as b','b.id','=','a.subscription_boosts_id')
                ->where(['a.id'=>$subscribed_boost_id])
                ->first();

            $data->product = Subscribed_boost::getBoostedProduct($data->category_id, $data->product_id, $user_id);
        
            $output['response']=true;
            $output['message']='Invoice';
            $output['data'] = $data;
            $output['status_code'] = 200;
            $output['error'] = '';
           
        } else {
            $output['response']=false;
            $output['message']='No Data Found';
            $output['data'] = $data;
            $output['status_code'] = 404;
            $output['error'] = 'No Data Found';
        }
        return $output;

    }


}