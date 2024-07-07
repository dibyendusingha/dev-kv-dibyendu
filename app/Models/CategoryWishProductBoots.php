<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryWishProductBoots extends Model
{
    use HasFactory;

    # Banner Position for Product Boost Post
    protected function category_wish_product_list ($category_id) {
        // echo "model";
        // dd($category_id);

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
                -- CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as meter_image,
                -- CONCAT('" . env('IMAGE_PATH_HARVESTER') . "',front_image) as tyre_image,
                NULL as meter_image,
                NULL as tyre_image,
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
                -- CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',meter_image) as meter_image,
                -- CONCAT('" . env('IMAGE_PATH_IMPLEMENTS') . "',tyre_image) as tyre_image,
                NULL as meter_image,
                NULL as tyre_image,
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
        join subscribed_boosts on  t.category_id= subscribed_boosts.category_id and t.id= subscribed_boosts.product_id 
        where subscribed_boosts.category_id=$category_id  and t.status=1 and subscribed_boosts.status = 1 ");
        //where subscribed_boosts.category_id=1  and t.status=1 and t.id = subscribed_boosts.product_id");


        foreach ($datas as $data) {
            $data->specification=[];
            $model_id = $data->model_id;
            $data->specification = DB::table('specifications')
                            ->where(['model_id'=>$model_id,'status'=>1])->get();
        }


       $output = array();
       $output = $datas;
       //dd($output);

        // $output['response']=true;
        // $output['message']='Data';
        // $output['data'] = $datas;
        // $output['status_code'] = 200;
        // $output['error'] = '';

        return $output;
    }


}
