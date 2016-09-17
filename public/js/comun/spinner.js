/**
 * Created by fmentado on 06/05/2015.
 */
$(document).ready(function () {
    $('.spinner').css('display', 'none');
    $('.hidden').removeClass('hidden');
});
$(document).on("submit", "Form", function (evt) {
    $("div.spinner").css("display", 'block');
});