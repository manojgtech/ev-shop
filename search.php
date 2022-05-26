<!doctype html>
<html lang="zxx">

<?php include 'include/style.php'; ?>



<body>

    <?php include 'include/navigation.php'; ?>

    <?php include 'include/websiteoverlaydontdel.php'; ?>

    <?php include 'include/slider.php'; ?>



    <?php include 'include/search-console.php'; ?>



    <section class="escootersection topbestthreeproduct" id="upcomingevoutersection">
        <div class="container">
            <?php
             


            if (isset($_POST['model'])  && $_POST['model']!='Select Model') {
                $model = trim($_POST['model']);
                $sql="select count(*) as pcount from products where model='$model'";
                $where="where model='$model'";

            }else if (isset($_POST['make']) && $_POST['make']!='Select Make') {
                $model = trim($_POST['make']);
                $sql="select count(*) as pcount from products where make=$model";
                $where="where make=$model";
            }else if (isset($_POST['category_id']) && $_POST['category_id']!='Select Vehicle Type') { 
                $model = trim($_POST['category']);
                $sql="select count(*) as pcount from products where make=$model";
                $where="where category_id=$model";
            }else{
                $where="";
                $sql="select count(*) as pcount from products";
            }  
           
            $perPage = 5;
            $prds = DB::query($sql);
            $total = $prds[0]['pcount'];
            $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
            $startAt = $perPage * ($page - 1);
            $totalPages = ceil($total / $perPage);
            ?>
    
            <?php
            
            $prods = DB::query("SELECT u.*, p.* FROM products AS u LEFT JOIN product_images AS p ON p.id = ( SELECT id FROM product_images AS p2 WHERE p2.product_id = u.id LIMIT 1 )  $where order by created_at limit $startAt,$perPage ;");
            
            if (count($prods) > 0) {
                $i = 0;
                foreach ($prods as $prod) {
            ?>
                    <div class="col-lg-12 col-md-12">
                        <div class="single-courses-list-box mb-30 innerproductlistcolumn">
                            <div class="box-item">
                                <div class="courses-image">
                                    <div class="image bg-1">
                                        <img src="<?php echo $prod['path']; ?>" alt="image">

                                        <a href="product-details.php?product=<?php echo $prod['slug']; ?>" class="link-btn"></a>

                                    </div>
                                </div>

                                <div class="courses-desc">
                                    <div class="courses-content productlistingdetails">

                                        <h3><a href="product-details.php?product=<?php echo $prod['slug']; ?>" class="d-inline-block"><?php echo $prod['title']; ?></a></h3>

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

                                        <p><?php echo substr(htmlspecialchars_decode($prod['description']), 0, 100) . '...'; ?></p>
                                        <ul class="upcomingfirstullist">
                                            <li><i class="fa fa-flash"></i><span><?php echo $prod['driving_range']; ?>*</span><label>Per Charge</label></li>
                                            <li><i class="fa fa-flash"></i><span><?php echo $prod['warranty']; ?>*</span><label>of Warranty</label></li>
                                            <li><i class="fa fa-flash"></i><span><?php echo $prod['charging_time']; ?>*</span><label>For Full Charge</label></li>
                                            <li><i class="fa fa-flash"></i><span><?php echo $prod['battery']; ?>*</span><label>Battery</label></li>
                                        </ul>
                                    </div>
                                    <!-- row -->
                                    <div class="courses-box-footer listingpagecolumn">
                                        <ul>
                                            <li class="students-number">
                                                <a href="request.php?product=<?php echo $prod['slug']; ?>">Enquire Now</a>
                                                <!--<i class='bx bx-user'></i> 10 students-->
                                            </li>

                                            <li class="courses-lesson">
                                                <!--<i class='bx bx-time'></i> 6 Hour-->
                                                <a href="#reqback-form">Request a Call Back</a>
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

            <?php $i++;
                }
            } else {
                echo "<h2>No product found for searched criteria !</h2>";
            }
            ?>
            <?php

            $links = "<ul class='pagination'>";
            for ($i = 1; $i <= $totalPages; $i++) {
                $links .= ($i != $page)
                    ? "<li class='page-item'><a class='page-link' href='search.php?page=$i'>Page $i</a> </li>"
                    : "<li class='page-item'><a class='page-link'> Page $page</a></li>";
            }
            $links .= "<ul>";
            echo $links;
            ?>

        </div>
    </section>


    <!--
        <section class="newupcomingoutersection">
        <h2 class="ceterwebheading">Best Products</h2>
        <div class="col-md-12 innercol12column">
            <div class="owl-carousel owl_carousel123">
                
