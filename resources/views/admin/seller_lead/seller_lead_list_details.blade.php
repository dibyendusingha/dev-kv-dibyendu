@extends('admin.layout.main')
@section('page-container')


<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title fs-5">POST LEAD LIST</h2>
        </div>
    </div>
    <div class="card-body">
        <div class="text-end mb-2">
            <button onclick="exportToExcelSellerLead()" class="btn btn-success px-3" style="font-size: 12px;color: white"><i class="ri-article-line me-1"></i>Export to Excel</button>

        </div>
        <div class="card mb-4">

            <!-- card-header end// -->
            <div class="card-body" id="table">
                <div class="table-responsive">
                    <table class="datatable-init-export nk-tb-list nk-tb-ulist table table-hover" data-auto-responsive="false" data-export-title="Export" id="sellerLead">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col tb-col-mb">Sl No</th>
                                <th class="nk-tb-col tb-col-mb">User Name</th>
                                <th class="nk-tb-col tb-col-mb">User type</th>
                                <th class="nk-tb-col tb-col-mb">Mobile</th>
                                <th class="nk-tb-col tb-col-mb">Pincode</th>
                                <th class="nk-tb-col tb-col-mb">State name</th>
                                <th class="nk-tb-col tb-col-mb">District name</th>
                                <th class="nk-tb-col tb-col-mb">City name</th>
                                <th class="nk-tb-col tb-col-mb">Status</th>
                                <th class="nk-tb-col tb-col-mb">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_tbody">
                            @foreach($sellerLeadList as $key => $seller)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$seller->name}}</td>
                                <td><span class="badge rounded-pill alert-<?php if ($seller->user_type_id == 2) {
                                                                                echo 'success';
                                                                            } else if ($seller->user_type_id == 3) {
                                                                                echo 'warning';
                                                                            } else if ($seller->user_type_id == 4) {
                                                                                echo 'secondary';
                                                                            } else {
                                                                                echo 'danger';
                                                                            } ?>">
                                        <?php if ($seller->user_type_id == 2) {
                                            echo 'Seller';
                                        } else if ($seller->user_type_id == 3) {
                                            echo 'Dealer';
                                        } else if ($seller->user_type_id == 4) {
                                            echo 'Exchanger';
                                        } ?>
                                    </span>
                                </td>
                                <td>{{$seller->mobile}}</td>
                                <td>{{$seller->zipcode}}</td>
                                <td>{{$seller->state_name}}</td>
                                <td>{{$seller->district_name}}</td>
                                <td>{{$seller->city_name}}</td>

                                <td>
                                    <?php if ($seller->sellerStatus == 1) { ?>
                                        <span class="d-inline-block bg-danger text-white  text-center rounded" style="width: 100px">Hot Lead</span>
                                    <?php } else if ($seller->sellerStatus == 0) { ?>
                                        <span class="d-inline-block bg-success text-white text-center  rounded" style="width: 100px">Normal Lead</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <form name="lead" method="post" action="{{ url('update-product-boost-status',$seller->seller_id)}}">
                                        @csrf
                                        <select name="lead_status" class="action-select">
                                            <option value="1" {{ $seller->sellerStatus == '1' ? 'selected' : '' }}>Hot Lead</option>
                                            <option value="0" {{ $seller->sellerStatus == '0' ? 'selected' : '' }}>Normal Lead</option>
                                        </select>
                                        <button type="submit" class="action-button">Submit</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- card-body end// -->
        </div>
        <nav>
            {{$sellerLeadList->links() }}
        </nav>
    </div>

</section>

<script>

</script>



@endsection