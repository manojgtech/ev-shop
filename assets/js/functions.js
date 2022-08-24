var baseurl = "https://digitalgoldbox.in/evfy/";
//var baseurl = "http://localhost:8081/evfy/";
function loadcatmake(val) {
    if (val != "") {
        $.ajax({
            type: "POST",
            url: baseurl + 'vendor/catModel.php',
            data: { func: 'findCatbrand', value: val },
            success: function (response) {
                $("#search-make1").niceSelect("destroy");
                $("#search-make1").html(response);
                $("#search-make1").niceSelect("update");
                var myEle = document.getElementById("search-make2");
                if(myEle){

                    $("#search-make2").niceSelect("destroy");
                    $("#search-make2").html(response);
                    $("#search-make2").niceSelect("update");
                }
            }
        });
    }

}


function showpmodel(val) {
    if (val != "") {
        $.ajax({
            type: "POST",
            url: baseurl + 'vendor/catModel.php',
            data: { func: 'findCatmodel', value: val },
            success: function (response) {
                $("#prod-models1").niceSelect("destroy");
                $("#prod-models1").html(response);
                $("#prod-models1").niceSelect("update");
                var myEle = document.getElementById("prod-models2");
                if(myEle){

                    $("#prod-models2").niceSelect("destroy");
                    $("#prod-models2").html(response);
                    $("#prod-models2").niceSelect("update");
                }
            }
        });

    }
}

//req submit

$("#reqformsubmit").click(function (e) {
    e.preventDefault();
    
    var name = $("#vname1").val().trim();
    var ecity = $("#ecity1").val().trim();
    var email = $("#mailuser1").val().trim();
    var rloc = $("#rlocation1").val() ?? '';
    console.log(name, ecity, email, rloc);
    if (name == "") {

        swal("Name is rquired");
    } else if (ecity == "" || !validatePhone(ecity)) {
        swal("Phone is not valid").show();
    } else if (email == "" || !validateEmail(email)) {
       swal("Email is not valid");
    } else {
        $("span.text-danger").hide();
        $.ajax({
            type: "POST",
            url: baseurl + 'vendor/quotesModel.php',
            data: { func: 'submitreq', name, ecity, email, rloc :rloc},
            success: function (response) {
                if (response == 1) {
                    swal("Request submitted successfully.");
                    $("#reqback-form")[0].reset();
                    setTimeout(() => {
                        swal.close();
                    }, 5000);
                }
            }
        });


    }

});

$("#reqformsubmit1").click(function (e) {
    e.preventDefault();

    var name = $("#vname11").val().trim();
    var ecity = $("#ecity11").val().trim();
    var email = $("#mailuser11").val().trim();
    var rloc = $("#rlocation11").val();
    console.log(name, ecity, email, rloc);
    if (name == "") {

        swal("Name is rquired");
    } else if (ecity == "" || !validatePhone(ecity)) {
        swal("Phone is not valid").show();
    } else if (email == "" || !validateEmail(email)) {
       swal("Email is not valid");
    } else {
        $("span.text-danger").hide();
        $.ajax({
            type: "POST",
            url: baseurl + 'vendor/quotesModel.php',
            data: { func: 'submitreq', name, ecity, email, rloc },
            success: function (response) {
                if (response == 1) {
                    swal("Request submitted successfully.");
                    $("#reqback-form1")[0].reset();
                    setTimeout(() => {
                        swal.close();
                        $("#requestmodal1").modal("close");
                    }, 5000);
                }
            }
        });


    }

});


// $("input").onBlur(function(){
//     $("span.text-danger").hide();
// });


function selectCity(v) {
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/quotesModel.php',
        data: { func: 'cities', data: v },
        success: function (response) {
            $("#chargingcities").niceSelect("destroy");
            $("#chargingcities").html(response);
            $("#chargingcities").niceSelect();
            $("html").niceScroll();
            $(".nice-select.list").niceScroll();
            var ns = $('.nice-select .open');
            var ns_option = $('.nice-select .open li');

            ns_option.on("click", function () {
                ns.removeClass("open");
            });
        }
    });
}
function selectCity1(v) {
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/quotesModel.php',
        data: { func: 'cities', data: v },
        success: function (response) {
            
            $("#chargingcities1").html(response);
            
        }
    });
}