<div class="item">
  
    <a href="e-cycle.php">
        <img src="assets/img/upcoming-images/product1.jpg" alt="" />
    </a>
    <div class="exclusiveribbon">
        <span>Best Seller</span>
    </div>
  <div class="inner upcomingcontentcolumn">
    <span class="firstspantag">Sold 9 units in last 24 hours!</span>
      <p>Super trendy and sporty! This E-Cycle can be your newest and most economical mode of transport. <strong></strong></p>
      <ul class="upcomingfirstullist">
            <li><i class="fa fa-flash"></i><span>30 Km*</span><label>Per Charge</label></li>
            <li><i class="fa fa-flash"></i><span>02 Years*</span><label>of Warranty</label></li>
            <li><i class="fa fa-flash"></i><span>5 Hours*</span><label>For Full Charge</label></li>
            <li><i class="fa fa-flash"></i><span>36V 8Ah*</span><label>Battery</label></li>
      </ul>
      <ul class="upcomingsecondullist">
          <li><a class="vechnamehead" href="e-cycle.php">Kinetic Kool E-Cycle<span>e-Cycle</span></a></li>
            <li><a class="buynowbuttonbike" href="#">Download Brochure</a></li>
            <li><a class="buynowbuttonbike" href="#">Enquire Now</a></li>
      </ul>
  </div>
  
</div>
                
                
<div class="item">
    <a href="kinetic-zoom.php">
        <img src="assets/img/upcoming-images/product2.jpg" alt="" />
    </a>
 <div class="exclusiveribbon">
        <span>Best Seller</span>
    </div>
  <div class="inner upcomingcontentcolumn">
    <span class="firstspantag">Sold 9 units in last 24 hours!</span>
      <p>Kinetic Zoom Electric scooter offers future-led design with its high-end features and technology.<strong></strong></p>
      <ul class="upcomingfirstullist">
            <li><i class="fa fa-flash"></i><span>100 Km*</span><label>Per Charge</label></li>
            <li><i class="fa fa-flash"></i><span>03 Years*</span><label>of Warranty</label></li>
            <li><i class="fa fa-flash"></i><span>3 Hours*</span><label>For Full Charge</label></li>
            <li><i class="fa fa-flash"></i><span>60V 22Ah*</span><label>Battery</label></li>
      </ul>
      <ul class="upcomingsecondullist">
            <li><a class="vechnamehead" href="kinetic-zoom.php">Kinetic Zoom<span>Two Wheelers</span></a></li>
            <li><a class="buynowbuttonbike" href="#">Download Brouchure</a></li>
            <li><a class="buynowbuttonbike" href="#">Enquire Now</a></li>
      </ul>
  </div>
  
</div>
                
                
<div class="item">
    <a href="kinetic-zing.php">
        <img src="assets/img/upcoming-images/product3.jpg" alt="" />
    </a>
 <div class="exclusiveribbon">
        <span>Popular Products</span>
    </div>
  <div class="inner upcomingcontentcolumn">
    <span class="firstspantag">Sold 9 units in last 24 hours!</span>
      <p>Pushback all your fuel worries with Kinetic Zing Electric Scooter. Simply charge and get going! <strong></strong></p>
      <ul class="upcomingfirstullist">
            <li><i class="fa fa-flash"></i><span>80 Km*</span><label>Per Charge</label></li>
            <li><i class="fa fa-flash"></i><span>03 Years*</span><label>of Warranty</label></li>
            <li><i class="fa fa-flash"></i><span>3 Hours*</span><label>For Full Charge</label></li>
            <li><i class="fa fa-flash"></i><span>60V 22Ah*</span><label>Battery</label></li>
      </ul>
      <ul class="upcomingsecondullist">
            <li><a class="vechnamehead" href="kinetic-zing.php">Kinetic Zing<span>Two Wheelers</span></a></li>
          <li><a class="buynowbuttonbike" href="#">Download Brouchure</a></li>
            <li><a class="buynowbuttonbike" href="#">Enquire Now</a></li>
      </ul>
  </div>
  
