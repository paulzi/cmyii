import Sortable from 'sortablejs';

(function () {
    let massOn = function () {
        $(this).find('.lv-mass-check input[type="checkbox"]').prop('checked', false);
    };

    let reorderOn = function () {
        $(this).find('.lv-mass-check input[type="checkbox"]').prop('checked', true);

        let $list  = $(this).find('.lv-items').first();
        let $tbody = $list.children('table').children('tbody');
        $list = $tbody.length ? $tbody : $list;
        let sortable = Sortable.create($list[0], {});
        $(this).data('lvSortable',     sortable);
        $(this).data('lvSortableData', sortable.toArray());
    };

    let reorderOff = function () {
        let sortable = $(this).data('lvSortable');
        let data     = $(this).data('lvSortableData');
        sortable.sort(data);
        sortable.destroy();
    };

    let setMode = function (mode) {
        let old = $(this).data('lvMode');
        if (old) {
            $(this).removeClass('lv-' + old + '-on').addClass('lv-' + old + '-off');
            if (modes[old][1]) {
                modes[old][1].apply(this);
            }
        }
        if (mode) {
            $(this).removeClass('lv-' + mode + '-off').addClass('lv-' + mode + '-on');
            if (modes[mode][0]) {
                modes[mode][0].apply(this);
            }
        }
        $(this).data('lvMode', mode);
    };

    let toggleMode = function (mode) {
        if ($(this).hasClass('lv-' + mode + '-on')) {
            setMode.call(this, false);
        } else {
            setMode.call(this, mode);
        }
    };

    let modes = {
        mass:    [massOn,    false],
        reorder: [reorderOn, reorderOff]
    };

    $(document).on('click', '.lv-mass-toggler', function (e) {
        e.preventDefault();
        let $lv = $(this).closest('.lv');
        toggleMode.call($lv[0], 'mass');
    });

    $(document).on('click', '.lv-mass-all', function (e) {
        e.preventDefault();
        let $list = $(this).closest('.lv').find('.lv-mass-check input[type="checkbox"]');
        if ($list.filter(function () { return !this.checked; }).length) {
            $list.prop('checked', true);
        } else {
            $list.prop('checked', false);
        }
    });

    $(document).on('click', '.lv-mass-copy', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let items = [];
        let $lv = $(this).closest('.lv');
        $lv.find('.lv-mass-check input[type="checkbox"]').each(function () {
            if (this.checked) {
                let item = $(this).closest('.lv-item').find('.pz-copy').data('pzCopy');
                items.push(item);
            }
        });
        toggleMode.call($lv[0], false);
        PzCms.setClipboard(items);
        PzCms.alert($(this).attr('data-message'), 'success');
    });

    $(document).on('click', '.lv-reorder-toggler', function (e) {
        e.preventDefault();
        let $lv = $(this).closest('.lv');
        toggleMode.call($lv[0], 'reorder');
    });
})();