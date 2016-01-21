$(document).ready(function(){
    var $rates = $("#rates");

    /*///////////////main index page navigation*/
    $("#navigation").accordion({header: "h3"});
    $("#navigation").accordion("activate", 0);

    /*/////////////////////////////// navigation on pages except main index page*/
    var $window = $(window),$navigation = $("nav");
    $window.scroll(function() {
        if (!$navigation.hasClass("fixed") && ($window.scrollTop() > $navigation.offset().top)) {
            $navigation.addClass("fixed").data("top", $navigation.offset().top);
        }
        else if ($navigation.hasClass("fixed") && ($window.scrollTop() < $navigation.data("top"))) {
            $navigation.removeClass("fixed");
        }
    });
    $("nav li").hover(
        function(){
            $(this)
                .stop(true)
                .animate(
                {
                    height: "120px"
                },
                {
                    duration: 500,
                    easing: "easeOutBounce"
                }
            );
        },
        function(){
            $(this)
                .stop(true)
                .animate(
                {
                    height: "20px"
                },
                {
                    duration: 500,
                    easing: "easeOutCirc"
                }
            );
        }
    );
    /*///////////////////////////////////////////////////////////////////////////*/

    ////////////////////// Top of page animation
    $("li.topofpage > a[href=#]").click(function(e){
        $.scrollTo(0,"slow");
       e.preventDefault();
    });

    // Rates ////////////////// Data Table JQuery plugin
    $("#exchanges").tabs();
    if($rates.length){
        $rates.DataTable();
    }
    //if($rates.length){
    //    $rates.dataTable( {
    //        "processing": true,
    //        "serverSide": true,
    //        "ajax": "../rates/server_processing.php"
    //    } );
    //}

    ////////////// LOGIN
    $("#open").click(function(){
        $("div#panel").slideDown("slow");
    });

    $("#close").click(function(){
        $("div#panel").slideUp("slow");
    });

    $("#toggle a").click(function () {
        $("#toggle a").toggle();
    });
});


