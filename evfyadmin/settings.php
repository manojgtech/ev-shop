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
            <h6 class="m-0 font-weight-bold text-primary">Settings</h6>

        </div>
        <div class="card-body">
            <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
            <div class="table-responsive" id="quotesdiv">
              
                   <div class="col-md-4">
                       <h3>Change password</h3>
                       <form action="settings.php" method="post">
                       <div class="form-group">
                           <label for="">Password</label>
                           <input type="password" class="form-control" name="password" placeholder="passowrd">
                      
                       <input type="password" class="form-control" name="resetpassword" placeholder="confirm passowrd">
</div>
                       <button type="submit" name="chanepwd" class="btn">Change</button>
                       </form>
                   </div>

                   <div class="col-md-4">
                       <h3>Cart or Catelogue</h3>
                       <form action="settings.php" method="post">
                       <div class="form-group">
                           <label for="">Password</label>
                           <input type="radio" name="cart" value="cart">
                           <input type="radio" name="cart" value="list" checked>
                       </div>
                       <button type="submit" name="cartorlist" class="btn">Change</button>
                       </form>
                   </div>
              
            </div>
        </div>
    </div>

</div>
</div>

<?php require_once("footer.php"); ?>