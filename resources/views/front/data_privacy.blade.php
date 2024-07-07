@extends('layout.main')
@section('page-container')
<?php
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();
?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="stylepp.css">
    <title>Krishi Vikas Udyog</title>

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
        <h1>DATA RETENTION POLICY</h1>
        <br>
        <hr>
        <p>
                   
            This Platform is created and operated by M/s Abybaby E-Com Private Limited, is a private limited company duly incorporated under the provisions of Companies Act, 2013 (hereinafter referred to as “We”, “Our”, and “Us”) having its registered address at “Ground Floor, 4B, Rani Bhabani Road, Kolkata, West Bengal - 700026” and operating under the brand name “Krishi Vikas” (“Brand Name”). We intend to ensure your steady commitment to the usage of this Platform and the services provided by us through our Application “Krishi Vikas” (“Application”) and website ‘www.KrishiVikas.com'.
        </p>       
        <p>    ABYBABY E-COM PRIVATE LIMITED seeks to ensure that it retains only data necessary to effectively conduct its program activities and work in fulfilment of its mission.</p>
            
            <br>
            <center><b>Reasons for Data Retention.</b></center>
              
            <p>Abybaby E-Com retains only that data that is necessary to effectively conduct its program activities, fulfill its mission and comply with applicable laws and regulations.</p>
        
            <p>Providing an ongoing service to the data subject (e.g. sending a newsletter, publication or ongoing program updates to an individual, ongoing training or participation in Abybaby E-Com’s programs, processing of employee payroll and other benefits).</p>
        
            <ul>
                <li>Compliance with applicable laws and regulations associated with financial and programmatic reporting by Abybaby E-Com to its funding agencies and other donors.</li>
                <li>Compliance with applicable labour, tax and immigration laws.</li>
                <li>Other regulatory requirements.</li>
              
            <li>Electronic communications, Invoices, billing, Customer records, Post records, Digital Marketing and Promotions.",</li>
            <li>Security incident or other investigation.</li>
            <li>Intellectual property preservation.</li>
            <li>Litigation.</li>
            
            <center><b>Data Duplication.</b></center>
        
            <p>Abybaby E-Com seeks to avoid duplication in data storage whenever possible, though there may be instances in which for programmatic or other business reasons it is necessary for data to be held in more than one place. This policy applies to all data in Abybaby E-Com’s possession, including duplicate copies of data.",
               
            <center><b>Retention Requirements.</b></center>
              
            <p>Abybaby E-Com has set the following guidelines for retaining all personal data as defined in the Institute’s data privacy policy.</p>
           
            <p>Website visitor data will be retained as long as necessary to provide the service requested/initiated through the Abybaby E-Com website.</p>
                
            <p>User data will be retained as long as required for particular events required in digital and social media advertisements in various forms for the promotion of Abybaby E-Com and its services.</p>
                
            <p>User data will be retained for the year in which the individual has contributed and then for [Duration] after the date of the last contribution. Financial information will not be retained longer than is necessary to process a single transaction.</p>
             
            <p>Event participant data will be retained for the period of the event, including any follow up activities, such as the distribution of reports, plus a period of 03 Years."</p>
               
            <p>Program participant data (including sign-in sheets) will be retained for the duration of the grant agreement that financed the program plus any additional time required under the terms of the grant agreement.</p>
              
            <p>Personal data of subgrantees, subcontractors and vendors will be kept for the duration of the contract or agreement.</p>
          
            <p>Employee data will be held for the duration of employment and then 03 Years after the last day of employment.</p>
                
            <p>Data associated with employee wages, leave and pension shall be held for the period of employment plus 03 Years, with the exception of pension eligibility and retirement beneficiary data which shall be kept for 03 Years.</p>
              
            <p>Recruitment data, including interview notes of unsuccessful applicants, will be held for [Duration] after the closing of the position recruitment process.</p>
             
            <p>Consultant (both paid and pro bono) data will be held for the duration of the consulting contract plus [Duration] after the end of the consultancy.</p>
               
            <p>Board member data will be held for the duration of service on the Board plus for [Duration] after the end of the member’s term.</p>
            <p>Data associated with tax payments (including payroll, corporate and VAT) will be held for [Duration].</p>
              
        
            <p>Operational data related to program proposals, reporting and program management will be held for the period required by the Abybaby E-Com donor, but not more than [Duration].</p>
            
            <center><b>Data Destruction</b></center>
            <p>Data destruction ensures that Abybaby E-Com manages the data it controls and processes it in an efficient and responsible manner. When the retention period for the data as outlined above expires, Abybaby E-Com will actively destroy the data covered by this policy. If an individual believes that there exists a legitimate business reason why certain data should not be destroyed at the end of a retention period, he or she should identify this data to his/her supervisor and provide information as to why the data should not be destroyed. Any exceptions to this data retention policy must be approved by Abybaby E-Com’s data protection offer in consultation with legal counsel. In rare circumstances, a litigation hold may be issued by legal counsel prohibiting the destruction of certain documents. A litigation hold remains in effect until released by legal counsel and prohibits the destruction of data subject to the hold.<p>
                
                
        </p>
    </div>

</body>

@endsection

