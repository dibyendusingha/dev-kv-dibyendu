@extends('layout.main')
@section('page-container')


<?php
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();
?>

<?php

// Get the current URL
$currentUrl = $_SERVER['REQUEST_URI'];

if (session()->has('bn')) {
    
// Check if the last character of the URL is 'h'
if (substr($currentUrl, -1) === 'h') {
    // Remove the last character ('h') and append 'b' to the current URL
    $modifiedUrl = substr($currentUrl, 0, -1) . 'b';

    // Perform the redirect to the modified URL
    header("Location: $modifiedUrl");
    exit;
}

 // Check if 'b' is already present at the end of the URL
else if (substr($currentUrl, -1) !== 'b') {
        // Append 'b' to the current URL
        $modifiedUrl = rtrim($currentUrl, '/') . 'b';

        // Perform the redirect to the modified URL
        header("Location: $modifiedUrl");
        exit;
    }
}

else if (session()->has('hn')) {
    
// Check if the last character of the URL is 'h'
if (substr($currentUrl, -1) === 'b') {
    // Remove the last character ('h') and append 'b' to the current URL
    $modifiedUrl = substr($currentUrl, 0, -1) . 'h';

    // Perform the redirect to the modified URL
    header("Location: $modifiedUrl");
    exit;
}

 // Check if 'b' is already present at the end of the URL
else if (substr($currentUrl, -1) !== 'h') {
        // Append 'b' to the current URL
        $modifiedUrl = rtrim($currentUrl, '/') . 'h';

        // Perform the redirect to the modified URL
        header("Location: $modifiedUrl");
        exit;
    }
}

else if (session()->has('en')) {
    // Check if 'b' is already present at the end of the URL
    if (substr($currentUrl, -1) === 'b') {
        // Remove the last character ('b') to revert to English
        $modifiedUrl = substr($currentUrl, 0, -1);

        // Perform the redirect to the modified URL
        header("Location: $modifiedUrl");
        exit;
    }

    // Check if 'h' is already present at the end of the URL
    elseif (substr($currentUrl, -1) === 'h') {
        // Remove the last character ('h') to revert to English
        $modifiedUrl = substr($currentUrl, 0, -1);

        // Perform the redirect to the modified URL
        header("Location: $modifiedUrl");
        exit;
    }
}


?>



