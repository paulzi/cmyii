import bootbox from 'bootbox';

bootbox.setDefaults({"locale" : "ru"});

$(document).on('click', '[data-sure]', function (e, isPassed) {
    if (!isPassed) {
        e.stopImmediatePropagation();
        e.preventDefault();
        let that = this;
        let data = $(this).data('sure');
        let options = {
            "size":      "small",
            "message":   typeof(data) === 'string' ? data : data.message,
            "className": data.class || null,
            "callback":  function (result) {
                if (result) {
                    $(this).one('hidden.bs.modal', function () {
                        $(that).focus();
                        //document.activeElement = that;
                        $(that).trigger('click', [true]);
                    });
                }
            }
        };
        if (data.button) {
            options.buttons = { "confirm": { "label": data.button } };
        }
        bootbox.confirm(options);
    }
});