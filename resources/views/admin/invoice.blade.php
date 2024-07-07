

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice Details</title>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");

      body{
        font-family: "Poppins", sans-serif;
      }

      h1,
      h2,
      h3,
      h4,
      h5,
      h6 {
        margin: 0;
      }

      .invoice-wrapper {
        width: 98%;
        margin: 0 auto;
  
        padding: 5px;
      }

      .container {
        padding: 35px 10px;
        border: 1px solid black;
      }

      .company-info {
        margin-top: 5px;
      }

      .company-info p,
      .left-sec p,
      .due-price p,
      .right-sec p {
        font-size: 12px;
        line-height: 25px;
      }

      .container-company-invoice {
        display: flex;
        justify-content: space-between;
      }

      .invoice-section {
        margin-top: 40px;
        text-align: right;
      }

      .invoice-section h3,
      p {
        margin: 0;
      }


      .due-price h4 {
        margin: 0;
      }

      .bill-to-section .right-sec {
        width: 130%;
        text-align: right;
      }

      .right-sec p span {
        padding-left: 10px;
        font-weight: bold;
      }

      .bill-to-section {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
      }

      table {
        width: 100%;
        margin-top: 20px;
      }

      thead {
        background-color: black;
        color: white;
        font-size: 12px;
      }

      tbody tr td {
        text-align: right;
        padding-right: 10px;
      }

      .total-section table {
        width: 80%;
        margin-left: auto;
      }

      .total-section table tr td {
        text-align: right;
      }

      .total-section table tr:last-child {
        background-color: rgb(214, 212, 212);
      }

      button {
        padding: 10px 20px;
        border-radius: 20px;
        background-color: green;
        color: white;
        font-family: "Poppins", sans-serif;
        cursor: pointer;
      }

      .download-btn{
        text-align: center;
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
    <div class="invoice-wrapper" id="pdf-container">
      <div class="container">
        <div class="container-company-invoice">
          <div class="company-info">
            <img
            src="{{asset('assets/images/new_logo_kv.png')}}"
              alt="kv-logo"
              width="150"
            />
            <h5>Krishi Vikas Udyog</h5>
            <p>
              Ground Floor, 4B, <br />Rani Bhabani Rd, <br />
              Sahanagar, Kalighat, <br />Kolkata, West Bengal <br />
              700026
            </p>
          </div>
          <div class="invoice-section">
            <h3>INVOICE</h3>
            <p>{{$boost_details->invoice_no}}</p>
          </div>
        </div>

        <div class="bill-to-section">
          <div class="left-sec">
            <h5>Bill To</h5>
            <p class="billto-name">{{$boost_details->name}}</p>
            <p class="bill-to-address">
              {{$boost_details->address}}, {{$boost_details->state_name}} {{$boost_details->district_name}},{{$boost_details->city_name}}
            </p>
            <p>{{$boost_details->zipcode}}</p>
          </div>
          <div class="right-sec">
            <p class="invoice-date">Start Date:<span>{{$start_date}}</span></p>
            <p class="time-bill">Time:<span>{{$start_time}}</span></p>
            <p class="due-date">End Date:<span>{{$end_date}}</span></p>
          </div>
        </div>

        <div class="invoice-table">
          <table>
            <thead>
              <tr>
                <th>Plan Name</th>
                <th>Rate</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Trial-99</td>
                <td>₹ {{$boost_details->price}}</td>
                <td>₹ {{$boost_details->price}}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="total-section">
          <table>
         


           <?php  if ($boost_details->gst > 0) { ?> 
            <tr>
              <td>GST In:</td>
              <td>₹ {{$boost_details->gst}}</td>
            </tr>
            <?php }if($boost_details->sgst > 0){ ?>
                <tr>
                    <td>CGST In:</td>
                    <td>₹ {{$boost_details->sgst}}</td>
                </tr>
            <?php }if($boost_details->cgst > 0){ ?>
                <tr>
                    <td>SGST In:</td>
                    <td>₹ {{$boost_details->cgst}}</td>
                </tr>
            <?php }if($boost_details->igst > 0){ ?>
                <tr>
                    <td>IGST In:</td>
                    <td>₹ {{$boost_details->igst}}</td>
                </tr>
            <?php } ?>    
                
            <tr>
              <td>Total Price:</td>
              <td>₹ {{$boost_details->purchased_price}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>

 

    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script>
      function downloadPDF() {
        var element = document.getElementById("pdf-container");

        html2pdf(element, {
          margin: 10,
          filename: "invoice.pdf",
          image: { type: "jpeg", quality: 0.98 },
          html2canvas: { scale: 1 },
          jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
        });
      }
    </script>
  </body>
</html>
