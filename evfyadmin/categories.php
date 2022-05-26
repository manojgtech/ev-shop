<?php require_once("header.php"); ?>
<?php
$results1 = DB::query("SELECT * FROM vehicles WHERE status=1");


?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Vehicle Categories</h6>
      <i class="fa fa-plus float-right" data-toggle="modal" data-target="#addcatModel"></i>
    </div>
    <div class="card-body">
      <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
      <div class="table-responsive" id="catdiv">

      </div>
    </div>
  </div>

</div>
</div>
<!-- End of Main Content -->
<div class="modal fade" tabindex="-1" role="dialog" id="editcatspopup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Category</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      <p class="catalert"><p>
        <form id="cat-form-edit">

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="editCat(this);">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add model -->
<div class="modal fade" tabindex="-1" role="dialog" id="addcatModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Category</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p class="catalert"><p>
        <form id="cat-form-add">
          <div class='form-group'><label>Name</label><input class='form-control' onblur="getslug(this.value,'titleslug');" type='text' value='' name='name' required placeholder="category name" /></div>
          <div class='form-group'><label>Slug</label><input class='form-control' id="titleslug" type='text' value='' readonly name='slug' required placeholder="slug" /></div>
          <div class='form-group'><label>Image</label><input class='form-control' id="catfile1" type='file' value='' name='file' required placeholder="image" /></div>
          <div class='form-group'><label>Status</label><select class='form-control' name='status' />
            <option value=1>Active</option>
            <option value=0>Dective</option></select>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick="addcat(this);">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->






<!-- endmodal -->




<div class="modal fade" tabindex="-1" role="dialog" id="deletecatspopup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Category</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Do you want to delete it?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="delpopup_btn" data-id="" onclick="delcat();">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
  window.addEventListener('load', function() {
    loadCategory();
  })
</script>
<!-- Footer -->
<?php require_once("footer.php"); ?>