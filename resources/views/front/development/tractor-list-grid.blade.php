@extends('layout.main')
@section('page-container')

<style>
    /*PAGINATION*/
    .paginate {
        margin-top: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination {
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .page-item.disabled .page-link {
        color: white;
        font-weight: 400;
    }

    .page-item .page-link {
        background: linear-gradient(33deg, #13693a, #8cbf44);
        color: white;
        font-weight: 400;
    }

    .page-item .page-link:hover {
        cursor: pointer;
        transform: scale(1.2);
        transition: all ease 0.3s;
    }

    .page-item.active .page-link {
        background: #212529 !important;
    }

    .page-item:first-child .page-link {
        background: #212529;
        border-radius: 46%;
        border: 3px solid #8dbf45;
    }

    .page-item:last-child .page-link {
        background: #212529;
        border-radius: 46%;
        border: 3px solid #8dbf45;
    }

    .page-item:first-child .page-link:hover,
    .page-item:last-child .page-link:hover {
        transform: scale(1);
    }
</style>


<?php 
use Illuminate\Support\Facades\DB;

$d = session()->has('condition');

?>

<!-- Dibyendu Change 06.09.2023  -->
<?php
    $url = Request::path();
    $exp = explode ('/',$url);
    // $type = $exp[1];

    if(!empty($exp[2])){
        $type = $exp[2];
    }else if(!empty($exp[1])){
        $type = $exp[1];
    }else{
        $type = '';
    }
    //echo $type;


    if (session()->has('KVMobile')) {
        //$profile_update = DB::table('user')->where(['mobile'=>session()->get('KVMobile')])->value('profile_update');
        $mobile = session()->get('KVMobile');
        $user_id = DB::table('user')->where(['mobile'=>$mobile])->value('id');
        $mytime = Carbon\Carbon::now();
        $date = $mytime->toDateTimeString();
         $set = $exp[1];
      //  echo $type;
        if($set =='new' || $set =='old' || $set == 'rent'){
            $values = array('user_id' => $user_id , 'category_id' =>1,'type'=>$type,'section'=>'viewall','created_at'=>$date);
            //print_r($values);
            DB::table('leads_view_all')->insert($values);
        }
        else if($exp[1] =='phl' || $exp[1] =='plh' || $exp[1] =='nf'){
            $values = array('user_id' => $user_id , 'category_id' =>1,'type'=>$type,'section'=>$set,'created_at'=>$date);
            DB::table('leads_view_all')->insert($values);
        } 
    }
?>


<?php
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();

$url = Request::path();
    $exp = explode ('/',$url);
    if ($exp[0]=='tractor-list') {

    } else if ($exp[0]=='tractor-filter') {
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
                    <h2>
                        <?php if (session()->has('bn')) {echo $lang['bn']['HOME'];}
                            else if (session()->has('hn')) {echo $lang['hn']['HOME'];}
                            else { echo 'HOME'; }
                            ?>
                    </h2>
                </a>
                <span><i class="fa-solid fa-angle-right fa-2x text-white"></i></span>
                <a href="#">
                    <h2>
                        <?php if (session()->has('bn')) {echo $lang['bn']['TRACTOR'];}
                            else if (session()->has('hn')) {echo $lang['hn']['TRACTOR'];}
                            else { echo 'TRACTOR'; }
                            ?>
                    </h2>
                </a>
            </div>
            <div class="pl-head text-center">
                <h1>
                    <?php
                        if ($exp[1] == 'old' ) {$tttype = 'USED'; $page = strtoupper($tttype).' '.'TRACTOR';}
                        else if ($exp[1] == 'phl' ) {$page = 'TRACTOR';}
                        else if ($exp[1] == 'plh' ) {$page = 'TRACTOR';}
                        else if ($exp[1] == 'nf' ) {$page = 'TRACTOR';}
                        else {$tttype = $exp[1]; $page = strtoupper($tttype).' '.'TRACTOR';}

                        if (session()->has('bn')) {echo $lang['bn'][$page];}
                            else if (session()->has('hn')) {echo $lang['hn'][$page];}
                            else { echo $page; }
                            ?>
                </h1>
            </div>
        </div>
    </div>

    <div class="fp-btn">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center border py-1 " id="sort">
                    <button> <span><img src="{{ URL::asset('assets/images/filter.png')}}" alt=""
                                class="img-fluid"></span>
                        Sort</button>
                </div>
                <div class="col-6 text-center border py-1 d-none" id="filter">

                    <button href=""> <span><img src="{{ URL::asset('assets/images/sort.png')}}" alt=""
                                class="img-fluid"></span>
                        Filter</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-md">
        <div class="row p-0 p-md-3">
            <div class="col-md-3 bg-white filter-block d-none">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-arrow-left pe-1 d-none" id="back"></i>
                    <p class="py-1 fs-4 bg-white ps-3 text-success"><strong>Filters</strong></p>
                </div>


                <form id="filter_trator" method="POST" action="{{url('tractor-filter/'.$type)}}">
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
                                        <input class="form-check-input" type="checkbox" value="tractor"
                                            name="category[]" id="trac-sell" <?php if ($type=='new' || $type=='old' )
                                            {echo 'checked' ;} ?>
                                        <?php if (session()->has('category')) { if (in_array('tractor', session()->get('category'))) {echo 'checked';} }?>>
                                        <label class="form-check-label" for="trac-sell">
                                            Buy
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="tractor"
                                            name="category[]" id="trac-rent" <?php if ($type=='rent' ) {echo 'checked'
                                            ;} ?>
                                        <?php if (session()->has('category')) { if (in_array('tractor', session()->get('category'))) {echo 'checked';} } ?>
                                        >
                                        <label class="form-check-label" for="trac-rent">
                                            Rent
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
                                        <input class="form-check-input" type="checkbox" value="sell" name="type[]"
                                            id="trac-sell" <?php if ($type=='new' || $type=='old' ) {echo 'checked' ;}
                                            ?>
                                        <?php if (session()->has('type')) { if (in_array('sell', session()->get('type'))) {echo 'checked';} }?>>
                                        <label class="form-check-label" for="trac-sell">
                                            Buy
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="rent" name="type[]"
                                            id="trac-rent" <?php if ($type=='rent' ) {echo 'checked' ;} ?>
                                        <?php if (session()->has('type')) { if (in_array('rent', session()->get('type'))) {echo 'checked';} } ?>
                                        >
                                        <label class="form-check-label" for="trac-rent">
                                            Rent
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item d-none">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Condition
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="new" name="condition[]"
                                            id="trac-new" <?php if ($type=='new' ) {echo 'checked' ;} else if
                                            ($type=='rent' ) {} ?>
                                        <?php if (session()->has('condition')) { if (in_array('new', session()->get('condition'))) {echo 'checked';} } ?>
                                        >
                                        <label class="form-check-label" for="trac-new">
                                            New
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="old" name="condition[]"
                                            id="trac-old" <?php if ($type=='old' ) {echo 'checked' ;} else if
                                            ($type=='rent' ) {echo 'checked' ;} ?>
                                        <?php if (session()->has('condition')) { if(in_array('old', session()->get('condition'))) {echo 'checked';} }?>
                                        >
                                        <label class="form-check-label" for="trac-old">
                                            Used
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingEight">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    Brand
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse show"
                                aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                 
                                    <div class="row brand-select"> 

                                        <?php
                                          //  echo '<pre>';
                                           // print_r($brand_name);
                                        ?>
                                        <?php foreach($brand_name as $brn){ ?>
                                        <div class="form-check p-0 col-4">
                                            <?php if (session()->has('brand')) { if(in_array($brn->id, session()->get('brand'))) {echo 'checked';} }?>
                                            <input class="form-check-input d-none"  id="state_prod_list" type="checkbox" value="{{$brn->id}}" name="brand[]" id="flexCheckDefault">
                                            
                                            <label class="form-check-label p-2 border rounded" for="flexCheckDefault">
                                                <img src="{{asset('storage/images/brands/'.$brn->logo)}}" alt="brand_logo" width="60"  style="object-fit:contain; object-position: center; border-radius: 8px;"/>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>   
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingNine">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                    Model
                                </button>
                            </h2>
                            <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    

                                <div class="row model-select"> 
                                    <div class="form-check p-0 col-4">
                                        <input class="form-check-input d-none" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label p-2 border rounded" for="flexCheckDefault">
                                            <img src="https://w7.pngwing.com/pngs/1020/483/png-transparent-mahindra-mahindra-logo-car-brand-india-car-company-text-trademark.png" alt="brand_logo" width="60"  style="object-fit:contain; object-position: center; border-radius: 8px;"/>
                                        </label>
                                    </div>
                                        
                                </div> 

                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    State
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach ($state_arr as $val)
                                    <?php 
                                        $val->state_name;
                                        if($type == 'rent'){
                                            $stateDataCount =  DB::table('tractorView')->where('state_id',$val->id)->where('set',$type)->whereIn('status',[1,4])->count();
                                        }else{
                                            $stateDataCount =  DB::table('tractorView')->where('state_id',$val->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                        }
                                        if($stateDataCount  >= 1){ 
                                    ?>
                                    <div class="form-check">
                                        <!-- <input class="form-check-input state_prod_list" name="state" id="state_prod_list" type="radio" value="{{$val->id}}" <?php if($state==$val->id) {echo 'checked';} ?>
                                        <?php if (session()->has('state_name')) { if($val->id==session()->get('state_name')) {echo 'checked';} }?>>
                                        <label class="form-check-label" for="trac-sell">
                                            {{$val->state_name}}
                                        </label> -->
                                        <input class="form-check-input state_prod_list" name="state[]"
                                            id="state_prod_list" type="checkbox" value="{{$val->id}}" <?php
                                            if($state==$val->id) {echo 'checked';} ?>
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
                                        if($type == 'rent'){
                                            $districtDataCount =  DB::table('tractorView')->where('state_id',$val1->state_id)->where('district_id',$val1->id)->where('set',$type)->whereIn('status',[1,4])->count();
                                        }else{
                                            $districtDataCount =  DB::table('tractorView')->where('state_id',$val1->state_id)->where('district_id',$val1->id)->where('type',$type)->where('set','sell')->whereIn('status',[1,4])->count();
                                        }
                                        if($districtDataCount >= 1){ 
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input state_prod_list" type="checkbox"
                                            name="district[]" id="state_prod_list" value="{{$val1->id}}" <?php
                                            if($district==$val1->id) {echo 'checked';}?>
                                        <?php if (session()->has('district')) { if(in_array($val1->id, session()->get('district'))) {echo 'checked';} }?>
                                        >
                                        <label class="form-check-label" for="trac-sell">
                                            {{$val1->district_name}} ({{$districtDataCount }})
                                        </label>
                                    </div>
                                    <?php }?>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Year of Manufacturing
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2023" <?php if (session()->has('yop')) { if(in_array('2023',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2023
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2022" <?php if (session()->has('yop')) { if(in_array('2022',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2022
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2021" <?php if (session()->has('yop')) { if(in_array('2021',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2021
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2020" <?php if (session()->has('yop')) { if(in_array('2020',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2020
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2019" <?php if (session()->has('yop')) { if(in_array('2019',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2019
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2018" <?php if (session()->has('yop')) { if(in_array('2018',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2018
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2017" <?php if (session()->has('yop')) { if(in_array('2017',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2017
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2016" <?php if (session()->has('yop')) { if(in_array('2016',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2016
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2015" <?php if (session()->has('yop')) { if(in_array('2015',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2015
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2014" <?php if (session()->has('yop')) { if(in_array('2014',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2014
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2013" <?php if (session()->has('yop')) { if(in_array('2013',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2013
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2012" <?php if (session()->has('yop')) { if(in_array('2012',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2012
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2011" <?php if (session()->has('yop')) { if(in_array('2011',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2011
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2010" <?php if (session()->has('yop')) { if(in_array('2010',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2010
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2009" <?php if (session()->has('yop')) { if(in_array('2009',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2009
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2008" <?php if (session()->has('yop')) { if(in_array('2008',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2008
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2007" <?php if (session()->has('yop')) { if(in_array('2007',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2007
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2006" <?php if (session()->has('yop')) { if(in_array('2006',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2006
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2005" <?php if (session()->has('yop')) { if(in_array('2005',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2005
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2004" <?php if (session()->has('yop')) { if(in_array('2004',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2004
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2003" <?php if (session()->has('yop')) { if(in_array('2003',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2003
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2002" <?php if (session()->has('yop')) { if(in_array('2002',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2002
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2001" <?php if (session()->has('yop')) { if(in_array('2001',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2001
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="2000" <?php if (session()->has('yop')) { if(in_array('2000',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            2000
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="1999" <?php if (session()->has('yop')) { if(in_array('1999',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            1999
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="1998" <?php if (session()->has('yop')) { if(in_array('1998',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            1998
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="1997" <?php if (session()->has('yop')) { if(in_array('1997',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            1997
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="1996" <?php if (session()->has('yop')) { if(in_array('1996',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            1996
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="1995" <?php if (session()->has('yop')) { if(in_array('1995',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            1995
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="1994" <?php if (session()->has('yop')) { if(in_array('1994',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            1994
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="1993" <?php if (session()->has('yop')) { if(in_array('1993',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            1993
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="1992" <?php if (session()->has('yop')) { if(in_array('1992',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            1992
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="1991" <?php if (session()->has('yop')) { if(in_array('1991',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            1991
                                        </label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="yop[]"
                                            value="1990" <?php if (session()->has('yop')) { if(in_array('1990',
                                        session()->get('yop'))) {echo 'checked';} }?>><label class="form-check-label">
                                            1990
                                        </label></div>

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
                                                    <input type="number" class="input-min"
                                                        value="<?php if (session()->has('min_price')) { echo session()->get('min_price'); } else {echo 100;}?>"
                                                        name="min_price" readonly>
                                                </div>
                                                <div class="separator pt-4">-</div>
                                                <div class="field d-md-flex flex-column">
                                                    <span>Max</span>
                                                    <input type="number" class="input-max"
                                                        value="<?php if (session()->has('max_price')) { echo session()->get('max_price'); } else {echo 1500000;}?>"
                                                        name="max_price" readonly>
                                                </div>
                                            </div>
                                            <div class="slider">
                                                <div class="progress"></div>
                                            </div>
                                            <div class="range-input pb-4">
                                                <input type="range" class="range-min" min="100" max="1500000"
                                                    value="100" step="100">
                                                <input type="range" class="range-max" min="100" max="1500000"
                                                    value="1500000" step="100">
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
                    <!-- Dibyendu Change 09.09.2023 -->
                    <?php if(!empty($type)){ ?>
                    <div class="sorting p-3">
                        <p class="d-inline me-3 bg-success text-white p-2"><strong>Sort By </strong></p>
                        <a href="{{url('tractor-filter/plh/'.$type)}}"
                            class=" <?php if ($exp[1]=='plh') {echo 'active-filter';} else {echo '';} ?>">Price- Low to
                            High</a>
                        <a href="{{url('tractor-filter/phl/'.$type)}}"
                            class=" <?php if ($exp[1]=='phl') {echo 'active-filter';} else {echo '';} ?>">Price- High to
                            Low</a>
                        <a href="{{url('tractor-filter/nf/'.$type)}}"
                            class=" <?php if ($exp[1]=='nf') {echo 'active-filter';} else {echo '';} ?>">Newest
                            First</a>
                    </div>
                    <?php }else{ ?>
                    <div class="sorting p-3">
                        <p class="d-inline me-3 bg-success text-white p-2"><strong>Sort By </strong></p>
                        <a href="#" class=" <?php if ($exp[1]=='plh') {echo 'active-filter';} else {echo '';} ?>">Price-
                            Low to High</a>
                        <a href="#" class=" <?php if ($exp[1]=='phl') {echo 'active-filter';} else {echo '';} ?>">Price-
                            High to Low</a>
                        <a href="#" class=" <?php if ($exp[1]=='nf') {echo 'active-filter';} else {echo '';} ?>">Newest
                            First</a>
                    </div>
                    <?php } ?>


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

                                    <a href="{{ url('tractor/'.$val['id']) }}"><img src="{{$val['front_image']}}" alt=""
                                            class="p-3 tractor-img"></a>
                                    <div class="shadow-line">

                                    </div>
                                    <p class="fw-bolder">{{$val['brand_name']}} {{$val['model_name']}}</p>

                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <!-- <p><i class="fa-solid fa-location-dot"></i> {{$val['city_name']}}</p> -->
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val['price']}}
                                            <?php if($val['set']=='rent') {
                                                if ($val['rent_type']=='Per Hour') {
                                                    echo '/hr';
                                                } else if ($val['rent_type']=='Per Day') {
                                                    echo '/m';
                                                } else if ($val['rent_type']=='Per Month') {
                                                    echo '/d';
                                                }
                                            } ?>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php } ?>

                    </div>
                    <?php } ?>

                    <!-- Dibyendu Add 09.09.2023 -->

                    <?php if (isset($data12)) {
                            //print_r($data12);
                            if ($exp[1]=='plh') {
                                $data12 = collect($data12)->sortBy('price')->values()->all();
                            } else if ($exp[1]=='phl') {
                                $data12 = collect($data12)->sortByDesc('price')->values()->all();
                            } else if ($exp[1]=='phl') {
                                $data12 = collect($data12)->sortBy('id')->values()->all();
                            }
                            ?>
                    <div class="row">
                        <?php foreach ($data12 as $val1) {
                                //  print_r($data12);
                                //  exit();
                            ?>
                        <div class="col-6 col-md-3 p-0">
                            <div class="tractor-list m-0 pb-3 px-2">

                                <div class="tractor-img-box">
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <a href="{{ url('tractor/'.$val1->id) }}">
                                        <!-- <img src="<?= env('APP_URL')."storage/tractor/$val1->front_image"; ?>" alt="" class="p-3 tractor-img"> -->
                                        <img src="{{asset('storage/tractor/'.$val1->front_image)}}" alt=""
                                            class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100"
                                            style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;bottom: 57%;">
                                    </a>
                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                            $brand_arr_data = DB::table('brand')->where(['id'=>$val1->brand_id])->first();
                                            $brand_name = $brand_arr_data->name;
                                            $model_arr_data = DB::table('model')->where(['id'=>$val1->model_id])->first();
                                            $model_name = $model_arr_data->model_name;
                                            $state_arr_data = DB::table('district')->where(['id'=>$val1->district_id])->first();
                                            $district_name = $state_arr_data->district_name;
                                            $city_arr_data = DB::table('city')->where(['pincode'=>$val1->pincode])->first();
                                            // $city_name = $city_arr_data->city_name;
                                        ?>
                                    <p class="fw-bolder">{{$brand_name}} {{$model_name}}</p>

                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val1->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val1->price}}
                                            <?php if($val1->set=='rent') {
                                                if ($val1->rent_type=='Per Hour') {
                                                    echo '/hr';
                                                } else if ($val1->rent_type=='Per Day') {
                                                    echo '/m';
                                                } else if ($val1->rent_type=='Per Month') {
                                                    echo '/d';
                                                }
                                            } ?>
                                        </p>
                                    </div>
                                    <?php
                                            $distance = round($val1->distance);
                                        ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km
                                        distance</p>
                                </div>

                            </div>
                        </div>
                        <?php } 
                            ?>
                        <?php if($data12 == ''){ ?>
                        <h1>NO DATA FOUND</h1>
                        <?php }?>

                    </div>

                    <?php }
                            
                        ?>


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
                        <?php foreach ($data1 as $val1) {
                              //print_r($val1)
                            ?>
                        <div class="col-6 col-md-3 p-0">
                            <div class="tractor-list m-0 pb-3 px-2">

                                <div class="tractor-img-box">
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}
                                    <?php if($val1->status == 1){?>
                                    <a href="{{ url('tractor/'.$val1->id) }}">
                                        <!-- <img src="<?= env('APP_URL')."storage/tractor/$val1->front_image"; ?>" alt="" class="p-3 tractor-img"> -->
                                        <img src="{{asset('storage/tractor/'.$val1->front_image)}}" alt=""
                                            class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100"
                                            style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;bottom: 53%;">
                                    </a>
                                    <?php }else if($val1->status == 4){ ?>
                                    <!-- <a href="{{ url('tractor/'.$val1->id) }}"> -->
                                    <img src="<?= env('APP_URL')." storage/tractor/$val1->front_image"; ?>" alt=""
                                    class="p-3 tractor-img">
                                    <img src="{{asset('sold/sold.jpg')}}" alt="sold" width="100"
                                        style="position: absolute; top: 0;">
                                    <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100"
                                        style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;bottom: 53%;">
                                    <!-- </a> -->
                                    <?php }?>

                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                            $brand_arr_data = DB::table('brand')->where(['id'=>$val1->brand_id])->first();
                                            $brand_name = $brand_arr_data->name;
                                            $model_arr_data = DB::table('model')->where(['id'=>$val1->model_id])->first();
                                            $model_name = $model_arr_data->model_name;
                                            $state_arr_data = DB::table('district')->where(['id'=>$val1->district_id])->first();
                                            $district_name = $state_arr_data->district_name;
                                            $city_arr_data = DB::table('city')->where(['pincode'=>$val1->pincode])->first();
                                            // $city_name = $city_arr_data->city_name;
                                        ?>
                                    <p class="fw-bolder">{{$brand_name}} {{$model_name}}</p>


                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val1->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val1->price}}
                                            <?php if($val1->set=='rent') {
                                                if ($val1->rent_type=='Per Hour') {
                                                    echo '/hr';
                                                } else if ($val1->rent_type=='Per Day') {
                                                    echo '/m';
                                                } else if ($val1->rent_type=='Per Month') {
                                                    echo '/d';
                                                }
                                            } ?>
                                        </p>
                                    </div>
                                    <?php
                                            $distance = round($val1->distance);
                                        ?>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}km
                                        distance</p>
                                </div>

                            </div>
                        </div>
                        <?php } ?>

                    </div>
                    <nav>{{$data1->links()}}</nav>
                    <?php } ?>

                    <!-- Dibyendu Change 28.08.2023 -->
                    <?php if(!empty($tr_rent)){ ?>
                    <div class="row">
                        <?php foreach ($tr_rent as $val1) {
                            //    print_r($tr_rent);
                            //    exit; ?>
                        <div class="col-6 col-md-3 p-0">
                            <div class="tractor-list m-0 pb-3 px-2">

                                <div class="tractor-img-box">
                                    {{-- <i class="fa-solid fa-heart" id="add-fav"></i> --}}

                                    <?php if($val1->status == 1){
                                         ?>
                                    <a href="{{ url('tractor/'.$val1->id) }}">
                                        <img src="{{asset('storage/tractor/'.$val1->front_image)}}" alt=""
                                            class="p-3 tractor-img">
                                        <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100"
                                            style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;top: -17%;">
                                    </a>
                                    <?php }else if($val1->status == 4){ ?>
                                    <!-- <a href="{{ url('tractor/'.$val1->id) }}"> -->
                                    <!-- <img src="<?= env('APP_URL')."storage/tractor/$val1->front_image"; ?>" alt=""
                                                    class="p-3 tractor-img"> -->
                                    <img src="{{asset('storage/tractor/'.$val1->front_image)}}" alt=""
                                        class="p-3 tractor-img">
                                    <img src="{{asset('sold/sold.jpg')}}" alt="sold" width="100"
                                        style="position: absolute; top: 0;">
                                    <img src="{{asset('storage/sold/kv.png')}}" alt="sold" width="100"
                                        style="position: absolute; right: -5%;object-fit: contain;width: 120px !important;bottom: -17%;">
                                    <!-- </a> -->
                                    <?php }?>
                                    <div class="shadow-line">

                                    </div>
                                    <?php
                                            $brand_arr_data = DB::table('brand')->where(['id'=>$val1->brand_id])->first();
                                            if(!empty( $brand_arr_data) || $brand_arr_data == null ){
                                                $brand_name = $brand_arr_data->name;

                                            }
                                            
                                            $model_arr_data = DB::table('model')->where(['id'=>$val1->model_id])->first();
                                            $model_name = $model_arr_data->model_name;
                                            $state_arr_data = DB::table('district')->where(['id'=>$val1->district_id])->first();
                                            $district_name = $state_arr_data->district_name;
                                            $city_arr_data = DB::table('city')->where(['pincode'=>$val1->pincode])->first();
                                            // $city_name = $city_arr_data->city_name;
                                        ?>
                                    <p class="fw-bolder">{{$brand_name}} {{$model_name}}</p>

                                    <div class="spec d-flex justify-content-around align-items-center pt-3">
                                        <p><i class="fa-solid fa-location-dot"></i> {{$val1->city_name}}</p>
                                        <p><i class="fa-solid fa-indian-rupee-sign"></i> {{$val1->price}}

                                            <?php if($val1->set=='rent') {
                                                if ($val1->rent_type=='Per Hour') {
                                                    echo '/hr';
                                                } else if ($val1->rent_type=='Per Day') {
                                                    echo '/m';
                                                } else if ($val1->rent_type=='Per Month') {
                                                    echo '/d';
                                                }
                                            } ?>
                                        </p>
                                        <?php
                                                $distance = round($val1->distance);
                                            ?>
                                    </div>
                                    <p class="distance"><i class="fa-solid fa-location-arrow"></i> {{$distance}}/km
                                        distance</p>
                                </div>

                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <?php } ?>

                    <!-- pagination -->
                    <!-- Dibyendu Change 28.08.2023 -->
                    <?php
                        if(!empty($tr_rent)){
                        ?>
                    <nav> {{$tr_rent->links()}}</nav>
                    <?php }?>

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

<script>
    $(document).ready(function (          // When the "Sell" button is clicked, store the choice and redirect the use        $("#sell_trac").click(function  () {
            localStorage.setItem("user-choice", "sell");
            window.location.href = "tractor-post.php";        );

         When the "Rent" button is clicked, store the choice and redirect the user
           ent_trac").click(function () { 
            localStorage.setItem("user-choice", "rent");
            window.location.href = "tractor-post.php";
              });
</script>

@endsection