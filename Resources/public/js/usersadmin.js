var start = 2;
var count;
var offset = 250;
var duration = 300;
var placesURI;
var divsArray = new Array();

var initDiv = [];

$(document).ready(function () {

    if ($(window).width() < 500) {
        $("#maintab").attr("class", " ");
    }

    $("body").on("click", ".enabled-users", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var approv = splitedID[2];

        var app = 0;

        if (approv == "n") {
            $('#enabled-' + ID + "-n").fadeOut(100);
        }
        else {
            app = 1;
            $('#enabled-' + ID + "-y").fadeOut(100);
        }
        $("#enabled-users-" + ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_users_enabled'),
            data: {
                idF: ID,
                verif: app

            },
            dataType: 'html',
            success: function (data) {


                $("#enabled-users-" + ID).attr("class", " ");

                if (approv == "y") {
                    $('#enabled-p-' + ID).html('<a  id="enabledBtn-' + ID + '-n"  href="#" class="enabled-users">' +
                        '<i id="enabled-' + ID + '-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>' +
                        '<div class="" id="enabled-users-' + ID + '"></div>');


                }
                else {
                    $('#enabled-p-' + ID).html('<a id="enabledBtn-' + ID + '-y"  href="#" class="enabled-users">' +
                        '<i id="enabled-' + ID + '-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>' +
                        '<div class="" id="enabled-users-' + ID + '"></div>');
                }

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


    $("body").on("click", ".reset-user-pass", function (e) {
        if (confirm("إعادة تعيين كلمة السر؟"))
        {
            // continue with delete

            var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
            var ID = splitedID[1];
            var approv = splitedID[2];

            var app = 0;

            $("#show-user-" + ID).attr("class", "imageload");

            $.ajax({
                type: 'POST',
                url: Routing.generate('syndex_cpanel_users_resert_pass'),
                data: {
                    idF: ID,
                    verif: app

                },
                dataType: 'html',
                success: function (data) {


                    $("#show-user-" + ID).attr("class", " ");


                }, error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });

        }
    });


    $("body").on("click", ".show-user", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        currid = ID;
        $("#show-user-" + ID).attr("class", "imageload");
        $('#show-user').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_user_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {


                $('#show-id').html(ID);
                $('#show-username').html(data[0].username);
                $('#show-firstName').html(data[0].firstName);
                $('#show-lastName').html(data[0].lastName);
                $('#show-address').html(data[0].address);
                $('#show-gender').html(data[0].gender);

                $('#show-createdAt').html(data[0].createdAt["date"]);
                if (data[0].updatedAt != null)
                    $('#show-updatedAt').html(data[0].updatedAt["date"]);
                if (data[0].lastLogin != null)
                    $('#show-lastLogin').html(data[0].lastLogin["date"]);

                if (data[0].enabled == 1)
                    $('#show-enabled').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-enabled').html('<i class="fa fa-times" aria-hidden="true"></i>');

                if (data[0].emailConfirmed == 1)
                    $('#show-emailConfirmed').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-emailConfirmed').html('<i class="fa fa-times" aria-hidden="true"></i>');
                finalizeActs();
                $('.user-statis').fadeOut(100);
                $('#user-show').fadeIn(100);
                $("#userid").attr("id", ID + "-0-userid-");
                $("#useridcats").attr("id", ID + "-0-useridcats-");
                $("#useridplaces").attr("id", ID + "-0-useridplaces-");
                $("#useridnass").attr("id", ID + "-0-useridnass-");
                $("#show-user-" + ID).attr("class", " ");
                var img=data[0].image;
                if(data[0].image=="default_profile_pic_.png")
                    img="default_profile_pic_"+data[0].gender+".png";
                $("#show-path").html(" " +
                    "<img src='/web/uploads/profile/img/"+img  +
                    "' alt='"+img  +
                    "' width='100' height='100'/>");

                initDiv.push("#"+ID + "-0-userid-");
                initDiv.push("#"+ID + "-0-useridcats-");
                initDiv.push("#"+ID + "-0-useridplaces-");
                initDiv.push("#"+ID + "-0-useridnass-");

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".user-show-close", function (e) {

        $('.user-statis').fadeIn(100);
        $('#user-show').fadeOut(100);
        finalizeActs();
    });

    $("body").on("click", ".user-products-list", function (e) {

        $("#user-prods-list").attr("class", "imageload");
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[0];
        var pos = splitedID[1];
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_user_products'),
            data: {
                idF: ID,
                curpos: pos,
            },
            dataType: 'html',
            success: function (data) {

                $('#user-prods-show').fadeIn(100);
                $('#user-prods-show').html("");
                $('#user-prods-show').append(data);

                $("#user-prods-list").attr("class", " ");

                //push a new div obj to public array
                var divObj = {
                    divid: "#" + ID + "-0-userid-",
                    orgclass: "user-products-list",
                    divclass: "#user-prods-show"

                };
                finalizeAct(divObj);

                divsArray.push(divObj);


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".user-cats-list", function (e) {

        $("#show-user-groups").attr("class", "imageload");
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[0];
        var pos = splitedID[1];
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_user_cats'),
            data: {
                idF: ID,
                curpos: pos,
            },
            dataType: 'html',
            success: function (data) {

                $('#user-cats-show').fadeIn(100);
                $('#user-cats-show').html("");
                $('#user-cats-show').append(data);

                $("#show-user-groups").attr("class", " ");

                //push a new div obj to public array
                var divObj = {
                    divid: "#" + ID + "-0-useridcats-",
                    orgclass: "user-cats-list",
                    divclass: "#user-cats-show"

                };
                finalizeAct(divObj);

                divsArray.push(divObj);


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });
    $("body").on("click", ".mobilebtn", function (e) {
        $("#show-user-mobile").attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_user_mobile_stats'),
            data: {},
            dataType: 'html',
            success: function (data) {


                $('#mobilesection').html("");
                $('#mobilesection').append(data);
                $('#mobilesection').slideDown("slow");

                $("#show-user-mobile").attr("class", " ");
                var divObj = {
                    divid: "#mobilebtnn",
                    orgclass: "mobilebtn",
                    divclass: "#mobilesection"

                };
                finalizeAct(divObj);

                divsArray.push(divObj);

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


    function finalizeActs() {
        if (divsArray.length > 0) {
            for (i = 0; i < divsArray.length; i++) {

                $($(divsArray[i].divid).attr("divclass")).slideUp();
                $(divsArray[i].divid).attr("class", "fa fa-angle-down " + divsArray[i].orgclass);
                $(divsArray[i].divid).html(" ");
                var splitedID = divsArray[i].divid.split('-'); //Split ID string (Split works as PHP explode)
                $(divsArray[i].divid).attr("id", splitedID[2]);
            }

            divsArray = [];
        }
        else {
            for(i=0; i<initDiv.length;i++) {

                var splitedID = initDiv[i].split('-'); //Split ID string (Split works as PHP explode)

                $(initDiv[i]).attr("id", splitedID[2]);
            }
            initDiv=[];
        }
    }

    function finalizeAct($obj) {
        $($obj.divid).attr("class", "fa fa-angle-up ");
        $($obj.divid).attr("orgclass", $obj.orgclass);
        $($obj.divid).attr("divclass", $obj.divclass);
        //$($divid2).html("");
        //$($divid2).fadeOut(1);
    }

    $("body").on("click", ".fa-angle-up", function (e) {

        $($(this).attr("divclass")).slideUp();
        $(this).attr("class", "fa fa-angle-down " + $(this).attr("orgclass"));

    });


    $("body").on("click", ".delete-group", function (e) {

        $("#show-user-groups").attr("class", "imageload");
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[0];
        var userId = splitedID[1];

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_user_cats_remove'),
            data: {
                idF: ID,
                userid: userId
            },
            dataType: 'html',
            success: function (data) {




                $("#show-user-groups").attr("class", " ");
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".add-group", function (e) {

        $("#show-user-groups").attr("class", "imageload");
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[0];
        var userId = splitedID[1];

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_user_groups_add'),
            data: {
                idF: ID,
                userid: userId
            },
            dataType: 'html',
            success: function (data) {


                $("#show-user-groups").attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


    $("body").on("click", ".user-places-list", function (e) {

        $("#user-places-list").attr("class", "imageload");
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[0];
        var pos = splitedID[1];
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_user_places'),
            data: {
                idF: ID,
                curpos: pos,
            },
            dataType: 'html',
            success: function (data) {

                $('#user-places-show').fadeIn(100);
                $('#user-places-show').html("");
                $('#user-places-show').append(data);

                $("#user-places-list").attr("class", " ");

                //push a new div obj to public array
                var divObj = {
                    divid: "#" + ID + "-0-useridplaces-",
                    orgclass: "user-places-list",
                    divclass: "#user-places-show"

                };
                finalizeAct(divObj);

                divsArray.push(divObj);


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".user-nass-list", function (e) {

        $("#show-user-nass").attr("class", "imageload");
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[0];
        var pos = splitedID[1];
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_user_nass'),
            data: {
                idF: ID,
                curpos: pos,
            },
            dataType: 'html',
            success: function (data) {

                $('#user-nass-show').fadeIn(100);
                $('#user-nass-show').html("");
                $('#user-nass-show').append(data);

                $("#show-user-nass").attr("class", " ");

                //push a new div obj to public array
                var divObj = {
                    divid: "#" + ID + "-0-useridnass-",
                    orgclass: "user-nass-list",
                    divclass: "#user-nass-show"

                };
                finalizeAct(divObj);

                divsArray.push(divObj);

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".user-nass-updateBtn", function (e) {

        $('.user-nass-update').fadeIn(100);

    });

    $("body").on("click", ".user-nass-scoren", function (e) {

        $('.user-nass-update').fadeOut(100);

    });
    $("body").on("click", ".user-nass-scorey", function (e) {

        $("#user-prods-list").attr("class", "imageload");
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        q = $('#scoreval-' + ID + '-y').val()
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_user_nass_update_score'),
            data: {
                idF: ID,
                val: q,

            },
            dataType: 'html',
            success: function (data) {

                $('.user-nass-update').fadeOut(100);
                $('#score-valk').html(q);


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });

    });


    function getProdImages(id) {

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_bazar_admin_product_images'),
            data: {
                idF: id,

            },
            dataType: 'json',
            success: function (data) {
                $('#imageLoading').fadeIn(1);

                for (i = 0; i < data.length; i++) {
                    //    var host = "";

                    //    if(!data[i].url.includes("http"))

                    var host = ((location.protocol) ? "https" : "http") + "://" + window.location.hostname + "/uploads/bazaar/";

                    $('#images').append('<div class="col-md-4 col-sm-4" style="border: 1px solid #f3f3f3; padding-bottom: 2px; margin--bottom: 5px;"  id="image-' + data[i].id + '">' +
                        '<img  style="width:85px; height:88px" src="' + host + data[i].path + '"/>' +
                        '<div style="    margin: 10px;"><div class="col-md-6 col-sm-6">' +
                        ' <i class="fa fa-trash-o fa-lg media-remove" id="imgfam-' + data[i].id + '"></i></div>' +
                        '<div class="  class="col-md-6 col-sm-6" id="limg-' + data[i].id + '"></div>' +
                        '' +
                        '</div></div>');
                }
                $('#imageLoading').fadeOut(1);
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    }

    $("body").on("click", ".update-bazar-product", function (e) {
        $vals = document.getElementsByName("values[]")
        $ids = document.getElementsByName("ids[]")

        var myArrayVals = []; //
        var myArrayIds = []; //
        for (var i = 0; i < $vals.length; i++) {
            myArrayVals[i] = ($vals[i].value); // ahhh, push it
            myArrayIds[i] = ($ids[i].value); // ahhh, push it
        }


        var nodesArray = Array.prototype.slice.call($vals);

        var proddata = new FormData();


        proddata.append('vals', myArrayVals);

        proddata.append('ids', myArrayIds);

        proddata.append('id', $('#id').val());
        proddata.append('name', $('#cpanel_bazaar_product_type_name').val());
        proddata.append('description', $('#cpanel_bazaar_product_type_description').val());
        proddata.append('price', $('#cpanel_bazaar_product_type_price').val());
        proddata.append('quantity', $('#cpanel_bazaar_product_type_quantity').val());
        proddata.append('phone', $('#cpanel_bazaar_product_type_phone').val());
        proddata.append('city', $('#cpanel_bazaar_product_type_city').val());
        proddata.append('category', $('#cpanel_bazaar_product_type_category').val());


        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: Routing.generate('syndex_bazar_admin_product_completeupdate'),
            //      dataType: "text", // Data type, HTML, json etc.
            data: proddata, processData: false,
            contentType: false, cache: false,
            success: function (response) {
                window.location.href = Routing.generate('syndex_bazar_admin_product_list');
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    });
});
