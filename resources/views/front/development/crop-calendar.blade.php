@extends('layout.main')
@section('page-container')

<?php
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();
?>

<div class="product-list pt-5">
    <div class="d-flex align-items-center justify-content-center">
        <a href="https://www.krishivikas.com/index">

            <h2>
                <?php if (session()->has('bn')) {echo $lang['bn']['HOME'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['HOME'];} 
                            else { echo 'HOME'; } 
                            ?>
            </h2>
        </a>
        <span><i class="fa-solid fa-angle-right fa-2x text-white"></i></span>
        <a href="#">
            
            <a href="#">
                        <h2><?php if (session()->has('bn')) {echo $lang['bn']['CROP CALENDAR'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['CROP CALENDAR'];} 
                            else { echo 'CROP CALENDAR'; } 
                            ?></h2>
            </a>
           
        </a>
    </div>



    <div class="pl-head text-center">
        <h1>
        <?php if (session()->has('bn')) {echo $lang['bn']['CROP CALENDAR'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['CROP CALENDAR'];} 
                            else { echo 'CROP CALENDAR'; } 
                            ?>
        </h1>
    </div>

</div>


<!-- CROP CALENDAR -->

<section class="crop-calendar">
    <div class="container py-5">
        <div class="calendar-category text-center">
            <h4 class="fw-bold border border-2 p-2 d-inline-block border-dark">
                <?php if (session()->has('bn')) {echo $lang['bn']['SEASON CATEGORY'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['SEASON CATEGORY'];} 
                            else { echo 'SEASON CATEGORY'; } 
                            ?>
            </h4>
            <div class="row justify-content-center pt-5">
                <div class="col-4 text-center">
                    <div class="icon-box p-4 rounded shadow d-inline-block mb-3 menu-link active"
                        style="background-color: #8dbf4530;" id="link1">
                        <img src="https://image.pngaaa.com/162/2809162-middle.png" alt=""
                            style="height: 100px; width: 100px; border-radius: 50%;background: white;">
                    </div>
                    <p class="fw-bold">
                    <?php if (session()->has('bn')) {echo $lang['bn']['RABI'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['RABI'];} 
                            else { echo 'RABI'; } 
                            ?>
                    </p>
                </div>
                <div class="col-4 text-center">
                    <div class="icon-box p-4 rounded shadow d-inline-block mb-3 menu-link"
                        style="background-color: #8dbf4530;" id="link2">
                        <img src="https://static.vecteezy.com/system/resources/previews/025/107/498/original/soybean-plant-pea-plant-pod-vegetable-legume-generative-ai-free-png.png"
                            alt="" style="height: 100px; width: 100px; border-radius: 50%;background: white;">
                    </div>
                    <p class="fw-bold">
                    <?php if (session()->has('bn')) {echo $lang['bn']['KHARIF'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['KHARIF'];} 
                            else { echo 'KHARIF'; } 
                            ?>
                    </p>
                </div>
                <div class="col-4 text-center">
                    <div class="icon-box p-4 rounded shadow d-inline-block mb-3 menu-link"
                        style="background-color: #8dbf4530;" id="link3">
                        <img src="https://png.pngtree.com/png-clipart/20221028/original/pngtree-green-watermelon-plant-with-cartoon-style-png-image_8741153.png"
                            alt="" style="height: 100px; width: 100px; border-radius: 50%;background: white;">
                    </div>
                    <p class="fw-bold">
                    <?php if (session()->has('bn')) {echo $lang['bn']['ZAID'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['ZAID'];} 
                            else { echo 'ZAID'; } 
                            ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="season-crop-content container mb-5">

        <!-- RABI CROPS -->
        <div id="content1" class="content active p-md-5 p-2 animate__animated animate__fadeIn"
            style="background-color: #8dbf4530;">
            <h3 class="text-center">
            <?php if (session()->has('bn')) {echo $lang['bn']['RABI CROPS'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['RABI CROPS'];} 
                            else { echo 'RABI CROPS'; } 
                            ?>
                    
            </h3>
            <div class="row justify-content-center">
                <div class="col-md-6 p-3">
                    <!-- WHEAT -->
                    <?php

                         if (session()->has('bn')) 
                         {echo '<a href="/crop-content/rabi/subcategory1b">
                            <div class="rabi d-flex align-items-center justify-content-around">
                                <img src="https://krishivikas.com/storage/CC/Wheat%201.jpg"
                                    alt="" class="img-fluid">
                                <h1>গম</h1>
                            </div>
                        </a>';} 

                         else if (session()->has('hn')) 
                         {echo '<a href="/crop-content/rabi/subcategory1h">
                            <div class="rabi d-flex align-items-center justify-content-around">
                                <img src="https://krishivikas.com/storage/CC/Wheat%201.jpg"
                                    alt="" class="img-fluid">
                                <h1>गेहूँ</h1>
                            </div>
                        </a>';} 

                         else 
                         { echo '<a href="/crop-content/rabi/subcategory1">
                            <div class="rabi d-flex align-items-center justify-content-around">
                                <img src="https://krishivikas.com/storage/CC/Wheat%201.jpg"
                                    alt="wheat" class="img-fluid">
                                <h1>Wheat</h1>
                            </div>
                        </a>'; }

                        ?>
                </div>
                <div class="col-md-6 p-3">
                <!-- Chickpea -->
                    <?php

                    if (session()->has('bn')) 
                    {echo '<a href="/crop-content/rabi/subcategory2b">
                        <div class="rabi d-flex align-items-center justify-content-around">
                            <img src="https://krishivikas.com/storage/CC/Chickpea.jpg" alt=""
                                class="img-fluid">
                            <h1>ছোলা</h1>
                        </div>
                    </a>';} 

                    else if (session()->has('hn')) 
                    {echo '<a href="/crop-content/rabi/subcategory2h">
                        <div class="rabi d-flex align-items-center justify-content-around">
                            <img src="https://krishivikas.com/storage/CC/Chickpea.jpg" alt=""
                                class="img-fluid">
                            <h1>चना</h1>
                        </div>
                    </a>';} 

                    else 
                    { echo '<a href="/crop-content/rabi/subcategory2">
                        <div class="rabi d-flex align-items-center justify-content-around">
                            <img src="https://krishivikas.com/storage/CC/Chickpea.jpg" alt=""
                                class="img-fluid">
                            <h1>Chickpea</h1>
                        </div>
                    </a>'; }

                    ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Mustard -->
                <?php

                    if (session()->has('bn')) 
                    {echo '<a href="/crop-content/rabi/subcategory3b">
                        <div class="rabi d-flex align-items-center justify-content-around">
                            <img src="https://krishivikas.com/storage/CC/Mustard.jpg"
                                alt="" class="img-fluid">
                            <h1>সরিষা</h1>
                        </div>
                    </a>';} 

                    else if (session()->has('hn')) 
                    {echo '<a href="/crop-content/rabi/subcategory3h">
                        <div class="rabi d-flex align-items-center justify-content-around">
                            <img src="https://krishivikas.com/storage/CC/Mustard.jpg"
                                alt="" class="img-fluid">
                            <h1>सरसों</h1>
                        </div>
                    </a>';} 

                    else 
                    { echo '<a href="/crop-content/rabi/subcategory3">
                        <div class="rabi d-flex align-items-center justify-content-around">
                            <img src="https://krishivikas.com/storage/CC/Mustard.jpg"
                                alt="" class="img-fluid">
                            <h1>Mustard</h1>
                        </div>
                    </a>'; }

                    ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Barley -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/rabi/subcategory4b">
                    <div class="rabi d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Barley.jpg"
                            alt="" class="img-fluid">
                        <h1>যব</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/rabi/subcategory4h">
                    <div class="rabi d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Barley.jpg"
                            alt="" class="img-fluid">
                        <h1>जौ</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/rabi/subcategory4">
                    <div class="rabi d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Barley.jpg"
                            alt="" class="img-fluid">
                        <h1>Barley</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Linseed -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/rabi/subcategory5">
                    <div class="rabi d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Lineseed.jpg"
                            alt="" class="img-fluid">
                        <h1>তিসি</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/rabi/subcategory5">
                    <div class="rabi d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Lineseed.jpg"
                            alt="" class="img-fluid">
                        <h1>तीसी</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/rabi/subcategory5">
                    <div class="rabi d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Lineseed.jpg"
                            alt="" class="img-fluid">
                        <h1>Linseed</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
            </div>


        </div>
        <!-- KHARIF CROP -->
        <div id="content2" class="content  p-md-5 p-2 animate__animated animate__fadeIn"
            style="background-color: #8dbf4530;">
            <h3 class="text-center">
            <?php if (session()->has('bn')) {echo $lang['bn']['KHARIF CROPS'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['KHARIF CROPS'];} 
                            else { echo 'KHARIF CROPS'; } 
                            ?>
            </h3>

            <div class="row justify-content-center">
                <div class="col-md-6 p-3">
                <!-- Rice -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/kharif/subcategory1">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Rice.jpg"
                            alt="" class="img-fluid">
                        <h1>চাল</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/kharif/subcategory1">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Rice.jpg"
                            alt="" class="img-fluid">
                        <h1>चावल</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/kharif/subcategory1">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Rice.jpg"
                            alt="" class="img-fluid">
                        <h1>Rice</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Maize -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/kharif/subcategory2b">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Maize.jpg"
                            alt="" class="img-fluid">
                        <h1>ভুট্টা</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/kharif/subcategory2h">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Maize.jpg"
                            alt="" class="img-fluid">
                        <h1>मक्का</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/kharif/subcategory2">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Maize.jpg"
                            alt="" class="img-fluid">
                        <h1>Maize</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Cotton -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/kharif/subcategory3b">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Cotton.jpg"
                            alt="" class="img-fluid">
                        <h1>তুলা</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/kharif/subcategory3h">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Cotton.jpg"
                            alt="" class="img-fluid">
                        <h1>कपास</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/kharif/subcategory3">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Cotton.jpg"
                            alt="" class="img-fluid">
                        <h1>Cotton</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Soybean -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/kharif/subcategory4b">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Soybeans.jpg" alt=""
                            class="img-fluid">
                        <h1>সয়াবিন</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/kharif/subcategory4h">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Soybeans.jpg" alt=""
                            class="img-fluid">
                        <h1>सोयाबीन</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/kharif/subcategory4">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Soybeans.jpg" alt=""
                            class="img-fluid">
                        <h1>Soybean</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Groundnut -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/kharif/subcategory5b">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Groundnut.jpg"
                            alt="" class="img-fluid">
                        <h1>চিনাবাদাম</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/kharif/subcategory5h">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Groundnut.jpg"
                            alt="" class="img-fluid">
                        <h1>मूंगफली</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/kharif/subcategory5">
                    <div class="kharif d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Groundnut.jpg"
                            alt="" class="img-fluid">
                        <h1>Groundnut</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
            </div>
        </div>
        <!-- ZAID CROP -->
        <div id="content3" class="content p-md-5 p-2 animate__animated animate__fadeIn"
            style="background-color: #8dbf4530;">
            <h3 class="text-center">
            <?php if (session()->has('bn')) {echo $lang['bn']['ZAID CROPS'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['ZAID CROPS'];} 
                            else { echo 'ZAID CROPS'; } 
                            ?>
            </h3>
            <div class="row justify-content-center">
                <div class="col-md-6 p-3">
                <!-- Watermelon -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/zaid/subcategory1b">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Watermelon.jpg"
                            alt="" class="img-fluid">
                        <h1>তরমুজ</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/zaid/subcategory1h">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Watermelon.jpg"
                            alt="" class="img-fluid">
                        <h1>तरबूज</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/zaid/subcategory1">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Watermelon.jpg"
                            alt="" class="img-fluid">
                        <h1>Watermelon</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Cucumber -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/zaid/subcategory2b">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Cucumber.jpg"
                            alt="" class="img-fluid">
                        <h1>শসা</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/zaid/subcategory2h">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Cucumber.jpg"
                            alt="" class="img-fluid">
                        <h1>खीरा</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/zaid/subcategory2">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Cucumber.jpg"
                            alt="" class="img-fluid">
                        <h1>Cucumber</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Muskmelon -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/zaid/subcategory3b">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Muskmelon.jpg" alt=""
                            class="img-fluid">
                        <h1>খরবুজা</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/zaid/subcategory3h">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Muskmelon.jpg" alt=""
                            class="img-fluid">
                        <h1>खरबूजा</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/zaid/subcategory3">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Muskmelon.jpg" alt=""
                            class="img-fluid">
                        <h1>Muskmelon</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Bitter Gourd -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/zaid/subcategory4b">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Bitter Gourd.jpg"
                            alt="" class="img-fluid">
                        <h1>করলা</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/zaid/subcategory4h">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Bitter Gourd.jpg"
                            alt="" class="img-fluid">
                        <h1>करेला</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/zaid/subcategory4">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Bitter Gourd.jpg"
                            alt="" class="img-fluid">
                        <h1>Bitter Gourd</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>
                <div class="col-md-6 p-3">
                <!-- Pumpkin -->
                <?php

                if (session()->has('bn')) 
                {echo '<a href="/crop-content/zaid/subcategory5b">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Pumpkin.jpg" alt=""
                            class="img-fluid">
                        <h1>কুমড়া</h1>
                    </div>
                </a>';} 

                else if (session()->has('hn')) 
                {echo '<a href="/crop-content/zaid/subcategory5h">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Pumpkin.jpg" alt=""
                            class="img-fluid">
                        <h1>कोंहड़ा</h1>
                    </div>
                </a>';} 

                else 
                { echo '<a href="/crop-content/zaid/subcategory5">
                    <div class="zaid d-flex align-items-center justify-content-around">
                        <img src="https://krishivikas.com/storage/CC/Pumpkin.jpg" alt=""
                            class="img-fluid">
                        <h1>Pumpkin</h1>
                    </div>
                </a>'; }

                ?>
                    
                </div>

            </div>
        </div>
    </div>
</section>






@endsection