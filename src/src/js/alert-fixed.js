// autoclose
$(document).on('click', function (e) {
    if ($(e.target).closest('.alert-fixed').length) {
        return;
    }
    $('.alert-fixed .alert').remove();
});

window.PzCms = window.PzCms || {};
window.PzCms.alert = function (message, type) {
    $('<div class="alert alert-dismissable fade in">')
        .addClass('alert-' + type)
        .text(message)
        .prepend('<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>')
        .appendTo('.alert-fixed');
};