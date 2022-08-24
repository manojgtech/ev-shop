<?php

//require('config.php');
require 'vendor/dbconnect.php';
session_start();

require 'vendor/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
$keyId = 'rzp_test_sUqjzvuqWL0242';
$keySecret = 'G9MUw4cKlM9bJkgrC5ftPUAA';
$displayCurrency = 'INR';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
    $html = "<p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
             $pid=$_POST['razorpay_payment_id'];
             $oid=$_SESSION['razorpay_order_id'];
       DB::update("orders",['payment_id'=>$pid,'order_id'=>$oid,'status'=>1],"id=%i",$_SESSION['orderid']);      
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
             $pid=$_POST['razorpay_payment_id'];
             $oid=$_SESSION['razorpay_order_id'];
             DB::update("orders",['payment_id'=>$pid,'order_id'=>$oid,'status'=>1],"id=%i",$_SESSION['orderid']); 
}

echo $html;
