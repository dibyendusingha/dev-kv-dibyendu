@extends('admin.layout.main')
@section('page-container')

<?php
use Illuminate\Support\Facades\DB;
?>

<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">Pin Update</h2>
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @elseif(session('failed'))
                <div class="alert alert-danger" role="alert">
                    {{ session('failed') }}
                </div>
                @endif
                <div class="col-md-12">

                    <form method="post" action="{{url('update-pincode', $editCity->id)}}" enctype="multipart/form-data" class="row">
                        @csrf

                        <div class="mb-4 col-md-6">
                            <label for="product_slug" class="form-label">Country</label>
                            <input type="text" class="form-control" name="country_id" value="India" disabled>
                        </div>

                        <div class="mb-4 col-md-6">
                            <label for="stateSelect" class="form-label">State</label>
                            <input type="text" class="form-control" name="state_id" value="{{$state_name}}" disabled>

                        </div>

                        <div class="mb-4 col-md-6">
                            <label for="districtSelect" class="form-label">District</label>
                            <input type="text" class="form-control" name="district_id" value="{{$district_name}}" disabled>
                        </div>

                        <div class="mb-4 col-md-6">
                            <label for="product_slug" class="form-label" >City</label>
                            <input type="text" class="form-control" name="city_name" value="{{$editCity->city_name}}" disabled>
                        </div>

                        <div class="mb-4 col-md-6">
                            <label for="product_slug" class="form-label">Pincode</label>
                            <input class="form-control" name="pincode" value="{{$editCity->pincode}}">

                        </div>

                        <div class="mb-4 col-md-6">
                            <label for="product_slug" class="form-label">Lattitude</label>
                            <input class="form-control" name="lattitude" value="{{$editCity->latitude}}">
                        </div>

                        <div class="mb-4 col-md-6">
                            <label for="product_slug" class="form-label">Longitude</label>
                            <input class="form-control" name="longitude" value="{{$editCity->longitude}}">
                        </div>

                        <div class="">
                            <button type="submit" class="btn btn-primary">UPDATE</button>
                        </div>
                    </form>
                </div>
                
                <!-- .col// -->
            </div>
            <!-- .row // -->
        </div>
        <!-- card body .// -->
    </div>
    <!-- card .// -->

    <!--Form Edit Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form method="post" action="{{url('krishi-add-company-data')}}" enctype="multipart/form-data">

                        <div class="mb-4">
                            <label for="product_slug" class="form-label">Country</label>
                            <!-- <input class="form-control" type="input" name="category"/> -->
                            <select class="form-control" name="category">
                                <option value="">-- select --</option>
                                <option value="1">INDIA</option>

                            </select>

                        </div>

                        <div class="mb-4">
                            <label for="stateSelect" class="form-label">State</label>
                            <!-- <input class="form-control" type="input" name="category"/> -->
                            <select class="form-control" name="category" id="stateSelect">
                                <option value="">-- select --</option>
                                <?php foreach($state as $s){ ?>
                                <option value="{{$s->id}}">{{$s->state_name}}</option>
                                <?php }?>
                            </select>

                        </div>

                        <div class="mb-4">
                            <label for="districtSelect" class="form-label">District</label>
                            <!-- <input class="form-control" type="input" name="category"/> -->
                            <select class="form-control" name="category" id="districtSelect">
                                <option value="">-- select --</option>

                            </select>

                        </div>

                        <div class="mb-4">
                            <label for="product_slug" class="form-label" >City</label>
                            <!-- <input class="form-control" type="input" name="category"/> -->
                            <select class="form-control" name="category" id="citySelect">
                                <option value="">-- select --</option>

                            </select>

                        </div>

                        <div class="mb-4">
                            <label for="product_slug" class="form-label">Pincode</label>
                            <!-- <input class="form-control" type="input" name="category"/> -->
                            <input class="form-control" name="pincode"></input>

                        </div>

                        <div class="mb-4">
                            <label for="product_slug" class="form-label">Lattitude</label>
                            <input class="form-control" name="pincode"></input>
                        </div>

                        <div class="mb-4">
                            <label for="product_slug" class="form-label">Longitude</label>
                            <input class="form-control" name="pincode"></input>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                        </div>
                    </form>
                </div>
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

@endsection