@extends('admin.layout.main')
@section('page-container')
<?php

use Illuminate\Support\Facades\DB;

$url = Request::path();
$parts = explode('/', $url);
$crops_subscribed_id = end($parts);
?>
<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">CROPS POST LIST</h2>
        </div>
    </div>
    
    <?php if ($crops_count > 0) { ?>
        <div class="card mb-4">
            <header class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-3 col-6">
                        <select class="form-select" id="status" onChange="filter(this.value)">
                            <option value="4" selected="">Select Status</option>
                            <option value="0">Pending</option>
                            <option value="1">Approve</option>
                            <option value="5">Expiry</option>
                            <option value="2">Reject</option>
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
                                <th class="nk-tb-col tb-col-mb">Crops Name</th>
                                <th class="nk-tb-col tb-col-mb">Boost/ Not Boost</th>
                                <th class="nk-tb-col tb-col-mb">Create Date</th>
                                <th class="nk-tb-col tb-col-mb">Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_tbody">
                            @foreach($crop_list as $key=> $crop)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$crop->name}}</td>
                                <td><span class="badge rounded-pill alert-<?php if ($crop->user_type_id == 2) {
                                                                                echo 'success';
                                                                            } else if ($crop->user_type_id == 3) {
                                                                                echo 'warning';
                                                                            } else if ($crop->user_type_id == 4) {
                                                                                echo 'secondary';
                                                                            } else {
                                                                                echo 'danger';
                                                                            } ?>">
                                        <?php if ($crop->user_type_id == 2) {
                                            echo 'Seller';
                                        } else if ($crop->user_type_id == 3) {
                                            echo 'Dealer';
                                        } else if ($crop->user_type_id == 4) {
                                            echo 'Exchanger';
                                        } ?>
                                    </span>
                                </td>
                                <td>{{$crop->mobile}}</td>
                                <td>{{$crop->crop_subscriptions_name}}</td>
                                <td>{{$crop->crops_cat_name}}</td>
                                <td><?php
                                    $created_at = $crop->crops_created_at;
                                    $date = new DateTime($created_at);
                                    $date = $date->format('d-m-Y');
                                    ?>
                                    {{$date}}
                                </td>
                                <td>
                                    <?php $boost_count = DB::table('crops_boosts')->where('crop_id', $crop->crops_id)->where('status', 1)->count();
                                    if ($boost_count > 0) { ?>
                                        <span class="badge rounded-pill alert-success">BOOST</span>
                                    <?php } else { ?>
                                        <span class="badge rounded-pill alert-danger">NO BOOST</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($crop->crop_status == 1) { ?>
                                        <span class="d-inline-block bg-success text-white  text-center rounded" style="width: 100px">Approve</span>
                                    <?php } else if ($crop->crop_status == 2) { ?>
                                        <span class="d-inline-block bg-danger text-white text-center  rounded" style="width: 100px">Reject</span>
                                    <?php } else if ($crop->crop_status == 0) { ?>
                                        <span class="d-inline-block bg-warning text-white text-center  rounded" style="width: 100px">Pending</span>
                                    <?php } else if ($crop->crop_status == 5) { ?>
                                        <span class="d-inline-block bg-dark text-white text-center  rounded" style="width: 100px">Expiry</span>
                                    <?php } else if ($crop->crop_status == 4) { ?>
                                        <span class="d-inline-block bg-warning text-white text-center  rounded" style="width: 100px">Sold</span>
                                    <?php } else if ($crop->crop_status == 3) { ?>
                                        <span class="d-inline-block bg-warning text-white text-center  rounded" style="width: 100px">Disable</span>
                                    <?php } ?>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                        <div class="dropdown-menu ">
                                            <a class="dropdown-item" href="{{url('crops-post-details/'.$crop->crops_id)}}">View Details</a>
                                        </div>
                                    </div>
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
        var crops_subscribed_id = "<?php echo $crops_subscribed_id; ?>";

        $.ajax({
            url: "{{ route('crop.postList.subscribed') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                status: status,
                crops_subscribed_id: crops_subscribed_id,
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