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
    <h1 class="fw-bolder py-2  border border-black border-3 px-5 d-inline-block rounded-pill">My Boosts</h1>
    <div class="row py-2">
        <div class="col-md-3 p-2">
           
                <div class="mypost-card-wrap">
                    <div class="mypost-card ">
                    <a href="#" class="text-decoration-none text-dark">
                        <img src="https://krishivikas.com/storage/tractor/2024-01-05-16-30-3269571000298153.jpg" alt="post-img" class="img-fluid post-img">
                        </a>
                        <small class="post-status plan-boost">BASIC</small>
                        <div class="mypost-card-body">
                            <h4 class="text-center">POWERTRAC Euro 50 Next</h4>
                            <div class="mypost-card-info px-4 d-flex justify-content-between align-items-center">
                                <p><i class="fa-solid fa-indian-rupee-sign me-1"></i>RS. 25</p>
                                <p><i class="fa-solid fa-calendar-days"></i> 29 Days Left</p>
                            </div>
                        </div>
                        <div class="product-boosted-btn text-center px-2 mb-2">
                            <span  class="text-decoration-none py-2 px-2 rounded-pill text-white"> <i class="fa-solid fa-rocket"></i> Boosted</span>
                        </div>
                    </div>
                </div>
            
        </div>
        <div class="col-md-3 p-2">
            
                <div class="mypost-card-wrap">
                    <div class="mypost-card ">
                    <a href="#" class="text-decoration-none text-dark">
                        <img src="https://krishivikas.com/storage/tractor/2024-01-05-16-30-3269571000298153.jpg" alt="post-img" class="img-fluid post-img">
                        </a>
                        <small class="post-status plan-boost">INTERMEDIATE</small>
                        <div class="mypost-card-body">
                            <h4 class="text-center">POWERTRAC Euro 50 Next</h4>
                            <div class="mypost-card-info px-4 d-flex justify-content-between align-items-center">
                                <p><i class="fa-solid fa-indian-rupee-sign me-1"></i>Rs. 50</p>
                                <p><i class="fa-solid fa-calendar-days"></i> 59 Days Left</p>
                            </div>
                        </div>
                        <div class="product-boosted-btn text-center px-2 mb-2">
                            <span  class="text-decoration-none py-2 px-2 rounded-pill text-white"> <i class="fa-solid fa-rocket"></i> Boosted</span>
                        </div>
                    </div>
                </div>
            
        </div>

        <div class="col-md-3 p-2">
            
                <div class="mypost-card-wrap">
                    <div class="mypost-card ">
                    <a href="#" class="text-decoration-none text-dark">
                        <img src="https://krishivikas.com/storage/tractor/2024-01-05-16-30-3269571000298153.jpg" alt="post-img" class="img-fluid post-img">
                        </a>
                        <small class="post-status plan-boost">PREMIUM</small>
                        <div class="mypost-card-body">
                            <h4 class="text-center">POWERTRAC Euro 50 Next</h4>
                            <div class="mypost-card-info px-4 d-flex justify-content-between align-items-center">
                                <p><i class="fa-solid fa-indian-rupee-sign me-1"></i>Rs. 100</p>
                                <p><i class="fa-solid fa-calendar-days"></i> 99 Days Left</p>
                            </div>
                        </div>
                        <div class="product-boosted-btn text-center px-2 mb-2">
                            <span  class="text-decoration-none py-2 px-2 rounded-pill text-white"> <i class="fa-solid fa-rocket"></i> Boosted</span>
                        </div>
                    </div>
                </div>
            
        </div>

        
        
    </div>
    </div>
</section>


@endsection