<?php
session_start();
require 'vendor/razorpay-php/Razorpay.php';
require 'vendor/dbconnect.php';
require 'vendor/mail.php';
    ?>
<?php
 $isus=DB::query("select 8 from users where email=%s",$user['email']);
$user['name']=htmlspecialchars(trim($_POST['cust_name']));
$user['email']=htmlspecialchars(trim($_POST['email']));
$user['mobile']=htmlspecialchars(trim($_POST['contact']));
$user['address']=htmlspecialchars(trim($_POST['address']));
$user['city']=htmlspecialchars(trim($_POST['city']));
$user['state']=htmlspecialchars(trim($_POST['state']));
$user['zip']=htmlspecialchars(trim($_POST['zip']));
$user['status']=3;
$isus=DB::query("select * from users where email=%s",$user['email']);
if(count($isus)==0){
    $usr=DB::insert("users",$user);
    $userid=DB::insertId();
    useremail($userid,$user['email'],$user['name']);
}
else{
    $user['name']=$isus[0]['name'];
    $userid=$isus[0]['id'];
    $user['email']=$isus[0]['email'];
}
$_SESSION['name']=$user['email'];
$_SESSION['name']=$user['name'];
 
?>


<?php
use Razorpay\Api\Api;
$api = new Api("rzp_test_sUqjzvuqWL0242", "G9MUw4cKlM9bJkgrC5ftPUAA");
$orderData = [
    'receipt'         => 3456,
    'amount'          => $_POST['amount'],
    'currency'        => $_POST['currency'],
    'payment_capture' => 1
];
$razorpayOrder = $api->order->create($orderData);
$razorpayOrderId = $razorpayOrder['id'];
$_SESSION['razorpay_order_id'] = $razorpayOrderId;
$displayAmount = $amount = $orderData['amount'];

$data = [
    "key"               => "rzp_test_sUqjzvuqWL0242",
    "amount"            => $amount,
    "name"              => $_POST['item_name'] ?? 'car 24',
    "description"       => $_POST['item_description'] ?? 'new car yu',
    "image"             => "",
    "prefill"           => [
    "name"              => $_POST['cust_name'],
    "email"             => $_POST['email'],
    "contact"           => $_POST['contact'],
    ],
    "notes"             => [
    "address"           => $_POST['address'],
    "merchant_order_id" => "12312321",
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];


$json = json_encode($data);
$iid=$_POST['item_id'];
DB::insert("orders",['product_id'=>$iid,'customer_id'=>$userid,'amount'=>$amount,'quantity'=>1,'status'=>3]);

$_SESSION['orderid']=DB::insertId();
require("manual.php");
?>