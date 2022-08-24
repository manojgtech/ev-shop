<!doctype html>
<html lang="eng">

<?php include 'include/style.php'; ?>

<body>

    <?php include 'include/preloader.php'; ?>

    <?php include 'include/navigation.php'; ?>

    <?php include 'include/websiteoverlaydontdel.php'; ?>
    <?php
    //  require 'vendor/PHPMailer-master/PHPMailer/src/Exception.php';
    //  require 'vendor/PHPMailer-master/PHPMailer/src/PHPMailer.php';
    //  require 'vendor/PHPMailer-master/PHPMailer/src/SMTP.php';
     //require 'vendor/razorpay-php/Razorpay.php';
     
    ?>
<?php 
 if(isset($_GET['id'])){
     $id=base64_decode(htmlspecialchars($_GET['id']));
     $prod=DB::query("select * from products where id=%i",$id);
 }
?>

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
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill">3</span>
          </h4>
          <ul class="list-group mb-3">
              <?php if(count($prod)>0){
                   foreach($prod as $prd){
                  ?>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0"><?php echo $prd['title']; ?></h6>
                <small class="text-muted">Brief description</small>
              </div>
              <span class="text-muted">INR&nbsp;<?php echo $prd['ex_showroom_price']; ?></span>
            </li>
            <?php 
                   } 
                }
                ?>
           
          </ul>

          <form class="card p-2">
              
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Promo code">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary">Redeem</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" id="checkoutform" action="doCheckout.php" method="post">
          <input type="hidden" name="currency" value="INR">
          <input type="hidden" name="item_number" value="ev<?php echo $prod[0]['id']; ?><?php echo $prod[0]['make']; ?>">
          <input type="hidden" name="item_id" value="ev<?php echo $prod[0]['id']; ?>">
          <input type="hidden" name="item_name" value="<?php echo $prod[0]['title']; ?>">
          <input type="hidden" name="item_description" value="<?php echo $prod[0]['model']; ?>">
          <input type="hidden" name="amount" value="<?php echo $prod[0]['ex_showroom_price']; ?>">
              <div class=" mb-3">
                <label for="firstName">Full Name</label>
                <input type="text" class="form-control"  id="name" name="cust_name" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>
              

            <div class="mb-3">
              <label for="email">Email <span class="text-muted">*</span></label>
              <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="mb-3">
              <label for="email">Phone <span class="text-muted">*</span></label>
              <input type="tel" class="form-control" id="phone" name="contact" placeholder="+91xxxxxxxxxx" required>
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="mb-3">
              <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment or suite">
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">Country</label>
                <select class="custom-select d-block w-100" name="country" id="country" required>
                  <option value="">Choose...</option>
                  <option value="india">India</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid country.
                </div>
              </div>
              <div class="col-md-4 mb-3">
              <?php $states = DB::query("select id,name from states"); ?>
                <label for="state">State</label>
                <select class="custom-select d-block w-100" id="checkout_state"  name="state"  onchange="selectCity1(this.value);" required>
                <option>Select State</option>
                                <?php if (count($states) > 0) {
                                    foreach ($states as $state) {
                                ?>
                                        <option value="<?php echo $state['id']; ?>"><?php echo $state['name']; ?></option>
                                <?php }
                                }
                                ?>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>
              <!-- cities -->
              <div class="col-md-4 mb-3">
              <?php $states = DB::query("select id,name from states"); ?>
                <label for="state">City</label>
                <select class="custom-select d-block w-100" name="city" id="chargingcities1" required>
                <option>Select city</option>
                               
                </select>
                <div class="invalid-feedback">
                  Please provide a valid city.
                </div>
              </div>
              <!-- end cities -->
              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" name="zip" placeholder="" required>
                <div class="invalid-feedback">
                  Zip code required.
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="same-address">
              <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="save-info">
              <label class="custom-control-label" for="save-info">Save this information for next time</label>
            </div>
            <hr class="mb-4">

          <!--  <h4 class="mb-3">Payment</h4>

            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="">
                <label class="custom-control-label" for="credit">Credit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="debit" name="paymentMethod" type="radio" class="custom-control-input">
                <label class="custom-control-label" for="debit">Debit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input">
                <label class="custom-control-label" for="paypal">Paypal</label>
              </div>
            </div>
                            -->
           <!-- <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cc-name">Name on card</label>
                <input type="text" class="form-control" name="cardname"  id="cc-name" placeholder="">
                <small class="text-muted">Full name as displayed on card</small>
                <div class="invalid-feedback">
                  Name on card is required
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="cc-number">Credit card number</label>
                <input type="text" class="form-control" id="cc-number" mex-length="16" name="cardnumber" placeholder="">
                <div class="invalid-feedback">
                  Credit card number is required
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">Expiration</label>
                <input type="text" class="form-control"  id="cc-expiration" name="expiry" placeholder="dd/yyyy">
                <div class="invalid-feedback">
                  Expiration date required
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">CVV</label>
                <input type="text" class="form-control" id="cc-cvv"  name="cvv"  placeholder="">
                <div class="invalid-feedback">
                  Security code required
                </div>
              </div>
            </div>
                            -->
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
          </form>
        </div>
      </div>
        </div>
    </section>
    <!-- End FAQ Area -->




    <?php include 'include/footer.php'; ?>

    <?php include 'include/script.php'; ?>

    <script src="assets/js/jquery.validate.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.4/additional-methods.min.js" integrity="sha512-XJiEiB5jruAcBaVcXyaXtApKjtNie4aCBZ5nnFDIEFrhGIAvitoqQD6xd9ayp5mLODaCeaXfqQMeVs1ZfhKjRQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
$('#checkoutform').validate({
    rules: {
        name: {
            required: true,
            number: false
        },
        
        email: {
            required: true,
            number: false
        },
        address: {
            required: true,

        },
        state: {
            required: true,

        },
        city: {
            required: true,
            number: false
        },
        zip: {
            required: true,
            minlength: 100
        },
        paymentmethod: {
            required: true,
        
        },
        cardname: {
            required: true,
            number: true
        },
        cardnum: {
        required: true,
        creditcard:true
    },
    expiry: {
        required: true,
        
    },
    cvv:{
        required:true
    }

    },
    //Submit Handler Function  files[]
    submitHandler: function (form) {
        form.submit();
    }

});
</scr>
</body>

</html>