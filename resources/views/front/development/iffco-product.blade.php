@extends('layout.main')
@section('page-container')
<?php
 use Illuminate\Support\Str;
 use Illuminate\Support\Facades\DB;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
use App\Models\language;
$lang = language::language();
?>

<!-- Dibyendu Change 15.09.2023 -->

<?php 

$url = Request::path();
$exp = explode ('/',$url);

if (session()->has('KVMobile')) {
    //print_r($exp[0]);
  
    $mobile = session()->get('KVMobile');
   // dd($mobile);
    $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
    $mytime = Carbon\Carbon::now();
    $date = $mytime->toDateTimeString();
  
   if($exp[0] =='iffco-product-page') {
        $values = array('user_id' => $user_id , 'call_status' =>null,'dealership_id'=>null,'product_id'=>null,'created_at'=>$date,'updated_at'=>$date);
       // print_r($values);
        DB::table('iffco_leads')->insert($values);
    }
}

?>

<style>
    @media(max-width: 768px){
    .iffco-product-content h5{
        font-size: 15px;
    }
}
</style>

<div class="product-list pt-5">
                <div class="d-flex align-items-center justify-content-center">
                    <a href="{{URL('/')}}">
                        <h2>HOME</h2>
                    </a>
                    <span><i class="fa-solid fa-angle-right fa-2x text-white"></i></span>
                    <a href="#">
                        <h2>IFFCO PRODUCT</h2>
                    </a>
                </div>



                <div class="pl-head text-center">
                    <h1>IFFCO PRODUCT</h1>
                </div>

</div>

    <div class="container-md">
            <div class="row p-0 p-md-3">
                    <div class="container-fluid bg-white">

                        <div class="row">
                            @foreach($getProduct as $data)
                            <div class="col-6 col-md-3 p-3 bg-white">
                                <div class="iffco-product border rounded overflow-hidden h-100">

                                    <div class="iffco-product-content text-center h-100">

                                        <a href="{{ url('iffco-dealer-page/iffco/'.$data->id) }}"><img src="{{asset('storage/iffco/products/'.$data->product_image) }}" alt="" class="p-3 img-fluid" style="height:250px;width:250px;object-fit: contain;"></a>
                                        <div class="text-end">
                                        <img src="https://www.indiancooperative.com/wp-content/uploads/2014/09/IFFCO-LOGO-page-001.jpg" alt="" width="80" class="d-inline-block p-2 img-fluid">
                                        </div>
                                        <h5 class="text-center text-capitalize p-3 m-0 text-dark bg-light h-100" >{{$data->product_name}}</h5>

                                    </div>

                                </div>
                            </div>
                            @endforeach

                        </div>


                        <!-- pagination -->


                    </div>


                </div>
            </div>


@endsection
