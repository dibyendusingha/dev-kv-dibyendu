@extends('admin.layout.main')
@section('page-container')

<?php
use Illuminate\Support\Facades\DB;
//  print_r($ads_banner->campaign_category_name);
?>

<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">Ads Banner List</h2>
            <p>Add, edit or delete</p>
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" />
                                        </div>
                                    </th>
                                    <th>Ads Banner Image</th>
                                    <th> Mobile No</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>state Name</th>
                                    <th>Category</th>
                                    <th>status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody class="mb-5">
                                <?php 
                                    if(!empty($ads_banner)){
                                ?>
                               @foreach($ads_banner as $banner)
                               <?php 
                                $banner_image = asset('storage/sponser/'.$banner->banner_img); 
                               ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" />
                                        </div>
                                    </td>
                                    <td><img src="{{asset('storage/sponser/'.$banner->banner_img)}}" alt="ads-image" width="200"/></td>
                                    <td>
                                        <?php 
                                            $user_mobile = DB::table('user')->where('id',$banner->user_id)->first()->mobile;
                                        ?>
                                        {{ $user_mobile}}
                                    </td>
                                    <td>{{$banner->start_date}}</td> 
                                    <td>{{$banner->end_date}}</td>
                                    <td>{{$banner->campaign_state_names}}</td> 
                                    <td>{{$banner->campaign_category_names}}</td> 
                                    <td>
                                        @if($banner->status == 1)
                                            <span class="bg-success rounded p-1 text-white">Approved</span>
                                        @endif

                                        @if($banner->status == 0)
                                            <span class="bg-warning rounded p-1 text-white">Pending</span>
                                        @endif

                                        @if($banner->status == 2)
                                        <span class="bg-danger rounded p-1 text-white">Rejected</span>
                                        @endif

                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu ">
                                                <a class="dropdown-item text-success" href='update-ads-banner-status/approve/{{ $banner->ads_banner_id }}'>Approve</a>
                                                <a class="dropdown-item text-warning" href='update-ads-banner-status/pending/{{ $banner->ads_banner_id }}'>Pending</a>
                                                <a class="dropdown-item text-danger" href="update-ads-banner-status/reject/{{ $banner->ads_banner_id }}">Reject</a>
                                                <a class="dropdown-item" href="ad-banner-details/{{ $banner->ads_banner_id }}" >View Details</a>
                                            </div>
                                        </div>
                                        <!-- dropdown //end -->
                                    </td>
                                </tr>
                                @endforeach
                                <?php }?>
                               
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



@endsection