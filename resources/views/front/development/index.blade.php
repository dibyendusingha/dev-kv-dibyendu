@extends('layout.main')
@section('page-container')
<?php
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();
?>

<div class="preloader">

       <img src="{{url('assets/images/preloader-logo.png')}}" alt="">
       <div class="preloader-orbit-loading">

           <div class="cssload-inner cssload-one"></div>
           <div class="cssload-inner cssload-two"></div>
           <div class="cssload-inner cssload-three"></div>
       </div>


   </div>

    <!-- BANNER SECTION START -->
{{-- {{session()->get('pincode')}} --}}
    <section class="banner">
        <div class="container-fluid p-0">

            <?php if (session()->has('bn')) { ?>
                <div class="owl-carousel owl-theme">
                    <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/mahindra banner.jpeg')}}" alt="" class="img-fluid">
                </div>

                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/1_bengali.jpg')}}" alt="" class="img-fluid">
                </div>
                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/2_bengali.jpg')}}" alt="" class="img-fluid">
                </div>
                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/3_bengali.jpg')}}" alt="" class="img-fluid">
                </div>
            </div>
                <?php } else if (session()->has('hn')) { ?>
                <div class="owl-carousel owl-theme">
    
                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/mahindra banner.jpeg')}}" alt="" class="img-fluid">
                </div>
                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/1_hindi.jpg')}}" alt="" class="img-fluid">
                </div>
                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/2_hindi.jpg')}}" alt="" class="img-fluid">
                </div>
                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/3_hindi.jpg')}}" alt="" class="img-fluid">
                </div>
            </div>
                <?php } else { ?>
                
                
            <div class="owl-carousel owl-theme">
                
                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/mahindra banner.jpeg')}}" alt="" class="img-fluid">
                </div>
                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/1.jpg')}}" alt="" class="img-fluid">
                </div>
                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/2.jpg')}}" alt="" class="img-fluid">
                </div>
                <div class="item">
                    <img src="{{ URL::asset('assets/images/banner/3.jpg')}}" alt="" class="img-fluid">
                </div>
            </div>
            <?php } ?>

            
        </div>
    </section>

    <!-- BANNER SECTION END -->


    <!-- CATEGORY SECTION START -->

    <section class="category">
        <div class="container-fluid p-0">
            <!-- <div class="cat-head">
                <h1>CATEGORY</h1>
                <div class="gray">

                </div>
                <div class="black">

                </div>
            </div> -->
            <div class="category-head">
                <h1 class="text-center pt-lg-5 pt-0 fs-3 d-md-block d-none"><i class="ri-layout-grid-fill me-2"></i>Top Categories</h1>
            </div>
            <div class="cat-content-list ">
            <a id="cat_tractor" href="{{url('tractor-list/old')}}">
                    <div class="cat-image-box">
                        <div class="cat-img">
                            
                            <img src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}"
                                    alt="" class="cat-shadow">
                        </div>
                        <p>
                            <?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                            else { echo 'TRACTOR'; } 
                            ?>
                        </p>
                    </div>
            </a>
            <a id="cat_gv" href="{{url('good-vehicle-list/old')}}">
                <div class="cat-image-box">
                    <div class="cat-img">
                        <img src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}" alt="" class="cat-shadow">
                    </div>
                    <p><?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                        else { echo 'GOODS VEHICLE'; } 
                        ?></p>
                </div>
            </a>
            <a id="cat_seeds" href="{{url('seed-list')}}">
                <div class="cat-image-box">
                    <div class="cat-img">
                        <img src="{{ URL::asset('assets/images/cat-logos/seeds-removebg-preview.png')}}" alt="" class="cat-shadow">
                    </div>
                    <p><?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];} 
                        else { echo 'SEEDS'; } 
                        ?></p>
                </div>
            </a>
            <a id="cat_pesticide" href="{{url('pesticides-list')}}">        
                <div class="cat-image-box">
                    <div class="cat-img">
                        <img src="{{ URL::asset('assets/images/cat-logos/pesticide-removebg-preview.png')}}" alt="" class="cat-shadow">
                    </div>
                    <p><?php if (session()->has('bn')) {echo $lang['bn']['PESTICIDES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['PESTICIDES'];} 
                        else { echo 'PESTICIDES'; } 
                        ?></p>
                </div>
            </a>
            <a id="cat_fertilizer" href="{{url('fertilizer-list')}}">
                <div class="cat-image-box">
                    <div class="cat-img">
                        <img src="{{ URL::asset('assets/images/cat-logos/fertilizer-removebg-preview.png')}}" alt="" class="cat-shadow">
                    </div>
                    <p><?php if (session()->has('bn')) {echo $lang['bn']['FERTILIZERS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['FERTILIZERS'];} 
                        else { echo 'FERTILIZERS'; } 
                        ?></p>
                </div>
            </a>
            <a id="cat_harvester" href="{{url('harvester-list/old')}}">
                <div class="cat-image-box">
                    <div class="cat-img">
                        <img src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}" alt="" class="cat-shadow">
                    </div>
                    <p><?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                        else { echo 'HARVESTER'; } 
                        ?></p>
                </div>
            </a>
            <a id="cat_implements" href="{{url('implements-list/old')}}">
                <div class="cat-image-box">
                    <div class="cat-img">
                        <img src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}" alt="" class="cat-shadow">
                    </div>
                    <p><?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                        else { echo 'IMPLEMENTS'; } 
                        ?></p>
                </div>
            </a>

                
            <a id="cat_tyre" href="{{url('tyre-list/old')}}">
                <div class="cat-image-box">
                    <div class="cat-img">
                        <img src="{{ URL::asset('assets/images/cat-logos/tyre-removebg-preview.png')}}" alt="" class="cat-shadow">
                    </div>
                    <p><?php if (session()->has('bn')) {echo $lang['bn']['TYRES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['TYRES'];} 
                        else { echo 'TYRES'; } 
                        ?></p>
                </div>
            </a>
            </div>
        </div>
    </section>

    <!-- CATEGORY SECTION END -->

    <section class="bs-banner d-md-none d-block">
        <div class="container-fluid">
            <h1>What would you like to do?</h1>
            <div class="bs-btns">
                <button class="r-btn"><?php if (session()->has('bn')) {echo $lang['bn']['RENT'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['RENT'];} 
                    else { echo 'RENT'; } 
                    ?></button>
                <button class="s-btn"><?php if (session()->has('bn')) {echo $lang['bn']['SELL'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['SELL'];} 
                    else { echo 'SELL'; } 
                    ?></button>
            </div>
        </div>
    </section>
    
    <a href="#" class="d-none"><img src="{{ URL::asset('assets/images/banner/mahindra banner.jpeg')}}" alt="mahindra banner" class="img-fluid"></a>

    <!-- TRACTOR SECTION START -->

    <section class="tractor">
        <div class="container-fluid p-0">
            <div class="tractor-header row m-0">
                <div class="col-md-5 h1">
                    <h1><?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                        else { echo 'TRACTOR'; } 
                        ?></h1>
                </div>

                <div class="col-md-7 d-flex justify-content-between listing pe-4">
                    <div class="options">
                        <ul>
                            <li id="rent-t"><a href="#" id="" class="tractor_rent ">
                                <?php if (session()->has('bn')) {echo $lang['bn']['RENT'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['RENT'];} 
                                else { echo 'RENT'; } 
                                ?></a></li>
                            <div class="ver-shadow"></div>
                            <li id="used-t"><a href="#" id="" class="tractor_used ">
                                <?php if (session()->has('bn')) {echo $lang['bn']['USED'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['USED'];} 
                                else { echo 'USED'; } 
                                ?></a></li>
                            <div class="ver-shadow"></div>
                            <li id="new-t"><a href="#" id="" class="tractor_new active-option">
                                <?php if (session()->has('bn')) {echo $lang['bn']['NEW'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['NEW'];} 
                                else { echo 'NEW'; } 
                                ?></a></li>
                            
                        </ul>
                    </div>

                    
                </div>


            </div>
            
            <!-- /** Dibyendu Change 22.09.2023 */ -->
            <!-- new section start -->
            <div id="new-carousel-t">
            <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                                                <a href="{{url('mahindra-all-product')}}">
                                    <div class="items d-flex  align-items-center justify-content-center">
                                        <div class="company-log-box">
                                            
                                                <img src="https://krishivikas.com/storage/images/brands/mahindra.png" alt="company-logo" class="img-fluid"> 
                                              
                                        </div>
                                        <p class="mb-0">Mahindra</p>
                                    </div>
                                    </a>
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <div class="owl-carousel owl-theme" >
                            <div class="item">
                            </div>
                            <div class="item">
                            </div>
                            <div class="item">
                            </div>
                            <div class="item">
                            </div>
                            <div class="item">
                            </div>
                            <!--VIEW ALL CARD-->
                            <div class="item">
                                    <div class="tractor-list">
        
                                        <div class="tractor-img-box p-5">
                                            
                                            <div class="view-all-box">
                                                <a href="{{url('mahindra-all-product')}}">
                                                    <div class="v-gradient d-flex align-items-center justify-content-center">
                                                        <img src="http://krishivikas.com/storage/images/brands/mahindra.png" alt="logo"/>
                                                        <p class="vw-text text-center">
                                                            VIEW ALL
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                            
                                        </div>
        
                                    </div>
                            </div>
                </div>
                
               
                
                

            </div>
            <!-- new section end -->

            <!-- used section start -->
            <div id="used-carousel-t">
            <?php if(!empty($data['tractor'][0])){
                //print_r($data['tractor_new'][0]);
                ?>
                <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                           
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                <?php 
                                //print_r($data['tractor_new']);
                                foreach($data['tractor'] as $tr){ ?>
                                <a href="{{url('brand-product/tractor/old/'.$tr->id)}}">
                                    <div class="items d-flex  align-items-center justify-content-center">
                                        <div class="company-log-box">
                                            
                                                <img src="{{asset('storage/images/brands/'.$tr->logo)}}" alt="company-logo" class="img-fluid">  
                                           
                                        </div>
                                        <p class="mb-0">{{$tr->name}}</p>
                                    </div>
                                    </a> 
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php } ?>
                <!-- TRACTOR COMPANY LOGO END-->
                <div class="owl-carousel owl-theme" >
                <?php
                    //print_r($tractor_sell_new); exit;
                    //$tractor_sell_new1 = array_splice($tractor_sell_new, 0, 10);
                    $tr_count2 = $tractor_sell_old->count();
                    foreach ($tractor_sell_old as $val_tsn) {
                        //print_r($tractor_sell_new[0]);
                        // print_r($tractor_sell_new[0]);
                        // exit;
                    ?>
                        <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_tsn->status == 4) { ?>
                                        <img src="<?= env('APP_URL')."storage/tractor/$val_tsn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top: -17%;">
                                    <?php } else{ ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('tractor/'.$val_tsn->id) }}">
                                        <!-- <img src="{{$val_tsn->front_image}}" alt="" class="p-3 tractor-img"> -->
                                        <img src="<?= env('APP_URL')."storage/tractor/$val_tsn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top: -17%;">
                                    </a>
                                    <?php } ?>
                                    <div class="shadow-line">
                                    </div>

                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_tsn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_tsn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_tsn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_tsn->pincode])->first();
                                        // $city_name = $city_arr_data->city_name;
                                    ?>
                                    <p class="model_name">
                                        <?php
                                        // $string = $val_tsn['brand_name'].' '.$val_tsn['model_name']; 
                                        ?>
                                        {{$brand_name}} {{$model_name}}

                                    </p>

                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_tsn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_tsn->price}}</p>
                                    </div>
                                    <?php
                                        $distance = round($val_tsn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    <!--VIEW ALL CARD-->
                    <?php if($tr_count2 >4){ ?>
                        <div class="item">
                            <div class="tractor-list">
                                <div class="tractor-img-box p-5">
                                    <div class="view-all-box">
                                        <a href="{{url('tractor-list/old')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                </div>


            </div>
            <!-- used section end -->

            <!-- rent section start -->
            <div id="rent-carousel-t">
            <?php if(!empty($data['tractor'][0])){
                //print_r($data['tractor_new'][0]);
                ?>
                <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                <?php 
                                //print_r($data['tractor_new']);
                                foreach($data['tractor'] as $tr){ ?>
                                <a href="{{url('brand-product/tractor/rent/'.$tr->id)}}">
                                    <div class="items d-flex  align-items-center justify-content-center">
                                        <div class="company-log-box">
                                            
                                                <img src="{{asset('storage/images/brands/'.$tr->logo)}}" alt="company-logo" class="img-fluid"> 
                                              
                                        </div>
                                        <p class="mb-0">{{$tr->name}}</p>
                                    </div>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php } ?>
                <!-- TRACTOR COMPANY LOGO END-->
                <div class="owl-carousel owl-theme" >
                    <?php
                    //print_r($tractor_sell_new); exit;
                    //$tractor_sell_new1 = array_splice($tractor_sell_new, 0, 10);
                    $tr_count3 = $tractor_rent->count();
                    foreach ($tractor_rent as $val_tsn) {   
                    ?>
                        <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_tsn->status == 4) { ?>
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="<?= env('APP_URL')."storage/tractor/$val_tsn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top: -17%;">
                                    <?php }else{ ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('tractor/'.$val_tsn->id) }}">
                                        <!-- <img src="{{$val_tsn->front_image}}" alt="" class="p-3 tractor-img"> -->
                                        <img src="<?= env('APP_URL')."storage/tractor/$val_tsn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>
                                    <?php }  ?>

                                    <div class="shadow-line">

                                    </div>

                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_tsn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_tsn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_tsn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_tsn->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                    <p class="model_name">
                                        <?php
                                        // $string = $val_tsn['brand_name'].' '.$val_tsn['model_name']; 
                                        ?>
                                        {{$brand_name}} {{$model_name}}
                                    </p>
                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_tsn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_tsn->price}}
                                            <?php if ($val_tsn->set== 'rent') {
                                                if ($val_tsn->rent_type == 'Per Hour') {
                                                    echo '/hr';
                                                } else if ($val_tsn->rent_type == 'Per Month') {
                                                    echo '/m';
                                                } else if ($val_tsn->rent_type == 'Per Day') {
                                                    echo '/d';
                                                }
                                            } ?>
                                        </p>
                                    </div>
                                    <?php
                                        $distance = round($val_tsn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    <!--VIEW ALL CARD-->
                    <?php if($tr_count3 > 4){?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('tractor-list/rent')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                </div>

                
            </div>
            <!-- rent section end -->
        </div>
    </section>
    <!-- TRACTOR SECTION END -->



        
        <!-- YOUTUBE PROMOTION SECTION START -->
        <section class="youtube-video-promotion position-relative">
            <video autoplay muted loop id="myVideo" height="340">
                <source src="{{ URL::asset('assets/images/kv-video.mp4')}}" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
            <div class="playbtn-wrap ">
                <a href="https://youtu.be/s5h6HE5QfYc?si=TRAH_QH_Uw8nJ70c" class="play-yt-btn text-decoration-none" target="_blank"><i class="ri-arrow-right-s-fill"></i></a>
            </div>
            <div class="circles">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
            </div>
        <!-- <video width=""  class="video-4" id="yt-vdo">
                    <source src="{{ URL::asset('assets/images/kv-video.mp4')}}" type="video/mp4"> -->
        </section>
        <!-- YOUTUBE PROMOTION SECTION END-->
    

    
    <!-- GOOD VEHICLE SECTION START -->

    <section class="good-vehicle">
        <div class="container-fluid p-0">
            <div class="good-vehicle-header row m-0">
                <div class="col-md-5 h1">
                    <h1><?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                        else { echo 'GOODS VEHICLE'; } 
                        ?></h1>
                </div>

                <div class="col-md-7 d-flex justify-content-between listing pe-4">
                    <div class="options">
                        <ul>
                            <li><a href="#" class="good_vehicle_rent active-option" id="rent-g">
                                <?php if (session()->has('bn')) {echo $lang['bn']['RENT'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['RENT'];} 
                                else { echo 'RENT'; } 
                                ?></a></li>
                            <div class="ver-shadow"></div>
                            <li><a href="#" class="good_vehicle_used" id="used-g">
                                <?php if (session()->has('bn')) {echo $lang['bn']['USED'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['USED'];} 
                                else { echo 'USED'; } 
                                ?></a></li>
                            <div class="ver-shadow"></div>
                            <li><a href="#" class="good_vehicle_new" id="new-g">
                                <?php if (session()->has('bn')) {echo $lang['bn']['NEW'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['NEW'];} 
                                else { echo 'NEW'; } 
                                ?></a></li>
                            
                            
                        </ul>
                    </div>

                    
                </div>


            </div>
           
            <!-- Dibyendu Change 21.09.2023  -->
            <!-- new good vehicle section start-->
            <div id="new-carousel-g">
                <!-- GOOD VEHICLE COMPANY LOGO START-->
                <?php if(!empty($data['gv_new'][0])){?>
                <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                    <?php foreach($data['gv_new'] as $gv){ ?>
                                        <a href="{{url('company-product/goodvehice/new/'.$gv->id)}}">
                                    <div class="items d-flex  align-items-center justify-content-center">
                                        <div class="company-log-box">
                                            
                                                <img src="{{asset('storage/company/'.$gv->logo)}}"  alt="company-logo" class="img-fluid">
                                            
                                        </div>
                                        <p class="mb-0">{{$gv->name}}</p>
                                    </div>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- GOOD VEHICLE COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                    <?php
                    //$gv_sell_new1 = array_splice($gv_sell_new, 0, 10);
                    $gv_count1 = $gv_sell_new->count();
                    foreach ($gv_sell_new  as $val_tsn) {
                        //  print_r($gv_sell_new[0]);
                        //  exit;
                    ?>
                        <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box">
                                    
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}
                                    <?php if($val_tsn->status == 1){?>

                                    <a href="{{ url('good-vahicle/'.$val_tsn->id) }}">
                                        <img src="<?= env('APP_URL')."storage/goods_vehicle/$val_tsn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <!-- <img src="{{$val_tsn->front_image}}" alt="" class="p-3 tractor-img"> -->
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>

                                    <?php }else{ ?>
                                        <img src="<?= env('APP_URL')."storage/goods_vehicle/$val_tsn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php }?>

                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_tsn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_tsn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_tsn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_tsn->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                    <p class="model_name">
                                        <?php
                                        // $string = $val_tsn['brand_name'].' '.$val_tsn['model_name']; 
                                        ?>
                                        {{$brand_name}} {{$model_name}}

                                    </p>

                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_tsn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_tsn->price}}

                                        </p>
                                    </div>
                                    <?php
                                    $distance = round($val_tsn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    
                    <!--VIEW ALL CARD-->
                    <?php if($gv_count1 > 4){ ?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('good-vehicle-list/new')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                </div>

                
            </div>
            <!-- new good vehicle section end-->


            <!-- used good vehicle section start-->
            <div id="used-carousel-g">
                <!-- GOOD VEHICLE COMPANY LOGO START-->
                <?php if(!empty($data['gv'][0])){
                        //print_r($data['gv']);
                    ?>
                    <section class="company">
                        <div class="container-fluid">
                            <div class="row">
                               
                                <div class="col-lg-12">
                                    <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                        <?php foreach($data['gv'] as $gv){
                                            ?>
                                            <a href="{{url('brand-product/goodvehice/old/'.$gv->id)}}">
                                        <div class="items d-flex  align-items-center justify-content-center">
                                            <div class="company-log-box">
                                            
                                                <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                                <img src="{{asset('storage/images/brands/'.$gv->logo)}}"  alt="company-logo" class="img-fluid">
                                            
                                            </div>
                                            <p class="mb-0">{{$gv->name}}</p>
                                        </div>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- GOOD VEHICLE COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                    //$gv_sell_new1 = array_splice($gv_sell_new, 0, 10);
                    $gv_count2 = $gv_sell_old->count();
                    foreach ($gv_sell_old  as $val_tsn) {
                        //  print_r($gv_sell_new[0]);
                        //  exit;
                    ?>
                        <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box">
                                    
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}
                                    <?php if($val_tsn->status == 1){?>

                                    <a href="{{ url('good-vahicle/'.$val_tsn->id) }}">
                                        <!-- <img src="{{$val_tsn->front_image}}" alt="" class="p-3 tractor-img"> -->
                                        <img src="<?= env('APP_URL')."storage/goods_vehicle/$val_tsn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>

                                    <?php }else{ ?>
                                        <img src="<?= env('APP_URL')."storage/goods_vehicle/$val_tsn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php }?>

                                    <div class="shadow-line">

                                    </div>

                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_tsn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_tsn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_tsn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_tsn->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                    <p class="model_name">
                                        <?php
                                        // $string = $val_tsn['brand_name'].' '.$val_tsn['model_name']; 
                                        ?>
                                        {{$brand_name}} {{$model_name}}

                                    </p>

                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_tsn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_tsn->price}}

                                        </p>
                                    </div>
                                    <?php
                                    $distance = round($val_tsn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    <!--VIEW ALL CARD-->
                    <?php if($gv_count2 > 4){?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('good-vehicle-list/old')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                </div>

                
            </div>
            <!-- used good vehicle section end-->


            <!-- rent good vehicle section start-->
            <div id="rent-carousel-g">
                <!-- GOOD VEHICLE COMPANY LOGO START-->
                <?php if(!empty($data['gv'][0])){
                        //print_r($data['gv']);
                    ?>
                    <section class="company">
                        <div class="container-fluid">
                            <div class="row">
                                
                                <div class="col-lg-12">
                                    <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                        <?php foreach($data['gv'] as $gv){
                                            ?>
                                            <a href="{{url('brand-product/goodvehice/rent/'.$gv->id)}}">
                                        <div class="items d-flex  align-items-center justify-content-center">
                                        
                                            <div class="company-log-box">
                                                <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                                <img src="{{asset('storage/images/brands/'.$gv->logo)}}"  alt="company-logo" class="img-fluid">
                                            </div>
                                       
                                            <p class="mb-0">{{$gv->name}}</p>
                                        </div>
                                        </a> 
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- GOOD VEHICLE COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                    <?php
                    //$gv_sell_new1 = array_splice($gv_sell_new, 0, 10);
                    $gv_count3 = $gv_rent->count();
                    foreach ($gv_rent  as $val_tsn) {
                        //  print_r($gv_sell_new[0]);
                        //  exit;
                    ?>
                        <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box">
                                    
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}
                                    <?php if($val_tsn->status == 1){?>

                                    <a href="{{ url('good-vahicle/'.$val_tsn->id) }}">
                                        <!-- <img src="{{$val_tsn->front_image}}" alt="" class="p-3 tractor-img"> -->
                                        <img src="<?= env('APP_URL')."storage/goods_vehicle/$val_tsn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>

                                    <?php }else{ ?>
                                        <img src="<?= env('APP_URL')."storage/goods_vehicle/$val_tsn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php }?>

                                    <div class="shadow-line">

                                    </div>

                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_tsn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_tsn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_tsn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_tsn->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                    <p class="model_name">
                                        {{$brand_name}} {{$model_name}}
                                    </p>
                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_tsn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_tsn->price}}
                                            <?php if ($val_tsn->set== 'rent') {
                                                if ($val_tsn->rent_type == 'Per Hour') {
                                                    echo '/hr';
                                                } else if ($val_tsn->rent_type == 'Per Month') {
                                                    echo '/m';
                                                } else if ($val_tsn->rent_type == 'Per Day') {
                                                    echo '/d';
                                                }
                                            } ?>
                                        </p>
                                    </div>
                                    <?php
                                    $distance = round($val_tsn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    <!--VIEW ALL CARD-->
                    <?php  if($gv_count3 > 4) {?> 
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('good-vehicle-list/rent')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php }?>
                </div>

                
            </div>
            <!-- rent good vehicle section end-->
        </div>
    </section>
    <!-- GOOD VEHICLE SECTION END -->

    <!-- TRACTOR BANNER SECTION START -->
    <section class="trac-banner">
        <div class="container-fluid ">

            <div class="row justify-content-center">
                <div class="col-md-12">
                <a href="/iffco-product-page">
                    <!-- <img src="{{env('APP_URL')}}storage/iffco/iffco-bner-10.webp" alt="" class="img-fluid py-3 h-100 w-100"> -->
                    <img src="https://krishivikas.com/storage/iffco/iffco-bner-10.webp" alt="" class="img-fluid py-3 h-100 w-100">
                </a>
                </div>
            </div>
        </div>
    </section>

    <!-- TRACTOR BANNER SECTION END --> 
    <!--IFFCO SECTION START-->
    
    <!--<section class="iffco-section mb-3">-->
        
    <!--    <div class="container-fluid">-->
        
           
    <!--            <div class="item">-->
    <!--                <a href="/ifco-product-page"><img src="{{env('APP_URL')}}storage/iffco/iffco_banner-app.jpg" alt="" class="img-fluid"></a>-->
    <!--            </div>-->
                
            
        
    <!--    </div>-->
        
    <!--</section>-->
    
      <!--IFFCO SECTION END-->


    
    <!-- Others SECTION START -->

    <section class="seed">
        <div class="container-fluid p-0">
            <div class="seed-header row m-0">
                <div class="col-md-5 h1">
                    <h1 id="others_data">
                        <?php if (session()->has('bn')) {echo $lang['bn']['OTHERS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['OTHERS'];} 
                        else { echo 'OTHERS'; } 
                        ?></h1>
                </div>

                <div class="col-md-7 d-flex justify-content-between listing pe-4">
                    <div class="options">
                        <ul>
                            <li><a href="#" class="seeds active-option" id="seeds">
                                <?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];} 
                                else { echo 'SEEDS'; } 
                                ?></a>
                            </li>
                            <div class="ver-shadow"></div>
                            <li><a href="#" class="pesticides" id="pesticides">
                                <?php if (session()->has('bn')) {echo $lang['bn']['PESTICIDES'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['PESTICIDES'];} 
                                else { echo 'PESTICIDES'; } 
                                ?></a>
                            </li>
                            <div class="ver-shadow"></div>
                            <li><a href="#" class="fertilizer" id="fertilizer">
                                <?php if (session()->has('bn')) {echo $lang['bn']['FERTILIZERS'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['FERTILIZERS'];} 
                                else { echo 'FERTILIZERS'; } 
                                ?></a>
                            </li>

                        </ul>
                    </div>

                    
                </div>


            </div>
           
            <!-- /** Dibyendu Change 22.09.2023 */ -->
            <!-- seed carousel section start -->
            <div id="seedC">
                 <!-- SEEDS COMPANY LOGO START-->
                <?php if(!empty($data['seed_new'][0])){ ?>
                    <section class="company">
                        <div class="container-fluid">
                            <div class="row">
                                
                                <div class="col-lg-12">
                                    <div class="company-logos d-flex gap-3 justify-content-start overflow-auto pt-3">
                                        <?php foreach($data['seed_new'] as $key=>$value) {  
                                            // print_r($value );
                                            // exit();
                                        ?>
                                        <a href="{{url('company-product/seed/new/'.$value->id)}}">
                                        <div class="items d-flex  align-items-center justify-content-center">
                                            <div class="company-log-box">
                                              
                                                    <img src="<?= env('APP_URL')."storage/company/$value->logo"; ?>"  alt="company-logo" class="img-fluid">
                                            
                                            </div>
                                            <p class="mb-0">{{$value->name}}</p>
                                        </div>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- SEEDS COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                    //$seed1 = array_splice($seed, 0, 10);
                    $se_count = $seed->count();
                    foreach ($seed as $val_see) {
                    ?>
                        <div class="item">
                            <div class="seed-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_see->status == 4) { ?>
                                        <!--<img src="{{$val_see->image1}}" alt="" class="p-3">-->
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="<?= env('APP_URL')."storage/seeds/$val_see->image1"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php } else{?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('seed/'.$val_see->id) }}">
                                        <!-- <img src="{{$val_see->image1}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/seeds/$val_see->image1"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>
                                    <?php } ?>
                                    <div class="shadow-line">

                                    </div>
                                    <p class="model_name">
                                        <?php $string = $val_see->title; ?>
                                        {{Str::limit($string, 17, '...')}}
                                    </p>

                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_see->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_see->price}}</p>

                                    </div>
                                    <?php
                                        $distance = round($val_see->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>

                            </div>
                        </div>
                    <?php }
                    ?>
                    <!--VIEW ALL CARD-->
                    <?php if($se_count  > 4){?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('seed-list')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/seeds-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php }?>
                </div>

            </div>
            <!-- seed carousel section end-->
            
            <!-- pesti carousel section start -->
            <div id="pestiC">
                 <!-- PESTICIDES COMPANY LOGO START-->
                 <?php if(!empty($data['pesticides_new'][0])){
                //print_r($data['gv']); 
                ?>
                <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                    <?php foreach($data['pesticides_new'] as $pe){
                                        ?>
                                        <a href="{{url('company-product/pesticides/new/'.$pe->id)}}">
                                    <div class="items d-flex  align-items-center justify-content-center">
                                        <div class="company-log-box">
                                            
                                                <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                                <img src="{{asset('storage/company/'.$pe->logo)}}"  alt="company-logo" class="img-fluid">
                                            
                                        </div>
                                        <p class="mb-0">{{$pe->name}}</p>
                                    </div>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- PESTICIDES COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                // $pesticides1 = array_splice($pesticides, 0, 10);
                    $pes_count = $pesticides->count();
                    foreach ($pesticides as $val_pes) {
                    ?>
                        <div class="item">
                            <div class="seed-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_pes->status == 4) { ?>
                                        <img src="<?= env('APP_URL')."storage/pesticides/$val_pes->image1"; ?>" alt="" class="p-3 tractor-img">
                                        <!-- <img src="{{$val_pes->image1}}" alt="" class="p-3"> -->
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php } else{ ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('pesticides/'.$val_pes->id) }}">
                                        <!-- <img src="{{$val_pes->image1}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/pesticides/$val_pes->image1"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>
                                    <?php } ?>
                                    <div class="shadow-line">

                                    </div>
                                    <p class="model_name">
                                        <?php $string = $val_pes->title; ?>
                                        {{Str::limit($string, 17, '...')}}
                                    </p>

                                    <!-- <div class="location-price d-flex justify-content-around">
                                        <p> <i class="fa-solid fa-location-dot"></i> KOLKATA</p>
                                        <p> <i class="fa-solid fa-indian-rupee-sign"></i> 15000</p>
                                    </div> -->

                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_pes->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_pes->price}}</p>
                                    </div>
                                    <?php
                                        $distance = round($val_pes->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    <!--VIEW ALL CARD-->
                    <?php if($pes_count > 4){?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('pesticides-list')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/pesticide-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php }?>
                </div>
                 

            </div>
            

            <!-- pesti carousel section end-->

            <!-- ferti carousel section start -->
            <div id="fertiC">
                <!-- FERTILIZER COMPANY LOGO START-->
                <?php if(!empty($data['fertilizers_new'][0])){
                //print_r($data['gv']); ?>
                    <section class="company">
                        <div class="container-fluid">
                            <div class="row">
                                 
                                <div class="col-lg-12">
                                    <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                        <?php foreach($data['fertilizers_new'] as $fe){
                                            ?>
                                             <a href="{{url('company-product/fertilizers/new/'.$fe->id)}}">
                                        <div class="items d-flex  align-items-center justify-content-center">
                                            <div class="company-log-box">
                                               
                                                    <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                                    <img src="{{asset('storage/company/'.$fe->logo)}}"  alt="company-logo" class="img-fluid">
                                               
                                            </div>
                                            <p class="mb-0">{{$fe->name}}</p>
                                        </div>

                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- FERTILIZER COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                    //$fertilizers1 = array_splice($fertilizers, 0, 10);
                    $fer_count = $fertilizers->count();
                    foreach ($fertilizers as $val_fer) {
                    ?>
                        <div class="item">
                            <div class="seed-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_fer->status == 4) { ?>
                                        <!-- <img src="{{$val_fer->image1}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/fertilizers/$val_fer->image1"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php }else{ ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('fertilizers/'.$val_fer->id) }}">
                                        <!-- <img src="{{$val_fer->image1}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/fertilizers/$val_fer->image1"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>
                                    <?php } ?>
                                    <div class="shadow-line">

                                    </div>
                                    <p class="model_name">
                                        <?php $string = $val_fer->title; ?>
                                        {{Str::limit($string, 17, '...')}}
                                    </p>

                                    <!-- <div class="location-price d-flex justify-content-around">
                                        <p> <i class="fa-solid fa-location-dot"></i> KOLKATA</p>
                                        <p> <i class="fa-solid fa-indian-rupee-sign"></i> 15000</p>
                                    </div> -->

                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_fer->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_fer->price}}</p>
                                    </div>
                                    <?php
                                        $distance = round($val_fer->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>

                                </div>

                            </div>
                        </div>
                    <?php }
                    ?>
                    <!--VIEW ALL CARD-->
                    <?php if($fer_count > 4){ ?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('fertilizer-list')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/fertilizer-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                </div>

                

            </div>
            <!-- ferti carousel section end-->
        </div>
    </section>
    <!-- SEEDS SECTION END -->

    <!-- SHORTLY DESCRIPTION WEATHER-->
    <section class="short-weather-description">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-2 col-6 border-end border-start">
                    <div class="min-temp text-white py-3 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-thermometer-low" viewBox="0 0 16 16">
                            <path d="M9.5 12.5a1.5 1.5 0 1 1-2-1.415V9.5a.5.5 0 0 1 1 0v1.585a1.5 1.5 0 0 1 1 1.415"/>
                            <path d="M5.5 2.5a2.5 2.5 0 0 1 5 0v7.55a3.5 3.5 0 1 1-5 0zM8 1a1.5 1.5 0 0 0-1.5 1.5v7.987l-.167.15a2.5 2.5 0 1 0 3.333 0l-.166-.15V2.5A1.5 1.5 0 0 0 8 1"/>
                        </svg>
                        <span class="min-temp-value text-uppercase fw-bold">Min Temperature</span>
                        <h6 class="fs-2" id="min-temperature-data">10°C</h6>
                    </div>
                    <div class="max-temp text-white py-3 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-thermometer-high" viewBox="0 0 16 16">
                            <path d="M9.5 12.5a1.5 1.5 0 1 1-2-1.415V2.5a.5.5 0 0 1 1 0v8.585a1.5 1.5 0 0 1 1 1.415"/>
                            <path d="M5.5 2.5a2.5 2.5 0 0 1 5 0v7.55a3.5 3.5 0 1 1-5 0zM8 1a1.5 1.5 0 0 0-1.5 1.5v7.987l-.167.15a2.5 2.5 0 1 0 3.333 0l-.166-.15V2.5A1.5 1.5 0 0 0 8 1"/>
                        </svg>
                        <span class="max-temp-value text-uppercase fw-bold">Max Temperature</span>
                        <h6 class="fs-2" id="max-temperature-data">21°C</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-6 border-end">
                    <div class="humidity text-white py-3 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            fill="currentColor" class="bi bi-moisture" viewBox="0 0 16 16">
                            <path
                                d="M13.5 0a.5.5 0 0 0 0 1H15v2.75h-.5a.5.5 0 0 0 0 1h.5V7.5h-1.5a.5.5 0 0 0 0 1H15v2.75h-.5a.5.5 0 0 0 0 1h.5V15h-1.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 .5-.5V.5a.5.5 0 0 0-.5-.5h-2zM7 1.5l.364-.343a.5.5 0 0 0-.728 0l-.002.002-.006.007-.022.023-.08.088a28.458 28.458 0 0 0-1.274 1.517c-.769.983-1.714 2.325-2.385 3.727C2.368 7.564 2 8.682 2 9.733 2 12.614 4.212 15 7 15s5-2.386 5-5.267c0-1.05-.368-2.169-.867-3.212-.671-1.402-1.616-2.744-2.385-3.727a28.458 28.458 0 0 0-1.354-1.605l-.022-.023-.006-.007-.002-.001L7 1.5zm0 0-.364-.343L7 1.5zm-.016.766L7 2.247l.016.019c.24.274.572.667.944 1.144.611.781 1.32 1.776 1.901 2.827H4.14c.58-1.051 1.29-2.046 1.9-2.827.373-.477.706-.87.945-1.144zM3 9.733c0-.755.244-1.612.638-2.496h6.724c.395.884.638 1.741.638 2.496C11 12.117 9.182 14 7 14s-4-1.883-4-4.267z" />
                        </svg>
                        <span class="min-temp-value text-uppercase fw-bold">Humidity</span>
                        <h6 class="fs-2" id="humidity-data">60%</h6>
                    </div>
                    <div class="air-pressure text-white py-3 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-stars" viewBox="0 0 16 16">
                            <path
                                d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828l.645-1.937zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.734 1.734 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.734 1.734 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.734 1.734 0 0 0 3.407 2.31l.387-1.162zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L10.863.1z" />
                        </svg>
                        <span class="min-temp-value text-uppercase fw-bold">Air Pressure</span>
                        <h6 class="fs-2" id="air-pressure-data">1014mb</h6>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="main-weather-state mb-5 text-white d-flex flex-column justify-content-center align-items-center">
                        <img src="https://www.krishivikas.com/storage/production/fill/day/partly-cloudy-day-rain.svg" alt="svg-weather-icon" id="weather-icons" width="100">
                        <div class="weather-state">
                            <p class="" id="condition">Partly Cloudy</p>
                        </div>
                        <div class="day-and-date">
                            <p class="lead" id="date-day">12 January, Friday</p>
                        </div>
                        <div class="temp-value">
                            <p class="" id="temperature">20°C</p>    
                        </div>
                        <div class="city-value">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pin-map-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8z"/>
                                <path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999z"/>
                            </svg>
                            <span class="ct-name " id="cityName">Kolkata</span>
                        </div>
                        
                    </div>

                    
                </div>
                <div class="col-lg-2 col-6 border-end border-start">
                    <div class="chance-of-rain text-white py-3 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-cloud-rain" viewBox="0 0 16 16">
                                                    <path
                                                        d="M4.158 12.025a.5.5 0 0 1 .316.633l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.317zm3 0a.5.5 0 0 1 .316.633l-1 3a.5.5 0 0 1-.948-.316l1-3a.5.5 0 0 1 .632-.317zm3 0a.5.5 0 0 1 .316.633l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.317zm3 0a.5.5 0 0 1 .316.633l-1 3a.5.5 0 1 1-.948-.316l1-3a.5.5 0 0 1 .632-.317zm.247-6.998a5.001 5.001 0 0 0-9.499-1.004A3.5 3.5 0 1 0 3.5 11H13a3 3 0 0 0 .405-5.973zM8.5 2a4 4 0 0 1 3.976 3.555.5.5 0 0 0 .5.445H13a2 2 0 0 1 0 4H3.5a2.5 2.5 0 1 1 .605-4.926.5.5 0 0 0 .596-.329A4.002 4.002 0 0 1 8.5 2z" />
                                                </svg>
                            <span class="min-temp-value text-uppercase fw-bold">Feels Like</span>
                            <h6 class="fs-2" id="chance-of-rain-data">20%</h6>
                    </div>
                    <div class="wind-speed text-white py-3 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-wind" viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.5 2A2.5 2.5 0 0 0 10 4.5a.5.5 0 0 1-1 0A3.5 3.5 0 1 1 12.5 8H.5a.5.5 0 0 1 0-1h12a2.5 2.5 0 0 0 0-5zm-7 1a1 1 0 0 0-1 1 .5.5 0 0 1-1 0 2 2 0 1 1 2 2h-5a.5.5 0 0 1 0-1h5a1 1 0 0 0 0-2zM0 9.5A.5.5 0 0 1 .5 9h10.042a3 3 0 1 1-3 3 .5.5 0 0 1 1 0 2 2 0 1 0 2-2H.5a.5.5 0 0 1-.5-.5z" />
                                                </svg>
                            <span class="min-temp-value text-uppercase fw-bold">Wind Speed</span>
                            <h6 class="fs-2" id="wind-speed-data">2.06km/h</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-6 border-end">
                    <div class="sunrise text-white py-3 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-sunrise" viewBox="0 0 16 16">
                                                    <path
                                                        d="M7.646 1.146a.5.5 0 0 1 .708 0l1.5 1.5a.5.5 0 0 1-.708.708L8.5 2.707V4.5a.5.5 0 0 1-1 0V2.707l-.646.647a.5.5 0 1 1-.708-.708l1.5-1.5zM2.343 4.343a.5.5 0 0 1 .707 0l1.414 1.414a.5.5 0 0 1-.707.707L2.343 5.05a.5.5 0 0 1 0-.707zm11.314 0a.5.5 0 0 1 0 .707l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zM8 7a3 3 0 0 1 2.599 4.5H5.4A3 3 0 0 1 8 7zm3.71 4.5a4 4 0 1 0-7.418 0H.499a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1h-3.79zM0 10a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 10zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                                                </svg>
                            <span class="min-temp-value text-uppercase fw-bold">Sunrise</span>
                            <h6 class="fs-2" id="sun-rise-data">6:17:12 AM</h6>
                    </div>
                    <div class="sunset text-white py-3 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-sunset" viewBox="0 0 16 16">
                                                    <path
                                                        d="M7.646 4.854a.5.5 0 0 0 .708 0l1.5-1.5a.5.5 0 0 0-.708-.708l-.646.647V1.5a.5.5 0 0 0-1 0v1.793l-.646-.647a.5.5 0 1 0-.708.708l1.5 1.5zm-5.303-.51a.5.5 0 0 1 .707 0l1.414 1.413a.5.5 0 0 1-.707.707L2.343 5.05a.5.5 0 0 1 0-.707zm11.314 0a.5.5 0 0 1 0 .706l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zM8 7a3 3 0 0 1 2.599 4.5H5.4A3 3 0 0 1 8 7zm3.71 4.5a4 4 0 1 0-7.418 0H.499a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1h-3.79zM0 10a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 10zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                                                </svg>
                            <span class="min-temp-value text-uppercase fw-bold">Sunset</span>
                            <h6 class="fs-2" id="sun-set-data">5:04:34 PM</h6>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="http://krishivikas.com/kv-weather-forecast" class="forecast-btn">10 Days Forecast</a>
            </div>
        </div>
    </section>
    
    <!-- HARVESTER SECTION START -->
    <section class="harvester">
        <div class="container-fluid p-0">
            <div class="harvester-header row m-0">
                <div class="col-md-5 h1">
                    <h1><?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                        else { echo 'HARVESTER'; } 
                        ?></h1>
                </div>

                <div class="col-md-7 d-flex justify-content-between listing pe-4">
                    <div class="options">
                        <ul>
                            <li><a href="#" class="harvester_rent active-option" id="rent-h">
                                <?php if (session()->has('bn')) {echo $lang['bn']['RENT'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['RENT'];} 
                                    else { echo 'RENT'; } 
                                    ?></a></li>
                            <div class="ver-shadow"></div>
                            <li><a href="#" class="harvester_used" id="old-h">
                                <?php if (session()->has('bn')) {echo $lang['bn']['USED'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['USED'];} 
                                    else { echo 'USED'; } 
                                    ?></a></li>
                            <div class="ver-shadow"></div>
                            <li><a href="#" class="harvester_new " id="new-h">
                                <?php if (session()->has('bn')) {echo $lang['bn']['NEW'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['NEW'];} 
                                    else { echo 'NEW'; } 
                                    ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- new section start -->
            <div id="new-carousel-h">
                 <!-- HARVESTER COMPANY LOGO START-->
                 <?php if(!empty($data['harvester_new'][0])){
                //print_r($data['gv']);
                ?>
                    <section class="company">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                        <?php foreach($data['harvester_new'] as $har){
                                            ?>
                                            <a href="{{url('company-product/harvester/new/'.$har->id)}}">
                                        <div class="items d-flex  align-items-center justify-content-center">
                                            <div class="company-log-box">
                                                
                                                    <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                                    <img src="{{asset('storage/company/'.$har->logo)}}"  alt="company-logo" class="img-fluid">
                                                
                                            </div>
                                            <p class="mb-0">{{$har->name}}</p>
                                        </div>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- HARVESTER COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                // $implements_sell_new1 = array_splice($implements_sell_new, 0, 10);
                //    print_r($harvester_sell_new);
                //    exit;
                    $har_count1 = $harvester_sell_new->count();
                    foreach ($harvester_sell_new as $val_isn) {
                    ?>
                        <div class="item">
                            <div class="implements-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_isn->status == 4) { ?>
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/harvester/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php } else { 
                                    ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('harvester/'.$val_isn->id) }}">
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/harvester/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>

                                    <?php } ?>
                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_isn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_isn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_isn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_isn->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                <p class="model_name">         
                                        {{$brand_name}} {{$model_name}}
                                    </p>
                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_isn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_isn->price}}</p>
                                    </div>
                                    <?php
                                        $distance = round($val_isn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    <!--VIEW ALL CARD-->
                    <?php if($har_count1 > 4){?>
                    <div class="item">
                            <div class="implements-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('harvester-list/new')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                    
                </div>
               
            </div>
            <!-- new section end -->

            <!-- old section start -->
            <div id="used-carousel-h">
                <!-- HARVESTER COMPANY LOGO START-->
                <?php if(!empty($data['harvester'][0])){
                //print_r($data['gv']);
                ?>
                <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                    <?php foreach($data['harvester'] as $har){
                                        ?>
                                         <a href="{{url('brand-product/harvester/old/'.$har->id)}}">
                                    <div class="items d-flex align-items-center justify-content-center">
                                       
                                            <div class="company-log-box">
                                                <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                                <img src="{{asset('storage/images/brands./'.$har->logo)}}"  alt="company-logo" class="img-fluid">
                                            </div>
                                        
                                        <p class="mb-0">{{$har->name}}</p>
                                    </div>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- HARVESTER COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                // $implements_sell_new1 = array_splice($implements_sell_new, 0, 10);
                //    print_r($harvester_sell_new);
                //    exit;
                    $har_count2 = $harvester_sell_old->count();
                    foreach ($harvester_sell_old as $val_isn) {
                    ?>
                        <div class="item">
                            <div class="implements-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_isn->status == 4) { ?>
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/harvester/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php } else { 
                                    ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('harvester/'.$val_isn->id) }}">
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/harvester/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>

                                    <?php } ?>
                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_isn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_isn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_isn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_isn->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                <p class="model_name">         
                                        {{$brand_name}} {{$model_name}}
                                    </p>
                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_isn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_isn->price}}</p>
                                    </div>
                                    <?php
                                        $distance = round($val_isn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>

                            </div>
                        </div>
                    <?php } ?>  
                    <!--VIEW ALL CARD-->
                    <?php if($har_count2 > 4){?>
                    <div class="item">
                            <div class="implements-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('harvester-list/old')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                </div>
                
            </div>
            <!-- old section end -->

            <!-- rent section start -->
            <div id="rent-carousel-h">
                <!-- HARVESTER COMPANY LOGO START-->
                <?php if(!empty($data['harvester'][0])){
                //print_r($data['gv']);
                ?>
                <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                    <?php foreach($data['harvester'] as $har){
                                    ?>
                                    <a href="{{url('brand-product/harvester/rent/'.$har->id)}}">
                                    <div class="items d-flex  align-items-center justify-content-center">
                                        
                                            <div class="company-log-box">
                                                <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                                <img src="{{asset('storage/images/brands/'.$har->logo)}}"  alt="company-logo" class="img-fluid">
                                            </div>
                                        
                                        <p class="mb-0">{{$har->name}}</p>
                                    </div>
                                    </a>
                                    
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- HARVESTER COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                // $implements_sell_new1 = array_splice($implements_sell_new, 0, 10);
                //    print_r($harvester_sell_new);
                //    exit;
                    $har_count3 =  $harvester_rent->count();
                    foreach ($harvester_rent as $val_isn) {
                    ?>
                        <div class="item">
                            <div class="implements-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_isn->status == 4) { ?>
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/harvester/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php } else { 
                                    ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('harvester/'.$val_isn->id) }}">
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/harvester/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>

                                    <?php } ?>
                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_isn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_isn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_isn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_isn->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                <p class="model_name">         
                                        {{$brand_name}} {{$model_name}}
                                    </p>
                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_isn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_isn->price}}
                                            <?php if ($val_isn->set== 'rent') {
                                                if ($val_isn->rent_type == 'Per Hour') {
                                                    echo '/hr';
                                                } else if ($val_isn->rent_type == 'Per Month') {
                                                    echo '/m';
                                                } else if ($val_isn->rent_type == 'Per Day') {
                                                    echo '/d';
                                                }
                                            } ?>
                                        </p>
                                    </div>
                                    <?php
                                        $distance = round($val_isn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!--VIEW ALL CARD-->
                    <?php if($har_count3 > 4){?>
                    <div class="item">
                            <div class="implements-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('harvester-list/rent')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                </div>

                
            </div>   
        <!-- rent section end -->
        </div>
    </section>
    <!-- HARVESTER SECTION END -->

    <!-- BUY SELL BANNER SECTION SATRT -->

    <section class="bs-banner d-md-block d-none">
        <div class="container-fluid">
            <h1><?php if (session()->has('bn')) {echo $lang['bn']['What would you like to do?'];} 
                else if (session()->has('hn')) {echo $lang['hn']['What would you like to do?'];} 
                else { echo 'What would you like to do?'; } 
                ?></h1>
            <div class="bs-btns">
                <button class="r-btn">
                    <?php if (session()->has('bn')) {echo $lang['bn']['RENT'];} 
                else if (session()->has('hn')) {echo $lang['hn']['RENT'];} 
                else { echo 'RENT'; } 
                ?></button>
                <button class="s-btn">
                    <?php if (session()->has('bn')) {echo $lang['bn']['SELL'];} 
                else if (session()->has('hn')) {echo $lang['hn']['SELL'];} 
                else { echo 'SELL'; } 
                ?></button>
            </div>
        </div>
    </section>

    <!-- IMPLEMENTS SECTION START -->
    <section class="implements mt-3">
        <div class="container-fluid p-0">
            <div class="implements-header row m-0">
                <div class="col-md-5 h1">
                    <h1>
                        <?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                else { echo 'IMPLEMENTS'; } 
                ?></h1>
                </div>

                <div class="col-md-7 d-flex justify-content-between listing pe-4">
                    <div class="options">
                        <ul>
                            <li><a href="#" class="implements_rent active-option" id="rent-i">
                                <?php if (session()->has('bn')) {echo $lang['bn']['RENT'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['RENT'];} 
                                    else { echo 'RENT'; } 
                                    ?></a></li>
                            <div class="ver-shadow"></div>
                            <li><a href="#" class="implements_used " id="used-i">
                                <?php if (session()->has('bn')) {echo $lang['bn']['USED'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['USED'];} 
                                    else { echo 'USED'; } 
                                    ?></a></li>
                            <div class="ver-shadow"></div>
                            <li><a href="#" class="implements_new" id="new-i">
                                <?php if (session()->has('bn')) {echo $lang['bn']['NEW'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['NEW'];} 
                                else { echo 'NEW'; } 
                                ?></a></li>
                            
                            
                        </ul>
                    </div>

                    
                </div>


            </div>

            <!-- new section start -->
            <div id="new-carousel-i">
                   <!-- IMPLEMENT COMPANY LOGO START-->
                   <?php if(!empty($data['implement_new'][0])){
                //print_r($data['gv']);
                ?>
                    <section class="company">
                        <div class="container-fluid">
                            <div class="row">
                            
                                <div class="col-lg-12">
                                    <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                        <?php foreach($data['implement_new'] as $im){
                                            ?>
                                            <a href="{{url('company-product/implement/new/'.$im->id)}}">
                                        <div class="items d-flex  align-items-center justify-content-center">
                                            <div class="company-log-box">
                                                
                                                    <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                                    <img src="{{asset('storage/company/'.$im->logo)}}"  alt="company-logo" class="img-fluid">
                                                
                                            </div>
                                            <p class="mb-0">{{$im->name}}</p>
                                        </div>

                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- IMPLEMENT COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                // $implements_sell_new1 = array_splice($implements_sell_new, 0, 10);
                    $im_count1 = $implements_sell_new->count();
                    foreach ($implements_sell_new as $val_isn) {
                    ?>
                        <div class="item">
                            <div class="implements-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_isn->status == 4) { ?>
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/implements/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php } else { 
                                    ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('implements/'.$val_isn->id) }}">
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/implements/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>

                                    <?php } ?>
                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_isn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_isn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_isn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_isn->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                <p class="model_name">         
                                        {{$brand_name}} {{$model_name}}
                                    </p>
                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_isn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_isn->price}}</p>
                                    </div>
                                    <?php
                                        $distance = round($val_isn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <!--VIEW ALL CARD-->
                    <?php if($im_count1 > 4){  ?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('implements-list/new')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                </div>
             
            </div>
            <!-- new section end -->


            <!-- old section start -->
            <div id="used-carousel-i">
                 <!-- IMPLEMENT COMPANY LOGO START-->
                 <?php if(!empty($data['implement'][0])){
                //print_r($data['gv']);
                ?>
                <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                           
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                    <?php foreach($data['implement'] as $im){
                                        ?>
                                        <a href="{{url('brand-product/implement/old/'.$im->id)}}">
                                    <div class="items d-flex  align-items-center justify-content-center">
                                        
                                            <div class="company-log-box">
                                                <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                                <img src="{{asset('storage/images/brands/'.$im->logo)}}"  alt="company-logo" class="img-fluid">
                                            </div>
                                       
                                        <p class="mb-0">{{$im->name}}</p>
                                    </div>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- IMPLEMENT COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                // $implements_sell_new1 = array_splice($implements_sell_new, 0, 10);
                    $im_count2 = $implements_sell_old ->count();
                    foreach ($implements_sell_old as $val_isn) {
                    ?>
                        <div class="item">
                            <div class="implements-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_isn->status == 4) { ?>
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/implements/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php } else { 
                                    ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('implements/'.$val_isn->id) }}">
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/implements/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>

                                    <?php } ?>
                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_isn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_isn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_isn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_isn->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                <p class="model_name">         
                                        {{$brand_name}} {{$model_name}}
                                    </p>
                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_isn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_isn->price}}</p>
                                    </div>
                                    <?php
                                        $distance = round($val_isn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!--VIEW ALL CARD-->
                    <?php if($im_count2 > 4){?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('implements-list/old')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                </div>
               
            </div>
            <!-- old section end -->

            <!-- rent section start -->
            <div id="rent-carousel-i">
                <!-- IMPLEMENT COMPANY LOGO START-->
                <?php if(!empty($data['implement'][0])){
                //print_r($data['gv']);
                ?>
                <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                    <?php foreach($data['implement'] as $im){
                                        ?>
                                         <a href="{{url('brand-product/implement/rent/'.$im->id)}}">
                                    <div class="items d-flex  align-items-center justify-content-center">
                                   
                                        <div class="company-log-box">
                                            <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                            <img src="{{asset('storage/images/brands/'.$im->logo)}}"  alt="company-logo" class="img-fluid">
                                        </div>
                                    
                                        <p class="mb-0">{{$im->name}}</p>
                                    </div>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- IMPLEMENT COMPANY LOGO END-->
                <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                    // $implements_sell_new1 = array_splice($implements_sell_new, 0, 10);
                    $im_count3 = $implements_rent ->count();
                    foreach ($implements_rent as $val_isn) {
                    ?>
                        <div class="item">
                            <div class="implements-list">

                                <div class="tractor-img-box">
                                    <?php if ($val_isn->status == 4) { ?>
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/implements/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php } else { 
                                    ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('implements/'.$val_isn->id) }}">
                                        <!-- <img src="{{$val_isn->front_image}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/implements/$val_isn->front_image"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    </a>

                                    <?php } ?>
                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_isn->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_isn->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_isn->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_isn->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                <p class="model_name">         
                                        {{$brand_name}} {{$model_name}}
                                    </p>
                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_isn->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_isn->price}}
                                            <?php if ($val_isn->set== 'rent') {
                                                if ($val_isn->rent_type == 'Per Hour') {
                                                    echo '/hr';
                                                } else if ($val_isn->rent_type == 'Per Month') {
                                                    echo '/m';
                                                } else if ($val_isn->rent_type == 'Per Day') {
                                                    echo '/d';
                                                }
                                            } ?>
                                        </p>
                                    </div>

                                    <?php
                                        $distance = round($val_isn->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    <!--VIEW ALL CARD-->
                    <?php if($im_count3 > 4){?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('implements-list/rent')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                    
                </div>
                
            </div>
            <!-- rent section end -->
        </div>
    </section>
    <!-- IMPLEMENTS SECTION END -->




        <!-- TRACTOR BANNER SECTION START -->
        <section class="trac-banner">
        <div class="container-banner">

            <div class="row justify-content-center">
                <div class="col-md-6 text-center vd1">
                <div class="thumb-1">
                    <i class="fa-sharp fa-solid fa-play play1"></i>
                <img src="{{ URL::asset('assets/images/v-th-2.png')}}" alt="" >
                </div>
                    <video width="" height="340"  class="video-1">
                    <source src="{{ URL::asset('assets/images/Krishi Bikash Poster_1_1.mp4')}}" type="video/mp4">  
                    </video>
                    <i class="fa-sharp fa-solid fa-pause pause1"></i>
                </div>
                <div class="col-md-6 text-center vd2">
                    <div class="thumb-2">
                        <i class="fa-sharp fa-solid fa-play play2"></i>
                    <img src="{{ URL::asset('assets/images/v-th-1.png')}}" alt="" >
                    </div>
                    <video width="" height="340"  class="video-2">
                   
                    <source src="{{ URL::asset('assets/images/Story_V005_1.mp4')}}" type="video/mp4">
                    
                   
                    </video>
                    <i class="fa-sharp fa-solid fa-pause pause2"></i>
                </div>
            </div>
        </div>
    </section>
    <!-- TRACTOR BANNER SECTION END -->


    <!-- TYRES SECTION START -->

    <section class="tyres">
        <div class="container-fluid p-0">
            <div class="tyres-header row m-0">
                <div class="col-md-5 h1">
                    <h1><?php if (session()->has('bn')) {echo $lang['bn']['TYRES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['TYRES'];} 
                        else { echo 'TYRES'; } 
                        ?></h1>
                </div>

                <div class="col-md-7 d-flex justify-content-between listing pe-4">
                    <div class="options">
                        <ul>
                            <li><a href="" class="tyre_used active-option" id="old-ts">
                                <?php if (session()->has('bn')) {echo $lang['bn']['USED'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['USED'];} 
                                    else { echo 'USED'; } 
                                    ?></a></li>
                            <div class="ver-shadow"></div>
                            <li><a href="" class="tyre_new" id="new-ts">
                                <?php if (session()->has('bn')) {echo $lang['bn']['NEW'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['NEW'];} 
                                    else { echo 'NEW'; } 
                                    ?></a></li>
                        </ul>
                    </div>
                </div>


            </div>
            <!-- Dibyendu Change 22.09.2023  -->

            <!-- new section start -->
            <div id="new-carousel-ty">
                 <!-- TYREs COMPANY LOGO START-->
        <?php if(!empty($data['tyre_new'][0])){
                //print_r($data['gv']);
                ?>
                <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                    <?php foreach($data['tyre_new'] as $ty){
                                        ?>
                                        <a href="{{url('company-product/tyre/new/'.$ty->id)}}">
                                    <div class="items d-flex  align-items-center justify-content-center">
                                        <div class="company-log-box">
                                        
                                            <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                            <img src="{{asset('storage/company/'.$ty->logo)}}"  alt="company-logo" class="img-fluid">
                                        
                                        </div>
                                        <p class="mb-0">{{$ty->name}}</p>
                                    </div>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
          
            <?php } ?>
            <div class="owl-carousel owl-theme" >
            <?php
                //$tyre_old1 = array_splice($tyre_old, 0, 10);
                $ty_count1 = $tyre_new->count();
                foreach ($tyre_new as $val_to) { ?>
                    <div class="item">
                        <div class="tyres-list">
                            <div class="tractor-img-box">
                                <?php if ($val_to->status == 4) { ?>
                                    <!-- <img src="{{$val_to->image1}}" alt="" class="p-3"> -->
                                    <img src="<?= env('APP_URL')."storage/tyre/$val_to->image1"; ?>" alt="" class="p-3 tractor-img">
                                    <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                    <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                <?php }else{ ?>
                                {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                <a href="{{ url('tyre/'.$val_to->id) }}">
                                    <!-- <img src="{{$val_to->image1}}" alt="" class="p-3"> -->
                                    <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <img src="<?= env('APP_URL')."storage/tyre/$val_to->image1"; ?>" alt="" class="p-3 tractor-img">
                                </a>
                                <?php } ?>
                                <div class="shadow-line">

                                </div>
                                <?php
                                    $brand_arr_data = DB::table('brand')->where(['id' => $val_to->brand_id])->first();
                                    $brand_name = $brand_arr_data->name;
                                    $model_arr_data = DB::table('model')->where(['id' => $val_to->model_id])->first();
                                    $model_name = $model_arr_data->model_name;
                                    $state_arr_data = DB::table('district')->where(['id' => $val_to->district_id])->first();
                                    $district_name = $state_arr_data->district_name;
                                    $city_arr_data = DB::table('city')->where(['pincode' => $val_to->pincode])->first();
                                    $city_name = $city_arr_data->city_name;
                                ?>
                                <p class="model_name">
                                    {{$brand_name}} {{$model_name}}
                                </p>
                                <div class="spec d-flex justify-content-around align-items-center pt-3">
                                    <p><i class="fa-solid fa-location-dot"></i> {{$val_to->city_name}}</p>
                                    <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_to->price}}</p>
                                </div>
                                <?php
                                    $distance = round($val_to->distance);
                                ?>
                                <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>

                            </div>

                        </div>
                    </div>
                <?php } ?>
                <!--VIEW ALL CARD-->
                <?php if($ty_count1 > 4){?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('tyre-list/new')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/tyre-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                <?php } ?>  
            </div>
            
       

            </div>
            <!-- new section end -->

            <!-- used section start -->
            <div id="used-carousel-ty">
                                 <!-- TYRES COMPANY LOGO START-->
            <?php if(!empty($data['tyre'][0])){
                //print_r($data['gv']);
                ?>
                <section class="company">
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="company-logos d-flex gap-3 justify-content-start overflow-auto py-3">
                                    <?php foreach($data['tyre'] as $ty){
                                        ?>
                                        <a href="{{url('brand-product/tyre/old/'.$ty->id)}}" class="text-decoration-none">
                                    <div class="items d-flex gap-2 align-items-center justify-content-center">
                                        
                                            <div class="company-log-box">
                                                <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Mahindra_Auto.png" alt="company-logo" class="img-fluid"> -->
                                                <img src="{{asset('storage/images/brands/'.$ty->logo)}}"  alt="company-logo" class="img-fluid">
                                            </div>
                                        
                                        <p class="mb-0">{{$ty->name}}</p>
                                    </div>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <!-- TYRE COMPANY LOGO END-->
            <?php } ?>
                <div class="owl-carousel owl-theme" >
                <?php
                    //$tyre_old1 = array_splice($tyre_old, 0, 10);
                    $ty_count2 = $tyre_old->count();
                    foreach ($tyre_old as $val_to) { ?>
                        <div class="item">
                            <div class="tyres-list">
                                <div class="tractor-img-box">
                                    <?php if ($val_to->status == 4) { ?>
                                        <!-- <img src="{{$val_to->image1}}" alt="" class="p-3"> -->
                                        <img src="<?= env('APP_URL')."storage/tyre/$val_to->image1"; ?>" alt="" class="p-3 tractor-img">
                                        <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="" width="100" style="position: absolute;top: 0;z-index: 1;">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                    <?php }else{ ?>
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('tyre/'.$val_to->id) }}">
                                        <!-- <img src="{{$val_to->image1}}" alt="" class="p-3"> -->
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-22%;">
                                        <img src="<?= env('APP_URL')."storage/tyre/$val_to->image1"; ?>" alt="" class="p-3 tractor-img">
                                    </a>
                                    <?php } ?>
                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                        $brand_arr_data = DB::table('brand')->where(['id' => $val_to->brand_id])->first();
                                        $brand_name = $brand_arr_data->name;
                                        $model_arr_data = DB::table('model')->where(['id' => $val_to->model_id])->first();
                                        $model_name = $model_arr_data->model_name;
                                        $state_arr_data = DB::table('district')->where(['id' => $val_to->district_id])->first();
                                        $district_name = $state_arr_data->district_name;
                                        $city_arr_data = DB::table('city')->where(['pincode' => $val_to->pincode])->first();
                                        $city_name = $city_arr_data->city_name;
                                    ?>
                                    <p class="model_name">
                                        {{$brand_name}} {{$model_name}}
                                    </p>
                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val_to->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_to->price}}</p>
                                    </div>
                                    <?php
                                        $distance = round($val_to->distance);
                                    ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>

                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    <!--VIEW ALL CARD-->
                    <?php if($ty_count2 > 4){?>
                    <div class="item">
                            <div class="tractor-list">

                                <div class="tractor-img-box p-5">
                                    
                                    <div class="view-all-box">
                                        <a href="{{url('tyre-list/old')}}">
                                            <div class="v-gradient d-flex align-items-center justify-content-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/tyre-removebg-preview.png')}}" alt=""/>
                                                <p class="vw-text text-center">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['VIEW ALL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['VIEW ALL'];} 
                                                    else { echo 'VIEW ALL'; } 
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    <?php } ?>
                
                </div>


            </div>
            <!-- used section end -->


        </div>
    </section>

    <!-- TYRES SECTION END -->



    <!-- FAQ SECTION START -->
    <section class="faq-kv position-relative">
        <div class="faq-bg-up" style="background: #555454;">
            <div class="d-flex align-items-center justify-content-center pt-2">
                <img src="https://krishivikas.com/storage/sold/kv.png" alt="sold" width="100" style="width: 60px" class="d-md-block d-none ">
            <h6 class="text-center text-white fw-bolder" >
                
                    
                    <?php if (session()->has('bn')) {echo $lang['bn']['FREQUENTLY ASKED QUESTIONS'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['FREQUENTLY ASKED QUESTIONS'];} 
                                else { echo 'FREQUENTLY ASKED QUESTIONS'; } 
                                ?>
                
            </h6>
            <img src="https://krishivikas.com/storage/sold/kv.png" alt="sold" width="100" style="width: 60px" class="d-md-block d-none ">
            </div>
        </div>
        <div class="faq-bg-down" style="background: linear-gradient(to bottom, #13693a, #8cbf44, #13693a);">
<div class="container faq-container">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                 
                 <?php if (session()->has('bn')) {echo 'কৃষি বিকাশ উদ্যোগ কি?';} 
                            else if (session()->has('hn')) {echo 'कृषि विकास उद्योग क्या है?';} 
                            else { echo 'What is Krishi Vikas Udyog?'; } 
                            ?>
                </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    
                    <?php if (session()->has('bn')) {echo 'কৃষি বিকাশ উদ্যোগ হল একটি ডিজিটাল প্ল্যাটফর্ম যা ভারতে কৃষি সরঞ্জাম, ইনপুট এবং আউটপুটগুলির জন্য একটি ব্যাপক মার্কেটপ্লেস হিসাবে কাজ করে। কৃষি বিকাশ এর মোবাইল অ্যাপ্লিকেশন এবং ওয়েবসাইটের মাধ্যমে কৃষক, ডিলার এবং ব্যবসায়ীদের সংযুক্ত করে।
';} 
                            else if (session()->has('hn')) {echo 'कृषि विकास उद्योग एक डिजिटल प्लेटफ़ॉर्म है जो भारत में कृषि उपकरण, इनपुट और आउटपुट के लिए एक व्यापक बाज़ार के रूप में कार्य करता है। कृषि विकास अपने मोबाइल एप्लिकेशन और वेबसाइट के माध्यम से किसानों, डीलरों और व्यापारियों को जोड़ता है।
                                ';} 
                            else { echo 'Krishi Vikas Udyog is a digital platform that serves as a comprehensive marketplace for agricultural equipment, inputs, and outputs in India. It connects farmers, dealers, and traders through its mobile application and website.'; } 
                            ?>
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                
                <?php if (session()->has('bn')) {echo 'অন্যান্য প্ল্যাটফর্ম থেকে কৃষি বিকাশ উদ্যোগকে আলাদা কীভাবে?
';} 
                            else if (session()->has('hn')) {echo 'कृषि विकास उद्योग अन्य प्लेटफार्मों से कैसे भिन्न है?
                                ';} 
                            else { echo 'What sets Krishi Vikas Udyog apart from other platforms?'; } 
                            ?>
                </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <?php if (session()->has('bn')) {echo 'কৃষি বিকাশ উদ্যোগ একটি অনন্য প্ল্যাটফর্ম যা একই সাথে কৃষি সরঞ্জাম এবং ইনপুট উভয়ের জন্য লেনদেনের সুবিধা দেয়। উপরন্তু, এটি ভাড়া দেওয়া এবং নেওয়ার সুবিধা প্রদান করে, যা বিশেষত করে ক্ষুদ্র কৃষকদের জন্য উপকারী। প্ল্যাটফর্মটি ব্যবহারকারীদের জন্য দৃশ্যমানতা এবং ব্যবসায়ী প্রতিযোগিতা বাড়াতে ব্যানার বিজ্ঞাপন এবং প্রোডাক্ট বুস্টের মতো বৈশিষ্ট্যও দেয়। ';} 
                            else if (session()->has('hn')) {echo 'कृषि विकास उद्योग एक अनूठा मंच है जो कृषि उपकरण और इनपुट दोनों के लिए एक साथ लेनदेन की सुविधा प्रदान करता है। इसके अलावा, यह किराये और पट्टे की सुविधा प्रदान करता है, जो विशेष रूप से छोटे किसानों के लिए फायदेमंद है। प्लेटफ़ॉर्म उपयोगकर्ताओं के लिए दृश्यता और व्यापारिक प्रतिस्पर्धा बढ़ाने के लिए बैनर विज्ञापन और उत्पाद बूस्ट जैसी सुविधाएँ भी प्रदान करता है।
                                ';} 
                            else { echo 'Krishi Vikas Udyog distinguishes itself by offering a unique platform that facilitates transactions for both agricultural equipment and inputs simultaneously. Additionally, it provides renting facilities, particularly beneficial for small-scale farmers. The platform also offers features such as banner ads and product boosts to enhance visibility and competitiveness for users.'; } 
                            ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                <?php if (session()->has('bn')) {echo 'কৃষি বিকাশ উদ্যোগের প্রোডাক্ট বুস্ট বৈশিষ্ট্য কী করে?
';} 
                            else if (session()->has('hn')) {echo 'कृषि विकास उद्योग की प्रोडक्ट बूस्ट विशेषताएं क्या हैं?';} 
                            else { echo ' What does the product boost feature of Krishi Vikas Udyog do? '; } 
                            ?>
               
                </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <?php if (session()->has('bn')) {echo 'কৃষি বিকাশ উদ্যোগ কৃষি সম্পর্কিত গ্রাহকদের উন্নতির জন্য অ্যাপ্লিকেশনটিতে একটি অসাধারন প্রোডাক্ট বুস্ট বৈশিষ্ট্য চালু করেছে। বৈশিষ্ট্যটি ব্যবহার করে, বিক্রেতারা তাদের বাজারকে একটি ছোট এলাকা ছাড়িয়ে দেশব্যাপী সম্প্রসারন করতে পারেন। যেহেতু বুস্ট করা প্রোডাক্ট সবার উপরে থাকে, তাই প্রোডাক্ট বুস্ট একটি নির্দিষ্ট পণ্যের বিক্রয় হওয়ার সম্ভাবনা বাড়ায়। অর্থাৎ এটি বেশি সংখ্যক দর্শক এবং সম্ভাব্য গ্রাহকদের কাছে পৌঁছায়। এভাবেই প্রোডাক্ট বুস্ট দ্রুত পণ্য বিক্রিতে সহায়তা করে।
';} 
                            else if (session()->has('hn')) {echo 'कृषि विकास उद्योग ने कृषि संबंधी ग्राहकों को बेहतर बनाने के लिए ऐप में एक अद्भुत प्रोडक्ट बूस्ट फीचर लॉन्च किया है। सुविधा का उपयोग करके, विक्रेता अपने बाज़ार को एक छोटे क्षेत्र से आगे बढ़कर देश भर में विस्तारित कर सकते हैं। चूंकि बूस्ट किया गया उत्पाद शीर्ष पर है, प्रोडक्ट बूस्ट से किसी विशेष उत्पाद के बिकने की संभावना बढ़ जाती है।
                                ';} 
                            else { echo "Krishi Vikas Udyog has introduced the unique product boost feature in the application for the betterment of the agri stakeholders. Using the feature, the sellers can extend their marketplace beyond a small locality to a nationwide ground. The product boost feature enhances the specific product's chances of being sold. Among all other products, the boosted product's visibility is improved as it comes above all the listed products. That means it reaches more viewers and potential customers. That is how the product boost helps in selling products fast."; } 
                            ?>
                     </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
               
                <?php if (session()->has('bn')) {echo 'আমি কিভাবে প্রোডাক্ট বুস্ট ব্যবহার করতে পারি?';} 
                            else if (session()->has('hn')) {echo 'मैं प्रोडक्ट बूस्ट का उपयोग कैसे कर सकता हूं?';} 
                            else { echo ' How can I use product boost?  '; } 
                            ?>
                </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <?php if (session()->has('bn')) {echo 'প্রোডাক্ট বুস্ট ব্যবহার করা অন্যতম সহজ কাজ। নিজের ফোনে অ্যাপলিকেশন খুলুন এবং হোমপেজ থেকে “New” বাটনে ক্লিক করুন। এরপর বক্স থেকে  "Product Boost" অপশনের উপর ক্লিক করুন। আগে থেকে পোস্ট করা যেকোনো প্রোডাক্ট এর "Product Boost" অপশনের উপর ক্লিক করুন। এবার বেসিক, ইন্টারমিডিয়েট এবং প্রিমিয়াম এর থেকে যেকোনো প্ল্যান বেছে নিন। নিয়ম এবং শর্তাবলী মনোযোগ সহকারে পড়ুন এবং এর পর পেমেন্ট এর প্রক্রিয়া সমাপ্ত করুন। নেটব্যাঙ্কিং, ইউ পি আই, কার্ড বা ই ওয়ালেট এর মাধ্যমে পেমেন্ট করা যেতে পারে। পেমেন্ট করার পর আপনার কাছে কৃষি বিকাশের পক্ষ থেকে ইনভয়েস চলে যাবে এবং আপনার প্রোডাক্ট সফল ভাবে বুস্ট হয়ে যাবে।';} 
                            else if (session()->has('hn')) {echo 'प्रोडक्ट बूस्ट का उपयोग करना सबसे आसान कार्यों में से एक है। अपने फोन पर एप्लिकेशन खोलें और होमपेज से "New" बटन पर क्लिक करें। फिर बॉक्स से "Product Boost" विकल्प पर क्लिक करें। पहले पोस्ट किए गए किसी भी उत्पाद के "Product Boost" विकल्प पर क्लिक करें। अब बेसिक, इंटरमीडिएट और प्रीमियम में से कोई भी प्लान चुनें। नियम और शर्तें ध्यान से पढ़ें और फिर पेमेंट प्रक्रिया पूरी करें। 
                                पेमेंट नेटबैंकिंग, यूपीआई, कार्ड या ई-वॉलेट के जरिए किया जा सकता है। पेमेंट के बाद आपको कृषि विकास उद्योग से इनवॉइस मिलेगा और आपका प्रोडक्ट सफलतापूर्वक बूस्ट हो जाएगा।
                                ';} 
                            else { echo "Using the product boost is a simple task in the application. Open the application on your phone, and click the `New` button from the homepage. Select the `Product Boost` option from the box. From any of the previously listed products, select the `Product Boost` option and choose any plan from Basic, Intermediate and Premium. Check the terms and conditions carefully, and finish payment through card, UPI, Netbanking or E-Wallet. And that's it. Your product will be boosted successfully and will be visible to more and more potential customers.  "; } 
                            ?>
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                
                <?php if (session()->has('bn')) {echo 'ব্যানার বিজ্ঞাপন কী? 
';} 
                            else if (session()->has('hn')) {echo 'बैनर विज्ञापन क्या है?';} 
                            else { echo ' What is a banner ad?  '; } 
                            ?>
                </button>
                </h2>
                <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"> 
                <?php if (session()->has('bn')) {echo 'একটি ব্যানার বিজ্ঞাপন বিশেষভাবে সহায়ক যখন আপনার বিভিন্ন প্রোডাক্ট  থাকে এবং আপনি প্রতিটিকে বিক্রয় করার জন্য দেখাতে চান। ব্যানার বিজ্ঞাপনের মাধ্যমে, আপনি আপনার প্রোডাক্ট এবং এন্টারপ্রাইজের প্রচার করতে পারেন। যদি আপনি একটি ব্যানার বিজ্ঞাপন সাবস্ক্রিপশন নেন, আপনার ব্যানার Mahindra মত বিখ্যাত ব্র্যান্ডের পাশে দৃশ্যমান হবে। আপনি বড় ব্যবসায়ীদের সাথে প্রতিদ্বন্দ্বিতা করতে সক্ষম হবেন এবং অল্প সময়ের মধ্যেই আপনার ব্যবসা বাড়াতে পারবেন।';} 
                            else if (session()->has('hn')) {echo 'एक बैनर विज्ञापन विशेष रूप से तब सहायक होता है जब आपके पास कई प्रोडक्ट हों और आप प्रत्येक को बिक्री के लिए प्रदर्शित करना चाहते हों। बैनर विज्ञापनों के माध्यम से आप अपने प्रोडक्ट और व्यापार का प्रचार कर सकते हैं। यदि आप बैनर विज्ञापन सब्सक्रिप्शन लेते हैं, तो आपका बैनर महिंद्रा जैसे प्रसिद्ध ब्रांडों के बगल में दिखाई देगा। आप बड़े व्यापारियों से प्रतिस्पर्धा करने में सक्षम होंगे और कुछ ही समय में अपना व्यवसाय बढ़ा सकेंगे।';} 
                            else { echo 'A banner ad is particularly helpful when you have a variety of products and you want to make each one visible. Through banner ads, you can promote your products and enterprise as well. In case you get a banner ad subscription, your banner will be visible beside famous brands like Mahindra. You will be able to compete with the tycoons of the industry and grow your business in no time. '; } 
                            ?>
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingSix">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                
                <?php if (session()->has('bn')) {echo 'আমি কিভাবে কৃষি বিকাশ উদ্যোগ মোবাইল অ্যাপ্লিকেশনে ব্যানার বিজ্ঞাপন ব্যবহার করতে পারি?
';} 
                            else if (session()->has('hn')) {echo 'मैं कृषि विकास उद्योग मोबाइल एप्लिकेशन में बैनर विज्ञापनों का उपयोग कैसे कर सकता हूं?
                                ';} 
                            else { echo 'How can I use banner ads in Krishi Vikas Udyog Mobile Application? '; } 
                            ?>
                </button>
                </h2>
                <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    
                                            <?php if (session()->has('bn')) {echo 'ব্যানার বিজ্ঞাপন দেওয়ার প্রক্রিয়াও মোটামুটি প্রোডাক্ট বুস্টের মতই। নিজের ফোনে অ্যাপলিকেশন খুলুন এবং হোমপেজ থেকে “New” বাটনে ক্লিক করুন। এরপর বক্স থেকে t “Banner ads” অপশন বাছুন। বেসিক, ইন্টারমিডিয়েট এবং প্রিমিয়াম এর থেকে যেকোনো প্ল্যান বেছে নিন। 
                            নিজের ব্যানারের জন্যে একটি ক্যাম্পেন নাম দিন এবং পছন্দসই ফটো আপলোড করুন। আটটির মধ্যে যেকোনো একটি শ্রেনী বাছুন। আপনি চাইলে  ALL বিকল্পও বাছতে পারেন। যে রাজ্যে ব্যানার বিজ্ঞাপন চালাতে চান সেই রাজ্য বাছুন এবং সাবমিট বাটনে ক্লিক করুন। নিয়ম এবং শর্তাবলী মনোযোগ সহকারে পড়ুন এবং এর পর পেমেন্ট এর প্রক্রিয়া সমাপ্ত করুন। নেটব্যাঙ্কিং, ইউ পি আই, কার্ড বা ই ওয়ালেট এর মাধ্যমে পেমেন্ট করা যেতে পারে। 
                            পেমেন্ট সফল্ভাবে সম্পূর্ণ করার পর আপনার ব্যানার অন্য সব ব্র্যান্ডের সাথে অ্যাপলিকেশনে দেখা যাবে।
                            ';} 
                            else if (session()->has('hn')) {echo 'बैनर विज्ञापन लगाने की प्रक्रिया प्रोडक्ट बूस्ट के समान है। अपने फोन पर एप्लिकेशन खोलें और होमपेज से "New" बटन पर क्लिक करें। फिर बॉक्स से “Banner ad” विकल्प चुनें। बेसिक, इंटरमीडिएट और प्रीमियम में से कोई भी प्लान चुनें।
                                अपने बैनर को एक अभियान नाम दें और वांछित फोटो अपलोड करें। आठ श्रेणियों में से कोई एक चुनें। आप चाहें तो ALL विकल्प भी चुन सकते हैं।
                                जिस राज्य में आप बैनर विज्ञापन चलाना चाहते हैं उसे चुनें और सबमिट बटन पर क्लिक करें। नियम और शर्तें ध्यान से पढ़ें और फिर पेमेंट प्रक्रिया पूरी करें। पेमेंट नेटबैंकिंग, यूपीआई, कार्ड या ई-वॉलेट के जरिए किया जा सकता है।
                                पेमेंट सफलतापूर्वक पूरा होने के बाद आपका बैनर अन्य सभी ब्रांडों के साथ एप्लिकेशन में दिखाई देगा।
                                ';} 
                            else { echo "The process of banner ads is more or less the same as the product boost. After opening the application on your phone, go to the 'New' option on the homepage. Then tap on it and from the box, select 'Banner ads'. You may choose any plan among Basic, Intermediate and Premium and tap on 'SELECT PLAN'. <br>
                                Provide a campaign name for your banner and upload a photo of your choice. After that, you have to choose one of the 8 categories. You can also select the 'All' option. Select the state where you want to promote your banner and tap on the submit option. After checking all the terms and conditions, check the tickbox written 'I accept the condition'. You will now be redirected to payment. You can make payments through UPI, Net Banking, Card or e-wallet. Click on the 'PAY NOW' button and complete the payment. <br>
                                And that's it. Your banner will be visible in the application."; } 
                            ?> 
              </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingSeven">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                 
                <?php if (session()->has('bn')) {echo 'কৃষি বিকাশের ভ্যালু অ্যাডেড সার্ভিস কী কী?
';} 
                            else if (session()->has('hn')) {echo 'कृषि विकास की मूल्य वर्धित सेवा क्या है?
                                ';} 
                            else { echo 'What are the value-added services of Krishi Vikas Udyog?'; } 
                            ?>
                </button>
                </h2>
                <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <?php if (session()->has('bn')) {echo 'মূল্য সংযোজন পরিষেবা বা ভ্যালু অ্যাডেড সার্ভিস কৃষি বিকাশ অ্যাপ্লিকেশনের এমন কিছু বৈশিষ্ট্য যা ব্যবহারকারীর অভিজ্ঞতা আরো ভালো করতে পারে এবং গ্রাহকদের বিভিন্ন উপায়ে সাহায্য করতে পারে। অ্যাপ্লিকেশনটিতে, একটি আবহাওয়া পূর্বাভাস সিস্টেম এবং একটি ফসল ক্যালেন্ডার রয়েছে।  প্রথমটি শস্য ব্যবস্থাপনা এবং গবাদি পশুর যত্নে গুরুত্বপূর্ণ সিদ্ধান্ত পরিচালনা করতে সহায়তা করে। বৃষ্টিপাত, তাপমাত্রা এবং ঝড়ের পূর্বাভাস রোপণ, সেচ এবং ফসল সংগ্রহের কৌশল পরিকল্পনায় সহায়তা করে। অন্যদিকে পরবর্তীটি সম্পদ ব্যবস্থাপনায় সহায়তা করে, ঝুঁকি কমায়, ফসলের ঘূর্ণন সক্ষম করে, বাজারের চাহিদার সাথে কৃষকদের অবগত করে এবং টেকসই কৃষি অনুশীলনের ব্যাপারে জানান দেয়। ';} 
                            else if (session()->has('hn')) {echo 'वैलु ऐडेड सर्विसेस या मूल्य वर्धित सेवाएँ कृषि विकास एप्लिकेशन की कुछ विशेषताएं हैं जो उपयोगकर्ता अनुभव को बेहतर बना सकती हैं और ग्राहकों को विभिन्न तरीकों से मदद कर सकती हैं। एप्लिकेशन में, एक मौसम पूर्वानुमान प्रणाली और एक फसल कैलेंडर है। पहला फसल प्रबंधन और पशुधन देखभाल में महत्वपूर्ण निर्णयों का मार्गदर्शन करने में मदद करता है। वर्षा, तापमान और तूफान के पूर्वानुमान से रोपण, सिंचाई और कटाई की योजना बनाने में मदद मिलती है।
                                दूसरी ओर, उत्तरार्द्ध संसाधन प्रबंधन में मदद करता है, जोखिम कम करता है, फसल चक्रण को सक्षम बनाता है, किसानों को बाजार की मांगों के बारे में सूचित करता है और टिकाऊ कृषि प्रथाओं की जानकारी देता है।
                                ';} 
                            else { echo 'Value-added services are some features of the Krishi Vikas application that can enhance the experience of the user and can help the stakeholder in different ways. In the application, there is a weather report forecast system and a crop calendar. The former helps in guiding crucial decisions in crop management and livestock care. Predictions on rainfall, temperature and storms aid in planning planting, irrigation and harvesting strategies. The latter on the other hand aids in efficient resource management, minimizes risks, enables crop rotation, aligns with market demands and promotes sustainable practices. '; } 
                            ?> </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingEight">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEight" aria-expanded="false" aria-controls="flush-collapseEight">
                
                <?php if (session()->has('bn')) {echo 'আমি কীভাবে প্রোডাক্ট “Sold” হিসাবে চিহ্নিত করব?
';} 
                            else if (session()->has('hn')) {echo 'मैं किसी प्रोडक्ट को "Sold" के रूप में कैसे चिह्नित करूं?
                                ';} 
                            else { echo 'How can I mark my product as sold?'; } 
                            ?>
                </button>
                </h2>
                <div id="flush-collapseEight" class="accordion-collapse collapse" aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                                <?php if (session()->has('bn')) {echo 'ক্রেতাদের সাথে কোনো ধরনের ভুল যোগাযোগ এড়াতে চুক্তির পরেই আপনার পণ্যগুলিকে "বিক্রীত" হিসাবে চিহ্নিত করা অপরিহার্য। এটি করতে, আপনার ফোনে অ্যাপ্লিকেশনটি খুলুন। এর পরে হোমপেজ থেকে আপনার প্রোফাইলে যান এবং তারপরে "My Posts " বিকল্প বাছুন। আপনি সেখানে তালিকাভুক্ত সমস্ত পণ্য দেখতে সক্ষম হবেন। তালিকা থেকে আপনি যে পণ্যটিকে বিক্রিত হিসাবে চিহ্নিত করতে চান সেটিতে ক্লিক করুন। উপরের ডানদিকের কোনে “Edit” বাটনে ক্লিক করুন এবং "Mark as Sold" অপশনে ক্লিক করুন। 
                                এখানেই আপনার কাজ শেষ। আপনার পণ্য সফলভাবে বিক্রিত হিসাবে চিহ্নিত করা হবে।
                                দয়া করে মনে রাখবেন যে আমাদের দ্বারা রিজেক্ট করা পণ্যগুলি বিক্রিত হিসাবে চিহ্নিত করা যাবে না।
                                ';} 
                            else if (session()->has('hn')) {echo 'खरीदारों के साथ किसी भी गलत संचार से बचने के लिए अनुबंध के तुरंत बाद अपने प्रोडक्ट को "Sold" के रूप में चिह्नित करना आवश्यक है। ऐसा करने के लिए, अपने फ़ोन पर एप्लिकेशन खोलें। इसके बाद होमपेज से अपनी प्रोफाइल पर जाएं और फिर "My Posts" विकल्प चुनें। आप वहां सूचीबद्ध सभी प्रोडक्ट देख पाएंगे। सूची से उस प्रोडक्ट पर क्लिक करें जिसे आप Sold के रूप में चिह्नित करना चाहते हैं।
                                ऊपरी दाएं कोने में "Edit" बटन पर क्लिक करें और "Mark as sold" विकल्प पर क्लिक करें।
                                आपका काम यहीं हो गया। आपके प्रोडक्ट को सफलतापूर्वक sold रूप में चिह्नित किया जाएगा।
                                कृपया ध्यान दें कि हमारे द्वारा अस्वीकृत प्रोडक्ट को sold  के रूप में चिह्नित नहीं किया जा सकता है।
                                ';} 
                            else { echo "It is essential to mark your products as 'sold' soon after the deal to avoid any sort of miscommunication with the buyers. To do so, open the application on your phone. After that go to your profile from the homepage and then tap on the 'My posts' option.
                                You will be able to see all the listed products there. From the list tap on the product you want to mark as sold. from the top right corner, click on the edit button and select the 'Mark as Sold' option. That's where your work is done. Your product will be marked as sold successfully. <br>
                                Please keep in mind that the products rejected by our end can not be marked as sold. "; } 
                            ?>
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingNine">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseNine" aria-expanded="false" aria-controls="flush-collapseNine">
                
                <?php if (session()->has('bn')) {echo 'কিভাবে কৃষি বিকাশ উদ্যোগের কাস্টমার সাপোর্ট টিমের সাথে যোগাযোগ করবেন?
';} 
                            else if (session()->has('hn')) {echo 'कृषि विकास उद्योग ग्राहक सहायता टीम से कैसे संपर्क करें?';} 
                            else { echo 'How to reach customer support of Krishi Vikas Udyog?'; } 
                            ?>
                </button>
                </h2>
                <div id="flush-collapseNine" class="accordion-collapse collapse" aria-labelledby="flush-headingNine" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <?php if (session()->has('bn')) {echo '
                            কৃষি বিকাশ উদ্যোগ দায়িত্বের সাথে আপনার সমস্যার যত্ন নেয়। যেকোনো সময়ে, আপনি যদি কোনো সমস্যার সম্মুখীন হন, আমাদের গ্রাহক সহায়তা দল আপনার সমস্যা সমাধানের জন্য প্রস্তুত। আপনার ফোনে অ্যাপ্লিকেশন খুলুন. হোমপেজে, আপনি উপরের ডানদিকে কোণায় তিনটি বিন্দু দেখতে পাবেন। তিনটি বিন্দুতে ক্লিক করুন। ড্রপ-ডাউন বক্স থেকে, কল বোতামে ক্লিক করুন এবং কল করুন। এইভাবে আপনি কৃষি বিকাশ উদ্যোগের  কাস্টমার সাপোর্ট টিমের সাথে সংযোগ করতে সক্ষম হবেন।
                            আপনার সুবিধার জন্য আমরা এখানেই কাস্টমার সাপোর্ট ফোন নম্বর এবং ইমেল দিয়ে রাখছি। 
                            Customer support contact no.:8100975657
                            Customer support Emal:support@krishivikas.com
                            ';} 
                            else if (session()->has('hn')) {echo 'कृषि विकास उद्योग आपकी समस्याओं का जिम्मेदारी से ध्यान रखता है। किसी भी समय, यदि आपको कोई समस्या आती है, तो हमारी ग्राहक सहायता टीम आपकी समस्या का समाधान करने के लिए तैयार है। अपने फ़ोन पर ऐप खोलें. होमपेज पर आपको ऊपरी दाएं कोने में तीन बिंदु दिखाई देंगे। तीन बिंदुओं पर क्लिक करें. ड्रॉप-डाउन बॉक्स से, कॉल बटन पर क्लिक करें और कॉल करें। इस तरह आप कृषि विकास उद्योग की ग्राहक सहायता टीम से जुड़ सकेंगे।
                                आपकी सुविधा के लिए हम यहीं ग्राहक सहायता फ़ोन नंबर और ईमेल प्रदान कर रहे हैं।
                                Customer support contact no.:8100975657
                                Customer support Emal:support@krishivikas.com
                                ';} 
                            else { echo 'Krishi Vikas Udyog takes care of your problems responsibly. At any point, if you face any issue, our customer support team is ready to solve your problems. Just open the application on your phone. On the homepage, you will see three dots in the top right corner. Click on the three dots. From the drop-down box, click on the call button and make a call. This way you will be able to connect with the customer support of Krishi Vikas Udyog.  <br>
                                To offer a hassle-free experience we have put the customer support phone no. and email address here. 
                                Customer support contact no.:8100975657
                                Customer support Emal:support@krishivikas.com'; } 
                            ?>

                </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        
    </section>
    <!-- FAQ SECTION END -->



    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    


<script>




$('.tractor_used').click(function(){
    var href = '{{ env('APP_URL')."tractor-list/old"}}';
    //alert(href);
    $("#tractor_viewall").attr("href", href);
    $("#cat_tractor").attr("href", href);
});

$('.tractor_new').click(function(){
    var href = '{{ env('APP_URL')."tractor-list/new" }}';
    //alert(href);
    $("#tractor_viewall").attr("href", href);
    $("#cat_tractor").attr("href", href);
});

$('.tractor_rent').click(function(){
    var href = '{{  env('APP_URL')."tractor-list/rent" }}';
    //alert(href);
    $("#tractor_viewall").attr("href", href);
    $("#cat_tractor").attr("href", href);
});


$('.good_vehicle_used').click(function(){
    var href = '{{ env('APP_URL')."good-vehicle-list/old"}}';
    //alert(href);
    $("#good_vehicle_viewall").attr("href", href);
    $("#cat_gv").attr("href", href);
});

$('.good_vehicle_new').click(function(){
    var href = '{{ env('APP_URL')."good-vehicle-list/new" }}';
    //alert(href);
    $("#good_vehicle_viewall").attr("href", href);
    $("#cat_gv").attr("href", href);
});

$('.good_vehicle_rent').click(function(){
    var href = '{{  env('APP_URL')."good-vehicle-list/rent" }}';
    //alert(href);
    $("#good_vehicle_viewall").attr("href", href);
    $("#cat_gv").attr("href", href);
});
   
   
$('.seeds').click(function(){
    var href = '{{ env('APP_URL')."seeds-list"}}';
    //alert(href);
    $("#seeds_viewall").attr("href", href);
    $("#cat_seeds").attr("href", href);
});

$('.pesticides').click(function(){
    var href = '{{ env('APP_URL')."pesticides-list" }}';
    //alert(href);
    $("#seeds_viewall").attr("href", href);
    $("#cat_pesticide").attr("href", href);
});

$('.fertilizer').click(function(){
    var href = '{{  env('APP_URL')."fertilizer-list" }}';
    //alert(href);
    $("#seeds_viewall").attr("href", href);
    $("#cat_fertilizer").attr("href", href);
});

$('.implements_used').click(function(){
    var href = '{{ env('APP_URL')."implements-list/old"}}';
    //alert(href);
    $("#implements_viewall").attr("href", href);
    $("#cat_implements").attr("href", href);
});

$('.implements_new').click(function(){
    var href = '{{ env('APP_URL')."implements-list/new" }}';
    //alert(href);
    $("#implements_viewall").attr("href", href);
    $("#cat_implements").attr("href", href);
});

$('.implements_rent').click(function(){
    var href = '{{  env('APP_URL')."implements-list/rent" }}';
    //alert(href);
    $("#implements_viewall").attr("href", href);
    $("#cat_implements").attr("href", href);
});

$('.harvester_used').click(function(){
    var href = '{{ env('APP_URL')."harvester-list/old"}}';
    //alert(href);
    $("#harvester_viewall").attr("href", href);
    $("#cat_harvester").attr("href", href);
});

$('.harvester_new').click(function(){
    var href = '{{ env('APP_URL')."harvester-list/new" }}';
    //alert(href);
    $("#harvester_viewall").attr("href", href);
    $("#cat_harvester").attr("href", href);
});

$('.harvester_rent').click(function(){
    var href = '{{  env('APP_URL')."harvester-list/rent" }}';
    //alert(href);
    $("#harvester_viewall").attr("href", href);
    $("#cat_harvester").attr("href", href);
});

$('.tyre_used').click(function(){
    var href = '{{ env('APP_URL')."tyre-list/old" }}';
    //alert(href);
    $("#tyre_viewall").attr("href", href);
    $("#cat_tyre").attr("href", href);
});

$('.tyre_new').click(function(){
    var href = '{{  env('APP_URL')."tyre-list/new" }}';
    //alert(href);
    $("#tyre_viewall").attr("href", href);
    $("#cat_tyre").attr("href", href);
});


function slon(){
    //alert(sessionStorage.getItem("KVMobile"));
    var kvmobile = sessionStorage.getItem("KVMobile");
    if (typeof(kvmobile) !== "undefined" && kvmobile !== null && kvmobile !== '') {
     
    } else {
        $("#myBtn").click();
    }
    
}

window.onload = setTimeout(slon, 30000);


// var str = $('.ptag').val();
// console.log(str);
// if(str.length > 25) {
//   str = str.substring(0,25);
//   $('.ptag').val(str);
//   //document.getElementById('ptag').innerHTML= str+'...';
// } else {
//     $('.ptag').val(str);
//   //document.getElementById('ptag').innerHTML= str;
// }

</script>

<!--WEATHER JS-->

<!-- <script src="{{ URL::asset('assets/js/weather.js')}}"></script> -->
<script src="{{ URL::asset('assets/js/weather-update.js')}}"></script>



@endsection  