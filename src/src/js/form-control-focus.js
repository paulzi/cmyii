$(document).on('focus', '.form-control', function (e) {
    $(this).parent('.form-control-wrap').addClass('form-control-focus');
});

$(document).on('blur', '.form-control', function (e) {
    $(this).parent('.form-control-wrap').removeClass('form-control-focus');
});