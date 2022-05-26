<?php
require_once('dbconnect.php');
if (isset($_POST['func'])) {
    $fun = trim($_POST['func']);
    switch ($fun) {
        case 'editC':
            editBrand();
            break;
        case 'showrequests':
            viewRequest();
            break;
        case 'addC':
            addCategory();
            break;
        case 'updateC':
            updateCat();
            break;
        case 'delC':
            deleteCat();
            break;
        case 'submitreq':
            submitreq();
            break;
        case 'viewC':
            viewCategory();
            break;
        case 'getlocs':
            getlocs();
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

function viewCategory()
{
    $type = $_POST['type'] ?? 1;
    if ($type == 1) {
        $sql = "SELECT * from quotation where type=$type order by created_at desc";
    } else {
        $sql = "SELECT quotation.*,products.title from quotation left join products on product_id=products.id where type=$type order by created_at desc";
    }
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
                    <?php if ($type == 1) { ?>
                        <th>Address</th>
                    <?php } else { ?>
                        <th>Product</th>
                    <?php } ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids1" onclick="checkAll(this.id);" /></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <?php if ($type == 1) { ?>
                        <th>Address</th>
                    <?php } else { ?>
                        <th>Product</th>
                    <?php } ?>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($results1 as $row) { ?>
                    <tr id="row_<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>">
                        <td><input type="checkbox" name="allcats" class="pids" id="check_<?php echo $row['id']; ?>" data-id="<?php echo $row['Id']; ?>" onclick="chechThisc(<?php echo $row['id']; ?>,this.id);" /></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['mobile']; ?></td>

                        <?php if ($type == 1) { ?>
                            <td><?php echo $row['address']; ?></td>
                        <?php } else { ?>
                            <td><?php echo $row['title']; ?></td>
                        <?php } ?>
                        <td><i class="fa fa-eye" data-id="<?php echo $row['id']; ?>" onclick="showviewquotes(<?php echo $row['id']; ?>);"></i>&nbsp;|&nbsp;<i class="fa fa-trash" data-id="<?php echo $row['id']; ?>" onclick="showDelBrandAlert(<?php echo $row['id']; ?>);"></i></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-warning">No post found!</div>
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
                                <li><a target="_blank" href="">Get Direction</a></li>
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