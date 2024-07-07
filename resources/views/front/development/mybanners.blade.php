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
<section class="user-post">
    <div class="container px-2 py-5">
    <h1 class="fw-bolder py-2  border border-black border-3 px-5 d-inline-block rounded-pill">My Ad Banners</h1>
    <div class="row py-2">
        <div class="col-md-4 p-2">
           
                <div class="mypost-card-wrap">
                    <div class="mypost-card ">
                    <a href="#" class="text-decoration-none text-dark">
                        <img src="https://krishivikas.com/storage/tractor/2024-01-05-16-30-3269571000298153.jpg" alt="post-img" class="img-fluid post-img">
                        </a>
                        <img src="https://krishivikas.com/storage/CC/approved.png" alt="rejected-badge " class="img-fluid banner-post-status" >
                        <small class="banner-plan">BASIC PLAN</small>
                        <div class="mypost-card-body">
                            <h4 class="text-left ps-3 fs-5">Advertisement Name </h4>
                            <div class="mypost-card-info px-3 d-flex justify-content-between align-items-center">
                                <p style="font-size: 16px;"><i class="ri-timer-flash-fill"></i>29 Days Left</p>
                                <div class="action-banner">
                                    <a href="#" class="p-2 text-white bg-success rounded-pill text-decoration-none"><i class="ri-edit-circle-fill"></i>EDIT</a>
                                    <a href="#" class="p-2 text-white bg-danger rounded-pill text-decoration-none"><i class="ri-delete-bin-4-fill"></i>DELETE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>

        <div class="col-md-4 p-2">
           
                <div class="mypost-card-wrap">
                    <div class="mypost-card ">
                    <a href="#" class="text-decoration-none text-dark">
                        <img src="https://krishivikas.com/storage/tractor/2024-01-05-16-30-3269571000298153.jpg" alt="post-img" class="img-fluid post-img">
                        </a>
                        <img src="https://krishivikas.com/storage/CC/pending.png" alt="rejected-badge " class="img-fluid banner-post-status" >
                        <small class="banner-plan">INTERMEDIATE PLAN</small>
                        <div class="mypost-card-body">
                            <h4 class="text-left ps-3 fs-5">Advertisement Name </h4>
                            <div class="mypost-card-info px-3 d-flex justify-content-between align-items-center">
                                <p style="font-size: 16px;"><i class="ri-timer-flash-fill"></i>59 Days Left</p>
                                <div class="action-banner">
                                    <a href="#" class="p-2 text-white bg-success rounded-pill text-decoration-none"><i class="ri-edit-circle-fill"></i>EDIT</a>
                                    <a href="#" class="p-2 text-white bg-danger rounded-pill text-decoration-none"><i class="ri-delete-bin-4-fill"></i>DELETE</a>
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