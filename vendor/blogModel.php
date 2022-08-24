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
            updateCat();
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
    $results1 = DB::query("SELECT * from posts order by created_at desc");

?>
    <?php if (!empty($results1)) { ?>
        <table class="table table-bordered" id="blogdataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids" onclick="checkAll(this.id);" /></th>
                    <th>Title</th>
                    <th>Meta</th>
                    <th>Datetime</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids1" onclick="checkAll(this.id);" /></th>
                    <th>Title</th>
                    <th>Meta</th>
                    <th>Datetime</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($results1 as $row) { ?>
                    <tr id="row_<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>">
                        <td><input type="checkbox" name="allcats" class="pids" id="check_<?php echo $row['id']; ?>" data-id="<?php echo $row['Id']; ?>" onclick="chechThisc(<?php echo $row['id']; ?>,this.id);" /></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['meta']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><a href="addPost.php?id=<?php echo $row['id']; ?>"><i class="fa fa-edit" data-id="<?php echo $row['id']; ?>" onclick="showEditbrandForm(<?php echo $row['id']; ?>);"></i></a>&nbsp;|&nbsp;<i class="fa fa-trash" data-id="<?php echo $row['id']; ?>" onclick="showPostdelAlert(<?php echo $row['id']; ?>);"></i></td>
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
        if (DB::delete("posts", "id=%d", $id)) {
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