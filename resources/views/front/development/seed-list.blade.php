@extends('layout.main')
@section('page-container')


<style>
    /*PAGINATION*/
.paginate{
    margin-top: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pagination{
    gap: 20px;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}
.page-item.disabled .page-link{
    color: white;
    font-weight: 400;
}
.page-item .page-link{
        background: linear-gradient(33deg,#13693a,#8cbf44);
        color: white;
        font-weight: 400;
}

.page-item .page-link:hover{
    cursor: pointer;
    transform: scale(1.2);
    transition: all ease 0.3s;
}
.page-item.active .page-link{
    background: #212529 !important;
}

.page-item:first-child .page-link{
        background: #212529;
    border-radius: 46%;
    border: 3px solid #8dbf45;
}
.page-item:last-child .page-link{
        background: #212529;
    border-radius: 46%;
    border: 3px solid #8dbf45;
}

.page-item:first-child .page-link:hover,
.page-item:last-child .page-link:hover{
    transform: scale(1);
}
</style>

<?php
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();

$url = Request::path();
    $exp = explode ('/',$url);
    if ($exp[0]=='seed-list') {
        $exp[1] = '';
    } else if ($exp[0]=='seed-filter') {
        //$exp[0] = '';
        //if ($exp[1]=='phl' || $exp[1]=='plh' || $exp[1]=='nf') {
        if (isset($exp[1])) {

        } else {
            $exp[1] = '';
        }

    } else {
        $exp[0] = '';
        $exp[1] = '';
    }
?>

    <!-- LIST GRID VIEW -->
    <div class="tractor-list-view">


        <!-- MOBILE FILTER AND SORT BUTTON -->

        <div class="container-fluid p-0">
            <div class="product-list pt-5">
                <div class="d-flex align-items-center justify-content-center">
                    <a href="{{url('index')}}">
                        <h2><?php if (session()->has('bn')) {echo $lang['bn']['HOME'];}
                            else if (session()->has('hn')) {echo $lang['hn']['HOME'];}
                            else { echo 'HOME'; }
                            ?></h2>
                    </a>
                    <span><i class="fa-solid fa-angle-right fa-2x text-white"></i></span>
                    <a href="#">
                        <h2><?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];}
                            else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];}
                            else { echo 'SEEDS'; }
                            ?></h2>
                    </a>
                </div>

                <div class="pl-head text-center">
                    <h1></h1>
                </div>

                <!-- <div class="tr-sl-menu">
                    @if (session()->has('KVMobile')==1)
                        <a href="{{route('seeds.post')}}">SELL</a>
                    @else
                        <a class="myBtn">SELL</a>
                    @endif

                </div> -->
            </div>
        </div>

        <div class="fp-btn">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center border py-1 " id="sort">
                        <button> <span><img src="./assets/images/filter.png" alt="" class="img-fluid" ></span>
                            Sort</button>
                    </div>
                    <div class="col-6 text-center border py-1 d-none" id="filter">

                        <button href=""> <span><img src="./assets/images/sort.png" alt="" class="img-fluid" ></span>
                            Filter</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-md">
            <div class="row p-0 p-md-3">
                <div class="col-md-3 bg-white p-2 filter-block d-none">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-arrow-left pe-1 d-none" id="back"></i>
                        <p class="py-2 fs-4 bg-white ps-3 text-success"><strong>Filters</strong></p>
                    </div>

                    <form id="filter_trator" method="POST" action="{{url('tractor-filter')}}">
                    @csrf
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item d-none">
                            <h2 class="accordion-header" id="headingTen">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Category
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="seed" name="category[]" id="trac-sell" <?php if ($exp[0]=='seed-list' || $exp[0]=='seed-filter') {echo 'checked';} ?>
                                        <?php if (session()->has('category')) { if (in_array('seed', session()->get('category'))) {echo 'checked';} }?>>
                                        <label class="form-check-label" for="trac-sell">
                                            Buy
                                        </label>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item d-none">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Type
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="sell" name="type[]" id="trac-sell" <?php if ($exp[0]=='seed-list' || $exp[0]=='seed-filter' ) {echo 'checked';} ?>
                                        <?php if (session()->has('type')) { if (in_array('sell', session()->get('type'))) {echo 'checked';} }?>>
                                        <label class="form-check-label" for="trac-sell">
                                            Buy
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item d-none">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" >
                                    Condition
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="new" name="condition[]" id="trac-new" <?php if ($exp[0]=='seed-list' || $exp[0]=='seed-filter') {echo 'checked';}  ?>
                                        <?php if (session()->has('condition')) { if (in_array('new', session()->get('condition'))) {echo 'checked';} } ?> >
                                        <label class="form-check-label" for="trac-new">
                                            New
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    State 
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach ($state_arr as $val)
                                    <?php 
                                        $val->state_name;
                                        if($exp[0]=='seed-list' || $exp[0]=='seed-filter'){
                                            $stateDataCount =  DB::table('seedView')->where('state_id',$val->id)->whereIn('status',[1,4])->count();
                                        }
                                        if($stateDataCount  >= 1){ 
                                    ?>
                                    <div class="form-check">
                                        <!-- <input class="form-check-input state_prod_list" name="state" id="state_prod_list" type="radio" value="{{$val->id}}" <?php if($state==$val->id) {echo 'checked';} ?>
                                        <?php if (session()->has('state_name')) { if($val->id==session()->get('state_name')) {echo 'checked';} }?>>
                                        <label class="form-check-label" for="trac-sell">
                                            {{$val->state_name}}
                                        </label> -->
                                        <input class="form-check-input state_prod_list" name="state[]" id="state_prod_list" type="checkbox" value="{{$val->id}}" <?php if($state==$val->id) {echo 'checked';} ?> 
                                        >
                                        <label class="form-check-label" for="trac-sell">
                                            {{$val->state_name}} ({{$stateDataCount }})
                                        </label>
                                    </div>
                                    <?php }?>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    District
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body" id="district_id">

                                    @foreach($district_arr as $val1)
                                    <?php 
                                        if($exp[0]=='seed-list' || $exp[0]=='seed-filter'){
                                            $districtDataCount =  DB::table('seedView')->where('state_id',$val1->state_id)->where('district_id',$val1->id)->whereIn('status',[1,4])->count();
                                        }
                                        
                                        if($districtDataCount >= 1){ 
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input state_prod_list" type="checkbox" name="district[]" id="state_prod_list" value="{{$val1->id}}" <?php if($district==$val1->id) {echo 'checked';}?>
                                            <?php if (session()->has('district')) { if(in_array($val1->id, session()->get('district'))) {echo 'checked';} }?> >
                                            <label class="form-check-label" for="trac-sell">
                                                {{$val1->district_name}}  ({{$districtDataCount }})
                                            </label>
                                        </div>
                                    <?php }?>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Price Range
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <!-- price range -->
                                    <div class="d-flex border">
                                        <div class="wrapper">
                                            <div class="price-input">
                                                <div class="field d-md-flex flex-column">
                                                    <span>Min</span>
                                                    <input type="number" class="input-min" value="<?php if (session()->has('min_price')) { echo session()->get('min_price'); } else {echo 100;}?>" name="min_price" readonly>
                                                </div>
                                                <div class="separator pt-4">-</div>
                                                <div class="field d-md-flex flex-column">
                                                    <span>Max</span>
                                                    <input type="number" class="input-max" value="<?php if (session()->has('max_price')) { echo session()->get('max_price'); } else {echo 1500000;}?>" name="max_price" readonly>
                                                </div>
                                            </div>
                                            <div class="slider">
                                                <div class="progress"></div>
                                            </div>
                                            <div class="range-input pb-4">
                                                <input type="range" class="range-min" min="100" max="1500000" value="100"
                                                    step="100" >
                                                <input type="range" class="range-max" min="100" max="1500000" value="1500000"
                                                    step="100" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="apply-btn text-center p-4">
                            <button class="px-3 rounded" type="submit" name="filter_button">APPLY</button>
                        </div>

                    </div>
                </form>


                </div>
                <div class="col-md-12 p-0 px-md-3">
                    <div class="container-fluid bg-white">


                        <div class="sorting p-3">
                            <p class="d-inline me-3 bg-success text-white p-2"><strong>Sort By</strong></p>
                            <a href="{{url('seed-filter/plh')}}" class="<?php if ($exp[1]=='plh') {echo 'active-filter';} else {echo '';} ?>">Price- Low to High</a>
                            <a href="{{url('seed-filter/phl')}}" class="<?php if ($exp[1]=='phl') {echo 'active-filter';} else {echo '';} ?>">Price- High to Low</a>
                            <a href="{{url('seed-filter/nf')}}" class="<?php if ($exp[1]=='nf') {echo 'active-filter';} else {echo '';} ?>">Newest First</a>
                        </div>

                        <?php if (isset($data)) {
                            if ($exp[1]=='plh') {
                                $data = collect($data)->sortBy('price')->values()->all();
                            } else if ($exp[1]=='phl') {
                                $data = collect($data)->sortByDesc('price')->values()->all();
                            } else if ($exp[1]=='nf') {
                                $data = collect($data)->sortBy('id')->values()->all();
                            }
                            ?>
                        <div class="row">
                            <?php foreach ($data as $val) { ?>
                            <div class="col-6 col-md-3 p-0">
                                <div class="tractor-list m-0">

                                    <div class="tractor-img-box">
                                        {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                        <a href="{{ url('seed/'.$val['id']) }}"><img src="{{$val['image1']}}" alt=""
                                                class="p-3 tractor-img"></a>
                                        <div class="shadow-line">

                                        </div>
                                        <p class="fw-bolder">{{$val['title']}}</p>

                                        <div class="spec d-flex justify-content-around align-items-center pt-3">
                                            <p><i class="fa-solid fa-location-dot"></i> {{$val['city_name']}}</p>
                                            <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val['price']}}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php } ?>

                        </div>
                        <?php } ?>

                        <?php if (isset($data1)) {
                            // if ($exp[1]=='plh') {
                            //     $data1 = collect($data1)->sortBy('price')->values()->all();
                            // } else if ($exp[1]=='phl') {
                            //     $data1 = collect($data1)->sortByDesc('price')->values()->all();
                            // } else if ($exp[1]=='phl') {
                            //     $data1 = collect($data1)->sortBy('id')->values()->all();
                            // }
                            ?>
                            <div class="row">
                                <?php foreach ($data1 as $val1) { ?>
                                <div class="col-6 col-md-3 p-0">
                                    <div class="tractor-list m-0">

                                        <div class="tractor-img-box">
                                            {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}
                                            
                                            <?php if($val1->status == 1){ ?>

                                            <a href="{{ url('seed/'.$val1->id) }}">
                                                <!-- <img src="<?= env('APP_URL')."storage/seeds/$val1->image1"; ?>" alt=""
                                                    class="p-3 tractor-img"> -->
                                                <img src="{{asset('storage/seeds/'.$val1->image1)}}" alt="" class="p-3 tractor-img">
                                                <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0;object-fit: contain;width: 120px !important; bottom:60%;">
                                            </a>
                                            <?php }else if($val1->status == 4){ ?>
                                                <!-- <img src="<?= env('APP_URL')."storage/seeds/$val1->image1"; ?>" alt=""
                                                    class="p-3 tractor-img"> -->
                                                <img src="{{asset('storage/seeds/'.$val1->image1)}}" alt="" class="p-3 tractor-img">
                                                <img src="{{asset('storage/photo/sold_tag.png')}}" alt="sold" width="100" style="position: absolute; top: 0;">
                                            <?php } ?>
                                                    
                                            <div class="shadow-line">

                                            </div>
                                            <?php
                                            $state_arr_data = DB::table('district')->where(['id'=>$val1->district_id])->first();
                                            $district_name = $state_arr_data->district_name;
                                            $city_arr_data = DB::table('city')->where(['pincode'=>$val1->pincode])->first();
                                            $city_name = $city_arr_data->city_name;
                                            ?>
                                            <p class="fw-bolder">{{$val1->title}}</p>

                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                                <p><i class="fa-solid fa-location-dot"></i> {{$city_name}}</p>
                                                <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val1->price}}</p>
                                            </div>
                                            <?php
                                              $distance = round($val1->distance);
                                            ?>
                                            <p class="distance"><i class="fa-solid fa-location-arrow"></i>  {{$distance}} km distance</p>
                                        </div>
                                       

                                    </div>
                                </div>
                                <?php } ?>

                            </div>
                            <nav>
                                {{$data1->links()}}
                            </nav>
                            <?php } ?>
                            
                        <?php if (isset($data12)) {
                            // if ($exp[1]=='plh') {
                            //     $data1 = collect($data1)->sortBy('price')->values()->all();
                            // } else if ($exp[1]=='phl') {
                            //     $data1 = collect($data1)->sortByDesc('price')->values()->all();
                            // } else if ($exp[1]=='phl') {
                            //     $data1 = collect($data1)->sortBy('id')->values()->all();
                            // }
                            ?>
                            <div class="row">
                                <?php foreach ($data12 as $val1) { ?>
                                <div class="col-6 col-md-3 p-0">
                                    <div class="tractor-list m-0">

                                        <div class="tractor-img-box">
                                            {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                            <a href="{{ url('seed/'.$val1->id) }}"><img src="<?= env('APP_URL')."storage/seeds/$val1->image1"; ?>" alt=""
                                                    class="p-3 tractor-img"></a>
                                                    
                                              <?php if($val1->status == 1){ ?>

                                            <a href="{{ url('seed/'.$val1->id) }}">
                                                <img src="<?= env('APP_URL')."storage/seeds/$val1->image1"; ?>" alt=""
                                                    class="p-3 tractor-img">
                                                <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0;object-fit: contain;width: 120px !important; bottom:60%;">

                                            </a>
                                            <?php }else if($val1->status == 4){ ?>
                                            
                                                <img src="<?= env('APP_URL')."storage/seeds/$val1->image1"; ?>" alt=""
                                                    class="p-3 tractor-img">
                                                <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="sold" width="100" style="position: absolute; top: 0;">
                                                <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0;object-fit: contain;width: 120px !important; bottom:60%;">

                                            
                                            <?php } ?>
                                            <div class="shadow-line">

                                            </div>
                                            <?php
                                            $state_arr_data = DB::table('district')->where(['id'=>$val1->district_id])->first();
                                            $district_name = $state_arr_data->district_name;
                                            $city_arr_data = DB::table('city')->where(['pincode'=>$val1->pincode])->first();
                                            $city_name = $city_arr_data->city_name;
                                            ?>
                                            <p class="fw-bolder">{{$val1->title}}</p>

                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                                <p><i class="fa-solid fa-location-dot"></i> {{$city_name}}</p>
                                                <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val1->price}}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>

                            <!-- Dibyendu Change 28.08.2023 -->
                            <?php if(!empty($seed_buy)){ ?>
                            <div class="row">
                                <?php foreach ($seed_buy as $val1) { ?>
                                <div class="col-6 col-md-3 p-0">
                                    <div class="tractor-list m-0">

                                        <div class="tractor-img-box">
                                            {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}
                                                    
                                              <?php if($val1->status == 1){ ?>

                                            <a href="{{ url('seed/'.$val1->id) }}">
                                                <img src="<?= env('APP_URL')."storage/seeds/$val1->image1"; ?>" alt=""
                                                    class="p-3 tractor-img">
                                                <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0;object-fit: contain;width: 120px !important; bottom:60%;">

                                            </a>
                                            <?php }else if($val1->status == 4){ ?>
                                                <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100" style="position: absolute; right: 0;object-fit: contain;width: 120px !important; bottom:60%;">
                                                <img src="<?= env('APP_URL')."storage/seeds/$val1->image1"; ?>" alt=""
                                                    class="p-3 tractor-img">
                                                <img src="{{asset('public/storage/photo/sold_tag.png')}}" alt="sold" width="100" style="position: absolute; top: 0;">
                                            
                                            <?php } ?>
                                            <div class="shadow-line">

                                            </div>
                                            <?php
                                            $state_arr_data = DB::table('district')->where(['id'=>$val1->district_id])->first();
                                            $district_name = $state_arr_data->district_name;
                                            $city_arr_data = DB::table('city')->where(['pincode'=>$val1->pincode])->first();
                                            $city_name = $city_arr_data->city_name;
                                            ?>
                                            <p class="fw-bolder">{{$val1->title}}</p>

                                            <div class="spec d-flex justify-content-around align-items-center pt-3">
                                                <p><i class="fa-solid fa-location-dot"></i> {{$city_name}}</p>
                                                <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val1->price}}</p>
                                            </div>
                                            <?php
                                                $distance = round($val1->distance);
                                            ?>
                                            <p class="distance"><i class="fa-solid fa-location-arrow"></i>  {{$distance}} km distance</p>
                                        </div>

                                    </div>
                                </div>
                                <?php } }?>

                            </div>

                        <!-- pagination -->
                        <!-- Dibyendu Change 28.08.2023 -->
                        <?php if(!empty($seed_buy)){ ?>
                            <nav>
                                {{$seed_buy->links()}}
                            </nav>

                       <?php  } ?>

                        {{-- <nav aria-label="..." class="d-flex justify-content-center pt-3">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav> --}}
                    </div>


                </div>
            </div>
        </div>
    </div>



    @endsection