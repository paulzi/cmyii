import 'selectize';

$(document).on('contentinit', function (e, $elements) {
    $elements.find('select').not('.no-style').each(function () {
        let options = {};
        if ($(this).hasClass('select-style')) {
            options.render = {
                option: function (item, escape) {
                    return '<div><div style="' + item.style + '">' + escape(item.text) + '</div></div>';
                }
            };
        }
        $.extend(options, $(this).data('selectize') || {});
        $(this).removeClass('form-control').selectize(options);
    });
});