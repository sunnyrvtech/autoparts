$(document).ready(function () {
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 193) {
            $(".top-header-section").addClass("scrollActive");
        } else {
            $(".top-header-section").removeClass("scrollActive");
        }
         if ($('.navbar-static-top').is(':visible')){
             $(this).addClass("fadeInDown");
         }
    });
});