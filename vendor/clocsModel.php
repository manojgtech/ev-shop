<?php
require_once('dbconnect.php');
if (isset($_POST['func'])) {
    $fun = trim($_POST['func']);
    switch ($fun) {
        case 'editLoc':
            editLoc();
            break;
        case 'viewLoc':
            viewLoc();
            break;
        case 'addLoc':
            addLoc();
            break;
        case 'updateLoc':
            updateLoc();
            break;
        case 'delLoc':
            deleteLoc();
            break;
        case 'showcatbrand':
            showcatbrand();
            break;
    }
}

function editLoc()
{
    $id = $_POST['val'];
    
    $row = DB::queryFirstRow("SELECT * from  charging_locations WHERE id=%i", $id);
    if (empty($row)) {
        echo '0';
    } else {
        echo json_encode($row);
    }
}

function viewLoc()
{
    $results1 = DB::query("SELECT *,charging_locations.id as Id from charging_locations join states on states.id=charging_locations.state join cities on cities.id=charging_locations.city order by charging_locations.id desc");

?>
    <?php if (!empty($results1)) { ?>
        <table class="table table-bordered" id="catdataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids" onclick="checkAll(this.id);" /></th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th><input type="checkbox" name="allcats" id="allids" onclick="checkAll(this.id);" /></th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($results1 as $row) { ?>
                    <tr id="row_<?php echo $row['Id']; ?>" data-id="<?php echo $row['Id']; ?>">
                        <td><input type="checkbox" name="allcats" class="pids" id="check_<?php echo $row['Id']; ?>" data-id="<?php echo $row['Id']; ?>" onclick="chechThisc(<?php echo $row['Id']; ?>,this.id);" /></td>
                        <td><?php echo $row['loc_title']; ?></td>
                        <td><adddress><?php echo $row['address']; ?></address></td>
                        <td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['lat']; ?></td>
                        <td><?php echo $row['lang']; ?></td>
                        <td><i class="fa fa-edit" data-id="<?php echo $row['Id']; ?>" onclick="showloceditform(<?php echo $row['Id']; ?>);"></i>&nbsp;|&nbsp;<i class="fa fa-trash" data-id="<?php echo $row['Id']; ?>" onclick="showDelLoc(<?php echo $row['Id']; ?>);"></i></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-warning">No brand found!</div>
    <?php } ?>


<?php
}

function updateLoc()
{
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $cat = isset($_POST['name']) ? $_POST['name'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $city = isset($_POST['city']) ? $_POST['city'] : null;
    $state = isset($_POST['state']) ? $_POST['state'] : null;
    $lat = isset($_POST['lat']) ? $_POST['lat'] : null;
    $long = isset($_POST['long']) ? $_POST['long'] : null;
    if ($cat != null && $address!=null && $city !=null) {
        $sf = DB::update("charging_locations", ['loc_title' => $cat, 'address' => $address, 'city' => $city,'state'=>$state,'lat'=>$lat,"lang"=>$long],"id=%i",$id);
        
        if ($sf) {
            echo 1;
            die;
        }
    } else echo '0';
    die;
}

function deleteLoc()
{
    $id = $_POST['data'] ?? null;
    if ($id != null) {
        if (DB::delete("charging_locations", "id=%d", $id)) {
            echo 1;
            die;
        }
    }
    echo 0;
    die;
}


function addLoc()
{
    
    $cat = isset($_POST['name']) ? $_POST['name'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $city = isset($_POST['city']) ? $_POST['city'] : null;
    $state = isset($_POST['state']) ? $_POST['state'] : null;
    $lat = isset($_POST['lat']) ? $_POST['lat'] : null;
    $long = isset($_POST['long']) ? $_POST['long'] : null;
    if ($cat != null && $address!=null && $city !=null) {
        $sf = DB::insert("charging_locations", ['loc_title' => $cat, 'address' => $address, 'city' => $city,'state'=>$state,'lat'=>$lat,"lang"=>$long]);
        
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