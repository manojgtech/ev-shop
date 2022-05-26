<?php
require_once 'dbconnect.php';
  function adminLogin(){
       $email=validP($_POST['admin-email']);
       $password=validP($_POST['admin-password']);
       $results1 = DB::queryFirstRow("SELECT * FROM evfy_users WHERE email=%s", $email);
       if(!empty($results1)){
          if(password_verify($password, $results1['password'])){
              session_start();
              $_SESSION['time']=time();
              $_SESSION['adminLoggedIn']=1;
              unset($results1['password']);
              unset($results1['reset_key']);
              $_SESSION['userinfo']=$results1;
              header("Location:../evfyadmin/index.php");
          }else{
             header("Location:../evfyadminadminlogin.php?err=f1");
          }
       }else{
         header("Location:../evfyadmin/adminlogin.php?err=f1");
       }

  }

  if(isset($_POST['login_type']) && $_POST['login_type']=='admin'){
    adminLogin();
  }

  function validP($v){
    return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8');
  }
  // $a=password_hash("123456",PASSWORD_DEFAULT); 
  // var_dump(password_verify('123456', $a));

?>