<?php require_once("header.php"); ?>
<?php
$results1 = DB::query("SELECT * FROM vehicles WHERE status=1");


?>
<?php $links=DB::query("select * from links"); ?>
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
        <form id="link-form-edit">
        <div class='form-group'>
          <label>Search product or categories ,brand</label>
        <input class='form-control searchtxtid2'  id="searchtxtid2" type='text' value='' name='search' required placeholder="search.." onkeyup="searchlink(this.value,2);" />
        
      </div>
      <div class="linkresult"></div>
      <div class='form-group'><label>Or Custom link <span class="ltype"></span></label>
      <input type="hidden" value="" name="type" id="ltype2" />
        <input class='form-control'  type='text' id="custlink2"  name='custom' required placeholder="custom link" />
        
      </div>
          <div class='form-group'>
            <label>Link Title</label><input class='form-control' id="addlinktitle2"  type='text' value='' name='title' required placeholder="Link title" /></div>
          <div class='form-group'><label>Parent Link</label>
          <select id="parentlink2" name="link" class="form-control" >
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
        <input class='form-control'  type='number' id="order2"  name='lorder' required placeholder="link order" />
        <input type="hidden" name="id" id="linkid">
      </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateLink(this);">Update</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add model -->

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
        <input class='form-control searchtxtid'  id="searchtxtid1" type='text' value='' name='search' required placeholder="search.." onkeyup="searchlink(this.value,1);" />
        
      </div>
      <div class="linkresult"></div>
      <div class='form-group'><label>Or Custom link <span class="ltype"></span></label>
      <input type="hidden" value="" name="type" id="ltype1" />
        <input class='form-control custlink'  type='text' id="custlink1"  name='custom' required placeholder="custom link" />
        
      </div>
          <div class='form-group'>
            <label>Link Title</label><input class='form-control addlinktitle' id="addlinktitle1"  type='text' value='' name='title' required placeholder="Link title" /></div>
          <div class='form-group'><label>Parent Link</label>
          <select id="parentlink1" name="link" class="form-control" >
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
        <input class='form-control'  type='number' id="order1"  name='lorder' required placeholder="link order" />
        
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