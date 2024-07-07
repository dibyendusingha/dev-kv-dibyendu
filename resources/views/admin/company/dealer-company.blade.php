@extends('admin.layout.main')
@section('page-container')


            <section class="content-main">
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Dealer List</h2>
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
                                                <th>Dealer Name</th>
                                                <th>Phone No</th>
                                                <th>Email Id</th>
                                                <th>Status</th>
                                                <!-- <th class="text-end">Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody class="mb-5">
                                            <?php if(!empty($getUser)){ ?>
                                            @foreach($getUser as $data)
                                            <tr >
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" />
                                                    </div>
                                                </td>
                                                <td>{{$data->name }}</td>
                                                <td>{{$data->mobile}}</td>
                                                <td>{{$data->email}}</td>
                                                <?php if($data->status == 1){ ?>
                                                <td><span class="badge rounded-pill bg-success"> Active</span></td>
                                                <?php }else{ ?>
                                                <td><span class="badge rounded-pill bg-danger"> Inactive</span></td>
                                                <?php }?>
                                                <!-- <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu ">
                                                          
                                                            <a class="dropdown-item text-danger" href="">Delete</a>
                                                        </div>
                                                    </div>
                                                </td> -->
                                            </tr>
                                            @endforeach
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <nav>{{$getUser->links()}}</nav>
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
