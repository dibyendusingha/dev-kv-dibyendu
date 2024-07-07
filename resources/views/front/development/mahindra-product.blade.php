@extends('layout.main')
@section('page-container')

    <!-- LIST GRID VIEW -->
    <div class="tractor-list-view">


        <!-- MOBILE FILTER AND SORT BUTTON -->


        <div class="container-fluid p-0">
            <div class="product-list pt-5">
                <div class="d-flex align-items-center justify-content-center">
                    <a href="#">
                        <h2>HOME</h2>
                    </a>
                    <span><i class="fa-solid fa-angle-right fa-2x text-white"></i></span>
                    <a href="#">
                        <h2>MAHINDRA TRACTORS</h2>
                    </a>
                </div>
                <div class="pl-head text-center">
                <h1>MAHINDRA TRACTORS</h1>
            </div>
            </div>
        </div>

        <div class="container" id="mahindra_product">
            <div class="row p-0 p-md-3">
                <div class="col-md-12 p-0 px-md-3">
                    <div class="container-fluid bg-white">
                        
                        <div class="row mahindra-skeleton">
                            <!--PRODUCT SKELETON-->
                            <div class="col-6 col-md-3 p-0">
                                <div class="tractor-list">
                                    <div class="tractor-img-box ph-item">
                                        <div class="ph-picture" style="height: 235px"></div>
                                        <div class="ph-col-12 big" style="height: 35px">
                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        </div>
                                        </div>
                                        
                                        <p class="distance"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 p-0">
                                <div class="tractor-list">
                                    <div class="tractor-img-box ph-item">
                                        <div class="ph-picture" style="height: 235px"></div>
                                        <div class="ph-col-12 big" style="height: 35px">
                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        </div>
                                        </div>
                                        
                                        <p class="distance"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 p-0">
                                <div class="tractor-list">
                                    <div class="tractor-img-box ph-item">
                                        <div class="ph-picture" style="height: 235px"></div>
                                        <div class="ph-col-12 big" style="height: 35px">
                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        </div>
                                        </div>
                                        
                                        <p class="distance"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 p-0">
                                <div class="tractor-list">
                                    <div class="tractor-img-box ph-item">
                                        <div class="ph-picture" style="height: 235px"></div>
                                        <div class="ph-col-12 big" style="height: 35px">
                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        </div>
                                        </div>
                                        
                                        <p class="distance"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 p-0">
                                <div class="tractor-list">
                                    <div class="tractor-img-box ph-item">
                                        <div class="ph-picture" style="height: 235px"></div>
                                        <div class="ph-col-12 big" style="height: 35px">
                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        </div>
                                        </div>
                                        
                                        <p class="distance"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 p-0">
                                <div class="tractor-list">
                                    <div class="tractor-img-box ph-item">
                                        <div class="ph-picture" style="height: 235px"></div>
                                        <div class="ph-col-12 big" style="height: 35px">
                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        </div>
                                        </div>
                                        
                                        <p class="distance"></p>
                                    </div>
                                </div>
                            </div><div class="col-6 col-md-3 p-0">
                                <div class="tractor-list">
                                    <div class="tractor-img-box ph-item">
                                        <div class="ph-picture" style="height: 235px"></div>
                                        <div class="ph-col-12 big" style="height: 35px">
                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        </div>
                                        </div>
                                        
                                        <p class="distance"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 p-0">
                                <div class="tractor-list">
                                    <div class="tractor-img-box ph-item">
                                        <div class="ph-picture" style="height: 235px"></div>
                                        <div class="ph-col-12 big" style="height: 35px">
                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        </div>
                                        </div>
                                        
                                        <p class="distance"></p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                       
                            <div class="row mahindra_product_container">
                               
                                
                               <!--PRODUCT WILL APPEAR HERE-->

                            </div>
   
                    </div>


                </div>
            </div>
        </div>
    </div>




    @endsection