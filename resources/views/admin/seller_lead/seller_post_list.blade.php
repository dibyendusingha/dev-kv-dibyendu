@extends('admin.layout.main')
@section('page-container')

<?php 
    $url = Request::path();
    $parts = explode('/', $url);
   echo $category_id = end($parts);

?>
<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title fs-5">SELLER POST LIST</h2>
        </div>
    </div>
    <div class="card-body">
        <div class="card mb-4">
            
            <!-- card-header end// -->
            <div class="card-body" id="table">
                <div class="table-responsive">
                    <table class="datatable-init-export nk-tb-list nk-tb-ulist table table-hover"
                        data-auto-responsive="false" data-export-title="Export">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col">Sl No</th>
                                <th class="nk-tb-col">Product Name</th>
                                <th class="nk-tb-col">Product Image</th>
                                <th class="nk-tb-col">Date</th>
                                <th class="nk-tb-col tb-col-mb">User Name</th>
                                <th class="nk-tb-col tb-col-mb">User Type</th>
                                <th class="nk-tb-col tb-col-mb">User Mobile</th>
                                <th class="nk-tb-col tb-col-mb">Address</th>
                                <th class="nk-tb-col tb-col-mb">Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_tbody">
                            @foreach($sellerList as $key => $seller)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$seller->title}}</td>
                                <td>
                                    <?php if($category_id == 1){ ?>
                                        <img src="{{asset('storage/tractor/'.$seller->image)}}" alt="" class="rounded-circle" width="100" height="100">
                                    <?php }else if($category_id == 3){ ?>
                                        <img src="{{asset('storage/goods_vehicle/'.$seller->image)}}" alt="" class="rounded-circle" width="100" height="100">
                                    <?php }else if($category_id == 4){ ?>
                                        <img src="{{asset('storage/harvester/'.$seller->image)}}" alt="" class="rounded-circle" width="100" height="100">
                                    <?php }else if($category_id == 5){ ?>
                                        <img src="{{asset('storage/implements/'.$seller->image)}}" alt="" class="rounded-circle" width="100" height="100">
                                    <?php }else if($category_id == 6){ ?>
                                        <img src="{{asset('storage/seeds/'.$seller->image)}}" alt="" class="rounded-circle" width="100" height="100">
                                    <?php }else if($category_id == 7){ ?>
                                        <img src="{{asset('storage/tyre/'.$seller->image)}}" alt="" class="rounded-circle" width="100" height="100">
                                    <?php }else if($category_id == 8){ ?>
                                        <img src="{{asset('storage/pesticides/'.$seller->image)}}" alt="" class="rounded-circle" width="100" height="100">
                                    <?php }else if($category_id == 9){ ?>
                                        <img src="{{asset('storage/fertilizers/'.$seller->image)}}" alt="" class="rounded-circle" width="100" height="100">
                                    <?php }else if($category_id == 12){ ?>
                                        <img src="{{asset('storage/crops/'.$seller->image)}}" alt="" class="rounded-circle" width="100" height="100">
                                    <?php } ?>

                                </td>
                                <td>{{$seller->created_at}}</td>
                                <td>{{$seller->name}}</td>

                                <td><span class="badge rounded-pill alert-<?php if ($seller->user_type_id == 2) {
                                                                                echo 'success';
                                                                            } else if ($seller->user_type_id == 3) {
                                                                                echo 'warning';
                                                                            } else if ($seller->user_type_id == 4) {
                                                                                echo 'secondary';
                                                                            } else {
                                                                                echo 'danger';
                                                                            } ?>">
                                        <?php if ($seller->user_type_id == 2) {
                                            echo 'Seller';
                                        } else if ($seller->user_type_id == 3) {
                                            echo 'Dealer';
                                        } else if ($seller->user_type_id == 4) {
                                            echo 'Exchanger';
                                        } ?>
                                    </span>
                                </td>
                                <td>{{$seller->mobile}}</td>
                                <td>
                                    {{$seller->state_name}}<br>
                                    {{$seller->district_name}} , {{$seller->city_name}}, {{$seller->zipcode}}
                                </td>
                              
                                <td>
                                    <?php if($seller->status == 1){ ?>
                                        <span class="badge rounded-pill alert-success">Active </span>
                                    <?php }else if($seller->status == 4){ ?>
                                        <span class="badge rounded-pill alert-danger">Sold </span>
                                    <?php }else{ ?>
                                        <span class="badge rounded-pill alert-warning">Pending </span>
                                    <?php } ?>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown"
                                            class="btn btn-light rounded btn-sm font-sm"> <i
                                                class="material-icons md-more_horiz"></i> </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{url('seller-lead-list',$seller->seller_id)}}">View leads
                                            </a>
                                            <!--<a class="dropdown-item text-danger" href="http://127.0.0.1:8000/krishi-tractor-post-delete/51">Delete</a>-->
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
        <nav>
            {{$sellerList->links()}}
        </nav>
    </div>

</section>



@endsection