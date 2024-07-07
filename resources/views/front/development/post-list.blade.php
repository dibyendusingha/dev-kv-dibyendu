@extends('layout.main')
@section('page-container')
<?php
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
                    <a href="{{url('/')}}">
                        <h2>Home</h2>
                    </a>
                    <span><i class="fa-solid fa-angle-right fa-2x text-white"></i></span>
                    <a href="#">
                        <h2>My Post</h2>
                    </a>
                </div>



                <div class="pl-head text-center">
                    <h1>MY POST</h1>
                </div>

                <!-- <div class="tr-sl-menu">
                                            <a href="http://kv.businessenquiry.co.in/tractor-post" id="sell_trac">SELL</a>
                    

                                            <a href="http://kv.businessenquiry.co.in/tractor-post" id="rent_trac">RENT</a>
                                        
                </div> -->
            </div>

<div class="container my-3">


    <div class="row">

    <h4 class="">My Post ({{$my_p_count}})</h4>
    <?php if (isset($my_p_tractor)) {?>
    <?php foreach ($my_p_tractor as $val) { ?>
        <div class="col-lg-6">
            <div class=" postlist d-flex align-items-center gap-3 mb-3">
                <div class=" postlist-img-box">
                    <a href="{{url('tractor/'.$val->id)}}"><img src="{{env('APP_URL')."/storage/tractor/$val->front_image"}}" alt=""></a>
                </div>
                <div class=" postlist-content ">
                    <a href="{{url('tractor/'.$val->id)}}" style="color:#000;text-decoration: none;"><h3><?= DB::table('brand')->where(['id'=>$val->brand_id])->value('name');?>
                        <?= DB::table('model')->where(['id'=>$val->model_id])->value('model_name');?></h3></a>
                    <h5>Rs. {{$val->price}}</h5>
                    <div class="location-date d-flex align-items-center gap-3">
                        <div class="location">
                            <small><i class="fa-sharp fa-solid fa-location-dot"></i> &nbsp; <?= DB::table('district')->where(['id'=>$val->district_id])->value('district_name');?></small>
                        </div>
                        <div class="date">
                            <small><i class="fa-sharp fa-regular fa-calendar-days"></i> &nbsp; {{$val->created_at}}</small>
                        </div>
                    </div>
                </div>
                <span class="badge <?php if ($val->status==1) {echo 'bg-success';} else if ($val->status==0) {echo 'bg-warning';} else {echo 'bg-danger';}?> ms-5 fw-normal"><?php if ($val->status==1) {echo 'Approved';} else if ($val->status==0) {echo 'Pending';} else {echo 'Reject';}?></span>
            </div>
            
        </div>
        <?php } } ?>


    <?php if (isset($my_p_gv)) {?>
        <?php foreach ($my_p_gv as $val) { ?>
            <div class="col-lg-6">
                <div class=" postlist d-flex align-items-center gap-3 mb-3">
                    <div class=" postlist-img-box">
                        <a href="{{url('good-vahicle/'.$val->id)}}"><img src="{{env('APP_URL')."/storage/goods_vehicle/$val->front_image"}}" alt=""></a>
                    </div>
                    <div class=" postlist-content ">
                        <a href="{{url('good-vahicle/'.$val->id)}}" style="color:#000;text-decoration: none;"><h3><?= DB::table('brand')->where(['id'=>$val->brand_id])->value('name');?>
                            <?= DB::table('model')->where(['id'=>$val->model_id])->value('model_name');?></h3></a>
                        <h5>Rs. {{$val->price}}</h5>
                        <div class="location-date d-flex align-items-center gap-3">
                            <div class="location">
                                <small><i class="fa-sharp fa-solid fa-location-dot"></i> &nbsp; <?= DB::table('district')->where(['id'=>$val->district_id])->value('district_name');?></small>
                            </div>
                            <div class="date">
                                <small><i class="fa-sharp fa-regular fa-calendar-days"></i> &nbsp; {{$val->created_at}}</small>
                            </div>
                        </div>
                    </div>
                    <span class="badge <?php if ($val->status==1) {echo 'bg-success';} else if ($val->status==0) {echo 'bg-warning';} else {echo 'bg-danger';}?> ms-5 fw-normal"><?php if ($val->status==1) {echo 'Approved';} else if ($val->status==0) {echo 'Pending';} else {echo 'Reject';}?></span>
                </div>
                
            </div>
            <?php } } ?>

    <?php if (isset($my_p_har)) {?>
    <?php foreach ($my_p_har as $val) { ?>
        <div class="col-lg-6">
            <div class=" postlist d-flex align-items-center gap-3 mb-3">
                <div class=" postlist-img-box">
                    <a href="{{url('harvester/'.$val->id)}}"><img src="{{env('APP_URL')."/storage/harvester/$val->front_image"}}" alt=""></a>
                </div>
                <div class=" postlist-content ">
                    <a href="{{url('harvester/'.$val->id)}}" style="color:#000;text-decoration: none;"><h3><?= DB::table('brand')->where(['id'=>$val->brand_id])->value('name');?>
                        <?= DB::table('model')->where(['id'=>$val->model_id])->value('model_name');?></h3></a>
                    <h5>Rs. {{$val->price}}</h5>
                    <div class="location-date d-flex align-items-center gap-3">
                        <div class="location">
                            <small><i class="fa-sharp fa-solid fa-location-dot"></i> &nbsp; <?= DB::table('district')->where(['id'=>$val->district_id])->value('district_name');?></small>
                        </div>
                        <div class="date">
                            <small><i class="fa-sharp fa-regular fa-calendar-days"></i> &nbsp; {{$val->created_at}}</small>
                        </div>
                    </div>
                </div>
                <span class="badge <?php if ($val->status==1) {echo 'bg-success';} else if ($val->status==0) {echo 'bg-warning';} else {echo 'bg-danger';}?> ms-5 fw-normal"><?php if ($val->status==1) {echo 'Approved';} else if ($val->status==0) {echo 'Pending';} else {echo 'Reject';}?></span>
            </div>
            
        </div>
        <?php } } ?>


    <?php if (isset($my_p_imp)) {?>
        <?php foreach ($my_p_imp as $val) { ?>
            <div class="col-lg-6">
                <div class=" postlist d-flex align-items-center gap-3 mb-3">
                    <div class=" postlist-img-box">
                        <a href="{{url('implements/'.$val->id)}}"><img src="{{env('APP_URL')."/storage/implements/$val->front_image"}}" alt=""></a>
                    </div>
                    <div class=" postlist-content ">
                        <a href="{{url('implements/'.$val->id)}}" style="color:#000;text-decoration: none;"><h3><?= DB::table('brand')->where(['id'=>$val->brand_id])->value('name');?>
                            <?= DB::table('model')->where(['id'=>$val->model_id])->value('model_name');?></h3></a>
                        <h5>Rs. {{$val->price}}</h5>
                        <div class="location-date d-flex align-items-center gap-3">
                            <div class="location">
                                <small><i class="fa-sharp fa-solid fa-location-dot"></i> &nbsp; <?= DB::table('district')->where(['id'=>$val->district_id])->value('district_name');?></small>
                            </div>
                            <div class="date">
                                <small><i class="fa-sharp fa-regular fa-calendar-days"></i> &nbsp; {{$val->created_at}}</small>
                            </div>
                        </div>
                    </div>
                    <span class="badge <?php if ($val->status==1) {echo 'bg-success';} else if ($val->status==0) {echo 'bg-warning';} else {echo 'bg-danger';}?> ms-5 fw-normal"><?php if ($val->status==1) {echo 'Approved';} else if ($val->status==0) {echo 'Pending';} else {echo 'Reject';}?></span>
                </div>
                
            </div>
            <?php } } ?>

    <?php if (isset($my_p_seed)) {?>
        <?php foreach ($my_p_seed as $val) { ?>
            <div class="col-lg-6">
                <div class=" postlist d-flex align-items-center gap-3 mb-3">
                    <div class=" postlist-img-box">
                        <a href="{{url('seed/'.$val->id)}}"><img src="{{env('APP_URL')."/storage/seeds/$val->image1"}}" alt=""></a>
                    </div>
                    <div class=" postlist-content ">
                        <a href="{{url('seed/'.$val->id)}}" style="color:#000;text-decoration: none;"><h3>{{$val->title}}</h3></a>
                        <h5>Rs. {{$val->price}}</h5>
                        <div class="location-date d-flex align-items-center gap-3">
                            <div class="location">
                                <small><i class="fa-sharp fa-solid fa-location-dot"></i> &nbsp; <?= DB::table('district')->where(['id'=>$val->district_id])->value('district_name');?></small>
                            </div>
                            <div class="date">
                                <small><i class="fa-sharp fa-regular fa-calendar-days"></i> &nbsp; {{$val->created_at}}</small>
                            </div>
                        </div>
                    </div>
                    <span class="badge <?php if ($val->status==1) {echo 'bg-success';} else if ($val->status==0) {echo 'bg-warning';} else {echo 'bg-danger';}?> ms-5 fw-normal"><?php if ($val->status==1) {echo 'Approved';} else if ($val->status==0) {echo 'Pending';} else {echo 'Reject';}?></span>
                </div>
                
            </div>
            <?php } } ?>

    <?php if (isset($my_p_pest)) {?>
        <?php foreach ($my_p_pest as $val) { ?>
            <div class="col-lg-6">
                <div class=" postlist d-flex align-items-center gap-3 mb-3">
                    <div class=" postlist-img-box">
                        <a href="{{url('pesticides/'.$val->id)}}"><img src="{{env('APP_URL')."/storage/pesticides/$val->image1"}}" alt=""></a>
                    </div>
                    <div class=" postlist-content ">
                        <a href="{{url('pesticides/'.$val->id)}}" style="color:#000;text-decoration: none;"><h3>{{$val->title}}</h3></a>
                        <h5>Rs. {{$val->price}}</h5>
                        <div class="location-date d-flex align-items-center gap-3">
                            <div class="location">
                                <small><i class="fa-sharp fa-solid fa-location-dot"></i> &nbsp; <?= DB::table('district')->where(['id'=>$val->district_id])->value('district_name');?></small>
                            </div>
                            <div class="date">
                                <small><i class="fa-sharp fa-regular fa-calendar-days"></i> &nbsp; {{$val->created_at}}</small>
                            </div>
                        </div>
                    </div>
                    <span class="badge <?php if ($val->status==1) {echo 'bg-success';} else if ($val->status==0) {echo 'bg-warning';} else {echo 'bg-danger';}?> ms-5 fw-normal"><?php if ($val->status==1) {echo 'Approved';} else if ($val->status==0) {echo 'Pending';} else {echo 'Reject';}?></span>
                </div>
                
            </div>
            <?php } } ?>

    <?php if (isset($my_p_fert)) {?>
        <?php foreach ($my_p_fert as $val) { ?>
            <div class="col-lg-6">
                <div class=" postlist d-flex align-items-center gap-3 mb-3">
                    <div class=" postlist-img-box">
                        <a href="{{url('fertilizers/'.$val->id)}}"><img src="{{env('APP_URL')."/storage/fertilizers/$val->image1"}}" alt=""></a>
                    </div>
                    <div class=" postlist-content ">
                        <a href="{{url('fertilizers/'.$val->id)}}" style="color:#000;text-decoration: none;"><h3>{{$val->title}}</h3></a>
                        <h5>Rs. {{$val->price}}</h5>
                        <div class="location-date d-flex align-items-center gap-3">
                            <div class="location">
                                <small><i class="fa-sharp fa-solid fa-location-dot"></i> &nbsp; <?= DB::table('district')->where(['id'=>$val->district_id])->value('district_name');?></small>
                            </div>
                            <div class="date">
                                <small><i class="fa-sharp fa-regular fa-calendar-days"></i> &nbsp; {{$val->created_at}}</small>
                            </div>
                        </div>
                    </div>
                    <span class="badge <?php if ($val->status==1) {echo 'bg-success';} else if ($val->status==0) {echo 'bg-warning';} else {echo 'bg-danger';}?> ms-5 fw-normal"><?php if ($val->status==1) {echo 'Approved';} else if ($val->status==0) {echo 'Pending';} else {echo 'Reject';}?></span>
                </div>
                
            </div>
            <?php } } ?>

    <?php if (isset($my_p_tyre)) {?>
        <?php foreach ($my_p_tyre as $val) { ?>
            <div class="col-lg-6">
                <div class=" postlist d-flex align-items-center gap-3 mb-3">
                    <div class=" postlist-img-box">
                        <a href="{{url('tyre/'.$val->id)}}"><img src="{{env('APP_URL')."/storage/tyre/$val->image1"}}" alt=""></a>
                    </div>
                    <div class=" postlist-content ">
                        <a href="{{url('tyre/'.$val->id)}}" style="color:#000;text-decoration: none;"><h3><?= DB::table('brand')->where(['id'=>$val->brand_id])->value('name');?>
                            <?= DB::table('model')->where(['id'=>$val->model_id])->value('model_name');?></h3></a>
                        <h5>Rs. {{$val->price}}</h5>
                        <div class="location-date d-flex align-items-center gap-3">
                            <div class="location">
                                <small><i class="fa-sharp fa-solid fa-location-dot"></i> &nbsp; <?= DB::table('district')->where(['id'=>$val->district_id])->value('district_name');?></small>
                            </div>
                            <div class="date">
                                <small><i class="fa-sharp fa-regular fa-calendar-days"></i> &nbsp; {{$val->created_at}}</small>
                            </div>
                        </div>
                    </div>
                    <span class="badge <?php if ($val->status==1) {echo 'bg-success';} else if ($val->status==0) {echo 'bg-warning';} else {echo 'bg-danger';}?> ms-5 fw-normal"><?php if ($val->status==1) {echo 'Approved';} else if ($val->status==0) {echo 'Pending';} else {echo 'Reject';}?></span>
                </div>
                
            </div>
            <?php } } ?>




    </div>

</div>


@endsection