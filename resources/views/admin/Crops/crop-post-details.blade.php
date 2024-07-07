@extends('admin.layout.main')
@section('page-container')

<?php

    use Illuminate\Support\Facades\DB;

    $url      = Request::path();
    $parts    = explode('/', $url);
    $crops_id = end($parts);

    $user_id = DB::table('crops')->where('id', $crops_id)->value('user_id');
?>

<section class="content-main">
    <div class="content-header">
        <a href="#" onclick="history.back();"><i class="material-icons md-arrow_back"></i> Go back </a>
    </div>
    <?php if($subscription_feature->number_crop_boost == $subscribed_crops_boost_count && $crop_details->status == 1 && $crops_boost_count == 0  ){ ?>
    <h1>LIMIT END</h1>
    <?php } ?>
    <div class="card-body bg-white mb-2 rounded">
        <div class="row w-100 mx-auto">
            <div class="col-md-2">
                <h5>Package Name: <span class="text-success fw-bold">{{$subscription_feature->name}}</span></h5>
            </div>
            <div class="col-md-2">
                <h5>Package Price: <span class="text-warning fw-bold">Rs. {{$subscription_feature->price}}</span></h5>
            </div>
            <div class="col-md-2">
                <h5>Days: <span class="text-danger fw-bold">{{$subscription_feature->days}}</span></h5>
            </div>
            <div class="col-md-2">
                <h5>Number Of Crops Post: <span class="text-info fw-bold">{{$subscription_feature->number_of_crops}}</span></h5>
            </div>
            <div class="col-md-2">
                <h5>Website:
                    <span class="text-success fw-bold">
                        <?php if($subscription_feature->website == 'Y'){ echo "YES" ; }
                        else{ echo "NO" ; }
                        ?>

                    </span>
                </h5>
            </div>
            <div class="col-md-2">
                <h5>Mobile:
                    <span class="text-warning fw-bold">
                        <?php if($subscription_feature->mobile == 'Y'){ echo "YES" ; }
                            else{ echo "NO" ; }
                        ?>
                    </span>
                </h5>
            </div>
            <div class="col-md-2">
                <h5>Category:
                    <span class="text-danger fw-bold">
                        <?php if($subscription_feature->category == 'Y'){ echo "YES" ; }
                            else{ echo "NO" ; }
                        ?>
                    </span>
                </h5>
            </div>
            <div class="col-md-2">
                <h5>Category View All:
                    <span class="text-info fw-bold">
                        <?php if($subscription_feature->category_view_all == 'Y'){ echo "YES" ; }
                            else{ echo "NO" ; }
                        ?>
                    </span>
                </h5>
            </div>
            <div class="col-md-2">
                <h5>Notification:
                    <span class="text-info fw-bold">
                        <?php if($subscription_feature->notification == 'Y'){ echo "YES" ; }
                            else{ echo "NO" ; }
                        ?>
                    </span>
                </h5>
            </div>
            <div class="col-md-2">
                <h5>Crop Boost:
                    <span class="text-success fw-bold">
                        <?php if($subscription_feature->crop_boost == 'Y'){ echo "YES" ; }
                            else{ echo "NO" ; }
                        ?>
                    </span>
                </h5>
            </div>
            <div class="col-md-2">
                <h5>Number Crop Boost: <span class="text-warning fw-bold">{{$subscription_feature->number_crop_boost}}</span></h5>
            </div>
            <div class="col-md-2">
                <h5>Crop Banner:
                    <span class="text-danger fw-bold">
                        <?php if($subscription_feature->crop_banner == 'Y'){ echo "YES" ; }
                            else{ echo "NO" ; }
                        ?>
                    </span>
                </h5>
            </div>
            <div class="col-md-2">
                <h5>Number Crop Banner: <span class="text-info fw-bold">{{$subscription_feature->number_crop_banner}}</span></h5>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <!--  col.// -->
                <div class="col-xl-6 col-lg-6">
                    <input type="hidden" name="item_id" id="item_id" value="51">
                    <h3>{{$crop_details->crops_cat_name }}</h3>
                    <?php if($crops_boost_count > 0 && $crop_details->status == 1){ ?>
                        <span class="px-4 py-1 fs-6 border border-warning text-warning rounded-pill">Boosted</span>
                    <?php } ?>

                    <p>{{$crop_details->description }}</p>
                    <h3 class="text-success">Rs.{{$crop_details->price }}
                        <?php if ($crop_details->is_negotiable == 1) { ?>
                            ( negotiable)
                        <?php } else if($crop_details->is_negotiable == 0) { ?>
                            (not negotiable)
                        <?php } ?>

                    </h3>
                </div>
            </div>

            <a href="{{url('crops-invoice/'.$subscribed_id)}}" target="_blank" type="button" class="btn btn-outline-success">Invoice</a>
            <?php if($crop_details->status == 1){ ?>
                <a href="" target="_blank" type="button" class="btn btn-outline-success">Active</a>
            <?php }else if($crop_details->status == 5){ ?>
                <a href="" target="_blank" type="button" class="btn btn-outline-danger">Expiry</a>
            <?php }else if($crop_details->status == 0){ ?>
                <a href="" target="_blank" type="button" class="btn btn-outline-warning">Pending</a>
            <?php }else if($crop_details->status == 2){ ?>
                <a href="" target="_blank" type="button" class="btn btn-outline-dark">Reject</a>
            <?php }?>

            <?php 
                if($crops_boost_count == 0 && $crop_details->status == 1){ 
                if($subscription_feature->number_crop_boost > $subscribed_crops_boost_count){
            ?>
                <a href="{{url('crops-boost/'.$subscribed_id.'/'.$crops_id)}}" target="_blank" type="button" class="btn btn-outline-success">Boosted</a>
            <?php }} ?>

            <?php if($crop_details->status == 0 || $crop_details->status == 2){ ?>
                <div class="row align-items-center">
                    <div class="col-md-3 col-6">
                        <select class="form-select" id="status" onChange="postStatusUpdate(this.value)">
                            <option value="0" selected="">Select Status</option>
                            <option value="1">Approve</option>
                            <option value="2">Reject</option>
                        </select>
                    </div>
                </div>
            <?php } ?>

            <hr class="my-4">
            <div class="row">
                <div class="alert alert-info" role="alert" id="model" style="display:none">
                    <div id="msg"></div>
                </div>

                <div class="col-md-3 col-lg-4 col-xl-4">
                    <h6> Crops Quantity</h6>
                    <p>{{$crop_details->quantity }} {{$crop_details->type }}</p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 col-lg-4 col-xl-4">
                    <h6>Crop Price</h6>
                    <p>{{$crop_details->price }} </p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 col-sm-4 col-xl-4 ">
                    <h6>Crops Create date</h6>
                    <p>Posted on :{{$crop_details->created_at }} </p>
                </div>
                <!--  col.// -->
            </div>
            <!-- card-body.// -->

            <hr class="my-4">
            <div class="row">
                <div class="col-md-3 col-lg-3 col-xl-3">
                    <p>User Name : <span class="text-success">{{$crop_details->username}}</span></p><br>
                    <p>Contacts : {{$crop_details->usermobile}}</p>
                </div>
                <!--  col.// -->
                <div class="col-md-3 col-lg-3 col-xl-3">
                    <h6>User Type </h6>
                    <span class="badge rounded-pill alert-<?php if ($crop_details->user_type_id == 2) {
                                                                echo 'success';
                                                            } else if ($crop_details->user_type_id == 3) {
                                                                echo 'warning';
                                                            } else if ($crop_details->user_type_id == 4) {
                                                                echo 'secondary';
                                                            } else {
                                                                echo 'danger';
                                                            } ?>">
                        <?php if ($crop_details->user_type_id == 2) {
                            echo 'Seller';
                        } else if ($crop_details->user_type_id == 3) {
                            echo 'Dealer';
                        } else if ($crop_details->user_type_id == 4) {
                            echo 'Exchanger';
                        } ?>
                    </span>
                </div>
                <!--  col.// -->
                <div class="col-md-3 col-lg-3 col-xl-3">
                    <h6>User Address</h6>
                    <p>
                        Location: {{$crop_details->city_name}}<br>
                        State Name: {{$crop_details->state_name}} <br>
                        District: {{$crop_details->district_name}}<br>
                        Postal code:{{$crop_details->pincode}}
                    </p>
                </div>

            </div>
            <!--  row.// -->

            <hr class="my-4">

            <!--  row.// -->
        </div>
        <!--  card-body.// -->
    </div>

    <!--  card.// -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Post Images</h4>
            <div class="row">
                <?php if(!empty($crop_details->image1)){ ?>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="#" target="_blank" class="img-wrap">
                        <img src="{{asset('storage/crops/'.$crop_details->image1)}}" alt="Front">
                        </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Image-1</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <?php } ?>

                <?php if(!empty($crop_details->image2)){ ?>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="#" target="_blank" class="img-wrap">
                        <img src="{{asset('storage/crops/'.$crop_details->image2)}}" alt="Front">
                        </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Image-2</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <?php } ?>

                <?php if(!empty($crop_details->image3)){ ?>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card card-product-grid">
                        <a href="#" target="_blank" class="img-wrap">
                        <img src="{{asset('storage/crops/'.$crop_details->image3)}}" alt="Front">
                        </a>
                        <div class="info-wrap">
                            <a href="#" class="title">Image-3</a>
                            <!-- price-wrap.// -->
                        </div>
                    </div>
                    <!-- card-product  end// -->
                </div>
                <!-- col.// -->
                <?php } ?>

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
                <h4 class="card-title">Online Leads Table </h4>
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
                            <th class="align-middle" scope="col">Status</th>
                            <th class="align-middle" scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($lead_online)) { ?>
                            @foreach($lead_online as $key => $data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$data->name}}</td>
                                <td>
                                    <?php if ($data->user_type_id == 1) { ?>
                                        <span class="badge badge-pill badge-soft-danger">Individual</span>
                                    <?php } else if ($data->user_type_id == 2) { ?>
                                        <span class="badge badge-pill badge-soft-danger">Seller</span>
                                    <?php } else if ($data->user_type_id == 3) { ?>
                                        <span class="badge badge-pill badge-soft-danger">Dealer</span>
                                    <?php } else if ($data->user_type_id == 4) { ?>
                                        <span class="badge badge-pill badge-soft-danger">Exchanger</span>
                                    <?php } ?>
                                </td>
                                <td>{{$data->mobile}}</td>
                                <td>{{$data->zipcode}}</td>
                                <td>
                                    <?php if ($data->status == 1) { ?>
                                        <span class="d-inline-block bg-danger text-white  text-center rounded" style="width: 100px">Hot Lead</span>
                                    <?php } else if ($data->status == 0) { ?>
                                        <span class="d-inline-block bg-success text-white text-center  rounded" style="width: 100px">Normal Lead</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <form name="lead" method="post" action="{{ url('update-product-boost-status',$data->seller_id)}}">
                                        @csrf
                                        <select name="lead_status" class="action-select">
                                            <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Hot Lead</option>
                                            <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>Normal Lead</option>
                                        </select>
                                        <button type="submit" class="action-button">Submit</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        <?php } else { ?>
                            <tr>
                                <td colspan="20">No data found</td>
                            </tr>
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
                        <?php if (!empty($offline_data)) { ?>
                            @foreach($offline_data as $key => $data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$data->username}}</td>
                                <td>{{$data->mobile}}</td>
                                <td>{{$data->zipcode}}</td>
                                <td>{{$data->created_at}}</td>
                            </tr>
                            @endforeach
                        <?php } else { ?>
                            <tr>
                                <td colspan="20">No data found</td>
                            </tr>
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
                <form method="post" enctype="multipart/form-data" action="{{url('add-offline-lead',[12,$crops_id,$user_id])}}">
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

<script>
    function postStatusUpdate(x) {
        var status = $('#status').val();
        console.log(status);
        var crop_id = "<?php echo $crops_id; ?>";
        var base_url = '<?php echo url('/') . '/'; ?>';

        $.ajax({
            url: "{{ route('crop.statusUpdate') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                status: status,
                crop_id:crop_id,
            },
            success: function(response) {
                history.back();
                // window.location.href =  base_url+'krishi-subscribed-crops-post-list';
            },
        });
    }
</script>


@endsection