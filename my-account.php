<?php
 session_start();
 ?>
<!doctype html>
<html lang="zxx">


<?php include 'include/style.php';?>

<body>

<?php include 'include/preloader.php';?>

<?php include 'include/navigation.php';?>
<?php

if(!isset($_SESSION['userid'])){
   Header("Location:login.php");
 }

 if(isset($_POST['callback'])){
   $name=$_POST['name'];
   $email=$_POST['email'];
   $phone=$_POST['phone'];
   $subject=$_POST['subject'];
   $msg=$_POST['message'];
   DB::insert("quotation",['name'=>$name,'subject'=>$subject,'email'=>$email,'mobile'=>$phone,'comment'=>$msg,"type"=>1]);
   ?>
    <script>
      alert("Callback request submited");
      window.location='<?php echo $_SERVER['PHP_SELF']; ?>'
    </script>
   <?php
 }
?>
<?php

if(isset($_POST['profileform'])){
  $fname=$_POST['sfname'];
  $lname=$_POST['slanme'];
  $email=$_POST['semail'];
  $phone=$_POST['sphone'];
  $address=$_POST['sadd'];
  $fb=$_POST['facebookid'];
  $tw=$_POST['twitterid'];
  $insta=$_POST['instagramid'];
  $link=$_POST['linkedid'];
  DB::update("users",['first_name'=>$fname,'last_name'=>$lname,'address'=>$address,'email'=>$email,'mobile'=>$phone,'fblink'=>$fb,'twlink'=>$tw,'instaid'=>$insta,'linkdid'=>$link],'id=%i',$_SESSION['userid']);
  ?>
   <script>
     alert("Profile updated");
     window.location='<?php echo $_SERVER['PHP_SELF']; ?>'
   </script>
  <?php
}

?>

<?php include 'include/websiteoverlaydontdel.php';?>
<?php 
 $usr=DB::queryFirstRow("select * from users where id=%i",$_SESSION['userid']);
?>
<!-- Start Page Title Area -->
<div class="page-title-area item-bg1 jarallax" data-jarallax='{"speed": 0.3}'>
<div class="container">
<div class="page-title-content">
<ul>
<li><a href="./">Home</a></li>
<li>My Account</li>
</ul>
<h2>My Account</h2>
</div>
</div>
</div>
<!-- End Page Title Area -->

<!-- Start My Account Area -->
<section class="my-account-area pt-100 pb-30">
<div class="container">
<div class="myAccount-profile">
<div class="row align-items-center"> 
<div class="col-lg-4 col-md-5">
<div class="profile-image">
<?php if(!empty($usr['image']) && file_exists($usr['image'])){ ?>
<img src="<?php echo $usr['image']; ?>" alt="<?php echo $usr['first_name'].' '.$usr['last_name']; ?>">
<?php  }else{  ?>
  <img src="assets/img/usericon.png" alt="<?php echo $usr['first_name'].' '.$usr['last_name']; ?>">
  <?php } ?>
</div>
</div>

<div class="col-lg-8 col-md-7">
<div class="profile-content">
<h3><?php echo $_SESSION['name']; ?></h3>
<p style="display:none;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore atque officiis maxime suscipit expedita obcaecati nulla in ducimus.</p>

<ul class="contact-info">
<li><i class='fa fa-envelope-o'></i> <a href="mailto:<?php echo $_SESSION['email']; ?>"><?php echo $_SESSION['email']; ?></a></li>
<li><i class='fa fa-phone'></i> <a href="tel:<?php echo $_SESSION['mobile']; ?>"><?php echo $_SESSION['mobile']; ?></a></li>
<li><i class='fa fa-globe'></i> <a href="#" target="_blank"><?php echo $usr['address']; ?></a></li>
</ul>
<ul class="social">
<li><a href="<?php echo trim($usr['fblink']); ?>" class="d-block" target="_blank"><i class='fa fa-facebook'></i></a></li>
<li><a href="<?php echo trim($usr['twlink']); ?>" class="d-block" target="_blank"><i class='fa fa-twitter'></i></a></li>
<li><a href="<?php echo trim($usr['instaid']); ?>"  class="d-block" target="_blank"><i class='fa fa-instagram'></i></a></li>
<li><a href="<?php echo trim($usr['linkdid']); ?>" class="d-block" target="_blank"><i class='fa fa-linkedin'></i></a></li>
<!-- <li><a href="" class="d-block" target="_blank"><i class='fa fa-pinterest'></i></a></li> -->
</ul>

