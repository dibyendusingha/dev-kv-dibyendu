@extends('admin.layout.main')
@section('page-container')


            <section class="content-main">
                <div class="content-header d-flex justify-content-between">
                    <div>
                        <h2 class="content-title card-title">Company</h2>
                        <p>Add, edit or delete</p>
                    </div>
                    <div><a href="http://127.0.0.1:8000/dealer-product" class="btn  text-white" style="background: #3bb77e">Product List</a></div>
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

                                <form method="post" action="{{url('krishi-update-company-data',$company_edit->id)}}" enctype="multipart/form-data">
                                 @csrf
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Company Name</label>
                                        <input type="text" placeholder="Type here" class="form-control" id="brand_name" name="name" value="{{$company_edit->name}}" />
                                        @error('brand_name')
                                        <div class="" style="color:red"></div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Company Full Name </label>
                                        <input type="text" placeholder="Type here" class="form-control" id="brand_name_full" name="brand_name_full" value="{{$company_edit->brand_name_full}}"/>
                                        @error('brand_name_full')
                                        <div class="" style="color:red"></div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="product_slug" class="form-label">Company Logo</label>
    	                                <img src="{{asset('storage/company/'.$company_edit->logo) }}" alt="" />
	                                    <input class="form-control" type="file" name="logo"/>

                                    </div>

                                    <div class="mb-4">
                                        <label for="product_slug" class="form-label">Category</label>
	                                    <!-- <input class="form-control" type="input" name="category" value="{{$company_edit->category}}"/> -->
                                        <select class="form-control" type="input" name="category">
                                        @foreach($category_data as $data)
                                            <option value="{{$data->id}}" {{ $company_edit->category == $data->id ? 'selected' : '' }}>{{$data->category}}</option>
                                        @endforeach

                                        </select>

                                    </div>

                                    <div class="mb-4">
                                        <label for="product_slug" class="form-label">Description</label>
	                                    <textarea class="form-control"  name="description">{{$company_edit->description}}</textarea>
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
                                                <th>Company Name</th>
                                                <th>Company Logo</th>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="mb-5">
                                             @foreach($company_data as $data)

                                            <tr>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" />
                                                    </div>
                                                </td>
                                                <td>{{$data->name}}</td>
                                                <td><img src="<?= env('APP_URL')."storage/company/$data->logo"; ?>" class="img-sm img-avatar" alt=""></td>
                                                <td>{{$data->get_category->category}}</td>
                                                <td>{{$data->description}}</td>

                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu ">
                                                            <!-- <a class="dropdown-item" href="krishi-dealer-company-list/{{$data->company_id}}">Dealer List</a>
                                                            <a class="dropdown-item" href="krishi-dealer-product-list">Product List</a> -->
                                                            <!-- <a class="dropdown-item" href="">Edit info</a> -->
                                                            <!-- <a class="dropdown-item" href="">Deactivate</a> -->
                                                            <a class="dropdown-item text-danger" href="krishi-delete-company/{{$data->id}}">Delete</a>
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
