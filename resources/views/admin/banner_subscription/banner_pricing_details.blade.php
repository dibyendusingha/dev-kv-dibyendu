@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
?>

            <section class="content-main">
               
            <section class="banner-subscription-wrapper">
      <div class="plan-content container">
        <div class="banner-plan-cover pb-2">
          <img src="https://krishivikas.com/storage/banner_ads/BASIC.png" alt="plan-cover-photo" class="w-100" />
        </div>
        <div class="price-table mt-5">
          <div class="row">
            <div class="col-3 p-4 features">
              <ul class="list-unstyled">
                <li><i class="ri-mac-fill me-2"></i>Website</li>
                <li><i class="ri-smartphone-fill me-2"></i>Mobile</li>
                <li><i class="ri-list-check-3 me-2"></i>Sub Category</li>
                <li><i class="ri-list-check-3 me-2"></i>Category</li>
                <li><i class="ri-list-view me-2"></i>Listing</li>
                <li><i class="ri-image-line me-2"></i>Creatives</li>
              </ul>
            </div>
            <div class="col-3 p-4 basic-plan active-plan">
                <h2>Basic</h2>
                <ul class="list-unstyled">
                    <li><i class="ri-close-line bg-danger rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-close-line bg-danger   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-close-line bg-danger   rounded-circle text-white p-1"></i></li>
                    <li class="px-2 border-dark border d-inline-block fw-bold">1</li>
                </ul>
            </div>
            <div class="col-3 p-4 intermediate-plan">
                <h2>Intermediate</h2>
                <ul class="list-unstyled">
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-close-line bg-danger   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li class="px-2 border-dark border d-inline-block fw-bold">3</li>
                </ul>
            </div>
            <div class="col-3 p-4 premium-plan">
                <h2>Premium</h2>
                <ul class="list-unstyled">
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li><i class="ri-check-double-line bg-success   rounded-circle text-white p-1"></i></li>
                    <li class="px-2 border-dark border d-inline-block fw-bold">5</li>
                </ul>
            </div>
            <div class="col-3">
                <img src="https://krishivikas.com/assets/images/new_logo_kv.png" alt="logo" class="img-fluid p-4">
            </div>
            <div class="col-md-9 ms-auto price-select">
                <div class="basic-plan-selected">
                    <ul class="list-unstyled plan-pricing p-0 show">
                        <li>
                            <figure>
                                <p>90 days</p>
                                <p>₹500</p>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <p>180 days</p>
                                <p>₹900</p>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <p>360 days</p>
                                <p>₹1250</p>
                            </figure>
                        </li>
                    </ul>
                </div>
                <div class="intermediate-plan-selected d-none">
                    <ul class="list-unstyled plan-pricing p-0 show">
                        <li>
                            <figure>
                                <p>90 days</p>
                                <p>₹800</p>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <p>180 days</p>
                                <p>₹1500</p>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <p>360 days</p>
                                <p>₹2000</p>
                            </figure>
                        </li>
                    </ul>
                </div>
                <div class="premium-plan-selected d-none">
                    <ul class="list-unstyled plan-pricing p-0 show">
                        <li>
                            <figure>
                                <p>90 days</p>
                                <p>₹1000</p>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <p>180 days</p>
                                <p>₹1800</p>
                            </figure>
                        </li>
                        <li>
                            <figure>
                                <p>360 days</p>
                                <p>₹2500</p>
                            </figure>
                        </li>
                    </ul>
                </div>
                
            </div>
          </div>
        </div>
      </div>
    </section>
            </section>
            
            
            
@endsection
