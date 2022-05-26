<div class="slidersearchform col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <span>find your electric cars</span>
                <form class="form-horizontal" method="" role="">
                    <div class="form-group">
                        <input type="form-control" id="searchcar" name="searchcar" placeholder="Type to select car name, e.g. Tata Nexon">
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>


<div class="afterslidernewsearchform">
    <div class="container">
        <h2 class="slidercapheading">Are You Looking For EV</h2>
        <div class="row">
            <div class="col-md-2 blank-space"></div>
            <div class="col-md-8 innersearchcolumn">
                <form class="form-horizontal" method="post" action="search.php" role="form">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#firsttab" data-toggle="tab">Find an EV</a></li>
                        <!--
                        <li><a href="#secondtab" data-toggle="tab">EV Reviews</a></li>
                        <li><a href="#thirdtab" data-toggle="tab">EV Accessories</a></li>
-->
                    </ul>
                    <?php $cats = DB::query("select * from vehicles where status=1");

                    ?>
                    <div class="tab-content">
                        <div class="tab-pane active" id="firsttab">
                            <div class="row">
                                <div class="col-md-3 mostinnercore">
                                    <div class="form-group">
                                        <?php 
                            $icat=0;
                           if(isset($_POST['category']) && $_POST['category']!='Select Vehicle Type'){
                               $icat=$_POST['category'];  
                           }
                                        ?>
                                        <select class="form-control" id="search-cat1" name="category" required onchange="loadcatmake(this.value);">
                                            <option>Select Vehicle Type</option>
                                            <?php if (count($cats)) {

                                                foreach ($cats as $cat) {
                                            ?>

                                                    <option value="<?php echo $cat['id']; ?>" <?php echo ($icat==$cat['id']) ? 'selected':''; ?>><?php echo $cat['name']; ?></option>

                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mostinnercore">
                                <?php 
                            $make=0;
                           if(isset($_POST['make']) && $_POST['make']!='Select Make'){
                               $make=$_POST['make'];  
                           }
                        ?>   
                                <?php $brands=DB::query("select * from brands");
                                    
                                    
                                    ?>
                                    <div class="form-group">
                                        <select class="form-control" id="search-make1" name="make" onchange="showpmodel(this.value);">
                                        <option>Select Make</option>
                                        <?php if(count($brands)>0){
                                           foreach($brands as $brand){   
                                         ?>
                                         <option value='<?php echo $brand['id']; ?>' <?php echo  ($make==$brand['id']) ? 'selected':''; ?>><?php echo $brand['brand_name']; ?></option>
                                         <?php }
                                             }
                                        ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mostinnercore">
                                    <?php $models=DB::query("select  distinct model from products");
                        
                                    ?>
                                          <?php 
                            $model=0;
                           if(isset($_POST['model']) && $_POST['model']!='Select Model'){
                               $make=$_POST['model'];  
                           }
                        ?>
                                    <div class="form-group">
                                        <select class="form-control" name="model"  id="prod-models1">
                                            <option>Select Model</option>
                                            <?php if(count($brands)>0){
                                           foreach($models as $model){   
                                         ?>
                                         <option value='<?php echo $model['id']; ?>' <?php echo ($make==$model['model']) ? 'selected':''; ?>><?php echo $model['model']; ?></option>
                                         <?php }
                                             }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mostinnercore">
                                    <input type="submit" class="form-control" id="searchbumit" name="searchsubmit" value="Find EV">
                                </div>
                            </div>
                        </div>
                        <!--
                    <div class="tab-pane" id="secondtab">
                             <div class="row">
                           
                            
                            <div class="col-md-4 mostinnercore">
                                <div class="form-group">
                                    <select class="form-control" required>
                                        <option>Select Make</option>
                                        <option>Tata</option>
                                        <option>Mahindra</option>
                                        <option>Mercedes Benz</option>
                                        <option>Hundai</option>
                                        <option>MG Hector</option>
                                        <option>Volkswagen</option>
                                    </select>
                                </div>
                            </div>
                            
                                <div class="col-md-4 mostinnercore">
                                    <div class="form-group">
                                        <select class="form-control" required>
                                            <option>Select Model</option>
                                            <option>Model 1</option>
                                            <option>Model 1</option>
                                            <option>Model 1</option>
                                            <option>Model 1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mostinnercore">
                                    <input type="submit" class="form-control" id="searchbumit" name="searchsubmit" value="Find EV">
                                </div>
                    </div>
                    </div>
                    <div class="tab-pane" id="thirdtab">
                        <div class="row">
                            <div class="col-md-3 mostinnercore">
                                <div class="form-group">
                                    <select class="form-control" required>
                                        <option>Select Vehicle Type</option>
                                        <option>EV Cars</option>
                                        <option>Low Speed EV's</option>
                                        <option>High Speed EV's</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mostinnercore">
                                <div class="form-group">
                                    <select class="form-control" required>
                                        <option>Select Make</option>
                                        <option>Tata</option>
                                        <option>Mahindra</option>
                                        <option>Mercedes Benz</option>
                                        <option>Hundai</option>
                                        <option>MG Hector</option>
                                        <option>Volkswagen</option>
                                    </select>
                                </div>
                            </div>
                            
                                <div class="col-md-3 mostinnercore">
                                    <div class="form-group">
                                        <select class="form-control" required>
                                            <option>Select Model</option>
                                            <option>Model 1</option>
                                            <option>Model 1</option>
                                            <option>Model 1</option>
                                            <option>Model 1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mostinnercore">
                                    <input type="submit" class="form-control" id="searchbumit" name="searchsubmit" value="Find EV">
                                </div>
                    </div>
                    </div>
-->
                    </div>
                </form>
            </div>
            <div class="col-md-2 blank-space"></div>
        </div>
    </div>
</div>