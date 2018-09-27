<?php
//Import PHPMailer class in to the global namespace
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING));
  $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
  $message = trim(filter_input(INPUT_POST, "message", FILTER_SANITIZE_SPECIAL_CHARS));

  if ($name == "" || $email == "" || $message == "") {
    $validation_error = "Please complete all fields";
  }

  if ($_POST["address"] != "") {
    $validation_error = "Bad form data";
  }
  
  if (!PHPMailer::validateAddress($email)) {
    $validation_error = "Invalid email address";
  }

  if(!isset($validation_error)) {
    $email_body = "";
    $email_body .= "Name " . $name . "\n";
    $email_body .= "Email " . $email . "\n";
    $email_body .= "Message " . $message . "\n";
    
    //TO DO: send email
    $mail = new PHPMailer(true);                             
        
    //Recipients
    $mail->setFrom('clareallanson@hotmail.com', $name);
    $mail->addReplyTo($email, $name);
    $mail->addAddress('clareallanson@hotmail.com', 'Francis Buffier'); 
  
    //Content
    $mail->isHTML(true);                             
    $mail->Subject = 'Website enquiry from' . $name;
    $mail->Body    = $email_body;
  
    if ($mail->send()) {
      header("location:contact.php?status=thanks");
      exit
    }
      $mail_error = "Mailer error: " . $mail->ErrorInfo;
    }
    
  } // only send the email if no validation errors were met


} // end if post

