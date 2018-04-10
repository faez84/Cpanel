var start = 2;
var count;
var offset = 250;
var duration = 300;
var placesURI;
$(document).ready(function () {




    $("body").on("click", ".show-indxchoice", function (e) {

        var splitedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var ID = splitedID[1];
        $("#limg-" + ID).attr("class", "imageload");
        $("#indexchoice-" + ID).attr("class", "imageload");
        $('#news-show').fadeOut(100);
        $('#indexchoice-show').fadeOut(100);

        $.ajax({
            type: 'POST',
            url: Routing.generate('syndex_cpanel_indexchoices_show'),
            data: {
                idF: ID,

            },
            dataType: 'json',
            success: function (data) {




                $('#show-id').html(ID);
                $('#show-type').html(data[0].type);
                $('#show-rank').html(data[0].rank);
                $('#show-status').html(data[0].status);
                $('#show-reference').html(data[0].reference);


                $('#show-createTime').html(data[0].createTime["date"]);
                if(data[0].updateTime!=null)
                    $('#show-updateTime').html(data[0].updateTime["date"]);


                $('#indexchoice-show').fadeIn(100);

                $("#limg-" + ID).attr("class", " ");
                $("#indexchoice-" + ID).attr("class", " ");


            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });


    });



});
