@extends('admin.layout.main')
@section('page-container')
<?php

use Illuminate\Support\Facades\DB;
// use Illuminate\Http\Request;
use App\Models\Lead;
//print_r($post_lead_user);

// print '<pre>';
// print_r($data);

$url = Request::path();
$parts = explode('/', $url);
$post_id = end($parts);

$boost_product_count = DB::table('subscribed_boosts')->where('category_id', 1)->where('product_id', $post_id)->where('status', 1)->count();
$category = DB::table('tractor')->where('id',$post_id)->first();
$category_status = $category->status;
$category_type   = $category->set;
$user_id         = $category->user_id;
//dd($category_type);
?>

<style>
    .scroll_edit {
        margin: 4px, 4px;
        padding: 4px;
        overflow-x: hidden;
        overflow-y: auto;
        text-align: justify;
    }
</style>



<section class="content-main">
    <div class="content-header">
        <a href="#" onclick="history.back();"><i class="material-icons md-arrow_back"></i> Go back </a>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <!--  col.// -->
                <div class="col-xl-6 col-lg-6">
                    <input type="hidden" name="item_id" id="item_id" value="<?= $data['id'] ?>" />
                    <h3>{{$data['brand_name']}}
                        <?php if ($boost_product_count > 0) { ?>
                            <span class="px-4 py-1 fs-6 border border-warning text-warning rounded-pill">Boosted</span>
                        <?php } ?>
                    </h3>
                    <p>{{$data['state_name']}}, {{$data['district_name']}} ,{{$data['pincode']}}</p>
                    <h3 class="text-success">Rs.{{$data['price']}}
                        <?php if ($data['set'] == 'rent') {
                            echo $data['rent_type'];
                        } ?>
                        <span class="text-muted negotiable">(<?php if ($data['is_negotiable'] == 1 || $data['is_negotiable'] == "true") {
                                                                    echo 'is negotiable';
                                                                } else {
                                                                    echo 'not negotiable';
                                                                } ?>)</span>
                    </h3>
                </div>


                <div class="col-xl-6 d-flex gap-3 align-items-center justify-content-end">
                    <?php if ($boost_product_count != 0) { ?>
                        <a href="{{url('/')}}/invoice-offline-boost/{{$post_id}}" target="_blank" type="button" class="btn btn-outline-success">Invoice</a>
                    <?php } ?>
                    <select class="form-select w-auto d-inline-block" onChange="status_change(this.value)">

                        <option value="pending" <?php if ($data['status'] == 0) {
                                                    echo 'selected';
                                                } ?>>Pending</option>
                        <option value="Approved" <?php if ($data['status'] == 1) {
                                                        echo 'selected';
                                                    } ?>>Approved</option>
                        <option value="Rejected" <?php if ($data['status'] == 2) {
                                                        echo 'selected';
                                                    } ?>>Rejected</option>
                        <option value="" <?php if ($data['status'] == 3) {
                                                echo 'selected';
                                            } ?>>Disabled</option>
                        <option value="sold" <?php if ($data['status'] == 4) {
                                                    echo 'selected';
                                                } ?>>Sold</option>
                    </select>
                    <?php 
                        if($category_status == 1 && $category_type == 'sell' ){
                        if ($boost_product_count == 0) { 
                    ?>
                        <a href="/krishi-boost-payment/tractor/{{$post_id}}" class="px-3 py-2 bg-success border border-success text-white rounded"><i class="fa-solid fa-rocket me-1"></i>Boost Post</a>
                    <?php }} ?>
                    <a href="#" class="edit-btn-sidebar px-3 py-2 border border-success text-success rounded"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <?php
                    if($category_status == 0){
                    ?>
                    <select class="form-select w-auto d-inline-block" onChange="transfer(this.value)">
                        <option value="">Transfer To</option>
                        <option value="gv-tractor-{{$data['id']}}">Transfer To Goodsvehicle</option>
                        <option value="harvester-tractor-{{$data['id']}}">Transfer To Harvester</option>
                        <option value="implements-tractor-{{$data['id']}}">Transfer To Implements</option>
                        <option value="seeds-tractor-{{$data['id']}}">Transfer To Seeds</option>
                        <option value="pesticides-tractor-{{$data['id']}}">Transfer To Pesticides</option>
                        <option value="fertilizer-tractor-{{$data['id']}}">Transfer To Fertilizer</option>
                        <option value="tyre-tractor-{{$data['id']}}">Transfer To Tyre</option>
                    </select>
                    <?php } ?>
                </div>


            </div>


            <hr class="my-4" />
            <div class="row">
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @elseif(session('failed'))
                <div class="alert alert-danger" role="alert">
                    {{ session('failed') }}
                </div>
                @endif

                <div class="alert alert-info" role="alert" id="model" style="display:none">
                    <div id="msg"></div>
                </div>

                <div class="col-md-4 col-lg-4 col-xl-4">
                    <h6>Registration No.</h6>
                    <p>
                        {{$data['registration_no']}}
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-4 col-lg-4 col-xl-4">
                    <h6>ROC Avaiable</h6>
                    <p>
                        <?php if ($data['rc_available'] == 1 || $data['rc_available'] == "true") {
                            echo 'Yes';
                        } else {
                            echo 'No';
                        } ?>
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-4 col-sm-4 col-xl-4 text-xl-end">
                    <h6>NOC Available</h6>
                    <p>
                        <?php if ($data['noc_available'] == 1 || $data['noc_available'] == "true") {
                            echo 'Yes';
                        } else {
                            echo 'No';
                        } ?>
                    </p>
                </div>
                <!--  col.// -->
            </div>
            <!-- card-body.// -->

            <hr class="my-4" />
            <div class="row">
                <div class="col-md-3 col-lg-3 col-xl-3">
                    <article class="box">
                        <p class="mb-0 text-muted">Type: <span class="text-success"><?php if ($data['set'] == 'sell') {
                                                                                        echo 'Sell';
                                                                                    } else if ($data['set'] == 'rent') {
                                                                                        echo 'rent';
                                                                                    } else {
                                                                                        echo 'Not set';
                                                                                    } ?></span></p>

                        <p class="mb-0 text-muted">Condition: <span class="text-success"><?php if ($data['type'] == 'new') {
                                                                                                echo 'New';
                                                                                            } else {
                                                                                                echo 'Used';
                                                                                            } ?></span></p>


                    </article>
                </div>
                <!--  col.// -->
                <div class="col-md-3 col-lg-3 col-xl-3">
                    <h6>Contacts</h6>
                    <p>
                        @if(!empty($data['name']))
                        {{$data['name']}}
                        @endif <br />
                        @if(!empty($data['email']))
                        {{$data['email']}} 
                        @endif<br />
                        @if(!empty($data['mobile']))
                        {{$data['mobile']}}
                        @endif
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 col-lg-3 col-xl-3">
                    <h6>Address</h6>
                    <p>
                        Location:   @if(!empty($data['address'])){{$data['address']}} @endif<br />
                        State:  @if(!empty($data['state_name'])){{$data['state_name']}}  @endif<br />
                        Postal code:  @if(!empty($data['zipcode'])) {{$data['zipcode']}} @endif
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 col-sm-3 col-xl-3 text-xl-end">
                    <h6>Date &amp; Time</h6>
                    <p>
                        Posted on:  @if(!empty($data['created_at'])){{$data['created_at']}}  @endif<br />
                        Total Views: <?php echo DB::table('leads_views')->where(['category_id' => 1, 'post_id' => $data['id']])->count(); ?> <br>
                        Total Leads: <?php echo DB::table('seller_leads')->where(['category_id' => 1, 'post_user_id' => $data['user_id'], 'post_id' => $data['id']])->count(); ?>

                    </p>
                </div>
                <!--  col.// -->
            </div>
            <!--  row.// -->

            <hr class="my-4" />
            <div class="row">
                <div class="col-sm-12">
                    <h6>Description</h6>
                    <p>
                        {!! $data['description'] !!}
                    </p>
                </div>
            </div>
            <!--  row.// -->
        </div>
        <!--  card-body.// -->
    </div>
    </div>
    <!--  card.// -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Post Images</h4>
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="{{$data['left_image']}}" target="_blank" class="img-wrap"> <img src="{{$data['left_image']}}" alt="Front" /> </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Left Image</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="{{$data['right_image']}}" target="_blank" class="img-wrap"> <img src="{{$data['right_image']}}" alt="Back" /> </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Right Image</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="{{$data['front_image']}}" target="_blank" class="img-wrap"> <img src="{{$data['front_image']}}" alt="Left" /> </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Front Image</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="{{$data['back_image']}}" target="_blank" class="img-wrap"> <img src="{{$data['back_image']}}" alt="Right" /> </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Back Image</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="{{$data['meter_image']}}" target="_blank" class="img-wrap"> <img src="{{$data['meter_image']}}" alt="Meter" /> </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Meter Image</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="{{$data['tyre_image']}}" target="_blank" class="img-wrap"> <img src="{{$data['tyre_image']}}" alt="Tyre" /> </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Tyre Image</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <!-- col.// -->
            </div>
            <!-- row.// -->
        </div>
        <!--  card-body.// -->
    </div>
    <!--  card.// -->

    <!-- POST LEAD TABLE -->

    <!--  card.// -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center pb-4">
                <h4 class="card-title">Leads Table</h4>
                <button onclick="exportToExcel()" class="btn btn-dark px-3" style="font-size: 12px;color: white"><i class="ri-article-line me-1"></i>Export to Excel</button>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0" id="table">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle" scope="col">Sl No</th>
                            <th class="align-middle" scope="col">User Name</th>
                            <th class="align-middle" scope="col">User Type</th>
                            <th class="align-middle" scope="col">Mobile No</th>
                            <th class="align-middle" scope="col">Pincode</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($post_lead_user)) { ?>
                            @foreach($post_lead_user as $key => $lead_user)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$lead_user->name}}</td>
                                <td>
                                    <span class="badge badge-pill badge-soft-<?php if ($lead_user->user_type_id == 1) {
                                                                                    echo 'warning';
                                                                                } else if ($lead_user->user_type_id == 2) {
                                                                                    echo 'success';
                                                                                } else if ($lead_user->user_type_id == 3) {
                                                                                    echo 'info';
                                                                                } else {
                                                                                    echo 'danger';
                                                                                } ?>"><?php if ($lead_user->user_type_id == 1) {
                                                                                            echo 'Individual';
                                                                                        } else if ($lead_user->user_type_id == 2) {
                                                                                            echo 'Seller';
                                                                                        } else if ($lead_user->user_type_id == 3) {
                                                                                            echo 'Dealer';
                                                                                        } else {
                                                                                            echo 'Exchanger';
                                                                                        } ?></span>
                                </td>
                                <td>{{$lead_user->mobile }}</td>
                                <td>{{$lead_user->zipcode }}</td>

                            </tr>
                            @endforeach
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
        <!--  card-body.// -->
    </div>
    <!--  card.// -->

    <!--  card.// -->

  
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center pb-4">
                <h4 class="card-title">Offline Leads Table</h4>
                <div>
                    <button onclick="exportToExcelOfflineLead()" class="btn btn-dark me-1" style="font-size: 12px;color: white ; padding:10px 40px;"><i class="ri-article-line me-1"></i>Export to Excel</button>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="ri-article-line me-1"></i> Import Excel
                    </button>

                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0" id="tableOffline">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle" scope="col">Sl No</th>
                            <th class="align-middle" scope="col">User Name</th>
                            <th class="align-middle" scope="col">Mobile No</th>
                            <th class="align-middle" scope="col">Pin Code</th>
                            <th class="align-middle" scope="col">Create Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($offline_lead)) { ?>
                            @foreach($offline_lead as $key => $lead)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$lead->username}}</td>
                                <td>{{$lead->mobile}}</td>
                                <td>{{$lead->zipcode}}</td>
                                <?php
                                $dateTimeString  = $lead->created_at;
                                $created_at      = date("d-m-Y", strtotime($dateTimeString));
                                ?>
                                <td>{{$created_at}}</td>
                            </tr>
                            @endforeach
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!--  card-body.// -->
       
    </div>
   
    <!--  card.// -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{url('add-offline-lead',[1,$post_id,$user_id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- <form> -->
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Excel Upload</label>
                            <input type="file" name="excelFile" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll upload only excel .</div>
                        </div>

                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                        <!-- </form> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" value="">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- content-main end// -->




