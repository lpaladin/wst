// ���ߣ������ / 1200012823
// �����Ҳ�Ŀ¼�Զ�����

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