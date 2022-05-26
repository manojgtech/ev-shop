var baseurl = "https://digitalgoldbox.in/evfy/";
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
    var rloc = $("#rlocation1").val().trim();
    console.log(name, ecity, email, rloc);
    if (name == "") {

        $("#vname1 ~ span").text("This is rquired").show();
    } else if (ecity == "") {
        $("#ecity1 ~ span").text("This is rquired").show();
    } else if (email == "") {
        $("#mailuser1 ~ span").text("This is rquired").show();
    } else if (rloc == "") {
        $("#rlocation1 ~ span").text("This is rquired").show();
    } else {
        $("span.text-danger").hide();
        $.ajax({
            type: "POST",
            url: baseurl + 'vendor/quotesModel.php',
            data: { func: 'submitreq', name, ecity, email, rloc },
            success: function (response) {
                if (response == 1) {
                    $(".formalertmsg1").text("Request submitted successfully.").show();
                    $("#reqback-form")[0].reset();
                    setTimeout(() => {
                        $(".formalertmsg1").text("").hide();
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
    var rloc = $("#rlocation11").val().trim();
    console.log(name, ecity, email, rloc);
    if (name == "") {

        $("#vname11 ~ span").text("This is rquired").show();
    } else if (ecity == "") {
        $("#ecity11 ~ span").text("This is rquired").show();
    } else if (email == "") {
        $("#mailuser11 ~ span").text("This is rquired").show();
    } else if (rloc == "") {
        $("#rlocation11 ~ span").text("This is rquired").show();
    } else {
        $("span.text-danger").hide();
        $.ajax({
            type: "POST",
            url: baseurl + 'vendor/quotesModel.php',
            data: { func: 'submitreq', name, ecity, email, rloc },
            success: function (response) {
                if (response == 1) {
                    $(".formalertmsg1").text("Request submitted successfully.").show();
                    $("#reqback-form1")[0].reset();
                    setTimeout(() => {
                        $(".formalertmsg1").text("").hide();
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
 filterProd('','',event.target.value);
 });

 
 

function filterProd(val='' , filter='', sort = 'l') {
    
      
 
    $("#bloader").show();
    
    const url = new URL(window.location);
    
        url.searchParams.set('filter', val);
        filterVal = val;
    
    if(filter!=''){
        url.searchParams.set('type', filter);
        filterby = filter;
    }


    

    url.searchParams.set('sortBy', sort);
    window.history.replaceState({}, '', url);
    
    
    sortBy = sort;
    
     
    let post = {
        value: filterVal,
        sort: sortBy,
        filter: filter,
        
    }
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/ProductModel.php',
        data: { func: 'shopPage', data: post },
        success: function (response) {
            $("#bloader").hide();
            $("#shopprods").html(response);

        }
    });
}

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


function requestmodal1(id, t, pid) {
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