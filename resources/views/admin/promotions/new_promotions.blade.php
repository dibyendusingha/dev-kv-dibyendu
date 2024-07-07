<?php

use Illuminate\Support\Facades\DB; ?>


@extends('admin.layout.main')
@section('page-container')
<section class="content-main">
    <div class="content-header">
        <div class="w-100 d-flex align-items-center justify-content-between">
            <h2 class="content-title card-title">Add Promotion</h2>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card pb-4">
        <!-- card-header end// -->
        <div class="card-body">
            @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @elseif(session('failed'))
            <div class="alert alert-danger" role="alert">
                {{ session('failed') }}
            </div>
            @endif
        </div>
        <form method="post" action="{{ url('new-promotion')}}" class="d-flex align-items-center gap-2 w-50 mx-auto">
            @csrf
            <label for="#" class="fw-bold" style="text-wrap: nowrap;">Search By Mobile No: </label>
            <input type="number" name="mobile_no" class="form-control" value="{{ old('mobile_no') }}">
            <button type="submit" class="rounded border-0 bg-dark text-white p-2"><i class="ri-search-2-line me-1"></i></button>
            @error('mobile_no')
            <span class="" style="color:red">{{ $message }}</span>
            @enderror
        </form>
    </div>
    </div>
    <!-- card-body end// -->
    <!-- Search Bar -->
    <div class="card mb-4">
        <!-- card-header end// -->
        <div class="card-body">

            <?php
            // print '<pre>';
            // print_r($userData);

            ?>
            <h5>Results:</h5>
            <hr>
            <?php
            if (!empty($userData)) {
            ?>
                <div class="row align-items-center gap-2 justify-content-center">
                    <input type="hidden" name="user_id" value="<?php if (!empty($userData->id)) {
                                                                    echo $userData->id;
                                                                } ?>">
                    <?php
                    $stateName  = DB::table('state')->where('id', $userData->state_id)->first()->state_name;

                    if (!empty($userData->user_type_id)) {
                        if ($userData->user_type_id == 0) {
                            $user_type_name = "Viewers";
                        } else if ($userData->user_type_id == 1) {
                            $user_type_name = "Individual";
                        } else if ($userData->user_type_id == 2) {
                            $user_type_name = "Individual seller";
                        } else if ($userData->user_type_id == 3) {
                            $user_type_name = "Dealer";
                        } else if ($userData->user_type_id == 4) {
                            $user_type_name = "Exchanger";
                        }
                    }

                    ?>


                    <div class="col-md-2">
                        <label for="#" class="fw-bold ">Name: </label>
                        <p class="result-field"><?php if (!empty($userData->name)) {
                                                    echo $userData->name;
                                                } ?></p>
                    </div>
                    <div class="col-md-2">
                        <label for="#" class="fw-bold">Phone No: </label>
                        <p class="result-field"><?php if (!empty($userData->mobile)) {
                                                    echo $userData->mobile;
                                                } ?></p>
                    </div>
                    <div class="col-md-2">
                        <label for="#" class="fw-bold">Address: </label>
                        <p class="result-field"><?php if (!empty($userData->address)) {
                                                    echo $userData->address;
                                                } ?></p>
                    </div>
                    <div class="col-md-2">
                        <label for="#" class="fw-bold">User Type: </label>
                        <p class="result-field"><?php
                                                if (!empty($userData->user_type_id)) {
                                                    if ($userData->user_type_id == 0) {
                                                        echo "Viewers";
                                                    } else if ($userData->user_type_id == 1) {
                                                        echo "Individual";
                                                    } else if ($userData->user_type_id == 2) {
                                                        echo "Individual seller";
                                                    } else if ($userData->user_type_id == 3) {
                                                        echo "Dealer";
                                                    } else if ($userData->user_type_id == 4) {
                                                        echo "Exchanger";
                                                    }
                                                }
                                                ?></p>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="rounded border-0 bg-dark text-white p-2" id="generate_coupon">Generate Coupon</button>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
    <!-- card-body end// -->
    <?php

    //echo "Date ".date('Y m d H:i:s');

    ?>

    <div class="card mb-4 animate__animated animate__fadeIn d-none coupon-form">
        <!-- card-header end// -->
        <div class="card-body">
            <form method="post" action="{{ url('add-promotion-coupon')}}" id="myForm" class="form-otp">
                @csrf
                <div class="row">
                    <input type="hidden" name="user_id" value="<?php if (!empty($userData->id)) {
                                                                    echo $userData->id;
                                                                } ?>">

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">User Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="user_name" value="" readonly>

                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Phone No. <span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="user_mobile" value="" readonly>
                    </div>

                    <?php if (!empty($userData->address)) {  ?>
                        <div class="mb-2 col-md-6">
                            <label for="product_slug" class="form-label">Address. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control result-field-copy" name="user_address" value="" readonly>
                        </div>
                    <?php } else if (!empty($stateName)) { ?>
                        <div class="mb-2 col-md-6">
                            <label for="product_slug" class="form-label">Address.<span class="text-danger">*</span></label>
                            <input type="text" name="user_address" class="form-control" value="{{$stateName}}" readonly>
                        </div>
                    <?php } ?>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">User Type <span class="text-danger">*</span></label>
                        <?php if (!empty($user_type_name)) { ?>
                            <input type="text" class="form-control" name="" value="{{$user_type_name}}" readonly>
                        <?php } ?>
                    </div>

                    <?php 
                    if(!empty($userData->user_type_id)){
                        if ($userData->user_type_id == 3 || $userData->user_type_id == 4) { ?>
                        <div class="mb-2 col-md-6">
                            <label for="product_slug" class="form-label">Package<span class="text-danger">*</span></label>
                            <select class="form-select" name="package_name" id="productSelect" onchange="getProductPrice(this.value)" required>
                                <option value="" selected>--select--</option>
                                <?php
                                $package_details = DB::table('promotion_package')->where('user_type_id', $userData->user_type_id)->get();
                                if (!empty($package_details)) {
                                    foreach ($package_details as $package) {
                                ?>
                                    <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            @error('package_name')
                            <span class="" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    <?php } else { ?>

                        <div class="mb-2 col-md-6">
                            <label for="product_slug" class="form-label">Package<span class="text-danger">*</span></label>
                            <select class="form-select" name="package_name" id="optionSelect" required>
                                <option value="">--select--</option>
                                <?php
                                if (!empty($packageName)) {
                                    foreach ($packageName as $package) {
                                ?>
                                        <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            @error('package_name')
                            <span class="" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    <?php } } ?>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Purchase Price<span class="text-danger">*</span></label>
                        <input type="number" class="form-control result-field-copy" id="productPrice" name="purchase_price" value="" readonly>
                        @error('purchase_price')
                        <span class="" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Discount (%)<span class="text-danger">*</span></label>
                        <input type="number" class="form-control result-field-copy" name="discount" value="">
                        @error('discount')
                        <span class="" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Types<span class="text-danger">*</span></label>
                        <select class="form-select" name="types_of_interest" id="optionSelect" onchange="getType(this.value)" required>
                            <option value="" selected>--select--</option>
                            <option value="gst">GST</option>
                            <option value="cgst">CGST</option>
                            <option value="cgst">SGST</option>
                            <option value="igst">IGST</option>
                        </select>
                        @error('transaction_type')
                        <span class="" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-2 col-md-12">
                        <label for="product_slug" class="form-label">Total Payment Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control result-field-copy" id="totalAmount" name="total_amount" value="" readonly>
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Downpayment<span class="text-danger">*</span></label>
                        <input type="number" class="form-control result-field-copy" name="down_payment" value="">
                        @error('discount')
                        <span class="" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Mode of transaction<span class="text-danger">*</span></label>
                        <select class="form-select" name="transaction_type" id="optionSelect1" required>
                            <option value="">--select--</option>
                            <option value="online" selected>Online</option>
                            <option value="offline" >Offline</option>
                        </select>
                        @error('transaction_type')
                        <span class="" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-2 col-md-6" id="inputField">
                        <label for="product_slug" class="form-label">Transaction Id<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="transaction_id" value="">
                    </div>


                    <div class="mb-2 col-md-6" id="inputField1">
                        <label for="product_slug" class="form-label">Order Id<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="order_id" value="">
                    </div>

                    <!-- <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Types<span class="text-danger">*</span></label>
                        <select class="form-select" name="types_of_interest" id="optionSelect" onchange="getType(this.value)" required>
                            <option value="" selected>--select--</option>
                            <option value="gst">GST</option>
                            <option value="cgst">CGST</option>
                            <option value="cgst">SGST</option>
                            <option value="igst">IGST</option>
                        </select>
                        @error('transaction_type')
                        <span class="" style="color:red">{{ $message }}</span>
                        @enderror
                    </div> -->

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Days<span class="text-danger">*</span></label>
                        <input type="number" class="form-control result-field-copy" name="promotion_days" value="">
                        @error('promotion_days')
                        <span class="" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Buffer Days<span class="text-danger">*</span></label>
                        <input type="number" class="form-control result-field-copy" name="buffer_days" value="">
                        @error('buffer_days')
                        <span class="" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Market User Name<span class="text-danger">*</span></label>
                        <select class="form-select" name="market_user_id" required>
                            <option value="">-- select user name --</option>
                            <?php
                            if (!empty($marketerName)) {
                                foreach ($marketerName as $key => $names) {
                            ?>
                                    <option value="<?php echo $names->id; ?>"><?php echo $names->name; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        @error('market_user_id')
                        <span class="" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Purchase Price<span class="text-danger">*</span></label>
                        <input type="number" class="form-control result-field-copy" id="totalAmount" name="total_amount" value="" readonly>
                    </div> -->

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
    generateCoupon.addEventListener("click", () => {inputField
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
    const inputField  = document.getElementById('inputField');
    const inputField1 = document.getElementById('inputField1');

    selectElement.addEventListener('change', function() {
        if (selectElement.value === '') {
            inputField.classList.add('hidden');
        } else if (selectElement.value === 'offline') {
            inputField.classList.add('hidden');
            inputField1.classList.add('hidden');
        } else if (selectElement.value === 'online') {
            inputField.classList.remove('hidden');
            inputField1.classList.remove('hidden');
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

    function getType(type) {
        var purchasePriceInput = document.querySelector('input[name="purchase_price"]').value;
        var discount           = document.querySelector('input[name="discount"]').value;
        console.log(discount);
        console.log(type);
        
        $.ajax({
            url: "{{ route('promotion.total.amount') }}",
            method: 'POST',
            data: {
                package_price: purchasePriceInput,
                discount: discount,
                type: type,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#totalAmount').val(response.total_amount);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
</script>


@endsection