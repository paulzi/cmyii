$(document).on('contentinit', function (e, $elements) {
    $elements.find('form').on('submit', function (e) {
        let $form = $(this),
            data = $form.data('yiiActiveForm');
        let $btn = $(document.activeElement);
        if ($btn.hasClass('btn-no-validate')) {
            data.validated = true;
        }
        if ($form.hasClass('form-simple-validate') || $btn.hasClass('btn-simple-validate')) {
            $form.yiiActiveForm('validate');
            if ($form.find('.has-error').length) {
                e.stopImmediatePropagation();
                e.preventDefault();
                return false;
            } else {
                data.validated = true;
            }
        }
    });
});