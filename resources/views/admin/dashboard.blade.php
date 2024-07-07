@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
?>

            <section class="content-main">
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Dashboard</h2>
                        <p>Whole data about your business here</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card card-body mb-4">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-monetization_on"></i></span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">Total Posts</h6>
                                    <span>
                                    <?php 
                                    $tractor_c = DB::table('tractor')->count();
                                    $goods_vehicle_c = DB::table('goods_vehicle')->count();
                                    $harvester_c = DB::table('harvester')->count();
                                    $implements_c = DB::table('implements')->count();
                                    $seeds_c = DB::table('seeds')->count();
                                    $pesticides_c = DB::table('pesticides')->count();
                                    $fertilizers_c = DB::table('fertilizers')->count();
                                    $tyres_c = DB::table('tyres')->count();
                                    echo $tractor_c+$goods_vehicle_c+$harvester_c+$implements_c+$seeds_c+$pesticides_c+$fertilizers_c+$tyres_c;
                                    ?>
                                    </span>
                                    <span class="text-sm"> In all categories </span>
                                </div>    
                            </article>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-body mb-4">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">Active posts</h6>
                                    <span><?php 
                                    $tractor_c = DB::table('tractor')->where(['status'=>1])->count();
                                    $goods_vehicle_c = DB::table('goods_vehicle')->where(['status'=>1])->count();
                                    $harvester_c = DB::table('harvester')->where(['status'=>1])->count();
                                    $implements_c = DB::table('implements')->where(['status'=>1])->count();
                                    $seeds_c = DB::table('seeds')->where(['status'=>1])->count();
                                    $pesticides_c = DB::table('pesticides')->where(['status'=>1])->count();
                                    $fertilizers_c = DB::table('fertilizers')->where(['status'=>1])->count();
                                    $tyres_c = DB::table('tyres')->where(['status'=>1])->count();
                                    echo $tractor_c+$goods_vehicle_c+$harvester_c+$implements_c+$seeds_c+$pesticides_c+$fertilizers_c+$tyres_c;
                                    ?></span>
                                    <span class="text-sm"> All active posts </span>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-body mb-4">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-qr_code"></i></span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">Pending Posts</h6>
                                    <span><?php 
                                    $tractor_c = DB::table('tractor')->where(['status'=>0])->count();
                                    $goods_vehicle_c = DB::table('goods_vehicle')->where(['status'=>0])->count();
                                    $harvester_c = DB::table('harvester')->where(['status'=>0])->count();
                                    $implements_c = DB::table('implements')->where(['status'=>0])->count();
                                    $seeds_c = DB::table('seeds')->where(['status'=>0])->count();
                                    $pesticides_c = DB::table('pesticides')->where(['status'=>0])->count();
                                    $fertilizers_c = DB::table('fertilizers')->where(['status'=>0])->count();
                                    $tyres_c = DB::table('tyres')->where(['status'=>0])->count();
                                    echo $tractor_c+$goods_vehicle_c+$harvester_c+$implements_c+$seeds_c+$pesticides_c+$fertilizers_c+$tyres_c;
                                    ?></span>
                                    <span class="text-sm"> In all categories </span>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-body mb-4">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-info-light"><i class="text-info material-icons md-shopping_basket"></i></span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">Total Subscribers</h6>
                                    <span>
                                    <?php
                                    echo DB::table('user')->where(['status'=>1])->count();
                                    ?></span>
                                    <span class="text-sm"> All active users </span>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="card mb-4">
                    <header class="card-header">
                        <h4 class="card-title">Latest Posts</h4>
                        <div class="row align-items-center">
                            <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                                <div class="custom_select">
                                    <select class="form-select select-nice" id="category" onChange="category(this.value)">
                                        <option value="Tractor" selected>Tractor</option>
                                        <option value="Goods Vehicle">Goods Vehicle</option>
                                        <option value="Harvester">Harvester</option>
                                        <option value="Tyre">Tyre</option>
                                        <option value="Seeds">Seeds</option>
                                        <option value="Implements">Implements</option>
                                        <option value="Pesticides">Pesticides</option>
                                        <option value="Fertilizers">Fertilizers</option>
                                    </select>
                                </div>
                            </div>
                            
                            
                        </div>
                    </header>
                    
                    
                    <div class="card-body" id="tractor_data" style="display:block;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle" scope="col">Date</th>
                                            <th class="align-middle" scope="col">Title</th>
                                            <th class="align-middle" scope="col">Category</th>
                                            <th class="align-middle" scope="col">Status</th>
                                            <th class="align-middle" scope="col">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tractor_data = DB::table('tractor')->orderBy('id','desc')->skip(0)->take(20)->get();
                                        foreach ($tractor_data as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $val->created_at;?></td>
                                            <td>
                                            <?php
                                            $brand = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                                            echo $brand->name.' ';
                                            $model = DB::table('model')->where(['id'=>$val->model_id])->first();
                                            echo $model->model_name;
                                            ?>
                                            </td>
                                            
                                            <td>Tractor</td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-<?php if ($val->status==0) {echo 'warning';} else if ($val->status==1) {echo 'success';} else {echo 'danger';}?>"><?php if ($val->status==0) {echo 'Pending';} else if ($val->status==1) {echo 'Approved';} else {echo 'Rejected';}?></span>
                                            </td>
                                            <td>
                                                <a href="{{ url('krishi-tractor-post-view/'.$val->id)}}" class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                    
                    <div class="card-body" id="gv_data" style="display:none;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle" scope="col">Date</th>
                                            <th class="align-middle" scope="col">Title</th>
                                            <th class="align-middle" scope="col">Category</th>
                                            <th class="align-middle" scope="col">Status</th>
                                            <th class="align-middle" scope="col">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tractor_data = DB::table('goods_vehicle')->orderBy('id','desc')->skip(0)->take(20)->get();
                                        foreach ($tractor_data as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $val->created_at;?></td>
                                            <td><?php
                                            $brand = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                                            echo $brand->name.' ';
                                            $model = DB::table('model')->where(['id'=>$val->model_id])->first();
                                            echo $model->model_name;
                                            ?>
                                            </td>
                                            <td>Goods Vehicle</td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-<?php if ($val->status==0) {echo 'warning';} else if ($val->status==1) {echo 'success';} else {echo 'danger';}?>"><?php if ($val->status==0) {echo 'Pending';} else if ($val->status==1) {echo 'Approved';} else {echo 'Rejected';}?></span>
                                            </td>
                                            <td>
                                                <a href="{{ url('krishi-gv-post-view/'.$val->id)}}" class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                    
                    <div class="card-body" id="hervester_data" style="display:none;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle" scope="col">Date</th>
                                            <th class="align-middle" scope="col">Title</th>
                                            
                                            <th class="align-middle" scope="col">Category</th>
                                            <th class="align-middle" scope="col">Status</th>
                                            <th class="align-middle" scope="col">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tractor_data = DB::table('harvester')->orderBy('id','desc')->skip(0)->take(20)->get();
                                        foreach ($tractor_data as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $val->created_at;?></td>
                                            <td><?php
                                            $brand = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                                            echo $brand->name.' ';
                                            $model = DB::table('model')->where(['id'=>$val->model_id])->first();
                                            echo $model->model_name;
                                            ?>
                                            </td>
                                            
                                            <td>Harvester</td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-<?php if ($val->status==0) {echo 'warning';} else if ($val->status==1) {echo 'success';} else {echo 'danger';}?>"><?php if ($val->status==0) {echo 'Pending';} else if ($val->status==1) {echo 'Approved';} else {echo 'Rejected';}?></span>
                                            </td>
                                            <td>
                                                <a href="{{ url('krishi-harvester-post-view/'.$val->id)}}" class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                    
                    <div class="card-body" id="implements_data" style="display:none;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle" scope="col">Date</th>
                                            <th class="align-middle" scope="col">Title</th>
                                            
                                            <th class="align-middle" scope="col">Category</th>
                                            <th class="align-middle" scope="col">Status</th>
                                            <th class="align-middle" scope="col">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tractor_data = DB::table('implements')->orderBy('id','desc')->skip(0)->take(20)->get();
                                        foreach ($tractor_data as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $val->created_at;?></td>
                                            <td><?php
                                            $brand = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                                            echo $brand->name.' ';
                                            $model = DB::table('model')->where(['id'=>$val->model_id])->first();
                                            echo $model->model_name;
                                            ?>
                                            </td>
                                            
                                            <td>Implements</td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-<?php if ($val->status==0) {echo 'warning';} else if ($val->status==1) {echo 'success';} else {echo 'danger';}?>"><?php if ($val->status==0) {echo 'Pending';} else if ($val->status==1) {echo 'Approved';} else {echo 'Rejected';}?></span>
                                            </td>
                                            <td>
                                                <a href="{{ url('krishi-implements-post-view/'.$val->id)}}" class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                    
                    <div class="card-body" id="tyre_data" style="display:none;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle" scope="col">Date</th>
                                            <th class="align-middle" scope="col">Title</th>
                                            
                                            <th class="align-middle" scope="col">Category</th>
                                            <th class="align-middle" scope="col">Status</th>
                                            <th class="align-middle" scope="col">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tractor_data = DB::table('tyres')->orderBy('id','desc')->skip(0)->take(20)->get();
                                        foreach ($tractor_data as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $val->created_at;?></td>
                                            <td><?php
                                            $brand = DB::table('brand')->where(['id'=>$val->brand_id])->first();
                                            echo $brand->name.' ';
                                            $model = DB::table('model')->where(['id'=>$val->model_id])->first();
                                            echo $model->model_name;
                                            ?>
                                            </td>
                                            <td>Tyres</td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-<?php if ($val->status==0) {echo 'warning';} else if ($val->status==1) {echo 'success';} else {echo 'danger';}?>"><?php if ($val->status==0) {echo 'Pending';} else if ($val->status==1) {echo 'Approved';} else {echo 'Rejected';}?></span>
                                            </td>
                                            <td>
                                                <a href="{{ url('krishi-tyre-post-view/'.$val->id)}}" class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                    
                    <div class="card-body" id="seed_data" style="display:none;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle" scope="col">Date</th>
                                            <th class="align-middle" scope="col">Title</th>
                                            
                                            <th class="align-middle" scope="col">Category</th>
                                            <th class="align-middle" scope="col">Status</th>
                                            <th class="align-middle" scope="col">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tractor_data = DB::table('seeds')->orderBy('id','desc')->skip(0)->take(20)->get();
                                        foreach ($tractor_data as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $val->created_at;?></td>
                                            <td><?= $val->title;
                                            ?>
                                            </td>
                                            
                                            <td>Seeds</td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-<?php if ($val->status==0) {echo 'warning';} else if ($val->status==1) {echo 'success';} else {echo 'danger';}?>"><?php if ($val->status==0) {echo 'Pending';} else if ($val->status==1) {echo 'Approved';} else {echo 'Rejected';}?></span>
                                            </td>
                                            <td>
                                                <a href="{{ url('krishi-seeds-post-view/'.$val->id)}}" class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                    
                    <div class="card-body" id="pesticides_data" style="display:none;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle" scope="col">Date</th>
                                            <th class="align-middle" scope="col">Title</th>
                                            
                                            <th class="align-middle" scope="col">Category</th>
                                            <th class="align-middle" scope="col">Status</th>
                                            <th class="align-middle" scope="col">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tractor_data = DB::table('pesticides')->orderBy('id','desc')->skip(0)->take(20)->get();
                                        foreach ($tractor_data as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $val->created_at;?></td>
                                            <td><?= $val->title;
                                            ?>
                                            </td>
                                           
                                            <td>Pesticides</td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-<?php if ($val->status==0) {echo 'warning';} else if ($val->status==1) {echo 'success';} else {echo 'danger';}?>"><?php if ($val->status==0) {echo 'Pending';} else if ($val->status==1) {echo 'Approved';} else {echo 'Rejected';}?></span>
                                            </td>
                                            <td>
                                                <a href="{{ url('krishi-pesticides-post-view/'.$val->id)}}" class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                    
                    <div class="card-body" id="fertilizer_data" style="display:none;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle" scope="col">Date</th>
                                            <th class="align-middle" scope="col">Title</th>
                                            
                                            <th class="align-middle" scope="col">Category</th>
                                            <th class="align-middle" scope="col">Status</th>
                                            <th class="align-middle" scope="col">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tractor_data = DB::table('fertilizers')->orderBy('id','desc')->skip(0)->take(20)->get();
                                        foreach ($tractor_data as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $val->created_at;?></td>
                                            <td><?= $val->title;
                                            ?>
                                            </td>
                                            
                                            <td>Fertilizers</td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-<?php if ($val->status==0) {echo 'warning';} else if ($val->status==1) {echo 'success';} else {echo 'danger';}?>"><?php if ($val->status==0) {echo 'Pending';} else if ($val->status==1) {echo 'Approved';} else {echo 'Rejected';}?></span>
                                            </td>
                                            <td>
                                                <a href="{{ url('krishi-fertilizers-post-view/'.$val->id)}}" class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                    
                </div>
                
            </section>
            
            
            <script>
                function category1 (x) {
                    var post_type = $('#post_type').val();
                	$.ajax({
                		url:"/dashboard-data",
                		type:"POST",
                		data:{
                		    "_token": "{{ csrf_token() }}",
                		    category:x,
                		    post_type:post_type
                		    
                		},
                		success:function(response){
                		    //alert(response);
                		    
                		    if (response) {
                		        //$('#model').html(response);
                		    } 
                        
                        },
                		
                
                	});  
                }
                
                function category (x) {
                    
                    if (x=='Tractor') {
                        $('#post_type').css('display','block');
                        $('#tractor_data').css('display','block');
                        $('#gv_data').css('display','none');
                        $('#hervester_data').css('display','none');
                        $('#implements_data').css('display','none');
                        $('#tyre_data').css('display','none');
                        $('#seed_data').css('display','none');
                        $('#pesticides_data').css('display','none');
                        $('#fertilizer_data').css('display','none');
                    }
                    else if (x=='Goods Vehicle') {
                        $('#post_type').css('display','block');
                        $('#tractor_data').css('display','none');
                        $('#gv_data').css('display','block');
                        $('#hervester_data').css('display','none');
                        $('#implements_data').css('display','none');
                        $('#tyre_data').css('display','none');
                        $('#seed_data').css('display','none');
                        $('#pesticides_data').css('display','none');
                        $('#fertilizer_data').css('display','none');
                    }
                    else if (x=='Harvester') {
                        $('#post_type').css('display','block');
                        $('#tractor_data').css('display','none');
                        $('#gv_data').css('display','none');
                        $('#hervester_data').css('display','block');
                        $('#implements_data').css('display','none');
                        $('#tyre_data').css('display','none');
                        $('#seed_data').css('display','none');
                        $('#pesticides_data').css('display','none');
                        $('#fertilizer_data').css('display','none');
                    }
                    else if (x=='Implements') {
                        $('#post_type').css('display','block');
                        $('#tractor_data').css('display','none');
                        $('#gv_data').css('display','none');
                        $('#hervester_data').css('display','none');
                        $('#implements_data').css('display','block');
                        $('#tyre_data').css('display','none');
                        $('#seed_data').css('display','none');
                        $('#pesticides_data').css('display','none');
                        $('#fertilizer_data').css('display','none');
                    }
                    else if (x=='Tyre') {
                        $('#post_type').css('display','block');
                        $('#tractor_data').css('display','none');
                        $('#gv_data').css('display','none');
                        $('#hervester_data').css('display','none');
                        $('#implements_data').css('display','none');
                        $('#tyre_data').css('display','block');
                        $('#seed_data').css('display','none');
                        $('#pesticides_data').css('display','none');
                        $('#fertilizer_data').css('display','none');
                    }
                    else if (x=='Seeds') {
                        $('#post_type').css('display','none');
                        $('#tractor_data').css('display','none');
                        $('#gv_data').css('display','none');
                        $('#hervester_data').css('display','none');
                        $('#implements_data').css('display','none');
                        $('#tyre_data').css('display','none');
                        $('#seed_data').css('display','block');
                        $('#pesticides_data').css('display','none');
                        $('#fertilizer_data').css('display','none');
                    }
                    else if (x=='Pesticides') {
                        $('#post_type').css('display','none');
                        $('#tractor_data').css('display','none');
                        $('#gv_data').css('display','none');
                        $('#hervester_data').css('display','none');
                        $('#implements_data').css('display','none');
                        $('#tyre_data').css('display','none');
                        $('#seed_data').css('display','none');
                        $('#pesticides_data').css('display','block');
                        $('#fertilizer_data').css('display','none');
                    }
                    else if (x=='Fertilizers') {
                        $('#post_type').css('display','none');
                        $('#tractor_data').css('display','none');
                        $('#gv_data').css('display','none');
                        $('#hervester_data').css('display','none');
                        $('#implements_data').css('display','none');
                        $('#tyre_data').css('display','none');
                        $('#seed_data').css('display','none');
                        $('#pesticides_data').css('display','none');
                        $('#fertilizer_data').css('display','block');
                    }
                    
                }
                
            </script>
            
@endsection