</div>
                
                

</div>
        </div>
    </section>
-->


    <section class="popularbrandsection courses-area">
        <div class="container">

            <div class="section-title text-left websiteheadingscolumn">
                <span class="sub-title">Discover Electric e-Vehicle</span>
                <h2 class="text-left">Best Brands Electric Vehicle</h2>
                <a href="#" class="default-btn"><i class='fa fa-eye icon-arrow before'></i><span class="label">Enquire Now</span><i class="fa fa-car icon-arrow after"></i></a>
            </div>
            <div class="emptyspace"></div>

            <div class="row">



                <div class="col-md-2 mostinnercolumn">
                    <a href="#">
                        <img src="assets/img/brand/b8.png" alt="Electric Car Brands" title="Electric Cars Brands">
                        <label>Kinetic</label>
                    </a>
                </div>


                <div class="col-md-2 mostinnercolumn">
                    <a href="#">
                        <img src="assets/img/brand/b9.png" alt="Electric Car Brands" title="Electric Cars Brands">
                        <label>Tata</label>
                    </a>
                </div>


                <div class="col-md-2 mostinnercolumn">
                    <a href="#">
                        <img src="assets/img/brand/b5.png" alt="Electric Car Brands" title="Electric Cars Brands">
                        <label>Mahindra</label>
                    </a>
                </div>


                <div class="col-md-2 mostinnercolumn">
                    <a href="#">
                        <img src="assets/img/brand/b3.png" alt="Electric Car Brands" title="Electric Cars Brands">
                        <label>Hundai</label>
                    </a>
                </div>


                <div class="col-md-2 mostinnercolumn">
                    <a href="#">
                        <img src="assets/img/brand/b10.png" alt="Electric Car Brands" title="Electric Cars Brands">
                        <label>MG</label>
                    </a>
                </div>

                <div class="col-md-2 mostinnercolumn">
                    <a href="#">
                        <img src="assets/img/brand/b12.png" alt="Electric Car Brands" title="Electric Cars Brands">
                        <label>Volkswagen</label>
                    </a>
                </div>



            </div>
        </div>
        <div id="particles-js-circle-bubble-4"></div>
    </section>




    <!-- Start Courses Area -->
    <section class="courses-area ourelectriccarssection" id="TestSeries">
        <div class="container">
            <div class="section-title text-left websiteheadingscolumn">
                <span class="sub-title">Featured Products</span>
                <h2 class="text-left">Our EV categories</h2>
                <a href="Shop-ev.php" class="default-btn"><i class='fa fa-eye icon-arrow before'></i><span class="label">View All EV</span><i class="fa fa-car icon-arrow after"></i></a>
            </div>
            <?php

            $catss = DB::query("SELECT id,slug ,name, (select count(*) from products where category_id=vehicles.id ) as prod FROM `vehicles` WHERE status=1");
            $cimgs = ['assets/img/categories/1.jpg', 'assets/img/categories/2.jpg', 'assets/img/categories/3.jpg', 'assets/img/categories/4.jpg'];
            ?>
            <div class="row">

                <?php if (count($catss) > 0) {
                    $i = 1;
                    foreach ($catss as $cat) {
                ?>
                        <div class="col-lg-3 col-sm-6 col-md-3">
                            <div class="single-categories-courses-item bg<?php echo $i; ?> mb-30 productcategoriescolumn" style="backgroung-image:url('<?php echo $cat['image']; ?>');">
                                <div class="icon">
                                    <i class='bx bx-layer'></i>
                                </div>
                                <h3><?php echo $cat['name']; ?></h3>
                                <span><?php echo $cat['prod']; ?> Products</span>

                                <a href="Shop-ev.php?cat=<?php echo $cat['slug']; ?>" class="learn-more-btn">Show All <i class='fa fa-long-arrow-right'></i></a>

                                <a href="Shop-ev.php?cat=<?php echo $cat['slug']; ?>" class="link-btn"></a>
                            </div>
                        </div>
                <?php $i++;
                    }
                }
                ?>




            </div>

        </div>
    </section>
    <!-- End Courses Area -->





    <!--
         <section class="escootersection" id="upcomingevoutersection">
            <div class="container">
                    <div class="section-title text-left websiteheadingscolumn">
                        <span class="sub-title">New EV Available</span>
                            <h2 class="text-left">Upcoming Electric Vehicle</h2>
                                <a href="#" class="default-btn"><i class='fa fa-eye icon-arrow before'></i><span class="label">View All Upcoming e-Scooters</span><i class="fa fa-car icon-arrow after"></i></a>
                    </div>
                <div class="emptyspace"></div>
                <div class="row">
                    <div class="courses-slides-upcoming owl-carousel owl-theme">
                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="https://freekideals.in/evfy/assets/img/upcoming-images/product1.jpg" alt="image"></a>
                            <div class="courses-tag">
                                <a href="#" class="d-block">E-Cycles</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">Kinetic Cool E-Cycle</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>Enquire Now</i>
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="https://freekideals.in/evfy/assets/img/upcoming-images/product2.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Two Wheelers</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">Kinetic Zoom</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>Enquire Now</i>
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                        
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="https://freekideals.in/evfy/assets/img/upcoming-images/product3.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Two Wheelers</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">Kinetic Zing</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>Enquire Now</i>
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                       
                    </div>

                </div>
                </div>
            </div>
        </section>
