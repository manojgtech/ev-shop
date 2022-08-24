<!doctype html>
<html lang="zxx">
    
<?php include 'include/style.php';?>
    


    <body>

         <?php include 'include/preloader.php';?>

        <?php include 'include/navigation.php';?>
            <?php
                if(isset($_POST['registerCust'])){
                    $fname=isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']):null;
                    $lname=isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']):null;
                    $email=isset($_POST['email']) ? htmlspecialchars($_POST['email']):null;
                    $phone=isset($_POST['phone']) ? htmlspecialchars($_POST['phone']):null;
                    $password=isset($_POST['password']) ? htmlspecialchars($_POST['password']):null;
                    if($email!=null && $lname!=null && $email!=null && $phone!=null && $password!=null ){
                        $s=DB::insert("users",['first_name'=>$fname,'last_name'=>$lname,'email'=>$email,'mobile'=>$phone,'password'=>md5(trim($password))]);
                        if($s){
                         ?>
                         <script>
                             alert("registered successfully");
                             window.location="my-account.php";
                         </script>
                         <?php
                        }
                    }
                }
            ?>
        <!-- Start Register Area -->
        <section class="register-area">
            <div class="row m-0">
                <div class="col-lg-6 col-md-12 p-0">
                    <div class="register-image">
                        <img src="assets/img/register-bg.jpg" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 p-0">
                    <div class="register-content">
                        <div class="d-table">
                            <div class="d-table-cell">
                                <div class="register-form">
<!--
                                    <div class="logo">
                                        <a href="index.php"><img src="assets/img/EVFY-logo.png" alt="image"></a>
                                    </div>
-->

                                    <h3>Registered to your EVFY Account now</h3>
                                    <p>Already registered? <a href="login.php">Log in</a></p>

                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <div class="form-group">
                                            <input type="text" name="first_name" id="fname" placeholder="First name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="last_name" id="lname" placeholder="Last name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" placeholder="Your email address" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="tel" name="phone" id="phone" placeholder="Phone" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <input type="password" minLength="6" name="password" id="password" placeholder="Create a password" class="form-control">
                                        </div>
                                       <input type="hidden" name="registerCust" />
                                        <button type="submit" name="register">Sign Up</button>

                                        <div class="connect-with-social">
                                            <span>Or</span>
                                            <button type="submit" class="facebook"><i class='fa fa-facebook'></i> Connect with Facebook</button>
                                            <button type="submit" class="twitter"><i class='fa fa-twitter'></i> Connect with Twitter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Register Area -->
<?php include 'include/footer.php';?>
        
        

        <?php include 'include/script.php';?>
    </body>

</html>