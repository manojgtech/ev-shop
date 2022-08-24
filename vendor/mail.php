   
   <?php 

  require 'vendor/PHPMailer-master/src/Exception.php';
     require 'vendor/PHPMailer-master/src/PHPMailer.php';
     require 'vendor/PHPMailer-master/src/SMTP.php';
     
     $admin_emails=['mkgupta@yopmail'];
     use PHPMailer\PHPMailer\PHPMailer;
     use PHPMailer\PHPMailer\Exception;

      $site="https://digitalgoldbox.in";
      $admin="admin@evfy.com";
  function sendMail($to,$name,$sub,$msg){
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;   
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;                                //Enable SMTP authentication
    $mail->Username   = 'ghgjgjgjhj@gmail.com';                     //SMTP username
    $mail->Password   = 'ghghh';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('coolntop.ray@gmail.com', 'Mailer');
    $mail->addAddress($to, 'Joe User');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $sub;
    $mail->Body    = $msg;
    

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
  }


 function  useremail($userid,$email,$name){
   //
   $message = '<html><body>';
   $message .= '<h1 style="color:#f40;">Hi '.$name.'</h1>';
   $message .= '<p style="color:#080;font-size:18px;">You have created an account on EVFY. Login here  <a href="'.$site.'/user">Evfy</a>?</p>';
   $message .= '</body></html>';

  }
  function  adminuemail($userid,$email,$name){
    //
    $message = '<html><body>';
    $message .= '<h1 style="color:#f40;">Hi Admin</h1>';
    $message .= '<p style="color:#080;font-size:18px;">User '. $name.' with email '.$email.' has signed up in EVFY.</p>';
    $message .= '</body></html>';
 
   }
   function  userorder($userid,$email,$name){
    //
    $message = '<html><body>';
    $message .= '<h1 style="color:#f40;">Hi '.$name.'</h1>';
    $message .= '<p style="color:#080;font-size:18px;"> you have successfully placed order for product of amount INT  in EVFY.</p>';
    $message .= '</body></html>';
 
   }
   function  useraorder($userid,$email,$name){
    //
    $message = '<html><body>';
    $message .= '<h1 style="color:#f40;">Hi Admin</h1>';
    $message .= '<p style="color:#080;font-size:18px;"> User $name'.' have  placed order for product of amount INT  in EVFY.</p>';
    $message .= '</body></html>';
 
   }