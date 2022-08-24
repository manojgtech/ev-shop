<?php require_once("header.php"); ?>

<style>
    .btn:focus,
    .btn:active,
    button:focus,
    button:active {
        outline: none !important;
        box-shadow: none !important;
    }

    #image-gallery .modal-footer {
        display: block;
    }

    .thumb {
        margin-top: 15px;
        margin-bottom: 15px;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Notifictions</h6>

        </div>
        <div class="card-body">
            <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
            <div class="table-responsive" id="quotesdiv">
              <?php $msgs=DB::query("select * from notification  where notireciver='Admin' "); ?>
              <ul class="list-group">
              <?php 
               if(count($msgs)){
                   foreach($msgs as $msg){
                       ?>
<li class="list-group-item"><b>User:<?php echo $msg['notiuser']; ?></b> |<b><?php echo $msg['notiuser']; ?></b> @ time <?php echo $msg['time']; ?></li>

                 <?php
                   }
               }
               ?>
                
                  
              
            </div>
        </div>
    </div>

</div>
</div>

<?php require_once("footer.php"); ?>