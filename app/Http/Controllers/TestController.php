<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription\notification_function;
use App\Models\MyLeadList;
use App\Models\Notification_save;
use function Laravel\Prompts\select;
use App\Models\Subscription\Subscription;
use App\Models\Subscription\SubscriptionFeatures;
use App\Models\Subscription\Subscribed;
use App\Models\Subscription\Subscribed_boost;

use App\Http\Controllers\API\Category\TractorController as TC;
use App\Http\Controllers\API\Category\GVController as GC;
use App\Http\Controllers\API\Category\HarvesterController as HC;
use App\Http\Controllers\API\Category\ImplementsController as IC;
use App\Http\Controllers\API\Category\SeedController as SC;
use App\Http\Controllers\API\Category\PesticidesController as PC;
use App\Http\Controllers\API\Category\FertilizerController as FC;
use App\Http\Controllers\API\Category\TyreController as TyC;
use App\Models\Category;

class TestController extends Controller
{
    public function adminPincodePage()
    {
        return view('admin.pin_update.pin_update');
    }

    /** State Name in Add PinCode Page */
    public function getStateName()
    {
        $cityDetails = DB::table('city')->orderBy('id', 'desc')->where('status', 1)->paginate(10);
        $state = DB::table('state')->where('country_id', 1)->get();
        return view('admin.pin_update.pin_update', ['state' => $state, 'city' => $cityDetails]);
    }

    /** District Name in Add PinCode Page */
    public function getDistrictName(Request $request)
    {
        $data = [];
        $district_details = DB::table('district')->where('state_id', $request->state_id)->get();

        foreach ($district_details as $key => $d) {

            $district = DB::table('district')->where('state_id', $d->state_id)->first()->district_name;

            $data[] = ['district_name' =>  $district];
        }

        return $district_details;
    }

    public function my_post(Request $request)
    {
        $output = [];
        $data = [];
        $new = [];
        $user_id = auth()->user()->id;

        $Autn = DB::table('user')->where(['id' => $user_id])->count();
        if ($Autn == 0) {
            $output['response'] = false;
            $output['message'] = 'Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        } else {
            $where = $user_id;
            $count_t = Tractor::where('user_id', $where)->count();
            //dd($count_t);
            if ($count_t > 0) {
                // $tractor = Tractor::get_data_by_where($where);
                $tractor = Tractor::get_data_by_where_my_post($where);
                // $data['tractor'] = $tractor;
            } else {
                $tractor = [];
            }


            $count_g = Goods_vehicle::where('user_id', $where)->count();
            //dd($count_g);
            if ($count_g > 0) {
                $gv = Goods_vehicle::get_data_by_where($where);
                //   $data['gv'] = $gv;  
            } else {
                $gv = [];
            }

            $count_h = Harvester::where('user_id', $where)->count();
            if ($count_h > 0) {
                $harvester = Harvester::get_data_by_where($where);
                // $data['harvester'] = $harvester; 
            } else {
                $harvester = [];
            }

            $count_i = Implement::where('user_id', $where)->count();

            if ($count_i > 0) {
                $implement = Implement::get_data_by_where($where);
                // $data['implement'] = $implement;
            } else {
                $implement = [];
            }

            $count_s = Seed::where('user_id', $where)->count();
            if ($count_s > 0) {
                $seed = Seed::get_data_by_where_my_post($where);
                // $data['seed'] = $seed;
            } else {
                $seed = [];
            }

            $count_ty = Tyre::where('user_id', $where)->count();
            if ($count_ty > 0) {
                $tyre = Tyre::get_data_by_where_my_post($where);
                // $data['tyre'] = $tyre;
            } else {
                $tyre = [];
            }


            $count_p = pesticides::where('user_id', $where)->count();
            if ($count_p > 0) {
                $pesticides = pesticides::get_data_by_where_my_post($where);
                // $data['pesticides'] = $pesticides;
            } else {
                $pesticides = [];
            }

            $count_f = fertilizers::where('user_id', $where)->count();
            if ($count_f > 0) {
                $fertilizer = fertilizers::get_data_by_where_my_post($where);
                // $data['fertilizers'] = $fertilizer;  
            } else {
                $fertilizer = [];
            }

            $data = array_merge($tractor, $gv, $harvester, $implement, $seed, $tyre, $pesticides, $fertilizer);
            // $data[] = [$tractor+$gv+$harvester+$implement+$seed+$tyre+$pesticides+$fertilizer];

        }

        if (!empty($data)) {
            $output['response'] = true;
            $output['message'] = 'Data Found';
            $output['data'] = $data;
            $output['error'] = "";
        } else {
            $output['response'] = false;
            $output['message'] = 'No Data Found';
            $output['data'] = [];
            $output['error'] = "";
        }

        return $output;
    }

    # Category Wish Post Details
    public function user_post_details(Request $request)
    {

        //dd(auth()->user()->id);
        $user_id = auth()->user()->id;
        $post_id = $request->post_id;
        $category_id = $request->category_id;

        $post_details  = MyLeadList::post_category_product_list($category_id, $post_id, $user_id);

        $output = array();

        if (!empty($post_details)) {
            $output['response'] = true;
            $output['message']  = 'My Post Details Category wish';
            $output['data']     =  $post_details;
            $output['error']    = "";
        } else {
            $output['response'] = false;
            $output['message']  = 'No Data Available';
            $output['data']     = [];
            $output['error']    = "";
        }

        return $output;
    }

    # Category Wish Banner And Product Boost
    // public function category_wish_Banner_boost_product(Request $request)
    // {
    //     $datas = [];
    //     $campaign_category = $request->campaign_category;
    //     $data = array();

    //     $all_banner_count = DB::table('ads_banners')->whereRaw('FIND_IN_SET(?, campaign_category)', [$campaign_category])->where('status',1)->count();
    //     $all_banner = DB::table('ads_banners')->whereRaw('FIND_IN_SET(?, campaign_category)', [$campaign_category])->where('status',1)->get();
        

    //     if($all_banner_count > 0){
    //         foreach ($all_banner as $key1 => $ban) {
    //             $banner_img = asset('storage/sponser/' . $ban->campaign_banner);

