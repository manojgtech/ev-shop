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
    #fileupload .error{
        font-size:14px !important;
        color:red;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add products</h6>

        </div>
        <div class="card-body">
            <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
            <div class="table-responsive" id="addprodsdiv">

                <form class="form-horizontal" id="fileupload" action="https://digitalgoldbox.in/evfy/vendor/ProductModel.php" name="add-product" method="POST" enctype="multipart/form-data">
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
                            <a class="nav-link" data-toggle="tab" href="#specs" role="tab" aria-controls="settingsact">Specification</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="basic" role="tabpanel">
                            <fieldset>
                                <legend>
                                    Product basic details
                                </legend>

                                <div class="form-group text-center">
                                    <button id="singlebutton" name="singlebutton" value="add" class="btn btn-primary btn-block">Save</button>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="product_name">PRODUCT NAME</label>
                                    <div class="form-group">
                                        <input id="product_name" name="product_name" placeholder="PRODUCT NAME" class="form-control input-md" type="text" onblur="getslug(this.value,'product_slug');" />
                                        <input type="hidden" name="selfurl" value="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="product_name">PRODUCT Slug</label>
                                    <div class="form-group">
                                        <input id="product_slug" readonly name="product_slug" placeholder="PRODUCT NAME" class="form-control input-md" type="text" />
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
                                                <option value='<?php echo $cat['id']; ?>'><?php echo $cat['name']; ?></option>
                                            <?php
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="product_brands">Brand</label>
                                    <div class="form-group">
                                        <select id="product_ibrands" name="brand" class="form-control">

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="product_brands">Model</label>
                                    <div class="form-group">
                                        <input id="prod-model" name="model" placeholder="Model" class="form-control input-md" type="text" />
                                    </div>
                                </div>



                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="control-label" for="product_description">PRODUCT DESCRIPTION</label>
                                    <div class="form-group">
                                        <textarea class="form-control" id="product_description" name="product_description"></textarea>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">AVAILABLE QUANTITY</label>
                                    <div class="form-group">
                                        <input id="available_quantity" min="0" name="available_quantity" placeholder="AVAILABLE QUANTITY" class="form-control input-md" type="number" />

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
                                        <input id="ex_showroom_price" min="0" name="ex_showroom_rpice" placeholder="Ex Showroom Price" class="form-control input-md" type="number">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">RTO</label>
                                    <div class="form-group">
                                        <input id="rto" min="0" name="rto" placeholder="RTO" class="form-control input-md" type="number">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="available_quantity">Insurance</label>
                                    <div class="form-group">
                                        <input id="insurance" min="0" name="insurance" placeholder="Insurance" class="form-control input-md" type="number">

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
                        <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
                    </div>


                    </fieldset>
                </form>

            </div>
        </div>
    </div>

</div>
</div>


<!-- Footer -->
<script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js">
</script>
<script>
ClassicEditor.create(document.querySelector("#product_description"));

                </script>
<?php require_once("footer.php"); ?>