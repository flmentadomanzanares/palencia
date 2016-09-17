/**
 * Created by fmentado on 04/09/2016.
 */
$(function () {
    $(document).on("click", "[data-role='menu'] ul li", function (evt) {
            //evt.preventDefault();
            //evt.stopPropagation();

            var target = $(this);
            var menu = target.closest("[data-role='menu']");

            //Mostramos el SubMenu si lo tuviera
            var nextSubMenu = target.find("ul").first();
            var actualSubMenu = target.closest("ul.active");
            if (nextSubMenu.length == 0)
                return;
            //Borramos la clase active de los hijos
            if (target.hasClass("active")) {
                var nextSubMenuActivos = target.find(".active");
                nextSubMenuActivos.each(function (idx, elem) {
                    var elem = $(elem);
                    elem.removeClass("active")
                });
                target.removeClass("active");
                return;
            }
            else if (actualSubMenu.length == 0) {
                menu.find(".active").each(function (idx, elem) {
                    var elem = $(elem);
                    elem.removeClass("active")
                });
            }
            else if (actualSubMenu.length > 0 && !target.hasClass("active") && actualSubMenu.find(".active").length > 0) {
                actualSubMenu.find(".active").each(function (idx, elem) {
                    var elem = $(elem);
                    elem.removeClass("active")
                });
            }

            if (actualSubMenu.length > 0) {
                var desplazamiento = actualSubMenu.width() - 15 + "px";
                nextSubMenu.css("margin-left", desplazamiento);
                nextSubMenu.css("margin-top", "-1.2em");
            }
            target.addClass("active");
            nextSubMenu.addClass("active");
        }
    );
});