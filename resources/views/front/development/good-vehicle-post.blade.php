@extends('layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();
?>

    <!-- SELL RENT SECTION START -->
    <section class="post-category bg-t" id="pc">
        <div class="container glass-t">

            <div class="post-head pb-4">

            <img src="./assets/images/G-head.png" alt="" width="100">
                <h3><?php if (session()->has('bn')) {echo $lang['bn']['GOODS VEHICLE'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['GOODS VEHICLE'];} 
                    else { echo 'GOODS VEHICLE'; } 
                    ?></h3>

            </div>


        </div>
    </section>


<div class="form-content container">
    <form action="{{url('good-vahicle-posting')}}" method="post" class="form" enctype="multipart/form-data">
    @csrf
        <!-- Progress bar -->
        <div class="progressbar">
            <div class="progress" id="progress"></div>

            <div class="progress-step progress-step-active" data-title=""></div>
            <div class="progress-step" data-title=""></div>
            <div class="progress-step" data-title=""></div>
            <div class="progress-step" data-title=""></div>
            <div class="progress-step" data-title=""></div>
        </div>

        <!-- Steps -->
        <div class="form-step form-step-active animate__animated animate__zoomIn">
            <h2 class="fs-title text-center fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['What would you like to do?'];} 
                else if (session()->has('hn')) {echo $lang['hn']['What would you like to do?'];} 
                else { echo 'What would you like to do?'; } 
                ?></h2>
            <h3 class="fs-subtitle"></h3>
            <div class="container sr">
                <div class="row">
                    <div class="col-6 ">
                        <label for="" class="w-100 h-100">
                        <div class="rent option-post">
                                        <img src="./assets/images/deal.png" alt="" class="img-fluid">
                                        <p class="fs-3 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['RENT'];} 
                                            else if (session()->has('hn')) {echo $lang['hn']['RENT'];} 
                                            else { echo 'RENT'; } 
                                            ?></p>
                                    </div>
                        </label>
                        <input type="radio" id="rent-trac" class="d-none" name="set" value="rent">
                    </div>
                    <div class="col-6 ">
                        <label for="" class="w-100 h-100">
                        <div class="sell option-post">
                                        <img src="./assets/images/sell.png" alt="" class="img-fluid">
                                        <p class="fs-3 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['SELL'];} 
                                            else if (session()->has('hn')) {echo $lang['hn']['SELL'];} 
                                            else { echo 'SELL'; } 
                                            ?></p>
                                    </div>
                        </label>
                        <input type="radio" id="sell-trac" class="d-none" name="set" value="sell">
                    </div>
                </div>
            </div>
            <div class="sr-cat">
                <a href="#pc" class="btn btn-next width-50 ml-auto disabled">Next</a>
            </div>
        </div>



        <div class="form-step animate__animated animate__zoomIn">
            <h2 class="fs-title text-center fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['what is the condition'];} 
                else if (session()->has('hn')) {echo $lang['hn']['what is the condition'];} 
                else { echo 'what is the condition'; } 
                ?>
            </h2>
            <div class="container tractor-option nu-trac">
                <div class="row">
                    <div class="col-6 ">
                        <label for="" class="w-100 h-100">
                            
                            <div class="new sell option-post">
                                        <img src="./assets/images/GVnew.png" alt="" class="img-fluid">
                                        <p class="fs-3 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['NEW GOODS VEHICLE'];} 
                                            else if (session()->has('hn')) {echo $lang['hn']['NEW GOODS VEHICLE'];} 
                                            else { echo 'NEW GOODS VEHICLE'; } 
                                            ?></p>
                                    </div>
                    </label>
                    <input type="radio" id="new-trac" class="d-none" name="type" value="new">
                    </div>
                    <div class="col-6 ">
                       <label for="" class="w-100 h-100">
                       <div class="old sell option-post">
                                        <img src="./assets/images/GVold.png" alt="" class="img-fluid">
                                        <p class="fs-3 fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['USED GOODS VEHICLE'];} 
                                            else if (session()->has('hn')) {echo $lang['hn']['USED GOODS VEHICLE'];} 
                                            else { echo 'USED GOODS VEHICLE'; } 
                                            ?></p>
                                    </div>
                       </label>
                        <input type="radio" id="used-trac" class="d-none" name="type" value="old">
                    </div>
                </div>
            </div>
            <div class="btns-group nu">
                <a href="#pc" class="btn btn-prev">Previous</a>
                <a href="#pc" class="btn btn-next disabled">Next</a>
            </div>
        </div>

        <div class="form-step animate__animated animate__zoomIn">

            <h2 class="fs-title text-center fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['SELECT BRAND AND MODEL'];} 
                else if (session()->has('hn')) {echo $lang['hn']['SELECT BRAND AND MODEL'];} 
                else { echo 'SELECT BRAND AND MODEL'; } 
                ?></h2>


            <div id="msform1" class="mb">
                <label class="fieldlabels text-dark fw-bolder"><?php if (session()->has('bn')) {echo $lang['bn']['select brand'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['select brand'];} 
                    else { echo 'Select Brand'; } 
                    ?>: *</label>
                <div class="mb-2  modelBrand">
                <select class="js-example-basic-single form-select" id="brand_id" name="brand_id" onchange="brand_to_model(this.value)" required >
                    
                    <option value="">Select</option>
                    @foreach ($brand as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                </div>

                <label class="fieldlabels text-dark fw-bolder"><?php if (session()->has('bn')) {echo $lang['bn']['select model'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['select model'];} 
                    else { echo 'Select Model'; } 
                    ?>: *</label>
                <div class="mb-2  modelBrand">
                <select class="js-example-basic-single form-select" required name="model_id" id="model_id">
                    
                </select>
                </div>
                
                    
                
            </div>
            <!-- <div class="input-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" />
        </div>
        <div class="input-group">
          <label for="confirmPassword">Confirm Password</label>
          <input
            type="password"
            name="confirmPassword"
            id="confirmPassword"
          />
        </div> -->
            <div class="btns-group mb-btn">
                <a href="#pc" class="btn btn-prev">Previous</a>
                <a href="#pc" class="btn btn-next disabled">Next</a>
            </div>
        </div>

        <div class="form-step animate__animated animate__zoomIn enDetails">
            <h2 class="fs-title text-center fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['ENTER DETAILS'];} 
                else if (session()->has('hn')) {echo $lang['hn']['ENTER DETAILS'];} 
                else { echo 'ENTER DETAILS'; } 
                ?></h2>
            <div class="container tractor-brand" id="msform1">
                <label class="fieldlabels text-dark">Select Year of Manufacture: *</label>
                <select class="form-select" name="yop" required>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                    <option value="2008">2008</option>
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                    <option value="2004">2004</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1999">1999</option>
                    <option value="1998">1998</option>
                    <option value="1997">1997</option>
                    <option value="1996">1996</option>
                    <option value="1995">1995</option>
                    <option value="1994">1994</option>
                    <option value="1993">1993</option>
                    <option value="1992">1992</option>
                    <option value="1991">1991</option>
                    <option value="1990">1990</option>
                </select>

                <br>
                <div class="form-check  flip-flop">

                    <div> <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">RC
                            Available
                        </label></div>
                    <div><div class="form-check d-flex gap-5">
  <div>
      <input class="form-check-input" type="radio" name="rc_available" id="flexRadioDefault1" value="true">
  <label class="form-check-label" for="flexRadioDefault1" >
    Yes
  </label>
  </div>
    <div>
      <input class="form-check-input" type="radio" name="rc_available" id="flexRadioDefault1" value="false">
  <label class="form-check-label" for="flexRadioDefault1" >
    No
  </label>
  </div>

    
</div></div>

                </div>

                <div class="form-check  flip-flop">

                    <div> <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">NOC
                            Available
                        </label></div>
                    <div><div class="form-check d-flex gap-5">
  <div>
      <input class="form-check-input" type="radio" name="noc_available" id="flexRadioDefault1" value="true">
  <label class="form-check-label" for="flexRadioDefault1" >
    Yes
  </label>
  </div>
    <div>
      <input class="form-check-input" type="radio" name="noc_available" id="flexRadioDefault1" value="false">
  <label class="form-check-label" for="flexRadioDefault1" >
    No
  </label>
  </div>

    
</div></div>

                </div>


                <input type="text" placeholder="Registration Number*" name="registration_number" required/>
                <input type="number" placeholder="Price*" name="price" required/>

                <div class="form-check flip-flop">

                    <div> <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">Is Negotiable
                        </label></div>
                    <div><div class="form-check d-flex gap-5">
  <div>
      <input class="form-check-input" type="radio" name="is_negotiable" id="flexRadioDefault1" value="true">
  <label class="form-check-label" for="flexRadioDefault1" >
    Yes
  </label>
  </div>
    <div>
      <input class="form-check-input" type="radio" name="is_negotiable" id="flexRadioDefault1" value="false">
  <label class="form-check-label" for="flexRadioDefault1" >
    No
  </label>
  </div>

    
</div></div>

                </div>

                <div class="rent-select w-100">
                    <label class="fieldlabels text-dark float-start">Rent: *</label>

                    <select name="rent_type" id="rent_type">
                    <option value="volvo">Select option</option>
                    <option value="Per Hour">Per Hour</option>
                    <option value="Per Day">Per Day</option>
                    <option value="Per Month">Per Month</option>
                    </select>
                </div>

                <label class="fieldlabels text-dark">Enter Zipcode: *</label>
                <input type="text" name="pincode" id="reg_pincode" placeholder="Zipcode" required/>

                <label class="fieldlabels text-dark">State Name: *</label>
                <input type="text" id="reg_state" placeholder="State Name" />
                <label class="fieldlabels text-dark">City/Town/Area: *</label>
                <input type="text" id="reg_city" placeholder="City/Town/Area" />

                

                <label class="fieldlabels text-dark">Description: </label>
                <textarea name="description" id="description" cols="20" rows="10" placeholder="Description"
                    class="" ></textarea>
            </div>

            <div class="btns-group ed">
                <a href="#pc" class="btn btn-prev">Previous</a>
                <a href="#pc" class="btn btn-next disabled next-ed">Next</a>
            </div>
        </div>



        <div class="form-step animate__animated animate__zoomIn">

            <h2 class="fs-title text-center fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['Image Upload'];} 
                else if (session()->has('hn')) {echo $lang['hn']['Image Upload'];} 
                else { echo 'Image Upload'; } 
                ?></h2>

            <div class="container upl">
                <div class="row">

                    <div class="col-6">
                    <div class="img-trac-box fw-bold">
                                        <p class="text-center">FRONT SIDE IMAGE</p>
                                        <img id="preview-g1" class="img-fluid"
                                                src="./assets/images/frontG.png" alt="">
                                        <!-- <input type="file" id="front-img" name="filename" class="d-none"
                                            accept="image/*" capture="camera"> -->
                                        <div class="camera-option d-none block-g1">
                                            <div class="bg-white p-5">
                                                <div class="camera-click">
                                                    <label for="front-img-g1"><i class="fa-solid fa-camera"></i>
                                                        Capture</label>
                                                    <input type="file" id="front-img-g1" name="front_image1" accept="image/*"
                                                        capture="camera" class="d-none">
                                                </div>
                                                <div class="gallery-click">
                                                    <label for="front-img-g2"><i class="fa-regular fa-image"></i> Choose
                                                        from Gallery</label>
                                                    <input type="file" id="front-img-g2" name="front_image2" class="d-none">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                    </div>

                    <div class="col-6">
                    <div class="img-trac-box fw-bold">
                                        <p class="text-center">BACK SIDE IMAGE</p>
                                        <img id="preview-g2" class="img-fluid"
                                                src="./assets/images/backG.png" alt="">
                                        <!-- <input type="file" id="back-img" name="filename" class="d-none" accept="image/*"
                                            capture="camera"> -->

                                        <div class="camera-option d-none block-g2">
                                            <div class="bg-white p-5">
                                                <div class="camera-click">
                                                    <label for="back-img-g1"><i class="fa-solid fa-camera"></i>
                                                        Capture</label>
                                                    <input type="file" id="back-img-g1" name="back_image1" accept="image/*"
                                                        capture="camera" class="d-none">
                                                </div>
                                                <div class="gallery-click">
                                                    <label for="back-img-g2"><i class="fa-regular fa-image"></i> Choose
                                                        from Gallery</label>
                                                    <input type="file" id="back-img-g2" name="back_image2" class="d-none">
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                    </div>

                    <div class="col-6">
                    <div class="img-trac-box">
                                        <p class="text-center fw-bold">LEFT SIDE IMAGE</p>
                                        <img id="preview-g3" class="img-fluid"
                                                src="./assets/images/leftG.png" alt="">
                                        <!-- <input type="file" id="left-img" name="filename" class="d-none" accept="image/*"
                                            capture="camera"> -->
                                        <div class="camera-option d-none block-g3">
                                            <div class="bg-white p-5">
                                                <div class="camera-click">
                                                    <label for="left-img-g1"><i class="fa-solid fa-camera"></i>
                                                        Capture</label>
                                                    <input type="file" id="left-img-g1" name="left_image1" accept="image/*"
                                                        capture="camera" class="d-none">
                                                </div>
                                                <div class="gallery-click">
                                                    <label for="left-img-g2"><i class="fa-regular fa-image"></i> Choose
                                                        from Gallery</label>
                                                    <input type="file" id="left-img-g2" name="left_image2" class="d-none">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                    </div>

                    <div class="col-6">
                    <div class="img-trac-box fw-bold">
                                        <p class="text-center">RIGHT SIDE IMAGE</p>
                                       <img id="preview-g4" class="img-fluid"
                                                src="./assets/images/rightG.png" alt="">
                                        <!-- <input type="file" id="right-img" name="filename" class="d-none"
                                            accept="image/*" capture="camera"> -->

                                            <div class="camera-option d-none block-g4">
                                                <div class="bg-white p-5">
                                                    <div class="camera-click">
                                                        <label for="right-img-g1"><i class="fa-solid fa-camera"></i>
                                                            Capture</label>
                                                        <input type="file" id="right-img-g1" name="right_image1" accept="image/*"
                                                            capture="camera" class="d-none">
                                                    </div>
                                                    <div class="gallery-click">
                                                        <label for="right-img-g2"><i class="fa-regular fa-image"></i> Choose
                                                            from Gallery</label>
                                                        <input type="file" id="right-img-g2" name="right_image2" class="d-none">
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                    </div>

                    <div class="col-6">
                    <div class="img-trac-box fw-bold">
                                        <p class="text-center">METER IMAGE</p>
                                        <img class="img-fluid" id="preview-g5"
                                                src="./assets/images/meter.png" alt="">
                                        <!-- <input type="file" id="meter-img" name="filename" class="d-none"
                                            accept="image/*" capture="camera"> -->
                                            <div class="camera-option d-none block-g5">
                                                <div class="bg-white p-5">
                                                    <div class="camera-click">
                                                        <label for="meter-img-g1"><i class="fa-solid fa-camera"></i>
                                                            Capture</label>
                                                        <input type="file" id="meter-img-g1" name="meter_image1" accept="image/*"
                                                            capture="camera" class="d-none">
                                                    </div>
                                                    <div class="gallery-click">
                                                        <label for="meter-img-g2"><i class="fa-regular fa-image"></i> Choose
                                                            from Gallery</label>
                                                        <input type="file" id="meter-img-g2" name="meter_image2" class="d-none">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                    </div>
                    <div class="col-6">
                    <div class="img-trac-box fw-bold">
                                        <p class="text-center">TYRE IMAGE</p>
                                        <img class="img-fluid" id="preview-g6"
                                                src="./assets/images/tyre-post.png" alt="">
                                        <!-- <input type="file" id="tyre-img" name="filename" class="d-none" accept="image/*"
                                            capture="camera"> -->
                                            <div class="camera-option d-none block-g6">
                                                <div class="bg-white p-5">
                                                    <div class="camera-click">
                                                        <label for="tyre-img-g1"><i class="fa-solid fa-camera"></i>
                                                            Capture</label>
                                                        <input type="file" id="tyre-img-g1" name="tyre_image1" accept="image/*"
                                                            capture="camera" class="d-none">
                                                    </div>
                                                    <div class="gallery-click">
                                                        <label for="tyre-img-g2"><i class="fa-regular fa-image"></i> Choose
                                                            from Gallery</label>
                                                        <input type="file" id="tyre-img-g2" name="tyre_image2" class="d-none">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                    </div>
                </div>

            </div>

            <div class="btns-group">
                <a href="#pc" class="btn btn-prev">Previous</a>
                <input type="submit" value="Submit" class="btn submit-btn disabled" />
            </div>

        </div>


    </form>
</div>

</section>
                </div>
            </div>
            <div class="col-lg-12 ">
                <div class="post-ban w-100 h-100 pb-4">
                    <img src="./assets/images/1024-X-512_banner1.jpg" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <!-- TRACTOR POST MODAL END -->

    <!-- SIGNUP_LOGIN MODAL -->

    <!-- The Modal -->

    <script>
        $(document).ready(function () {
            // Check if the user's choice is already stored
            
            var userChoice = localStorage.getItem("user-choice");
            var kvuser_type = {{ Session::get('kvuser_type')  }};
            if (userChoice == "sell") {
                // If the user chose "Sell" on the first page, select the "Sell" radio button
                $('input[id="sell-trac"]').prop("checked", true);
                $(".rent-select").addClass("d-none");
                $('.sell').click();
                
                if (kvuser_type==1) {
                    $('input[id="used-trac"]').prop("checked", true);
                    $('.old').click();
                    document.querySelector(".nu .btn-next").click();
                } else if (kvuser_type==2) {
                    $('input[id="new-trac"]').prop("checked", true);
                    $('.new').click();
                }
            } 
            else if (userChoice == "rent") {
                // If the user chose "Rent" on the first page, select the "Rent" radio button
                $('input[id="rent-trac"]').prop("checked", true);
                $(".rent-select").removeClass("d-none");
                $('.rent').click();

                if (kvuser_type==1) {
                    $('input[id="used-trac"]').prop("checked", true);
                    $('.old').click();
                    document.querySelector(".nu .btn-next").click();
                } else if (kvuser_type==2) {
                    $('input[id="new-trac"]').prop("checked", true);
                    $('.new').click();
                }
            }

            // Simulate a click on the "Next" button
            //document.querySelector('.sr-cat .btn').click();
        });
    </script>

@endsection