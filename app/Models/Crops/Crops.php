<?php

namespace App\Models\Crops;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Leads_view;
use App\Models\Lead;

class Crops extends Model
{
    use HasFactory;

    # ADD CROPS
    protected function addCrops($crop_data)
    {
        //dd($crop_data);
        $insert_crops = DB::table('crops')->insertGetId($crop_data);
        return true;
    }

    # ADD CROPS
    protected function addCropCategoryItemCount($crop_category_id)
    {

        $add_crops_category = DB::table('crops_category')->where('id', $crop_category_id)->where('status', 1)->first();
        // dd($add_crops_category);
        $crops_category_item = $add_crops_category->item_count;
        // dd($crops_category_item);
        $add_item_count = $crops_category_item + 1;
        $update_crops_category = DB::table('crops_category')->where('id', $crop_category_id)
            ->where('status', 1)->update(['item_count' => $add_item_count]);

        return true;
    }

    # ADD CROPS SUBSCRIBED
    protected function addCropsSubscribed($crops_subscribed)
    {
        //dd($crops_subscribed);
        $add_crops_subscribed_id = DB::table('crops_subscribed')->insertGetId($crops_subscribed);

        $crops_subscribed_details = DB::table('crops_subscribed')->where('id', $add_crops_subscribed_id)->first();

        $user_id          = $crops_subscribed_details->user_id;
        $subscription_id  = $crops_subscribed_details->subscription_id;

        $crops_verification_tag   = DB::table('crop_subscription_features')->where('crops_subscription_id', $subscription_id)
            ->value('verification_tag');

        $user_update = DB::table('user')->where('id', $user_id)->update(['crops_verify_tag' => $crops_verification_tag]);
        return true;
    }


    # DIBYENDU CHANGE

