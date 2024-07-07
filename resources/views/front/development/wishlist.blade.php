@extends('layout.main')
@section('page-container')
<?php
use App\Models\Tractor;
use App\Models\Rent_tractor;
use App\Models\Goods_vehicle;
use App\Models\Harvester;
use App\Models\Implement;
use App\Models\Seed;
use App\Models\pesticides;
use App\Models\fertilizers;
use App\Models\Tyre;

use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();
?>

<div class="preloader">
    <img src="./assets/images/preloader-logo.png" alt="">
    <div class="preloader-orbit-loading">

        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
    </div>


</div>
<div class="product-list pt-5">
                <div class="d-flex align-items-center justify-content-center">
                    <a href="{{URL('/')}}">
                        <h2><?php if (session()->has('bn')) {echo $lang['bn']['HOME'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['HOME'];} 
                            else { echo 'HOME'; } 
                            ?></h2>
                    </a>
                    <span><i class="fa-solid fa-angle-right fa-2x text-white"></i></span>
                    <a href="{{URL('wishlist')}}">
                        <h2><?php if (session()->has('bn')) {echo $lang['bn']['My Wishlist'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['My Wishlist'];} 
                            else { echo 'My Wishlist'; } 
                            ?></h2>
                    </a>
                </div>



                <div class="pl-head text-center">
                    <h1></h1>
                </div>

                <!-- <div class="tr-sl-menu">
                                            <a href="http://kv.businessenquiry.co.in/tractor-post" id="sell_trac">SELL</a>
                    

                                            <a href="http://kv.businessenquiry.co.in/tractor-post" id="rent_trac">RENT</a>
                                        
                </div> -->
            </div>

<div class="container my-3">



    <div class="row">

    <h4 class="">My Wishlist ({{$count}})</h4>
    <?php foreach ($wishlistarr as $val) {
        $id = $val->id;
        $user_id = $val->user_id;
        $category_id = $val->category_id;
        $item_id = $val->item_id;

        if ($category_id==1) {
            $data = Tractor::tractor_single($item_id,$user_id);
            $title = $data['brand_name'].' '.$data['model_name'];
            $price = $data['price'];
            $district_name = $data['district_name'];
            $created_at = $data['created_at'];
            $image = $data['front_image'];
            $url = url('tractor/'.$data['id']);
        } else if ($category_id==3) {
            $data = Goods_vehicle::gv_single($item_id,$user_id);
            $title = $data['brand_name'].' '.$data['model_name'];
            $price = $data['price'];
            $district_name = $data['district_name'];
            $created_at = $data['created_at'];
            $image = $data['front_image'];
            $url = url('good-vahicle/'.$data['id']);
        }else if ($category_id==4) {
            $data = Harvester::harvester_single($item_id,$user_id);
            $title = $data['brand_name'].' '.$data['model_name'];
            $price = $data['price'];
            $district_name = $data['district_name'];
            $created_at = $data['created_at'];
            $image = $data['front_image'];
            $url = url('harvester/'.$data['id']);
        }else if ($category_id==5) {
            $data = Implement::implement_single($item_id,$user_id);
            $title = $data['brand_name'].' '.$data['model_name'];
            $price = $data['price'];
            $district_name = $data['district_name'];
            $created_at = $data['created_at'];
            $image = $data['front_image'];
            $url = url('implements/'.$data['id']);
        }else if ($category_id==6) {
            $data = Seed::seed_single($item_id,$user_id);
            $title = $data['title'];
            $price = $data['price'];
            $district_name = $data['district_name'];
            $created_at = $data['created_at'];
            $image = $data['image1'];
            $url = url('seed/'.$data['id']);
        }else if ($category_id==7) {
            $data = Tyre::tyre_single($item_id,$user_id);
            $title = $data['brand_name'].' '.$data['model_name'];
            $price = $data['price'];
            $district_name = $data['district_name'];
            $created_at = $data['created_at'];
            $image = $data['image1'];
            $url = url('tyre/'.$data['id']);
        }else if ($category_id==8) {
            $data = pesticides::pesticides_single($item_id,$user_id);
            $title = $data['title'];
            $price = $data['price'];
            $district_name = $data['district_name'];
            $created_at = $data['created_at'];
            $image = $data['image1'];
            $url = url('pesticides/'.$data['id']);
        }else if ($category_id==9) {
            $data = fertilizers::fertilizers_single($item_id,$user_id);
            $title = $data['title'];
            $price = $data['price'];
            $district_name = $data['district_name'];
            $created_at = $data['created_at'];
            $image = $data['image1'];
            $url = url('fertilizers/'.$data['id']);
        }
        ?>
        <div class="col-lg-6">
            <div class="wishlist d-flex align-items-center gap-3 mb-3">
                <div class="wishlist-img-box">
                    <a href="{{$url}}"><img src="{{$image}}" alt=""></a>
                </div>
                <div class="wishlist-content ">
                    <h3>{{$title}}</h3>
                    <h5>Rs. {{$price}}</h5>
                    <div class="location-date d-flex align-items-center gap-3">
                        <div class="location">
                            <small><i class="fa-sharp fa-solid fa-location-dot"></i> &nbsp; {{$district_name}}</small>
                        </div>
                        <div class="date">
                            <small><i class="fa-sharp fa-regular fa-calendar-days"></i> &nbsp; {{$created_at}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
    </div>

</div>


@endsection