<a href="logout.php" class="myAccount-logout">Logout</a>
</div>
</div>
</div>
</div>









</div>
</section>
<!-- End My Account Area -->


<!-- Start FAQ Area -->
<section class="faq-area myaccounttab pb-40">
<div class="container">
<div class="tab faq-accordion-tab">
<ul class="tabs d-flex flex-wrap justify-content-center">
<li><a href="#"><span>Enquiry History</span></a></li>

<li><a href="#"><span>Recently Viewed EV</span></a></li>

<li><a href="#"><span>Profile Details</span></a></li>

<li style="display:none;"><a href="#"><span>Give Reviews</span></a></li>

<li><a href="#"><span>FAQ</span></a></li>

<li><a href="#"><span>Request a Call Back</span></a></li>

</ul>

<div class="tab-content">



<div class="tabs-item">
<div class="myAccount-content">
<h3>Recent Enquiry Details</h3>
<div class="recent-orders-table table-responsive">
  <?php $enquiries=DB::query("select *,products.title from quotation left join products on products.id=quotation.product_id where type=2 and email=%s",$_SESSION['email']);
  
  ?>
<table class="table">
<thead>
<tr>
<th>SN.</th>
<th>Product</th>
<th>Comment</th>
<th>Status</th>
<th>Date</th>
<th>Response</th>
<!-- <th>Actions</th> -->

</tr>
</thead>
<tbody>
  <?php $i=1;foreach($enquiries as $t){ ?>
<tr>
  <td><?php echo $i; ?></td>
<td><?php echo $t['title']; ?></td>
<td><?php echo $t['comment']; ?></td>
<td><?php echo ($t['status']==1) ? 'Completed':'panding'; ?></td>
<td><?php echo $t['created_at']; ?></td>
<td><?php echo $t['response']; ?></td>
<!-- <td><a href="test-details.php" target="_blank" class="view-button">View</a></td> -->
</tr>
<tr>
<?php $i++; } ?>
</tbody>
</table>
</div>
</div>
</div>




<div class="tabs-item">
<div class="myAccount-content yourexamdetails">
<h3>Mostly Viewed EV</h3>
<div class="recent-orders-table table-responsive">
<table class="table">
<thead>
<tr>
<th>S.No</th>
<th>Product Name</th>
<th>Date</th>

</tr>
</thead>
<tbody>
  <?php $searchdata=DB::query("select searchhistory.*,products.title from searchhistory left join products on products.id=searchhistory.product_id");
  $i=1;
    foreach($searchdata as $data){
  ?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $data['title']; ?></td>
<td><?php echo $data['created']; ?></td>
</tr>
<?php $i++; } ?>
</tbody>
</table>
</div>
</div>
</div>





<div class="tabs-item">
<div class="myAccount-content studentaddressdetails">
<form class="edit-account" name="profileForm" method="post">
<div class="row">
<div class="col-lg-6 col-md-6">
<div class="form-group">
<label>First name</label>
<input type="text" class="form-control" id="sfname" name="sfname" value="<?php echo $usr['first_name']; ?>" required>
</div>
</div>

<div class="col-lg-6 col-md-6">
<div class="form-group">
<label>Last name</label>
<input type="text" class="form-control" id="slanme" name="slanme" value="<?php echo $usr['last_name']; ?>" required>
</div>
</div>

<div class="col-lg-6 col-md-6">
<div class="form-group">
<label>Phone Number</label>
<input type="tel" class="form-control" id="sphone" name="sphone" value="<?php echo $usr['mobile']; ?>" required>
</div>
</div>

<div class="col-lg-6 col-md-6">
<div class="form-group">
<label>Email address</label>
<input type="email" readonly class="form-control" id="semail" name="semail" value="<?php echo $usr['email']; ?>" required>
</div>
</div>


<div class="col-lg-12 col-md-12">
<div class="form-group">
<label>Address Details</label>
<textarea class="form-control" id="sadd" name="sadd"  required><?php echo $usr['address']; ?></textarea>
</div>
</div>
    
<div class="col-lg-3 col-md-3">
<div class="form-group">
<label>Facebook Account URL</label>
<input type="text" class="form-control" id="facebookid" value="<?php echo $usr['fblink']; ?>" name="facebookid" required>
</div>
</div>
    
