@extends('layout.main')
@section('page-container')

<section class="weather-section text-white">

    <!-- <div class="weather-loader vh-100 w-100 d-flex justify-content-center align-items-center">
        <div class="custom-loader"></div>
    </div> -->
    <!-- <video autoplay muted loop id="weather_video">
                    <source src="https://krishivikas.com/storage/webVideo/clear_sky_night.mp4" type="video/mp4">
                    Your browser does not support HTML5 video.
    </video> -->



    <!-- WEATHER NEW TEMPLATE -->

    <div class="container-fluid weather-new-wrapper d-none">
        <div class="weather-container-layer">
            <div class="row align-items-center main-wrap py-5">
                <div class="col-md-4 weather-layer-left-section ">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <div class="weather-short-info d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/production/fill/thermometer-colder.svg"
                                    alt="min_temperature" class="img-fluid" width="100">
                                <div class="short-weather-info-details">
                                    <h4>MIN TEPERATURE</h4>
                                    <h2 id="ltemp">21°C</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="weather-short-info d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/production/fill/thermometer-warmer.svg"
                                    alt="min_temperature" class="img-fluid" width="100">
                                <div class="short-weather-info-details">
                                    <h4>MAX TEPERATURE</h4>
                                    <h2 id="htemp">21°C</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="weather-short-info d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/production/fill/humidity.svg"
                                    alt="min_temperature" class="img-fluid" width="100">
                                <div class="short-weather-info-details">
                                    <h4>HUMIDITY</h4>
                                    <h2 id="humidity">21°C</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="weather-short-info d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/production/fill/barometer.svg"
                                    alt="min_temperature" class="img-fluid" width="100">
                                <div class="short-weather-info-details">
                                    <h4>AIR PRESSURE</h4>
                                    <h2 id="air-pressure">21°C</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="weather-short-info d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/production/fill/raindrop.svg"
                                    alt="min_temperature" class="img-fluid" width="100">
                                <div class="short-weather-info-details">
                                    <h4>CHANCE OF RAIN</h4>
                                    <h2 id="chance-of-rain">21°C</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="weather-short-info d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/production/fill/wind.svg"
                                    alt="min_temperature" class="img-fluid" width="100">
                                <div class="short-weather-info-details">
                                    <h4>WIND SPEED</h4>
                                    <h2 id="wind-speed">21°C</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 weather-layer-middle-section">

                    <div
                        class="d-flex flex-column justify-content-center align-items-center text-white weather-main-data">
                        <div class="w-icon">
                            <img id="weather-icons" src="" alt="Weather Icon" class="img-fluid ms-auto" width="150">
                        </div>
                        <p class="fs-4"><span id="condition"></span></p>
                        <p class="p-0 m-0 temp fw-bold" style="font-size: 100px"><span id="temperature"></span>°C</p>


                        <h3><i class="fa-solid fa-location-dot"></i> <span id="cityName"></span></h3>

                        <div class="currentday fs-4">
                            <p id="current-date"></p>
                        </div>

                    </div>

                </div>
                <div class="col-md-4 weather-layer-right-section weather-container ">
                    <h2 class="text-center text-white my-3">GRAPHICAL HOURLY FORECAST</h2>
                    <canvas id="temperature-chart" height=""></canvas>
                </div>

            </div>
            <hr>
            <div class=" pt-2 weather-forecast pb-5">
                <h2 class="text-center text-white mb-3">10 DAYS WEATHER FORECAST</h2>
                <div id="weather-container" class="d-flex justify-content-between gap-3">

                </div>
            </div>


        </div>
    </div>


</section>

<!--WEATHER JS-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="{{ URL::asset('assets/js/weather-forecast.js')}}"></script>
@endsection