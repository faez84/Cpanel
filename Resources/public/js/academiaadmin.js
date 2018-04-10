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
    $("body").on("click", ".deletet-publisher-btn", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $(".deletet-hp-btn").attr("class", "disabled-deletet-hp-btn");

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
                        url: Routing.generate('syndex_cpanel_academia_publisher_deleted'),
                        data: {
                            idF: ID,
                        },
                        dataType: 'json',
                        success: function (resObj) {

                            window.location.href = Routing.generate('syndex_acedemia_publishers_admin_list');
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
                            $(".disabled-deletet-publisher-btn").attr("class", "deletet-publisher-btn");

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
                    $(".disabled-deletet-publisher-btn").attr("class", "deletet-publisher-btn");

                    return false;
                }
                }
            ]
        });

    });

    $("body").on("click", ".show-publisher", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#show-loading-" + ID).attr("class", "imageload");
        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_academia_publisher_show'),
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

    $("body").on("click", ".show-research", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        currid = ID;
        $("#show-research-" + ID).attr("class", "imageload");
        $('#show-research').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_academia_research_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {


                $('#show-id').html(ID);
                $('#show-title_ar').html(data[0].title_ar);
                $('#show-title_en').html(data[0].title_en);
                $('#show-approved').html(data[0].approved);
                $('#show-content').html(data[0].contentt);
                $('#show-publisher_ar').html(data[0].publisher_ar);
                $('#show-researchReferences').html(data[0].researchReferences);
                $('#show-publisher').html(data[0].publisher);
                $('#show-category').html(data[0].category);
                $('#show-publisher_slug').html(data[0].publisher_slug);
                $('#show-tags').html(data[0].tags);
                $('#show-tagSlug').html(data[0].tagSlug);
                $('#show-contributers_ar').html(data[0].contributers_ar);
                $('#show-contributerSlug').html(data[0].contributerSlug);
                $('#show-field').html(data[0].field);
                $('#show-field_slug').html(data[0].field_slug);
                $('#show-contributers_ar').html(data[0].contributers_ar);
                $('#show-contributerSlug').html(data[0].contributerSlug);


                $('#show-publication_date').html(data[0].publication_date["date"]);
                $('#research-show').fadeIn(100);
                $("#show-research-" + ID).attr("class", " ");
                finalizeActs();
                // $('.user-statis').fadeOut(100);
                // $('#user-show').fadeIn(100);
                // $("#userid").attr("id", ID + "-0-userid-");
                // $("#useridcats").attr("id", ID + "-0-useridcats-");
                // $("#useridplaces").attr("id", ID + "-0-useridplaces-");
                // $("#useridnass").attr("id", ID + "-0-useridnass-");
                // $("#show-user-" + ID).attr("class", " ");
                // var img=data[0].image;
                // if(data[0].image=="default_profile_pic_.png")
                //     img="default_profile_pic_"+data[0].gender+".png";
                // $("#show-path").html(" " +
                //     "<img src='/web/uploads/profile/img/"+img  +
                //     "' alt='"+img  +
                //     "' width='100' height='100'/>");
                //
                // initDiv.push("#"+ID + "-0-userid-");
                // initDiv.push("#"+ID + "-0-useridcats-");
                // initDiv.push("#"+ID + "-0-useridplaces-");
                // initDiv.push("#"+ID + "-0-useridnass-");

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });


});