-->




    <!--
        <section class="escootersection twentyfivekmsection">
            <div class="container">
                    <div class="section-title text-left websiteheadingscolumn">
                        <span class="sub-title">Discover Low Speed Scooter (upto 25kmph)</span>
                            <h2 class="text-left">Available Cycles e-Scooters</h2>
                                <a href="#" class="default-btn"><i class='fa fa-eye icon-arrow before'></i><span class="label">View All e-Scooters</span><i class="fa fa-car icon-arrow after"></i></a>
                    </div>
                <div class="emptyspace"></div>
                <div class="row">
                    <div class="courses-slides-upcoming owl-carousel owl-theme">
                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/scooters/sc1.jpg" alt="image"></a>
                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">Jupiter ZX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>55.960 Thousands
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/scooters/sc2.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">Jupiter ZX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>55.960 Thousands
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                        
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/scooters/sc3.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">Jupiter ZXX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>55.960 Thousands
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                       
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/scooters/sc4.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">Jupiter ZX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>55.960 Thousands
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                       
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/scooters/sc5.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                       <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">Jupiter ZX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>55.960 Thousands
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                       
                    </div>
                    

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/scooters/sc6.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">Jupiter ZX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>55.960 Thousands
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>
                    </div>
                        
                        
                        <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/scooters/sc7.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">Jupiter ZX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>55.960 Thousands
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>
                    </div>
                        
                        
                        
                </div>
                </div>
            </div>
        </section>
-->











    <!--
        <section class="upcommingcar">
            <div class="container">
                <div class="section-title text-left websiteheadingscolumn">
                        <span class="sub-title">Discover High Speed Scooter (above 25kmph)</span>
                            <h2 class="text-left">Available e-Scooters</h2>
                                <a href="#" class="default-btn"><i class='fa fa-eye icon-arrow before'></i><span class="label">View All e-Scooters</span><i class="fa fa-car icon-arrow after"></i></a>
                    </div>
                <div class="emptyspace"></div>
                
                <div class="row">
                    <div class="courses-slides-upcoming owl-carousel owl-theme">
                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/bike1.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/bike2.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                        
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/sc2.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                       
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/sc3.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                       
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/sc5.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                       <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                       
                    </div>
                    

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/sc7.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div> 
                    </div>
                        
                        
                        <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/sc5.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div> 
                    </div>
                        
                        
                        <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/bike4.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div> 
                    </div>
                        
                        
                        <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/bike5.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div> 
                    </div>
                </div>
                </div>
            </div>
            <div id="particles-js-circle-bubble-2"></div>
        </section>
