<?php require_once("header.php"); ?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
$edit = false;
$cats = DB::query("SELECT * FROM blog_category WHERE type=1 order by posted desc");
if ($id != null) {
    $edit = true;
    $blog = DB::query("select * from posts where id=$id");
    $blog = $blog[0];
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
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lname">Post Category:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="blogcat" id="catblog">
                                <option value="0">Uncategorized</option>
                                <?php if (count($cats) > 0) {
                                    foreach ($cats as $cat) {
                                ?>
                                        <option value="<?php echo $cat['id'] ?>" <?php echo ($cat['id'] == $blog['category_ids']) ? 'selected' : ''; ?>><?php echo $cat['category']; ?></option>

                                <?php }
                                } ?>

                            </select>
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
<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="image-gallery-title"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="image-gallery-image" class="img-responsive col-md-12" src="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
                </button>

                <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
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
<script src="https://cdn.tiny.cloud/1/4ot0e0i9cw0ytt2epho0unod9mztur57rinkz1yo7byoxatz/tinymce/6/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        height: 500,
        menubar: false,
        plugins: [
            'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
            'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
            'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help',

        valid_elements: '*[*]',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });

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