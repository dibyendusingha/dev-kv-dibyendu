@extends('admin.layout.main')
@section('page-container')

<?php
use Illuminate\Support\Facades\DB;
?>

<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">PinCode Input</h2>
            <p>Add, edit or delete</p>
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
                <div class="col-md-3">

                    <form method="post" action="{{url('add-pin-code')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="product_slug" class="form-label">Country</label>
                            <select class="form-control" name="country_id">
                                <option value="">-- select --</option>
                                <option value="1">INDIA</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="stateSelect" class="form-label">State</label>
                            <select class="form-control" name="state_id" id="stateSelect">
                                <option value="">-- select --</option>
                                <?php foreach($state as $s){ ?>
                                <option value="{{$s->id}}">{{$s->state_name}}</option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="districtSelect" class="form-label">District</label>
                            <select class="form-control" name="district_id" id="districtSelect">
                                <option value="">-- select --</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="product_slug" class="form-label" >City</label>
                            <select class="form-control" name="city_name" id="citySelect">
                                <option value="">-- select --</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="product_slug" class="form-label">Pincode</label>
                            <input class="form-control" name="pincode"></input>

                        </div>

                        <div class="mb-4">
                            <label for="product_slug" class="form-label">Lattitude</label>
                            <input class="form-control" name="lattitude"></input>
                        </div>

                        <div class="mb-4">
                            <label for="product_slug" class="form-label">Longitude</label>
                            <input class="form-control" name="longitude"></input>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" />
                                        </div>
                                    </th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>District</th>
                                    <th>City</th>
                                    <th>Pincode</th>
                                    <th>Lattitude</th>
                                    <th>Longitude</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody class="mb-5">
                                <?php foreach($city as $c){ ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" />
                                        </div>
                                    </td>
                                    <td>India</td>
                                    <?php $state_name = DB::table('state')->where('id',$c->state_id)->first()->state_name; ?>
                                    <td>{{$state_name}}</td>

                                    <?php $district_name = DB::table('district')->where('id',$c->district_id)->first()->district_name; ?>
                                    <td>{{$district_name}}</td>
                                    <td>{{$c->city_name}}</td>
                                    <td>{{$c->pincode}}</td>
                                    <td>{{$c->latitude}}</td>
                                    <td>{{$c->longitude}}</td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu ">
                                                <a class="dropdown-item" href='krishi-edit-pincode/{{$c->id}}'>Edit</a>
                                                <a class="dropdown-item text-danger" href="delete-pincode/{{$c->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</a>
                                            </div>
                                        </div>
                                        <!-- dropdown //end -->
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <nav>
                            {{$city->links()}}
                        </nav>
                    </div>
                </div>
                <!-- .col// -->
            </div>
            <!-- .row // -->
        </div>
        <!-- card body .// -->
    </div>
    <!-- card .// -->

    <!-- Delete Modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     
      <div class="modal-body d-flex justify-content-between">
            <h3>Are you sure you want to delete?</h3> 
            <i class='bx bxs-trash fs-3 text-danger'></i>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary">Yes</button>
      </div>
    </div>
  </div>
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