@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
//echo $url = Request::path();
// if (isset($_GET['search_user_list'])) {
//     $search_user_list = $_GET['search_user_list'];
// }
?>


<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Subscriber list</h2>
    </div>
                


    <div class="card mb-4">
               
    <header class="card-header">
                        
    <div class="d-flex justify-content-between align-items-center">

        <div >
            <form method="post" action="{{url('krishi-seller-list')}}" class="d-flex justify-content-center align-items-center gap-2">
            @csrf
            <input type="text" class="form-control p-1 border border-success" id="search_user_list" name="search_user_list" value="<?php if (isset($_GET['search_user_list'])) {echo $_GET['search_user_list'];}?>">
            <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    
    
        <div class="d-flex justify-content-between gap-5 fw-bold">
            <?php
            $i=0;
            $total_user_counter = DB::table('user')->where(['status'=>1])->count();
            $total_user = DB::table('user')->where(['status'=>1])->get();

            // $total_user = DB::table('user')
            //                    ->select('user.id', 'tractor.user_id', 'goods_vehicle.user_id', 'harvester.user_id', 'implements.user_id',
            //                    'seeds.user_id', 'pesticides.user_id', 'fertilizers.user_id', 'tyres.user_id')
            //                    ->leftJoin('tractor as tractor', 'user.id', '=', 'tractor.user_id')
            //                    ->leftJoin('goods_vehicle as goods_vehicle', 'user.id', '=', 'goods_vehicle.user_id')
            //                    ->leftJoin('harvester as harvester', 'user.id', '=', 'harvester.user_id')
            //                    ->leftJoin('implements as implements', 'user.id', '=', 'implements.user_id')
            //                    ->leftJoin('seeds as seeds', 'user.id', '=', 'seeds.user_id')
            //                    ->leftJoin('pesticides as pesticides', 'user.id', '=', 'pesticides.user_id')
            //                    ->leftJoin('fertilizers as fertilizers', 'user.id', '=', 'fertilizers.user_id')
            //                    ->leftJoin('tyres as tyres', 'user.id', '=', 'tyres.user_id')
            //                    ->where(['user.status'=>1])
            //                    ->get();

            foreach ($total_user as $val) {
            $user_id = $val->id;
                $tractor_count      = DB::table('tractor')->where(['user_id'=>$user_id])->count();
                $gv_count           = DB::table('goods_vehicle')->where(['user_id'=>$user_id])->count();
                $harvester_count    = DB::table('harvester')->where(['user_id'=>$user_id])->count();
                $implement_count    = DB::table('implements')->where(['user_id'=>$user_id])->count();
                $seed_count         = DB::table('seeds')->where(['user_id'=>$user_id])->count();
                $pesticide_count    = DB::table('pesticides')->where(['user_id'=>$user_id])->count();
                $fertilizer_count   = DB::table('fertilizers')->where(['user_id'=>$user_id])->count();
                $tyre_count         = DB::table('tyres')->where(['user_id'=>$user_id])->count();
                
                $post = $tractor_count+$gv_count+$harvester_count+$implement_count+$seed_count+$pesticide_count+$fertilizer_count+$tyre_count;
                if ($post>0) {
                    $i++;
                }
            }
            ?>
            <!-- <small class="border p-2 border-success rounded">Total Seller : </small>
            <small class="border p-2 border-success rounded">Total Buyer : </small> -->
            <small class="border p-2 border-success rounded">Total Seller : <?= $i;?></small>
            <small class="border p-2 border-success rounded">Total Buyer : <?= $total_user_counter-$i?></small>

        </div>

    </div>
    
                        <!--<div class="row gx-3">
                            <div class="col-lg-4 col-md-6 me-auto">
                                <input type="text" placeholder="Search..." class="form-control" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-6">
                                <select class="form-select">
                                    <option>Status</option>
                                    <option>Active</option>
                                    <option>Disabled</option>
                                    <option>Show all</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-6">
                                <select class="form-select">
                                    <option>Show 20</option>
                                    <option>Show 30</option>
                                    <option>Show 40</option>
                                </select>
                            </div>
                        </div>-->
                    </header>
                    <!-- card-header end// -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Seller</th>
                                        <th>Phone / Email</th>
                                        <th>Pin Code</th>
                                        <th>Status</th>
                                        <th>Registered</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php

                                    if (isset($_POST['search_user_list'])) {
                                        //$user = DB::table('user')->orderBy('id','desc')->where('mobile', 'LIKE', "%{$_GET['search_user_list']}%")->paginate(500);
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
                                        <?php if(!empty($val->zipcode)){?>
                                            <td><?= $val->zipcode; ?></td>
                                        <?php }else if($val->zipcode == null){ ?>
                                            <td>-</td>
                                        <?php }?>
                                        
                                        <td><span class="badge rounded-pill alert-<?php if($val->profile_update==1) {echo 'success';} else {echo 'danger';}?>"><?php if($val->profile_update==1) {echo 'Registered';} else {echo 'Unregistered';}?></span></td>
                                        <td><?= $val->created_at; ?></td>
                                        <td class="text-end">
                                            <a href="{{url('krishi-seller-details/'.$val->id)}}" class="btn btn-sm btn-brand rounded font-sm mt-15">View details</a>
                                        </td>
                                    </tr>


                                    <?php } } else {

                                   // $user = DB::table('user')->orderBy('id','desc')->paginate(1);
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
                                        <?php if(!empty($val->zipcode)){?>
                                            <td><?= $val->zipcode; ?></td>
                                        <?php }else if($val->zipcode == null){ ?>
                                            <td>N/A</td>
                                        <?php }?>
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
                            <nav>
                                {{$user->links()}}

                            </nav>
                            <!-- {!! $user->links() !!} -->
                        </ul>
                    </nav>
                </div>
            </section>
            
@endsection
