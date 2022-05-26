<?php
require_once('dbconnect.php');
if (isset($_REQUEST['func'])) {
    $fun = trim($_REQUEST['func']);
    switch ($fun) {
        case 'editProd':
            editProduct();
            break;
        case 'viewProd':
            viewProduct();
            break;
        case 'addC':
            viewCategory();
            break;
        case 'updateC':
            updateCat();
            break;
        case 'delC':
            deleteCat();
            break;
        case 'getProduct':
            getProduct();
            break;
        case 'bestProduct':
            markbestProduct();
            break;
        case 'markfeatured':
            markfeatured();
            break;
        case 'shopPage':
            shopPage();
            break;
        case 'markPrd':
            markPrd();
            break;
            case 'rempic':
                DeletePic();
                break;
                case 'addpic':
                    uploadPic();
                    break;
        default:
            addProduct();
    }
}



if (isset($_POST['singlebutton'])) {
    
    addProduct();
}
if (isset($_POST['editbutton'])) {
    
    updateProduct();
}


function addProduct()
{
    $cats = null;
    $data['title'] = isset($_POST['product_name']) ? htmlspecialchars(trim($_POST['product_name'])) : null;
    $data['description'] = isset($_POST['product_description']) ? htmlspecialchars($_POST['product_description']) : null;
    $data['stock'] = isset($_POST['available_quantity']) ? $_POST['available_quantity'] : 0;
    $data['rto'] = isset($_POST['rto']) ? $_POST['rto'] : 0;
    $data['ex_showroom_price'] = isset($_POST['ex_showroom_rpice']) ? $_POST['ex_showroom_rpice'] : 0;
    $data['insurance'] = isset($_POST['insurance']) ? $_POST['insurance'] : 0;
    $data['driving_range'] = isset($_POST['driving_range']) ? $_POST['driving_range'] : 0;
    $data['wheels'] = isset($_POST['wheel_type']) ? $_POST['wheel_type'] : null;
    $data['wheel_size'] = isset($_POST['wheel_size']) ? $_POST['wheel_size'] : null;
    $data['tyres'] = isset($_POST['tyres']) ? $_POST['tyres'] : null;
    $data['ground_clearance'] = isset($_POST['ground_clearance']) ? $_POST['ground_clearance'] : null;
    $data['loading_capacity'] = isset($_POST['loading_capacity']) ? $_POST['loading_capacity'] : 0;
    $data['controller'] = isset($_POST['controller']) ? $_POST['controller'] : null;
    $data['controller'] = isset($_POST['breaking_system']) ? $_POST['breaking_system'] : null;
    $data['battery'] = isset($_POST['battery']) ? $_POST['battery'] : null;
    $data['slug'] = isset($_POST['product_slug']) ? $_POST['product_slug'] : null;
    $data['model'] = isset($_POST['model']) ? $_POST['model'] : null;
    $data['make'] = isset($_POST['brand']) ? $_POST['brand'] : null;
    $data['battery_attach'] = isset($_POST['battery_attach']) ? $_POST['battery_attach'] : null;
    $data['headlight'] = isset($_POST['headlight']) ? $_POST['headlight'] : null;
    if (isset($_POST['product_categories'])) {
        $cats =  $_POST['product_categories'];
        $data['category_id'] = $cats;
    }
    if ($data['title'] != null  && $data['slug'] != null && $data['model'] != null && $data['make']) {
        $prods = DB::insert("products", $data);
        echo DB::lastQuery();
        $id = DB::insertId();
        uploadGallery($id);
?>

        <script>
            alert("Product added successfully");
            window.location = "../evfyadmin/products.php";
        </script>
    <?php
    } else {
        $url = $_POST['selfurl'] . "?er=1";
        header("Location:$url");
    }
}
function updateProduct()
{
    $cats = null;
    $id = isset($_POST['id']) ? htmlspecialchars(trim($_POST['id'])) : null;
    $data['title'] = isset($_POST['product_name']) ? htmlspecialchars(trim($_POST['product_name'])) : null;
    $data['description'] = isset($_POST['product_description']) ? htmlspecialchars($_POST['product_description']) : null;
    $data['stock'] = isset($_POST['available_quantity']) ? $_POST['available_quantity'] : 0;
    $data['rto'] = isset($_POST['rto']) ? $_POST['rto'] : 0;
    $data['ex_showroom_price'] = isset($_POST['ex_showroom_rpice']) ? $_POST['ex_showroom_rpice'] : 0;
    $data['insurance'] = isset($_POST['insurance']) ? $_POST['insurance'] : 0;
    $data['driving_range'] = isset($_POST['driving_range']) ? $_POST['driving_range'] : 0;
    $data['wheels'] = isset($_POST['wheel_type']) ? $_POST['wheel_type'] : null;
    $data['wheel_size'] = isset($_POST['wheel_size']) ? $_POST['wheel_size'] : null;
    $data['tyres'] = isset($_POST['tyres']) ? $_POST['tyres'] : null;
    $data['ground_clearance'] = isset($_POST['ground_clearance']) ? $_POST['ground_clearance'] : null;
    $data['loading_capacity'] = isset($_POST['loading_capacity']) ? $_POST['loading_capacity'] : 0;
    $data['controller'] = isset($_POST['controller']) ? $_POST['controller'] : null;
    $data['controller'] = isset($_POST['breaking_system']) ? $_POST['breaking_system'] : null;
    $data['battery'] = isset($_POST['battery']) ? $_POST['battery'] : null;
    $data['slug'] = isset($_POST['product_slug']) ? $_POST['product_slug'] : null;
    $data['model'] = isset($_POST['model']) ? $_POST['model'] : null;
    $data['make'] = isset($_POST['brand']) ? $_POST['brand'] : null;
    $data['battery_attach'] = isset($_POST['battery_attach']) ? $_POST['battery_attach'] : null;
    $data['headlight'] = isset($_POST['headlight']) ? $_POST['headlight'] : null;
    if (isset($_POST['product_categories'])) {
        $cats =  $_POST['product_categories'];
        $data['category_id'] = $cats;
    }
    if ($data['title'] != null  && $data['slug'] != null && $data['model'] != null && $data['make']) {
        $prods = DB::update("products", $data,"id=$id");
        //echo DB::lastQuery();
        $id = DB::insertId();
        uploadGallery($id);

?>

        <script>
            alert("Product updated successfully! ");
            window.location = "../evfyadmin/products.php";
        </script>
    <?php
    } else {
        $url = $_POST['selfurl'] . "?id= $id&er=1";
        header("Location:$url");
    }
}
function uploadGallery($id)
{

    if (isset($_FILES['files']['tmp_name'])) {
        $num_files = count($_FILES['files']['tmp_name']);
        for ($x = 0; $x < $num_files; $x++) {
            $image = str_replace(" ","-",$_FILES['files']['name'][$x]);
            if (!is_uploaded_file($_FILES['files']['tmp_name'][$x])) {
                $messages[] = $image . ' No file uploaded."<br>"';
            }
            $img = "uploads/products/" . $image;
            $default = ($x == 0) ? 1 : 0;
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$x], "../uploads/products/" . $image)) {
                DB::insert("product_images", ['product_id' => $id, 'path' => $img, 'is_default' => $default]);
                $messages[] = $image . ' uploaded';
            }
            //copy("images/".$image, '../images/'.$image);

        }
    }
    return 1;
}

