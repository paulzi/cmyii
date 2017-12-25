import 'jquery.nicescroll';

$(document).on('contentinit', function (e, $elements) {
    $elements.find('.scroll').niceScroll({
        cursoropacitymax: 0.4,
        cursorborder: 0,
        cursorborderradius: 0,
        cursorwidth: '5px',
        bouncescroll: true
    });
});