    //             $user_count  = DB::table('user')->where(['id' => $ban->user_id])->count();
    //             if ($user_count > 0) {
    //                 $user_details  = DB::table('user')->where(['id' => $ban->user_id])->first();
    //                 if(!empty($user_details->name)){
    //                     $name          = $user_details->name;
    //                 }else{
    //                     $name = null;
    //                 }

    //                 if(!empty($user_details->company_name)){
    //                     $company_name  = $user_details->company_name;
    //                 }else{
    //                     $company_name = null;
    //                 }

    //                 if(!empty($user_details->mobile)){
    //                     $mobile        = $user_details->mobile;
    //                 }else{
    //                     $mobile = null;
    //                 }

    //                 if(!empty($user_details->email)){
    //                     $email         = $user_details->email;
    //                 }else{
    //                     $email = null;
    //                 }
    //             }else{
    //                 $name = null;
    //                 $company_name = null;
    //                 $mobile = null;
    //                 $email = null;
    //             }

    //             $banner[$key1] = [
    //                 'id' => $ban->id, 'banner_image' => $banner_img, 'user_id' => $ban->user_id, 'name' => $name,
    //                 'company_name' => $company_name, 'mobile' => $mobile, 'email' => $email, 'status' => $ban->status
    //             ];
    //         }
    //     }else{
    //         $banner = [];
    //     }

   
    //     $datas = DB::select(
    //     "SELECT 
    //         NULL as distance,
    //         t.id,
    //         t.category_id,
    //         t.user_id,
    //             user.name,
    //             user.user_type_id,
    //             user.role_id,
    //             user.company_name,
    //             user.mobile,
    //             user.email,
    //             user.gender,
    //             user.address,
    //             user.zipcode,
    //             user.firebase_token,
    //             user.created_at as created_at_user,
    //             user.photo,
    //         t.set,
    //         t.type,
    //         t.brand_id,
    //         t.model_id,
    //         t.title,
    //         brand.name AS brand_name,
    //         model.model_name AS model_name,

    //         t.year_of_purchase,
    //         t.rc_available,
    //         t.noc_available,
    //         t.registration_no,
    //         t.description,
    //         t.is_negotiable,
    //         t.crop_type,
    //         t.cutting_with,
    //         t.power_source,
    //         t.position,

    //         t.front_image,
    //         t.left_image,
    //         t.right_image,
    //         t.back_image,
    //         t.meter_image,
    //         t.tyre_image,
    //         t.image1,
    //         t.image2,
    //         t.image3,
    //         t.price,
    //         t.rent_type,
            
    //         t.country_id,
    //         t.state_id,
    //         t.district_id,
    //         t.pincode,
    //         t.city_id,
    //         state.state_name AS state_name,
    //         district.district_name AS district_name,
    //         city.city_name AS city_name,
    //         t.latlong,
    //         t.ad_report,
    //         t.created_at,
    //         t.updated_at,
    //         t.status  
    //     FROM (
    //         SELECT
    //             'tractor',
    //             id,
    //             category_id,
    //             user_id,
    //             `set`,
    //             type,
    //             brand_id,
    //             model_id,
    //             title,

    //             year_of_purchase,
    //             rc_available,
    //             noc_available,
    //             registration_no,
    //             description,
    //             is_negotiable,
    //             NULL as crop_type,
    //             NULL as cutting_with,
    //             NULL as power_source,
    //             NULL as position,

    //             CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',front_image) as front_image,
    //             CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',left_image) as left_image,
    //             CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',right_image) as right_image,
    //             CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',back_image) as back_image,
    //             CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',meter_image) as meter_image,
    //             CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',tyre_image) as tyre_image,
    //             NULL as image1,
    //             NULL as image2,
    //             NULL as image3,
                
    //             price,
    //             rent_type,
    //             country_id,
    //             state_id,
    //             district_id,
    //             city_id,
    //             pincode,

    //             latlong,
    //             ad_report,
    //             created_at,
    //             updated_at,
    //             status
    //         FROM tractor
            
        
    //         UNION ALL
        
    //         SELECT
    //             'goods_vehicle',
    //             id,
    //             category_id,
    //             user_id,
    //             `set`,
    //             type,
    //             brand_id,
    //             model_id,
    //             title,

    //             year_of_purchase,
    //             rc_available,
    //             noc_available,
    //             registration_no,
    //             description,
    //             is_negotiable,
    //             NULL as crop_type,
    //             NULL as cutting_with,
    //             NULL as power_source,
    //             NULL as position,

    //             CONCAT('" . env('IMAGE_PATH_GV') . "',front_image) as front_image,
    //             CONCAT('" . env('IMAGE_PATH_GV') . "',left_image) as left_image,
    //             CONCAT('" . env('IMAGE_PATH_GV') . "',right_image) as right_image,
    //             CONCAT('" . env('IMAGE_PATH_GV') . "',back_image) as back_image,
    //             CONCAT('" . env('IMAGE_PATH_GV') . "',meter_image) as meter_image,
    //             CONCAT('" . env('IMAGE_PATH_GV') . "',tyre_image) as tyre_image,
    //             NULL as image1,
    //             NULL as image2,
    //             NULL as image3,
                
    //             price,
    //             rent_type,
    //             country_id,
    //             state_id,
    //             district_id,
    //             city_id,
    //             pincode,

    //             latlong,
    //             ad_report,
    //             created_at,
    //             updated_at,
    //             status
    //         FROM goods_vehicle
            
    //         UNION ALL
        
    //         SELECT
    //             'harvester',
    //             id,
    //             category_id,
    //             user_id,
    //             `set`,
    //             type,
    //             brand_id,
    //             model_id,
    //             title,

    //             year_of_purchase,
    //             NULL as rc_available,
    //             NULL as noc_available,
    //             NULL as registration_no,
    //             description,
    //             is_negotiable,
    //             crop_type,
    //             cutting_with,
    //             power_source,
    //             NULL as position,

    //             CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as front_image,
    //             CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',left_image) as left_image,
    //             CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',right_image) as right_image,
    //             CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',back_image) as back_image,
    //             CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as meter_image,
    //             CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as tyre_image,
    //             NULL as image1,
    //             NULL as image2,
    //             NULL as image3,
                
    //             price,
    //             rent_type,
    //             country_id,
    //             state_id,
    //             district_id,
    //             city_id,
    //             pincode,

