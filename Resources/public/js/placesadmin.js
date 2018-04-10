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
    $("body").on("click", ".status-oplaces", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var fhp = splitedID[2];

        var app = 100;

        if (fhp == "y") {
            app = 1;
            $('#status-' + ID + "-y").fadeOut(100);
        }
        else
            $('#status-' + ID + "-n").fadeOut(100);
        $("#show-loading-" + ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_oplace_status'),
            data: {
                idF: ID,
                status: app

            },
            dataType: 'json',
            success: function (data) {


                $("#show-loading-" + ID).attr("class", " ");

                if (fhp == "y") {


                    $('#status-p-' + ID).html('<a  id="statusBtn-' + ID + '-n"  href="#" class="status-oplaces">' +
                        '<i id="status-' + ID + '-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>' +
                        '<div class="" id="status-oplaces-' + ID + '"></div>');


                }
                else {


                    $('#status-p-' + ID).html('<a id="statusBtn-' + ID + '-y"  href="#" class="status-oplaces">' +
                        '<i id="status-' + ID + '-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>' +
                        '<div class="" id="status-oplaces-' + ID + '"></div>');
                }
                noty({
                    text: 'تم التعديل بنجاح',
                    layout: 'top',
                    theme: 'relax',
                    type: 'success',
                    timeout: 1500,
                    animation: {
                        open: {height: 'toggle'}, // jQuery animate function property object
                        close: {height: 'toggle'}, // jQuery animate function property object
                        easing: 'swing', // easing
                        speed: 500 // opening & closing animation speed
                    }
                });
            }, error: function (xhr, ajaxOptions, thrownError) {
                noty({
                    text: 'حدث خطأ',
                    layout: 'top',
                    theme: 'relax',
                    type: 'error',
                    timeout: 1500,
                    animation: {
                        open: {height: 'toggle'}, // jQuery animate function property object
                        close: {height: 'toggle'}, // jQuery animate function property object
                        easing: 'swing', // easing
                        speed: 500 // opening & closing animation speed
                    }
                });
            }
        });


    });

    $("body").on("click", ".show-ownerplace", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#show-loading-" + ID).attr("class", "imageload");
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_places_ownerplaces_admin_show'),
            data: {
                idF: ID,
            },
            dataType: 'html',
            success: function (data) {
                $('#show-section').slideDown(100);
                $('#show-section').html("");
                $('#show-section').append(data);
                $("#show-loading-"+ID).attr("class", " ");
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    });

    $("body").on("click", ".deletett-hp-btn", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $(".deletett-hp-btn").attr("class", "disabled-deletett-hp-btn");

        noty({
            text: 'هل أنت متأكد من الحذف ',
            layout: 'top',
            theme: 'relax',
            type: 'confirm',
            animation: {
                open: {height: 'toggle'}, // jQuery animate function property object
                close: {height: 'toggle'}, // jQuery animate function property object
                easing: 'swing', // easing
                speed: 500 // opening & closing animation speed
            },
            buttons: [
                {
                    addClass: 'btn btn-primary', text: 'نعم', onClick: function ($noty) {
                    $("#show-user-" + ID).attr("class", "imageload");

                    $.ajax({
                        type: 'POST',
                        url: Routing.generate('syndex_cpanel_hpplace_deleted'),
                        data: {
                            idF: ID,
                        },
                        dataType: 'json',
                        success: function (resObj) {

                            window.location.href = Routing.generate('syndex_places_hp_admin_list');
                            noty({
                                text: 'تم الحذف بنجاح',
                                layout: 'top',
                                theme: 'relax',
                                type: 'success',
                                timeout: 1000,
                                animation: {
                                    open: {height: 'toggle'}, // jQuery animate function property object
                                    close: {height: 'toggle'}, // jQuery animate function property object
                                    easing: 'swing', // easing
                                    speed: 500 // opening & closing animation speed
                                }
                            });
                            $("#show-user-" + ID).attr("class", " ");
                            if (resObj.status == "OK") {
                                $('#ad' + adId).remove();
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $(".disabled-deletett-hp-btn").attr("class", "deletett-hp-btn");

                            noty({
                                text: 'حدث خطأ',
                                layout: 'top',
                                theme: 'relax',
                                type: 'error',
                                timeout: 1500,
                                animation: {
                                    open: {height: 'toggle'}, // jQuery animate function property object
                                    close: {height: 'toggle'}, // jQuery animate function property object
                                    easing: 'swing', // easing
                                    speed: 500 // opening & closing animation speed
                                }
                            });
                        }


                    });
                    $noty.close();
                }
                },
                {
                    addClass: 'btn btn-danger', text: 'لا', onClick: function ($noty) {
                    $noty.close();
                    $(".disabled-deletett-hp-btn").attr("class", "deletett-hp-btn");

                    return false;
                }
                }
            ]
        });

    });

    var today = new Date();
    $('.datepicker').datepicker({
        format: 'mm-dd-yyyy',
        autoclose: true,
        endDate: "today",
        minDate: today
    }).on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });


    $('.datepicker').keyup(function () {

    });


    /**
     *
     */
    $("body").on("click", ".update-hpplace", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];

        var ssdate = $('#startdade-' + ID).val();
        var eedate = $('#enddate-' + ID).val();
        var d = new Date(ssdate);
        var ed = new Date(eedate);
        var yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);

        if ((d >= yesterday ) && (ed >= yesterday ) && (ed >= d)) {
            $("#forceonhp-" + ID).slideUp(100);
            $("#loadin-hpplace-" + ID).attr("class", "imageload ");
            $.ajax({
                type: 'POST',
                url: Routing.generate('syndex_cpanel_hp_changedate'),
                data: {
                    idF: ID,
                    startdate: ssdate,
                    enddate: eedate
                },
                dataType: 'json',
                success: function (data) {

                    $("#loadin-hpplace-" + ID).attr("class", " ");
                    $("#forceonhp-" + ID).slideDown(100);
                    $("#section-hpplace-" + ID).slideUp(100);
                    $("#hidehpplace-" + ID).slideUp(100);
                    $("#showhpplace-" + ID).slideDown(100);

                    $('#tdminDate-' + ID).html(ssdate);
                    $('#tdmaxDate-' + ID).html(eedate);


                    noty({
                        text: 'تم التعديل بنجاح',
                        layout: 'top',
                        theme: 'relax',
                        type: 'success',
                        timeout: 1500,
                        animation: {
                            open: {height: 'toggle'}, // jQuery animate function property object
                            close: {height: 'toggle'}, // jQuery animate function property object
                            easing: 'swing', // easing
                            speed: 500 // opening & closing animation speed
                        }
                    });

                }, error: function (xhr, ajaxOptions, thrownError) {
                    noty({
                        text: 'حدث خطأ',
                        layout: 'top',
                        theme: 'relax',
                        type: 'error',
                        timeout: 1500,
                        animation: {
                            open: {height: 'toggle'}, // jQuery animate function property object
                            close: {height: 'toggle'}, // jQuery animate function property object
                            easing: 'swing', // easing
                            speed: 500 // opening & closing animation speed
                        }
                    });
                }
            });
        }
        else {
            noty({
                text: 'حدث خطأ التاريخ المدخل غير صالح',
                layout: 'top',
                theme: 'relax',
                type: 'error',
                timeout: 1500,
                animation: {
                    open: {height: 'toggle'}, // jQuery animate function property object
                    close: {height: 'toggle'}, // jQuery animate function property object
                    easing: 'swing', // easing
                    speed: 500 // opening & closing animation speed
                }
            });
        }
    });

    /**
     *
     * @param message
     * @constructor
     */
    function ConfirmDialog(message) {
        $('<div></div>').appendTo('body')
            .html('<div><h6>' + message + '?</h6></div>')
            .dialog({
                modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                width: 'auto', resizable: false,
                buttons: {
                    Yes: function () {
                        // $(obj).removeAttr('onclick');
                        // $(obj).parents('.Parent').remove();

                        $('body').append('<h1>Confirm Dialog Result: <i>Yes</i></h1>');

                        $(this).dialog("close");
                    },
                    No: function () {
                        $('body').append('<h1>Confirm Dialog Result: <i>No</i></h1>');
                        $(this).dialog("close");
                    }
                },
                close: function (event, ui) {
                    $(this).remove();
                }
            });
    };
    $("body").on("click", ".show-phpalcebBtn", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#section-hpplace-" + ID).slideDown(100);
        $("#showhpplace-" + ID).slideUp(100);
        $("#hidehpplace-" + ID).slideDown(100);

    });
    $("body").on("click", ".hide-phpalcebBtn", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#section-hpplace-" + ID).slideUp(100);
        $("#hidehpplace-" + ID).slideUp(100);
        $("#showhpplace-" + ID).slideDown(100);

    });

    $("body").on("click", ".add-hpplace", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];

        var ssdate = $('#startdade-' + ID).val();
        var eedate = $('#enddate-' + ID).val();
        var d = new Date(ssdate);
        var ed = new Date(eedate);
        var yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);

        if ((d >= yesterday ) && (ed >= yesterday ) && (ed >= d)) {
            $("#forceonhp-" + ID).slideUp(100);
            $("#loadin-hpplace-" + ID).attr("class", "imageload ");
            $.ajax({
                type: 'POST',
                url: Routing.generate('syndex_cpanel_hp_add'),
                data: {
                    idF: ID,
                    startdate: ssdate,
                    enddate: eedate
                },
                dataType: 'json',
                success: function (data) {

                    $("#loadin-hpplace-" + ID).attr("class", " ");
                    $("#forceonhp-" + ID).slideDown(100);
                    $("#section-hpplace-" + ID).slideUp(100);
                    $("#hidehpplace-" + ID).slideUp(100);
                    $("#showhpplace-" + ID).slideDown(100);
                    noty({
                        text: 'تم التعديل بنجاح',
                        layout: 'top',
                        theme: 'relax',
                        type: 'success',
                        timeout: 1500,
                        animation: {
                            open: {height: 'toggle'}, // jQuery animate function property object
                            close: {height: 'toggle'}, // jQuery animate function property object
                            easing: 'swing', // easing
                            speed: 500 // opening & closing animation speed
                        }
                    });

                }, error: function (xhr, ajaxOptions, thrownError) {
                    noty({
                        text: 'حدث خطأ',
                        layout: 'top',
                        theme: 'relax',
                        type: 'error',
                        timeout: 1500,
                        animation: {
                            open: {height: 'toggle'}, // jQuery animate function property object
                            close: {height: 'toggle'}, // jQuery animate function property object
                            easing: 'swing', // easing
                            speed: 500 // opening & closing animation speed
                        }
                    });
                }
            });
        }
        else {
            noty({
                text: 'حدث خطأ',
                layout: 'top',
                theme: 'relax',
                type: 'error',
                timeout: 1500,
                animation: {
                    open: {height: 'toggle'}, // jQuery animate function property object
                    close: {height: 'toggle'}, // jQuery animate function property object
                    easing: 'swing', // easing
                    speed: 500 // opening & closing animation speed
                }
            });
        }

    });


    //========================================================================
    $("body").on("click", ".forceonhp-hpplace", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var fhp = splitedID[2];

        var app = 0;

        if (fhp == "n") {
            $('#forceonhp-' + ID + "-n").fadeOut(100);
        }
        else {

            app = 1;
            $('#forceonhp-' + ID + "-y").fadeOut(100);
        }
        $("#forceonhp-hpplace-" + ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_hpplace_forceonhp'),
            data: {
                idF: ID,
                forceonhp: app

            },
            dataType: 'json',
            success: function (data) {


                $("#forceonhp-hpplace-" + ID).attr("class", " ");

                if (fhp == "y") {
                    $('#forceonhp-p-' + ID).html('<a  id="forceonhpBtn-' + ID + '-n"  href="#" class="forceonhp-hpplace">' +
                        '<i id="forceonhp-' + ID + '-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>' +
                        '<div class="" id="forceonhp-hpplace-' + ID + '"></div>');


                }
                else {
                    $('#forceonhp-p-' + ID).html('<a id="forceonhpBtn-' + ID + '-y"  href="#" class="forceonhp-hpplace">' +
                        '<i id="forceonhp-' + ID + '-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>' +
                        '<div class="" id="forceonhp-hpplace-' + ID + '"></div>');
                }
                noty({
                    text: 'تم التعديل بنجاح',
                    layout: 'top',
                    theme: 'relax',
                    type: 'success',
                    timeout: 1500,
                    animation: {
                        open: {height: 'toggle'}, // jQuery animate function property object
                        close: {height: 'toggle'}, // jQuery animate function property object
                        easing: 'swing', // easing
                        speed: 500 // opening & closing animation speed
                    }
                });
            }, error: function (xhr, ajaxOptions, thrownError) {
                noty({
                    text: 'حدث خطأ',
                    layout: 'top',
                    theme: 'relax',
                    type: 'error',
                    timeout: 1500,
                    animation: {
                        open: {height: 'toggle'}, // jQuery animate function property object
                        close: {height: 'toggle'}, // jQuery animate function property object
                        easing: 'swing', // easing
                        speed: 500 // opening & closing animation speed
                    }
                });
            }
        });


    });

    $("body").on("click", ".deleted-hpplace", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var approv = splitedID[2];

        var app = 0;

        if (approv == "n") {
            $('#deleted-' + ID + "-n").fadeOut(100);
        }
        else {
            app = 1;
            $('#deleted-' + ID + "-y").fadeOut(100);
        }
        $("#deleted-hpplace-" + ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_hpplace_deleted'),
            data: {
                idF: ID,
                verif: app

            },
            dataType: 'html',
            success: function (data) {


                $("#deleted-hpplace-" + ID).attr("class", " ");

                if (approv == "y") {
                    $('#deleted-p-' + ID).html('<a  id="deletedBtn-' + ID + '-n"  href="#" class="deleted-hpplace">' +
                        '<i id="deleted-' + ID + '-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>' +
                        '<div class="" id="deleted-hpplace-' + ID + '"></div>');


                }
                else {
                    $('#deleted-p-' + ID).html('<a id="deletedBtn-' + ID + '-y"  href="#" class="deleted-hpplace">' +
                        '<i id="deleted-' + ID + '-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>' +
                        '<div class="" id="deleted-hpplace-' + ID + '"></div>');
                }

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


    $("body").on("click", ".reset-user-pass", function (e) {
        if (confirm("إعادة تعيين كلمة السر؟")) {
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


    $("body").on("click", ".show-place", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        currid = ID;
        $("#show-user-" + ID).attr("class", "imageload");
        $('#show-user').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_place_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {


                $('#show-id').html(ID);
                $('#show-name').html(data[0].name);
                $('#show-normalized').html(data[0].normalized);
                $('#show-vicinity').html(data[0].vicinity);
                $('#show-description').html(data[0].description);
                $('#show-landNumber').html(data[0].landNumber);

                $('#show-fax').html(data[0].fax);

                $('#show-email').html(data[0].email);

                $('#show-website').html(data[0].website);

                $('#show-opening_hour').html(data[0].opening_hour);

                $('#show-closing_hour').html(data[0].closing_hour);

                $('#show-holiday').html(data[0].holiday);
                $('#show-city').html(data[0].city);
                $('#show-lat').html(data[0].lat);
                $('#show-lng').html(data[0].lng);
                $('#show-rating').html(data[0].rating);
                $('#show-rateNumber').html(data[0].rateNumber);
                $('#show-hits').html(data[0].hits);
                $('#show-owner').html(data[0].ownername);
                $('#show-updateBy').html(data[0].updateusername);
                $('#show-inv_id').html(data[0].invId);
                $('#show-facebook').html(data[0].facebook);
                $('#show-twitter').html(data[0].twitter);
                $('#show-type').html(data[0].type);

                $('#show-createTime').html(data[0].createTime["date"]);
                if (data[0].updateTime != null)
                    $('#show-updateTime').html(data[0].updateTime["date"]);
                if (data[0].verifiedTime != null)
                    $('#show-verifiedTime').html(data[0].verifiedTime["date"]);

                if (data[0].verified == 1)
                    $('#show-verified').html('<i class="fa fa-check" aria-hidden="true"></i>');
                else
                    $('#show-verified').html('<i class="fa fa-times" aria-hidden="true"></i>');


                $('#user-show').fadeIn(100);

                $("#placecomments").attr("id", ID + "-0-placecomments-");
                $("#placemedia").attr("id", ID + "-0-placemedia-");


                $("#show-user-" + ID).attr("class", " ");

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    });

    $("body").on("click", ".places-media-list", function (e) {

        $("#places-media-loading").attr("class", "imageload");
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[0];
        var pos = splitedID[1];
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_place_media'),
            data: {
                idF: ID,
                curpos: pos,
            },
            dataType: 'html',
            success: function (data) {

                $('#places-media-show').fadeIn(100);
                $('#places-media-show').html("");
                $('#places-media-show').append(data);

                $("#places-media-loading").attr("class", " ");

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    });

    $("body").on("click", ".places-comments-list", function (e) {

        $("#places-comments-loading").attr("class", "imageload");
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[0];
        var pos = splitedID[1];
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_place_comments'),
            data: {
                idF: ID,
                curpos: pos,
            },
            dataType: 'html',
            success: function (data) {

                $('#places-comments-show').fadeIn(100);
                $('#places-comments-show').html("");
                $('#places-comments-show').append(data);

                $("#places-comments-loading").attr("class", " ");

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });

    });

});
