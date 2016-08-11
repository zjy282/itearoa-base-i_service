var YP = YP || {};
YP.ajax = (function($) {
    var ypAjax = {};
    ypAjax.ajax = function(ajaxConfig) {
        var dfd = $.Deferred(), promise = dfd.promise(), ajax = $.ajax(ajaxConfig);
        ajax.done(function(data) {
            if (data && data.code == 0) {// 成功
                var o = {
                    data : data.data,
                    page : data.page
                };
                dfd.resolve(o);
            } else {// 失败
                data = data || {
                    'code' : 1,
                    "msg" : "服务器错误"
                };
                dfd.reject(data);
            }
        }).fail(function() {
            var data = {
                'code' : 1,
                "msg" : "连接服务器失败"
            };
            dfd.reject(data);
        });
        promise.ajax = ajax;
        return promise;
    };
    ypAjax.getPage = function() {

    }
    return ypAjax;
})(jQuery);