?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <!-- Bootstrap CSS (local) -->
        <link rel="stylesheet" href="bootstrap-4.1.0-dist/css/bootstrap.css"/>
    
        <!-- Font Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
    
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Archivo+Narrow|Roboto:300,400,400i" rel="stylesheet">

        <!-- Main CSS -->
        <link rel="stylesheet" href="css/style.css">
    
        <title>Buffier Livestock Marketing</title>
    </head>
  <body>
   
    <!-- Header-->
    <header id="sticker" class="navbar sticky-top navbar-expand flex-column flex-md-row bd-navbar bg-white justify-content-between navbar-fixed-top">
        <a class="navbar-brand mr-0 mr-md-2 m-2" href="index.html" aria-label="Buffier Livestock Marketing">
          <img src="img/logo.svg" width="250" alt="Buffier Livestock Marketing Logo">
        </a>
      
        <div class="navbar-nav-scroll">
            <ul class="nav navbar-nav bd-navbar-nav flex-row">
              <li class="nav-item">
                <a class="nav-link text-dark" href="about.html">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="team.html">Team</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="sales.html">Sales</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn btn-outline-primary" href="contact.html">Contact</a>
              </li>
            </ul>
        </div>
  
    </header>
    <!-- /.Header -->
    
    <!-- Contact Form -->
    <div id="contact" class="container-fluid contact bg-light">                      
      <section class="contact-section section d-flex flex-column mx-auto py-5">
        
        <!--Section heading-->
        <h2 class="section-heading h1 text-center pt-4">Contact</h2>
        <hr class="mt-2 mb-3 mx-auto" style="width: 100px; border: 2px solid #999966;">
        <div class="py-4">
          <p class="text-center"><i class="fa fa-home mr-3"></i> PO Box 192 SCONE 2337</p>
          <p class="text-center"><i class="fa fa-envelope mr-3"></i><a href="mailto:bufflivestock@hotmail.com">bufflivestock@hotmail.com</a></p>
          <p class="text-center"><i class="fa fa-phone mr-3"></i><a href="tel:0428113663"> 0428 113 663</a></p>
          <p class="text-center"><a href="https://www.facebook.com/Buffier-Livestock-Marketing-467962290074774/" target="_blank"><img class="text-center" src="img/facebook-circle.png" alt="facebook logo" width="40px"/></a></p>
        </div>  
        <div id="map-container-8" class="map-container mb-4" style="height: 300px"></div>
        <!--Section description-->
        <?php if (isset($_GET["status"]) && $_GET["status"] == "thanks") {
                echo '<p class="section-description mt-5 text-center lead">Thank you for your email! We&rsquo;ll reply to you shortly.</p>';
        } else if (isset($validation_error)) {
            echo '<p class="section-description mt-5 text-center lead">' . $validation_error . '</p>';
        } else {
            echo '<p class="section-description mt-5 text-center lead">Or send us an email using the form below.</p>';
        }?>


        
        <div class="contact-form-wrapper row mx-auto">
            <!--Grid column-->
            <div class="d-flex flex-column col-md-12 my-3">
              <form id="contact-form" name="contact-form" action="contact.php" method="POST">
                  
                  <!--Grid row-->
                  <div class="row my-2">
                    <!--Grid column-->
                    <div class="col-md-12 my-1">
                        <div class="md-form">
                            <label for="name" class="">Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    <!--/.Grid column-->
                  </div>
                  <!--/.Grid row-->

                  <!--Grid row-->
                  <div class="row my-2">
                      <!--Grid column-->
                      <div class="col-md-12 my-1">
                          <div class="md-form">
                              <label for="email" class="">Email</label>
                              <input type="text" id="email" name="email" class="form-control">
                          </div>
                      </div>
                      <!--/.Grid column-->
                  </div>
                  <!--/.Grid row-->

                  <!--Grid row-->
                  <div class="row">
                      <!--Grid column-->
                      <div class="col-md-12">
                          <div class="md-form">
                              <label for="message">Message</label>
                              <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
                          </div>
                      </div>
                  </div>
                  <!--Grid row-->

              </form>
              <a class="btn btn-secondary text-white btn-block my-5 py-2" onclick="document.getElementById('contact-form').submit();">Send</a>
              <div class="status"></div>
            </div>
            <!--Grid column-->
        </div>

      </section>
    </div>  
    <!-- /.Contact Form -->

    <!-- Footer -->
    <footer class="page-footer font-small text-white ">

        <!-- Subscribe -->
        <div class="bg-dark">
          <div class="container">

            <!-- Grid row-->
            <div class="row py-4 d-flex align-items-center">

              <!-- Grid column -->
              <div class="col-md-12 col-lg-12 text-white text-center mb-4 mb-md-0">
                <!-- MailChimp Signup Form -->
                <div id="" class="">
                <form id="subscribe-form" name="subscribe-form" class="" target="_blank" novalidate>
                  <div id="" class="d-flex flex-column flex-sm-row align-items-center justify-content-center py-3">
                    
                    <label for="mce-EMAIL" class="my-0 mx-1 mb-1 mb-sm-0"><bold class="lead">Subscribe to our mailing list</bold></label>
      
                    <div class="d-flex flex-row">
                      <input type="email" value="" name="EMAIL" class="email form-control d-inline-block mx-2" id="mce-EMAIL" placeholder="email address" required>
      
                      <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
      
                      <div style="position: absolute; left: -5000px;" aria-hidden="true">
                        <input type="text" name="address" tabindex="-1" value="">
                      </div>
      
                      <div class=""> <!-- list-inline-item -->
                        <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary">
                      </div>
      
                    </div>
      
                  </div>
                </form>
                </div>  
                <!--End MailChimp SignUp Form-->
              </div>
              <!-- Grid column -->

            </div>
            <!-- Grid row-->

          </div>
        </div>
        <!-- /.Subscribe -->

        <!-- Footer Links -->
        <div class="container text-center text-md-left mt-5">

          <!-- Grid row -->
          <div class="row mt-3">

            <!-- Grid column -->
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

              <!-- Content -->
              <h6 class="text-uppercase font-weight-bold">Company</h6>
              <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
              <p>Read our website <a href="terms.html">Terms of Use</a> and <a href="privacy.html">Privacy Policy</a>.</p> 
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

              <!-- Links -->
              <h6 class="text-uppercase font-weight-bold">Site Links</h6>
              <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
              <p>
                <a href="about.html">About Us</a>
              </p>
              <p>
                <a href="sales.html">Upcoming Sales</a>
              </p>
              <p>
                <a href="contact.html">Contact Us</a>
              </p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-5">

              <!-- Links -->
              <h6 class="text-uppercase font-weight-bold">Useful links</h6>
              <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
              <p>
                <a href="https://auctionsplus.com.au/" target="_blank">Auctions Plus</a>
              </p>
              <p>
                <a href="http://www.bom.gov.au/" target="_blank">Bureau of Meteorology</a>
              </p>
              <p>
                <a href="https://www.mla.com.au/" target="_blank">MLA</a>
              </p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

              <!-- Links -->
              <h6 class="text-uppercase font-weight-bold">Contact</h6>
              <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; color: #ffffff">
              <p>
                <i class="fa fa-home mr-3"></i> PO Box 192 SCONE 2337</p>
              <p>
                <i class="fa fa-envelope mr-3"></i><a href="mailto:bufflivestock@hotmail.com">bufflivestock@hotmail.com</a></p>
              <p>
                <i class="fa fa-phone mr-3"></i><a href="tel:0428113663"> 0428 113 663</a></p>
              <p>
                  <i class="fab fa-facebook-f mr-3"></i><a href="https://www.facebook.com/Buffier-Livestock-Marketing-467962290074774/" target="_blank"> Connect on facebook</a></p>

            </div>
            <!-- Grid column -->

          </div>
          <!-- Grid row -->

        </div>
        <!-- Footer Links -->

        <!-- Copyright -->
        <div class="mx-auto mt-3" style="width: 120px;">
          <a href="#"><img class="" src="img/bull-white.png" alt="bull" width="120px"/></a>
        </div>   
        <div class="footer-copyright text-center py-3"><p>© 2018
          <a href="index.html"> Buffier Livestock Marketing</a></p>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->
                    

    <!-- Optional JavaScript -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Lightbox JS -->
    <script type="text/javascript" src="js/lightbox-plus-jquery.min.js"></script>
    <!-- Google Maps -->
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCXaF2pDbu8Vowow9st8bI15umIO-SUFgk"></script>
    <script>
      // Regular map
      function regular_map() {
        var var_location = new google.maps.LatLng(-32.0546144, 150.85948200000007);

        var var_mapoptions = {
            center: var_location,
            zoom: 10
        };

        var var_map = new google.maps.Map(document.getElementById("map-container-8"),
            var_mapoptions);

        var var_marker = new google.maps.Marker({
            position: var_location,
            map: var_map,
            title: "Scone"
        });
      }

      google.maps.event.addDomListener(window, 'load', regular_map);
    </script>

  </body>
</html>
