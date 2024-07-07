<?php

namespace App\Models\Subscription;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class Subscribed_boost extends Model
{
    use HasFactory;

    

    protected function getBoostedProduct($category_id, $product_id, $user_id)
    {

        if ($category_id==1) {
            $product = DB::table('tractor as t')
                            ->select('t.*',DB::raw("CONCAT('".env('IMAGE_PATH_TRACTOR')."',t.front_image) as front_image"),'b.name as brand_name','m.model_name')
                            ->leftJoin('brand as b','b.id','=','t.brand_id')
                            ->leftJoin('model as m','m.id','=','t.model_id')
                            ->where(['t.id'=>$product_id,'t.user_id'=>$user_id])->first();
        }
        if ($category_id==3) {
            $product = DB::table('goods_vehicle as g')
                            ->select('g.*',DB::raw("CONCAT('".env('IMAGE_PATH_GV')."',g.front_image) as front_image"),'b.name as brand_name','m.model_name')
                            ->leftJoin('brand as b','b.id','=','g.brand_id')
                            ->leftJoin('model as m','m.id','=','g.model_id')
                            ->where(['g.id'=>$product_id,'g.user_id'=>$user_id])->first();
        }
        if ($category_id==4) {
            $product = DB::table('harvester as h')
                            ->select('h.*',DB::raw("CONCAT('".env('IMAGE_PATH_HARVESTER')."',h.front_image) as front_image"),'b.name as brand_name','m.model_name')
                            ->leftJoin('brand as b','b.id','=','h.brand_id')
                            ->leftJoin('model as m','m.id','=','h.model_id')
                            ->where(['h.id'=>$product_id,'h.user_id'=>$user_id])->first();
        }
        if ($category_id==5) {
            $product = DB::table('implements as i')
                            ->select('i.*',DB::raw("CONCAT('".env('IMAGE_PATH_IMPLEMENTS')."',i.front_image) as front_image"),'b.name as brand_name','m.model_name')
                            ->leftJoin('brand as b','b.id','=','i.brand_id')
                            ->leftJoin('model as m','m.id','=','i.model_id')
                            ->where(['i.id'=>$product_id,'i.user_id'=>$user_id])->first();
        }
        if ($category_id==6) {
            $product = DB::table('seeds as s')
                            ->select('s.*',DB::raw("CONCAT('".env('IMAGE_PATH_SEEDS')."',s.image1) as front_image"))
                            ->where(['s.id'=>$product_id,'s.user_id'=>$user_id])->first();
        }
        if ($category_id==8) {
            $product = DB::table('pesticides as p')
                            ->select('p.*',DB::raw("CONCAT('".env('IMAGE_PATH_PESTICIDES')."',p.image1) as front_image"))
                            ->where(['p.id'=>$product_id,'p.user_id'=>$user_id])->first();
        }
        if ($category_id==9) {
            $product = DB::table('fertilizers as f')
                            ->select('f.*',DB::raw("CONCAT('".env('IMAGE_PATH_FERTILIZERS')."',f.image1) as front_image"))
                            ->where(['f.id'=>$product_id,'f.user_id'=>$user_id])->first();
        }
        if ($category_id==7) {
            $product = DB::table('tyres as ty')
                            ->select('ty.*',DB::raw("CONCAT('".env('IMAGE_PATH_TYRE')."',ty.image1) as front_image"),'b.name as brand_name','m.model_name')
                            ->leftJoin('brand as b','b.id','=','ty.brand_id')
                            ->leftJoin('model as m','m.id','=','ty.model_id')
                            ->where(['ty.id'=>$product_id,'ty.user_id'=>$user_id])->first();
        }

        /*if ($category_id==12) {
            $product = DB::table('crops as c')
                            ->select('c.*',DB::raw("CONCAT('".env('IMAGE_PATH_CROPS')."',c.image1) as front_image"))
                            ->where(['c.id'=>$product_id,'c.user_id'=>$user_id])->first();
        }*/
        
        if ($category_id==12) {
            $product = DB::table('crops as c')
                            ->select('c.*','cc.crops_cat_name as crop_category_name',DB::raw("CONCAT('".env('IMAGE_PATH_CROPS')."',c.image1) as front_image"), 'cc.crops_cat_name as crop_category_name')
                            ->leftJoin('crops_category as cc', 'cc.id', '=', 'c.crops_category_id')
                            ->where(['c.id'=>$product_id,'c.user_id'=>$user_id])->first();
        }

        return $product;
    }

    # View All Which Product Boosted 
    protected function view_all_boosted_products($category_id,$product_id)
    {
        //dd($category_id);
        
        if($category_id == 12){
            $subscribed_boosts_count = DB::table('crops_boosts')
            ->where(['category_id'=>$category_id,'crop_id'=>$product_id,'status'=>1])
            ->count();
        }else{
            $subscribed_boosts_count = DB::table('subscribed_boosts')
            ->where(['category_id'=>$category_id,'product_id'=>$product_id,'status'=>1])
            ->count();
        }
        
      

        if($subscribed_boosts_count > 0){
            $boosted = 1;
        }else if($subscribed_boosts_count == 0){
            $boosted = 0;
        }
       // dd($boosted);

        return $boosted;
    }

    protected function viewAllCropsProduct($category_id,$product_id)
    {
        
        //$subscribed_boosts_count = DB::table('crops_subscribeds')
        $subscribed_boosts_count = DB::table('crops_boosts')
        ->where(['category_id'=>$category_id,'crop_id'=>$product_id,'status'=>1])
        ->count();

        if($subscribed_boosts_count > 0){
            $boosted = 1;
        }else if($subscribed_boosts_count == 0){
            $boosted = 0;
        }
       // dd($boosted);

        return $boosted;
    }


}
