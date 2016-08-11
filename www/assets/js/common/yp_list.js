/**
 * @author 张福顺
 * @date 2015-11-20
 * @back 开发背景：OTA及AL后台大量的雷同列表，JS出现大量重复逻辑
 * @description 说明：用于雷同产品管理列表的场景，可实现列表的初始化加载、筛选等逻辑
 */
var YP = YP || {};
YP.list = (function($) {

    var ypList = {};
    var ajax = YP.ajax;
    var listParams = {
        colCount : 9,// table中td数量
        listUrl : '',// 列表ajax请求地址
        params : {// 列表ajax参数
            page : 1,
            limit : 10,
        },
        pageDomObject : $("#pageDiv"),// 分页html元素对象
        listDomObject : $("#listContent"),// 列表主体元素对象
        searchButtonDomObject : $("#searchBtn"),// 筛选搜索按钮元素对象
        listTemplate : 'list_tpl',// 列表模版名称
        pageTemplate : 'listPage_tpl',// 分页模版名称
        noDataTemplate : 'listNoData_tpl',// 没有数据展示的模版名称
        loadingTemplate : 'listLoading_tpl',// loading状态模版名称
        listSuccess : function(data) {// 成功的回调
        },
        listFail : function(data) {// 失败回调
        },
    }

    /**
     * 初始化
     */
    ypList.init = function(option) {
        option = $.extend(listParams, option);
        loadList();
        initPageChange();
    };

    /**
     * 把列表数据写入页面
     */
    ypList.writeListData = function(data) {
        var html = '';
        if (data.data.list.length > 0) {
            html = template(listParams.listTemplate, data.data);
            var pageHtml = template(listParams.pageTemplate, data.data.pageData);
            listParams.pageDomObject.html(pageHtml).show();
        } else {
            html = template(listParams.noDataTemplate, {
                colCount : listParams.colCount
            });
            listParams.pageDomObject.hide();
        }
        listParams.listDomObject.html(html);
    }

    /**
     * 重置搜索按钮
     */
    ypList.resetSearchButton = function() {
        listParams.searchButtonDomObject.button('reset');
    };

    /**
     * 更新参数
     */
    ypList.updateParams = function(option) {
        option = $.extend(listParams.params, option);
    };

    /**
     * 重新加载数据
     */
    ypList.reLoadList = function() {
        loadList();
    }

    /**
     * 初始化分页信息
     */
    function initPageChange() {
        listParams.pageDomObject.on("click", "a[op=prevPage]", function() {
            listParams.params['page'] = parseInt(listParams.params['page']) - 1;
            loadList();
        });
        listParams.pageDomObject.on("click", "a[op=nextPage]", function() {
            listParams.params['page'] = parseInt(listParams.params['page']) + 1;
            loadList();
        });
        listParams.pageDomObject.on("click", "a[op=jumpTo]", function() {
            listParams.params['page'] = listParams.pageDomObject.find("input[op=jumpPage]").val();
            loadList();
        });
    }

    /**
     * 加载列表
     */
    function loadList() {
        listParams.searchButtonDomObject.button('loading');
        listParams.listDomObject.html(template(listParams.loadingTemplate, {
            colCount : listParams.colCount
        }));
        var xhr = ajax.ajax({
            url : listParams.listUrl,
            type : "POST",
            data : listParams.params,
            cache : false,
            dataType : "json",
            timeout : 10000
        });
        xhr.done(function(data) {
            listParams.listSuccess(data);
            ypList.resetSearchButton();
        }).fail(function(data) {
            listParams.listFail(data);
            html = template(listParams.noDataTemplate, {
                colCount : listParams.colCount
            });
            listParams.listDomObject.html(html);
            ypList.resetSearchButton();
        });
    }

    return ypList;
})(jQuery);