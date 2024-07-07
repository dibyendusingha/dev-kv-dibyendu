<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription\Subscription;
use Image;
use App\Models\Subscription\Subscribed_boost;

class Crop extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'crops_cat_name', 'logo', 'status', 'created_at', 'updated_at'];

    public static function getAllCropsCategory($catId)
    {
        $query = DB::table('crops_category')
                 ->select('id','category_id','crops_cat_name',DB::raw('CONCAT("' . env('IMAGE_PATH_CROPS') . '", logo) as logo'),'ln_bn','ln_hn','status','created_at', 'updated_at')
                ->where('category_id','=', $catId)
                ->where('status','=', '1')
                ->get();
        return $query;
     }

    public static function getAllCropsSubCategory($catId, $subCatId)
    {
        $query = DB::table('crops_sub_category as cs')
                ->select('cs.id','cs.category_id','cc.crops_cat_name as crops_category_name','cs.crops_category_id','cs.crops_sub_cat_name','cs.logo')
                ->leftjoin('crops_category as cc', 'cc.id','=','cs.crops_category_id')
                ->where('cs.category_id','=', $catId)
                ->where('cs.crops_category_id','=', $subCatId)
                ->where('cs.status','=', '1')
                ->get();
        return $query;
     }

    public static function getAllCropBoosts()
    {
        $query = DB::table('crop_subscription_features as csf')
                ->select('csf.*', 'cs.crop_subscriptions_name')
                ->leftJoin('crop_subscriptions as cs', 'cs.id', '=', 'csf.crops_subscription_id')
                ->where('csf.status','=', '1')
                ->get();

        return $query;
     }

    public static function saveCrops($data)
    {
        $insert_id = DB::table('crops')->insertGetId($data);
        return $insert_id;
    }

    public static function getSubscription($subscriptionId)
    {
        $query = DB::table('crop_subscription_features as csf')
                ->select('csf.crops_subscription_id','csf.id','csf.name','csf.days','csf.price','csf.number_of_crops','csf.website','csf.mobile','csf.category','csf.category_view_all','csf.notification','csf.crop_boost','csf.number_crop_boost','csf.crop_banner','csf.number_crop_banner','csf.gst_as_applicable',DB::raw('CONCAT("' . env('IMAGE_PATH_CROPS') . '", csf.verification_tag) as verification_tag'),'csf.status','csf.created_at','csf.updated_at', 'cs.crop_subscriptions_name')
               // ->select('csf.crops_subscription_id','csf.id','csf.name','csf.days','csf.price','csf.number_of_crops','csf.website','csf.mobile','csf.category','csf.category_view_all','csf.notification','csf.number_crop_boost as number_of_boost','csf.number_crop_banner as number_of_banner','csf.gst_as_applicable',DB::raw('CONCAT("' . env('IMAGE_PATH_CROPS') . '", csf.verification_tag) as verification_tag'),'csf.status','csf.created_at','csf.updated_at', 'cs.crop_subscriptions_name')
                ->leftJoin('crop_subscriptions as cs', 'cs.id', '=', 'csf.crops_subscription_id')
                ->where('csf.id','=', $subscriptionId)
                ->where('csf.status','=', '1')
                ->get();

        return $query;
     }

    public static function getUserdata($userId)
    {
        $result = DB::table('user')
                ->select('id','mobile')
                ->where('id','=',$userId)
                ->where('status','=',1)
                ->first();
        return $result;
    }

    public static function getUserCount($userId)
    {
        $result = DB::table('user')
                ->select('id','mobile')
                ->where('id','=',$userId)
                ->where('status','=',1)
                ->count();
        return $result;
    }

    public static function saveCropSubscriptionPayment($data)
    {
        $insert_id = DB::table('crops_subscribeds')->insertGetId($data);
        return $insert_id;
    }

    public static function getSubscribedData($subscriptionId)
    {
        $res =  DB::table('crops_subscribeds as cs')
                ->leftJoin('user as u', 'u.id', '=', 'cs.user_id') 
                ->leftJoin('crop_subscription_features as csf', 'csf.id', '=', 'cs.subscription_feature_id')
                ->leftJoin('crop_subscriptions as css', 'css.id', '=', 'csf.crops_subscription_id')
                ->leftJoin('coupons as c', 'c.id', '=', 'cs.coupon_code_id')
                ->select('cs.*', 'u.name', 'u.user_type_id', 'u.mobile', 'css.crop_subscriptions_name as subscribtion_name', 'c.discount_type', 'c.discount_percentage', 'c.discount_flat',DB::raw('CONCAT("'.env('IMAGE_PATH').'invoice/crops_subscription/'.$subscriptionId.'") as invoice_id')) 
                ->where('cs.id', '=', $subscriptionId) 
                ->first();

        return $res;
    }

    public static function getFinancialYear($inputDate,$format="Y"){
        $date=date_create($inputDate);
        if (date_format($date,"m") >= 4) {
            $financial_year = (date_format($date,$format)) . '-' . (date_format($date,$format)+1);
        } else {
            $financial_year = (date_format($date,$format)-1) . '-' . date_format($date,$format);
        }
    
        return $financial_year;
    } 

    public static function getInvoiceDetails($subscriptionId)
    {
            $res =  DB::table('crops_subscribeds as cs')
                ->leftJoin('crops as cr', 'cr.id', '=', 'cs.crops_id') 
                ->leftJoin('crops_category as cc', 'cc.id', '=', 'cr.crops_category_id') 
                ->leftJoin('user as u', 'u.id', '=', 'cs.user_id') 
                ->leftJoin('crop_subscription_features as csf', 'csf.id', '=', 'cs.subscription_feature_id')
                 ->leftJoin('crop_subscriptions as css', 'css.id', '=', 'csf.crops_subscription_id')
                ->leftJoin('coupons as c', 'c.id', '=', 'cs.coupon_code_id')
                ->leftJoin('state as s', 's.id','=', 'u.state_id')
                ->leftJoin('city as ci', 'ci.id','=', 'u.city_id')
                ->leftJoin('district as d', 'd.id','=', 'u.district_id')
                ->select('cs.*', 'cr.title', 'cr.price','cc.crops_cat_name', 'u.name', 'u.user_type_id', 'u.mobile', 'css.crop_subscriptions_name as subscribtion_name', 'c.discount_type', 'c.discount_percentage', 'c.discount_flat','u.address as street_no', 's.id as state_id', 's.state_name', 'ci.id as city_id', 'ci.city_name', 'ci.pincode', 'd.id as district_id', 'd.district_name') 
                ->where('cs.id', '=', $subscriptionId) 
                ->first();

        return $res;
    }

    public static function getMyCropsAllData($userId)
    {
        $res =  DB::table('crops as cs')
                ->leftJoin('crops_subscribeds as csd', 'csd.crops_id', '=', 'cs.id')
                ->select('cs.id as crops_id', 'csd.id as crop_subscribed_id', 'cs.title', 'cs.price', 'cs.created_at', DB::raw('CONCAT("' . env('IMAGE_PATH_CROPS') . '", cs.image1) as image1'),  DB::raw('CONCAT("' . env('IMAGE_PATH_CROPS') . '", cs.image2) as image2'),  DB::raw('CONCAT("' . env('IMAGE_PATH_CROPS') . '", cs.image3) as image3'), 'csd.status', 'csd.start_date', 'csd.end_date')
                ->where('csd.user_id', '=', $userId)
                ->where('csd.status', 1)
                ->get();


        return $res;
    }

    public static function getCropsDetails($cropsId)
    {
        $res =  DB::table('crops as cs')
                ->leftJoin('user as u', 'u.id', '=', 'cs.user_id') 
                ->select('cs.*','u.name', 'u.user_type_id', 'u.mobile') 
                ->where('cs.id', '=', $cropsId) 
                ->get();

        return $res;
    }

    public static function getCropsAllData()
    {
         $res =  DB::table('crops as cs')
                ->leftJoin('crops_subscribeds as csd', 'csd.crops_id','=','cs.id')
                ->leftJoin('state as st', 'st.id', '=', 'cs.state_id' )
                ->select('cs.id as crops_id','csd.id as crop_subscribed_id','cs.product_name','cs.product_price','cs.created_at', 'st.state_name',
                    DB::raw('CASE WHEN cs.image1 IS NOT NULL THEN CONCAT("'.env('IMAGE_PATH_CROPS').'", cs.image1) ELSE NULL END AS image1'),  
                    DB::raw('CASE WHEN cs.image2 IS NOT NULL THEN CONCAT("'.env('IMAGE_PATH_CROPS').'", cs.image2) ELSE NULL END AS image2'),  
                    DB::raw('CASE WHEN cs.image3 IS NOT NULL THEN CONCAT("'.env('IMAGE_PATH_CROPS').'", cs.image3) ELSE NULL END AS image3'), 
                    'csd.status', 'csd.start_date', 'csd.end_date') 
                ->where('csd.status',1)
                ->orderBy('csd.id', 'DESC')
                ->get();

        return $res;
    }
    
     protected function get_notification_data_by_where ($where,$user_id_db) {
        $data=[];
        $count = DB::table('crops')->orderBy('id','desc')->where('status',1)->where($where)->count();
        if ($count>0) {
        $array_fer_model = DB::table('crops')->orderBy('id','desc')->where('status',1)->where($where)->get();
            foreach ($array_fer_model as $val) {
                
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
                $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                $data['device_id']  = $user_details->device_id;
                $data['firebase_token']  = $user_details->firebase_token;
                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                    $data['photo']='';
                } else {
                $data['photo'] = asset("storage/photo/$user_details->photo");
                }
                
                $data['title'] = $val->title;
                $data['price'] = $val->price;
                $data['description'] = $val->description;
                if ($val->image1=='' || $val->image1=='NULL') { 
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/crops/$val->image1"); 
                }
                if ($val->image2=='' || $val->image2=='NULL') { 
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/crops/$val->image2"); 
                }
                if ($val->image3=='' || $val->image3=='NULL') { 
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/crops/$val->image3"); 
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
                
                $data['pincode'] = $val->pincode;
                $data['latlong'] = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till'] = $val->valid_till;
                $data['ad_report'] = $val->ad_report;
                $data['status'] = $val->status;
                $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at'] = $val->updated_at;
                
                $data['wishlist_status'] = DB::table('wishlist')->where(['user_id'=>$user_id_db,'category_id'=>12,'item_id'=>$val->id])->count();
                
                $data['view_lead'] = Leads_view::where(['category_id'=>12,'post_id'=>$val->id])->count();
                $data['call_lead'] = Lead::where(['category_id'=>12,'post_id'=>$val->id,'calls_status'=>1])->count();
                $data['msg_lead'] = Lead::where(['category_id'=>12,'post_id'=>$val->id,'messages_status'=>1])->count();
                
                $u_data = Userss::where(['id'=>$user_id_db,'status'=>1])->first();
                $data['lead_name'] = $u_data->name;
                $data['lead_mobile'] = $u_data->mobile;
                $data['lead_email'] = $u_data->email;
                
                //$new[] = $data;
                
                
            }
        }
            return $data;
    }

}
