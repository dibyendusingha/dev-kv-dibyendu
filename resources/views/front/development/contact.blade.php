    @extends('layout.main')
@section('page-container')
    <?php
use Illuminate\Support\Str;
use App\Models\language;
$lang = language::language();
?>
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact pb-5">
      <div class="container" data-aos="fade-up">

        <div class="section-title py-4">
          <h1 class="fw-bold" style="color: #8dbf45;">Contact <span  style="color: #000;"> Us</span></h1>
        </div>

        <div>
            <img src="{{asset('storage/photo/KV bnr.jpg')}}" alt="kv-contact" class="img-fluid w-100"/>
          <!--<iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe>-->
        </div>

        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="fa-solid fa-location-dot"></i>
                <h4>Location:</h4>
                <p>6B Janak Road, Kolkata- 700029</p>
              </div>

              <div class="email">
                <i class="fa-solid fa-envelope"></i>
                <h4>Email:</h4>
                <p>support@krishivikas.com</p>
              </div>

              <div class="phone">
                <i class="fa-solid fa-phone-volume"></i>
                <h4>Call:</h4>
                <p>8100975657</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">

            <form action="#" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->
    
    @endsection