function showstations(v) {
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/quotesModel.php',
        data: { func: 'getlocs', data: v },
        success: function (response) {

            $(".maonoutercharginglocationresult").html(response);

        }
    });
}


 var filterVal='';
 var filterby='';
 var sortBy='l';
 $("#sortprods").change(function(event){
 console.log(event.target.value);
 filterProd();
 });

 
 
 var currentRequest = null;  
function filterProd() {
    $("#bloader").show();
    var cats=getPcats() ;
    var battery=getBattype() ;
    var chargeTime=getChargetype() ;
    var cat=$("#filterShopData").attr("data-cat");
    var brand=$("#filterShopData").attr("data-brand");
    var page=$("#filterShopData").attr("data-page");
    var model=$("#filterShopData").attr("data-model");
    var sort=$("#sortprods").val();
    var price=$("#amount").val();
    var search=$("#searchshop").val();
    let post = {
        cat,brand,page,sort,price,cats:cats,battery:battery,chargeTime:chargeTime,type:1,search,model
        
    }
    currentRequest=$.ajax({
        type: "POST",
        url: baseurl + 'vendor/ProductModel.php',
        beforeSend : function()    {           
            if(currentRequest != null) {
                currentRequest.abort();
            }
        },
        data: { func: 'shopPage', data: post,cats },
        success: function (response) {
            $("#bloader").hide();
            $("#shopprods").html(response);

        }
    });
}

function getPcats(){
    var cats=[];
    $("#cattype input:checked").each(function(){
      cats.push($(this).val());
    });
    return cats;
}
function getBattype(){
    var cats=[];
    $("#battery_type input:checked").each(function(){
      cats.push($(this).val());
    });
    return cats;
}
function getChargetype(){
    var cats=[];
    $("#charging_time input:checked").each(function(){
      cats.push($(this).val());
    });
    return cats;
}

$(".bump input").click(function(){
  filterProd();
});

//add cart 
function addtocart(id, name = '', slug = '', price = 0) {

    let carts = localStorage.getItem("cartItems");
    if (carts == null || carts == '[]') {
        carts = [];
        let cart = { id: id, name: name, q: 1, slug: slug, price: price };
        carts.push(cart);
    } else {
        carts = JSON.parse(carts);
        // carts = carts.map((cart) => {
        //     if (cart.id == id) {
        //         cart.q = cart.q + 1;
        //     }else{

        //     }
        //     return cart;
        // })
        console.log(carts);

        let ind = carts.findIndex(function (w) {
            return w.id == id;
        });
        console.log(ind);
        if (ind > -1) {
            let cart = carts[ind];
            cart.q = cart.q + 1;
            carts[ind] = cart;
        } else {
            let cart1 = { id: id, name: name, q: 1, slug: slug, price: price };
            carts.push(cart1);
        }
    }

    localStorage.setItem("cartItems", JSON.stringify(carts));
    loadCart();
}

function removefromcart(id) {

    let carts = localStorage.getItem("cartItems");
    if (carts != null) {
        carts = JSON.parse(carts);
        let ind = carts.findIndex(function (w) {
            return w.id == id;
        });
        if (carts[ind].q > 1) {
            let cart = carts[ind];
            cart.q = cart.q - 1;
            carts[ind] = cart;
        } else {
            carts.splice(ind, 1);
        }
    }

    localStorage.setItem("cartItems", JSON.stringify(carts));
    loadCart();
}

