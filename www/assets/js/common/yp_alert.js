var YP = YP || {};
YP.alert = (function($) {
    var isAppended = false, header = $('#header'), elem = null;

    function showTipDiv(type) {
        var div = '<div class="alert alertStyle alert-' + type + '" role="alert"></div>';
        if (!isAppended) {
            elem = $(div).insertAfter(header)
        }
        return elem;
    }

    return {
        show : function(msg, type, time) {
            if (!msg) {
                return false;
            }
            // info success warning danger
            var type = type || 'danger', time = time * 1000 || 5000;
            var tips = showTipDiv(type);
            if (type != "success") {
                msg = 'o(>_<)o ~~  杯具了，' + msg;
            }
            tips.slideDown().html(msg);
            setTimeout(function() {
                tips.slideUp();
            }, time);
        }
    }
})(jQuery);