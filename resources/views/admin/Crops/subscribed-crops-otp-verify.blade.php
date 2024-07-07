<?php
    $crops_data = json_encode($subscribed_crops_data);
    $url = Request::path();
    $parts = explode('/', $url);
    $crops_subscribed_id = end($parts);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Otp Verification</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('admin/imgs/theme/favicon.svg') }}" />
    <!-- Template CSS -->
    <link href="{{ URL::asset('admin/css/main.css?v=1.1') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin/css/datatable.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

</head>

<body>
    <div class="otp-wrapper">
        <div class="container-otp">
            <header class="header-otp d-flex align-items-center">
                <i class="bx bxs-check-shield"></i>
            </header>
            <h4>Enter OTP Code</h4>
            <form  id="crop-form">
                <div class="input-field-otp text-center">
                    <input type="number" name="first"  id="first" />
                    <input type="number" name="second" id="second" disabled />
                    <input type="number" name="third"  id="third" disabled />
                    <input type="number" name="forth"  id="forth" disabled />
                </div>
                <div class="d-flex flex-column gap-2 align-items-center">
                    <button type="submit" class="btn disabled mt-4">Verify OTP</button>
                    <button type="button" class="btn btn-secondary" onclick="otpSent()">Resend OTP</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT JS -->
    <script>
        const inputs = document.querySelectorAll(".otp-wrapper input"),
            buttonVerify = document.querySelector(".otp-wrapper button");
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

    <!-- ADD CROPS -->
    <script>
        $(document).ready(function() {
            $('#crop-form').submit(function(e) {
                e.preventDefault(); 

                var crops_data = [];
                crops_data = '<?php echo $crops_data; ?>';
                var crops_subscribed_id = '<?php echo  $crops_subscribed_id; ?>';

                var formData = $(this).serialize(); 

                var first = document.getElementById("first").value;
                var second = document.getElementById("second").value;
                var third = document.getElementById("third").value;
                var forth = document.getElementById("forth").value;

                var base_url = '<?php echo url('/') . '/'; ?>';
                console.log(base_url);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('add.subscribed.crops') }}", 
                    data: {
                        first:first,
                        second:second,
                        third:third,
                        forth:forth,
                        crops_subscribed_id:crops_subscribed_id,
                        crops_data: crops_data,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // console.log(response);
                        if(response.response == "failed"){
                            alert("OTP not matching");
                        }else if(response.response == "success"){
                            console.log(response);
                            window.location.href= base_url+'krishi-crops-banner-post/'+crops_subscribed_id;
                        }
                    }
                });
            });
        });
    </script>

    <script>
        function otpSent() {

            var crops_data = [];
            crops_data     = '<?php echo $crops_data; ?>';

            $.ajax({
                type: 'POST',
                url: "{{route('resend.otp')}}",
                data:{
                    crops_subscribed_all: crops_data,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    alert("otp sent successfully");
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
</body>

</html>