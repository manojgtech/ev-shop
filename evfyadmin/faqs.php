
<?php require_once("header.php"); ?>
<?php


if(isset($_POST['addfaq'])){
    $q=htmlspecialchars($_POST['question']);
    $ans=htmlspecialchars($_POST['answer']);
    DB::insert("faqs",['question'=>$q,'answer'=>$ans]);
    $page = $_SERVER['PHP_SELF'];
    header("Location:$page");
}else if(isset($_POST['editfaq'])){
    $q=htmlspecialchars($_POST['question']);
    $ans=htmlspecialchars($_POST['answer']);
    DB::update("faqs",['question'=>$q,'answer'=>$ans],"id=%i",$id);
    $page = $_SERVER['PHP_SELF'];
    header("Location:$page");
}
$results = DB::query("SELECT * FROM faqs");


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
#accordion-style-1 h1,
#accordion-style-1 a{
    color:#007b5e;
}
#accordion-style-1 .btn-link {
    font-weight: 400;
    color: #007b5e;
    background-color: transparent;
    text-decoration: none !important;
    font-size: 16px;
    font-weight: bold;
	padding-left: 25px;
}

#accordion-style-1 .card-body {
    border-top: 2px solid #007b5e;
}

#accordion-style-1 .card-header .btn.collapsed .fa.main{
	display:none;
}

#accordion-style-1 .card-header .btn .fa.main{
	background: #007b5e;
    padding: 13px 11px;
    color: #ffffff;
    width: 35px;
    height: 41px;
    position: absolute;
    left: -1px;
    top: 10px;
    border-top-right-radius: 7px;
    border-bottom-right-radius: 7px;
	display:block;
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
      <i class="fa fa-plus float-right" data-toggle="modal" data-target="#addfaqModel"></i>
    </div>
    <div class="card-body">
      <div class="spinner-border  loaddiv" id="bloader" style="display:none;"></div>
      <div class="table-responsive" id="clocsdiv">
      <section>
			<div class="row">
				<div class="col-12">
					<h1 class="text-green mb-4 text-center">Frequently Asked Questions</h1>
				</div>
				<div class="col-10 mx-auto">
					<div class="accordion" id="accordionExample">
                        <?php if(count($results)>0){
                            $i=1;
                            foreach($results as $faq){ ?>
						<div class="card">
                            <div class="card-footer">
                                <a href="faqs.php?action=edit&id=<?php echo $faq['id']; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a href="faqs.php?action=trash&id=<?php echo $faq['id']; ?>"><i class="fa fa-trash"></i></a>   
                            </div>
							<div class="card-header" id="heading<?php echo $i; ?>">
								<h5 class="mb-0">
							<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
							  <i class="fa fa-amazon main"></i><i class="fa fa-angle-double-right mr-3"></i><?php echo htmlspecialchars_decode($faq['question']); ?></button>
						  </h5>

							</div>

							<div id="collapse<?php echo $i; ?>" class="collapse  fade" aria-labelledby="headingOne" data-parent="#accordionExample">
								<div class="card-body">
                                <?php echo htmlspecialchars_decode($faq['answer']); ?>
								</div>
                                
							</div>
						</div>
                        <?php }
                          }else{
                              echo "No faq";
                          }
                        ?>
						
					</div>
				</div>	
			</div>
		</section>

      </div>
    </div>
  </div>

</div>
</div>
<!-- End of Main Content -->

<div class="modal fade" tabindex="-1" role="dialog" id="editfaq">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Charging Location</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      <form id="editFaq" method="post" action="faqs.php" name="add">
<div class="form-group">
  <label for="">Question</label>
  <textarea class="form-control" name="question" required>

  </textarea>
</div>

<div class="form-group">
  <label for="">Answer</label>
  <textarea class="form-control" name="answer" required>
      
  </textarea>
</div>
<button type="submit" name="edit" class="btn btn-primary">Add</button>
</form>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add model -->




<div class="modal fade" tabindex="-1" role="dialog" id="addfaqModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add FAQ</h4>
        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
            <form id="addFaq" method="post" action="faqs.php" name="add">
            <div class="form-group">
            <label for="">Question</label>
            <textarea class="form-control" name="question" required>

            </textarea>
            </div>

            <div class="form-group">
            <label for="">Answer</label>
            <textarea class="form-control" name="answer" required>
                
            </textarea>
            </div>
            <button type="submit" name="addfaq" class="btn btn-primary">Add</button>
            </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       
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
    //loadClocations();
  })
</script>


<!-- Footer -->

<?php require_once("footer.php"); ?>
