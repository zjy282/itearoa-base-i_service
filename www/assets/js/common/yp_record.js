var YP = YP || {};
YP.record = (function($, tpl, RECORD_VARS) {
    var record = {};

    record.getCreateLog = function(option) {
        var param = {
            modelName : "",
            value : ""
        };
        option = $.extend(param, option);
        var data = {
            adminName : RECORD_VARS.adminName,
            modelName : option.modelName,
            createValue : option.value
        };
        return record.makeLog({
            data : data,
            type : 'create'
        });
    }

    record.getEditLog = function(option) {
        var param = {
            modelName : "",
            value : ""
        };
        option = $.extend(param, option);
        var data = {
            adminName : RECORD_VARS.adminName,
            modelName : option.modelName,
            editValue : option.value
        };
        if (option.value.length == 0) {
            return false;
        }
        return record.makeLog({
            data : data,
            type : 'edit'
        });
    }

    record.getDeleteLog = function(option) {
        var param = {
            modelName : "",
            value : ""
        };
        option = $.extend(param, option);
        var data = {
            adminName : RECORD_VARS.adminName,
            modelName : option.modelName,
            deleteValue : option.value
        };
        return record.makeLog({
            data : data,
            type : 'delete'
        });
    }

    record.makeLog = function(option) {
        var param = {
            data : {},
            type : ""
        };
        option = $.extend(param, option);
        var recordLog = "";
        switch (option.type) {
            case "create":
                recordLog = tpl('recordCreate_tpl', option.data);
                break;
            case "edit":
                recordLog = tpl('recordEdit_tpl', option.data);
                break;
            case "delete":
                recordLog = tpl('recordDelete_tpl', option.data);
                break;
        }
        return recordLog;
    };

    record.compareText = function(option) {
        var param = {
            domOb : {}
        };
        option = $.extend(param, option);
        var domObject = option.domOb, oldData = domObject.data("old"), newData = domObject.val(), title = domObject.data("title");
        if (oldData != newData) {
            return {
                title : title,
                from : oldData,
                to : newData
            }
        }
        return false;
    };

    record.comparePassword = function(option) {
        var param = {
            domOb : {}
        };
        option = $.extend(param, option);
        var domObject = option.domOb, domValue = domObject.val(), title = domObject.data("title");
        if (domValue != "") {
            return {
                title : title,
                from : 'xxxx',
                to : 'xxxx'
            }
        }
        return false;
    };

    record.compareSelect = function(option) {
        var param = {
            domOb : {}
        };
        option = $.extend(param, option);
        var domObject = option.domOb, oldData = domObject.data("old"), newData = domObject.val(), title = domObject.data("title");
         try {
        if (domObject.attr('multiple') == 'multiple' && newData != null) {
            if (oldData != newData.join(',')) {
                var oldDataList = [];
                $.each(oldData, function(key, value) {
                    if (value == '') {
                        return true;
                    }
                    dataShow = domObject.find("option[value=" + value + "]");
                    if (dataShow != undefined) {
                        oldDataList.push(dataShow.html());
                    }
                });
                var newDataList = [];
                $.each(newData, function(key, value) {
                    if (value == '') {
                        return true;
                    }
                    dataShow = domObject.find("option[value=" + value + "]");
                    if (dataShow != undefined) {
                        newDataList.push(dataShow.html());
                    }
                });
                return {
                    title : title,
                    from : oldDataList ? oldDataList.join(',') : oldData,
                    to : newDataList ? newDataList.join(',') : newData.join(","),
                }
            }
            return false;
        }
        newData = newData == null ? '' : newData;
        if (oldData != newData) {
            if (domObject.attr('multiple') == 'multiple' && newData != null) {
                var oldDataList = [];
                $.each(oldData, function(key, value) {
                    if (value == '') {
                        return true;
                    }
                    dataShow = domObject.find("option[value=" + value + "]");
                    if (dataShow != undefined) {
                        oldDataList.push(dataShow.html());
                    }
                });
                var newDataList = [];
                $.each(newData, function(key, value) {
                    if (value == '') {
                        return true;
                    }
                    dataShow = domObject.find("option[value=" + value + "]");
                    if (dataShow != undefined) {
                        newDataList.push(dataShow.html());
                    }
                });
                return {
                    title : title,
                    from : oldDataList ? oldDataList.join(',') : oldData,
                    to : newDataList ? newDataList.join(',') : newData.join(","),
                }
            }
            return {
                title : title,
                from : domObject.find("option[value=" + oldData + "]").html(),
                to : domObject.find("option[value=" + newData + "]").html(),
            }
        }
         } catch (e) {
            return {
                title : title,
                from : oldData,
                to : newData,
            }
        }
        return false;
    };

    record.compareRadio = function(option) {
        var param = {
            domOb : {}
        };
        option = $.extend(param, option);
        var domObject = option.domOb, oldDataId = domObject.data("old"), oldData = domObject.find("input[value=" + oldDataId + "]").data("show"), newDataId = domObject.find("input[type=radio]:checked").val(), newData = domObject.find("input[type=radio]:checked").data("show"), title = domObject.data("title");
        if (oldDataId != newDataId) {
            return {
                title : title,
                from : oldData,
                to : newData,
            }
        }
        return false;
    };

    record.compareCheckBox = function(option) {
        var param = {
            domOb : {}
        };
        option = $.extend(param, option);
        var domObject = option.domOb, oldDataId = domObject.data("old"), title = domObject.data("title");
        if (domObject.prop("checked") != oldDataId) {
            var from = domObject.prop("checked") ? "否" : "是";
            var to = domObject.prop("checked") ? "是" : "否";
            return {
                title : title,
                from : from,
                to : to,
            }
        }
        return false;
    };

    record.compareOther = function(option) {
        var param = {
            title : "",
            from : "",
            to : "",
        };
        option = $.extend(param, option);
        if (option.title == "" || option.from == "" || option.to == "") {
            return false;
        }
        return {
            title : option.title,
            from : option.from,
            to : option.to
        }
    };

    return record;
})(jQuery, template, YP_RECORD_VARS);