import 'moment';
import 'moment/locale/ru';
import 'eonasdan-bootstrap-datetimepicker';

$(document).on('contentinit', function (e, $elements) {
    $elements.find('.datetime-picker').datetimepicker();
});