<!DOCTYPE html>
<html lang="en">
<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();


?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="RENT A USED TRACTOR">
    <meta name="description" content="Krishi Vikas Udyog helps both small and large-scale farmers rent used tractors of different brands from eligible sellers to buyers at various mutually accepted ranges.">
    

    <link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/images/KV 16 by 16-01.png')}}">
    <title>KRISHI VIKAS UDYOG | RENT A USED TRACTOR</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/product.css')}}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- OWL CAROUSEL CDN -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/owl.theme.default.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/owl.carousel.css')}}">

    <!-- BOOTSTRAP CDNS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <!-- ANIMATE CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/owl.carousel.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
/>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <!-- HEADER SECTION START -->
    <header id="header">


        <div class="right-head">

            <div class="nav1 py-1 px-5 border-bottom">
                <div class="phone-and-email d-flex gap-2 align-items-center">
                    <small class="d-lg-block d-none border-end pe-2 border-dark "><a href="mailto:support@krishivikas.com" class="text-decoration-none text-white"><i class="fa-sharp fa-solid fa-envelope"></i>
                                    &nbsp;support@krishivikas.com</a></small>
                    <small class="d-lg-block d-none"><a href="tel:8100975657" class="text-decoration-none text-white"><i
                                class="fa-sharp fa-solid fa-phone"></i> 8100975657 </a></small>
                </div>


                <section class="category sell-cat">

                    <div class="text-center mt-2">
                        <h2>
                            <?php if (session()->has('bn')) {echo $lang['bn']['What do you want to sell?'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['What do you want to sell?'];} 
                                                    else { echo 'What do you want to sell?'; } 
                                                    ?></h2>
                    </div>
                    <div class="container-fluid p-0">

                        <div class="cat-content-list  flex-wrap justify-content-center">
                            <?php 
                                if (session()->has('KVMobile')) {
                                    $profile_update = DB::table('user')->where(['mobile'=>session()->get('KVMobile')])->value('profile_update');
                                } else {
                                    $profile_update = 0;
                                }
                            ?>
                            <?php //if ($profile_update==1) { ?>
                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('tractor.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}"
                                            alt="" class="sell_trac"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                                    else { echo 'TRACTOR'; } 
                                    ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p>
                                    <?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                                        else { echo 'TRACTOR'; } 
                                        ?></p>
                            </div>
                            @endif



                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('gv.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}"
                                            alt="" class="sell_trac"></a>
                                </div>
                                <p>
                                    <?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                                                            else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                                                            else { echo 'GOODS VEHICLE'; } 
                                                            ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                                    else { echo 'GOODS VEHICLE'; } 
                                    ?></p>
                            </div>
                            @endif

                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('seeds.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/seeds-removebg-preview.png')}}"
                                            alt="" class="sell_trac"></a>
                                </div>
                                <p>
                                    <?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];} 
                                        else { echo 'SEEDS'; } 
                                        ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/seeds-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];} 
                                    else { echo 'SEEDS'; } 
                                    ?></p>
                            </div>
                            @endif


                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('pesticide.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/pesticide-removebg-preview.png')}}"
                                            alt="" class="sell_trac"></a>
                                </div>
                                <p>
                                    <?php if (session()->has('bn')) {echo $lang['bn']['PESTICIDES'];} 
                                                            else if (session()->has('hn')) {echo $lang['hn']['PESTICIDES'];} 
                                                            else { echo 'PESTICIDES'; } 
                                                            ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/pesticide-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['PESTICIDES'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['PESTICIDES'];} 
                                    else { echo 'PESTICIDES'; } 
                                    ?></p>
                            </div>
                            @endif


                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('fertilizer.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/fertilizer-removebg-preview.png')}}"
                                            alt="" class="sell_trac"></a>
                                </div>
                                <p>
                                    <?php if (session()->has('bn')) {echo $lang['bn']['FERTILIZERS'];} 
                                                            else if (session()->has('hn')) {echo $lang['hn']['FERTILIZERS'];} 
                                                            else { echo 'FERTILIZERS'; } 
                                                            ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/fertilizer-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['FERTILIZERS'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['FERTILIZERS'];} 
                                    else { echo 'FERTILIZERS'; } 
                                    ?></p>
                            </div>
                            @endif


                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('harvester.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}"
                                            alt="" class="sell_trac"></a>
                                </div>
                                <p>
                                    <?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                                        else { echo 'HARVESTER'; } 
                                        ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                                    else { echo 'HARVESTER'; } 
                                    ?></p>
                            </div>
                            @endif


                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('implement.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}"
                                            alt="" class="sell_trac"></a>
                                </div>
                                <p>
                                    <?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                                        else { echo 'IMPLEMENTS'; } 
                                        ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                                    else { echo 'IMPLEMENTS'; } 
                                    ?></p>
                            </div>
                            @endif


                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('tyre.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/tyre-removebg-preview.png')}}"
                                            alt="" class="sell_trac"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['TYRES'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['TYRES'];} 
                                    else { echo 'TYRES'; } 
                                    ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/tyre-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['TYRES'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['TYRES'];} 
                                    else { echo 'TYRES'; } 
                                    ?></p>
                            </div>
                            @endif

                        </div>
                    </div>
                </section>



                <section class="category rent-cat">
                    <div class="container-fluid p-0">
                        <div class="text-center mt-2">
                            <h2>
                                <?php if (session()->has('bn')) {echo $lang['bn']['What do you want to rent?'];} 
                                                        else if (session()->has('hn')) {echo $lang['hn']['What do you want to rent?'];} 
                                                        else { echo 'What do you want to rent?'; } 
                                                        ?></h2>
                        </div>

                        <div class="cat-content-list bs-height h-2">
                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('tractor.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}"
                                            alt="" class="rent_trac"></a>
                                </div>
                                <p>
                                    <?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                                        else { echo 'TRACTOR'; } 
                                        ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p>
                                    <?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                                        else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                                        else { echo 'TRACTOR'; } 
                                        ?></p>
                            </div>
                            @endif



                            @if ($profile_update==1)
                            {{-- <a href="{{route('tractor.post')}}" id="sell_trac">SELL</a> --}}
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('gv.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}"
                                            alt="" class="rent_trac"></a>
                                </div>
                                <p>
                                    <?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                                                            else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                                                            else { echo 'GOODS VEHICLE'; } 
                                                            ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                                    else { echo 'GOODS VEHICLE'; } 
                                    ?></p>
                            </div>
                            @endif


                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('harvester.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}"
                                            alt="" class="rent_trac"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                                    else { echo 'HARVESTER'; } 
                                    ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                                    else { echo 'HARVESTER'; } 
                                    ?></p>
                            </div>
                            @endif

                            @if ($profile_update==1)
                            <div class="cat-image-box ">
                                <div class="cat-img ">
                                    <a href="{{route('implement.post')}}"> <img
                                            src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}"
                                            alt="" class="rent_trac"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                                    else { echo 'IMPLEMENTS'; } 
                                    ?></p>
                            </div>
                            @else
                            <div class="cat-image-box">
                                <div class="cat-img ">
                                    <a> <img src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}"
                                            alt="" class="myBtn"></a>
                                </div>
                                <p><?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                                    else { echo 'IMPLEMENTS'; } 
                                    ?></p>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>

                <div class="location-language-socialicon d-flex gap-3 align-items-center">
                <div id="pin" class="d-md-flex align-items-center gap-1 d-none">
                <i class="ri-map-pin-2-fill"></i>
                    <span> <small style="font-size: 20px" class="border-end pe-2 border-dark">
                            <?php
                    $dist = DB::table('district as d')
                                ->join('city as c', 'd.id' ,'=', 'c.district_id' )
                                ->select('d.*')
                                ->where('c.pincode', session()->get('pincode'))
                                ->where('c.status', 1)->get();
                                //print_r($dist);
                                echo $dist[0]->district_name;
                                //echo $dist[0]['district_name'];
                    //DB::table('city')->where(['pincode'=>session()->get('pincode')])->value('city_name');
                    ?>
                        </small> </span>
                </div>

                <div class="bg-white px-2 pin-input">
                    <div id="msform1" class="d-flex align-items-center gap-2">
                        <input type="number" id="pincode1" placeholder="Enter Pincode"
                            style="margin-bottom: 0px !important;" value="<?php
                                    if (session()->has('pincode')) {echo $pincode = session()->get('pincode');} else {echo $pincode = session()->put('pincode',$pincode_ip);
                                    } ?>" />
                        <button type="button" id="pincode_apply1" class="btn login ms-2">APPLY</button>
                    </div>
                </div>

                <div class="d-flex align-items-center position-relative" id="language-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="black" class="bi bi-translate text-white" viewBox="0 0 16 16">
            <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z"/>
            <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.94.31z"/>
            </svg>
            <input type="hidden" id="lang_id" value="<?php if (session()->has('hn')) {echo 'hn';} 
            else if (session()->has('bn')) {echo 'bn';} 
            else { echo 'en'; } 
            ?>"/>
                <small class="border-end pe-2 border-dark"> &nbsp; <?php if (session()->has('hn')) {echo 'हिंदी';} 
                                    else if (session()->has('bn')) {echo 'বাংলা';} 
                                    else { echo 'English'; } 
                                    ?> <i class="ri-arrow-down-s-line"></i></small>
                                    

                    <div id="language-dropdown" style="display: none;">
                        <ul>
                            <li><a href="{{url('en')}}">English</a></li>
                            <li><a href="{{url('hn')}}">हिंदी</a></li>
                            <li><a href="{{url('bn')}}">বাংলা</a></li>
                        </ul>
                    </div>
                </div>
                

                <!-- Social Icon -->

                <div class="social-logo d-flex flex-wrap gap-3">
                            <div class="">
                                <a href="https://www.facebook.com/joinkrishivikas" target="_blank"><i class="ri-facebook-circle-fill"></i></a>
                            </div>
                            <div class="">
                                <a href="https://www.instagram.com/joinkrishivikas/" target="_blank"><i class="ri-instagram-fill"></i></a>
                            </div>
                            <div class="">
                                <a href="https://twitter.com/JoinKrishiVikas" target="_blank"><i class="ri-twitter-x-fill"></i></a>
                            </div>
                        </div>
                
                <?php //echo session()->get('KVMobile');exit;?>
                
                </div>

            </div>

            


                <div class="mid-nav-with-logo d-flex align-items-center justify-content-between">
                    <div class="logo position-relative">
                        <a href="{{url('index')}}" class="ps-lg-4 p-0"><img src="{{ URL::asset('assets/images/KV logo-01.png')}}"
                                alt="KV-LOGO-IMG" class="kv-logo"></a>

                                <div class="logo-bg1" style="background: #8dbf45;"></div>
                                <div class="logo-bg2" style="background: #13693a;"></div>
                                <div class="logo-bg3" style="background: #000;"></div>
                    </div>

                    <!-- ////// -->

                    <div class="d-md-flex align-items-center gap-3 d-none">
                    <p class="m-0 p-0"><?php if (session()->has('bn')) {echo $lang['bn']['DOWNLOAD KRISHI VIKAS APP'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['DOWNLOAD KRISHI VIKAS APP'];} 
                    else { echo 'DOWNLOAD KRISHI VIKAS APP'; } 
                    ?></p>
                <div class="d-flex align-items-center flex-lg-row flex-column gap-2">
              
                   
                    <a href="https://play.google.com/store/search?q=krishi+vikas&c=apps"><img
                            src="{{ URL::asset('assets/images/Google-Play-Store-removebg-preview.png')}}" alt="google play store" loading="lazy" width="100"
                            width="150"></a>
                
               
                    <a href="https://apps.apple.com/in/app/krishi-vikas/id6449253442?platform=ipad"><img
                            src="{{ URL::asset('assets/images/apple-store.png')}}" alt="apple store" loading="lazy"  width="100"
                            width="150" class="rounded"></a>
                
                </div>
                    </div>



                <!-- ///////////////////// -->

                    <?php if (session()->has('KVMobile')==1) {?>
                <div class="prof p-2">
                    <a href="#"><img src="{{ URL::asset('img/istockphoto-1316420668-612x612.jpg')}}" alt="" width="40"
                            class="rounded-circle"></a>
                    <div class="pro-list">
                        <div class="tri d-none"><i class="fa-solid fa-sort-up"></i></div>
                        <ul>
                            <li><a href="{{route('profile')}}"><i class="fa-solid fa-id-badge text-success pe-2"></i>
                                <?php if (session()->has('bn')) {echo $lang['bn']['My Profile'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['My Profile'];} 
                                    else { echo 'My Profile'; } 
                                    ?></a></li>
                            <li><a href="{{route('wishlist')}}"><i class="fa-solid fa-heart text-success pe-2"></i>
                                <?php if (session()->has('bn')) {echo $lang['bn']['My Wishlist'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['My Wishlist'];} 
                                    else { echo 'My Wishlist'; } 
                                    ?></a></li>
                            
                            <li><a href="{{route('logout')}}"><i class="fa-solid fa-power-off text-success pe-2"></i>
                                <?php if (session()->has('bn')) {echo $lang['bn']['Log out'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['Log out'];} 
                                    else { echo 'Log out'; } 
                                    ?></a></li>
                        </ul>
                    </div>
                </div>
                <?php } else { ?>

                    <div class="login-wishlist d-flex align-items-center gap-4 pe-5">
                    <a href="#" class="wishlist-btn text-decoration-none text-dark fw-bold position-relative d-md-block d-none"><i class="ri-heart-line me-1"></i>
                    <?php if (session()->has('bn')) {echo $lang['bn']['Wishlist'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['Wishlist'];} 
                                    else { echo 'Wishlist'; } 
                                    ?>
                    <figure class="wishlist-count">0</figure>
                </a>
                    <button class="myBtn" style="    
                text-decoration: none;
                color: black;
                background: none;
                padding: 3px 10px;
                border: 1px solid #d5d5d5;
                border-radius: 5px;
                font-size: 15px;
                font-weight: bolder;
                letter-spacing: 1px;
    "> <i class="ri-user-star-fill"></i> <?php if (session()->has('bn')) {echo $lang['bn']['Log In'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['Log In'];} 
                                    else { echo 'Log In'; } 
                                    ?> </button>
                </div>
                
                <?php } ?>
                </div>

            <div class="nav2">

            <!-- ALL CATEGORIES BUTTON -->
            <div class="dropdown all-category d-md-block d-none">
                <button class="btn btn-secondary py-0 dropdown-toggle shadow-none bg-transparent border-2 border-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: 0 0 5px white !important;">
                <i class="ri-list-check"></i>
                <?php if (session()->has('bn')) {echo $lang['bn']['ALL CATEGORIES'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['ALL CATEGORIES'];} 
                            else { echo 'ALL CATEGORIES'; } 
                            ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{url('tractor-list/old')}}"><img style="width: 20px" src="{{ URL::asset('assets/images/cat-logos/tractor-removebg-preview.png')}}"
                                alt="" class="cat-shadow">
                                <?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                        else { echo 'TRACTOR'; } 
                        ?>
                            </a>
                    </li>
                    <li><a class="dropdown-item" href="{{url('good-vehicle-list/old')}}"><img style="width: 20px" src="{{ URL::asset('assets/images/cat-logos/goods-vehicle-removebg-preview.png')}}"
                                alt="" class="cat-shadow">
                                <?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                        else { echo 'GOODS VEHICLE'; } 
                        ?>
                            </a>
                    </li>
                    <li><a class="dropdown-item" href="{{url('seed-list')}}"><img style="width: 20px" src="{{ URL::asset('assets/images/cat-logos/seeds-removebg-preview.png')}}"
                                alt="" class="cat-shadow">
                                <?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];} 
                        else { echo 'SEEDS'; } 
                        ?>
                            </a>
                    </li>
                    <li><a class="dropdown-item" href="{{url('pesticides-list')}}"><img style="width: 20px" src="{{ URL::asset('assets/images/cat-logos/pesticide-removebg-preview.png')}}"
                                alt="" class="cat-shadow">
                                <?php if (session()->has('bn')) {echo $lang['bn']['PESTICIDES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['PESTICIDES'];} 
                        else { echo 'PESTICIDES'; } 
                        ?>
                            </a>
                    </li>
                    <li><a class="dropdown-item" href="{{url('fertilizer-list')}}"><img style="width: 20px" src="{{ URL::asset('assets/images/cat-logos/fertilizer-removebg-preview.png')}}"
                                alt="" class="cat-shadow">
                                <?php if (session()->has('bn')) {echo $lang['bn']['FERTILIZERS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['FERTILIZERS'];} 
                        else { echo 'FERTILIZERS'; } 
                        ?>
                            </a>
                    </li>
                    <li><a class="dropdown-item" href="{{url('harvester-list/old')}}"><img style="width: 20px" src="{{ URL::asset('assets/images/cat-logos/harvester-removebg-preview.png')}}"
                                alt="" class="cat-shadow">
                                <?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                        else { echo 'HARVESTER'; } 
                        ?>
                            </a>
                    </li>
                    <li><a class="dropdown-item" href="{{url('implements-list/old')}}"><img style="width: 20px" src="{{ URL::asset('assets/images/cat-logos/implements-removebg-preview.png')}}"
                                alt="" class="cat-shadow">
                                <?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                        else { echo 'IMPLEMENTS'; } 
                        ?>
                            </a>
                    </li>
                    <li><a class="dropdown-item" href="{{url('tyre-list/old')}}"><img style="width: 20px" src="{{ URL::asset('assets/images/cat-logos/tyre-removebg-preview.png')}}"
                                alt="" class="cat-shadow">
                                <?php if (session()->has('bn')) {echo $lang['bn']['TYRES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['TYRES'];} 
                        else { echo 'TYRES'; } 
                        ?>
                            </a>
                    </li>
                    
                </ul>
            </div>
                <nav class="h-100 p-0">
                    <ul class="navlist h-100 p-0">
                        <li>
                            <a href="{{url('index')}}"><?php if (session()->has('bn')) {echo $lang['bn']['HOME'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['HOME'];} 
                                else { echo 'HOME'; } 
                                ?></a>
                        </li>

                        <li class="trac"><a href="#" class="h-100">
                            <?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];} 
                                else { echo 'TRACTOR'; } 
                                ?></a>
                            <div class="dropdown-1 animate__animated animate__fadeIn" style="display: none;">

                                <div class="row">
                                    <div class="col-lg-5 col-12">
                                        <div class="d-flex flex-column pt-lg-4">
                                            <div class="drop-item px-2"><a
                                                    href="{{url('tractor-list/new')}}">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['BUY NEW TRACTOR'];} 
                                                        else if (session()->has('hn')) {echo $lang['hn']['BUY NEW TRACTOR'];} 
                                                        else { echo 'BUY NEW TRACTOR'; } 
                                                        ?></a></div>
                                            <div class="drop-item px-2"><a
                                                    href="{{url('tractor-list/old')}}">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['BUY USED TRACTOR'];} 
                                                        else if (session()->has('hn')) {echo $lang['hn']['BUY USED TRACTOR'];} 
                                                        else { echo 'BUY USED TRACTOR'; } 
                                                        ?></a></div>
                                            <div class="drop-item px-2"><a
                                                    href="{{url('tractor-list/rent')}}">
                                                    <?php if (session()->has('bn')) {echo $lang['bn']['RENT TRACTOR'];} 
                                                        else if (session()->has('hn')) {echo $lang['hn']['RENT TRACTOR'];} 
                                                        else { echo 'RENT TRACTOR'; } 
                                                        ?></a></div>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <img src="{{ URL::asset('assets/images/trac-drop.jpg')}}"
                                            alt="" class="img-fluid d-lg-block d-none p-1" >
                                    </div>
                                </div>

                                <div class="tri d-none"><i class="fa-sharp fa-solid fa-sort-up"></i></div>
                            </div>
                        </li>

                        <li class="goodVehicle"><a href="#" class="h-100">
                            <?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                            else { echo 'GOODS VEHICLE'; } 
                            ?></a>
                            <div class="dropdown-2 animate__animated animate__fadeIn">
                                <div class="row">
                                    <div class="col-lg-6 col-12 pe-0">
                                        <div class="d-flex flex-column pt-lg-4">
                                            <div class="drop-item px-2"><a href="{{url('good-vehicle-list/new')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['BUY NEW GOODS VEHICLE'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['BUY NEW GOODS VEHICLE'];} 
                                                    else { echo 'BUY NEW GOODS VEHICLE'; } 
                                                    ?></a></div>
                                            <div class="drop-item px-2"><a href="{{url('good-vehicle-list/old')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['BUY USED GOODS VEHICLE'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['BUY USED GOODS VEHICLE'];} 
                                                    else { echo 'BUY USED GOODS VEHICLE'; } 
                                                    ?></a></div>
                                            <div class="drop-item px-2"><a href="{{url('good-vehicle-list/rent')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['RENT GOODS VEHICLE'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['RENT GOODS VEHICLE'];} 
                                                    else { echo 'RENT GOODS VEHICLE'; } 
                                                    ?></a></div>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end ps-0">
                                    <img src="{{ URL::asset('assets/images/gv-drop.webp')}}"
                                            alt="" class="img-fluid d-lg-block d-none p-1" >
                                    </div>
                                </div>
                                <div class="tri d-none"><i class="fa-sharp fa-solid fa-sort-up"></i></div>


                            </div>
                        </li>

                        <li class="oth" style="position: relative"><a href="#" class="h-100" >
                            <?php if (session()->has('bn')) {echo $lang['bn']['AGRI INPUTS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['AGRI INPUTS'];} 
                                                    else { echo 'AGRI INPUTS'; } 
                                                    ?></a>
                            <div class="dropdown-6 animate__animated animate__fadeIn">
                                
                                <div class="row">
                                    <div class="col-6 pe-0">
                                        <img src="{{ URL::asset('assets/images/others.png')}}"
                                            alt="" class="img-fluid d-lg-block d-none p-1">
                                    </div>
                                    <div class="col-lg-6 col-12 ps-0">
                                        <div class="d-flex flex-column pt-lg-4">
                                            <div class="drop-item px-2"><a href="{{url('seed-list')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];} 
                                                    else { echo 'SEEDS'; } 
                                                    ?></a>
                                            </div>
                                            <div class="drop-item px-2"><a href="{{url('pesticides-list')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['PESTICIDES'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['PESTICIDES'];} 
                                                    else { echo 'PESTICIDES'; } 
                                                    ?></a>
                                            </div>
                                            <div class="drop-item px-2"><a href="{{url('fertilizer-list')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['FERTILIZERS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['FERTILIZERS'];} 
                                                    else { echo 'FERTILIZERS'; } 
                                                    ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tri d-none"><i class="fa-sharp fa-solid fa-sort-up"></i></div>
                                
                            </div>
                        </li>

                        <li class="harvest" style="position: relative"><a href="#" class="h-100" >
                            <?php if (session()->has('bn')) {echo $lang['bn']['HARVESTER'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['HARVESTER'];} 
                                                    else { echo 'HARVESTER'; } 
                                                    ?></a>
                            <div class="dropdown-3 animate__animated animate__fadeIn">
                                <div class="row">
                                    <div class="col-7 pe-0">
                                        <img src="{{ URL::asset('assets/images/harvest-drop.webp')}}"
                                            alt="" class="img-fluid d-lg-block d-none p-1" >
                                    </div>
                                    <div class="col-lg-5 col-12 ps-0">
                                        <div class="d-flex flex-column pt-lg-4 ">
                                            <div class="drop-item px-2"><a href="{{url('harvester-list/new')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['BUY NEW HARVESTER'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['BUY NEW HARVESTER'];} 
                                                    else { echo 'BUY NEW HARVESTER'; } 
                                                    ?></a></div>
                                            <div class="drop-item px-2"><a href="{{url('harvester-list/old')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['BUY USED HARVESTER'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['BUY USED HARVESTER'];} 
                                                    else { echo 'BUY USED HARVESTER'; } 
                                                    ?></a></div>
                                            <div class="drop-item px-2"><a href="{{url('harvester-list/rent')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['RENT HARVESTER'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['RENT HARVESTER'];} 
                                                    else { echo 'RENT HARVESTER'; } 
                                                    ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tri d-none"><i class="fa-sharp fa-solid fa-sort-up"></i></div>
                            </div>
                        </li>

                        <li class="imple" style="position: relative"><a href="#" class="h-100">
                            <?php if (session()->has('bn')) {echo $lang['bn']['IMPLEMENTS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['IMPLEMENTS'];} 
                                                    else { echo 'IMPLEMENTS'; } 
                                                    ?></a>
                            <div class="dropdown-4 animate__animated animate__fadeIn">

                                <div class="row">
                                    <div class="col-6 pe-0">
                                        <img src="{{ URL::asset('assets/images/implement-drop.jpg')}}"
                                            alt="" class="img-fluid d-lg-block d-none p-1">
                                    </div>
                                    <div class="col-lg-6 col-12 ps-0">
                                        <div class="d-flex flex-column pt-lg-4">
                                            <div class="drop-item px-2"><a href="{{url('implements-list/new')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['BUY NEW IMPLEMENTS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['BUY NEW IMPLEMENTS'];} 
                                                    else { echo 'BUY NEW IMPLEMENTS'; } 
                                                    ?></a></div>
                                            <div class="drop-item px-2"><a href="{{url('implements-list/old')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['BUY USED IMPLEMENTS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['BUY USED IMPLEMENTS'];} 
                                                    else { echo 'BUY USED IMPLEMENTS'; } 
                                                    ?></a></div>
                                            <div class="drop-item px-2"><a href="{{url('implements-list/rent')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['RENT IMPLEMENTS'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['RENT IMPLEMENTS'];} 
                                                    else { echo 'RENT IMPLEMENTS'; } 
                                                    ?></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tri d-none"><i class="fa-sharp fa-solid fa-sort-up"></i></div>


                            </div>
                        </li>

                        <li class="tyr" style="position: relative"><a href="#" class="h-100" >
                            <?php if (session()->has('bn')) {echo $lang['bn']['TYRES'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['TYRES'];} 
                                                    else { echo 'TYRES'; } 
                                                    ?></a>
                            <div class="dropdown-5 animate__animated animate__fadeIn">

                                <div class="row">
                                    <div class="col-6 pe-0">
                                        <img src="{{ URL::asset('assets/images/tyres-drop.jpg')}}"
                                            alt="" class="img-fluid d-lg-block d-none p-1">
                                    </div>
                                    <div class="col-lg-6 col-12 ps-0">
                                        <div class="d-flex flex-column pt-lg-4">
                                            <div class="drop-item px-2"><a href="{{url('tyre-list/new')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['BUY NEW TYRES'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['BUY NEW TYRES'];} 
                                                    else { echo 'BUY NEW TYRES'; } 
                                                    ?></a></div>
                                            <div class="drop-item px-2"><a href="{{url('tyre-list/old')}}">
                                                <?php if (session()->has('bn')) {echo $lang['bn']['BUY USED TYRES'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['BUY USED TYRES'];} 
                                                    else { echo 'BUY USED TYRES'; } 
                                                    ?></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tri d-none"><i class="fa-sharp fa-solid fa-sort-up"></i></div>

                              
                            </div>
                        </li>


                        <li class="more-option" style="position: relative"><a href="#" class="h-100" ><i class="fa-solid fa-grip"></i> 
                        
                        <?php if (session()->has('bn')) {echo $lang['bn']['OTHER'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['OTHER'];} 
                            else { echo 'OTHER'; } 
                            ?>

                        </a>
                            <div class="dropdown-7 animate__animated animate__fadeIn p-3 rounded border">

                                <div class="row">
                                    <div class="col-12">
                                        <a href="/crop-calendar" class="text-dark"><img src="{{ URL::asset('assets/images/drop-others-crop-calender.png')}}" alt="crop-calendar-icon" width="80"><p class="text-center">
                                        <?php if (session()->has('bn')) {echo $lang['bn']['CROP CALENDAR'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['CROP CALENDAR'];} 
                            else { echo 'CROP CALENDAR'; } 
                            ?>
                                        </p></a>
                                    </div>
                                </div>

                            </div>
                        </li>


                       

                        



                        <li class="bg-white px-2 search-input">
                            <div id="msform1" class="d-flex align-items-center gap-2">
                                <input type="number" placeholder="Search here.."
                                    style="margin-bottom: 0px !important;" />
                                <button type="button" class="btn login ms-2"><?php if (session()->has('bn')) {echo $lang['bn']['SEARCH'];} 
                                    else if (session()->has('hn')) {echo $lang['hn']['SEARCH'];} 
                                    else { echo 'SEARCH'; } 
                                    ?></button>
                            </div>
                        </li>

                        <div class="social-logo d-flex gap-3 social-logo-mobile d-md-none">
                            <div class="">
                                <a href="https://www.facebook.com/joinkrishivikas" target="_blank"><i
                                        class="fa-brands fa-facebook-f"></i></a>
                            </div>
                            <div class="">
                                <a href="https://www.instagram.com/joinkrishivikas/" target="_blank"><i
                                        class="fa-brands fa-instagram text-white"></i></a>
                            </div>
                            <div class="">
                                <a href="https://twitter.com/JoinKrishiVikas" target="_blank"><i
                                        class="fa-brands fa-twitter text-white"></i></a>
                            </div>
                            <div class="">
                                <a href="https://www.linkedin.com/company/joinkrishivikas/" target="_blank"><i
                                        class="fa-brands fa-linkedin-in"></i></a>
                            </div>
                            <!-- <div class="">
                                    <a href=""><i class="fa-brands fa-google-plus-g"></i></a>
                                </div> -->
                            <div class="">
                                <a href="https://www.youtube.com/@JoinKrishiVikas" target="_blank"><i
                                        class="fa-brands fa-youtube"></i></a>
                            </div>
                        </div>



                    </ul>

                    <div class="menu-btn" id="navbtn">
                        <i class="fa-solid fa-bars"></i><span> <?php if (session()->has('bn')) {echo $lang['bn']['MENU'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['MENU'];} 
                            else { echo 'MENU'; } 
                            ?></span>
                    </div>

                   
                    <!--<div class="search-and-navbtn">-->
                    <!--    <i class="fa-solid fa-magnifying-glass"></i>-->
                    <!--</div>-->


                </nav>
                <div class="rs-button-head me-lg-0 me-4">
                        <button href="#" class="s-btn btn1 btn1-anim">
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect x="0.193726" y="0.763155" width="19.9522" height="19.9522" fill="url(#pattern0_13_74)"/>
                        <defs>
                        <pattern id="pattern0_13_74" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_13_74" transform="scale(0.01)"/>
                        </pattern>
                        <image id="image0_13_74" width="100" height="100" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAFM0lEQVR4nO2deahXRRTHR9M2s4WsjB6FkS20QYuZbbRSmGBZIO1hRLTQK0hTlMr29JEUheUfZWZFWQkFQSUtJIlFFERZibRnlBW2qPV8nzhwXvx4ed/v/e7M/O7M3PnA/H3Pud87c2fOnDNjTCaTyWQymUwmk8lk/gPYDbgM6AKeBJ5tY5sPzASOBQabOgPsDSwEugmDNcAFwCBTN4AzgF8Jk+eAYaYuAGcF1CuKWAYMNTUZpn4jDuaY1AGeIB7+BkabxGdT3cTF/SZVdGobG2tMqug6I0Z2MCmii74Y2c+kiK6MbegBvgBeG2BbDqzHnoNNilgK8p2EN0o8czvg4SyIe0HGW3wIg4GVFs/OPaQPG21XzcAtlCcL0ofNwHBLQeZSnizIFui0EGMn4GvKkwUpGLamAx0tCLEtcALwHnZkQQIjCxIYWZDAyIIERhYkMLIggZEFCYwsSGBkQQIjCxIYWZDASFaQp4mTA0yKAPOIkx1NigDXEB9rTaoA+2iiQkwsMCkDvEI8yMczxqQMcJjmzMbAYlMHgMsJn09l69fUBeA64B/CRLZ89zJ1AxgHrCAc/gBmS3KdqSvAIBXmXuBl/Trfb2N7W3OOZRjd1dKXYcC+ySZnxwCwOzAV+LhhSi81MG8AJ1VtX20ARgD3AX82SfC7qmpbkwbYBbi9hax66S2HV213cgDDgVklS7kXtPunPAa4EXhex9LvgU36dfyiaZxSq/E4cD1wYiwBO81+vAH4ifKsbIehI/WLWV3SyB49OeFF4DZgsqZ9jtZhYWvvTvTv3xBgimVOcC/LfRoqL+vuJj8zV2zWHjbQJj3zI+AxYKK81JI9/nxglUM/5voSYxLwI/HwOXBKC/4dA7zr2IYNsjZxLYQseBYTJxuA45r416GLQx9bA9NdizFKh4GY+QTYqsC/CR6H35ecHvkEHAr8QBqcWuDjeZ6e96HTaDFwFLCOdJhZ4OdYD8+S0u2RLsU40HLeHSJdBb4e4fg5Ur49yvX64ivSo7Ofs7tcISPKIa4XQ2+SJgcV+HyFw72Usc7EUOPmkCZL+vFZzny0RQpST/ex6IstRWegP9gR/YwIP2OHxOwmuBZjz4APpLRhSZEYjqa8khNwrlMx1DCJ0obyNS8CHrFokq7aWfTPaPB5KPCZha0SyZ7sQwwZqkLggTLBQAu/Z1gGPS/xYZQcXfQt1bO6zWKcrS+1DPKfneLLsJsIg0VeHCwW43cLMa72ZdjOAYVGlnlx8v//jBkWPcPqAJyBGHgr4dDdLERu4ecQnU3Z/MCFqT7sazQ0pIxBdBi5WYQBjrRoEhQdryvwhQ7WGcIsr2KoIK87MLQOzPYuRmDT3ZC5sy1iOI7jpEpXW8Vo2CuXOohMKOe96zbtX30MqjPzKhOjQZRrq34LgfBoMNcdAS9QbxYEI0ZDRuKX1JP5QYnRiyZNx1Ih64qHghSjFz0bty7cY0JHD65/lbTpkTCNiaxuTjLJU2QTcJGJDeA0y1B1iKwDTjaxAtxFOqxwmlFYBbqX8I7FS5ALJJ/SYnxZfE7TdofeeiNXnL6lyQ2S2+SD9TpR2WL2e6w3c7a6s7hRX/z2JdJYjwbO0VpEufPjGa1P/KbFOxDXSkwK2MOkhpaH9bSw0TTOY4/tUNHOBC4ErtTcgGlawH+pbnKl0SOKAB4coCCTqra1FgDbAB80EWNp1XbWCmD/Jik0LV9rl7EEuLhAjFVBx4RSRqOjjcgCcmLVdtUWjXfJKQdLNTn6+KptymQymUwmk8mYjPkXT1Zks2fxHy8AAAAASUVORK5CYII="/>
                        </defs>
                        </svg>
                            <?php if (session()->has('bn')) {echo $lang['bn']['SELL'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['SELL'];} 
                                                    else { echo 'SELL'; } 
                                                    ?></button>
                        <button href="#" class="r-btn btn1 btn1-anim">
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect x="0.978516" y="0.763155" width="19.9522" height="19.9522" fill="url(#pattern0_13_76)"/>
                            <defs>
                            <pattern id="pattern0_13_76" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_13_76" transform="scale(0.01)"/>
                            </pattern>
                            <image id="image0_13_76" width="100" height="100" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAE3klEQVR4nO2dXahVRRTHd1nYt2mQYJaFRWoWfaBESh9kD4lCEpK9+CB4i4Li9qBSkEFQPiR9IdIXUlQP56GXniqC6qGHSu2bChQ0MaMbWaZ1rXt/MbgOnO49d5+7956918yc9YPzds9es9b/zqyZWbPnZJlhGIZhGIZhlAaYCywHVnv+uGfOLd+yPgNYBXxF/XwJ3KHtb9AAW2mep7T9DhLgAfS4X9v/oABmAL8rCnIYmK4dh2AA1qPPOu04BAOwXVsNYJt2HIIBeKNHsPYDm4E1Jaa5a+S7P/aw8bp2HIIBeD4nUF8A0zzYOFemuhPxnB9vEgDYlBOoWz3auS3HzgZfdqIHWJETqHM82pmWY2e5LzvRA8zOCdQCj3YW5tiZ5ctOEgB7JgjUDo82XpvAxg++bCQD8GLOf+8O4ApgSonnTpHvvprz/Bfq8SpigLvR4y5t/4MDOB8YVRDD2Zyp7X+QAJ8rCLJb2+9gAR5TEORRbb+DBbhSQZCF2n4HDfBdg2LYdLcXwJYGBXmyZ4P6HWBxg4Is0vY3CoB3GxDjHW0/owE4262egaEahBiSgthZ2n5GD9AqIUBLu93JggkSFpggSQjykHa7k4XigmzWbnPSUEwQEyMgQV6qvTFGVkSQP4EbLWZhDVkmSoBJ3USpE1uHBAa2MAwLTJCwwFbqYYGt1MMCW6lHK8jL2m3tCyi2Ur9Zu73JQ/GV+i3abU4aiif1I8BNWYwAc4BB4D3gADAM/AR8CjwBXB1AG1ukXFN3r4sBa0WEkUk4txsYAE5Xam8rOUGAk4Fl8jaRG2fL8LOcMLyg4banIwhwDfA0cAh//C1vNzUynLn6eNQ1dfciI/AgsIv6+UyGv1Nq9mljVGVcN77LDQZvA//QPHslaDOURdEVA7ikYl7wzR/As8ClNfk7KDml22ewDptFG+h6RYiMyCxuJXBS1i8ELEgn30tOOyNLnUgE6bwwzA1nF2apEpkgbY7LmH9DlhqRCtJt2nxqlgIJCNLmoLwefV4WMwkJ0uaovOl0cQOxc/eh3A48426WAx4H5ld9aGqCdOaZTd6iP/46j4eBfYznX9dTqzw8VUHarPcoxBK559GVGHpxnwnSHVebmVpBhDPlOlpXQijCr6Xs9kEPcVxbIi6XS274jfIsNUG6s6JAkl4lWzajTdntxx6yoEcMZgKPyD2/PplngoxnZ44QS4E3J5mki/JJYTH6oIccHZs/3E0MwD1y0XJduFLGVSbI/9nZKYYbPmRj0m1Q1snX7v6uUmIk2kOGgW/GFJ4+auBeRnfm4N7KpegEBWmaY3KSpvI98yZINUal9/ndM6vYQ9yv23wIvAV8XNNsJUTed8ejvApRUZAPgDvHbg3IfVXr3JSPNPm21GKvJkGGpYteP8nnXieXibmDy7EzJDX9Ws+OTVaQQ1WOf8o54IGa5/1xJOyKguySQJ7m0Va71xyjHxN2CUFG5OTispptTpchYKKfmtBO2IV3h30L0j5eM0fpRH1L6fhqJ+4i5tVN+p9XjlQ/gAZcJDVpd1ihSfyssFOFEzWJlR5rEuEk7NgBLpOg/ZJEwk4FYKrkOtdr4k3YKQLMlwnIkegSdspwYptmoMev6zS3wjbGnZd6RX639i/ZFdjgROv4M8MwDMMwDMMwDMMwjKw7/wHtPP+S2yPWvAAAAABJRU5ErkJggg=="/>
                            </defs>
                            </svg>
                            <?php if (session()->has('bn')) {echo $lang['bn']['RENT'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['RENT'];} 
                                                    else { echo 'RENT'; } 
                                                    ?></button>
                    </div>
            </div>

        </div>
    </header>