<?php 

$slug=htmlspecialchars($_GET['product']);
$rel_prods=DB::query("select *,vehicles.name from products join vehicles on vehicles.id=products.category_id  where category_id=(select category_id from products where slug=%s) limit 10",$slug);
 
?>

<section class="newupcomingoutersection" id="similarev">
        <h2 class="ceterwebheading">Related Products</h2>
        <div class="col-md-12 innercol12column">
            <div class="owl-carousel owl_carousel123">
                <?php 
    if(count($rel_prods)>0){
    foreach($rel_prods as $prod){
      $img=DB::queryFirstRow("select path from product_images where product_id=%i",$prod['id']);
    ?>
<div class="item">
  
    <a href="e-cycle.php">
        <img src="<?php echo $img['path']; ?>" alt="<?php echo $prod['title']; ?>" />
    </a>
    <div class="exclusiveribbon">
        <span>Best Seller</span>
    </div>
  <div class="inner upcomingcontentcolumn">
    <span class="firstspantag">Sold 9 units in last 24 hours!</span>
      <p><?php echo  substr(htmlspecialchars_decode($prod['description']),0,100); ?> <strong></strong></p>
      <ul class="upcomingfirstullist" display:none;>
            <li><i class="fa fa-flash"></i><span>30 Km*</span><label>Per Charge</label></li>
            <li><i class="fa fa-flash"></i><span>02 Years*</span><label>of Warranty</label></li>
            <li><i class="fa fa-flash"></i><span>5 Hours*</span><label>For Full Charge</label></li>
            <li><i class="fa fa-flash"></i><span>36V 8Ah*</span><label>Battery</label></li>
      </ul>
      <ul class="upcomingsecondullist">
<!--            <li>MRP: <i class="fa fa-inr"></i> 34,099/-<span>price in your city</span><label>EMI available</label></li>-->
          <li><a class="vechnamehead" href="e-cycle.php"><?php echo $prod['title']; ?><span><?php echo $prod['name'];  ?></span></a></li>
            <li><a class="buynowbuttonbike" href="#">Download Brochure</a></li>
            <li><a class="buynowbuttonbike" href="#">Enquire Now</a></li>
      </ul>
  </div>
  
</div>
      <?php } } ?>          
                
                

<!--
   <div class="item">
  <img src="assets/img/upcoming-images/product4.jpg" alt="" />
       <div class="exclusiveribbon">
        <span>Best Seller</span>
    </div>
  <div class="inner upcomingcontentcolumn">
    <span class="firstspantag">Sold 9 units in last 24 hours!</span>
      <p>The unconqured High speed cars, <strong>Pro Series MBT</strong></p>
      <ul class="upcomingfirstullist">
            <li><i class="fa fa-flash"></i><span>Durable Carbon</span><label>Steel Frame</label></li>
            <li><i class="fa fa-flash"></i><span>Shock-Free</span><label>Suspension</label></li>
            <li><i class="fa fa-flash"></i><span>Fast & Dynamic</span><label>Disc Brakes</label></li>
            <li><i class="fa fa-flash"></i><span>21 High Speed</span><label>Shimano Gears</label></li>
      </ul>
      <ul class="upcomingsecondullist">
            <li>MRP: <i class="fa fa-inr"></i> 34,099/-<span>price in your city</span><label>EMI available</label></li>
            <li><a class="vechnamehead" href="#">Invictus 27.7T<span>Product Category</span></a></li>
            <li><a class="buynowbuttonbike" href="#">Buy Now</a></li>
      </ul>
  </div>
</div>
-->
                
                

<!--
<div class="item">
  <img src="assets/img/upcoming-images/product5.jpg" alt="" />
 <div class="exclusiveribbon">
        <span>Best Seller</span>
    </div>
  <div class="inner upcomingcontentcolumn">
    <span class="firstspantag">Sold 9 units in last 24 hours!</span>
      <p>The unconqured High speed cars, <strong>Pro Series MBT</strong></p>
      <ul class="upcomingfirstullist">
            <li><i class="fa fa-flash"></i><span>Durable Carbon</span><label>Steel Frame</label></li>
            <li><i class="fa fa-flash"></i><span>Shock-Free</span><label>Suspension</label></li>
            <li><i class="fa fa-flash"></i><span>Fast & Dynamic</span><label>Disc Brakes</label></li>
            <li><i class="fa fa-flash"></i><span>21 High Speed</span><label>Shimano Gears</label></li>
      </ul>
      <ul class="upcomingsecondullist">
            <li>MRP: <i class="fa fa-inr"></i> 34,099/-<span>price in your city</span><label>EMI available</label></li>
            <li><a class="vechnamehead" href="#">Invictus 27.7T<span>Product Category</span></a></li>
            <li><a class="buynowbuttonbike" href="#">Buy Now</a></li>
      </ul>
  </div>
