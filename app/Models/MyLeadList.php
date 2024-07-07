<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription\Subscribed_boost;

class MyLeadList extends Model
{
    use HasFactory;
    # My Product Lead User List
    protected function my_lead_product_list($user_id, $skip, $take, $start_date, $end_date)
    {
        //dd($user_id);
        $datas = [];
        $lead_count = DB::table('seller_leads')->where('post_user_id', $user_id)->count();

       // $offline_lead_count = DB::table('offline_leads')->where('user_id', $user_id)->count();
       // dd($offline_lead_count);
      
        if ($lead_count > 0) {
            $lead_details = DB::table('seller_leads')->where('post_user_id', $user_id)->get();
            // dd($lead_details);
            foreach ($lead_details as $key => $lead) {
                // $category_id = $lead->category_id;
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
                     seller_leads.id as seller_leads_id,
                     seller_leads.user_id as seller_leads_user_id,
                     seller_leads.created_at as seller_leads_created_at
                     
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
                         CONCAT('https://krishivikas.com/storage/tyres/',image3) as image3,
                         
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
                 LEFT JOIN seller_leads on  t.category_id = seller_leads.category_id and t.id = seller_leads.post_id  
                 where  seller_leads.created_at between '$start_date' and '$end_date' and seller_leads.post_user_id=$user_id and t.status=1 limit $skip,$take"
                );

                //where subscribed_boosts.category_id=1  and t.status=1 and t.id = subscribed_boosts.product_id");
                //print_r($datas);
                //dd($datas);

                foreach ($datas as $data) {
                    $data->specification = [];
                    $model_id = $data->model_id;
                    $data->specification = DB::table('specifications')
                        ->where(['model_id' => $model_id, 'status' => 1])->get();
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
           // dd($datas); 

            if (!empty($datas)) {
                return $datas;
            }
        }
    }

    protected function my_lead_product_offline_list($user_id, $skip, $take, $start_date, $end_date)
    {
      //  dd($user_id);
        $datas = [];
       // $lead_count = DB::table('seller_leads')->where('post_user_id', $user_id)->count();

        $offline_lead_count = DB::table('offline_leads')->where('user_id', $user_id)->count();
       // dd($offline_lead_count);
      
        if ($offline_lead_count > 0) {
            $lead_details = DB::table('offline_leads')->where('user_id', $user_id)->get();
            // dd($lead_details);
            foreach ($lead_details as $key => $lead) {
                // $category_id = $lead->category_id;
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
                         CONCAT('https://krishivikas.com/storage/tyres/',image3) as image3,
                         
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
                 LEFT JOIN offline_leads on  t.category_id = offline_leads.category_id and t.id = offline_leads.post_id  
                 where offline_leads.user_id=$user_id  limit $skip,$take"
                );

        //dd($datas); 
                foreach ($datas as $data) {
                    $data->specification = [];
                    $model_id = $data->model_id;
                    $data->specification = DB::table('specifications')
                        ->where(['model_id' => $model_id, 'status' => 1])->get();
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
                            ->where(['ol.user_id' => $data->user_id ,'post_id'=>$data->id ,'id'=>$data->offline_leads_id])
                            ->first();
                }
            }
            //dd($datas); 
           // exit;

            if (!empty($datas)) {
                return $datas;
            }
        }
    }

    # My Banner Lead User List
    protected function my_lead_banner_list($user_id, $skip, $take, $start_date, $end_date)
    {

        // dd($end_date);
        $banner_lead = DB::table('banner_leads')->where('banner_post_user_id', $user_id)->get();

        foreach ($banner_lead as $key => $banner) {
            $banner_details = DB::table('ads_banners as adb')
                ->select(
                    'adb.id',
                    'adb.subscription_id',
                    'adb.subscription_features_id',
                    'adb.subscribed_id',
                    'adb.user_id',
                    'adb.campaign_name',
                    'adb.campaign_state',
                    'adb.status',
                    'adb.created_at',
                    'adb.updated_at',

                    'subs.price',
                    'subs.start_date',
                    'subs.end_date',
                    'subs.coupon_code_id',
                    'subs.coupon_code',
                    'subs.purchased_price',
                    'subs.transaction_id',
                    'subs.order_id',
                    'subs.invoice_no',

                    'sf.name as subscribtion_feature_name',
                    'sf.days',
                    'sf.website',
                    'sf.mobile',
                    'sf.sub_category',
                    'sf.category',
                    'sf.listing',
                    'sf.creatives',
                    'sf.state as no_of_state',

                    'sub.name as subscribtion_name',

                    'e.discount_percentage',
                    'e.discount_percentage',
                    'e.discount_flat',

                    'b.id as banner_leads_id',
                    'b.user_id as banner_leads_user_id',
                    'b.created_at as banner_leads_created_at',


                    'us.id as user_id',
                    'us.name as user_name',
                    'us.gst_no as user_gst_no',
                    'us.company_name as user_company_name',
                    'us.mobile as user_mobile',

                    // 'u.id as lead_user_id', 'u.user_type_id as lead_user_type_id','u.name as lead_user_name', 'u.gst_no as lead_user_gst_no' , 'u.company_name as lead_user_company_name','u.mobile as lead_user_mobile' ,
                    // 'sell.created_at as seller_lead_created_at','u.zipcode as lead_user_zipcode','u.zipcode as lead_user_zipcode', 's.state_name','d.district_name',
                    
                    DB::raw("CONCAT('".env('IMAGE_PATH_SPONSER')."', adb.campaign_banner) as campaign_banner")
                )
                ->leftJoin('banner_leads as b', 'b.banner_id', '=', 'adb.id')
                ->leftJoin('subscribeds as subs', 'subs.id', '=', 'adb.subscribed_id')
                ->leftJoin('subscriptions as sub', 'sub.id', '=', 'adb.subscription_id')
                ->leftJoin('subscription_features as sf', 'sf.id', '=', 'adb.subscription_features_id')
                ->leftJoin('coupons as e', 'e.id', '=', 'subs.coupon_code_id')
                // ->leftJoin('user as u', 'u.id', '=', 'b.user_id')
                ->leftJoin('user as us', 'us.id', '=', 'adb.user_id')
                // ->leftJoin('state as s', 's.id', '=', 'u.state_id')
                // ->leftJoin('district as d', 'd.id', '=', 'u.district_id')
                // ->leftJoin('seller_leads as sell', 'sell.post_user_id', '=', 'u.id')
                ->where(['adb.status' => 1])
                ->where('b.banner_post_user_id', $user_id)
                ->whereBetween('b.created_at', [$start_date, $end_date])

                ->skip($skip)
                ->take($take)
                ->get();
        }

        if (!empty($banner_details)) {
            return $banner_details;
        }
    }

    # My Enquiry Category Product
  /*  protected function my_enquiry_product_list($user_id, $category_id, $skip, $take)
    {

        //dd($user_id);
        $lead_count   = DB::table('seller_leads')->where('user_id', $user_id)->count();
        // dd($lead_count);
        if ($lead_count > 0) {

            //  $lead_details = DB::table('seller_leads')->where('user_id', $user_id)->get();
            // dd($lead_details);

            //  foreach ($lead_details as $key => $lead) {

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
                          seller_leads.user_id as seller_leads_user_id
                          
                          
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
                      join seller_leads on  t.category_id= seller_leads.category_id and t.id = seller_leads.post_id  
                      where  t.status=1 and seller_leads.user_id = $user_id order by t.id desc limit $skip,$take"
            );

            foreach ($datas as $data) {
                $data->specification = [];
                $model_id = $data->model_id;
                $data->specification = DB::table('specifications')
                    ->where(['model_id' => $model_id, 'status' => 1])->get();
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
                        'user.mobile as lead_user_mobile',
                        'user.zipcode as lead_user_zipcode ',
                        'user.status as lead_user_status ',
                        'seller_leads.created_at as seller_lead_created_at',
                        'state.state_name',
                        'district.district_name'
                    )
                    ->leftJoin('state', 'state.id', '=', 'user.state_id')
                    ->leftJoin('district', 'district.id', '=', 'user.district_id')
                    ->leftJoin('seller_leads', 'seller_leads.user_id', '=', 'user.id')
                    ->where(['user.id' => $data->seller_leads_user_id])->first();
            }

            if (!empty($datas)) {
                return $datas;
            }
        }
    } */
    /*protected function my_enquiry_product_list($user_id, $category_id, $skip, $take)
    {

        //dd($user_id);
        $lead_count   = DB::table('seller_leads')->where('user_id', $user_id)->count();
        // dd($lead_count);
        if ($lead_count > 0) {
          $datas =  DB::select(
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
                seller_leads.user_id as seller_leads_user_id
            FROM (
                SELECT
                    'tractor' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM tractor
                
                UNION ALL
                
                SELECT
                    'goods_vehicle' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM goods_vehicle
                
                UNION ALL
                
                SELECT
                    'harvester' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM harvester
                
                UNION ALL
                
                SELECT
                    'implements' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM implements
                
                UNION ALL
                
                SELECT
                    'seeds' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM seeds
                
                UNION ALL
                
                SELECT
                    'pesticides' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM pesticides
                
                UNION ALL
                
                SELECT
                    'fertilizers' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM fertilizers

                UNION ALL
                
                SELECT
                    'crops' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM crops
                
                UNION ALL
                
                SELECT
                    'tyres' AS item_type,
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
                    CONCAT('http://127.0.0.1:8000/storage/tyre/', image1) as image1,
                    CONCAT('http://127.0.0.1:8000/storage/tyre/', image2) as image2,
                    CONCAT('http://127.0.0.1:8000/storage/tyre/', image3) as image3,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM tyres

            ) AS t
            LEFT JOIN brand ON t.brand_id = brand.id
            LEFT JOIN model ON t.model_id = model.id
            LEFT JOIN state ON t.state_id = state.id
            LEFT JOIN district ON t.district_id = district.id
            LEFT JOIN city ON t.city_id = city.id
            LEFT JOIN user on t.user_id = user.id
            JOIN seller_leads on t.category_id = seller_leads.category_id and t.id = seller_leads.post_id  
            WHERE t.status=1 AND seller_leads.user_id = $user_id 
            ORDER BY t.id DESC 
            LIMIT $skip,$take");


            foreach ($datas as $data) {
                $data->specification = [];
                $model_id = $data->model_id;
                $data->specification = DB::table('specifications')
                    ->where(['model_id' => $model_id, 'status' => 1])->get();
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
                        'user.mobile as lead_user_mobile',
                        'user.zipcode as lead_user_zipcode ',
                        'user.status as lead_user_status ',
                        'seller_leads.created_at as seller_lead_created_at',
                        'state.state_name',
                        'district.district_name'
                    )
                    ->leftJoin('state', 'state.id', '=', 'user.state_id')
                    ->leftJoin('district', 'district.id', '=', 'user.district_id')
                    ->leftJoin('seller_leads', 'seller_leads.user_id', '=', 'user.id')
                    ->where(['user.id' => $data->seller_leads_user_id])->first();
            }

            if (!empty($datas)) {
                return $datas;
            }
        }
    }*/
    
