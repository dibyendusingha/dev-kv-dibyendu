@extends('layout.main')
@section('page-container')

<?php
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();
use Illuminate\Support\Facades\DB;
?>

<?php 
    $url = Request::path();
    $exp = explode ('/',$url);
    $pesticide_id =  $exp[1];

    $pesticide = DB::table('pesticides')->where('id',$pesticide_id)->first();
    $user_id = $pesticide->user_id;

    $user_details = DB::table('user')->where('id',$user_id)->first();
    $data['user_type_id']    = $user_details->user_type_id;
    $data['role_id']         = $user_details->role_id;
    $data['name']            = $user_details->name;
    $data['company_name']    = $user_details->company_name;
    $data['mobile']          = $user_details->mobile;
    $data['email']           = $user_details->email;
    $data['gender']          = $user_details->gender;
    $data['address']         = $user_details->address;
    $data['zipcode']         = $user_details->zipcode;
    $data['device_id']       = $user_details->device_id;
    $data['firebase_token']  = $user_details->firebase_token;
    $data['created_at_user'] = date("d-m-Y", strtotime($user_details->created_at));
    if ($user_details->photo=='NULL' || $user_details->photo=='') {
        $data['photo']='';
    } else {
    $data['photo'] = env('APP_URL')."storage/photo/$user_details->photo";
    }

?>


