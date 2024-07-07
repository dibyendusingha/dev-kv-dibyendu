@extends('sbi.sbi_layouts.header')
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Data Tables</h1>
        <nav class="d-flex justify-content-between w-100">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">All Leads</li>
            </ol>

        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="filter-section p-5 mt-3 rounded-3">
                            <form action="#">
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="date" name="startDate" id="startDate" class="form-control" />

                                    <input type="date" name="endDate" id="endDate" class="form-control" />

                                    <select class="form-select" aria-label="Default select example">
                                        <option selected="">--CATEGORY--</option>
                                        <option value="1">Used Tractor Loan</option>
                                        <option value="2">New Tractor Loan</option>
                                        <option value="3">Loan Against Tractor</option>
                                        <option value="1">Used Good Vehicle Loan</option>
                                        <option value="2">New Good Vehicle Loan</option>
                                        <option value="3">Loan Agaist Good Vehicle</option>
                                        <option value="1">Used Harvester Loan</option>
                                        <option value="2">New Harvester Loan</option>
                                        <option value="3">Loan Against Harvester</option>
                                        <option value="1">Used Implement Loan</option>
                                        <option value="2">New Implement Loan</option>
                                        <option value="3">Loan Against Implement</option>
                                        <option value="1">Personal Loan</option>


                                    </select>

                                    <select class="form-select" aria-label="Default select example">
                                        <option selected="">--STATUS--</option>
                                        <option value="1">Not Connected</option>
                                        <option value="2">Conneted</option>
                                        <option value="3">Converted</option>
                                    </select>

                                    <button type="submit" class="d-flex align-items-center submit-btn">
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile No</th>
                                    <th scope="col">Pincode</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Brandon Jacob</td>
                                    <td>1234567894</td>
                                    <td>755200</td>
                                    <td>New Tractor Loan</td>
                                    <td><span class="badge bg-success">Contacted</span></td>
                                    <td>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected="">--SELECT--</option>
                                            <option value="1">Contacted</option>
                                            <option value="1">Converted</option>
                                            <option value="2">Not contacted</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Brandon Jacob</td>
                                    <td>1234567894</td>
                                    <td>755200</td>
                                    <td>Used Harvester Loan</td>
                                    <td><span class="badge bg-success">Contacted</span></td>
                                    <td>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected="">--SELECT--</option>
                                            <option value="1">Contacted</option>
                                            <option value="1">Converted</option>
                                            <option value="2">Not contacted</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Brandon Jacob</td>
                                    <td>1234567894</td>
                                    <td>755200</td>
                                    <td>Used Tractor Loan</td>
                                    <td><span class="badge bg-success">Contacted</span></td>
                                    <td>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected="">--SELECT--</option>
                                            <option value="1">Contacted</option>
                                            <option value="1">Converted</option>
                                            <option value="2">Not contacted</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Brandon Jacob</td>
                                    <td>1234567894</td>
                                    <td>755200</td>
                                    <td>New Harvester Loan</td>
                                    <td><span class="badge bg-success">Contacted</span></td>
                                    <td>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected="">--SELECT--</option>
                                            <option value="1">Contacted</option>
                                            <option value="1">Converted</option>
                                            <option value="2">Not contacted</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Brandon Jacob</td>
                                    <td>1234567894</td>
                                    <td>755200</td>
                                    <td>Used Good Vehicle Loan</td>
                                    <td><span class="badge bg-success">Contacted</span></td>
                                    <td>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected="">--SELECT--</option>
                                            <option value="1">Contacted</option>
                                            <option value="1">Converted</option>
                                            <option value="2">Not contacted</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->



@endsection