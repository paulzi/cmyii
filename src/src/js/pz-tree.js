import Cookies from 'js-cookie';

(function () {
    let moreClick = function (e) {
        let $li = $(this).closest('li');
        if ($li.children('ul').length === 0) {
            $li.addClass('pz-tree-loading');
            let data = {};
            data.type = $li.attr('data-type');
            if ($li.attr('data-id')) {
                data.id = $li.attr('data-id');
            }
            $.ajax({
                    'url':      $li.closest('#pz-tree-root').attr('data-url'),
                    'method':   'get',
                    'data':     data
                })
                .done(function (data) {
                    let $data = $($.parseHTML(data, true));
                    $li.append($data);
                    if ($data.children('li').length === 0) {
                        $li.children('.icon-more').remove();
                    } else {
                        $data.collapse('show');
                    }
                })
                .always(function () {
                    $li.removeClass('pz-tree-loading');
                });
        }
    };

    let subShow = function (e) {
        $(this).closest('li').addClass('pz-tree-expand');
        e.stopPropagation();
    };

    let subHide = function (e) {
        $(this).closest('li').removeClass('pz-tree-expand');
        e.stopPropagation();
    };

    let saveState = function (e) {
        let list = [];
        let root = $(this).closest('#pz-tree-root');
        root.find('.pz-tree-expand')
            .filter(':visible')
            .each(function () {
                let $this = $(this);
                let type  = $this.attr('data-type');
                let id    = $this.attr('data-id');
                list.push(type + (id ? '-' + id : ''));
            });
        Cookies.set('pz-tree', list.join(','));
    };

    $(document).on('click', '.pz-tree .icon-more', moreClick);
    $(document).on('show.bs.collapse',   '.pz-tree', subShow);
    $(document).on('hide.bs.collapse',   '.pz-tree', subHide);
    $(document).on('shown.bs.collapse',  '.pz-tree', saveState);
    $(document).on('hidden.bs.collapse', '.pz-tree', saveState);
})();