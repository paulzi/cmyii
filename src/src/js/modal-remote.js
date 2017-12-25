$(document).on('click', '.modal-remote', function (e) {
    e.preventDefault();
    let that   = this;
    let $this  = $(this);
    let $modal = $('#modal-remote');
    let modal  = $modal.data('bs.modal');
    if (modal && modal.isShown) {
        modal.hide();
        return;
    }
    let url  = $this.data('url') || $this.attr('href');
    if (url) {
        if ($this.hasClass('modal-remote-iframe')) {

            $iframe = $('<iframe>').attr('src', url);
            $iframe.one('load', function () {
                $modal.data('bs.modal.related', $this);
                $modal.modal('show', that);
            });
            $modal.find('.modal-content')
                .empty()
                .append('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>')
                .append($iframe);

        } else {
            $.ajax({url: url})
                .fail(function () {
                    PzCms.alert('Ошибка загрузки данных', 'danger');
                })
                .done(function (data) {
                    let $data = $($.parseHTML(data));
                    $(document).trigger('contentprepare', [$data]);
                    $modal.find('.modal-content').html($data);
                    $(document).trigger('contentinit', [$data]);
                    $modal.data('bs.modal.related', $this);
                    $modal.modal('show', that);
                });
        }
    }
});

$(document).on('show.bs.modal', '#modal-remote', function (e) {
    let $related = $(e.relatedTarget);
    $(this).addClass($related.data('modalClass'));
    $(this).children('.modal-dialog').addClass($related.data('modalDialogClass'));
});

$(document).on('hidden.bs.modal', '#modal-remote', function (e) {
    let $this    = $(this);
    let $related = $this.data('bs.modal.related');
    let $content = $this.find('.modal-content');
    $content.empty();
    $this.removeClass($related.data('modalClass'));
    $this.children('.modal-dialog').removeClass($related.data('modalDialogClass'));
    $this.removeData('bs.modal.related');
});