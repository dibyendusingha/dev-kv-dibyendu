<?php

use Illuminate\Support\Facades\DB; 
//print_r($promotionDetails);
$url = Request::path();
$exp = explode('/', $url);

if (!empty($exp[1])) {
    $promotion_id = $exp[1];
}
$base_url = url('/');
?>
<?php
    if (!empty($promotionDetails->user_type_id)) {
        if ($promotionDetails->user_type_id == 0) {
            $user_type_name =  "Viewers";
        } else if ($promotionDetails->user_type_id == 1) {
            $user_type_name =  "Individual";
        } else if ($promotionDetails->user_type_id == 2) {
            $user_type_name =  "Individual seller";
        } else if ($promotionDetails->user_type_id == 3) {
            $user_type_name = "Dealer";
        } else if ($promotionDetails->user_type_id == 4) {
            $user_type_name =  "Exchanger";
        }
    }
?>

<?php
    if (!empty($promotionDetails->gst)) {
        $type = 'GST';
    }else if (!empty($promotionDetails->cgst)){
        $type = 'CGST';
    }else if (!empty($promotionDetails->sgst)){
        $type = 'SGST';
    }else if (!empty($promotionDetails->igst)){
        $type = 'IGST';
    }
?>


@extends('admin.layout.main')
@section('page-container')
<section class="content-main">
    <div class="content-header">
        <div class="w-100 d-flex align-items-center justify-content-between">
            <h2 class="content-title card-title">Update Promotion</h2>
        </div>
    </div>

 

    <div class="card mb-4">
        <!-- card-header end// -->
        <div class="card-body">

      <div class="row w-75 mx-auto">
        <div class="col-md-3">
            <h5>User Name: <span class="text-success fw-bold">{{$promotionDetails->userName}}</span></h5>
        </div>
        <div class="col-md-3">
            <h5>Paid Amount: <span class="text-warning fw-bold">Rs. {{$promotionDetails->downpayment_price}}</span></h5>
        </div>
        <div class="col-md-3">
            <h5>Due Amount: <span class="text-danger fw-bold">Rs. {{$promotionDetails->due_amount}}</span></h5>
        </div>
        <div class="col-md-3">
            <h5>Total Amount: <span class="text-info fw-bold">Rs. {{$promotionDetails->total_amount}}</span></h5>
        </div>
      </div>

            

        </div>
    </div>
    <!-- card-body end// -->
    <?php

    //echo "Date ".date('Y m d H:i:s');

    ?>

    <div class="card mb-4 animate__animated animate__fadeIn coupon-form">
        <!-- card-header end// -->
        <div class="card-body">
            <form method="post" action="{{url('update-promotion',$promotion_id)}}"  class="form-otp">
                @csrf
                <div class="row">
                    <input type="hidden" name="user_id" value="John Doe">

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">User Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="user_name" value="{{$promotionDetails->userName}}" readonly>

                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Phone No. <span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="user_mobile" value="{{$promotionDetails->userMobile}}" readonly>
                    </div>


                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Address.<span class="text-danger">*</span></label>
                        <?php if(!empty($promotionDetails->userAddress)){ ?>
                        <input type="text" class="form-control result-field-copy" name="user_mobile" value="{{$promotionDetails->userAddress}}" readonly>
                        <?php }else{ ?>
                            <input type="text" class="form-control result-field-copy" name="user_mobile" value="{{$promotionDetails->state_name}}" readonly>
                        <?php } ?>
                    </div>
                    
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">User Type <span class="text-danger">*</span></label>

                        <input type="text" class="form-control" name="" value="{{$user_type_name}}" readonly>
                    </div>

                
                        <div class="mb-2 col-md-6">
                            <label for="product_slug" class="form-label">Package<span class="text-danger">*</span></label>
                            <select class="form-select" name="package_name" id="productSelect" onchange="getProductPrice(this.value)" >
                                <option value="" selected>{{$promotionDetails->package_name}}</option>
                            </select>
                        </div>
                    
                        <div class="mb-2 col-md-6">
                            <label for="product_slug" class="form-label">Purchase Price*<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="" value="{{$promotionDetails->package_price}}" readonly>
                           
                        </div>
                  

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Discount<span class="text-danger">*</span></label>
                        <input type="number" class="form-control result-field-copy"  name="purchase_price" value="{{$promotionDetails->discount}}" readonly>
                        
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Downpayment<span class="text-danger">*</span></label>
                        <input type="number" class="form-control result-field-copy" name="discount" value="{{$promotionDetails->downpayment_price}}" readonly>
                        
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Mode of transaction<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" value="{{$promotionDetails->transaction_type}}" readonly>
                    </div>

                    <?php if($promotionDetails->transaction_type == 'online'){ ?>
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Transaction Id<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" value="{{$promotionDetails->transaction_id}}" readonly>
                    </div>
                    <?php } ?>

                    <?php if($promotionDetails->transaction_type == 'online'){ ?>
                    <div class="mb-2 col-md-6" id="inputField">
                        <label for="product_slug" class="form-label">Order Id<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy"  value="{{$promotionDetails->order_id}}" readonly>
                    </div>
                    <?php } ?>


                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Type<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" value="{{$type}}" readonly>
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Days<span class="text-danger"></span></label>
                        <input type="text" class="form-control result-field-copy" name="total_days" value=""  required>
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Buffer Days <span class="text-danger"></span></label>
                        <input type="text" class="form-control result-field-copy" name="buffer_days" value="" required>
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Market User Name<span class="text-danger">*</span></label>
                        <select class="form-select" name="market_user_id" >
                            <option value="" selected>{{$promotionDetails->marketUserName}}</option>
                        </select>  
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Due Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" value="{{$promotionDetails->due_amount}}" readonly >
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Total Payment Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" value="{{$promotionDetails->total_amount}}" readonly >
                    </div>
                    
                    <div class="mb-2 col-md-12">
                       <div class="settlement shadow p-3 mt-4 w-50 mx-auto border border-secondary">
                       <label for="product_slug" class="form-label">Settlement Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="settlement_amount" value="" required >
                       </div>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary" id="boost-post">Submit</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="otpSent()" id="boost-post">Submit</button> -->
                </div>

            </form>
        </div>
    </div>
    <!-- card-body end// -->
    </div>
    <!-- card end// -->

</section>

<!-- content-main end// -->

<script>
    const generateCoupon = document.querySelector("#generate_coupon");
    const formCoupon = document.querySelector(".coupon-form");
    generateCoupon.addEventListener("click", () => {
        const resultField = document.querySelectorAll(".result-field");
        const resultFieldCopy = document.querySelectorAll(".result-field-copy");
        formCoupon.classList.remove("d-none");
        resultField.forEach((element, index) => {
            resultFieldCopy[index].value = element.innerHTML;
        });
    })
</script>

<style>
    .hidden {
        display: none;
    }
</style>

<script>
    const selectElement = document.getElementById('optionSelect1');
    const inputField = document.getElementById('inputField');


    selectElement.addEventListener('change', function() {
        if (selectElement.value === '') {
            inputField.classList.add('hidden');
        } else if (selectElement.value === 'offline') {
            inputField.classList.add('hidden');
        } else if (selectElement.value === 'online') {
            inputField.classList.remove('hidden');
        }
    });
</script>

<script>
    function getProductPrice(productId) {
        console.log(productId);
        $.ajax({
            url: "{{ route('get.package.price') }}",
            method: 'POST',
            data: {
                product_id: productId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                $('#productPrice').val(response.price);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
</script>


@endsection