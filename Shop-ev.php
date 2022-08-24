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

<?php 


$page=1;
if(isset($_GET['page'])){
 $page=$_GET['page'];
}
?>
<?php $prange=DB::queryFirstRow("select MIN(ex_showroom_price) as minp, MAX(ex_showroom_price) as maxp from products");
 ?>
  <script>
    localStorage.setItem("page",'<?php echo $page; ?>');
    //-----JS for Price Range slider-----

    $(function() {
      $("#slider-range").slider({
        range: true,
        min: parseFloat("<?php echo $prange['minp']; ?>".replace(/,/g, '')),
        max: parseFloat("<?php echo $prange['maxp']; ?>".replace(/,/g, '')),
        values: [1300, 2500000],
        slide: function(event, ui) {
          $("#amount").val("INR" + ui.values[0] + " - INR" + ui.values[1]);
          filterProd();
        }
      });
    });
      
  </script>
  
  
  
 <input type="hidden" id="filterShopData" data-cat="<?php echo isset($_GET['cat']) ? urldecode(htmlspecialchars_decode($_GET['cat'])) :''; ?>" data-model="<?php echo isset($_GET['model']) ? urldecode(htmlspecialchars_decode($_GET['model'])) :''; ?>" data-brand="<?php echo isset($_GET['brand']) ? urldecode(htmlspecialchars_decode($_GET['brand'])) :''; ?>" data-page="<?php echo $page; ?>" >
    <script>
      window.addEventListener('load', function() {
        filterProd();
        document.title = "Evfy Shop";
        
        

        document.getElementById('searchshop').addEventListener('keypress', function(event) {
        event.preventDefault();
        var key = event.charCode || event.keyCode || 0;     
        if (key == 13) {
        
        
            event.preventDefault();
            var v=document.getElementById('searchshop').value;
            
            if(v.length>2){
                filterProd();  
            }
        }
    });
    
      });
    </script>


  
</body>

</html>