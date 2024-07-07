<?php

use Illuminate\Support\Str;
use App\Models\language;

$lang = language::language();
?>
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content  animate__animated animate__zoomIn animate__fast">
        <span class="close"><i class="fa-solid fa-xmark"></i></span>

        <!-- LOCATION PAGE -->
        <div class="adr" id="adr">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 bgc p-4">
                        <h1><?php if (session()->has('bn')) {
                                echo $lang['bn']['LOCATION'];
                            } else if (session()->has('hn')) {
                                echo $lang['hn']['LOCATION'];
                            } else {
                                echo 'LOCATION';
                            }
                            ?></h1>
                        <p><?php if (session()->has('bn')) {
                                echo $lang['bn']['Select your location/address to serve quickly.'];
                            } else if (session()->has('hn')) {
                                echo $lang['hn']['Select your location/address to serve quickly.'];
                            } else {
                                echo 'Select your location/address to serve quickly.';
                            }
                            ?></p>
                        <img src="{{ URL::asset('assets/images/293.png')}}" alt="" class="img-fluid">
                        <img src="{{ URL::asset('assets/images/V_-_Card-01-removebg-preview.png')}}" alt="" class="img-fluid" id="logo-kv">
                    </div>

                    <div class="col-lg-8 p-4">
                        <div class="form-modal">
                            <h3>
                                <?php if (session()->has('bn')) {
                                    echo $lang['bn']['SELECT ADDRESS'];
                                } else if (session()->has('hn')) {
                                    echo $lang['hn']['SELECT ADDRESS'];
                                } else {
                                    echo 'SELECT ADDRESS';
                                }
                                ?></h3>
                            <div class="login-block ">

                                <?php
                                if (session()->has('KVMobile')) { ?>

                                    <p class="pt-2 m-0"><?php if (session()->has('bn')) {
                                                            echo $lang['bn']['Please Update Your Profile'];
                                                        } else if (session()->has('hn')) {
                                                            echo $lang['hn']['Please Update Your Profile'];
                                                        } else {
                                                            echo 'Please Update Your Profile';
                                                        }
                                                        ?></p>

                                    <a href="{{url('profile#page4')}}" class="btn btn-success"><?php if (session()->has('bn')) {
                                                                                                    echo $lang['bn']['profile update'];
                                                                                                } else if (session()->has('hn')) {
                                                                                                    echo $lang['hn']['profile update'];
                                                                                                } else {
                                                                                                    echo 'profile update';
                                                                                                }
                                                                                                ?></a>
                                <?php } else { ?>
                                    <p class="pt-2 m-0"><?php if (session()->has('bn')) {
                                                            echo $lang['bn']['Login to view your saved search address'];
                                                        } else if (session()->has('hn')) {
                                                            echo $lang['hn']['Login to view your saved search address'];
                                                        } else {
                                                            echo 'Login to view your saved search address';
                                                        }
                                                        ?></p>
                                    <button type="button" class="btn login" id="enable-login"><?php if (session()->has('bn')) {
                                                                                                    echo $lang['bn']['login'];
                                                                                                } else if (session()->has('hn')) {
                                                                                                    echo $lang['hn']['login'];
                                                                                                } else {
                                                                                                    echo 'login';
                                                                                                }
                                                                                                ?></button>
                                <?php } ?>
                            </div>
                            <h4 class="text-center pt-2">OR</h4>

                            <h3><?php if (session()->has('bn')) {
                                    echo $lang['bn']['PINCODE'];
                                } else if (session()->has('hn')) {
                                    echo $lang['hn']['PINCODE'];
                                } else {
                                    echo 'PINCODE';
                                }
                                ?></h3>
                            <div class="login-block ">
                                <p class="m-0 pt-2"><?php if (session()->has('bn')) {
                                                        echo $lang['bn']['Enter a pincode'];
                                                    } else if (session()->has('hn')) {
                                                        echo $lang['hn']['Enter a pincode'];
                                                    } else {
                                                        echo 'Enter a pincode';
                                                    }
                                                    ?></p>

                                <div class=" lblock d-flex align-items-center justify-content-around mx-5 g-5 flex-column">
                                    <input type="text" id="pincode" placeholder="Pincode" onkeypress="return allowOnlyNumbers(event)" onkeyup="validPincodeMsg(this.value)" value="<?php
                                                                                                                                                                                    if (session()->has('pincode')) {
                                                                                                                                                                                        echo $pincode = session()->get('pincode');
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo $pincode = session()->put('pincode', $pincode_ip);
                                                                                                                                                                                    } ?>" />
                                    <div id="pincode_msg" style="display: block;width: 100%;text-align: left;"></div>
                                    <button type="button" id="pincode_apply" class="btn login ms-3"><?php if (session()->has('bn')) {
                                                                                                        echo $lang['bn']['APPLY'];
                                                                                                    } else if (session()->has('hn')) {
                                                                                                        echo $lang['hn']['APPLY'];
                                                                                                    } else {
                                                                                                        echo 'APPLY';
                                                                                                    }
                                                                                                    ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LOCATION PAGE  END-->
        <div class="container-fluid" id="l-and-s">
            <div class="row">
                <!-- <div class="col-lg-5 bgc d-none">

                <h1 class="fs-3 text-center mt-5">LOGIN & SIGN UP</h1>
                <img src="./assets/images/293.png" alt="" class="img-fluid">
                <img src="./assets/images/V_-_Card-01-removebg-preview.png" alt="" class="img-fluid"
                    id="logo-kv">

            </div> -->
                <div class="col-lg-12">
                    <div class="form-modal mb-4">

                        <div class="form-toggle mt-5">
                            <button id="login-toggle" onclick="toggleLogin();"><?php if (session()->has('bn')) {
                                                                                    echo $lang['bn']['log in'];
                                                                                } else if (session()->has('hn')) {
                                                                                    echo $lang['hn']['log in'];
                                                                                } else {
                                                                                    echo 'log in';
                                                                                }
                                                                                ?></button>
                            <button id="signup-toggle" onclick="toggleSignup();"><?php if (session()->has('bn')) {
                                                                                        echo $lang['bn']['sign up'];
                                                                                    } else if (session()->has('hn')) {
                                                                                        echo $lang['hn']['sign up'];
                                                                                    } else {
                                                                                        echo 'sign up';
                                                                                    }
                                                                                    ?></button>
                        </div>

                        <div id="login-form">

                            <form>
                                <div class="step-1" id="step1">
                                    <p class="text-center"><?php if (session()->has('bn')) {
                                                                echo $lang['bn']['Please Login to Continue'];
                                                            } else if (session()->has('hn')) {
                                                                echo $lang['hn']['Please Login to Continue'];
                                                            } else {
                                                                echo 'Please Login to Continue';
                                                            }
                                                            ?></p>

                                    <div class="d-flex flex-lg-row flex-column">

                                        <input type="text" name="mobile_login" id="mobile_login" placeholder="Enter Mobile Number" onkeypress="return allowOnlyNumbers(event)" />

                                        <button type="button" class="btn login otp_button" id="lvo"><?php if (session()->has('bn')) {
                                                                                                        echo $lang['bn']['login via OTP'];
                                                                                                    } else if (session()->has('hn')) {
                                                                                                        echo $lang['hn']['login via OTP'];
                                                                                                    } else {
                                                                                                        echo 'login via OTP';
                                                                                                    }
                                                                                                    ?></button>
                                    </div>
                                    <span class="validate phno-validation message"></span>



                                </div>

                                <div class="step-2" id="step2">

                                    <div class="text-center">

                                        <p class="text-success"><?php if (session()->has('bn')) {
                                                                    echo $lang['bn']['OTP sent to your mobile number. Kindly check'];
                                                                } else if (session()->has('hn')) {
                                                                    echo $lang['hn']['OTP sent to your mobile number. Kindly check'];
                                                                } else {
                                                                    echo 'OTP sent to your mobile number. Kindly check !!';
                                                                }
                                                                ?></p>
                                        <div id="otp" class="mt-2">
                                            <input class="m-2 form-control rounded d-inline otp-input" type="number" id="first" maxlength="1" />
                                            <input class="m-2 form-control rounded otp-input" type="number" id="second" maxlength="1" />
                                            <input class="m-2 form-control rounded otp-input" type="number" id="third" maxlength="1" />
                                            <input class="m-2 form-control rounded otp-input" type="number" id="fourth" maxlength="1" />
                                            <input class="m-2 form-control rounded otp-input" type="number" id="fifth" maxlength="1" />
                                            <input class="m-2 form-control rounded otp-input" type="number" id="sixth" maxlength="1" />
                                        </div>
                                    </div>

                                    <div class="mt-4"> <button type="button" class="btn login verify_otp" id="votp"><?php if (session()->has('bn')) {
                                                                                                                        echo $lang['bn']['Validate OTP'];
                                                                                                                    } else if (session()->has('hn')) {
                                                                                                                        echo $lang['hn']['Validate OTP'];
                                                                                                                    } else {
                                                                                                                        echo 'Validate OTP';
                                                                                                                    }
                                                                                                                    ?></button> </div>
                                </div>

                                <div id="success_msg_login" style="display:none;">
                                    <h2 class="purple-text text-center"><strong>SUCCESS
                                            !</strong>
                                    </h2> <br>
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <img src="{{ URL::asset('assets/images/tick-mark-symbol-icon-26.png')}}" class="fit-image">
                                        </div>
                                    </div> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5 class="purple-text text-center"><?php if (session()->has('bn')) {
                                                                                    echo $lang['bn']['You are successfully logged in'];
                                                                                } else if (session()->has('hn')) {
                                                                                    echo $lang['hn']['You are successfully logged in'];
                                                                                } else {
                                                                                    echo 'You are successfully logged in';
                                                                                }
                                                                                ?></h5>
                                        </div>
                                    </div>
                                </div>

                                <div id="failed_msg_login" style="display:none;">
                                    <h2 class="purple-text text-center text-danger"><strong>FAILED!</strong>
                                    </h2> <br>
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <img src="{{ URL::asset('assets/images/cross.png')}}" class="fit-image" style="width: 80px">
                                        </div>
                                    </div> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5 class="purple-text text-center text-danger"><?php if (session()->has('bn')) {
                                                                                                echo $lang['bn']['Failed to Sign Up'];
                                                                                            } else if (session()->has('hn')) {
                                                                                                echo $lang['hn']['Failed to Sign Up'];
                                                                                            } else {
                                                                                                echo 'Failed to Sign Up';
                                                                                            }
                                                                                            ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div>


                            <div class="container-fluid" id="signup-form">
                                <div class="row justify-content-center w-100 m-0">
                                    <div class="col-12 text-center p-0  mb-2">
                                        <div class="card px-0 pb-0 pt-2 mb-3">

                                            <form id="msform" class="registration_form" enctype="multipart/form-data">
                                                <!-- progressbar -->
                                                <ul id="progressbar">
                                                    <li class="active" id="account"><strong>Category</strong>
                                                    </li>
                                                    <li id="personal"><strong>Personal</strong></li>
                                                    <li id="address"><strong>Address</strong></li>
                                                    <li id="payment"><strong>Image</strong></li>
                                                    <li id="confirm"><strong>Verify</strong></li>
                                                </ul>
                                                <!-- fieldsets -->
                                                <fieldset>
                                                    <div class="form-card">


                                                        <div class="user-type mb-2 w-100 border rounded border-dark">
                                                            <div class="d-flex">
                                                                <h4 class="p-3"><?php if (session()->has('bn')) {
                                                                                    echo $lang['bn']['Who are you?'];
                                                                                } else if (session()->has('hn')) {
                                                                                    echo $lang['hn']['Who are you?'];
                                                                                } else {
                                                                                    echo 'Who are you?';
                                                                                }
                                                                                ?></h4>

                                                                <label class="radio px-3 dealer" onclick="myFunction1();">
                                                                    <input type="radio" name="user_type" id="dealer" value="2" checked>
                                                                    <p>DEALER</p>
                                                                </label>
                                                                <label class="radio px-3 individual" onclick="myFunction2();">
                                                                    <input type="radio" name="user_type" id="individual" value="1">
                                                                    <p>INDIVIDUAL</p>
                                                                </label>
                                                            </div>
                                                        </div>



                                                    </div> <input type="button" name="next" class="next action-button" value="Next" />
                                                </fieldset>
                                                <fieldset>
                                                    <div class="form-card">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="option-change">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="">
                                                                                <label class="fieldlabels"><?php if (session()->has('bn')) {
                                                                                                                echo $lang['bn']['Company Name'];
                                                                                                            } else if (session()->has('hn')) {
                                                                                                                echo $lang['hn']['Company Name'];
                                                                                                            } else {
                                                                                                                echo 'Company Name';
                                                                                                            }
                                                                                                            ?><span class="text-danger">*</span></label>
                                                                                <input class="request_reg" type="text" placeholder="Company Name" id="c_name" name="c_name" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="">
                                                                                <label class="fieldlabels"><?php if (session()->has('bn')) {
                                                                                                                echo $lang['bn']['GST Number'];
                                                                                                            } else if (session()->has('hn')) {
                                                                                                                echo $lang['hn']['GST Number'];
                                                                                                            } else {
                                                                                                                echo 'GST Number';
                                                                                                            }
                                                                                                            ?><span class="text-danger">*</span></label>
                                                                                <input class="request_reg" type="text" placeholder="GST Number" id="gst_no" name="gst_no" />
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="fieldlabels"><?php if (session()->has('bn')) {
                                                                                                echo $lang['bn']['Name'];
                                                                                            } else if (session()->has('hn')) {
                                                                                                echo $lang['hn']['Name'];
                                                                                            } else {
                                                                                                echo 'Name';
                                                                                            }
                                                                                            ?> <span class="text-danger">*</span></label>
                                                                <input type="text" class="request_reg personal" name="reg_name" id="reg_name" placeholder="Name" required />

                                                                <label class="fieldlabels"><?php if (session()->has('bn')) {
                                                                                                echo $lang['bn']['Contact No'];
                                                                                            } else if (session()->has('hn')) {
                                                                                                echo $lang['hn']['Contact No'];
                                                                                            } else {
                                                                                                echo 'Contact No';
                                                                                            }
                                                                                            ?> <span class="text-danger">*</span></label>
                                                                <input type="text" class="request_reg personal" name="reg_phno" id="reg_phno" placeholder="Contact No." onkeypress="return allowOnlyNumbers(event)" required />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="fieldlabels"><?php if (session()->has('bn')) {
                                                                                                echo $lang['bn']['Email Id'];
                                                                                            } else if (session()->has('hn')) {
                                                                                                echo $lang['hn']['Email Id'];
                                                                                            } else {
                                                                                                echo 'Email Id';
                                                                                            }
                                                                                            ?> <span class="validate email-validation"></span></label>
                                                                <input type="reg_email" class="request_reg personal" name="reg_email" placeholder="Email Id." id="email_id" />

                                                                <label class="fieldlabels"><?php if (session()->has('bn')) {
                                                                                                echo $lang['bn']['Date of Birth'];
                                                                                            } else if (session()->has('hn')) {
                                                                                                echo $lang['hn']['Date of Birth'];
                                                                                            } else {
                                                                                                echo 'Date of Birth';
                                                                                            }
                                                                                            ?> <span class="text-danger">*</span></label>
                                                                <input type="date" class="request_reg" name="reg_dob" id="reg_dob" placeholder="Date of Birth" required />
                                                            </div>

                                                        </div>


                                                    </div> <input type="button" name="next" class="btn next action-button next1 disabled" value="Next" />
                                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                                </fieldset>
                                                <fieldset>
                                                    <div class="form-card">
                                                        <label class="fieldlabels"><?php if (session()->has('bn')) {
                                                                                        echo $lang['bn']['Zipcode'];
                                                                                    } else if (session()->has('hn')) {
                                                                                        echo $lang['hn']['Zipcode'];
                                                                                    } else {
                                                                                        echo 'Zipcode';
                                                                                    }
                                                                                    ?><span class="text-danger">*</span></label>
                                                        <input type="text" class="request_reg address" name="reg_pincode" id="reg_pincode" placeholder="Zipcode" onkeypress="return allowOnlyNumbers(event)" required />

                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label class="fieldlabels"><?php if (session()->has('bn')) {
                                                                                                echo $lang['bn']['State Name'];
                                                                                            } else if (session()->has('hn')) {
                                                                                                echo $lang['hn']['State Name'];
                                                                                            } else {
                                                                                                echo 'State Name';
                                                                                            }
                                                                                            ?>: <span class="text-danger">*</span></label>
                                                                <input type="text" class="request_reg address" name="reg_state" id="reg_state" placeholder="State Name" readonly />
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="fieldlabels"><?php if (session()->has('bn')) {
                                                                                                echo $lang['bn']['City/town/Area'];
                                                                                            } else if (session()->has('hn')) {
                                                                                                echo $lang['hn']['City/town/Area'];
                                                                                            } else {
                                                                                                echo 'City/Town/Area';
                                                                                            }
                                                                                            ?>: <span class="text-danger">*</span></label>
                                                                <input type="text" class="request_reg address" name="reg_city" id="reg_city" placeholder="City/Town/Area" readonly />
                                                            </div>
                                                        </div>

                                                        <label class="fieldlabels"><?php if (session()->has('bn')) {
                                                                                        echo $lang['bn']['Address'];
                                                                                    } else if (session()->has('hn')) {
                                                                                        echo $lang['hn']['Address'];
                                                                                    } else {
                                                                                        echo 'Address';
                                                                                    }
                                                                                    ?>: </label>
                                                        <textarea name="reg_address" class="request_reg address" id="reg_address" cols="20" rows="10" placeholder="Address"></textarea>

                                                    </div>
                                                    <input type="button" name="next" class="btn next action-button next2 disabled" value="Next" />
                                                    <input type="button" name="previous" class="btn previous action-button-previous" value="Previous" />
                                                </fieldset>
                                                <fieldset>
                                                    <div class="form-card">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title"><?php if (session()->has('bn')) {
                                                                                            echo $lang['bn']['Image Upload'];
                                                                                        } else if (session()->has('hn')) {
                                                                                            echo $lang['hn']['Image Upload'];
                                                                                        } else {
                                                                                            echo 'Image Upload';
                                                                                        }
                                                                                        ?> </h2>
                                                            </div>
                                                            <div class="col-5">
                                                                <h2 class="steps">Step 3 - 4</h2>
                                                            </div>
                                                        </div>
                                                        <div class="img-container">
                                                            <input type="file" name="reg_image" id="image-file" accept="image/*" style="display: none;" />

                                                            <div class="img-box mb-3 text-center m-auto">
                                                                <label for="image-file" class=""><i class="fa-solid fa-circle-plus fa-2x d-inline-block" style="color: #57b846"></i></label>
                                                                <img id="image-preview" class="image-preview" src="{{ URL::asset('img/istockphoto-1316420668-612x612.jpg')}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="button" name="next" class="btn next action-button next3 disabled" value="Next" onclick="send_otp()" />
                                                    <input type="button" name="previous" class="btn previous action-button-previous" value="Previous" />
                                                </fieldset>
                                                <fieldset>
                                                    <div class="form-card">

                                                        <div class="text-center">
                                                            <p class="text-success lead"><?php if (session()->has('bn')) {
                                                                                                echo $lang['bn']['OTP sent to your mobile number. Kindly check'];
                                                                                            } else if (session()->has('hn')) {
                                                                                                echo $lang['hn']['OTP sent to your mobile number. Kindly check'];
                                                                                            } else {
                                                                                                echo 'OTP sent to your mobile number. Kindly check';
                                                                                            }
                                                                                            ?> !!</p>
                                                            <div id="otp" class="mt-2">
                                                                <input class="m-2 form-control rounded d-inline" type="number" id="first" name="reg_first" maxlength="1" />
                                                                <input class="m-2 form-control rounded" type="number" id="second" name="reg_second" maxlength="1" />
                                                                <input class="m-2 form-control rounded" type="number" id="third" name="reg_third" maxlength="1" />
                                                                <input class="m-2 form-control rounded" type="number" id="fourth" name="reg_fourth" maxlength="1" />
                                                                <input class="m-2 form-control rounded" type="number" id="fifth" name="reg_fifth" maxlength="1" />
                                                                <input class="m-2 form-control rounded" type="number" id="sixth" name="reg_sixth" maxlength="1" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="submit" name="next" class="btn next action-button submit-btn " value="Submit" />

                                                    <input type="button" name="previous" class="btn previous action-button-previous" value="Previous" />
                                                </fieldset>

                                                <fieldset>

                                                    <div id="success_msg" style="display:none;">
                                                        <h2 class="purple-text text-center"><strong>SUCCESS
                                                                !</strong>
                                                        </h2> <br>
                                                        <div class="row justify-content-center">
                                                            <div class="col-3"> <img src="{{ URL::asset('assets/images/tick-mark-symbol-icon-26.png')}}" class="fit-image"> </div>
                                                        </div> <br><br>
                                                        <div class="row justify-content-center">
                                                            <div class="col-7 text-center">
                                                                <h5 class="purple-text text-center">You Have
                                                                    Successfully Signed Up</h5>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="failed_msg" style="display:none;">
                                                        <h2 class="purple-text text-center text-danger"><strong>FAILED
                                                                !</strong>
                                                        </h2> <br>
                                                        <div class="row justify-content-center">
                                                            <div class="col-3"> <img src="{{ URL::asset('assets/images/cross.png')}}" class="fit-image" style="width: 80px"> </div>
                                                        </div> <br><br>
                                                        <div class="row justify-content-center">
                                                            <div class="col-7 text-center">
                                                                <h5 class="purple-text text-center text-danger">Failed to Sign Up</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function allowOnlyNumbers(event) {
        var keyCode = event.keyCode || event.which;
        if ((keyCode < 48 || keyCode > 57) && keyCode !== 8) {
            return false;
        }
        return true;
    }

    function validPincodeMsg(pincode) {
        console.log(pincode);
        $.ajax({
            url: "{{ route('valid.pincode') }}",
            method: 'POST',
            data: {
                pincode: pincode,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#pincode_msg').html(response.messsage);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
</script>

<!-- Zipcode Maximum 6 characters -->
<script>
    var numberInput = document.getElementById("pincode");
    numberInput.addEventListener("input", function() {
        if (numberInput.value.length > 6) {
            numberInput.value = numberInput.value.slice(0, 6);
        }
    });
</script>

<script>
    var reg_pincode = document.getElementById("reg_pincode");
    reg_pincode.addEventListener("input", function() {
        if (reg_pincode.value.length > 6) {
            reg_pincode.value = reg_pincode.value.slice(0, 6);
        }
    });
</script>

<!-- MOBILE NUMBER 10 CHARACTER -->
<script>
    var mobile_login = document.getElementById("mobile_login");
    mobile_login.addEventListener("input", function() {
        if (mobile_login.value.length > 10) {
            mobile_login.value = mobile_login.value.slice(0, 10);
        }
    });
</script>

<script>
    var reg_phno = document.getElementById("reg_phno");
    reg_phno.addEventListener("input", function() {
        if (reg_phno.value.length > 10) {
            reg_phno.value = reg_phno.value.slice(0, 10);
        }
    });
</script>

<!-- GST NUMBER -->
<script>
    const gst_no = document.getElementById('gst_no');

    gst_no.addEventListener('input', function() {
        let inputValueUpperCase = gst_no.value.toUpperCase();
        gst_no.value = inputValueUpperCase;
    });
    gst_no.addEventListener("input", function() {
        if (gst_no.value.length > 15) {
            gst_no.value = gst_no.value.slice(0, 15);
        }
    });
</script>

<script>
    // Function to check if all OTP input fields are filled
    function checkOTPInputFilled() {
        var otpInputs = document.querySelectorAll('.otp-input');
        var allFilled = true;

        otpInputs.forEach(function(input) {
            if (input.value === '' || input.value === null) {
                allFilled = false;
            }
        });

        return allFilled;
    }

    // Function to show/hide validate OTP button based on OTP input status
    function updateValidateOTPButton() {
        var validateOTPButton = document.getElementById('votp');
        if (checkOTPInputFilled()) {
            validateOTPButton.style.display = 'block';
        } else {
            validateOTPButton.style.display = 'none';
        }
    }

    // Add event listeners to all OTP input fields
    var otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach(function(input) {
        input.addEventListener('input', updateValidateOTPButton);
        input.addEventListener('keyup', updateValidateOTPButton); // Call updateValidateOTPButton on keyup event
    });

    // Initially hide the validate OTP button
    updateValidateOTPButton();
</script>