    //             NULL as latlong,
    //             ad_report,
    //             created_at,
    //             updated_at,
    //             status
    //         FROM harvester
            
        
    //         UNION ALL
        
    //         SELECT
    //             'implements',
    //             id,
    //             category_id,
    //             user_id,
    //             `set`,
    //             type,
    //             brand_id,
    //             model_id,
    //             title,

    //             year_of_purchase,
    //             NULL as rc_available,
    //             NULL as noc_available,
    //             NULL as registration_no,
    //             description,
    //             is_negotiable,
    //             NULL as crop_type,
    //             NULL as cutting_with,
    //             NULL as power_source,
    //             NULL as position,

    //             CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as front_image,
    //             CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',left_image) as left_image,
    //             CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',right_image) as right_image,
    //             CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',back_image) as back_image,
    //             CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as meter_image,
    //             CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as tyre_image,
    //             NULL as image1,
    //             NULL as image2,
    //             NULL as image3,
                
    //             price,
    //             rent_type,
    //             country_id,
    //             state_id,
    //             district_id,
    //             city_id,
    //             pincode,

    //             latlong,
    //             ad_report,
    //             created_at,
    //             updated_at,
    //             status
    //         FROM implements
        
        
    //         UNION ALL
        
    //         SELECT
    //             'seeds',
    //             id,
    //             category_id,
    //             user_id,
    //             NULL as `set`,
    //             NULL as type,
    //             NULL as brand_id,
    //             NULL as model_id,
    //             title,

    //             NULL as year_of_purchase,
    //             NULL as rc_available,
    //             NULL as noc_available,
    //             NULL as registration_no,
    //             description,
    //             is_negotiable,
    //             NULL as crop_type,
    //             NULL as cutting_with,
    //             NULL as power_source,
    //             NULL as position,

    //             NULL as front_image,
    //             NULL as left_image,
    //             NULL as right_image,
    //             NULL as back_image,
    //             NULL as meter_image,
    //             NULL as tyre_image,
    //             CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image1) as image1,
    //             CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image2) as image2,
    //             CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image3) as image3,
                
    //             price,
    //             NULL as rent_type,
    //             country_id,
    //             state_id,
    //             district_id,
    //             city_id,
    //             pincode,

    //             latlong,
    //             ad_report,
    //             created_at,
    //             updated_at,
    //             status
    //         FROM seeds
        
        
    //         UNION ALL
        
    //         SELECT
    //             'pesticides',
    //             id,
    //             category_id,
    //             user_id,
    //             NULL as `set`,
    //             NULL as type,
    //             NULL as brand_id,
    //             NULL as model_id,
    //             title,

    //             NULL as year_of_purchase,
    //             NULL as rc_available,
    //             NULL as noc_available,
    //             NULL as registration_no,
    //             description,
    //             is_negotiable,
    //             NULL as crop_type,
    //             NULL as cutting_with,
    //             NULL as power_source,
    //             NULL as position,

    //             NULL as front_image,
    //             NULL as left_image,
    //             NULL as right_image,
    //             NULL as back_image,
    //             NULL as meter_image,
    //             NULL as tyre_image,
    //             CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image1) as image1,
    //             CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image2) as image2,
    //             CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image3) as image3,
                
    //             price,
    //             NULL as rent_type,
    //             country_id,
    //             state_id,
    //             district_id,
    //             city_id,
    //             pincode,

    //             latlong,
    //             ad_report,
    //             created_at,
    //             updated_at,
    //             status
    //         FROM pesticides
        
        
    //         UNION ALL
        
    //         SELECT
    //         ' fertilizers',
    //             id,
    //             category_id,
    //             user_id,
    //             NULL as `set`,
    //             NULL as type,
    //             NULL as brand_id,
    //             NULL as model_id,
    //             title,

    //             NULL as year_of_purchase,
    //             NULL as rc_available,
    //             NULL as noc_available,
    //             NULL as registration_no,
    //             description,
    //             is_negotiable,
    //             NULL as crop_type,
    //             NULL as cutting_with,
    //             NULL as power_source,
    //             NULL as position,

    //             NULL as front_image,
    //             NULL as left_image,
    //             NULL as right_image,
    //             NULL as back_image,
    //             NULL as meter_image,
    //             NULL as tyre_image,
    //             CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image1) as image1,
    //             CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image2) as image2,
    //             CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image3) as image3,
                
    //             price,
    //             NULL as rent_type,
    //             country_id,
    //             state_id,
    //             district_id,
    //             city_id,
    //             pincode,

    //             latlong,
    //             ad_report,
    //             created_at,
    //             updated_at,
    //             status
    //         FROM fertilizers
        
        
    //         UNION ALL
        
    //         SELECT
    //         'tyres',
    //             id,
    //             category_id,
    //             user_id,
    //             NULL as `set`,
    //             type,
    //             brand_id,
    //             model_id,
    //             title,

    //             NULL as year_of_purchase,
    //             NULL as rc_available,
    //             NULL as noc_available,
    //             NULL as registration_no,
    //             description,
    //             is_negotiable,
    //             NULL as crop_type,
    //             NULL as cutting_with,
    //             NULL as power_source,
    //             position,

    //             NULL as front_image,
    //             NULL as left_image,
    //             NULL as right_image,
    //             NULL as back_image,
    //             NULL as meter_image,
    //             NULL as tyre_image,
    //             CONCAT('" . env('IMAGE_PATH_TYRE') . "',image1) as image1,
    //             CONCAT('" . env('IMAGE_PATH_TYRE') . "',image2) as image2,
    //             CONCAT('" . env('IMAGE_PATH_TYRE') . "',image3) as image3,
                
    //             price,
    //             NULL as rent_type,
    //             country_id,
    //             state_id,
    //             district_id,
    //             city_id,
    //             pincode,

    //             latlong,
    //             ad_report,
    //             created_at,
    //             updated_at,
    //             status
    //         FROM tyres
        
        
    //     ) AS t
    //     LEFT JOIN brand ON t.brand_id = brand.id
    //     LEFT JOIN model ON t.model_id = model.id
    //     LEFT JOIN state ON t.state_id = state.id
    //     LEFT JOIN district ON t.district_id = district.id
    //     LEFT JOIN city ON t.city_id = city.id
    //     LEFT JOIN user on t.user_id = user.id
    //     LEFT JOIN subscribed_boosts on t.id = subscribed_boosts.product_id
        
