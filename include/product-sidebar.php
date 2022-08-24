<div class="col-md-3 productrightsidebar">
    <div class="row sidebarrow">
        <div class="col-md-12 innercolumnproduct pricebreakup">
            <h3>Kinetic Kool E-Cycle</h3>
            <ul>
                <li class="firstproductheading">
                    <label>City</label>
                    <span>Ex-showroom Price</span>
                </li>
                
                <li>
                    <a href="#">Noida</a>
                    <span>Rs. 1.26 - 1.45 Lakh</span>
                </li>
                
                <li>
                    <a href="#">Gurgaon</a>
                    <span>Rs. 1.26 - 1.45 Lakh</span>
                </li>
                
                <li>
                    <a href="#">New Delhi</a>
                    <span>Rs. 1.26 - 1.45 Lakh</span>
                </li>
                
                <li>
                    <a href="#">Lucknow</a>
                    <span>Rs. 1.26 - 1.45 Lakh</span>
                </li>
                
                <li>
                    <a href="#">Ranchi</a>
                    <span>Rs. 1.26 - 1.45 Lakh</span>
                </li>
                
                <li>
                    <a href="#">Noida</a>
                    <span>Rs. 1.26 - 1.45 Lakh</span>
                </li>
                
                <li>
                    <a href="#">Kanpur</a>
                    <span>Rs. 1.26 - 1.45 Lakh</span>
                </li>
                
                <li>
                    <a href="#">Jammu</a>
                    <span>Rs. 1.26 - 1.45 Lakh</span>
                </li>
                
                <li>
                    <a href="#">Orissa</a>
                    <span>Rs. 1.26 - 1.45 Lakh</span>
                </li>
                
                <li class="productselecttag">
                    <a href="#">Select Your City</a>
                </li>
                
            </ul>
        </div>
    </div>
    
    <div class="row sidebarrow">
        <div class="col-md-12 innercolumnproduct">
            <h3>Request a Call Back</h3>
            <form class="form-horizontal" method="post" action="" role="form" id="requestacallbackform">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Your Name" id="vname1" name="vname" required>
                </div>
                
                <div class="form-group">
                    <input type="email" id="mailuser1" class="form-control" name="mailuser" placeholder="Your Mail" required>
                </div>
                
                <div class="form-group">
                    <input type="tel" id="ecity1" name="ecity" class="form-control" placeholder="Phone" required>
                </div>
                
                <div class="form-group">
                    <input type="submit" id="reqformsubmit" name="rsubmit" value="Submit">
                </div>
            </form>
        </div>
    </div>
    
     <div class="row sidebarrow">
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
    </div>
    
    
    <div class="row sidebarrow">
        <div class="col-md-12 innercolumnproduct">
            <h3>Find Your Perfect EV</h3>
            <form class="form-horizontal" method="post" action="" role="form">
                    
                    
                <div class="tab-content">
                        <div class="tab-pane active" id="firsttab">
                            <div class="row">
                            <div class="col-md-12 mostinnercore">
                                <div class="form-group">
                                    <?php $pcats=DB::Query("select * from vehicles"); ?>
                                    <select class="form-control" id="pcatdata1" required onchange="loadcatmake(this.value);">
                                        <option>Select Vehicle Type</option>
                                       <?php foreach($pcats as $cat){ ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mostinnercore">
                                <div class="form-group">
                                    <select class="form-control" id="search-make1" required onchange="showpmodel(this.value);">
                                        <option>Select Make</option>
                                         
                                    </select>
                                </div>
                            </div>
                            
                                <div class="col-md-12 mostinnercore">
                                    <div class="form-group">
                                        <select class="form-control" required id="prod-models1">
                                            <option>Select Model</option>
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mostinnercore">
                                    <input type="button" class="form-control" id="findevbtn" name="searchsubmit" value="Find EV">
                                </div>
                    </div>
                        </div>
                </div>
                </form>
        </div>
    </div>
    
    
    <div class="row sidebarrow">
        <div class="col-md-12 innercolumnproduct">
            <h3>Book a Test Drive</h3>
            <form class="form-horizontal" method="post" action="" role="form">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Your Name" id="rname" name="name" required>
                </div>
                
                <div class="form-group">
                    <input type="email" id=remail" class="form-control" name="email" placeholder="Your Mail" required>
                </div>
                
                <div class="form-group">
                    <input type="tel" id="rphone" name="phone" class="form-control" placeholder="Phone" required>
                </div>
                
                <div class="form-group">
                    <input type="text" id="rcity" name="city" class="form-control" placeholder="City" required>
                </div>
                
                <div class="form-group">
                    <input type="text" id="rlocation" name="address" class="form-control" placeholder="Your Location" required>
                </div>
                
                <div class="form-group">
                <?php $pcats=DB::Query("select * from vehicles"); ?>
                    <select class="form-control" id="pcatdata2" name="category" required onchange="loadcatmake(this.value);">
                                       <option>Select Vehicle Type</option>
                                       <?php foreach($pcats as $cat){ ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                        <?php } ?>
                                    </select>
                </div>
                
                <div class="form-group">
                                    <select class="form-control" id="search-make2" name="brand" required onchange="showpmodel(this.value);">
                                        <option>Select Make</option>
                                         
                                    </select>
                                </div>
                
                 <div class="form-group">
                                        <select class="form-control" name="model" required id="prod-models2">
                                            <option>Select Model</option>
                                            
                                        </select>
                                    </div>
                <input type="hidden" name="selfurl" value="<?php $_SERVER['PHP_SELF'] ?>?product=<?php echo $_GET['product']; ?>">
                <div class="form-group">
                    <input type="submit" id="rsubmit" name="bookdrive" value="Submit">
                </div>
            </form>
        </div>
    </div>
    
    
    
    
</div>

