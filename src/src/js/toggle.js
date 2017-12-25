$(document).on('click',  '[data-toggle="toggle"]', function (e) {
    let $target = $($(this).attr('data-target') || $(this).attr('href'));
    $target.toggleClass('toggle-on').toggleClass('toggle-off');
    if (!$(this).is(':checkbox')) {
        e.preventDefault();
    }
});