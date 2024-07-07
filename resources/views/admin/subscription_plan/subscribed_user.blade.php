@extends('admin.layout.main')
@section('page-container')

<?php

use Illuminate\Support\Facades\DB;
//echo '<pre>';
//print_r($subscribed_details);
?>

<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">Banner Subscription User List</h2>
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
                                    <th>SL No</th>
                                    <th>User Name</th>
                                    <th>Subscription Plan</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Purchased Amount</th>
                                    <th>Invoice No</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody class="mb-5">
                                <?php
                                if (count($subscribed_details) > 0) {
                                    $i = 1;
                                    foreach ($subscribed_details as $details) {
                                ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $details->user_name}}</td>
                                            <td>{{ $details->subscription_name}}</td>
                                            <td>{{ $details->start_date}}</td>
                                            <td>{{ $details->end_date}}</td>
                                            <td>{{ $details->price}}</td>
                                            <td>{{ $details->invoice_no}}</td>
                                            <td><span class="bg-success rounded p-1 text-white">Active</span></td>
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                    <div class="dropdown-menu ">
                                                        <a class="dropdown-item" href="{{ url('subscribed-user-details',$details->id)}}">View Details</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                        $i++;
                                    }
                                }
                                ?>
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