@extends('admin.layout.main')
@section('page-container')
<?php

    use Illuminate\Support\Facades\DB;
    //print_r($data);

    $url = Request::path();
    $parts = explode('/', $url);
    $post_id = end($parts);

    $boost_product_count = DB::table('subscribed_boosts')->where('category_id', 9)->where('product_id', $post_id)->where('status', 1)->count();
    $category = DB::table('fertilizers')->where('id',$post_id)->first();
    $category_status = $category->status;
    $user_id  = $category->user_id;

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
                <div class="col-xl-6">
                    <input type="hidden" name="item_id" id="item_id" value="<?= $data['id'] ?>" />
                    <h3>{{$data['title']}}
                        <?php if ($boost_product_count > 0) { ?>
                            <span class="px-4 py-1 fs-6 border border-warning text-warning rounded-pill">Boosted</span>
                        <?php } ?>
                    </h3>
                    <p>{{$data['state_name']}}, {{$data['district_name']}}</p>
                    <h3 class="text-success">Rs.{{$data['price']}} <span class="text-muted negotiable">(<?php if ($data['is_negotiable'] == 1) {
                                                                                                            echo 'is negotiable';
                                                                                                        } else {
                                                                                                            echo 'not negotiable';
                                                                                                        } ?>)</span></h3>
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
                        <option value="" <?php if ($data['status'] == 4) {
                                                echo 'selected';
                                            } ?>>Sold</option>
                    </select>
                    <?php 
                    if($category_status == 1){

                    if ($boost_product_count == 0) { ?>
                        <a href="/krishi-boost-payment/fertilizer/{{$post_id}}" class="px-3 py-2 bg-success border border-success text-white rounded"><i class="fa-solid fa-rocket me-1"></i>Boost Post</a>
                    <?php } } ?>
                    <a href="#" class="edit-btn-sidebar px-3 py-2 border border-success text-success rounded"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <?php if($category_status == 0){ ?>
                    <select class="form-select w-auto d-inline-block" onChange="transfer(this.value)">
                        <option value="">Transfer To</option>
                        <option value="tractor-fertilizer-{{$data['id']}}">Transfer To Tractor</option>
                        <option value="gv-fertilizer-{{$data['id']}}">Transfer To Goods Vehicle</option>
                        <option value="harvester-fertilizer-{{$data['id']}}">Transfer To Harvester</option>
                        <option value="implements-fertilizer-{{$data['id']}}">Transfer To Implements</option>
                        <option value="seeds-fertilizer-{{$data['id']}}">Transfer To Seeds</option>
                        <option value="pesticides-fertilizer-{{$data['id']}}">Transfer To Pesticides</option>
                        <option value="tyre-fertilizer-{{$data['id']}}">Transfer To Tyre</option>
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



                <!--  col.// -->
            </div>
            <!-- card-body.// -->

            <hr class="my-4" />
            <div class="row">

                <!--  col.// -->
                <div class="col-md-4 col-lg-4 col-xl-4">
                    <h6>Contacts</h6>
                    <p>
                        {{$data['name']}} <br />
                        {{$data['email']}} <br />
                        {{$data['mobile']}}
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-4 col-lg-4 col-xl-4">
                    <h6>Address</h6>
                    <p>
                        Location: {{$data['address']}}<br />
                        State: {{$data['state_name']}} <br />
                        Postal code: {{$data['zipcode']}}
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-4 col-sm-4 col-xl-4 text-xl-end">
                    <h6>Date &amp; Time</h6>
                    <p>
                        Posted on: {{$data['created_at']}} <br />
                        Total Views: <?php echo DB::table('leads_views')->where(['category_id' => 9, 'post_id' => $data['id']])->count(); ?> <br />
                        Total Leads: <?php echo DB::table('seller_leads')->where(['category_id' => 9, 'post_user_id' => $data['user_id'], 'post_id' => $data['id']])->count(); ?>
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
                        <a href="{{$data['image1']}}" target="_blank" class="img-wrap"> <img src="{{$data['image1']}}" alt="Front" /> </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Image 1</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="{{$data['image2']}}" target="_blank" class="img-wrap"> <img src="{{$data['image2']}}" alt="Back" /> </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Image 2</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="{{$data['image3']}}" target="_blank" class="img-wrap"> <img src="{{$data['image3']}}" alt="Left" /> </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Image 3</a>
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
                            <th class="align-middle" scope="col">Pincode</th>
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
                <form action="{{url('add-offline-lead',[9,$post_id,$user_id])}}" method="post" enctype="multipart/form-data">
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
        <form method="POST" action="{{route('fertilizer.update')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="update_id" value="{{$data['id']}}" />


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

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Image1:</label>
                <input type="file" class="form-control" name="image1" id="exampleFormControlInput1">
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Image2:</label>
                <input type="file" class="form-control" name="image2" id="exampleFormControlInput1">
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1" class="form-label fw-bold">Image3:</label>
                <input type="file" class="form-control" name="image3" id="exampleFormControlInput1">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success text-white">Submit</button>
            </div>

        </form>


    </div>
</div>

<script>
    function status_change(x) {
        var status = x;
        var item_id = $('#item_id').val();

        $.ajax({
            url: "/krishi-fertilizers-status-change",
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
</script>

@endsection