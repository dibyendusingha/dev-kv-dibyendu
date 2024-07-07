@extends('admin.layout.main')
@section('page-container')
<?php $boost_count = count($crop_boost_list); ?>

<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">CROP BOOST LIST</h2>
        </div>

    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card card-body mb-4">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-primary-light"><i class="icon material-icons md-person fs-2 ps-2 text-success"></i></span>
                        <div class="text">
                            <h6 class="mb-1 card-title">ACTIVE CROPS BOOST</h6>
                            <span>{{$active_boost}}</span>
                        </div>
                    </article>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card card-body mb-4">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-warning-light"><i class="icon material-icons md-person fs-2 ps-2 text-danger"></i></span>
                        <div class="text">
                            <h6 class="mb-1 card-title">INACTIVE CROPS BOOST</h6>
                            <span>{{$inactive_boost}}</span>

                        </div>
                    </article>
                </div>
            </div>

        </div>
    </div>
    <?php if($boost_count > 0){ ?>
    <div class="card">
        <div class="card-body">
            <header class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-3 col-6">
                        <select class="form-select" id="status" onChange="filter(this.value)">
                            <option value="0" selected="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                        </select>
                    </div>
                </div>
            </header>
            <div class="row">

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Crops Name </th>
                                    <th>User Name</th>
                                    <th>Subscription Plan</th>
                                    <th>Invoice No</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody class="mb-5" id="table_tbody">
                                <?php if (!empty($crop_boost_list)) { ?>
                                    @foreach($crop_boost_list as $key=> $crop)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$crop->crops_cat_name}}</td>
                                        <td>{{$crop->username}}</td>
                                        <td>{{$crop->crop_subscriptions_name}}</td>
                                        <td>{{$crop->invoice_no}}</td>
                                        <td>
                                            <?php if ($crop->boost_status == 1) { ?>
                                                <span class="bg-success rounded p-1 text-white">Active</span>
                                            <?php } else { ?>
                                                <span class="bg-danger rounded p-1 text-white">Inactive</span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                <div class="dropdown-menu ">
                                                    <a class="dropdown-item" href="{{url('crops-post-details/'.$crop->crop_id)}}">View Details</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                <?php } ?>

                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- .col// -->
            </div>
            <!-- .row // -->
        </div>
        <!-- card body .// -->
    </div>
    <!-- card .// -->
    <?php } ?>


    <script>
        function filter(x) {
            var status = $('#status').val();
            console.log(status);

            $.ajax({
                url: "{{ route('crop.boostList') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    status: status,
                },
                success: function(response) {
                    if (response) {
                        $('#table_tbody').html(response);
                    }

                },
            });
        }
    </script>

    @endsection