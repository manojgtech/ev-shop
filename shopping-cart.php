<!doctype html>
<html lang="zxx">




<?php include 'include/style.php'; ?>

<body>

    <?php include 'include/preloader.php'; ?>

    <?php include 'include/navigation.php'; ?>

    <?php include 'include/websiteoverlaydontdel.php'; ?>


    <!-- Start Page Title Area -->
    <div class="page-title-area item-bg1 faqmainbanner">
        <div class="container">
            <div class="page-title-content">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li>Cart</li>
                </ul>

            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Start FAQ Area -->
    <section class="faq-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Items in your cart</h2>
                    <div id="cartitems"></div>
                    <div class="row"><div style="float:right;"><a href="shop-ev.php"><button class="btn btn-info">Shop Page</button></a>
                    <a href="checkout.php"><button class="btn btn-primary">Checkout</button></a></div></div>
                </div>
            </div>

        </div>
    </section>
    <!-- End FAQ Area -->




    <?php include 'include/footer.php'; ?>

    <?php include 'include/script.php'; ?>
    <script>
        window.addEventListener('load', function() {
            loadCart();
        })
    </script>
</body>

</html>