    # TOTAL CROPS PRODUCT LEAD
    protected function my_lead_product_list($user_id, $skip, $take, $start_date, $end_date)
    {
        $datas = [];
        $lead_count = DB::table('seller_leads')->where('post_user_id', $user_id)->count();
        //dd($lead_count);

        if ($lead_count > 0) {
            $lead_details = DB::table('seller_leads')->where('post_user_id', $user_id)->get();
            // dd($lead_details);
            foreach ($lead_details as $key => $lead) {
                $viewer_user_id = $lead->user_id;

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
                     t.crops_category_id,
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
                     t.status,
                     seller_leads.id as seller_leads_id,
                     seller_leads.user_id as seller_leads_user_id,
                     seller_leads.created_at as seller_leads_created_at,
                     crops_category.crops_cat_name
                     
                 FROM (
                     SELECT
                         'crops',
                         id,
                         crops_subscribed_id,
                         category_id,
                         user_id,
                         NULL as `set`,
                         NULL as type,
                         NULL as brand_id,
                         NULL as model_id,
                         title,
                         quantity,
         
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
                         
                         crops_category_id,
                         
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
                     FROM crops
                 ) AS t
                 LEFT JOIN brand ON t.brand_id = brand.id
                 LEFT JOIN model ON t.model_id = model.id
                 LEFT JOIN state ON t.state_id = state.id
                 LEFT JOIN district ON t.district_id = district.id
                 LEFT JOIN city ON t.city_id = city.id
                 LEFT JOIN user on t.user_id = user.id
                  LEFT JOIN crops_category on t.crops_category_id = crops_category.id
                 LEFT JOIN seller_leads on  t.category_id = seller_leads.category_id and t.id = seller_leads.post_id  
                 where  seller_leads.created_at between '$start_date' and '$end_date' and seller_leads.post_user_id=$user_id and t.status=1 limit $skip,$take"
                );

                //dd($datas); 

                foreach ($datas as $data) {
                    $data->specification = [];
                }


                foreach ($datas as $data) {
                    $data->lead_user_details = [];
                    $data->lead_user_details = DB::table('user')
                        ->select(
                            'user.id as lead_user_id',
                            'user.user_type_id as lead_user_type_id',
                            'user.name as lead_user_name',
                            'user.mobile as lead_user_mobile',
                            'user.company_name as lead_user_company_name',
                            'user.gst_no as lead_user_gst_no',
                            'user.zipcode as lead_user_zipcode',
                            'user.status as lead_user_status',
                            'seller_leads.created_at as seller_lead_created_at',
                            'state.state_name',
                            'district.district_name',
                            'seller_leads.status as hot_lead_status'
                        )
                        ->leftJoin('state', 'state.id', '=', 'user.state_id')
                        ->leftJoin('district', 'district.id', '=', 'user.district_id')
                        ->leftJoin('seller_leads', 'seller_leads.user_id', '=', 'user.id')
                        ->where(['user.id' => $data->seller_leads_user_id, 'user.status' => 1, 'seller_leads.id' => $data->seller_leads_id])->first();
                }
            }

            ///dd($datas);

            if (!empty($datas)) {
                return $datas;
            }
        }
    }


    # TOTAL CROPS BANNER LEAD
    protected function my_lead_banner_list($user_id, $skip, $take, $start_date, $end_date)
    {
        //dd($end_date);
        $crops_banner_lead_count = DB::table('crops_banner_leads')->where('crops_banner_post_user_id', $user_id)->count();
        //dd( $crops_banner_lead_count);
        if ($crops_banner_lead_count > 0) {
            $crops_banner_lead = DB::table('crops_banner_leads')->where('crops_banner_post_user_id', $user_id)->get();

            foreach ($crops_banner_lead as $key => $banner) {

                $banner_details = DB::table('crops_banner_leads as cbl')
                    ->select(
                        'cbl.lead_user_id',
                        'us.id as user_id',
                        'us.name as user_name',
                        'us.mobile as user_mobile',
                         'us.zipcode as user_zipcode',
                        'state.state_name',
                        'district.district_name',
                        'cb.title as banner_title',
                        'cb.description as banner_description',
                        'cbl.created_at',
                        'cbl.status as banner_status',
                        DB::raw("CONCAT('" . env('IMAGE_PATH_CROPS_BANNER') . "', cb.image) as crops_banner")
                    )
                    ->leftJoin('user as us', 'us.id', '=', 'cbl.lead_user_id')
                    ->leftJoin('state', 'state.id', '=', 'us.state_id')
                    ->leftJoin('district', 'district.id', '=', 'us.district_id')
                    ->leftJoin('crops_banners as cb', 'cb.id', '=', 'cbl.crops_banner_id')

                    ->where('cbl.crops_banner_post_user_id', $user_id)
                    ->whereBetween('cbl.created_at', [$start_date, $end_date])
                    ->skip($skip)
                    ->take($take)
                    ->get();
            }

            //dd($banner_details);

            if (!empty($banner_details)) {
                return $banner_details;
            }
        } else {
            return false;
        }
    }


    protected function my_lead_product_offline_list($user_id, $skip, $take, $start_date, $end_date)
    {
        //dd($user_id);
        $datas = [];
        $offline_lead_count = DB::table('offline_leads')->where('user_id', $user_id)->count();
        //dd($offline_lead_count);

        if ($offline_lead_count > 0) {
            $lead_details = DB::table('offline_leads')->where('user_id', $user_id)->get();
            // dd($lead_details);

            foreach ($lead_details as $key => $lead) {
                $viewer_user_id = $lead->user_id;

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
                     t.status,
                     offline_leads.id as offline_leads_id
                     
                 FROM (
                     SELECT
                     'crops',
                         id,
                         crops_subscribed_id,
                         category_id,
                         user_id,
                         NULL as `set`,
                         NULL as type,
                         NULL as brand_id,
                         NULL as model_id,
                         title,
                         quantity,
         
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
                     FROM crops
                 ) AS t
                 LEFT JOIN brand ON t.brand_id = brand.id
                 LEFT JOIN model ON t.model_id = model.id
                 LEFT JOIN state ON t.state_id = state.id
                 LEFT JOIN district ON t.district_id = district.id
                 LEFT JOIN city ON t.city_id = city.id
                 LEFT JOIN user on t.user_id = user.id
                 LEFT JOIN offline_leads on  t.category_id = offline_leads.category_id and t.id = offline_leads.post_id  
                 where offline_leads.user_id=$user_id  limit $skip,$take"
                );

                foreach ($datas as $data) {
                    $data->specification = [];
                }

                foreach ($datas as $data) {
                    $data->lead_user_details = [];
                    $data->lead_user_details = DB::table('offline_leads as ol')
                        ->select(
                            'ol.username as lead_user_name',
                            'ol.mobile as lead_user_mobile',
                            'ol.zipcode as lead_user_zipcode',
                            'ol.status as hot_lead_status',
                            'ol.created_at as seller_lead_created_at'
                        )
                        ->where(['ol.user_id' => $data->user_id, 'post_id' => $data->id, 'id' => $data->offline_leads_id])
                        ->first();
                }
            }

            if (!empty($datas)) {
                return $datas;
            }
        }
    }
    
     protected function get_data_by_where($where)
    {
        $new = [];
        $count = DB::table('crops')->orderBy('id', 'desc')->where($where)->count();
        if ($count > 0) {
            $array_fer_model = DB::table('crops')->orderBy('id', 'desc')->where($where)->get();
            foreach ($array_fer_model as $val) {

                $data['id'] = $val->id;
                $data['category_id'] = $val->category_id;
                $data['user_id'] = $val->user_id;

                $user_count = DB::table('user')->where(['id' => $val->user_id])->count();
                if ($user_count > 0) {
                    $user_details = DB::table('user')->where(['id' => $val->user_id])->first();
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
                    if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                        $data['photo'] = '';
                    } else {
                        $data['photo'] = asset("storage/photo/$user_details->photo");
                    }
                }

                $data['title']       = $val->title;
                $data['price']       = $val->price;
                $data['description'] = $val->description;

                if ($val->image1 == '' || $val->image1 == 'NULL') {
                    $data['image1'] = '';
                } else {
                    $data['image1'] = asset("storage/crops/$val->image1");
                }
                if ($val->image2 == '' || $val->image2 == 'NULL') {
                    $data['image2'] = '';
                } else {
                    $data['image2'] = asset("storage/crops/$val->image2");
                }
                if ($val->image3 == '' || $val->image3 == 'NULL') {
                    $data['image3'] = '';
                } else {
                    $data['image3'] = asset("storage/crops/$val->image3");
                }

                $data['is_negotiable'] = $val->is_negotiable;
                $data['country_id']    = $val->country_id;
                $data['state_id']      = $val->state_id;
                $data['district_id']   = $val->district_id;
                $data['city_id']       = $val->city_id;

                if ($val->state_id != '' || $val->state_id != NULL) {
                    $state_arr_data = DB::table('state')->where(['id' => $val->state_id])->first();

                    $data['state_name'] = $state_arr_data->state_name;
                }

                if ($val->district_id != '' || $val->district_id != NULL) {
                    $state_arr_data = DB::table('district')->where(['id' => $val->district_id])->first();

                    $data['district_name'] = $state_arr_data->district_name;
                }

                if ($val->city_id != '' || $val->city_id != NULL) {
                    $city_arr_data = DB::table('city')->where(['id' => $val->city_id])->first();
                    $data['city_name'] = $city_arr_data->city_name;
                }

                $data['pincode']     = $val->pincode;
                $data['latlong']     = $val->latlong;
                $data['is_featured'] = $val->is_featured;
                $data['valid_till']  = $val->valid_till;
                $data['ad_report']   = $val->ad_report;
                $data['status']      = $val->status;
                $data['created_at']  = date("d-m-Y", strtotime($val->created_at));
                $data['updated_at']  = $val->updated_at;

                $data['view_lead'] = Leads_view::where(['category_id' => 12, 'post_id' => $val->id])->count();
                $data['call_lead'] = Lead::where(['category_id' => 12, 'post_id' => $val->id, 'calls_status' => 1])->count();
                $data['msg_lead']  = Lead::where(['category_id' => 12, 'post_id' => $val->id, 'messages_status' => 1])->count();

                $new[] = $data;
            }
        }
        return $new;
    }

    protected function crops_single($id, $user_id)
    {
        $count = DB::table('crops')->where(['id' => $id])->count();
        if ($count > 0) {

            $val = DB::table('crops')->where(['id' => $id])->first();

            $data['id']          = $val->id;
            $data['category_id'] = $val->category_id;
            $data['user_id']     = $val->user_id;

            $user_count = DB::table('user')->where(['id' => $val->user_id])->count();
            if ($user_count > 0) {
                $user_details = DB::table('user')->where(['id' => $val->user_id])->first();
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
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $data['photo'] = '';
                } else {
                    $data['photo'] = assert("storage/photo/$user_details->photo");
                }
            }


            $data['title'] = $val->title;
            $data['price'] = $val->price;
            $data['description'] = $val->description;
            if ($val->image1 == '' || $val->image1 == 'NULL') {
                $data['image1'] = '';
            } else {
                $data['image1'] = asset("storage/crops/$val->image1");
            }
            if ($val->image2 == '' || $val->image2 == 'NULL') {
                $data['image2'] = '';
            } else {
                $data['image2'] = asset("storage/crops/$val->image2");
            }
            if ($val->image3 == '' || $val->image3 == 'NULL') {
                $data['image3'] = '';
            } else {
                $data['image3'] = asset("storage/crops/$val->image3");
            }

            $data['is_negotiable'] = $val->is_negotiable;
            $data['country_id'] = $val->country_id;
            $data['state_id'] = $val->state_id;
            $data['district_id'] = $val->district_id;
            $data['city_id'] = $val->city_id;

            if ($val->state_id != '' || $val->state_id != NULL) {
                $state_arr_data = DB::table('state')->where(['id' => $val->state_id])->first();

                $data['state_name'] = $state_arr_data->state_name;
            }

            if ($val->district_id != '' || $val->district_id != NULL) {
                $state_arr_data = DB::table('district')->where(['id' => $val->district_id])->first();

                $data['district_name'] = $state_arr_data->district_name;
            }

            if ($val->city_id != '' || $val->city_id != NULL) {
                $city_arr_data = DB::table('city')->where(['id' => $val->city_id])->first();
                $data['city_name'] = $city_arr_data->city_name;
            }

            $data['wishlist_status'] = DB::table('wishlist')->where(['user_id' => $user_id, 'category_id' => 12, 'item_id' => $val->id])->count();
            $data['pincode'] = $val->pincode;
            $data['latlong'] = $val->latlong;
            $data['is_featured'] = $val->is_featured;
            $data['valid_till'] = $val->valid_till;
            $data['ad_report'] = $val->ad_report;
            $data['status'] = $val->status;
            // $data['created_at'] = date("d-m-Y", strtotime($val->created_at));
            $data['created_at'] = $val->created_at;
            $data['updated_at'] = $val->updated_at;
            $data['crops_subscribed_id'] = $val->crops_subscribed_id;
            $data['crops_category_id'] = $val->crops_category_id;
            $data['crop_category_name'] = DB::table('crops_category')->where('id',$val->crops_category_id)->value('crops_cat_name');
        }
        return $data;
    }
}
