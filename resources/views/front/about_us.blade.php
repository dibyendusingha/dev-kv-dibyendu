@extends('layout.main')
@section('page-container')
<?php
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();
?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            //font-family: 'Oswald', sans-serif;
        }

        .terms-of-use {
            width: 100%;
            padding: 50px;
            text-align: center;
            display: grid;
            align-content: center;
        }

        .terms-of-use p {

            text-align: justify;
            margin: 0 auto;
        }

        .terms-of-use ul {
            display: grid;
            align-content: center;
            text-align: justify;
            list-style-type: none;
            margin: 0 auto;
        }
    </style>

<body>

    <div class="terms-of-use">
        <h1>About Krishi Vikas</h1>
        <hr>
        <p>
            Krishi Vikas Udyog is the first one-stop solution for the farming community scattered across the country, by connecting buyers and sellers of Agri-products and equipment through technology ( Mobile and Desktop Application). We help farmers to Buy, Sell, Finance, Insure and Service New/Used tractors and every kind of farm equipment.
        </p>
        
           <p> This platform is created to solve the Agri-crisis to healthy Agri-culture and improve with every decision making, thereby making it convenient for them to solve their occupation-related requirements by providing them access to those having relevant solutions – Peer to Peer or B2C.</p>
        
        
           <p> We have created an ecosystem on the back of technology, shared economy and useful content, that connects the demand side of agriculture to its supply side, we have created a wide range of variety categorization from tractors to seeds, from fertilizer to implements where people from all walks can either buy, sell or rent as per their need with our user-friendly Krishi Vikas Udyog Application.</p>
        
          <br>
            <center><b>Krishi Vikas Udyog to Fulfill Farmer's Dreams.</b></center>
        
            <p>Krishi Vikas Udyog considered Indian farmers as the most important backbone of Indian society. That's why we show complete information in every separate section so that you can get every farm information comfortably sitting at home. We aim to revolutionise the Indian tractor industry by bringing transparency to pricing, information and comparison of tractors, farm equipment and related financial products.</p>
          <br>
            <center><b>Krishi Vikas Udyog- Solution at your fingertip.</b></center>
        
            <p>We aim to provide all information related to farming to every part of India. Download our Krishi Vikas Udyog Application and get exciting offers, deals, expert reviews, videos and a lot of agriculture-related things. We provide you with a one-stop solution to all your farming needs and queries.</p>
        
            <p>Our mission is to provide an easy solution to tractor buying or selling, fertilizers, seeds and every farming product. Through Krishi Vikas Udyog, we aim to empower Indian farmers with exhaustive and unbiased information on farming products through expert reviews, owner reviews, detailed specifications and comparisons.</p>
        
            <p>We understand that farmers are one of the essential parts of having a thriving country.</p>
       
        
    </div>

</body>

@endsection