<div class="col-lg-3 col-md-3">
<div class="form-group">
<label>Twitter Account URL</label>
<input type="text" class="form-control" id="twitterid" value="<?php echo $usr['twlink']; ?>"  name="twitterid" required>
</div>
</div>
    
<div class="col-lg-3 col-md-3">
<div class="form-group">
<label>Instagram Accoutn URL</label>
<input type="text" class="form-control" id="instagramid" name="instagramid" value="<?php echo $usr['instaid']; ?>" required>
</div>
</div>
    
<div class="col-lg-3 col-md-3">
<div class="form-group">
<label>Linkedin Accoutn URL</label>
<input type="text" class="form-control" id="linkedid" name="linkedid" value="<?php echo $usr['linkdid']; ?>" required>
</div>
</div>
<input type="hidden" name="profileform" value="profileform">
<div class="col-lg-12 col-md-12">
<button type="submit" class="default-btn"><i class="fa fa-eye icon-arrow before"></i><span class="label">Update</span><i class="fa fa-car icon-arrow after"></i></button>
</div>
</div>
</form>
</div>
</div>




<div class="tabs-item" style="display:none;">
<div class="col-md-12 col-lg-12"> 
<div class="students-feedback-form studentdashreviews">
<h3>Customer Feedback Form</h3>

<form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div class="row">
<div class="col-lg-6 col-md-6">
<div class="form-group">
<input type="text" class="form-control" placeholder="Your name*">
<span class="label-title"><i class="fa fa-user"></i></span>
</div>
</div>

<div class="col-lg-6 col-md-6">
<div class="form-group">
<input type="text" class="form-control" placeholder="Subject*">
<span class="label-title"><i class="fa fa-home"></i></span>
</div>
</div>

<div class="col-lg-6 col-md-6">
<div class="form-group">
<input type="email" class="form-control" placeholder="Your email*">
<span class="label-title"><i class="fa fa-envelope-o"></i></span>
</div>
</div>

<div class="col-lg-6 col-md-6">
<div class="form-group">
<input type="text" class="form-control" placeholder="Your phone*">
<span class="label-title"><i class="fa fa-phone"></i></span>
</div>
</div>

<div class="col-lg-12 col-md-12">
<div class="form-group">
<textarea cols="30" rows="5" class="form-control" placeholder="Write something here (Optional)"></textarea>
<span class="label-title"><i class="fa fa-pencil"></i></span>
</div>
</div>


