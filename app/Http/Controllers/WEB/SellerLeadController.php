<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerLeadController extends Controller
{
    public function allCategoryList()
    {
        return view('admin.seller_lead.seller_lead_by_category');
    }


    public function categoryWishProductList($categoryId)
    {
        //  dd($categoryId);
        if ($categoryId == 1) {
            $sellerList = DB::table('seller_leads as sl')
                ->select(
                    'tractor.front_image as image',
                    'tractor.created_at',
                    'tractor.status',
                    'brand.name as title',
                    'user.name',
                    'user.mobile',
                    'user.user_type_id',
                    'user.zipcode',
                    'state.state_name',
                    'district.district_name',
                    'city.city_name',
                    'sl.post_id',
                    'sl.id as seller_id'
                )
                ->leftJoin('tractor', 'tractor.id', '=', 'sl.post_id')
                ->leftJoin('user', 'user.id', '=', 'sl.post_user_id')
                ->leftJoin('state', 'state.id', '=', 'user.state_id')
                ->leftJoin('district', 'district.id', '=', 'user.district_id')
                ->leftJoin('city', 'city.id', '=', 'user.city_id')
                ->leftJoin('brand', 'brand.id', '=', 'tractor.brand_id')
                ->where('sl.category_id', 1)
                ->orderBy('sl.id', 'asc')
                ->groupBy('tractor.id')
                ->paginate(10);
            //->get();
        } else if ($categoryId == 3) {
            $sellerList = DB::table('seller_leads as sl')
                ->select(
                    'goods_vehicle.front_image as image',
                    'goods_vehicle.created_at',
                    'goods_vehicle.status',
                    'brand.name as title',
                    'user.name',
                    'user.mobile',
                    'user.user_type_id',
                    'user.zipcode',
                    'state.state_name',
                    'district.district_name',
                    'city.city_name',
                    'sl.post_id',
                    'sl.id as seller_id'
                )
                ->leftJoin('goods_vehicle', 'goods_vehicle.id', '=', 'sl.post_id')
                ->leftJoin('user', 'user.id', '=', 'sl.post_user_id')
                ->leftJoin('state', 'state.id', '=', 'user.state_id')
                ->leftJoin('district', 'district.id', '=', 'user.district_id')
                ->leftJoin('city', 'city.id', '=', 'user.city_id')
                ->leftJoin('brand', 'brand.id', '=', 'goods_vehicle.brand_id')
                ->where('sl.category_id', 3)
                ->orderBy('sl.id', 'asc')
                ->groupBy('goods_vehicle.id')
                ->paginate(10);
        } else if ($categoryId == 4) {
            $sellerList = DB::table('seller_leads as sl')
                ->select(
                    'harvester.front_image as image',
                    'harvester.created_at',
                    'harvester.status',
                    'brand.name as title',
                    'user.name',
                    'user.mobile',
                    'user.user_type_id',
                    'user.zipcode',
                    'state.state_name',
                    'district.district_name',
                    'city.city_name',
                    'sl.post_id',
                    'sl.id as seller_id'
                )
                ->leftJoin('harvester', 'harvester.id', '=', 'sl.post_id')
                ->leftJoin('user', 'user.id', '=', 'sl.post_user_id')
                ->leftJoin('state', 'state.id', '=', 'user.state_id')
                ->leftJoin('district', 'district.id', '=', 'user.district_id')
                ->leftJoin('city', 'city.id', '=', 'user.city_id')
                ->leftJoin('brand', 'brand.id', '=', 'harvester.brand_id')
                ->where('sl.category_id', 4)
                ->orderBy('sl.id', 'asc')
                ->groupBy('harvester.id')
                ->paginate(10);
        } else if ($categoryId == 5) {
            $sellerList = DB::table('seller_leads as sl')
                ->select(
                    'implements.front_image as image',
                    'implements.created_at',
                    'implements.status',
                    'brand.name as title',
                    'user.name',
                    'user.mobile',
                    'user.user_type_id',
                    'user.zipcode',
                    'state.state_name',
                    'district.district_name',
                    'city.city_name',
                    'sl.post_id',
                    'sl.id as seller_id'
                )
                ->leftJoin('implements', 'implements.id', '=', 'sl.post_id')
                ->leftJoin('user', 'user.id', '=', 'sl.post_user_id')
                ->leftJoin('state', 'state.id', '=', 'user.state_id')
                ->leftJoin('district', 'district.id', '=', 'user.district_id')
                ->leftJoin('city', 'city.id', '=', 'user.city_id')
                ->leftJoin('brand', 'brand.id', '=', 'implements.brand_id')
                ->where('sl.category_id', 5)
                ->orderBy('sl.id', 'asc')
                ->groupBy('implements.id')
                ->paginate(10);
        } else if ($categoryId == 6) {
            $sellerList = DB::table('seller_leads as sl')
                ->select(
                    'seeds.image1 as image',
                    'seeds.created_at',
                    'seeds.status',
                    'seeds.title as title',
                    'user.name',
                    'user.mobile',
                    'user.user_type_id',
                    'user.zipcode',
                    'state.state_name',
                    'district.district_name',
                    'city.city_name',
                    'sl.post_id',
                    'sl.id as seller_id'
                )
                ->leftJoin('seeds', 'seeds.id', '=', 'sl.post_id')
                ->leftJoin('user', 'user.id', '=', 'sl.post_user_id')
                ->leftJoin('state', 'state.id', '=', 'user.state_id')
                ->leftJoin('district', 'district.id', '=', 'user.district_id')
                ->leftJoin('city', 'city.id', '=', 'user.city_id')
                ->where('sl.category_id', 6)
                ->orderBy('sl.id', 'asc')
                ->groupBy('seeds.id')
                ->paginate(10);
        } else if ($categoryId == 7) {
            $sellerList = DB::table('seller_leads as sl')
                ->select(
                    'tyres.image1 as image',
                    'tyres.created_at',
                    'tyres.status',
                    'brand.name as title',
                    'user.name',
                    'user.mobile',
                    'user.user_type_id',
                    'user.zipcode',
                    'state.state_name',
                    'district.district_name',
                    'city.city_name',
                    'sl.post_id',
                    'sl.id as seller_id'
                )
                ->leftJoin('tyres', 'tyres.id', '=', 'sl.post_id')
                ->leftJoin('user', 'user.id', '=', 'sl.post_user_id')
                ->leftJoin('state', 'state.id', '=', 'user.state_id')
                ->leftJoin('district', 'district.id', '=', 'user.district_id')
                ->leftJoin('city', 'city.id', '=', 'user.city_id')
                ->leftJoin('brand', 'brand.id', '=', 'tyres.brand_id')
                ->where('sl.category_id', 7)
                ->orderBy('sl.id', 'asc')
                ->groupBy('tyres.id')
                ->paginate(10);
        } else if ($categoryId == 8) {
            $sellerList = DB::table('seller_leads as sl')
                ->select(
                    'pesticides.image1 as image',
                    'pesticides.created_at',
                    'pesticides.status',
                    'pesticides.title as title',
                    'user.name',
                    'user.mobile',
                    'user.user_type_id',
                    'user.zipcode',
                    'state.state_name',
                    'district.district_name',
                    'city.city_name',
                    'sl.post_id',
                    'sl.id as seller_id'
                )
                ->leftJoin('pesticides', 'pesticides.id', '=', 'sl.post_id')
                ->leftJoin('user', 'user.id', '=', 'sl.post_user_id')
                ->leftJoin('state', 'state.id', '=', 'user.state_id')
                ->leftJoin('district', 'district.id', '=', 'user.district_id')
                ->leftJoin('city', 'city.id', '=', 'user.city_id')
                ->where('sl.category_id', 8)
                ->orderBy('sl.id', 'asc')
                ->groupBy('pesticides.id')
                ->paginate(10);
        } else if ($categoryId == 9) {
            $sellerList = DB::table('seller_leads as sl')
                ->select(
                    'fertilizers.image1 as image',
                    'fertilizers.created_at',
                    'fertilizers.status',
                    'fertilizers.title as title',
                    'user.name',
                    'user.mobile',
                    'user.user_type_id',
                    'user.zipcode',
                    'state.state_name',
                    'district.district_name',
                    'city.city_name',
                    'sl.post_id',
                    'sl.id as seller_id'
                )
                ->leftJoin('fertilizers', 'fertilizers.id', '=', 'sl.post_id')
                ->leftJoin('user', 'user.id', '=', 'sl.post_user_id')
                ->leftJoin('state', 'state.id', '=', 'user.state_id')
                ->leftJoin('district', 'district.id', '=', 'user.district_id')
                ->leftJoin('city', 'city.id', '=', 'user.city_id')
                ->where('sl.category_id', 9)
                ->orderBy('sl.id', 'asc')
                ->groupBy('fertilizers.id')
                ->paginate(10);
        } else if ($categoryId == 12) {
            $sellerList = DB::table('seller_leads as sl')
                ->select(
                    'crops.image1 as image',
                    'crops.created_at',
                    'crops.status',
                    'crops_category.crops_cat_name as title',
                    'user.name',
                    'user.mobile',
                    'user.user_type_id',
                    'user.zipcode',
                    'state.state_name',
                    'district.district_name',
                    'city.city_name',
                    'sl.post_id',
                    'sl.id as seller_id'
                )
                ->leftJoin('crops', 'crops.id', '=', 'sl.post_id')
                ->leftJoin('crops_category', 'crops_category.id', '=', 'crops.crops_category_id')
                ->leftJoin('user', 'user.id', '=', 'sl.post_user_id')
                ->leftJoin('state', 'state.id', '=', 'user.state_id')
                ->leftJoin('district', 'district.id', '=', 'user.district_id')
                ->leftJoin('city', 'city.id', '=', 'user.city_id')
                ->where('sl.category_id', 12)
                ->orderBy('sl.id', 'asc')
                ->groupBy('crops.id')
                ->paginate(10);
        }

        return view('admin.seller_lead.seller_post_list', ['sellerList' => $sellerList]);
    }

    public function allSellerList($seller_id)
    {
        // dd($seller_id);
        $seller = DB::table('seller_leads')->where('id', $seller_id)->first();
        $category_id = $seller->category_id;
        $post_id = $seller->post_id;


        $sellerLeadList = DB::table('seller_leads as sl')
            ->select(
                'user.name',
                'user.mobile',
                'user.user_type_id',
                'user.zipcode',
                'state.state_name',
                'district.district_name',
                'city.city_name',
                'sl.status as sellerStatus',
                'sl.created_at',
                'sl.id as seller_id'
            )

            ->leftJoin('user', 'user.id', '=', 'sl.user_id')
            ->leftJoin('state', 'state.id', '=', 'user.state_id')
            ->leftJoin('district', 'district.id', '=', 'user.district_id')
            ->leftJoin('city', 'city.id', '=', 'user.city_id')
            ->where('sl.category_id', $category_id)
            ->where('sl.post_id', $post_id)
            ->orderBy('sl.id', 'asc')
            ->groupBy('sl.user_id')
            //->get();
            ->paginate(10);

            //dd($sellerLeadList);


        return view('admin.seller_lead.seller_lead_list_details', ['sellerLeadList' => $sellerLeadList]);
    }
}
