import 'summernote';

if ($.summernote) {
    $.summernote.ui = $.summernote.ui_template();
    $.summernote.ui.icon = function (iconClassName, tagName) {
        tagName = tagName || 'i';
        return '<' + tagName + ' class="icon icon-24">' + iconClassName + '</' + tagName + '>';
    };

    $.extend($.summernote.options, {
        'lang': 'ru-RU',
        'toolbar': [
            ['custom',    ['divider']],
            ['style',     ['style', 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['paragraph', ['paragraph', 'ol', 'ul']],
            ['insert',    ['link', 'picture', 'video', 'area', 'cols', 'table']],
            ['misc',      ['fullscreen', 'codeview', 'undo', 'redo']]
        ],
        'buttons': {
            'cols': function (context) {
                return $.summernote.ui.button({
                    contents: '<i class="icon icon-24">&#xE8EC;</i>',
                    tooltip: 'Адаптивные колонки',
                    click: function () {
                        context.invoke('editor.insertNode', $('<div class="pz-cols"><div class="row"><div class="col-xs-12 col-md-6 note-editable"></div><div class="col-xs-12 col-md-6 note-editable"></div></div></div>').get(0));
                    }
                }).render();
            }
        },
        'popover': $.extend($.summernote.options.popover, {
            'image': false
        }),
        disableResizeImage: true,
        'minHeight': '100px',
        'maxHeight': '80vh',
        'dialogsInBody': true,
        'dialogsFade': true,
        'tableClassName': 'table table-bordered table-striped',
        'icons': {
            'align': '&#xE236;',
            'alignCenter': '&#xE234;',
            'alignJustify': '&#xE235;',
            'alignLeft': '&#xE236;',
            'alignRight': '&#xE237;',
            'indent': '&#xE23E;',
            'outdent': '&#xE23D;',
            'bold': '&#xE238;',
            'italic': '&#xE23F;',
            'caret': '&#xE5C5;',
            'eraser': '&#xE239;',
            'link': '&#xE250;',
            'unlink': '&#xE872;',
            'magic': '&#xE41D;',
            'menuCheck': '&#xE5CA;',
            'orderedlist': '&#xE242;',
            'picture': '&#xE251;',
            'redo': '&#xE15A;',
            'strikethrough': '&#xE257;',
            'subscript': '&#xE262;',
            'superscript': '&#xE245;',
            'table': '&#xE228;',
            'trash': '&#xE872;',
            'underline': '&#xE249;',
            'undo': '&#xE166;',
            'unorderedlist': '&#xE241;',
            'video': '&#xE02C;',
            'arrowsAlt': '&#xE5D0;',
            'code': '&#xE86F;'
        }
    });

    $(document).on('contentinit', function (e, $elements) {
        $elements.find('.summer-note').each(function () {
            var $this  = $(this);
            var config = {};
            if ($this.hasClass('summer-note-div')) {
                config.buttons = config.buttons || $.extend({}, $.summernote.options.buttons);
                config.buttons.divider = function (context) {
                    return $.summernote.ui.button({
                        contents: '<i class="icon icon-24">&#xE86D;</i>',
                        tooltip: 'Разделитель полной статьи',
                        click: function () {
                            context.invoke('editor.insertNode', $('<div class="divider post-divider" contentEditable="false"><span>Полная статья</span></div>').get(0));
                        }
                    }).render();
                };
            }
            if ($this.hasClass('summer-note-area')) {
                config.buttons = config.buttons || $.extend({}, $.summernote.options.buttons);
                config.buttons.area = function (context) {
                    return $.summernote.ui.button({
                        contents: '<i class="icon icon-24">&#xE02E;</i>',
                        tooltip: 'Добавить область для блоков',
                        click: function () {
                            var id  = 'area-' + Date.now();
                            var template = $('.pz-area-template').html().trim().replace('%25area', encodeURIComponent(id));
                            var $area = $(template).attr('id', id);
                            context.invoke('editor.insertNode', $area[0]);
                        }
                    }).render();
                };
            }
            $this.summernote(config);
        });

        $elements.find('.note-editor .pz-area').each(function () {
            var id = $(this).attr('id');
            var template = $('.pz-area-template').html().trim().replace('%25area', encodeURIComponent(id));
            var $area = $(template).attr('id', id);
            $(this).replaceWith($area);
        });
    });
}
