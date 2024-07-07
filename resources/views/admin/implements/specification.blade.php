@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
?>


            <section class="content-main">
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Specification</h2>
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
                                <form  method="post" action="{{url('krishi-implements-specification-submit')}}" enctype="multipart/form-data">
                                @csrf
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Brand Name</label>
                                        <select class="form-select" name="brand" id="brand" onChange="brand_change(this.value)">
                                            <option value="">Select</option>
                                            <?php
                                            $brand_arr = DB::table('brand')->where(['status'=>1,'category_id'=>5])->get();
                                            foreach ($brand_arr as $val_b) { ?>
                                                <option value="<?= $val_b->id?>"><?= $val_b->name?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Model</label>
                                        <select class="form-select" name="model" id="model">
                                            
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="product_slug" class="form-label">Specification Label</label>
    	                                <input type="text" placeholder="Type here" class="form-control" id="specification" name="specification" />
    	                                @error('specification')
                                        <div class="" style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="product_slug" class="form-label">Value</label>
    	                                <input type="text" placeholder="Type here" class="form-control" id="value" name="value" />
    	                                @error('value')
                                        <div class="" style="color:red">{{ $message }}</div>
                                        @enderror
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
                                                <th>Brand</th>
                                                <th>Model</th>
                                                <th>Specification</th>
                                                <th>Value</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;?>
                                            @foreach ($get as $val)
                                            <tr>
                                                <td><?= $i;?></td>
                                                <td><?php 
                                                $data_m = DB::table('model')->where(['id'=>$val->model_id])->first();
                                                $data_m->brand_id;
                                                $data_b = DB::table('brand')->where(['id'=>$data_m->brand_id])->first();
                                                echo $data_b->name;
                                                ?></td>
                                                <td><?php 
                                                $data_m = DB::table('model')->where(['id'=>$val->model_id])->first();
                                                echo $data_m->model_name;
                                                ?></td>
                                                <td>{{$val->spec_name}}</td>
                                                <td>{{$val->value}}</td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{url('krishi-implements-specification-edit/'.$val->id)}}">Edit info</a>
                                                            <a class="dropdown-item text-danger" href="{{url('krishi-implements-specification-delete/'.$val->id)}}">Delete</a>
                                                        </div>
                                                    </div>
                                                    <!-- dropdown //end -->
                                                </td>
                                            </tr>
                                            <?php $i++;?>
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
<script>

function brand_change(x) {
                //e.preventDefault();

var brand_id = x;
//alert(brand_id);
//var formData = new FormData($(this)[0]);
	
	$.ajax({
		url:"/brand-to-model",
		type:"POST",
		data:{
		    "_token": "{{ csrf_token() }}",
		    brand_id:brand_id
		    
		},
		success:function(response){
		    //alert(response);
		    
		    if (response) {
		        $('#model').html(response);
		    } 
        
        },
		

	});
}
</script>
@endsection