<div class="col-lg-12 col-md-12">
<div class="form-group">
<div class="feedback">
<div class="rating">
<input type="radio" name="rating" id="rating-5">
<label for="rating-5"></label>
<input type="radio" name="rating" id="rating-4">
<label for="rating-4"></label>
<input type="radio" name="rating" id="rating-3">
<label for="rating-3"></label>
<input type="radio" name="rating" id="rating-2">
<label for="rating-2"></label>
<input type="radio" name="rating" id="rating-1">
<label for="rating-1"></label>
<div class="emoji-wrapper">
<div class="emoji">
<svg class="rating-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
<circle cx="256" cy="256" r="256" fill="#ffd93b"></circle>
<path d="M512 256c0 141.44-114.64 256-256 256-80.48 0-152.32-37.12-199.28-95.28 43.92 35.52 99.84 56.72 160.72 56.72 141.36 0 256-114.56 256-256 0-60.88-21.2-116.8-56.72-160.72C474.8 103.68 512 175.52 512 256z" fill="#f4c534"></path>
<ellipse transform="scale(-1) rotate(31.21 715.433 -595.455)" cx="166.318" cy="199.829" rx="56.146" ry="56.13" fill="#fff"></ellipse>
<ellipse transform="rotate(-148.804 180.87 175.82)" cx="180.871" cy="175.822" rx="28.048" ry="28.08" fill="#3e4347"></ellipse>
<ellipse transform="rotate(-113.778 194.434 165.995)" cx="194.433" cy="165.993" rx="8.016" ry="5.296" fill="#5a5f63"></ellipse>
<ellipse transform="scale(-1) rotate(31.21 715.397 -1237.664)" cx="345.695" cy="199.819" rx="56.146" ry="56.13" fill="#fff"></ellipse>
<ellipse transform="rotate(-148.804 360.25 175.837)" cx="360.252" cy="175.84" rx="28.048" ry="28.08" fill="#3e4347"></ellipse>
<ellipse transform="scale(-1) rotate(66.227 254.508 -573.138)" cx="373.794" cy="165.987" rx="8.016" ry="5.296" fill="#5a5f63"></ellipse>
<path d="M370.56 344.4c0 7.696-6.224 13.92-13.92 13.92H155.36c-7.616 0-13.92-6.224-13.92-13.92s6.304-13.92 13.92-13.92h201.296c7.696.016 13.904 6.224 13.904 13.92z" fill="#3e4347"></path>
</svg>
<svg class="rating-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
<circle cx="256" cy="256" r="256" fill="#ffd93b"></circle>
<path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"></path>
<path d="M328.4 428a92.8 92.8 0 0 0-145-.1 6.8 6.8 0 0 1-12-5.8 86.6 86.6 0 0 1 84.5-69 86.6 86.6 0 0 1 84.7 69.8c1.3 6.9-7.7 10.6-12.2 5.1z" fill="#3e4347"></path>
<path d="M269.2 222.3c5.3 62.8 52 113.9 104.8 113.9 52.3 0 90.8-51.1 85.6-113.9-2-25-10.8-47.9-23.7-66.7-4.1-6.1-12.2-8-18.5-4.2a111.8 111.8 0 0 1-60.1 16.2c-22.8 0-42.1-5.6-57.8-14.8-6.8-4-15.4-1.5-18.9 5.4-9 18.2-13.2 40.3-11.4 64.1z" fill="#f4c534"></path>
<path d="M357 189.5c25.8 0 47-7.1 63.7-18.7 10 14.6 17 32.1 18.7 51.6 4 49.6-26.1 89.7-67.5 89.7-41.6 0-78.4-40.1-82.5-89.7A95 95 0 0 1 298 174c16 9.7 35.6 15.5 59 15.5z" fill="#fff"></path>
<path d="M396.2 246.1a38.5 38.5 0 0 1-38.7 38.6 38.5 38.5 0 0 1-38.6-38.6 38.6 38.6 0 1 1 77.3 0z" fill="#3e4347"></path>
<path d="M380.4 241.1c-3.2 3.2-9.9 1.7-14.9-3.2-4.8-4.8-6.2-11.5-3-14.7 3.3-3.4 10-2 14.9 2.9 4.9 5 6.4 11.7 3 15z" fill="#fff"></path>
<path d="M242.8 222.3c-5.3 62.8-52 113.9-104.8 113.9-52.3 0-90.8-51.1-85.6-113.9 2-25 10.8-47.9 23.7-66.7 4.1-6.1 12.2-8 18.5-4.2 16.2 10.1 36.2 16.2 60.1 16.2 22.8 0 42.1-5.6 57.8-14.8 6.8-4 15.4-1.5 18.9 5.4 9 18.2 13.2 40.3 11.4 64.1z" fill="#f4c534"></path>
<path d="M155 189.5c-25.8 0-47-7.1-63.7-18.7-10 14.6-17 32.1-18.7 51.6-4 49.6 26.1 89.7 67.5 89.7 41.6 0 78.4-40.1 82.5-89.7A95 95 0 0 0 214 174c-16 9.7-35.6 15.5-59 15.5z" fill="#fff"></path>
<path d="M115.8 246.1a38.5 38.5 0 0 0 38.7 38.6 38.5 38.5 0 0 0 38.6-38.6 38.6 38.6 0 1 0-77.3 0z" fill="#3e4347"></path>
<path d="M131.6 241.1c3.2 3.2 9.9 1.7 14.9-3.2 4.8-4.8 6.2-11.5 3-14.7-3.3-3.4-10-2-14.9 2.9-4.9 5-6.4 11.7-3 15z" fill="#fff"></path>
</svg>
<svg class="rating-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
<circle cx="256" cy="256" r="256" fill="#ffd93b"></circle>
<path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"></path>
<path d="M336.6 403.2c-6.5 8-16 10-25.5 5.2a117.6 117.6 0 0 0-110.2 0c-9.4 4.9-19 3.3-25.6-4.6-6.5-7.7-4.7-21.1 8.4-28 45.1-24 99.5-24 144.6 0 13 7 14.8 19.7 8.3 27.4z" fill="#3e4347"></path>
<path d="M276.6 244.3a79.3 79.3 0 1 1 158.8 0 79.5 79.5 0 1 1-158.8 0z" fill="#fff"></path>
<circle cx="340" cy="260.4" r="36.2" fill="#3e4347"></circle>
<g fill="#fff">
<ellipse transform="rotate(-135 326.4 246.6)" cx="326.4" cy="246.6" rx="6.5" ry="10"></ellipse>
<path d="M231.9 244.3a79.3 79.3 0 1 0-158.8 0 79.5 79.5 0 1 0 158.8 0z"></path>
</g>
<circle cx="168.5" cy="260.4" r="36.2" fill="#3e4347"></circle>
<ellipse transform="rotate(-135 182.1 246.7)" cx="182.1" cy="246.7" rx="10" ry="6.5" fill="#fff"></ellipse>
</svg>
<svg class="rating-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
<circle cx="256" cy="256" r="256" fill="#ffd93b"></circle>
<path d="M407.7 352.8a163.9 163.9 0 0 1-303.5 0c-2.3-5.5 1.5-12 7.5-13.2a780.8 780.8 0 0 1 288.4 0c6 1.2 9.9 7.7 7.6 13.2z" fill="#3e4347"></path>
<path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"></path>
<g fill="#fff">
<path d="M115.3 339c18.2 29.6 75.1 32.8 143.1 32.8 67.1 0 124.2-3.2 143.2-31.6l-1.5-.6a780.6 780.6 0 0 0-284.8-.6z"></path>
<ellipse cx="356.4" cy="205.3" rx="81.1" ry="81"></ellipse>
</g>
<ellipse cx="356.4" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"></ellipse>
<g fill="#fff">
<ellipse transform="scale(-1) rotate(45 454 -906)" cx="375.3" cy="188.1" rx="12" ry="8.1"></ellipse>
<ellipse cx="155.6" cy="205.3" rx="81.1" ry="81"></ellipse>
</g>
<ellipse cx="155.6" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"></ellipse>
<ellipse transform="scale(-1) rotate(45 454 -421.3)" cx="174.5" cy="188" rx="12" ry="8.1" fill="#fff"></ellipse>
</svg>
<svg class="rating-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
<circle cx="256" cy="256" r="256" fill="#ffd93b"></circle>
<path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"></path>
<path d="M232.3 201.3c0 49.2-74.3 94.2-74.3 94.2s-74.4-45-74.4-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"></path>
<path d="M96.1 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2C80.2 229.8 95.6 175.2 96 173.3z" fill="#d03f3f"></path>
<path d="M215.2 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"></path>
<path d="M428.4 201.3c0 49.2-74.4 94.2-74.4 94.2s-74.3-45-74.3-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"></path>
<path d="M292.2 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2-77.8-65.7-62.4-120.3-61.9-122.2z" fill="#d03f3f"></path>
<path d="M411.3 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"></path>
<path d="M381.7 374.1c-30.2 35.9-75.3 64.4-125.7 64.4s-95.4-28.5-125.8-64.2a17.6 17.6 0 0 1 16.5-28.7 627.7 627.7 0 0 0 218.7-.1c16.2-2.7 27 16.1 16.3 28.6z" fill="#3e4347"></path>
<path d="M256 438.5c25.7 0 50-7.5 71.7-19.5-9-33.7-40.7-43.3-62.6-31.7-29.7 15.8-62.8-4.7-75.6 34.3 20.3 10.4 42.8 17 66.5 17z" fill="#e24b4b"></path>
</svg>
<svg class="rating-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
<g fill="#ffd93b">
<circle cx="256" cy="256" r="256"></circle>
<path d="M512 256A256 256 0 0 1 56.8 416.7a256 256 0 0 0 360-360c58 47 95.2 118.8 95.2 199.3z"></path>
</g>
<path d="M512 99.4v165.1c0 11-8.9 19.9-19.7 19.9h-187c-13 0-23.5-10.5-23.5-23.5v-21.3c0-12.9-8.9-24.8-21.6-26.7-16.2-2.5-30 10-30 25.5V261c0 13-10.5 23.5-23.5 23.5h-187A19.7 19.7 0 0 1 0 264.7V99.4c0-10.9 8.8-19.7 19.7-19.7h472.6c10.8 0 19.7 8.7 19.7 19.7z" fill="#e9eff4"></path>
<path d="M204.6 138v88.2a23 23 0 0 1-23 23H58.2a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#45cbea"></path>
<path d="M476.9 138v88.2a23 23 0 0 1-23 23H330.3a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#e84d88"></path>
<g fill="#38c0dc">
<path d="M95.2 114.9l-60 60v15.2l75.2-75.2zM123.3 114.9L35.1 203v23.2c0 1.8.3 3.7.7 5.4l116.8-116.7h-29.3z"></path>
</g>
<g fill="#d23f77">
<path d="M373.3 114.9l-66 66V196l81.3-81.2zM401.5 114.9l-94.1 94v17.3c0 3.5.8 6.8 2.2 9.8l121.1-121.1h-29.2z"></path>
</g>
<path d="M329.5 395.2c0 44.7-33 81-73.4 81-40.7 0-73.5-36.3-73.5-81s32.8-81 73.5-81c40.5 0 73.4 36.3 73.4 81z" fill="#3e4347"></path>
<path d="M256 476.2a70 70 0 0 0 53.3-25.5 34.6 34.6 0 0 0-58-25 34.4 34.4 0 0 0-47.8 26 69.9 69.9 0 0 0 52.6 24.5z" fill="#e24b4b"></path>
<path d="M290.3 434.8c-1 3.4-5.8 5.2-11 3.9s-8.4-5.1-7.4-8.7c.8-3.3 5.7-5 10.7-3.8 5.1 1.4 8.5 5.3 7.7 8.6z" fill="#fff" opacity=".2"></path>
</svg>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-lg-12 col-md-12">
<button type="submit" class="default-btn"><i class="fa fa-eye icon-arrow before"></i><span class="label">Send Feedback</span><i class="fa fa-car icon-arrow after"></i></button>
</div>
</div>
</form>
</div>    
</div>
</div>





