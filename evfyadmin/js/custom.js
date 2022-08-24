var ids = [];
var baseurl = "https://digitalgoldbox.in/evfy/";
function chechThisc(id, pid) {
    console.log(id, pid);
    if ($("#" + pid).is(":checked")) {
        if (!ids.includes(id)) {
            ids.push(id);
        }
    } else {
        if (ids.includes(id)) {
            var i = ids.indexOf(id);
            if (i > -1) {
                ids.splice(i, 1);
            }
        }
    }


}

function checkAll(id) {
    if ($("#" + id).is(":checked")) {
        $("thead input").attr("checked", "checked");
        $("tfoot input").attr("checked", "checked");
        var trs = $("tbody tr");

        if (ids.length < trs.length) {
            trs.each(function (index) {
                console.log(this);
                ids.push($(this).attr("data-id"));
                $(this).find(".pids").attr("checked", "checked");
            });
        }
    } else {
        $("thead input").removeAttr("checked");
        $("tfoot input").removeAttr("checked");
        $(".pids").removeAttr("checked");
        ids = [];
    }

}

function showEditForm(id) {
    $("#cat-form").html('');
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/catModel.php',
        data: { id: id, func: 'editC' },
        success: function (response) {
            console.log(response);
            $("#cat-form-edit").html(response);
            $("#editcatspopup").modal();
        }
    });

}

function showEditbrandForm(id) {
    $("#brand-form").html('');
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/brandModel.php',
        data: { id: id, func: 'editC' },
        success: function (response) {
            console.log(response);
            $("#brand-form-edit").html(response);
            $("#editbrandspopup").modal();
        }
    });

}
function showPDelAlert(id) {
    $("#delprodpopup_btn").attr("data-id", id);
    $("#deleteprodspopup").modal();
}
function showDelAlert(id) {
    $("#delpopup_btn").attr("data-id", id);
    $("#deletecatspopup").modal();
}
function showLinkDelAlert(id) {
    $("#dellpopup_btn").attr("data-id", id);
    $("#showLinkDelAlert").modal();
}
function showPostdelAlert(id) {
    $("#delpostpopup_btn").attr("data-id", id);
    $("#deleteblogpopup").modal();
}

function showDelBrandAlert(id) {
    $("#delpopup_btn").attr("data-id", id);
    $("#deletebrandpopup").modal();
}

// $(document).ready(function(){
//     loadCategory();
//     loadProduct();
//     loadBrands();
// });

function loadCategory() {
    $("#bloader").show();
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/catModel.php',
        data: { func: 'viewC' },
        success: function (response) {

            $("#catdiv").html(response);
            $('#catdataTable').DataTable();
            $("#bloader").hide();
        }
    });
}

function loadUsers() {
    $("#bloader").show();
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/userModel.php',
        data: { func: 'viewUser' },
        success: function (response) {

            $("#usersdiv").html(response);
            $('#catdataTable').DataTable();
            $("#bloader").hide();
        }
    });
}

function loadLinks() {
    $("#bloader").show();
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/linkmodel.php',
        data: { func: 'viewL' },
        success: function (response) {

            $("#linksdiv").html(response);
            $('#catdataTable').DataTable();
            $("#bloader").hide();
        }
    });
}


function loadClocations() {
    $("#bloader").show();
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/clocsModel.php',
        data: { func: 'viewLoc' },
        success: function (response) {

            $("#clocsdiv").html(response);
            $('#catdataTable').DataTable();
            $("#bloader").hide();
        }
    });
}




function loadBlog() {
    $("#bloader").show();
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/blogModel.php',
        data: { func: 'viewC' },
        success: function (response) {

            $("#blogdiv").html(response);
            $('#blogdataTable').DataTable();
            $("#bloader").hide();
        }
    });
}

function loadquotes() {
    $("#bloader").show();
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/quotesModel.php',
        data: { func: 'viewC', type: 2 },
        success: function (response) {

            $("#quotesdiv").html(response);
            $('#quotedataTable').DataTable();
            $("#bloader").hide();
        }
    });
}

