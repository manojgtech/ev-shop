<div class="col-lg-4 col-md-12">
    <aside class="widget-area">

        <?php
        $catss = DB::query("SELECT id,slug ,name, (select count(*) from products where category_id=vehicles.id ) as prod FROM `vehicles` WHERE status=1");
        ?>
        <section class="widget widget_categories">
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
            <h3 class="widget-title">Battery Type</h3>

            <ul>
                <li><a href="#">Lithium-Ion (Li-On) <span class="post-count">(05)</span></a></li>
                <li><a href="#">Nicle-Metal Hybrid (NiMH) <span class="post-count">(03)</span></a></li>
                <li><a href="#">Lead Acid (SLA) <span class="post-count">(07)</span></a></li>
                <li><a href="#">Ultracapacitor <span class="post-count">(10)</span></a></li>
                <li><a href="#">Zebra (Zero Emissions Batteries Research Activity) <span class="post-count">(1)</span></a></li>
            </ul>
        </section>


        <section class="widget widget_categories">
            <h3 class="widget-title">Charging Time</h3>

            <ul>
                <li><a href="#">3 Hours <span class="post-count">(02)</span></a></li>
                <li><a href="#">2 Hours <span class="post-count">(03)</span></a></li>
                <li><a href="#">1.5 Hours <span class="post-count">(06)</span></a></li>
                <li><a href="#">4 Hours <span class="post-count">(1)</span></a></li>
                <li><a href="#">5 Hours <span class="post-count">(02)</span></a></li>
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