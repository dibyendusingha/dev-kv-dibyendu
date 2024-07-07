@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
?>

            <section class="content-main">
                <div class="content-header">
                    <h2 class="content-title">Profile setting</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row gx-5">
                            <div class="col-lg-12">
                                @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                                </div>
                                @elseif(session('failed'))
                                    <div class="alert alert-danger" role="alert">
                                    {{ session('failed') }}
                                    </div>
                                @endif
                                <?php
                                $admindata = DB::table('admin')->where(['username'=>session()->get('admin-krishi')])->first();
                                ?>
                                <section class="content-body p-xl-4">
                                    <form method="post" action="{{url('krishi-profile-submit')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="row gx-3">
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">First name</label>
                                                        <input class="form-control" name="first_name" type="text" value="<?php if ($admindata->first_name=='') {echo '';} else {echo $admindata->first_name;}?>" placeholder="Type here" />
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">Last name</label>
                                                        <input class="form-control" name="last_name" type="text" value="<?php if ($admindata->last_name=='') {echo '';} else {echo $admindata->last_name;}?>" placeholder="Type here" />
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-6 mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input class="form-control" name="email" type="email" value="<?php if ($admindata->email=='') {echo '';} else {echo $admindata->email;}?>" placeholder="example@mail.com" />
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-6 mb-3">
                                                        <label class="form-label">Phone</label>
                                                        <input class="form-control" name="phone" type="tel" value="<?php if ($admindata->phone_no=='') {echo '';} else {echo $admindata->phone_no;}?>" placeholder="+1234567890" />
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-6 mb-3">
                                                        <label class="form-label">Birthday</label>
                                                        <input class="form-control" name="dob" type="date" value="<?php if ($admindata->dob=='') {echo '';} else {echo $admindata->dob;}?>"/>
                                                    </div>
                                                    <!-- col .// -->
                                                </div>
                                                <!-- row.// -->
                                            </div>
                                            <!-- col.// -->
                                            <aside class="col-lg-4">
                                                <figure class="text-lg-center">
                                                    
                                                    
                                                    
                                                    <?php if ($admindata->photo!="") { ?>
                                                    <img class="img-lg mb-3 img-avatar" src="<?= env('APP_URL')."storage/admin_photo/".$admindata->photo; ?>" alt="User Photo" />
                                                    <?php } else { ?>
                                                    <img class="img-lg mb-3 img-avatar" src="{{ url('admin/imgs/people/avatar-1.png') }}" alt="User Photo" />
                                                    <?php } ?>
                                                    
                                                    <figcaption>
                                           				<input class="form-control" name="photo" type="file" />
                                                    </figcaption>
                                                </figure>
                                            </aside>
                                            <!-- col.// -->
                                        </div>
                                        <!-- row.// -->
                                        <br />
                                        <button class="btn btn-primary" type="submit">Save changes</button>
                                    </form>
                                    
                                    <!-- row.// -->
                                </section>
                                <!-- content-body .// -->
                            </div>
                            <!-- col.// -->
                        </div>
                        <!-- row.// -->
                    </div>
                    <!-- card body end// -->
                </div>
                <!-- card end// -->
            </section>
            
@endsection