-->









    <!--
        <section class="compareelectriccars">
            <div class="container">
                <div class="section-title text-left websiteheadingscolumn">
                        <span class="sub-title">Discover EV Cars</span>
                            <h2 class="text-left">Our Available e-Cars</h2>
                                <a href="#" class="default-btn"><i class='fa fa-eye icon-arrow before'></i><span class="label">View All</span><i class="fa fa-car icon-arrow after"></i></a>
                    </div>
                <div class="row">
                    <div class="courses-slides owl-carousel owl-theme">
                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn availecarscolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/car1.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn availecarscolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/car2.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                        
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn availecarscolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/car3.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                       
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn availecarscolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/car4.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                       
                    </div>

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn availecarscolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/car5.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                       <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                       
                    </div>
                    

                    <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn availecarscolumn">
                        <div class="courses-image">
                            <a href="#" class="d-block"><img src="assets/img/cars/car6.jpg" alt="image"></a>

                            <div class="courses-tag">
                                <a href="#" class="d-block">Category Name</a>
                            </div>
                        </div>

                        <div class="courses-content">
                            <h3><a href="#" class="d-inline-block">The 2017 Honda NSX</a></h3>
                            <div class="courses-box-footer">
                                <ul>
                                    <li class="courses-price">
                                        <i>��?��</i>7.96 Lakh
                                    </li>
                                </ul>
                            </div>
                            <div class="courses-rating">
                               <p>Avg. Ex-Showroom price</p>
                            </div>
                            
                            <div class="carlocation">
                                <label>Show price in my city</label>
                            </div>
                        </div>

                        
                    </div>
                </div>
                </div>
            </div>
        </section>
-->


    <!--
        <section class="compareelectriccars">
            <div class="container">
                    <div class="section-title text-left websiteheadingscolumn">
                        <span class="sub-title">High Speed e-Scooters</span>
                            <h2 class="text-left">Top e-Scooters Comparison</h2>
                                <a href="#" class="default-btn"><i class='fa fa-eye icon-arrow before'></i><span class="label">Compare More</span><i class="fa fa-car icon-arrow after"></i></a>
                    </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 headertext">
                       <p>When it comes to buying a car, everyone has different priorities. carspot comes with excellent car comparison features that suits your needs.</p>
                    </div>
                <div class="col-md-2"></div>
                </div>
            
            
            <div class="row">
                <div class="col-md-4 compareoutersection">
                    <div class="row">
                        <div class="col-md-6 compareinnercolumn">
                            <a href="#">
                                <img src="assets/img/scooters/sc1.jpg" alt="" title="">
                            <div class="innercomparecontent">
                                <h3>TVS Wego 110 Drum</h3>
                                <ul>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <div class="courses-box-footer">
                                    <ul>
                                        <li class="courses-price">
                                            <i>��?��</i>7.96 Lakh
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="cbutton">
                            <i>VS</i>
                        </div>
                        <div class="col-md-6 compareinnercolumn">
                            <a href="#">
                                <img src="assets/img/scooters/sc2.jpg" alt="" title="">
                            <div class="innercomparecontent">
                                <h3>TVS Wego 110 Drum</h3>
                                <ul>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <div class="courses-box-footer">
                                    <ul>
                                        <li class="courses-price">
                                            <i>��?��</i>7.96 Lakh
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <a class="outercolumncomparebutton" href="#">compare TVS wego 110 vs TVS wego 110</a>
                </div>
                
                
                <div class="col-md-4 compareoutersection">
                    <div class="row">
                        <div class="col-md-6 compareinnercolumn">
                            <a href="#">
                                <img src="assets/img/scooters/sc3.jpg" alt="" title="">
                            <div class="innercomparecontent">
                               <h3>TVS Wego 110 Drum</h3>
                                <ul>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <div class="courses-box-footer">
                                    <ul>
                                        <li class="courses-price">
                                            <i>��?��</i>7.96 Lakh
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="cbutton">
                            <i>VS</i>
                        </div>
                        <div class="col-md-6 compareinnercolumn">
                            <a href="#">
                                <img src="assets/img/scooters/sc4.jpg" alt="" title="">
                            <div class="innercomparecontent">
                                <h3>TVS Wego 110 Drum</h3>
                                <ul>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <div class="courses-box-footer">
                                    <ul>
                                        <li class="courses-price">
                                            <i>��?��</i>7.96 Lakh
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <a class="outercolumncomparebutton" href="#">compare TVS wego 110 vs TVS wego 110</a>
                </div>
                
                
                <div class="col-md-4 compareoutersection">
                    <div class="row">
                        <div class="col-md-6 compareinnercolumn">
                            <a href="#">
                                <img src="assets/img/scooters/sc5.jpg" alt="" title="">
                            <div class="innercomparecontent">
                                <h3>TVS Wego 110 Drum</h3>
                                <ul>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <div class="courses-box-footer">
                                    <ul>
                                        <li class="courses-price">
                                            <i>��?��</i>7.96 Lakh
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="cbutton">
                            <i>VS</i>
                        </div>
                        <div class="col-md-6 compareinnercolumn">
                            <a href="#">
                                <img src="assets/img/scooters/sc6.jpg" alt="" title="">
                            <div class="innercomparecontent">
                                <h3>TVS Wego 110 Drum</h3>
                                <ul>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <div class="courses-box-footer">
                                    <ul>
                                        <li class="courses-price">
                                            <i>��?��</i>7.96 Lakh
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <a class="outercolumncomparebutton" href="#">compare TVS wego 110 vs TVS wego 110</a>
                </div>
                
                
            </div>
            
            
            </div>
        </section>
