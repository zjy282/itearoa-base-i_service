var YP = YP || {};
YP.recordList = (function($, tpl) {
    var ajax = YP.ajax, pullLoad = YP.pullLoad;
    var recordList = {};

    recordList.init = function(option) {
        var listParams = {
            page : 1,
            limit : 4,
            dataId : 0,
            contentDomOb : $("#recordList"),
            listDomOb : $("#recordListContent"),
            listUrl : '',
            listTpl : 'recordList_tpl',
            nextPageOb : $("#nextPage"),
            loadingOb : $("#loading")
        };
        listParams = $.extend(listParams, option);
        recordList.loadList(listParams);
        pullLoad.initLoad({
            tiggerHeight : 640,
            nextPage : listParams.nextPageOb,
            loadingOb : listParams.loadingOb,
            contextOb : listParams.contentDomOb,
            moveStartCall : function() {
            },
            moveEndCall : function() {
                listParams.page = listParams.nextPageOb.val();
                if (listParams.page > 0) {
                    recordList.loadList(listParams);
                }
            }
        });
    }

    recordList.loadList = function(listParams) {
        var $listOb = listParams.listDomOb;
        if (listParams.page == 1) {
            $listOb.html("");
        }
        params = {
            page : listParams.page,
            limit : listParams.limit,
            dataid : listParams.dataId
        };
        var xhr = ajax.ajax({
            url : listParams.listUrl,
            type : "POST",
            data : params,
            cache : false,
            dataType : "json",
            timeout : 10000
        });
        xhr.done(function(data) {
            var html = '';
            if (data.data.list.length > 0) {
                html = template(listParams.listTpl, data.data);
                pullLoad.setScollFlag();
            }else if(listParams.page == 1){
                listParams.contentDomOb.hide();
            }
            $("#loading").hide();
            listParams.nextPageOb.val(data.data.nextPage);
            if (params.page == 1) {
                if (html == '') {
                    listParams.contentDomOb.hide();
                } else {
                    $listOb.html(html);
                    listParams.contentDomOb.show();
                    listParams.contentDomOb.scrollTop(0);
                }
            } else {
                $listOb.append(html);
            }
        }).fail(function(data) {
            alert(data.msg);
        });
    }

    return recordList;
})(jQuery, template);