@extends('admin.layout.main')
@section('page-container')
<?php
$url = Request::path();
$parts = explode('/', $url);
$crops_subscribed_id = end($parts);
?>

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">BANNER AND CROPS POST</h2>

        </div>
    </div>
    @if (session('message'))
    <div class="err-msg animate__animated animate__shakeX">
        <h1>{{ session('message') }}</h1>
    </div>
    @endif

 

    <div class="card-body">
        <div class="row justify-content-center">
            <?php if ($crops_count > 0) { ?>
                <?php if($subscription_feature->number_crop_banner > $banner_count){ ?>
                    <div class="col-lg-5">
                        <a href="{{url('crops-banner/'.$crops_subscribed_id)}}">
                            <div class="card card-body mb-4">
                                <article class="icontext">
                                    <span class="icon icon-sm rounded-circle bg-primary-light"><i class="icon material-icons md-person fs-2 ps-2 text-success"></i></span>
                                    <div class="text">
                                        <h6 class="mb-1 card-title">Banner Post</h6>
                                    </div>
                                </article>
                            </div>
                        </a>
                    </div>
                <?php }else{ ?>
                    <div class="col-lg-5" style="opacity: 0.5;">
                        <div class="card card-body mb-4 ">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-primary-light"><i class="icon material-icons md-person fs-2 ps-2 text-success"></i></span>
                                <div class="text">
                                    <h6 class="mb-1 card-title ">Banner Post</h6>
                                </div>
                            </article>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

            <?php if($subscription_feature->number_of_crops > $crops_count){ ?>
                <div class="col-lg-5">
                    <a href="{{url('add-krishi-subscribed-crops-post',$crops_subscribed_id)}}">
                        <div class="card card-body mb-4">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-warning-light"><i class="icon material-icons md-person fs-2 ps-2 text-danger"></i></span>
                                <div class="text">
                                    <h5 class="mb-1 card-title">Add Crop</h5>
                                    <span></span>
                                </div>
                            </article>
                        </div>
                    </a>
                </div>
            <?php }else{ ?>
                <div class="col-lg-5" style="opacity: 0.5;">
                    <div class="card card-body mb-4">
                        <article class="icontext">
                            <span class="icon icon-sm rounded-circle bg-warning-light"><i class="icon material-icons md-person fs-2 ps-2 text-danger"></i></span>
                            <div class="text">
                                <h5 class="mb-1 card-title">Add Crop</h5>
                                <span></span>
                            </div>
                        </article>
                    </div>
                </div>
            <?php } ?>

            <?php if ($banner_count > 0) { ?>
                <div class="col-lg-5">
                    <a href="{{url('crops-banner-list-wish-subscribed',$crops_subscribed_id)}}">
                        <div class="card card-body mb-4">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-warning-light"><i class="icon material-icons md-person fs-2 ps-2 text-danger"></i></span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">Crops banner list</h6>
                                    <span>{{$banner_count}}</span>
                                </div>
                            </article>
                        </div>
                    </a>
                </div>
            <?php } ?>

            <?php if ($crops_count > 0) { ?>
                <div class="col-lg-5">
                    <a href="{{url('crops-post-list-wish-subscribed',$crops_subscribed_id)}}">
                        <div class="card card-body mb-4">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-warning-light"><i class="icon material-icons md-person fs-2 ps-2 text-danger"></i></span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">Crops post list</h6>
                                    <span>{{$crops_count}}</span>
                                </div>
                            </article>
                        </div>
                    </a>
                </div>
            <?php } ?>


        </div>
    </div>
</section>



@endsection