<?php require_once("header.php"); ?>
<?php
$cats = DB::query("SELECT * FROM vehicles WHERE status=1");

?>




<style>
    .nav.nav-tabs {
        float: left;
        display: block;
        margin-right: 20px;
        border-bottom: 0;
        border-right: 1px solid #ddd;
        padding-right: 15px;
    }

    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        background: #ccc;
    }

    .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #007bff !important;
        border-color: transparent !important;
    }

    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: 0rem !important;
        border-top-right-radius: 0rem !important;
    }

    .tab-content>.active {
        display: block;

        min-height: 165px;
    }

    .nav.nav-tabs {
        float: left;
        display: block;
        margin-right: 20px;
        border-bottom: 0;
        border-right: 1px solid transparent;
        padding-right: 15px;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit products</h6>
            <nav class="nav float-right">
                <a href="addProduct.php" class="nav-link"><i class="fa fa-plus float-right"></i></a>

                <a href="products.php" class="nav-link"><i class="fa fa-arrow-left float-right"></i></a>

            </nav>
        </div>
        <?php

        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id == null) {
            echo "<div class='alert alert-danger'>Id is required!</div>";
            die;
        }
        $prod = DB::query("select * from products where id=$id");
        if (empty($prod)) {
            echo "<div class='alert alert-danger'>Not found!</div>";
            die;
        } else {
            $pcats = DB::query("select * from vehicles where id=" . $prod[0]['category_id']);
            $pbrand = DB::query("select * from brands where id=" . $prod[0]['make']);
            $cc=$prod[0]['category_id'];
            $brands = DB::query("SELECT * FROM brands WHERE status=1 and category=$cc");
            $pimgs = DB::query("select * from product_images where product_id=" . $prod[0]['id']);
        }
        
        
        ?>


        <div class="card-body">
            <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
            <div class="table-responsive" id="addprodsdiv">

                <form class="form-horizontal" id="fileupload" action="https://digitalgoldbox.in/evfy/vendor/ProductModel.php" name="edit-product" method="POST" enctype="multipart/form-data">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#basic" role="tab" aria-controls="home">Basic Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pricing" role="tab" aria-controls="profile">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#images" role="tab" aria-controls="messages">Images</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#specs" role="tab" aria-controls="settings">Specification</a>
                        </li>
                    </ul>
                    <input type="hidden" name="selfurl" value="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="id" value="<?php echo $prod[0]['id']; ?>">
                    <div class="tab-content">
                        <div class="tab-pane active" id="basic" role="tabpanel">
                            <fieldset>
                                <legend>
                                    Product basic details
                                </legend>
                                <div class="form-group text-center">
                                    <button id="singlebutton" name="editbutton" class="btn btn-primary btn-block">Save</button>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="product_name">PRODUCT NAME</label>
                                    <div class="form-group">
                                        <input id="product_name" name="product_name" value="<?php echo $prod[0]['title']; ?>" placeholder="PRODUCT NAME" class="form-control input-md" type="text" onblur="getslug(this.value,'product_slug');">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="product_name">PRODUCT Slug</label>
                                    <div class="form-group">
                                        <input id="product_slug" readonly name="product_slug" value="<?php echo $prod[0]['slug']; ?>" placeholder="PRODUCT NAME" class="form-control input-md"  type="text" value= />
                                        <input type="hidden" name="selfurl" value="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="control-label" for="product_categorie">PRODUCT CATEGORY</label>
                                    <div class="form-group">
                                        <select id="product_categories" name="product_categories" class="form-control" onchange="showprodbrand(this.id);">
                                            <?php foreach ($cats as $cat) {
                                            ?>
                                                <option value='<?php echo $cat['id']; ?>' <?php echo $prod[0]['category_id'] == $cat['id'] ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
                                            <?php
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="product_brands">Brand</label>
                                    <div class="form-group">
                                        <select id="product_ibrands" name="brand"  class="form-control">
                                        <?php foreach ($brands as $cat) {
                                            ?>
                                                <option value='<?php echo $cat['id']; ?>' <?php echo $prod[0]['make'] == $cat['id'] ? 'selected' : ''; ?>><?php echo $cat['brand_name']; ?></option>
                                            <?php
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="product_brands">Model</label>
                                    <div class="form-group">
                                        <input id="prod-model" name="model" value="<?php echo $prod[0]['model']; ?>" placeholder="Model" value="" class="form-control input-md" type="text" />
                                    </div>
                                </div>




                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="control-label" for="product_description">PRODUCT DESCRIPTION</label>
                                    <div class="form-group">
                                        <textarea class="form-control" id="product_description" name="product_description"><?php echo htmlspecialchars_decode($prod[0]['description']); ?></textarea>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">AVAILABLE QUANTITY</label>
                                    <div class="form-group">
                                        <input id="available_quantity" min="0" value="<?php echo htmlspecialchars_decode($prod[0]['stock']); ?>" name="available_quantity" placeholder="AVAILABLE QUANTITY" class="form-control input-md" type="number">

                                    </div>
                                </div>
                            </fieldset>


                        </div>
                        <div class="tab-pane" id="pricing" role="tabpanel">
                            <fieldset>
                                <legend>Product Pricing</legend>
                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Ex Showroom Price</label>
                                    <div class="form-group">
                                        <input id="ex_showroom_price" min="0" name="ex_showroom_rpice" value="<?php echo $prod[0]['ex_showroom_price']; ?>" placeholder="Ex Showroom Price" class="form-control input-md" type="number">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">RTO</label>
                                    <div class="form-group">
                                        <input id="rto" min="0" name="rto" placeholder="RTO" <?php echo $prod[0]['rto']; ?> class="form-control input-md" type="number">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Insurance</label>
                                    <div class="form-group">
                                        <input id="insurance" min="0" name="insurance" placeholder="Insurance" <?php echo $prod[0]['insurance']; ?> class="form-control input-md" type="number">

                                    </div>
                                </div>



                            </fieldset>

                        </div>
                        <div class="tab-pane" id="images" role="tabpanel">
                            <!-- File Button -->
                            <fieldset>
                                <legend>
                                    Product Images
                                </legend>
                                <div class="form-group">                                        

                                    <div class="form-group">
                                        <label for="">Product Gallery</label>
                                       
                                        <div class="file-loading">
                                            <input type="file" class="file" id="test_upload" name="files[]" multiple data-theme="fas">
                                        </div>
                                        <div id="errorBlock" class="help-block"></div>
                                    </div>

                            </fieldset>

                        </div>
                        <div class="tab-pane" id="specs" role="tabpanel">
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Specification Required ?</label>
                                    <div class="form-group">
                                        <input id="specs_required" name="specs_required" class="form-control input-md" value="yes" type="radio" onchange="toggleSpecs(this.value);"> Yes
                                        <input id="specs_required" name="specs_required" class="form-control input-md" value="no" type="radio" checked onchange="toggleSpecs(this.value);"> No

                                    </div>
                                </div>
                            </fieldset>
                            <fieldset id="specsDiv" style="display:none;">
                                <legend>
                                    Vehicle Features
                                </legend>
                                <!-- Text input-->

                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Driving Range</label>
                                    <div class="form-group">
                                        <input id="driving_range" min="0" name="driving_range" placeholder="Driving Range" class="form-control input-md" type="number">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Wheel Type</label>
                                    <div class="form-group">
                                        <input id="wheel_type" min="0" name="wheel_type" placeholder="Wheel Type" class="form-control input-md" type="text">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Wheel Size</label>
                                    <div class="form-group">
                                        <input id="wheel_size" min="0" name="wheel_size" placeholder="Wheel Size" class="form-control input-md" type="number">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Tyres</label>
                                    <div class="form-group">
                                        <input id="tyres" name="tyres" placeholder="Tyres" class="form-control input-md" type="text">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Motor</label>
                                    <div class="form-group">
                                        <input id="motor" name="driving_range" placeholder="Tyres" class="form-control input-md" type="text">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Ground Clearance</label>
                                    <div class="form-group">
                                        <input id="ground_clearance" name="ground_clearance" placeholder="Ground Clearance" class="form-control input-md" type="text">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Loading Capacity</label>
                                    <div class="form-group">
                                        <input id="loading_capacity" name="loading_capacity" placeholder="Loading Capacity" class="form-control input-md" type="text">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Controller</label>
                                    <div class="form-group">
                                        <input id="controller" name="controller" placeholder="Controller" class="form-control input-md" type="text">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Breaking System</label>
                                    <div class="form-group">
                                        <input id="breaking_system" name="breaking_system" placeholder="Breaking System" class="form-control input-md" type="text">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Battery</label>
                                    <div class="form-group">
                                        <input id="battery" name="battery" placeholder="Battery" class="form-control input-md" type="text">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Battery Attach</label>
                                    <div class="form-group">
                                        <input id="battery_attach" name="battery_attach" placeholder="Battery Attach" class="form-control input-md" type="text">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Headlight</label>
                                    <div class="form-group">
                                        <input id="headlight" name="headlight" placeholder="Headlight" class="form-control input-md" type="text">
                                    </div>
                                </div>
                            </fieldset>

                        </div>
                    </div>


                    <div class="form-group text-center">
                        <button id="singlebutton" name="editbutton" class="btn btn-primary">Save</button>
                    </div>


                    </fieldset>
                </form>

            </div>
        </div>
    </div>

</div>
</div>

<script>
        $(document).ready(function() {
            $("#test_upload").fileinput({
                theme: 'fas',
                uploadUrl: "../vendor/ProductModel.php?func=addpic&pid=<?php echo $prod[0]['id']; ?>",
                uploadAsync: false,
                minFileCount: 1,
                maxFileCount: 1,
                overwriteInitial: true,
                initialPreview: [
<?php
foreach($pimgs as $img){
    ?>
"<img src='<?php echo "../".$img['path']; ?>'>",
    <?php
}

?>
                    
                ],
initialPreviewConfig: [
    <?php
foreach($pimgs as $img){
    ?>
{caption:'<?php echo $prod[0]['title']; ?>',description:'',url:'<?php echo "../vendor/ProductModel.php?func=rempic&id=".$img['id']; ?>',key:<?php echo $img['id']; ?>},
    <?php
}

?>
],

            }).on('fileuploaded', function(event, previewId, index, fileId) {
        console.log('File Uploaded', 'ID: ' + fileId + ', Thumb ID: ' + previewId);
    }).on('fileuploaderror', function(event, data, msg) {
        console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
    }).on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
        console.log('File Batch Uploaded', preview, config, tags, extraData);
    });
        });
    </script>
<!-- Footer -->
<script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js">
</script>
<script>
ClassicEditor.create(document.querySelector("#product_description"));

                </script>
<?php require_once("footer.php"); ?>