function loadrequests() {
    $("#bloader").show();
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/quotesModel.php',
        data: { func: 'viewC', type: 1 },
        success: function (response) {

            $("#quotesdiv").html(response);
            $('#quotedataTable').DataTable();
            $("#bloader").hide();
        }
    });
}
function loadBrands() {
    $("#bloader").show();
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/brandModel.php',
        data: { func: 'viewC' },
        success: function (response) {

            $("#branddiv").html(response);
            $('#catdataTable').DataTable();
            $("#bloader").hide();
        }
    });
}
//load products
function loadProduct() {
    $("#bloader").show();
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/ProductModel.php',
        data: { func: 'viewProd' },
        success: function (response) {

            $("#prodsdiv").html(response);
            $('#prodsdataTable').DataTable();
            $("#bloader").hide();
        }
    });
}

function editCat(th) {
    //let formdata = $("#cat-form-edit").serialize();
    //var data = new FormData(formdata
    var formData = new FormData($('#cat-form-edit')[0]);
    formData.append("func", "updateC");
    fetch(baseurl + 'vendor/catModel.php',
        {
            method: 'POST',
            body: formData
        }).then(resonse =>resonse.json()).then(res=>{
               
            if (res.msg==1) {
                swal("Data saved successfully");
                
                setTimeout(() => {
                    $(".catalert").addClass("text-success").text("");
                    $("#editcatspopup").modal('hide');
                    loadCategory();
                }, 5000);


            }
        }).catch(err => {
            console.log(err);
        });

}

function editBrand(th) {
    
    var formData = new FormData($('#brand-form-edit')[0]);
    formData.append("func", "updateC");
    var name = document.getElementById("brand-form-edit").elements["name"].value;
    if (typeof name === 'undefined' || name == '' || name.length == 0) {
        $(".brandalert").text("Name required").addClass("text-success");
        return false;
    }
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/brandModel.php',
        data:  formData, 
        cache : false,
        processData: false,
         contentType: false,
        success: function (response) {
            $("#brand-form-edit")[0].reset();
            swal("Data saved successfully");
            if (response == 1) {
                setTimeout(() => {
                    $("#editbrandspopup").modal('hide');
                    loadBrands();
                    $(".brandalert").text("").addClass("text-success");
                }, 5000);
            }
        }
    });

}
function addcat(th) {
    var formdata = new FormData($('#cat-form-add')[0]);
    formdata.append("func", "addC");

    // $.ajax({
    //     type: "POST",
    //     url: baseurl + 'vendor/catModel.php',
    //     data: formdata,
    //     success: function (response) {
    //         if (response == 1) {
    //             setTimeout(() => {
    //                 $("#addcatModel").modal('hide');
    //                 $("#cat-form-add")[0].reset();
    //                 loadCategory();
    //             }, 5000);
    //         }
    //     }
    // });

    fetch(baseurl + 'vendor/catModel.php',
        {
            method: 'POST',
            body: formdata
        }).then(resonse => resonse.json()).then(res=>{


            if (res.msg==1) {

                
                swal("Data added successfully.");
                setTimeout(() => {
                    swal.close();
                    $("#addcatModel").modal('hide');
                    $("#cat-form-add")[0].reset();
                    loadCategory();
                }, 5000);

            }
        }).catch(err => {
            console.log(err);
        });


}

//add brand

function addbrand(th) {
    
    var formData = new FormData($('#cat-form-add')[0]);
    formData.append("func", "addC");
    var name = document.getElementById("cat-form-add").elements["name"].value;
    if (typeof name === 'undefined' || name == '' || name.length == 0) {
        $("#addcatModel .modal-body form").append("<p>brand name is required</p>");
        return false;
    }
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/brandModel.php',
        data:  formData, 
        cache : false,
        processData: false,
         contentType: false,
        success: function (response) {
            $("#cat-form-add")[0].reset();
            swal("Data added successfully.");
            if (response == 1) {
                setTimeout(() => {
                    $("#addbrandModel").modal('hide');
                    loadBrands();
                    swal.close();
                }, 5000);
            }
        }
    });
}

function delcat() {
    $("#deletecatspopup").modal("hide");
    var id = $("#delpopup_btn").attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/catModel.php',
        data: { func: 'delC', data: id },
        success: function (response) {
            swal("Data deleted successfully.");
            if (response == 1) {
                setTimeout(() => {
                 swal.close();
                    loadCategory();
                }, 2000);

            }
        }
    });
    
}