<div class="modal_wrapper w-100">
    <div class="edit_modal_sidebar py-5 px-3 scroll_edit">

        <div class="close-edit">
            <i class="fa-solid fa-circle-xmark"></i>
        </div>
        <h3 class="text-center mb-4 bg-dark text-white rounded">EDIT POST</h3>
        <form method="POST" action="{{route('tractor.update')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="update_id" value="{{$data['id']}}" />

            <div class="d-flex align-items-center gap-3 mb-4">
                <label class="fw-bold">Set:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="set" id="flexRadioDefault1" <?php if ($data['set'] == 'sell') {  echo 'checked';  } ?> value="sell">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Sell
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="set" id="flexRadioDefault1" <?php if ($data['set'] == 'rent') { echo 'checked'; } ?> value="rent">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Rent
                    </label>
                </div>

            </div>

            <div class="d-flex align-items-center gap-3 mb-4">
                <label class="fw-bold">Type:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" <?php if ($data['type'] == 'new') { echo 'checked'; } ?> value="new">
                    <label class="form-check-label" for="flexRadioDefault2">
                        New
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" <?php if ($data['type'] == 'old') { echo 'checked'; } ?> value="old">
                    <label class="form-check-label" for="flexRadioDefault2">
                        Old
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Title:</label>
                <input type="text" class="form-control" name="title" id="exampleFormControlInput1" placeholder="Enter Title" value="{{$data['title']}}">
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Price:</label>
                <input type="number" class="form-control" name="price" id="exampleFormControlInput1" placeholder="Enter Price" value="{{$data['price']}}">
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Pincode:</label>
                <input type="number" class="form-control" name="pincode" id="exampleFormControlInput1" placeholder="Enter Pincode" value="{{$data['pincode']}}">
            </div>

            <div>
                <label class="fw-bold mb-1">Rent Type:</label>
                <select class="form-select mb-4" aria-label="Default select example" name="rent_type">
                    <option value="">--Rent Type--</option>
                    <option value="Per Hour" <?php if ($data['rent_type'] == "Per Hour") {
                                                    echo 'selected';
                                                } ?>>Per Hour</option>
                    <option value="Per Day" <?php if ($data['rent_type'] == "Per Day") {
                                                echo 'selected';
                                            } ?>>Per Day</option>
                    <option value="Per Month" <?php if ($data['rent_type'] == "Per Month") {
                                                    echo 'selected';
                                                } ?>>Per Month</option>
                </select>
            </div>


            <div>
                <label class="fw-bold mb-1">Brand:</label>
                <select class="form-select mb-4" aria-label="Default select example" name="brnad" onChange="brand_change(this.value)">
                    <option value="">--Select Brand--</option>
                    <?php
                    $brand_array = DB::table('brand')->where(['category_id' => 1])->get();
                    foreach ($brand_array as $val_b) { ?>
                        <option value="{{$val_b->id}}" <?php if ($data['brand_id'] == $val_b->id) {
                                                            echo 'selected';
                                                        } ?>>{{$val_b->name}}</option>
                    <?php }
                    ?>
                </select>
            </div>


            <div>
                <label class="fw-bold mb-1">Model:</label>
                <select class="form-select mb-4" aria-label="Default select example" name="model_id" id="model_id">
                    <option value="{{$data['model_id']}}">{{$data['model_name']}}</option>
                </select>
            </div>
            <!--  -->
            <div>
                <label class="fw-bold mb-1">ROC Avaiable:</label>
                <select class="form-select mb-4" aria-label="Default select example" name="roc_available" id="roc_available">
                    <option value="1" <?php  if($data['rc_available']==1){ echo "selected"; } ?>>Yes</option>
                    <option value="0" <?php  if($data['rc_available']==0){ echo "selected"; } ?>>No</option>
                </select>
            </div>
            <div>
                <label class="fw-bold mb-1">NOC Available:</label>
                <select class="form-select mb-4" aria-label="Default select example" name="noc_available" id="noc_available">
                    <option value="1" <?php  if($data['noc_available']==1){ echo "selected"; } ?>>Yes</option>
                    <option value="0" <?php  if($data['noc_available']==0){ echo "selected"; } ?>>No</option>
                </select>
            </div>
            <div>
                <label class="fw-bold mb-1">Is Negotiable:</label>
                <select class="form-select mb-4" aria-label="Default select example" name="is_negotiable" id="is_negotiable">
                    <option value="1" <?php  if($data['is_negotiable']==1){ echo "selected"; } ?>>Yes</option>
                    <option value="0" <?php  if($data['is_negotiable']==0){ echo "selected"; } ?>>No</option>
                </select>
            </div>
            <!--  -->
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Front Image:</label>
                <input type="file" class="form-control" name="f_image" id="exampleFormControlInput1">
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Left Image:</label>
                <input type="file" class="form-control" name="l_image" id="exampleFormControlInput1">
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Right Image:</label>
                <input type="file" class="form-control" name="r_image" id="exampleFormControlInput1">
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Back Image:</label>
                <input type="file" class="form-control" name="b_image" id="exampleFormControlInput1">
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Meter Image:</label>
                <input type="file" class="form-control" name="m_image" id="exampleFormControlInput1">
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Tyre Image:</label>
                <input type="file" class="form-control" name="t_image" id="exampleFormControlInput1">
            </div>


            <div class="text-center">
                <button type="submit" class="btn btn-success text-white">Submit</button>
            </div>

        </form>


    </div>
