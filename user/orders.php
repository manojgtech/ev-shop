<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

?>
    <!doctype html>
    <html lang="en" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>Edit Profile</title>

        <!-- Font awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Sandstone Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Bootstrap Datatables -->
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
        <!-- Bootstrap social button library -->
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <!-- Bootstrap select -->
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <!-- Bootstrap file input -->
        <link rel="stylesheet" href="css/fileinput.min.css">
        <!-- Awesome Bootstrap checkbox -->
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <!-- Admin Stye -->
        <link rel="stylesheet" href="css/style.css">

        <script type="text/javascript" src="../vendor/countries.js"></script>
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #dd3d36;
                color: #fff;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #5cb85c;
                color: #fff;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>


    </head>

    <body>
        <?php
        try {
            $email = $_SESSION['aloginid'];
            $sql = "SELECT orders.*,products.title from orders left join products on products.id=orders.product_id where customer_id = (:email);";
            $query = $dbh->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_INT);
            $query->execute();
            $orders=[];
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                $orders[]=$result;
            }
            $cnt = 1;
            
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
   $order_status=array("","Completed","Pending","Failed");
        ?>
        <?php include('includes/header.php'); ?>
        <div class="ts-main-content">
            <?php include('includes/leftbar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                       
                        <div class="col-md-12">
                            <?php if(count($orders)>0){ ?>
                           <table id="user-orders" class="table">
                               <thead>
                                   <tr>
                                   <th>Sn</th>
                                   <th>Order Id</th>
                                   <th>Product</th>
                                   <th>Amount</th>
                                   <th>Quantity</th>
                                   <th>Date</th>
                                   <th>Payment Id</th>
                                   <th>status</th>
                                   
                                   </tr>
                               </thead>
                               <tbody>
                               <?php   foreach($orders as $order){    
                                   
                            ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['order_id']; ?></td>

                                <td><?php echo $order['title']; ?></td>
                                <td><?php echo $order['amount']; ?></td>
                                <td><?php echo $order['quantity']; ?></td>

                                <td><?php echo $order['order_date']; ?></td> 
                                <td><?php echo $order['payment_id']; ?></td>
                                <td><?php echo $order_status[$order['status']]; ?></td>

                            </tr>
                               
                          
                          <?php  } 
                          ?>  </table>
                          <?php
                           }else{
echo "No orders";
                           }
                          ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/chartData.js"></script>
        <script src="js/main.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                setTimeout(function() {
                    $('.succWrap').slideUp("slow");
                }, 3000);
            });
        </script>
    </body>

    </html>
<?php } ?>