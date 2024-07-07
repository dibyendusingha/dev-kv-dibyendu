
@extends('layout.main')
@section('page-container')

<style>
    /*PAGINATION*/
.paginate{
    margin-top: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pagination{
    gap: 20px;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}
.page-item.disabled .page-link{
    color: white;
    font-weight: 400;
}
.page-item .page-link{
        background: linear-gradient(33deg,#13693a,#8cbf44);
        color: white;
        font-weight: 400;
}

.page-item .page-link:hover{
    cursor: pointer;
    transform: scale(1.2);
    transition: all ease 0.3s;
}
.page-item.active .page-link{
    background: #212529 !important;
}

.page-item:first-child .page-link{
        background: #212529;
    border-radius: 46%;
    border: 3px solid #8dbf45;
}
.page-item:last-child .page-link{
        background: #212529;
    border-radius: 46%;
    border: 3px solid #8dbf45;
}

.page-item:first-child .page-link:hover,
.page-item:last-child .page-link:hover{
    transform: scale(1);
}
</style>

<?php
use Illuminate\Support\Facades\DB;
    $url = Request::path();
    $exp = explode ('/',$url);
    
    // if($exp[0] == 'filter-brand'){
    //     echo $exp[0];
    //     echo $type = $exp[1];
    //     echo $bandId = $exp[2];
    //     echo $_GET['flexRadioDefault'];
    // }
     if(!empty($exp[2]) && !empty($exp[3])){
        $category = $exp[1];
        $type     = $exp[2];
        $bandId   = $exp[3];
    }
    else{
        $type = '';
    }
?>

<section class="brand-product-body">
    <div class="container">
        <div class="row">
            <div class="col-md-3 bp-filter p-4 border-end">
                <a href="#" class="bp-filter-btn-toggle d-md-none d-block"><i class="fa-solid fa-filter"></i></a>
                
                <form action="{{url('filter-brand',[$category,$type,$bandId])}}" method="post">
                @csrf
                    <h5><i class="fa-solid fa-filter"></i> FILTER</h5> 
                <div class="bp-filter-box">
                    <div class="bp-sort">
                        <p>PRICE</p>
                        <div class="form-check">
                            <?php if(!empty($sortByPrice)){ ?>
                            <input class="form-check-input" type="radio" name="flexRadioDefault" value="phl" id="flexRadioDefault1" <?php if($sortByPrice == 'phl') {echo 'checked';}?>>
                            <?php }else{ ?>
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="phl" id="flexRadioDefault1">
                            <?php } ?>
                            <label class="form-check-label" for="flexRadioDefault1">
                                High to Low
                            </label>
                        </div>
                        <div class="form-check">
                        <?php if(!empty($sortByPrice)){ ?>
                            <input class="form-check-input" type="radio" name="flexRadioDefault" value="plh" id="flexRadioDefault1" <?php if($sortByPrice == 'plh') {echo 'checked';}?>>
                            <?php }else{ ?>
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="plh" id="flexRadioDefault1">
                        <?php } ?>
                          <label class="form-check-label" for="flexRadioDefault2">
                            Low to High
                          </label>
                        </div>
                        <div class="form-check">
                        <?php if(!empty($sortByPrice)){ ?>
                            <input class="form-check-input" type="radio" name="flexRadioDefault" value="nf" id="flexRadioDefault1" <?php if($sortByPrice == 'nf') {echo 'checked';}?>>
                            <?php }else{ ?>
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="nf" id="flexRadioDefault1">
                        <?php } ?>
                        
                          <label class="form-check-label" for="flexRadioDefault2">
                            Newest First
                          </label>
                        </div>
                    </div>
                    
                    <div class="bp-brand-list">
                        <!-- Testing -->
                        <?php if($exp[0] == 'filter-brand'){ ?>
                        <div class="accordion-item d-none">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" >
                                    Price
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="phl" name="sort[]" id="trac-new"
                                        <?php if (session()->has('sort')) { if (in_array('phl', session()->get('sort'))) {echo 'checked';} } ?> >
                                        <label class="form-check-label" for="trac-new">
                                            phl
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="plh" name="sort[]" id="trac-old"
                                        <?php if (session()->has('sort')) { if(in_array('plh', session()->get('sort'))) {echo 'checked';} }?> >
                                        <label class="form-check-label" for="trac-old">
                                            plh
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="nf" name="sort[]" id="trac-old" 
                                        <?php if (session()->has('sort')) { if(in_array('nf', session()->get('sort'))) {echo 'checked';} }?> >
                                        <label class="form-check-label" for="trac-old">
                                            nf
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- Testing -->


                        <div class="accordion-item d-none">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" >
                                    Condition
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="new" name="condition[]" id="trac-new" <?php if ($type=='new') {echo 'checked';} else if ($type=='rent') {} ?>
                                        <?php if (session()->has('condition')) { if (in_array('new', session()->get('condition'))) {echo 'checked';} } ?> >
                                        <label class="form-check-label" for="trac-new">
                                            New
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="old" name="condition[]" id="trac-old" <?php if ($type=='old') {echo 'checked';} else if ($type=='rent') {} ?>
                                        <?php if (session()->has('condition')) { if(in_array('old', session()->get('condition'))) {echo 'checked';} }?> >
                                        <label class="form-check-label" for="trac-old">
                                            Used
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="rent" name="condition[]" id="trac-old" <?php if ($type=='rent') {echo 'checked';} else if ($type=='old') {} ?>
                                        <?php if (session()->has('condition')) { if(in_array('rent', session()->get('condition'))) {echo 'checked';} }?> >
                                        <label class="form-check-label" for="trac-old">
                                            Rent
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion" id="accordionExample">
                              <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    BRANDS
                                  </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                  <div class="accordion-body">
                                    
                                    @foreach($brandName as $val1)
                                    <?php 
                                        if($category == 'tractor'){
                                            if($type == 'rent'){
                                                $brandDataCount =  DB::table('tractorView')->where('brand_id',$val1->id)->where('set',$type)->whereIn('status',[1,4])->count();
                                            }else{
                                                $brandDataCount =  DB::table('tractorView')->where('brand_id',$val1->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                            }
                                        }
                                        else if($category == 'goodvehice'){
                                            if($type == 'rent'){
                                                $brandDataCount =  DB::table('goodVehicleView')->where('brand_id',$val1->id)->where('set',$type)->whereIn('status',[1,4])->count();
                                            }else{
                                                $brandDataCount =  DB::table('goodVehicleView')->where('brand_id',$val1->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                            }
                                        }
                                        else if($category == 'harvester'){
                                            if($type == 'rent'){
                                                $brandDataCount =  DB::table('harvesterView')->where('brand_id',$val1->id)->where('set',$type)->whereIn('status',[1,4])->count();
                                            }else{
                                                $brandDataCount =  DB::table('harvesterView')->where('brand_id',$val1->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                            }
                                        }
                                        else if($category == 'implement'){
                                            if($type == 'rent'){
                                                $brandDataCount =  DB::table('implementView')->where('brand_id',$val1->id)->where('set',$type)->whereIn('status',[1,4])->count();
                                            }else{
                                                $brandDataCount =  DB::table('implementView')->where('brand_id',$val1->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                            }
                                        }
                                        else if($category == 'tyre'){
                                            if($type == 'old'){
                                                $brandDataCount =  DB::table('tyresView')->where('brand_id',$val1->id)->where('type',$type)->whereIn('status',[1,4])->count();
                                            }
                                        }
                                        if($brandDataCount >= 1){ 
                                    ?>
                                    <div class="form-check">
                                        <?php if(!empty($bandId1)){ ?>
                                            <input class="form-check-input" type="radio" name="brand" value="{{$val1->id}}" id="flexCheckDefault" <?php if($bandId1 == $val1->id) {echo 'checked';}?>>
                                        <?php }else {?>
                                            <input class="form-check-input" type="radio" name="brand" value="{{$val1->id}}" id="flexCheckDefault" <?php if($bandId == $val1->id) {echo 'checked';}?>>
                                        <?php } ?>

                                      <label class="form-check-label" for="flexCheckDefault">
                                      {{$val1->name}} ({{$brandDataCount }})
                                      </label>
                                    </div>
                                    <?php } ?>
                                    @endforeach
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn text-center fw-bold text-white">APPLY</button>
                </div>
                </form>
            </div>
            
            <div class="col-md-9 p-4">
                <?php if(isset($tr_data)){?>
                <div class="brand-product-container">
                    <div class="row">
                        <?php foreach ($tr_data as $val1) { ?>
                            <div class="col-lg-4 col-6 mb-3">
                                <div class="bp-card">
                                    <div class="bp-top">
                                        <?php if($val1->status == 4){ ?>
                                            <?php if($category == 'tyre'){ ?>
                                                <a href="{{ url('tyre/'.$val1->id) }}">
                                                    {{-- <img src="<?= env('APP_URL')."storage/tyre/$val1->image1"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                    <img src="{{asset('storage/tyre/'.$val1->image1)}}" alt="brand-product-image" class="img-fluid"/>
                                                    <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">
                                                </a>
                                            <?php }else if($category == 'goodvehice'){ ?>
                                                <a href="{{ url('good-vahicle/'.$val1->id) }}">
                                                    {{-- <img src="<?= env('APP_URL')."storage/goods_vehicle/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                    <img src="{{asset('storage/goods_vehicle/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid"/>
                                                    <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">
                                                </a>
                                            <?php  }else if($category == 'harvester'){  ?>
                                                <a href="{{ url('harvester/'.$val1->id) }}">
                                                    {{-- <img src="<?= env('APP_URL')."storage/harvester/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                    <img src="{{asset('storage/harvester/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid"/>
                                                    <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">
                                                </a>
                                            <?php }else if($category == 'implement'){ ?>
                                                <a href="{{ url('implements/'.$val1->id) }}">
                                                    {{-- <img src="<?= env('APP_URL')."storage/implements/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                    <img src="{{asset('storage/implements/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid"/>
                                                    <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">
                                                </a>
                                            <?php }else{?>
                                                <a href="{{ url('tractor/'.$val1->id) }}">
                                                    {{-- <img src="<?= env('APP_URL')."storage/tractor/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                    <img src="{{asset('storage/tractor/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid"/>
                                                    <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">
                                                    
                                                </a>
                                            <?php }?>
                                        <?php }else{ ?>
                                            <!-- <a href="{{ url('tractor/'.$val1->id) }}"> -->
                                                <?php if($category == 'tyre'){ ?>
                                                    <a href="{{ url('tyre/'.$val1->id) }}">
                                                        {{-- <img src="<?= env('APP_URL')."storage/tyre/$val1->image1"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                        <img src="{{asset('storage/tyre/'.$val1->image1)}}" alt="brand-product-image" class="img-fluid"/>
                                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">
                                                    </a>
                                                <?php }else if($category == 'goodvehice'){ ?>
                                                    <a href="{{ url('good-vahicle/'.$val1->id) }}">
                                                        {{-- <img src="<?= env('APP_URL')."storage/goods_vehicle/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                        <img src="{{asset('storage/goods_vehicle/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid"/>
                                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">
                                                    </a>
                                                <?php  }else if($category == 'harvester'){  ?>
                                                    <a href="{{ url('harvester/'.$val1->id) }}">
                                                        {{-- <img src="<?= env('APP_URL')."storage/harvester/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                        <img src="{{asset('storage/harvester/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid"/>
                                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">
                                                    </a>
                                                <?php }else if($category == 'implement'){ ?>
                                                    <a href="{{ url('implements/'.$val1->id) }}">
                                                        {{-- <img src="<?= env('APP_URL')."storage/implements/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                        <img src="{{asset('storage/implements/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid"/>
                                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">
                                                    </a>
                                                <?php }else{?>
                                                    <a href="{{ url('tractor/'.$val1->id) }}">
                                                        {{-- <img src="<?= env('APP_URL')."storage/tractor/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                        <img src="{{asset('storage/tractor/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid"/>
                                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">
                                                    </a>
                                                <?php }?>
                                            <!-- </a> -->
                                        <?php } ?>
                                        <?php
                                            $brand_arr_data = DB::table('brand')->where(['id'=>$val1->brand_id])->first();
                                            $brand_name     = $brand_arr_data->name;
                                            $model_arr_data = DB::table('model')->where(['id'=>$val1->model_id])->first();
                                            $model_name     = $model_arr_data->model_name;
                                            $state_arr_data = DB::table('district')->where(['id'=>$val1->district_id])->first();
                                            $district_name  = $state_arr_data->district_name;
                                            $city_arr_data  = DB::table('city')->where(['pincode'=>$val1->pincode])->first();
                                            $city_name      = $city_arr_data->city_name;
                                        ?>
                                        <div class="bp-location">
                                            <p class="m-0"><i class="fa-solid fa-location-dot"></i> {{$city_name}}</p>
                                        </div>
                                    </div>
                                    <div class="bp-card-content">
                                        <div class="bp-price">
                                            
                                            <p class="m-0"><i class="fa-solid fa-indian-rupee-sign"></i> {{$val1->price}}
                                            <?php if($category != 'tyre'){?>
                                                <?php if($val1->set=='rent') {
                                                    if ($val1->rent_type=='Per Hour') {
                                                        echo '/hr';
                                                    } else if ($val1->rent_type=='Per Day') {
                                                        echo '/m';
                                                    } else if ($val1->rent_type=='Per Month') {
                                                        echo '/d';
                                                    }
                                                } ?>
                                            <?php } ?>
                                            </p>
                                        </div>
                                        <p class="fw-bolder bp-name">{{$brand_name}} {{$model_name}}</p>
                                    </div>
                                    <?php $distance = round($val1->distance); ?>
                                    <p class="distance m-0"><i class="fa-solid fa-location-arrow"></i>{{$distance}}km distance</p>
                                </div>
                            </div>
                        <?php }?>

                    </div>
                </div>
                <?php }?>

                <?php if(isset($tr_data1)){?>
                    {{-- <div class="brand-product-container">
                        <div class="row">
                            <?php foreach ($tr_data1 as $val1) { ?>
                                <div class="col-lg-4 col-6 mb-3">
                                    <div class="bp-card">
                                        <div class="bp-top">
                                            <?php if($val1->status == 4){ ?>
                                                <?php if($category == 'tyre'){ ?>
                                                    <img src="<?= env('APP_URL')."storage/tyre/$val1->image1"; ?>" alt="brand-product-image" class="img-fluid"/>
                                                <?php }if($category == 'goodvehice'){ ?>
                                                    <img src="<?= env('APP_URL')."storage/goods_vehicle/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/>
                                                <?php  }if($category == 'harvester'){  ?>
                                                    <img src="<?= env('APP_URL')."storage/harvester/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/>
                                                <?php }if($category == 'implement'){ ?>
                                                    <img src="<?= env('APP_URL')."storage/implements/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/>
                                                <?php }else{?>
                                                    <img src="<?= env('APP_URL')."storage/tractor/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/>
                                                <?php }?>
                                            <?php }else{ ?>
                                                <?php if($category == 'tyre'){ ?>
                                                    <a href="{{ url('tyre/'.$val1->id) }}">
                                                        <img src="<?= env('APP_URL')."storage/tyre/$val1->image1"; ?>" alt="brand-product-image" class="img-fluid"/>
                                                    </a>
                                                <?php }if($category == 'goodvehice'){ ?>
                                                    <a href="{{ url('good-vahicle/'.$val1->id) }}">
                                                        <img src="<?= env('APP_URL')."storage/goods_vehicle/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/>
                                                    </a>
                                                <?php  }if($category == 'harvester'){  ?>
                                                    <a href="{{ url('harvester/'.$val1->id) }}">
                                                        <img src="<?= env('APP_URL')."storage/harvester/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/>
                                                    </a>
                                                <?php }if($category == 'implement'){ ?>
                                                    <a href="{{ url('implements/'.$val1->id) }}">
                                                        <img src="<?= env('APP_URL')."storage/implements/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/>
                                                    </a>
                                                <?php }else{?>
                                                    <a href="{{ url('tractor/'.$val1->id) }}">
                                                        <img src="<?= env('APP_URL')."storage/tractor/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/>
                                                    </a>
                                                <?php }?>
                                            <?php } ?>
                                            <?php
                                                $brand_arr_data = DB::table('brand')->where(['id'=>$val1->brand_id])->first();
                                                $brand_name     = $brand_arr_data->name;
                                                $model_arr_data = DB::table('model')->where(['id'=>$val1->model_id])->first();
                                                $model_name     = $model_arr_data->model_name;
                                                $state_arr_data = DB::table('district')->where(['id'=>$val1->district_id])->first();
                                                $district_name  = $state_arr_data->district_name;
                                                $city_arr_data  = DB::table('city')->where(['pincode'=>$val1->pincode])->first();
                                                $city_name      = $city_arr_data->city_name;
                                            ?>
                                            <div class="bp-location">
                                                <p class="m-0"><i class="fa-solid fa-location-dot"></i> {{$city_name}}</p>
                                            </div>
                                        </div>
                                        <div class="bp-card-content">
                                            <div class="bp-price">
                                                <p class="m-0"><i class="fa-solid fa-indian-rupee-sign"></i> {{$val1->price}}
                                                <?php if($category != 'tyre'){?>
                                                    <?php if($val1->set=='rent') {
                                                        if ($val1->rent_type=='Per Hour') {
                                                            echo '/hr';
                                                        } else if ($val1->rent_type=='Per Day') {
                                                            echo '/m';
                                                        } else if ($val1->rent_type=='Per Month') {
                                                            echo '/d';
                                                        }
                                                    } ?>
                                                <?php } ?>
                                                </p>
                                            </div>
                                            <p class="fw-bolder bp-name">{{$brand_name}} {{$model_name}}</p>
                                        </div>
                                        <?php $distance = round($val1->distance); ?>
                                        <p class="distance m-0"><i class="fa-solid fa-location-arrow"></i>{{$distance}}km distance</p>
                                    </div>
                                </div>
                            <?php }?>

                        </div>
                    </div> --}}
                    <div class="brand-product-container">
                        <div class="row">
                            <?php foreach ($tr_data1 as $val1) { ?>
                                <div class="col-lg-4 col-6 mb-3">
                                    <div class="bp-card">
                                        <div class="bp-top">
                                            <?php if($val1->status == 4){ ?>
                                                <?php if($category == 'tyre'){ ?>
                                                    <a href="{{ url('tyre/'.$val1->id) }}">
                                                        {{-- <img src="<?= env('APP_URL')."storage/tyre/$val1->image1"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                        <img src="{{asset('storage/tyre/'.$val1->image1)}}" alt="brand-product-image" class="img-fluid shadow"/>
                                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0%;object-fit: contain;width: 120px !important;top:20%;">

                                                    </a>
                                                <?php }else if($category == 'goodvehice'){ ?>
                                                    <a href="{{ url('good-vahicle/'.$val1->id) }}">
                                                        {{-- <img src="<?= env('APP_URL')."storage/goods_vehicle/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                        <img src="{{asset('storage/goods_vehicle/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid shadow"/>
                                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:20%;">
                                                    </a>
                                                <?php  }else if($category == 'harvester'){  ?>
                                                    <a href="{{ url('harvester/'.$val1->id) }}">
                                                        {{-- <img src="<?= env('APP_URL')."storage/harvester/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                        <img src="{{asset('storage/harvester/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid shadow"/>
                                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:20%;">
                                                    </a>
                                                <?php }else if($category == 'implement'){ ?>
                                                    <a href="{{ url('implements/'.$val1->id) }}">
                                                        {{-- <img src="<?= env('APP_URL')."storage/implements/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                        <img src="{{asset('storage/implements/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid shadow"/>
                                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:20%;">
                                                    </a>
                                                <?php }else{?>
                                                    <a href="{{ url('tractor/'.$val1->id) }}">
                                                        {{-- <img src="<?= env('APP_URL')."storage/tractor/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                        <img src="{{asset('storage/tractor/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid shadow"/>
                                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:20%;">
                                                        
                                                    </a>
                                                <?php }?>
                                            <?php }else{ ?>
                                                <!-- <a href="{{ url('tractor/'.$val1->id) }}"> -->
                                                    <?php if($category == 'tyre'){ ?>
                                                        <a href="{{ url('tyre/'.$val1->id) }}">
                                                            {{-- <img src="<?= env('APP_URL')."storage/tyre/$val1->image1"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                            <img src="{{asset('storage/tyre/'.$val1->image1)}}" alt="brand-product-image" class="img-fluid shadow"/>
                                                            <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:20%;">
                                                        </a>
                                                    <?php }else if($category == 'goodvehice'){ ?>
                                                        <a href="{{ url('good-vahicle/'.$val1->id) }}">
                                                            {{-- <img src="<?= env('APP_URL')."storage/goods_vehicle/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                            <img src="{{asset('storage/goods_vehicle/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid shadow"/>
                                                            <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:20%;">
                                                        </a>
                                                    <?php  }else if($category == 'harvester'){  ?>
                                                        <a href="{{ url('harvester/'.$val1->id) }}">
                                                            {{-- <img src="<?= env('APP_URL')."storage/harvester/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                            <img src="{{asset('storage/harvester/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid shadow"/>
                                                            <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:20%;">
                                                        </a>
                                                    <?php }else if($category == 'implement'){ ?>
                                                        <a href="{{ url('implements/'.$val1->id) }}">
                                                            {{-- <img src="<?= env('APP_URL')."storage/implements/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                            <img src="{{asset('storage/implements/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid shadow"/>
                                                            <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:20%;">
                                                        </a>
                                                    <?php }else{?>
                                                        <a href="{{ url('tractor/'.$val1->id) }}">
                                                            {{-- <img src="<?= env('APP_URL')."storage/tractor/$val1->front_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                            <img src="{{asset('storage/tractor/'.$val1->front_image)}}" alt="brand-product-image" class="img-fluid shadow"/>
                                                            <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:20%;">
                                                            
                                                        </a>
                                                    <?php }?>
                                                <!-- </a> -->
                                            <?php } ?>
                                            <?php
                                                $brand_arr_data = DB::table('brand')->where(['id'=>$val1->brand_id])->first();
                                                $brand_name     = $brand_arr_data->name;
                                                $model_arr_data = DB::table('model')->where(['id'=>$val1->model_id])->first();
                                                $model_name     = $model_arr_data->model_name;
                                                $state_arr_data = DB::table('district')->where(['id'=>$val1->district_id])->first();
                                                $district_name  = $state_arr_data->district_name;
                                                $city_arr_data  = DB::table('city')->where(['pincode'=>$val1->pincode])->first();
                                                $city_name      = $city_arr_data->city_name;
                                            ?>
                                            <div class="bp-location">
                                                <p class="m-0"><i class="fa-solid fa-location-dot"></i> {{$city_name}}</p>
                                            </div>
                                        </div>
                                        <div class="bp-card-content">
                                            <div class="bp-price">
                                                <p class="m-0"><i class="fa-solid fa-indian-rupee-sign"></i> {{$val1->price}}
                                                <?php if($category != 'tyre'){?>
                                                    <?php if($val1->set=='rent') {
                                                        if ($val1->rent_type=='Per Hour') {
                                                            echo '/hr';
                                                        } else if ($val1->rent_type=='Per Day') {
                                                            echo '/m';
                                                        } else if ($val1->rent_type=='Per Month') {
                                                            echo '/d';
                                                        }
                                                    } ?>
                                                <?php } ?>
                                                </p>
                                            </div>
                                            <p class="fw-bolder bp-name">{{$brand_name}} {{$model_name}}</p>
                                        </div>
                                        <?php $distance = round($val1->distance); ?>
                                        <p class="distance m-0"><i class="fa-solid fa-location-arrow"></i>{{$distance}}km distance</p>
                                    </div>
                                </div>
                            <?php }?>
    
                        </div>
                    </div>
                
                <?php }?>

                <?php
                    if(!empty($tr_data)){
                    ?>
                    <nav> {{$tr_data->links()}}</nav>
                <?php }?>
            </div>
           
            
        </div>
        
    </div>
    
</section>

<!--FILTER TOGGLE JS-->
<script>

   $(document).ready(function() {
    const $bpTogg = $(".bp-filter-btn-toggle");
    const $bpBody = $(".bp-filter");

    $bpTogg.click(function() {
        $bpBody.toggleClass("active-bp-filter");
    });
    });

</script>

    @endsection
