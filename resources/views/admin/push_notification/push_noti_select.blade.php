@extends('admin.layout.main')
@section('page-container')

<?php
use Illuminate\Support\Facades\DB;
?>


            <section class="content-main">
                <div class="content-header d-flex justify-content-between">
                    <div>
                        <h2 class="content-title card-title">Select State and District for push notification</h2>
                        <p>Add, edit or delete</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                  {{ session('success') }}
                                </div>
                            @elseif(session('failed'))
                                <div class="alert alert-danger" role="alert">
                                  {{ session('failed') }}
                                </div>
                            @endif
                            <div class="col-md-3">

                                <form method="post" action="#" enctype="multipart/form-data">

                                    <div class="mb-4">
                                        <label for="product_slug" class="form-label">Select State</label>
	                                    <!-- <input class="form-control" type="input" name="category"/> -->
                                        <select class="form-control" name="category">
                                            <option value="">-- select --</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                            <option value="4">Four</option>
                                        </select>

                                    </div>

                                    <div class="mb-4">
                                        <label for="product_slug form-control" class="form-label">Select District</label>
	                                    
                                       <select class="js-example-basic-multiple form-control" name="states[]" multiple="multiple">
                                          <option value="AL">Alabama</option>
                                          <option value="WY">Wyoming</option>
                                        </select>

                                      
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                   Sl No
                                                </th>
                                                <th>State Name</th>
                                                <th>District Name</th>
                                                <th>Status</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>West Bengal</td>
                                                <td>Bnakura</td>
                                                <td>Active</td>
                                                <td>West Bengal</td>
                                            </tr>
                                        </thead>
                                     
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
            </section>

@endsection
