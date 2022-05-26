<!doctype html>
<html lang="zxx">

<?php include 'include/style.php'; ?>

<body>

  <?php include 'include/navigation.php'; ?>
  <?php include 'include/websiteoverlaydontdel.php'; ?>
  <script>
    var filtertype= '';
    var sortBy = 'l';
    var filter = '';
    
  </script>


  <!-- Start Page Title Area -->
  <div class="page-title-area innerpagebannerheading5">
    <div class="container">
      <div class="page-title-content">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li>Shop</li>
        </ul>
        <h2>All Our EV's</h2>
      </div>
    </div>
  </div>
  <!-- End Page Title Area -->

  <!-- Start Courses Area -->

  <section class="courses-area ptb-100 innerpageproductsection">
    <div class="container">
      <div class="courses-topbar">
        <div class="row align-items-center">
          <div class="col-lg-4 col-md-4">
            <div class="topbar-result-count">
              <p>Showing 1 – 6 of 54</p>
            </div>
          </div>

          <div class="col-lg-8 col-md-8">
            <div class="topbar-ordering-and-search">
              <div class="row align-items-center">
                <div class="col-lg-3 col-md-5 offset-lg-4 offset-md-1">
                  <div class="topbar-ordering">
                    <select  id="sortprods" name="sort" onChange"filterProd('','',this.value);">
                    
                      <option value="l">Sort by latest</option>
                      <option value="o">Sort by oldest</option>
                      <option value="lp">Price- low to high</option>
                      <option value="hp">Price - high to low</option>
                      <!-- <option>Default sorting</option> -->
                      <!-- <option>Sort by rating</option>
                      <option>Sort by new</option> -->
                    </select>
                  </div>
                </div>

                <div class="col-lg-5 col-md-6">
                  <div class="topbar-search">
                    <form>
                      <label><i class="fa fa-search"></i></label>
                      <input type="text" class="input-search" id="searchshop" placeholder="Search here..." onkeyup>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8 col-md-12">
          <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
          <div class="row" id="shopprods">



            <div class="col-lg-12 col-md-12">
              <div class="single-courses-list-box mb-30 innerproductlistcolumn">
                <div class="box-item">
                  <div class="courses-image">
                    <div class="image bg-2">
                      <img src="assets/img/cars/ki1.jpg" alt="image">

                      <a href="product-details.php" class="link-btn"></a>

                    </div>
                  </div>

                  <div class="courses-desc">
                    <div class="courses-content productlistingdetails">

                      <h3><a href="product-details.php" class="d-inline-block">Kinetic Zing</a></h3>

                      <div class="courses-rating">
                        <div class="review-stars-rated">
                          <i class='fa fa-star'></i>
                          <i class='fa fa-star'></i>
                          <i class='fa fa-star'></i>
                          <i class='fa fa-star'></i>
                          <i class='fa fa-star'></i>
                        </div>

                        <div class="rating-total">
                          5.0 (1 rating)
                        </div>
                      </div>

                      <p>Pushback all your fuel worries with Kinetic Zing Electric Scooter. Simply charge and get going!</p>
                      <ul class="upcomingfirstullist">
                        <li><i class="fa fa-flash"></i><span>80 Km*</span><label>Per Charge</label></li>
                        <li><i class="fa fa-flash"></i><span>03 Years*</span><label>of Warranty</label></li>
                        <li><i class="fa fa-flash"></i><span>3 Hours*</span><label>Full Charge</label></li>
                        <li><i class="fa fa-flash"></i><span>60V 22Ah*</span><label>Battery</label></li>
                      </ul>
                    </div>

                    <div class="courses-box-footer listingpagecolumn">
                      <ul>
                        <li class="students-number">
                          <a href="#">Enquire Now</a>
                          <!--<i class='bx bx-user'></i> 10 students-->
                        </li>

                        <li class="courses-lesson">
                          <!--<i class='bx bx-time'></i> 6 Hour-->
                          <a href="#">Request a Call Back</a>
                        </li>

                        <!--
<li class="courses-price">
<i>₹</i>780
</li>
-->
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 col-md-12">
              <div class="single-courses-list-box mb-30 innerproductlistcolumn">
                <div class="box-item">
                  <div class="courses-image">
                    <div class="image bg-2">
                      <img src="assets/img/cars/evfyscooter.jpg" alt="image">

                      <a href="product-details.php" class="link-btn"></a>

                    </div>
                  </div>

                  <div class="courses-desc">
                    <div class="courses-content productlistingdetails">

                      <h3><a href="product-details.php" class="d-inline-block">Kinetic Zoom</a></h3>

                      <div class="courses-rating">
                        <div class="review-stars-rated">
                          <i class='fa fa-star'></i>
                          <i class='fa fa-star'></i>
                          <i class='fa fa-star'></i>
                          <i class='fa fa-star'></i>
                          <i class='fa fa-star'></i>
                        </div>

                        <div class="rating-total">
                          5.0 (1 rating)
                        </div>
                      </div>

                      <p>Kinetic Zoom Electric scooter offers future-led design with its high-end features and technology.</p>
                      <ul class="upcomingfirstullist">
                        <li><i class="fa fa-flash"></i><span>80 Km*</span><label>Per Charge</label></li>
                        <li><i class="fa fa-flash"></i><span>03 Years*</span><label>of Warranty</label></li>
                        <li><i class="fa fa-flash"></i><span>3 Hours*</span><label>Full Charge</label></li>
                        <li><i class="fa fa-flash"></i><span>60V 22Ah*</span><label>Battery</label></li>
                      </ul>
                    </div>

                    <div class="courses-box-footer listingpagecolumn">
                      <ul>
                        <li class="students-number">
                          <a href="#">Enquire Now</a>
                          <!--<i class='bx bx-user'></i> 10 students-->
                        </li>

                        <li class="courses-lesson">
                          <!--<i class='bx bx-time'></i> 6 Hour-->
                          <a href="#">Request a Call Back</a>
                        </li>

                        <!--
