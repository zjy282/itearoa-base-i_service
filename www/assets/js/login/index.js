var ypAdminOTA = ypAdminOTA || {};
ypAdminOTA.loginIndex = (function($, ypRecordVar) {

    var ajax = YP.ajax;

    function initLogin() {
        var user = $("#userName"), pass = $("#userPass"), buttonDom = $("#submitForm");
        buttonDom.on('click', function() {
            var params = {
                username : user.val(),
                password : pass.val(),
            };
            if (!params['username']) {
                showMsg('用户名不能为空！');
                return false;
            }
            if (!params['password']) {
                showMsg('密码不能为空！');
                return false;
            }
            params[ypRecordVar.recordPostVar] = "登录后台";
            doLogin(params);
        });
    }

    function doLogin(params) {
        var url = '/loginajax/doLogin';
        var xhr = ajax.ajax({
            url : url,
            type : 'POST',
            data : params,
            cache : false,
            dataType : 'json',
            timeout : 1000,
        });
        xhr.done(function() {
            location.href = "/index/index";
        }).fail(function(data) {
            showMsg(data.msg);
        });
    }

    function showMsg(message) {
        var messageDom = $("#message");
        if (message) {
            messageDom.show().html(message);
        }
    }

    function init() {
        initLogin();
    }

    return {
        init : init
    };
})(jQuery, YP_RECORD_VARS);

$(function() {
    ypAdminOTA.loginIndex.init();
})