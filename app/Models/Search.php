<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Tractor;
use App\Models\Rent_tractor;
use App\Models\Goods_vehicle;
use App\Models\Harvester;
use App\Models\Implement;
use App\Models\Tyre;
use App\Models\Seed;
use App\Models\pesticides;
use App\Models\fertilizers;
use App\Models\Leads_view;


class Search extends Model
{
    use HasFactory;
    
    protected function search_by_brand ($category_id,$brand_id,$keyword) {
        $category_id = $category_id;
        $brand_id = $brand_id;
        
        if ($category_id==1) {
            $data = Tractor::search_tractor_brand($brand_id,$keyword);
        } else if ($category_id==3) {
            $data = Goods_vehicle::search_gv_brand($brand_id,$keyword);
        } else if ($category_id==4) {
            $data = Harvester::search_harvester_brand($brand_id,$keyword);
        } else if ($category_id==5) {
            $data = Implement::search_implement_brand($brand_id,$keyword);
        } else if ($category_id==7) {
            $data = Tyre::search_tyre_brand($brand_id,$keyword);
        } else if ($category_id==6) {
            $data = Seed::search_seed_brand($keyword);
        } else if ($category_id==8) {
            $data = pesticides::search_pesticide_brand($keyword);
        } else if ($category_id==9) {
            $data = fertilizers::search_fertilizer_brand($keyword);
        }
        return $data;
    }
    
    protected function search_by_model ($category_id,$model_id,$keyword) {
        $brand_id = DB::table('model')->where(['id'=>$model_id])->value('brand_id');
        if ($category_id==1) {
            $data = Tractor::search_tractor_model($brand_id,$model_id,$keyword);
        } else if ($category_id==3) {
            $data = Goods_vehicle::search_gv_model($brand_id,$model_id,$keyword);
        } else if ($category_id==4) {
            $data = Harvester::search_harvester_model($brand_id,$model_id,$keyword);
        } else if ($category_id==5) {
            $data = Implement::search_implement_model($brand_id,$model_id,$keyword);
        } else if ($category_id==7) {
            $data = Tyre::search_tyre_model($brand_id,$model_id,$keyword);
        } else if ($category_id==6) {
            $data = Seed::search_seed_model($keyword);
        } else if ($category_id==8) {
            $data = pesticides::search_pesticide_model($keyword);
        } else if ($category_id==9) {
            $data = fertilizers::search_fertilizer_model($keyword);
        }
        return $data;
    }
    
    protected function search_by_state ($category_id,$state_id,$keyword) {
        if ($category_id==1) {
            $data = Tractor::search_tractor_state($state_id,$keyword);
        } else if ($category_id==3) {
            $data = Goods_vehicle::search_gv_state($state_id,$keyword);
        } else if ($category_id==4) {
            $data = Harvester::search_harvester_state($state_id,$keyword);
        } else if ($category_id==5) {
            $data = Implement::search_implement_state($state_id,$keyword);
        } else if ($category_id==7) {
            $data = Tyre::search_tyre_state($state_id,$keyword);
        } else if ($category_id==6) {
            $data = Seed::search_seed_state($state_id,$keyword);
        } else if ($category_id==8) {
            $data = pesticides::search_pesticide_state($state_id,$keyword);
        } else if ($category_id==9) {
            $data = fertilizers::search_fertilizer_state($state_id,$keyword);
        }
        return $data;
    }
    
    
    protected function search_by_district ($category_id,$district_id,$keyword) {
        if ($category_id==1) {
            $data = Tractor::search_tractor_district($district_id,$keyword);
        } else if ($category_id==3) {
            $data = Goods_vehicle::search_gv_district($district_id,$keyword);
        } else if ($category_id==4) {
            $data = Harvester::search_harvester_district($district_id,$keyword);
        } else if ($category_id==5) {
            $data = Implement::search_implement_district($district_id,$keyword);
        } else if ($category_id==7) {
            $data = Tyre::search_tyre_district($district_id,$keyword);
        } else if ($category_id==6) {
            $data = Seed::search_seed_district($district_id,$keyword);
        } else if ($category_id==8) {
            $data = pesticides::search_pesticide_district($district_id,$keyword);
        } else if ($category_id==9) {
            $data = fertilizers::search_fertilizer_district($district_id,$keyword);
        }
        return $data;
    }
    
    
    
    protected function empty_search ($category_id,$keyword) {
        $new=[];
        $new1=[];
        $new2=[];
        $new3=[];
        $new4=[];
        $new[0]=[];
        $query = DB::table('search_engine')->where('keyword','like', '%'.$keyword.'%')->get();
            foreach ($query as $val) {
                    if ($val->category_id==$category_id) {
                    $id = $val->id;
                    $search_id = $val->search_id;
                    $string_id = $val->string_id;
                    $keyword = $val->keyword; 
                    
                    $brand_arr = DB::table('brand')->where('name','like', '%'.$keyword.'%')->get();
                    foreach ($brand_arr as $val3) {
                        $brand_id = $val3->id;
                        $new2[] = Search::search_by_brand($category_id,$brand_id,$keyword);
                        
                    }
                    
                    $model_arr = DB::table('model')->where('model_name','like', '%'.$keyword.'%')->get();
                    foreach ($model_arr as $val1) {
                        $model_id = $val1->id;
                        $new1[] = Search::search_by_model($category_id,$model_id,$keyword);
                        
                    }
                    } 
                    
                    if ($val->category_id==NULL || $val->category_id=='') {
                    $id = $val->id;
                    $search_id = $val->search_id;
                    $string_id = $val->string_id;
                    $keyword = $val->keyword; 
                    
                    $state_arr = DB::table('state')->where('state_name','like', '%'.$keyword.'%')->get();
                    foreach ($state_arr as $val4) {
                        $state_id = $val4->id;
                        $new3[] = Search::search_by_state($category_id,$state_id,$keyword);
                        
                    }
                    $district_arr = DB::table('district')->where('district_name','like', '%'.$keyword.'%')->get();
                    foreach ($district_arr as $val2) {
                        $district_id = $val2->id;
                        $new4[] = Search::search_by_district($category_id,$district_id,$keyword);
                        
                    }
                    } 
                    $new = array_merge($new2,$new1,$new3,$new4);
                    // if ($new1!='' || $new1!=null) {
                    //     array_push($new,$new1);
                    // }
                    // if ($new2!='' || $new2!=null) {
                    //     array_push($new,$new2);
                    // }
                    // if ($new3!='' || $new3!=null) {
                    //     array_push($new,$new3);
                    // }
                    // if ($new4!='' || $new4!=null) {
                    //     array_push($new,$new4);
                    // }
                    
            
        }
        return $new[0];
    }
    
    
}