    //     where subscribed_boosts.category_id = $campaign_category and subscribed_boosts.status = 1
    //     and t.category_id = $campaign_category
        
    //     ");

    //     foreach($datas as $key=>$ban_det){

    //         $specification = [];
    //         $model_id = $ban_det->model_id;
    //         $specification = DB::table('specifications')
    //                 ->where(['model_id' => $model_id, 'status' => 1])->get();
            

    //         $banner_details[$key] = 
    //         [
    //             'distance'         => $ban_det->distance,
    //             'is_boosted'      => true,
    //             'id'               => $ban_det->id,
    //             'category_id'      => $ban_det->category_id,
    //             'user_id'          => $ban_det->user_id,
    //             'name'             =>$ban_det->name,
    //             'user_type_id'     =>$ban_det->user_type_id,
    //             'role_id'          =>$ban_det->role_id,
    //             'company_name'     =>$ban_det->company_name,
    //             'mobile'           =>$ban_det->mobile,
    //             'email'            =>$ban_det->email,
    //             'gender'           =>$ban_det->gender,
    //             'address'          =>$ban_det->address,
    //             'zipcode'          =>$ban_det->zipcode,
    //             'firebase_token'   =>$ban_det->firebase_token,
    //             'created_at_user'  =>$ban_det->created_at_user,
    //             'photo'            =>$ban_det->photo,
    //             'set'              =>$ban_det->set,
    //             'type'             => $ban_det->type,
    //             'brand_id'         => $ban_det->brand_id,
    //             'model_id'         => $ban_det->model_id,
    //             'title'            => $ban_det->title,
    //             'brand_name'       => $ban_det->brand_name,
    //             'model_name'       => $ban_det->model_name,
    //             'year_of_purchase' => $ban_det->year_of_purchase,
    //             'rc_available'     => $ban_det->rc_available,
    //             'noc_available'    => $ban_det->noc_available,
    //             'registration_no'  => $ban_det->registration_no,
    //             'description'      => $ban_det->description,
    //             'is_negotiable'    => $ban_det->is_negotiable,
    //             'crop_type'        => $ban_det->crop_type,
    //             'cutting_with'     => $ban_det->cutting_with,
    //             'power_source'     => $ban_det->power_source,
    //             'position'         => $ban_det->position,
    //             'front_image'      => $ban_det->front_image,
    //             'left_image'       => $ban_det->left_image,
    //             'right_image'      =>$ban_det->right_image ,
    //             'back_image'       => $ban_det->back_image,
    //             'meter_image'      => $ban_det->meter_image,
    //             'tyre_image'       => $ban_det->tyre_image,
    //             'image1'           => $ban_det->image1,
    //             'image2'           => $ban_det->image2,
    //             'image3'           => $ban_det->image3,
    //             'price'            => $ban_det->price,
    //             'rent_type'        => $ban_det->rent_type,
    //             'country_id'       => $ban_det->country_id,
    //             'state_id'         => $ban_det->state_id,
    //             'district_id'      => $ban_det->district_id,
    //             'pincode'          => $ban_det->pincode,
    //             'city_id'          => $ban_det->city_id,
    //             'state_name'       => $ban_det->state_name,
    //             'district_name'    => $ban_det->district_name,
    //             'city_name'        => $ban_det->city_name,
    //             'latlong'          => $ban_det->latlong,
    //             'ad_report'        => $ban_det->ad_report,
    //             'created_at'       => $ban_det->created_at,
    //             'updated_at'       => $ban_det->updated_at,
    //             'status'           => $ban_det->status,
    //             'specification'   => $specification

    //         ];

    //     }

    // //   $data['boost']= $datas;
    // //   return $data;

    //     if(!empty($datas)){
    //         $boost_product = $banner_details;
    //     }else{
    //         $boost_product = [];
    //     }

    //     if ($campaign_category==1) {
    //         $image = Tractor::tractor_category_page();
    //     } else if ($campaign_category==3) {
    //         $image = Goods_vehicle::gv_category_page();
    //     } else if ($campaign_category==4) {
    //         $image = Harvester::harvester_category_page();
    //     } else if ($campaign_category==5) {
    //         $image = Implement::implement_category_page();
    //     } else if ($campaign_category==6) {
    //         $image = Seed::seeds_category_page();
    //     } else if ($campaign_category==7) {
    //         $image = Tyre::tyre_category_page();
    //     } else if ($campaign_category==8) {
    //         $image = pesticides::pesticides_category_page();
    //     } else if ($campaign_category==9) {
    //         $image = fertilizers::fertilizers_category_page();
    //     }

    //     $output['response']        = true;
    //     $output['message']         = 'Category Wish Banner And Boost Product';
    //     $output['banner']          = $banner;
    //     $output['boost_product']   = $boost_product;
    //     $output['image']           = $image;
    //     $output['error']           = "";

    //     return $output;
        
    // }
    
