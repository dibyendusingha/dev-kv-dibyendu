
<?php 

?>
@extends('admin.layout.main')
@section('page-container')


<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">Promotion List</h2>
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
                                    <th>User Name</th>
                                    <th>User Mobile</th>
                                    <th>Coupon Code</th>
                                    <th>Due Status</th>
                                    <th>Date</th>
                                    <th class="text-end">Action</th>
                                </tr>  
                            </thead>

                            <tbody class="mb-5">

                                @foreach($promotion_list as $key => $promotion)
                                
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$promotion->name}}</td>
                                    <td>{{$promotion->mobile}}</td>
                                    <td>{{$promotion->coupon_code}}</td>   
                                    <td>
                                        <?php if($promotion->due_amount == 0){ ?>
                                        <span class="bg-success text-white p-1 rounded-pill">Cleared</span>
                                        <?php }else if($promotion->due_amount > 0){ ?>
                                        <span class="bg-danger text-white py-1 px-3 rounded-pill">Due</span>
                                        <?php } ?>
                                    </td> 
                                    <td>
                                        <?php 
                                          $date = date_create($promotion->created_at);
                                          $create_date   = date_format($date, "d/m/Y");
                                        ?>
                                        {{$create_date}}
                                    </td> 
                                                  
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu ">
                                            <a class="dropdown-item" href='/single-promotion/{{$promotion->id}}'>View Details</a>
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