function editCategory()
{
    $id = $_POST['id'];
    $row = DB::queryFirstRow("SELECT * FROM vehicles WHERE id=%i", $id);
    if (empty($row)) {
        echo '0';
    } else {
        $ac1 = ($row['status'] == 1) ? 'selected' : '';
        $ac2 = ($row['status'] != 1) ? 'selected' : '';
        $html = "<div class='form-group'><label>Name</label><input class='form-control' type='text' value='" . $row['name'] . "' name='name' required placeholder='Category'/></div>";
        $html .= "<input type='hidden' value='" . $row['id'] . "' name='id'/>";
        $html .= "<div class='form-group'><label>Status</label><select  class='form-control' name='status' /><option value=1 $ac1>Active</option><option value=0 $ac2>Dective</option></select></div>";
        echo $html;
    }
}

function viewProduct()
{
    $results1 = DB::query("SELECT *,products.id as Id FROM products inner join vehicles on vehicles.id=products.category_id left join brands on brands.id=products.make left join product_images on product_images.product_id=products.id  group by products.id order by updated_at desc");
    //print_r($results1);
    ?>
    <?php if (!empty($results1)) { ?>
        <table class="table table-bordered" id="prodsdataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids" onclick="checkAll(this.id);" /></th>
                    <th>Product Title</th>
                    <th>Best selling</th>
                    <th>Featured</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Showroom Price</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids1" onclick="checkAll(this.Id);" /></th>
                    <th>Product Title</th>
                    <th>Best selling</th>
                    <th>Featured</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Showroom Price</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($results1 as $row) { ?>
                    <tr id="row_<?php echo $row['id']; ?>" data-id="<?php echo $row['Id']; ?>">
                        <td><input type="checkbox" name="allcats" class="pids" id="check_<?php echo $row['Id']; ?>" data-id="<?php echo $row['id']; ?>" onclick="chechThisc(<?php echo $row['id']; ?>,this.id);" /></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><i id="best_<?php echo $row['Id']; ?>" data-val="<?php echo $row['best']; ?>" class='fa fa-<?php echo ($row['best'] == 1) ? 'eye' : 'eye-slash'; ?>' onclick="markitf(<?php echo $row['Id']; ?>,2);"></i></td>
                        <td><i id="featured_<?php echo $row['Id']; ?>" data-val="<?php echo $row['featured']; ?>" onclick="markitf(<?php echo $row['Id']; ?>,1);" class='fa fa-<?php echo ($row['featured'] == 1) ? 'eye' : 'eye-slash'; ?>'></i></td>

                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['brand_name']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td><?php echo $row['ex_showroom_price']; ?>Rs</td>
                        <td><?php echo ($row['status'] == 1) ? 'Active' : 'Disabled'; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><a href="product-details.php?id=<?php echo $row['Id']; ?>"><i class="fa fa-eye" data-id="<?php echo $row['Id']; ?>"></i></a>&nbsp;|&nbsp;<a href="edit-product.php?id=<?php echo $row['Id']; ?>"><i class="fa fa-edit" data-id="<?php echo $row['Id']; ?>"></i></a>&nbsp;|&nbsp;<i class="fa fa-trash" data-id="<?php echo $row['Id']; ?>" onclick="showPDelAlert(<?php echo $row['Id']; ?>);"></i></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-warning">No products found!</div>
    <?php } ?>


<?php
}

function updateCat()
{
    $params = [];
    parse_str($_POST['data'], $params);
    $id = isset($params['id']) ? $params['id'] : null;
    $cat = isset($params['name']) ? $params['name'] : null;
    $st = $params['status'] ?? 1;
    if ($id != null) {
        $sf = DB::update("vehicles", ['name' => $cat, 'status' => $st], "id=%d", $id);
        if ($sf) {
            echo 1;
            die;
        }
    } else echo '0';
    die;
}
function deleteCat()
{
    $id = $_POST['data'] ?? null;
    if ($id != null) {
        if (DB::delete("products", "id=%d", $id)) {
            echo 1;
            die;
        }
    }
    echo 0;
    die;
}

function getProduct()
{
}

function markbestProduct()
{
    $ids = isset($_POST['data']) ? $_POST['data'] : null;
    if ($ids != null) {
        $ids = array_unique(json_decode($ids, true));
        $ids = implode(",", $ids);


        DB::query("update products set best=1 where id in ($ids)");
    }
}
function markfeatured()
{
    $ids = isset($_POST['data']) ? $_POST['data'] : null;
    if ($ids != null) {
        $ids = array_unique(json_decode($ids, true));
        $ids = implode(",", $ids);


        DB::query("update products set featured=1 where id in ($ids)");
    }
}


function shopPage()
{

    if (isset($_POST['data'])) {
        $filter = $_POST['data']['filter'];
        $val = htmlspecialchars(trim($_POST['data']['value']));
        $sort = $_POST['data']['sort'];
        
        if ($filter == "cat") {
            $cats = DB::query("select * from vehicles where slug='$val'");
            $catid = $cats[0]['id'];
            $where = "where u.category_id=$catid";
        } if ($filter == "brand") {
            $cats = DB::query("select * from brands where brand_name='$val'");
            $catid = $cats[0]['id'];
            $where = "where u.make=$catid";
        }else if($filter=='price'){
            $vals=explode(":",$val);
            $where = " where u.ex_showRoom_price between $val[0] and $val[1] ";
        } else if($filter=='search'){
            
            $vals=htmlspecialchars(trim($val));
            if($vals!=""){
                $where = " where title like '%".$vals."%' ";
            }else{
                $where = "  ";
            }
            

        } else {
            $where = "";
        }
        $sortby=" order by created_at desc ";
        if($sort=='l'){
            $sortby=" order by created_at desc ";
        }
        if($sort=='o'){
            $sortby=" order by created_at asc ";
        }
        if($sort=='lp'){
            $sortby=" order by ex_showroom_price asc ";
        }
        if($sort=='hp'){
            $sortby=" order by ex_showroom_price desc ";
        }

        $prods = DB::query("SELECT u.*, p.* FROM products AS u LEFT JOIN product_images AS p ON p.id = ( SELECT id FROM product_images AS p2 WHERE p2.product_id = u.id LIMIT 1 ) $where $sortby   limit 15;");
    } else {
        $prods = DB::query("SELECT u.*, p.* FROM products AS u LEFT JOIN product_images AS p ON p.id = ( SELECT id FROM product_images AS p2 WHERE p2.product_id = u.id LIMIT 1 ) order by created_at desc limit 15;");
    }




?>


    <?php

    if (count($prods) > 0) {
        $i = 0;
        foreach ($prods as $prod) {
    ?>
            <div class="col-lg-12 col-md-12">
                <div class="single-courses-list-box mb-30 innerproductlistcolumn">
                    <div class="box-item">
                        <div class="courses-image">
                            <?php $img1 = $prod['path']; ?>
                            <div class="image bg-1" style="background-image:url('<?php echo $img1; ?>');">
                                <img src="<?php echo $prod['path']; ?>" alt="image">

                                <a href="product-details.php?product=<?php echo $prod['slug']; ?>" class="link-btn"></a>

                            </div>
                        </div>

                        <div class="courses-desc">
                            <div class="courses-content productlistingdetails">

                                <h3><a href="product-details.php?product=<?php echo $prod['slug']; ?>" class="d-inline-block"><?php echo $prod['title']; ?></a></h3>

                                <div class="courses-rating">
                                    <div class="review-stars-rated">
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                    </div>

                                    <div class="rating-total">
                                        5.0 (1 rating)
                                    </div>
                                </div>

                                <p><?php echo substr(htmlspecialchars_decode($prod['description']), 0, 100) . '...'; ?></p>
                                <ul class="upcomingfirstullist">
                                    <li><i class="fa fa-flash"></i><span><?php echo $prod['driving_range']; ?>*</span><label>Per Charge</label></li>
                                    <li><i class="fa fa-flash"></i><span><?php echo $prod['warranty']; ?>*</span><label>of Warranty</label></li>
                                    <li><i class="fa fa-flash"></i><span><?php echo $prod['charging_time']; ?>*</span><label>For Full Charge</label></li>
                                    <li><i class="fa fa-flash"></i><span><?php echo $prod['battery']; ?>*</span><label>Battery</label></li>
                                </ul>
                            </div>
                            <!-- row -->
                            <div class="courses-box-footer listingpagecolumn">
                                <ul>
                                    <li class="students-number">
                                        <a onclick="requestmodal1('requestmodal1',1,<?php echo $prod['id']; ?>)">Enquire Now</a>
                                        <!--<i class='bx bx-user'></i> 10 students-->
                                    </li>

                                    <li class="courses-lesson">
                                        <!--<i class='bx bx-time'></i> 6 Hour-->
                                        <a  onclick="requestmodal1('requestmodal1',2,<?php echo $prod['id']; ?>);">Request a Call Back</a>
                                    </li>

                                    <!--
<li class="courses-price">
<i>₹</i>780
</li>
-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php $i++;
        }
    }else{
        echo "<p class='text-warning'>No product found!</p>";
    }
}

function markPrd()
{
    $id = $_POST['product'];
    $val = ($_POST['val'] == 1) ? 0 : 1;
    $type = $_POST['type'] ?? 1;
    if ($type == 1) {
        echo $p = DB::query("update products set featured=$val where id=$id");
    } else {
        echo $p = DB::query("update products set best=$val where id=$id");
    }
}

function DeletePic(){
    $id=isset($_GET['id']) ? $_GET['id']:null;
    if($id!=null){
        echo $p = DB::query("delete from product_images where id=$id");
    }
}
function upload() {
    
    $preview = $config = $errors = [];
    $targetDir = "../uploads/products/";
    if (!file_exists($targetDir)) {
        @mkdir($targetDir);
    }
    $fileBlob = 'files';                      // the parameter name that stores the file blob
    if (isset($_FILES[$fileBlob])) {
        
        $file = $_FILES[$fileBlob]['tmp_name'][0];  // the path for the uploaded file chunk 
        $fileName = $_FILES[$fileBlob]['name'][0];        // you receive the file name as a separate post data
        
        
        $fileSize = $_FILES[$fileBlob]['size'];          // you receive the file size as a separate post data
        $fileId = $_POST['fileId'];              // you receive the file identifier as a separate post data
        $index =  1;          // the current file chunk index
        $totalChunks = 1;     // the total number of chunks for this file
        $targetFile = $targetDir.'/'.$fileName;  // your target file path
        if ($totalChunks > 1) {                  // create chunk files only if chunks are greater than 1
            $targetFile .= '_' . str_pad($index, 4, '0', STR_PAD_LEFT); 
        } 
        $thumbnail = 'unknown.jpg';
        if(move_uploaded_file($file, $targetFile)) {
            // get list of all chunks uploaded so far to server
            $chunks = glob("{$targetDir}/{$fileName}_*"); 
            // check uploaded chunks so far (do not combine files if only one chunk received)
            $allChunksUploaded = $totalChunks > 1 && count($chunks) == $totalChunks;
            if ($allChunksUploaded) {           // all chunks were uploaded
                $outFile = $targetDir.'/'.$fileName;
                // combines all file chunks to one file
                combineChunks($chunks, $outFile);
            } 
            // if you wish to generate a thumbnail image for the file
            $targetUrl = getThumbnailUrl($targetDir, $fileName);
            // separate link for the full blown image file
            $zoomUrl = 'https://digitalgoldbox.in/evfy/uploads/products/' . $fileName;
            return [
                'chunkIndex' => $index,         // the chunk index processed
                'initialPreview' => $targetUrl, // the thumbnail preview data (e.g. image)
                'initialPreviewConfig' => [
                    [
                        'type' => 'image',      // check previewTypes (set it to 'other' if you want no content preview)
                        'caption' => $fileName, // caption
                        'key' => $fileId,       // keys for deleting/reorganizing preview
                        'fileId' => $fileId,    // file identifier
                        'size' => $fileSize,    // file size
                        'zoomData' => $zoomUrl, // separate larger zoom data
                    ]
                ],
                'append' => true
            ];
        } else {
            return [
                'error' => 'Error uploading chunk 1'
            ];
        }
    }
    return [
        'error' => 'No file found'
    ];
}
 
// combine all chunks
// no exception handling included here - you may wish to incorporate that
function combineChunks($chunks, $targetFile) {
    // open target file handle
    $handle = fopen($targetFile, 'a+');
    
    foreach ($chunks as $file) {
        fwrite($handle, file_get_contents($file));
    }
    
    // you may need to do some checks to see if file 
    // is matching the original (e.g. by comparing file size)
    
    // after all are done delete the chunks
    foreach ($chunks as $file) {
        @unlink($file);
    }
    
    // close the file handle
    fclose($handle);
}
 
// generate and fetch thumbnail for the file
function getThumbnailUrl($path, $fileName) {
    // assuming this is an image file or video file
    // generate a compressed smaller version of the file
    // here and return the status
    $sourceFile = $path . '/' . $fileName;
    $targetFile = $path . '/thumbs/' . $fileName;
    //
    // generateThumbnail: method to generate thumbnail (not included)
    // using $sourceFile and $targetFile
    //
    
        return 'https://digitalgoldbox.in/evfy/uploads/products/' . $fileName; // return the original file
    
}


function uploadPic(){
    header('Content-Type: application/json'); // set json response headers
$outData = upload(); // a function to upload the bootstrap-fileinput files
echo json_encode($outData); // return json data
exit();
}

?>