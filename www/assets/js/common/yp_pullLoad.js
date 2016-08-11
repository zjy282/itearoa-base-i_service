var YP = YP || {};
YP.pullLoad = (function($) {
    var pullLoad = {};

    var isScrollShowMore = null;

    pullLoad.initLoad = function(option) {
        var param = {
            tiggerHeight : 700,
            nextPage : null,
            loadingOb : null,
            contextOb : $(document),
            moveStartCall : function() {
            },
            moveEndCall : function() {
            }
        };
        option = $.extend(param, option);
        option.contextOb.scroll(function() {
            pullLoad.movePage(option);
        });
        option.contextOb.bind("touchmove", function() {
            pullLoad.movePage(option);
        });
    };

    pullLoad.movePage = function(option) {
        var pageHeight = parseInt(option.contextOb.height()); // 获取文档的高度
        var scrollTop = parseInt(option.contextOb.scrollTop()); // 获取滚动条到顶部的垂直高度

        option.moveStartCall(pageHeight, scrollTop);
        if ((pageHeight - scrollTop) < option.tiggerHeight && option.nextPage.val() != -1 && !isScrollShowMore) {
            isScrollShowMore = 1;
            option.loadingOb.show();
            option.loadingOb.ajaxComplete(function() {
                $(this).hide();
            });
            $("html body").animate({
                scrollTop : option.contextOb.height()
            }, 300);
            setTimeout(function() {
                option.moveEndCall(pageHeight, scrollTop);
            }, 800);
        }
    }

    pullLoad.setScollFlag = function() {
        isScrollShowMore = null;
    }

    pullLoad.setState = function(option) {
        var top = parseInt(option.contextOb.scrollTop()); // 获取滚动条到顶部的垂直高度
        var param = {
            html : '',
            top : top,
            nextPage : 2,
            otherInfo : {}
        };
        state = $.extend(param, option);
        history.replaceState(state, document.title, location.href);
    }

    pullLoad.getState = function(option) {
        var param = {
            key : 'showList',
            contentOb : null,
            nextPageOb : null,
            handlerOtherInfo : function(otherInfo) {
            }
        };
        option = $.extend(param, option);
        try {
            var showCacheList = store.get('showCacheList');
        } catch (e) {
            console.log(e);
        }

        if (showCacheList == 1) {
            try {
                store.remove('showCacheList');
            } catch (e) {
                console.log(e);
            }
            if (history.state) {
                option.contentOb.html(history.state.html);
                $("html,body").animate({
                    scrollTop : history.state.html.top
                }, 1000);
                if (parseInt(history.state.nextPage) != -1) {
                    option.nextPageOb.val(parseInt(history.state.nextPage) + 1);
                } else {
                    option.nextPageOb.val(-1);
                }
                option.handlerOtherInfo(history.state.otherInfo);
                return true;
            }
        }
        return false;
    }

    pullLoad.getDataCount = function(option) {
        var param = {
            data : {}
        };
        option = $.extend(param, option);
        if (option.data.length == undefined) {
            dataCount = Object.keys(option.data).length;
        } else {
            dataCount = option.data.length;
        }
        return dataCount;
    }

    return pullLoad;
})(jQuery);
