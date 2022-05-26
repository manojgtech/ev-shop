<!doctype html>
<html lang="zxx">

<?php include 'include/style.php'; ?>

<body>

    <?php include 'include/navigation.php'; ?>
    <?php include 'include/websiteoverlaydontdel.php'; ?>

    <section>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <section class="widget widget_contact" style="height:auto;">
                    <div class="innercolumnproduct">
                        <h3>Request a Call Back</h3>
                        <form class="form-horizontal" id="reqback-form" method="post" action="" role="form">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Name" id="vname1" name="vname" required>
                            </div>
                            <input type="hidden" name="product" >
                            <div class="form-group">
                                <input type="email" class="form-control" id="ecity1" name="ecity" placeholder="Your Mail" required>
                            </div>

                            <div class="form-group">
                                <input type="tel" id="mailuser1" name="mailuser" class="form-control" placeholder="Phone" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="rlocation1" name="rlocation" placeholder="Location">

                            </div>

                            <div class="form-group">
                                <input type="submit" id="reqformsubmit" name="rsubmit" value="Submit">
                            </div>
                        </form>
                    </div>
                </section>


            </div>

        </div>
    </section>

    <?php include 'include/footer.php'; ?>
    <?php include 'include/script.php'; ?>

    <script>
        const products = document.querySelectorAll(".product");
        const container = document.querySelector(".container");
        const nav = document.querySelector(".nav");
        const cover = document.querySelector(".cover");
        const productWidth = 310;
        const overlay = document.querySelector(".product__overlay");

        function getProductOffset() {
            return (container.offsetWidth - container.offsetWidth * 70 / 100) / 2;
        }

        function removeActiveClass() {
            const activeProduct = document.querySelector(".product--active");
            if (activeProduct) {
                activeProduct.scrollTop = 0;
                activeProduct.classList.remove("product--active");
                container.classList.remove("container--detail");
            }
        }

        products.forEach(product => {
            product.addEventListener("click", e => {
                if (e.target.classList.contains("product__close")) {
                    overlay.style.display = "none";
                    removeActiveClass();
                    return;
                }
                if (!e.currentTarget.classList.contains("product--active")) {
                    overlay.style.display = "block";
                    removeActiveClass();
                    e.currentTarget.classList.add("product--active");
                    container.classList.add("container--detail");

                    const left =
                        productWidth * parseInt(e.currentTarget.getAttribute("data-index")) +
                        cover.offsetWidth +
                        parseInt(e.currentTarget.getAttribute("data-index")) * 6 +
                        nav.offsetWidth -
                        getProductOffset();

                    container.scrollLeft = left;
                    overlay.style.display = "none";
                    if (
                        /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                            navigator.userAgent))

                    {
                        e.currentTarget.scrollIntoView({
                            inline: "start"
                        });
                    }
                }
            });
        });
    </script>


    <script>
        //-----JS for Price Range slider-----

        $(function() {
            $("#slider-range").slider({
                range: true,
                min: 130,
                max: 500,
                values: [130, 250],
                slide: function(event, ui) {
                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });
            $("#amount").val("$" + $("#slider-range").slider("values", 0) +
                " - $" + $("#slider-range").slider("values", 1));
        });
    </script>
    <?php if (isset($_GET['cat']) && !empty($_GET['cat'])) {
        $cat = htmlspecialchars(trim($_GET['cat']));
    ?>
        <script>
            window.addEventListener('load', function() {
                filterProd('<?php echo $cat; ?>', 'cat', sortBy, order);
                document.title = "Evfy Shop";
            });
        </script>
    <?php } else { ?>
        <script>
            window.addEventListener('load', function() {
                filterProd();
                document.title = "Evfy Shop";
            });
        </script>
    <?php } ?>
</body>

</html>