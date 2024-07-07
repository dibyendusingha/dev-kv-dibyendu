<?php 
    use Illuminate\Support\Facades\Session;
    $username = Session::get('admin-krishi-mahindra');
?>  

<?php if(!empty($username)){
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Krishi Vikas - Mahindra Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('mahindra/assets/download.png')}}" rel="icon">
  <link href="{{asset('mahindra/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('mahindra/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('mahindra/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('mahindra/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('mahindra/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('mahindra/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('mahindra/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('mahindra/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('mahindra/assets/css/style.css')}}" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
      <div class="d-flex align-items-center justify-content-between">
        <a
          href="#"
          class="logo d-flex align-items-center justify-content-center"
        >
          <img src="{{asset('mahindra/assets/krishi_vikash_logo (1).png')}}" alt="" />
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
      </div>
      <!-- End Logo -->

      {{-- <div class="search-bar">
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
      </div> --}}
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
                src="{{asset('mahindra/assets/img/profile-img.jpg')}}"
                alt="Profile"
                class="rounded-circle"
              />
              <span class="d-none d-md-block dropdown-toggle ps-2"
                >{{$username}}</span
              > </a
            ><!-- End Profile Iamge Icon -->

            <ul
              class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
            >
              <li>
                <a class="dropdown-item d-flex align-items-center" href="mahindra-logout">
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
        <a class="nav-link {{ Request::is('mahindra-dasboard') ? 'active' : '' }}" href="mahindra-dasboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard -->

      <li class="nav-item">
        <a class="nav-link {{ Request::is('mahindra-all-lead') ? 'active' : '' }}" href="mahindra-all-lead">
          <i class="bi bi-people"></i>
          <span>All Leads</span>
        </a>
      </li><!-- End All Leads -->

      <li class="nav-item">
        <a class="nav-link {{ Request::is('mahindra-new-lead') ? 'active' : '' }}" href="mahindra-new-lead">
          <i class="bi bi-people"></i>
          <span>New Leads</span>
        </a>
      </li><!-- End All Leads -->

      <li class="nav-item">
        <a class="nav-link {{ Request::is('mahindra-hot-lead') ? 'active' : '' }}" href="mahindra-hot-lead">
          <i class="bi bi-people"></i>
          <span>Hot Leads</span>
        </a>
      </li><!-- End All Leads -->

      <li class="nav-item">
        <a class="nav-link {{ Request::is('mahindra-warm-lead') ? 'active' : '' }}" href="mahindra-warm-lead">
          <i class="bi bi-people"></i>
          <span>Warm Leads</span>
        </a>
      </li><!-- End All Leads -->

      <li class="nav-item">
        <a class="nav-link {{ Request::is('mahindra-cold-lead') ? 'active' : '' }}" href="mahindra-cold-lead">
          <i class="bi bi-people"></i>
          <span>Cold Leads</span>
        </a>
      </li><!-- End All Leads -->


      <li class="nav-item">
        <a class="kv-logo" href="#">
          <img src="{{asset('mahindra/assets/mahindra-nw-logo.png')}}" alt="kv-logo" class="img-fluid">
        </a>
      </li><!-- End All Leads -->

      

    </ul>

    </aside><!-- End Sidebar-->


    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright. All Rights Reserved Krish-Vikas
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('mahindra/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('mahindra/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('mahindra/assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('mahindra/assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('mahindra/assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('mahindra/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('mahindra/assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('mahindra/assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('mahindra/assets/js/main.js')}}"></script>

</body>

</html>
<?php }else{ ?>
  <script>
    window.location.href = 'mahindra-login';
  </script>
  
<?php }?>