(function () {

    PzCms.setClipboard = function (item) {
        if (!Array.isArray(item)) {
            item = [item];
        }
        localStorage.setItem('pzCopy', JSON.stringify(item));
        checkCond();
        $(document).trigger('pzcopy', [item]);
    };

    PzCms.getClipboard = function (item) {
        let data = localStorage.getItem('pzCopy');
        return data ? JSON.parse(data) : [];
    };

    let checkCond = function () {
        let items = PzCms.getClipboard();
        $(document).find('.pz-copy-cond').each(function () {
            let isHidden = false;
            let cond = $(this).data('pzCopyCond');
            for (let i = 0; i < items.length; i++) {
                if (!PzCms.checkCondition(items[i], cond)) {
                    isHidden = true;
                }
            }
            $(this).toggleClass('hidden', isHidden);
        });
    };

    $(document).on('contentinit', checkCond);

    $(document).on('click', '.pz-copy', function (e) {
        e.preventDefault();
        PzCms.setClipboard($(this).data('pzCopy'));
    });

    $(document).on('click', '.pz-copy-param', function () {
        let $form   = $(this).closest('form');
        let $hidden = $('<input type="hidden" name="items">').val(JSON.stringify(PzCms.getClipboard())).appendTo($form);
        setTimeout(function () {
            $hidden.remove();
        }, 300);
    });
})();