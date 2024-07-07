<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Krishi Vikas - SBI Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('sbi/assets/img/sbi logo.webp')}}" rel="icon">
  <link href="{{asset('sbi/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('sbi/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('sbi/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('sbi/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('sbi/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('sbi/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('sbi/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('sbi/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('sbi/assets/css/style.css')}}" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
      <div class="d-flex align-items-center justify-content-between">
        <a
          href="sbi-dasboard"
          class="logo d-flex align-items-center justify-content-center"
        >
          <img src="{{asset('sbi/assets/krishi_vikash_logo (1).png')}}" alt="" />
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
      </div>
      <!-- End Logo -->

      <div class="search-bar">
        <form
          class="search-form d-flex align-items-center"
          method="POST"
          action="#"
        >
          <input
            type="text"
            name="query"
            placeholder="Search"
            title="Enter search keyword"
          />
          <button type="submit" title="Search">
            <i class="bi bi-search"></i>
          </button>
        </form>
      </div>
      <!-- End Search Bar -->

      <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
          <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle" href="#">
              <i class="bi bi-search"></i>
            </a>
          </li>
          <!-- End Search Icon-->

          <li class="nav-item dropdown pe-3">
            <a
              class="nav-link nav-profile d-flex align-items-center pe-0"
              href="#"
              data-bs-toggle="dropdown"
            >
              <img
                src="{{asset('sbi/assets/img/profile-img.jpg')}}"
                alt="Profile"
                class="rounded-circle"
              />
              <span class="d-none d-md-block dropdown-toggle ps-2"
                >K. Anderson</span
              > </a
            ><!-- End Profile Iamge Icon -->

            <ul
              class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
            >
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                </a>
              </li>
            </ul>
            <!-- End Profile Dropdown Items -->
          </li>
          <!-- End Profile Nav -->
        </ul>
      </nav>
      <!-- End Icons Navigation -->
    </header>
    <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link active" href="sbi-dasboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard -->

      <li class="nav-item">
        <a class="nav-link " href="sbi-all-lead">
          <i class="bi bi-people"></i>
          <span>All Leads</span>
        </a>
      </li><!-- End All Leads -->

      <li class="nav-item">
        <a class="nav-link " href="used-tractor-loan.html">
          <i class="bi bi-people"></i>
          <span>Used Tractor Loan</span>
        </a>
      </li><!-- End All Leads -->

      <li class="nav-item">
        <a class="nav-link " href="new-tractor-loan.html">
          <i class="bi bi-people"></i>
          <span>New Tractor Loan</span>
        </a>
      </li><!-- End All Leads -->

      <li class="nav-item">
        <a class="nav-link " href="loan-against-tractor.html">
          <i class="bi bi-people"></i>
          <span>Loan Against Tractor</span>
        </a>
      </li><!-- End All Leads -->

      <li class="nav-item">
        <a class="nav-link" href="used-good-vehicle-loan.html">
          <i class="bi bi-people"></i>
          <span>Used Good Vehicle Loan</span>
        </a>
      </li><!-- End All Leads -->



      <li class="nav-item">
        <a class="nav-link" href="new-good-vehicle-loan.html">
          <i class="bi bi-people"></i>
          <span>New Good Vehicle Loan</span>
        </a>
      </li><!-- End All Leads -->


      <li class="nav-item">
        <a class="nav-link" href="loan-agaist-good-vehicle.html">
          <i class="bi bi-people"></i>
          <span>Loan Agaist Good Vehicle</span>
        </a>
      </li><!-- End All Leads -->



      <li class="nav-item">
        <a class="nav-link" href="used-harvester-loan.html">
          <i class="bi bi-people"></i>
          <span>Used Harvester Loan</span>
        </a>
      </li><!-- End All Leads -->



      <li class="nav-item">
        <a class="nav-link" href="new-harvester-loan.html">
          <i class="bi bi-people"></i>
          <span>New Harvester Loan</span>
        </a>
      </li><!-- End All Leads -->


      <li class="nav-item">
        <a class="nav-link" href="loan-against-harvester.html">
          <i class="bi bi-people"></i>
          <span>Loan Against Harvester</span>
        </a>
      </li><!-- End All Leads -->


      <li class="nav-item">
        <a class="nav-link" href="used-implements-loan.html">
          <i class="bi bi-people"></i>
          <span>Used Implement Loan</span>
        </a>
      </li><!-- End All Leads -->



      <li class="nav-item">
        <a class="nav-link" href="new-implement-loan.html">
          <i class="bi bi-people"></i>
          <span>New Implement Loan</span>
        </a>
      </li><!-- End All Leads -->


      <li class="nav-item">
        <a class="nav-link" href="loan-agaist-implement.html">
          <i class="bi bi-people"></i>
          <span>Loan Against Implement</span>
        </a>
      </li><!-- End All Leads -->

      <li class="nav-item">
        <a class="nav-link" href="personal-loan.html">
          <i class="bi bi-people"></i>
          <span>Personal Loan</span>
        </a>
      </li><!-- End All Leads -->

      <li class="nav-item">
        <a class="kv-logo" href="#">
          <img src="{{asset('sbi/assets/img/sbi logo.webp')}}" alt="kv-logo" class="img-fluid">
        </a>
      </li><!-- End All Leads -->

      

    </ul>

  </aside><!-- End Sidebar-->


  @yield('content')


  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('sbi/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('sbi/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('sbi/assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('sbi/assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('sbi/assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('sbi/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('sbi/assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('sbi/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('sbi/assets/js/main.js')}}"></script>

</body>

</html>