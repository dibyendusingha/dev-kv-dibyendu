<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebFilterController extends Controller
{
    /** Brand And Model Data  */
    public function getBrandModelData(Request $request){
        // echo "Brand to Model Data";
       // dd($request->all());

        $categoryId  = $request->category;
        $type        = $request->type;
        $brand_id    = $request->brand_id;

        // Brand Wish Model Data Show
        if(!empty($brand_id) && !empty($categoryId) && !empty($type)){
            $brand_id    = $request->brand_id;
            $categoryId  = $request->category;
            $type        = $request->type;
            
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
        else{
            $output['response'] = false;
            $output['message']  = 'Select Category And Type';
            $output['data']     =  []; 
        }

        return $output;

    }
    
}