    public function category_wish_Banner_boost_product(Request $request)
    {
        $datas = [];
        $campaign_category = $request->campaign_category;
        $data = array();

        if($campaign_category == 12){
           // dd($campaign_category);
            $all_banner_count = DB::table('crops_banners')->where('category_id',$campaign_category)->where('status',1)->count();
            $all_banner = DB::table('crops_banners')->where('category_id',$campaign_category)->where('status',1)->get();

            if($all_banner_count > 0){
                //dd($all_banner);
                foreach ($all_banner as $key1 => $ban) {
                    $banner_img = asset('storage/crops/banner/' . $ban->image);
    
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
    
                    $banner[$key1] = [
                        'id' => $ban->id, 'banner_image' => $banner_img, 'user_id' => $ban->user_id, 'name' => $name,
                        'company_name' => $company_name, 'mobile' => $mobile, 'email' => $email, 'status' => $ban->status
                    ];
                }

            }else{
                $banner = [];
            }

            $crops_boost_count = DB::table('crops_boosts')->count();
            if($crops_boost_count > 0){
                $datas = DB::select(
                    "SELECT 
                        NULL as distance,
                        t.id,
                        t.category_id,
                        t.user_id,
                            user.name,
                            user.user_type_id,
                            user.role_id,
                            user.company_name,
                            user.mobile,
                            user.email,
                            user.gender,
                            user.address,
                            user.zipcode,
                            user.firebase_token,
                            user.created_at as created_at_user,
                            user.photo,
                        t.set,
                        t.type,
                        t.brand_id,
                        t.model_id,
                        t.title,
                        brand.name AS brand_name,
                        model.model_name AS model_name,
            
                        t.year_of_purchase,
                        t.rc_available,
                        t.noc_available,
                        t.registration_no,
                        t.description,
                        t.is_negotiable,
                        t.crop_type,
                        t.cutting_with,
                        t.power_source,
                        t.position,
            
                        t.front_image,
                        t.left_image,
                        t.right_image,
                        t.back_image,
                        t.meter_image,
                        t.tyre_image,
                        t.image1,
                        t.image2,
                        t.image3,
                        t.price,
                        t.rent_type,
                        
                        t.country_id,
                        t.state_id,
                        t.district_id,
                        t.pincode,
                        t.city_id,
                        state.state_name AS state_name,
                        district.district_name AS district_name,
                        city.city_name AS city_name,
                        t.latlong,
                        t.ad_report,
                        t.created_at,
                        t.updated_at,
                        t.status ,
                        t.crops_subscribed_id,
                        t.crops_category_id,
                        crops_category.crops_cat_name as crop_category_name
                    FROM (
                        SELECT
                            'crops',
                            id,
                            crops_subscribed_id,
                            category_id,
                            user_id,
                            NULL as `set`,
                            NULL as brand_id,
                            NULL as model_id,
                            type,
                            title,
                            price,
                            quantity,
                            expiry_date,
                            valid_till,
                            crops_category_id,
            
                            NULL as year_of_purchase,
                            NULL as rc_available,
                            NULL as noc_available,
                            NULL as registration_no,
                            description,
                            is_negotiable,
                            NULL as crop_type,
                            NULL as cutting_with,
                            NULL as power_source,
                            NULL as position,
            
                            NULL as front_image,
                            NULL as left_image,
                            NULL as right_image,
                            NULL as back_image,
                            NULL as meter_image,
                            NULL as tyre_image,
                            CONCAT('" . env('IMAGE_PATH_CROPS') . "',image1) as image1,
                            CONCAT('" . env('IMAGE_PATH_CROPS') . "',image2) as image2,
                            CONCAT('" . env('IMAGE_PATH_CROPS') . "',image3) as image3,
                            
                            NULL as rent_type,
                            country_id,
                            state_id,
                            district_id,
                            city_id,
                            pincode,
            
                            latlong,
                            ad_report,
                            created_at,
                            updated_at,
                            status
                        FROM crops
        
                    ) AS t
                    LEFT JOIN brand ON t.brand_id = brand.id
                    LEFT JOIN model ON t.model_id = model.id
                    LEFT JOIN state ON t.state_id = state.id
                    LEFT JOIN district ON t.district_id = district.id
                    LEFT JOIN city ON t.city_id = city.id
                    LEFT JOIN user on t.user_id = user.id
                    LEFT JOIN crops_boosts on t.id = crops_boosts.crop_id
                    LEFT JOIN crops_category on t.crops_category_id = crops_category.id
                    
                    where crops_boosts.category_id = $campaign_category and crops_boosts.status = 1 and crops_boosts.crop_id = t.id
                ");

                foreach($datas as $key=>$ban_det){
    
                    $specification = [];

                    $banner_details[$key] = 
                    [
                        'distance'         => $ban_det->distance,
                        'is_boosted'       => true,
                        'id'               => $ban_det->id,
                        'category_id'      => $ban_det->category_id,
                        'user_id'          => $ban_det->user_id,
                        'name'             =>$ban_det->name,
                        'user_type_id'     =>$ban_det->user_type_id,
                        'role_id'          =>$ban_det->role_id,
                        'company_name'     =>$ban_det->company_name,
                        'mobile'           =>$ban_det->mobile,
                        'email'            =>$ban_det->email,
                        'gender'           =>$ban_det->gender,
                        'address'          =>$ban_det->address,
                        'zipcode'          =>$ban_det->zipcode,
                        'firebase_token'   =>$ban_det->firebase_token,
                        'created_at_user'  =>$ban_det->created_at_user,
                        'photo'            =>$ban_det->photo,
                        'set'              =>$ban_det->set,
                        'type'             => $ban_det->type,
                        'brand_id'         => $ban_det->brand_id,
                        'model_id'         => $ban_det->model_id,
                        'title'            => $ban_det->title,
                        'brand_name'       => $ban_det->brand_name,
                        'model_name'       => $ban_det->model_name,
                        'year_of_purchase' => $ban_det->year_of_purchase,
                        'rc_available'     => $ban_det->rc_available,
                        'noc_available'    => $ban_det->noc_available,
                        'registration_no'  => $ban_det->registration_no,
                        'description'      => $ban_det->description,
                        'is_negotiable'    => $ban_det->is_negotiable,
                        'crop_type'        => $ban_det->crop_type,
                        'cutting_with'     => $ban_det->cutting_with,
                        'power_source'     => $ban_det->power_source,
                        'position'         => $ban_det->position,
                        'front_image'      => $ban_det->front_image,
                        'left_image'       => $ban_det->left_image,
                        'right_image'      =>$ban_det->right_image ,
                        'back_image'       => $ban_det->back_image,
                        'meter_image'      => $ban_det->meter_image,
                        'tyre_image'       => $ban_det->tyre_image,
                        'image1'           => $ban_det->image1,
                        'image2'           => $ban_det->image2,
                        'image3'           => $ban_det->image3,
                        'price'            => $ban_det->price,
                        'rent_type'        => $ban_det->rent_type,
                        'country_id'       => $ban_det->country_id,
                        'state_id'         => $ban_det->state_id,
                        'district_id'      => $ban_det->district_id,
                        'pincode'          => $ban_det->pincode,
                        'city_id'          => $ban_det->city_id,
                        'state_name'       => $ban_det->state_name,
                        'district_name'    => $ban_det->district_name,
                        'city_name'        => $ban_det->city_name,
                        'latlong'          => $ban_det->latlong,
                        'ad_report'        => $ban_det->ad_report,
                        'created_at'       => $ban_det->created_at,
                        'updated_at'       => $ban_det->updated_at,
                        'status'           => $ban_det->status,
                        'specification'   => $specification,
                        'crops_subscribed_id' => $ban_det->crops_subscribed_id,
                        'crops_category_id' => $ban_det->crops_category_id,
                        'crop_category_name' => $ban_det->crop_category_name,
        
                    ];
        
                }

              //  dd($banner_details);

            }else{
                $banner_details = [];
            }
            
            $banner_d = DB::table('settings')->where(['status'=>'crops_category_page_banner'])->get();
            //dd($banner_d);
            foreach ($banner_d as $val) {
                $db_id = $val->id;
                $name = $val->name;
                $value = $val->value;
                $status = $val->status;
                $banner_crops[] = ['db_id'=>$db_id,'name'=>$name,'banner'=>$value,'status'=>$status];
            }
            
            $array['banner'] = $banner_crops;
            $array['icons'] = [];
            $array;
           
            $output['response']        = true;
            $output['message']         = 'Category Wish Banner And Boost Product';
            $output['banner']          = $banner;
            $output['boost_product']   = $banner_details;
            $output['image']           = $array;
            $output['error']           = "";


        }else{
           // dd($campaign_category);
            $all_banner_count = DB::table('ads_banners')->whereRaw('FIND_IN_SET(?, campaign_category)', [$campaign_category])->where('status',1)->count();
            $all_banner = DB::table('ads_banners')->whereRaw('FIND_IN_SET(?, campaign_category)', [$campaign_category])->where('status',1)->get();
            
            if($all_banner_count > 0){
                foreach ($all_banner as $key1 => $ban) {
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
    
                    $banner[$key1] = [
                        'id' => $ban->id, 'banner_image' => $banner_img, 'user_id' => $ban->user_id, 'name' => $name,
                        'company_name' => $company_name, 'mobile' => $mobile, 'email' => $email, 'status' => $ban->status
                    ];
                }
            }else{
                $banner = [];
            }
    
       
            $datas = DB::select(
            "SELECT 
                NULL as distance,
                t.id,
                t.category_id,
                t.user_id,
                    user.name,
                    user.user_type_id,
                    user.role_id,
                    user.company_name,
                    user.mobile,
                    user.email,
                    user.gender,
                    user.address,
                    user.zipcode,
                    user.firebase_token,
                    user.created_at as created_at_user,
                    user.photo,
                t.set,
                t.type,
                t.brand_id,
                t.model_id,
                t.title,
                brand.name AS brand_name,
                model.model_name AS model_name,
    
                t.year_of_purchase,
                t.rc_available,
                t.noc_available,
                t.registration_no,
                t.description,
                t.is_negotiable,
                t.crop_type,
                t.cutting_with,
                t.power_source,
                t.position,
    
                t.front_image,
                t.left_image,
                t.right_image,
                t.back_image,
                t.meter_image,
                t.tyre_image,
                t.image1,
                t.image2,
                t.image3,
                t.price,
                t.rent_type,
                
                t.country_id,
                t.state_id,
                t.district_id,
                t.pincode,
                t.city_id,
                state.state_name AS state_name,
                district.district_name AS district_name,
                city.city_name AS city_name,
                t.latlong,
                t.ad_report,
                t.created_at,
                t.updated_at,
                t.status  
            FROM (
                SELECT
                    'tractor',
                    id,
                    category_id,
                    user_id,
                    `set`,
                    type,
                    brand_id,
                    model_id,
                    title,
    
                    year_of_purchase,
                    rc_available,
                    noc_available,
                    registration_no,
                    description,
                    is_negotiable,
                    NULL as crop_type,
                    NULL as cutting_with,
                    NULL as power_source,
                    NULL as position,
    
                    CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',front_image) as front_image,
                    CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',left_image) as left_image,
                    CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',right_image) as right_image,
                    CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',back_image) as back_image,
                    CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',meter_image) as meter_image,
                    CONCAT('" . env('IMAGE_PATH_TRACTOR') . "',tyre_image) as tyre_image,
                    NULL as image1,
                    NULL as image2,
                    NULL as image3,
                    
                    price,
                    rent_type,
                    country_id,
                    state_id,
                    district_id,
                    city_id,
                    pincode,
    
                    latlong,
                    ad_report,
                    created_at,
                    updated_at,
                    status
                FROM tractor
                
            
                UNION ALL
            
                SELECT
                    'goods_vehicle',
                    id,
                    category_id,
                    user_id,
                    `set`,
                    type,
                    brand_id,
                    model_id,
                    title,
    
                    year_of_purchase,
                    rc_available,
                    noc_available,
                    registration_no,
                    description,
                    is_negotiable,
                    NULL as crop_type,
                    NULL as cutting_with,
                    NULL as power_source,
                    NULL as position,
    
                    CONCAT('" . env('IMAGE_PATH_GV') . "',front_image) as front_image,
                    CONCAT('" . env('IMAGE_PATH_GV') . "',left_image) as left_image,
                    CONCAT('" . env('IMAGE_PATH_GV') . "',right_image) as right_image,
                    CONCAT('" . env('IMAGE_PATH_GV') . "',back_image) as back_image,
                    CONCAT('" . env('IMAGE_PATH_GV') . "',meter_image) as meter_image,
                    CONCAT('" . env('IMAGE_PATH_GV') . "',tyre_image) as tyre_image,
                    NULL as image1,
                    NULL as image2,
                    NULL as image3,
                    
                    price,
                    rent_type,
                    country_id,
                    state_id,
                    district_id,
                    city_id,
                    pincode,
    
                    latlong,
                    ad_report,
                    created_at,
                    updated_at,
                    status
                FROM goods_vehicle
                
                UNION ALL
            
                SELECT
                    'harvester',
                    id,
                    category_id,
                    user_id,
                    `set`,
                    type,
                    brand_id,
                    model_id,
                    title,
    
                    year_of_purchase,
                    NULL as rc_available,
                    NULL as noc_available,
                    NULL as registration_no,
                    description,
                    is_negotiable,
                    crop_type,
                    cutting_with,
                    power_source,
                    NULL as position,
    
                    CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as front_image,
                    CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',left_image) as left_image,
                    CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',right_image) as right_image,
                    CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',back_image) as back_image,
                    CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as meter_image,
                    CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as tyre_image,
                    NULL as image1,
                    NULL as image2,
                    NULL as image3,
                    
                    price,
                    rent_type,
                    country_id,
                    state_id,
                    district_id,
                    city_id,
                    pincode,
    
                    NULL as latlong,
                    ad_report,
                    created_at,
                    updated_at,
                    status
                FROM harvester
                
            
                UNION ALL
            
                SELECT
                    'implements',
                    id,
                    category_id,
                    user_id,
                    `set`,
                    type,
                    brand_id,
                    model_id,
                    title,
    
                    year_of_purchase,
                    NULL as rc_available,
                    NULL as noc_available,
                    NULL as registration_no,
                    description,
                    is_negotiable,
                    NULL as crop_type,
                    NULL as cutting_with,
                    NULL as power_source,
                    NULL as position,
    
                    CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as front_image,
                    CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',left_image) as left_image,
                    CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',right_image) as right_image,
                    CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',back_image) as back_image,
                    CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as meter_image,
                    CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',front_image) as tyre_image,
                    NULL as image1,
                    NULL as image2,
                    NULL as image3,
                    
                    price,
                    rent_type,
                    country_id,
                    state_id,
                    district_id,
                    city_id,
                    pincode,
    
                    latlong,
                    ad_report,
                    created_at,
                    updated_at,
                    status
                FROM implements
            
            
                UNION ALL
            
                SELECT
                    'seeds',
                    id,
                    category_id,
                    user_id,
                    NULL as `set`,
                    NULL as type,
                    NULL as brand_id,
                    NULL as model_id,
                    title,
    
                    NULL as year_of_purchase,
                    NULL as rc_available,
                    NULL as noc_available,
                    NULL as registration_no,
                    description,
                    is_negotiable,
                    NULL as crop_type,
                    NULL as cutting_with,
                    NULL as power_source,
                    NULL as position,
    
                    NULL as front_image,
                    NULL as left_image,
                    NULL as right_image,
                    NULL as back_image,
                    NULL as meter_image,
                    NULL as tyre_image,
                    CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image1) as image1,
                    CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image2) as image2,
                    CONCAT('" . env('IMAGE_PATH_SEEDS') . "',image3) as image3,
                    
                    price,
                    NULL as rent_type,
                    country_id,
                    state_id,
                    district_id,
                    city_id,
                    pincode,
    
                    latlong,
                    ad_report,
                    created_at,
                    updated_at,
                    status
                FROM seeds
            
            
                UNION ALL
            
                SELECT
                    'pesticides',
                    id,
                    category_id,
                    user_id,
                    NULL as `set`,
                    NULL as type,
                    NULL as brand_id,
                    NULL as model_id,
                    title,
    
                    NULL as year_of_purchase,
                    NULL as rc_available,
                    NULL as noc_available,
                    NULL as registration_no,
                    description,
                    is_negotiable,
                    NULL as crop_type,
                    NULL as cutting_with,
                    NULL as power_source,
                    NULL as position,
    
                    NULL as front_image,
                    NULL as left_image,
                    NULL as right_image,
                    NULL as back_image,
                    NULL as meter_image,
                    NULL as tyre_image,
                    CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image1) as image1,
                    CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image2) as image2,
                    CONCAT('" . env('IMAGE_PATH_PESTICIDES') . "',image3) as image3,
                    
                    price,
                    NULL as rent_type,
                    country_id,
                    state_id,
                    district_id,
                    city_id,
                    pincode,
    
                    latlong,
                    ad_report,
                    created_at,
                    updated_at,
                    status
                FROM pesticides
            
            
                UNION ALL
            
                SELECT
                ' fertilizers',
                    id,
                    category_id,
                    user_id,
                    NULL as `set`,
                    NULL as type,
                    NULL as brand_id,
                    NULL as model_id,
                    title,
    
                    NULL as year_of_purchase,
                    NULL as rc_available,
                    NULL as noc_available,
                    NULL as registration_no,
                    description,
                    is_negotiable,
                    NULL as crop_type,
                    NULL as cutting_with,
                    NULL as power_source,
                    NULL as position,
    
                    NULL as front_image,
                    NULL as left_image,
                    NULL as right_image,
                    NULL as back_image,
                    NULL as meter_image,
                    NULL as tyre_image,
                    CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image1) as image1,
                    CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image2) as image2,
                    CONCAT('" . env('IMAGE_PATH_FERTILIZERS') . "',image3) as image3,
                    
                    price,
                    NULL as rent_type,
                    country_id,
                    state_id,
                    district_id,
                    city_id,
                    pincode,
    
                    latlong,
                    ad_report,
                    created_at,
                    updated_at,
                    status
                FROM fertilizers
            
            
                UNION ALL
            
                SELECT
                'tyres',
                    id,
                    category_id,
                    user_id,
                    NULL as `set`,
                    type,
                    brand_id,
                    model_id,
                    title,
    
                    NULL as year_of_purchase,
                    NULL as rc_available,
                    NULL as noc_available,
                    NULL as registration_no,
                    description,
                    is_negotiable,
                    NULL as crop_type,
                    NULL as cutting_with,
                    NULL as power_source,
                    position,
    
                    NULL as front_image,
                    NULL as left_image,
                    NULL as right_image,
                    NULL as back_image,
                    NULL as meter_image,
                    NULL as tyre_image,
                    CONCAT('" . env('IMAGE_PATH_TYRE') . "',image1) as image1,
                    CONCAT('" . env('IMAGE_PATH_TYRE') . "',image2) as image2,
                    CONCAT('" . env('IMAGE_PATH_TYRE') . "',image3) as image3,
                    
                    price,
                    NULL as rent_type,
                    country_id,
                    state_id,
                    district_id,
                    city_id,
                    pincode,
    
                    latlong,
                    ad_report,
                    created_at,
                    updated_at,
                    status
                FROM tyres
            
            
            ) AS t
            LEFT JOIN brand ON t.brand_id = brand.id
            LEFT JOIN model ON t.model_id = model.id
            LEFT JOIN state ON t.state_id = state.id
            LEFT JOIN district ON t.district_id = district.id
            LEFT JOIN city ON t.city_id = city.id
            LEFT JOIN user on t.user_id = user.id
            LEFT JOIN subscribed_boosts on t.id = subscribed_boosts.product_id
            
            where subscribed_boosts.category_id = $campaign_category and subscribed_boosts.status = 1
            and t.category_id = $campaign_category
            
            ");
    
            foreach($datas as $key=>$ban_det){
    
                $specification = [];
                $model_id = $ban_det->model_id;
                $specification = DB::table('specifications')
                        ->where(['model_id' => $model_id, 'status' => 1])->get();
                
    
                $banner_details[$key] = 
                [
                    'distance'         => $ban_det->distance,
                    'is_boosted'      => true,
                    'id'               => $ban_det->id,
                    'category_id'      => $ban_det->category_id,
                    'user_id'          => $ban_det->user_id,
                    'name'             =>$ban_det->name,
                    'user_type_id'     =>$ban_det->user_type_id,
                    'role_id'          =>$ban_det->role_id,
                    'company_name'     =>$ban_det->company_name,
                    'mobile'           =>$ban_det->mobile,
                    'email'            =>$ban_det->email,
                    'gender'           =>$ban_det->gender,
                    'address'          =>$ban_det->address,
                    'zipcode'          =>$ban_det->zipcode,
                    'firebase_token'   =>$ban_det->firebase_token,
                    'created_at_user'  =>$ban_det->created_at_user,
                    'photo'            =>$ban_det->photo,
                    'set'              =>$ban_det->set,
                    'type'             => $ban_det->type,
                    'brand_id'         => $ban_det->brand_id,
                    'model_id'         => $ban_det->model_id,
                    'title'            => $ban_det->title,
                    'brand_name'       => $ban_det->brand_name,
                    'model_name'       => $ban_det->model_name,
                    'year_of_purchase' => $ban_det->year_of_purchase,
                    'rc_available'     => $ban_det->rc_available,
                    'noc_available'    => $ban_det->noc_available,
                    'registration_no'  => $ban_det->registration_no,
                    'description'      => $ban_det->description,
                    'is_negotiable'    => $ban_det->is_negotiable,
                    'crop_type'        => $ban_det->crop_type,
                    'cutting_with'     => $ban_det->cutting_with,
                    'power_source'     => $ban_det->power_source,
                    'position'         => $ban_det->position,
                    'front_image'      => $ban_det->front_image,
                    'left_image'       => $ban_det->left_image,
                    'right_image'      =>$ban_det->right_image ,
                    'back_image'       => $ban_det->back_image,
                    'meter_image'      => $ban_det->meter_image,
                    'tyre_image'       => $ban_det->tyre_image,
                    'image1'           => $ban_det->image1,
                    'image2'           => $ban_det->image2,
                    'image3'           => $ban_det->image3,
                    'price'            => $ban_det->price,
                    'rent_type'        => $ban_det->rent_type,
                    'country_id'       => $ban_det->country_id,
                    'state_id'         => $ban_det->state_id,
                    'district_id'      => $ban_det->district_id,
                    'pincode'          => $ban_det->pincode,
                    'city_id'          => $ban_det->city_id,
                    'state_name'       => $ban_det->state_name,
                    'district_name'    => $ban_det->district_name,
                    'city_name'        => $ban_det->city_name,
                    'latlong'          => $ban_det->latlong,
                    'ad_report'        => $ban_det->ad_report,
                    'created_at'       => $ban_det->created_at,
                    'updated_at'       => $ban_det->updated_at,
                    'status'           => $ban_det->status,
                    'specification'   => $specification
    
                ];
    
            }
    
        //   $data['boost']= $datas;
        //   return $data;
    
            if(!empty($datas)){
                $boost_product = $banner_details;
            }else{
                $boost_product = [];
            }
    
            if ($campaign_category==1) {
                $image = Tractor::tractor_category_page();
            } else if ($campaign_category==3) {
                $image = Goods_vehicle::gv_category_page();
            } else if ($campaign_category==4) {
                $image = Harvester::harvester_category_page();
            } else if ($campaign_category==5) {
                $image = Implement::implement_category_page();
            } else if ($campaign_category==6) {
                $image = Seed::seeds_category_page();
            } else if ($campaign_category==7) {
                $image = Tyre::tyre_category_page();
            } else if ($campaign_category==8) {
                $image = pesticides::pesticides_category_page();
            } else if ($campaign_category==9) {
                $image = fertilizers::fertilizers_category_page();
            }
    
            $output['response']        = true;
            $output['message']         = 'Category Wish Banner And Boost Product';
            $output['banner']          = $banner;
            $output['boost_product']   = $boost_product;
            $output['image']           = $image;
            $output['error']           = "";

            // return $output;

        }

        return $output;

    }

    public function category_page (Request $request) {
        $output=[];
        $data=[];
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        $category = $request->category;
        
        $Autn = DB::table('user')->where(['id'=>$user_id,'token'=>$user_token])->count();
        if ($Autn==0) {
            $output['response']=false;
            $output['message']='Authentication Failed';
            $output['data'] = $data;
            $output['error'] = "";
            return $output;
            exit;
        }
        
        $validator = Validator::make($request->all(), [
            //'category_id' => 'required',
            'user_id' => 'required',
            'user_token' => 'required',
            'category' => 'required'
        ]);
        if ($validator->fails()) {
            $output['response']=false;
            $output['message']='Validation error!';
            $output['data'] = $data;
            $output['error'] = "Validation error!";
        } else {
            if ($category==1) {
                $image = Tractor::tractor_category_page();
            } else if ($category==3) {
                $image = Goods_vehicle::gv_category_page();
            } else if ($category==4) {
                $image = Harvester::harvester_category_page();
            } else if ($category==5) {
                $image = Implement::implement_category_page();
            } else if ($category==6) {
                $image = Seed::seeds_category_page();
            } else if ($category==7) {
                $image = Tyre::tyre_category_page();
            } else if ($category==8) {
                $image = pesticides::pesticides_category_page();
            } else if ($category==9) {
                $image = fertilizers::fertilizers_category_page();
            }
               $data[] = $image;
                
                $output['response']=true;
                $output['message']='Data';
                $output['data'] = $data;
                $output['error'] = "";
        }
        return $output;
    }

    public function category_test(Request $request ,TC $tc , GC $gc , HC $hc , IC $ic, SC $sc , PC $pc , FC $fc , TyC $tyC ){
        //dd($request->all());
        $category_id = $request->category_id;
        //dd($category_id);

        if($category_id == 1){
            $add = $tc->tractor_add($request);
        }

    }

}