<div class="tabs-item">
<div class="faq-accordion">
<ul class="accordion">
  <?php $faqs=DB::query("select * from faqs");
     $i=0;
     foreach($faqs as $faq){
  ?>
<li class="accordion-item">
<a class="accordion-title <?php echo $i==0 ? 'active':''; ?>" href="javascript:void(0)">
<i class='bx bx-chevron-down'></i>
<?php echo $faq['question']; ?>
</a>

<div class="accordion-content show">
<p><?php echo $faq['answer']; ?></p>
</div>
</li>
<?php $i++; } ?>

</ul>
</div>
</div>




<div class="tabs-item">
<div class="contact-form studentaddressdetails">
<form id="contactForm1" novalidate="true" method="post">
<div class="row">
<div class="col-lg-6 col-md-12">
<div class="form-group">
<input type="text" name="name" id="name" class="form-control" required="" data-error="Please enter your name" placeholder="Your Name">
<div class="help-block with-errors"></div>
</div>
</div>

<div class="col-lg-6 col-md-12">
<div class="form-group">
<input type="email" name="email" id="email" class="form-control" required="" data-error="Please enter your email" placeholder="Your Email">
<div class="help-block with-errors"></div>
</div>
</div>

<div class="col-lg-6 col-md-12">
<div class="form-group">
<input type="text" name="phone" id="phone_number" required="" data-error="Please enter your number" class="form-control" placeholder="Your Phone">
<div class="help-block with-errors"></div>
</div>
</div>

<div class="col-lg-6 col-md-12">
<div class="form-group">
<input type="text" name="subject" id="msg_subject" class="form-control" required="" data-error="Please enter your subject" placeholder="Your Subject">
<div class="help-block with-errors"></div>
</div>
</div>

<div class="col-lg-12 col-md-12">
<div class="form-group">
<textarea name="message" class="form-control" name="msg" id="message" cols="30" rows="5" required="" data-error="Write your message" placeholder="Your Message"></textarea>
<div class="help-block with-errors"></div>
</div>
</div>
<input type="hidden" name="callback" value="callback">
<div class="col-lg-12 col-md-12">
<button type="submit" class="default-btn"><i class="fa fa-eye icon-arrow before"></i><span class="label">Send Feedback</span><i class="fa fa-car icon-arrow after"></i></button>
<div id="msgSubmit" class="h3 text-center hidden"></div>
<div class="clearfix"></div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- End FAQ Area -->





<?php include 'include/footer.php';?>



<?php include 'include/script.php';?>
</body>


</html>