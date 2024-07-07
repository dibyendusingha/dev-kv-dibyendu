<?php
$url = Request::path();
$exp = explode('/', $url);

if (!empty($exp[1])) {
    $promotion_id = $exp[1];
}
$base_url = url('/');
?>


@extends('admin.layout.main')
@section('page-container')

<style>
    table,
    th,
    td {
        border: 1px solid gray !important;
        border-collapse: collapse !important;
        font-size: 16px !important;
    }

    th,
    td:nth-child(odd) {
        background-color: #ebebeb !important;
        padding-left: 20px;

    }

    .due-update-form {
        position: absolute;
        width: 100%;
        top: 0;
        left: 0;
        height: 100%;
        background: #0000009c;
    }

    .cross {
        position: absolute;
        width: 40px;
        height: 40px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: bold;
        top: 10px;
        left: 10px;
    }
</style>

<section class="content-main">
    <div class="content-header d-flex justify-content-between">
        <div>
            <h2 class="content-title card-title">Promotion Details</h2>
        </div>

    </div>
    <div class="card ">
        <div class="card-body">
            <div class="btn-set text-end">
                <a href="{{$base_url}}/invoice-promotion/{{$promotion_id}}" target="_blank" class="bg-info text-white p-2 rounded border-0">SHOW INVOICE</a>
                <?php if($promotion->due_amount > 0){ ?>
                <a href="{{$base_url}}/edit-promotion/{{$promotion_id}}"  class="bg-dark text-white p-2 rounded border-0" >UPDATE DUE</a>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive w-75 py-5 mx-auto">
                        <table class="table table-bordered">
                            <tbody class="mb-5">
                                <tr>
                                    <td>Name</td>
                                    <td>{{$promotion->name}}</td>
                                <tr>

                                <tr>
                                    <td>Address</td>
                                    <?php if(!empty($promotion->address)){ ?>
                                        <td>{{$promotion->address}}</td>
                                    <?php }else if(!empty($promotion->state_name)){ ?>
                                        <td>{{$promotion->state_name}}</td>
                                    <?php } ?>
                                </tr>

                                <tr>
                                    <td>User Type</td>
                                    <td>
                                        <?php if ($promotion->user_type_id == 1) { ?>
                                            Individual
                                        <?php } else if ($promotion->user_type_id == 2) {  ?>
                                            Seller
                                        <?php } else if ($promotion->user_type_id == 3) {  ?>
                                            Dealer
                                        <?php } else if ($promotion->user_type_id == 4) { ?>
                                            Exchanger
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Package</td>
                                    <td>{{$promotion->package_name}}</td>
                                </tr>

                                <tr>
                                    <td>Price</td>
                                    <td>{{$promotion->purchase_price}}</td>
                                </tr>
                                <tr>
                                    <td>Down Price</td>
                                    <td>{{$promotion->downpayment_price}}</td>
                                </tr>
                                <tr>
                                    <td>Due Price</td>
                                    <td>{{$promotion->due_amount}}</td>
                                </tr>

                                <tr>
                                    <td>Mode of transaction</td>
                                    <td>{{$promotion->transaction_type}}</td>
                                </tr>

                                <tr>
                                    <td>Days</td>
                                    <td>{{$promotion->total_days}}</td>
                                </tr>

                                <tr>
                                    <td>Buffer Days</td>
                                    <td>{{$promotion->buffer_days}}</td>
                                </tr>

                                <tr>
                                    <td>Market User Name</td>
                                    <td>{{$promotion->marketer_user_name}}</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- DUE UPDATE FORM -->

                        <div class="due-update-form d-none animate__animated animate__fadeIn">
                            <span class="cross" onclick="closeupdateDue()">x</span>
                            <div class="d-flex justify-content-center align-items-center h-100 w-100">
                                <form action="{{url('update-due-amount',$promotion_id)}}" method="post" class="border p-5 bg-white w-50">
                                @csrf
                                    <h5>DUE PRICE : {{$promotion->due_amount}}</h5>
                                    <div class="input-group shadow w-50 mx-auto mt-4">
                                        <input type="number" name="due_amount" class="form-control" placeholder="Enter Due Amount" required>
                                        <input class="border-0 bg-dark text-white px-2" type="submit" value="UPDATE">
                                    </div>
                                </form>
                            </div>
                        </div>

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

    <script>
        const dueModal = document.querySelector(".due-update-form");

        function updateDue() {
            dueModal.classList.remove('d-none');
        }

        function closeupdateDue() {
            dueModal.classList.add('d-none');
        }
    </script>

    



    @endsection