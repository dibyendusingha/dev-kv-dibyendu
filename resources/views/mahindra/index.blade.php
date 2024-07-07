


@extends('mahindra.mahindra_layout.header')
@section('content')


<main id="main" class="main">

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li> 
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">
        <!-- Customers Card -->
        <div class="col-xxl-6 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">ALL LEADS</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$all_lead}}</h6>
                </div>
              </div>

            </div>
          </div>

        </div><!-- End Customers Card -->
        <!-- Customers Card -->
        <div class="col-xxl-6 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">NEW LEADS</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$new_lead}}</h6>
                </div>
              </div>

            </div>
          </div>

        </div><!-- End Customers Card -->
         <!-- Customers Card -->
         <div class="col-xxl-4 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">HOT LEADS</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$hot_lead}}</h6>
                </div>
              </div>

            </div>
          </div>

        </div><!-- End Customers Card -->
        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">WARM LEADS</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$warm_lead}}</h6>
                </div>
              </div>

            </div>
          </div>

        </div><!-- End Customers Card -->
        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">COLD LEADS</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$cold_lead}}</h6>
                </div>
              </div>

            </div>
          </div>

        </div><!-- End Customers Card -->


        <!-- Recent Sales -->
        <div class="col-12">
          <div class="card recent-sales overflow-auto">
            <div class="card-body">
              <h2 class="card-title">Todays Top 10 Leads</h2>

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
              <tbody>
                <?php $i=1;?>
                @foreach ($top_lead as $item)
                <tr>    
                  <th scope="row">{{$i}}</th>
                  <td>{{$item->created_at}}</td>
                  <td>{{$item->name}}</td>
                  <td>{{$item->mobile}}</td>
                  <td>{{$item->state}}</td>
                  <td>{{$item->district}}</td>
                  <td>{{$item->model_name}}</td>
                  <td>
                      @if ($item->lead_status=='Within 30 Days')
                      <span class="badge bg-danger">HOT</span>
                      @elseif ($item->lead_status=='Within 30 to 90 Days')
                      <span class="badge bg-warning">WARM</span>
                      @elseif ($item->lead_status=='More than 90 Days')
                      <span class="badge bg-success">COLD</span>
                      @endif
                  </td>
                  
                </tr>
              <?php $i++; ?>
                @endforeach
                
                

              </tbody>
            </table>
            <!-- End Table with stripped rows -->

            </div>

          </div>
        </div><!-- End Recent Sales -->


      </div>
    </div><!-- End Left side columns -->

  </div>
</section>

</main><!-- End #main -->


@endsection