<li class="courses-price">
<i>₹</i>780
</li>
-->
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>






          </div>
        </div>





        <?php include 'include/product-category-sidebar.php'; ?>
      </div>
    </div>
  </section>
  <!-- End Courses Area -->



  <?php include 'include/footer.php'; ?>
  <?php include 'include/script.php'; ?>

  <script>
    const products = document.querySelectorAll(".product");
    const container = document.querySelector(".container");
    const nav = document.querySelector(".nav");
    const cover = document.querySelector(".cover");
    const productWidth = 310;
    const overlay = document.querySelector(".product__overlay");

    function getProductOffset() {
      return (container.offsetWidth - container.offsetWidth * 70 / 100) / 2;
    }

    function removeActiveClass() {
      const activeProduct = document.querySelector(".product--active");
      if (activeProduct) {
        activeProduct.scrollTop = 0;
        activeProduct.classList.remove("product--active");
        container.classList.remove("container--detail");
      }
    }

    products.forEach(product => {
      product.addEventListener("click", e => {
        if (e.target.classList.contains("product__close")) {
          overlay.style.display = "none";
          removeActiveClass();
          return;
        }
        if (!e.currentTarget.classList.contains("product--active")) {
          overlay.style.display = "block";
          removeActiveClass();
          e.currentTarget.classList.add("product--active");
          container.classList.add("container--detail");

          const left =
            productWidth * parseInt(e.currentTarget.getAttribute("data-index")) +
            cover.offsetWidth +
            parseInt(e.currentTarget.getAttribute("data-index")) * 6 +
            nav.offsetWidth -
            getProductOffset();

          container.scrollLeft = left;
          overlay.style.display = "none";
          if (
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
              navigator.userAgent))

          {
            e.currentTarget.scrollIntoView({
              inline: "start"
            });
          }
        }
      });
    });
  </script>


  <script>
    //-----JS for Price Range slider-----

    $(function() {
      $("#slider-range").slider({
        range: true,
        min: 130,
        max: 500,
        values: [130, 250],
        slide: function(event, ui) {
          $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
          filterProd(ui.values[0] + ":" + ui.values[1],'price','l');
        }
      });
      $("#amount").val("$" + $("#slider-range").slider("values", 0) +
        " - $" + $("#slider-range").slider("values", 1));
    });
  </script>
  
  <?php if ((isset($_GET['cat']) && !empty($_GET['cat']))|| (isset($_GET['brand']) && !empty($_GET['brand']))  ) {
    $cat =  isset($_GET['cat']) ? htmlspecialchars(trim($_GET['cat'])) : htmlspecialchars(trim($_GET['brand']));
    $fcat =  isset($_GET['cat']) ? 'cat' : 'brand';

  ?>
    <script>
      window.addEventListener('load', function() {
        filterProd('<?php echo $cat; ?>', '<?php echo $fcat; ?>', sortBy, order);
        document.title = "Evfy Shop";
        
    

      });

    </script>
  <?php } else { ?>
    <script>
      window.addEventListener('load', function() {
        filterProd();
        document.title = "Evfy Shop";
        const url = new URL(window.location);
url.searchParams.set('filter', '');
url.searchParams.set('type', '');
url.searchParams.set('sortBy', 'l');
window.history.pushState({}, '', url);
document.getElementById('searchshop')

    .addEventListener('keypress', function(event) {
        event.preventDefault();
        var key = event.charCode || event.keyCode || 0;     
        if (key == 13) {
        
        
            event.preventDefault();
            var v=document.getElementById('searchshop').value;
            
            if(v.length>2){
                filterProd(v,'search','l');  
            }else{
                filterProd();
            }
        }
    });
    
      });
    </script>
  <?php } ?>

  <script>
window.addEventListener('load', function() {
document.getElementById('searchshop')
    .addEventListener('keypress', function(event) {
        event.preventDefault();
        var key = event.charCode || event.keyCode || 0;     
        if (key == 13) {
        
        
            event.preventDefault();
            var v=document.getElementById('searchshop').value;
            
            if(v.length>2){
                filterProd(v,'search','l');  
            }else{
                filterProd();
            }
        }
    });
  });
</script>
</body>

</html>