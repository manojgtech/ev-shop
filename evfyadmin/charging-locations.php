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
  <?php 
$states=DB::query("select * from states");


?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Charging Locations</h6>
      <i class="fa fa-plus float-right" data-toggle="modal" data-target="#addChargingModel"></i>
    </div>
    <div class="card-body">
      <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
      <div class="table-responsive" id="clocsdiv">

      </div>
    </div>
  </div>

</div>
</div>
<!-- End of Main Content -->
<div class="modal fade" tabindex="-1" role="dialog" id="editclocspopup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Charging Location</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      <form id="updateStations">
<div class="form-group">
  <label for="">Name</label>
  <input type="text" class="form-control" id="locname" name="name">
</div>
<div class="form-group">
  <label for="">Address</label>
  <input type="text" class="form-control" id="locaddress" name="address">
</div>
<div class="form-group">
  <label for="">State</label>
  <select class="form-control" name="state" id="locstate" onchange="selectCity(this.value,'loccity');">
   <?php
  foreach($states as $state){

?>


<option value="<?php echo $state['id']; ?>"><?php echo $state['name']; ?></option>
<?php } ?>
</select>
<input type="hidden" name="id" id="locid" >
</div>
<div class="form-group">
  <label for="">City</label>
  <select class="form-control" name="city" id="loccity" id="charge_city">
   
</select>
</div>
<div class="form-group">
  <label for="">Location Latitude</label>
  <input type="text" id="loclat" class="form-control" name="lat">
</div>

<div class="form-group">
  <label for="">Location Longitude</label>
  <input type="text" id="loclong" class="form-control" name="long">
</div>

  </form>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateLoc(this);">Update</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add model -->




<div class="modal fade" tabindex="-1" role="dialog" id="addChargingModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Charging Location</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
         <form id="addStations">
<div class="form-group">
  <label for="">Name</label>
  <input type="text" class="form-control" name="name">
</div>
<div class="form-group">
  <label for="">Address</label>
  <input type="text" class="form-control" name="address">
</div>
<div class="form-group">
  <label for="">State</label>
  <select class="form-control" name="state" onchange="selectCity(this.value,'charge_city');">
   <?php
  foreach($states as $state){

?>

<option value="<?php echo $state['id']; ?>"><?php echo $state['name']; ?></option>
<?php } ?>
</select>
</div>
<div class="form-group">
  <label for="">City</label>
  <select class="form-control" name="city" id="charge_city">
   
</select>
</div>
<div class="form-group">
  <label for="">Location Latitude</label>
  <input type="text" class="form-control" name="lat">
</div>

<div class="form-group">
  <label for="">Location Longitude</label>
  <input type="text" class="form-control" name="long">
</div>


</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick="addStations(this);">Add</button>
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
    loadClocations();
  })
</script>
<!-- Footer -->
<?php require_once("footer.php"); ?>