function dellink() {
    $("#showLinkDelAlert").modal("hide");
    var id = $("#dellpopup_btn").attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/linkmodel.php',
        data: { func: 'delL', data: id },
        success: function (response) {
            if (response == 1) {
                swal("Data deleted successfully.");
                setTimeout(() => {
swal.close();
                    loadLinks();
                }, 2000);

            }
        }
    });
    
}
    
function delProd() {
    $("#deleteprodspopup").modal("hide");
    var id = $("#delprodpopup_btn").attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/ProductModel.php',
        data: { func: 'delC', data: id },
        success: function (response) {
            if (response == 1) {
                swal("Data deleted successfully.");
                setTimeout(() => {
swal.close();
                    loadProduct();
                }, 2000);

            }
        }
    });


}

function delbrand() {
    $("#deletebrandpopup").modal("hide");
    var id = $("#delpopup_btn").attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/brandModel.php',
        data: { func: 'delC', data: id },
        success: function (response) {
            if (response == 1) {
                swal("Data deleted successfully.");

                setTimeout(() => {
                    swal.close();
                    loadBrands();
                }, 2000);

            }
        }
    });

}


//delete brand
function delpost() {
    $("#deleteblogpopup").modal("hide");
    var id = $("#delpostpopup_btn").attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/blogModel.php',
        data: { func: 'delC', data: id },
        success: function (response) {
            swal("Post deleted successfully.")
            if (response == 1) {
                setTimeout(() => {
                  swal.close();
                    loadBlog();
                }, 2000);

            }
        }
    });



}

$('#file').fileinput({
    theme: 'fas',

    uploadUrl: '#',
    allowedFileExtensions: ['jpg', 'png', 'gif']
});


//show brands

function showprodbrand(id) {
    var cat = $("#" + id).val();

    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/brandModel.php',
        data: { func: 'showcatbrand', data: cat },
        success: function (response) {
            if (response != '0') {
                var resp = JSON.parse(response);
                var html = "";
                resp.forEach(row => {
                    console.log(row);
                    html += `<option value=${row.id}>${row.brand_name}</option>`;
                });
                $("#product_ibrands").html(html);
            } else {
                html = `<option value='0'>No brand</option>`;
                $("#product_ibrands").html(html);
            }

        }
    });


}
//toggle visible specs

function toggleSpecs(val) {
    console.log(val);
    if (val == 'yes') {
        $("#specsDiv").show();
    } else {
        $("#specsDiv").hide();
    }
}

//open lightbox



$(function () {
    /* BOOTSNIPP FULLSCREEN FIX */
    if (window.location == window.parent.location) {
        $('#back-to-bootsnipp').removeClass('hide');
        $('.alert').addClass('hide');
    }

    $('#fullscreen').on('click', function (event) {
        event.preventDefault();
        window.parent.location = "http://bootsnipp.com/iframe/Q60Oj";
    });

    $('tbody > tr').on('click', function (event) {
        event.preventDefault();
        $('#myModal').modal('show');
    })

    $('.btn-mais-info').on('click', function (event) {
        $('.open_info').toggleClass("hide");
    })


});


function showProductModal(id) {
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/ProductModel.php',
        data: { func: 'getProduct', data: id },
        success: function (response) {
            if (response != '0') {

                $("#product_ibrands").html(html);
            } else {
                html = `<option value='0'>No brand</option>`;
                $("#product_ibrands").html(html);
            }

        }
    });

}

$('#carouselExampleSlidesOnly').carousel();

function blogslug(v) {
    if (v.length != 0) {
        var vs = v.replace(/[^a-zA-Z0-9\- ]/g, "");
        vs = vs.replace(/\s\s+/g, ' ');
        $("#bpostname").val(vs);
        var slug = vs.replace(/\s/g, '-');
        $("#postslug").val(slug.toLowerCase());
    }
}

function getslug(v, id) {
    if (v.length != 0) {
        var vs = v.replace(/[^a-zA-Z0-9\- ]/g, "");
        vs = vs.replace(/\s\s+/g, ' ');
        $("#" + id).val(vs);
        var slug = vs.replace(/\s/g, '-');
        $("#" + id).val(slug.toLowerCase());
    }
}


