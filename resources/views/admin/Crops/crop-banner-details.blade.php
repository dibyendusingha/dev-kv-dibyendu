@extends('admin.layout.main')
@section('page-container')

<?php
    $url      = Request::path();
    $parts    = explode('/', $url);
    $crops_banner_id = end($parts);
 ?>

<section class="content-main">

    <div class="content-header">
        <a href="javascript:history.back()"><i class="material-icons md-arrow_back"></i> Go back </a>
    </div>
    <h4 class="mb-3">CROPS BANNER DETAILS</h4>
    <?php if($crops_banner->status == 0 || $crops_banner->status == 2){ ?>
                <div class="row align-items-center">
                    <div class="col-md-3 col-6">
                        <select class="form-select" id="status" onChange="postBannerStatusUpdate(this.value)">
                            <option value="0" selected="">Select Status</option>
                            <option value="1">Approve</option>
                            <option value="2">Reject</option>
                        </select>
                    </div>
                </div>
            <?php } ?>
    <div class="card mb-4">

        <div class="card-body">

            <div class="row border">
                <div class="col-lg-6 border-end p-4">
                    <div class="benner-img-box d-flex justify-content-center p-3">
                        <img src="{{asset('storage/crops/banner/'.$crops_banner->image)}}" alt="banner-img" class="img-fluid" height="300">
                    </div>
                </div>
                <!--  col.// -->
                <div class="col-lg-6">
                    <div class="banner-creative-details d-flex justify-content-center align-items-center flex-column">
                        <h5 class="my-4 border p-2">Crops Banner Information</h5>
                        <ul class="list-style">
                            <li>
                                <p class="text-success p-2 fw-bold">Title :</p> <span> {{$crops_banner->title}}</span>
                            </li>
                            <li>
                                <p class="text-success p-2 fw-bold">Description:</p> <span>{{$crops_banner->description}}</span>
                            </li>
                            <li>
                                <p class="text-success p-2 fw-bold">Start Date:</p> <span>{{$crops_banner->start_date}}</span>
                            </li>
                            <li>
                                <p class="text-success p-2 fw-bold">End Date:</p> <span>{{$crops_banner->end_date}}</span>
                            </li>
                            <li>
                                <p class="text-success p-2 fw-bold">State Covered:</p> 
                                <span>
                                    <?php 
                                    echo $state = implode(',', $state_name); 
                                    ?>
                                </span>
                            </li>
                            <li>
                                <p class="text-success p-2 fw-bold">Banner Status:</p> 
                                <?php if($crops_banner->status == 1){ ?>
                                    <span class="bg-success rounded p-1 text-white">Active</span>
                                <?php }else if($crops_banner->status == 2){ ?>
                                    <span class="bg-danger rounded p-1 text-white">Reject</span>
                                <?php }else if($crops_banner->status == 0){ ?>
                                    <span class="bg-warning rounded p-1 text-white">Pending</span>
                                <?php }else if($crops_banner->status == 5){ ?>
                                    <span class="bg-dark rounded p-1 text-white">Expiry</span>
                                <?php } ?>
                            </li>

                        </ul>
                    </div>
                </div>
                <!--  col.// -->

            </div>
            <!-- card-body.// -->
            <hr class="my-4" />
            <h4 class="mb-3">User Information</h4>
            <div class="row border p-5">

                <div class="col-md-2 p-2">
                    <p><span class="text-success p-2 fw-bold">Name:</span>{{$user_name}}</p>
                </div>
                <!--  col.// -->
                <div class="col-md-2 p-2">
                    <p><span class="text-success p-2 fw-bold">Phone No:</span>{{$user_mobile}}</p>
                </div>
         
                <div class="col-md-3 p-2">
                    <p><span class="text-success p-2 fw-bold">Address:</span>
                  {{$user_state_name}},{{$district_name}},{{$city_name}}
                 </p>
                </div>
                <!--  col.// -->
                <div class="col-md-2 p-2">
                    <p><span class="text-success p-2 fw-bold">Pincode:</span>
                      {{$user_zipcode}}
                    </p>
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
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <br>
                   <?php 
                    if(!empty($crop_banner_lead_list)){ 
                 
                    ?>
                    @foreach($crop_banner_lead_list as $key=> $lead)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$lead->name}}</td>
                        <td>
                            <?php if($lead->user_type_id == 1){ ?>
                                Individual
                            <?php }else if($lead->user_type_id == 2){?>
                                Seller
                            <?php }else if($lead->user_type_id == 3){?>
                                Dealer
                            <?php }else if($lead->user_type_id == 4){?>
                                Exchanger
                            <?php }?>
                        </td>
                        <td>{{$lead->mobile}}</td>
                        <td>{{$lead->zipcode}}</td>
                        <td>
                            <?php if ($lead->status == 1) { ?>
                                <span class="d-inline-block bg-danger text-white  text-center rounded" style="width: 100px">Hot Lead</span>
                            <?php } else if ($lead->status == 0) { ?>
                                <span class="d-inline-block bg-success text-white text-center  rounded" style="width: 100px">Normal Lead</span>
                            <?php } ?>
                        </td>
                        <td>
                            <form name="lead" method="post" action="{{url('crop-banner-lead-update',$lead->banner_lead_id)}}">
                                @csrf

                                <select name="lead_status" class="action-select">
                                    <option value="1" {{ $lead->status == '1' ? 'selected' : '' }}>Hot Lead</option>
                                    <option value="0" {{ $lead->status == '0' ? 'selected' : '' }}>Normal Lead</option>
                                </select>
                                <button type="submit" class="action-button">Submit</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <?php
                         }
                    ?>
                </tbody>
            </table>
        </div>
        <!--  card-body.// -->
    </div>
    <!--  card.// -->

</section>


<script>
    function postBannerStatusUpdate(x) {
        var status = $('#status').val();
        console.log(status);
        var crops_banner_id = "<?php echo $crops_banner_id; ?>";
        var base_url = '<?php echo url('/') . '/'; ?>';

        $.ajax({
            url: "{{ route('crop.banner.statusUpdate') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                status: status,
                crops_banner_id:crops_banner_id,
            },
            success: function(response) {
                history.back();
                // window.location.href =  base_url+'krishi-subscribed-crops-post-list';
            },
        });
    }
</script>


@endsection