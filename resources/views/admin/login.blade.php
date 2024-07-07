<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Krishi Vikas udyog :: AD Manager</title>
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
    </head>

    <body>
        <main>

            <section class="content-login">        	                
                <div class="card mx-auto card-login">
                    <div class="card-body">
                    	<img src="{{ URL::asset('admin/imgs/theme/kvl.png') }}" alt="Krishi Vikas Dashboard" />
                        <br>
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                                </div>
                            @elseif(session('failed'))
                                <div class="alert alert-danger" role="alert">
                                {{ session('failed') }}
                                </div>
                            @endif
                        <br>

                        <h4 class="card-title mb-4">Sign in</h4>
                        <form action="{{url('krishi-login')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <input class="form-control" name="username" placeholder="Username" type="text" />
                            </div>
                            @error('username')
                            <div class="" style="color:red">{{ $message }}</div>
                            @enderror
                            <!-- form-group// -->
                            <div class="mb-3">
                                <input class="form-control" name="password" placeholder="Password" type="password" />
                            </div>
                            @error('password')
                            <div class="" style="color:red">{{ $message }}</div>
                            @enderror
                            <!-- form-group// -->
                            <div class="mb-3">
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input" checked="" />
                                    <span class="form-check-label">Remember</span>
                                </label>
                            </div>
                            <!-- form-group form-check .// -->
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                            <!-- form-group// -->
                        </form>
                    </div>
                </div>
            </section>
        </main>
        <script src="{{ URL::asset('admin/js/vendors/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ URL::asset('admin/js/vendors/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ URL::asset('admin/js/vendors/jquery.fullscreen.min.js') }}"></script>
        <!-- Main Script -->
        <script src="{{ URL::asset('admin/js/main.js?v=1.1') }}" type="text/javascript"></script>
    </body>
</html>
