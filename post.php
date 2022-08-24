<!doctype html>
<html lang="zxx">

<?php include 'include/style.php'; ?>

<style>
    .blogShort {
        border-bottom: 1px solid #ddd;
    }

    .blogShort img {
        width: 275px;
    }

    .btn-blog {
        color: #ffffff;
        background-color: #37d980;
        border-color: #37d980;
        border-radius: 0;
        margin-bottom: 10px
    }

    .btn-blog:hover,
    .btn-blog:focus,
    .btn-blog:active,
    .btn-blog.active,
    .open .dropdown-toggle.btn-blog {
        color: white;
        background-color: #34ca78;
        border-color: #34ca78;
    }

    h2 {
        color: #34ca78;
    }


    .margin10 {
        margin-bottom: 10px;
        margin-right: 10px;
    }
    .btn-blog {
    color: #ffffff;
    background-color: #37d980;
    border-color: #37d980;
    border-radius:0;
    margin-bottom:10px
}
.btn-blog:hover,
.btn-blog:focus,
.btn-blog:active,
.btn-blog.active,
.open .dropdown-toggle.btn-blog {
    color: white;
    background-color:#34ca78;
    border-color: #34ca78;
}
article h2{color:#333333;}
h2{color:#34ca78;}
 .margin10{margin-bottom:10px; margin-right:10px;}
 .blogShort{ border-bottom:1px solid #ddd;}
</style>

<body>

    <?php include 'include/navigation.php'; ?>

    <?php include 'include/websiteoverlaydontdel.php'; ?>

    <?php include 'include/slider.php'; ?>



    <?php include 'include/search-console.php'; ?>
<?php 
      $id=htmlspecialchars($_GET['post']);
    $post=DB::query("select * from posts where slug=%s",$id);
     if($post){
         $post=$post[0];
    
    ?>
    <section class="courses-area" id="blogsect">
        <div class="container">
           <div class="row">
           <div class="col-md-12 blogShort">
                     <h1><?php echo $post['title']; ?></h1>
                     <img src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>" class="pull-left img-responsive postImg img-thumbnail margin10">
                     <article><?php echo htmlspecialchars_decode($post['postbody']); ?>
                     </article>
                
                 </div>
	
           </div>
    </section>

    <?php } ?>



    <!-- <section class="escootersection topbestthreeproduct" id="upcomingevoutersection">
        <div class="container">
   
    <h2 class="ceterwebheading">Best Products</h2>
    <div class="emptyspace"></div>
    <div class="row">
        <div class="courses-slides-upcoming owl-carousel owl-theme">
            <div class="single-courses-box without-box-shadow mb-30 ourelectriccarinnercolumn lowspeedevcolumn">
                <div class="courses-image">
                    <a href="https://freekideals.in/evfy/e-cycle.php" class="d-block"><img src="https://freekideals.in/evfy/assets/img/upcoming-images/product1.jpg" alt="image"></a>
                    <div class="courses-tag">
                        <a href="https://freekideals.in/evfy/e-cycle.php" class="d-block">E-Cycles</a>
                    </div>
                </div>

                <div class="courses-content">
                    <h3><a href="https://freekideals.in/evfy/e-cycle.php" class="d-inline-block">Kinetic Cool E-Cycle</a></h3>
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
                    <a href="https://freekideals.in/evfy/kinetic-zoom.php" class="d-block"><img src="https://freekideals.in/evfy/assets/img/upcoming-images/product2.jpg" alt="image"></a>

                    <div class="courses-tag">
                        <a href="https://freekideals.in/evfy/kinetic-zoom.php" class="d-block">Two Wheelers</a>
                    </div>
                </div>

                <div class="courses-content">
                    <h3><a href="https://freekideals.in/evfy/kinetic-zoom.php" class="d-inline-block">Kinetic Zoom</a></h3>
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
                    <a href="https://freekideals.in/evfy/kinetic-zing.php" class="d-block"><img src="https://freekideals.in/evfy/assets/img/upcoming-images/product3.jpg" alt="image"></a>

                    <div class="courses-tag">
                        <a href="https://freekideals.in/evfy/kinetic-zing.php" class="d-block">Two Wheelers</a>
                    </div>
                </div>

                <div class="courses-content">
                    <h3><a href="https://freekideals.in/evfy/kinetic-zing.php" class="d-inline-block">Kinetic Zing</a></h3>
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




    <section class="popularbrandsection courses-area">
        <div class="container">

            blogs
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

            $catss = DB::query("SELECT id,slug ,name,image, (select count(*) from products where category_id=vehicles.id ) as prod FROM `vehicles` WHERE status=1");
            $cimgs = ['assets/img/categories/1.jpg', 'assets/img/categories/2.jpg', 'assets/img/categories/3.jpg', 'assets/img/categories/4.jpg'];
            ?>
            <div class="row">

                <?php if (count($catss) > 0) {
                    $i = 1;
                    foreach ($catss as $cat) {
                ?>
                        <div class="col-lg-3 col-sm-6 col-md-3">
                            <div class="single-categories-courses-item bg<?php echo $i; ?> mb-30 productcategoriescolumn" style="backgroung-image:url('<?php echo "assets/img/categories/" . $cat['image']; ?>');">
                                <div class="icon">
                                    <i class='bx bx-layer'></i>
                                </div>
                                <h3><?php echo $cat['name']; ?></h3>
                                <span><?php echo $cat['prod']; ?> Products</span>

                                <a href="Shop-ev.php?cat=<?php echo urlencode($cat['slug']); ?>" class="learn-more-btn">Show All <i class='fa fa-long-arrow-right'></i></a>

                                <a href="Shop-ev.php?cat=<?php echo urlencode($cat['slug']); ?>" class="link-btn"></a>
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











    <section class="testrideandprice" style="display:none;">
        <div class="container">
            <div class="row firstinnerrow">

                <div class="col-md-8 leftsideroadprice">
                    <h2>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</h2>
                </div>
                <div class="col-md-4 rightsideformcolumn">

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


                    </div>
                </div>

            </div>
        </div>
    </section>




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