function loadCart() {

    var d = localStorage.getItem("cartItems");
    console.log("carts", d);
    var s = 0;
    if (d == null || d == '[]') {

        $("#cartitems").html("<div class='alert alert-danger'>No item in carts</div>");

    } else {
        var items = JSON.parse(d);
        var html = "<table class='table table-stripped'><tr><th>Sn.</th><th>Name</th><th>Quantity</th><th>Price</th><th>&nbsp;&nbsp;&nbsp;</th></tr>";
        items.forEach(function (v) {
            html += "<tr><td>" + v.id + "</td><td><a class='btn btn-info' href='product-details.php?product=" + v.slug + "'>" + v.name + "</a></td><td>" + v.q + "</td><td>" + v.price * v.q + "</td><td><i class='fa fa-plus' onclick='addtocart(" + v.id + ");'>add</i>&nbsp;|&nbsp;<i onclick='removefromcart(" + v.id + ");' class='fa fa-minus'>remove</i></td></tr>";
            s = s + v.price * v.q;
        });
        html += "</table>";
        html += "<div class='price float-right'>Total:<span>" + s + "</span></div>";
        $("#cartitems").html(html);

    }

}


function requestmodal1(id, t, pid=null) {
    $("#reqback-form")[0].reset();
    let title=(t==1) ? "Enquire now" : "Request a Call Back";
    if(t==1){
        $("#urmsg").show();
    }else{
        $("#urmsg").hide();
    }
    $("#"+id+" modal-title").html(title);
    $("#req_prod").val(pid);
    $("#" + id).modal();
}


const validateEmail = (email) => {
    return email.match(
      /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
  };

  const validatePhone = (phone) => {
    return phone.match(
        /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g
    );
  };

//feedback form
const form = document.querySelector('#prod_review_form');
//form.addEventListener('submit', validatefeedbackForm);
function validatefeedbackForm(event){

  event.preventDefault();
  var id=document.forms['feedback_form']['product_id'].value;
  var name=document.forms['feedback_form']['name'].value;
  var sub=document.forms['feedback_form']['subject'].value;
  var phone=document.forms['feedback_form']['phone'].value;
  var email=document.forms['feedback_form']['email'].value;
  var rating=document.forms['feedback_form']['rating'].value;
   var err=false;
   var msg="";
   if(name.length==0){
      err=true;
      msg=msg+" Name is required.";
    
   }
   if(sub.length==0){
    err=true;
    msg=msg+" Subject is required. ";
  
 }
 
 if(!validateEmail(email)){
    err=true;
    msg=msg+" Email is not valid. ";
  
 }
 if(!validatePhone(phone)){
    err=true;
    msg=msg+" Phone  is not Valid.";
  
 }
 if ($('input[name=rating]:checked').length==0){
    err=true;
    msg=msg+" Please give some rating.";
  
 }
 
 if(!err){
     
    event.currentTarget.submit();
 }else{
    swal('Validation Erros',msg,'warning');
    return false;
 }
}

function ShowMapUrl(th){
  var addr=$(th).attr('data-href');
 var url= "https://maps.google.com/maps?q="+addr +  "&output=embed"
  $("#mapframe").attr("src",url)
}

function showdir(th){
 var lat=$(th).attr('data-lat');
 var lang=$(th).attr('data-lang');
 var url= "https://www.google.com/maps/dir/?api=1&origin="+localStorage.getItem("lat")+","+localStorage.getItem('long')+"&destination="+lat+","+lang+"&travelmode=driving";
 $("#mapframe").attr("href",url)
 $("#mapframe").attr("_target","blank")
 window.open(url,"blank");
  
}

window.addEventListener("load",function(){
    getLocation();
    
});
  
function getLocation() {
    
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    }
  }
  
  function showPosition(position) {
      
     localStorage.setItem("lat",position.coords.latitude);
     localStorage.setItem("long",position.coords.longitude);
  }

  $("#findevbtn").click(function(e){
    e.preventDefault();
     var brand=$("#prod-models1").val();
   
    if(brand!=""){
       window.location="Shop-ev.php?model="+brand;
    }
   });

   function RenderPage(i){
     $("#filterShopData").attr("data-page",i);
    filterProd();
   }