</div>
-->
                
                
                
<!--
<div class="item">
  <img src="assets/img/upcoming-images/product6.jpg" alt="" />
    <div class="exclusiveribbon">
        <span>Best Seller</span>
    </div>
  <div class="inner upcomingcontentcolumn">
    <span class="firstspantag">Sold 9 units in last 24 hours!</span>
      <p>The unconqured High speed cars, <strong>Pro Series MBT</strong></p>
      <ul class="upcomingfirstullist">
            <li><i class="fa fa-flash"></i><span>Durable Carbon</span><label>Steel Frame</label></li>
            <li><i class="fa fa-flash"></i><span>Shock-Free</span><label>Suspension</label></li>
            <li><i class="fa fa-flash"></i><span>Fast & Dynamic</span><label>Disc Brakes</label></li>
            <li><i class="fa fa-flash"></i><span>21 High Speed</span><label>Shimano Gears</label></li>
      </ul>
      <ul class="upcomingsecondullist">
            <li>MRP: <i class="fa fa-inr"></i> 34,099/-<span>price in your city</span><label>EMI available</label></li>
            <li><a class="vechnamehead" href="#">Invictus 27.7T<span>Product Category</span></a></li>
            <li><a class="buynowbuttonbike" href="#">Buy Now</a></li>
      </ul>
  </div>
</div>
-->
                
                

<!--
<div class="item">
  <img src="assets/img/upcoming-images/product7.jpg" alt="" />
 <div class="exclusiveribbon">
        <span>Best Seller</span>
    </div>
  <div class="inner upcomingcontentcolumn">
    <span class="firstspantag">Sold 9 units in last 24 hours!</span>
      <p>The unconqured High speed e-cars, <strong></strong></p>
      <ul class="upcomingfirstullist">
            <li><i class="fa fa-flash"></i><span>Steel Chassis Frame</span><label>Body</label></li>
            <li><i class="fa fa-flash"></i><span>5kW DC Motor</span><label>Motor Type</label></li>
            <li><i class="fa fa-flash"></i><span>1200kg</span><label>Maximum loading</label></li>
            <li><i class="fa fa-flash"></i><span>8 Hours*</span><label>Charging Time</label></li>
      </ul>
      <ul class="upcomingsecondullist">
            <li>MRP: <i class="fa fa-inr"></i> 34,099/-<span>price in your city</span><label>EMI available</label></li>
            <li><a class="vechnamehead" href="#">Smart Commute Buggies<span>Four Wheelers</span></a></li>
            <li><a class="buynowbuttonbike" href="#">Buy Now</a></li>
      </ul>
  </div>
</div>
-->
                
                
<!--

<div class="item">
  <img src="assets/img/upcoming-images/product8.jpg" alt="" />
 <div class="exclusiveribbon">
        <span>Best Seller</span>
    </div>
  <div class="inner upcomingcontentcolumn">
    <span class="firstspantag">Sold 9 units in last 24 hours!</span>
      <p>The unconqured High speed cars, <strong></strong></p>
      <ul class="upcomingfirstullist">
            <li><i class="fa fa-flash"></i><span>28 Km*</span><label>Max Speed</label></li>
            <li><i class="fa fa-flash"></i><span>14 Seater*</span><label>Suspension</label></li>
            <li><i class="fa fa-flash"></i><span>80 Km*</span><label>Per Charge</label></li>
            <li><i class="fa fa-flash"></i><span>8 Hours*</span><label>Charging Time</label></li>
      </ul>
      <ul class="upcomingsecondullist">
            <li>MRP: <i class="fa fa-inr"></i> 34,099/-<span>price in your city</span><label>EMI available</label></li>
            <li><a class="vechnamehead" href="#">New Age Buggies<span>Four Wheelers</span></a></li>
            <li><a class="buynowbuttonbike" href="#">Buy Now</a></li>
      </ul>
  </div>
  
</div>
-->
</div>
        </div>
    </section>