@extends('admin.layout.main')
@section('page-container')
<?php

use Illuminate\Support\Facades\DB;
// print_r($subscribed_details);
$user_count = DB::table('user')->where('id', $subscribed_details->user_id)->count();
if ($user_count > 0) {
    $user_details = DB::table('user')->where('id', $subscribed_details->user_id)->first();
    $user_name    = $user_details->name;
    $user_type_id = $user_details->user_type_id;
    $user_mobile  = $user_details->mobile;
    $user_email   = $user_details->email;
    $user_zipcode = $user_details->zipcode;
    $user_address = $user_details->address;
    $user_state_name    = DB::table('state')->where('id', $user_details->state_id)->first()->state_name;
    $user_district_name = DB::table('district')->where('id', $user_details->district_id)->first()->district_name;
    $user_city_name     = DB::table('city')->where('id', $user_details->city_id)->first()->city_name;
}

?>

<section class="content-main">

    <div class="content-header">
        <a href="javascript:history.back()"><i class="material-icons md-arrow_back"></i> Go back </a>
    </div>
    <h4 class="mb-3">Banner Details</h4>
    <div class="card mb-4">

        <div class="card-body">

            <div class="row border">
                <div class="col-lg-6 border-end p-4">
                    <div class="benner-img-box d-flex justify-content-center p-3">
                        <img src="{{$banner_details->campaign_banner_image}}" alt="banner-img" class="img-fluid" height="300">
                    </div>

                    <div class="banner-creative-details d-flex justify-content-center align-items-center flex-column">
                        <h5 class="mb-4 border p-2">Campaign Information</h5>
                        <ul class="list-style">
                            <li><span class="text-success p-2 fw-bold">Campaign Name:</span> <span>{{$subscribed_details->campaign_name}}</span></li>
                            <li><span class="text-success p-2 fw-bold">Start Date:</span> <span>{{$subscribed_details->start_date}}</span></li>
                            <li><span class="text-success p-2 fw-bold">End Date:</span> <span>{{$subscribed_details->end_date}}</span></li>
                            <li><span class="text-success p-2 fw-bold">State Covered:</span> <span>{{$banner_details->campaign_state_names}}</span></li>
                            <li><span class="text-success p-2 fw-bold">Banner Status:</span> <span>
                                    @if($subscribed_details->status == 1)
                                    <span class="bg-success rounded p-1 text-white">Approved</span>
                                    @endif

                                    @if($subscribed_details->status == 0)
                                    <span class="bg-warning rounded p-1 text-white">Pending</span>
                                    @endif

                                    @if($subscribed_details->status == 2)
                                    <span class="bg-danger rounded p-1 text-white">Rejected</span>
                                    @endif
                                </span></li>

                        </ul>
                    </div>
                </div>
                <!--  col.// -->
                <div class="col-lg-6">
                    <div class="invoice-details d-flex justify-content-center align-items-center flex-column h-100">
                        <h5 class="mb-4 border p-2">Payment Information</h5>
                        <ul class="list-style">
                            <li><span class="text-success p-2 fw-bold">Transaction ID:</span> <span>{{ $subscribed_details->transaction_id}}</span></li>
                            <li><span class="text-success p-2 fw-bold">Payment Date:</span> <span>{{$subscribed_details->created_at}}</span></li>
                            <li><span class="text-success p-2 fw-bold">Amount:</span> <span>{{$subscribed_details->purchased_price}}</span></li>
                            <li><span class="text-success p-2 fw-bold">Validity:</span> <span>{{$subscribed_details->end_date}}</span></li>
                            <li><span class="text-success p-2 fw-bold">Invoice No:</span> <span>{{$subscribed_details->invoice_no}}</span></li>
                          
                        </ul>
                    </div>
                </div>
                <!--  col.// -->

            </div>
            <!-- card-body.// -->
            <hr class="my-4" />
            <h4 class="mb-3">User Information</h4>
            <div class="row border p-5">

                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Name:</span>{{$user_name}} </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Phone No:</span>{{$user_mobile}}</p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Email ID:</span>
                        <?php
                        if ($user_email != null) { ?>
                            {{$user_email}}
                        <?php } else { ?>
                            N/A
                        <?php } ?>
                    </p>

                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">User Type:</span>
                        <?php if ($user_type_id == 1) { ?>
                            Buyer
                        <?php } else if ($user_type_id == 2) { ?>
                            Individual
                        <?php } else if ($user_type_id == 3) { ?>
                            Dealer
                        <?php } else if ($user_type_id == 4) { ?>
                            Exchanger
                        <?php } ?>
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Address:</span> {{$user_address}},{{$user_state_name}},{{$user_district_name}},{{$user_city_name}}</p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Pincode:</span> {{$user_zipcode}}</p>
                </div>
                <!--  col.// -->

            </div>
            <!--  row.// -->
        </div>
        <!--  card-body.// -->
    </div>
    <!--  card.// -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Banner User's Lead Table</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User Name</th>
                        <th scope="col">User Type</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Zipcode</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <br>
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <br>

                    <?php
                    //  echo '<pre>';
                    //  print_r($banner_lead_details);
                    ?>
                    @foreach ($banner_lead_details as $key => $user)
                    <?php
                    if ($user->user_type_id  == 1) {
                        $user_type = "Buyer";
                    } else if ($user->user_type_id  == 2) {
                        $user_type = "Individual";
                    } else if ($user->user_type_id  == 3) {
                        $user_type = "Dealer";
                    } else if ($user->user_type_id  == 4) {
                        $user_type = "Exchanger";
                    }
                    ?>
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user_type}}</td>
                        <td>{{$user->mobile }}</td>
                        <td>{{$user->zipcode }}</td>
                        <td>
                            <form name="lead" method="post" action="{{ url('update-banner-status',$user->id)}}">
                                @csrf

                                <select name="lead_status" class="action-select">
                                    <option value="1" <?php if ($user->status == 1) { ?>selected<?php } ?>>Hot Lead</option>
                                    <option value="0" <?php if ($user->status == 0) { ?>selected<?php } ?>>Normal Lead</option>
                                </select>
                                <button type="submit" class="action-button">Submit</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
        <!--  card-body.// -->
    </div>
    <!--  card.// -->

</section>



@endsection