</div>

<script>
    function status_change(x) {
        console.log(x);
        var status = x;
        var item_id = $('#item_id').val();

        $.ajax({
            url: "/krishi-tractor-status-change",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                status_change: x,
                item_id: item_id

            },
            success: function(response) {
                console.log(response);

                if (response.success) {
                    $('#model').css('display', 'block');
                    $('#msg').html(response.msg);
                    setTimeout(() => {
                        location.relod();
                    }, "1000")

                } else {

                    $('#model').css('display', 'block');
                    $('#msg').html(response.msg);
                    setTimeout(() => {
                        location.relod();
                    }, "1000")

                }
            },
        });
    }


    function transfer(x) {
        var text = x.split("-");
        var operation_to = text[0];
        var operation_from = text[1];
        var operation_id = text[2];

        $.ajax({
            url: "/krishi-transfer-to",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                operation_to: operation_to,
                operation_from: operation_from,
                operation_id: operation_id

            },
            success: function(response) {
                console.log(response);

                if (response.success) {
                    window.location.replace(response.goto);
                } else {}
            },
        });

    }

    function brand_change(x) {
        var op = '';
        $.ajax({
            type: 'POST',
            url: '{{ route("brand.to.model") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                brand_id: x
            },
            success: function(data) {
                //console.log(data)
                op = '<option value="">Select</option>';
                for (var i = 0; i < data.length; i++) {
                    op += '<option value=' + data[i].id + '>' + data[i].model_name + '</option>';
                }
                //alert(op);
                $('#model_id').html(op);
            },
            error: function() {
                console.log("Error Occurred");
            }


        });
    }
</script>

@endsection