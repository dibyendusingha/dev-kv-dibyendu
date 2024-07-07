@extends('admin.layout.main')
@section('page-container')


            <section class="content-main">
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Brands</h2>
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
                                
                                <form method="post" action="{{url('krishi-tyre-brand-submit')}}" enctype="multipart/form-data">
                                 @csrf
                                 <div class="mb-4">
                                        <label for="product_name" class="form-label">Brand Name</label>
                                        <input type="text" placeholder="Type here" class="form-control" id="brand_name" name="brand_name" />
                                        @error('brand_name')
                                        <div class="" style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="product_slug" class="form-label">Icon</label>
    	                                <img src="assets/imgs/theme/upload.svg" alt="" />
	                                    <input class="form-control" type="file" name="file"/>
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
                                               
                                                <th>ID</th>
                                                <th>Icon</th>
                                                <th>Brand Name</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;?>
                                            @foreach ($get as $val)
                                            <tr>
                                                
                                                <td><?= $i;?></td>
                                                <td><img src="<?= env('APP_URL')."storage/images/brands/$val->logo";?>" class="img-sm img-avatar" alt=""></td>
                                                <td>{{$val->name}}</td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ url('krishi-tyre-brand-edit/'.$val->id) }}">Edit info</a>
                                                            <a class="dropdown-item text-danger" href="{{ url('krishi-tyre-brand-delete/'.$val->id) }}">Delete</a>
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