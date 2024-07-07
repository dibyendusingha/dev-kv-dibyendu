
@extends('admin.layout.main')
@section('page-container')

<?php
use Illuminate\Support\Facades\DB;
?>
<?php 
// print_r($subscribed_boots);
?>

<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">Product Boots List</h2>
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
                                    <th>Subscription Boots Plan Name</th>
                                    <th>User Name</th>
                                    <th>User Mobile</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Purchase Price</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                               
                            </thead>

                            <tbody class="mb-5">
                                <?php if(!empty($subscribed_boots)){?>
                                @foreach($subscribed_boots as $boots)
                                <?php 
                                    $subscription_boots_plan_name = DB::table('subscription_boosts')->where('id',$boots->subscription_boosts_id)->first()->name;
                                    $user_count = DB::table('user')->where('id',$boots->user_id)->count();
                                    if($user_count > 0){
                                        $user_details = DB::table('user')->where('id',$boots->user_id)->first();
                                        $user_name   =  $user_details->name;
                                        $user_mobile =  $user_details->mobile;
                                    }else{
                                        $user_name   = 'N/A';
                                        $user_mobile = 'N/A';

                                    } 
                                ?>
                                <tr>
                                    <td>{{$boots->id}}</td>
                                    <td>{{$subscription_boots_plan_name}}</td>
                                    <?php if($user_name != null){?>
                                        <td>{{$user_name}}</td>
                                    <?php }else{?>
                                        <td>N/A</td>
                                    <?php }?>

                                    <?php if($user_mobile != null){?>
                                        <td>{{$user_mobile}}</td>
                                    <?php }else{?>
                                        <td>N/A</td>
                                    <?php }?>

                                    <td>{{$boots->start_date}}</td>
                                    <td>{{$boots->end_date}}</td>
                                    <td>{{$boots->purchased_price}}</td>
                                    <?php
                                    if(!empty($boots->category_id)){
                                        $subscription_category = DB::table('category')->where('id',$boots->category_id)->first()->category;
                                    }else{
                                        $subscription_category = "N/A";
                                    }
                                         
                                    ?>
                                    <td>{{$subscription_category}}</td>
                                    <?php if($boots->status == 1){ ?>
                                    <td>
                                        <span class="bg-success rounded p-1 text-white">Approved</span>
                                    </td>
                                    <?php } ?>
                                    
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu ">
                                                <a class="dropdown-item" href='subscription-boots-details/{{$boots->id}}'>View Details</a>
                                              
                                            </div>
                                        </div>
                                        <!-- dropdown //end -->
                                    </td>
                                </tr>
                                @endforeach
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="10"></td>
                                    </tr>
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



@endsection