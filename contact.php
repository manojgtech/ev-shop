<!doctype html>
<html lang="zxx">
    
<?php include 'include/style.php';?>

    <body>

       <?php include 'include/preloader.php';?>

        <?php include 'include/navigation.php';?>
                

 <?php include 'include/websiteoverlaydontdel.php';?>

        <!-- Start Page Title Area -->
        <div class="page-title-area item-bg2 jarallax" data-jarallax='{"speed": 0.3}'>
            <div class="container">
                <div class="page-title-content">
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li>Contact</li>
                    </ul>
                    <h2>Contact Us</h2>
                </div>
            </div>
        </div>
        <!-- End Page Title Area -->

        <!-- Start Contact Info Area -->
        <section class="contact-info-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="contact-info-box mb-30">
                            <div class="icon">
                                <i class='bx bx-envelope'></i>
                            </div>

                            <h3>Email Here</h3>
                            <p><a href="mailto:kaushalsingh1st@gmail.com">kaushalsingh1st@gmail.com</a></p>
                            <p><a href="mailto:kaushalsingh1st@gmail.com">kaushalsingh1st@gmail.com</a></p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="contact-info-box mb-30">
                            <div class="icon">
                                <i class='bx bx-map'></i>
                            </div>

                            <h3>Location Here</h3>
                            <p><a href="https://goo.gl/maps/Mii9keyeqXeNH4347" target="_blank">Allahabad, Uttar Pradesh</a></p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-0 offset-md-3 offset-sm-3">
                        <div class="contact-info-box mb-30">
                            <div class="icon">
                                <i class='bx bx-phone-call'></i>
                            </div>

                            <h3>Call Here</h3>
                            <p><a href="tel:9455686876">+91-9455686876</a></p>
                            <p><a href="tel:9455686876">+91-9455686876</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="particles-js-circle-bubble-2"></div>
        </section>
        <!-- End Contact Info Area -->

        <!-- Start Contact Area -->
        <section class="contact-area pb-100">
            <div class="container">
                <div class="section-title">
                    <span class="sub-title">Contact Us</span>
                    <h2>Drop us Message for any Query</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="contact-form studentaddressdetails">
                    <form id="contactForm">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" required data-error="Please enter your name" placeholder="Your Name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" required data-error="Please enter your email" placeholder="Your Email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="phone_number" id="phone_number" required data-error="Please enter your number" class="form-control" placeholder="Your Phone">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="msg_subject" id="msg_subject" class="form-control" required data-error="Please enter your subject" placeholder="Your Subject">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="5" required data-error="Write your message" placeholder="Your Message"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <button type="submit" class="default-btn"><i class='bx bx-paper-plane icon-arrow before'></i><span class="label">Send Message</span><i class="bx bx-paper-plane icon-arrow after"></i></button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="particles-js-circle-bubble-3"></div>
            <div class="contact-bg-image"><img src="assets/img/map.png" alt="image"></div>
        </section>
        <!-- End Contact Area -->

        <!-- Maps -->
<!--        <div id="map"></div>-->
        
        <div class="col-md-12">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d115323.9755053042!2d81.77444924103101!3d25.40902008074977!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x398534c9b20bd49f%3A0xa2237856ad4041a!2sPrayagraj%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1587634939373!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        
        <!-- End Maps -->

         <?php include 'include/footer.php';?>
        
        

        <?php include 'include/script.php';?>
    </body>


</html>