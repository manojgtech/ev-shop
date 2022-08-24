<?php
require_once('dbconnect.php');
if (isset($_POST['func'])) {
    $fun = trim($_POST['func']);
    switch ($fun) {
        
        
        case 'addUser':
            addUsers();
            break;
        case 'updateUser':
            updateCat();
            break;
        case 'delUser':
            deleteCat();
            break;
        case 'viewUser':
            viewUsers();
            break;
            
    }
}

function editBrand()
{
    $id = $_POST['id'];
    $cats = DB::query("select * from posts where status=1");
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
        $html .= "<input type='hidden' value='" . $row['Id'] . "' name='id'/>";
        $html .= "<div class='form-group'><label>Status</label><select  class='form-control' name='status' /><option value=1 $ac1>Active</option><option value=0 $ac2>Dective</option></select></div>";
        echo $html;
    }
}

function viewUsers()
{
        $sql = "SELECT * from users";
        $results1 = DB::query($sql);

?>
    <?php if (!empty($results1)) { ?>
        <table class="table table-bordered" id="quotedataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids" onclick="checkAll(this.id);" /></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Zip</th>
                    <th>State</th>
                    <th>status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids1" onclick="checkAll(this.id);" /></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Zip</th>
                    <th>State</th>
                  
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($results1 as $row) { ?>
                    <tr id="row_<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>">
                        <td><input type="checkbox" name="allcats" class="pids" id="check_<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>" onclick="chechThisc(<?php echo $row['id']; ?>,this.id);" /></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['mobile']; ?></td>
                        <td><?php echo $row['gender']; ?></td>

                       
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['city']; ?></td>
                        
                            <td><?php echo $row['zip']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        
                        <td><i class="fa fa-eye" data-id="<?php echo $row['id']; ?>" onclick="showviewquotes(<?php echo $row['id']; ?>);"></i>&nbsp;|&nbsp;<i class="fa fa-trash" data-id="<?php echo $row['id']; ?>" onclick="showDelBrandAlert(<?php echo $row['id']; ?>);"></i></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-warning">No user found!</div>
    <?php } ?>


<?php
}

function updateBrand()
{
    $params = [];
    parse_str($_POST['data'], $params);
    $id = isset($params['id']) ? $params['id'] : null;
    $cat = isset($params['name']) ? $params['name'] : null;
    $st = $params['status'] ?? 1;
    if ($id != null) {
        $sf = DB::update("brands", ['name' => $cat, 'status' => $st], "id=%d", $id);
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
    $params = [];
    parse_str($_POST['data'], $params);
    $cat = isset($params['name']) ? $params['name'] : null;
    $st = $params['status'] ?? 1;
    if ($cat != null) {
        $sf = DB::insert("brands", ['name' => $cat, 'status' => $st]);
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
        $brands = DB::query("select * from brands where category=$cat");
        if (count($brands) > 0) {
            echo json_encode($brands);
        } else {
            echo '0';
        }
    } else {
        echo '0';
    }
}

function submitreq()
{

    $data['name'] = $_POST['name'];
    $data['mobile'] = $_POST['ecity'];
    $data['email'] = $_POST['email'];
    $data['address'] = $_POST['rloc'];
    $s = DB::insert('quotation', $data);
    echo $s;
}
function getcities()
{
    $state = $_POST['data'] ?? null;
    $cities = DB::query("select id,city from cities where  state_id=$state");
    $html = "<option>Select City</option>";
    if (count($cities) > 0) {
        foreach ($cities as $city) {

            $html .= "<option value=" . $city['id'] . ">" . $city['city'] . "</option>";
        }
    }
    echo $html;
}

function getlocs()
{
    $city = $_POST['data'] ?? null;
    $cities = DB::query("select * from charging_locations where  city=$city");
    $html = "";
    if (count($cities) > 0) {
        foreach ($cities as $city) {

            $html .= '<div class="col-md-12 col-xs-12 col-lg-12 mapresultsection">
                            <h4>' . $city['loc_title'] . '</h4>
                            <p>' . $city['address'] . '</p>
                            <ul>
                                <li><a target="_blank" href="' . $city['map'] . '">View On Map</a></li>
                                <li><a target="_blank" href="' . $city['map'] . '">Get Direction</a></li>
                            </ul>
                        </div>';
        }
    } else {
        $html .= '<div class="col-md-12 col-xs-12 col-lg-12 mapresultsection">
                            <h4> No station found!</h4>
                           <p>Seach another location</p>
                        </div>';
    }
    echo $html;
}

function viewRequest(){
    $id=isset($_POST['val']) ? $_POST['val']:null;
    if($id!=null){
        $req=DB::query("select * from quotation where id=$id");
        if($req){
            echo json_encode($req);
        }
    } 
    die; 
}
?>