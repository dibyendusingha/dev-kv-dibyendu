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

            <img src="./assets/images/ddd.png" alt="" width="100">
                <h3><?php if (session()->has('bn')) {echo $lang['bn']['SEEDS'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['SEEDS'];} 
                    else { echo 'SEEDS'; } 
                    ?></h3>

            </div>


        </div>
    </section>


<div class="form-content container">
    <form action="{{url('seeds-posting')}}" method="post" class="form" enctype="multipart/form-data">
        @csrf
        <!-- Progress bar -->
        <div class="progressbar">
            <div class="progress" id="progress"></div>

            <div class="progress-step progress-step-active" data-title=""></div>
            <div class="progress-step" data-title=""></div>
            
        </div>


        <div class="form-step form-step-active animate__animated animate__zoomIn enDetails">
            <h2 class="fs-title text-center fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['ENTER DETAILS'];} 
                else if (session()->has('hn')) {echo $lang['hn']['ENTER DETAILS'];} 
                else { echo 'ENTER DETAILS'; } 
                ?></h2>
            <div class="container tractor-brand" id="msform1">
                
            <input type="text" placeholder="Title*" name="title"/>
                

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

                <label class="fieldlabels text-dark">Enter Zipcode: *<span
                                                                class="validate zipcode-validation"></span></label>
                <input type="text" id="reg_pincode" name="pincode" placeholder="Zipcode" required/>

                <label class="fieldlabels text-dark">State Name: *</label>
                <input type="text" id="reg_state" name="reg_state" placeholder="State Name" required/>
                <label class="fieldlabels text-dark">City/Town/Area: *</label>
                <input type="text" id="reg_city" name="reg_city" placeholder="City/Town/Area" required/>

                

                <label class="fieldlabels text-dark">Description: </label>
                <textarea name="description" id="description" cols="20" rows="10" placeholder="Description"
                    class="" ></textarea>
            </div>

            <div class="btns-group ed">
               
                <a href="#pc" class="btn btn-next disabled next-ed">Next</a>
            </div>
        </div>



        <div class="form-step animate__animated animate__zoomIn upl">

            <h2 class="fs-title text-center fw-bold"><?php if (session()->has('bn')) {echo $lang['bn']['Image Upload'];} 
                else if (session()->has('hn')) {echo $lang['hn']['Image Upload'];} 
                else { echo 'Image Upload'; } 
                ?></h2>

            <div class="container">
                <div class="row">

                    <div class="col-6 mb-2">
                    <div class="img-trac-box fw-bold">
                                        <p class="text-center pt-2">IMAGE 1</p>
                                        <img id="preview-s1" class="img-fluid"
                                                src="./assets/images/seed-cat.png" alt="">
                                        <!-- <input type="file" id="front-img" name="filename" class="d-none"
                                            accept="image/*" capture="camera"> -->
                                        <div class="camera-option d-none block-s1">
                                            <div class="bg-white p-5">
                                                <div class="camera-click">
                                                    <label for="front-img-s1"><i class="fa-solid fa-camera"></i>
                                                        Capture</label>
                                                    <input type="file" id="front-img-s1" name="image1_1" accept="image/*"
                                                        capture="camera" class="d-none">
                                                </div>
                                                <div class="gallery-click">
                                                    <label for="front-img-s2"><i class="fa-regular fa-image"></i> Choose
                                                        from Gallery</label>
                                                    <input type="file" id="front-img-s2" name="image1_2" class="d-none">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                    </div>

                    <div class="col-6">
                    <div class="img-trac-box fw-bold">
                                        <p class="text-center pt-2">IMAGE 2</p>
                                        <img id="preview-s2" class="img-fluid"
                                                src="./assets/images/seed-cat.png" alt="">
                                        <!-- <input type="file" id="back-img" name="filename" class="d-none" accept="image/*"
                                            capture="camera"> -->

                                        <div class="camera-option d-none block-s2">
                                            <div class="bg-white p-5">
                                                <div class="camera-click">
                                                    <label for="back-img-s1"><i class="fa-solid fa-camera"></i>
                                                        Capture</label>
                                                    <input type="file" id="back-img-s1" name="image2_1" accept="image/*"
                                                        capture="camera" class="d-none">
                                                </div>
                                                <div class="gallery-click">
                                                    <label for="back-img-s2"><i class="fa-regular fa-image"></i> Choose
                                                        from Gallery</label>
                                                    <input type="file" id="back-img-s2" name="image2_2" class="d-none">
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                    </div>

                    <div class="col-6">
                    <div class="img-trac-box">
                                        <p class="text-center pt-2">IMAGE 3</p>
                                        <img id="preview-s3" class="img-fluid"
                                                src="./assets/images/seed-cat.png" alt="">
                                        <!-- <input type="file" id="left-img" name="filename" class="d-none" accept="image/*"
                                            capture="camera"> -->
                                        <div class="camera-option d-none block-s3">
                                            <div class="bg-white p-5">
                                                <div class="camera-click">
                                                    <label for="left-img-s1"><i class="fa-solid fa-camera"></i>
                                                        Capture</label>
                                                    <input type="file" id="left-img-s1" name="image3_1" accept="image/*"
                                                        capture="camera" class="d-none">
                                                </div>
                                                <div class="gallery-click">
                                                    <label for="left-img-s2"><i class="fa-regular fa-image"></i> Choose
                                                        from Gallery</label>
                                                    <input type="file" id="left-img-s2" name="image3_2" class="d-none">
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

@endsection