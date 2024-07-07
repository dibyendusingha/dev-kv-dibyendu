@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
?>
            <section class="content-main">
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Model</h2>
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
                                <form method="post" action="{{url('krishi-implements-model-submit')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Brand Name</label>
                                        <select class="form-select" name="brand_id">
                                            <?php
                                            $brand_arr = DB::table('brand')->where(['category_id'=>5])->get();
                                            print_r($brand_arr);
                                            foreach ($brand_arr as $val) { ?>
                                                <option value="<?= $val->id; ?>"><?= $val->name; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Model</label>
                                        <input type="text" placeholder="Type here" class="form-control" id="model" name="model" />
                                        @error('model')
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
                                                <th>Model</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;?>
                                            @foreach ($get as $val_m)

                                            <?php 
                                                // echo $i;
                                                // echo '<br />';
                                                // echo $val_m->id;
                                                // echo env('APP_URL')."storage/images/model/$val_m->icon";
                                                // echo '<br />';
                                            ?>
                                            <tr>
                                                <td><?= $i;?></td>
                                                <td><img src="<?= env('APP_URL')."storage/images/model/$val_m->icon";?>" class="img-sm img-avatar" alt=""></td>
                                                <td><?php 
                                                $count = DB::table('brand')->where(['id'=>$val_m->brand_id])->count();
                                                if ($count>0) {
                                                $c_data = DB::table('brand')->where(['id'=>$val_m->brand_id])->first();
                                                echo $c_data->name;
                                                } else {
                                                    echo 'Bad';
                                                }
                                                ?></td>
                                                <td>{{$val_m->model_name}}</td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{url('krishi-implements-model-edit/'.$val_m->id)}}">Edit info</a>
                                                            <a class="dropdown-item text-danger" href="{{url('krishi-implements-model-delete/'.$val_m->id)}}">Delete</a>
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
