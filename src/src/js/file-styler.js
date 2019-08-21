window.FileStyler = (function () {
    'use strict';

    let baseClass  = 'file-styler';
    let pluginName = 'fileStyler';
    let eventName  = pluginName;

    let FileStyler = function (element, options) {

        let change = function () {

            let isCanAdding = !!options.adding;
            if (options.adding === 'auto') {
                isCanAdding = !("multiple" in document.createElement("input"));
            }
            isCanAdding = isCanAdding && that.isMultiple;
            if (!isCanAdding) {
                $list.empty();
            }

            let files = this.files;
            if (typeof(files) === 'undefined') {
                files = [{name: this.value.split('\\').pop()}];
            }
            for (let i = 0; i < files.length; i++) {
                $list.append(options.itemTemplate(files[i]));
            }

            if (isCanAdding) {
                let $clone = $file.clone(true).val('');
                $file.after($clone).addClass(baseClass + '-hidden');
                $file = $clone;
            }

            $element.toggleClass(baseClass + '-empty', $list.is(':empty'));
        };

        let clear = function (e) {
            e.preventDefault();
            that.clear();
        };
		
		let remove = function (e) {
            e.preventDefault();
            $(this).closest('.' + baseClass + '-item').remove();
        };


        options  = $.extend({}, FileStyler.default, options);
        let that = this;
        let $element = this.$element = $(element);
        let $list;
        if (options.list !== false) {
            $list = this.$list = $(options.list);
        } else {
            $list = this.$list = $element.find('.' + baseClass + '-list');
        }
        $element.find('.' + baseClass + '-file').slice(1).remove();
        let $file = this.$file = $element.find('.' + baseClass + '-file')
            .addClass(options.buttonClasses)
            .find('input[type="file"]')
            .on('change', change);
        this.isMultiple = !!$file.attr('multiple');
        if (options.addingByOne) {
            $file.removeAttr('multiple').prop('multiple', false);
        }
        $element.find('.' + baseClass + '-clear').on('click', clear);
		$element.find('.' + baseClass + '-remove').on('click', remove);
        $element
            .data(pluginName + 'Item', this)
            .removeClass(baseClass + '-uninitialized')
            .addClass(baseClass + '-initialized')
            .trigger('init.' + eventName);
    };

    FileStyler.prototype.clear = function()
    {
        this.$element.addClass(baseClass + '-empty');
        this.$list.empty();
        this.$file.val('');
    };

    FileStyler.isImage = function (file) {
        return file.type && FileStyler.default.supportedImages.indexOf(file.type) !== -1;
    };

    FileStyler.getImage = function (file) {
        if (FileStyler.isImage(file)) {
            let image = new Image();
            if (!!window.FileReader) {
                let fileReader = new FileReader();
                fileReader.onloadend = function () {
                    image.src = fileReader.result;
                };
                fileReader.readAsDataURL(file);
            }
            return image;
        }
        return null;
    };

    FileStyler.default = {
        autoInitSelector: '.' + baseClass,
        buttonClasses: 'btn btn-default',
        adding: true,
        addingByOne: false,
        supportedImages: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'],
        list: false,
        itemTemplate: function (file) {
            let $result = $('<div>').addClass(baseClass + '-item');
            if (file.type) {
                $result.addClass(baseClass + '-item-' + file.type.replace(/[^\w\d_-]/g, '-'));
            }
            let image = FileStyler.getImage(file);
            if (image) {
                $result.addClass(baseClass + '-item-image');
                $('<div>').addClass(baseClass + '-image').append(image).appendTo($result);
            }
            $('<div>').addClass(baseClass + '-name').append('<i class="icon"></i>').append(file.name).appendTo($result);
            return $result;
        }
    };

    $.fn[pluginName] = function (options) {
        $(this).each(function () {
            new FileStyler(this, $.extend({}, options, $(this).data(pluginName)));
        });
    };

    $(function () {
        let autoInit = FileStyler.default.autoInitSelector;
        if (autoInit) {
            $(autoInit)[pluginName]();
        }
    });

    return FileStyler;
})();