$(document).ready(function () {


    var endDate = new Date();
    $('.datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        maxDate: endDate

    }).on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });
    $("body").on("click", ".deletet-img-btn", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var thisid = this.id;
        var ID = splitedID[1];
        var restore = splitedID[2];
        $(".deletet-action-btn").attr("class", "disabled-deletet-action-btn");
        var img = $("#"+thisid).attr("_img");
        noty({
            text: 'هل أنت متأكد من العملية ',
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
                        url: Routing.generate($("#"+thisid).attr("_action"))+"/"+$("#"+thisid).attr("_section")+"/"+$("#"+thisid).attr("_object")+"/imgdelete",
                        data: {
                            idF: ID,
                            fld: restore,
                            img: img
                        },
                        dataType: 'json',
                        success: function (resObj) {
                            window.location.href = Routing.generate($("#"+thisid).attr("_action"))+"/"+$("#"+thisid).attr("_section")+"/"+$("#"+thisid).attr("_object")+"/nedit/"+ID;

                            noty({
                                text: 'تمت العملية بنجاح',
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
                            $(".disabled-deletet-publisher-btn").attr("class", "deletet-sction-btn");

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
                    $(".disabled-deletet-action-btn").attr("class", "deletet-action-btn");

                    return false;
                }
                }
            ]
        });

    });

    $("body").on("click", ".inedit-action", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];

        $("#show-loading-" + ID).attr("class", "imageload");
        var searchEles = document.getElementsByClassName("inedit");
        var fields = [];

        for(var i = 0; i < searchEles.length; i++) {
            var person = {
                name:searchEles[i].id,
                value:searchEles[i].value
            }
            fields.push(person);
        }
        $.ajax({
            type: 'POST',
            url: Routing.generate($("#"+this.id).attr("_action"))+"/"+$("#"+this.id).attr("_section")+"/"+$("#"+this.id).attr("_object")+"/inedit",
            data: {
                idF: ID,
                hhh: fields// JSON.stringify(fields)
            },
            dataType: 'html',
            success: function (data) {
                noty({
                    text: 'تمت العملية بنجاح',
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
                $('#inedit').html("");
                $('#inedit').append("<div></div>");
                $("#show-loading-"+ID).attr("class", " ");
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

    $("body").on("click", ".sublist-action", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var page = splitedID[2];
        var fileldid = splitedID[3];
        $("#show-loading-" + ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate($("#"+this.id).attr("_rout"))+"/"+$("#"+this.id).attr("_section")+"/"+$("#"+this.id).attr("_object")+"/nsublist",
            data: {
                idF: ID,
                page: page,
                fileldid: fileldid
            },
            dataType: 'html',
            success: function (data) {
                $('#show-section').slideDown(100);
                closeAct();
                $('#show-section').html("");
                $('#show-section').append(data);
                $("#show-loading-"+ID).attr("class", " ");
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

    function closeAct() {
        $('#stats-section').slideUp(100);
        $('#statsangledown').slideDown(100);
    }

    $("body").on("click", ".stats-bts", function (e) {
        $('#show-section').slideUp(100);
        $('#stats-section').slideDown(100);
        $('#statsangledown').slideUp(100);
    });
    $("body").on("click", ".show-close", function (e) {
        $('#show-section').slideUp(100);
        $('#stats-section').slideDown(100);
        $('#statsangledown').slideUp(100);
    });
    $("body").on("click", ".show-action", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];

        $("#show-loading-" + ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate($("#"+this.id).attr("_show"))+"/"+$("#"+this.id).attr("_section")+"/"+$("#"+this.id).attr("_object")+"/nshow",
            data: {
                idF: ID,
                d: $("#"+this.id).attr("_d")
            },
            dataType: 'html',
            success: function (data) {
                $('#show-section').slideDown(100);
                closeAct();
                $('#show-section').html("");
                $('#show-section').append(data);
                $("#show-loading-"+ID).attr("class", " ");
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
    $("body").on("click", ".deletet-action-btn", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var thisid = this.id;
        var ID = splitedID[1];
        var restore = splitedID[2];
        $(".deletet-action-btn").attr("class", "disabled-deletet-action-btn");

        noty({
            text: 'هل أنت متأكد من العملية ',
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
                        url: Routing.generate($("#"+thisid).attr("_action"))+"/"+$("#"+thisid).attr("_section")+"/"+$("#"+thisid).attr("_object")+"/ndelete",
                        data: {
                            idF: ID,
                            restore: restore
                        },
                        dataType: 'json',
                        success: function (resObj) {

                            window.location.href = Routing.generate($("#"+thisid).attr("_action"))+"/"+$("#"+thisid).attr("_section")+"/"+$("#"+thisid).attr("_object")+"/nlist";
                            noty({
                                text: 'تمت العملية بنجاح',
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
                            $(".disabled-deletet-publisher-btn").attr("class", "deletet-sction-btn");

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
                    $(".disabled-deletet-action-btn").attr("class", "deletet-action-btn");

                    return false;
                }
                }
            ]
        });

    });
    $("body").on("click", ".status-action", function (e) {
        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        var fhp = splitedID[2];
        var thisid=this.id;
        var app = 0;
        var _rout=$("#"+thisid).attr("_action");
        var _section=$("#"+thisid).attr("_section");
        var _object=$("#"+thisid).attr("_object");
        if (fhp == "y") {
            app = 1;
            $('#status-' + ID + "-y").fadeOut(100);
        }
        else
            $('#status-' + ID + "-n").fadeOut(100);
        $("#show-loading-" + ID).attr("class", "imageload");

        $.ajax({
            type: 'POST',
            url: Routing.generate(_rout)+"/"+$("#"+thisid).attr("_section")+"/"+$("#"+thisid).attr("_object")+"/nstatus",
            data: {
                idF: ID,
                op: app

            },
            dataType: 'json',
            success: function (data) {


                $("#show-loading-" + ID).attr("class", " ");

                if (fhp == "y") {


                    $('#status-p-' + ID).html('<a  id="statusBtn-' + ID + '-n" ' +
                        ' href="#" class="status-action" _action="'+_rout+'"  _section="'+_section+'"  _object="'+_object+'" >' +
                        '<i id="status-' + ID + '-n" class="fa fa-check fa-2x " aria-hidden="true"></i></a>' +
                        '<div class="" id="status-loading-' + ID + '"></div>');


                }
                else {


                    $('#status-p-' + ID).html('<a id="statusBtn-' + ID + '-y"  href="#" class="status-action" ' +
                        '_action="'+_rout+'" _section="'+_section+'"  _object="'+_object+'">' +
                        '<i id="status-' + ID + '-y" class="fa fa-times fa-2x " aria-hidden="true"></i></a>' +
                        '<div class="" id="status-loading-' + ID + '"></div>');
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
});