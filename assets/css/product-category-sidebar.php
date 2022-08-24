<div class="col-lg-4 col-md-12 allpagerightsidebar">
    <aside class="widget-area">

        <?php
        $catss = DB::query("SELECT id,slug ,name, (select count(*) from products where category_id=vehicles.id ) as prod FROM `vehicles` WHERE status=1");
        ?>
        <section class="widget widget_categories">
            
            
            
<aside id="filters">
<div id="type">
<h1>Product Categories</h1>
<div class="bump">
<div class="box1">
<input type="checkbox" id="pc1">
<label for="pc1" class="check-box"></label>
<h4>Clothing</h4>
</div>
<div class="box1">
<input type="checkbox" id="pc2">
<label for="pc2" class="check-box"></label>
<h4>Equipment</h4>
</div>
<div class="box1">
<input type="checkbox" id="pc3">
<label for="pc3" class="check-box"></label>
<h4>Trips/Tickets</h4>
</div>
<div class="box1">
<input type="checkbox" id="pc4">
<label for="pc4" class="check-box"></label>
<h4>Social Media</h4>
</div>
<div class="box1">
<input type="checkbox" id="pc5">
<label for="pc5" class="check-box"></label>
<h4>Profile Perks</h4>
</div>
</div>
</div>
</aside>
            
            
            
            
            
            
            
            
            
            <h3 class="widget-title">Product Categories</h3>

            <ul>
                <?php if (count($catss) > 0) {
                    foreach ($catss as $cat) {
                ?>
                        <li><a onclick="filterProd('<?php echo $cat['slug']; ?>','cat','l');"><?php echo $cat['name']; ?> <span class="post-count">(<?php echo $cat['prod']; ?>)</span></a></li>
                <?php

                    }
                }
                ?>
            </ul>
        </section>

        <section class="widget widget_categories rightsidebarproductfilter">
            <h3 class="widget-title">Product Range</h3>

            <div class="price-range-slider">

                <p class="range-value">
                    <input type="text" id="amount" onchange="filterProd(this.value,'price','l');" readonly>
                </p>
                <div id="slider-range" class="range-bar"></div>

            </div>
        </section>


        <section class="widget widget_categories" style="margin-top:30%;">
            
            
            
            <aside id="filters">
<div id="battery-type">
<h1>Battery Type</h1>
<div class="bump">
<div class="box1">
<input type="checkbox" id="bc1">
<label for="bc1" class="check-box"></label>
<h4>Clothing</h4>
</div>
<div class="box1">
<input type="checkbox" id="bc2">
<label for="bc2" class="check-box"></label>
<h4>Equipment</h4>
</div>
<div class="box1">
<input type="checkbox" id="bc3">
<label for="bc3" class="check-box"></label>
<h4>Trips/Tickets</h4>
</div>
<div class="box1">
<input type="checkbox" id="bc4">
<label for="bc4" class="check-box"></label>
<h4>Social Media</h4>
</div>
<div class="box1">
<input type="checkbox" id="bc5">
<label for="bc5" class="check-box"></label>
<h4>Profile Perks</h4>
</div>
</div>
</div>
</aside>
            
            
            
            <h3 class="widget-title">Battery Type</h3>
            <?php
        $bprods= DB::query("SELECT battery , (select count(*) from products  where prd.battery=battery ) as prod FROM `products` as prd  WHERE status=1 group by prd.battery ");
        
        ?>
            <ul>
                <?php if(count($bprods)){
                  foreach($bprods as $prod){    
                ?>
                <li><a href="#"><?php echo ucwords($prod['battery']); ?> <span class="post-count">(<?php echo $prod['prod'] ?? 0; ?>)</span></a></li>
               <?php }
                }
                ?>
            </ul>
        </section>


        <section class="widget widget_categories">
            
            
                <aside id="filters">
<div id="charging-time">
<h1>Charging Time</h1>
<div class="bump">
<div class="box1">
<input type="checkbox" id="ct1">
<label for="ct1" class="check-box"></label>
<h4>Clothing</h4>
</div>
<div class="box1">
<input type="checkbox" id="ct2">
<label for="ct2" class="check-box"></label>
<h4>Equipment</h4>
</div>
<div class="box1">
<input type="checkbox" id="ct3">
<label for="ct3" class="check-box"></label>
<h4>Trips/Tickets</h4>
</div>
<div class="box1">
<input type="checkbox" id="ct4">
<label for="ct4" class="check-box"></label>
<h4>Social Media</h4>
</div>
<div class="box1">
<input type="checkbox" id="ct5">
<label for="ct5" class="check-box"></label>
<h4>Profile Perks</h4>
</div>
</div>
</div>
</aside>
            
            
            <h3 class="widget-title">Charging Time</h3>
            <?php
        $bprods= DB::query("SELECT charging_time, (select count(*) from products where prd.charging_time=charging_time ) as prod FROM `products` as prd  WHERE status=1  group by prd.charging_time ");
        
        ?>
            <ul>
            <?php if(count($bprods)){
                  foreach($bprods as $prod){    
                ?>
                <li><a href="#"><?php echo ucwords($prod['charging_time']); ?> <span class="post-count">(<?php echo $prod['prod'] ?? 0; ?>)</span></a></li>
                <?php }
                }
                ?>
            </ul>
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