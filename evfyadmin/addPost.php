<?php require_once("header.php"); ?>
<?php
$edit=false;
$id = isset($_GET['id']) ? $_GET['id'] : null;
if($id!=null){
    $post=DB::query("select * from posts where id=%i",$id);
    $edit=true;
    $blog=$post[0];
}
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
            <h6 class="m-0 font-weight-bold text-primary">Blogs</h6>
            <a href="blog.php"><i class="fa fa-arrow-left float-right"></i></a>
        </div>
        <div class="card-body">
            <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
            <form class="form" action="savepost.php" method="post" enctype="multipart/form-data">
                <div class="contact-form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="fname">Post Title:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo isset($blog['title']) ? $blog['title'] : ''; ?>" id="bpostname" placeholder="Enter title" name="title" onblur="blogslug(this.value);">
                        </div>
                    </div>
                    
                    <?php
                    if ($edit == true) {
                    ?>
                        <input type="hidden" name="postid" value="<?php echo $blog['id']; ?>">
                    <?php } ?>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Slug:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo isset($blog['slug']) ? $blog['slug'] : ''; ?>" id="postslug" placeholder="slug" name="slug">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="comment">Post Content:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" id="content" name="postbody"><?php echo isset($blog['postbody']) ? htmlspecialchars_decode($blog['postbody']) : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="comment">Post Image:</label>
                        <div class="col-sm-10">
                            <div class="file-loading">
                                <input type="file" class="file" value="<?php echo isset($blog['image']) ? $blog['image'] : ''; ?>" id="input-702" name="files" data-theme="fas">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Meta description:</label>
                        <div class="col-sm-10">
                            <input type="text"  class="form-control" value="<?php echo isset($blog['meta']) ? $blog['meta'] : ''; ?>" id="meta" placeholder="meta" name="meta">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" name="submit-post" value="<?php echo $edit == true ? 'edit' : 'add'; ?>" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

</div>
</div>

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


<script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js">
</script>
<script>
ClassicEditor.create(document.querySelector("textarea"));

                </script>
<script>
   
    window.addEventListener('load', function() {
        loadBlog();
        document.title = "Create blog posts";
    });
</script>
<?php
if ($edit === true) {
?>
    <script>
        $(document).ready(function() {
            $("#input-702").fileinput({
                theme: 'fa',
                uploadUrl: "/file-upload-batch/1",
                uploadAsync: false,
                minFileCount: 1,
                maxFileCount: 1,
                overwriteInitial: true,
                initialPreview: [
                    "<?php echo isset($blog['image']) ? $blog['image'] : ''; ?>"
                ],
                initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
                initialPreviewFileType: 'image', // image is the default and can be overridden in config below

            });
        });
    </script>
<?php } else { ?>
    <script>
        $(document).ready(function() {
            $("#input-702").fileinput({
                theme: 'fa',
                uploadUrl: "/file-upload-batch/1",
                uploadAsync: false,
                minFileCount: 1,
                maxFileCount: 1,
                overwriteInitial: true,
                initialPreview: [],
                initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
                initialPreviewFileType: 'image', // image is the default and can be overridden in config below

            });
        });
    </script>
<?php } ?>
<?php require_once("footer.php"); ?>