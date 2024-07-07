<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Krishi Vikas udyog :: AD Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('admin/imgs/theme/favicon.svg') }}" />
    <!-- Template CSS -->
    <link href="{{ URL::asset('admin/css/main.css?v=1.1') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin/css/datatable.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

</head>

<body>
    <div class="screen-overlay"></div>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="{{url('krishi-dashboard')}}" class="brand-wrap">
                <img src="{{ url('admin/imgs/theme/kvl.png') }}" class="logo" alt="Krishi Vikas Dashboard" />
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize"><i class="text-muted material-icons md-menu_open"></i></button>
            </div>
        </div>
        <nav>
            <ul class="menu-aside">
                <li class="menu-item active">
                    <a class="menu-link" href="{{url('krishi-dashboard')}}">
                        <i class="icon material-icons md-home"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-grass"></i>
                        <span class="text">Crops</span>
                    </a>
                    <div class="submenu">
                        <a href="{{url('add-krishi-crops-post')}}">Add subscription</a>
                        <a href="{{url('crops-post-list')}}"> Subscription list</a>
                        <a href="{{url('krishi-subscribed-crops-post-list')}}">Crops list</a>
                        <a href="{{url('crops-category-list')}}">Crops category list</a>
                        <a href="{{url('crops-banner-list')}}">Banner list</a>
                        <a href="{{url('crops-boost-list')}}">Boost list</a>
                    </div>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{url('seller-category-list')}}">
                        <i class="icon material-icons md-account_circle"></i>
                        <span class="text">Sellers Leads</span>
                    </a>   
                </li>
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-agriculture"></i>
                        <span class="text">Tractor</span>
                    </a>
                    <div class="submenu">
                        <?php
                        if (session()->get('admin-krishi') == 'admin') {
                        ?>
                            <a href="{{url('krishi-tractor-brand')}}">Brands</a>
                            <a href="{{url('krishi-tractor-model')}}">Models</a>
                            <a href="{{url('krishi-tractor-specification')}}">Specification</a>
                        <?php } ?>
                        <a href="{{url('krishi-tractor-post-list')}}">Posts</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-local_shipping"></i>
                        <span class="text">Goods Vehicle</span>
                    </a>
                    <div class="submenu">
                        <?php
                        if (session()->get('admin-krishi') == 'admin') {
                        ?>
                            <a href="{{url('krishi-gv-brand')}}">Brands</a>
                            <a href="{{url('krishi-gv-model')}}">Models</a>
                            <a href="{{url('krishi-gv-specification')}}">Specification</a>
                        <?php } ?>
                        <a href="{{url('krishi-gv-post-list')}}">Posts</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-agriculture"></i>
                        <span class="text">Harvester</span>
                    </a>
                    <div class="submenu">
                        <?php
                        if (session()->get('admin-krishi') == 'admin') {
                        ?>
                            <a href="{{url('krishi-harvester-brand')}}">Brands</a>
                            <a href="{{url('krishi-harvester-model')}}">Models</a>
                            <a href="{{url('krishi-harvester-specification')}}">Specification</a>
                        <?php } ?>
                        <a href="{{url('krishi-harvester-post-list')}}">Posts</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-build"></i>
                        <span class="text">Implements</span>
                    </a>
                    <div class="submenu">
                        <?php
                        if (session()->get('admin-krishi') == 'admin') {
                        ?>
                            <a href="{{url('krishi-implements-brand')}}">Brands</a>
                            <a href="{{url('krishi-implements-model')}}">Models</a>
                            <a href="{{url('krishi-implements-specification')}}">Specification</a>
                        <?php } ?>
                        <a href="{{url('krishi-implements-post-list')}}">Posts</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-sports_soccer"></i>
                        <span class="text">Tyres</span>
                    </a>
                    <div class="submenu">
                        <?php
                        if (session()->get('admin-krishi') == 'admin') {
                        ?>
                            <a href="{{url('krishi-tyre-brand')}}">Brands</a>
                            <a href="{{url('krishi-tyre-model')}}">Models</a>
                            <a href="{{url('krishi-tyre-specification')}}">Specification</a>
                        <?php } ?>
                        <a href="{{url('krishi-tyre-post-list')}}">Posts</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-grass"></i>
                        <span class="text">Seeds</span>
                    </a>
                    <div class="submenu">
                        <a href="{{url('krishi-seeds-post-list')}}">Posts</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Fertilizer</span>
                    </a>
                    <div class="submenu">
                        <a href="{{url('krishi-fertilizers-post-list')}}">Posts</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-bug_report"></i>
                        <span class="text">Pesticides</span>
                    </a>
                    <div class="submenu">
                        <a href="{{url('krishi-pesticides-post-list')}}">Posts</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-account_circle"></i>
                        <span class="text">Subscribers</span>
                    </a>

                    <div class="submenu">
                        <a href="{{url('krishi-seller-list')}}">Sellers list</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-account_circle"></i>
                        <span class="text">Referral</span>
                    </a>
                    <div class="submenu">
                        <a href="{{url('krishi-referral-code-list')}}">Referral list</a>
                        <a href="{{url('krishi-referral-code-user')}}">Referral by User</a>
                    </div>

                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-build"></i>
                        <span class="text">Push Notification</span>
                    </a>
                    <div class="submenu">
                        <a href="{{url('push-notification')}}">Schedule</a>
                        <a href="{{url('notification-schedule-list')}}">Schedule List</a>
                    </div>
                </li>

                <!-- Dibyendu Change 31.08.2023 -->

                <!-- Season-Page -->
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-build"></i>
                        <span class="text">Season</span>
                    </a>
                    <div class="submenu">
                        <?php
                        if (session()->get('admin-krishi') == 'admin') {
                        ?>
                        <?php } ?>
                        <a href="#{{--url('krishi-season-list')--}}">Season-list</a>
                        <a href="#{{--url('krishi-season-crop-calender-list')--}}">Season-Cro-calender</a>
                    </div>
                </li>

                <!-- Company-Page -->
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-build"></i>
                        <span class="text">Company</span>
                    </a>
                    <div class="submenu">
                        <?php
                        if (session()->get('admin-krishi') == 'admin') {
                        ?>
                            <!-- <a href="{{url('krishi-implements-brand')}}">Brands</a>
                            <a href="{{url('krishi-implements-model')}}">Models</a>
                            <a href="{{url('krishi-implements-specification')}}">Specification</a> -->
                        <?php } ?>
                        <a href="{{url('krishi-add-company')}}">Add Company</a>
                        <!-- <a href="{{url('krishi-dealer-company-list')}}">Company List</a>
                            <a href="{{url('krishi-dealer-product-list')}}">Dealer Product List</a> -->
                    </div>
                </li>

                <!-- Pincode -->
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-build"></i>
                        <span class="text">Pin Update</span>
                    </a>
                    <div class="submenu">
                        <?php
                        if (session()->get('admin-krishi') == 'admin') {
                        ?>
                            <!-- <a href="{{url('krishi-implements-brand')}}">Brands</a>
                            <a href="{{url('krishi-implements-model')}}">Models</a>
                            <a href="{{url('krishi-implements-specification')}}">Specification</a> -->
                        <?php } ?>
                        <a href="{{url('krishi-add-pincode')}}">Add Pincode</a>
                        <!-- <a href="{{url('krishi-dealer-company-list')}}">Company List</a>
                            <a href="{{url('krishi-dealer-product-list')}}">Dealer Product List</a> -->
                    </div>
                </li>

                <!-- Ads Manager -->
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-verified"></i>
                        <span class="text">Ads Banner</span>
                    </a>
                    <div class="submenu">
                        <?php
                        if (session()->get('admin-krishi') == 'admin') {
                        ?>
                            <a href="/ads-banner-list">Ads Banner</a>
                        <?php } ?>
                        <!-- <a href="/manage-ads">Manange Ads</a> -->
                       
                    </div>
                </li>

                <!-- Subscription Manager -->
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-verified"></i>
                        <span class="text">Subscription Manager</span>
                    </a>
                    <div class="submenu">
                        <?php
                        if (session()->get('admin-krishi') == 'admin') {
                        ?>
                        <a href="/subscription-plan">Subscription Plan</a>
                        <a href="/subscribed-user">Subscribed User</a>
                        <a href="/subscription-boots-list">Subscribed Boots List</a> 
                        <?php }else{ ?>
                            <a href="/subscribed-user">Subscribed User</a>
                            <a href="/subscription-boots-list">Subscribed Boots List</a>
                        <?php  } ?>
                       
                        
                    </div>
                </li>


                <!--Users Manager -->
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-verified"></i>
                        <span class="text">Users</span>
                    </a>
                    <div class="submenu">
                        <a href="/user-list">User List</a>
                    </div>
                </li>


                <!--Promotion Manager -->
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-verified"></i>
                        <span class="text">Promotions</span>
                    </a>
                    <div class="submenu">
                        <a href="/new-promotion">New Promotions</a>
                        <a href="/promotion-list">Promotions List</a>
                    </div>
                </li>


                <!--Banner Subscription Manager -->
                <?php
                if (session()->get('admin-krishi') == 'admin') {
                ?>
                    <li class="menu-item has-submenu">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-verified"></i>
                            <span class="text">Banner Subscription</span>
                        </a>
                        <div class="submenu">
                            <a href="/banner-subscription">Banner Subscription Pricing</a>
                            <a href="#">Banner Subscribed User</a>
                            <a href="#">Banner User Lead</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <hr />
            <ul class="menu-aside">

                <li class="menu-item">
                    <a class="menu-link" href="{{url('krishi-profile')}}">
                        <i class="icon material-icons md-person"></i>
                        <span class="text"> Accounts </span>
                    </a>
                </li>
            </ul>
            <br />
            <br />
        </nav>
    </aside>
    <main class="main-wrap">
        <header class="main-header navbar sticky-top">
            <div class="col-search">
            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i class="material-icons md-apps"></i></button>
                <ul class="nav">
                    <!--<li class="nav-item">
                            <a class="nav-link btn-icon" href="#">
                                <i class="material-icons md-notifications animation-shake"></i>
                                <span class="badge rounded-pill">3</span>
                            </a>
                        </li>-->
                    <li class="nav-item">
                        <a class="nav-link btn-icon darkmode" href="#"> <i class="material-icons md-nights_stay"></i> </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="requestfullscreen nav-link btn-icon"><i class="material-icons md-fullscreen"></i></a>
                    </li>
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount" aria-expanded="false"> <img class="img-xs rounded-circle" src="{{url('admin/imgs/people/avatar-2.png') }}" alt="User" /></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                            <a class="dropdown-item" href="{{url('krishi-profile')}}"><i class="material-icons md-perm_identity"></i>Edit Profile</a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{url('krishi-logout')}}"><i class="material-icons md-exit_to_app"></i>Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>