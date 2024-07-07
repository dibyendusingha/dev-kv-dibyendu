@extends('layout.main')
@section('page-container')

<?php
    use Illuminate\Support\Facades\DB;
    $url = Request::path();
     $exp = explode ('/',$url);
    if(!empty($exp[3])){
        $companyId = $exp[3];
       $category = $exp[1];
    }
    else if(!empty($exp[1])){
       $category = $exp[1];
         $companyId = $exp[2];
    }
    else{
        $companyId = '';
    } 
?>

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


<section class="dealers-body">
    
    <div class="container">
        
        <div class="search-wrapper">
            <div class="search-section bg-white">
            <form action="{{url('search-company-product',[$category ,$companyId])}}" method="post">
            @csrf
                <div class="search-box">
                    <?php
                    if(!empty($value)){ ?>
                        <input type="text" id="fname" name="filter" class="form-control" placeholder="Search Products" value="<?php echo $value ?>">
                    <?php }else{?>
                        <input type="text" id="fname" name="filter" class="form-control" placeholder="Search Products">
                    <?php }?>
                </div>
                <div class="search-icon">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 p-4">
                <div class="brand-product-container">
                    <?php if(!empty($company_product)){ ?>
                        <div class="row">
                            <?php foreach($company_product as $cp){ ?>
                                <div class="col-lg-3 col-6 mb-3">
                                    <div class="bp-card">
                                        <div class="bp-top">
                                            <a href="{{ url('dealer-company-page/'.$cp->id) }}">
                                                <?php if($companyId == 4 || $companyId == 5|| $companyId == 9){ ?>
                                                    {{-- <img src="<?= env('APP_URL')."storage/company/products/$cp->product_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                    <img src="{{asset('storage/company/products/'.$cp->product_image)}}" alt="brand-product-image" class="img-fluid bg-white shadow"/>
                                                <?php } else if($companyId == 11 || $companyId == 12 || $companyId == 1){ ?>
    
                                                    {{-- <img src="<?= env('APP_URL')."storage/iffco/products/$cp->product_image"; ?>" alt="brand-product-image" class="img-fluid"/> --}}
                                                    <img src="{{asset('storage/iffco/products/'.$cp->product_image)}}" alt="brand-product-image" class="img-fluid bg-white shadow"/>
                                                <?php }else{?>
                                                    <img src="{{asset('storage/company/products/'.$cp->product_image)}}" alt="brand-product-image" class="img-fluid bg-white shadow"/>
                                                <?php } ?>
                                                
                                            </a>
                                            <!-- <div class="bp-location">
                                                <p class="m-0"><i class="fa-solid fa-location-dot"></i> {{$cp->product_name}} </p>
                                            </div> -->
                                        </div>
                                    
                                            <div class="bp-card-content">
                                                 <?php if($cp->price != 0){ ?>
                                                <div class="bp-price">
                                                    <p class="m-0"><i class="fa-solid fa-indian-rupee-sign"></i>
                                                        {{$cp->price}}
                                                    </p>
                                                </div>
                                                <?php } ?>
                                                <p class="fw-bolder bp-name">{{$cp->product_name}}</p>
                                            </div>
                                        </a>
                                        <!-- <p class="distance m-0"><i class="fa-solid fa-location-arrow"></i>15km distance</p> -->
                                    </div>
                                </div>
                            <?php }?>
                            
    
                    </div>
                    <?php }else{ ?>
                    <h1 class="distance m-0" > No Data Found !!</h1>
                    <?php }?>
                </div>
       
            </div>
        </div>
        
        
    </div>
    
</section>

<!--FILTER TOGGLE JS-->
<script>

   $(document).ready(function() {
    const $bpTogg = $(".bp-filter-btn-toggle");
    const $bpBody = $(".bp-filter");

    $bpTogg.click(function() {
        $bpBody.toggleClass("active-bp-filter");
    });
    });

</script>


    @endsection
