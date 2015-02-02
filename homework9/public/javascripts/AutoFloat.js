// 作者：周昊宇 / 1200012823
// 用于右侧目录自动浮动

$(document).ready(function () {
    var elementPosition = $('.contents').offset();

    $(window).scroll(function () {
        if ($(window).scrollTop() > elementPosition.top - 40) {
            $('.contents').css({ position: 'fixed', top: 40, left: elementPosition.left });
        } else {
            $('.contents').css({ position: 'static' });
        }
    });
});