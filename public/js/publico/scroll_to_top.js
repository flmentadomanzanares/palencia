/**
 * Created by franc on 07/06/2017.
 */
$(function () {

    var $BloqueToTop = $(".scroll_to_top");
    $(document).on("click", ".scroll_to_top", function (evt) {
        evt.preventDefault();
        $("body").animate({
            scrollTop: 0
        }, 600);
    });
    $(window).scroll(function (evt) {
        evt.preventDefault();
        mostrarOcultarToTop($(this), $BloqueToTop);
    });

    mostrarOcultarToTop = function (window, elemToTop) {
        if (window.length > 0 && elemToTop.length > 0) {
            if (window.scrollTop() <= 50) {
                elemToTop.fadeOut();
            } else {
                elemToTop.fadeIn();
            }
        }
        return false;
    };
    mostrarOcultarToTop($(window), $BloqueToTop);
});