-->


    <section class="testrideandprice" style="display:none;">
        <div class="container">
            <div class="row firstinnerrow">

                <div class="col-md-8 leftsideroadprice">
                    <h2>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</h2>
                </div>
                <div class="col-md-4 rightsideformcolumn">
                    <!--
                            <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#firsttab" data-toggle="tab">Check On Road Price</a>
                            </li>

                            <li>
                                <a href="#secondtab" data-toggle="tab">Book a Test Drive</a>
                            </li>
                            </ul>
-->
                    <div class="tab-content tab_content">
                        <div class="tab-pane active" id="firsttab">
                            <form class="form-horizontal" action="submit">
                                <h3>Check On Road Price in Your City</h3>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="vname" name="vname" placeholder="Type to select Car or e-Bikes" required>
                                    <i class="fa fa-search"></i>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="ecity" name="ecity" placeholder="Select City" required readonly>
                                    <i class="fa fa-chevron-right"></i>
                                </div>
                            </form>
                        </div>

                        <!--
                            <div class="tab-pane" id="secondtab">
                                <form class="form-horizontal" action="">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="baname" name="baname" placeholder="Your Full Name*" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="tel" class="form-control" id="bphone" name="bphone" placeholder="Your Email Id*" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="bmail" name="bmail" placeholder="Your Phone Number*" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <select class="form-control" id="bcity" name="bcity" required>
                                            <option>Select Your City*</option>
                                            <option>New Delhi</option>
                                            <option>Mumbai</option>
                                            <option>Kolkata</option>
                                            <option>Bangalore</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <select class="form-control" id="bev" name="bev" required>
                                            <option>Select an EV*</option>
                                            <option>Electric Vehcile1</option>
                                            <option>Electric Vehcile2</option>
                                            <option>Electric Vehcile3</option>
                                            <option>Electric Vehcile4</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group termandcondition">
                                        <input type="checkbox" class="form-control" id="bterm" name="bterm" value="yes" required>
                                        <label for="agree">I agree to the terms and conditions</label>
                                    </div>
                                    
                                    <div class="form-group webformlastformcolumn">
                                        <input type="submit" value="Book Now" class="webformbutton">
                                    </div>
                                </form>
                            </div>
-->
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="testrideandprice">
        <div class="container">
            <div class="row firstinnerrow">

                <div class="col-md-5 leftsideroadprice">
                    <h2>The perfect solution for a big city<br />Have any queries? call us anytime</h2>
                </div>
                <div class="col-md-3 phonenumbercolumn">
                    <ul>
                        <li>
                            <a href="tel:+91-9311111437"><i class="fa fa-mobile"></i>+91-93111 11437</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 rightsideformcolumn">
                    <!--
                            <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#firsttab" data-toggle="tab">Check On Road Price</a>
                            </li>

                            <li>
                                <a href="#secondtab" data-toggle="tab">Book a Test Drive</a>
                            </li>
                            </ul>
