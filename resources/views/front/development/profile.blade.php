@extends('layout.main')
@section('page-container')
<?php //print_r($data); 
//print_r($data->location); 
//print_r($data->location['district_name']); 
 //exit;
 use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();

?>
<section class="my-profile pt-4">
    

    <div class="container">
        <div class="banner-profile-header">
            <h2 class="text-white fw-bold name" style="margin-left: 300px">Lorem Ipsum</h2>
            
            <div class="profile-picture">
                    <label for="image-input">
                        <div class="cam">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </label>
                    <input type="file" id="image-input" name="image" accept="image/*" class="d-none">

                    <div class="profile-img-box">
                        @if ($data->photo)
                        <img src="{{ env('APP_URL').'/storage/photo/'.$data->photo}}" alt="" id="image-preview1">
                        @else
                        <img src="{{ URL::asset('img/istockphoto-1316420668-612x612.jpg')}}" alt="" id="image-preview1">
                        @endif
                    </div>
            </div>
        </div>

        <div class="text-end mt-3">
        <h1 class="fw-bolder py-2  border border-black border-3 px-5 d-inline-block rounded-pill"><?php if (session()->has('bn')) {echo $lang['bn']['My Profile'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['My Profile'];} 
                        else { echo 'My Profile'; } 
                        ?></h1>
        </div>
        
            <!-- <div
                class="py-5 text-center bg-profile mb-3 d-flex flex-column align-items-center justify-content-center ">
                <div class="">
                    

                    <h3 class="pt-4">{{$data->name}}</h3>

                    <div class="ph-no">
                        <i class="fa-solid fa-mobile-screen"></i>
                        <p>{{$data->mobile}}</p>
                    </div>

                    <div class="email-id">
                        <i class="fa-regular fa-envelope"></i>
                        <p>{{$data->email}}</p>
                    </div>
                </div>



            </div> -->

            <div class="row panel-wrapper py-3">
                
                <div class="col-md-3">
                    <div class="pro-options bg-white rounded rounded-4 p-3">
                        <ul id="menu" class="m-0 list-unstyled">
                            <li><a href="#" data-target="page1" class="active-pro-menu"> <i class="ri-layout-grid-fill"></i>
                                <?php if (session()->has('bn')) {echo $lang['bn']['My Dashboard'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['My Dashboard'];} 
                            else { echo 'My Dashboard'; } 
                            ?></a></li>
                            <!-- <li><a href="#" data-target="page2"> <i class="ri-signpost-fill"></i>
                                <?php if (session()->has('bn')) {echo $lang['bn']['my posts'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['my posts'];} 
                            else { echo 'my posts'; } 
                            ?></a></li>
                            <li><a href="#" data-target="page3"><i class="ri-line-height"></i>
                                <?php if (session()->has('bn')) {echo $lang['bn']['my leads'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['my leads'];} 
                                else { echo 'my leads'; } 
                                ?></a></li> -->
                            <li><a href="#" data-target="page4"><i class="ri-archive-stack-line"></i>
                                <?php if (session()->has('bn')) {echo $lang['bn']['my enquiry'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['my enquiry'];} 
                                else { echo 'my enquiry'; } 
                                ?></a></li>
                            <li><a href="#page4" data-target="page5"><i class="ri-profile-fill"></i>
                                <?php if (session()->has('bn')) {echo $lang['bn']['Profile'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['Profile'];} 
                                else { echo 'Profile'; } 
                                ?></a></li>
                            <li><a href="#" data-target="page6"><i class="ri-settings-fill"></i>
                                <?php if (session()->has('bn')) {echo $lang['bn']['setting'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['setting'];} 
                                else { echo 'setting'; } 
                                ?></a></li>
                            <li><a href="#" data-target="page7"><i class="ri-hand-heart-fill"></i>
                                <?php if (session()->has('bn')) {echo $lang['bn']['help center'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['help center'];} 
                                else { echo 'help center'; } 
                                ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                <div class="pages bg-white m-1 p-3 rounded rounded-4">
                    <!-- MY DASHBOARD SECTION -->
                    <div id="page1" class="page active animate__animated animate__zoomIn">
                        <div class="dashboard">
                            <div class="subscription-details d-flex justify-content-between align-items-center px-md-5 px-2">
                                <h3>No Ad Subscriptions</h3>
                                <a href="#">Subscribe</a>
                            </div>
                            <div class="product-boost-details d-flex justify-content-between align-items-center px-md-5 px-2">
                                <h3>No Product Boosted</h3>
                                <a href="#">Boost</a>
                            </div>
                            <div class="my-posts">
                                <a href="/myposts">
                                    <i class="ri-list-check-2"></i>
                                    <h5>My Posts</h5>
                                </a>
                            </div>
                            <div class="my-leads">
                                <a href="#">
                                    <i class="ri-group-fill"></i>
                                    <h5>My Leads</h5>
                                </a>
                            </div> 
                            <div class="my-banner">
                                <a href="/mybanners">
                                    <i class="ri-gallery-fill"></i>
                                    <h5>My Banner</h5>
                                </a>
                            </div>
                            <div class="new-ads">
                                <a href="#">
                                    <i class="ri-sticky-note-add-fill"></i>
                                    <h5>New Ads</h5>
                                </a>
                            </div>
                            <div class="my-boosts">
                                <a href="/myboosts">
                                    <i class="ri-rocket-2-fill"></i>
                                    <h5>My Boosts</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="page2" class="page animate__animated animate__zoomIn">
                        <!-- MY POST SECTION -->
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6 d-flex gap-4">
                                            <div class="mpost-img-box text-center">
                                                <a href="{{route('my.tractor')}}" style="color:#000;text-decoration: none;"><img
                                                        src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}"
                                                        alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                                                    else { echo 'TRACTOR'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">{{$my_p_tractor}}</p></a>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <a href="{{route('my.goods_vehicle')}}" style="color:#000;text-decoration: none;"><img
                                                        src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}"
                                                        alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                                                    else { echo 'GOODS VEHICLE'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">{{$my_p_goods_vehicle}}
                                                </p></a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex gap-4">

                                            <div class="mpost-img-box text-center">
                                                <a href="{{route('my.seeds')}}" style="color:#000;text-decoration: none;"><img
                                                        src="{{ URL::asset('assets/images/cat-logos/seeds-removebg-preview.png')}}"
                                                        alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];} 
                                                    else { echo 'SEEDS'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">{{$my_p_seeds}}</p></a>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <a href="{{route('my.pesticides')}}" style="color:#000;text-decoration: none;"><img
                                                        src="{{ URL::asset('assets/images/cat-logos/pesticide-removebg-preview.png')}}"
                                                        alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['PESTICIDES'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['PESTICIDES'];} 
                                                    else { echo 'PESTICIDES'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">{{$my_p_pesticides}}</p></a>
                                            </div>
                                                                                        
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6 d-flex gap-4">

                                            <div class="mpost-img-box text-center">
                                                <a href="{{route('my.fertilizers')}}" style="color:#000;text-decoration: none;"><img
                                                        src="{{ URL::asset('assets/images/cat-logos/fertilizer-removebg-preview.png')}}"
                                                        alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['FERTILIZERS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['FERTILIZERS'];} 
                                                    else { echo 'FERTILIZERS'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">{{$my_p_fertilizers}}</p></a>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <a href="{{route('my.harvester')}}" style="color:#000;text-decoration: none;"><img
                                                        src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}"
                                                        alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                                                    else { echo 'HARVESTER'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">{{$my_p_harvester}}</p></a>
                                            </div>

                                            
                                        </div>
                                        <div class="col-md-6 d-flex gap-4">
                                            <div class="mpost-img-box text-center">
                                                <a href="{{route('my.implements')}}" style="color:#000;text-decoration: none;"><img
                                                        src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}"
                                                        alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                                                    else { echo 'IMPLEMENTS'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">{{$my_p_implements}}</p></a>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <a href="{{route('my.tyres')}}" style="color:#000;text-decoration: none;"><img
                                                        src="{{ URL::asset('assets/images/cat-logos/tyre-removebg-preview.png')}}"
                                                        alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['TYRES'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['TYRES'];} 
                                                    else { echo 'TYRES'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">{{$my_p_tyres}}</p></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="page3" class="page animate__animated animate__zoomIn">
                        <div class="container">
                            <div class="row m-0 p-0">
                                <div class="col-md-12">
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6 d-flex gap-4">
                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                                                    else { echo 'TRACTOR'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                                                    else { echo 'GOODS VEHICLE'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex gap-4">
                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/seeds-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];} 
                                                    else { echo 'SEEDS'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/pesticide-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['PESTICIDES'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['PESTICIDES'];} 
                                                    else { echo 'PESTICIDES'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6 d-flex gap-4">
                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/fertilizer-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['FERTILIZERS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['FERTILIZERS'];} 
                                                    else { echo 'FERTILIZERS'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                                                    else { echo 'HARVESTER'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>

                                            
                                        </div>
                                        <div class="col-md-6 d-flex gap-4">
                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                                                    else { echo 'IMPLEMENTS'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/tyre-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['TYRES'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['TYRES'];} 
                                                    else { echo 'TYRES'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="page4" class="page animate__animated animate__zoomIn">
                        <div class="container">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6 d-flex gap-4">
                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                                                    else { echo 'TRACTOR'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                                                    else { echo 'GOODS VEHICLE'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex gap-4">
                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/seeds-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];} 
                                                    else { echo 'SEEDS'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/pesticide-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['PESTICIDES'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['PESTICIDES'];} 
                                                    else { echo 'PESTICIDES'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>


                                            

                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6 d-flex gap-4">
                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/fertilizer-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['FERTILIZERS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['FERTILIZERS'];} 
                                                    else { echo 'FERTILIZERS'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                                                    else { echo 'HARVESTER'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>

                                            
                                        </div>
                                        <div class="col-md-6 d-flex gap-4">
                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                                                    else { echo 'IMPLEMENTS'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>

                                            <div class="mpost-img-box text-center">
                                                <img src="{{ URL::asset('assets/images/cat-logos/tyre-removebg-preview.png')}}"
                                                    alt="" class="img-fluid">
                                                <p class="m-0 fs-5 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['TYRES'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['TYRES'];} 
                                                    else { echo 'TYRES'; } 
                                                    ?></p>
                                                <p class="counter m-0 fs-5 fw-bold text-white">00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="page5" class="page profile-form animate__animated animate__zoomIn">

                        <!-- PROFILE SECTION -->
                        <form method="post" action="{{route('profile.update')}}" class="container">
                        <div class="row">
                            <div class="col-md-6">
                            @csrf
                            <label class="fieldlabels"><?php if (session()->has('bn')) {echo $lang['bn']['Name'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['Name'];} 
                                else { echo 'Name'; } 
                                ?>: *</label>
                            <input type="text" name="name" placeholder="Name" value="{{$data->name}}" />
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <?php $user_type_id = DB::table('user')->where(['mobile'=>session()->get('KVMobile')])->value('user_type_id');
                            if ($user_type_id==2) { ?>
                            
                                <label class="fieldlabels"><?php if (session()->has('bn')) {echo $lang['bn']['Company Name'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['Company Name'];} 
                                    else { echo 'Company Name'; } 
                                    ?>: *</label>
                            <input type="text" name="company_name" placeholder="Company Name" value="{{$data->company_name}}" />
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <label class="fieldlabels"><?php if (session()->has('bn')) {echo $lang['bn']['GST Number'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['GST Number'];} 
                                else { echo 'GST Number'; } 
                                ?>: *</label>
                            <input type="text" name="gst_no" placeholder="GST Number" value="{{$data->gst_no}}" />
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <?php } ?>


                            <label class="fieldlabels"><?php if (session()->has('bn')) {echo $lang['bn']['Phone number'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['Phone number'];} 
                                else { echo 'Phone No.'; } 
                                ?>: *</label>
                            <input type="text" name="phno" placeholder="Mobile No." value="{{$data->mobile}}"
                                readonly />

                            <label class="fieldlabels"><?php if (session()->has('bn')) {echo $lang['bn']['Email'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['Email'];} 
                                else { echo 'Email'; } 
                                ?>: </label>
                            <input type="email" name="email" placeholder="Email" value="{{$data->email}}" />


                            <label class="fieldlabels"><?php if (session()->has('bn')) {echo $lang['bn']['zipcode'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['zipcode'];} 
                                else { echo 'Zipcode'; } 
                                ?>: *</label>
                            <input type="text" name="pincode" placeholder="Zipcode" id="reg_pincode"
                                value="{{$data->zipcode}}" on />
                            @error('pincode')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <label class="fieldlabels"><?php if (session()->has('bn')) {echo $lang['bn']['State Name'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['State Name'];} 
                                else { echo 'State Name'; } 
                                ?>: </label>
                            <input type="text" name="state" id="reg_state" placeholder="State Name"
                                value="{{$data->location['state_name']}}" readonly />
                            </div>
                            <div class="col-md-6">
                            <label class="fieldlabels"><?php if (session()->has('bn')) {echo $lang['bn']['City/town/Area'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['City/town/Area'];} 
                                else { echo 'City/town/Area'; } 
                                ?>: </label>
                            <input type="text" name="city" id="reg_city" placeholder="City/town/Area"
                                value="{{$data->location['city_name']}}" readonly />

                            <label class="fieldlabels"><?php if (session()->has('bn')) {echo $lang['bn']['Address'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['Address'];} 
                                else { echo 'Address'; } 
                                ?>: </label>
                            <textarea name="address" id="address" cols="20" rows="10"
                                placeholder="Address">{{$data->address}}</textarea>

                            <label class="fieldlabels"><?php if (session()->has('bn')) {echo $lang['bn']['Date Of Birth'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['Date Of Birth'];} 
                                else { echo 'Date Of Birth'; } 
                                ?>: </label>
                            <input type="date" name="dob" id="dob" placeholder="Date Of Birth" value="{{$data->dob}}" />
                            </div>
                        </div>
                            

                            

                            <div class="button text-center">
                                <button class="text-center"><?php if (session()->has('bn')) {echo $lang['bn']['submit'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['submit'];} 
                                    else { echo 'Submit'; } 
                                    ?></button>
                            </div>
                        </form>

                    </div>
                    <div id="page6" class="page animate__animated animate__zoomIn">
                        <div class="container tractor-brand" id="msform1">

                            <form action="{{route('profileSettings.update')}}" method="post">
                                @csrf
                                
                                <div class="form-check  flip-flop">
                                    <div> <label class="form-check-label fw-bold" for="flexSwitchCheckDefault"><?php if (session()->has('bn')) {echo $lang['bn']['Email Newslatter'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['Email Newslatter'];} 
                                        else { echo 'Email Newslatter'; } 
                                        ?></label></div>
                                    <div><div class="form-check d-flex gap-5">
                                    <div>
                                          <input class="form-check-input" type="radio" name="email_newslatter" id="flexRadioDefault1" value="1" <?php if ($data->email_newslatter==1) {echo 'checked';} ?>>
                                    <label class="form-check-label" for="flexRadioDefault1" >
                                        <?php if (session()->has('bn')) {echo $lang['bn']['yes'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['yes'];} 
                                        else { echo 'Yes'; } 
                                        ?></label>
                                    </div>
                                    <div>
                                      <input class="form-check-input" type="radio" name="email_newslatter" id="flexRadioDefault1" value="0" <?php if ($data->email_newslatter==0) {echo 'checked';} ?>>
                                    <label class="form-check-label" for="flexRadioDefault1" >
                                        <?php if (session()->has('bn')) {echo $lang['bn']['no'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['no'];} 
                                        else { echo 'No'; } 
                                        ?>
                                    </label>
                                    </div>
                                </div></div>
                                </div>
                                
                                
                                <div class="form-check  flip-flop">
                                    <div> <label class="form-check-label fw-bold" for="flexSwitchCheckDefault"><?php if (session()->has('bn')) {echo $lang['bn']['whatsapp notification'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['whatsapp notification'];} 
                                        else { echo 'Email Newslatter'; } 
                                        ?></label></div>
                                    <div><div class="form-check d-flex gap-5">
                                    <div>
                                          <input class="form-check-input" type="radio" name="whatsapp_notification" id="flexRadioDefault1" value="1" <?php if ($data->whatsapp_notification==1) {echo 'checked';} ?>>
                                    <label class="form-check-label" for="flexRadioDefault1" >
                                        <?php if (session()->has('bn')) {echo $lang['bn']['yes'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['yes'];} 
                                        else { echo 'Yes'; } 
                                        ?></label>
                                    </div>
                                    <div>
                                      <input class="form-check-input" type="radio" name="whatsapp_notification" id="flexRadioDefault1" value="0" <?php if ($data->whatsapp_notification==0) {echo 'checked';} ?>>
                                    <label class="form-check-label" for="flexRadioDefault1" >
                                        <?php if (session()->has('bn')) {echo $lang['bn']['no'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['no'];} 
                                        else { echo 'No'; } 
                                        ?>
                                    </label>
                                    </div>
                                </div></div>
                                </div>
                                
                                <div class="form-check  flip-flop">
                                    <div> <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">
                                        <?php if (session()->has('bn')) {echo $lang['bn']['promition offer'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['promition offer'];} 
                                        else { echo 'Promition Offer'; } 
                                        ?></label></div>
                                    <div><div class="form-check d-flex gap-5">
                                    <div>
                                          <input class="form-check-input" type="radio" name="promotion" id="flexRadioDefault1" value="1" <?php if ($data->promotin==1) {echo 'checked';} ?>>
                                    <label class="form-check-label" for="flexRadioDefault1" >
                                        <?php if (session()->has('bn')) {echo $lang['bn']['yes'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['yes'];} 
                                        else { echo 'Yes'; } 
                                        ?></label>
                                    </div>
                                    <div>
                                      <input class="form-check-input" type="radio" name="promotion" id="flexRadioDefault1" value="0" <?php if ($data->promotin==0) {echo 'checked';} ?>>
                                    <label class="form-check-label" for="flexRadioDefault1" >
                                        <?php if (session()->has('bn')) {echo $lang['bn']['no'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['no'];} 
                                        else { echo 'No'; } 
                                        ?>
                                    </label>
                                    </div>
                                </div></div>
                                </div>
                                
                                <div class="form-check  flip-flop">
                                    <div> <label class="form-check-label fw-bold" for="flexSwitchCheckDefault"><?php if (session()->has('bn')) {echo $lang['bn']['marketing communication'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['marketing communication'];} 
                                        else { echo 'Marketing Communication'; } 
                                        ?></label></div>
                                    <div><div class="form-check d-flex gap-5">
                                    <div>
                                          <input class="form-check-input" type="radio" name="marketing" id="flexRadioDefault1" value="1" <?php if ($data->marketing_communication==1) {echo 'checked';} ?>>
                                    <label class="form-check-label" for="flexRadioDefault1" >
                                        <?php if (session()->has('bn')) {echo $lang['bn']['yes'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['yes'];} 
                                        else { echo 'Yes'; } 
                                        ?></label>
                                    </div>
                                    <div>
                                      <input class="form-check-input" type="radio" name="marketing" id="flexRadioDefault1" value="0" <?php if ($data->marketing_communication==0) {echo 'checked';} ?>>
                                    <label class="form-check-label" for="flexRadioDefault1" >
                                        <?php if (session()->has('bn')) {echo $lang['bn']['no'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['no'];} 
                                        else { echo 'No'; } 
                                        ?>
                                    </label>
                                    </div>
                                </div></div>
                                </div>
                                
                                <div class="form-check  flip-flop">
                                    <div> <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">
                                        <?php if (session()->has('bn')) {echo $lang['bn']['social media'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['social media'];} 
                                        else { echo 'Social Media'; } 
                                        ?></label></div>
                                    <div><div class="form-check d-flex gap-5">
                                    <div>
                                          <input class="form-check-input" type="radio" name="social_media" id="flexRadioDefault1" value="1" <?php if ($data->social_media_promotion==1) {echo 'checked';} ?>>
                                    <label class="form-check-label" for="flexRadioDefault1" >
                                        <?php if (session()->has('bn')) {echo $lang['bn']['yes'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['yes'];} 
                                        else { echo 'Yes'; } 
                                        ?></label>
                                    </div>
                                    <div>
                                      <input class="form-check-input" type="radio" name="social_media" id="flexRadioDefault1" value="0" <?php if ($data->social_media_promotion==0) {echo 'checked';} ?>>
                                    <label class="form-check-label" for="flexRadioDefault1" >
                                        <?php if (session()->has('bn')) {echo $lang['bn']['no'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['no'];} 
                                        else { echo 'No'; } 
                                        ?>
                                    </label>
                                    </div>
                                </div></div>
                                </div>
                
                                
                                <div class="button text-center">
                                    <button class="text-center"><?php if (session()->has('bn')) {echo $lang['bn']['submit'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['submit'];} 
                                        else { echo 'Submit'; } 
                                        ?></button>
                                </div>
                            </form>




                        </div>
                    </div>
                    <div id="page7" class="page animate__animated animate__zoomIn">
                        <div class="container-fluid">
                            <div class="form-check flip-flop">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div class="">
                                        <p class="m-0 fw-bold">
                                            <?php if (session()->has('bn')) {echo $lang['bn']['ABOUT US'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['ABOUT US'];} 
                                        else { echo 'ABOUT US'; } 
                                        ?></p>
                                    </div>
                                    <div class="">
                                        <a href="{{url('about-us')}}" target="_blank">Click Here</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check flip-flop">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div class="">
                                        <p class="m-0 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['PRIVACY POLICY'];} 
                                            else if (session()->has('hn')) {echo $lang['hn']['PRIVACY POLICY'];} 
                                            else { echo 'PRIVACY POLICY'; } 
                                            ?></p>
                                    </div>
                                    <div class="">
                                        <a href="{{url('privacy-policy')}}" target="_blank">Click Here</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check flip-flop">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div class="">
                                        <p class="m-0 fw-bold">
                                            <?php if (session()->has('bn')) {echo $lang['bn']['TERMS OF USE'];} 
                                            else if (session()->has('hn')) {echo $lang['hn']['TERMS OF USE'];} 
                                            else { echo 'TERMS OF USE'; } 
                                            ?></p>
                                    </div>
                                    <div class="">
                                        <a href="{{url('terms-condition')}}" target="_blank">Click Here</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check flip-flop">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <div class="">
                                        <p class="m-0 fw-bold">
                                            <?php if (session()->has('bn')) {echo $lang['bn']['DATA PRIVACY'];} 
                                            else if (session()->has('hn')) {echo $lang['hn']['DATA PRIVACY'];} 
                                            else { echo 'DATA PRIVACY'; } 
                                            ?></p>
                                    </div>
                                    <div class="">
                                        <a href="{{url('data-privacy')}}" target="_blank">Click Here</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                </div>
                

            </div>
        
    </div>
</section>


@endsection