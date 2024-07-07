@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
//echo $url = Request::path();
if (isset($_GET['search_user_list'])) {
    $search_user_list = $_GET['search_user_list'];
}
?>


<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Referral list</h2>
    </div>
                


    <div class="card mb-4">
               
    <header class="card-header">
                        
    <div class="d-flex justify-content-between align-items-center">

    <div >
        <form method="get" action="" class="d-flex justify-content-center align-items-center gap-2">
        <input type="text" class="form-control p-1 border border-success" id="search_user_list" name="search_user_list" value="<?php if (isset($_GET['search_user_list'])) {echo $_GET['search_user_list'];}?>">
        <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    </div>
    
                  
                    </header>
                    <!-- card-header end// -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Seller</th>
                                        <th>Phone / Email</th>
                                        <th>Referral Code</th>
                                        <th>Referral Name</th>
                                        <th>Status</th>
                                        <th>Registered</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php

                                    if (isset($_GET['search_user_list'])) {
                                        $user = DB::table('user')->orderBy('id','desc')
                                        ->where('referral_code','<>',NULL)
                                        ->where('mobile', 'LIKE', "%{$_GET['search_user_list']}%")
                                        ->orwhere('referral_code', 'LIKE', "%{$_GET['search_user_list']}%")
                                        ->paginate(50);
                                    foreach ($user as $val) {
                                    ?>
                                    <tr>
                                        <td width="40%">
                                            <a href="#" class="itemside">
                                                <div class="left">
                                                    <?php if ($val->photo!='') { ?>
                                                    <img src="<?= env('APP_URL')."storage/photo/".$val->photo;?>" class="img-sm img-avatar" alt="Userpic" />
                                                    <?php } else { ?>
                                                    <img src="<?= env('APP_URL')."storage/noimage.jpg" ?>" class="img-sm img-avatar" alt="Userpic" />
                                                    <?php } ?>
                                                </div>
                                                <div class="info pl-3">
                                                    <h6 class="mb-0 title"><?= $val->name;?></h6>
                                                    <small class="text-muted">Total Posts: 
                                                    <?php
                                                    $tractor_count = DB::table('tractor')->where(['user_id'=>$val->id])->count();
                                                    $gv_count = DB::table('goods_vehicle')->where(['user_id'=>$val->id])->count();
                                                    $harvester_count = DB::table('harvester')->where(['user_id'=>$val->id])->count();
                                                    $implement_count = DB::table('implements')->where(['user_id'=>$val->id])->count();
                                                    $seed_count = DB::table('seeds')->where(['user_id'=>$val->id])->count();
                                                    $pesticide_count = DB::table('pesticides')->where(['user_id'=>$val->id])->count();
                                                    $fertilizer_count = DB::table('fertilizers')->where(['user_id'=>$val->id])->count();
                                                    $tyre_count = DB::table('tyres')->where(['user_id'=>$val->id])->count();
                                                    echo $tractor_count+$gv_count+$harvester_count+$implement_count+$seed_count+$pesticide_count+$fertilizer_count+$tyre_count;
                                                    ?>
                                                    </small>
                                                </div>
                                            </a>
                                        </td>
                                        <td><?= $val->mobile;?><br>
                                        <?= $val->email; ?></td>
                                        <td>{{$val->referral_code}}</td>
                                        <td><?= DB::table('referral_code')->where(['referral_code'=>$val->referral_code])->value('name');?></td>
                                        <td><span class="badge rounded-pill alert-<?php if($val->profile_update==1) {echo 'success';} else {echo 'danger';}?>"><?php if($val->profile_update==1) {echo 'Registered';} else {echo 'Unregistered';}?></span></td>
                                        <td><?= $val->created_at; ?></td>
                                        <td class="text-end">
                                            <a href="{{url('krishi-seller-details/'.$val->id)}}" class="btn btn-sm btn-brand rounded font-sm mt-15">View details</a>
                                        </td>
                                    </tr>


                                    <?php } } else {

                                    foreach ($user as $val) {
                                    ?>
                                    <tr>
                                        <td width="40%">
                                            <a href="#" class="itemside">
                                                <div class="left">
                                                    <?php if ($val->photo!='') { ?>
                                                    <img src="<?= env('APP_URL')."storage/photo/".$val->photo;?>" class="img-sm img-avatar" alt="Userpic" />
                                                    <?php } else { ?>
                                                    <img src="<?= env('APP_URL')."storage/noimage.jpg" ?>" class="img-sm img-avatar" alt="Userpic" />
                                                    <?php } ?>
                                                </div>
                                                <div class="info pl-3">
                                                    <h6 class="mb-0 title"><?= $val->name;?></h6>
                                                    <small class="text-muted">Total Posts: 
                                                    <?php
                                                    $tractor_count = DB::table('tractor')->where(['user_id'=>$val->id])->count();
                                                    $gv_count = DB::table('goods_vehicle')->where(['user_id'=>$val->id])->count();
                                                    $harvester_count = DB::table('harvester')->where(['user_id'=>$val->id])->count();
                                                    $implement_count = DB::table('implements')->where(['user_id'=>$val->id])->count();
                                                    $seed_count = DB::table('seeds')->where(['user_id'=>$val->id])->count();
                                                    $pesticide_count = DB::table('pesticides')->where(['user_id'=>$val->id])->count();
                                                    $fertilizer_count = DB::table('fertilizers')->where(['user_id'=>$val->id])->count();
                                                    $tyre_count = DB::table('tyres')->where(['user_id'=>$val->id])->count();
                                                    echo $tractor_count+$gv_count+$harvester_count+$implement_count+$seed_count+$pesticide_count+$fertilizer_count+$tyre_count;
                                                    ?>
                                                    </small>
                                                </div>
                                            </a>
                                        </td>
                                        <td><?= $val->mobile;?><br>
                                        <?= $val->email; ?></td>
                                        <td>{{$val->referral_code}}</td>
                                        <td><?= DB::table('referral_code')->where(['referral_code'=>$val->referral_code])->value('name');?></td>
                                        <td><span class="badge rounded-pill alert-<?php if($val->profile_update==1) {echo 'success';} else {echo 'danger';}?>"><?php if($val->profile_update==1) {echo 'Registered';} else {echo 'Unregistered';}?></span></td>
                                        <td><?= $val->created_at; ?></td>
                                        <td class="text-end">
                                            <a href="{{url('krishi-seller-details/'.$val->id)}}" class="btn btn-sm btn-brand rounded font-sm mt-15">View details</a>
                                        </td>
                                    </tr>
                                    <?php } } ?>


                                </tbody>
                            </table>
                            <!-- table-responsive.// -->
                        </div>
                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->
                <div class="pagination-area mt-15 mb-50">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-start">
                            {!! $user->links() !!}
                        </ul>
                    </nav>
                </div>
            </section>
            
@endsection