        protected function my_enquiry_product_list($user_id, $category_id, $skip, $take)
    {

        //dd($user_id);
        $lead_count   = DB::table('seller_leads')->where('user_id', $user_id)->count();
        // dd($lead_count);
        if ($lead_count > 0) {
            //\DB::enableQueryLog();
             $datas =  DB::select(
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
                t.crops_category_id,
                t.quantity,
                crops_category.crops_cat_name AS crop_category_name,
                seller_leads.user_id as seller_leads_user_id
            FROM (
                SELECT
                    'tractor' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM tractor
                
                UNION ALL
                
                SELECT
                    'goods_vehicle' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM goods_vehicle
                
                UNION ALL
                
                SELECT
                    'harvester' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM harvester
                
                UNION ALL
                
                SELECT
                    'implements' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM implements
                
                UNION ALL
                
                SELECT
                    'seeds' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM seeds
                
                UNION ALL
                
                SELECT
                    'pesticides' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM pesticides
                
                UNION ALL
                
                SELECT
                    'fertilizers' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM fertilizers

                UNION ALL
                
                SELECT
                    'crops' AS item_type,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM crops
                
                UNION ALL
                
                SELECT
                    'tyres' AS item_type,
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
                    CONCAT('http://127.0.0.1:8000/storage/tyre/', image1) as image1,
                    CONCAT('http://127.0.0.1:8000/storage/tyre/', image2) as image2,
                    CONCAT('http://127.0.0.1:8000/storage/tyre/', image3) as image3,
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
                    status,
                    NULL as crops_subscribed_id,
                    NULL as quantity,
                    NULL as expiry_date,
                    NULL as valid_till,
                    NULL as crops_category_id,
                    NULL as is_featured,
                    NULL as reason_for_rejection,
                    NULL as rejected_by,
                    NULL as rejected_at,
                    NULL as approved_by,
                    NULL as approved_at
                FROM tyres

            ) AS t
            LEFT JOIN brand ON t.brand_id = brand.id
            LEFT JOIN model ON t.model_id = model.id
            LEFT JOIN state ON t.state_id = state.id
            LEFT JOIN district ON t.district_id = district.id
            LEFT JOIN city ON t.city_id = city.id
            LEFT JOIN user on t.user_id = user.id

            JOIN seller_leads on t.category_id = seller_leads.category_id and t.id = seller_leads.post_id 
            LEFT JOIN crops_category on t.crops_category_id = crops_category.id 
            WHERE t.status=1 AND seller_leads.user_id = $user_id 
            ORDER BY t.id DESC 
            LIMIT $skip,$take");

            foreach ($datas as $data) {
                $data->specification = [];
                $model_id = $data->model_id;
                $data->specification = DB::table('specifications')
                    ->where(['model_id' => $model_id, 'status' => 1])->get();
            }
            //dd(\DB::getQueryLog());
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
                        'user.mobile as lead_user_mobile',
                        'user.zipcode as lead_user_zipcode ',
                        'user.status as lead_user_status ',
                        'seller_leads.created_at as seller_lead_created_at',
                        'state.state_name',
                        'district.district_name'
                    )
                    ->leftJoin('state', 'state.id', '=', 'user.state_id')
                    ->leftJoin('district', 'district.id', '=', 'user.district_id')
                    ->leftJoin('seller_leads', 'seller_leads.user_id', '=', 'user.id')
                    ->where(['user.id' => $data->seller_leads_user_id])->first();
            }

            if (!empty($datas)) {
                return $datas;
            }
        }
    }
  

    # Post Id and Category Id Wish Product list
    protected function post_category_product_list1($category_id, $post_id, $user_id)
    {

        //dd($category_id);

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
                  `type`,
                  brand_id,
                  model_id,
                  title,
  
                  year_of_purchase,
                  rc_available,
                  noc_available,
                  registration_no,
                  `description`,
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
                  `status`
              FROM tractor
              WHERE user_id = $user_id
          
              UNION ALL
          
              SELECT
                  'goods_vehicle',
                  id,
                  category_id,
                  user_id,
                  `set`,
                  `type`,
                  brand_id,
                  model_id,
                  title,
  
                  year_of_purchase,
                  rc_available,
                  noc_available,
                  registration_no,
                  `description`,
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
                  `status`
              FROM goods_vehicle
              WHERE user_id = $user_id
          
              UNION ALL
          
              SELECT
                 'harvester',
                  id,
                  category_id,
                  user_id,
                  `set`,
                  `type`,
                  brand_id,
                  model_id,
                  title,
  
                  year_of_purchase,
                  NULL as rc_available,
                  NULL as noc_available,
                  NULL as registration_no,
                  `description`,
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
                  `status`
              FROM harvester
              WHERE user_id = $user_id
          
              UNION ALL
          
              SELECT
                  'implements',
                  id,
                  category_id,
                  user_id,
                  `set`,
                  `type`,
                  brand_id,
                  model_id,
                  title,
  
                  year_of_purchase,
                  NULL as rc_available,
                  NULL as noc_available,
                  NULL as registration_no,
                  `description`,
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
                  `status`
              FROM implements
              WHERE user_id = $user_id
          
              UNION ALL
          
              SELECT
                  'seeds',
                  id,
                  category_id,
                  user_id,
                  NULL as `set`,
                  NULL as `type`,
                  NULL as brand_id,
                  NULL as model_id,
                  title,
  
                  NULL as year_of_purchase,
                  NULL as rc_available,
                  NULL as noc_available,
                  NULL as registration_no,
                  `description`,
                  `is_negotiable`,
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
                  `status`
              FROM seeds
              WHERE user_id = $user_id
          
              UNION ALL
          
              SELECT
                  'pesticides',
                  id,
                  category_id,
                  user_id,
                  NULL as `set`,
                  NULL as `type`,
                  NULL as brand_id,
                  NULL as model_id,
                  title,
  
                  NULL as year_of_purchase,
                  NULL as rc_available,
                  NULL as noc_available,
                  NULL as registration_no,
                  `description`,
                  `is_negotiable`,
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
                  `status`
              FROM pesticides
              WHERE user_id = $user_id
          
              UNION ALL
          
              SELECT
               ' fertilizers',
                  id,
                  category_id,
                  user_id,
                  NULL as `set`,
                  NULL as `type`,
                  NULL as brand_id,
                  NULL as model_id,
                  title,
  
                  NULL as year_of_purchase,
                  NULL as rc_available,
                  NULL as noc_available,
                  NULL as registration_no,
                  `description`,
                  `is_negotiable`,
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
                  `status`
              FROM fertilizers
              WHERE user_id = $user_id
          
              UNION ALL
          
              SELECT
              'tyres',
                  id,
                  category_id,
                  user_id,
                  NULL as `set`,
                  `type`,
                  brand_id,
                  model_id,
                  title,
  
                  NULL as year_of_purchase,
                  NULL as rc_available,
                  NULL as noc_available,
                  NULL as registration_no,
                  `description`,
                  `is_negotiable`,
                  NULL as crop_type,
                  NULL as cutting_with,
                  NULL as power_source,
                  `position`,
  
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
                  `status`
              FROM tyres
              WHERE user_id = $user_id
          
          ) AS t
          LEFT JOIN brand ON t.brand_id = brand.id
          LEFT JOIN model ON t.model_id = model.id
          LEFT JOIN state ON t.state_id = state.id
          LEFT JOIN district ON t.district_id = district.id
          LEFT JOIN city ON t.city_id = city.id
          LEFT JOIN user on t.user_id = user.id
          where  t.status=1  and t.category_id = $category_id and t.id = $post_id"
        );



        foreach ($datas as $data) {
            $data->specification = [];
            $model_id = $data->model_id;
            $data->specification = DB::table('specifications')
                ->where(['model_id' => $model_id, 'status' => 1])->get();
        }

        // dd($datas);

        $output = array();
        $output = $datas;

        if (!empty($output)) {
            return $output;
        }
    }

    protected function post_category_product_list($category_id, $post_id, $user_id)
    {

        // echo $category_id;
        // echo '<br />';
        // echo $post_id;
        // die;

        $user_details = DB::table('user')->where('id', $user_id)->first();

        if (!empty($user_details->zipcode)) {
            $pincode = $user_details->zipcode;
        } else {
            $pincode = '700029';
        }


        $pindata_count = DB::table('city')->where(['pincode' => $pincode])->count();
        if ($pindata_count > 0) {
            $pindata = DB::table('city')->where(['pincode' => $pincode])->first();
            $latitude = $pindata->latitude;
            $longitude = $pindata->longitude;
        } else {
            $latitude = "23.3202";
            $longitude = "86.8426";
        }


        if ($category_id == 1) {
            $tr = DB::table('tractorView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                * cos(radians(tractorView.latitude))
                * cos(radians(tractorView.longitude) - radians(" . $longitude . "))
                + sin(radians(" . $latitude . "))
                * sin(radians(tractorView.latitude))) AS distance")
                )
                // ->whereIn('status',[1,4])
                ->where('id', $post_id)
                ->first();
        } else if ($category_id == 3) {
            $tr = DB::table('goodVehicleView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                * cos(radians(goodVehicleView.latitude))
                * cos(radians(goodVehicleView.longitude) - radians(" . $longitude . "))
                + sin(radians(" . $latitude . "))
                * sin(radians(goodVehicleView.latitude))) AS distance")
                )
                // ->whereIn('status',[1,4])
                ->where('id', $post_id)
                ->first();
        } else if ($category_id == 4) {
            $tr = DB::table('harvesterView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                * cos(radians(harvesterView.latitude))
                * cos(radians(harvesterView.longitude) - radians(" . $longitude . "))
                + sin(radians(" . $latitude . "))
                * sin(radians(harvesterView.latitude))) AS distance")
                )
                // ->whereIn('status',[1,4])
                ->where('id', $post_id)
                ->first();
        } else if ($category_id == 5) {
            //dd($post_id);
            $tr = DB::table('implementView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                * cos(radians(implementView.latitude))
                * cos(radians(implementView.longitude) - radians(" . $longitude . "))
                + sin(radians(" . $latitude . "))
                * sin(radians(implementView.latitude))) AS distance")
                )
                // ->whereIn('status',[1,4])
                ->where('id', $post_id)
                ->first();
            //  dd($tr);
        } else if ($category_id == 7) {
            $tr = DB::table('tyresView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                * cos(radians(tyresView.latitude))
                * cos(radians(tyresView.longitude) - radians(" . $longitude . "))
                + sin(radians(" . $latitude . "))
                * sin(radians(tyresView.latitude))) AS distance")
                )
                // ->whereIn('status',[1,4])
                ->where('id', $post_id)
                ->first();
        } else if ($category_id == 6) {
            $tr = DB::table('seedView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                * cos(radians(seedView.latitude))
                * cos(radians(seedView.longitude) - radians(" . $longitude . "))
                + sin(radians(" . $latitude . "))
                * sin(radians(seedView.latitude))) AS distance")
                )
                // ->whereIn('status',[1,4])
                ->where('id', $post_id)
                ->first();
        } else if ($category_id == 8) {
            $tr = DB::table('pesticidesView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                * cos(radians(pesticidesView.latitude))
                * cos(radians(pesticidesView.longitude) - radians(" . $longitude . "))
                + sin(radians(" . $latitude . "))
                * sin(radians(pesticidesView.latitude))) AS distance")
                )
                // ->whereIn('status',[1,4])
                ->where('id', $post_id)
                ->first();
        } else if ($category_id == 9) {
            $tr = DB::table('fertilizerView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                * cos(radians(fertilizerView.latitude))
                * cos(radians(fertilizerView.longitude) - radians(" . $longitude . "))
                + sin(radians(" . $latitude . "))
                * sin(radians(fertilizerView.latitude))) AS distance")
                )
                // ->whereIn('status',[1,4])
                ->where('id', $post_id)
                ->first();
        } else if ($category_id == 12) {
            $tr = DB::table('cropsView')
                ->select(
                    '*',
                    DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                * cos(radians(cropsView.latitude))
                * cos(radians(cropsView.longitude) - radians(" . $longitude . "))
                + sin(radians(" . $latitude . "))
                * sin(radians(cropsView.latitude))) AS distance")
                )
                // ->whereIn('status',[1,4])
                ->where('id', $post_id)
                ->first();
        }
        
      // dd($tr);



        if ($category_id == 1) {

            $output = [];

            /** Date of Create at */
            $create = $tr->created_at;
            $newtime = strtotime($create);
            $created_at = date('M d, Y', $newtime);

            /** Date of Update at */
            $update = $tr->updated_at;
            $newtime1 = strtotime($update);
            $updated_at = date('M d, Y', $newtime1);

            /** Brand Name And Model Name */
            $brand_o_n = DB::table('brand')->where(['id' => $tr->brand_id])->value('name');
            if ($brand_o_n == 'Others') {
               // $brand_name = $tr->title;
                $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                $brand_name = $brand_arr_data->name;
                $model_name = $tr->description;
            } else {
                $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                $brand_name = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id' => $tr->model_id])->first();
                $model_name = $model_arr_data->model_name;
            }

            /** Distance Show */
            $d = round($tr->distance);
            if ($d == null) {
                $distance = 0;
            } else {
                $distance = $d;
            }

            $state_name = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;
            $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;

            $fertilizers_array = array();
            $tractor_array['distance'] = $distance;

            $user_count = DB::table('user')->where(['id' => $tr->user_id])->count();
            if ($user_count > 0) {
                $user_details = DB::table('user')->where(['id' => $tr->user_id])->first();
                $tractor_array['user_type_id'] = $user_details->user_type_id;
                $tractor_array['role_id'] = $user_details->role_id;
                $tractor_array['name'] = $user_details->name;
                $tractor_array['company_name'] = $user_details->company_name;
                $tractor_array['mobile'] = $user_details->mobile;
                $tractor_array['email'] = $user_details->email;
                $tractor_array['gender'] = $user_details->gender;
                $tractor_array['address'] = $user_details->address;
                $tractor_array['zipcode'] = $user_details->zipcode;
                $tractor_array['device_id'] = $user_details->device_id;
                $tractor_array['firebase_token'] = $user_details->firebase_token;
                $tractor_array['verify_tag'] = $user_details->verify_tag ? $user_details->verify_tag : null;
                $tractor_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $tractor_array['photo'] = '';
                } else {
                    $tractor_array['photo'] = asset("storage/photo/$user_details->photo");
                }
            } else {
                $tractor_array['user_type_id'] = 'null';
                $tractor_array['role_id'] = 'null';
                $tractor_array['name'] = 'null';
                $tractor_array['company_name'] = 'null';
                $tractor_array['mobile'] = 'null';
                $tractor_array['email'] = 'null';
                $tractor_array['gender'] = 'null';
                $tractor_array['address'] = 'null';
                $tractor_array['zipcode'] = 'null';
                $tractor_array['device_id'] = 'null';
                $tractor_array['firebase_token'] = 'null';
                $tractor_array['created_at_user'] = 'null';
                $tractor_array['photo'] = 'null';
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

            $boosted = Subscribed_boost::view_all_boosted_products(1,$tr->id);
            if($boosted == 0){
                $tractor_array['is_boosted']  = false;
            }else if($boosted == 1){
                $tractor_array['is_boosted']  = true;
            }

            $tractor_array['id'] = $tr->id;
            $tractor_array['city_name'] = $tr->city_name;
            $tractor_array['category_id'] = $tr->category_id;
            $tractor_array['user_id'] = $tr->user_id;
            $tractor_array['set'] = $tr->set;
            $tractor_array['type'] = $tr->type;
            $tractor_array['brand_id'] = $tr->brand_id;
            $tractor_array['model_id'] = $tr->model_id;
            $tractor_array['year_of_purchase'] = $tr->year_of_purchase;
            $tractor_array['title'] = $tr->title;
            $tractor_array['rc_available'] = $tr->rc_available;
            $tractor_array['noc_available'] = $tr->noc_available;
            $tractor_array['registration_no'] = $tr->registration_no;
            $tractor_array['description'] = $tr->description;

            if (!empty($tr->front_image)) {
                $tractor_array['front_image'] = asset("storage/tractor/$tr->front_image");
            }
            if (!empty($tr->left_image)) {
                $tractor_array['left_image'] = asset("storage/tractor/$tr->left_image");
            }
            if (!empty($tr->right_image)) {
                $tractor_array['right_image'] = asset("storage/tractor/$tr->right_image");
            }
            if (!empty($tr->back_image)) {
                $tractor_array['back_image'] = asset("storage/tractor/$tr->back_image");
            }
            if (!empty($tr->meter_image)) {
                $tractor_array['meter_image'] = asset("storage/tractor/$tr->meter_image");
            }
            if (!empty($tr->tyre_image)) {
                $tractor_array['tyre_image'] = asset("storage/tractor/$tr->tyre_image");
            }


            $tractor_array['price'] = $tr->price;
            $tractor_array['rent_type'] = $tr->rent_type;
            $tractor_array['is_negotiable'] = $tr->is_negotiable;
            $tractor_array['country_id'] = $tr->country_id;
            $tractor_array['state_id'] = $tr->state_id;
            $tractor_array['district_id'] = $tr->district_id;
            $tractor_array['city_id'] = $tr->city_id;
            $tractor_array['pincode'] = $tr->pincode;
            $tractor_array['tractor_latlong'] = $tr->tractor_latlong;
            $tractor_array['ad_report'] = $tr->ad_report;
            $tractor_array['status'] = $tr->status;
            $tractor_array['created_at'] = $tr->created_at;
            $tractor_array['updated_at'] = $updated_at;
            $tractor_array['reason_for_rejection'] = $tr->reason_for_rejection;
            $tractor_array['rejected_by'] = $tr->rejected_by;
            $tractor_array['rejected_at'] = $tr->rejected_at;
            $tractor_array['approved_by'] = $tr->approved_by;
            $tractor_array['approved_at'] = $tr->approved_at;
            $tractor_array['district_name'] = $district_name;
            $tractor_array['brand_name'] = $brand_name;
            $tractor_array['model_name'] = $model_name;
            $tractor_array['approved_at'] = $tr->approved_at;

            $tractor_array['state_name'] = $state_name;
            $tractor_array['wishlist_status'] = DB::table('wishlist')->where(['user_id' => $user_id, 'category_id' => 1, 'item_id' => $tr->id])->count();
            $tractor_array['view_lead'] = Leads_view::where(['category_id' => 1, 'post_id' => $tr->id])->count();
            $tractor_array['call_lead'] = Lead::where(['category_id' => 1, 'post_id' => $tr->id, 'calls_status' => 1])->count();
            $tractor_array['msg_lead'] = Lead::where(['category_id' => 1, 'post_id' => $tr->id, 'messages_status' => 1])->count();

            $data[] = $tractor_array;
        } else if ($category_id == 3) {

            $output = [];

            /** Date of Create at */
            $create = $tr->created_at;
            $newtime = strtotime($create);
            $created_at = date('M d, Y', $newtime);

            /** Date of Update at */
            $update = $tr->updated_at;
            $newtime1 = strtotime($update);
            $updated_at = date('M d, Y', $newtime1);

            /** Brand Name And Model Name */
            $brand_o_n = DB::table('brand')->where(['id' => $tr->brand_id])->value('name');
            if ($brand_o_n == 'Others') {
                //$brand_name = $tr->title;
                $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                $brand_name = $brand_arr_data->name;
                $model_name = $tr->description;
            } else {
                $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                $brand_name = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id' => $tr->model_id])->first();
                $model_name = $model_arr_data->model_name;
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
            $state_name = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

            $gv_array = array();

            $gv_array['distance'] = $distance;

            $user_count = DB::table('user')->where(['id' => $tr->user_id])->count();
            if ($user_count > 0) {
                $user_details = DB::table('user')->where(['id' => $tr->user_id])->first();
                $gv_array['user_type_id'] = $user_details->user_type_id;
                $gv_array['role_id'] = $user_details->role_id;
                $gv_array['name'] = $user_details->name;
                $gv_array['company_name'] = $user_details->company_name;
                $gv_array['mobile'] = $user_details->mobile;
                $gv_array['email'] = $user_details->email;
                $gv_array['gender'] = $user_details->gender;
                $gv_array['address'] = $user_details->address;
                $gv_array['zipcode'] = $user_details->zipcode;
                $gv_array['device_id'] = $user_details->device_id;
                $gv_array['firebase_token'] = $user_details->firebase_token;
                $gv_array['verify_tag'] = $user_details->verify_tag ? $user_details->verify_tag : null;
                $gv_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $gv_array['photo'] = '';
                } else {
                    $gv_array['photo'] = asset("storage/photo/" . $user_details->photo);
                }
            } else if ($user_count == 0) {
                $gv_array['user_type_id'] = 'null';
                $gv_array['role_id'] = 'null';
                $gv_array['name'] = 'null';
                $gv_array['company_name'] = 'null';
                $gv_array['mobile'] = 'null';
                $gv_array['email'] = 'null';
                $gv_array['gender'] = 'null';
                $gv_array['address'] = 'null';
                $gv_array['zipcode'] = 'null';
                $gv_array['device_id'] = 'null';
                $gv_array['firebase_token'] = 'null';
                $gv_array['created_at_user'] = 'null';
                $gv_array['photo'] = 'null';
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

            $boosted = Subscribed_boost::view_all_boosted_products(3,$tr->id);
            if($boosted == 0){
                $gv_array['is_boosted']  = false;
            }else if($boosted == 1){
                $gv_array['is_boosted']  = true;
            }

            $gv_array['id'] = $tr->id;
            $gv_array['city_name'] = $tr->city_name;
            $gv_array['category_id'] = $tr->category_id;
            $gv_array['user_id'] = $tr->user_id;
            $gv_array['set'] = $tr->set;
            $gv_array['type'] = $tr->type;
            $gv_array['brand_id'] = $tr->brand_id;
            $gv_array['model_id'] = $tr->model_id;
            $gv_array['year_of_purchase'] = $tr->year_of_purchase;
            $gv_array['title'] = $tr->title;
            $gv_array['rc_available'] = $tr->rc_available;
            $gv_array['noc_available'] = $tr->noc_available;
            $gv_array['registration_no'] = $tr->registration_no;
            $gv_array['description'] = $tr->description;

            if (!empty($tr->front_image)) {
                $gv_array['front_image'] = asset("storage/goods_vehicle/$tr->front_image");
            }
            if (!empty($tr->left_image)) {
                $gv_array['left_image'] = asset("storage/goods_vehicle/$tr->left_image");
            }
            if (!empty($tr->right_image)) {
                $gv_array['right_image'] = asset("storage/goods_vehicle/$tr->right_image");
            }
            if (!empty($tr->back_image)) {
                $gv_array['back_image'] = asset("storage/goods_vehicle/$tr->back_image");
            }
            if (!empty($tr->meter_image)) {
                $gv_array['meter_image'] = asset("storage/goods_vehicle/$tr->meter_image");
            }
            if (!empty($tr->tyre_image)) {
                $gv_array['tyre_image'] = asset("storage/goods_vehicle/$tr->tyre_image");
            }

            $gv_array['price'] = $tr->price;
            $gv_array['rent_type'] = $tr->rent_type;
            $gv_array['is_negotiable'] = $tr->is_negotiable;
            $gv_array['country_id'] = $tr->country_id;
            $gv_array['state_id'] = $tr->state_id;
            $gv_array['district_id'] = $tr->district_id;
            $gv_array['city_id'] = $tr->city_id;
            $gv_array['pincode'] = $tr->pincode;
            $gv_array['gv_latlong'] = $tr->latlong;
            $gv_array['ad_report'] = $tr->ad_report;
            $gv_array['status'] = $tr->status;
            $gv_array['created_at'] = $tr->created_at;
            $gv_array['updated_at'] = $updated_at;
            $gv_array['reason_for_rejection'] = $tr->reason_for_rejection;
            $gv_array['rejected_by'] = $tr->rejected_by;
            $gv_array['rejected_at'] = $tr->rejected_at;
            $gv_array['approved_by'] = $tr->approved_by;
            $gv_array['approved_at'] = $tr->approved_at;
            $gv_array['district_name'] = $district_name;
            $gv_array['brand_name'] = $brand_name;
            $gv_array['model_name'] = $model_name;
            $gv_array['approved_at'] = $tr->approved_at;
            $gv_array['state_name'] = $state_name;

            $gv_array['wishlist_status'] = DB::table('wishlist')->where(['user_id' => $user_id, 'category_id' => 3, 'item_id' => $tr->id])->count();
            $gv_array['view_lead'] = Leads_view::where(['category_id' => 3, 'post_id' => $tr->id])->count();
            $gv_array['call_lead'] = Lead::where(['category_id' => 3, 'post_id' => $tr->id, 'calls_status' => 1])->count();
            $gv_array['msg_lead'] = Lead::where(['category_id' => 3, 'post_id' => $tr->id, 'messages_status' => 1])->count();

            $data[] = $gv_array;
        } else if ($category_id == 4) {

            $output = [];

            /** Date of Create at */
            $create = $tr->created_at;
            $newtime = strtotime($create);
            $created_at = date('M d, Y', $newtime);

            /** Date of Update at */
            $update = $tr->updated_at;
            $newtime1 = strtotime($update);
            $updated_at = date('M d, Y', $newtime1);

            /** Brand Name And Model Name */
            $brand_o_n = DB::table('brand')->where(['id' => $tr->brand_id])->value('name');
            if ($brand_o_n == 'Others') {
                //$brand_name = $tr->title;
                $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                $brand_name = $brand_arr_data->name;
                $model_name = $tr->description;
            } else {
                $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                $brand_name = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id' => $tr->model_id])->first();
                $model_name = $model_arr_data->model_name;
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
            $state_name = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

            $hr_array = array();

            $hr_array['distance'] = $distance;

            $user_count = DB::table('user')->where(['id' => $tr->user_id])->count();

            if ($user_count > 0) {
                $user_details = DB::table('user')->where(['id' => $tr->user_id])->first();
                $hr_array['user_type_id'] = $user_details->user_type_id;
                $hr_array['role_id'] = $user_details->role_id;
                $hr_array['name'] = $user_details->name;
                $hr_array['company_name'] = $user_details->company_name;
                $hr_array['mobile'] = $user_details->mobile;
                $hr_array['email'] = $user_details->email;
                $hr_array['gender'] = $user_details->gender;
                $hr_array['address'] = $user_details->address;
                $hr_array['zipcode'] = $user_details->zipcode;
                $hr_array['device_id'] = $user_details->device_id;
                $hr_array['firebase_token'] = $user_details->firebase_token;
                $hr_array['verify_tag'] = $user_details->verify_tag ? $user_details->verify_tag : null;
                $hr_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $hr_array['photo'] = '';
                } else {
                    $hr_array['photo'] = asset("storage/photo/" . $user_details->photo);
                }
            } else {
                $hr_array['user_type_id'] = 'null';
                $hr_array['role_id'] = 'null';
                $hr_array['name'] = 'null';
                $hr_array['company_name'] = 'null';
                $hr_array['mobile'] = 'null';
                $hr_array['email'] = 'null';
                $hr_array['gender'] = 'null';
                $hr_array['address'] = 'null';
                $hr_array['zipcode'] = 'null';
                $hr_array['device_id'] = 'null';
                $hr_array['firebase_token'] = 'null';
                $hr_array['created_at_user'] = 'null';
                $hr_array['photo'] = 'null';
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

            $boosted = Subscribed_boost::view_all_boosted_products(4,$tr->id);
            if($boosted == 0){
                $hr_array['is_boosted']  = false;
            }else if($boosted == 1){
                $hr_array['is_boosted']  = true;
            }

            $hr_array['id'] = $tr->id;
            $hr_array['city_name'] = $tr->city_name;
            $hr_array['category_id'] = $tr->category_id;
            $hr_array['user_id'] = $tr->user_id;
            $hr_array['set'] = $tr->set;
            $hr_array['type'] = $tr->type;
            $hr_array['brand_id'] = $tr->brand_id;
            $hr_array['model_id'] = $tr->model_id;
            $hr_array['year_of_purchase'] = $tr->year_of_purchase;
            $hr_array['title'] = $tr->title;
            $hr_array['crop_type'] = $tr->crop_type;
            $hr_array['cutting_with'] = $tr->cutting_with;
            $hr_array['power_source'] = $tr->power_source;
            $hr_array['spec_id'] = $tr->spec_id;

            if (!empty($tr->front_image)) {
                $hr_array['front_image'] = asset("storage/harvester/$tr->front_image");
            }
            if (!empty($tr->left_image)) {
                $hr_array['left_image'] = asset("storage/harvester/$tr->left_image");
            }
            if (!empty($tr->right_image)) {
                $hr_array['right_image'] = asset("storage/harvester/$tr->right_image");
            }
            if (!empty($tr->back_image)) {
                $hr_array['back_image'] = asset("storage/harvester/$tr->back_image");
            }

            $hr_array['description'] = $tr->description;
            $hr_array['price'] = $tr->price;
            $hr_array['rent_type'] = $tr->rent_type;
            $hr_array['is_negotiable'] = $tr->is_negotiable;
            $hr_array['country_id'] = $tr->country_id;
            $hr_array['state_id'] = $tr->state_id;
            $hr_array['district_id'] = $tr->district_id;
            $hr_array['city_id'] = $tr->city_id;
            $hr_array['pincode'] = $tr->pincode;
            $hr_array['latlong'] = $tr->latlong;
            $hr_array['is_featured'] = $tr->is_featured;
            $hr_array['valid_till'] = $tr->valid_till;
            $hr_array['ad_report'] = $tr->ad_report;
            $hr_array['status'] = $tr->status;
            // $hr_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
            $hr_array['created_at'] = $tr->created_at;
            $hr_array['updated_at'] = $updated_at;
            $hr_array['reason_for_rejection'] = $tr->reason_for_rejection;
            $hr_array['rejected_by'] = $tr->rejected_by;
            $hr_array['rejected_at'] = $tr->rejected_at;
            $hr_array['approved_by'] = $tr->approved_by;
            $hr_array['approved_at'] = $tr->approved_at;
            $hr_array['district_name'] = $district_name;
            $hr_array['brand_name'] = $brand_name;
            $hr_array['model_name'] = $model_name;
            $hr_array['approved_at'] = $tr->approved_at;
            $hr_array['state_name'] = $state_name;

            $hr_array['wishlist_status'] = DB::table('wishlist')->where(['user_id' => $user_id, 'category_id' => 4, 'item_id' => $tr->id])->count();
            $hr_array['view_lead'] = Leads_view::where(['category_id' => 4, 'post_id' => $tr->id])->count();
            $hr_array['call_lead'] = Lead::where(['category_id' => 4, 'post_id' => $tr->id, 'calls_status' => 1])->count();
            $hr_array['msg_lead'] = Lead::where(['category_id' => 4, 'post_id' => $tr->id, 'messages_status' => 1])->count();

            $data[] = $hr_array;
        } else if ($category_id == 5) {
            //dd($category_id);

            $output = [];

            /** Date of Create at */
            $create = $tr->created_at;
            $newtime = strtotime($create);
            $created_at = date('M d, Y', $newtime);
            // dd($created_at);

            /** Date of Update at */
            $update = $tr->updated_at;
            $newtime1 = strtotime($update);
            $updated_at = date('M d, Y', $newtime1);

            /** Brand Name And Model Name */

            $brand_o_n = DB::table('brand')->where(['id' => $tr->brand_id])->value('name');
            // dd($brand_o_n);
            if ($brand_o_n == 'Others') {
                //$brand_name = $tr->title;
                $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                $brand_name = $brand_arr_data->name;
                $model_name = $tr->description;
            } else {
                $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                $brand_name = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id' => $tr->model_id])->first();
                $model_name = $model_arr_data->model_name;
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
            $state_name = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

            $imp_array = array();

            $imp_array['distance'] = $distance;

            $user_count = DB::table('user')->where(['id' => $tr->user_id])->count();
            if ($user_count > 0) {
                $user_details = DB::table('user')->where(['id' => $tr->user_id])->first();
                $imp_array['user_type_id'] = $user_details->user_type_id;
                $imp_array['role_id'] = $user_details->role_id;
                $imp_array['name'] = $user_details->name;
                $imp_array['company_name'] = $user_details->company_name;
                $imp_array['mobile'] = $user_details->mobile;
                $imp_array['email'] = $user_details->email;
                $imp_array['gender'] = $user_details->gender;
                $imp_array['address'] = $user_details->address;
                $imp_array['zipcode'] = $user_details->zipcode;
                $imp_array['device_id'] = $user_details->device_id;
                $imp_array['firebase_token'] = $user_details->firebase_token;
                $imp_array['verify_tag'] = $user_details->verify_tag ? $user_details->verify_tag : null;
                $imp_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $imp_array['photo'] = '';
                } else {
                    $imp_array['photo'] = asset("storage/photo/" . $user_details->photo);
                }
            } else {
                $imp_array['user_type_id'] = 'null';
                $imp_array['role_id'] = 'null';
                $imp_array['name'] = 'null';
                $imp_array['company_name'] = 'null';
                $imp_array['mobile'] = 'null';
                $imp_array['email'] = 'null';
                $imp_array['gender'] = 'null';
                $imp_array['address'] = 'null';
                $imp_array['zipcode'] = 'null';
                $imp_array['device_id'] = 'null';
                $imp_array['firebase_token'] = 'null';
                $imp_array['created_at_user'] = 'null';
                $imp_array['photo'] = 'null';
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

            $boosted = Subscribed_boost::view_all_boosted_products(5,$tr->id);
            if($boosted == 0){
                $imp_array['is_boosted']  = false;
            }else if($boosted == 1){
                $imp_array['is_boosted']  = true;
            }

            $imp_array['id'] = $tr->id;
            $imp_array['city_name'] = $tr->city_name;
            $imp_array['category_id'] = $tr->category_id;
            $imp_array['user_id'] = $tr->user_id;
            $imp_array['set'] = $tr->set;
            $imp_array['type'] = $tr->type;
            $imp_array['brand_id'] = $tr->brand_id;
            $imp_array['model_id'] = $tr->model_id;
            $imp_array['year_of_purchase'] = $tr->year_of_purchase;
            $imp_array['title'] = $tr->title;

            if (!empty($tr->front_image)) {
                $imp_array['front_image'] = asset("storage/implements/$tr->front_image");
            }
            if (!empty($tr->left_image)) {
                $imp_array['left_image'] = asset("storage/implements/$tr->left_image");
            }
            if (!empty($tr->right_image)) {
                $imp_array['right_image'] = asset("storage/implements/$tr->right_image");
            }
            if (!empty($tr->back_image)) {
                $imp_array['back_image'] = asset("storage/implements/$tr->back_image");
            }

            $imp_array['spec_id'] = $tr->spec_id;
            $imp_array['description'] = $tr->description;
            $imp_array['price'] = $tr->price;
            $imp_array['rent_type'] = $tr->rent_type;
            $imp_array['is_negotiable'] = $tr->is_negotiable;
            $imp_array['country_id'] = $tr->country_id;
            $imp_array['state_id'] = $tr->state_id;
            $imp_array['district_id'] = $tr->district_id;
            $imp_array['city_id'] = $tr->city_id;
            $imp_array['pincode'] = $tr->pincode;
            $imp_array['latlong'] = $tr->latlong;
            $imp_array['is_featured'] = $tr->is_featured;
            $imp_array['valid_till'] = $tr->valid_till;
            $imp_array['ad_report'] = $tr->ad_report;
            $imp_array['status'] = $tr->status;
            $imp_array['created_at'] = $tr->created_at;
            $imp_array['updated_at'] = $updated_at;
            $imp_array['reason_for_rejection'] = $tr->reason_for_rejection;
            $imp_array['rejected_by'] = $tr->rejected_by;
            $imp_array['approved_by'] = $tr->approved_by;
            $imp_array['approved_at'] = $tr->approved_at;
            $imp_array['district_name'] = $district_name;
            $imp_array['brand_name'] = $brand_name;
            $imp_array['model_name'] = $model_name;
            $imp_array['approved_at'] = $tr->approved_at;
            $imp_array['state_name'] = $state_name;

            $imp_array['wishlist_status'] = DB::table('wishlist')->where(['user_id' => $user_id, 'category_id' => 5, 'item_id' => $tr->id])->count();
            $imp_array['view_lead'] = Leads_view::where(['category_id' => 5, 'post_id' => $tr->id])->count();
            $imp_array['call_lead'] = Lead::where(['category_id' => 5, 'post_id' => $tr->id, 'calls_status' => 1])->count();
            $imp_array['msg_lead'] = Lead::where(['category_id' => 5, 'post_id' => $tr->id, 'messages_status' => 1])->count();
            $data[] = $imp_array;
        } else if ($category_id == 6) {

            $output = [];

            /** Date of Create at */
            $create = $tr->created_at;
            $newtime = strtotime($create);
            $created_at = date('M d, Y', $newtime);

            /** Date of Update at */
            $update = $tr->updated_at;
            $newtime1 = strtotime($update);
            $updated_at = date('M d, Y', $newtime1);

            /** Distance Show */
            $d = round($tr->distance);
            if ($d == null) {
                $distance = 0;
            } else {
                $distance = $d;
            }

            /** District Name */
            $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;
            $state_name = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

            $seed_array = array();
            $seed_array['distance'] = $distance;

            $user_count = DB::table('user')->where(['id' => $tr->user_id])->count();
            if ($user_count > 0) {
                $user_details = DB::table('user')->where(['id' => $tr->user_id])->first();
                $seed_array['user_type_id'] = $user_details->user_type_id;
                $seed_array['role_id'] = $user_details->role_id;
                $seed_array['name'] = $user_details->name;
                $seed_array['company_name'] = $user_details->company_name;
                $seed_array['mobile'] = $user_details->mobile;
                $seed_array['email'] = $user_details->email;
                $seed_array['gender'] = $user_details->gender;
                $seed_array['address'] = $user_details->address;
                $seed_array['zipcode'] = $user_details->zipcode;
                $seed_array['device_id'] = $user_details->device_id;
                $seed_array['firebase_token'] = $user_details->firebase_token;
                $seed_array['verify_tag'] = $user_details->verify_tag ? $user_details->verify_tag : null;
                $seed_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $seed_array['photo'] = '';
                } else {
                    $seed_array['photo'] = asset("storage/photo/" . $user_details->photo);
                }
            } else {
                $seed_array['user_type_id'] = 'null';
                $seed_array['role_id'] = 'null';
                $seed_array['name'] = 'null';
                $seed_array['company_name'] = 'null';
                $seed_array['mobile'] = 'null';
                $seed_array['email'] = 'null';
                $seed_array['gender'] = 'null';
                $seed_array['address'] = 'null';
                $seed_array['zipcode'] = 'null';
                $seed_array['device_id'] = 'null';
                $seed_array['firebase_token'] = 'null';
                $seed_array['created_at_user'] = 'null';
                $seed_array['photo'] = 'null';
            }

            $boosted = Subscribed_boost::view_all_boosted_products(6,$tr->id);
            if($boosted == 0){
                $seed_array['is_boosted']  = false;
            }else if($boosted == 1){
                $seed_array['is_boosted']  = true;
            }

            $seed_array['id'] = $tr->id;
            $seed_array['city_name'] = $tr->city_name;
            $seed_array['category_id'] = $tr->category_id;
            $seed_array['user_id'] = $tr->user_id;
            $seed_array['title'] = $tr->title;
            $seed_array['description'] = $tr->description;
            $seed_array['price'] = $tr->price;
            $seed_array['is_negotiable'] = $tr->is_negotiable;

            if (!empty($tr->image1)) {
                $seed_array['image1'] = asset("storage/seeds/" . $tr->image1);
            }
            if (!empty($tr->image2)) {
                $seed_array['image2'] = asset("storage/seeds/" . $tr->image2);
            }
            if (!empty($tr->image3)) {
                $seed_array['image3'] = asset("storage/seeds/" . $tr->image3);
            }

            $seed_array['country_id'] = $tr->country_id;
            $seed_array['state_id'] = $tr->state_id;
            $seed_array['district_id'] = $tr->district_id;
            $seed_array['city_id'] = $tr->city_id;
            $seed_array['pincode'] = $tr->pincode;
            $seed_array['latlong'] = $tr->latlong;
            $seed_array['is_featured'] = $tr->is_featured;
            $seed_array['valid_till'] = $tr->valid_till;
            $seed_array['ad_report'] = $tr->ad_report;
            $seed_array['status'] = $tr->status;
            // $seed_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
            $seed_array['created_at'] = $tr->created_at;
            $seed_array['updated_at'] = $updated_at;
            $seed_array['reason_for_rejection'] = $tr->reason_for_rejection;
            $seed_array['rejected_by'] = $tr->rejected_by;
            $seed_array['rejected_at'] = $tr->rejected_at;
            $seed_array['approved_by'] = $tr->approved_by;
            $seed_array['approved_at'] = $tr->approved_at;
            $seed_array['district_name'] = $district_name;

            $seed_array['state_name'] = $state_name;
            $seed_array['wishlist_status'] = DB::table('wishlist')->where(['user_id' => $user_id, 'category_id' => 6, 'item_id' => $tr->id])->count();
            $seed_array['view_lead'] = Leads_view::where(['category_id' => 6, 'post_id' => $tr->id])->count();
            $seed_array['call_lead'] = Lead::where(['category_id' => 6, 'post_id' => $tr->id, 'calls_status' => 1])->count();
            $seed_array['msg_lead'] = Lead::where(['category_id' => 6, 'post_id' => $tr->id, 'messages_status' => 1])->count();

            $data[] = $seed_array;
        } else if ($category_id == 7) {
            $output = [];

            /** Date of Create at */
            $create = $tr->created_at;
            $newtime = strtotime($create);
            $created_at = date('M d, Y', $newtime);

            /** Date of Update at */
            $update = $tr->updated_at;
            $newtime1 = strtotime($update);
            $updated_at = date('M d, Y', $newtime1);

            /** Brand Name And Model Name */
            $brand_o_n = DB::table('brand')->where(['id' => $tr->brand_id])->value('name');
            if ($brand_o_n == 'Others') {
               // $brand_name = $tr->title;
                $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                $brand_name = $brand_arr_data->name;
                $model_name = $tr->description;
            } else {
                $brand_arr_data = DB::table('brand')->where(['id' => $tr->brand_id])->first();
                $brand_name = $brand_arr_data->name;
                $model_arr_data = DB::table('model')->where(['id' => $tr->model_id])->first();
                $model_name = $model_arr_data->model_name;
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
            $state_name = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

            $tyre_array = array();

            $tyre_array['distance'] = $distance;

            $user_count = DB::table('user')->where(['id' => $tr->user_id])->count();
            if ($user_count > 0) {
                $user_details = DB::table('user')->where(['id' => $tr->user_id])->first();
                $tyre_array['user_type_id'] = $user_details->user_type_id;
                $tyre_array['role_id'] = $user_details->role_id;
                $tyre_array['name'] = $user_details->name;
                $tyre_array['company_name'] = $user_details->company_name;
                $tyre_array['mobile'] = $user_details->mobile;
                $tyre_array['email'] = $user_details->email;
                $tyre_array['gender'] = $user_details->gender;
                $tyre_array['address'] = $user_details->address;
                $tyre_array['zipcode'] = $user_details->zipcode;
                $tyre_array['device_id'] = $user_details->device_id;
                $tyre_array['firebase_token'] = $user_details->firebase_token;
                $tyre_array['verify_tag'] = $user_details->verify_tag ? $user_details->verify_tag : null;
                $tyre_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $tyre_array['photo'] = '';
                } else {
                    $tyre_array['photo'] = asset("storage/photo/" . $user_details->photo);
                }
            } else {
                $tyre_array['user_type_id'] = 'null';
                $tyre_array['role_id'] = 'null';
                $tyre_array['name'] = 'null';
                $tyre_array['company_name'] = 'null';
                $tyre_array['mobile'] = 'null';
                $tyre_array['email'] = 'null';
                $tyre_array['gender'] = 'null';
                $tyre_array['address'] = 'null';
                $tyre_array['zipcode'] = 'null';
                $tyre_array['device_id'] = 'null';
                $tyre_array['firebase_token'] = 'null';
                $tyre_array['created_at_user'] = 'null';
                $tyre_array['photo'] = 'null';
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

            $boosted = Subscribed_boost::view_all_boosted_products(7,$tr->id);
            if($boosted == 0){
                $tyre_array['is_boosted']  = false;
            }else if($boosted == 1){
                $tyre_array['is_boosted']  = true;
            }

            $tyre_array['id'] = $tr->id;
            $tyre_array['city_name'] = $tr->city_name;
            $tyre_array['category_id'] = $tr->category_id;
            $tyre_array['user_id'] = $tr->user_id;
            $tyre_array['type'] = $tr->type;
            $tyre_array['brand_id'] = $tr->brand_id;
            $tyre_array['model_id'] = $tr->model_id;
            $tyre_array['year_of_purchase'] = $tr->year_of_purchase;
            $tyre_array['title'] = $tr->title;
            $tyre_array['position'] = $tr->position;
            $tyre_array['price'] = $tr->price;
            $tyre_array['description'] = $tr->description;

            if (!empty($tr->image1)) {
                $tyre_array['image1'] = asset("storage/tyre/$tr->image1");
            }
            if (!empty($tr->image2)) {
                $tyre_array['image2'] = asset("storage/tyre/$tr->image2");
            }
            if (!empty($tr->image3)) {
                $tyre_array['image3'] = asset("storage/tyre/$tr->image3");
            }

            $tyre_array['is_negotiable'] = $tr->is_negotiable;
            $tyre_array['country_id'] = $tr->country_id;
            $tyre_array['state_id'] = $tr->state_id;
            $tyre_array['district_id'] = $tr->district_id;
            $tyre_array['city_id'] = $tr->city_id;
            $tyre_array['pincode'] = $tr->pincode;
            $tyre_array['latlong'] = $tr->latlong;
            $tyre_array['is_featured'] = $tr->is_featured;
            $tyre_array['valid_till'] = $tr->valid_till;
            $tyre_array['ad_report'] = $tr->ad_report;
            $tyre_array['status'] = $tr->status;
            // $tyre_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
            $tyre_array['created_at'] = $tr->created_at;
            $tyre_array['updated_at'] = $updated_at;
            $tyre_array['reason_for_rejection'] = $tr->reason_for_rejection;
            $tyre_array['rejected_by'] = $tr->rejected_by;
            $tyre_array['rejected_at'] = $tr->rejected_at;
            $tyre_array['approved_by'] = $tr->approved_by;
            $tyre_array['approved_at'] = $tr->approved_at;
            $tyre_array['district_name'] = $district_name;
            $tyre_array['brand_name'] = $brand_name;
            $tyre_array['model_name'] = $model_name;
            $tyre_array['approved_at'] = $tr->approved_at;

            $tyre_array['state_name'] = $state_name;
            $tyre_array['wishlist_status'] = DB::table('wishlist')->where(['user_id' => $user_id, 'category_id' => 7, 'item_id' => $tr->id])->count();
            $tyre_array['view_lead'] = Leads_view::where(['category_id' => 7, 'post_id' => $tr->id])->count();
            $tyre_array['call_lead'] = Lead::where(['category_id' => 7, 'post_id' => $tr->id, 'calls_status' => 1])->count();
            $tyre_array['msg_lead'] = Lead::where(['category_id' => 7, 'post_id' => $tr->id, 'messages_status' => 1])->count();

            $data[] = $tyre_array;
        } else if ($category_id == 8) {
            $output = [];

            /** Date of Create at */
            $create = $tr->created_at;
            $newtime = strtotime($create);
            $created_at = date('M d, Y', $newtime);

            /** Date of Update at */
            $update = $tr->updated_at;
            $newtime1 = strtotime($update);
            $updated_at = date('M d, Y', $newtime1);

            /** Distance Show */
            $d = round($tr->distance);
            if ($d == null) {
                $distance = 0;
            } else {
                $distance = $d;
            }

            /** District Name */
            $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;
            $state_name = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

            $pesticide_array = array();

            $pesticide_array['distance'] = $distance;

            $user_count = DB::table('user')->where(['id' => $tr->user_id])->count();
            if ($user_count > 0) {
                $user_details = DB::table('user')->where(['id' => $tr->user_id])->first();
                $pesticide_array['user_type_id'] = $user_details->user_type_id;
                $pesticide_array['role_id'] = $user_details->role_id;
                $pesticide_array['name'] = $user_details->name;
                $pesticide_array['company_name'] = $user_details->company_name;
                $pesticide_array['mobile'] = $user_details->mobile;
                $pesticide_array['email'] = $user_details->email;
                $pesticide_array['gender'] = $user_details->gender;
                $pesticide_array['address'] = $user_details->address;
                $pesticide_array['zipcode'] = $user_details->zipcode;
                $pesticide_array['device_id'] = $user_details->device_id;
                $pesticide_array['firebase_token'] = $user_details->firebase_token;
                $pesticide_array['verify_tag'] = $user_details->verify_tag ? $user_details->verify_tag : null;
                $pesticide_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $pesticide_array['photo'] = '';
                } else {
                    $pesticide_array['photo'] = asset("storage/photo/" . $user_details->photo);
                }
            } else {
                $pesticide_array['user_type_id'] = 'null';
                $pesticide_array['role_id'] = 'null';
                $pesticide_array['name'] = 'null';
                $pesticide_array['company_name'] = 'null';
                $pesticide_array['mobile'] = 'null';
                $pesticide_array['email'] = 'null';
                $pesticide_array['gender'] = 'null';
                $pesticide_array['address'] = 'null';
                $pesticide_array['zipcode'] = 'null';
                $pesticide_array['device_id'] = 'null';
                $pesticide_array['firebase_token'] = 'null';
                $pesticide_array['created_at_user'] = 'null';
                $pesticide_array['photo'] = 'null';
            }

            $boosted = Subscribed_boost::view_all_boosted_products(8,$tr->id);
            if($boosted == 0){
                $pesticide_array['is_boosted']  = false;
            }else if($boosted == 1){
                $pesticide_array['is_boosted']  = true;
            }

            $pesticide_array['id'] = $tr->id;
            $pesticide_array['city_name'] = $tr->city_name;
            $pesticide_array['category_id'] = $tr->category_id;
            $pesticide_array['user_id'] = $tr->user_id;
            $pesticide_array['title'] = $tr->title;
            $pesticide_array['description'] = $tr->description;
            $pesticide_array['price'] = $tr->price;
            $pesticide_array['is_negotiable'] = $tr->is_negotiable;

            if (!empty($tr->image1)) {
                $pesticide_array['image1'] = asset("storage/pesticides/$tr->image1");
            }
            if (!empty($tr->image2)) {
                $pesticide_array['image2'] = asset("storage/pesticides/$tr->image2");
            }
            if (!empty($tr->image3)) {
                $pesticide_array['image3'] = asset("storage/pesticides/$tr->image3");
            }

            $pesticide_array['country_id'] = $tr->country_id;
            $pesticide_array['state_id'] = $tr->state_id;
            $pesticide_array['district_id'] = $tr->district_id;
            $pesticide_array['city_id'] = $tr->city_id;
            $pesticide_array['pincode'] = $tr->pincode;
            $pesticide_array['latlong'] = $tr->latlong;
            $pesticide_array['is_featured'] = $tr->is_featured;
            $pesticide_array['valid_till'] = $tr->valid_till;
            $pesticide_array['ad_report'] = $tr->ad_report;
            $pesticide_array['status'] = $tr->status;
            //    $pesticide_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
            $pesticide_array['created_at'] = $tr->created_at;
            $pesticide_array['updated_at'] = $updated_at;
            $pesticide_array['reason_for_rejection'] = $tr->reason_for_rejection;
            $pesticide_array['rejected_by'] = $tr->rejected_by;
            $pesticide_array['rejected_at'] = $tr->rejected_at;
            $pesticide_array['approved_by'] = $tr->approved_by;
            $pesticide_array['approved_at'] = $tr->approved_at;
            $pesticide_array['district_name'] = $district_name;

            $pesticide_array['state_name'] = $state_name;
            $pesticide_array['wishlist_status'] = DB::table('wishlist')->where(['user_id' => $user_id, 'category_id' => 8, 'item_id' => $tr->id])->count();
            $pesticide_array['view_lead'] = Leads_view::where(['category_id' => 8, 'post_id' => $tr->id])->count();
            $pesticide_array['call_lead'] = Lead::where(['category_id' => 8, 'post_id' => $tr->id, 'calls_status' => 1])->count();
            $pesticide_array['msg_lead'] = Lead::where(['category_id' => 8, 'post_id' => $tr->id, 'messages_status' => 1])->count();
            $data[] = $pesticide_array;
        } else if ($category_id == 9) {
            $output = [];
            /** Date of Create at */
            $create = $tr->created_at;
            $newtime = strtotime($create);
            $created_at = date('M d, Y', $newtime);

            /** Date of Update at */
            $update = $tr->updated_at;
            $newtime1 = strtotime($update);
            $updated_at = date('M d, Y', $newtime1);

            /** Distance Show */
            $d = round($tr->distance);
            if ($d == null) {
                $distance = 0;
            } else {
                $distance = $d;
            }

            /** District Name */
            $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;
            $state_name = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

            $fertilizers_array = array();

            $fertilizers_array['distance'] = $distance;

            $user_count = DB::table('user')->where(['id' => $tr->user_id])->count();
            if ($user_count > 0) {
                $user_details = DB::table('user')->where(['id' => $tr->user_id])->first();
                $fertilizers_array['user_type_id'] = $user_details->user_type_id;
                $fertilizers_array['role_id'] = $user_details->role_id;
                $fertilizers_array['name'] = $user_details->name;
                $fertilizers_array['company_name'] = $user_details->company_name;
                $fertilizers_array['mobile'] = $user_details->mobile;
                $fertilizers_array['email'] = $user_details->email;
                $fertilizers_array['gender'] = $user_details->gender;
                $fertilizers_array['address'] = $user_details->address;
                $fertilizers_array['zipcode'] = $user_details->zipcode;
                $fertilizers_array['device_id'] = $user_details->device_id;
                $fertilizers_array['firebase_token'] = $user_details->firebase_token;
                $fertilizers_array['verify_tag'] = $user_details->verify_tag ? $user_details->verify_tag : null;
                $fertilizers_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $fertilizers_array['photo'] = '';
                } else {
                    $fertilizers_array['photo'] = asset("storage/photo/" . $user_details->photo);
                }
            } else {
                $fertilizers_array['user_type_id'] = 'null';
                $fertilizers_array['role_id'] = 'null';
                $fertilizers_array['name'] = 'null';
                $fertilizers_array['company_name'] = 'null';
                $fertilizers_array['mobile'] = 'null';
                $fertilizers_array['email'] = 'null';
                $fertilizers_array['gender'] = 'null';
                $fertilizers_array['address'] = 'null';
                $fertilizers_array['zipcode'] = 'null';
                $fertilizers_array['device_id'] = 'null';
                $fertilizers_array['firebase_token'] = 'null';
                $fertilizers_array['created_at_user'] = 'null';
                $fertilizers_array['photo'] = 'null';
            }
            $boosted = Subscribed_boost::view_all_boosted_products(9,$tr->id);
            if($boosted == 0){
                $fertilizers_array['is_boosted']  = false;
            }else if($boosted == 1){
                $fertilizers_array['is_boosted']  = true;
            }

            $fertilizers_array['id'] = $tr->id;
            $fertilizers_array['city_name'] = $tr->city_name;
            $fertilizers_array['category_id'] = $tr->category_id;
            $fertilizers_array['user_id'] = $tr->user_id;
            $fertilizers_array['title'] = $tr->title;
            $fertilizers_array['description'] = $tr->description;
            $fertilizers_array['price'] = $tr->price;
            $fertilizers_array['is_negotiable'] = $tr->is_negotiable;

            if (!empty($tr->image1)) {
                $fertilizers_array['image1'] = asset("storage/fertilizers/$tr->image1");
            }
            if (!empty($tr->image2)) {
                $fertilizers_array['image2'] = asset("storage/fertilizers/$tr->image2");
            }
            if (!empty($tr->image3)) {
                $fertilizers_array['image3'] = asset("storage/fertilizers/$tr->image2");
            }

            $fertilizers_array['country_id'] = $tr->country_id;
            $fertilizers_array['state_id'] = $tr->state_id;
            $fertilizers_array['district_id'] = $tr->district_id;
            $fertilizers_array['city_id'] = $tr->city_id;
            $fertilizers_array['pincode'] = $tr->pincode;
            $fertilizers_array['latlong'] = $tr->latlong;
            $fertilizers_array['is_featured'] = $tr->is_featured;
            $fertilizers_array['valid_till'] = $tr->valid_till;
            $fertilizers_array['ad_report'] = $tr->ad_report;
            $fertilizers_array['status'] = $tr->status;
            //    $fertilizers_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
            $fertilizers_array['created_at'] = $tr->created_at;
            $fertilizers_array['updated_at'] = $updated_at;
            $fertilizers_array['reason_for_rejection'] = $tr->reason_for_rejection;
            $fertilizers_array['rejected_by'] = $tr->rejected_by;
            $fertilizers_array['rejected_at'] = $tr->rejected_at;
            $fertilizers_array['approved_by'] = $tr->approved_by;
            $fertilizers_array['approved_at'] = $tr->approved_at;
            $fertilizers_array['district_name'] = $district_name;

            $fertilizers_array['state_name'] = $state_name;
            $fertilizers_array['wishlist_status'] = DB::table('wishlist')->where(['user_id' => $user_id, 'category_id' => 9, 'item_id' => $tr->id])->count();
            $fertilizers_array['view_lead'] = Leads_view::where(['category_id' => 9, 'post_id' => $tr->id])->count();
            $fertilizers_array['call_lead'] = Lead::where(['category_id' => 9, 'post_id' => $tr->id, 'calls_status' => 1])->count();
            $fertilizers_array['msg_lead'] = Lead::where(['category_id' => 9, 'post_id' => $tr->id, 'messages_status' => 1])->count();

            $data[] = $fertilizers_array;
        } else if ($category_id == 12) {
           // dd($tr);
            $output = [];

            /** Date of Create at */
            $create = $tr->created_at;
            $newtime = strtotime($create);
            $created_at = date('M d, Y', $newtime);

            /** Date of Update at */
            $update = $tr->updated_at;
            $newtime1 = strtotime($update);
            $updated_at = date('M d, Y', $newtime1);

            /** Distance Show */
            $d = round($tr->distance);
            if ($d == null) {
                $distance = 0;
            } else {
                $distance = $d;
            }

            /** District Name */
            $district_name = DB::table('district')->where('id', $tr->district_id)->first()->district_name;
            $state_name = DB::table('state')->where(['id' => $tr->state_id])->first()->state_name;

            $crops_array = array();

            $crops_array['distance'] = $distance;

            $user_count = DB::table('user')->where(['id' => $tr->user_id])->count();
            if ($user_count > 0) {
                $user_details = DB::table('user')->where(['id' => $tr->user_id])->first();
                $crops_array['user_type_id'] = $user_details->user_type_id;
                $crops_array['role_id'] = $user_details->role_id;
                $crops_array['name'] = $user_details->name;
                $crops_array['company_name'] = $user_details->company_name;
                $crops_array['mobile'] = $user_details->mobile;
                $crops_array['email'] = $user_details->email;
                $crops_array['gender'] = $user_details->gender;
                $crops_array['address'] = $user_details->address;
                $crops_array['zipcode'] = $user_details->zipcode;
                $crops_array['device_id'] = $user_details->device_id;
                $crops_array['firebase_token'] = $user_details->firebase_token;
                $crops_array['verify_tag'] = $user_details->verify_tag ? $user_details->verify_tag : null;
                $crops_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                if ($user_details->photo == 'NULL' || $user_details->photo == '') {
                    $crops_array['photo'] = '';
                } else {
                    $crops_array['photo'] = asset("storage/photo/" . $user_details->photo);
                }
            } else {
                $crops_array['user_type_id'] = 'null';
                $crops_array['role_id'] = 'null';
                $crops_array['name'] = 'null';
                $crops_array['company_name'] = 'null';
                $crops_array['mobile'] = 'null';
                $crops_array['email'] = 'null';
                $crops_array['gender'] = 'null';
                $crops_array['address'] = 'null';
                $crops_array['zipcode'] = 'null';
                $crops_array['device_id'] = 'null';
                $crops_array['firebase_token'] = 'null';
                $crops_array['created_at_user'] = 'null';
                $crops_array['photo'] = 'null';
            }
            $boosted = Subscribed_boost::view_all_boosted_products(12,$tr->id);
            if($boosted == 0){
                $crops_array['is_boosted']  = false;
            }else if($boosted == 1){
                $crops_array['is_boosted']  = true;
            }

            $crops_array['id'] = $tr->id;
            $crops_array['city_name'] = $tr->city_name;
            $crops_array['category_id'] = $tr->category_id;
            $crops_array['user_id'] = $tr->user_id;
            $crops_array['title'] = $tr->title;
            $crops_array['description'] = $tr->description;
            $crops_array['price'] = $tr->price;
            $crops_array['is_negotiable'] = $tr->is_negotiable;
            $crops_array['type']  = $tr->type;
             $crops_array['crops_subscribed_id']  = $tr->crops_subscribed_id;
            $crops_array['quantity']  = $tr->quantity;
            //$crops_array['expiry_date'] = DB::table('crops_subscribeds')->where('id',$tr->crops_subscribed_id)->value('end_date');
            $crops_array['expiry_date'] = $tr->expiry_date;
            $crops_array['crops_category_id'] = $tr->crops_category_id;
            $crops_array['crop_category_name']  = DB::table('crops_category')->where('id',$tr->crops_category_id)->value('crops_cat_name');

            $tag= DB::table('user_crops_verify_tag')
                    ->where('user_id',$user_id)
                    ->orderBy('subscription_id','DESC')
                    ->count();
            if($tag > 0){
                $v_tag= DB::table('user_crops_verify_tag')
                    ->where('user_id',$user_id)
                    ->orderBy('subscription_id','DESC')
                    ->first();
                    
                    //dd($v_tag);
                if(!empty($v_tag->crops_verify_tag) && $v_tag->crops_verify_tag!=null){
                    $crops_array['crops_verify_tag']  = $v_tag->crops_verify_tag;
                } else {
                    $crops_array['crops_verify_tag']  = null;
                }
                 
            } else {
                 $crops_array['crops_verify_tag'] = null;
            }
          

            if (!empty($tr->image1)) {
                $crops_array['image1'] = asset("storage/crops/$tr->image1");
            }
            if (!empty($tr->image2)) {
                $crops_array['image2'] = asset("storage/crops/$tr->image2");
            }
            if (!empty($tr->image3)) {
                $crops_array['image3'] = asset("storage/crops/$tr->image2");
            }

            $crops_array['country_id'] = $tr->country_id;
            $crops_array['state_id'] = $tr->state_id;
            $crops_array['district_id'] = $tr->district_id;
            $crops_array['city_id'] = $tr->city_id;
            $crops_array['pincode'] = $tr->pincode;
            $crops_array['latlong'] = $tr->latlong;
            $crops_array['is_featured'] = $tr->is_featured;
            $crops_array['valid_till'] = $tr->valid_till;
            $crops_array['ad_report'] = $tr->ad_report;
            $crops_array['status'] = $tr->status;
            $crops_array['created_at'] = $tr->created_at;
            $crops_array['updated_at'] = $updated_at;
            $crops_array['reason_for_rejection'] = $tr->reason_for_rejection;
            $crops_array['rejected_by'] = $tr->rejected_by;
            $crops_array['rejected_at'] = $tr->rejected_at;
            $crops_array['approved_by'] = $tr->approved_by;
            $crops_array['approved_at'] = $tr->approved_at;
            $crops_array['district_name'] = $district_name;

            $crops_array['state_name'] = $state_name;
            $crops_array['wishlist_status'] = DB::table('wishlist')->where(['user_id' => $user_id, 'category_id' => 12, 'item_id' => $tr->id])->count();
            $crops_array['view_lead'] = Leads_view::where(['category_id' => 12, 'post_id' => $tr->id])->count();
            $crops_array['call_lead'] = Lead::where(['category_id' => 12, 'post_id' => $tr->id, 'calls_status' => 1])->count();
            $crops_array['msg_lead'] = Lead::where(['category_id' => 12, 'post_id' => $tr->id, 'messages_status' => 1])->count();

            $data[] = $crops_array;
        }

        if (!empty($data)) {
            return $data;
        }
    }
}
