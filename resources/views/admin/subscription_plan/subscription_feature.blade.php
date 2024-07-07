
@extends('admin.layout.main')
@section('page-container')

<?php
use Illuminate\Support\Facades\DB;
// print_r($subscription_feature_details);
?>

<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">Subscribed User List</h2>
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
                                    <th>Sl No</th>
                                    <th>Subscription Plan Name</th>
                                    <th>Days</th>
                                    <th>Price</th>
                                    <th>Website</th>
                                    <th>Mobile</th>
                                    <th>sub Category</th>
                                    <th>Category</th>
                                    <th>listing</th>
                                    <th>state Count </th>
                                    <th>Creatives </th>
                                    <th>Status</th>  
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody class="mb-5">
                               @foreach($subscription_feature_details as $subsf)
                               <?php 
                                $subscription = DB::table('subscriptions')->where('id',$subsf->subscription_id)->first();
                                ?>
                                <tr>
                                    <td>{{$subsf->id}}</td>
                                    <td>{{$subscription->name}}</td>
                                    <td>{{$subsf->days}}</td>
                                    <td>{{$subsf->price}}</td>
                                    <td>
                                        <?php if($subsf->website == 'N'){?>
                                            NO
                                        <?php }else{ ?>
                                            Yes
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if($subsf->mobile == 'N'){?>
                                            NO
                                        <?php }else{ ?>
                                            Yes
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if($subsf->sub_category == 'N'){?>
                                            NO
                                        <?php }else{ ?>
                                            Yes
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if($subsf->category == 'N'){?>
                                            NO
                                        <?php }else{ ?>
                                            Yes
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if($subsf->listing == 'N'){?>
                                            NO
                                        <?php }else{ ?>
                                            Yes
                                        <?php }?>
                                    </td>
                                    <td>{{$subsf->creatives}}</td>
                                    <td>{{$subsf->state}}</td>
                                   
                                    <td>
                                        <?php if($subsf->status == 1){ ?>
                                            <span class="bg-success rounded p-1 text-white">Approved</span>
                                        <?php }else{?>
                                            <span class="bg-danger rounded p-1 text-white">Reject</span>
                                            <?php }?>
                                    </td>
                                    
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu ">
                                                <a class="dropdown-item" href='#'>Edit</a>
                                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</a>
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
                <!-- .col// -->
            </div>
            <!-- .row // -->
        </div>
        <!-- card body .// -->
    </div>
    <!-- card .// -->

    <!-- Delete Modal -->



@endsection