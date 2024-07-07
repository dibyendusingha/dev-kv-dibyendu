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
        width: 700px;
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
            font-size: 22px;
    line-height: 30px;
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
        text-align: left;
      }
      
      .left-sec{
          width: 50%;
      }

      .right-sec p span {
        padding-left: 10px;
        font-weight: bold;
      }

      .bill-to-section {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        gap: 50px;
      }

      table {
        width: 100%;
        margin-top: 20px;
      }

      thead {
        background-color: black;
        color: white;
        font-size: 22px;
      }

      tbody tr td {
        text-align: right;
        padding-right: 10px;
        font-size: 22px;
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
              width="250"
            />
            <h1>Krishi Vikas Udyog</h1>
            <p>
              Ground Floor, 4B, <br />Rani Bhabani Rd, <br />
              Sahanagar, Kalighat, <br />Kolkata, West Bengal <br />
              700026
            </p>
          </div>
          <div class="invoice-section">
            <h2>INVOICE</h2>
            <p>{{$invoice_no}}</p>
          </div>
        </div>

        <div class="bill-to-section">
          <div class="left-sec">
            <h2>Bill To</h2>
            <p class="billto-name">{{$user_name}}</p>
            <p class="bill-to-address">
              {{$user_state_name}}, {{$user_district_name}},{{$user_city_name}}. {{$user_zipcode}}
            </p>
          </div>
          <div class="right-sec">
            <p class="invoice-date">Invoice Date:<span>{{$invoice_start_date}}</span></p>
            <p class="due-date">End Date:<span>{{$invoice_end_date}}</span></p>
          </div>
        </div>

        <div class="invoice-table">
          <table>
            <thead>
              <tr>
                <th>Plan Name</th>
              
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$plane_name}}</td>
              
                <td>₹ {{$plane_price}}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="total-section">
          <table>
            <tr>
              <td>Price:</td>
              <td>₹ {{$plane_price}}</td>
            </tr>

            <!-- GST -->
            <?php if($gst > 0){ ?>
            <tr>
              <td>GST In:</td>
              <td>₹ {{$gst}}</td>
            </tr>
            <?php }?>

            <!-- SGST -->
            <?php if($sgst > 0){ ?>
            <tr>
              <td>SGST In:</td>
              <td>₹ {{$sgst}}</td>
            </tr>
            <?php }?>

            <!-- CGST -->
            <?php if($cgst > 0){ ?>
            <tr>
              <td>CGST In:</td>
              <td>₹ {{$cgst}}</td>
            </tr>
            <?php }?>

            <!-- IGST -->
            <?php if($igst > 0){ ?>
            <tr>
              <td>IGST In:</td>
              <td>₹ {{$igst}}</td>
            </tr>
            <?php }?>

            <?php if($discount > 0){?>
            <tr>
              <td>Discount :</td>
              <td>{{$discount}} %</td>
            </tr>
            <?php }else{ ?>
              <tr>
              <td>Discount :</td>
              <td>{{$discount}}</td>
            </tr>
            <?php }?>

            <tr>
              <td>Total Paid Amount :</td>
              <td>₹ {{$total_price}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div class="download-btn">
        <button onclick="downloadPDF()">Download INVOICE</button>
    </div>

    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script>
      function downloadPDF() {
        var element = document.getElementById("pdf-container");
        console.log(element);
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
