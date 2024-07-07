@extends('admin.layout.main')
@section('page-container')

<?php
    $url = Request::path();
    $parts = explode('/', $url);
    $crops_subscribed_id = end($parts);
?>
<style>
    .preview-image {
        width: 100%;
        height: 200px;
        object-fit: contain;
        object-position: center;
        margin-top: 20px
    }
</style>


<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">ADD CROPS POST</h2>
            <p>Fill New Crops Details</p>
        </div>
    </div>
    @if (session('message'))
        <div class="err-msg animate__animated animate__shakeX">
            <i class="ri-error-warning-fill fs-5">{{ session('message') }}</i>
        </div>
    @endif

    <?php if (!empty($crop_subscribed_post)) { ?>
        <div class="card mb-4 animate__animated ">
            <!-- card-header end// -->
            <div class="card-body">
                <form enctype="multipart/form-data" class="row justify-content-center" onsubmit="return validateForm()" method="post" action="{{url('verify-subscribed-crops-data',$crops_subscribed_id)}}">
                    @csrf
                    <div class="mb-4 col-md-4">
                        <label for="user_name" class="form-label">User Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="user_name" id="user_name" value="{{$crop_subscribed_post->username}}" readonly />
                        <input type="hidden" class="form-control" name="user_id" value="{{$crop_subscribed_post->user_id}}" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="phone_no" class="form-label">Phone No<span class="text-danger">*</span></label>
                        <input type="text" class="form-control result-field-copy" name="phone_no" id="phone_no" value="{{$crop_subscribed_post->user_mobile}}" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="zipcode" class="form-label">ZipCode<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="zipcode" id="zipcode" onkeyup="getAddressDetails(this.value)" />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="state_name" class="form-label">State Name<span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control" name="state_id" id="state_id" />
                        <input type="text" class="form-control" name="state_name" id="state_name" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="district_name" class="form-label">District Name<span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control" name="district_id" id="district_id" />
                        <input type="text" class="form-control" name="district_name" id="district_name" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="city_name" class="form-label">City Name<span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control" name="city_id" id="city_id" />
                        <input type="text" class="form-control" name="city_name" id="city_name" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="description" id="description" />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="crop_category_name" class="form-label">Crops Category Name<span class="text-danger">*</span></label>
                        <select class="form-control" name="crop_category_name" id="crop_category_name">
                            <option value="" selected>-- select --</option>
                            @foreach($crops_category as $crops_category)
                            <option value="{{$crops_category->id}}">{{$crops_category->crops_cat_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 col-md-4" id="cropTitle">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="title" />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="quantity" class="form-label">Crop Quantity<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="quantity" id="quantity" onkeypress="return allowOnlyNumbers(event)" />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="crop_type" class="form-label">Crop Type<span class="text-danger">*</span></label>
                        <select class="form-control" name="crop_type" id="crop_type">
                            <option value="" selected>-- select --</option>
                            <option value="kg">KG</option>
                            <option value="quintal">QUINTAL</option>
                            <option value="gm">GM</option>
                            <option value="ton">TON</option>
                        </select>
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="crop_price" class="form-label">Crop Price<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="crop_price" id="crop_price" onkeypress="return allowOnlyNumbers(event)" />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="is_negotiable" class="form-label">Is Negotiable<span class="text-danger">*</span></label>
                        <select class="form-control" name="is_negotiable" id="is_negotiable">
                            <option value="">-- select --</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="package_name" class="form-label">Package Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="package_name" id="package_name" value="{{$crop_subscribed_post->crop_subscriptions_name}}" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="package_price" class="form-label">Package Price<span class="text-danger">*</span></label>
                        <input class="form-control" name="package_price" id="package_price" value="{{$crop_subscribed_post->subscription_price}}" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="package_days" class="form-label">Package Total Days<span class="text-danger">*</span></label>
                        <input class="form-control" name="package_days" id="package_days" type="text" value="{{$crop_subscribed_post->subscription_days}}" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="start_date" class="form-label">Start Date<span class="text-danger">*</span></label>
                        <input class="form-control" name="start_date" id="start_date" type="text" value="{{$crop_subscribed_post->start_date}}" readonly />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="end_date" class="form-label">End Date<span class="text-danger">*</span></label>
                        <input class="form-control" name="end_date" id="end_date" type="text" value="{{$crop_subscribed_post->end_date}}" readonly />
                    </div>
                    <div class="mb-4 col-md-12" style="padding: 0 24px;">
                        <div class="row border rounded p-4">
                            <h5 class="mb-2">Upload Images</h5>
                            <div class="col-md-4">
                                <label for="image1" class="form-label">Image-1<span class="text-danger">*</span></label>
                                <input class="form-control" id="image1" name="image1" type="file">
                                <img id="preview-image1" class="preview-image" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-512.png" alt="">
                            </div>
                            <div class="col-md-4">
                                <label for="image2" class="form-label">Image-2</label>
                                <input class="form-control" id="image2" name="image2" type="file">
                                <img id="preview-image2" class="preview-image" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-512.png" alt="">
                            </div>
                            <div class="col-md-4">
                                <label for="image3" class="form-label">Image-3</label>
                                <input class="form-control" id="image3" name="image3" type="file">
                                <img id="preview-image3" class="preview-image" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-512.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="SUBMIT">
                    </div>
                </form>
            </div>




        </div>
        <!-- card-body end// -->
    <?php } ?>

    <?php
    //  } 
    ?>

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
        var zipcode = document.getElementById("zipcode").value;
        var description = document.getElementById("description").value;
        var crop_category_name = document.getElementById("crop_category_name").value;
        var quantity = document.getElementById("quantity").value;
        var crop_type = document.getElementById("crop_type").value;
        var crop_price = document.getElementById("crop_price").value;
        var is_negotiable = document.getElementById("is_negotiable").value;
        var package_name = document.getElementById("package_name").value;
        var start_date = document.getElementById("start_date").value;
        var end_date = document.getElementById("end_date").value;
        var image1 = document.getElementById("image1").value;

        if (zipcode == "") {
            alert("Pincode must be filled out");
            return false;
        } else if (zipcode.length < 6) {
            alert("Pincode must be 6 characters");
            return false;
        }
        if (description == "") {
            alert("Description must be filled out");
            return false;
        }
        if (crop_category_name == "") {
            alert("Crops category name must be filled out");
            return false;
        }
        if (quantity == "") {
            alert("Quantity must be filled out");
            return false;
        }
        if (crop_type == "") {
            alert("Crop Type must be filled out");
            return false;
        }
        if (crop_price == "") {
            alert("Crops Price must be filled out");
            return false;
        }
        if (is_negotiable == "") {
            alert("Is Negotiable must be filled out");
            return false;
        }
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
        if (image1 == "") {
            alert("Image 1 must be filled out");
            return false;
        }
    }
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