<div class="product-list pt-5">
    <div class="d-flex align-items-center justify-content-center">
        <a href="/">
            <h2>
            <?php if (session()->has('bn')) {echo $lang['bn']['HOME'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['HOME'];} 
                            else { echo 'HOME'; } 
                            ?>
            </h2>
        </a>
        <span><i class="fa-solid fa-angle-right fa-2x text-white"></i></span>
        <a href="/crop-calendar">
            <h2>
            <?php if (session()->has('bn')) {echo $lang['bn']['CROP CALENDAR'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['CROP CALENDAR'];} 
                            else { echo 'CROP CALENDAR'; } 
                            ?>
            </h2>
        </a>
        <span><i class="fa-solid fa-angle-right fa-2x text-white"></i></span>
        <a href="#">
            <h2>
            <?php if (session()->has('bn')) {echo $lang['bn']['CROPS'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['CROPS'];} 
                            else { echo 'CROPS'; } 
                            ?>
            </h2>
        </a>
    </div>



    <div class="pl-head text-center">
        <h1>
        <?php if (session()->has('bn')) {echo $lang['bn']['CROPS'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['CROPS'];} 
                            else { echo 'CROPS'; } 
                            ?>
        </h1>
    </div>

</div>


<!-- CROP CONTENT -->

<section class="crop-contents">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-9 pt-3">
                <div id="content">
                    {!! $content !!}
                </div>
            </div>


            <!-- OTHER CATEGORY AND SUBCATEGORY LIST -->
            <div class="col-md-3 pt-3">
                <div class="other-crops-option">
                    <div class="rabi-option">
                        <h4>
                        <?php if (session()->has('bn')) {echo $lang['bn']['RABI'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['RABI'];} 
                            else { echo 'RABI'; } 
                            ?>
                        </h4>

                        <?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/rabi/subcategory1b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/wheat-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>গম</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/rabi/subcategory1h">
                            <div class="crops-box d-flex  align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/wheat-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>गेहूँ</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/rabi/subcategory1">
                            <div class="crops-box d-flex  align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/wheat-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>WHEAT</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

<?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/rabi/subcategory2b">
                            <div class="crops-box d-flex  align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/chick-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>ছোলা</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/rabi/subcategory2h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/chick-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>चना</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/rabi/subcategory2">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/chick-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Chickpea</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

<?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/rabi/subcategory3b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/mustard-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>সরিষা</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/rabi/subcategory3h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/mustard-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>सरसों</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/rabi/subcategory3">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/mustard-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Mustard</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

<?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/rabi/subcategory4b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/barley-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>যব</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/rabi/subcategory4h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/barley-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>जौ</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/rabi/subcategory4">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/barley-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Barley</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

<?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/rabi/subcategory5b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/lseed-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>তিসি</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/rabi/subcategory5h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/lseed-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>तीसी</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/rabi/subcategory5">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/lseed-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Linseed</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

                    </div>
                    <div class="kharif-option">
                        <h4>
                        <?php if (session()->has('bn')) {echo $lang['bn']['KHARIF'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['KHARIF'];} 
                            else { echo 'KHARIF'; } 
                            ?>
                        </h4>

                        <?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/kharif/subcategory1b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/rice-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>চাল</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/kharif/subcategory1h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/rice-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>चावल</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/kharif/subcategory1">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/rice-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Rice</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

<?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/kharif/subcategory2b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/maize-1.jpeg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>ভুট্টা</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/kharif/subcategory2h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/maize-1.jpeg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>मक्का</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/kharif/subcategory2">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/maize-1.jpeg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Maize</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

                <?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/kharif/subcategory3b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/cotton-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>তুলা</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/kharif/subcategory3h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/cotton-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>कपास</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/kharif/subcategory3">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/cotton-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Cotton</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

                <?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/kharif/subcategory4b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/soyabean-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>সয়াবিন</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/kharif/subcategory4h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/soyabean-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>सोयाबीन</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/kharif/subcategory4">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/soyabean-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Soyabean</h3>
                            </div>
                        </a>'; } 
                        
                        ?>
                        

                        <?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/kharif/subcategory5b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/gnut-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>চিনাবাদাম</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/kharif/subcategory5h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/gnut-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>मूंगफली</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/kharif/subcategory5">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/gnut-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Groundnut</h3>
                            </div>
                        </a>'; } 
                        
                        ?>
                        
                        
                        
                        
                    </div>
                    <div class="zaid-option">
                        <h4>
                        <?php if (session()->has('bn')) {echo $lang['bn']['ZAID'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['ZAID'];} 
                            else { echo 'ZAID'; } 
                            ?>
                        </h4>

                        <?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/zaid/subcategory1b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/wmelon-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>তরমুজ</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/zaid/subcategory1h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/wmelon-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>तरबूज</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/zaid/subcategory1">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/wmelon-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Watermelon</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

                        <?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/zaid/subcategory2b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/cum-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>শসা</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/zaid/subcategory2h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/cum-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>खीरा</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/zaid/subcategory2">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/cum-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Cucumber</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

                        <?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/zaid/subcategory3b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/musk-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>খরবুজা</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/zaid/subcategory3h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/musk-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>खरबूजा</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/zaid/subcategory3">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/musk-1.jpg"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Muskmelon</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

                        <?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/zaid/subcategory4b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/bgrd-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>করলা</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/zaid/subcategory4h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/bgrd-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>करेला</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/zaid/subcategory4">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/bgrd-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Bitter Gourd</h3>
                            </div>
                        </a>'; } 
                        
                        ?>

<?php 
                        
                        if (session()->has('bn')) 
                        {echo '<a href="/crop-content/zaid/subcategory5b">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/pkin-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>কুমড়া</h3>
                            </div>
                        </a>';}
                         
                        else if (session()->has('hn')) 
                        {echo '<a href="/crop-content/zaid/subcategory5h">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/pkin-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>कोंहड़ा</h3>
                            </div>
                        </a>';}

                        else { echo '<a href="/crop-content/zaid/subcategory5">
                            <div class="crops-box d-flex align-items-center">
                                <img src="https://krishivikas.com/storage/webCC/pkin-1.webp"
                                    alt="wheat-image" class="img-fluid rounded-circle">
                                <h3>Pumpkin</h3>
                            </div>
                        </a>'; } 
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>


    </div>

</section>


<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

@endsection