-->
                    <div class="tab-content tab_content">
                        <div class="tab-pane active" id="firsttab">
                            <?php
                            include("include/request-callback.php");
                            ?>
                        </div>

                        <!--
                            <div class="tab-pane" id="secondtab">
                                <form class="form-horizontal" action="">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="baname" name="baname" placeholder="Your Full Name*" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="tel" class="form-control" id="bphone" name="bphone" placeholder="Your Email Id*" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="bmail" name="bmail" placeholder="Your Phone Number*" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <select class="form-control" id="bcity" name="bcity" required>
                                            <option>Select Your City*</option>
                                            <option>New Delhi</option>
                                            <option>Mumbai</option>
                                            <option>Kolkata</option>
                                            <option>Bangalore</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <select class="form-control" id="bev" name="bev" required>
                                            <option>Select an EV*</option>
                                            <option>Electric Vehcile1</option>
                                            <option>Electric Vehcile2</option>
                                            <option>Electric Vehcile3</option>
                                            <option>Electric Vehcile4</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group termandcondition">
                                        <input type="checkbox" class="form-control" id="bterm" name="bterm" value="yes" required>
                                        <label for="agree">I agree to the terms and conditions</label>
                                    </div>
                                    
                                    <div class="form-group webformlastformcolumn">
                                        <input type="submit" value="Book Now" class="webformbutton">
                                    </div>
                                </form>
                            </div>
-->
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Start Testimonials Area -->
    <!--
        <section class="testimonials-area ourtestimonialoutersection">
            <div class="container">
              <div class="section-title text-left websiteheadingscolumn">
                        <span class="sub-title">Testimonials</span>
                            <h2 class="text-left">What Our Client Say's Says</h2>
                                <a href="#" class="default-btn"><i class='fa fa-eye icon-arrow before'></i><span class="label">View All</span><i class="fa fa-car icon-arrow after"></i></a>
                    </div>

                <div class="testimonials-slides owl-carousel owl-theme">
                    <div class="single-testimonials-item">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

                        <div class="info">
                            <img src="assets/img/user1.jpg" class="shadow rounded-circle" alt="image">
                            <h3>John Smith</h3>
                            <span>Student</span>
                        </div>
                    </div>

                    <div class="single-testimonials-item">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

                        <div class="info">
                            <img src="assets/img/user2.jpg" class="shadow rounded-circle" alt="image">
                            <h3>Sarah Taylor</h3>
                            <span>Student</span>
                        </div>
                    </div>

                    <div class="single-testimonials-item">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

                        <div class="info">
                            <img src="assets/img/user3.jpg" class="shadow rounded-circle" alt="image">
                            <h3>David Warner</h3>
                            <span>Student</span>
                        </div>
                    </div>

                    <div class="single-testimonials-item">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

                        <div class="info">
                            <img src="assets/img/user4.jpg" class="shadow rounded-circle" alt="image">
                            <h3>James Anderson</h3>
                            <span>Student</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
