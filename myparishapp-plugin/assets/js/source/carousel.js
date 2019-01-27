const mpaCarousel = (function ($) {

    let slideWidth;

    function moveLeft() {
        $('#slider ul').animate({
            left: +slideWidth
        }, 300, function () {
            $('#slider ul li:last-child').css({
                display: "none"
            });
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
            $('#slider ul li:first-child').css({
                display: "block"
            });
        });
    }

    function moveRight() {
        $('#slider ul').animate({
            left: -slideWidth
        }, 300, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
        })
    }

    function init() {
        slideWidth = $('#slider ul li').width();
        $('.my_parish_control_prev').click(moveLeft);
        $('.my_parish_control_next').click(moveRight);
    }

    return {
        init: init
    }

})(window.jQuery);


$(document).ready(mpaCarousel.init());