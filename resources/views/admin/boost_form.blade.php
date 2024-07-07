@extends('admin.layout.main')
@section('page-container')
<?php

use Illuminate\Support\Facades\DB;

$url = Request::path();
$parts = explode('/', $url);
$category = $parts[1];
$product_id = $parts[2];
//    echo $product_id;

//print_r($product);
// $user_name = DB::table('user')->select('user.name')->where()->first();
?>

<section class="content-main">
    <div class="content-header">
        <div class="w-100 d-flex align-items-center justify-content-between">
            <h2 class="content-title card-title"><i class="fa-solid fa-rocket me-1"></i>Boost Product</h2>
            <?php if (!empty($msg)) { ?>
            <div class="err-msg animate__animated animate__shakeX">
                <i class="ri-error-warning-fill fs-5"></i> {{$msg}}
                <?php 
                    // if (!empty($msg)) {
                    //     echo $msg;
                    // } 
                ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="card mb-4">

        <!-- card-header end// -->
        <div class="card-body">

            <form method="post" action="{{url('add-boost-payment',[$category,$product_id])}}" id="myForm" class="form-otp">
                @csrf
                <div class="row">
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">User Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{$product->name}}" readonly>
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Subscription Boosts plan <span class="text-danger">*</span></label>
                        <select class="form-select" name="subscription_boosts_id" required>
                            <option value="">-- select plan --</option>
                            <option value="1" selected>Trial 99</option>

                        </select>
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="category_name" value="{{$category}}" readonly>
                    </div>


                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="product_name" value="{{$product->brand_name}}" readonly>
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Days <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="days" value="" required>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Purchased Price <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="purchased_price" value="" required>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Transaction<span class="text-danger">*</span></label>
                        <select class="form-select" name="transaction_type" id="optionSelect" required>
                            <option value="" selected>--select--</option>
                            <option value="cash">Cash</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                    <div class="mb-2 col-md-6" id="inputField">
                        <label for="product_slug" class="form-label">Transaction No <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="transaction_id" value="">
                    </div>
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">GST/CGST <span class="text-danger">*</span></label>
                        <select class="form-select" name="tax" required>
                            <option value="" selected>--select--</option>
                            <option value="gst">GST</option>
                            <option value="cgst">CGST</option>
                        </select>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Market User Name<span class="text-danger">*</span></label>
                        <select class="form-select" name="market_user_id" required>
                            <option value="" selected>-- select user name --</option>
                            @foreach($market_user as $mu)
                            <option value="{{$mu->id}}">{{$mu->name}}</option>
                            @endforeach

                        </select>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="button" class="btn btn-primary" onclick="otpSent()" id="boost-post">BOOST POST</button>
                </div>

                <div class="otp-wrapper d-none ">
                    <div class="container-otp">
                        <header class="header-otp d-flex align-items-center">
                            <i class="bx bxs-check-shield"></i>
                        </header>
                        <h4>Enter OTP Code</h4>

                        <div class="input-field-otp">
                            <input type="number" name="first" />
                            <input type="number" name="second" disabled />
                            <input type="number" name="third" disabled />
                            <input type="number" name="forth" disabled />
                        </div>
                        <button type="submit" class="btn disabled mt-4">Verify OTP</button>
                        <button type="button" class="btn btn-secondary" onclick="otpSent()">Resend OTP</button>


                    </div>
                </div>
        </div>


        </form>
        <!-- <div class="otp-wrapper d-none ">
            <div class="container-otp">
                <header class="header-otp d-flex align-items-center">
                    <i class="bx bxs-check-shield"></i>
                </header>
                <h4>Enter OTP Code</h4>

                <div class="input-field-otp">
                    <input type="number" />
                    <input type="number" disabled />
                    <input type="number" disabled />
                    <input type="number" disabled />
                </div>
                <button type="button" class="btn disabled mt-4">Verify OTP</button>


            </div>
        </div> -->
    </div>
    <!-- card-body end// -->
    </div>
    <!-- card end// -->

</section>

<!-- content-main end// -->
<?php
// $segment = Request::segment(2);
?>

<script>
    setTimeout(() => {
        $(".err-msg").fadeOut();
    }, 4000)

    function otpSent() {
        var product_id = '<?php echo $product_id; ?>';
        var category = '<?php echo $category ?>';
        var base_url = '<?php echo url('/') . '/'; ?>';
        console.log(product_id);
        console.log(category);

        $.ajax({
            type: 'GET',
            url: base_url + 'boost-otp-sent/' + category + '/' + product_id,
            success: function(response) {
                console.log('Success:', response);
                alert("otp sent successfully");
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#myForm').submit(function(e) {
            var category = <?php echo $category; ?>;
            var product_id = <?php echo $product_id; ?>;
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'add-boost-payment/' + category + '/' + product_id,
                success: function(response) {
                    console.log("response");
                    // if(response.message === true){
                    //     alert('OTP not matched');

                    // }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>


<style>
    .hidden {
        display: none;
    }
</style>

<script>
    const selectElement = document.getElementById('optionSelect');
    const inputField = document.getElementById('inputField');


    selectElement.addEventListener('change', function() {
        if (selectElement.value === '') {
            inputField.classList.add('hidden');
        } else if (selectElement.value === 'cash') {
            inputField.classList.add('hidden');
        } else if (selectElement.value === 'online') {
            inputField.classList.remove('hidden');
        }
    });
</script>

<script>
    const inputs = document.querySelectorAll(".otp-wrapper input"),
        buttonVerify = document.querySelector(".otp-wrapper button");

    // iterate over all inputs
    inputs.forEach((input, index1) => {
        input.addEventListener("keyup", (e) => {
            // This code gets the current input element and stores it in the currentInput variable
            // This code gets the next sibling element of the current input element and stores it in the nextInput variable
            // This code gets the previous sibling element of the current input element and stores it in the prevInput variable
            const currentInput = input,
                nextInput = input.nextElementSibling,
                prevInput = input.previousElementSibling;

            // if the value has more than one character then clear it
            if (currentInput.value.length > 1) {
                currentInput.value = "";
                return;
            }
            // if the next input is disabled and the current value is not empty
            //  enable the next input and focus on it
            if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                nextInput.removeAttribute("disabled");
                nextInput.focus();
            }

            // if the backspace key is pressed
            if (e.key === "Backspace") {
                // iterate over all inputs again
                inputs.forEach((input, index2) => {
                    // if the index1 of the current input is less than or equal to the index2 of the input in the outer loop
                    // and the previous element exists, set the disabled attribute on the input and focus on the previous element
                    if (index1 <= index2 && prevInput) {
                        input.setAttribute("disabled", true);
                        input.value = "";
                        prevInput.focus();
                    }
                });
            }
            //if the fourth input( which index number is 3) is not empty and has not disable attribute then
            //add active class if not then remove the active class.
            if (!inputs[3].disabled && inputs[3].value !== "") {
                buttonVerify.classList.remove("disabled");
                return;
            }
            buttonVerify.classList.add("disabled");
        });
    });

    //focus the first input which index is 0 on window load
    window.addEventListener("load", () => inputs[0].focus());

    const boostPost = document.querySelector("#boost-post");
    const otpPage = document.querySelector(".otp-wrapper");
    boostPost.addEventListener("click", () => {
        otpPage.classList.remove("d-none");
        console.log("clicked");
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector('.form-otp');
        const inputs = form.querySelectorAll('input, select');
        const boostPostButton = document.getElementById('boost-post');

        function checkFormValidity() {
            let isValid = true;

            inputs.forEach(input => {
                if (input.required && !input.value.trim()) {
                    isValid = false;
                }
            });

            if (isValid) {
                boostPostButton.classList.remove('disabled');
            } else {
                boostPostButton.classList.add('disabled');
            }
        }

        inputs.forEach(input => {
            input.addEventListener('change', checkFormValidity);
        });

        // Trigger initial check
        checkFormValidity();
    });
</script>




@endsection