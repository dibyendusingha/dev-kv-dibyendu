<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BandProductController extends Controller
{ 
    /** Dibyendu Change 05.10.2023*/
    public function brand_product_page(){
        return view('front.development.brand-product');
    }

    public function brandNameCategoryWish(Request $request ,$category,$type,$brandId){
        // dd($request->all());
        //dd($category);
        //dd($brandId);
        $pincode = $request->session()->get('pincode');
        //dd($pincode);
        $pindata = DB::table('city')->where(['pincode'=>$pincode])->first();

        $latitude = $pindata->latitude;
        $longitude = $pindata->longitude;

        if($category == 'tractor'){
            if($type == 'rent'){
                $tr_data = DB::table('tractorView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(tractorView.latitude))
                            * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(tractorView.latitude))) AS distance"))
                            ->where('set','rent')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('distance','asc')
                            ->paginate(9);
            }else if($type == 'old'){
                $tr_data = DB::table('tractorView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(tractorView.latitude))
                        * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(tractorView.latitude))) AS distance"))
                        ->where('set','sell')
                        ->where('type','old')
                        ->where('brand_id',$brandId)
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->paginate(9);
                        // ->get();
            }
        }
        else if($category == 'goodvehice'){
            if($type == 'rent'){
                $tr_data = DB::table('goodVehicleView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(goodVehicleView.latitude))
                            * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(goodVehicleView.latitude))) AS distance"))
                            ->where('set','rent')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('distance','asc')
                            ->paginate(9);
            }else if($type == 'old'){
                $tr_data = DB::table('goodVehicleView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(goodVehicleView.latitude))
                        * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(goodVehicleView.latitude))) AS distance"))
                        ->where('set','sell')
                        ->where('type','old')
                        ->where('brand_id',$brandId)
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->paginate(9);
                        // ->get();
            }

        }
        else if($category == 'harvester'){
            if($type == 'rent'){
                $tr_data = DB::table('harvesterView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(harvesterView.latitude))
                            * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(harvesterView.latitude))) AS distance"))
                            ->where('set','rent')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('distance','asc')
                            ->paginate(9);
            }else if($type == 'old'){
                $tr_data = DB::table('harvesterView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(harvesterView.latitude))
                        * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(harvesterView.latitude))) AS distance"))
                        ->where('set','sell')
                        ->where('type','old')
                        ->where('brand_id',$brandId)
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->paginate(9);
                        // ->get();
            }

        }
        else if($category == 'implement'){
            if($type == 'rent'){
                $tr_data = DB::table('implementView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(implementView.latitude))
                            * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(implementView.latitude))) AS distance"))
                            ->where('set','rent')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('distance','asc')
                            ->paginate(9);
            }else if($type == 'old'){
                $tr_data = DB::table('implementView')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(implementView.latitude))
                        * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(implementView.latitude))) AS distance"))
                        ->where('set','sell')
                        ->where('type','old')
                        ->where('brand_id',$brandId)
                        ->whereIn('status',[1,4])
                        ->orderBy('distance','asc')
                        ->paginate(9);
                        // ->get();
            }

        }
        else if($category == 'tyre'){
            if($type == 'old'){
                $tr_data = DB::table('tyresView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(tyresView.latitude))
                            * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(tyresView.latitude))) AS distance"))
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('distance','asc')
                            ->paginate(9);
            }

        }

        
        if($category == 'tractor'){
            $brandName    = DB::table('brand')->where('category_id',1)->get();
        }
        else if($category == 'goodvehice'){
            $brandName    = DB::table('brand')->where('category_id',3)->get();
        }
        else if($category == 'harvester'){
            $brandName    = DB::table('brand')->where('category_id',4)->get();
        }
        else if($category == 'implement'){
            $brandName    = DB::table('brand')->where('category_id',5)->get();
        }
        else if($category == 'tyre'){
            $brandName    = DB::table('brand')->where('category_id',7)->get();
        }

        return view('front.development.brand-product',['tr_data'=>$tr_data,'brandName'=>$brandName]);

    }

    public function filterDataBrandName(Request $request ,$category,$type , $bandId){
       // dd($request->all());

        $sortByPrice   = $request->flexRadioDefault;
        $type          = $request->condition[0];
       /// dd($type );
        $brandId       = $request->brand;

        //dd($sortByPrice);

        $pincode = $request->session()->get('pincode');
        //dd($pincode);
        $pindata = DB::table('city')->where(['pincode'=>$pincode])->first();

        $latitude = $pindata->latitude;
        $longitude = $pindata->longitude;

        if($request->flexRadioDefault == 'phl' ){
            if($category == 'tractor'){
                if($type == 'rent'){
                    $tr_data = DB::table('tractorView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(tractorView.latitude))
                                * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(tractorView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('price','desc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('tractorView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(tractorView.latitude))
                            * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(tractorView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('price','desc')
                            // ->paginate(9);
                            ->get();
                }
            } 
            else if($category == 'goodvehice'){
                if($type == 'rent'){
                    $tr_data = DB::table('goodVehicleView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(goodVehicleView.latitude))
                                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(goodVehicleView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('price','desc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('goodVehicleView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(goodVehicleView.latitude))
                            * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(goodVehicleView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('price','desc')
                            // ->paginate(9);
                            ->get();
                }
            } 
            else if($category == 'harvester'){
                if($type == 'rent'){
                    $tr_data = DB::table('harvesterView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(harvesterView.latitude))
                                * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(harvesterView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('price','desc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('harvesterView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(harvesterView.latitude))
                            * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(harvesterView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('price','desc')
                            // ->paginate(9);
                            ->get();
                }
            }  
            else if($category == 'implement'){
                if($type == 'rent'){
                    $tr_data = DB::table('implementView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(implementView.latitude))
                                * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(implementView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('price','desc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('implementView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(implementView.latitude))
                            * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(implementView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('price','desc')
                            // ->paginate(9);
                            ->get();
                }
            } 
            else if($category == 'tyre'){
                if($type == 'old'){
                    $tr_data = DB::table('tyresView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(tyresView.latitude))
                            * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(tyresView.latitude))) AS distance"))
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('price','desc')
                            // ->paginate(9);
                            ->get();
                }
            } 
        }
        else if($request->flexRadioDefault == 'plh' ){
            if($category == 'tractor'){
                if($type == 'rent'){
                    $tr_data = DB::table('tractorView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(tractorView.latitude))
                                * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(tractorView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('price','asc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('tractorView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(tractorView.latitude))
                            * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(tractorView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('price','asc')
                            // ->paginate(9);
                            ->get();
                }
            } 
            else if($category == 'goodvehice'){
                if($type == 'rent'){
                    $tr_data = DB::table('goodVehicleView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(goodVehicleView.latitude))
                                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(goodVehicleView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('price','asc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('goodVehicleView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(goodVehicleView.latitude))
                            * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(goodVehicleView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('price','asc')
                            // ->paginate(9);
                            ->get();
                }
            } 
            else if($category == 'harvester'){
                if($type == 'rent'){
                    $tr_data = DB::table('harvesterView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(harvesterView.latitude))
                                * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(harvesterView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('price','asc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('harvesterView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(harvesterView.latitude))
                            * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(harvesterView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('price','asc')
                            // ->paginate(9);
                            ->get();
                }
            }  
            else if($category == 'implement'){
                if($type == 'rent'){
                    $tr_data = DB::table('implementView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(implementView.latitude))
                                * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(implementView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('price','asc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('implementView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(implementView.latitude))
                            * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(implementView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('price','asc')
                            // ->paginate(9);
                            ->get();
                }
            } 
            else if($category == 'tyre'){
                if($type == 'old'){
                    $tr_data = DB::table('tyresView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(tyresView.latitude))
                            * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(tyresView.latitude))) AS distance"))
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('price','asc')
                            // ->paginate(9);
                            ->get();
                }
            } 
        }
        else if($request->flexRadioDefault == 'nf' ){
            if($category == 'tractor'){
                if($type == 'rent'){
                    $tr_data = DB::table('tractorView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(tractorView.latitude))
                                * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(tractorView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('id','desc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('tractorView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(tractorView.latitude))
                            * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(tractorView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('id','desc')
                            // ->paginate(9);
                            ->get();
                }
            } 
            else if($category == 'goodvehice'){
                if($type == 'rent'){
                    $tr_data = DB::table('goodVehicleView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(goodVehicleView.latitude))
                                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(goodVehicleView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('id','desc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('goodVehicleView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(goodVehicleView.latitude))
                            * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(goodVehicleView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('id','desc')
                            // ->paginate(9);
                            ->get();
                }
            } 
            else if($category == 'harvester'){
                if($type == 'rent'){
                    $tr_data = DB::table('harvesterView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(harvesterView.latitude))
                                * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(harvesterView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('id','desc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('harvesterView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(harvesterView.latitude))
                            * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(harvesterView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('id','desc')
                            // ->paginate(9);
                            ->get();
                }
            }  
            else if($category == 'implement'){
                if($type == 'rent'){
                    $tr_data = DB::table('implementView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(implementView.latitude))
                                * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(implementView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('id','desc')
                                // ->paginate(9);
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('implementView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(implementView.latitude))
                            * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(implementView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->where('set','sell')
                            ->whereIn('status',[1,4])
                            ->orderBy('id','desc')
                            // ->paginate(9);
                            ->get();
                }
            } 
            else if($category == 'tyre'){
                if($type == 'old'){
                    $tr_data = DB::table('tyresView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(tyresView.latitude))
                            * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(tyresView.latitude))) AS distance"))
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('id','desc')
                            // ->paginate(9);
                            ->get();
                }
            }  
        }
        else if($request->flexRadioDefault == '' && !empty($category) ){
            if($category == 'tractor'){
                if($type == 'rent'){
                    $tr_data = DB::table('tractorView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(tractorView.latitude))
                                * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(tractorView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('distance','asc')
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('tractorView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(tractorView.latitude))
                            * cos(radians(tractorView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(tractorView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('distance','asc')
                            ->get();
                            // ->get();
                }
            }
            else if($category == 'goodvehice'){
                if($type == 'rent'){
                    $tr_data = DB::table('goodVehicleView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(goodVehicleView.latitude))
                                * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(goodVehicleView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('distance','asc')
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('goodVehicleView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(goodVehicleView.latitude))
                            * cos(radians(goodVehicleView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(goodVehicleView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('distance','asc')
                            ->get();
                            // ->get();
                }
    
            }
            else if($category == 'harvester'){
                if($type == 'rent'){
                    $tr_data = DB::table('harvesterView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(harvesterView.latitude))
                                * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(harvesterView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('distance','asc')
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('harvesterView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(harvesterView.latitude))
                            * cos(radians(harvesterView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(harvesterView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('distance','asc')
                            ->get();
                            // ->get();
                }
    
            }
            else if($category == 'implement'){
                if($type == 'rent'){
                    $tr_data = DB::table('implementView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(implementView.latitude))
                                * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(implementView.latitude))) AS distance"))
                                ->where('set','rent')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('distance','asc')
                                ->get();
                }else if($type == 'old'){
                    $tr_data = DB::table('implementView')
                            ->select('*'
                            , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                            * cos(radians(implementView.latitude))
                            * cos(radians(implementView.longitude) - radians(" .$longitude. "))
                            + sin(radians(" .$latitude. "))
                            * sin(radians(implementView.latitude))) AS distance"))
                            ->where('set','sell')
                            ->where('type','old')
                            ->where('brand_id',$brandId)
                            ->whereIn('status',[1,4])
                            ->orderBy('distance','asc')
                            ->get();
                            // ->get();
                }
            }
            else if($category == 'tyre'){
                if($type == 'old'){
                    $tr_data = DB::table('tyresView')
                                ->select('*'
                                , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                                * cos(radians(tyresView.latitude))
                                * cos(radians(tyresView.longitude) - radians(" .$longitude. "))
                                + sin(radians(" .$latitude. "))
                                * sin(radians(tyresView.latitude))) AS distance"))
                                ->where('type','old')
                                ->where('brand_id',$brandId)
                                ->whereIn('status',[1,4])
                                ->orderBy('distance','asc')
                                ->get();
                }
            }
    
        }

        if($category == 'tractor'){
            $brandName    = DB::table('brand')->where('category_id',1)->get();
        }
        else if($category == 'goodvehice'){
            $brandName    = DB::table('brand')->where('category_id',3)->get();
        }
        else if($category == 'harvester'){
            $brandName    = DB::table('brand')->where('category_id',4)->get();
        }
        else if($category == 'implement'){
            $brandName    = DB::table('brand')->where('category_id',5)->get();
        }
        else if($category == 'tyre'){
            $brandName    = DB::table('brand')->where('category_id',7)->get();
        }

        return view('front.development.brand-product',['tr_data1'=>$tr_data,'brandName'=>$brandName,'bandId1'=>$brandId ,'sortByPrice'=>$request->flexRadioDefault ,'category' => $category]);
    }

    public function test(Request $request){

        $category   = $request->category;
        $type       = $request->type;
        //$type = 1;

        $data = [$request->category,$type];

        return $data;

    }

    /** Dibyendu Change on 28.10.2023 */
    public function companyWishCategory(){
        return view('front.development.new-product-list');
    }

    public function getCompanyProduct(Request $request,$category,$type,$companyId){

        //dd($category);
        if($category == 'tractor'){
           $company_product =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',1)->where('status',1)->get();
        }
        else if($category == 'goodvehice'){
            $company_product =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',3)->where('status',1)->get();
        }
        else if($category == 'harvester'){
            $company_product =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',4)->where('status',1)->get();
        }
        else if($category == 'implement'){
            $company_product =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',5)->where('status',1)->get();
        }
        else if($category == 'tyre'){
            $company_product =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',7)->where('status',1)->get();
        }
        else if($category == 'seed'){
            $company_product =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',6)->where('status',1)->get();
        }
        else if($category == 'pesticides'){
            $company_product =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',8)->where('status',1)->get();
        }
        else if($category == 'fertilizers'){
            $company_product =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',9)->where('status',1)->get();
        }

        return view('front.development.new-product-list',['company_product'=>$company_product]);

    }

    public function dealerPageCompany(Request $request ,$companyId){
       // dd($companyId);
        if(!empty($companyId)){
            $company= DB::table('company_product')->where('id',$companyId)->first();
          //  dd($company);
            $company_price       = $company->price;
            $product_name        = $company->product_name;
            $product_image       = $company->product_image;
            $company_description = $company->description;
            $company_id          = $company->company_id;
           // dd($company_id);

          $pincode = $request->session()->get('pincode');
         // dd($pincode);
          $pindata   = DB::table('city')->where(['pincode'=>$pincode])->first();
          $latitude  = $pindata->latitude;
          $longitude = $pindata->longitude;

          //  $dealer = DB::table('user')->where('company_id',$company_id)->where('user_type_id',2)->where('status',1)->get();
            if($company_id == 1 || $company_id == 11 || $company_id == 12 ){
              //  dd($company_id);
              $dealer = DB::table('user')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(user.lat))
                        * cos(radians(user.long) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(user.lat))) AS distance"))
                        ->where('company_id',1)
                        ->where('user_type_id',2)
                        ->where('status',1)
                        ->get();

                //dd($dealer);

            }else{
                $dealer = DB::table('user')
                        ->select('*'
                        , DB::raw("6371 * acos(cos(radians(" .$latitude. "))
                        * cos(radians(user.lat))
                        * cos(radians(user.long) - radians(" .$longitude. "))
                        + sin(radians(" .$latitude. "))
                        * sin(radians(user.lat))) AS distance"))
                        ->where('company_id',$company_id)
                        ->where('user_type_id',2)
                        ->where('status',1)
                        ->get();

            }
            
           
            //dd($dealer);
        }
        return view('front.development.new-product-dealer',['company_price'=>$company_price ,'product_name' =>$product_name,
        'product_image' =>$product_image,'company_description' =>$company_description,'dealer' =>$dealer,'company_id' =>$company_id]);
    }

    public function searchCompanyProduct(Request $request,$category,$companyId){
        // dd($companyId);
         //dd($request->all());
        
        try{
            if(!empty($request->filter)){
                $company_product = DB::table('company_product')
                            ->where('product_name','LIKE','%'.$request->filter.'%')
                            ->where('company_id',$companyId)
                            ->where('status',1);

            if($category == 'tractor'){
                //dd($category);
                $company_product->where('category_id',1);
            }
            if($category == 'goodvehice'){
                $company_product->where('category_id',3);
            }
            if($category == 'harvester'){
                $company_product->where('category_id',4);
            }
            if($category == 'implement'){
                $company_product->where('category_id',5);
            }
            if($category == 'tyre'){
                $company_product->where('category_id',7);
            }
            if($category == 'seed'){
                $company_product->where('category_id',6);
            }
            if($category == 'pesticides'){
                $company_product->where('category_id',8);
            }
            if($category == 'fertilizers'){
                $company_product->where('category_id',9);
            }
                           
            $company_product1 = $company_product->get();

            }else{
                //$query = []; 
                if($category == 'tractor'){
                    $company_product1 =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',1)->where('status',1)->get();
                }
                else if($category == 'goodvehice'){
                    $company_product1 =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',3)->where('status',1)->get();
                }
                else if($category == 'harvester'){
                    $company_product1 =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',4)->where('status',1)->get();
                }
                else if($category == 'implement'){
                    $company_product1 =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',5)->where('status',1)->get();
                }
                else if($category == 'tyre'){
                    $company_product1 =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',7)->where('status',1)->get();
                }
                else if($category == 'seed'){
                    $company_product1 =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',6)->where('status',1)->get();
                }
                else if($category == 'pesticides'){
                    $company_product1 =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',8)->where('status',1)->get();
                }
                else if($category == 'fertilizers'){
                    $company_product1 =  DB::table('company_product')->where('company_id',$companyId)->where('category_id',9)->where('status',1)->get();
                }
          
            }
            
           // dd($company_product1);

            return view('front.development.new-product-list',['company_product'=>$company_product1 , 'value' => $request->filter]);

        }catch(\Exception $e){
            return [
                'success' => false,
                'message' => $e
            ];
        }

    }
    
}
