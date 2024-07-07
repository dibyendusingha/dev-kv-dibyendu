@extends('admin.layout.main')
@section('page-container')

<style>
    .preview-image{
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
            <h2 class="content-title card-title">EDIT CROPS POST</h2>
            <p>Chnage  Necessary  Details</p>
        </div>

    </div>
    <div class="card">
        <div class="card-body">

                    <form method="post" action="#" enctype="multipart/form-data" class="row justify-content-center">
                        
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Title</label>
                            <input class="form-control" name="lattitude"></input>
                        </div>

                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Package Name</label>
                            <input class="form-control" name="longitude"></input>
                        </div>

                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Price</label>
                            <input class="form-control" name="longitude"></input>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Is Negotiable</label>
                            <select class="form-control" name="country_id">
                                <option value="">-- select --</option>
                                <option value="1">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">ZipCode</label>
                            <input class="form-control" name="longitude"></input>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">State Name</label>
                            <select class="form-control" name="country_id">
                                <option value="">-- select --</option>
                                <option value="1">INDIA</option>
                            </select>
                        </div>

                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">District Name</label>
                            <select class="form-control" name="country_id">
                                <option value="">-- select --</option>
                                <option value="1">INDIA</option>
                            </select>
                        </div>

                        <div class="mb-4 col-md-4">
                            <label for="stateSelect" class="form-label">City Name</label>
                            <select class="form-control" name="state_id" id="stateSelect">
                                <option value="">-- select --</option>
                                
                            </select>
                        </div>

                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Description</label>
                            <input class="form-control" name="longitude"></input>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Start Date</label>
                            <input class="form-control" name="longitude" type="date"></input>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">End Date</label>
                            <input class="form-control" name="longitude" type="date"></input>
                        </div>

                        


                        <div class="mb-4 col-md-4">
                            <label for="districtSelect" class="form-label">Discount</label>
                            <input class="form-control" name="longitude"></input>
                        </div>

                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label" >Types</label>
                            <select class="form-control" name="city_name" id="citySelect">
                                <option value="">-- select --</option>
                                <option value="">GST</option>
                                <option value="">CGST</option>
                                <option value="">IGST</option>
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label" >Mode of transaction</label>
                            <select class="form-control" name="city_name" id="citySelect">
                                <option value="">-- select --</option>
                                <option value="">Online</option>
                                <option value="">Offline</option>
                            </select>
                        </div>

                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Transaction Id</label>
                            <input class="form-control" name="pincode"></input>

                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Order Id</label>
                            <input class="form-control" name="pincode"></input>

                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Days</label>
                            <input class="form-control" name="pincode"></input>

                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Buffer Days</label>
                            <input class="form-control" name="pincode"></input>

                        </div>

                        <div class="mb-4 col-md-12" style="padding: 0 24px;">
                        <div class="row border rounded p-4">
                            <h5 class="mb-2">Upload Images</h5>
                            <div class="col-md-4">
                                <label for="image1" class="form-label">Image-1</label>
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

                        

                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Total Payment</label>
                            <input class="form-control" name="longitude"></input>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="product_slug" class="form-label">Down Payment</label>
                            <input class="form-control" name="longitude"></input>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                        </div>
                    </form>
                
            <!-- .row // -->
        </div>
        <!-- card body .// -->
    </div>
    <!-- card .// -->

    <!-- Delete Modal -->


</section>

<script>
    function getDistrict() {
        // Dynamically retrieve the selected state_id
        var selectedStateId = $("#stateSelect").val();

        $.ajax({
            type: 'POST',
            url: '{{ route("district.to.district") }}',
            data: { state_id: selectedStateId },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                // console.log("District Data:", data);
                 $("#districtSelect").empty();
                 $("#districtSelect").append(`<option value="#">--Select District--</option>`);
                for (let i = 0; i < data.length; i++) {
                    $("#districtSelect").append(`<option value="${data[i].id}">${data[i].district_name}</option>`);
                }

                // Trigger the change event on district select to update city options
                $("#districtSelect").change();
            },
            error: function () {
                console.log("Error occurred while fetching districts.");
            }
        });
    }

    function getCity() {
        var selectedDistrictId = $("#districtSelect").val();
        $.ajax({
            type: 'POST',
            url: '{{ route("district.to.city") }}',
            data: { district_id: selectedDistrictId },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                // console.log("City Data:", data);
                $("#citySelect").empty();
                $("#citySelect").append(`<option value="#">--Select City--</option>`);
                for (let i = 0; i < data.length; i++) {
                    // $("#citySelect").append(`<option value="${data[i].id}">${data[i].city_name}</option>`);
                    $("#citySelect").append(`<option value="${data[i].city_name}">${data[i].city_name}</option>`);
                }
            },
            error: function () {
                console.log("Error occurred while fetching cities.");
            }
        });
    }
            // Set up an event listener for the state select change event
            $("#stateSelect").on("change", function () {
                // Call getDistrict whenever the state select changes
                getDistrict();
            });

            // Set up an event listener for the state select change event
            $("#districtSelect").on("change", function () {
                // Call getDistrict whenever the state select changes
                getCity();
            });
</script>

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

@endsection