@extends('admin.layout.main')
@section('page-container')
<?php

use Illuminate\Support\Facades\DB;
?>

<?php
// echo $category_id;
?>

<section class="content-main">

    <div class="content-header">
        <a href="javascript:history.back()"><i class="material-icons md-arrow_back"></i> Go back </a>
    </div>
    <h4 class="mb-3">Product Boost Details</h4>
    <div class="card mb-4">

        <div class="card-body">

            <div class="row border">
                <div class="col-lg-6 border-end p-4">
                    <div class="benner-img-box d-flex justify-content-center p-3">
                        <?php if ($category_id == 1) { ?>
                            <img src="{{asset('storage/tractor/'.$image)}}" alt="banner-img" class="img-fluid" height="300">
                        <?php } else if ($category_id == 3) { ?>
                            <img src="{{asset('storage/goods_vehicle/'.$image)}}" alt="banner-img" class="img-fluid" height="300">
                        <?php } else if ($category_id == 4) { ?>
                            <img src="{{asset('storage/harvester/'.$image)}}" alt="banner-img" class="img-fluid" height="300">
                        <?php } else if ($category_id == 5) { ?>
                            <img src="{{asset('storage/implements/'.$image)}}" alt="banner-img" class="img-fluid" height="300">
                        <?php } else if ($category_id == 6) { ?>
                            <img src="{{asset('storage/seeds/'.$image)}}" alt="banner-img" class="img-fluid" height="300">
                        <?php } else if ($category_id == 7) { ?>
                            <img src="{{asset('storage/tyre/'.$image)}}" alt="banner-img" class="img-fluid" height="300">
                        <?php } else if ($category_id == 8) { ?>
                            <img src="{{asset('storage/pesticides/'.$image)}}" alt="banner-img" class="img-fluid" height="300">
                        <?php } else if ($category_id == 9) { ?>
                            <img src="{{asset('storage/fertilizers/'.$image)}}" alt="banner-img" class="img-fluid" height="300">
                        <?php } ?>
                    </div>
                </div>
                <!--  col.// -->
                <div class="col-lg-6">
                    <div class="invoice-details d-flex justify-content-center align-items-center flex-column h-100">
                        <h5 class="mb-4 border p-2">Payment Information</h5>
                        <ul class="list-style">
                            <li><span class="text-success p-2 fw-bold">Transaction ID:</span> <span>{{$subscribe_boost_details->transaction_id}}</span></li>
                            <li><span class="text-success p-2 fw-bold">Payment Date:</span> <span>{{$subscribe_boost_details->created_at}}</span></li>
                            <li><span class="text-success p-2 fw-bold">Amount:</span> <span>{{$subscribe_boost_details->purchased_price}}</span></li>
                            <li><span class="text-success p-2 fw-bold">Validity:</span> <span>{{$subscribe_boost_details->end_date}}</span></li>
                            <li class="text-center  mt-3"><a target="_blank" href="{{url('/')}}/invoice/subscription_boots/{{$subscribedId}}" class="btn btn-success text-white">Download Invoice</a></li>
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
                    <p><span class="text-success p-2 fw-bold">Name:</span>
                        <?php if (!empty($user_details->name)) { ?>
                            {{$user_details->name}}
                        <?php } else { ?>
                            N/A
                        <?php } ?>
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Phone No:</span>
                        <?php if (!empty($user_details->mobile)) { ?>
                            {{$user_details->mobile}}
                        <?php } else { ?>
                            N/A
                        <?php } ?>
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Email ID:</span>
                        <?php if (!empty($user_details->email)) { ?>
                            {{$user_details->email}}
                        <?php } else { ?>
                            N/A
                        <?php } ?>
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">User Type:</span>
                        <?php if ($user_details->user_type_id == 1) { ?>
                            Buyer
                        <?php } else if ($user_details->user_type_id == 2) { ?>
                            Individual
                        <?php } else if ($user_details->user_type_id == 3) { ?>
                            Dealer
                        <?php } else if ($user_details->user_type_id == 4) { ?>
                            Exchanger
                        <?php } ?>
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Address:</span>
                        <?php if (!empty($user_details->address)) { ?>
                            {{$user_details->address}}
                        <?php } else { ?>
                            N/A
                        <?php } ?>
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Pincode:</span>
                        <?php if (!empty($user_details->zipcode)) { ?>
                            {{$user_details->zipcode}}
                        <?php } else { ?>
                            N/A
                        <?php } ?>
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Company Name:</span>
                        <?php if (!empty($user_details->company_name)) { ?>
                            {{$user_details->company_name}}
                        <?php } else { ?>
                            N/A
                        <?php } ?>
                    </p>
                </div>

            </div>
            <!--  row.// -->
        </div>
        <!--  card-body.// -->
    </div>

    <!--  card.// -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">User's Lead Table</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Zipcode</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
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
                    @foreach ($seller_lead_details as $seller)
                    <?php
                    // print_r($seller->status);
                    $user_count = DB::table('user')->where('id', $seller->user_id)->count();

                    if ($user_count > 0) {
                        $user = DB::table('user')->where('id', $seller->user_id)->first();
                    }
                    ?>
                    <tr>
                        <?php if (!empty($user->id)) { ?>
                            <td>{{$user->id}}</td>
                        <?php } else { ?>
                            <td>N/A</td>
                        <?php } ?>

                        <?php if (!empty($user->name)) { ?>
                            <td>{{$user->name}}</td>
                        <?php } else { ?>
                            <td>N/A</td>
                        <?php } ?>

                        <?php if (!empty($user->mobile)) { ?>
                            <td>{{$user->mobile}}</td>
                        <?php } else { ?>
                            <td>N/A</td>
                        <?php } ?>

                        <?php if (!empty($user->zipcode)) { ?>
                            <td>{{$user->zipcode}}</td>
                        <?php } else { ?>
                            <td>N/A</td>
                        <?php } ?>
                        <td>
                            <?php if ($seller->status == 1) { ?>
                                <span class="d-inline-block bg-danger text-white  text-center rounded" style="width: 100px">Hot Lead</span>
                            <?php } else if ($seller->status == 0) { ?>
                                <span class="d-inline-block bg-success text-white text-center  rounded" style="width: 100px">Normal Lead</span>
                            <?php } ?>
                        </td>
                        <td>
                            <form name="lead" method="post" action="{{ url('update-product-boost-status',$seller->id)}}">
                                @csrf
                                <select name="lead_status" class="action-select">
                                    <option value="1" {{ $seller->status == '1' ? 'selected' : '' }}>Hot Lead</option>
                                    <option value="0" {{ $seller->status == '0' ? 'selected' : '' }}>Normal Lead</option>
                                </select>
                                <button type="submit" class="action-button">Submit</button>
                            </form>
                        </td>

                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
        <nav>
            {{--$seller_lead_details->links()--}}
        </nav>
        <!--  card-body.// -->
    </div>
    <!--  card.// -->

</section>



@endsection