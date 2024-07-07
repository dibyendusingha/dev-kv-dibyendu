@extends('mahindra.mahindra_layout.header')
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Data Tables</h1>
        <nav class="d-flex justify-content-between w-100">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">All Leads</li>
            </ol>
            <ul class="d-flex gap-5 align-items-center list-unstyled">
                <li><span class="badge bg-danger ">HOT</span> : <span class="text-danger fw-semibold">Within 30 Days</span></li>
                <li><span class="badge bg-warning">WARM</span> : <span class="text-warning fw-semibold">Within 90 Days</span></li>
                <li><span class="badge bg-success">COLD</span> : <span class="text-success fw-semibold">Beyond 90 Days</span></li>
            </ul>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="filter-section p-5 mt-3 rounded-3">
                            <form action="{{url('mahindra-all-lead-filter')}}" method="post">
                                @csrf
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="w-25">
                                        <label for="startDate" class="form-label" style="color: #ED2831">START DATE</label>
                                        <input type="date" name="startDate" id="startDate" class="form-control" />
                                    </div>
                                    <div class="w-25">
                                        <label for="" class="form-label" style="color: #ED2831">END DATE</label>
                                        <input type="date" name="endDate" id="endDate" class="form-control" />
                                    </div>
                                    <div class="w-25">
                                        <label for="" class="form-label" style="color: #ED2831">MODEL</label>
                                        <select class="form-select" aria-label="Default select example" name="mahindra_id">
                                            <option selected="" value="">--SELECT--</option>
                                            <?php
                                            if (!empty($mahindra_details)) {
                                                foreach ($mahindra_details as $model) {
                                            ?>
                                                    <option value="{{$model->id}}">{{$model->name}}</option>
                                            <?php }
                                            } ?>

                                        </select>
                                    </div>
                                    <div class="w-25">
                                        <label for="endDate" class="form-label" style="color: #ED2831">STATUS</label>
                                        <select class="form-select" aria-label="Default select example" name="status" class="form-control">
                                            <option selected="" value="">--SELECT--</option>
                                            <option value="Within 30 Days">HOT</option>
                                            <option value="Within 30 to 90 Days">WARM</option>
                                            <option value="More than 90 Days">COLD</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="d-flex align-items-center submit-btn" style="margin-top: 30px">
                                        <i class="bi bi-funnel me-2"></i>FILTER
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <h5 class="card-title">Datatables</h5>
                            <button id="downloadExcelBtn" class="btn btn-success">
                                <i class="bi bi-filetype-xlsx pe-2"></i>Download Excel
                            </button>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile No</th>
                                    <th scope="col">State</th>
                                    <th scope="col">District</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <?php $i = 1; ?>
                            <tbody>
                                <?php
                                $i = 1;
                                if (!empty($all_data1)) { ?>
                                    @foreach ($all_data1 as $item)

                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->mobile}}</td>
                                        <td>{{$item->state}}</td>
                                        <td>{{$item->district}}</td>
                                        <td>{{$item->model_name}}</td>
                                        <td>
                                            @if ($item->lead_status=='Within 30 Days' || $item->lead_status=='30 দিনের মধ্যে' || $item->lead_status=='30 दिन के भीतर')
                                            <span class="badge bg-danger">HOT</span>
                                            @elseif ($item->lead_status=='Within 30 to 90 Days' || $item->lead_status=='30 থেকে 90 দিনের মধ্যে' || $item->lead_status=='30 से 90 दिन के भीतर')
                                            <span class="badge bg-warning">WARM</span>
                                            @elseif ($item->lead_status=='More than 90 Days' || $item->lead_status=='90 দিনের চেয়ে বেশী' || $item->lead_status=='90 दिन से ज़्यादा')
                                            <span class="badge bg-success">COLD</span>
                                            @endif
                                        </td>

                                    </tr>
                                    <?php $i++; ?>
                                    @endforeach
                                <?php } else {
                                    $i = 1;
                                ?>
                                    @foreach ($all_data as $item)
                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->mobile}}</td>
                                        <td>{{$item->state}}</td>
                                        <td>{{$item->district}}</td>
                                        <td>{{$item->model_name}}</td>
                                        <td>
                                            @if ($item->lead_status=='Within 30 Days' || $item->lead_status=='30 দিনের মধ্যে' || $item->lead_status=='30 दिन के भीतर')
                                            <span class="badge bg-danger">HOT</span>
                                            @elseif ($item->lead_status=='Within 30 to 90 Days' || $item->lead_status=='30 থেকে 90 দিনের মধ্যে' || $item->lead_status=='30 से 90 दिन के भीतर')
                                            <span class="badge bg-warning">WARM</span>
                                            @elseif ($item->lead_status=='More than 90 Days' || $item->lead_status=='90 দিনের চেয়ে বেশী' || $item->lead_status=='90 दिन से ज़्यादा')
                                            <span class="badge bg-success">COLD</span>
                                            @endif
                                        </td>

                                    </tr>
                                    <?php $i++; ?>
                                    @endforeach
                                <?php } ?>

                            </tbody>
                        </table>

                        <div>

                            <?php if (empty($all_data1)) { ?>
                                <nav>
                                    {{$all_data->links()}}
                                </nav>

                            <?php } ?>

                        </div>

                        <!-- End Table with stripped rows -->
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->


@endsection