//best
function markbest(th) {

    if (ids.length > 0) {
        $.ajax({
            type: "POST",
            url: baseurl + 'vendor/ProductModel.php',
            data: { func: 'bestProduct', data: JSON.stringify(ids) },
            success: function (response) {
                console.log(response);
                loadProduct();
            }
        });


    }
}

function markfeatured(th) {

    if (ids.length > 0) {
        $.ajax({
            type: "POST",
            url: baseurl + 'vendor/ProductModel.php',
            data: { func: 'markfeatured', data: JSON.stringify(ids) },
            success: function (response) {
                console.log(response);
                loadProduct();
            }
        });


    }
}

//mark favourite 
function markitf(id, type) {
    var pc = (type == 1) ? 'featured_' : 'best_';
    console.log("#" + pc + id);
    var pid = $("#" + pc + id).attr("data-val");
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/ProductModel.php',
        data: { func: 'markPrd', product: id, val: pid, type: type },
        success: function (response) {
            if (type == 1) {
                $("#" + pc + id).attr("data-val", 0);
                $("#" + pc + id).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $("#" + pc + id).attr("data-val", 1);
                $("#" + pc + id).removeClass('fa-eye-slash').addClass("fa-eye");
            }


        }
    });


}

// form validation

$('#fileupload').validate({
    rules: {
        product_name: {
            required: true,
            number: false
        },
        
        product_categories: {
            required: true,

        },
        brand: {
            required: true,

        },
        model: {
            required: true,
            number: false
        },
        product_description: {
            required: true,
            minlength: 100
        },
        available_quantity: {
            required: true,
            number: true
        },
        ex_showroom_rpice: {
            required: true,
            
        },
        test_upload: {
        required: true,
        accept: "image/*"
    },
    "files": {
        required: true,
        accept: "image/*"
    }

    },
    //Submit Handler Function  files[]
    submitHandler: function (form) {
        form.submit();
    }

});

//custom.js

function searchlink(v,i){
    if(v.length>2){
        $.ajax({
            type: "POST",
            url: baseurl + 'vendor/linkmodel.php',
            data: { func: 'searchLinks', val:v,n:i },
            success: function (response) {
                $(".linkresult").html(response);
    
            }
        });
    }{
        $(".linkresult").html("");
    }
}

