<?php require_once("header.php"); ?>
<?php
$results1 = DB::query("SELECT * FROM vehicles WHERE status=1");


?>
<style>
.linkresult ul {
    z-index: 999;
    /* top: 2px; */
    /* position: absolute; */
    margin-top: -14px;
    max-height: 120px;
    overflow-y: scroll;
    position: absolute;
    width: 461px;
}
.linkresult ul li:hover{
  background:blue;
  color:#eee;
}
  </style>
<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Menu Links</h6>
      <i class="fa fa-plus float-right" data-toggle="modal" data-target="#addLinkModel"></i>
    </div>
    <div class="card-body">
      <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
      <div class="table-responsive" id="linksdiv">

      </div>
    </div>
  </div>

</div>
</div>
<!-- End of Main Content -->
<div class="modal fade" tabindex="-1" role="dialog" id="editlinkspopup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Menu</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      <p class="catalert"><p>
        <form id="cat-form-edit">

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="editCat(this);">Update</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add model -->
<?php $links=DB::query("select * from links"); ?>
<div class="modal fade" tabindex="-1" role="dialog" id="addLinkModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Menu</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p class="catalert"><p>
        <form id="link-form-add">
        <div class='form-group'>
          <label>Search product or categories ,brand</label>
        <input class='form-control'  id="searchtxtid" type='text' value='' name='search' required placeholder="search.." onkeyup="searchlink(this.value);" />
        
      </div>
      <div class="linkresult"></div>
      <div class='form-group'><label>Or Custom link <span class="ltype"></span></label>
      <input type="hidden" value="" name="type" id="ltype" />
        <input class='form-control'  type='text' id="custlink"  name='custom' required placeholder="custom link" />
        
      </div>
          <div class='form-group'>
            <label>Link Title</label><input class='form-control' id="addlinktitle"  type='text' value='' name='title' required placeholder="Link title" /></div>
          <div class='form-group'><label>Parent Link</label>
          <select id="parentlink" name="link" class="form-control" >
          <option>No parent</option>
           <?php if(count($links)>0){
              foreach($links as $link){
          ?>
          <option value="<?php echo $link['id']; ?>"><?php echo $link['title']; ?></option>

      <?php

              }

           } ?>
           </select>
        </div>
        <div class='form-group'><label>Link Order in Menu</label>
        <input class='form-control'  type='number' id="order"  name='lorder' required placeholder="link order" />
        
      </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick="addlink(this);">Add Link</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->






<!-- endmodal -->




<div class="modal fade" tabindex="-1" role="dialog" id="showLinkDelAlert">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Link</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Do you want to delete it?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="dellpopup_btn" data-id="" onclick="dellink();">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
  window.addEventListener('load', function() {
    loadLinks();
  })
</script>
<!-- Footer -->
<?php require_once("footer.php"); ?>