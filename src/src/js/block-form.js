$(document).on('change', '.block-form-class', function () {
    let $this  = $(this);
    let $form  = $this.closest('.block-form');
    let $title = $form.find('.block-form-title');
    if ($title.val() === '') {
        $title.val($this.find('option:selected').text());
    }
    let url = $this.data('settings');
    $.ajax({
        url:    url + (url.indexOf('?') === -1 ? '?' : '&') + 'widget=' + encodeURIComponent($this.val()),
        method: 'get'
    })
        .done(function (data) {
            let $data = $($.parseHTML(data.trim(), true));
            if ($data.hasClass('block-form-type-data')) {
                $(document).trigger('contentprepare', [$data]);
                $form.find('.block-form-type-data').replaceWith($data);
                $(document).trigger('contentinit', [$data]);
            }
        });
});