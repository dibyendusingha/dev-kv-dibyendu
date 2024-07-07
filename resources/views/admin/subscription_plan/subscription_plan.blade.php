
@extends('admin.layout.main')
@section('page-container')

<?php
use Illuminate\Support\Facades\DB;
// print_r($subscription_details);
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
                                    <th>Status</th>
                                    
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody class="mb-5">
                               @foreach($subscription_details as $subs)
                                <tr>
                                    <td>{{$subs->id}}</td>
                                    <td>{{$subs->name}}</td>
                                    <td>
                                        @if($subs->status == 1)
                                        <span class="bg-success rounded p-1 text-white">Approved</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu ">
                                                <a class="dropdown-item" href='subscription-feature/{{$subs->id}}'>View Details</a>
                                                
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