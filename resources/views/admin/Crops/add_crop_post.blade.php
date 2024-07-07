@extends('admin.layout.main')
@section('page-container')

<style>
    .preview-image {
        width: 100%;
        height: 200px;
        object-fit: contain;
        object-position: center;
        margin-top: 20px
    }
</style>

<?php
//print_r($crops_category); 
?>

<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">ADD CROPS SUBSCRIPTION</h2>
            <p>Fill New Crops Details</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card pb-4">
        <!-- card-header end// -->
        <div class="card-body">
        </div>
        @if(session('message'))
            <div class="err-msg animate__animated animate__shakeX w-25 ms-auto mb-5">
                <i class="ri-error-warning-fill fs-5">{{ session('message') }}</i>
            </div>
        @endif
        <form method="post" action="{{url('search-crop-user')}}" class="d-flex align-items-center gap-2 w-50 mx-auto" onsubmit="return searchValidateForm()">
            @csrf
            <label for="#" class="fw-bold" style="text-wrap: nowrap;">Search By Mobile No: </label>
            <input type="text" name="mobile_no" id="mobile_no" class="form-control" value="" onkeypress="return allowOnlyNumbers(event)">
            <button type="submit" class="rounded border-0 bg-dark text-white p-2"><i class="ri-search-2-line me-1"></i></button>
        </form>
    </div>

    <!-- card-body end// -->
    <?php if (!empty($userData)) { ?>
        <!-- Search Bar -->
        <div class="card mb-4">
            <!-- card-header end// -->
            <div class="card-body">

                <h5>Results:</h5>
                <hr>
                <div class="row align-items-center gap-2 justify-content-center">
                    <div class="col-md-2">
                        <label for="#" class="fw-bold ">Name: </label>
                        <p class="result-field">{{$userData->name}}</p>
                    </div>
                    <div class="col-md-2">
                        <label for="#" class="fw-bold">Phone No: </label>
                        <p class="result-field">{{$userData->mobile}}</p>
                    </div>
                    <div class="col-md-2">
                        <label for="#" class="fw-bold">Address: </label>
                        <p class="result-field">{{$userData->address}}</p>
                    </div>
                    <div class="col-md-2">
                        <label for="#" class="fw-bold">User Type: </label>
                        <?php if ($userData->user_type_id == 2) { ?>
                            <p class="result-field">Seller</p>
                        <?php } else if ($userData->user_type_id == 3) { ?>
                            <p class="result-field">Dealer</p>
                        <?php } else if ($userData->user_type_id == 4) { ?>
                            <p class="result-field">Exchanger</p>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="rounded border-0 bg-dark text-white p-2" id="generate_coupon">Create Post</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- card-body end// -->

        <div class="card mb-4 animate__animated animate__fadeIn coupon-form d-none">
            <!-- card-header end// -->
            <div class="card-body">

                <form enctype="multipart/form-data" class="row justify-content-center" onsubmit="return validateForm()" method="post" action="{{url('verify-crops-data')}}">
                    @csrf
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">User Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="user_name" id="user_name" readonly />
                        <?php if (!empty($userData->id)) { ?>
                            <input type="hidden" class="form-control" name="user_id" value="{{$userData->id}}" readonly />
                        <?php } ?>
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">Phone No<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="phone_no" id="phone_no" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">Address<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="address" id="address" readonly />
                    </div>

                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">Package Name<span class="text-danger">*</span></label>
                        <select class="form-control" name="package_name" id="package_name" onchange="getPackagePrice(this.value)" />
                        <option value="" selected>-- select --</option>
                        <?php if (!empty($packageName)) { ?>
                            @foreach($packageName as $package)
                            <option value="{{$package->id}}">{{$package->crop_subscriptions_name}}</option>
                            @endforeach
                        <?php } ?>
                        </select>
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">Package Price<span class="text-danger">*</span></label>
                        <input class="form-control" name="package_price" id="package_price" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">Package Total Days<span class="text-danger">*</span></label>
                        <input class="form-control" name="package_days" id="package_days" type="text" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">Start Date<span class="text-danger">*</span></label>
                        <input class="form-control" name="start_date" id="start_date" type="text" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">End Date<span class="text-danger">*</span></label>
                        <input class="form-control" name="end_date" id="end_date" type="text" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="districtSelect" class="form-label">Discount</label>
                        <input type="text" class="form-control" name="discount" id="discount" onkeypress="return allowOnlyNumbers(event)" />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">Types<span class="text-danger">*</span></label>
                        <select class="form-control" name="type" id="type" onchange="getTotalPrice(this.value)">
                            <option value="">-- select --</option>
                            <option value="GST">GST</option>
                            <option value="CGST">CGST</option>
                            <option value="SGST">SGST</option>
                            <option value="IGST">IGST</option>
                        </select>
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">Total Payment<span class="text-danger">*</span></label>
                        <input class="form-control" name="total_payment" id="total_payment" type="text" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">Down Payment<span class="text-danger">*</span></label>
                        <input class="form-control" name="down_payment" id="down_payment" type="text" onkeypress="return allowOnlyNumbers(event)" />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="product_slug" class="form-label">Mode of transaction<span class="text-danger">*</span></label>
                        <select class="form-control" name="mode_transaction" id="mode_transaction">
                            <option value="online" selected>Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                    <div class="mb-4 col-md-4" id="inputField">
                        <label for="product_slug" class="form-label">Transaction Id</label>
                        <input type="text" class="form-control" name="transaction_id" id="transaction_id" />
                    </div>
                    <div class="mb-4 col-md-4" id="inputField1">
                        <label for="product_slug" class="form-label">Order Id</label>
                        <input type="text" class="form-control" name="order_id" id="order_id" />
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="SUBMIT">
                    </div>
                </form>

                <!-- .row // -->
            </div>

        </div>
        <!-- card-body end// -->

        <!-- card end// -->
    <?php } ?>

</section>


<script>
    // Function to preview image before upload
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#' + previewId).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    // Event listener for file inputs
    $('#image1').change(function() {
        previewImage(this, 'preview-image1');
    });

    $('#image2').change(function() {
        previewImage(this, 'preview-image2');
    });

    $('#image3').change(function() {
        previewImage(this, 'preview-image3');
    });
</script>

<!-- FORM VALIDATION -->
<script>
    function validateForm() {


        var package_name = document.getElementById("package_name").value;
        var start_date = document.getElementById("start_date").value;
        var end_date = document.getElementById("end_date").value;
        var type = document.getElementById("type").value;
        var total_payment = document.getElementById("total_payment").value;
        var down_payment = document.getElementById("down_payment").value;
        var mode_transaction = document.getElementById("mode_transaction").value;


        if (package_name == "") {
            alert("Package Name must be filled out");
            return false;
        }
        if (start_date == "") {
            alert("Start date must be filled out");
            return false;
        }
        if (end_date == "") {
            alert("End date must be filled out");
            return false;
        }
        if (type == "") {
            alert("Type must be filled out");
            return false;
        }
        if (total_payment == "") {
            alert("Total Payment be filled out");
            return false;
        }
        if (down_payment == "") {
            alert("Down Payment be filled out");
            return false;
        }
        if (mode_transaction == "") {
            alert("Mode transaction be filled out");
            return false;
        }
        if (image1 == "") {
            alert("Image 1 be filled out");
            return false;
        }
    }

    function searchValidateForm() {
        var mobile_no = document.getElementById("mobile_no").value;
        var mobile_no_length = mobile_no.length;

        if (mobile_no == "") {
            alert("Mobile No must be filled out");
            return false;
        }else if(mobile_no_length > 10){
            alert("Mobile No  must be 10 characters");
            return false;
        }
    }
</script>

<!-- Zipcode Maximum 6 characters -->
<script>
    var mobile_no = document.getElementById("mobile_no");
    mobile_no.addEventListener("input", function() {
        if (mobile_no.value.length > 10) {
            mobile_no.value = mobile_no.value.slice(0, 10);
        }
    });
</script>

<!-- KEY PRESS -->
<script>
    function allowOnlyNumbers(event) {
        var keyCode = event.keyCode || event.which;
        if ((keyCode < 48 || keyCode > 57) && keyCode !== 8) {
            return false;
        }
        return true;
    }
</script>

<!-- CROP CATEGORY NAME -->
<script>
    const crop_category_name = document.getElementById('crop_category_name');
    //  console.log(crop_category_name.value);
    const crop_title = document.getElementById('cropTitle');

    crop_category_name.addEventListener('change', function() {
        if (crop_category_name.value === '') {
            crop_title.classList.add('hidden');
        } else if (crop_category_name.value === '13') {

            crop_title.classList.remove('hidden');
        } else {
            crop_title.classList.add('hidden');

        }
    });
</script>

<!-- MODE OF TRANSACTION -->
<script>
    const selectElement = document.getElementById('mode_transaction');
    const inputField = document.getElementById('inputField');
    const inputField1 = document.getElementById('inputField1');
    console.log(selectElement.value);

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
    const generateCoupon = document.querySelector("#generate_coupon");
    const formCoupon = document.querySelector(".coupon-form");
    generateCoupon.addEventListener("click", () => {
        inputField
        const resultField = document.querySelectorAll(".result-field");
        const resultFieldCopy = document.querySelectorAll(".result-field-copy");
        formCoupon.classList.remove("d-none");
        resultField.forEach((element, index) => {
            resultFieldCopy[index].value = element.innerHTML;
        });
    })
</script>

<!-- AJAX CALL -->
<script>
    function getPackagePrice(packageId) {
        console.log(packageId);
        $.ajax({
            url: "{{ route('package.details') }}",
            method: 'POST',
            data: {
                package_id: packageId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#package_price').val(response.price);
                $('#package_days').val(response.package_days);
                $('#start_date').val(response.start_date);
                $('#end_date').val(response.end_date);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    function getAddressDetails(zipcode) {
        var pincode = document.getElementById("zipcode").value;
        var pincode_length = pincode.length;
        console.log(pincode.length);

        if (pincode_length > 6) {
            alert("Pincode  must be 6 characters");
            return false;

        } else if (pincode_length == 6) {
            $.ajax({
                url: "{{ route('address.details') }}",
                method: 'POST',
                data: {
                    zipcode: zipcode,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    $('#state_id').val(response.state_id);
                    $('#state_name').val(response.state_name);
                    $('#district_id').val(response.district_id);
                    $('#district_name').val(response.district_name);
                    $('#city_id').val(response.city_id);
                    $('#city_name').val(response.city_name);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });

        }
    }

    function getTotalPrice(type) {
        console.log(type);
        var package_price = document.querySelector('input[name="package_price"]').value;
        var discount = document.querySelector('input[name="discount"]').value;

        console.log(package_price);
        console.log(discount);

        $.ajax({
            url: "{{ route('total.price') }}",
            method: 'POST',
            data: {
                package_price: package_price,
                discount: discount,
                type: type,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#total_payment').val(response.total_amount);

            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
</script>

<!-- Zipcode Maximum 6 characters -->
<script>
    var numberInput = document.getElementById("zipcode");
    numberInput.addEventListener("input", function() {
        if (numberInput.value.length > 6) {
            numberInput.value = numberInput.value.slice(0, 6);
        }
    });
</script>

@endsection