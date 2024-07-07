@extends('admin.layout.main')
@section('page-container')


            <section class="content-main">
                <div class="content-header d-flex justify-content-between">
                    <div>
                        <h2 class="content-title card-title">Season Crop</h2>
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

                                <form method="post" action="{{url('krishi-update-seasons-crop',$season_Crop_edit->id)}}" enctype="multipart/form-data">
                                 @csrf
                                 <div class="mb-4">
                                        <label for="product_name" class="form-label">Season Name</label>
                                        <!-- <input type="text" placeholder="Type here" class="form-control" id="brand_name" name="brand_name" /> -->
                                        <select class="form-control" id="brand_name" name="season_id">
                                            <option value="">-- select --</option>
                                            @foreach($season_data as $data)
                                            <option value="{{$data->id}}" {{ $season_Crop_edit->season_id == $data->id ? 'selected' : '' }}>{{$data->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('brand_name')
                                        <div class="" style="color:red"></div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Season Crop Name</label>
                                        <input type="text" placeholder="Type here" class="form-control" id="brand_name" name="cropName" value="{{$season_Crop_edit->cropName}}" />
                                        @error('brand_name')
                                        <div class="" style="color:red"></div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="product_slug" class="form-label">Season Crop Image</label>
    	                                <img src="{{asset('storage/crop_calender/'.$season_Crop_edit->image) }}" alt="" />
	                                    <input class="form-control" type="file" name="image"/>

                                    </div>



                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">UPDATE</button>
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
                                                <th>Season Name</th>
                                                <th>Season Crop Name</th>
                                                <th>Season Crop Image</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="mb-5">
                                            @foreach($season_crop_data as $data)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" />
                                                    </div>
                                                </td>

                                                <td>{{$data->get_season->name}}</td>
                                                <td>{{$data->cropName}}</td>
                                                <td><img src="{{asset('storage/crop_calender/'.$data->image) }}" class="img-sm img-avatar" alt=""></td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu ">
                                                            <!-- <a class="dropdown-item" href="">Edit info</a> -->
                                                            <a class="dropdown-item" href="">Deactivate</a>
                                                            <a class="dropdown-item text-danger" href="">Delete</a>
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
            </section>

@endsection
