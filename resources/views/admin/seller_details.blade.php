@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
?>

            <section class="content-main">
                <div class="content-header">
                    <a href="javascript:history.back()"><i class="material-icons md-arrow_back"></i> Go back </a>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-brand-2" style="height: 150px"></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl col-lg flex-grow-0" style="flex-basis: 230px">
                                <div class="img-thumbnail shadow w-100 bg-white position-relative text-center" style="height: 190px; width: 200px; margin-top: -120px">
                                    <img src="<?= env('APP_URL')."storage/photo/".$user_data->photo;?>" class="center-xy img-fluid" alt="Logo Brand" />
                                </div>
                            </div>
                            <!--  col.// -->
                            <div class="col-xl col-lg">
                                <h3>{{$user_data->name}}</h3>
                                <h5 class="text-success"><?php if ($user_data->user_type_id==1) {echo "Individual";} else {echo "Dealer";}?></h5>
                                <p>GST No. {{$user_data->gst_no}}</p>
                            </div>
                            <!--  col.// -->
                           
                        </div>
                        <!-- card-body.// -->
                        <hr class="my-4" />
                        <div class="row g-4">
                            
                            <div class="col-sm-6 col-lg-4 col-xl-3">
                                <h6>Profile</h6>
                                <p>
                                    {{$user_data->mobile}} <br />
                                    {{$user_data->email}} <br />
                                    DOB : {{$user_data->dob}}
                                </p>
                            </div>
                            <!--  col.// -->
                            <div class="col-sm-6 col-lg-4 col-xl-4">
                                <h6>Address</h6>
                                <p>
                                    {{$user_data->address}}
                                </p>
                            </div>
                            <!--  col.// -->
                            <div class="col-md-12 col-lg-4 col-xl-4">
                                <article class="box">
                                    <p class="mb-0 text-muted"><span class="text-success">Total Posts:</span> 
                                    <?php
                                                    $tractor_count = DB::table('tractor')->where(['user_id'=>$user_data->id])->count();
                                                    $gv_count = DB::table('goods_vehicle')->where(['user_id'=>$user_data->id])->count();
                                                    $harvester_count = DB::table('harvester')->where(['user_id'=>$user_data->id])->count();
                                                    $implement_count = DB::table('implements')->where(['user_id'=>$user_data->id])->count();
                                                    $seed_count = DB::table('seeds')->where(['user_id'=>$user_data->id])->count();
                                                    $pesticide_count = DB::table('pesticides')->where(['user_id'=>$user_data->id])->count();
                                                    $fertilizer_count = DB::table('fertilizers')->where(['user_id'=>$user_data->id])->count();
                                                    $tyre_count = DB::table('tyres')->where(['user_id'=>$user_data->id])->count();
                                                    echo $tractor_count+$gv_count+$harvester_count+$implement_count+$seed_count+$pesticide_count+$fertilizer_count+$tyre_count;
                                                    ?>
                                    </p>
                                    <p class="mb-0 text-muted"><span class="text-success">Total Leads:</span> 
                                    <?= Lead::where(['post_user_id'=>$user_data->id])->count(); ?>
                                    	<a href="#" class="float-end"> <i class="icons material-icons md-visibility"></i> View</a>
                                    </p>
                                    <p class="mb-0 text-muted"><span class="text-success">Total Enquiry:</span> 
                                    <?= Lead::where(['user_id'=>$user_data->id])->count(); ?>
                                    	<a href="#" class="float-end"> <i class="icons material-icons md-visibility"></i> View</a>
                                    </p>
                                </article>
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
                        <h4 class="card-title">Posts by subscriber</h4>
                        <div class="row">
                           
                            <!-- col.// -->
                            @foreach($tractor_data as $tval)
                            <div class="col-xl-2 col-lg-3 col-md-6">
                                <div class="card card-product-grid">
                                    <a href="{{ url('krishi-tractor-post-view/'.$tval->id)}}" class="img-wrap"> <img src="<?= env('APP_URL')."storage/tractor/".$tval->left_image;?>" alt="Product" /> </a>
                                    <div class="info-wrap">
                                        <a href="{{ url('krishi-tractor-post-view/'.$tval->id)}}" class="title">
                                        <?php $brand_data = DB::table('brand')->where(['id'=>$tval->brand_id])->first(); echo $brand_data->name;?>
                                        </a>
                                        <div class="price mt-1"><?php if ($tval->type=='new') {echo 'New';} else {echo 'Old';}?></div>
                                        <!-- price-wrap.// -->
                                    </div>
                                </div>
                                <!-- card-product  end// -->
                            </div>
                            @endforeach
                            
                            
                            @foreach($goods_vehicle_data as $gval)
                            <div class="col-xl-2 col-lg-3 col-md-6">
                                <div class="card card-product-grid">
                                    <a href="{{ url('krishi-gv-post-view/'.$gval->id)}}" class="img-wrap"> <img src="<?= env('APP_URL')."storage/goods_vehicle/".$gval->left_image;?>" alt="Product" /> </a>
                                    <div class="info-wrap">
                                        <a href="{{ url('krishi-gv-post-view/'.$gval->id)}}" class="title">
                                        <?php $brand_data = DB::table('brand')->where(['id'=>$gval->brand_id])->first(); echo $brand_data->name;?>
                                        </a>
                                        <div class="price mt-1"><?php if ($gval->type=='new') {echo 'New';} else {echo 'Old';}?></div>
                                        <!-- price-wrap.// -->
                                    </div>
                                </div>
                                <!-- card-product  end// -->
                            </div>
                            @endforeach
                            
                            
                            @foreach($harvester_data as $hval)
                            <div class="col-xl-2 col-lg-3 col-md-6">
                                <div class="card card-product-grid">
                                    <a href="{{ url('krishi-harvester-post-view/'.$hval->id)}}" class="img-wrap"> <img src="<?= env('APP_URL')."storage/harvester/".$hval->left_image;?>" alt="Product" /> </a>
                                    <div class="info-wrap">
                                        <a href="{{ url('krishi-harvester-post-view/'.$hval->id)}}" class="title">
                                        <?php $brand_data = DB::table('brand')->where(['id'=>$hval->brand_id])->first(); echo $brand_data->name;?>
                                        </a>
                                        <div class="price mt-1"><?php if ($hval->type=='new') {echo 'New';} else {echo 'Old';}?></div>
                                        <!-- price-wrap.// -->
                                    </div>
                                </div>
                                <!-- card-product  end// -->
                            </div>
                            @endforeach
                            
                            
                            @foreach($implements_data as $ival)
                            <div class="col-xl-2 col-lg-3 col-md-6">
                                <div class="card card-product-grid">
                                    <a href="{{ url('krishi-implements-post-view/'.$ival->id)}}" class="img-wrap"> <img src="<?= env('APP_URL')."storage/implements/".$ival->left_image;?>" alt="Product" /> </a>
                                    <div class="info-wrap">
                                        <a href="{{ url('krishi-implements-post-view/'.$ival->id)}}" class="title">
                                        <?php $brand_data = DB::table('brand')->where(['id'=>$ival->brand_id])->first(); echo $brand_data->name;?>
                                        </a>
                                        <div class="price mt-1"><?php if ($ival->type=='new') {echo 'New';} else {echo 'Old';}?></div>
                                        <!-- price-wrap.// -->
                                    </div>
                                </div>
                                <!-- card-product  end// -->
                            </div>
                            @endforeach
                            
                            
                            @foreach($seeds_data as $sval)
                            <div class="col-xl-2 col-lg-3 col-md-6">
                                <div class="card card-product-grid">
                                    <a href="{{ url('krishi-seeds-post-view/'.$sval->id)}}" class="img-wrap"> <img src="<?= env('APP_URL')."storage/seeds/".$sval->image1;?>" alt="Product" /> </a>
                                    <div class="info-wrap">
                                        
                                        <div class="price mt-1">{{$sval->title}}</div>
                                        <!-- price-wrap.// -->
                                    </div>
                                </div>
                                <!-- card-product  end// -->
                            </div>
                            @endforeach
                            
                            
                            @foreach($pesticides_data as $pval)
                            <div class="col-xl-2 col-lg-3 col-md-6">
                                <div class="card card-product-grid">
                                    <a href="{{ url('krishi-pesticides-post-view/'.$pval->id)}}" class="img-wrap"> <img src="<?= env('APP_URL')."storage/pesticides/".$pval->image1;?>" alt="Product" /> </a>
                                    <div class="info-wrap">
                                        
                                        <div class="price mt-1">{{$pval->title}}</div>
                                        <!-- price-wrap.// -->
                                    </div>
                                </div>
                                <!-- card-product  end// -->
                            </div>
                            @endforeach
                            
                            @foreach($fertilizers_data as $fval)
                            <div class="col-xl-2 col-lg-3 col-md-6">
                                <div class="card card-product-grid">
                                    <a href="{{ url('krishi-fertilizers-post-view/'.$fval->id)}}" class="img-wrap"> <img src="<?= env('APP_URL')."storage/fertilizers/".$fval->image1;?>" alt="Product" /> </a>
                                    <div class="info-wrap">
                                        
                                        <div class="price mt-1">{{$fval->title}}</div>
                                        <!-- price-wrap.// -->
                                    </div>
                                </div>
                                <!-- card-product  end// -->
                            </div>
                            @endforeach
                            
                            @foreach($tyres_data as $tyval)
                            <div class="col-xl-2 col-lg-3 col-md-6">
                                <div class="card card-product-grid">
                                    <a href="{{ url('krishi-tyre-post-view/'.$tyval->id)}}" class="img-wrap"> <img src="<?= env('APP_URL')."storage/tyre/".$tyval->image1;?>" alt="Product" /> </a>
                                    <div class="info-wrap">
                                        <a href="{{ url('krishi-tyre-post-view/'.$tyval->id)}}" class="title">
                                        <?php $brand_data = DB::table('brand')->where(['id'=>$tyval->brand_id])->first(); echo $brand_data->name;?>
                                        </a>
                                        <div class="price mt-1"><?php if ($tyval->type=='new') {echo 'New';} else {echo 'Old';}?></div>
                                        <!-- price-wrap.// -->
                                    </div>
                                </div>
                                <!-- card-product  end// -->
                            </div>
                            @endforeach
                            
                            <!-- col.// -->
                        </div>
                        <!-- row.// -->
                    </div>
                    <!--  card-body.// -->
                </div>
                <!--  card.// -->
                
            </section>
            


@endsection