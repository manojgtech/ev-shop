<?php
include("vendor/dbconnect.php");
print_r($_POST);
$data['name']=htmlspecialchars($_POST['name']);
$data['subject']=htmlspecialchars($_POST['subject']);
$data['email']=htmlspecialchars($_POST['email']);
$data['phone']=htmlspecialchars($_POST['phone']);
$data['feedback']=htmlspecialchars($_POST['feedback']);
$data['product']=$_POST['product_id'];
$data['rating']=$_POST['rating'];
$slug=htmlspecialchars($_POST['slug']);
DB::insert('feedbacks',$data);
header("Location:http://localhost:8081/evfy/product-details.php?product=$slug");


?>