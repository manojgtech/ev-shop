<?php require_once("header.php"); ?>
<?php
$results1 = DB::query("SELECT * FROM products WHERE status=1");


?>
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
            <h6 class="m-0 font-weight-bold text-primary">Callback Requests</h6>

        </div>
        <div class="card-body">
            <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
            <div class="table-responsive" id="quotesdiv">

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
                <form id="cat-form">

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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

<!-- Footer -->
<div class="modal fade" id="showrequestmodel" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="image-gallery-title">Callback Request</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
            </div>
             <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal">Close
                </button>

                
            </div> 
        </div>
    </div>
</div>
<!-- view model -->

<!-- Modal -->
<div class="modal" id="prodviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- fim Modal-->

<script>
    window.addEventListener('load', function() {

        loadrequests();
        document.title = "Callback Requests";
    });
</script>
<?php require_once("footer.php"); ?>