<?php require_once("header.php"); ?>
<div class="container-fluid">
    <?php
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if ($id != null) {
        $results1 = DB::query("SELECT *,products.id as Id FROM products inner join vehicles on vehicles.id=products.category_id left join brands on brands.id=products.make  where products.id=$id");
        $images = DB::query("SELECT * from product_images where product_id=$id");
    } else {
        echo "product not found";
    }
    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product Details</h6>

            <nav class="nav float-right">
                <a href="addProduct.php" class="nav-link"><i class="fa fa-plus float-right"></i></a>
                <a href="edit-product.php?id=<?php echo $results1[0]['Id']; ?>" class="nav-link"><i class="fa fa-edit float-right"></i></a>
                <a href="products.php" class="nav-link"><i class="fa fa-arrow-left float-right"></i></a>

            </nav>
        </div>
        <div class=" card-body">
            <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
            <div class="modal-header">

                <h4 class="modal-title" id="myModalLabel"><i class="text-muted fa fa-shopping-cart"></i> <strong>#<?php echo $results1[0]['Id']; ?></strong> - <?php echo $results1[0]['title']; ?> </h4>
            </div>
            <div class="modal-body">

                <table class="pull-left col-md-8 ">
                    <tbody>
                        <tr>
                            <td class="h6"><strong>Category</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['name'] ?? 'Not set'; ?></td>
                        </tr>

                        <tr>
                            <td class="h6"><strong>Brand</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['brand_name'] ?? 'Not set'; ?></td>
                        </tr>
                        <tr>
                            <td class="h6"><strong>Model</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['model'] ?? 'Not set'; ?></td>
                        </tr>
                        
                        <tr>
                            <td class="h6"><strong>Stock</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['stock'] ?? '0'; ?></td>
                        </tr>

                        <tr>
                            <td class="h6"><strong>Driving Range</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['driving_range'] ?? 'not set'; ?></td>
                        </tr>

                        <tr>
                            <td class="h6"><strong>Charging Time</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['charging_time'] ?? 'not set'; ?></td>
                        </tr>
                        <tr>
                            <td class="h6"><strong>Battery</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['battery'] ?? 'not set'; ?></td>
                        </tr>
                        <tr>
                            <td class="h6"><strong>Battery Attached</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['battery_attach'] ?? 'not set'; ?></td>
                        </tr>

                        <tr>
                            <td class="h6"><strong>Wheels</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['wheels'] ?? 'not set'; ?></td>
                        </tr>

                        <tr>
                            <td class="h6"><strong>Wheel Size</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['wheel_size'] ?? 'not set'; ?></td>
                        </tr>
                        <tr>
                            <td class="h6"><strong>Tyres</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['tyres'] ?? 'not set'; ?></td>
                        </tr>
                        <tr>
                            <td class="h6"><strong>Motor</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['motor'] ?? 'not set'; ?></td>
                        </tr>
                        <tr>
                            <td class="h6"><strong>Ground Clearance</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['ground_clearance'] ?? 'not set'; ?></td>
                        </tr>
                        <tr>
                            <td class="h6"><strong>Controller</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['controller'] ?? 'not set'; ?></td>
                        </tr>
                        <tr>
                            <td class="h6"><strong>Headlight</strong></td>
                            <td> </td>
                            <td class="h5"><?php echo $results1[0]['headlight'] ?? 'not set'; ?></td>
                        </tr>


                    </tbody>
                </table>


                <div class="col-md-12 card">

                   <div class="card-header"><h3>Product Images</h3></div>
                    
                        <div class="row">
                            <?php $i = 1;
                            foreach ($images as $image) { ?>
                                <div class="col-md-3  <?php echo $i == 1 ? 'active' : ''; ?>">
                                    <img class="d-block img-thumbnail" src="<?php echo '../' . $image['path']; ?>" alt="First slide" onclick="prevImg('<?php echo '../' . $image['path']; ?>');">
                                </div>
                            <?php $i++;
                            } ?>
                        </div>
                       
                </div>

                <div class="clearfix"></div>
                <br />
                <br />
                <h3><b>Description</b></h3>
                <p class="open_info hide card-body border"><?php echo htmlspecialchars_decode($results1[0]['description']); ?></p>
            </div>

            <div class="modal-footer">

                <div class="text-right pull-right col-md-3">
                    Ex Showroom Price: <br />
                    <span class="h3 text-muted"><strong> R<?php echo $results1[0]['ex_showroom_price']; ?> </strong></span></span>
                </div>

                <div class="text-right pull-right col-md-3">
                    RTO: <br />
                    <span class="h3 text-muted"><strong>R<?php echo $results1[0]['rto']; ?></strong></span>
                </div>
                <div class="text-right pull-right col-md-3">
                    Insurance: <br />
                    <span class="h3 text-muted"><strong>R<?php echo $results1[0]['insurance']; ?></strong></span>
                </div>

            </div>
        </div>
    </div>

</div>


<!-- gallery -->
<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="image-gallery-title"></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="image-gallery-image" class="img-responsive col-md-12" src="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
        </button>

        <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
        </button>
      </div>
    </div>
  </div>
</div>
<script>
    document.title = "Product detail page"
    function prevImg(path) {
    
     $("#image-gallery-image").attr("src", path);
    $("#image-gallery").modal('show');

}
</script>