-->
    <!-- End Testimonials Area -->

    <?php
    $posts = DB::query("select * from posts order by created_at limit 6");


    ?>

    <!-- Start Blog Area -->
    <section class="blog-area ourevnewsoutersection">
        <div class="container">
            <div class="section-title text-left websiteheadingscolumn">
                <span class="sub-title">EV News</span>
                <h2 class="text-left">Our Latest News</h2>
                <a href="blog.php" class="default-btn"><i class='fa fa-eye icon-arrow before'></i><span class="label">View All</span><i class="fa fa-car icon-arrow after"></i></a>
            </div>

            <div class="blog-slides owl-carousel owl-theme">
                <div class="single-blog-post mb-30">
                    <div class="post-image">
                        <a href="#" class="d-block">
                            <img src="https://imgd.aeplcdn.com/1280x720/n/cw/ec/104705/right-side-view0.jpeg?isig=0&q=75" alt="image">
                        </a>

                        <div class="tag">
                            <a href="#">E Bikes</a>
                        </div>
                    </div>

                    <div class="post-content">
                        <ul class="post-meta">
                            <li class="post-author">
                                <img src="assets/img/user1.jpg" class="d-inline-block rounded-circle mr-2" alt="image">
                                By: <a href="#" class="d-inline-block">Steven Smith</a>
                            </li>
                            <li><a href="#">August 30, 2019</a></li>
                        </ul>
                        <h3><a href="#" class="d-inline-block">Kawasaki��??s KTM 125 Duke rival updated for 2022</a></h3>
                        <a href="#" class="read-more-btn">Read More <i class='fa fa-long-arrow-right'></i></a>
                    </div>
                </div>

                <div class="single-blog-post mb-30">
                    <div class="post-image">
                        <a href="#" class="d-block">
                            <img src="https://imgd.aeplcdn.com/1280x720/n/cw/ec/100617/ola-s1-right-front-three-quarter4.jpeg?isig=0&q=75" alt="image">
                        </a>

                        <div class="tag">
                            <a href="#">E Scooters</a>
                        </div>
                    </div>

                    <div class="post-content">
                        <ul class="post-meta">
                            <li class="post-author">
                                <img src="assets/img/user2.jpg" class="d-inline-block rounded-circle mr-2" alt="image">
                                By: <a href="#" class="d-inline-block">Lina D'Souja</a>
                            </li>
                            <li><a href="#">August 29, 2019</a></li>
                        </ul>
                        <h3><a href="#" class="d-inline-block">Ola S1 and S1 Pro electric scooter launched in India</a></h3>
                        <a href="#" class="read-more-btn">Read More <i class='fa fa-long-arrow-right'></i></a>
                    </div>
                </div>

                <div class="single-blog-post mb-30">
                    <div class="post-image">
                        <a href="#" class="d-block">
                            <img src="https://imgd.aeplcdn.com/1280x720/n/cw/ec/103491/left-side-view1.jpeg?isig=0&q=75" alt="image">
                        </a>

                        <div class="tag">
                            <a href="#">EV World</a>
                        </div>
                    </div>

                    <div class="post-content">
                        <ul class="post-meta">
                            <li class="post-author">
                                <img src="https://imgd.aeplcdn.com/1280x720/n/cw/ec/103293/left-side-view1.jpeg?isig=0&q=75" class="d-inline-block rounded-circle mr-2" alt="image">
                                By: <a href="#" class="d-inline-block">David Malan</a>
                            </li>
                            <li><a href="#">August 28, 2019</a></li>
                        </ul>
                        <h3><a href="#" class="d-inline-block">Ola Electric scooters sales postponed due to technical</a></h3>
                        <a href="#" class="read-more-btn">Read More <i class='fa fa-long-arrow-right'></i></a>
                    </div>
                </div>

                <div class="single-blog-post mb-30">
                    <div class="post-image">
                        <a href="#" class="d-block">
                            <img src="https://imgd.aeplcdn.com/1280x720/n/cw/ec/103293/left-side-view1.jpeg?isig=0&q=75" alt="image">
                        </a>

                        <div class="tag">
                            <a href="#">EV News</a>
                        </div>
                    </div>

                    <div class="post-content">
                        <ul class="post-meta">
                            <li class="post-author">
                                <img src="assets/img/user5.jpg" class="d-inline-block rounded-circle mr-2" alt="image">
                                By: <a href="#" class="d-inline-block">David Warner</a>
                            </li>
                            <li><a href="#">August 27, 2019</a></li>
                        </ul>
                        <h3><a href="#" class="d-inline-block">Ola S1 and S1 Pro electric scooter sales commence</a></h3>
                        <a href="#" class="read-more-btn">Read More <i class='fa fa-long-arrow-right'></i></a>
                    </div>
                </div>

                <div class="single-blog-post mb-30">
                    <div class="post-image">
                        <a href="#" class="d-block">
                            <img src="https://imgd.aeplcdn.com/1280x720/n/cw/ec/103681/right-front-three-quarter2.jpeg?isig=0&q=75" alt="image">
                        </a>

                        <div class="tag">
                            <a href="#">E Cars</a>
                        </div>
                    </div>

                    <div class="post-content">
                        <ul class="post-meta">
                            <li class="post-author">
                                <img src="assets/img/user6.jpg" class="d-inline-block rounded-circle mr-2" alt="image">
                                By: <a href="#" class="d-inline-block">Olivar Waise</a>
                            </li>
                            <li><a href="#">August 26, 2019</a></li>
                        </ul>
                        <h3><a href="#" class="d-inline-block">Ola S1 and S1 Pro sales to reopen on 1 November</a></h3>
                        <a href="#" class="read-more-btn">Read More <i class='fa fa-long-arrow-right'></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Blog Area -->


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
</body>


</html>