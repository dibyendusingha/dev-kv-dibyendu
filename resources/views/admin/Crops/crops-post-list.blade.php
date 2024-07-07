@extends('admin.layout.main')
@section('page-container')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">CROPS SUBSCRIPTION LIST</h2>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card card-body mb-4">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-primary-light"><i class="icon material-icons md-person fs-2 ps-2 text-success"></i></span>
                        <div class="text">
                            <h6 class="mb-1 card-title">ACTIVE CROPS SUBSCRIPTION</h6>
                            <span>{{$active_user}}</span>
                        </div>
                    </article>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card card-body mb-4">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-warning-light"><i class="icon material-icons md-person fs-2 ps-2 text-danger"></i></span>
                        <div class="text">
                            <h6 class="mb-1 card-title">EXPIRED CROPS SUBSCRIPTION</h6>
                            <span>{{$expiry_user}}</span>

                        </div>
                    </article>
                </div>
            </div>

        </div>
    </div>
    <?php if ($crop_subscribed_count > 0) { ?>
        <div class="card mb-4">
            <header class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-3 col-6">
                        <select class="form-select" id="status" onChange="filter(this.value)">
                            <option value="0" selected="">Select Status</option>
                            <option value="1">Active </option>
                            <option value="2">Expiry</option>
                        </select>
                    </div>
                </div>
            </header>
            <!-- card-header end// -->



            <div class="card-body" id="table">
                <div class="table-responsive">
                    <table class="datatable-init-export nk-tb-list nk-tb-ulist table table-hover" data-auto-responsive="false" data-export-title="Export">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col">Sl No</th>
                                <th class="nk-tb-col tb-col-mb">User Name</th>
                                <th class="nk-tb-col tb-col-mb">User Type</th>
                                <th class="nk-tb-col tb-col-mb">Mobile</th>
                                <th class="nk-tb-col tb-col-mb">Crops Plane</th>
                                <th class="nk-tb-col tb-col-mb">Create Date</th>
                                <th class="nk-tb-col tb-col-mb">Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_tbody">
                            @foreach($crop_subscribed_details as $key => $cs)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$cs->username}}</td>
                                <td><span class="badge rounded-pill alert-<?php if ($cs->user_type_id == 2) {
                                                                                echo 'success';
                                                                            } else if ($cs->user_type_id == 3) {
                                                                                echo 'warning';
                                                                            } else if ($cs->user_type_id == 4) {
                                                                                echo 'secondary';
                                                                            } else {
                                                                                echo 'danger';
                                                                            } ?>">
                                        <?php if ($cs->user_type_id == 2) {
                                            echo 'Seller';
                                        } else if ($cs->user_type_id == 3) {
                                            echo 'Dealer';
                                        } else if ($cs->user_type_id == 4) {
                                            echo 'Exchanger';
                                        } ?>
                                    </span>
                                </td>
                                <td>{{$cs->user_mobile}}</td>
                                <td>{{$cs->crop_subscriptions_name}}</td>
                                <td>
                                    <?php
                                    $created_at = $cs->crops_subscribed_created_at;
                                    $date = new DateTime($created_at);
                                    $date = $date->format('d-m-Y');
                                    ?>
                                    {{$date}}
                                </td>
                                <td>
                                    <?php if ($cs->crops_subscribed_status == 1) { ?>
                                        <span class="badge rounded-pill alert-success">Active </span>
                                    <?php } else { ?>
                                        <span class="badge rounded-pill alert-danger">Expiry </span>
                                    <?php  } ?>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" target="_blank" href="{{url('crops-invoice/'.$cs->subscribed_id)}}">Download Invoice</a>
                                            <a class="dropdown-item" href="{{url('krishi-crops-banner-post/'.$cs->subscribed_id)}}">Add Crop</a>
                                        </div>
                                    </div>
                                    <!-- dropdown //end -->
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- card-body end// -->

        </div>
        <!-- card end// -->
    <?php } ?>

</section>

<script>
    function filter(x) {
        var status = $('#status').val();
        console.log(status);

        $.ajax({
            url: "{{ route('crops.subscribed') }}",
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