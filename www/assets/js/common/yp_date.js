var YP = YP || {};
YP.DatePicker = (function($) {

    var DateObj = {};

    DateObj.bindPickerPari = function($start, $end, config) {
        if (config == undefined) {
            throw "没有传入date picker配置";
        }
        $start.datetimepicker(config).on("changeDate", function() {
            var $s = $start.find('input'), sValue = $s.val(), $e = $end.find('input'), eValue = $e.val();
            if (e == "" || sValue > eValue) {
                $e.val(sValue);
                $e.change();
            }
        });
        $end.datetimepicker(config).on("changeDate", function() {
            var $s = $start.find('input'), sValue = $s.val(), $e = $end.find('input'), eValue = $e.val();
            if (s == "" || sValue > eValue) {
                $s.val(eValue);
                $s.change();
            }
        });
    }

    return DateObj;
})(jQuery);