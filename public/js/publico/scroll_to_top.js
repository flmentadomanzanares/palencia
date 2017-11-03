/**
 * Created by franc on 07/06/2017.
 */
$(function () {
    var $bloqueToTop = $(".scroll_to_top");
    var $bloqueToBottom = $(".scroll_to_bottom");
    $(document).on("click", ".scroll_to_top", function (evt) {
        evt.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 600);
    });

    $(document).on("click", ".scroll_to_bottom", function (evt) {
        evt.preventDefault();
        $("html, body").animate({
            scrollTop: document.body.scrollHeight
        }, 600);
    });

    $(window).scroll(function (evt) {
        evt.preventDefault();
        mostrarOcultar($(this), $bloqueToTop, $bloqueToBottom);
    });

    var mostrarOcultar = function (window, elemToTop, elemToBottom) {
        if (elemToTop.length > 0) {
            if (window.scrollTop() <= 50) {
                elemToTop.fadeOut();
            } else {
                elemToTop.fadeIn();
            }
        }
        if (elemToBottom.length > 0) {
            if (window.height() >= document.body.clientHeight
                || window.scrollTop() + window.height() >= document.body.scrollHeight) {
                elemToBottom.fadeOut();
            } else {
                elemToBottom.fadeIn();
            }
        }
        return false;
    };
    mostrarOcultar($(window), $bloqueToTop, $bloqueToBottom);
    setTimeout(function () {
        mostrarOcultar($(window), $bloqueToTop, $bloqueToBottom)
    }, 1000);
});
