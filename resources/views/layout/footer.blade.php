<!-- FOOTER SECTION START -->

<footer>
    <div class="footer-associates" style="background: #ebebeb;">
        <div class="row align-items-center text-center p-lg-2 p-0">
            <div class="col-4">
                <img src="{{ URL::asset('assets/images/associates/associates-1.png')}}" alt="association" class="img-fluid" loading="lazy">
            </div>
            <div class="col-4">
                <img src="{{ URL::asset('assets/images/associates/associates-2.png')}}" alt="association" class="img-fluid" loading="lazy">
            </div>
            <div class="col-4">
                <img src="{{ URL::asset('assets/images/associates/associates-3.png')}}" alt="association" class="img-fluid" loading="lazy">
            </div>
        </div>
    </div>
    <div class="container-fluid p-5">

        <div class="foot-logo text-center">
            <!-- <img src="{{ URL::asset('assets/images/white kv logo.png')}}" alt="" class="img-fluid" width="200"> -->
        </div>
        <div class="row justify-content-lg-around">

        <div class="col-lg-2 col-md-6 mb-4">

        <img src="{{ URL::asset('assets/images/kv with R.png')}}" alt="footer-kv-logo" class="p-3 rounded-circle w-50 bg-white mb-3" loading="lazy">
                
                <ul class="px-2">
                    <li><a href="tel:8100975657"><small><i class="fa-sharp fa-solid fa-phone"></i> &nbsp; 8100975657
                            </small></a></li>

                    <li>
                        <a href="mailto:support@krishivikas.com"><small><i class="fa-sharp fa-solid fa-envelope"></i>
                                &nbsp;support@krishivikas.com</small></a>
                    </li>

                    <li>
                        <p class=" fw-normal">FOLLOW US</p>
                        <div class="social-logo d-flex flex-wrap gap-3">
                            <div class="">
                                <a href="https://www.facebook.com/joinkrishivikas" target="_blank"><i
                                        class="fa-brands fa-facebook-f"></i></a>
                            </div>
                            <div class="">
                                <a href="https://www.instagram.com/joinkrishivikas/" target="_blank"><i
                                        class="fa-brands fa-instagram text-white"></i></a>
                            </div>
                            <div class="">
                                <a href="https://twitter.com/JoinKrishiVikas" target="_blank"><i class="ri-twitter-x-fill"></i></a>
                            </div>
                            <div class="">
                                <a href="https://www.linkedin.com/company/joinkrishivikas/" target="_blank"><i
                                        class="fa-brands fa-linkedin-in"></i></a>
                            </div>
                            <!-- <div class="">
                                    <a href=""><i class="fa-brands fa-google-plus-g"></i></a>
                                </div> -->
                            <div class="">
                                <a href="https://www.youtube.com/@JoinKrishiVikas" target="_blank"><i
                                        class="fa-brands fa-youtube"></i></a>
                                
                            </div>
                        </div>
                    </li>
                </ul>

                <p class=""><?php if (session()->has('bn')) {echo $lang['bn']['DOWNLOAD KRISHI VIKAS APP'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['DOWNLOAD KRISHI VIKAS APP'];} 
                    else { echo 'DOWNLOAD KRISHI VIKAS APP'; } 
                    ?></p>
                <div class="d-flex align-items-center flex-lg-row flex-column gap-2">
              
                   
                    <a href="https://play.google.com/store/search?q=krishi+vikas&c=apps"><img
                            src="{{ URL::asset('assets/images/Google-Play-Store-removebg-preview.png')}}" alt=""
                            width="150"></a>
                
               
                    <a href="https://apps.apple.com/in/app/krishi-vikas/id6449253442?platform=ipad"><img
                            src="{{ URL::asset('assets/images/apple-store.png')}}" alt=""
                            width="150" class="rounded"></a>
                
                </div>
                

            </div>

            <div class="col-lg-2 col-md-6">
                <p class="fs-4"><?php if (session()->has('bn')) {echo $lang['bn']['SELL PRODUCTS'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['SELL PRODUCTS'];} 
                    else { echo 'SELL PRODUCTS'; } 
                    ?></p>
                <ul class="sell-foot px-2">
                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('tractor.post')}}" class="sell_trac">
                        <?php if (session()->has('bn')) {echo $lang['bn']['NEW TRACTOR'];} 
                            else if (session()->has('hn')) {echo $lang['hn']['NEW TRACTOR'];} 
                            else { echo 'New Tractor'; } 
                            ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['NEW TRACTOR'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW TRACTOR'];} 
                        else { echo 'NEW TRACTOR'; } 
                        ?></a></li>
                    @endif
                    
                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('tractor.post')}}" class="sell_trac">
                    <?php if (session()->has('bn')) {echo $lang['bn']['USED TRACTOR'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED TRACTOR'];} 
                        else { echo 'USED TRACTOR'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['USED TRACTOR'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED TRACTOR'];} 
                        else { echo 'USED TRACTOR'; } 
                        ?></a></li>
                    @endif

                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('gv.post')}}" class="sell_trac">
                    <?php if (session()->has('bn')) {echo $lang['bn']['NEW GOODS VEHICLE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW GOODS VEHICLE'];} 
                        else { echo 'NEW GOODS VEHICLE'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['NEW GOODS VEHICLE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW GOODS VEHICLE'];} 
                        else { echo 'NEW GOODS VEHICLE'; } 
                        ?></a></li>
                    @endif
                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('gv.post')}}" class="sell_trac">
                    <?php if (session()->has('bn')) {echo $lang['bn']['USED GOODS VEHICLE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED GOODS VEHICLE'];} 
                        else { echo 'USED GOODS VEHICLE'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['USED GOODS VEHICLE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED GOODS VEHICLE'];} 
                        else { echo 'USED GOODS VEHICLE'; } 
                        ?></a></li>
                    @endif

                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('harvester.post')}}" class="sell_trac">
                    <?php if (session()->has('bn')) {echo $lang['bn']['NEW HARVESTER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW HARVESTER'];} 
                        else { echo 'NEW HARVESTER'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['NEW HARVESTER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW HARVESTER'];} 
                        else { echo 'NEW HARVESTER'; } 
                        ?></a></li>
                    @endif
                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('harvester.post')}}" class="sell_trac">
                    <?php if (session()->has('bn')) {echo $lang['bn']['USED HARVESTER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED HARVESTER'];} 
                        else { echo 'USED HARVESTER'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['USED HARVESTER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED HARVESTER'];} 
                        else { echo 'USED HARVESTER'; } 
                        ?></a></li>
                    @endif

                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('implement.post')}}" class="sell_trac">
                    <?php if (session()->has('bn')) {echo $lang['bn']['NEW IMPLEMENTS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW IMPLEMENTS'];} 
                        else { echo 'NEW IMPLEMENTS'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['NEW IMPLEMENTS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW IMPLEMENTS'];} 
                        else { echo 'NEW IMPLEMENTS'; } 
                        ?></a></li>
                    @endif
                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('implement.post')}}" class="sell_trac">
                    <?php if (session()->has('bn')) {echo $lang['bn']['USED IMPLEMENTS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED IMPLEMENTS'];} 
                        else { echo 'USED IMPLEMENTS'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['USED IMPLEMENTS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED IMPLEMENTS'];} 
                        else { echo 'USED IMPLEMENTS'; } 
                        ?></a></li>
                    @endif

                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('tyre.post')}}">
                    <?php if (session()->has('bn')) {echo $lang['bn']['NEW TYRES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW TYRES'];} 
                        else { echo 'NEW TYRES'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['NEW TYRES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW TYRES'];} 
                        else { echo 'NEW TYRES'; } 
                        ?></a></li>
                    @endif
                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('tyre.post')}}">
                    <?php if (session()->has('bn')) {echo $lang['bn']['USED TYRES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED TYRES'];} 
                        else { echo 'USED TYRES'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['USED TYRES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED TYRES'];} 
                        else { echo 'USED TYRES'; } 
                        ?></a></li>
                    @endif

                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('seeds.post')}}">
                    <?php if (session()->has('bn')) {echo $lang['bn']['SELL SEEDS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['SELL SEEDS'];} 
                        else { echo 'SELL SEEDS'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['SELL SEEDS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['SELL SEEDS'];} 
                        else { echo 'SELL SEEDS'; } 
                        ?></a></li>
                    @endif

                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('pesticide.post')}}">
                    <?php if (session()->has('bn')) {echo $lang['bn']['SELL PESTICIDES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['SELL PESTICIDES'];} 
                        else { echo 'SELL PESTICIDES'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['SELL PESTICIDES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['SELL PESTICIDES'];} 
                        else { echo 'SELL PESTICIDES'; } 
                        ?></a></li>
                    @endif

                    @if (session()->has('KVMobile')==1)
                    <li><a href="{{route('fertilizer.post')}}">
                    <?php if (session()->has('bn')) {echo $lang['bn']['SELL FERTILIZERS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['SELL FERTILIZERS'];} 
                        else { echo 'SELL FERTILIZERS'; } 
                        ?></a></li>
                    @else
                    <li><a href="#" class="myBtn">
                        <?php if (session()->has('bn')) {echo $lang['bn']['SELL FERTILIZERS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['SELL FERTILIZERS'];} 
                        else { echo 'SELL FERTILIZERS'; } 
                        ?></a></li>
                    @endif

                    

                </ul>
            </div>
            <div class="col-lg-2 col-md-6">
                <p class="fs-4"><?php if (session()->has('bn')) {echo $lang['bn']['BUY PRODUCTS'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['BUY PRODUCTS'];} 
                    else { echo 'BUY PRODUCTS'; } 
                    ?></p>
                <ul class="buy-foot px-2">
                    <li><a href="{{url('tractor-list/new')}}"><?php if (session()->has('bn')) {echo $lang['bn']['NEW TRACTOR'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW TRACTOR'];} 
                        else { echo 'NEW TRACTOR'; } 
                        ?></a></li>
                    <li><a href="{{url('tractor-list/old')}}"><?php if (session()->has('bn')) {echo $lang['bn']['USED TRACTOR'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED TRACTOR'];} 
                        else { echo 'USED TRACTOR'; } 
                        ?></a></li>
                    <li><a href="{{url('good-vehicle-list/new')}}"><?php if (session()->has('bn')) {echo $lang['bn']['NEW GOODS VEHICLE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW GOODS VEHICLE'];} 
                        else { echo 'NEW GOODS VEHICLE'; } 
                        ?></a></li>
                    <li><a href="{{url('good-vehicle-list/old')}}"><?php if (session()->has('bn')) {echo $lang['bn']['USED GOODS VEHICLE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED GOODS VEHICLE'];} 
                        else { echo 'USED GOODS VEHICLE'; } 
                        ?></a></li>
                    <li><a href="{{url('harvester-list/new')}}"><?php if (session()->has('bn')) {echo $lang['bn']['NEW HARVESTER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW HARVESTER'];} 
                        else { echo 'NEW HARVESTER'; } 
                        ?></a></li>
                    <li><a href="{{url('harvester-list/old')}}"><?php if (session()->has('bn')) {echo $lang['bn']['USED HARVESTER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED HARVESTER'];} 
                        else { echo 'USED HARVESTER'; } 
                        ?></a></li>
                    <li><a href="{{url('implements-list/new')}}"><?php if (session()->has('bn')) {echo $lang['bn']['NEW IMPLEMENTS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW IMPLEMENTS'];} 
                        else { echo 'NEW IMPLEMENTS'; } 
                        ?></a></li>
                    <li><a href="{{url('implements-list/old')}}"><?php if (session()->has('bn')) {echo $lang['bn']['USED IMPLEMENTS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED IMPLEMENTS'];} 
                        else { echo 'USED IMPLEMENTS'; } 
                        ?></a></li>
                    <li><a href="{{url('seed-list')}}"><?php if (session()->has('bn')) {echo $lang['bn']['BUY SEEDS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['BUY SEEDS'];} 
                        else { echo 'BUY SEEDS'; } 
                        ?></a></li>
                    <li><a href="{{url('pesticides-list')}}"><?php if (session()->has('bn')) {echo $lang['bn']['BUY PESTICIDES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['BUY PESTICIDES'];} 
                        else { echo 'BUY PESTICIDES'; } 
                        ?></a></li>
                    <li><a href="{{url('fertilizer-list')}}"><?php if (session()->has('bn')) {echo $lang['bn']['BUY FERTILIZER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['BUY FERTILIZER'];} 
                        else { echo 'BUY FERTILIZER'; } 
                        ?></a></li>
                    <li><a href="{{url('tyre-list/new')}}"><?php if (session()->has('bn')) {echo $lang['bn']['NEW TYRES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['NEW TYRES'];} 
                        else { echo 'NEW TYRES'; } 
                        ?></a></li>
                    <li><a href="{{url('tyre-list/old')}}"><?php if (session()->has('bn')) {echo $lang['bn']['USED TYRES'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USED TYRES'];} 
                        else { echo 'USED TYRES'; } 
                        ?></a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6">
                <!-- <div class="foot-logo">
                        <img src="./assets/images/white kv logo.png" alt="" class="img-fluid">
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium esse cumque provident
                        consequuntur, quia commodi nesciunt accusantium saepe magnam cupiditate corrupti dolorum
                        voluptatum minus sint!</p> -->
                <p class="fs-4">
                    <?php if (session()->has('bn')) {echo $lang['bn']['RENT PRODUCTS'];} 
                    else if (session()->has('hn')) {echo $lang['hn']['RENT PRODUCTS'];} 
                    else { echo 'RENT PRODUCTS'; } 
                    ?></p>
                <ul class="rent-foot px-2">

                   
                    <li>
                        <a href="{{url('tractor-list/rent')}}"><?php if (session()->has('bn')) {echo $lang['bn']['RENT TRACTOR'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['RENT TRACTOR'];} 
                        else { echo 'RENT TRACTOR'; } 
                        ?></a>
                        </li>
                    <li>
                        <a href="{{url('good-vehicle-list/rent')}}"><?php if (session()->has('bn')) {echo $lang['bn']['RENT GOODS VEHICLE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['RENT GOODS VEHICLE'];} 
                        else { echo 'RENT GOODS VEHICLE'; } 
                        ?></a>
                        </li>    
                    
                    <li><a href="{{url('harvester-list/rent')}}" class="rent_trac">
                        <?php if (session()->has('bn')) {echo $lang['bn']['RENT HARVESTER'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['RENT HARVESTER'];} 
                        else { echo 'RENT HARVESTER'; } 
                        ?></a></li>
                    
                    <li><a href="{{url('implements-list/rent')}}" class="rent_trac">
                        <?php if (session()->has('bn')) {echo $lang['bn']['RENT IMPLEMENTS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['RENT IMPLEMENTS'];} 
                        else { echo 'RENT IMPLEMENTS'; } 
                        ?></a></li>

                    
                </ul>


                <p class="fs-4 ">
                    <?php if (session()->has('bn')) {echo $lang['bn']['USEFUL LINKS'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['USEFUL LINKS'];} 
                        else { echo 'USEFUL LINKS'; } 
                        ?></p>
                <ul class="useful px-2">
                    <li><a  href="{{url('contact')}}">
                        <?php if (session()->has('bn')) {echo $lang['bn']['CONTACT US'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['CONTACT US'];} 
                        else { echo 'CONTACT US'; } 
                        ?></a></li>
                    <li><a target="_blank" href="{{url('about-us')}}">
                        <?php if (session()->has('bn')) {echo $lang['bn']['ABOUT US'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['ABOUT US'];} 
                        else { echo 'ABOUT US'; } 
                        ?></a></li>
                    <li><a target="_blank" href="{{url('privacy-policy')}}" target="_blank">
                        <?php if (session()->has('bn')) {echo $lang['bn']['PRIVACY POLICY'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['PRIVACY POLICY'];} 
                        else { echo 'PRIVACY POLICY'; } 
                        ?></a></li>
                    <li><a target="_blank" href="{{url('terms-condition')}}" target="_blank">
                        <?php if (session()->has('bn')) {echo $lang['bn']['TERMS OF USE'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['TERMS OF USE'];} 
                        else { echo 'TERMS OF USE'; } 
                        ?></a></li>
                    <li><a target="_blank" href="{{url('data-privacy')}}">
                        <?php if (session()->has('bn')) {echo $lang['bn']['DATA PRIVACY'];} 
                        else if (session()->has('hn')) {echo $lang['hn']['DATA PRIVACY'];} 
                        else { echo 'DATA PRIVACY'; } 
                        ?></a></li>


                </ul>


                <div class="dmca-badge">
                    <h6>CONTENT PROTECTED BY</h6>
                    <a href="//www.dmca.com/Protection/Status.aspx?ID=d3e7ce42-4fd7-442e-a624-62f0745303e1" title="DMCA.com Protection Status" class="dmca-badge"> <img src ="https://images.dmca.com/Badges/dmca-badge-w150-5x1-06.png?ID=d3e7ce42-4fd7-442e-a624-62f0745303e1"  alt="DMCA.com Protection Status" /></a> 
                </div>

                

            </div>
            
            

            <hr class="mt-4">

            <div class="d-flex justify-content-around align-items-center">
                <div class="make-in-ind">
                    <img src="{{ URL::asset('assets/images/make-in-india-logo-make-in-india-icon-free-free-vector-removebg-preview.png')}}"
                        width="80" alt="">
                </div>
                <div class="text-center">
                    <p class="text-white py-2 m-0">Copyright © 2023-24 | ABYBABY E-COM PRIVATE LIMITED |
                        ALL RIGHTS RESERVED</p>
                </div>
            </div>
        </div>
    </div>
</footer>



<!-- FOOTER SECTION END-->




<!-- JS SECTION -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>



<script src="{{ URL::asset('assets/js/form.js')}}"></script>
<script>
    const buttons = document.querySelectorAll('.tractor-list-view .sorting a');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            buttons.forEach(b => b.classList.remove('active-filter'));
            this.classList.add('active-filter');
        });
    });

</script>
<script>
    // const btn1 = document.querySelector('#language-btn');
    const dropdown = document.querySelector('#language-dropdown');

    $('#language-btn').click(function () {
        dropdown.style.display = (dropdown.style.display === 'none') ? 'block' : 'none';
    } );

    function setLanguage(language) {
        // Your code to set the language
        dropdown.style.display = 'none';
    }
</script>

<script>
    const dealBtn = document.querySelector(".dealer");
    const indiBtn = document.querySelector(".individual");
    const opChnge = document.querySelector(".option-change");

    dealBtn.addEventListener("click", () => {

        opChnge.style.display = "block";

    });


    indiBtn.addEventListener("click", () => {

        opChnge.style.display = "none";

    });
</script>

<script src="{{ URL::asset('assets/js/mahindraApiData.js')}}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="{{ URL::asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/owl.carousel.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ URL::asset('assets/js/app.js')}}"></script>
<script src="{{ URL::asset('assets/js/filter.js')}}"></script>
{{--
<script type="text/javascript" src="{{ URL::asset('assets/js/zoom.js')}}"></script> --}}
<script src="{{ URL::asset('assets/js/tractor-post.js')}}"></script>
<script src="{{ URL::asset('assets/js/GV-post.js')}}"></script>
<script src="{{ URL::asset('assets/js/fertilizer-post.js')}}"></script>
<script src="{{ URL::asset('assets/js/im-post.js')}}"></script>
<script src="{{ URL::asset('assets/js/seed-post.js')}}"></script>
<script src="{{ URL::asset('assets/js/hv.js')}}"></script>
<script src="{{ URL::asset('assets/js/tyre-post.js')}}"></script>
<script src="{{ URL::asset('assets/js/form.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    $('#pincode_apply').click(function (e) {
        e.preventDefault();
        var token = $('meta[name="csrf-token"]').attr('content');
        var pincode = $('#pincode').val();
        //var formData = new FormData($("#save_cast")[0]);
        //$("#dvloader").show();
        $.ajax({
            type: 'POST',
            url: '{{ route("pincode.put") }}',
            data: { pincode: pincode },
            success: function (resp) {
                if (resp.status == 'success') {
                    //alert('Pincode Data Get');
                    location.reload();
                } else {
                    //alert('Error!');
                    location.reload();
                }

            },

        });

    });

    $('#pincode_apply1').click(function (e) {
        e.preventDefault();
        var token = $('meta[name="csrf-token"]').attr('content');
        var pincode = $('#pincode1').val();
        //var formData = new FormData($("#save_cast")[0]);
        //$("#dvloader").show();
        $.ajax({
            type: 'POST',
            url: '{{ route("pincode.put") }}',
            data: { pincode: pincode },
            success: function (resp) {
                if (resp.status == 'success') {
                    //alert('Pincode Data Get');
                    location.reload();
                } else {
                    //alert('Error!');
                    location.reload();
                }

            },

        });

    });

    $('.otp_button').click(function (e) {
        e.preventDefault();
        var token = $('meta[name="csrf-token"]').attr('content');
        var mobile_login = $('#mobile_login').val();
        //var validateMobNum = /^\d*(?:\.\d{1,2})?$/;
        var phoneno = /^\d{10}$/;
        if (mobile_login.match(phoneno)) {
            //var formData = new FormData($("#save_cast")[0]);
            //$("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("login") }}',
                data: { mobile_login:mobile_login },
                success: function (resp) {
                    //alert(resp.status);
                    if (resp.status == 'success') {
                        $('#step1').css('display', 'none');
                        $('#step2').css('display', 'block');
                    } else {
                        //alert('Error!');
                        $('.message').val('Invalid Mobile Number');
                        return false;
                    }

                },

            });

        } else {
            //alert('Invalid Mobile Number');
            $('.message').val('Invalid Mobile Number');
            return false;
        }

    });

    $('.verify_otp').click(function (e) {
        e.preventDefault();
        var token = $('meta[name="csrf-token"]').attr('content');
        var first_num = $('#first').val();
        var second_num = $('#second').val();
        var third_num = $('#third').val();
        var fourth_num = $('#fourth').val();
        var fifth_num = $('#fifth').val();
        var sixth_num = $('#sixth').val();
        var otp = first_num + second_num + third_num + fourth_num + fifth_num + sixth_num;
        //alert(otp);
        //var formData = new FormData($("#save_cast")[0]);
        //$("#dvloader").show();
        $.ajax({
            type: 'POST',
            url: '{{ route("otp.check") }}',
            data: { otp: otp },
            success: function (resp) {
                //alert(resp.status);
                if (resp.status == 'success') {
                    var kvuser_type = resp.kvuser_type;
                    //alert(kvuser_type);
                    if (kvuser_type==0) {
                        $('#step2').css('display', 'none');
                        //$('#step3').css('display', 'block');
                        $('#success_msg_login').css('display', 'block');
                        $('#signup-toggle').click();
                    } else {
                        $('#step2').css('display', 'none');
                        //$('#step3').css('display', 'block');
                        $('#success_msg_login').css('display', 'block');
                        setTimeout(function () {
                            location.reload();
                        }, 3000); 
                    }
                    
                } else {
                    //alert('Failed');
                    $('#step2').css('display', 'none');
                    $('#failed_msg_login').css('display', 'block');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }

            },

        });
    });

    $('#reg_pincode').keyup(function (e) {
        e.preventDefault();
        var pincode = $(this).val();
        //alert(pincode);
        //$("#dvloader").show();
        $.ajax({
            type: 'POST',
            url: '{{ route("pincode.state.city.district") }}',
            data: { pincode: pincode },
            success: function (resp) {
                //alert(resp.state_name);
                if (resp.status == 'success') {
                    $('#reg_state').val(resp.state_name);
                    $('#reg_city').val(resp.city_name);
                } else {
                    //alert('failed');
                }

            },

        });
    });

    $('.registration_form').submit(function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        //$("#dvloader").show();
        $.ajax({
            type: 'POST',
            url: '{{ route("register") }}',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (resp) {
                console.log(resp);
                //alert(resp);
                //alert(resp.status);
                if (resp.status == 'success') {
                    //alert(resp.messsage);
                    $('#success_msg').css('display', 'block');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else if (resp.status == 'failed') {
                    //alert(resp.messsage);
                    $('#failed_msg').css('display', 'block');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    //alert('Failed');
                    $('#failed_msg').css('display', 'block');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }

            },

        });
    });

    function send_otp() {
        var reg_phno = $('#reg_phno').val();
        $.ajax({
            type: 'POST',
            url: '{{ route("register.sendotp") }}',
            data: { reg_phno: reg_phno },
            success: function () {

            },

        });
    }

    function brand_to_model(x) {
        //var op = '';
        $.ajax({
            type: 'POST',
            url: '{{ route("brand.to.model") }}',
            data: { brand_id: x },
            success: function (data) {
                //console.log(data)
                op = '<option value="">Select</option>';
                for (var i = 0; i < data.length; i++) {
                    op += '<option value=' + data[i].id + '>' + data[i].model_name + '</option>';
                }
                $('#model_id').html(op);
            },
            error: function () {
                console.log("Error Occurred");
            }


        });
    }


    
    // Multiple State Wish District
    // Dibyendu Change 30.09.2023
    $('.state_prod_list').click(function () {
       const form = document.getElementById("filter_trator");
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        console.log(checkboxes);
        const selectedData = [];
        checkboxes.forEach(checkbox => {
            selectedData.push(checkbox.value);
        });

        var prod = selectedData;
        console.log(selectedData);

        $.ajax({
            type: 'POST',
            url: '{{ route("brand.to.model.data") }}',
            data: { state_id: prod },
            success: function (data) {
                console.log(data);
                op = '';
                for (var i = 0; i< data.district.length; i++) {
                    if (data.district_count[i]>0) {
                        op += '<div class="form-check">';
                        op += '<input class="form-check-input" type="checkbox" name="district[]" value="' + data.district[i].id + '" id="trac-sell">';
                        op += '<label class="form-check-label" for="trac-sell">';
                        op += data.district[i].district_name+' ' +'('+data.district_count[i]+')'; 
                        op += '</label>';
                        op += '</div>';
                    }
                }
                $('#district_id').html(op);
            },
            error: function () {
                console.log("Error Occurred");
            }
        });
    });

    function addtofav(x, y) {
        $.ajax({
            type: 'POST',
            url: '{{ route("item.wishlist") }}',
            data: { db_id: x, item_id: y },
            success: function (resp) {
                //console.log(resp);
                if (resp.status == 'success') {
                    //alert(resp.messsage);

                } else if (resp.status == 'failed') {
                    //alert(resp.messsage);

                }
            },
        });
    }

    $('.personal').keyup(function(){

var reg_email = $('#email_id').val();
var reg_name = $('#reg_name').val();
var reg_phno = $('#reg_phno').val();



if (reg_name=='' || reg_phno=='' || reg_email=='') {
    $('.next1').addClass('disabled');
} 
});

$('#reg_dob').change(()=>{
$('.next1').removeClass('disabled');
})

$('.address').keyup(function(){
var reg_pin = $('#reg_pincode').val();


var reg_address = $('#reg_address').val();

if (reg_pin=='' || reg_address=='') {
    $('.next2').addClass('disabled');
} 

else{
    $('.next2').removeClass('disabled');
}
});

$('#image-file').change(()=>{
$('.next3').removeClass('disabled');
})


</script>

<script>
    $(document).ready(function () {
        // When the "Sell" button is clicked, store the choice and redirect the user
        $(".high-to-low").click(function () {
            localStorage.setItem("user-sort", "hl");
        });

        // // When the "Rent" button is clicked, store the choice and redirect the user
        $(".low-to-high").click(function () {
            localStorage.setItem("user-sort", "lh");
        });

        $(".new-first").click(function () {
            localStorage.setItem("user-sort", "nf");
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Check if the user's choice is already stored


        var userSort = localStorage.getItem("user-sort");
        if (userSort === "hl") {
            // If the user chose "Sell" on the first page, select the "Sell" radio button

            $(".high-to-low").addClass("active-filter");
            $(".low-to-high").removeClass("active-filter");
            $(".new-first").removeClass("active-filter");

        }
        else if (userSort === "lh") {
            // If the user chose "Rent" on the first page, select the "Rent" radio button

            $(".high-to-low").removeClass("active-filter");
            $(".low-to-high").addClass("active-filter");
            $(".new-first").removeClass("active-filter");
        }
        else if (userSort === "nf") {
            // If the user chose "Rent" on the first page, select the "Rent" radio button

            $(".high-to-low").removeClass("active-filter");
            $(".low-to-high").removeClass("active-filter");
            $(".new-first").addClass("active-filter");
        }


        // Simulate a click on the "Next" button
        document.querySelector('.sr-cat .btn').click();
    });
</script>

<script>
    $(document).ready(function () {
        // When the "Sell" button is clicked, store the choice and redirect the user
        $(".sell_trac").click(function () {
            localStorage.setItem("user-choice", "sell");
            window.location.href = "tractor-post.php";
        });

        // // When the "Rent" button is clicked, store the choice and redirect the user
        $(".rent_trac").click(function () {
            localStorage.setItem("user-choice", "rent");
            window.location.href = "tractor-post.php";
        });
    });
</script>

<script>
    var toggle = document.querySelectorAll(".toggle");
    toggle.forEach((item) => {
        item.onchange = function () {
            if (item.checked) {
                item.value = 'true';
            }
            else {
                item.value = 'false';
            }
        }
    });

</script>



<script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script> 



</body>

</html>