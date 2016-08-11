// 提交权限数据
function addAuthor(data, button) {
    // 锁定添加按钮
    button.button('loading');

    var ajax = YP.ajax, url = '/Authorajax/add', xhr = ajax.ajax({
        url : url,
        type : 'POST',
        data : data,
        cache : false,
        dataType : 'json',
        timeout : 1000,
    });

    xhr.done(function(data) {
        alert(data.data.msg);
        history.go(-1);
    }).fail(function(data) {
        alert(data.msg);

        // 解除添加按钮的锁定状态
        button.button('reset');
    });
}

// 获取权限列表
function getAuthor(data) {
    var result = {}, ajax = YP.ajax, url = '/Authorajax/getAuthorByCondition', xhr = ajax.ajax({
        url : url,
        type : 'POST',
        data : data,
        cache : false,
        dataType : 'json',
        async : false,
        timeout : 1000
    });

    xhr.done(function(data) {
        result = data;
    }).fail(function(data) {
        result = false;
    });

    return result;
}

// 删除指定权限
function deleteAuthor(data) {
    var ajax = YP.ajax, url = '/Authorajax/deleteAuthority', xhr = ajax.ajax({
        url : url,
        type : 'POST',
        data : data,
        cache : false,
        dataType : 'json',
        async : false,
        timeout : 1000
    });

    xhr.done(function(data) {
        alert('删除成功！');
        location.reload();
    }).fail(function(data) {
        alert(data.msg);
    });
}