<!-- PRODUCT CONTAINER START -->
<section class="product-container pro-bg pt-3">
    <div class="product-content">
        <div class="container bg-white">
            <div class="row">
                <div class="col-lg-7">
                    <div class="d-flex">
                        <div class="product-img-list py-3 px-2">
                            <section id="product-diff-img">

                                <?php if ($data['image1']!='') { ?>
                                <div class="item">
                                    <!-- <img src="{{$data['image1']}}" alt="" class="small-img"> -->
                                    <img src="{{asset($data['image1'])}}" alt="" class="small-img">
                                </div>
                                <?php } ?>
                                <?php if ($data['image2']!='') { ?>
                                <div class="item">
                                    <!-- <img src="{{$data['image2']}}" alt="" class="small-img"> -->
                                    <img src="{{asset($data['image2'])}}" alt="" class="small-img">
                                </div>
                                <?php } ?>
                                <?php if ($data['image3']!='') { ?>
                                <div class="item">
                                    <!-- <img src="{{$data['image3']}}" alt="" class="small-img"> -->
                                    <img src="{{asset($data['image2'])}}" alt="" class="small-img">
                                </div>
                                <?php } ?>
                            </section>
                        </div>

                        <div class="product-modal mb-4" style="position:relative;">

                            <?php if ($data['status']==4) { ?>
                                <img src="{{asset('storage/photo/sold_tag.png')}}" class="img-fluid" alt="" width="100" style="position: absolute;top: 0;object-fit:contain">
                                <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0;object-fit: contain;width: 120px !important; bottom:40%;">
                                <!-- <img src="{{$data['image1']}}" alt="" class="img-fluid" id="main-img-original" onclick="openLightbox()"> -->
                                <img src="{{asset($data['image1'])}}" alt="" class="img-fluid" id="main-img-original" onclick="openLightbox()">
                            <?php } ?>
                            <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0;object-fit: contain;width: 120px !important; bottom:40%;">
                            <!-- <img src="{{$data['image1']}}" alt="" class="img-fluid" id="main-img-original" onclick="openLightbox()"> -->
                            <img src="{{asset($data['image1'])}}" alt="" class="img-fluid" id="main-img-original" onclick="openLightbox()">
                        </div>
                    </div>
                    





                    <div id="lightbox" class="lightbox animate__animated animate__zoomIn">
                        <span class="close-button" onclick="closeLightbox()">&times;</span>
                        <div class="lightbox-content">
                            <img src="" alt="Product main image" id="lightbox-image">
                            <div class="lightbox-navigation">
                                <a href="#" class="prev-button" onclick="prevImage()">&#10094;</a>
                                <a href="#" class="next-button" onclick="nextImage()">&#10095;</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-5 pt-4">
                    <div class="d-flex border rounded px-4 justify-content-around">
                        <div class="">
                            <h1 class="text-success">{{$data['title']}}</h1>
                            <div class="">
                                <div class="fs-4">
                                    <i class="fa-solid fa-location-dot text-success"></i> &nbsp; <span>
                                        {{$data['city_name']}}, {{$data['district_name']}} , {{$data['state_name']}},
                                        {{$data['pincode']}} </span>
                                </div>
                                <div class="fs-4">
                                    <i class="fa-solid fa-calendar-days text-success"></i> &nbsp; <span>
                                        {{$data['created_at']}}</span>
                                </div>
                            </div>

                            <div class="price">
                                <p> <i class="fa-solid fa-indian-rupee-sign"></i> {{$data['price']}}</p>
                            </div>
                        </div>
                        <div>
                            <?php if (session()->has('KVMobile')) { 
                        $mobile = session()->get('KVMobile');
                        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
                        $wishcount = DB::table('wishlist')->where(['user_id'=>$user_id,'category_id'=>8,'item_id'=>$data['id']])->count();
                        ?>
                            <i class="fa-solid fa-heart <?php if ($wishcount>0) {echo 'active-fav';} ?>" id="add-fav"
                                onclick="addtofav('pesticides',{{$data['id']}})"></i>
                            {{-- <i class="fa-solid fa-share-nodes" id="add-share"></i> --}}
                            <?php } ?>
                        </div>
                    </div>

                    <div class="seller-datails border rounded p-3 mt-3">
                        <div class="d-flex px-5 py-3 gap-2">
                            <img src="./img/istockphoto-1316420668-612x612.jpg" alt="" width="40"
                                class="rounded-circle">
                            <p class="h3 p-0">{{$data['name']}}</p>
                        </div>
                        <div class="no-show px-5">

                            <?php  
                                if (session()->has('KVMobile')) {
                                    $profile_update = DB::table('user')->where(['mobile'=>session()->get('KVMobile')])->value('profile_update');
                                } else {
                                    $profile_update = 0;
                                }
                                ?>
                            <?php if ($profile_update==1) { ?>
                            <p class="text-center px-5 py-2 rounded bg-light text-dark border border-2 border-dark">
                                {{$data['mobile']}}</p>

                            <a href="tel:{{$data['mobile']}}" type="button"
                                class="w-100 px-5 py-2 border-0 rounded bg-success fw-bold text-white text-center text-decoration-none"><i
                                    class="fa-sharp fa-solid fa-phone"></i> CALL</a>

                            <?php } else { ?>
                            <p class="text-center px-5 py-2 rounded bg-light text-dark border border-2 border-dark">
                                XXXXXXXXXX</p>
                            <button type="button"
                                class="w-100 px-5 py-2 border-0 rounded  bg-success fw-bold text-white myBtn">
                                <?php if (session()->has('bn')) {echo $lang['bn']['SHOW NUMBER'];} 
                                else if (session()->has('hn')) {echo $lang['hn']['SHOW NUMBER'];} 
                                else { echo 'SHOW NUMBER'; } 
                                ?></button>
                            <?php } ?>
                        </div>
                        <div class="px-5">
                            {{-- <button class="px-5 py-3 rounded w-100 text-center"
                                style="background-color: #e1e7ec; color: black; border: 1px solid black"><i
                                    class="fa-solid fa-comments"></i> Chat With Seller</button> --}}
                        </div>
                    </div>

                    {{-- <div class="post-location border p-3 mt-3 rounded">
                        <p class="h3">Posted in</p>
                        <small>Kolkata, 700152</small>
                        <div style="width: 100%"><iframe width="100%" height="300" frameborder="0" scrolling="no"
                                marginheight="0" marginwidth="0"
                                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street,%20Dublin,%20Ireland+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a
                                    href="https://www.maps.ie/distance-area-calculator.html">area maps</a></iframe>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-7">
                    <div class="spec-row rounded" id="summarySpecs">
                        <h2>
                            <?php if (session()->has('bn')) {echo $lang['bn']['Specifications'];} 
                                                    else if (session()->has('hn')) {echo $lang['hn']['Specifications'];} 
                                                    else { echo 'TRACTOR'; } 
                                                    ?></h2>
                        <table width="100%" class="table table-striped mt-5">
                            <tbody>

                                <tr>
                                    <th>Price Negotiable</th>
                                    <td><span itemprop="mileageFromOdometer" class="wpcm-vehicle-data">
                                            <?php if($data['is_negotiable']=='true') {echo 'Yes';} else {echo 'No';} ?>
                                        </span> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- PRODUCT CONTAINER END -->


<!-- REALTED PRODUCT SECTION START -->

<section class="rp">
    <div class="container-fluid p-0 bg-white my-5">
        <div class="rp-header row m-0">
            <div class="col-md-5 h1">
                <h1><?php if (session()->has('bn')) {echo $lang['bn']['RELATED ITEMS'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['RELATED ITEMS'];} 
                    else { echo 'RELATED ITEMS'; } 
                    ?></h1>
            </div>

            <div class="col-md-7 d-flex justify-content-between listing">
                <div class="options">
                </div>
                <div class="next-prev-view h-100">
                </div>
            </div>
        </div>

        <div class="owl-carousel owl-theme">
            <?php
            $related_product1 = array_splice($related_product, 0, 5);
            foreach ($related_product1 as $val_rel) { ?>
            <div class="item">
                <div class="rp-list">
                    <div class="rp-img-box">
                        <a href="{{ url('pesticides/'.$val_rel['id']) }}">
                            <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top:-5%;">
                            <!-- <img src="{{$val_rel['image1']}}" alt="" class="p-3 tractor-img"> -->
                            <img src="{{asset($val_rel['image1'])}}" alt="" class="p-3 tractor-img">
                        </a>
                        <div class="shadow-line">
                        </div>
                        <p class="fw-bolder">{{$val_rel['title']}}</p>

                        <!-- <div class="location-price d-flex justify-content-around">
                                <p> <i class="fa-solid fa-location-dot"></i> KOLKATA</p>
                                <p> <i class="fa-solid fa-indian-rupee-sign"></i> 5000</p>
                            </div> -->

                        <div class="spec d-flex justify-content-around align-items-center pt-3">
                            <p><i class="fa-solid fa-location-dot"></i> {{$val_rel['district_name']}}</p>
                            <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val_rel['price']}}</p>
                        </div>
                        <?php
                            $distance = round($val_rel['distance']);
                        ?>
                        <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km distance</p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- RELATED PRODUCTS SECTION END -->



@endsection