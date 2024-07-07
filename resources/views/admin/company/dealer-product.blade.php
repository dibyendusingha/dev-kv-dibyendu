@extends('admin.layout.main')
@section('page-container')


            <section class="content-main">
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Dealer Product List</h2>
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

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" />
                                                    </div>
                                                </th>
                                                <th>Product Name</th>
                                                <th>Product Image</th>
                                                <th >Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="mb-5">
                                        <?php if(!empty($getProduct)){ ?>
                                            @foreach($getProduct as $data)
                                            <?php //print_r($getProduct); ?>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" />
                                                    </div>
                                                </td>
                                                <td>{{$data->product_name}}</td>
                                                <td>
                                                    <?php
                                                    //DB::table('company')->where(['id'=>$data->company_id])->value('');
                                                    ?>
                                                    @if ($data->company_id==1 || $data->company_id==11 || $data->company_id==12)
                                                    <img src="{{asset('storage/iffco/products/'.$data->product_image) }}" class="img-sm img-avatar" alt="">
                                                    @else 
                                                    <img src="{{asset('storage/company/products/'.$data->product_image) }}" class="img-sm img-avatar" alt="">
                                                    @endif
                                                </td>
                                                <td><span class="badge rounded-pill bg-success"> Active</span></td>
                                            </tr>
                                            @endforeach
                                            <?php }?>

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
