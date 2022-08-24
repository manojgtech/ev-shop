<div class="col-lg-4 col-md-12 allpagerightsidebar">
    <aside class="widget-area">

        <?php
        $catss = DB::query("SELECT id,slug ,name, (select count(*) from products where category_id=vehicles.id ) as prod FROM `vehicles` WHERE status=1");
        ?>
        <section class="widget widget_categories">
            
            
            
<aside id="filters">
<div id="cattype">
<h1>Product Categories</h1>
<div class="bump">
<?php 
 $pccat=isset($_GET['cat']) ? urldecode(htmlspecialchars_decode($_GET['cat'])) :'';
if (count($catss) > 0) {
foreach ($catss as $cat) {
?>
<div class="box1">
<input type="checkbox" <?php echo ($pccat==$cat['slug']) ? 'checked':'';  ?> name="pcatid" id="pc<?php echo $cat['id']; ?>"   class="pcatids" value="<?php echo $cat['id']; ?>">
<label for="pc<?php echo $cat['id']; ?>" class="check-box"></label>
<h4><?php echo $cat['name']; ?>(<?php echo $cat['prod'];  ?>)</h4>
</div>
<?php

     }
}
?>

</div>
</div>
</aside>

        <section class="widget widget_categories rightsidebarproductfilter">
            <h3 class="widget-title">Product Range</h3>

            <div class="price-range-slider">

                <p class="range-value">
                    <input type="text" id="amount" onchange="filterProd();" readonly>
                </p>
                <div id="slider-range" class="range-bar"></div>

            </div>
        </section>


        <section class="widget widget_categories" style="margin-top:30%;">
            
            
            
<aside id="filters">
<div id="battery_type">
<h1>Battery Type</h1>
<div class="bump">
<?php
        $bprods= DB::query("SELECT battery , (select count(*) from products  where prd.battery=battery ) as prod FROM `products` as prd  WHERE status=1 group by prd.battery ");
        
        ?>
            <ul>
                <?php if(count($bprods)){
                    $i=1;
                  foreach($bprods as $prod){    
                ?>
<div class="box1">
<input type="checkbox"  id="bc<?php echo $i; ?>" value="<?php echo ucwords($prod['battery']); ?>">
<label for="bc<?php echo $i; ?>" class="check-box"></label>
<h4><?php echo ucwords($prod['battery']); ?>(<?php echo $prod['prod']; ?>)</h4>
</div>
<?php
  $i++; }
    }
?>
</div>
</div>
</aside>
           
        </section>


        <section class="widget widget_categories">
            
            
<aside id="filters">
<div id="charging_time">
<h1>Charging Time</h1>
<div class="bump">
<?php
        $bprods= DB::query("SELECT charging_time, (select count(*) from products where prd.charging_time=charging_time ) as prod FROM `products` as prd  WHERE status=1  group by prd.charging_time ");
        
        ?>
<?php if(count($bprods)){
     $i=1;
    foreach($bprods as $prod){    
    ?>
<div class="box1">
<input type="checkbox" id="ct<?php echo $i; ?>" value="<?php echo $prod['charging_time']; ?>">
<label for="ct<?php echo $i; ?>" class="check-box"></label>
<h4><?php echo $prod['charging_time']; ?></h4>
</div>
<?php  $i++; }
    }
?>

</div>
</div>
</aside>
            
            
        </section>


        <section class="widget widget_contact" style="height:auto;">
            <div class="col-md-12 innercolumnproduct">
                <h3>Contact Us</h3>
                <ul class="quickconnect">
                    <li>
                        <label><i class="fa fa-whatsapp"></i> Whats App Lets Chat</label>
                        <a href="tel:+093111 11437">+093111 11437</a>
                    </li>

                    <li>
                        <label><i class="fa fa-phone"></i> Sales Enquiry</label>
                        <a href="tel:+093111 11437">+093111 11437</a>
                    </li>

                    <li>
                        <label><i class="fa fa-envelope-o"></i> Send Email</label>
                        <a href="mailto:info@evfy.com">info@evfy.com</a>
                    </li>
                </ul>
            </div>
        </section>


        <section class="widget widget_contact" style="height:auto;">
            <div class="col-md-12 innercolumnproduct">
                <h3>Request a Call Back</h3>
                <form class="form-horizontal" id="reqback-form" method="post" action="" role="form">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Name" id="vname1" name="vname" required>
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" id="ecity1" name="ecity" placeholder="Your Mail" required>
                    </div>

                    <div class="form-group">
                        <input type="tel" id="mailuser1" name="mailuser" class="form-control" placeholder="Phone" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="rlocation1" name="rlocation" placeholder="Location">

                    </div>

                    <div class="form-group">
                        <input type="submit" id="reqformsubmit" name="rsubmit" value="Submit">
                    </div>
                </form>
            </div>
        </section>


    </aside>
</div>