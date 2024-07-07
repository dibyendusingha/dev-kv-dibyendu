@extends('layout.main')
@section('page-container')
<?php
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();
?>

<!-- Dibyendu Change 15.09.2023 -->
<?php
use Illuminate\Support\Facades\DB;
    $url = Request::path();
    $exp = explode ('/',$url);
    // $type = $exp[1];

    if(!empty($exp[2])){
        $productId = $exp[2];
    }else if(!empty($exp[1])){
        $type = $exp[1];
    }
    
    if($exp[1] == 'iffco'){
        if (session()->has('KVMobile')) {
            //$profile_update = DB::table('user')->where(['mobile'=>session()->get('KVMobile')])->value('profile_update');
            $mobile = session()->get('KVMobile');
            $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
            $mytime = Carbon\Carbon::now();
            $date = $mytime->toDateTimeString();
             $set = $exp[1];
    
            if(!empty($productId)){
                $values = array('user_id' => $user_id , 'call_status' =>null,'dealership_id'=>null,'product_id'=>$productId,'created_at'=>$date,'updated_at'=>$date);
                DB::table('iffco_leads')->insert($values);
            }
           
        }
    }
   
?>

<div class="product-list pt-5">
                <div class="d-flex align-items-center justify-content-center">
                    <a href="/">
                        <h2>HOME</h2>
                    </a>
                    <span><i class="fa-solid fa-angle-right fa-2x text-white"></i></span>
                    <a href="#">
                        <h2>IFFCO DEALER</h2>
                    </a>
                </div>



                <div class="pl-head text-center">
                    <h1>IFFCO DEALER</h1>
                </div>

</div>

    <div class="container-md">
            <div class="row p-0 p-md-3">
                    <div class="container-fluid bg-white">
                     
                        <div class="row">
                            @foreach($output['get'] as $d)
                             <?php if(!empty($d->mobile) && !empty($d->district_name)  && !empty($d->state_name) && !empty($d->zipcode)){?>
                            <div class="col-6 pb-4 px-3 bg-white ">


                                <div class="iffco-dealer h-100  rounded overflow-hidden shadow" >
                                   
                                    <div class="iffco-dealer-content text-center row">
                                        <div class="col-md-4 ">
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <img src="https://www.indiancooperative.com/wp-content/uploads/2014/09/IFFCO-LOGO-page-001.jpg" alt=""  class="d-inline-block p-2 img-fluid">
                                            </div>
                                        </div>
                                        <div class="address-dealer col-md-8 mt-4">
                                            <p class="p-3 bg-light"><i class="fa-solid fa-map"></i> &nbsp;
                                                <?php 
                                                if(!empty($d->address)){
                                                    echo $d->address.',';
                                                }
                                                ?>

                                             {{$d->district_name}}, {{$d->state_name}} - {{$d->zipcode}} </p>
                                            <?php if (session()->has('KVMobile')) { ?>
                                            <form  action="{{url('ifco-dealer-tracking/'.$d->mobile.'/'.$d->id)}}" method="post">
                                            @csrf
                                                <a href="tel:$d->mobile" class="btn animate__animated animate__pulse animate__slow animate__infinite" style="background: #ea5b28 !important;" ><i class="fa-solid fa-phone-volume"></i>&nbsp;{{$d->mobile}}</a>
                                            </form>
                                           <?php  }else{ ?>
                                            <a href="tel:$d->mobile" class="btn animate__animated animate__pulse animate__slow animate__infinite" style="background: #ea5b28 !important;" ><i class="fa-solid fa-phone-volume"></i>&nbsp;{{$d->mobile}}</a>
                                           <?php } ?>
                                        </div>
                                    </div>
                                    
                                    <?php //$district = round($d->distance); ?>
                                </div>







                            </div>
                            <?php }?>
                            @endforeach
                        </div>

                        <!-- pagination -->
                       <div class="d-flex justify-content-center align-items-center">
                            <nav>
                            {{$output['get']->links()}}
                            </nav>
                       </div>


                    </div>


                </div>
            </div>


@endsection
