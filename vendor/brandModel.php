<?php
require_once('dbconnect.php');
if (isset($_POST['func'])) {
    $fun = trim($_POST['func']);
    switch ($fun) {
        case 'editC':
            editBrand();
            break;
        case 'viewC':
            viewCategory();
            break;
        case 'addC':
            addCategory();
            break;
        case 'updateC':
            updateBrand();
            break;
        case 'delC':
            deleteCat();
            break;
        case 'showcatbrand':
            showcatbrand();
            break;
    }
}

function editBrand()
{
    $id = $_POST['id'];
    $cats = DB::query("select * from vehicles where status=1");
    $row = DB::queryFirstRow("SELECT *,brands.id as Id FROM brands inner join vehicles on brands.category=vehicles.id WHERE brands.id=%i", $id);
    if (empty($row)) {
        echo '0';
    } else {
        $ac1 = ($row['status'] == 1) ? 'selected' : '';
        $ac2 = ($row['status'] != 1) ? 'selected' : '';
        $html = "";
        $html .= "<div class='form-group'><label>Category</label><select  class='form-control' name='category' />";
        foreach ($cats as $cat) {
            $html .= "<option value='" . $cat['id'] . "'>" . $cat['name'] . "</option>";
        }
        $html .= "</select></div>";

        $html .= "<div class='form-group'><label>Name</label><input class='form-control' type='text' value='" . $row['brand_name'] . "' name='name' required placeholder='Category'/></div>";
        $html .= "<div class='form-group'><label>Brand Logo</label><img src='../".$row['logo']."'><input class='form-control' type='file'  name='file' required placeholder='Category'/></div>";
        $html .= "<input type='hidden' value='" . $row['Id'] . "' name='id'/>";
        $html .= "<div class='form-group'><label>Status</label><select  class='form-control' name='status' /><option value=1 $ac1>Active</option><option value=0 $ac2>Dective</option></select></div>";
        echo $html;
    }
}

function viewCategory()
{
    $results1 = DB::query("SELECT *,brands.id as Id FROM brands left join vehicles on brands.category=vehicles.id order by brands.id desc");

?>
    <?php if (!empty($results1)) { ?>
        <table class="table table-bordered" id="catdataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids" onclick="checkAll(this.id);" /></th>
                    <th>Brand Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids1" onclick="checkAll(this.id);" /></th>
                    <th>Brand Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($results1 as $row) { ?>
                    <tr id="row_<?php echo $row['Id']; ?>" data-id="<?php echo $row['Id']; ?>">
                        <td><input type="checkbox" name="allcats" class="pids" id="check_<?php echo $row['Id']; ?>" data-id="<?php echo $row['Id']; ?>" onclick="chechThisc(<?php echo $row['Id']; ?>,this.id);" /></td>
                        <td><?php echo $row['brand_name']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><img src="<?php echo '../'.$row['logo']; ?>" class="img-thumbnail" style="width:60px;" ></td>
                        <td><?php echo ($row['status'] == 1) ? 'Active' : 'Disabled'; ?></td>
                        <td><i class="fa fa-edit" data-id="<?php echo $row['Id']; ?>" onclick="showEditbrandForm(<?php echo $row['Id']; ?>);"></i>&nbsp;|&nbsp;<i class="fa fa-trash" data-id="<?php echo $row['Id']; ?>" onclick="showDelBrandAlert(<?php echo $row['Id']; ?>);"></i></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-warning">No brand found!</div>
    <?php } ?>


<?php
}

function updateBrand()
{
    $cat = isset($_POST['name']) ? $_POST['name'] : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $st = $_POST['status'] ?? 1;
    $cats = $_POST['category'];

    
    if ($id != null && $cat!=null) {
        $sf = DB::update("brands", ['brand_name' => $cat,'category'=>$cats, 'status' => $st], "id=%d", $id);
        uploadLogo($id);
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
        if (DB::delete("brands", "id=%d", $id)) {
            echo 1;
            die;
        }
    }
    echo 0;
    die;
}


function addCategory()
{
    
    $cat = isset($_POST['name']) ? $_POST['name'] : null;
    $st = $_POST['status'] ?? 1;
    $cats = $_POST['cats'];

    if ($cat != null && isset($_FILES['file']['name'])) {
        $sf = DB::insert("brands", ['brand_name' => $cat, 'category' => $cats, 'status' => $st]);
        $id=DB::insertId();
        uploadLogo($id);
        if ($sf) {
            echo 1;
            die;
        }
    } else echo '0';
    die;
}

function showcatbrand()
{
    $cat = isset($_POST['data']) ? $_POST['data'] : null;
    if ($cat != null) {
        $brands = DB::query("select * from brands where category=$cat order by id desc");
        if (count($brands) > 0) {
            echo json_encode($brands);
        } else {
            echo '0';
        }
    } else {
        echo '0';
    }
}

function uploadLogo($id){
        $message=true;
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK)
    {
            // get details of the uploaded file
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $fileSize = $_FILES['file']['size'];
            $fileType = $_FILES['file']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
        
            // sanitize file-name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        
            // check if file has one of the following extensions
            $allowedfileExtensions = array('jpg', 'gif', 'png');
        
            if (in_array($fileExtension, $allowedfileExtensions))
            {
            // directory in which the uploaded file will be moved
            $uploadFileDir = '../uploads/brands/';
            $rpath = 'uploads/brands/'.$newFileName;
            $dest_path = $uploadFileDir . $newFileName;
        
            if(move_uploaded_file($fileTmpPath, $dest_path)) 
            {
                $message ='File is successfully uploaded.';
                DB::query("update brands set logo= '".$rpath."' where id= $id");
            }
            else
            {
                $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
            }
            }
            else
            {
            $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            }
        }
        else
        {
            $message = 'There is some error in the file upload. Please check the following error.<br>';
            $message .= 'Error:' . $_FILES['file']['error'];
        }
        return $message;
}
 


?>