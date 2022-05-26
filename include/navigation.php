<!-- Start Header Area -->
<header class="header-area p-relative navbar-style-three mainheader">
<?php $parents=DB::query("select * from links where parent=0 order by linkorder asc");
$links=[];
      foreach($parents as $plink){
          $link=$plink['id'];
          $l=DB::query("select * from links where parent=$link");
          if(count($l)>0){
            $links[$plink['id']]=$l;
          }
          
      }
      
    
?>
    <div class="top-header top-header-style-three">
        <div class="container-fluid2">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-8">
                    <ul class="top-header-contact-info">
                        <li>
                            Call:
                            <a href="tel:#">+91-93111 11437</a>
                        </li>
                    </ul>

                    <div class="top-header-social">
                        <span>Follow us:</span>
                        <a href="https://twitter.com/evfyin" class="d-block" target="_blank"><i class='fa fa-twitter'></i></a>
                        <a href="https://www.instagram.com/evfy.in/" class="d-block" target="_blank"><i class='fa fa-instagram'></i></a>
                        <a href="https://api.whatsapp.com/send?phone=919311111437&text=&source=&data=&app_absent=" class="d-block" target="_blank"><i class='fa fa-whatsapp'></i></a>

                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <ul class="top-header-login-register">
                        <li><a href="login.php"><i class='fa fa-user'></i></a></li>
                        <li><a href="#"><i class='fa fa-language'></i></a></li>
                        <li><a href="#"><i class='fa fa-map-marker'></i></a></li>
                        <li><a href="#" data-toggle="modal" data-target="#exampleModal"><i class='fa fa-sun-o'></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Navbar Area -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded maintopnavigation mainnav">
        <a class="navbar-brand" href="./">
            <img src="assets/img/EVFY-logo.png">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ml-auto">

              <?php
                foreach($parents as $plink){
                    $dropdown_toggle="";
                    $data_toggle="";
                    $ex=false;
                    if(isset($links[$plink['id']])){
                        $dropdown_toggle="dropdown-toggle";
                        $data_toggle="data-toggle='dropdown'";
                        $ex=true;
                    }
                    ?>
                <li class="nav-item dropdown megamenu-li">
                    <a class="nav-link <?php echo $dropdown_toggle; ?>"  <?php echo $data_toggle; ?> href="<?php echo $plink['url']; ?>" id="dropdown02" aria-haspopup="true" aria-expanded="false"><?php echo $plink['title']; ?> <?php echo ($ex==true) ? "<i class='fa fa-caret-down'></i>":'';?></a>
                    <?php  if($ex==true){  ?>
                        <ul class="dropdown-menu">
                        <?php
                        foreach($links[$plink['id']] as $child){
                        ?>
<li class="nav-item"><a href="<?php echo $child['url']; ?>" class="nav-link"><?php echo $child['title']; ?></a></li>
                        <?php }  ?>
                        </ul>
                        <?php
                    }
                        ?>
                       
                </li>

              <?php
                }
              ?>



            </ul>

            <div class="others-option">
                <div class="search-box d-inline-block">
                    <i class='fa fa-search'></i>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar Area -->




    <!-- Start Sticky Navbar Area -->

    <!-- End Sticky Navbar Area -->




</header>
<!-- End Header Area -->