<!-- Jquery JS -->
<script src="assets/js/jquery.min.js"></script>

<!-- Popper JS -->
<script src="assets/js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- Owl Carousel JS -->
<script src="assets/js/owl.carousel.min.js"></script>
<!-- Mixitup JS -->
<script src="assets/js/mixitup.min.js"></script>
<!-- Parallax JS -->
<script src="assets/js/parallax.min.js"></script>
<!-- Appear JS -->
<script src="assets/js/jquery.appear.min.js"></script>
<!-- Odometer JS -->
<script src="assets/js/odometer.min.js"></script>
<!-- Particles JS -->
<script src="assets/js/particles.min.js"></script>
<!-- MeanMenu JS -->
<script src="assets/js/meanmenu.min.js"></script>
<!-- Nice Select JS -->
<script src="assets/js/jquery.nice-select.min.js"></script>
<!-- Viewer JS -->
<script src="assets/js/viewer.min.js"></script>
<!-- Slick JS -->
<script src="assets/js/slick.min.js"></script>
<!-- Magnific Popup JS -->
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<!-- AjaxChimp JS -->
<script src="assets/js/jquery.ajaxchimp.min.js"></script>
<!-- Form Validator JS -->
<script src="assets/js/form-validator.min.js"></script>
<!-- Contact Form JS -->
<script src="assets/js/contact-form-script.js"></script>
<!-- Raque Map JS -->
<script src="assets/js/raque-map.js"></script>
<script src="assets/js/functions.js"></script>
<!-- Main JS -->
<script src="assets/js/main.js"></script>



<script type="text/javascript" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/43033/owl.carousel.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js"></script>


<script type="text/javascript" src="assets/js/civilmanthan.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>



<!-- Website Color Theme Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Website Color Themes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="websitecolortheme">
          <li class="white"><span></span></li>
          <li class="black"><span></span></li>
          <li class="blue"><span></span></li>
          <li class="green"><span></span></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  var yourNavigation = $(".mainnav");
  stickyDiv = "sticky";
  yourHeader = $('.mainheader').height();

  $(window).scroll(function() {
    if ($(this).scrollTop() > yourHeader) {
      yourNavigation.addClass(stickyDiv);
    } else {
      yourNavigation.removeClass(stickyDiv);
    }
  });
</script>

<script type="text/javascript">
  $('.owl_carousel123').owlCarousel({
    stagePadding: 200,
    loop: true,
    margin: 10,
    nav: false,
    items: 1,
    lazyLoad: true,
    nav: true,
    responsive: {
      0: {
        items: 1,
        stagePadding: 60
      },
      600: {
        items: 1,
        stagePadding: 100
      },
      1000: {
        items: 1,
        stagePadding: 200
      },
      1200: {
        items: 1,
        stagePadding: 250
      },
      1400: {
        items: 1,
        stagePadding: 300
      },
      1600: {
        items: 1,
        stagePadding: 350
      },
      1800: {
        items: 1,
        stagePadding: 400
      }
    }
  })
</script>