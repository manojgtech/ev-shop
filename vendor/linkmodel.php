<?php
require_once('dbconnect.php');
if (isset($_POST['func'])) {
    $fun = trim($_POST['func']);
    switch ($fun) {
        case 'editL':
            editLink();
            break;
        case 'viewL':
            viewLink();
            break;
        case 'addL':
            addLink();
            break;
        case 'updateL':
            updateLink();
            break;
        case 'delL':
            deleteLink();
            break;
        case 'findCatbrand':
            findCatbrand();
            break;
        case 'searchLinks':
            findLinks();
            break;
    }
}

function editLink()
{
    $id = $_POST['val'];
    $row = DB::queryFirstRow("SELECT * FROM links WHERE id=%i", $id);
    
    if (empty($row)) {
        echo '0';
    } else {
       echo json_encode($row);
    }
}

function viewLink()
{
    $results1 = DB::query("SELECT s.*,m.title as parent_title FROM links s left join links m on m.id=s.parent  order by s.id desc");
    
?>
    <?php if (!empty($results1)) { ?>
        <table class="table table-bordered" id="catdataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids" onclick="checkAll(this.id);" /></th>
                    <th>Title</th>
                    <th>Parent</th>
                    <th>Link</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><input type="checkbox" name="allcats" id="allids1" onclick="checkAll(this.id);" /></th>
                    <th>Title</th>
                    <th>Parent</th>
                    <th>Link</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($results1 as $row) { ?>
                    <tr id="row_<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>">
                        <td><input type="checkbox" name="allcats" class="pids" id="check_<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>" onclick="chechThisc(<?php echo $row['id']; ?>,this.id);" /></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['parent_title'] ?? 'No parent'; ?></td>
                        <td><?php echo $row['url']; ?></td>
                        <td><?php echo $row['linkorder']; ?></td>
                        <td><i class="fa fa-edit" data-id="<?php echo $row['id']; ?>" onclick="showLinkEditForm(<?php echo $row['id']; ?>);"></i>&nbsp;|&nbsp;<i class="fa fa-trash" data-id="<?php echo $row['id']; ?>" onclick="showLinkDelAlert(<?php echo $row['id']; ?>);"></i></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-warning">No link found!</div>
    <?php } ?>


<?php
}

function updateCat()
{
    

    $cat = isset($_POST['name']) ? $_POST['name'] : null;
    $slug = isset($_POST['slug']) ? $_POST['slug'] : null;
    $st = isset($_POST['status']) ? $_POST['status'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    
    if (isset($_FILES['file']['name'])) {
        move_uploaded_file($_FILES['file']['tmp_name'], "../assets/img/categories/" . $_FILES['file']['name']);
        $img = $_FILES['file']['name'];
    }
    if ($cat != null && $slug != null && $id!=null) {
        $sf = DB::update("vehicles", ['name' => $cat, 'slug' => $slug, 'image' => $img, 'status' => $st],"id=%d", $id);
        if ($sf) {
            echo  json_encode(['msg' => 1]);
            die;
        }
    } else
        echo  json_encode(['msg' => 0]);


}

function deleteCat()
{
    $id = $_POST['data'] ?? null;
    if ($id != null) {
        if (DB::delete("vehicles", "id=%d", $id)) {
            echo 1;
            die;
        }
    }
    echo 0;
    die;
}


function addCategory()
{
    $cat = isset($_POST['name']) ? $_POST['name'] : '';
    $slug = isset($_POST['slug']) ? $_POST['slug'] : '';
    $st = isset($_POST['status']) ? $_POST['status'] : '';

    if (isset($_FILES['file']['name'])) {
        move_uploaded_file($_FILES['file']['tmp_name'], "../assets/img/categories/" . $_FILES['file']['name']);
        $img = $_FILES['file']['name'];
    }
    if ($cat != null && $slug != null) {
        $sf = DB::insert("vehicles", ['name' => $cat, 'slug' => $slug, 'image' => $img, 'status' => $st]);
        if ($sf) {
            echo  json_encode(['msg' => 1]);
            die;
        }
    } else
        echo  json_encode(['msg' => 0]);

    die;
}


function findCatbrand()
{
    $val = $_POST['value'];
    $brands = DB::query("select * from brands where category=$val and status=1");
    $html = "<option>Select Make</option>";
    if (count($brands) > 0) {
        foreach ($brands as $brand) {
            $html .= "<option value='" . $brand['id'] . "'>" . $brand['brand_name'] . "</option>";
        }
    }
    echo $html;
}

function findCatmodel()
{
    $val = $_POST['value'];
    $brands = DB::query("select model from products where make=$val");
    //echo DB::last_query();

    $html = "<option>Select Model</option>";
    if (count($brands) > 0) {
        foreach ($brands as $brand) {
            $html .= "<option value='" . $brand['model'] . "'>" . $brand['model'] . "</option>";
        }
    }
    echo $html;
}

function findLinks(){
    $v=htmlspecialchars(trim($_POST['val']));
    $n=$_POST['n'];
    if(strlen($v)>2){
        $res=DB::query("(select title  ,id ,slug, 'Product' as type from products  where products.title like '%".$v."%') union (select name as title ,id ,slug,'Category' as type from vehicles  where  vehicles.name like '%".$v."%') union (select brand_name as title ,id ,brand_name as  slug,'Brand' as type from brands  where  brands.brand_name like '%".$v."%') ");
       // echo DB::lastQuery();
       $html="<ul class='list-group'>";
        if(count($res)>0){
            foreach($res as $it){
                $html=$html."<li class='list-group-item' data-type=".$it['type']." data-id=".$it['id']." data-slug=".$it['slug']." id='sres_".$it['id']."' onclick='feedit(this.id,".$n.");'>".ucwords($it['title'])." (".$it['type'].")</li>";
            }
        }else{
            $html.="<li class='list-group-item'>No Result</li>";
        }
        $html.="</ul>";
    }
    echo $html;
}

function addLink(){
    $title=isset($_POST['title']) ? $_POST['title']:null;
    $par=isset($_POST['link']) ? $_POST['link']:0;
    $link=isset($_POST['custom']) ? $_POST['custom']:null;
    $linkorder=isset($_POST['lorder']) ? $_POST['lorder']:null;
    $type=isset($_POST['type']) ? $_POST['type']:null;
    if($title!=null && $link!=null){
        DB::insert("links",['title'=>$title,'url'=>$link,'parent'=>$par,'type'=>$type,'linkorder'=>$linkorder]);
        echo 1;
        die;
    }
    echo 0;

}

function deleteLink(){
    $id=$_POST['data'];
    echo DB::query("delete from links where id=$id");
}

function updateLink(){
    
        $title=isset($_POST['title']) ? $_POST['title']:null;
        $par=isset($_POST['link']) ? $_POST['link']:0;
        $link=isset($_POST['custom']) ? $_POST['custom']:null;
        $linkorder=isset($_POST['lorder']) ? $_POST['lorder']:null;
        $type=isset($_POST['type']) ? $_POST['type']:null;
        $id=isset($_POST['id']) ? $_POST['id']:null;
        if($title!=null && $link!=null && $id!=null){
            DB::update("links",['title'=>$title,'url'=>$link,'parent'=>$par,'type'=>$type,'linkorder'=>$linkorder],"id=$id");
            echo 1;
            die;
        }
        echo 0;
    
    
}
?>