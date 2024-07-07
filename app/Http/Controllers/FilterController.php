<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\Leads_view;
use App\Models\Subscription\Subscribed_boost;

class FilterController extends Controller
{
    /** Brand And Model Data  */
    public function getBrandModelData(Request $request){
        $categoryId  = $request->category;
        $type        = $request->type;

        $brand_id    = $request->brand_id;
        $rent_type   = $request->rent_type;

        // Brand Wish Model Data Show
        if(!empty($brand_id) && !empty($categoryId) && !empty($type)){
      
            $brand_id    = $request->brand_id;

            $categoryId  =  $request->category;
            $type        =  $request->type;
            
            // $categoryId = $request->category;
            // $type       = $request->type;
            $brand = [];
            if($categoryId == 1){
                $brandName = DB::table('brand')->where('id',$request->brand_id)->where('category_id',1)->where('status',1)->get();
            }
            if($categoryId == 3){
                $brandName = DB::table('brand')->where('category_id',3)->where('status',1)->get();
            }
            if($categoryId == 4){
                $brandName = DB::table('brand')->where('category_id',4)->where('status',1)->get();
            }
            if($categoryId == 5){
                $brandName = DB::table('brand')->where('category_id',5)->where('status',1)->get();
            }
            if($categoryId == 7){
                $brandName = DB::table('brand')->where('category_id',7)->where('status',1)->get();
            }
        
            foreach($brandName as $br){
                $brand_id          = $br->id;
                $brand_name        = $br->name;
                $logo              = $br->logo;
                $brand_logo        = "https://krishivikas.com/storage/images/brands/".$br->logo;
                $popular           = $br->popular;
                
                if($request->category == 1){
                    if($type == 'new' || $type == 'old'){
                        $brandDataCount    =  DB::table('tractorView')->where('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        $price             =  DB::table('tractorView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                        $max    = $price->max('price');
                        $min    = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                        
                    }
                    else if(!empty($request->rent_type) && $type == 'rent'){
                        $brandDataCount    =  DB::table('tractorView')->where('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count(); 
                        $price             =  DB::table('tractorView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                    else{
                        $brandDataCount    =  DB::table('tractorView')->where('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        $price             =  DB::table('tractorView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }

                    }
                }
                else if($categoryId == 3){
                    if($type == 'new' || $type == 'old'){
                        $brandDataCount   =  DB::table('goodvehicleview')->where('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        $price            =  DB::table('goodvehicleview')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                    else if(!empty($request->rent_type) && $type == 'rent'){
                        $brandDataCount    =  DB::table('goodVehicleView')->where('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count(); 
                        $price             =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get(); 
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                    else{
                        $brandDataCount    =  DB::table('goodvehicleview')->where('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        $price             =  DB::table('goodvehicleview')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                }
                else if($categoryId == 4){
                    if($type == 'new' || $type == 'old'){
                        $brandDataCount    =  DB::table('harvesterView')->where('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        $price             =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                    else if(!empty($request->rent_type) && $type == 'rent'){
                        $brandDataCount    =  DB::table('harvesterView')->where('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count(); 
                        $price             =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get(); 
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                    else{
                        $brandDataCount    =  DB::table('harvesterView')->where('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        $price             =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                }
                else if($categoryId == 5){
                    if($type == 'new' || $type == 'old'){
                        $brandDataCount  =  DB::table('implementView')->where('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        $price           =  DB::table('implementView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                        $max             = $price->max('price');
                        $min             = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    } 
                    else if(!empty($request->rent_type) && $type == 'rent'){
                        $brandDataCount  =  DB::table('implementView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count();
                        $price           =  DB::table('implementView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max             = $price->max('price');
                        $min             = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        } 
                    }
                    else{
                        $brandDataCount  =  DB::table('implementView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        $price           =  DB::table('implementView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max             = $price->max('price');
                        $min             = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                }
                else if($categoryId == 7){
                    if($type == 'new' || $type == 'old'){
                        $brandDataCount  =  DB::table('tyresView')->where('brand_id',$request->brand_id)->where('type',$type)->whereIn('status',[1,4])->count();
                        $price           =  DB::table('tyresView')->where('brand_id',$brand_id)->where('type',$type)->whereIn('status',[1,4])->get();
                        $max             = $price->max('price');
                        $min             = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                }
                else{
                    $brandDataCount = "";
                }

                $model_details = [];
                $model_name = DB::table('model')->where('brand_id',$br->id)->where('status',1)->get();
                //print_r($model_name);
                foreach($model_name as $model){
                    if($request->category == 1){
                        if($type == 'new' || $type == 'old'){
                            $modelCount    =  DB::table('tractorView')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                            $price1         =  DB::table('tractorView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                            $max1           = $price1->max('price');
                            $min1           = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $modelCount   =  DB::table('tractorView')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1       =  DB::table('tractorView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1         = $price1->max('price');
                            $min1         = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            } 
                        }
                        else{
                            $modelCount   =  DB::table('tractorView')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1       =  DB::table('tractorView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1         = $price1->max('price');
                            $min1         = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            } 
                        }  
                    }
                    else if($categoryId == 3){
                        if($type == 'new' || $type == 'old'){
                            $modelCount  =  DB::table('goodvehicleview')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('goodvehicleview')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                            $max1        = $price1->max('price');
                            $min1        = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $modelCount  =  DB::table('goodVehicleView')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count(); 
                            $price1      =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1        = $price1->max('price');
                            $min1        = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else{
                            $modelCount  =  DB::table('goodvehicleview')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('goodvehicleview')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1        = $price1->max('price');
                            $min1        = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                    }
                    else if($categoryId == 4){
                        if($type == 'new' || $type == 'old'){
                            $modelCount  =  DB::table('harvesterview')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('harvesterview')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                            $max1        = $price1->max('price');
                            $min1        = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $modelCount  =  DB::table('harvesterview')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count(); 
                            $price1      =  DB::table('harvesterview')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get(); 
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else{
                            $modelCount  =  DB::table('harvesterview')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('harvesterview')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                    }
                    else if($categoryId == 5){
                        if($type == 'new' || $type == 'old'){
                            $modelCount  =  DB::table('implementview')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('implementview')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $modelCount  =  DB::table('implementview')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('implementview')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            } 
                        }
                        else{
                            $modelCount  =  DB::table('implementview')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('implementview')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                    }else if($categoryId == 7){
                        if($type == 'new' || $type == 'old'){
                            $modelCount  =  DB::table('tyresView')->where('brand_id',$request->brand_id)->where('model_id',$model->id)->where('type',$type)->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('tyresView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->whereIn('status',[1,4])->get();
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                    }
                    else{
                        $modelCount = "";
                    }
                    
                    // if($modelCount > 0){
                        $model_id      = $model->id;
                        $model_name    = $model->model_name;
                         $model_image   = "https://krishivikas.com/storage/images/model/".$model->icon;
                        //$model_details[] = ['model_id'=>$model_id,'model_name'=>$model_name,'item_count' => $modelCount , 'max' => $max1 , 'min' => $min1]; 
                        $model_details[] = ['model_id'=>$model_id,'model_name'=>$model_name,'model_image'=>$model_image,'item_count' => $modelCount]; 
                    // }


                }
            
                //$data[]  = ['brand_id'=>$brand_id,'brand_name'=>$brand_name , 'brand_logo' => $brand_logo ,'popular' => $popular,'item_count'=>$brandDataCount , 'max' => $max , 'min' => $min, 'model' => $model_details]; 
                $data[]  = ['brand_id'=>$brand_id,'brand_name'=>$brand_name , 'brand_logo' => $brand_logo ,'popular' => $popular,'item_count'=>$brandDataCount , 'model' => $model_details];          
            }
            
            if(!empty($data)){
                $output['response'] = true;
                $output['message']  = 'Brand Wish Data';
                // $output['max']      = $max;
                // $output['min']      = $min;
                $output['data']     = $data;
                $output['error']    = "";
            }else{
                    $output['response'] = false;
                    $output['message']  = 'No Data Available';
                    $output['data']     = [];
            }
            
        } 
        else if(!empty($categoryId) && !empty($type)) {

            $brand_id    = $request->brand_id;
            $categoryId  =  $request->category;
            $type        =  $request->type;
            
            $brand = [];
            if($categoryId == 1){
                $brandName = DB::table('brand')->where('category_id',1)->where('status',1)->get();
            }
            if($categoryId == 3){
                $brandName = DB::table('brand')->where('category_id',3)->where('status',1)->get();
            }
            if($categoryId == 4){
                $brandName = DB::table('brand')->where('category_id',4)->where('status',1)->get();
            }
            if($categoryId == 5){
                $brandName = DB::table('brand')->where('category_id',5)->where('status',1)->get();
            }
            if($categoryId == 7){
                $brandName = DB::table('brand')->where('category_id',7)->where('status',1)->get();
            }
        
            foreach($brandName as $br){
                $brand_id          = $br->id;
                $brand_name        = $br->name;
                $logo              = $br->logo;
                $brand_logo        = "https://krishivikas.com/storage/images/brands/".$br->logo;
                $popular           = $br->popular;
                
                if($request->category == 1){
                    if($type == 'new' || $type == 'old'){
                        $brandDataCount    =  DB::table('tractorView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        $price             =  DB::table('tractorView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                        $max    = $price->max('price');
                        $min    = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                        
                    }
                    else if(!empty($request->rent_type) && $type == 'rent'){
                        $brandDataCount    =  DB::table('tractorView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count(); 
                        $price             =  DB::table('tractorView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                    else{
                        $brandDataCount    =  DB::table('tractorView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        $price             =  DB::table('tractorView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }

                    }
                }
                else if($categoryId == 3){
                    if($type == 'new' || $type == 'old'){
                        $brandDataCount   =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        $price            =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                    else if(!empty($request->rent_type) && $type == 'rent'){
                        $brandDataCount    =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count(); 
                        $price             =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get(); 
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                    else{
                        $brandDataCount    =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        $price             =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                }
                else if($categoryId == 4){
                    if($type == 'new' || $type == 'old'){
                        $brandDataCount    =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        $price             =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                    else if(!empty($request->rent_type) && $type == 'rent'){
                        $brandDataCount    =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count(); 
                        $price             =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get(); 
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                    else{
                        $brandDataCount    =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        $price             =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max               = $price->max('price');
                        $min               = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                }
                else if($categoryId == 5){
                    if($type == 'new' || $type == 'old'){
                        $brandDataCount  =  DB::table('implementView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        $price           =  DB::table('implementView')->where('brand_id',$brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                        $max             = $price->max('price');
                        $min             = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    } 
                    else if(!empty($request->rent_type) && $type == 'rent'){
                        $brandDataCount  =  DB::table('implementView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count();
                        $price           =  DB::table('implementView')->where('brand_id',$brand_id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max             = $price->max('price');
                        $min             = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        } 
                    }
                    else{
                        $brandDataCount  =  DB::table('implementView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        $price           =  DB::table('implementView')->where('brand_id',$brand_id)->where('set','rent')->whereIn('status',[1,4])->get();
                        $max             = $price->max('price');
                        $min             = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                }else if($categoryId == 7){
                    if($type == 'new' || $type == 'old'){
                        $brandDataCount  =  DB::table('tyresView')->where('brand_id',$brand_id)->where('type',$type)->whereIn('status',[1,4])->count();
                        $price           =  DB::table('tyresView')->where('brand_id',$brand_id)->where('type',$type)->whereIn('status',[1,4])->get();
                        $max             = $price->max('price');
                        $min             = $price->min('price');
                        if($max == null && $min == null){
                            $max = 0;
                            $min = 0;
                        }
                        else{
                            $max    = $price->max('price');
                            $min    = $price->min('price');
                        }
                    }
                }
                else{
                    $brandDataCount = "";
                }

                $model_details = [];
                $model_name = DB::table('model')->where('brand_id',$br->id)->where('status',1)->get();
                //print_r($model_name);
                foreach($model_name as $model){

                    if($request->category == 1){
                        if($type == 'new' || $type == 'old'){
                            $modelCount    =  DB::table('tractorView')->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                            $price1         =  DB::table('tractorView')->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                            $max1           = $price1->max('price');
                            $min1           = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $modelCount   =  DB::table('tractorView')->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1       =  DB::table('tractorView')->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1         = $price1->max('price');
                            $min1         = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            } 
                        }
                        else{
                            $modelCount   =  DB::table('tractorView')->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1       =  DB::table('tractorView')->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1         = $price1->max('price');
                            $min1         = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            } 
                        }  
                    }
                    else if($categoryId == 3){
                        if($type == 'new' || $type == 'old'){
                            $modelCount  =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                            $max1        = $price1->max('price');
                            $min1        = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $modelCount  =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count(); 
                            $price1      =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1        = $price1->max('price');
                            $min1        = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else{
                            $modelCount  =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('goodVehicleView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1        = $price1->max('price');
                            $min1        = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                    }
                    else if($categoryId == 4){
                        if($type == 'new' || $type == 'old'){
                            $modelCount  =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                            $max1        = $price1->max('price');
                            $min1        = $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $modelCount  =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count(); 
                            $price1      =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get(); 
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else{
                            $modelCount  =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('harvesterView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                    }
                    else if($categoryId == 5){
                        if($type == 'new' || $type == 'old'){
                            $modelCount  =  DB::table('implementView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('implementView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->get();
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $modelCount  =  DB::table('implementView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('implementView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('rent_type',$request->rent_type)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            } 
                        }
                        else{
                            $modelCount  =  DB::table('implementView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('implementView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('set','rent')->whereIn('status',[1,4])->get();
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                    }else if($categoryId == 7){
                        if($type == 'new' || $type == 'old'){
                            $modelCount  =  DB::table('tyresView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->whereIn('status',[1,4])->count();
                            $price1      =  DB::table('tyresView')->where('brand_id',$brand_id)->where('model_id',$model->id)->where('type',$type)->whereIn('status',[1,4])->get();
                            $max1        =  $price1->max('price');
                            $min1        =  $price1->min('price');
                            if($max1 == null && $min1 == null){
                                $max1 = 0;
                                $min1 = 0;
                            }
                            else{
                                $max1    = $price1->max('price');
                                $min1   = $price1->min('price');
                            }
                        }
                    }
                    else{
                        $modelCount = "";
                    }
                    
                    // if($modelCount > 0){
                        $model_id      = $model->id;
                        $model_name    = $model->model_name;
                        $model_image   = "https://krishivikas.com/storage/images/model/".$model->icon;
                       // $model_details[] = ['model_id'=>$model_id,'model_name'=>$model_name,'item_count' => $modelCount , 'max' => $max1 , 'min' => $min1]; 
                        $model_details[] = ['model_id'=>$model_id,'model_name'=>$model_name,'model_image'=>$model_image,'item_count' => $modelCount]; 
                  //  }

                }
            
               // $data[]  = ['brand_id'=>$brand_id,'brand_name'=>$brand_name , 'brand_logo' => $brand_logo ,'popular' => $popular,'item_count'=>$brandDataCount , 'max' => $max , 'min' => $min, 'model' => $model_details];  
                $data[]  = ['brand_id'=>$brand_id,'brand_name'=>$brand_name , 'brand_logo' => $brand_logo ,'popular' => $popular,'item_count'=>$brandDataCount , 'model' => $model_details];          

            }
            
            if(!empty($data)){
                $output['response'] = true;
                $output['message']  = 'Brand & Model Data';
                // $output['max']      = $max;
                // $output['min']      = $min;
                $output['data']     = $data;
                $output['error']    = "";
            }else{
                    $output['response'] = false;
                    $output['message']  = 'No Data Available';
                    $output['data']     = [];
            }
            
        }
        else if(!empty($categoryId) && empty($type) && empty($brand_id)) {

            $categoryId  =  $request->category;

            $brand = [];
            if($categoryId == 1){
                $brandName = DB::table('brand')->where('category_id',1)->where('status',1)->get();
            }
            if($categoryId == 3){
                $brandName = DB::table('brand')->where('category_id',3)->where('status',1)->get();
            }
            if($categoryId == 4){
                $brandName = DB::table('brand')->where('category_id',4)->where('status',1)->get();
            }
            if($categoryId == 5){
                $brandName = DB::table('brand')->where('category_id',5)->where('status',1)->get();
            }
            if($categoryId == 7){
                $brandName = DB::table('brand')->where('category_id',7)->where('status',1)->get();
            }
        
            foreach($brandName as $br){
                $brand_id          = $br->id;
                $brand_name        = $br->name;
                $logo              = $br->logo;
                $brand_logo        = "https://krishivikas.com/storage/images/brands/".$br->logo;
                $popular           = $br->popular;
                
                $model_details = [];
                $model_name = DB::table('model')->where('brand_id',$br->id)->where('status',1)->get();
                foreach($model_name as $model){
                    $model_id      = $model->id;
                    $model_name    = $model->model_name;
                    $model_image   = "https://krishivikas.com/storage/images/model/".$model->icon;

                    $model_details[] = ['model_id'=>$model_id,'model_name'=>$model_name,'model_image'=>$model_image]; 
                }
                $data[]  = ['brand_id'=>$brand_id,'brand_name'=>$brand_name , 'brand_logo' => $brand_logo ,'popular' => $popular, 'model' => $model_details];          

            }
            
            if(!empty($data)){
                $output['response'] = true;
                $output['message']  = 'Brand & Model Data';
                $output['data']     = $data;
                $output['error']    = "";
            }else{
                    $output['response'] = false;
                    $output['message']  = 'No Data Available';
                    $output['data']     = [];
            }
        }
        else if(!empty($brand_id) && !empty($categoryId) && empty($type)){
      
            $brand_id    = $request->brand_id;
            $categoryId  =  $request->category;
            
            $brand = [];
            if($categoryId == 1){
                $brandName = DB::table('brand')->where('id',$request->brand_id)->where('category_id',1)->where('status',1)->get();
            }
            if($categoryId == 3){
                $brandName = DB::table('brand')->where('id',$request->brand_id)->where('category_id',3)->where('status',1)->get();
            }
            if($categoryId == 4){
                $brandName = DB::table('brand')->where('id',$request->brand_id)->where('category_id',4)->where('status',1)->get();
            }
            if($categoryId == 5){
                $brandName = DB::table('brand')->where('id',$request->brand_id)->where('category_id',5)->where('status',1)->get();
            }
            if($categoryId == 7){
                $brandName = DB::table('brand')->where('id',$request->brand_id)->where('category_id',7)->where('status',1)->get();
            }
        
            foreach($brandName as $br){
                $brand_id          = $br->id;
                $brand_name        = $br->name;
                $logo              = $br->logo;
                $brand_logo        = "https://krishivikas.com/storage/images/brands/".$br->logo;
                $popular           = $br->popular;
                
                $model_details = [];
                $model_name = DB::table('model')->where('brand_id',$br->id)->where('status',1)->get();
                foreach($model_name as $model){
                    // if($modelCount > 0){
                        $model_id      = $model->id;
                        $model_name    = $model->model_name;
                         $model_image   = "https://krishivikas.com/storage/images/model/".$model->icon;
                        //$model_details[] = ['model_id'=>$model_id,'model_name'=>$model_name,'item_count' => $modelCount , 'max' => $max1 , 'min' => $min1]; 
                        $model_details[] = ['model_id'=>$model_id,'model_name'=>$model_name,'model_image'=>$model_image]; 
                    // }

                }
                $data[]  = ['brand_id'=>$brand_id,'brand_name'=>$brand_name , 'brand_logo' => $brand_logo ,'popular' => $popular, 'model' => $model_details];          
            }
            
            if(!empty($data)){
                $output['response'] = true;
                $output['message']  = 'Brand Wish Data';
                $output['data']     = $data;
                $output['error']    = "";
            }else{
                    $output['response'] = false;
                    $output['message']  = 'No Data Available';
                    $output['data']     = [];
            }
            
        } 
        else{

            $output['response'] = false;
            $output['message']  = 'Select Category And Type';
            $output['data']     =  []; 
        }

        return $output;

    }
    
    /** State Wish District Show  */
    public function stateWishDistrictName(Request $request){
        //echo "dip";
        $categoryId = $request->category;
        $type       = $request->type;

        $state_id    = $request->state_id;
        $district_id = $request->district_id;
        $brand_id    = $request->brand_id;
        $model_id    = $request->model_id;
        $rent_type   = $request->rent_type;
        $crops_category_id   = $request->crops_category_id;

       // dd($categoryId);
 
        if(!empty($request->brand_id) && empty($request->model_id) && empty($state_id) && empty($district_id) && !empty($categoryId) && !empty($type)){
           // $stateName = DB::table('state')->where('status',1)->get();
            $stateName = DB::table('state')->where('status',1)->orderBy('id','DESC')->get();
            $data = array();
            foreach($stateName as $key => $state){
    
                if( !empty($categoryId) ){  
                    if($categoryId == 1){
                        if($type == 'rent' && empty($request->rent_type)){
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 3){
                        if($type == 'rent'){
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 4){
                        if($type == 'rent'){
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }else{
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 5){
                        if($type == 'rent'){
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 7){
                        if($type == 'old' || $type == 'new'){
                            $stateDataCount =  DB::table('tyresView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('type',$type)->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 6){
                        $stateDataCount =  DB::table('seedView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 8){
                        $stateDataCount =  DB::table('pesticidesView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 9){
                        $stateDataCount =  DB::table('fertilizerView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 12){
                        $stateDataCount =  DB::table('cropsView')->where('state_id',$state->id)->whereIn('crops_category_id',$request->crops_category_id)->whereIn('status',[1,4])->count();
                    }
                }else{
                    $stateDataCount = '';
                }
    
                if($stateDataCount >=0){
    
                    $stateId  = $state->id;
                    $stateName = $state->state_name; 
    
                    $dist = [];
                    $districtName = DB::table('district')->where('state_id',$state->id)->where('status',1)->get();
                        foreach($districtName as $key1 => $district){
    
                            if( !empty($categoryId) ){
                                if($categoryId == 1){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('tractorView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('tractorView')->whereIn('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('tractorView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 3){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('goodVehicleView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('goodVehicleView')->whereIn('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('goodVehicleView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 4){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('harvesterView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('harvesterView')->whereIn('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('harvesterView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 5){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('implementView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('implementView')->whereIn('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('implementView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 7){
                                    if($type == 'old' || $type == 'new'){
                                        $districtDataCount =  DB::table('tyresView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('type',$type)->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                }
                                else if($categoryId == 6){
                                    $districtDataCount =  DB::table('seedView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 8){
                                    $districtDataCount =  DB::table('pesticidesView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 9){
                                    $districtDataCount =  DB::table('fertilizerView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 12){
                                    $districtDataCount =  DB::table('cropsView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                            }else{
                                $districtDataCount = '';
                            }
    
                            if($districtDataCount > 0){
                                $dist_id      = $district->id;
                                $dist_name    = $district->district_name;
                                $dist[] = ['dist_id'=>$dist_id,'dist_name'=>$dist_name,'item_count' => $districtDataCount]; 
                            }          
                        }  
    
                    $data[] = ['state_id'=>$stateId,'state_name' => $stateName, 'item_count'=>$stateDataCount,'dist'=> $dist];
    
                }

                if(!empty($data)){
                    $output['response'] = true;
                    $output['message']  = 'Brand Wish State Show';
                    $output['data']     = $data;
                    $output['error']    = "";
                }else{
                    $output['response'] = false;
                    $output['message']  = 'No Data Available';
                    $output['data']     = [];
    
                }
            }
        }
        else if(!empty($request->brand_id) && !empty($request->model_id)&& empty($state_id) && empty($district_id) && !empty($categoryId) && !empty($type)){
           // echo "model";

            $state_id    = $request->state_id;
            $district_id = $request->district_id;
            $brand_id    = $request->brand_id;
            $model_id    = $request->model_id;
            //print_r($model_id);

           // $stateName = DB::table('state')->where('status',1)->get();
            $stateName = DB::table('state')->where('status',1)->orderBy('id','DESC')->get();
            $data = array();
            foreach($stateName as $key => $state){
    
                if( !empty($categoryId) ){  
                    if($categoryId == 1){
                        if($type == 'rent' && empty($request->rent_type)){
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 3){
                        if($type == 'rent'){
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 4){
                        if($type == 'rent'){
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }else{
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 5){
                        if($type == 'rent'){
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 7){
                        if($type == 'old' || $type == 'new'){
                            $stateDataCount =  DB::table('tyresView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('type',$type)->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 6){
                        $stateDataCount =  DB::table('seedView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 8){
                        $stateDataCount =  DB::table('pesticidesView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 9){
                        $stateDataCount =  DB::table('fertilizerView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 12){
                        $stateDataCount =  DB::table('cropsView')->where('state_id',$state->id)->whereIn('crops_category_id',$request->crops_category_id)->whereIn('status',[1,4])->count();
                    }
                }else{
                    $stateDataCount = '';
                }
    
                if($stateDataCount >=0){
    
                    $stateId  = $state->id;
                    $stateName = $state->state_name; 
    
                    $dist = [];
                    $districtName = DB::table('district')->where('state_id',$state->id)->where('status',1)->get();
                        foreach($districtName as $key1 => $district){
    
                            if( !empty($categoryId) ){
                                if($categoryId == 1){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('tractorView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('tractorView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('tractorView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 3){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('goodVehicleView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('goodVehicleView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('goodVehicleView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 4){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('harvesterView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('harvesterView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('harvesterView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 5){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('implementView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('implementView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('implementView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 7){
                                    if($type == 'old' || $type == 'new'){
                                        $districtDataCount =  DB::table('tyresView')->whereIn('brand_id',$request->brand_id)->whereIn('model_id',$request->model_id)->where('district_id',$district->id)->where('type',$type)->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                }
                                else if($categoryId == 6){
                                    $districtDataCount =  DB::table('seedView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 8){
                                    $districtDataCount =  DB::table('pesticidesView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 9){
                                    $districtDataCount =  DB::table('fertilizerView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 12){
                                    $districtDataCount =  DB::table('cropsView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                            }else{
                                $districtDataCount = '';
                            }
    
                            if($districtDataCount > 0){
                                $dist_id      = $district->id;
                                $dist_name    = $district->district_name;
                                $dist[] = ['dist_id'=>$dist_id,'dist_name'=>$dist_name,'item_count' => $districtDataCount]; 
                            }          
                        }  
    
                    $data[] = ['state_id'=>$stateId,'state_name' => $stateName, 'item_count'=>$stateDataCount,'dist'=> $dist];
    
                }

                if(!empty($data)){
                    $output['response'] = true;
                    $output['message']  = 'Brand Wish State And District Show';
                    $output['data']     = $data;
                    $output['error']    = "";
                }else{
                    $output['response'] = false;
                    $output['message']  = 'No Data Available';
                    $output['data']     = [];
    
                }
            }
        }
        else if(empty($request->brand_id) && empty($request->model_id) && empty($state_id) && empty($district_id) && empty($type) && !empty($categoryId)  && !empty($crops_category_id)){
        //dd($crops_category_id);
           // $stateName = DB::table('state')->where('status',1)->get();
            $stateName = DB::table('state')->where('status',1)->orderBy('id','DESC')->get();
            $data = array();
            foreach($stateName as $key => $state){
                
                if( !empty($categoryId) ){  
                     
                    if($categoryId == 1){
                        if($type == 'rent' && empty($request->rent_type)){
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 3){
                        if($type == 'rent'){
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 4){
                        if($type == 'rent'){
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }else{
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 5){
                        if($type == 'rent'){
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->where('rent_type',$request->rent_type)->whereIn('brand_id',$request->brand_id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 7){
                        if($type == 'old' || $type == 'new'){
                            $stateDataCount =  DB::table('tyresView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->where('type',$type)->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 6){
                        $stateDataCount =  DB::table('seedView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 8){
                        $stateDataCount =  DB::table('pesticidesView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 9){
                        $stateDataCount =  DB::table('fertilizerView')->where('state_id',$state->id)->whereIn('brand_id',$request->brand_id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 12){
                       $cropsCategoryIds = is_array($request->crops_category_id) ? $request->crops_category_id : json_decode($request->crops_category_id, true);
                       $stateDataCount = DB::table('cropsView')->where('state_id',$state->id)->whereIn('crops_category_id',$cropsCategoryIds)->where('status',[1,4])->count();
                    }
                   
                }else{
                    $stateDataCount = '';
                }

                if($stateDataCount >=0){
    
                    $stateId  = $state->id;
                    $stateName = $state->state_name; 
    
                    $dist = [];
                    $districtName = DB::table('district')->where('state_id',$state->id)->where('status',1)->get();
                        foreach($districtName as $key1 => $district){
                            if( !empty($categoryId) ){
                                if($categoryId == 1){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('tractorView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('tractorView')->whereIn('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('tractorView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 3){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('goodVehicleView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('goodVehicleView')->whereIn('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('goodVehicleView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 4){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('harvesterView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('harvesterView')->whereIn('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('harvesterView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 5){
                                    if($type == 'rent'){
                                        $districtDataCount =  DB::table('implementView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('implementView')->whereIn('brand_id',$request->brand_id)->where('rent_type',$request->rent_type)->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('implementView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 7){
                                    if($type == 'old' || $type == 'new'){
                                        $districtDataCount =  DB::table('tyresView')->whereIn('brand_id',$request->brand_id)->where('district_id',$district->id)->where('type',$type)->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                }
                                else if($categoryId == 6){
                                    $districtDataCount =  DB::table('seedView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 8){
                                    $districtDataCount =  DB::table('pesticidesView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 9){
                                    $districtDataCount =  DB::table('fertilizerView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 12){
                                    $districtDataCount =  DB::table('cropsView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                            }else{
                                $districtDataCount = '';
                            }
    
                            if($districtDataCount > 0){
                                $dist_id      = $district->id;
                                $dist_name    = $district->district_name;
                                $dist[] = ['dist_id'=>$dist_id,'dist_name'=>$dist_name,'item_count' => $districtDataCount]; 
                            }          
                        }  
    
                    $data[] = ['state_id'=>$stateId,'state_name' => $stateName, 'item_count'=>$stateDataCount,'dist'=> $dist];
    
                }

                if(!empty($data)){
                    $output['response'] = true;
                    $output['message']  = 'Brand Wish State Show';
                    $output['data']     = $data;
                    $output['error']    = "";
                }else{
                    $output['response'] = false;
                    $output['message']  = 'No Data Available';
                    $output['data']     = [];
    
                }
            }
        }
        else{
            $stateName = DB::table('state')->where('status',1)->get();
           // dd($stateName);
            $data = array();
            foreach($stateName as $key => $state){
    
                if( !empty($categoryId) ){  
                    if($categoryId == 1){
                        if($type == 'rent' && empty($request->rent_type)){
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('tractorView')->where('rent_type',$request->rent_type)->where('state_id',$state->id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('tractorView')->where('state_id',$state->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 3){
                        if($type == 'rent' && empty($request->rent_type)){
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->where('set','rent')->whereIn('status',[1,4])->count();
    
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('goodVehicleView')->where('rent_type',$request->rent_type)->where('state_id',$state->id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('goodVehicleView')->where('state_id',$state->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 4){
                        if($type == 'rent' && empty($request->rent_type)){
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('harvesterView')->where('rent_type',$request->rent_type)->where('state_id',$state->id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('harvesterView')->where('state_id',$state->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 5){
                        if($type == 'rent' && empty($request->rent_type)){
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else if(!empty($request->rent_type) && $type == 'rent'){
                            $stateDataCount =  DB::table('implementView')->where('rent_type',$request->rent_type)->where('state_id',$state->id)->where('set','rent')->whereIn('status',[1,4])->count();
                        }
                        else{
                            $stateDataCount =  DB::table('implementView')->where('state_id',$state->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 7){
                        if($type == 'old' || $type == 'new'){
                            $stateDataCount =  DB::table('tyresView')->where('state_id',$state->id)->where('type',$type)->whereIn('status',[1,4])->count();
                        }
                    }
                    else if($categoryId == 6){
                        $stateDataCount =  DB::table('seedView')->where('state_id',$state->id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 8){
                        $stateDataCount =  DB::table('pesticidesView')->where('state_id',$state->id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 9){
                        $stateDataCount =  DB::table('fertilizerView')->where('state_id',$state->id)->whereIn('status',[1,4])->count();
                    }
                    else if($categoryId == 12){
                        //dd($state->id);
                        $stateDataCount =  DB::table('cropsView')->where('state_id',$state->id)->whereIn('status',[1,4])->count();
                    }
                }else{
                    $stateDataCount = '';
                }
    
                if($stateDataCount >= 0){
    
                    $stateId  = $state->id;
                    $stateName = $state->state_name; 

                   // dd($stateName);
    
                    $dist = [];
                    $districtName = DB::table('district')->where('state_id',$state->id)->where('status',1)->get();
                        foreach($districtName as $key1 => $district){
    
                            if( !empty($categoryId) ){
                                if($categoryId == 1){
                                    if($type == 'rent' && empty($request->rent_type)){
                                        $districtDataCount =  DB::table('tractorView')->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('tractorView')->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('tractorView')->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 3){
                                    if($type == 'rent' && empty($request->rent_type)){
                                        $districtDataCount =  DB::table('goodVehicleView')->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('goodVehicleView')->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('goodVehicleView')->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 4){
                                    
                                    if($type == 'rent' && empty($request->rent_type)){
                                        $districtDataCount =  DB::table('harvesterView')->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        
                                        $districtDataCount =  DB::table('harvesterView')->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                       // dd($type);
                                        
                                        $districtDataCount =  DB::table('harvesterView')->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                       // dd($districtDataCount);
                                    }
                                }
                                else if($categoryId == 5){
                                    if($type == 'rent' && empty($request->rent_type) ){
                                        $districtDataCount =  DB::table('implementView')->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if(!empty($request->rent_type) && $type == 'rent'){
                                        $districtDataCount =  DB::table('implementView')->where('district_id',$district->id)->where('set','rent')->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                    else{
                                        $districtDataCount =  DB::table('implementView')->where('district_id',$district->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                    }
                                }
                                else if($categoryId == 7){
                                    if($type == 'old' || $type == 'new'){
                                        $districtDataCount =  DB::table('tyresView')->where('district_id',$district->id)->where('type',$type)->whereIn('status',[1,4])->count();
                                    }
                                    else if( $type != 'rent' && isset($request->rent_type) ){
                                        return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                                    }
                                }
                                else if($categoryId == 6){
                                    $districtDataCount =  DB::table('seedView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 8){
                                    $districtDataCount =  DB::table('pesticidesView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 9){
                                    $districtDataCount =  DB::table('fertilizerView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                                else if($categoryId == 12){
                                    $districtDataCount =  DB::table('cropsView')->where('district_id',$district->id)->whereIn('status',[1,4])->count();
                                }
                            }else{
                                $districtDataCount = '';
                            }
    
                            if($districtDataCount > 0){
                                $dist_id      = $district->id;
                                $dist_name    = $district->district_name;
                                $dist[] = ['dist_id'=>$dist_id,'dist_name'=>$dist_name,'item_count' => $districtDataCount]; 
                            }          
                        }  
    
                    $data[] = ['state_id'=>$stateId,'state_name' => $stateName, 'item_count'=>$stateDataCount,'dist'=> $dist];
    
                }

                if(!empty($data)){
                    $output['response'] = true;
                    $output['message']  = ' State Show';
                    $output['data']     = $data;
                    $output['error']    = "";
                }else{
                    $output['response'] = false;
                    $output['message']  = 'No Data Available';
                    $output['data']     = [];
    
                }
            }
        }
    
        return $output;
    }
    
    public function getYear(Request $request){
        //echo "tear";

        $categoryId  = $request->category;
        $type        = $request->type;
        
        if($request->state_id == null || $request->state_id == 0){
            $state_length = 0;
        }
        else{
            $state_length  = count($request->state_id);
        }

        if($request->district_id == null || $request->district_id == 0){
            $district_length = 0;
        }
        else{
            $district_length  = count($request->state_id);
        }

        if($request->brand_id == null || $request->brand_id == 0){
            $brand_length = 0;
        }
        else{
            $brand_length  = count($request->brand_id);
        }

        if($request->model_id == null || $request->model_id == 0){
            $model_length = 0;
        }
        else{
            $model_length  = count($request->model_id);
        }

        if($state_length > 0 || $district_length > 0 || $model_length > 0 || $brand_length > 0){
           // echo $brand_length;

           // $sql1 = $sql->get();
           // $sql1_count = $sql->count();

           $year_details = DB::table('year')->where('status', 1)->get();
           foreach($year_details as $yr){
            if($request->category == 1){
               // echo "hi";
                $sql = DB::table('tractorView')->where('year_of_purchase', $yr->year)->whereIn('status',[1,4]);
            }
            else if($request->category == 3){
                $sql = DB::table('goodVehicleView')->where('year_of_purchase', $yr->year)->whereIn('status',[1,4]);
            }
            else if($request->category == 4){
                $sql = DB::table('harvesterView')->where('year_of_purchase', $yr->year)->whereIn('status',[1,4]);
            }
            else if($request->category == 5){
                $sql = DB::table('implementView')->where('year_of_purchase', $yr->year)->whereIn('status',[1,4]);
            }
            else if($request->category == 7){
                $sql = DB::table('tyresView')->where('year_of_purchase', $yr->year)->whereIn('status',[1,4]);
            }


            if (isset($request->state_id)) {
                $state          = $request->state_id;
                $state_length   = count($state);

                if($state_length > 0){
                    $sql->whereIn('state_id', $request->state_id);
                }
            }
            
            if (isset($request->district_id)) {
                $district          = $request->district_id;
                $district_length   = count($district);

                if($district_length > 0){
                    $sql->whereIn('district_id', $request->district_id);
                }
            }

            if (isset($request->brand_id) ) { 
              //  echo $request->brand_id;
                $brand          = $request->brand_id;
                $brand_length   = count($brand);
                if($brand_length > 0){
                    $sql->whereIn('brand_id', $request->brand_id);
                }
                
            }

            if (isset($request->model_id)) { 
                $model_id       = $request->model_id;
                $model_length   = count($model_id);

                if($model_length > 0){
                    $sql->whereIn('model_id', $request->model_id);
                }
            }

            if($type == 'rent'){
                $sql->where('set', $type);
            }

            if($type == 'old' || $type == 'new'){
                $sql->where('type', $type)->where('set','sell');
            }

            /** Rent Type  */
            if($type == 'rent'){
                if ($type == 'rent' && isset($request->rent_type) ) { 
                    $rent_type      = $request->rent_type;
                    if($request->rent_type == 'Per Hour'){
                        $sql->where('rent_type', 'Per Hour');
                    }
                    else if($request->rent_type == 'Per Day'){
                        $sql->where('rent_type', 'Per Day');
                    }
                    else if($request->rent_type == 'Per Month'){
                        $sql->where('rent_type', 'Per Month');
                    }
                }
            }
            else if( $type != 'rent' && isset($request->rent_type) ){
                return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
            }

            $sql1_count = $sql->count();


            $years[] = ['year' => $yr->year , 'item_count' => $sql1_count ];

            $output['response'] = true;
            $output['message']  = 'Year Data';
            $output['data']     = $years;
            $output['error']    = "";

           }
        }
        else{
           // echo "else";
            $year_details = DB::table('year')->where('status', 1)->get();
            foreach($year_details as $yr){
                if($request->category == 1){
                    //echo "hi";
                    $sql = DB::table('tractorView')->where('year_of_purchase', $yr->year)->whereIn('status',[1,4]);
                }
                else if($request->category == 3){
                    //echo "3";
                    $sql = DB::table('goodVehicleView')->where('year_of_purchase', $yr->year)->whereIn('status',[1,4]);
                }
                else if($request->category == 4){
                    $sql = DB::table('harvesterView')->where('year_of_purchase', $yr->year)->whereIn('status',[1,4]);
                }
                else if($request->category == 5){
                    $sql = DB::table('implementView')->where('year_of_purchase', $yr->year)->whereIn('status',[1,4]);
                }
                else if($request->category == 7){
                    $sql = DB::table('tyresView')->where('year_of_purchase', $yr->year)->whereIn('status',[1,4]);
                }


                if($type == 'rent'){
                    $sql->where('set', $type);
                }

                if($type == 'old' || $type == 'new'){
                    $sql->where('type', $type)->where('set','sell');
                }

                /** Rent Type  */
                if($type == 'rent'){
                    if ($type == 'rent' && isset($request->rent_type) ) { 
                        $rent_type      = $request->rent_type;
                        if($request->rent_type == 'Per Hour'){
                            $sql->where('rent_type', 'Per Hour');
                        }
                        else if($request->rent_type == 'Per Day'){
                            $sql->where('rent_type', 'Per Day');
                        }
                        else if($request->rent_type == 'Per Month'){
                            $sql->where('rent_type', 'Per Month');
                        }
                    }
                }
                else if( $type != 'rent' && isset($request->rent_type) ){
                    return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                }
 
                $sql1_count = $sql->count();
    
    
                $years[] = ['year' => $yr->year , 'item_count' => $sql1_count ];
    
                $output['response'] = true;
                $output['message']  = 'Year Data';
                $output['data']     = $years;
                $output['error']    = "";
            }
 
        }

        return $output;


    }

    public function getMaxMinPrice(Request $request){
       // dd($request->all());

        $categoryId  = $request->category;
        $type        = $request->type;

        $state_id    = $request->state_id;
        $district_id = $request->district_id;
        $brand_id    = $request->brand_id;
        $model_id    = $request->model_id;
        $year        = $request->year;
        $rent_type   = $request->rent_type;
        $crops_category_id   = $request->crops_category_id;

         

        if(!empty($request->state_id) || !empty($request->district_id) || !empty($request->brand_id)  || !empty($request->crops_category_id)){
            if($request->category == 1){
                $sql = DB::table('tractorView')->whereIn('status',[1,4]);
            }
            else if($request->category == 3){
                $sql = DB::table('goodVehicleView')->whereIn('status',[1,4]);
            }
            else if($request->category == 4){
                $sql = DB::table('harvesterView')->whereIn('status',[1,4]);
            }
            else if($request->category == 5){
                $sql = DB::table('implementView')->whereIn('status',[1,4]);
            }
            else if($request->category == 7){
                $sql = DB::table('tyresView')->whereIn('status',[1,4]);
            }
            else if($request->category == 6){
                $sql = DB::table('seedView')->whereIn('status',[1,4]);
            }
            else if($request->category == 8){
                $sql = DB::table('pesticidesView')->whereIn('status',[1,4]);
            }
            else if($request->category == 9){
                $sql = DB::table('fertilizerView')->whereIn('status',[1,4]);
            }
            else if($request->category == 12){
                $sql = DB::table('cropsView')->whereIn('status',[1,4]);
            }

           if (isset($request->crops_category_id)) {
                $crops_category_id          = $request->crops_category_id;
                $category_length   = count($crops_category_id);
                if($category_length > 0){
                    $sql->whereIn('crops_category_id', $request->crops_category_id);
                }
            }

            if (isset($request->state_id)) {
                $state          = $request->state_id;
                $state_length   = count($state);
                if($state_length > 0){
                    $sql->whereIn('state_id', $request->state_id);
                }
            }
            
            if (isset($request->district_id)) {
                $district          = $request->district_id;
                $district_length   = count($district);
                if($district_length > 0){
                    $sql->whereIn('district_id', $request->district_id);
                }
            }

            if (isset($request->brand_id)) { 
                $brand          = $request->brand_id;
                $brand_length   = count($brand);
                if($brand_length > 0){
                    $sql->whereIn('brand_id', $request->brand_id);
                }
            }

            if (isset($request->model_id)) { 
                $model_id       = $request->model_id;
                $model_length   = count($model_id);
                if($model_length > 0){
                    $sql->whereIn('model_id', $request->model_id);
                }
            }

            if (isset($request->year)) { 
                $year          = $request->year;
                $year_length   = count($year);
                if($year_length > 0){
                    $sql->whereIn('year_of_purchase', $request->year);
                }
            }

            if($type == 'rent'){
                $sql->where('set', $type);
            }

            if($type == 'old' || $type == 'new'){
                $sql->where('type', $type)->where('set','sell');
            }

            /** Rent Type  */
            if($type == 'rent'){

                if ($type == 'rent' && isset($request->rent_type) ) { 
                    $rent_type      = $request->rent_type;
                    if($request->rent_type == 'Per Hour'){
                        $sql->where('rent_type', 'Per Hour');
                    }
                    else if($request->rent_type == 'Per Day'){
                        $sql->where('rent_type', 'Per Day');
                    }
                    else if($request->rent_type == 'Per Month'){
                        $sql->where('rent_type', 'Per Month');
                    }
                }
            }
            else if( $type != 'rent' && isset($request->rent_type) ){
                return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
            }

           
            $price_count = $sql->get();
            $max         = $price_count->max('price');
            $min         = $price_count->min('price'); 

            $output['response'] = true;
            $output['message']  = 'Price Wish Data';
            $output['max']      = $max;
            $output['min']      = $min;


        }
        else{

            if($request->category == 1){
                // echo "hi";
                $sql = DB::table('tractorView')->whereIn('status',[1,4]);
            }
            else if($request->category == 3){
                $sql = DB::table('goodVehicleView')->whereIn('status',[1,4]);
            }
            else if($request->category == 4){
                $sql = DB::table('harvesterView')->whereIn('status',[1,4]);
            }
            else if($request->category == 5){
                $sql = DB::table('implementView')->whereIn('status',[1,4]);
            }
            else if($request->category == 7){
                $sql = DB::table('tyresView')->whereIn('status',[1,4]);
            }
            else if($request->category == 6){
                $sql = DB::table('seedView')->whereIn('status',[1,4]);
            }
            else if($request->category == 8){
                $sql = DB::table('pesticidesView')->whereIn('status',[1,4]);
            }
            else if($request->category == 9){
                $sql = DB::table('fertilizerView')->whereIn('status',[1,4]);
            }
            else if($request->category == 12){
                $sql = DB::table('cropsView')->whereIn('status',[1,4]);
            }



            if($type == 'rent'){
                $sql->where('set', $type);
            }

            if($type == 'old' || $type == 'new'){
                $sql->where('type', $type)->where('set','sell');
            }

            /** Rent Type  */
            if($type == 'rent'){
                if ($type == 'rent' && isset($request->rent_type) ) { 
                    $rent_type      = $request->rent_type;
                    if($request->rent_type == 'Per Hour'){
                        $sql->where('rent_type', 'Per Hour');
                    }
                    else if($request->rent_type == 'Per Day'){
                        $sql->where('rent_type', 'Per Day');
                    }
                    else if($request->rent_type == 'Per Month'){
                        $sql->where('rent_type', 'Per Month');
                    }
                }
            }

            else if( $type != 'rent' && isset($request->rent_type) ){
                return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
            }

            $price_count = $sql->get();
            $max         = $price_count->max('price');
            $min         = $price_count->min('price'); 

            $output['response'] = true;
            $output['message']  = 'Price Wish Data';
            $output['max']      = $max;
            $output['min']      = $min;

        }
        
        return $output;

    }
    
    /** Tractor Filter */
    public function tractorFilter(Request $request){
        // print_r($request->all());
 
        $categoryId       = $request->categoryId;
        $type             = $request->type;
        $userId           = $request->userId;
        $price_sort       = $request->price_sort; 
        $skip             = $request->skip;
        $take             = $request->take;

        $stateId          = $request->stateId;
        $districtId       = $request->districtId;
        $yom              = $request->yom;
        $brandId          = $request->brandId;
        $model_id         = $request->model_id;
        $min_price        = $request->min_price;
        $max_price        = $request->max_price;

        $state_length      = count($stateId);
        $district_length   = count($districtId);
        $year_of_perches   = count($yom);
        $brand_length      = count($brandId);
        $model_length      = count($model_id);
 
        if($categoryId == 1){
            if(!empty($userId)){
                $Autn = DB::table('user')->where(['id'=>$userId])->count();
                if ($Autn==0) {
                    $output['response']=false;
                    $output['message']='Authentication Failed';
                    $output['data'] = '';
                    $output['error'] = "";
                    return $output;
                    exit;
                }
                else if($type== 'new' || $type== 'old' || $type== 'rent'){
                    if($state_length > 0 || $district_length > 0 || $year_of_perches > 0 || $brand_length > 0 ||  $model_length > 0) {
            
                        $stateId        = $request->stateId;
                        $districtId     = $request->districtId;
                        $yom            = $request->yom;
                        $min_price      = $request->min_price;
                        $max_price      = $request->max_price;
                        $brandId        = $request->brandId;
                        $model_id       = $request->model_id;
                        $userId         = $request->userId;
                        $categoryId     = $request->categoryId;
                        $type           = $request->type;
                        $price_sort     = $request->price_sort; 
                        
                        // $userId         = $request->userId;
        
                        $userId       = $request->userId; 
                        $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode; 
                        $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                        $latitude    = $pindata->latitude;
                        $longitude   = $pindata->longitude;
            
                        if($categoryId == 1){                    
                            if($type == 'rent'){
                                $sql = DB::table('tractorView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(tractorView.latitude))
                                * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(tractorView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                            }else{
                                $sql = DB::table('tractorView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(tractorView.latitude))
                                * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(tractorView.latitude))) AS distance"))
                                ->where('set','sell')
                                ->whereIn('status',[1,4]);
                            }
                        }
            
                        if (isset($request->stateId)) {
                            $state          = $request->stateId;
                            $state_length   = count($state);
            
                            if($state_length > 0){
                                $sql->whereIn('state_id', $request->stateId);
                            }
                        }
            
                        if (isset($request->districtId)) {
                            $district          = $request->districtId;
                            $district_length   = count($district);
            
                            if($district_length > 0){
                                $sql->whereIn('district_id', $request->districtId);
                            }
                        }
            
                        if (isset($request->min_price)){
                            
                            $min          = $request->min_price;
                            $max          = $request->max_price;
            
                            $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                        }
            
                        if (isset($request->yom)) {
                            $length          = $request->yom;
                            $year_of_perches = count($length);
            
                            if($year_of_perches > 0){
                                $sql->whereIn('year_of_purchase', $request->yom);
                            }
                        }
            
                        if (isset($request->brandId)) { 
                            $brand          = $request->brandId;
                            $brand_length   = count($brand);
            
                            if($brand_length > 0){
                                $sql->whereIn('brand_id', $request->brandId);
                            }
                        }

                        if (isset($request->model_id)) { 
                            //echo "hi";
                            $model_id       = $request->model_id;
                            $model_length   = count($model_id);
            
                            if($model_length > 0){
                                $sql->whereIn('model_id', $request->model_id);
                            }
                        }
                    
                        /** Rent Type  */
                        if($type == 'rent'){
                            if ($type == 'rent' && isset($request->rent_type) ) { 
                                $rent_type      = $request->rent_type;
                                if($request->rent_type == 'Per Hour'){
                                    $sql->where('rent_type', 'Per Hour');
                                }
                                else if($request->rent_type == 'Per Day'){
                                    $sql->where('rent_type', 'Per Day');
                                }
                                else if($request->rent_type == 'Per Month'){
                                    $sql->where('rent_type', 'Per Month');
                                }
                            }
                        }
                        else if( $type != 'rent' && isset($request->rent_type) ){
                            return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                        }
            
                        if($type == 'rent'){
                            $sql->where('set', $type);
                        }
            
                        if($type == 'old' || $type == 'new'){
                            $sql->where('type', $type);
                        }
                        
                        /** Low To High    &&    High to low */
                        if($price_sort == 'asc' || $price_sort == 'desc'){
                            $sql->orderBy('price',$price_sort);
                        }
                        
                        /** Newest First */
                        if($price_sort == 'nf'){
                            $sql->orderBy('id','desc');
                        }
                        
                        /** Distance Wish Data Show */
                        if($price_sort == null || $price_sort ==''){
                            $sql->orderBy('distance','asc');
                        }
    
                        if(isset($skip)){
                            $sql->skip($skip);
                        }
            
                        if(isset($take)){
                            if($request->take == 0){
                                $sql->take(100000);
                            }else{
                                $sql->take($take);
                            }
                            // $sql->take($take);
                        }
            
                        $sql1 = $sql->get();
                        $sql1_count = $sql->count();
                        //print_r($sql1);
                       // return $sql1;
    
                        foreach($sql1 as $key => $s){ 
                            $output=[];
                        // $data = [];
                            $tr = $sql1->where('id',$s->id)->first();
        
                            /** Image of Tractor */
                            $left_image  = asset("storage/tractor/$tr->left_image"); 
                            $right_image = asset("storage/tractor/$tr->right_image");
                            $front_image = asset("storage/tractor/$tr->front_image");
                            $back_image  = asset("storage/tractor/$tr->back_image");
                            $meter_image = asset("storage/tractor/$tr->meter_image");
                            $tyre_image  = asset("storage/tractor/$tr->tyre_image");
        
                            /** Date of Create at */
                            $create     = $tr->created_at;
                            $newtime    = strtotime($create);
                            $created_at = date('M d, Y',$newtime);
                            
                            /** Date of Update at */
                            $update      = $tr->updated_at;
                            $newtime1    = strtotime($update);
                            $updated_at  = date('M d, Y',$newtime1);
        
                            /** Brand Name And Model Name */
                            $brand_o_n = DB::table('brand')->where(['id'=>$tr->brand_id])->value('name');
                            if ($brand_o_n=='Others') {
                                $brand_name = $tr->title;
                                $model_name = $tr->description;
                            } else {
                                $brand_arr_data = DB::table('brand')->where(['id'=>$tr->brand_id])->first();
                                $brand_name     = $brand_arr_data->name;
                                $model_arr_data = DB::table('model')->where(['id'=>$tr->model_id])->first();
                                $model_name     = $model_arr_data->model_name;
                            }
        
                            /** Distance Show */
                            $d = round($tr->distance);
                            if($d == null){
                                $distance = 0;
                            }else{
                                $distance = $d;
                            }
        
                            $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
                            $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
            
                            $tractor_array = array();
                            $boosted = Subscribed_boost::view_all_boosted_products(1,$tr->id);
                            if($boosted == 0){
                                $tractor_array['is_boosted']  = false;
                            }else if($boosted == 1){
                                $tractor_array['is_boosted']  = true;
                            }
                            $tractor_array['distance']           = $distance;

                            $user_count  = DB::table('user')->where(['id'=>$tr->user_id])->count();
                            if($user_count != null){
                                $user_details                     = DB::table('user')->where(['id'=>$tr->user_id])->first();
                                $tractor_array['user_type_id']    = $user_details->user_type_id;
                                $tractor_array['role_id']         = $user_details->role_id;
                                $tractor_array['name']            = $user_details->name;
                                $tractor_array['company_name']    = $user_details->company_name;
                                $tractor_array['mobile']          = $user_details->mobile;
                                $tractor_array['email']           = $user_details->email;
                                $tractor_array['gender']          = $user_details->gender;
                                $tractor_array['address']         = $user_details->address;
                                $tractor_array['zipcode']         = $user_details->zipcode;
                                $tractor_array['device_id']       = $user_details->device_id;
                                $tractor_array['firebase_token']  = $user_details->firebase_token;
                                $tractor_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                    $tractor_array['photo']='';
                                } else {
                                $tractor_array['photo'] = asset("storage/photo/$user_details->photo");
                                }
                            }

                            $specification=[];
                            $spec_count = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->count();
                            if ($spec_count>0) {
                                $specification_arr = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->get();
                                foreach ($specification_arr as $val_s) {
                                    $spec_name = $val_s->spec_name;
                                    $spec_value = $val_s->value;
                                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                                }
                                $tractor_array['specification'] = $specification;
                            } else {
                                $tractor_array['specification'] = '';
                            }
                            
                            $tractor_array['id']                =  $tr->id;
                            $tractor_array['city_name']         =  $tr->city_name;
                            $tractor_array['category_id']       =  $tr->category_id;
                            $tractor_array['user_id']           =  $tr->user_id;
                            $tractor_array['set']               =  $tr->set;
                            $tractor_array['type']              =  $tr->type;
                            $tractor_array['brand_id']          =  $tr->brand_id;
                            $tractor_array['model_id']          =  $tr->model_id;
                            $tractor_array['year_of_purchase']  =  $tr->year_of_purchase;
                            $tractor_array['title']             =  $tr->title;
                            $tractor_array['rc_available']      =  $tr->rc_available;
                            $tractor_array['noc_available']     =  $tr->noc_available;
                            $tractor_array['registration_no']   =  $tr->registration_no;
                            $tractor_array['description']       =  $tr->description;
                            
                            if(!empty($tr->front_image) ){
                                $tractor_array['front_image'] =  $front_image;
                            }
                            if(!empty($tr->left_image) ){
                                $tractor_array['left_image'] =  $left_image;
                            }
                            if(!empty($tr->right_image) ){
                                $tractor_array['right_image'] =  $right_image;
                            }
                            if(!empty($tr->back_image) ){
                                $tractor_array['back_image'] =  $back_image;
                            }
                            if(!empty($tr->meter_image) ){
                                $tractor_array['meter_image'] =  $meter_image;
                            }
                            if(!empty($tr->tyre_image) ){
                                $tractor_array['tyre_image'] =  $tyre_image;
                            }

                            // $tractor_array['image'] = ['front_image' => $front_image , 'left_image' => $left_image ,'right_image'=> $right_image , 'back_image' => $back_image, 'meter_image'=> $meter_image , 'tyre_image' => $tyre_image ];
                            //$tractor_array['image']  =  $img;
        
                            $tractor_array['price']                =  $tr->price;
                            $tractor_array['rent_type']            =  $tr->rent_type ;
                            $tractor_array['is_negotiable']        =  $tr->is_negotiable;
                            $tractor_array['country_id']           =  $tr->country_id;
                            $tractor_array['state_id']             =  $tr->state_id;
                            $tractor_array['district_id']          =  $tr->district_id;
                            $tractor_array['city_id']              =  $tr->city_id;
                            $tractor_array['pincode']              =  $tr->pincode;
                            $tractor_array['tractor_latlong']      =  $tr->tractor_latlong;
                            $tractor_array['ad_report']            =  $tr->ad_report;
                            $tractor_array['status']               =  $tr->status;
                            // $tractor_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                            $tractor_array['created_at']           =  $tr->created_at;
                            $tractor_array['updated_at']           =  $updated_at;
                            $tractor_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                            $tractor_array['rejected_by']          =  $tr->rejected_by;
                            $tractor_array['rejected_at']          =  $tr->rejected_at;
                            $tractor_array['approved_by']          =  $tr->approved_by;
                            $tractor_array['approved_at']          =  $tr->approved_at;
                            $tractor_array['district_name']        =  $district_name;
                            $tractor_array['brand_name']           =  $brand_name;
                            $tractor_array['model_name']           =  $model_name;
                            $tractor_array['approved_at']          =  $tr->approved_at;

                            $tractor_array['state_name']           =  $state_name;
                            $tractor_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>1,'item_id'=>$tr->id])->count();
                            $tractor_array['view_lead']            = Leads_view::where(['category_id'=>1,'post_id'=>$tr->id])->count();
                            $tractor_array['call_lead']            = Lead::where(['category_id'=>1,'post_id'=>$tr->id,'calls_status'=>1])->count();
                            $tractor_array['msg_lead']             = Lead::where(['category_id'=>1,'post_id'=>$tr->id,'messages_status'=>1])->count();

                        //     $img = ['left_image' => $left_image , 'right_image' => $right_image ,'front_image' => $front_image,'back_image'=>$back_image , 'meter_image' => $meter_image ,'tyre_image' =>$tyre_image];
            
                        //   $data[$key] = ['description' => $data1,'date'=>$date,'img' =>$img,'tractor' => $tr];
                        $data[] = $tractor_array;
        
                            $output['response']       = true;
                            $output['message']        = 'Tractor Data';
                            $output['tractor_count']  = $sql1_count;
                            $output['data']           = $data;
                            $output['error']          = "";
                        }
                        if(!empty($data)){
                            return $output;
                        }else {
                            return ['message' => 'No Data Available','data' =>[]];
                        }
                    }
                    else if(!empty($userId) && !empty($type)){
                        $userId      = $request->userId; 
                        $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                        $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                        $latitude    = $pindata->latitude;
                        $longitude   = $pindata->longitude;
    
                        $min_price      = $request->min_price;
                        $max_price      = $request->max_price;
            
                        if($categoryId == 1){
                            if($type == 'rent'){
                            //  $sql = DB::table('tractorView')->where('pincode',$pincode)->orderBy('id','desc')->whereIn('status',[1,4]);
                                $sql = DB::table('tractorView')
                                    ->select('*'
                                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                    * cos(radians(tractorView.latitude))
                                    * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                                    + sin(radians(" .$latitude. "))
                                    * sin(radians(tractorView.latitude))) AS distance"))
                                    ->whereIn('status',[1,4]);
                            }else{
                            //  echo $type;
                                $sql = DB::table('tractorView')
                                    ->select('*'
                                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                    * cos(radians(tractorView.latitude))
                                    * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                                    + sin(radians(" .$latitude. "))
                                    * sin(radians(tractorView.latitude))) AS distance"))
                                    ->where('set','sell')
                                    // ->whereBetween('price', [$request->min_price,$request->max_price])
                                    ->whereIn('status',[1,4]);
                            }
                        }
                        
                        if($type == 'rent'){
                            $sql->where('set', $type);
                        }
    
                        if($type == 'old' || $type == 'new'){
                            $sql->where('type', $type);
                        }
    
                        if (isset($request->min_price)){
                            $min          = $request->min_price;
                            $max          = $request->max_price;
            
                            $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                        }
                        
                        /** Rent Type Data Show */
                        if($type == 'rent'){
                            if ($type == 'rent' && isset($request->rent_type) ) { 
                                $rent_type      = $request->rent_type;
                                if($request->rent_type == 'Per Hour'){
                                    $sql->where('rent_type', 'Per Hour');
                                }
                                else if($request->rent_type == 'Per Day'){
                                    $sql->where('rent_type', 'Per Day');
                                }
                                else if($request->rent_type == 'Per Month'){
                                    $sql->where('rent_type', 'Per Month');
                                }
                            }
                        }
                        else if( $type != 'rent' && isset($request->rent_type) ){
                            return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                        }
            
                        /** Low To High    &&    High to low */
                        if($price_sort == 'asc' || $price_sort == 'desc'){
                            $sql->orderBy('price',$price_sort);
                        }
    
                        /** Newest First */
                        if($price_sort == 'nf'){
                            $sql->orderBy('id','desc');
                        }
                        
                        /** Distance Wish Data Show */
                        if($price_sort == null || $price_sort ==''){
                            $sql->orderBy('distance','asc');
                        }
    
                        if(isset($skip)){
                            $sql->skip($skip);
                        }
                        if(isset($take)){
                            if($request->take == 0){
                                $sql->take(100000);
                            }else{
                                $sql->take($take);
                            }
                            //$sql->take($take);
                        }
            
                        $sql1 = $sql->get();
                        $sql1_count = $sql->count();
            
                        foreach($sql1 as $key => $s){ 
                            $output=[];
                        // $data = [];
                            
                            $tr = $sql1->where('id',$s->id)->first();
        
                            /** Image of Tractor */
                            $left_image  = asset("storage/tractor/$tr->left_image"); 
                            $right_image = asset("storage/tractor/$tr->right_image");
                            $front_image = asset("storage/tractor/$tr->front_image");
                            $back_image  = asset("storage/tractor/$tr->back_image");
                            $meter_image = asset("storage/tractor/$tr->meter_image");
                            $tyre_image  = asset("storage/tractor/$tr->tyre_image");
        
                            /** Date of Create at */
                            $create     = $tr->created_at;
                            $newtime    = strtotime($create);
                            $created_at = date('M d, Y',$newtime);
                            
                            /** Date of Update at */
                            $update      = $tr->updated_at;
                            $newtime1    = strtotime($update);
                            $updated_at  = date('M d, Y',$newtime1);
        
                            /** Brand Name And Model Name */
                            $brand_o_n = DB::table('brand')->where(['id'=>$tr->brand_id])->value('name');
                            if ($brand_o_n=='Others') {
                                $brand_name = $tr->title;
                                $model_name = $tr->description;
                            } else {
                                $brand_arr_data = DB::table('brand')->where(['id'=>$tr->brand_id])->first();
                                $brand_name     = $brand_arr_data->name;
                                $model_arr_data = DB::table('model')->where(['id'=>$tr->model_id])->first();
                                $model_name     = $model_arr_data->model_name;
                            }

                            
        
                            /** Distance Show */
                            $d = round($tr->distance);
                            if($d == null){
                                $distance = 0;
                            }else{
                                $distance = $d;
                            }
        
                            /** District Name */
                            $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                            $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
        
                            $tractor_array = array();

                            $boosted = Subscribed_boost::view_all_boosted_products(1,$tr->id);
                            if($boosted == 0){
                                $tractor_array['is_boosted']  = false;
                            }else if($boosted == 1){
                                $tractor_array['is_boosted']  = true;
                            }
                            
                            $tractor_array['distance']           = $distance;
                         
                            $user_count  = DB::table('user')->where(['id'=>$tr->user_id])->count();
                            if($user_count != null){
                                $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                                $tractor_array['user_type_id']    = $user_details->user_type_id;
                                $tractor_array['role_id']         = $user_details->role_id;
                                $tractor_array['name']            = $user_details->name;
                                $tractor_array['company_name']    = $user_details->company_name;
                                $tractor_array['mobile']          = $user_details->mobile;
                                $tractor_array['email']           = $user_details->email;
                                $tractor_array['gender']          = $user_details->gender;
                                $tractor_array['address']         = $user_details->address;
                                $tractor_array['zipcode']         = $user_details->zipcode;
                                $tractor_array['device_id']       = $user_details->device_id;
                                $tractor_array['firebase_token']  = $user_details->firebase_token;
                                $tractor_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                    $tractor_array['photo']='';
                                } else {
                                $tractor_array['photo'] = asset("storage/photo/".$user_details->photo);
                                }
                            }
                         
                            $specification=[];
                            $spec_count = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->count();
                            if ($spec_count>0) {
                                $specification_arr = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->get();
                                foreach ($specification_arr as $val_s) {
                                    $spec_name = $val_s->spec_name;
                                    $spec_value = $val_s->value;
                                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                                }
                                $tractor_array['specification'] = $specification;
                            }else {
                                $tractor_array['specification'] = '';
                            }

                            $tractor_array['id']                =  $tr->id;
                            $tractor_array['city_name']         =  $tr->city_name;
                            $tractor_array['category_id']       =  $tr->category_id;
                            $tractor_array['user_id']           =  $tr->user_id;
                            $tractor_array['set']               =  $tr->set;
                            $tractor_array['type']              =  $tr->type;
                            $tractor_array['brand_id']          =  $tr->brand_id;
                            $tractor_array['model_id']          =  $tr->model_id;
                            $tractor_array['year_of_purchase']  =  $tr->year_of_purchase;
                            $tractor_array['title']             =  $tr->title;
                            $tractor_array['rc_available']      =  $tr->rc_available;
                            $tractor_array['noc_available']     =  $tr->noc_available;
                            $tractor_array['registration_no']   =  $tr->registration_no;
                            $tractor_array['description']       =  $tr->description;
                            
                            if(!empty($tr->front_image) ){
                                $tractor_array['front_image'] =  $front_image;
                            }
                            if(!empty($tr->left_image) ){
                                $tractor_array['left_image'] =  $left_image;
                            }
                            if(!empty($tr->right_image) ){
                                $tractor_array['right_image'] =  $right_image;
                            }
                            if(!empty($tr->back_image) ){
                                $tractor_array['back_image'] =  $back_image;
                            }
                            if(!empty($tr->meter_image) ){
                                $tractor_array['meter_image'] =  $meter_image;
                            }
                            if(!empty($tr->tyre_image) ){
                                $tractor_array['tyre_image'] =  $tyre_image;
                            }
    
                            // $tractor_array['image'] = ['front_image' => $front_image , 'left_image' => $left_image ,'right_image'=> $right_image , 'back_image' => $back_image, 'meter_image'=> $meter_image , 'tyre_image' => $tyre_image ];
        
                            $tractor_array['price']                =  $tr->price;
                            $tractor_array['rent_type']            =  $tr->rent_type ;
                            $tractor_array['is_negotiable']        =  $tr->is_negotiable;
                            $tractor_array['country_id']           =  $tr->country_id;
                            $tractor_array['state_id']             =  $tr->state_id;
                            $tractor_array['district_id']          =  $tr->district_id;
                            $tractor_array['city_id']              =  $tr->city_id;
                            $tractor_array['pincode']              =  $tr->pincode;
                            $tractor_array['tractor_latlong']      =  $tr->tractor_latlong;
                            $tractor_array['ad_report']            =  $tr->ad_report;
                            $tractor_array['status']               =  $tr->status;
                            // $tractor_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                            $tractor_array['created_at']           =  $tr->created_at;
                            $tractor_array['updated_at']           =  $updated_at;
                            $tractor_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                            $tractor_array['rejected_by']          =  $tr->rejected_by;
                            $tractor_array['rejected_at']          =  $tr->rejected_at;
                            $tractor_array['approved_by']          =  $tr->approved_by;
                            $tractor_array['approved_at']          =  $tr->approved_at;
                            $tractor_array['district_name']        =  $district_name;
                            $tractor_array['brand_name']           =  $brand_name;
                            $tractor_array['model_name']           =  $model_name;
                            $tractor_array['approved_at']          =  $tr->approved_at;

                            $tractor_array['state_name']           =  $state_name;
                            $tractor_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>1,'item_id'=>$tr->id])->count();
                            $tractor_array['view_lead']            = Leads_view::where(['category_id'=>1,'post_id'=>$tr->id])->count();
                            $tractor_array['call_lead']            = Lead::where(['category_id'=>1,'post_id'=>$tr->id,'calls_status'=>1])->count();
                            $tractor_array['msg_lead']             = Lead::where(['category_id'=>1,'post_id'=>$tr->id,'messages_status'=>1])->count();
            
                        //     $img = ['left_image' => $left_image , 'right_image' => $right_image ,'front_image' => $front_image,'back_image'=>$back_image , 'meter_image' => $meter_image ,'tyre_image' =>$tyre_image];
            
                        //   $data[$key] = ['description' => $data1,'date'=>$date,'img' =>$img,'tractor' => $tr];
                        $data[] = $tractor_array;
        
                            $output['response']       = true;
                            $output['message']        = 'Tractor Data';
                            $output['tractor_count']  = $sql1_count;
                            $output['data']           = $data;
                            $output['error']          = "";
                        }
                        if(!empty($data)){
                            return $output;
                        }else {
                            return ['message' => 'No Data Available','data' =>[]];
                        }
                    }
                }
                else{
                    $msg = ' please Enter Type';
                    return array('message' => $msg); 
                }
            }else{
                $msg = ' please Enter User-id';
                return array('message' => $msg); 
            }
        }else{
            $msg = ' please Enter Right Category Id';
            return array('message' => $msg); 
        }
    }
    
    /** Good Vehicle Filter */
    public function goodVehicleFilter(Request $request){
        //print_r($request->all());
 
        $categoryId       = $request->categoryId;
        $type             = $request->type;
        $userId           = $request->userId;
        $price_sort       = $request->price_sort; 
        $skip             = $request->skip;
        $take             = $request->take;

        $stateId          = $request->stateId;
        $districtId       = $request->districtId;
        $yom              = $request->yom;
        $brandId          = $request->brandId;
        $model_id         = $request->model_id;
        $min_price        = $request->min_price;
        $max_price        = $request->max_price;
        

        $state_length      = count($stateId);
        $district_length   = count($districtId);
        $year_of_perches   = count($yom);
        $brand_length      = count($brandId);
        $model_length      = count($model_id);

        if($categoryId == 3){
            if(!empty($userId)){
                $Autn = DB::table('user')->where(['id'=>$userId])->count();
                if ($Autn==0) {
                    $output['response']=false;
                    $output['message']='Authentication Failed';
                    $output['data'] = '';
                    $output['error'] = "";
                    return $output;
                    exit;
                }
                else if($type== 'new' || $type== 'old' || $type== 'rent'){
                    if($state_length > 0 || $district_length > 0 || $year_of_perches > 0 || $brand_length > 0 || $model_length > 0) {
                        //  print_r($request->all());
                  
                        $stateId        = $request->stateId;
                        $districtId     = $request->districtId;
                        $yom            = $request->yom;
                        $min_price      = $request->min_price;
                        $max_price      = $request->max_price;
                        $brandId        = $request->brandId;
                        $model_id       = $request->model_id;
                        $userId         = $request->userId;
                        $categoryId     = $request->categoryId;
                        $type           = $request->type;
                        $price_sort     = $request->price_sort; 
        
                        $userId       = $request->userId; 
                        $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode; 
                        $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                        $latitude    = $pindata->latitude;
                        $longitude   = $pindata->longitude;
              
                        if($categoryId == 3){
                            if($type == 'rent'){
                                $sql = DB::table('goodVehicleView')
                                    ->select('*'
                                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                    * cos(radians(goodVehicleView.latitude))
                                    * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                                    + sin(radians(" .$latitude. "))
                                    * sin(radians(goodVehicleView.latitude))) AS distance"))
                                    ->whereIn('status',[1,4]);
                            }else{
                                $sql = DB::table('goodVehicleView')
                                        ->select('*'
                                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                        * cos(radians(goodVehicleView.latitude))
                                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                                        + sin(radians(" .$latitude. "))
                                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                                        ->where('set','sell')
                                        ->whereIn('status',[1,4]);
                            }
                        }
              
                        if (isset($request->stateId)) {
                            $state          = $request->stateId;
                            $state_length   = count($state);
            
                            if($state_length > 0){
                                $sql->whereIn('state_id', $request->stateId);
                            }
                        }
            
                        if (isset($request->districtId)) {
                            $district          = $request->districtId;
                            $district_length   = count($district);
            
                            if($district_length > 0){
                                $sql->whereIn('district_id', $request->districtId);
                            }
                        }
            
                        if ($min_price && $max_price){
                            $min          = $request->min_price;
                            $max          = $request->max_price;
            
                            $sql->whereBetween('price', [$min,$max]); 
                        }
            
                        if (isset($request->yom)) {
                            $length          = $request->yom;
                            $year_of_perches = count($length);
            
                            if($year_of_perches > 0){
                                $sql->whereIn('year_of_purchase', $request->yom);
                            }
                        }
            
                        if (isset($request->brandId)) { 
                            $brand          = $request->brandId;
                            $brand_length   = count($brand);
            
                            if($brand_length > 0){
                                $sql->whereIn('brand_id', $request->brandId);
                            }
                        }

                        if (isset($request->model_id)) { 
                            $model_id       = $request->model_id;
                            $model_length   = count($model_id);
            
                            if($model_length > 0){
                                $sql->whereIn('model_id', $request->model_id);
                            }
                        }
            
                        if($type == 'rent'){
                            $sql->where('set', $type);
                        }
            
                        if($type == 'old' || $type == 'new'){
                            $sql->where('type', $type);
                        }
                        
                        /** Rent Type  */
                        if($type == 'rent'){
                            if ($type == 'rent' && isset($request->rent_type) ) { 
                                $rent_type      = $request->rent_type;
                                if($request->rent_type == 'Per Hour'){
                                    $sql->where('rent_type', 'Per Hour');
                                }
                                else if($request->rent_type == 'Per Day'){
                                    $sql->where('rent_type', 'Per Day');
                                }
                                else if($request->rent_type == 'Per Month'){
                                    $sql->where('rent_type', 'Per Month');
                                }
                            }
                        }
                        else if( $type != 'rent' && isset($request->rent_type) ){
                            return ['msg' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                        }
      
                        if (isset($request->min_price)){
                            $min          = $request->min_price;
                            $max          = $request->max_price;
                    
                            $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                        }
                                                                                                                                                            
                        /** Low To High    &&    High to low */
                        if($price_sort == 'asc' || $price_sort == 'desc'){
                            $sql->orderBy('price',$price_sort);
                        }

                        /** Newest First */
                        if($price_sort == 'nf'){
                            $sql->orderBy('id','desc');
                        }
                        
                        /** Distance Wish Data Show */
                        if($price_sort == null || $price_sort == ''){
                            $sql->orderBy('distance','asc');
                        }
            
                        if(isset($skip)){
                            $sql->skip($skip);
                        }
            
                        if(isset($take)){
                            if($request->take == 0){
                                $sql->take(100000);
                            }else{
                                $sql->take($take);
                            }
                           // $sql->take($take);
                        }
              
                        $sql1 = $sql->get();
                        $sql1_count = $sql->count();
                      // return $sql1;
                          
                        foreach($sql1 as $key => $s){ 
                            $output=[];
                            
                            $tr = $sql1->where('id',$s->id)->first();
        
                            /** Image of Tractor */
                            $left_image  = asset("storage/goods_vehicle/$tr->left_image"); 
                            $right_image = asset("storage/goods_vehicle/$tr->right_image");
                            $front_image = asset("storage/goods_vehicle/$tr->front_image");
                            $back_image  = asset("storage/goods_vehicle/$tr->back_image");
                            $meter_image = asset("storage/goods_vehicle/$tr->meter_image");
                            $tyre_image  = asset("storage/goods_vehicle/$tr->tyre_image");
        
                            /** Date of Create at */
                            $create     = $tr->created_at;
                            $newtime    = strtotime($create);
                            $created_at = date('M d, Y',$newtime);
                            
                            /** Date of Update at */
                            $update      = $tr->updated_at;
                            $newtime1    = strtotime($update);
                            $updated_at  = date('M d, Y',$newtime1);
        
                            /** Brand Name And Model Name */
                            $brand_o_n = DB::table('brand')->where(['id'=>$tr->brand_id])->value('name');
                            if ($brand_o_n=='Others') {
                                $brand_name = $tr->title;
                                $model_name = $tr->description;
                            } else {
                                $brand_arr_data = DB::table('brand')->where(['id'=>$tr->brand_id])->first();
                                $brand_name     = $brand_arr_data->name;
                                $model_arr_data = DB::table('model')->where(['id'=>$tr->model_id])->first();
                                $model_name     = $model_arr_data->model_name;
                            }
        
                            /** Distance Show */
                            $d = round($tr->distance);
                            if($d == null){
                                $distance = 0;
                            }else{
                                $distance = $d;
                            }
          
                            /** District Name */
                            $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                            $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
        
                            $gv_array = array();
                            $boosted = Subscribed_boost::view_all_boosted_products(3,$tr->id);
                            if($boosted == 0){
                                $gv_array['is_boosted']  = false;
                            }else if($boosted == 1){
                                $gv_array['is_boosted']  = true;
                            }
                            
                            $gv_array['distance']        =  $distance;
                            
                            $user_count                  = DB::table('user')->where(['id'=>$tr->user_id])->count();
                            if($user_count > 0){
                                $user_details                = DB::table('user')->where(['id'=>$tr->user_id])->first();
                                $gv_array['user_type_id']    = $user_details->user_type_id;
                                $gv_array['role_id']         = $user_details->role_id;
                                $gv_array['name']            = $user_details->name;
                                $gv_array['company_name']    = $user_details->company_name;
                                $gv_array['mobile']          = $user_details->mobile;
                                $gv_array['email']           = $user_details->email;
                                $gv_array['gender']          = $user_details->gender;
                                $gv_array['address']         = $user_details->address;
                                $gv_array['zipcode']         = $user_details->zipcode;
                                $gv_array['device_id']       = $user_details->device_id;
                                $gv_array['firebase_token']  = $user_details->firebase_token;
                                $gv_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                    $gv_array['photo']='';
                                } else {
                                $gv_array['photo'] = asset("storage/photo/".$user_details->photo);
                                }
                            }

                            $specification=[];
                            $spec_count = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->count();
                            if ($spec_count>0) {
                                $specification_arr = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->get();
                                foreach ($specification_arr as $val_s) {
                                    $spec_name = $val_s->spec_name;
                                    $spec_value = $val_s->value;
                                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                                }
                                $gv_array['specification'] = $specification;
                            } else {
                                $gv_array['specification'] = '';
                            }

                            $gv_array['id']                =  $tr->id;
                            $gv_array['city_name']         =  $tr->city_name;
                            $gv_array['category_id']       =  $tr->category_id;
                            $gv_array['user_id']           =  $tr->user_id;
                            $gv_array['set']               =  $tr->set;
                            $gv_array['type']              =  $tr->type;
                            $gv_array['brand_id']          =  $tr->brand_id;
                            $gv_array['model_id']          =  $tr->model_id;
                            $gv_array['year_of_purchase']  =  $tr->year_of_purchase;
                            $gv_array['title']             =  $tr->title;
                            $gv_array['rc_available']      =  $tr->rc_available;
                            $gv_array['noc_available']     =  $tr->noc_available;
                            $gv_array['registration_no']   =  $tr->registration_no;
                            $gv_array['description']       =  $tr->description;
                            
                            if(!empty($tr->front_image) ){
                                $gv_array['front_image'] =  $front_image;
                            }
                            if(!empty($tr->left_image) ){
                                $gv_array['left_image'] =  $left_image;
                            }
                            if(!empty($tr->right_image) ){
                                $gv_array['right_image'] =  $right_image;
                            } 
                            if(!empty($tr->back_image) ){
                                $gv_array['back_image'] =  $back_image;
                            }
                            if(!empty($tr->meter_image) ){
                                $gv_array['meter_image'] =  $meter_image;
                            }
                            if(!empty($tr->tyre_image) ){
                                $gv_array['tyre_image'] =  $tyre_image;
                            }
        
                            $gv_array['price']                =  $tr->price;
                            $gv_array['rent_type']            =  $tr->rent_type ;
                            $gv_array['is_negotiable']        =  $tr->is_negotiable;
                            $gv_array['country_id']           =  $tr->country_id;
                            $gv_array['state_id']             =  $tr->state_id;
                            $gv_array['district_id']          =  $tr->district_id;
                            $gv_array['city_id']              =  $tr->city_id;
                            $gv_array['pincode']              =  $tr->pincode;
                            $gv_array['gv_latlong']           =  $tr->latlong;
                            $gv_array['ad_report']            =  $tr->ad_report;
                            $gv_array['status']               =  $tr->status;
                            // $gv_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                            $gv_array['created_at']           = $tr->created_at;
                            $gv_array['updated_at']           =  $updated_at;
                            $gv_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                            $gv_array['rejected_by']          =  $tr->rejected_by;
                            $gv_array['rejected_at']          =  $tr->rejected_at;
                            $gv_array['approved_by']          =  $tr->approved_by;
                            $gv_array['approved_at']          =  $tr->approved_at;
                            $gv_array['district_name']        =  $district_name;
                            $gv_array['brand_name']           =  $brand_name;
                            $gv_array['model_name']           =  $model_name;
                            $gv_array['approved_at']          =  $tr->approved_at;
                            $gv_array['state_name']           =  $state_name;

                            $gv_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>3,'item_id'=>$tr->id])->count();
                            $gv_array['view_lead']            = Leads_view::where(['category_id'=>3,'post_id'=>$tr->id])->count();
                            $gv_array['call_lead']            = Lead::where(['category_id'=>3,'post_id'=>$tr->id,'calls_status'=>1])->count();
                            $gv_array['msg_lead']             = Lead::where(['category_id'=>3,'post_id'=>$tr->id,'messages_status'=>1])->count();
                                        
                            $data[] = $gv_array;
        
                            $output['response'] = true;
                            $output['message']  = 'Good-Vehicle Data';
                            $output['gv_count']  = $sql1_count;
                            $output['data']     = $data;
                            $output['error']    = "";
                        }
                        if(!empty($data)){
                            return $output;
                        }else {
                            return ['message' => 'No Data Available','data' =>[]];
                        }
                    }
                    else if(!empty($userId) && !empty($type)) {
                        $userId      = $request->userId; 
                        $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                        $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                        $latitude    = $pindata->latitude;
                        $longitude   = $pindata->longitude;
    
                        $min_price   = $request->min_price;
                        $max_price   = $request->max_price;
            
                        if($categoryId == 3){
                            if($type == 'rent'){
                            //  $sql = DB::table('tractorView')->where('pincode',$pincode)->orderBy('id','desc')->whereIn('status',[1,4]);
                                $sql = DB::table('goodVehicleView')
                                        ->select('*'
                                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                        * cos(radians(goodVehicleView.latitude))
                                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                                        + sin(radians(" .$latitude. "))
                                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                                        ->whereIn('status',[1,4]);
                            }else{
                            //  echo $type;
                                $sql = DB::table('goodVehicleView')
                                    ->select('*'
                                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                    * cos(radians(goodVehicleView.latitude))
                                    * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                                    + sin(radians(" .$latitude. "))
                                    * sin(radians(goodVehicleView.latitude))) AS distance"))
                                    ->where('set','sell')
                                    ->whereIn('status',[1,4]);
                            }
                        }
                        
                        if($type == 'rent'){
                            $sql->where('set', $type);
                        }
                        if($type == 'old' || $type == 'new'){
                            $sql->where('type', $type);
                        }
    
                        if (isset($request->min_price)){
                            $min          = $request->min_price;
                            $max          = $request->max_price;
                    
                            $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                        }
                          
                        /** Rent Type  */
                        if($type == 'rent'){
                            if ($type == 'rent' && isset($request->rent_type) ) { 
                                $rent_type      = $request->rent_type;
                                if($request->rent_type == 'Per Hour'){
                                    $sql->where('rent_type', 'Per Hour');
                                }
                                else if($request->rent_type == 'Per Day'){
                                    $sql->where('rent_type', 'Per Day');
                                }
                                else if($request->rent_type == 'Per Month'){
                                    $sql->where('rent_type', 'Per Month');
                                }
                            }
                        }
                        else if( $type != 'rent' && isset($request->rent_type) ){
                            return ['message' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                        }
      
                        /** Low To High    &&    High to low */
                        if($price_sort == 'asc' || $price_sort == 'desc'){
                            $sql->orderBy('price',$price_sort);
                        }

                        /** Newest First */
                        if($price_sort == 'nf'){
                            $sql->orderBy('id','desc');
                        }
      
                        /** Distance Wish Data Show */
                        if($price_sort == null || $price_sort ==''){
                            $sql->orderBy('distance','asc');
                        }
      
                        if(isset($skip)){
                            $sql->skip($skip);
                        }
                        if(isset($take)){
                            if($request->take == 0){
                                $sql->take(100000);
                            }else{
                                $sql->take($take);
                            }
                            //$sql->take($take);
                        }
              
                        $sql1 = $sql->get();
                        $sql1_count = $sql->count();
              
                        foreach($sql1 as $key => $s){ 
                            $output=[];
    
                            $tr = $sql1->where('id',$s->id)->first();
        
                            $left_image  = asset("storage/goods_vehicle/$tr->left_image"); 
                            $right_image = asset("storage/goods_vehicle/$tr->right_image");
                            $front_image = asset("storage/goods_vehicle/$tr->front_image");
                            $back_image  = asset("storage/goods_vehicle/$tr->back_image");
                            $meter_image = asset("storage/goods_vehicle/$tr->meter_image");
                            $tyre_image  = asset("storage/goods_vehicle/$tr->tyre_image");
        
                            /** Date of Create at */
                            $create     = $tr->created_at;
                            $newtime    = strtotime($create);
                            $created_at = date('M d, Y',$newtime);
                            
                            /** Date of Update at */
                            $update      = $tr->updated_at;
                            $newtime1    = strtotime($update);
                            $updated_at  = date('M d, Y',$newtime1);
        
                            /** Brand Name And Model Name */
                            $brand_o_n = DB::table('brand')->where(['id'=>$tr->brand_id])->value('name');
                            if ($brand_o_n=='Others') {
                                $brand_name = $tr->title;
                                $model_name = $tr->description;
                            } else {
                                $brand_arr_data = DB::table('brand')->where(['id'=>$tr->brand_id])->first();
                                $brand_name     = $brand_arr_data->name;
                                $model_arr_data = DB::table('model')->where(['id'=>$tr->model_id])->first();
                                $model_name     = $model_arr_data->model_name;
                            }
        
                            /** Distance Show */
                            $d = round($tr->distance);
                            if($d == null){
                                $distance = 0;
                            }else{
                                $distance = $d;
                            }
        
                            /** District Name */
                            $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                            $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
        
                            $gv_array = array();
                            
                            $gv_array['distance']          =  $distance;

                            $boosted = Subscribed_boost::view_all_boosted_products(3,$tr->id);
                            if($boosted == 0){
                                $gv_array['is_boosted']  = false;
                            }else if($boosted == 1){
                                $gv_array['is_boosted']  = true;
                            }

                            $user_count  = DB::table('user')->where(['id'=>$tr->user_id])->count();
                            if($user_count != null){
                                $user_details                = DB::table('user')->where(['id'=>$tr->user_id])->first();
                                $gv_array['user_type_id']    = $user_details->user_type_id;
                                $gv_array['role_id']         = $user_details->role_id;
                                $gv_array['name']            = $user_details->name;
                                $gv_array['company_name']    = $user_details->company_name;
                                $gv_array['mobile']          = $user_details->mobile;
                                $gv_array['email']           = $user_details->email;
                                $gv_array['gender']          = $user_details->gender;
                                $gv_array['address']         = $user_details->address;
                                $gv_array['zipcode']         = $user_details->zipcode;
                                $gv_array['device_id']       = $user_details->device_id;
                                $gv_array['firebase_token']  = $user_details->firebase_token;
                                $gv_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                    $gv_array['photo']='';
                                } else {
                                $gv_array['photo'] = asset("storage/photo/".$user_details->photo);
                                }
                            }
                            
                            $specification=[];
                            $spec_count = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->count();
                            if ($spec_count>0) {
                                $specification_arr = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->get();
                                foreach ($specification_arr as $val_s) {
                                    $spec_name = $val_s->spec_name;
                                    $spec_value = $val_s->value;
                                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                                }
                                $gv_array['specification'] = $specification;
                            } else {
                                $gv_array['specification'] = '';
                            }

                            $gv_array['id']                =  $tr->id;
                            $gv_array['city_name']         =  $tr->city_name;
                            $gv_array['category_id']       =  $tr->category_id;
                            $gv_array['user_id']           =  $tr->user_id;
                            $gv_array['set']               =  $tr->set;
                            $gv_array['type']              =  $tr->type;
                            $gv_array['brand_id']          =  $tr->brand_id;
                            $gv_array['model_id']          =  $tr->model_id;
                            $gv_array['year_of_purchase']  =  $tr->year_of_purchase;
                            $gv_array['title']             =  $tr->title;
                            $gv_array['rc_available']      =  $tr->rc_available;
                            $gv_array['noc_available']     =  $tr->noc_available;
                            $gv_array['registration_no']   =  $tr->registration_no;
                            $gv_array['description']       =  $tr->description;
                            
                            if(!empty($tr->front_image) ){
                                $gv_array['front_image'] =  $front_image;
                            }
                            if(!empty($tr->left_image) ){
                                $gv_array['left_image'] =  $left_image;
                            }
                            if(!empty($tr->right_image) ){
                                $gv_array['right_image'] =  $right_image;
                            }
                            if(!empty($tr->back_image) ){
                                $gv_array['back_image'] =  $back_image;
                            }
                            if(!empty($tr->meter_image) ){
                                $gv_array['meter_image'] =  $meter_image;
                            }
                            if(!empty($tr->tyre_image) ){
                                $gv_array['tyre_image'] =  $tyre_image;
                            }
        
                            $gv_array['price']                =  $tr->price;
                            $gv_array['rent_type']            =  $tr->rent_type ;
                            $gv_array['is_negotiable']        =  $tr->is_negotiable;
                            $gv_array['country_id']           =  $tr->country_id;
                            $gv_array['state_id']             =  $tr->state_id;
                            $gv_array['district_id']          =  $tr->district_id;
                            $gv_array['city_id']              =  $tr->city_id;
                            $gv_array['pincode']              =  $tr->pincode;
                            $gv_array['gv_latlong']           =  $tr->latlong;
                            $gv_array['ad_report']            =  $tr->ad_report;
                            $gv_array['status']               =  $tr->status;
                            // $gv_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                            $gv_array['created_at']           =  $tr->created_at;
                            $gv_array['updated_at']           =  $updated_at;
                            $gv_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                            $gv_array['rejected_by']          =  $tr->rejected_by;
                            $gv_array['rejected_at']          =  $tr->rejected_at;
                            $gv_array['approved_by']          =  $tr->approved_by;
                            $gv_array['approved_at']          =  $tr->approved_at;
                            $gv_array['district_name']        =  $district_name;
                            $gv_array['brand_name']           =  $brand_name;
                            $gv_array['model_name']           =  $model_name;
                            $gv_array['approved_at']          =  $tr->approved_at;
                            $gv_array['state_name']           =  $state_name;

                            $gv_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>3,'item_id'=>$tr->id])->count();
                            $gv_array['view_lead']            = Leads_view::where(['category_id'=>3,'post_id'=>$tr->id])->count();
                            $gv_array['call_lead']            = Lead::where(['category_id'=>3,'post_id'=>$tr->id,'calls_status'=>1])->count();
                            $gv_array['msg_lead']             = Lead::where(['category_id'=>3,'post_id'=>$tr->id,'messages_status'=>1])->count();   
                                        
                            $data[] = $gv_array;
        
                            $output['response'] = true;
                            $output['message']  = 'Good-Vehicle Data';
                            $output['gv_count']  = $sql1_count;
                            $output['data']     = $data;
                            $output['error']    = "";
                        }
                        if(!empty($data)){
                            return $output;
                        }else {
                            return ['message' => 'No Data Available','data' =>[]];
                        }
                    }
                }
                else{
                    $msg = ' please Enter Type';
                    return array('message' => $msg); 
                }
            }else{
                $msg = ' please Enter User-id';
                return array('message' => $msg); 
            }
        }else{
            $msg = ' please Enter Right Category Id';
            return array('message' => $msg); 
        }
    }
    
    /** Harvester Filter */
    public function harvesterFilter(Request $request){
        // print_r($request->all());
    
        $categoryId       = $request->categoryId;
        $type             = $request->type;
        $userId           = $request->userId;
        $price_sort       = $request->price_sort; 
        $skip             = $request->skip;
        $take             = $request->take;

        $stateId          = $request->stateId;
        $districtId       = $request->districtId;
        $yom              = $request->yom;
        $brandId          = $request->brandId;
        $model_id         = $request->model_id;

        $state_length      = count($stateId);
        $district_length   = count($districtId);
        $year_of_perches   = count($yom);
        $brand_length      = count($brandId);
        $model_length      = count($model_id);

        if($categoryId == 4){
            if(!empty($userId)){
                $Autn = DB::table('user')->where(['id'=>$userId])->count();
                if ($Autn==0) {
                    $output['response']=false;
                    $output['message']='Authentication Failed';
                    $output['data'] = '';
                    $output['error'] = "";
                    return $output;
                    exit;
                }
                else if($type== 'new' || $type== 'old' || $type== 'rent'){
                    if($state_length > 0 || $district_length > 0 || $year_of_perches > 0 || $brand_length > 0 || $model_length > 0  ) {
                
                        $stateId        = $request->stateId;
                        $districtId     = $request->districtId;
                        $yom            = $request->yom;
                        $min_price      = $request->min_price;
                        $max_price      = $request->max_price;
                        $brandId        = $request->brandId;
                        $model_id       = $request->model_id;
                        $userId         = $request->userId;
                        $categoryId     = $request->categoryId;
                        $type           = $request->type;
                        $price_sort     = $request->price_sort; 
        
                        $userId       = $request->userId; 
                        $userPinCode  = DB::table('user')->where('id',$userId)->first()->zipcode; 
                        $pindata      = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                        $latitude     = $pindata->latitude;
                        $longitude    = $pindata->longitude;
            
                        if($categoryId == 4){
                            if($type == 'rent'){
                                $sql = DB::table('harvesterView')
                                    ->select('*'
                                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                    * cos(radians(harvesterView.latitude))
                                    * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                                    + sin(radians(" .$latitude. "))
                                    * sin(radians(harvesterView.latitude))) AS distance"))
                                    ->whereIn('status',[1,4]);
                            }else{
                                $sql = DB::table('harvesterView')
                                        ->select('*'
                                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                        * cos(radians(harvesterView.latitude))
                                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                                        + sin(radians(" .$latitude. "))
                                        * sin(radians(harvesterView.latitude))) AS distance"))
                                        ->where('set','sell')
                                        ->whereIn('status',[1,4]);
                            }
                        }
            
                        if (isset($request->stateId)) {
                            $state          = $request->stateId;
                            $state_length   = count($state);
            
                            if($state_length > 0){
                                $sql->whereIn('state_id', $request->stateId);
                            }
                        }
            
                        if (isset($request->districtId)) {
                            $district          = $request->districtId;
                            $district_length   = count($district);
            
                            if($district_length > 0){
                                $sql->whereIn('district_id', $request->districtId);
                            }
                        }
            
                        if (isset($request->min_price)){
                            $min          = $request->min_price;
                            $max          = $request->max_price;
                    
                            $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                        }
            
                        if (isset($request->yom)) {
                            $length          = $request->yom;
                            $year_of_perches = count($length);
            
                            if($year_of_perches > 0){
                                $sql->whereIn('year_of_purchase', $request->yom);
                            }
                        }
            
                        if (isset($request->brandId)) { 
                            $brand          = $request->brandId;
                            $brand_length   = count($brand);
            
                            if($brand_length > 0){
                                $sql->whereIn('brand_id', $request->brandId);
                            }
                        }

                        if (isset($request->model_id)) { 
                           // echo "hi";
                            $model_id       = $request->model_id;
                            $model_length   = count($model_id);
            
                            if($model_length > 0){
                                $sql->whereIn('model_id', $request->model_id);
                            }
                        }
            
                        if($type == 'rent'){
                            $sql->where('set', $type);
                        }
            
                        if($type == 'old' || $type == 'new'){
                            $sql->where('type', $type);
                        }

                        /** Rent Type  */
                        if($type == 'rent'){
                            if ($type == 'rent' && isset($request->rent_type) ) { 
                                $rent_type      = $request->rent_type;
                                if($request->rent_type == 'Per Hour'){
                                    $sql->where('rent_type', 'Per Hour');
                                }
                                else if($request->rent_type == 'Per Day'){
                                    $sql->where('rent_type', 'Per Day');
                                }
                                else if($request->rent_type == 'Per Month'){
                                    $sql->where('rent_type', 'Per Month');
                                }
                            }
                        }
                        else if( $type != 'rent' && isset($request->rent_type) ){
                            return ['message' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                        }
                        
                        /** Low To High    &&    High to low */
                        if($price_sort == 'asc' || $price_sort == 'desc'){
                            $sql->orderBy('price',$price_sort);
                        }

                        /** Newest First */
                        if($price_sort == 'nf'){
                            $sql->orderBy('id','desc');
                        }

                        /** Distance Wish Data Show */
                        if($price_sort == null || $price_sort ==''){
                            $sql->orderBy('distance','asc');
                        }
            
                        if(isset($skip)){
                            $sql->skip($skip);
                        }
            
                        if(isset($take)){
                            if($request->take == 0){
                                $sql->take(100000);
                            }else{
                                $sql->take($take);
                            }
                            //$sql->take($take);
                        }
            
                        $sql1 = $sql->get();
                        $sql1_count = $sql->count();

                    // return $sql1;
                        
                        foreach($sql1 as $key => $s){ 
                            $output=[];
                            
                            $tr = $sql1->where('id',$s->id)->first();
        
                            $left_image  = asset("storage/harvester/$tr->left_image");
                            $right_image = asset("storage/harvester/$tr->right_image");
                            $front_image = asset("storage/harvester/$tr->front_image");
                            $back_image  = asset("storage/harvester/$tr->back_image");
        
                            /** Date of Create at */
                            $create     = $tr->created_at;
                            $newtime    = strtotime($create);
                            $created_at = date('M d, Y',$newtime);
                            
                            /** Date of Update at */
                            $update      = $tr->updated_at;
                            $newtime1    = strtotime($update);
                            $updated_at  = date('M d, Y',$newtime1);
        
                            /** Brand Name And Model Name */
                            $brand_o_n = DB::table('brand')->where(['id'=>$tr->brand_id])->value('name');
                            if ($brand_o_n=='Others') {
                                $brand_name = $tr->title;
                                $model_name = $tr->description;
                            } else {
                                $brand_arr_data = DB::table('brand')->where(['id'=>$tr->brand_id])->first();
                                $brand_name     = $brand_arr_data->name;
                                $model_arr_data = DB::table('model')->where(['id'=>$tr->model_id])->first();
                                $model_name     = $model_arr_data->model_name;
                            }
        
                            /** Distance Show */
                            $d = round($tr->distance);
                            if($d == null){
                                $distance = 0;
                            }else{
                                $distance = $d;
                            }
        
                            /** District Name */
                            $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                            $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
        
                            $hr_array = array();

                            $boosted = Subscribed_boost::view_all_boosted_products(4,$tr->id);
                            if($boosted == 0){
                                $hr_array['is_boosted']  = false;
                            }else if($boosted == 1){
                                $hr_array['is_boosted']  = true;
                            }

                            $hr_array['distance']        =  $distance;
                            
                            $user_count                  = DB::table('user')->where(['id'=>$tr->user_id])->count();
                            if($user_count > 0){
                                $user_details                = DB::table('user')->where(['id'=>$tr->user_id])->first();
                                $hr_array['user_type_id']    = $user_details->user_type_id;
                                $hr_array['role_id']         = $user_details->role_id;
                                $hr_array['name']            = $user_details->name;
                                $hr_array['company_name']    = $user_details->company_name;
                                $hr_array['mobile']          = $user_details->mobile;
                                $hr_array['email']           = $user_details->email;
                                $hr_array['gender']          = $user_details->gender;
                                $hr_array['address']         = $user_details->address;
                                $hr_array['zipcode']         = $user_details->zipcode;
                                $hr_array['device_id']       = $user_details->device_id;
                                $hr_array['firebase_token']  = $user_details->firebase_token;
                                $hr_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                    $hr_array['photo']='';
                                } else {
                                $hr_array['photo'] = asset("storage/photo/".$user_details->photo);
                                }
                            }
 
                            $specification=[];
                            $spec_count = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->count();
                            if ($spec_count>0) {
                                $specification_arr = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->get();
                                foreach ($specification_arr as $val_s) {
                                    $spec_name = $val_s->spec_name;
                                    $spec_value = $val_s->value;
                                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                                }
                                $hr_array['specification'] = $specification;
                            } else {
                                $hr_array['specification'] = '';
                            }
                            $hr_array['id']                =  $tr->id;
                            $hr_array['city_name']         =  $tr->city_name;
                            $hr_array['category_id']       =  $tr->category_id;
                            $hr_array['user_id']           =  $tr->user_id;
                            $hr_array['set']               =  $tr->set;
                            $hr_array['type']              =  $tr->type;
                            $hr_array['brand_id']          =  $tr->brand_id;
                            $hr_array['model_id']          =  $tr->model_id;
                            $hr_array['year_of_purchase']  =  $tr->year_of_purchase;
                            $hr_array['title']             =  $tr->title;
                            $hr_array['crop_type']         =  $tr->crop_type;
                            $hr_array['cutting_with']      =  $tr->cutting_with;
                            $hr_array['power_source']      =  $tr->power_source;
                            $hr_array['spec_id']           =  $tr->spec_id;
        
                            if(!empty($tr->front_image) ){
                                $hr_array['front_image'] =  $front_image;
                            }
                            if(!empty($tr->left_image) ){
                                $hr_array['left_image'] =  $left_image;
                            }
                            if(!empty($tr->right_image) ){
                                $hr_array['right_image'] =  $right_image;
                            }
                            
                            if(!empty($tr->back_image) ){
                                $hr_array['back_image'] =  $back_image;
                            }
                            
                            $hr_array['description']          =  $tr->description;
                            $hr_array['price']                =  $tr->price;
                            $hr_array['rent_type']            =  $tr->rent_type ;
                            $hr_array['is_negotiable']        =  $tr->is_negotiable;
                            $hr_array['country_id']           =  $tr->country_id;
                            $hr_array['state_id']             =  $tr->state_id;
                            $hr_array['district_id']          =  $tr->district_id;
                            $hr_array['city_id']              =  $tr->city_id;
                            $hr_array['pincode']              =  $tr->pincode;
                            $hr_array['latlong']              =  $tr->latlong;
                            $hr_array['is_featured']          =  $tr->is_featured;
                            $hr_array['valid_till']           =  $tr->valid_till;
                            $hr_array['ad_report']            =  $tr->ad_report;
                            $hr_array['status']               =  $tr->status;
                            // $hr_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                            $hr_array['created_at']           =  $tr->created_at;
                            $hr_array['updated_at']           =  $updated_at;
                            $hr_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                            $hr_array['rejected_by']          =  $tr->rejected_by;
                            $hr_array['rejected_at']          =  $tr->rejected_at;
                            $hr_array['approved_by']          =  $tr->approved_by;
                            $hr_array['approved_at']          =  $tr->approved_at;
                            $hr_array['district_name']        =  $district_name;
                            $hr_array['brand_name']           =  $brand_name;
                            $hr_array['model_name']           =  $model_name;
                            $hr_array['approved_at']          =  $tr->approved_at;
                            $hr_array['state_name']           =  $state_name;

                            $hr_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>4,'item_id'=>$tr->id])->count();
                            $hr_array['view_lead']            = Leads_view::where(['category_id'=>4,'post_id'=>$tr->id])->count();
                            $hr_array['call_lead']            = Lead::where(['category_id'=>4,'post_id'=>$tr->id,'calls_status'=>1])->count();
                            $hr_array['msg_lead']             = Lead::where(['category_id'=>4,'post_id'=>$tr->id,'messages_status'=>1])->count();   
            
                            $data[] = $hr_array;
        
                            $output['response'] = true;
                            $output['message']  = 'Harvester Data';
                            $output['harvester_count']  = $sql1_count;
                            $output['data']     = $data;
                            $output['error']    = "";
                        }
                        if(!empty($data)){
                            return $output;
                        }else {
                            return ['message' => 'No Data Available','data' =>[]];
                        }
                    }
                    else if(!empty($userId) && !empty($type)){
                       // echo "else";
            
                        $userId      = $request->userId; 
                        $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                        $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                        $latitude    = $pindata->latitude;
                        $longitude   = $pindata->longitude;

                        $min_price      = $request->min_price;
                        $max_price      = $request->max_price;
            
                        if($categoryId == 4){
                            if($type == 'rent'){
                            //  $sql = DB::table('tractorView')->where('pincode',$pincode)->orderBy('id','desc')->whereIn('status',[1,4]);
                                $sql = DB::table('harvesterView')
                                        ->select('*'
                                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                        * cos(radians(harvesterView.latitude))
                                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                                        + sin(radians(" .$latitude. "))
                                        * sin(radians(harvesterView.latitude))) AS distance"))
                                        ->whereIn('status',[1,4]);
                            }else{
                            //  echo $type;
                                $sql = DB::table('harvesterView')
                                    ->select('*'
                                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                    * cos(radians(harvesterView.latitude))
                                    * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                                    + sin(radians(" .$latitude. "))
                                    * sin(radians(harvesterView.latitude))) AS distance"))
                                    ->where('set','sell')
                                    ->whereIn('status',[1,4]);
                            }
                        }
                        
                        if($type == 'rent'){
                            $sql->where('set', $type);
                        }

                        if($type == 'old' || $type == 'new'){
                            $sql->where('type', $type);
                        }

                        if (isset($request->min_price)){
                            $min          = $request->min_price;
                            $max          = $request->max_price;
                            $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                        }

                        /** Rent Type  */
                        if($type == 'rent'){
                            if ($type == 'rent' && isset($request->rent_type) ) { 
                                $rent_type      = $request->rent_type;
                                if($request->rent_type == 'Per Hour'){
                                    $sql->where('rent_type', 'Per Hour');
                                }
                                else if($request->rent_type == 'Per Day'){
                                    $sql->where('rent_type', 'Per Day');
                                }
                                else if($request->rent_type == 'Per Month'){
                                    $sql->where('rent_type', 'Per Month');
                                }
                            }
                        }
                        else if( $type != 'rent' && isset($request->rent_type) ){
                            return ['message' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                        }

                        /** Low To High    &&    High to low */
                        if($price_sort == 'asc' || $price_sort == 'desc'){
                            $sql->orderBy('price',$price_sort);
                        }
                        
                        /** Newest First */
                        if($price_sort == 'nf'){
                            $sql->orderBy('id','desc');
                        }

                        /** Newest First */
                        if($price_sort == 'nf'){
                            $sql->orderBy('id','desc');
                        }

                        /** Distance Wish Data Show */
                        if($price_sort == null || $price_sort ==''){
                            $sql->orderBy('distance','asc');
                        }

                        if(isset($skip)){
                            $sql->skip($skip);
                        }

                        if(isset($take)){
                            if($request->take == 0){
                                $sql->take(100000);
                            }else{
                                $sql->take($take);
                            }
                           // $sql->take($take);
                        }
            
                        $sql1 = $sql->get();

                        $sql1_count = $sql->count();
            
                        foreach($sql1 as $key => $s){ 
                            $output=[];
                            
                            $tr = $sql1->where('id',$s->id)->first();
        
                            $left_image  = asset("storage/harvester/$tr->left_image");
                            $right_image = asset("storage/harvester/$tr->right_image");
                            $front_image = asset("storage/harvester/$tr->front_image");
                            $back_image  = asset("storage/harvester/$tr->back_image");
        
                            /** Date of Create at */
                            $create     = $tr->created_at;
                            $newtime    = strtotime($create);
                            $created_at = date('M d, Y',$newtime);
                            
                            /** Date of Update at */
                            $update      = $tr->updated_at;
                            $newtime1    = strtotime($update);
                            $updated_at  = date('M d, Y',$newtime1);
        
                            /** Brand Name And Model Name */
                            $brand_o_n = DB::table('brand')->where(['id'=>$tr->brand_id])->value('name');
                            if ($brand_o_n=='Others') {
                                $brand_name = $tr->title;
                                $model_name = $tr->description;
                            } else {
                                $brand_arr_data = DB::table('brand')->where(['id'=>$tr->brand_id])->first();
                                $brand_name     = $brand_arr_data->name;
                                $model_arr_data = DB::table('model')->where(['id'=>$tr->model_id])->first();
                                $model_name     = $model_arr_data->model_name;
                            }
        
                            /** Distance Show */
                            $d = round($tr->distance);
                            if($d == null){
                                $distance = 0;
                            }else{
                                $distance = $d;
                            }
        
                            /** District Name */
                            $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                            $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
        
                            $hr_array = array();

                            $boosted = Subscribed_boost::view_all_boosted_products(4,$tr->id);
                            if($boosted == 0){
                                $hr_array['is_boosted']  = false;
                            }else if($boosted == 1){
                                $hr_array['is_boosted']  = true;
                            }
                            
                            $hr_array['distance']          =  $distance;
                            
                            $user_count                  = DB::table('user')->where(['id'=>$tr->user_id])->count();
                            if($user_count > 0){
                                $user_details                = DB::table('user')->where(['id'=>$tr->user_id])->first();
                                $hr_array['user_type_id']    = $user_details->user_type_id;
                                $hr_array['role_id']         = $user_details->role_id;
                                $hr_array['name']            = $user_details->name;
                                $hr_array['company_name']    = $user_details->company_name;
                                $hr_array['mobile']          = $user_details->mobile;
                                $hr_array['email']           = $user_details->email;
                                $hr_array['gender']          = $user_details->gender;
                                $hr_array['address']         = $user_details->address;
                                $hr_array['zipcode']         = $user_details->zipcode;
                                $hr_array['device_id']       = $user_details->device_id;
                                $hr_array['firebase_token']  = $user_details->firebase_token;
                                $hr_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                    $hr_array['photo']='';
                                } else {
                                $hr_array['photo'] = asset("storage/photo/".$user_details->photo);
                                }
                            }

                            $specification=[];
                            $spec_count = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->count();
                            if ($spec_count>0) {
                                $specification_arr = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->get();
                                foreach ($specification_arr as $val_s) {
                                    $spec_name = $val_s->spec_name;
                                    $spec_value = $val_s->value;
                                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                                }
                                $hr_array['specification'] = $specification;
                            } else {
                                $hr_array['specification'] = '';
                            }
                            $hr_array['id']                =  $tr->id;
                            $hr_array['city_name']         =  $tr->city_name;
                            $hr_array['category_id']       =  $tr->category_id;
                            $hr_array['user_id']           =  $tr->user_id;
                            $hr_array['set']               =  $tr->set;
                            $hr_array['type']              =  $tr->type;
                            $hr_array['brand_id']          =  $tr->brand_id;
                            $hr_array['model_id']          =  $tr->model_id;
                            $hr_array['year_of_purchase']  =  $tr->year_of_purchase;
                            $hr_array['title']             =  $tr->title;
                            $hr_array['crop_type']         =  $tr->crop_type;
                            $hr_array['cutting_with']      =  $tr->cutting_with;
                            $hr_array['power_source']      =  $tr->power_source;
                            $hr_array['spec_id']           =  $tr->spec_id;
        
                            if(!empty($tr->front_image) ){
                                $hr_array['front_image'] =  $front_image;
                            }
                            if(!empty($tr->left_image) ){
                                $hr_array['left_image'] =  $left_image;
                            }
                            if(!empty($tr->right_image) ){
                                $hr_array['right_image'] =  $right_image;
                            }
                            if(!empty($tr->back_image) ){
                                $hr_array['back_image'] =  $back_image;
                            }
                            
                            $hr_array['description']          =  $tr->description;
                            $hr_array['price']                =  $tr->price;
                            $hr_array['rent_type']            =  $tr->rent_type ;
                            $hr_array['is_negotiable']        =  $tr->is_negotiable;
                            $hr_array['country_id']           =  $tr->country_id;
                            $hr_array['state_id']             =  $tr->state_id;
                            $hr_array['district_id']          =  $tr->district_id;
                            $hr_array['city_id']              =  $tr->city_id;
                            $hr_array['pincode']              =  $tr->pincode;
                            $hr_array['latlong']              =  $tr->latlong;
                            $hr_array['is_featured']          =  $tr->is_featured;
                            $hr_array['valid_till']           =  $tr->valid_till;
                            $hr_array['ad_report']            =  $tr->ad_report;
                            $hr_array['status']               =  $tr->status;
                            // $hr_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                            $hr_array['created_at']           =  $tr->created_at;
                            $hr_array['updated_at']           =  $updated_at;
                            $hr_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                            $hr_array['rejected_by']          =  $tr->rejected_by;
                            $hr_array['rejected_at']          =  $tr->rejected_at;
                            $hr_array['approved_by']          =  $tr->approved_by;
                            $hr_array['approved_at']          =  $tr->approved_at;
                            $hr_array['district_name']        =  $district_name;
                            $hr_array['brand_name']           =  $brand_name;
                            $hr_array['model_name']           =  $model_name;
                            $hr_array['approved_at']          =  $tr->approved_at;
                            $hr_array['state_name']           =  $state_name;

                            $hr_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>4,'item_id'=>$tr->id])->count();
                            $hr_array['view_lead']            = Leads_view::where(['category_id'=>4,'post_id'=>$tr->id])->count();
                            $hr_array['call_lead']            = Lead::where(['category_id'=>4,'post_id'=>$tr->id,'calls_status'=>1])->count();
                            $hr_array['msg_lead']             = Lead::where(['category_id'=>4,'post_id'=>$tr->id,'messages_status'=>1])->count();      
            
                            $data[] = $hr_array;
        
                            $output['response'] = true;
                            $output['message']  = 'Harvester Data';
                            $output['harvester_count']  = $sql1_count;
                            $output['data']     = $data;
                            $output['error']    = "";
                        }

                        if(!empty($data)){
                            return $output;
                        }else {
                            return ['message' => 'No Data Available','data' =>[]];
                        }
                    }
                }
                else{
                    $msg = ' please Enter Type';
                    return array('message' => $msg); 
                }
            }else{
                $msg = ' please Enter User-id';
                return array('message' => $msg); 
            }
        }else{
            $msg = ' please Enter Right Category Id';
            return array('message' => $msg); 

        } 
    }
    
    /** Implement Filter */
    public function implementFilter(Request $request){
        // print_r($request->all());
 
        $categoryId       = $request->categoryId;
        $type             = $request->type;
        $userId           = $request->userId;
        $price_sort       = $request->price_sort;
        $skip             = $request->skip;
        $take             = $request->take;

        $stateId          = $request->stateId;
        $districtId       = $request->districtId;
        $yom              = $request->yom;
        $brandId          = $request->brandId;
        $model_id         = $request->model_id;

        $state_length      = count($stateId);
        $district_length   = count($districtId);
        $year_of_perches   = count($yom);
        $brand_length      = count($brandId);
        $model_length      = count($model_id);
         
        if($categoryId == 5){
            if(!empty($userId)){
                $Autn = DB::table('user')->where(['id'=>$userId])->count();
                if ($Autn==0) {
                    $output['response']=false;
                    $output['message']='Authentication Failed';
                    $output['data'] = '';
                    $output['error'] = "";
                    return $output;
                    exit;
                }
                else if($type== 'new' || $type== 'old' || $type== 'rent'){
                    if($state_length > 0 || $district_length > 0 || $year_of_perches > 0 || $brand_length > 0 || $model_length > 0) {
                
                        $stateId        = $request->stateId;
                        $districtId     = $request->districtId;
                        $yom            = $request->yom;
                        $min_price      = $request->min_price;
                        $max_price      = $request->max_price;
                        $brandId        = $request->brandId;
                        $model_id       = $request->model_id;
                        $userId         = $request->userId;
                        $categoryId     = $request->categoryId;
                        $type           = $request->type;
                        $price_sort     = $request->price_sort;
                        // $userId         = $request->userId;
        
                        $userId       = $request->userId; 
                        $userPinCode  = DB::table('user')->where('id',$userId)->first()->zipcode; 
                        $pindata      = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                        $latitude     = $pindata->latitude;
                        $longitude    = $pindata->longitude;
            
                        if($categoryId == 5){
                            if($type == 'rent'){
                                $sql = DB::table('implementView')
                                    ->select('*'
                                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                    * cos(radians(implementView.latitude))
                                    * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                                    + sin(radians(" .$latitude. "))
                                    * sin(radians(implementView.latitude))) AS distance"))
                                    ->whereIn('status',[1,4]);
                            }else{
                                $sql = DB::table('implementView')
                                        ->select('*'
                                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                        * cos(radians(implementView.latitude))
                                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                                        + sin(radians(" .$latitude. "))
                                        * sin(radians(implementView.latitude))) AS distance"))
                                        ->where('set','sell')
                                        ->whereIn('status',[1,4]);
                            }
                        }
            
                        if (isset($request->stateId)) {
                            $state          = $request->stateId;
                            $state_length   = count($state);
            
                            if($state_length > 0){
                                $sql->whereIn('state_id', $request->stateId);
                            }
                        }
            
                        if (isset($request->districtId)) {
                            $district          = $request->districtId;
                            $district_length   = count($district);
            
                            if($district_length > 0){
                                $sql->whereIn('district_id', $request->districtId);
                            }
                        }
            
                        if (isset($request->min_price)){
                            $min          = $request->min_price;
                            $max          = $request->max_price;
                    
                            $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                        }
            
                        if (isset($request->yom)) {
                            $length          = $request->yom;
                            $year_of_perches = count($length);
            
                            if($year_of_perches > 0){
                                $sql->whereIn('year_of_purchase', $request->yom);
                            }
                        }
            
                        if (isset($request->brandId)) { 
                            $brand          = $request->brandId;
                            $brand_length   = count($brand);
            
                            if($brand_length > 0){
                                $sql->whereIn('brand_id', $request->brandId);
                            }
                        }

                        if (isset($request->model_id)) { 
                            //echo "hi";
                            $model_id       = $request->model_id;
                            $model_length   = count($model_id);
            
                            if($model_length > 0){
                                $sql->whereIn('model_id', $request->model_id);
                            }
                        }
            
                        if($type == 'rent'){
                            $sql->where('set', $type);
                        }
            
                        if($type == 'old' || $type == 'new'){
                            $sql->where('type', $type);
                        }

                        /** Rent Type  */
                        if($type == 'rent'){
                            if ($type == 'rent' && isset($request->rent_type) ) { 
                                $rent_type      = $request->rent_type;
                                if($request->rent_type == 'Per Hour'){
                                    $sql->where('rent_type', 'Per Hour');
                                }
                                else if($request->rent_type == 'Per Day'){
                                    $sql->where('rent_type', 'Per Day');
                                }
                                else if($request->rent_type == 'Per Month'){
                                    $sql->where('rent_type', 'Per Month');
                                }
                            }
                        }
                        else if( $type != 'rent' && isset($request->rent_type) ){
                            return ['message' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                        }

                        /** Low To High    &&    High to low */
                        if($price_sort == 'asc' || $price_sort == 'desc'){
                            $sql->orderBy('price',$price_sort);
                        }
                        
                        /** Newest First */
                        if($price_sort == 'nf'){
                            $sql->orderBy('id','desc');
                        }
                        
                        /** Distance Wish Data Show */
                        if($price_sort == null || $price_sort ==''){
                            $sql->orderBy('distance','asc');
                        }
            
                        if(isset($skip)){
                            $sql->skip($skip);
                        }
            
                        if(isset($take)){
                            if($request->take == 0){
                                $sql->take(100000);
                            }else{
                                $sql->take($take);
                            }
                           // $sql->take($take);
                        }
            
                        $sql1 = $sql->get();
                        $sql1_count = $sql->count();
                    // return $sql1;
                        
                        foreach($sql1 as $key => $s){ 
                            $output=[];
                            
                            $tr = $sql1->where('id',$s->id)->first();
        
                            $left_image  = asset("storage/implements/$tr->left_image");
                            $right_image = asset("storage/implements/$tr->right_image");
                            $front_image = asset("storage/implements/$tr->front_image");
                            $back_image  = asset("storage/implements/$tr->back_image");
        
                            /** Date of Create at */
                            $create     = $tr->created_at;
                            $newtime    = strtotime($create);
                            $created_at = date('M d, Y',$newtime);
                            
                            /** Date of Update at */
                            $update      = $tr->updated_at;
                            $newtime1    = strtotime($update);
                            $updated_at  = date('M d, Y',$newtime1);
        
                            /** Brand Name And Model Name */
                            $brand_o_n = DB::table('brand')->where(['id'=>$tr->brand_id])->value('name');
                            if ($brand_o_n=='Others') {
                                $brand_name = $tr->title;
                                $model_name = $tr->description;
                            } else {
                                $brand_arr_data = DB::table('brand')->where(['id'=>$tr->brand_id])->first();
                                $brand_name     = $brand_arr_data->name;
                                $model_arr_data = DB::table('model')->where(['id'=>$tr->model_id])->first();
                                $model_name     = $model_arr_data->model_name;
                            }
        
                            /** Distance Show */
                            $d = round($tr->distance);
                            if($d == null){
                                $distance = 0;
                            }else{
                                $distance = $d;
                            }
        
                            /** District Name */
                            $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                            $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
        
                            $imp_array = array();

                            $boosted = Subscribed_boost::view_all_boosted_products(5,$tr->id);
                            if($boosted == 0){
                                $imp_array['is_boosted']  = false;
                            }else if($boosted == 1){
                                $imp_array['is_boosted']  = true;
                            }
                            
                            $imp_array['distance']        =  $distance;
                            
                            $user_count                   = DB::table('user')->where(['id'=>$tr->user_id])->count();
                            if($user_count > 0){
                                $user_details                 = DB::table('user')->where(['id'=>$tr->user_id])->first();
                                $imp_array['user_type_id']    = $user_details->user_type_id;
                                $imp_array['role_id']         = $user_details->role_id;
                                $imp_array['name']            = $user_details->name;
                                $imp_array['company_name']    = $user_details->company_name;
                                $imp_array['mobile']          = $user_details->mobile;
                                $imp_array['email']           = $user_details->email;
                                $imp_array['gender']          = $user_details->gender;
                                $imp_array['address']         = $user_details->address;
                                $imp_array['zipcode']         = $user_details->zipcode;
                                $imp_array['device_id']       = $user_details->device_id;
                                $imp_array['firebase_token']  = $user_details->firebase_token;
                                $imp_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                    $imp_array['photo']='';
                                } else {
                                $imp_array['photo'] = asset("storage/photo/".$user_details->photo);
                                }
                            }

                            $specification=[];
                            $spec_count = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->count();
                            if ($spec_count>0) {
                                $specification_arr = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->get();
                                foreach ($specification_arr as $val_s) {
                                    $spec_name = $val_s->spec_name;
                                    $spec_value = $val_s->value;
                                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                                }
                                $imp_array['specification'] = $specification;
                            } else {
                                $imp_array['specification'] = '';
                            }
                            $imp_array['id']                =  $tr->id;
                            $imp_array['city_name']         =  $tr->city_name;
                            $imp_array['category_id']       =  $tr->category_id;
                            $imp_array['user_id']           =  $tr->user_id;
                            $imp_array['set']               =  $tr->set;
                            $imp_array['type']              =  $tr->type;
                            $imp_array['brand_id']          =  $tr->brand_id;
                            $imp_array['model_id']          =  $tr->model_id;
                            $imp_array['year_of_purchase']  =  $tr->year_of_purchase;
                            $imp_array['title']             =  $tr->title;
                            
                            if(!empty($tr->front_image) ){
                                $imp_array['front_image'] =  $front_image;
                            }
                            if(!empty($tr->left_image) ){
                                $imp_array['left_image'] =  $left_image;
                            }
                            if(!empty($tr->right_image) ){
                                $imp_array['right_image'] =  $right_image;
                            }
                            if(!empty($tr->back_image) ){
                                $imp_array['back_image'] =  $back_image;
                            }
        
                            $imp_array['spec_id']              =  $tr->spec_id;
                            $imp_array['description']          =  $tr->description;
                            $imp_array['price']                =  $tr->price;
                            $imp_array['rent_type']            =  $tr->rent_type ;
                            $imp_array['is_negotiable']        =  $tr->is_negotiable;
                            $imp_array['country_id']           =  $tr->country_id;
                            $imp_array['state_id']             =  $tr->state_id;
                            $imp_array['district_id']          =  $tr->district_id;
                            $imp_array['city_id']              =  $tr->city_id;
                            $imp_array['pincode']              =  $tr->pincode;
                            $imp_array['latlong']              =  $tr->latlong;
                            $imp_array['is_featured']          =  $tr->is_featured;
                            $imp_array['valid_till']           =  $tr->valid_till;
                            $imp_array['ad_report']            =  $tr->ad_report;
                            $imp_array['status']               =  $tr->status;
                            // $imp_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                            $imp_array['created_at']           =  $tr->created_at;
                            $imp_array['updated_at']           =  $updated_at;
                            $imp_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                            $imp_array['rejected_by']          =  $tr->rejected_by;
                            $imp_array['approved_by']          =  $tr->approved_by;
                            $imp_array['approved_at']          =  $tr->approved_at;
                            $imp_array['district_name']        =  $district_name;
                            $imp_array['brand_name']           =  $brand_name;
                            $imp_array['model_name']           =  $model_name;
                            $imp_array['approved_at']          =  $tr->approved_at;
                            $imp_array['state_name']           =  $state_name;

                            $imp_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>5,'item_id'=>$tr->id])->count();
                            $imp_array['view_lead']            = Leads_view::where(['category_id'=>5,'post_id'=>$tr->id])->count();
                            $imp_array['call_lead']            = Lead::where(['category_id'=>5,'post_id'=>$tr->id,'calls_status'=>1])->count();
                            $imp_array['msg_lead']             = Lead::where(['category_id'=>5,'post_id'=>$tr->id,'messages_status'=>1])->count();            
            
                            $data[] = $imp_array;
        
                            $output['response'] = true;
                            $output['message']  = 'Implement Data';
                            $output['implement_count']  = $sql1_count;
                            $output['data']     = $data;
                            $output['error']    = "";
                        }
                        if(!empty($data)){
                            return $output;
                        }else {
                            return ['message' => 'No Data Available','data' =>[]];
                        }
                    }
                    else if(!empty($userId) && !empty($type)){
            
                        $userId      = $request->userId; 
                        $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                        $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                        $latitude    = $pindata->latitude;
                        $longitude   = $pindata->longitude;

                        $min_price      = $request->min_price;
                        $max_price      = $request->max_price;
            
                        if($categoryId == 5){
                            if($type == 'rent'){
                            //  $sql = DB::table('tractorView')->where('pincode',$pincode)->orderBy('id','desc')->whereIn('status',[1,4]);
                                $sql = DB::table('implementView')
                                        ->select('*'
                                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                        * cos(radians(implementView.latitude))
                                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                                        + sin(radians(" .$latitude. "))
                                        * sin(radians(implementView.latitude))) AS distance"))
                                        ->whereIn('status',[1,4]);
                            }else{
                            //  echo $type;
                                $sql = DB::table('implementView')
                                    ->select('*'
                                    , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                    * cos(radians(implementView.latitude))
                                    * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                                    + sin(radians(" .$latitude. "))
                                    * sin(radians(implementView.latitude))) AS distance"))
                                    ->where('set','sell')
                                    ->whereIn('status',[1,4]);
                            }
                        }
                        
                        if($type == 'rent'){
                            $sql->where('set', $type);
                        }
                        if($type == 'old' || $type == 'new'){
                            $sql->where('type', $type);
                        }

                        if (isset($request->min_price)){
                            $min          = $request->min_price;
                            $max          = $request->max_price;
                    
                            $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                        }

                        /** Rent Type  */
                        if($type == 'rent'){
                            if ($type == 'rent' && isset($request->rent_type) ) { 
                                $rent_type      = $request->rent_type;
                                if($request->rent_type == 'Per Hour'){
                                    $sql->where('rent_type', 'Per Hour');
                                }
                                else if($request->rent_type == 'Per Day'){
                                    $sql->where('rent_type', 'Per Day');
                                }
                                else if($request->rent_type == 'Per Month'){
                                    $sql->where('rent_type', 'Per Month');
                                }
                            }
                        }
                        else if( $type != 'rent' && isset($request->rent_type) ){
                            return ['message' => 'Please Type Select Rent Or Deselect Rent Type','data' =>[]];
                        }

                        /** Low To High    &&    High to low */
                        if($price_sort == 'asc' || $price_sort == 'desc'){
                            $sql->orderBy('price',$price_sort);
                        }
                        
                        /** Newest First */
                        if($price_sort == 'nf'){
                            $sql->orderBy('id','desc');
                        }
                                                /** Distance Wish Data Show */
                        if($price_sort == null || $price_sort ==''){
                            $sql->orderBy('distance','asc');
                        }

                        if(isset($skip)){
                            $sql->skip($skip);
                        }
                        if(isset($take)){
                            if($request->take == 0){
                                $sql->take(100000);
                            }else{
                                $sql->take($take);
                            }
                           // $sql->take($take);
                        }
            
                        $sql1 = $sql->get();
                        $sql1_count = $sql->count();
            
                        foreach($sql1 as $key => $s){ 
                            $output=[];
                            
                            $tr = $sql1->where('id',$s->id)->first();
        
                            $left_image  = asset("storage/implements/$tr->left_image");
                            $right_image = asset("storage/implements/$tr->right_image");
                            $front_image = asset("storage/implements/$tr->front_image");
                            $back_image  = asset("storage/implements/$tr->back_image");
        
                            /** Date of Create at */
                            $create     = $tr->created_at;
                            $newtime    = strtotime($create);
                            $created_at = date('M d, Y',$newtime);
                            
                            /** Date of Update at */
                            $update      = $tr->updated_at;
                            $newtime1    = strtotime($update);
                            $updated_at  = date('M d, Y',$newtime1);
        
                            /** Brand Name And Model Name */
                            $brand_o_n = DB::table('brand')->where(['id'=>$tr->brand_id])->value('name');
                            if ($brand_o_n=='Others') {
                                $brand_name = $tr->title;
                                $model_name = $tr->description;
                            } else {
                                $brand_arr_data = DB::table('brand')->where(['id'=>$tr->brand_id])->first();
                                $brand_name     = $brand_arr_data->name;
                                $model_arr_data = DB::table('model')->where(['id'=>$tr->model_id])->first();
                                $model_name     = $model_arr_data->model_name;
                            }
        
                            /** Distance Show */
                            $d = round($tr->distance);
                            if($d == null){
                                $distance = 0;
                            }else{
                                $distance = $d;
                            }
        
                            /** District Name */
                            $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                            $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
        
                            $imp_array = array();

                            $boosted = Subscribed_boost::view_all_boosted_products(5,$tr->id);
                            if($boosted == 0){
                                $imp_array['is_boosted']  = false;
                            }else if($boosted == 1){
                                $imp_array['is_boosted']  = true;
                            }
                            
                            $imp_array['distance']        =  $distance;
                            
                            $user_count                   = DB::table('user')->where(['id'=>$tr->user_id])->count();
                            if($user_count > 0){
                                $user_details                 = DB::table('user')->where(['id'=>$tr->user_id])->first();
                                $imp_array['user_type_id']    = $user_details->user_type_id;
                                $imp_array['role_id']         = $user_details->role_id;
                                $imp_array['name']            = $user_details->name;
                                $imp_array['company_name']    = $user_details->company_name;
                                $imp_array['mobile']          = $user_details->mobile;
                                $imp_array['email']           = $user_details->email;
                                $imp_array['gender']          = $user_details->gender;
                                $imp_array['address']         = $user_details->address;
                                $imp_array['zipcode']         = $user_details->zipcode;
                                $imp_array['device_id']       = $user_details->device_id;
                                $imp_array['firebase_token']  = $user_details->firebase_token;
                                $imp_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                                if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                    $imp_array['photo']='';
                                } else {
                                $imp_array['photo'] = asset("storage/photo/".$user_details->photo);
                                }
                            }

                            $specification=[];
                            $spec_count = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->count();
                            if ($spec_count>0) {
                                $specification_arr = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->get();
                                foreach ($specification_arr as $val_s) {
                                    $spec_name = $val_s->spec_name;
                                    $spec_value = $val_s->value;
                                    $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                                }
                                $imp_array['specification'] = $specification;
                            } else {
                                $imp_array['specification'] = '';
                            }
                            $imp_array['id']                =  $tr->id;
                            $imp_array['city_name']         =  $tr->city_name;
                            $imp_array['category_id']       =  $tr->category_id;
                            $imp_array['user_id']           =  $tr->user_id;
                            $imp_array['set']               =  $tr->set;
                            $imp_array['type']              =  $tr->type;
                            $imp_array['brand_id']          =  $tr->brand_id;
                            $imp_array['model_id']          =  $tr->model_id;
                            $imp_array['year_of_purchase']  =  $tr->year_of_purchase;
                            $imp_array['title']             =  $tr->title;
                            
                            if(!empty($tr->front_image) ){
                                $imp_array['front_image'] =  $front_image;
                            }
                            if(!empty($tr->left_image) ){
                                $imp_array['left_image'] =  $left_image;
                            }
                            if(!empty($tr->right_image) ){
                                $imp_array['right_image'] =  $right_image;
                            }
                           
                            if(!empty($tr->back_image) ){
                                $imp_array['back_image'] =  $back_image;
                            }
                            
                            $imp_array['spec_id']           =  $tr->spec_id;
                            $imp_array['description']          =  $tr->description;
                            $imp_array['price']                =  $tr->price;
                            $imp_array['rent_type']            =  $tr->rent_type ;
                            $imp_array['is_negotiable']        =  $tr->is_negotiable;
                            $imp_array['country_id']           =  $tr->country_id;
                            $imp_array['state_id']             =  $tr->state_id;
                            $imp_array['district_id']          =  $tr->district_id;
                            $imp_array['city_id']              =  $tr->city_id;
                            $imp_array['pincode']              =  $tr->pincode;
                            $imp_array['latlong']              =  $tr->latlong;
                            $imp_array['is_featured']          =  $tr->is_featured;
                            $imp_array['valid_till']           =  $tr->valid_till;
                            $imp_array['ad_report']            =  $tr->ad_report;
                            $imp_array['status']               =  $tr->status;
                            // $imp_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                            $imp_array['created_at']           =  $tr->created_at;
                            $imp_array['updated_at']           =  $updated_at;
                            $imp_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                            $imp_array['rejected_by']          =  $tr->rejected_by;
                            $imp_array['approved_by']          =  $tr->approved_by;
                            $imp_array['approved_at']          =  $tr->approved_at;
                            $imp_array['district_name']        =  $district_name;
                            $imp_array['brand_name']           =  $brand_name;
                            $imp_array['model_name']           =  $model_name;
                            $imp_array['approved_at']          =  $tr->approved_at;
                            $imp_array['state_name']           =  $state_name;

                            $imp_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>5,'item_id'=>$tr->id])->count();
                            $imp_array['view_lead']            = Leads_view::where(['category_id'=>5,'post_id'=>$tr->id])->count();
                            $imp_array['call_lead']            = Lead::where(['category_id'=>5,'post_id'=>$tr->id,'calls_status'=>1])->count();
                            $imp_array['msg_lead']             = Lead::where(['category_id'=>5,'post_id'=>$tr->id,'messages_status'=>1])->count(); 
            
                            $data[] = $imp_array;
        
                            $output['response'] = true;
                            $output['message']  = 'Implement Data';
                            $output['implement_count']  = $sql1_count;
                            $output['data']     = $data;
                            $output['error']    = "";
                        }
                        if(!empty($data)){
                            return $output;
                        }else {
                            return ['message' => 'No Data Available','data' =>[]];
                        }
                    }
                }   
                else{
                    $msg = ' please Enter Type';
                    return array('message' => $msg); 
                }
            }else{
                $msg = ' please Enter User-id';
                return array('message' => $msg); 
            }
        }else{
            $msg = ' please Enter Right Category Id';
            return array('message' => $msg); 
        }
    }
    
    /** Tyres Filter */
    public function tyreFilter(Request $request){
        // print_r($request->all());
 
        $categoryId       = $request->categoryId;
        $type             = $request->type;
        $userId           = $request->userId;
        $price_sort       = $request->price_sort; 
        $skip             = $request->skip;
        $take             = $request->take;

        $stateId          = $request->stateId;
        $districtId       = $request->districtId;
        $yom              = $request->yom;
        $brandId          = $request->brandId;
        $model_id         = $request->model_id;

        $state_length      = count($stateId);
        $district_length   = count($districtId);
        $year_of_perches   = count($yom);
        $brand_length      = count($brandId);
        $model_length      = count($model_id);
         
        if($categoryId == 7){
            if(!empty($userId) && $categoryId == 7){
                $Autn = DB::table('user')->where(['id'=>$userId])->count();
                if ($Autn==0) {
                    $output['response']=false;
                    $output['message']='Authentication Failed';
                    $output['data'] = '';
                    $output['error'] = "";
                    return $output;
                    exit;
                }
                if($state_length > 0 || $district_length > 0 || $year_of_perches > 0 || $brand_length > 0 || $model_length > 0) {
            
                    $stateId        = $request->stateId;
                    $districtId     = $request->districtId;
                    $yom            = $request->yom;
                    $min_price      = $request->min_price;
                    $max_price      = $request->max_price;
                    $brandId        = $request->brandId;
                    $model_id       = $request->model_id;
                    $userId         = $request->userId;
                    $categoryId     = $request->categoryId;
                    $type           = $request->type;
                    $price_sort     = $request->price_sort; 
                    // $userId         = $request->userId;
    
                    $userId       = $request->userId; 
                    $userPinCode  = DB::table('user')->where('id',$userId)->first()->zipcode; 
                    $pindata      = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude     = $pindata->latitude;
                    $longitude    = $pindata->longitude;
        
                    if($categoryId == 7){
                        $sql = DB::table('tyresView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(tyresView.latitude))
                                * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(tyresView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }
        
                    if (isset($request->stateId)) {
                        $state          = $request->stateId;
                        $state_length   = count($state);
        
                        if($state_length > 0){
                            $sql->whereIn('state_id', $request->stateId);
                        }
                    }
        
                    if (isset($request->districtId)) {
                        $district          = $request->districtId;
                        $district_length   = count($district);
        
                        if($district_length > 0){
                            $sql->whereIn('district_id', $request->districtId);
                        }
                    }
        
                    if(isset($request->min_price)){
                        $min          = $request->min_price;
                        $max          = $request->max_price;
                
                        $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                    }
        
                    if (isset($request->yom)) {
                       // echo "year";
                        $length          = $request->yom;
                        $year_of_perches = count($length);
        
                        if($year_of_perches > 0){
                            $sql->whereIn('year_of_purchase', $request->yom);
                        }
                    }

        
                    if (isset($request->brandId)) { 
                        $brand          = $request->brandId;
                        $brand_length   = count($brand);
        
                        if($brand_length > 0){
                            $sql->whereIn('brand_id', $request->brandId);
                        }
                    }
                    
                    if (isset($request->model_id)) { 
                        $model_id       = $request->model_id;
                        $model_length   = count($model_id);
        
                        if($model_length > 0){
                            $sql->whereIn('model_id', $request->model_id);
                        }
                    }
        
                    if($type == 'old' || $type == 'new'){
                        $sql->where('type', $type);
                    }

                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }
                    
                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
        
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
        
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                       // $sql->take($take);
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
                // return $sql1;
                    
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    
                        /** Image of Tyres */
                        // $image1  = "https://krishivikas.com/storage/tyre/".$tr->image1;
                        // $image2  = "https://krishivikas.com/storage/tyre/".$tr->image2;
                        // $image3  = "https://krishivikas.com/storage/tyre/".$tr->image3;

                        $image1  = asset("storage/tyre/$tr->image1"); 
                        $image2  = asset("storage/tyre/$tr->image2"); 
                        $image3  = asset("storage/tyre/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Brand Name And Model Name */
                        $brand_o_n = DB::table('brand')->where(['id'=>$tr->brand_id])->value('name');
                        if ($brand_o_n=='Others') {
                            $brand_name = $tr->title;
                            $model_name = $tr->description;
                        } else {
                            $brand_arr_data = DB::table('brand')->where(['id'=>$tr->brand_id])->first();
                            $brand_name     = $brand_arr_data->name;
                            $model_arr_data = DB::table('model')->where(['id'=>$tr->model_id])->first();
                            $model_name     = $model_arr_data->model_name;
                        }
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                        $tyre_array = array();

                        $boosted = Subscribed_boost::view_all_boosted_products(7,$tr->id);
                        if($boosted == 0){
                            $tyre_array['is_boosted']  = false;
                        }else if($boosted == 1){
                            $tyre_array['is_boosted']  = true;
                        }
                        
                        $tyre_array['distance']        =  $distance;
                        
                        $user_count                    = DB::table('user')->where(['id'=>$tr->user_id])->count();
                        if($user_count > 0){
                            $user_details                  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                            $tyre_array['user_type_id']    = $user_details->user_type_id;
                            $tyre_array['role_id']         = $user_details->role_id;
                            $tyre_array['name']            = $user_details->name;
                            $tyre_array['company_name']    = $user_details->company_name;
                            $tyre_array['mobile']          = $user_details->mobile;
                            $tyre_array['email']           = $user_details->email;
                            $tyre_array['gender']          = $user_details->gender;
                            $tyre_array['address']         = $user_details->address;
                            $tyre_array['zipcode']         = $user_details->zipcode;
                            $tyre_array['device_id']       = $user_details->device_id;
                            $tyre_array['firebase_token']  = $user_details->firebase_token;
                            $tyre_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                            if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                $tyre_array['photo']='';
                            } else {
                            $tyre_array['photo'] = asset("storage/photo/".$user_details->photo);
                            }
                        }    

                        $specification=[];
                        $spec_count = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->count();
                        if ($spec_count>0) {
                            $specification_arr = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->get();
                            foreach ($specification_arr as $val_s) {
                                $spec_name = $val_s->spec_name;
                                $spec_value = $val_s->value;
                                $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                            }
                            $tyre_array['specification'] = $specification;
                        } else {
                            $tyre_array['specification'] = '';
                        }
                        $tyre_array['id']                =  $tr->id;
                        $tyre_array['city_name']         =  $tr->city_name;
                        $tyre_array['category_id']       =  $tr->category_id;
                        $tyre_array['user_id']           =  $tr->user_id;
                        $tyre_array['type']              =  $tr->type;
                        $tyre_array['brand_id']          =  $tr->brand_id;
                        $tyre_array['model_id']          =  $tr->model_id;
                        $tyre_array['year_of_purchase']  =  $tr->year_of_purchase;
                        $tyre_array['title']             =  $tr->title;
                        $tyre_array['position']          =  $tr->position;
                        $tyre_array['price']             =  $tr->price;
                        $tyre_array['description']       =  $tr->description;
                        
                        if(!empty($tr->image1) ){
                            $tyre_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                            $tyre_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                            $tyre_array['image3'] =  $image3;
                        }
    
                        $tyre_array['is_negotiable']        =  $tr->is_negotiable;
                        $tyre_array['country_id']           =  $tr->country_id;
                        $tyre_array['state_id']             =  $tr->state_id;
                        $tyre_array['district_id']          =  $tr->district_id;
                        $tyre_array['city_id']              =  $tr->city_id;
                        $tyre_array['pincode']              =  $tr->pincode;
                        $tyre_array['latlong']              =  $tr->latlong;
                        $tyre_array['is_featured']          =  $tr->is_featured;
                        $tyre_array['valid_till']           =  $tr->valid_till;
                        $tyre_array['ad_report']            =  $tr->ad_report;
                        $tyre_array['status']               =  $tr->status;
                        // $tyre_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                        $tyre_array['created_at']           =  $tr->created_at;
                        $tyre_array['updated_at']           =  $updated_at;
                        $tyre_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                        $tyre_array['rejected_by']          =  $tr->rejected_by;
                        $tyre_array['rejected_at']          =  $tr->rejected_at;
                        $tyre_array['approved_by']          =  $tr->approved_by;
                        $tyre_array['approved_at']          =  $tr->approved_at;
                        $tyre_array['district_name']        =  $district_name;
                        $tyre_array['brand_name']           =  $brand_name;
                        $tyre_array['model_name']           =  $model_name;
                        $tyre_array['approved_at']          =  $tr->approved_at;
                        
                        $tyre_array['state_name']           =  $state_name;
                        $tyre_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>7,'item_id'=>$tr->id])->count();
                        $tyre_array['view_lead']            = Leads_view::where(['category_id'=>7,'post_id'=>$tr->id])->count();
                        $tyre_array['call_lead']            = Lead::where(['category_id'=>7,'post_id'=>$tr->id,'calls_status'=>1])->count();
                        $tyre_array['msg_lead']             = Lead::where(['category_id'=>7,'post_id'=>$tr->id,'messages_status'=>1])->count();      
        
                        $data[] = $tyre_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Tyre Data';
                        $output['tyre_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['message' => 'No Data Available','data' =>[]];
                    }
                }
                else if(!empty($userId) && !empty($type)){
        
                    $userId      = $request->userId; 
                    $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                    $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude    = $pindata->latitude;
                    $longitude   = $pindata->longitude;

                    $min_price      = $request->min_price;
                    $max_price      = $request->max_price;
        
                    if($categoryId == 7){
                        $sql = DB::table('tyresView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(tyresView.latitude))
                                * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(tyresView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }
                    
                    if($type == 'old' || $type == 'new'){
                        $sql->where('type', $type);
                    }

                    if (isset($request->min_price)){
                        $min          = $request->min_price;
                        $max          = $request->max_price;
                
                        $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                    }

                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }
                    
                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }

                    if(isset($skip)){
                        $sql->skip($skip);
                    }

                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                       // $sql->take($take);
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
        
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    
                        /** Image of Tyres */
                        // $image1  = "https://krishivikas.com/storage/tyre/".$tr->image1;
                        // $image2  = "https://krishivikas.com/storage/tyre/".$tr->image2;
                        // $image3  = "https://krishivikas.com/storage/tyre/".$tr->image3;

                        $image1  = asset("storage/tyre/$tr->image1"); 
                        $image2  = asset("storage/tyre/$tr->image2"); 
                        $image3  = asset("storage/tyre/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Brand Name And Model Name */
                        $brand_o_n = DB::table('brand')->where(['id'=>$tr->brand_id])->value('name');
                        if ($brand_o_n=='Others') {
                            $brand_name = $tr->title;
                            $model_name = $tr->description;
                        } else {
                            $brand_arr_data = DB::table('brand')->where(['id'=>$tr->brand_id])->first();
                            $brand_name     = $brand_arr_data->name;
                            $model_arr_data = DB::table('model')->where(['id'=>$tr->model_id])->first();
                            $model_name     = $model_arr_data->model_name;
                        }
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                        $tyre_array = array();

                        $boosted = Subscribed_boost::view_all_boosted_products(7,$tr->id);
                        if($boosted == 0){
                            $tyre_array['is_boosted']  = false;
                        }else if($boosted == 1){
                            $tyre_array['is_boosted']  = true;
                        }
                        
                        $tyre_array['distance']          =  $distance;
                        
                        $user_count                      = DB::table('user')->where(['id'=>$tr->user_id])->count();
                        if($user_count > 0){
                            $user_details                  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                            $tyre_array['user_type_id']    = $user_details->user_type_id;
                            $tyre_array['role_id']         = $user_details->role_id;
                            $tyre_array['name']            = $user_details->name;
                            $tyre_array['company_name']    = $user_details->company_name;
                            $tyre_array['mobile']          = $user_details->mobile;
                            $tyre_array['email']           = $user_details->email;
                            $tyre_array['gender']          = $user_details->gender;
                            $tyre_array['address']         = $user_details->address;
                            $tyre_array['zipcode']         = $user_details->zipcode;
                            $tyre_array['device_id']       = $user_details->device_id;
                            $tyre_array['firebase_token']  = $user_details->firebase_token;
                            $tyre_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                            if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                $tyre_array['photo']='';
                            } else {
                            $tyre_array['photo'] = asset("storage/photo/".$user_details->photo);
                            }
                        }
                    
                        $specification=[];
                        $spec_count = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->count();
                        if ($spec_count>0) {
                            $specification_arr = DB::table('specifications')->where(['model_id'=>$tr->model_id,'status'=>1])->get();
                            foreach ($specification_arr as $val_s) {
                                $spec_name = $val_s->spec_name;
                                $spec_value = $val_s->value;
                                $specification[] = ['spec_name'=>$spec_name,'spec_value'=>$spec_value];
                            }
                            $tyre_array['specification'] = $specification;
                        } else {
                            $tyre_array['specification'] = '';
                        }
                    
                        $tyre_array['id']                =  $tr->id;
                        $tyre_array['city_name']         =  $tr->city_name;
                        $tyre_array['category_id']       =  $tr->category_id;
                        $tyre_array['user_id']           =  $tr->user_id;
                        $tyre_array['type']              =  $tr->type;
                        $tyre_array['brand_id']          =  $tr->brand_id;
                        $tyre_array['model_id']          =  $tr->model_id;
                        $tyre_array['year_of_purchase']  =  $tr->year_of_purchase;
                        $tyre_array['title']             =  $tr->title;
                        $tyre_array['position']          =  $tr->position;
                        $tyre_array['price']             =  $tr->price;
                        $tyre_array['description']       =  $tr->description;
                        
                        if(!empty($tr->image1) ){
                            $tyre_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                            $tyre_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                            $tyre_array['image3'] =  $image3;
                        }
    
                        $tyre_array['is_negotiable']        =  $tr->is_negotiable;
                        $tyre_array['country_id']           =  $tr->country_id;
                        $tyre_array['state_id']             =  $tr->state_id;
                        $tyre_array['district_id']          =  $tr->district_id;
                        $tyre_array['city_id']              =  $tr->city_id;
                        $tyre_array['pincode']              =  $tr->pincode;
                        $tyre_array['latlong']              =  $tr->latlong;
                        $tyre_array['is_featured']          =  $tr->is_featured;
                        $tyre_array['valid_till']           =  $tr->valid_till;
                        $tyre_array['ad_report']            =  $tr->ad_report;
                        $tyre_array['status']               =  $tr->status;
                        // $tyre_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                        $tyre_array['created_at']           =  $tr->created_at;
                        $tyre_array['updated_at']           =  $updated_at;
                        $tyre_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                        $tyre_array['rejected_by']          =  $tr->rejected_by;
                        $tyre_array['rejected_at']          =  $tr->rejected_at;
                        $tyre_array['approved_by']          =  $tr->approved_by;
                        $tyre_array['approved_at']          =  $tr->approved_at;
                        $tyre_array['district_name']        =  $district_name;
                        $tyre_array['brand_name']           =  $brand_name;
                        $tyre_array['model_name']           =  $model_name;
                        $tyre_array['approved_at']          =  $tr->approved_at;

                        $tyre_array['state_name']           =  $state_name;
                        $tyre_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>7,'item_id'=>$tr->id])->count();
                        $tyre_array['view_lead']            = Leads_view::where(['category_id'=>7,'post_id'=>$tr->id])->count();
                        $tyre_array['call_lead']            = Lead::where(['category_id'=>7,'post_id'=>$tr->id,'calls_status'=>1])->count();
                        $tyre_array['msg_lead']             = Lead::where(['category_id'=>7,'post_id'=>$tr->id,'messages_status'=>1])->count();  
        
                        $data[] = $tyre_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Tyre Data';
                        $output['tyre_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['message' => 'No Data Available','data' =>[]];
                    }
                }
            }else{
                $msg = ' please Enter User-id';
                return array('message' => $msg); 
            }

        }else{
            $msg = ' please Enter Right Category Id';
            return array('message' => $msg); 
        }
        
    }
   
    
    /** Seed Filter */
    public function seedFilter(Request $request){
        // print_r($request->all());
 
        $categoryId       = $request->categoryId;
        $userId           = $request->userId;
        $price_sort       = $request->price_sort;
        $skip             = $request->skip;
        $take             = $request->take;

        $stateId          = $request->stateId;
        $districtId       = $request->districtId;
        $min_price        = $request->min_price;
        $max_price        = $request->max_price;

        $state_length      = count($stateId);
        $district_length   = count($districtId);
         
        if($categoryId == 6){
            if(!empty($userId) && $categoryId == 6){
                $Autn = DB::table('user')->where(['id'=>$userId])->count();
                if ($Autn==0) {
                    $output['response']=false;
                    $output['message']='Authentication Failed';
                    $output['data'] = '';
                    $output['error'] = "";
                    return $output;
                    exit;
                }
                if($state_length > 0 || $district_length > 0) {
            
                    $stateId        = $request->stateId;
                    $districtId     = $request->districtId;
                    $min_price      = $request->min_price;
                    $max_price      = $request->max_price;
                    $userId         = $request->userId;
                    $categoryId     = $request->categoryId;
                    $price_sort     = $request->price_sort;
    
                    $userId       = $request->userId; 
                    $userPinCode  = DB::table('user')->where('id',$userId)->first()->zipcode; 
                    $pindata      = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude     = $pindata->latitude;
                    $longitude    = $pindata->longitude;
        
                    if($categoryId == 6){
                        $sql = DB::table('seedView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(seedView.latitude))
                                * cos(radians(seedView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(seedView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }
        
                    if (isset($request->stateId)) {
                        $state          = $request->stateId;
                        $state_length   = count($state);
        
                        if($state_length > 0){
                            $sql->whereIn('state_id', $request->stateId);
                        }
                    }
        
                    if (isset($request->districtId)) {
                        $district          = $request->districtId;
                        $district_length   = count($district);
        
                        if($district_length > 0){
                            $sql->whereIn('district_id', $request->districtId);
                        }
                    }
        
                    if (isset($request->min_price)){
                        $min          = $request->min_price;
                        $max          = $request->max_price;
                
                        $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['message' => 'Deselect Type','data' =>[]];
                    }
        
                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }

                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
        
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
        
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                       // $sql->take($take);
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
                    
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    
                        $image1  = asset("storage/seeds/$tr->image1"); 
                        $image2  = asset("storage/seeds/$tr->image2"); 
                        $image3  = asset("storage/seeds/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                        $seed_array = array();

                        $boosted = Subscribed_boost::view_all_boosted_products(6,$tr->id);
                        if($boosted == 0){
                            $seed_array['is_boosted']  = false;
                        }else if($boosted == 1){
                            $seed_array['is_boosted']  = true;
                        }
                        $seed_array['distance']         =  $distance;
                        
                        $user_count                     = DB::table('user')->where(['id'=>$tr->user_id])->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                            $seed_array['user_type_id']    = $user_details->user_type_id;
                            $seed_array['role_id']         = $user_details->role_id;
                            $seed_array['name']            = $user_details->name;
                            $seed_array['company_name']    = $user_details->company_name;
                            $seed_array['mobile']          = $user_details->mobile;
                            $seed_array['email']           = $user_details->email;
                            $seed_array['gender']          = $user_details->gender;
                            $seed_array['address']         = $user_details->address;
                            $seed_array['zipcode']         = $user_details->zipcode;
                            $seed_array['device_id']       = $user_details->device_id;
                            $seed_array['firebase_token']  = $user_details->firebase_token;
                            $seed_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                            if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                $seed_array['photo']='';
                            } else {
                            $seed_array['photo'] = asset("storage/photo/".$user_details->photo);
                            }
                        }

                        $seed_array['id']           =  $tr->id;
                        $seed_array['city_name']         =  $tr->city_name;
                        $seed_array['category_id']       =  $tr->category_id;
                        $seed_array['user_id']           =  $tr->user_id;
                        $seed_array['title']             =  $tr->title;
                        $seed_array['description']       =  $tr->description;
                        $seed_array['price']             =  $tr->price;
                        $seed_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                            $seed_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                            $seed_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                            $seed_array['image3'] =  $image3;
                        }

                        $seed_array['country_id']           =  $tr->country_id;
                        $seed_array['state_id']             =  $tr->state_id;
                        $seed_array['district_id']          =  $tr->district_id;
                        $seed_array['city_id']              =  $tr->city_id;
                        $seed_array['pincode']              =  $tr->pincode;
                        $seed_array['latlong']              =  $tr->latlong;
                        $seed_array['is_featured']          =  $tr->is_featured;
                        $seed_array['valid_till']           =  $tr->valid_till;
                        $seed_array['ad_report']            =  $tr->ad_report;
                        $seed_array['status']               =  $tr->status;
                        // $seed_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                        $seed_array['created_at']           =  $tr->created_at;
                        $seed_array['updated_at']           =  $updated_at;
                        $seed_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                        $seed_array['rejected_by']          =  $tr->rejected_by;
                        $seed_array['rejected_at']          =  $tr->rejected_at;
                        $seed_array['approved_by']          =  $tr->approved_by;
                        $seed_array['approved_at']          =  $tr->approved_at;
                        $seed_array['district_name']        =  $district_name;

                        $seed_array['state_name']           =  $state_name;
                        $seed_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>6,'item_id'=>$tr->id])->count();
                        $seed_array['view_lead']            = Leads_view::where(['category_id'=>6,'post_id'=>$tr->id])->count();
                        $seed_array['call_lead']            = Lead::where(['category_id'=>6,'post_id'=>$tr->id,'calls_status'=>1])->count();
                        $seed_array['msg_lead']             = Lead::where(['category_id'=>6,'post_id'=>$tr->id,'messages_status'=>1])->count();  

                        $data[] = $seed_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Seeds Data';
                        $output['seed_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['message' => 'No Data Available','data' =>[]];
                    }
                    
                }
                else if(!empty($userId)){
        
                    $userId      = $request->userId; 
                    $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                    $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude    = $pindata->latitude;
                    $longitude   = $pindata->longitude;
        
                    if($categoryId == 6){
                        $sql = DB::table('seedView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(seedView.latitude))
                                * cos(radians(seedView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(seedView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }

                    if (isset($request->min_price)){
                            $min          = $request->min_price;
                            $max          = $request->max_price;
                    
                            $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['msg' => 'Deselect Type','data' =>[]];
                    }

                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }

                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
                    
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
                    if(isset($take)){
                         if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                       // $sql->take($take);
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
        
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    

                        $image1  = asset("storage/seeds/$tr->image1"); 
                        $image2  = asset("storage/seeds/$tr->image2"); 
                        $image3  = asset("storage/seeds/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                        $seed_array = array();

                        $boosted = Subscribed_boost::view_all_boosted_products(6,$tr->id);
                        if($boosted == 0){
                            $seed_array['is_boosted']  = false;
                        }else if($boosted == 1){
                            $seed_array['is_boosted']  = true;
                        }
                        
                        $seed_array['distance']          =  $distance;
                        
                        $user_count                     = DB::table('user')->where(['id'=>$tr->user_id])->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                            $seed_array['user_type_id']    = $user_details->user_type_id;
                            $seed_array['role_id']         = $user_details->role_id;
                            $seed_array['name']            = $user_details->name;
                            $seed_array['company_name']    = $user_details->company_name;
                            $seed_array['mobile']          = $user_details->mobile;
                            $seed_array['email']           = $user_details->email;
                            $seed_array['gender']          = $user_details->gender;
                            $seed_array['address']         = $user_details->address;
                            $seed_array['zipcode']         = $user_details->zipcode;
                            $seed_array['device_id']       = $user_details->device_id;
                            $seed_array['firebase_token']  = $user_details->firebase_token;
                            $seed_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                            if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                $seed_array['photo']='';
                            } else {
                            $seed_array['photo'] = asset("storage/photo/".$user_details->photo);
                            }
                        }

                        $seed_array['id']                =  $tr->id;
                        $seed_array['city_name']         =  $tr->city_name;
                        $seed_array['category_id']       =  $tr->category_id;
                        $seed_array['user_id']           =  $tr->user_id;
                        $seed_array['title']             =  $tr->title;
                        $seed_array['description']       =  $tr->description;
                        $seed_array['price']             =  $tr->price;
                        $seed_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                            $seed_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                            $seed_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                            $seed_array['image3'] =  $image3;
                        }

                        $seed_array['country_id']           =  $tr->country_id;
                        $seed_array['state_id']             =  $tr->state_id;
                        $seed_array['district_id']          =  $tr->district_id;
                        $seed_array['city_id']              =  $tr->city_id;
                        $seed_array['pincode']              =  $tr->pincode;
                        $seed_array['latlong']              =  $tr->latlong;
                        $seed_array['is_featured']          =  $tr->is_featured;
                        $seed_array['valid_till']           =  $tr->valid_till;
                        $seed_array['ad_report']            =  $tr->ad_report;
                        $seed_array['status']               =  $tr->status;
                        // $seed_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                        $seed_array['created_at']           =  $tr->created_at;
                        $seed_array['updated_at']           =  $updated_at;
                        $seed_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                        $seed_array['rejected_by']          =  $tr->rejected_by;
                        $seed_array['rejected_at']          =  $tr->rejected_at;
                        $seed_array['approved_by']          =  $tr->approved_by;
                        $seed_array['approved_at']          =  $tr->approved_at;
                        $seed_array['district_name']        =  $district_name;

                        $seed_array['state_name']           =  $state_name;
                        $seed_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>6,'item_id'=>$tr->id])->count();
                        $seed_array['view_lead']            = Leads_view::where(['category_id'=>6,'post_id'=>$tr->id])->count();
                        $seed_array['call_lead']            = Lead::where(['category_id'=>6,'post_id'=>$tr->id,'calls_status'=>1])->count();
                        $seed_array['msg_lead']             = Lead::where(['category_id'=>6,'post_id'=>$tr->id,'messages_status'=>1])->count();    

                        $data[] = $seed_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Seeds Data';
                        $output['seed_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['message' => 'No Data Available','data' =>[]];
                    }
                }
            }else{
                $msg = ' please Enter User-id';
                return array('message' => $msg); 
            }

        }else{
            $msg = ' please Enter Right Category Id';
            return array('message' => $msg); 
        }
        
    }

    
    /** Pesticides Filter */
    public function pesticidesFilter(Request $request){
        // print_r($request->all());
 
        $categoryId       = $request->categoryId;
        $userId           = $request->userId;
        $price_sort       = $request->price_sort;
        $skip             = $request->skip;
        $take             = $request->take;

        $stateId          = $request->stateId;
        $districtId       = $request->districtId;
        $min_price        = $request->min_price;
        $max_price        = $request->max_price;

        $state_length      = count($stateId);
        $district_length   = count($districtId);
         
        if($categoryId == 8){
            if(!empty($userId) && $categoryId == 8){
                $Autn = DB::table('user')->where(['id'=>$userId])->count();
                if ($Autn==0) {
                    $output['response']=false;
                    $output['message']='Authentication Failed';
                    $output['data'] = '';
                    $output['error'] = "";
                    return $output;
                    exit;
                }
                if($state_length > 0 || $district_length > 0) {
            
                    $stateId        = $request->stateId;
                    $districtId     = $request->districtId;
                    $min_price      = $request->min_price;
                    $max_price      = $request->max_price;
                    $userId         = $request->userId;
                    $categoryId     = $request->categoryId;
                    $price_sort     = $request->price_sort;
    
                    $userId       = $request->userId; 
                    $userPinCode  = DB::table('user')->where('id',$userId)->first()->zipcode; 
                    $pindata      = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude     = $pindata->latitude;
                    $longitude    = $pindata->longitude;
        
                    if($categoryId == 8){
                        $sql = DB::table('pesticidesView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(pesticidesView.latitude))
                                * cos(radians(pesticidesView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(pesticidesView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }
        
                    if (isset($request->stateId)) {
                        $state          = $request->stateId;
                        $state_length   = count($state);
        
                        if($state_length > 0){
                            $sql->whereIn('state_id', $request->stateId);
                        }
                    }
        
                    if (isset($request->districtId)) {
                        $district          = $request->districtId;
                        $district_length   = count($district);
        
                        if($district_length > 0){
                            $sql->whereIn('district_id', $request->districtId);
                        }
                    }
        
                    if (isset($request->min_price)){
                        $min          = $request->min_price;
                        $max          = $request->max_price;
                
                        $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['message' => 'Deselect Type','data' =>[]];
                    }
        
                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }

                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
        
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
        
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                       // $sql->take($take);
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
                    
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    

                        $image1  = asset("storage/pesticides/$tr->image1"); 
                        $image2  = asset("storage/pesticides/$tr->image2"); 
                        $image3  = asset("storage/pesticides/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                       $pesticide_array = array();

                       $boosted = Subscribed_boost::view_all_boosted_products(8,$tr->id);
                        if($boosted == 0){
                            $pesticide_array['is_boosted']  = false;
                        }else if($boosted == 1){
                            $pesticide_array['is_boosted']  = true;
                        }
                        
                       $pesticide_array['distance']          =  $distance;
                       
                       $user_count                     = DB::table('user')->where(['id'=>$tr->user_id])->count();
                       if($user_count > 0){
                           $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                           $pesticide_array['user_type_id']    = $user_details->user_type_id;
                           $pesticide_array['role_id']         = $user_details->role_id;
                           $pesticide_array['name']            = $user_details->name;
                           $pesticide_array['company_name']    = $user_details->company_name;
                           $pesticide_array['mobile']          = $user_details->mobile;
                           $pesticide_array['email']           = $user_details->email;
                           $pesticide_array['gender']          = $user_details->gender;
                           $pesticide_array['address']         = $user_details->address;
                           $pesticide_array['zipcode']         = $user_details->zipcode;
                           $pesticide_array['device_id']       = $user_details->device_id;
                           $pesticide_array['firebase_token']  = $user_details->firebase_token;
                           $pesticide_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                            if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                $pesticide_array['photo']='';
                            } else {
                                $pesticide_array['photo'] = asset("storage/photo/".$user_details->photo);
                            }
                        }

                       $pesticide_array['id']                =  $tr->id;
                       $pesticide_array['city_name']         =  $tr->city_name;
                       $pesticide_array['category_id']       =  $tr->category_id;
                       $pesticide_array['user_id']           =  $tr->user_id;
                       $pesticide_array['title']             =  $tr->title;
                       $pesticide_array['description']       =  $tr->description;
                       $pesticide_array['price']             =  $tr->price;
                       $pesticide_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                           $pesticide_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                           $pesticide_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                           $pesticide_array['image3'] =  $image3;
                        }

                       $pesticide_array['country_id']           =  $tr->country_id;
                       $pesticide_array['state_id']             =  $tr->state_id;
                       $pesticide_array['district_id']          =  $tr->district_id;
                       $pesticide_array['city_id']              =  $tr->city_id;
                       $pesticide_array['pincode']              =  $tr->pincode;
                       $pesticide_array['latlong']              =  $tr->latlong;
                       $pesticide_array['is_featured']          =  $tr->is_featured;
                       $pesticide_array['valid_till']           =  $tr->valid_till;
                       $pesticide_array['ad_report']            =  $tr->ad_report;
                       $pesticide_array['status']               =  $tr->status;
                    //    $pesticide_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                       $pesticide_array['created_at']           =  $tr->created_at;
                       $pesticide_array['updated_at']           =  $updated_at;
                       $pesticide_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                       $pesticide_array['rejected_by']          =  $tr->rejected_by;
                       $pesticide_array['rejected_at']          =  $tr->rejected_at;
                       $pesticide_array['approved_by']          =  $tr->approved_by;
                       $pesticide_array['approved_at']          =  $tr->approved_at;
                       $pesticide_array['district_name']        =  $district_name;

                       $pesticide_array['state_name']           =  $state_name;
                       $pesticide_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>8,'item_id'=>$tr->id])->count();
                       $pesticide_array['view_lead']            = Leads_view::where(['category_id'=>8,'post_id'=>$tr->id])->count();
                       $pesticide_array['call_lead']            = Lead::where(['category_id'=>8,'post_id'=>$tr->id,'calls_status'=>1])->count();
                       $pesticide_array['msg_lead']             = Lead::where(['category_id'=>8,'post_id'=>$tr->id,'messages_status'=>1])->count();      

                        $data[] =$pesticide_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Pesticides Data';
                        $output['pesticides_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['message' => 'No Data Available','data' =>[]];
                    }
                }
                else if(!empty($userId)){
        
                    $userId      = $request->userId; 
                    $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                    $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude    = $pindata->latitude;
                    $longitude   = $pindata->longitude;
        
                    if($categoryId == 8){
                        $sql = DB::table('pesticidesView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(pesticidesView.latitude))
                                * cos(radians(pesticidesView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(pesticidesView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['message' => 'Deselect Type','data' =>[]];
                    }

                    if (isset($request->min_price)){
                        $min          = $request->min_price;
                        $max          = $request->max_price;
                
                        $sql->whereBetween('price', [$request->min_price,$request->max_price]); 
                    }
                    
                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }
                    
                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
                    
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                        //$sql->take($take);
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
        
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    
                        /** Image of Tyres */
                        // $image1  = "https://krishivikas.com/storage/pesticides/".$tr->image1;
                        // $image2  = "https://krishivikas.com/storage/pesticides/".$tr->image2;
                        // $image3  = "https://krishivikas.com/storage/pesticides/".$tr->image3;

                        $image1  = asset("storage/pesticides/$tr->image1"); 
                        $image2  = asset("storage/pesticides/$tr->image2"); 
                        $image3  = asset("storage/pesticides/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                       $pesticide_array = array();

                       $boosted = Subscribed_boost::view_all_boosted_products(8,$tr->id);
                        if($boosted == 0){
                            $pesticide_array['is_boosted']  = false;
                        }else if($boosted == 1){
                            $pesticide_array['is_boosted']  = true;
                        }
                        
                       $pesticide_array['distance']          =  $distance;
                       
                       $user_count                           = DB::table('user')->where(['id'=>$tr->user_id])->count();
                       if($user_count > 0){
                           $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                           $pesticide_array['user_type_id']    = $user_details->user_type_id;
                           $pesticide_array['role_id']         = $user_details->role_id;
                           $pesticide_array['name']            = $user_details->name;
                           $pesticide_array['company_name']    = $user_details->company_name;
                           $pesticide_array['mobile']          = $user_details->mobile;
                           $pesticide_array['email']           = $user_details->email;
                           $pesticide_array['gender']          = $user_details->gender;
                           $pesticide_array['address']         = $user_details->address;
                           $pesticide_array['zipcode']         = $user_details->zipcode;
                           $pesticide_array['device_id']       = $user_details->device_id;
                           $pesticide_array['firebase_token']  = $user_details->firebase_token;
                           $pesticide_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                           if ($user_details->photo=='NULL' || $user_details->photo=='') {
                               $pesticide_array['photo']='';
                           } else {
                           $pesticide_array['photo'] = asset("storage/photo/".$user_details->photo);
                           }
                        }   

                       $pesticide_array['id']           =  $tr->id;
                       $pesticide_array['city_name']         =  $tr->city_name;
                       $pesticide_array['category_id']       =  $tr->category_id;
                       $pesticide_array['user_id']           =  $tr->user_id;
                       $pesticide_array['title']             =  $tr->title;
                       $pesticide_array['description']       =  $tr->description;
                       $pesticide_array['price']             =  $tr->price;
                       $pesticide_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                           $pesticide_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                           $pesticide_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                           $pesticide_array['image3'] =  $image3;
                        }

                       $pesticide_array['country_id']           =  $tr->country_id;
                       $pesticide_array['state_id']             =  $tr->state_id;
                       $pesticide_array['district_id']          =  $tr->district_id;
                       $pesticide_array['city_id']              =  $tr->city_id;
                       $pesticide_array['pincode']              =  $tr->pincode;
                       $pesticide_array['latlong']              =  $tr->latlong;
                       $pesticide_array['is_featured']          =  $tr->is_featured;
                       $pesticide_array['valid_till']           =  $tr->valid_till;
                       $pesticide_array['ad_report']            =  $tr->ad_report;
                       $pesticide_array['status']               =  $tr->status;
                    //    $pesticide_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                       $pesticide_array['created_at']           =  $tr->created_at;
                       $pesticide_array['updated_at']           =  $updated_at;
                       $pesticide_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                       $pesticide_array['rejected_by']          =  $tr->rejected_by;
                       $pesticide_array['rejected_at']          =  $tr->rejected_at;
                       $pesticide_array['approved_by']          =  $tr->approved_by;
                       $pesticide_array['approved_at']          =  $tr->approved_at;
                       $pesticide_array['district_name']        =  $district_name;

                       $pesticide_array['state_name']           =  $state_name;
                       $pesticide_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>8,'item_id'=>$tr->id])->count();
                       $pesticide_array['view_lead']            = Leads_view::where(['category_id'=>8,'post_id'=>$tr->id])->count();
                       $pesticide_array['call_lead']            = Lead::where(['category_id'=>8,'post_id'=>$tr->id,'calls_status'=>1])->count();
                       $pesticide_array['msg_lead']             = Lead::where(['category_id'=>8,'post_id'=>$tr->id,'messages_status'=>1])->count();        

                        $data[] =$pesticide_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Pesticides Data';
                        $output['pesticides_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['message' => 'No Data Available','data' =>[]];
                    }
                }
            }else{
                $msg = ' please Enter User-id';
                return array('message' => $msg); 
            }

        }else{
            $msg = ' please Enter Right Category Id';
            return array('message' => $msg); 
        } 
    }
    
    
    /** Fertilizer Filter */
    public function fertilizerFilter(Request $request){
        //print_r($request->all());
 
        $categoryId       = $request->categoryId;
        $userId           = $request->userId;
        $price_sort       = $request->price_sort;
        $skip             = $request->skip;
        $take             = $request->take;

        $stateId          = $request->stateId;
        $districtId       = $request->districtId;

        $state_length      = count($stateId);
        $district_length   = count($districtId);
         
        if($categoryId == 9){
            if(!empty($userId) && $categoryId == 9){
                $Autn = DB::table('user')->where(['id'=>$userId])->count();
                if ($Autn==0) {
                    $output['response']=false;
                    $output['message']='Authentication Failed';
                    $output['data'] = '';
                    $output['error'] = "";
                    return $output;
                    exit;
                }
                if($state_length > 0 || $district_length > 0) {
            
                    $stateId        = $request->stateId;
                    $districtId     = $request->districtId;
                    $min_price      = $request->min_price;
                    $max_price      = $request->max_price;
                    $userId         = $request->userId;
                    $categoryId     = $request->categoryId;
                    $price_sort     = $request->price_sort;
    
                    $userId       = $request->userId; 
                    $userPinCode  = DB::table('user')->where('id',$userId)->first()->zipcode; 
                    $pindata      = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude     = $pindata->latitude;
                    $longitude    = $pindata->longitude;
        
                    if($categoryId == 9){
                        $sql = DB::table('fertilizerView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(fertilizerView.latitude))
                                * cos(radians(fertilizerView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(fertilizerView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['message' => 'Deselect Type','data' =>[]];
                    }
        
                    if (isset($request->stateId)) {
                        $state          = $request->stateId;
                        $state_length   = count($state);
        
                        if($state_length > 0){
                            $sql->whereIn('state_id', $request->stateId);
                        }
                    }
        
                    if (isset($request->districtId)) {
                        $district          = $request->districtId;
                        $district_length   = count($district);
        
                        if($district_length > 0){
                            $sql->whereIn('district_id', $request->districtId);
                        }
                    }
        
                    if ($min_price && $max_price){
                        $min          = $request->min_price;
                        $max          = $request->max_price;
        
                        $sql->whereBetween('price', [$min,$max]); 
                    }
        
                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }

                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
        
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
        
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                       // $sql->take($take);
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
                    
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    
                        /** Image of Tyres */
                        // $image1  = "https://krishivikas.com/storage/fertilizers/".$tr->image1;
                        // $image2  = "https://krishivikas.com/storage/fertilizers/".$tr->image2;
                        // $image3  = "https://krishivikas.com/storage/fertilizers/".$tr->image3;

                        $image1  = asset("storage/fertilizers/$tr->image1"); 
                        $image2  = asset("storage/fertilizers/$tr->image2"); 
                        $image3  = asset("storage/fertilizers/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                        $fertilizers_array = array();
                        
                        $fertilizers_array['distance']          =  $distance;
                        
                        $user_count                             = DB::table('user')->where(['id'=>$tr->user_id])->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                            $fertilizers_array['user_type_id']    = $user_details->user_type_id;
                            $fertilizers_array['role_id']         = $user_details->role_id;
                            $fertilizers_array['name']            = $user_details->name;
                            $fertilizers_array['company_name']    = $user_details->company_name;
                            $fertilizers_array['mobile']          = $user_details->mobile;
                            $fertilizers_array['email']           = $user_details->email;
                            $fertilizers_array['gender']          = $user_details->gender;
                            $fertilizers_array['address']         = $user_details->address;
                            $fertilizers_array['zipcode']         = $user_details->zipcode;
                            $fertilizers_array['device_id']       = $user_details->device_id;
                            $fertilizers_array['firebase_token']  = $user_details->firebase_token;
                            $fertilizers_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                            if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                $fertilizers_array['photo']='';
                            } else {
                                $fertilizers_array['photo'] = asset("storage/photo/".$user_details->photo);
                            }
                        }    

                       $fertilizers_array['id']                =  $tr->id;
                       $fertilizers_array['city_name']         =  $tr->city_name;
                       $fertilizers_array['category_id']       =  $tr->category_id;
                       $fertilizers_array['user_id']           =  $tr->user_id;
                       $fertilizers_array['title']             =  $tr->title;
                       $fertilizers_array['description']       =  $tr->description;
                       $fertilizers_array['price']             =  $tr->price;
                       $fertilizers_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                           $fertilizers_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                           $fertilizers_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                           $fertilizers_array['image3'] =  $image3;
                        }

                       $fertilizers_array['country_id']           =  $tr->country_id;
                       $fertilizers_array['state_id']             =  $tr->state_id;
                       $fertilizers_array['district_id']          =  $tr->district_id;
                       $fertilizers_array['city_id']              =  $tr->city_id;
                       $fertilizers_array['pincode']              =  $tr->pincode;
                       $fertilizers_array['latlong']              =  $tr->latlong;
                       $fertilizers_array['is_featured']          =  $tr->is_featured;
                       $fertilizers_array['valid_till']           =  $tr->valid_till;
                       $fertilizers_array['ad_report']            =  $tr->ad_report;
                       $fertilizers_array['status']               =  $tr->status;
                    //    $fertilizers_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                       $fertilizers_array['created_at']           =  $tr->created_at;
                       $fertilizers_array['updated_at']           =  $updated_at;
                       $fertilizers_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                       $fertilizers_array['rejected_by']          =  $tr->rejected_by;
                       $fertilizers_array['rejected_at']          =  $tr->rejected_at;
                       $fertilizers_array['approved_by']          =  $tr->approved_by;
                       $fertilizers_array['approved_at']          =  $tr->approved_at;
                       $fertilizers_array['district_name']        =  $district_name;

                        $fertilizers_array['state_name']           =  $state_name;
                        $fertilizers_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>9,'item_id'=>$tr->id])->count();
                        $fertilizers_array['view_lead']            = Leads_view::where(['category_id'=>9,'post_id'=>$tr->id])->count();
                        $fertilizers_array['call_lead']            = Lead::where(['category_id'=>9,'post_id'=>$tr->id,'calls_status'=>1])->count();
                        $fertilizers_array['msg_lead']             = Lead::where(['category_id'=>9,'post_id'=>$tr->id,'messages_status'=>1])->count();    

                        $data[] =$fertilizers_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Fertilizers Data';
                        $output['fertilizers_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['msg' => 'No Data Available','data' =>[]];
                    }
                    
                }
                else if($state_length == 0 && $district_length == 0 &&  $request->min_price == null && $request->max_price == null){
        
                    $userId      = $request->userId; 
                    $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                    $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude    = $pindata->latitude;
                    $longitude   = $pindata->longitude;
        
                    if($categoryId == 9){
                        $sql = DB::table('fertilizerView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(fertilizerView.latitude))
                                * cos(radians(fertilizerView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(fertilizerView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['message' => 'Deselect Type','data' =>[]];
                    }

                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }

                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
                    
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                        //$sql->take($take);
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
        
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    
                        /** Image of Tyres */
                        // $image1  = "https://krishivikas.com/storage/fertilizers/".$tr->image1;
                        // $image2  = "https://krishivikas.com/storage/fertilizers/".$tr->image2;
                        // $image3  = "https://krishivikas.com/storage/fertilizers/".$tr->image3;

                        $image1  = asset("storage/fertilizers/$tr->image1"); 
                        $image2  = asset("storage/fertilizers/$tr->image2"); 
                        $image3  = asset("storage/fertilizers/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                       $fertilizers_array = array();
                       $boosted = Subscribed_boost::view_all_boosted_products(9,$tr->id);
                        if($boosted == 0){
                            $fertilizers_array['is_boosted']  = false;
                        }else if($boosted == 1){
                            $fertilizers_array['is_boosted']  = true;
                        }
                       $fertilizers_array['distance']          =  $distance;
                       
                       $user_count                            = DB::table('user')->where(['id'=>$tr->user_id])->count();
                       if($user_count > 0){
                           $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                           $fertilizers_array['user_type_id']    = $user_details->user_type_id;
                           $fertilizers_array['role_id']         = $user_details->role_id;
                           $fertilizers_array['name']            = $user_details->name;
                           $fertilizers_array['company_name']    = $user_details->company_name;
                           $fertilizers_array['mobile']          = $user_details->mobile;
                           $fertilizers_array['email']           = $user_details->email;
                           $fertilizers_array['gender']          = $user_details->gender;
                           $fertilizers_array['address']         = $user_details->address;
                           $fertilizers_array['zipcode']         = $user_details->zipcode;
                           $fertilizers_array['device_id']       = $user_details->device_id;
                           $fertilizers_array['firebase_token']  = $user_details->firebase_token;
                           $fertilizers_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                           if ($user_details->photo=='NULL' || $user_details->photo=='') {
                               $fertilizers_array['photo']='';
                           } else {
                            $fertilizers_array['photo'] = asset("storage/photo/".$user_details->photo);
                           }
                       }

                       $fertilizers_array['id']                =  $tr->id;
                       $fertilizers_array['city_name']         =  $tr->city_name;
                       $fertilizers_array['category_id']       =  $tr->category_id;
                       $fertilizers_array['user_id']           =  $tr->user_id;
                       $fertilizers_array['title']             =  $tr->title;
                       $fertilizers_array['description']       =  $tr->description;
                       $fertilizers_array['price']             =  $tr->price;
                       $fertilizers_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                           $fertilizers_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                           $fertilizers_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                           $fertilizers_array['image3'] =  $image3;
                        }

                       $fertilizers_array['country_id']           =  $tr->country_id;
                       $fertilizers_array['state_id']             =  $tr->state_id;
                       $fertilizers_array['district_id']          =  $tr->district_id;
                       $fertilizers_array['city_id']              =  $tr->city_id;
                       $fertilizers_array['pincode']              =  $tr->pincode;
                       $fertilizers_array['latlong']              =  $tr->latlong;
                       $fertilizers_array['is_featured']          =  $tr->is_featured;
                       $fertilizers_array['valid_till']           =  $tr->valid_till;
                       $fertilizers_array['ad_report']            =  $tr->ad_report;
                       $fertilizers_array['status']               =  $tr->status;
                    //    $fertilizers_array['created_at']           =  date("d-m-Y", strtotime($tr->created_at));
                       $fertilizers_array['created_at']           =  $tr->created_at;
                       $fertilizers_array['updated_at']           =  $updated_at;
                       $fertilizers_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                       $fertilizers_array['rejected_by']          =  $tr->rejected_by;
                       $fertilizers_array['rejected_at']          =  $tr->rejected_at;
                       $fertilizers_array['approved_by']          =  $tr->approved_by;
                       $fertilizers_array['approved_at']          =  $tr->approved_at;
                       $fertilizers_array['district_name']        =  $district_name;

                       $fertilizers_array['state_name']           =  $state_name;
                       $fertilizers_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>9,'item_id'=>$tr->id])->count();
                       $fertilizers_array['view_lead']            = Leads_view::where(['category_id'=>9,'post_id'=>$tr->id])->count();
                       $fertilizers_array['call_lead']            = Lead::where(['category_id'=>9,'post_id'=>$tr->id,'calls_status'=>1])->count();
                       $fertilizers_array['msg_lead']             = Lead::where(['category_id'=>9,'post_id'=>$tr->id,'messages_status'=>1])->count();      

                        $data[] =$fertilizers_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Fertilizers Data';
                        $output['fertilizers_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['message' => 'No Data Available','data' =>[]];
                    }
                }
            }else{
                $msg = ' please Enter User-id';
                return array('message' => $msg); 
            }

        }else{
            $msg = ' please Enter Right Category Id';
            return array('message' => $msg); 
        }
        
    }

    /** Crops Filter */
 /*   public function cropsFilter(Request $request){
        //print_r($request->all());
        //dd($request->all());
 
        $categoryId       = $request->categoryId;
        $userId           = $request->userId;
        $price_sort       = $request->price_sort;
        $skip             = $request->skip;
        $take             = $request->take;

        $stateId          = $request->stateId;
        $districtId       = $request->districtId;
        $crops_category_id = $request->crops_category_id;

        $state_length      = count($stateId);
        $district_length   = count($districtId);
         
        if($categoryId == 12){
            if(!empty($userId) && $categoryId == 12){
                $Autn = DB::table('user')->where(['id'=>$userId])->count();
                if ($Autn==0) {
                    $output['response']=false;
                    $output['message']='Authentication Failed';
                    $output['data'] = '';
                    $output['error'] = "";
                    return $output;
                    exit;
                }
                if($state_length > 0 || $district_length > 0) {
            
                    $stateId        = $request->stateId;
                    $districtId     = $request->districtId;
                    $min_price      = $request->min_price;
                    $max_price      = $request->max_price;
                    $userId         = $request->userId;
                    $categoryId     = $request->categoryId;
                    $price_sort     = $request->price_sort;
    
                    $userId       = $request->userId; 
                    $userPinCode  = DB::table('user')->where('id',$userId)->first()->zipcode; 
                    $pindata      = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude     = $pindata->latitude;
                    $longitude    = $pindata->longitude;
        
                    if($categoryId == 12){
                        $sql = DB::table('cropsView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(cropsView.latitude))
                                * cos(radians(cropsView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(cropsView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['message' => 'Deselect Type','data' =>[]];
                    }
        
                    if (isset($request->crops_category_id)) {
                        $crops_category_id          = $request->crops_category_id;
                        $crops_category_id_length   = count($crops_category_id);
        
                        if($crops_category_id_length > 0){
                            $sql->whereIn('crops_category_id', $request->crops_category_id);
                        }
                    }

                    if (isset($request->stateId)) {
                        $state          = $request->stateId;
                        $state_length   = count($state);
        
                        if($state_length > 0){
                            $sql->whereIn('state_id', $request->stateId);
                        }
                    }
        
                    if (isset($request->districtId)) {
                        $district          = $request->districtId;
                        $district_length   = count($district);
        
                        if($district_length > 0){
                            $sql->whereIn('district_id', $request->districtId);
                        }
                    }
        
                    if ($min_price && $max_price){
                        
                        $min          = $request->min_price;
                        $max          = $request->max_price;
        
                        $sql->whereBetween('price', [$min,$max]); 
                    }
        
                    
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }

                   
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
        
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
        
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                       // $sql->take($take);
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
                    
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
                        $image1  = asset("storage/crops/$tr->image1"); 
                        $image2  = asset("storage/crops/$tr->image2"); 
                        $image3  = asset("storage/crops/$tr->image3"); 
    
                        
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                       
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                        $crops_array = array();
                        
                        $crops_array['distance']          =  $distance;
                        
                        $user_count                             = DB::table('user')->where(['id'=>$tr->user_id])->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                            $crops_array['user_type_id']    = $user_details->user_type_id;
                            $crops_array['role_id']         = $user_details->role_id;
                            $crops_array['name']            = $user_details->name;
                            $crops_array['company_name']    = $user_details->company_name;
                            $crops_array['mobile']          = $user_details->mobile;
                            $crops_array['email']           = $user_details->email;
                            $crops_array['gender']          = $user_details->gender;
                            $crops_array['address']         = $user_details->address;
                            $crops_array['zipcode']         = $user_details->zipcode;
                            $crops_array['device_id']       = $user_details->device_id;
                            $crops_array['firebase_token']  = $user_details->firebase_token;
                            $crops_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                            if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                $crops_array['photo']='';
                            } else {
                                $crops_array['photo'] = asset("storage/photo/".$user_details->photo);
                            }
                        }    

                       $crops_array['id']                =  $tr->id;
                       $crops_array['city_name']         =  $tr->city_name;
                       $crops_array['category_id']       =  $tr->category_id;
                       $crops_array['user_id']           =  $tr->user_id;
                       $crops_array['title']             =  $tr->title;
                       $crops_array['description']       =  $tr->description;
                       $crops_array['price']             =  $tr->price;
                       $crops_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                           $crops_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                           $crops_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                           $crops_array['image3'] =  $image3;
                        }

                       $crops_array['country_id']           =  $tr->country_id;
                       $crops_array['state_id']             =  $tr->state_id;
                       $crops_array['district_id']          =  $tr->district_id;
                       $crops_array['city_id']              =  $tr->city_id;
                       $crops_array['pincode']              =  $tr->pincode;
                       $crops_array['latlong']              =  $tr->latlong;
                       $crops_array['is_featured']          =  $tr->is_featured;
                       $crops_array['valid_till']           =  $tr->valid_till;
                       $crops_array['ad_report']            =  $tr->ad_report;
                       $crops_array['status']               =  $tr->status;
                       $crops_array['created_at']           =  $tr->created_at;
                       $crops_array['updated_at']           =  $updated_at;
                       $crops_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                       $crops_array['rejected_by']          =  $tr->rejected_by;
                       $crops_array['rejected_at']          =  $tr->rejected_at;
                       $crops_array['approved_by']          =  $tr->approved_by;
                       $crops_array['approved_at']          =  $tr->approved_at;
                       $crops_array['district_name']        =  $district_name;

                        $crops_array['state_name']           =  $state_name;
                        $crops_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>12,'item_id'=>$tr->id])->count();
                        $crops_array['view_lead']            = Leads_view::where(['category_id'=>12,'post_id'=>$tr->id])->count();
                        $crops_array['call_lead']            = Lead::where(['category_id'=>12,'post_id'=>$tr->id,'calls_status'=>1])->count();
                        $crops_array['msg_lead']             = Lead::where(['category_id'=>12,'post_id'=>$tr->id,'messages_status'=>1])->count();    

                        $data[] =$crops_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Crops Data';
                        $output['crops_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['msg' => 'No Data Available','data' =>[]];
                    }
                    
                }
                else if($state_length == 0 && $district_length == 0 &&  $request->min_price == null && $request->max_price == null){
        
                    $userId      = $request->userId; 
                    $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                    $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude    = $pindata->latitude;
                    $longitude   = $pindata->longitude;
        
                    if($categoryId == 12){
                        $sql = DB::table('cropsView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(cropsView.latitude))
                                * cos(radians(cropsView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(cropsView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['message' => 'Deselect Type','data' =>[]];
                    }

                    if (isset($request->crops_category_id)) {
                        $crops_category_id          = $request->crops_category_id;
                        $crops_category_id_length   = count($crops_category_id);
        
                        if($crops_category_id_length > 0){
                            $sql->whereIn('crops_category_id', $request->crops_category_id);
                        }
                    }

                   
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }

                   
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
                    
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
        
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    
                        $image1  = asset("storage/crops/$tr->image1"); 
                        $image2  = asset("storage/crops/$tr->image2"); 
                        $image3  = asset("storage/crops/$tr->image3"); 
    
                       
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                       $crops_array = array();
                       $boosted = Subscribed_boost::viewAllCropsProduct(12,$tr->id);
                        if($boosted == 0){
                            $crops_array['is_boosted']  = false;
                        }else if($boosted == 1){
                            $crops_array['is_boosted']  = true;
                        }
                       $crops_array['distance']          =  $distance;
                       
                       $user_count                            = DB::table('user')->where(['id'=>$tr->user_id])->count();
                       if($user_count > 0){
                           $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                           $crops_array['user_type_id']    = $user_details->user_type_id;
                           $crops_array['role_id']         = $user_details->role_id;
                           $crops_array['name']            = $user_details->name;
                           $crops_array['company_name']    = $user_details->company_name;
                           $crops_array['mobile']          = $user_details->mobile;
                           $crops_array['email']           = $user_details->email;
                           $crops_array['gender']          = $user_details->gender;
                           $crops_array['address']         = $user_details->address;
                           $crops_array['zipcode']         = $user_details->zipcode;
                           $crops_array['device_id']       = $user_details->device_id;
                           $crops_array['firebase_token']  = $user_details->firebase_token;
                           $crops_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                           if ($user_details->photo=='NULL' || $user_details->photo=='') {
                               $crops_array['photo']='';
                           } else {
                            $crops_array['photo'] = asset("storage/photo/".$user_details->photo);
                           }
                       }

                       $crops_array['id']                =  $tr->id;
                       $crops_array['city_name']         =  $tr->city_name;
                       $crops_array['category_id']       =  $tr->category_id;
                       $crops_array['user_id']           =  $tr->user_id;
                       $crops_array['title']             =  $tr->title;
                       $crops_array['description']       =  $tr->description;
                       $crops_array['price']             =  $tr->price;
                       $crops_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                           $crops_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                           $crops_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                           $crops_array['image3'] =  $image3;
                        }

                       $crops_array['country_id']           =  $tr->country_id;
                       $crops_array['state_id']             =  $tr->state_id;
                       $crops_array['district_id']          =  $tr->district_id;
                       $crops_array['city_id']              =  $tr->city_id;
                       $crops_array['pincode']              =  $tr->pincode;
                       $crops_array['latlong']              =  $tr->latlong;
                       $crops_array['is_featured']          =  $tr->is_featured;
                       $crops_array['valid_till']           =  $tr->valid_till;
                       $crops_array['ad_report']            =  $tr->ad_report;
                       $crops_array['status']               =  $tr->status;
                       $crops_array['created_at']           =  $tr->created_at;
                       $crops_array['updated_at']           =  $updated_at;
                       $crops_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                       $crops_array['rejected_by']          =  $tr->rejected_by;
                       $crops_array['rejected_at']          =  $tr->rejected_at;
                       $crops_array['approved_by']          =  $tr->approved_by;
                       $crops_array['approved_at']          =  $tr->approved_at;
                       $crops_array['district_name']        =  $district_name;

                       $crops_array['state_name']           =  $state_name;
                       $crops_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>12,'item_id'=>$tr->id])->count();
                       $crops_array['view_lead']            = Leads_view::where(['category_id'=>12,'post_id'=>$tr->id])->count();
                       $crops_array['call_lead']            = Lead::where(['category_id'=>12,'post_id'=>$tr->id,'calls_status'=>1])->count();
                       $crops_array['msg_lead']             = Lead::where(['category_id'=>12,'post_id'=>$tr->id,'messages_status'=>1])->count();      

                        $data[] =$crops_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Crops Data';
                        $output['crops_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['message' => 'No Data Available','data' =>[]];
                    }
                }
            }else{
                $msg = ' please Enter User-id';
                return array('message' => $msg); 
            }

        }else{
            $msg = ' please Enter Right Category Id';
            return array('message' => $msg); 
        }
        
    }  */
    
        public function cropsFilter(Request $request){
        //print_r($request->all());
 
        $categoryId       = $request->categoryId;
        $userId           = $request->userId;
        $price_sort       = $request->price_sort;
       // dd($price_sort);
        $skip             = $request->skip;
        $take             = $request->take;

        $stateId          = $request->stateId;
        $districtId       = $request->districtId;
        $crops_category_id = $request->crops_category_id;

        $state_length      = count($stateId);
        $district_length   = count($districtId);
         
        if($categoryId == 12){
            if(!empty($userId) && $categoryId == 12){
                $Autn = DB::table('user')->where(['id'=>$userId])->count();
                if ($Autn==0) {
                    $output['response']=false;
                    $output['message']='Authentication Failed';
                    $output['data'] = '';
                    $output['error'] = "";
                    return $output;
                    exit;
                }
                if($state_length > 0 || $district_length > 0) {
            
                    $stateId        = $request->stateId;
                    $districtId     = $request->districtId;
                    $min_price      = $request->min_price;
                    $max_price      = $request->max_price;
                    $userId         = $request->userId;
                    $categoryId     = $request->categoryId;
                    $price_sort     = $request->price_sort;
    
                    $userId       = $request->userId; 
                    $userPinCode  = DB::table('user')->where('id',$userId)->first()->zipcode; 
                    $pindata      = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude     = $pindata->latitude;
                    $longitude    = $pindata->longitude;
        
                    if($categoryId == 12){
                        $sql = DB::table('cropsView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(cropsView.latitude))
                                * cos(radians(cropsView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(cropsView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['message' => 'Deselect Type','data' =>[]];
                    }
        
                    if (isset($request->crops_category_id)) {
                        $crops_category_id          = $request->crops_category_id;
                        $crops_category_id_length   = count($crops_category_id);
        
                        if($crops_category_id_length > 0){
                            $sql->whereIn('crops_category_id', $request->crops_category_id);
                        }
                    }

                    if (isset($request->stateId)) {
                        $state          = $request->stateId;
                        $state_length   = count($state);
        
                        if($state_length > 0){
                            $sql->whereIn('state_id', $request->stateId);
                        }
                    }
        
                    if (isset($request->districtId)) {
                        $district          = $request->districtId;
                        $district_length   = count($district);
        
                        if($district_length > 0){
                            $sql->whereIn('district_id', $request->districtId);
                        }
                    }
        
                    if ($min_price && $max_price){
                        $min          = $request->min_price;
                        $max          = $request->max_price;
        
                        $sql->whereBetween('price', [$min,$max]); 
                    }
        
                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }

                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
        
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
        
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                       // $sql->take($take);
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
                    
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
                        $image1  = asset("storage/crops/$tr->image1"); 
                        $image2  = asset("storage/crops/$tr->image2"); 
                        $image3  = asset("storage/crops/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                        $crops_array = array();
                        
                        $crops_array['distance']          =  $distance;
                        
                        $user_count                             = DB::table('user')->where(['id'=>$tr->user_id])->count();
                        if($user_count > 0){
                            $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                            $crops_array['user_type_id']    = $user_details->user_type_id;
                            $crops_array['role_id']         = $user_details->role_id;
                            $crops_array['name']            = $user_details->name;
                            $crops_array['company_name']    = $user_details->company_name;
                            $crops_array['mobile']          = $user_details->mobile;
                            $crops_array['email']           = $user_details->email;
                            $crops_array['gender']          = $user_details->gender;
                            $crops_array['address']         = $user_details->address;
                            $crops_array['zipcode']         = $user_details->zipcode;
                            $crops_array['device_id']       = $user_details->device_id;
                            $crops_array['firebase_token']  = $user_details->firebase_token;
                            $crops_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                            if ($user_details->photo=='NULL' || $user_details->photo=='') {
                                $crops_array['photo']='';
                            } else {
                                $crops_array['photo'] = asset("storage/photo/".$user_details->photo);
                            }
                        }    

                       $crops_array['id']                =  $tr->id;
                       $crops_array['city_name']         =  $tr->city_name;
                       $crops_array['category_id']       =  $tr->category_id;
                       $crops_array['user_id']           =  $tr->user_id;
                       $crops_array['title']             =  $tr->title;
                       $crops_array['description']       =  $tr->description;
                       $crops_array['price']             =  $tr->price;
                       $crops_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                           $crops_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                           $crops_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                           $crops_array['image3'] =  $image3;
                        }
                    
                      $crops_array['crop_category_name']  = DB::table('crops_category')->where('id',$tr->crops_category_id)->value('crops_cat_name');

                       $crops_array['country_id']           =  $tr->country_id;
                       $crops_array['state_id']             =  $tr->state_id;
                       $crops_array['district_id']          =  $tr->district_id;
                       $crops_array['city_id']              =  $tr->city_id;
                       $crops_array['pincode']              =  $tr->pincode;
                       $crops_array['latlong']              =  $tr->latlong;
                       $crops_array['is_featured']          =  $tr->is_featured;
                       $crops_array['valid_till']           =  $tr->valid_till;
                       $crops_array['ad_report']            =  $tr->ad_report;
                       $crops_array['status']               =  $tr->status;
                       $crops_array['created_at']           =  $tr->created_at;
                       $crops_array['updated_at']           =  $updated_at;
                       $crops_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                       $crops_array['rejected_by']          =  $tr->rejected_by;
                       $crops_array['rejected_at']          =  $tr->rejected_at;
                       $crops_array['approved_by']          =  $tr->approved_by;
                       $crops_array['approved_at']          =  $tr->approved_at;
                       $crops_array['district_name']        =  $district_name;

                        $crops_array['state_name']           =  $state_name;
                        $crops_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>12,'item_id'=>$tr->id])->count();
                        $crops_array['view_lead']            = Leads_view::where(['category_id'=>12,'post_id'=>$tr->id])->count();
                        $crops_array['call_lead']            = Lead::where(['category_id'=>12,'post_id'=>$tr->id,'calls_status'=>1])->count();
                        $crops_array['msg_lead']             = Lead::where(['category_id'=>12,'post_id'=>$tr->id,'messages_status'=>1])->count();    

                        $data[] =$crops_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Crops Data';
                        $output['crops_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['msg' => 'No Data Available','data' =>[]];
                    }
                    
                }
                
                else if($state_length == 0 && $district_length == 0 &&  $request->min_price == null && $request->max_price == null){
        
                    $userId      = $request->userId; 
                    $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                    $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude    = $pindata->latitude;
                    $longitude   = $pindata->longitude;
        
                    if($categoryId == 12){
                        $sql = DB::table('cropsView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(cropsView.latitude))
                                * cos(radians(cropsView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(cropsView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['message' => 'Deselect Type','data' =>[]];
                    }

                    if (isset($request->crops_category_id)) {
                        $crops_category_id          = $request->crops_category_id;
                        $crops_category_id_length   = count($crops_category_id);
        
                        if($crops_category_id_length > 0){
                            $sql->whereIn('crops_category_id', $request->crops_category_id);
                        }
                    }

                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        $sql->orderBy('price',$price_sort);
                    }

                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
                    
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                    }
        
                    $sql1 = $sql->get();
                    $sql1_count = $sql->count();
        
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    
                        $image1  = asset("storage/crops/$tr->image1"); 
                        $image2  = asset("storage/crops/$tr->image2"); 
                        $image3  = asset("storage/crops/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                       $crops_array = array();
                       $boosted = Subscribed_boost::viewAllCropsProduct(12,$tr->id);
                        if($boosted == 0){
                            $crops_array['is_boosted']  = false;
                        }else if($boosted == 1){
                            $crops_array['is_boosted']  = true;
                        }
                       $crops_array['distance']          =  $distance;
                       
                       $user_count                            = DB::table('user')->where(['id'=>$tr->user_id])->count();
                       if($user_count > 0){
                           $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                           $crops_array['user_type_id']    = $user_details->user_type_id;
                           $crops_array['role_id']         = $user_details->role_id;
                           $crops_array['name']            = $user_details->name;
                           $crops_array['company_name']    = $user_details->company_name;
                           $crops_array['mobile']          = $user_details->mobile;
                           $crops_array['email']           = $user_details->email;
                           $crops_array['gender']          = $user_details->gender;
                           $crops_array['address']         = $user_details->address;
                           $crops_array['zipcode']         = $user_details->zipcode;
                           $crops_array['device_id']       = $user_details->device_id;
                           $crops_array['firebase_token']  = $user_details->firebase_token;
                           $crops_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                           if ($user_details->photo=='NULL' || $user_details->photo=='') {
                               $crops_array['photo']='';
                           } else {
                            $crops_array['photo'] = asset("storage/photo/".$user_details->photo);
                           }
                       }

                       $crops_array['id']                =  $tr->id;
                       $crops_array['city_name']         =  $tr->city_name;
                       $crops_array['category_id']       =  $tr->category_id;
                       $crops_array['user_id']           =  $tr->user_id;
                       $crops_array['title']             =  $tr->title;
                       $crops_array['description']       =  $tr->description;
                       $crops_array['price']             =  $tr->price;
                       $crops_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                           $crops_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                           $crops_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                           $crops_array['image3'] =  $image3;
                        }
                          $crops_array['crop_category_name']  = DB::table('crops_category')->where('id',$tr->crops_category_id)->value('crops_cat_name');

                       $crops_array['country_id']           =  $tr->country_id;
                       $crops_array['state_id']             =  $tr->state_id;
                       $crops_array['district_id']          =  $tr->district_id;
                       $crops_array['city_id']              =  $tr->city_id;
                       $crops_array['pincode']              =  $tr->pincode;
                       $crops_array['latlong']              =  $tr->latlong;
                       $crops_array['is_featured']          =  $tr->is_featured;
                       $crops_array['valid_till']           =  $tr->valid_till;
                       $crops_array['ad_report']            =  $tr->ad_report;
                       $crops_array['status']               =  $tr->status;
                       $crops_array['created_at']           =  $tr->created_at;
                       $crops_array['updated_at']           =  $updated_at;
                       $crops_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                       $crops_array['rejected_by']          =  $tr->rejected_by;
                       $crops_array['rejected_at']          =  $tr->rejected_at;
                       $crops_array['approved_by']          =  $tr->approved_by;
                       $crops_array['approved_at']          =  $tr->approved_at;
                       $crops_array['district_name']        =  $district_name;

                       $crops_array['state_name']           =  $state_name;
                       $crops_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>12,'item_id'=>$tr->id])->count();
                       $crops_array['view_lead']            = Leads_view::where(['category_id'=>12,'post_id'=>$tr->id])->count();
                       $crops_array['call_lead']            = Lead::where(['category_id'=>12,'post_id'=>$tr->id,'calls_status'=>1])->count();
                       $crops_array['msg_lead']             = Lead::where(['category_id'=>12,'post_id'=>$tr->id,'messages_status'=>1])->count();      

                        $data[] =$crops_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Crops Data';
                        $output['crops_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['message' => 'No Data Available','data' =>[]];
                    }
                }

                else if($state_length == 0 && $district_length == 0 &&  $request->min_price !="" && $request->max_price != ""){
                    $min_price      = $request->min_price;
                    $max_price      = $request->max_price;
                    $userId      = $request->userId; 
                    $userPinCode = DB::table('user')->where('id',$userId)->first()->zipcode;
                    $pindata     = DB::table('city')->where(['pincode'=>$userPinCode])->first();
                    $latitude    = $pindata->latitude;
                    $longitude   = $pindata->longitude;
        
                    if($categoryId == 12){
                     //   \DB::enableQueryLog();
                        $sql = DB::table('cropsView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(cropsView.latitude))
                                * cos(radians(cropsView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(cropsView.latitude))) AS distance"))
                                ->whereIn('status',[1,4]);
                    }

                    if($request->type == 'old' || $request->type == 'rent'){
                        return ['message' => 'Deselect Type','data' =>[]];
                    }

                    if (isset($request->crops_category_id)) {
                        $crops_category_id          = $request->crops_category_id;
                        $crops_category_id_length   = count($crops_category_id);
        
                        if($crops_category_id_length > 0){
                            $sql->whereIn('crops_category_id', $request->crops_category_id);
                        }
                    }

                    if ($min_price && $max_price){
                        $min          = $request->min_price;
                        $max          = $request->max_price;
                       // dd($min);
        
                        $sql->whereBetween('price', [$min,$max]); 
                    }
        
  
                    /** Low To High    &&    High to low */
                    if($price_sort == 'asc' || $price_sort == 'desc'){
                        //dd("h");
                        $sql->orderBy('price',$price_sort);
                    }

                    /** Newest First */
                    if($price_sort == 'nf'){
                        $sql->orderBy('id','desc');
                    }
                    
                    /** Distance Wish Data Show */
                    if($price_sort == null || $price_sort ==''){
                        $sql->orderBy('distance','asc');
                    }
                    
                    if(isset($skip)){
                        $sql->skip($skip);
                    }
                    if(isset($take)){
                        if($request->take == 0){
                            $sql->take(100000);
                        }else{
                            $sql->take($take);
                        }
                    }
      
                    $sql1 = $sql->get();
                     // dd(\DB::getQueryLog()); 
                    $sql1_count = $sql->count();
                  //  dd($sql1_count);
                    foreach($sql1 as $key => $s){ 
                        $output=[];
                        
                        $tr = $sql1->where('id',$s->id)->first();
    
                        $image1  = asset("storage/crops/$tr->image1"); 
                        $image2  = asset("storage/crops/$tr->image2"); 
                        $image3  = asset("storage/crops/$tr->image3"); 
    
                        /** Date of Create at */
                        $create     = $tr->created_at;
                        $newtime    = strtotime($create);
                        $created_at = date('M d, Y',$newtime);
                        
                        /** Date of Update at */
                        $update      = $tr->updated_at;
                        $newtime1    = strtotime($update);
                        $updated_at  = date('M d, Y',$newtime1);
    
                        /** Distance Show */
                        $d = round($tr->distance);
                        if($d == null){
                            $distance = 0;
                        }else{
                            $distance = $d;
                        }
    
                        /** District Name */
                        $district_name = DB::table('district')->where('id',$tr->district_id)->first()->district_name;
                        $state_name    = DB::table('state')->where(['id'=>$tr->state_id])->first()->state_name;
    
                       $crops_array = array();
                       $boosted = Subscribed_boost::viewAllCropsProduct(12,$tr->id);
                        if($boosted == 0){
                            $crops_array['is_boosted']  = false;
                        }else if($boosted == 1){
                            $crops_array['is_boosted']  = true;
                        }
                       $crops_array['distance']          =  $distance;
                       
                       $user_count                            = DB::table('user')->where(['id'=>$tr->user_id])->count();
                       if($user_count > 0){
                           $user_details  = DB::table('user')->where(['id'=>$tr->user_id])->first();
                           $crops_array['user_type_id']    = $user_details->user_type_id;
                           $crops_array['role_id']         = $user_details->role_id;
                           $crops_array['name']            = $user_details->name;
                           $crops_array['company_name']    = $user_details->company_name;
                           $crops_array['mobile']          = $user_details->mobile;
                           $crops_array['email']           = $user_details->email;
                           $crops_array['gender']          = $user_details->gender;
                           $crops_array['address']         = $user_details->address;
                           $crops_array['zipcode']         = $user_details->zipcode;
                           $crops_array['device_id']       = $user_details->device_id;
                           $crops_array['firebase_token']  = $user_details->firebase_token;
                           $crops_array['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
                           if ($user_details->photo=='NULL' || $user_details->photo=='') {
                               $crops_array['photo']='';
                           } else {
                            $crops_array['photo'] = asset("storage/photo/".$user_details->photo);
                           }
                       }

                       $crops_array['id']                =  $tr->id;
                       $crops_array['city_name']         =  $tr->city_name;
                       $crops_array['category_id']       =  $tr->category_id;
                       $crops_array['user_id']           =  $tr->user_id;
                       $crops_array['title']             =  $tr->title;
                       $crops_array['description']       =  $tr->description;
                       $crops_array['price']             =  $tr->price;
                       $crops_array['is_negotiable']     =  $tr->is_negotiable;

                        if(!empty($tr->image1) ){
                           $crops_array['image1'] =  $image1;
                        }
                        if(!empty($tr->image2) ){
                           $crops_array['image2'] =  $image2;
                        }
                        if(!empty($tr->image3) ){
                           $crops_array['image3'] =  $image3;
                        }
                        
                        $crops_array['crop_category_name']  = DB::table('crops_category')->where('id',$tr->crops_category_id)->value('crops_cat_name');

                       $crops_array['country_id']           =  $tr->country_id;
                       $crops_array['state_id']             =  $tr->state_id;
                       $crops_array['district_id']          =  $tr->district_id;
                       $crops_array['city_id']              =  $tr->city_id;
                       $crops_array['pincode']              =  $tr->pincode;
                       $crops_array['latlong']              =  $tr->latlong;
                       $crops_array['is_featured']          =  $tr->is_featured;
                       $crops_array['valid_till']           =  $tr->valid_till;
                       $crops_array['ad_report']            =  $tr->ad_report;
                       $crops_array['status']               =  $tr->status;
                       $crops_array['created_at']           =  $tr->created_at;
                       $crops_array['updated_at']           =  $updated_at;
                       $crops_array['reason_for_rejection'] =  $tr->reason_for_rejection;
                       $crops_array['rejected_by']          =  $tr->rejected_by;
                       $crops_array['rejected_at']          =  $tr->rejected_at;
                       $crops_array['approved_by']          =  $tr->approved_by;
                       $crops_array['approved_at']          =  $tr->approved_at;
                       $crops_array['district_name']        =  $district_name;

                       $crops_array['state_name']           =  $state_name;
                       $crops_array['wishlist_status']      = DB::table('wishlist')->where(['user_id'=>$tr->user_id,'category_id'=>12,'item_id'=>$tr->id])->count();
                       $crops_array['view_lead']            = Leads_view::where(['category_id'=>12,'post_id'=>$tr->id])->count();
                       $crops_array['call_lead']            = Lead::where(['category_id'=>12,'post_id'=>$tr->id,'calls_status'=>1])->count();
                       $crops_array['msg_lead']             = Lead::where(['category_id'=>12,'post_id'=>$tr->id,'messages_status'=>1])->count();      

                        $data[] =$crops_array;
    
                        $output['response'] = true;
                        $output['message']  = 'Crops Data';
                        $output['crops_count']  = $sql1_count;
                        $output['data']     = $data;
                        $output['error']    = "";
                    }
                    if(!empty($data)){
                        return $output;
                    }else {
                        return ['message' => 'No Data Available','data' =>[]];
                    }
                }

            }else{
                $msg = ' please Enter User-id';
                return array('message' => $msg); 
            }

        }else{
            $msg = ' please Enter Right Category Id';
            return array('message' => $msg); 
        }
        
    }


    
}
