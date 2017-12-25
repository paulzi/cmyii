let inputResizeHandler = function (e) {
    $(this).find('.auto-size').add($(this).filter('.auto-size')).each(function () {
        let $this = $(this);
        let handler = function () {
            let isTextArea = $this.get(0).tagName === 'TEXTAREA';
            let $clone = $this.clone(true).css({
                "position":   "absolute",
                "visibility": "hidden",
                "z-index":    -1
            }).insertAfter($this);

            if (isTextArea) {
                $clone.html($this.val());
                $clone.height(0);
            } else {
                $clone.width(0);
            }

            if ($this.val() === '') {
                $clone.val($this.attr('placeholder'));
            }
            if (isTextArea) {
                $this.innerHeight(Math.max($clone.get(0).scrollHeight, 30));
            } else {
                $this.innerWidth(Math.max($clone.get(0).scrollWidth, 30));
            }
            $clone.remove();
        };
        if (e.type !== 'keydown') {
            handler.apply(this);
        } else {
            setTimeout(handler, 1);
        }
    });
};
$(document).on('keydown', '.auto-size', inputResizeHandler);
$(document).on('keyup',   '.auto-size', inputResizeHandler);
$(document).on('change',  '.auto-size', inputResizeHandler);
$(document).on('contentinit', inputResizeHandler);