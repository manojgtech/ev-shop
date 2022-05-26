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
        $html .= "<input type='hidden' value='" . $row['Id'] . "' name='id'/>";
        $html .= "<div class='form-group'><label>Status</label><select  class='form-control' name='status' /><option value=1 $ac1>Active</option><option value=0 $ac2>Dective</option></select></div>";
        echo $html;
    }
}

function viewCategory()
{
    $results1 = DB::query("SELECT *,brands.id as Id FROM brands left join vehicles on brands.category=vehicles.id");

?>
    <?php if (!empty($results1)) { ?>
        <table class="table table-bordered" id="catdataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids" onclick="checkAll(this.id);" /></th>
                    <th>Brand Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids1" onclick="checkAll(this.id);" /></th>
                    <th>Brand Name</th>
                    <th>Category</th>
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
    $params = [];
    parse_str($_POST['data'], $params);
    $id = isset($params['id']) ? $params['id'] : null;
    $cat = isset($params['category']) ? $params['category'] : null;
    $name = isset($params['name']) ? $params['name'] : null;
    $st = $params['status'] ?? 1;
    if ($id != null) {
        $sf = DB::update("brands", ['brand_name' => $name,'category'=>$cat, 'status' => $st], "id=%d", $id);
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
    $cats = $params['cats'];
    if ($cat != null) {
        $sf = DB::insert("brands", ['brand_name' => $cat, 'category' => $cats, 'status' => $st]);
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

?>