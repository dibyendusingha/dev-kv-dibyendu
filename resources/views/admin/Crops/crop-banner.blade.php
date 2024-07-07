@extends('admin.layout.main')
@section('page-container')
<?php

    use Illuminate\Support\Facades\DB;

    $url = Request::path();
    $parts = explode('/', $url);
    $crops_subscribed_id = end($parts);
    $crop_subscribed = DB::table('cropsSubscribedView')->where('subscribed_id', $crops_subscribed_id)->first();
   // dd($crop_subscribed);

?>
<section class="content-main">
    <div class="content-header">
        <div class="w-100 d-flex align-items-center justify-content-between">
            <h2 class="content-title card-title"><i class="fa-solid fa-rocket me-1"></i>ADD CROPS BANNER </h2>
            @if (session('message'))
            <div class="err-msg animate__animated animate__shakeX">
                <i class="ri-error-warning-fill fs-5">{{ session('message') }}</i>
            </div>
            @endif
        </div>
    </div>
    <div class="card mb-4">

        <!-- card-header end// -->
        <div class="card-body">

            <form method="post" action="{{url('add-crop-banner',[$crops_subscribed_id])}}" id="myForm" class="form-otp" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">User Name<span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$crop_subscribed->user_id}}" readonly>
                        <input type="text" class="form-control" name="user_name" value="{{$crop_subscribed->username}}" readonly>
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Crops Package plan <span class="text-danger">*</span></label>
                        <select class="form-select" name="crop_subscription_id" required>
                            <option value="{{$crop_subscribed->subscription_id}}" selected>{{$crop_subscribed->crop_subscriptions_name}}</option>
                        </select>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Package Days <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="days" value="{{$crop_subscribed->subscription_days}}" readonly>
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="category_id" value="Crops" readonly>
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="start_date" value="{{$crop_subscribed->start_date}}" readonly>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="end_date" value="{{$crop_subscribed->end_date}}" readonly>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="crops_title" value="" required>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label for="product_slug" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="crops_description" id="" class="form-control" required></textarea>
                    </div>
                    <div class="mb-2 col-md-12">
                        <label for="product_slug" class="form-label">State Name <span class="text-danger">*</span></label>
                        <input type="checkbox" id="masterCheckbox"> Select All<br>
                        @foreach($state as $s)
                            <input type="checkbox" class="subCheckbox"  name="crops_state[]" value="{{$s->id}}" >&nbsp;{{$s->state_name}} &nbsp;
                        @endforeach
                        
                    </div>
                    <div class="mb-4 col-md-12" style="padding: 0 24px;">
                        <div class="row border rounded p-4">
                            <h5 class="mb-2">Upload Banner</h5>
                            <div class="col-md-4">
                                <label for="image1" class="form-label">Banner-Image<span class="text-danger">*</span></label>
                                <input class="form-control" id="image1" name="banner_img" type="file" required>
                                <img id="preview-image1" class="preview-image" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-512.png" alt="">
                            </div>
                        </div>
                    </div>


                </div>

                <div class="text-center mt-4">
                    <button type="button" class="btn btn-primary" onclick="otpSent()" id="boost-post">BANNER CROPS</button>
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

    </div>
    <!-- card-body end// -->
    </div>
    <!-- card end// -->

</section>




<style>
    .hidden {
        display: none;
    }
</style>

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

<script>
    function otpSent() {
        var user_id = document.getElementById('user_id').value ;
        console.log(user_id);
        $.ajax({
            type: 'POST',
            url: "{{route('otp.send')}}",
            data:{
                user_id : user_id,
                _token: "{{ csrf_token() }}"
            },
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

<!-- SELECT ALL CHECK BOX  -->
<script>
    document.getElementById('masterCheckbox').addEventListener('change', function () {
        var checkboxes = document.getElementsByClassName('subCheckbox');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });
</script>




@endsection