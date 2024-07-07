<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription\Subscription_boost;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    # Subscribe Boost
    public function subscribe_boots(){
        $subscription_boots_details = DB::table('subscribed_boosts')->where('status',1)->get();
       
        return view('admin.subscription_plan.subscribed_boots',['subscribed_boots' => $subscription_boots_details]);
    }

    # Subscribe Boost List
    public function subscribe_boost_details_page($subscribe_boots_id){

        $subscribe_boost_details = DB::table('subscribed_boosts')->where('id',$subscribe_boots_id)->first();
        $product_id  = $subscribe_boost_details->product_id;
        $category_id = $subscribe_boost_details->category_id;
        $subscription_boosts_id  = $subscribe_boost_details->subscription_boosts_id;

        $subscription_boosts     = DB::table('subscription_boosts')->where('id',$subscription_boosts_id)->first();
       

        if($category_id == 1){
            $tractor_details = DB::table('tractorView')->where('id',$product_id)->first();
            $image = $tractor_details->front_image;
            $user_count      = DB::table('user')->where('id',$tractor_details->user_id)->count(); 
            if($user_count > 0){
                $user_details    = DB::table('user')->where('id',$tractor_details->user_id)->first(); 
            }else{
                $user_details = null;
            }

            $seller_lead_count = DB::table('seller_leads')->where('post_id',$product_id)->count();
            // dd( $seller_lead_count);
            if($seller_lead_count > 0){
                $seller_lead_details = DB::table('seller_leads')->where('post_id',$product_id)->paginate(10);
            }else{
                $seller_lead_details = null;
            }
        }
        if($category_id == 3){
            $tractor_details = DB::table('goodVehicleView')->where('id',$product_id)->first();
            $image = $tractor_details->front_image;
            $user_count      = DB::table('user')->where('id',$tractor_details->user_id)->count(); 
            if($user_count > 0){
                $user_details    = DB::table('user')->where('id',$tractor_details->user_id)->first(); 
            }else{
                $user_details = null;
            }

            $seller_lead_count = DB::table('seller_leads')->where('post_id',$product_id)->count();
            if($seller_lead_count > 0){
                $seller_lead_details = DB::table('seller_leads')->where('post_id',$product_id)->get();
            }else{
                $seller_lead_details = null;
            }
        }
        if($category_id == 4){
            $tractor_details = DB::table('harvesterView')->where('id',$product_id)->first();
            $image = $tractor_details->front_image;
            $user_count      = DB::table('user')->where('id',$tractor_details->user_id)->count(); 
            if($user_count > 0){
                $user_details    = DB::table('user')->where('id',$tractor_details->user_id)->first(); 
            }else{
                $user_details = null;
            }

            $seller_lead_count = DB::table('seller_leads')->where('post_id',$product_id)->count();
            if($seller_lead_count > 0){
                $seller_lead_details = DB::table('seller_leads')->where('post_id',$product_id)->get();
            }else{
                $seller_lead_details = null;
            }
        }
        if($category_id == 5){
            $tractor_details = DB::table('implementView')->where('id',$product_id)->first();
            $image = $tractor_details->front_image;
            $user_count      = DB::table('user')->where('id',$tractor_details->user_id)->count(); 
            if($user_count > 0){
                $user_details    = DB::table('user')->where('id',$tractor_details->user_id)->first(); 
            }else{
                $user_details = null;
            }

            $seller_lead_count = DB::table('seller_leads')->where('post_id',$product_id)->count();
            if($seller_lead_count > 0){
                $seller_lead_details = DB::table('seller_leads')->where('post_id',$product_id)->get();
            }else{
                $seller_lead_details = null;
            }
        }
        if($category_id == 6){
            $tractor_details = DB::table('seedView')->where('id',$product_id)->first();
            $image = $tractor_details->image1;
            $user_count      = DB::table('user')->where('id',$tractor_details->user_id)->count(); 
            if($user_count > 0){
                $user_details    = DB::table('user')->where('id',$tractor_details->user_id)->first(); 
            }else{
                $user_details = null;
            }

            $seller_lead_count = DB::table('seller_leads')->where('post_id',$product_id)->count();
            if($seller_lead_count > 0){
                $seller_lead_details = DB::table('seller_leads')->where('post_id',$product_id)->get();
            }else{
                $seller_lead_details = null;
            }
        }
        if($category_id == 7){
            $tractor_details = DB::table('tyresView')->where('id',$product_id)->first();
            $image = $tractor_details->image1;
            $user_count      = DB::table('user')->where('id',$tractor_details->user_id)->count(); 
            if($user_count > 0){
                $user_details    = DB::table('user')->where('id',$tractor_details->user_id)->first(); 
            }else{
                $user_details = null;
            }

            $seller_lead_count = DB::table('seller_leads')->where('post_id',$product_id)->count();
            if($seller_lead_count > 0){
                $seller_lead_details = DB::table('seller_leads')->where('post_id',$product_id)->get();
            }else{
                $seller_lead_details = null;
            }
        }
        if($category_id == 8){
            $tractor_details = DB::table('pesticidesView')->where('id',$product_id)->first();
            $image = $tractor_details->image1;
            $user_count      = DB::table('user')->where('id',$tractor_details->user_id)->count(); 
            if($user_count > 0){
                $user_details    = DB::table('user')->where('id',$tractor_details->user_id)->first(); 
            }else{
                $user_details = null;
            }

            $seller_lead_count = DB::table('seller_leads')->where('post_id',$product_id)->count();
            if($seller_lead_count > 0){
                $seller_lead_details = DB::table('seller_leads')->where('post_id',$product_id)->get();
            }else{
                $seller_lead_details = null;
            }
        }
        if($category_id == 9){
            $tractor_details = DB::table('fertilizerView')->where('id',$product_id)->first();
            $image = $tractor_details->image1;
            $user_count      = DB::table('user')->where('id',$tractor_details->user_id)->count(); 
            if($user_count > 0){
                $user_details    = DB::table('user')->where('id',$tractor_details->user_id)->first(); 
            }else{
                $user_details = null;
            }

            $seller_lead_count = DB::table('seller_leads')->where('post_id',$product_id)->count();
            if($seller_lead_count > 0){
                $seller_lead_details = DB::table('seller_leads')->where('post_id',$product_id)->get();
            }else{
                $seller_lead_details = null;
            }
        }
        
        return view('admin.subscription_plan.subscribed_boots_details',['tractor_details'=>$tractor_details,
            'user_details'=>$user_details,'subscribe_boost_details'=>$subscribe_boost_details,
            'subscription_boosts'=>$subscription_boosts,'image'=>$image , 'seller_lead_details'=>$seller_lead_details,
            'seller_lead_count'=>$seller_lead_count, 'category_id'=>$category_id , 'subscribedId'=>$subscribe_boots_id]);
    }

    public function updateProductBoostStatus(Request $request, $seller_id){
       // dd($request->lead_status);
        $update = DB::table('seller_leads')->where('id',$seller_id)->update(['status'=>$request->lead_status]);
        return redirect()->back()->with('success','Lead status changed successfully.');
    }

    # Subscription Details List
    public function get_subscription_details(){
        $subscription_details = DB::table('subscriptions')->get();
        return view('admin.subscription_plan.subscription_plan',['subscription_details'=> $subscription_details]);
    }

    # Subscription Details List
    public function get_subscription_feature_details($subscription_id){
        $subscription_feature_details = DB::table('subscription_features')->where('subscription_id',$subscription_id)->get();
        return view('admin.subscription_plan.subscription_feature',['subscription_feature_details'=> $subscription_feature_details]);
    }

    # Subscribed List Details
    // public function get_subscribed_list(){
    //     $subscribed_details = DB::table('subscribeds')
    //                 ->select('subscribeds.*','subscriptions.name as subscriptions_name','user.name','user.mobile')
    //                 ->leftJoin('subscriptions', 'subscriptions.id', '=', 'subscribeds.subscription_id')
    //                  ->leftJoin('user', 'user.id', '=', 'subscribeds.user_id')
    //                 ->get();

    //                //dd($subscribed_details);
        
    //     return view('admin.subscription_plan.subscribed_user', ['subscribed_details'=>$subscribed_details]);
    // }

    # User List
    public function user_list(){
        $user_details = DB::table('user')
        ->select('user.id','user.user_type_id','user.name','user.mobile','user.user_post_count','user.limit_count','user.created_at')
        ->orderBy('user.id','asc')
        ->limit(1000)
        // ->paginate(10);
        ->get();
        return view('admin.users.user_list',['user_details'=>$user_details]);
    }

    # User Details
    public function user_details($user_id){
        $user_details = DB::table('user')
            ->select('user.id','user.user_type_id','user.name','user.mobile','user.user_post_count','user.limit_count','user.created_at')
            ->where('user.id',$user_id)
            ->first();
        return view('admin.users.user_details',['user'=>$user_details]);
    }

    public function user_details_update(Request $request,$user_id){
        //dd($user_id);
        $user_post_count = $request->user_post_count;
        //dd($user_post_count);
        $limit_count     = $request->limit_count;

        $user_update = DB::table('user')->where('id',$user_id)->update(['user_post_count'=>$user_post_count ,'limit_count'=>$limit_count]);

        $user_details = DB::table('user')
        ->select('user.id','user.user_type_id','user.name','user.mobile','user.user_post_count','user.limit_count','user.created_at')
        ->orderBy('user.id','asc')
        ->get();
        // ->paginate(10);

        //return view('admin.users.user_list',['user_details'=>$user_details]);
        return redirect('user-list')->with(['user_details'=>$user_details]);

    }

    # Subscribed List Details
    public function get_subscribed_list(){
        $subscribed_details = DB::table('subscribeds')
                    ->select('subscribeds.*', 'user.name as user_name', 'subscriptions.name as subscription_name')
                    ->leftJoin('subscriptions', 'subscriptions.id', '=', 'subscribeds.subscription_id')
                    ->leftJoin('user', 'user.id', '=', 'subscribeds.user_id')
                    ->where('subscribeds.status', 1)
                    ->get();
        return view('admin.subscription_plan.subscribed_user', ['subscribed_details'=>$subscribed_details]);
    }

    # Subscribed User Details
    public function getSubscribedUserDetails(Request $request, $subscribedId ){
       // dd($subscribedId);
        $subscribed_details = DB::table('subscribeds')
                    ->select('subscribeds.*', 'user.name as user_name', 'subscriptions.name as subscription_name', 'ads_banners.campaign_name', 'ads_banners.campaign_banner')
                    ->leftJoin('subscriptions', 'subscriptions.id', '=', 'subscribeds.subscription_id')
                    ->leftJoin('user', 'user.id', '=', 'subscribeds.user_id')
                    ->leftJoin('ads_banners', 'ads_banners.user_id', '=', 'user.id')
                    ->where('subscribeds.status', 1)
                    ->where('subscribeds.id', $subscribedId)
                    ->groupBy('user.id')
                    ->orderBy('id','desc')
                    ->first();

        $banner_id = DB::table('ads_banners')->where('subscribed_id',$subscribedId)->first()->id;

        $data = DB::table('ads_banners as a')
            ->select('a.campaign_banner as banner_img',
            DB::raw('GROUP_CONCAT(s.state_name) AS campaign_state_names'),
            DB::raw("CONCAT('".env('IMAGE_PATH_SPONSER')."',a.campaign_banner) as campaign_banner_image")
            )
          
            ->leftJoin('state as s', function($join){
                $join->whereRaw("find_in_set(s.id, a.campaign_state)");
            })
            ->where('a.id',$banner_id)
            ->first();

          //dd($data);

        $banner_user_lead = DB::table('banner_leads as  b')
        ->select('u.user_type_id', 'u.name','u.mobile','u.zipcode','b.banner_post_user_id','b.id','b.status')
        ->leftJoin('user as u', 'u.id', '=', 'b.user_id')
        ->where('b.banner_id',$banner_id)->get();
      //dd($banner_user_lead);
        return view('admin.subscription_plan.subscribed_details', ['subscribed_details'=>$subscribed_details , 
        'banner_lead_details' => $banner_user_lead ,'banner_details'=>$data]);
    }


    
}
