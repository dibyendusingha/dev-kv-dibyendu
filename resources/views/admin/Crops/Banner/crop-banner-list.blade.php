@extends('admin.layout.main')
@section('page-container')

<?php
$url = Request::path();
$parts = explode('/', $url);
$crops_subscribed_id = end($parts);

?>

<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">CROPS BANNER LIST</h2>
        </div>

    </div>

    <div class="card">
        <div class="card-body">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Banner Image</th>
                                    <th>User Name</th>
                                    <th>Subscription Plan</th>
                                    <th>Invoice No</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody class="mb-5" id="table_tbody">
                                <?php if (!empty($crop_banner_list)) { ?>
                                    @foreach($crop_banner_list as $key => $crop)

                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <img width="100" src="{{asset('storage/crops/banner/'.$crop->banner_image)}}" />
                                        </td>
                                        <td>{{$crop->username}}</td>
                                        <td>{{$crop->crop_subscriptions_name}}</td>
                                        <td>{{$crop->invoice_no}}</td>
                                        <td>
                                            <?php if ($crop->banner_status == 1) { ?>
                                                <span class="bg-success rounded p-1 text-white">Approve</span>
                                            <?php } else if ($crop->banner_status == 0) { ?>
                                                <span class="bg-warning rounded p-1 text-white">Pending</span>
                                            <?php } else if ($crop->banner_status == 2) { ?>
                                                <span class="bg-light rounded p-1 text-white">Reject</span>
                                            <?php } else if ($crop->banner_status == 4) { ?>
                                                <span class="bg-warning rounded p-1 text-white">Sold</span>
                                            <?php } else if ($crop->banner_status == 3) { ?>
                                                <span class="bg-warning rounded p-1 text-white">Disable</span>
                                            <?php } else { ?>
                                                <span class="bg-danger rounded p-1 text-white">Expiry</span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                <div class="dropdown-menu ">
                                                    <a class="dropdown-item" href="{{url('crops-banner-details/'.$crop->crop_banner_id)}}">View Details</a>
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

    <!-- Delete Modal -->

    <script>
        function filter(x) {
            var status = $('#status').val();
            console.log(status);
            var crops_subscribed_id = "<?php echo $crops_subscribed_id; ?>";
            console.log(crops_subscribed_id);

            $.ajax({
                url: "{{ route('crop.bannerList.subscribed') }}",
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