var start = 2;
var count;
var offset = 250;
var duration = 300;
var placesURI;
$(document).ready(function () {




    $("body").on("click", ".bazar-stores", function (e) {


        $("#bazarstores").attr("class", "imageload");


        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_bazar_admin_stores'),
            data: {


            },
            dataType: 'html',
            success: function (data) {






                $('#bazar-show').fadeIn(100);
                $('#bazar-show').html("");
                $('#bazar-show').append(data);

                $("#bazarstores" ).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".bazar-products", function (e) {

        $("#bazarproducts").attr("class", "imageload");
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_bazar_admin_products'),
            data: {
            },
            dataType: 'html',
            success: function (data) {

                $('#bazar-show').fadeIn(100);
                $('#bazar-show').html("");
                $('#bazar-show').append(data);

                $("#bazarproducts" ).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".bazar-products-stores", function (e) {

        $("#productsstores").attr("class", "imageload");
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_bazar_admin_products_stores'),
            data: {
            },
            dataType: 'html',
            success: function (data) {

                $('#bazar-show').fadeIn(100);
                $('#bazar-show').html("");
                $('#bazar-show').append(data);

                $("#productsstores" ).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".bazar-stores-products", function (e) {

        $("#storesproducts").attr("class", "imageload");
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_bazar_admin_stores_products'),
            data: {
            },
            dataType: 'html',
            success: function (data) {

                $('#bazar-show').fadeIn(100);
                $('#bazar-show').html("");
                $('#bazar-show').append(data);

                $("#storesproducts" ).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".bazar-products-notdcity", function (e) {

        var ID = this.id;

        $("#bazaarprodstats").attr("class", "imageload");
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_bazar_admin_products_notdcity'),
            data: {
                idF:ID
            },
            dataType: 'html',
            success: function (data) {

                $('#bazar-show').fadeIn(100);
                $('#container').html("");
                $('#container').append(data);

                $("#bazaarprodstats" ).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


    $("body").on("click", ".bazar-stores-dnullplist", function (e) {
        var ID = this.id;

        $("#bazaarprodstats").attr("class", "imageload");
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_bazar_admin_stores_dnullplist'),
            data: {
                idF:ID  },
            dataType: 'html',
            success: function (data) {

                $('#bazar-show').fadeIn(100);
                $('#container').html("");
                $('#container').append(data);

                $("#bazaarprodstats" ).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".bazar-prods-notdstore", function (e) {
        var ID = this.id;
        $("#bazaarprodstats").attr("class", "imageload");
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_bazar_admin_prods_notdstore'),
            data: {  idF:ID
            },
            dataType: 'html',
            success: function (data) {

                $('#bazar-show').fadeIn(100);
                $('#container').html("");
                $('#container').append(data);

                $("#bazaarprodstats" ).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });
    $("body").on("click", ".bazar-prods-notddate", function (e) {
        var ID = this.id;
        $("#bazaarprodstats").attr("class", "imageload");
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_bazar_admin_prods_notddate'),
            data: {  idF:ID
            },
            dataType: 'html',
            success: function (data) {

                $('#bazar-show').fadeIn(100);
                $('#container').html("");
                $('#container').append(data);

                $("#bazaarprodstats" ).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });
    $("body").on("click", ".bazar-prods-notdcat", function (e) {
        var ID = this.id;
        $("#bazaarprodstats").attr("class", "imageload");
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_bazar_admin_prods_notdcat'),
            data: {  idF:ID
            },
            dataType: 'html',
            success: function (data) {

                $('#bazar-show').fadeIn(100);
                $('#container').html("");
                $('#container').append(data);

                $("#bazaarprodstats" ).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".show-bazar-product", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#bazar-product-" + ID).attr("class", "imageload");
        $('#news-show').fadeOut(100);
        $('#bazar-product-show').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_product_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {



                $('#show-name').html(data[0].name);
                $('#show-categoryName').html(data[0].categoryName);
                $('#show-storeName').html(data[0].storeName);
                $('#show-cityName').html(data[0].cityName);
                $('#show-slug').html(data[0].slug);
                $('#show-description').html(data[0].description);
                $('#show-price').html(data[0].price);
                $('#show-offer').html(data[0].offer);
                $('#show-phone').html(data[0].phone);
                $('#show-quantity').html(data[0].quantity);
                $('#show-totalQuantity').html(data[0].totalQuantity);
                $('#show-hits').html(data[0].hits);
                $('#show-id').val(data[0].id);

                $('#show-addedBy').html(data[0].ausername);

                $('#show-updatedBy').html(data[0].uusername);

                $('#show-approvedBy').html(data[0].apusername);


                $('#show-createTime').html(data[0].createTime["date"]);
                if(data[0].updateTime!=null)
                    $('#show-updateTime').html(data[0].updateTime["date"]);
                if(data[0].approveTime!=null)

                    $('#show-approveTime').html(data[0].approveTime["date"]);

                if(data[0].indexed==1)
                    $('#show-indexed').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-indexed').html('<i class="fa fa-times" aria-hidden="true"></i>');

                if(data[0].approved==1)
                    $('#show-approved').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-approved').html('<i class="fa fa-times" aria-hidden="true"></i>');

                $('#bazar-product-show').fadeIn(100);
                var  host= ((location.protocol) ? "https" : "http")+"://"+window.location.hostname+"/uploads/bazaar/";

                $('#show-path').html( '<img  style="width:100%; height:300px" src="' + host+data[0].logo + '" alt="'+data[0].logo+'"/>' );


                $("#bazar-product-" + ID).attr("class", " ");
                $('#images').html('');

                for (i = 0; i < data['pAttr'].length; i++) {
                    //    var host = "";
                    //    if(!data[i].url.includes("http"))


                    $('#show-attribs').append(' <div class="col-md-12 col-sm-12 div-show">'+
                        '<div align="right" style="   font-weight: bold;  ">' +data['pAttr'][i]["name"]+

                        '</div><div align="right" >' +data['pAttr'][i]["value"]
                        +
                        '</div></div>');

                }
                getProdImages(data[0].id);


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });
    $("body").on("click", ".media-remove", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];

        $("#limg-" + ID).attr("class", "imageload");
        jQuery.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_mediaggg_remove'),
            // url: Routing.generate('syndex_cpanel_bazar_product_show'),
            data: {
                idF: ID,

            },
            dataType: 'html',
            success: function (data) {
                $('#image-' + ID).remove();
                $("#limg-" + ID).attr("class", "after-delete");
            }
        });
    });
    $("body").on("click", ".approved-bazar-product", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var approv = splitedID[2];

        var app=0;

        if(approv=="n") {
            $('#approved-' + ID + "-n").fadeOut(100);
        }
        else {
            app=1;
            $('#approved-' + ID + "-y").fadeOut(100);
        }
        $("#approved-bazar-product-"+ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_product_approved'),
            data: {  idF:ID,
                approv:app

            },
            dataType: 'html',
            success: function (data) {



                $("#approved-bazar-product-"+ID ).attr("class", " ");

                if(approv=="y") {
                    $('#approved-p-' + ID).html('<a  id="approvedBtn-'+ID+'-n"  href="#" class="approved-bazar-product">'+
                        '<i id="approved-'+ID+'-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="approved-bazar-product-'+ID+'"></div>');


                }
                else {
                    $('#approved-p-' + ID).html('<a id="approvedBtn-'+ID+'-y"  href="#" class="approved-bazar-product">'+
                        '<i id="approved-'+ID+'-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="approved-bazar-product-'+ID+'"></div>');
                }

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


    $("body").on("click", ".show-bazar-store", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#bazar-store-" + ID).attr("class", "imageload");
        $('#news-show').fadeOut(100);
        $('#bazar-store-show').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_store_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {


                $('#show-id').html(ID);
                $('#show-name').html(data[0].name);
                $('#show-normalized').html(data[0].normalized);
                $('#show-slug').html(data[0].slug);
                $('#show-city').html(data[0].city);
                $('#show-description').html(data[0].description);
                $('#show-address').html(data[0].address);
                $('#show-phone').html(data[0].phone);
                $('#show-phoneAlt').html(data[0].phoneAlt);
                $('#show-email').html(data[0].email);
                $('#show-website').html(data[0].website);
                $('#show-hits').html(data[0].hits);
                $('#lat').html(data[0].lat);
                $('#lng').html(data[0].lng);

                $('#show-addedBy').html(data[0].ausername);


                //  $('#show-approvedBy').html(data[0].apusername);


                $('#show-createTime').html(data[0].createTime["date"]);
                if(data[0].updateTime!=null)
                    $('#show-updateTime').html(data[0].updateTime["date"]);
                if(data[0].approveTime!=null)

                    $('#show-approveTime').html(data[0].approveTime["date"]);

                if(data[0].verified==1)
                    $('#show-verified').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-verified').html('<i class="fa fa-times" aria-hidden="true"></i>');

                if(data[0].approved==1)
                    $('#show-approved').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-approved').html('<i class="fa fa-times" aria-hidden="true"></i>');

                var  host= ((location.protocol) ? "https" : "http")+"://"+window.location.hostname+"/uploads/bazaar/";

                $('#show-path').html( '<img  style="width:100%; height:300px" src="' + host+data[0].path + '" alt="'+data[0].path+'"/>' );


                $('#bazar-store-show').fadeIn(100);

                $("#bazar-store-" + ID).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });
    $("body").on("click", ".approved-bazar-store", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var approv = splitedID[2];

        var app=0;

        if(approv=="n") {
            $('#approved-' + ID + "-n").fadeOut(100);
        }
        else {
            app=1;
            $('#approved-' + ID + "-y").fadeOut(100);
        }
        $("#approved-bazar-store-"+ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_store_approved'),
            data: {  idF:ID,
                approv:app

            },
            dataType: 'html',
            success: function (data) {



                $("#approved-bazar-store-"+ID ).attr("class", " ");

                if(approv=="y") {
                    $('#approved-p-' + ID).html('<a  id="approvedBtn-'+ID+'-n"  href="#" class="approved-bazar-store">'+
                        '<i id="approved-'+ID+'-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="approved-bazar-store-'+ID+'"></div>');


                }
                else {
                    $('#approved-p-' + ID).html('<a id="approvedBtn-'+ID+'-y"  href="#" class="approved-bazar-store">'+
                        '<i id="approved-'+ID+'-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="approved-bazar-store-'+ID+'"></div>');
                }

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });
    $("body").on("click", ".verified-bazar-store", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var approv = splitedID[2];

        var app=0;

        if(approv=="n") {
            $('#verified-' + ID + "-n").fadeOut(100);
        }
        else {
            app=1;
            $('#verified-' + ID + "-y").fadeOut(100);
        }
        $("#verified-bazar-store-"+ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_store_verified'),
            data: {  idF:ID,
                verif:app

            },
            dataType: 'html',
            success: function (data) {



                $("#verified-bazar-store-"+ID ).attr("class", " ");

                if(approv=="y") {
                    $('#verified-p-' + ID).html('<a  id="verifiedBtn-'+ID+'-n"  href="#" class="verified-bazar-store">'+
                        '<i id="verified-'+ID+'-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="verified-bazar-store-'+ID+'"></div>');


                }
                else {
                    $('#verified-p-' + ID).html('<a id="verifiedBtn-'+ID+'-y"  href="#" class="verified-bazar-store">'+
                        '<i id="verified-'+ID+'-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="verified-bazar-store-'+ID+'"></div>');
                }

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".show-bazar-purchase", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#bazar-purchase-" + ID).attr("class", "imageload");
        $('#bazar-purchase-show').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_purchase_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {


                $('#show-id').html(ID);
                $('#show-slug').html(data[0].slug);
                $('#show-productName').html(data[0].productName);
                $('#show-approveQuantity').html(data[0].approveQuantity);
                $('#show-sellerReview').html(data[0].sellerReview);
                $('#show-customerReview').html(data[0].customerReview);
                $('#show-deleted').html(data[0].deleted);

                $('#show-ausername').html(data[0].ausername);
                $('#show-upsername').html(data[0].upsername);


                $('#show-quantity').html(data[0].quantity);


                $('#show-createTime').html(data[0].createTime["date"]);
                if(data[0].updateTime!=null)
                    $('#show-updateTime').html(data[0].updateTime["date"]);

                if(data[0].status==1)
                    $('#show-status').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-status').html('<i class="fa fa-times" aria-hidden="true"></i>');

                if(data[0].publish==1)
                    $('#show-publish').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-publish').html('<i class="fa fa-times" aria-hidden="true"></i>');

                $('#bazar-purchase-show').fadeIn(100);

                $("#bazar-purchase-" + ID).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


    $("body").on("click", ".status-bazar-purchase", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var approv = splitedID[2];

        var app=0;

        if(approv=="n") {
            $('#status-' + ID + "-n").fadeOut(100);
        }
        else {
            app=1;
            $('#status-' + ID + "-y").fadeOut(100);
        }
        $("#status-bazar-purchase-"+ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_purchase_status'),
            data: {  idF:ID,
                stat:app

            },
            dataType: 'html',
            success: function (data) {



                $("#status-bazar-purchase-"+ID ).attr("class", " ");

                if(approv=="y") {
                    $('#status-p-' + ID).html('<a  id="statusBtn-'+ID+'-n"  href="#" class="status-bazar-purchase">'+
                        '<i id="status-'+ID+'-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="status-bazar-purchase-'+ID+'"></div>');


                }
                else {
                    $('#status-p-' + ID).html('<a id="statusBtn-'+ID+'-y"  href="#" class="status-bazar-purchase">'+
                        '<i id="status-'+ID+'-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="status-bazar-purchase-'+ID+'"></div>');
                }

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });
    $("body").on("click", ".publish-bazar-pun", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $('#pp-' + ID  ).fadeOut(100);
        $('#publish-p-' + ID).html('<a id="pubBtn-'+ID+'-y"  href="#" class="publish-bazar-puu">'+
            '<i id="publish-'+ID+'-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>'+
            '<div class="" id="publish-bazar-purchase-'+ID+'"></div>');

    });

    $("body").on("click", ".publish-bazar-puu", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];

        $('#pp-' + ID  ).fadeIn(100);
        $('#pubBtn-'+ID+'-y').fadeOut(100);

    });
    $("body").on("click", ".publish-bazar-purchase", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var approv = splitedID[2];
        var q=0;
        var app=0;

        if(approv=="n") {
            $('#publish-' + ID + "-n").fadeOut(100);
        }
        else {
            app=1;
            q=$('#publishval-'+ID+'-y').val()
            $('#publish-' + ID + "-y").fadeOut(100);

        }
        $("#publish-bazar-purchase-"+ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_purchase_publish'),
            data: {  idF:ID,
                publis:app,
                qq:q

            },
            dataType: 'html',
            success: function (data) {



                $("#publish-bazar-purchase-"+ID ).attr("class", " ");

                if(approv=="y") {
                    $('#publish-p-' + ID).html('<a  id="publishBtn-'+ID+'-n"  href="#" class="publish-bazar-purchase">'+
                        '<i id="publish-'+ID+'-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="publish-bazar-purchase-'+ID+'"></div>');
                    $('#pp-' + ID  ).fadeOut(100);

                }
                else {
                    $('#publish-p-' + ID).html('<a id="pubBtn-'+ID+'-y"  href="#" class="publish-bazar-puu">'+
                        '<i id="publish-'+ID+'-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="publish-bazar-purchase-'+ID+'"></div>');
                }

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".show-bazar-category", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#bazar-category-" + ID).attr("class", "imageload");

        $('#bazar-category-show').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_category_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {


                $('#show-id').html(ID);
                $('#show-name').html(data[0].name);
                $('#show-normalized').html(data[0].normalized);
                $('#show-slug').html(data[0].slug);
                $('#show-parent').html(data[0].parent);
                $('#show-code').html(data[0].code);
                $('#show-deleted').html(data[0].deleted);
                $('#show-icon').html(data[0].icon);


                $('#show-addedBy').html(data[0].ausername);


                $('#show-approvedBy').html(data[0].apusername);


                $('#show-createTime').html(data[0].createTime["date"]);
                if(data[0].updateTime!=null)
                    $('#show-updateTime').html(data[0].updateTime["date"]);

                if(data[0].status==1)
                    $('#show-status').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-status').html('<i class="fa fa-times" aria-hidden="true"></i>');
                if(data[0].deleted==1)
                    $('#show-deleted').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-deleted').html('<i class="fa fa-times" aria-hidden="true"></i>');
                var  host= ((location.protocol) ? "https" : "http")+"://"+window.location.hostname+"/uploads/bazaar/";

                $('#show-icon').html( '<img  style="width:100%; height:300px" src="' + host+data[0].icon + '" alt="'+data[0].icon+'"/>' );


                $('#bazar-category-show').fadeIn(100);

                $("#bazar-category-" + ID).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


    $("body").on("click", ".status-bazar-category", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var approv = splitedID[2];

        var app=0;

        if(approv=="n") {
            $('#status-' + ID + "-n").fadeOut(100);
        }
        else {
            app=1;
            $('#status-' + ID + "-y").fadeOut(100);
        }
        $("#status-bazar-category-"+ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_category_status'),
            data: {  idF:ID,
                approv:app

            },
            dataType: 'html',
            success: function (data) {



                $("#status-bazar-category-"+ID ).attr("class", " ");

                if(approv=="y") {
                    $('#status-p-' + ID).html('<a  id="statusBtn-'+ID+'-n"  href="#" class="status-bazar-category">'+
                        '<i id="status-'+ID+'-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="status-bazar-category-'+ID+'"></div>');


                }
                else {
                    $('#status-p-' + ID).html('<a id="statusBtn-'+ID+'-y"  href="#" class="status-bazar-category">'+
                        '<i id="status-'+ID+'-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="status-bazar-category-'+ID+'"></div>');
                }

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


    $("body").on("click", ".status-bazar-attr", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var approv = splitedID[2];

        var app=0;

        if(approv=="n") {
            $('#status-' + ID + "-n").fadeOut(100);
        }
        else {
            app=1;
            $('#status-' + ID + "-y").fadeOut(100);
        }
        $("#status-bazar-attr-"+ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_attr_status'),
            data: {  idF:ID,
                approv:app

            },
            dataType: 'html',
            success: function (data) {



                $("#status-bazar-attr-"+ID ).attr("class", " ");

                if(approv=="y") {
                    $('#status-p-' + ID).html('<a  id="statusBtn-'+ID+'-n"  href="#" class="status-bazar-attr">'+
                        '<i id="status-'+ID+'-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="status-bazar-attr-'+ID+'"></div>');


                }
                else {
                    $('#status-p-' + ID).html('<a id="statusBtn-'+ID+'-y"  href="#" class="status-bazar-attr">'+
                        '<i id="status-'+ID+'-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="status-bazar-attr-'+ID+'"></div>');
                }

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


    $("body").on("click", ".show-bazar-attr", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#bazar-attr-" + ID).attr("class", "imageload");

        $('#bazar-atrribute-show').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_attribute_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {


                $('#show-id').html(ID);
                $('#show-name').html(data[0].name);
                $('#show-unit').html(data[0].unit);
                $('#show-slug').html(data[0].slug);



                $('#show-createTime').html(data[0].createTime["date"]);
                if(data[0].updateTime!=null)
                    $('#show-updateTime').html(data[0].updateTime["date"]);

                if(data[0].status==1)
                    $('#show-status').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-status').html('<i class="fa fa-times" aria-hidden="true"></i>');
                if(data[0].deleted==1)
                    $('#show-deleted').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-deleted').html('<i class="fa fa-times" aria-hidden="true"></i>');


                $('#bazar-atrribute-show').fadeIn(100);

                $("#bazar-attr-" + ID).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".status-bazar-review", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var approv = splitedID[2];

        var app=0;

        if(approv=="n") {
            $('#status-' + ID + "-n").fadeOut(100);
        }
        else {
            app=1;
            $('#status-' + ID + "-y").fadeOut(100);
        }
        $("#status-bazar-review-"+ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_review_status'),
            data: {  idF:ID,
                approv:app

            },
            dataType: 'html',
            success: function (data) {



                $("#status-bazar-review-"+ID ).attr("class", " ");

                if(approv=="y") {
                    $('#status-p-' + ID).html('<a  id="statusBtn-'+ID+'-n"  href="#" class="status-bazar-review">'+
                        '<i id="status-'+ID+'-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="status-bazar-review-'+ID+'"></div>');


                }
                else {
                    $('#status-p-' + ID).html('<a id="statusBtn-'+ID+'-y"  href="#" class="status-bazar-review">'+
                        '<i id="status-'+ID+'-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>'+
                        '<div class="" id="status-bazar-review-'+ID+'"></div>');
                }

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });
    $("body").on("click", ".show-bazar-review", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#bazar-review-" + ID).attr("class", "imageload");

        $('#bazar-review-show').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_review_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {


                $('#show-id').html(ID);
                $('#show-target').html(data[0].target);
                $('#show-targetId').html(data[0].targetId);
                $('#show-slug').html(data[0].slug);
                $('#show-authorType').html(data[0].authorType);
                $('#show-author').html(data[0].author);
                $('#show-rate').html(data[0].rate);
                $('#show-content').html(data[0].content);



                $('#show-createTime').html(data[0].createTime["date"]);
                if(data[0].updateTime!=null)
                    $('#show-updateTime').html(data[0].updateTime["date"]);

                if(data[0].status==1)
                    $('#show-status').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-status').html('<i class="fa fa-times" aria-hidden="true"></i>');
                if(data[0].deleted==1)
                    $('#show-deleted').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-deleted').html('<i class="fa fa-times" aria-hidden="true"></i>');


                $('#bazar-review-show').fadeIn(100);

                $("#bazar-review-" + ID).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });
    $("body").on("click", ".show-bazar-up", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#bazar-up-" + ID).attr("class", "imageload");

        $('#bazar-up-show').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_bazar_up_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {


                $('#show-id').html(ID);
                $('#show-name').html(data[0].name);
                $('#show-value').html(data[0].value);
                $('#show-ausername').html(data[0].ausername);




                $('#show-createTime').html(data[0].createTime["date"]);
                if(data[0].updateTime!=null)
                    $('#show-updateTime').html(data[0].updateTime["date"]);


                $('#bazar-up-show').fadeIn(100);

                $("#bazar-up-" + ID).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });

    $("body").on("click", ".add-bazar-product", function (e) {
        $vals=document.getElementsByName("values[]")
        $ids=document.getElementsByName("ids[]")

        var myArrayVals = []; //
        var myArrayIds = []; //
        for (var i = 0; i < $vals.length; i++) {
            myArrayVals[i]=($vals[i].value); // ahhh, push it
            myArrayIds[i]=($ids[i].value); // ahhh, push it
        }


        var nodesArray = Array.prototype.slice.call($vals);
        alert(myArrayIds);
        alert(myArrayVals);
        var proddata = new FormData();


        proddata.append('vals', myArrayVals);

        proddata.append('ids', myArrayIds);

        proddata.append('name', $('#cpanel_bazaar_product_type_name').val());
        proddata.append('description', $('#cpanel_bazaar_product_type_description').val());
        proddata.append('price', $('#cpanel_bazaar_product_type_price').val());
        proddata.append('quantity', $('#cpanel_bazaar_product_type_quantity').val());
        proddata.append('phone', $('#cpanel_bazaar_product_type_phone').val());
        proddata.append('city', $('#cpanel_bazaar_product_type_city').val());
        proddata.append('category', $('#cpanel_bazaar_product_type_category').val());



        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: Routing.generate('syndex_bazar_admin_product_completeadd'),
            //      dataType: "text", // Data type, HTML, json etc.
            data: proddata, processData: false,
            contentType: false,  cache: false,
            success: function (response) {
                window.location.href=Routing.generate('syndex_bazar_admin_product_list');
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    });
    $("body").on("click", "#addimag", function (e) {

        var dataimg = new FormData();

        dataimg.append('idF', $('#show-id').val());


        dataimg.append('urlF', $("#file")[0].files[0]);



        var id = $('#show-id').val();

        var url = $('#imgURL').val();

        $('#imageLoading').fadeIn(1);

        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: Routing.generate('syndex_bazar_admin_product_addimages'),
            //      dataType: "text", // Data type, HTML, json etc.
            data: dataimg, processData: false,
            contentType: false,  cache: false,
            success: function (response) {
                $('#msg').fadeIn(100);

                $("#images").html("");
                getProdImages(id);


                $('#msg').fadeOut(3000);
                $('#imageLoading').fadeOut(1);

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

                    var  host= ((location.protocol) ? "https" : "http")+"://"+window.location.hostname+"/uploads/bazaar/";

                    $('#images').append('<div class="col-md-4 col-sm-4" style="border: 1px solid #f3f3f3; padding-bottom: 2px; margin--bottom: 5px;"  id="image-' + data[i].id + '">' +
                        '<img  style="width:85px; height:88px" src="' +host+data[i].path + '"/>' +
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
        $vals=document.getElementsByName("values[]")
        $ids=document.getElementsByName("ids[]")

        var myArrayVals = []; //
        var myArrayIds = []; //
        for (var i = 0; i < $vals.length; i++) {
            myArrayVals[i]=($vals[i].value); // ahhh, push it
            myArrayIds[i]=($ids[i].value); // ahhh, push it
        }


        var nodesArray = Array.prototype.slice.call($vals);

        var proddata = new FormData();


        proddata.append('vals', myArrayVals);

        proddata.append('ids', myArrayIds);
        alert($('#id').val());
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
            contentType: false,  cache: false,
            success: function (response) {
                window.location.href=Routing.generate('syndex_bazar_admin_product_list');
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    });
});
