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


<section class="brand-product-body">
    
    <div class="container">
        
        
        <?php
          $productName         = $product_name;
          $productImage        = $product_image;
          $companyDescription  = $company_description;
          $companyPrice        = $company_price;
          $companyId           = $company_id;
          $companyName         = DB::table('company')->where('id',$companyId)->first()->brand_name_full;
        ?>
        <h5><span>Product Name : </span>{{$product_name}}</h5>
        <h5><span>Product Image : </span></h5>  
        {{-- <img src="<?= env('APP_URL')."storage/company/$product_image"; ?>" alt="logo"  class="d-inline-block p-2 img-fluid"><br/> --}}
        <?php if($companyId == 1 || $companyId == 11 || $companyId == 12){ ?> 
            {{-- <img src="<?= env('APP_URL')."storage/iffco/products/$product_image"; ?>" alt="logo"  class="d-inline-block p-2 img-fluid"><br/> --}}
            <div style="width: 50%; margin: 0 auto;">
                <img src="{{asset('storage/iffco/products/'.$product_image)}}" alt="logo"  class="d-inline-block p-2 img-fluid">
            </div>
        <?php }else{?>
            {{-- <img src="<?= env('APP_URL')."storage/company/products/$product_image"; ?>" alt="logo"  class="d-inline-block p-2 img-fluid"><br/> --}}
            <div style="width: 50%; margin: 0 auto;">
                <img src="{{asset('storage/company/products/'.$product_image)}}" alt="logo"  class="d-inline-block p-2 img-fluid"></div><br/>
        <?php } ?>


        <?php if($companyId == 1 || $companyId == 11 || $companyId == 12 ){ ?>
            <h5><span>Product Description : </span></h5>
            
                 <div>{!! html_entity_decode($companyDescription) !!}</div>
            

       <? }else{ ?>
         <h5><span>Product Description : </span></h5>
         <p>{{$companyDescription}}</p><br/>
        <?php } ?>
        
        <h5><span>Product price : </span>{{$companyPrice}}</h5> <br/>
        
        <h5><span>Company Name : </span> {{$companyName}}</h5> <br/>
        <div class="row">
            <div class="col-md-12 p-4">
                
                <div class="brand-product-container">
                    <div class="row">
                        <?php foreach($dealer as $d){ 
                          //  print_r($dealer);
                        ?>
                        <div class="col-lg-6 mb-5 px-4">
                            <div class="dealer-card">
                                <div class="dealer-top text-center">
                                    <p>{{$d->name}}</p>
                                </div>
                                <div class="dealer-location">
                                    <?php  $address = substr($d->address , 0 , 100);?>
                                    <p class="m-0"><i class="fa-solid fa-map"></i>  {{$d->address}}</p>
                                </div>
                                <div class="dealer-foot d-flex align-items-center justify-content-center my-3">
                                    <div class="call-btn animate__animated animate__pulse animate__slow animate__infinite">
                                        <a href="tel:$d->mobile">
                                            <p class="m-0"><i class="fa-solid fa-phone"></i> <span class="px-2">{{$d->mobile}}</span></p>
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
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
