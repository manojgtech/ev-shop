<?php require_once("header.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Brands</h6>
      <i class="fa fa-plus float-right" data-toggle="modal" data-target="#addbrandModel"></i>
    </div>
    <div class="card-body">
      <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
      <div class="table-responsive" id="branddiv">

      </div>
    </div>
  </div>

</div>
</div>
<!-- End of Main Content -->
<div class="modal fade" tabindex="-1" role="dialog" id="editbrandspopup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Brand</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p class="brandalert"></p>
        <form id="brand-form-edit">

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="editBrand(this);">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add model -->
<div class="modal fade" tabindex="-1" role="dialog" id="addbrandModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Category</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      <p class="brandalert"></p>
        <form id="cat-form-add">
          <?php $vehicles = DB::query("select * from vehicles") ?>

          <div class='form-group'><label>Category</label>
            <select name="cats" class="form-control">
              <?php if (count($vehicles) > 0) {
                foreach ($vehicles as $row) {
              ?>
                  <option value="<?php echo $row['id'];  ?>"><?php echo $row['name']; ?></option>
              <?php
                }
              } ?>


            </select>
          </div>
          <div class='form-group'><label>Brand Name</label><input class='form-control' type='text' value='' name='name' required placeholder="brand name" /></div>
          <div class='form-group'><label>Status</label><select class='form-control' name='status' />
            <option value=1>Active</option>
            <option value=0>Dective</option></select>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick="addbrand(this);">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->






<!-- endmodal -->




<div class="modal fade" tabindex="-1" role="dialog" id="deletebrandpopup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Brand</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Do you want to delete it?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="delpopup_btn" data-id="" onclick="delbrand();">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
  window.addEventListener('load', function() {
    loadBrands();
  })
</script> <!-- Footer -->
<?php require_once("footer.php"); ?>