function feedit(id,n){
    let s= $("#"+id).attr("data-id");
    let slug= $("#"+id).attr("data-slug");
    let type= $("#"+id).attr("data-type");
     let t=$("#"+id).text();
     $("#searchtxtid"+n).val("");
      let t1=t.split("(");
     $("#addlinktitle"+n).val(t1[0]);
     $(".ltype").text("("+t1[1].trim().slice(0, -1)+")");
     $("#ltype"+n).val(t1[1].trim().slice(0, -1));
     var link="";
     if(type=="Product"){
         link=baseurl+"Shop-ev.php?product="+slug;
     }else if(type=="Product"){
         link=baseurl+"Shop-ev.php?product="+slug;
     }else if(type=="Brand"){
        link=baseurl+"Shop-ev.php?brand="+slug;
    }else{
        link=baseurl+"Shop-ev.php?cat="+slug;
     }
     $("#custlink"+n).val(link);
     $(".linkresult").html("");
 }

 //add link
 function addlink(th){
    var formData = new FormData($('#link-form-add')[0]);
    formData.append("func", "addL");
    fetch(baseurl + 'vendor/linkmodel.php',
        {
            method: 'POST',
            body: formData
        }).then(resonse =>resonse).then(res=>{
               
            
                swal("Data saved successfully");
                setTimeout(() => {
                    swal.close();
                    $("#addLinkModel").modal('hide');
                    loadLinks();
                }, 5000);


            
        }).catch(err => {
            console.log(err);
        });
 }


 function updateLink(th){
    var formData = new FormData($('#link-form-edit')[0]);
    formData.append("func", "updateL");
    fetch(baseurl + 'vendor/linkmodel.php',
        {
            method: 'POST',
            body: formData
        }).then(resonse =>resonse).then(res=>{
            swal("Data saved successfully");
                setTimeout(() => {
                    swal.close();
                    $("#editlinkspopup").modal('hide');
                    loadLinks();
                }, 5000);


            
        }).catch(err => {
            console.log(err);
        });
 }


 function showviewquotes(id){
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/quotesModel.php',
        data: { func: 'showrequests', val:id },
        success: function (response) {
            var res=JSON.parse(response);
            
            res=res[0];
            var html="<table class='table'>";
               html=html+"<tr><th>Name</th><td>"+res.name+"</td></tr>";
               html=html+"<tr><th>Email</th><td>"+res.email+"</td></tr>";
               html=html+"<tr><th>Phone</th><td>"+res.mobile+"</td></tr>";
               html=html+"<tr><th>Assress</th><td><address>"+res.address+"<address></td></tr>";
               html=html+"<tr><th>Date</th><td><address>"+res.created_at+"<address></td></tr>";
               if(res.type==2){
                 html=html+"<tr><th>Product</th><td><address>"+res.product_id+"<address></td></tr>";
                 html=html+"<tr><th>Comment</th><td><blockquote>"+res.comment+"<blockquote></td></tr>";
               }
               html=html+"</table>";
            $("#showrequestmodel .card-body").html(html);
            $("#showrequestmodel").modal('show');

             
        }
    });

 }

 function showLinkEditForm(id){
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/linkmodel.php',
        data: { func: 'editL', val:id },
        success: function (response) {
            var res=JSON.parse(response);
              $("#custlink2").val(res.url);
              $("#addlinktitle2").val(res.title);
              $("#custlink2").val(res.url);
              $("#parentlink2 option").each(function(){
                 if($(this).val()===res.parent && res.parent!=0){
                    $(this).attr("selected",'selected');
                 }
              });
              $("#linkid").val(res.id);
            $("#order2").val(res.linkorder);
            $("#editlinkspopup").modal('show');
        }
    });
    
 }


 function showloceditform(id){
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/clocsModel.php',
        data: { func: 'editLoc', val:id },
        success: function (response) {
            var res=JSON.parse(response);
              $("#locname").val(res.loc_title);
              $("#locaddress").val(res.address);
            
              $("#locstate option").each(function(){
                 if($(this).val()===res.state){
                    $(this).attr("selected",'selected');
                 }
              });
              $("#locid").val(id);
              $("#locstate").trigger("change");
              $("#loclink").val(res.map);
             setTimeout(() => {
                $("#loccity option").each(function(){
                    if($(this).val()===res.city){
                       $(this).attr("selected",'selected');
                    }
                 });
             }, 2000);
            $("#editclocspopup").modal('show');
        }
    });
    
 }


 //cities

 function selectCity(v,i) {
    $.ajax({
        type: "POST",
        url: baseurl + 'vendor/quotesModel.php',
        data: { func: 'cities', data: v },
        success: function (response) {
        
            $("#"+i).html(response);
            
        }
    });
}


function addStations(th){
    var formData = new FormData($('#addStations')[0]);
    formData.append("func", "addLoc");
    fetch(baseurl + 'vendor/clocsModel.php',
        {
            method: 'POST',
            body: formData
        }).then(resonse =>resonse).then(res=>{
               
            
                swal("Data saved successfully");
                setTimeout(() => {
                    swal.close();
                    $("#addChargingModel").modal('hide');
                    loadClocations();
                }, 5000);


            
        }).catch(err => {
            console.log(err);
        });

}


function updateLoc(th){
    var formData = new FormData($('#updateStations')[0]);
    formData.append("func", "updateLoc");
    fetch(baseurl + 'vendor/clocsModel.php',
        {
            method: 'POST',
            body: formData
        }).then(resonse =>resonse).then(res=>{
               
            
                swal("Data saved successfully");
                setTimeout(() => {
                    swal.close();
                    $("#editclocspopup").modal('hide');
                    loadClocations();
                }, 5000);


            
        }).catch(err => {
            console.log(err);
        });

}


function showDelLoc(id){
    swal({
        title: "Are you sure?",
        text: "Do you want to delete it!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        $.ajax({
            type: "POST",
            url: baseurl + 'vendor/clocsModel.php',
            data: { func: 'delLoc', data: id },
            success: function (response) {
                
                if (response == 1) {
                    swal("Location has been deleted!", {
                        icon: "success",
                      });
                    setTimeout(() => {
                      swal.close();
                        loadBlog();
                    }, 2000);
    
                }
            }
        });
        
      });
}