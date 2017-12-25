import '../sass/app.scss';

import 'bootstrap';

import './alert-fixed';
import './array-condition';
import './auto-size';
import './block-form';
import './date-picker';
import './file-styler';
import './form-control-focus';
import './list-view';
import './modal-remote';
import './nice-scroll';
import './pz-copy';
import './pz-tree';
import './selectize';
import './summer-note';
import './sure';
import './toggle';
import './tooltip';
import './yii2-active-form-fix';

$(() => {
    let $document = $(document);
    let $html = $('html');
    $html.removeClass('no-js');
    if (window.top !== window) {
        $html.addClass('iframe');
    }
    $document.trigger('contentinit', [$document]);
});
