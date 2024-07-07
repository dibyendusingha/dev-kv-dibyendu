@extends('admin.layout.main')
@section('page-container')


            <section class="content-main">
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Push Notificatio List</h2>
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
                                
                                <form method="post" action="{{url('krishi-tractor-brand-submit')}}" enctype="multipart/form-data">
                                 @csrf
                                 <div class="mb-4">
                                        <label for="product_name" class="form-label">Language</label>
                                       <select class="form-select" aria-label="Default select example">
                                          <option selected>Select Language</option>
                                          <option value="1">English</option>
                                          <option value="2">Bengali</option>
                                          <option value="3">Hindi</option>
                                        </select>
                                       
                                    </div>
                                    <div class="mb-4">
                                        <label for="product_slug" class="form-label">Select Date</label>
    	                                <input type="date" name="notification-date" class="form-control">
	                                    
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
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" />
                                                    </div>
                                                </th>
                                                <th>Date Time</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; ?>
                                            @foreach ($arr as $val) 
                                            <tr>
                                                
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" />
                                                    </div>
                                                </td>
                                                <td>{{$val->date .' '.$val->time}}</td>
                                                <td>{{$val->tiltle}}</td>
                                                <td>{{$val->deception}}</td>
                                                <td><img src="{{$val->img}}" alt="notification-image"/></td>
                                                <td>@if ($val->status==1) <span class="btn btn-success">Sent</span> 
                                                @elseif ($val->status==0) <span class="btn btn-warning">Scheduled</span> 
                                                @elseif ($val->status==3) <span class="btn btn-danger">Rejected</span> 
                                                @endif</td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-danger" href="{{url('push-notification-update/'.$val->id)}}">Update</a>
                                                            <a class="dropdown-item text-danger" href="{{url('push-notification-deactive/'.$val->id)}}">Delete</a>
                                                        </div>
                                                    </div>
                                                    <!-- dropdown //end -->
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
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
            </section>
            
@endsection