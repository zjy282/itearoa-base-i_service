/**
 * @author 张福顺
 * @date 2015-11-20
 * @back 开发背景：OTA及AL后台大量的雷同列表弹出层的编辑也，JS出现大量重复逻辑
 * @description 说明：用于雷同产品管理列表编辑的场景，可实现在列表点击添加和编辑写入表单默认数据、提交表单的必填验证、表单提交
 */
var YP = YP || {};
YP.form = (function($) {

    var ypForm = {};
    var ajax = YP.ajax, ypRecord = YP.record;
    var formParams = {
        editorDom : {},// 表单输入框元素对象
        saveButtonDom : {},// 保存按钮元素对象
        checkParams : [],// 需要检查的必填元素
        modelDom : $("#editor"),// 编辑弹出层元素对象
        saveUrl : "",// 保存ajax地址
        saveBefore : function(saveParams) {// 生成保存数据发起ajax前回调
            return saveParams;
        },
        saveSuccess : function(data) {// 保存成功回调
        },
        saveFail : function(data) {// 保存失败回调
        },
    }

    /**
     * 初始化
     */
    ypForm.init = function(option) {
        option = $.extend(formParams, option);
        initFormBlurCheck();
        initFormSubmit();
    }

    /**
     * 更新参数
     */
    ypForm.updateParams = function(option) {
        option = $.extend(formParams, option);
    };

    /**
     * 写入表单默认数据
     */
    ypForm.writeEditor = function(option) {
        params = {
            editorDom : formParams.editorDom,
            writeData : {}
        }
        option = $.extend(params, option);
        $.each(option.editorDom.find("[id^='edit_']"), function(key, value) {
            var $editDom = $(value);
            $editDom.parents("[op=editFiled]").removeClass('error');
            var $inputType = $editDom.attr('type'), $editTag = $editDom.prop('tagName').toLowerCase(), $editId = $editDom.attr('id');
            var $editType = ($editTag == 'input') ? $inputType : $editTag;
            var $editKey = $editId.split("_");
            $editKey = $editKey[1];
            switch ($editType) {
                case "hidden":
                case "number":
                    $writeValue = option.writeData[$editKey] ? option.writeData[$editKey] : 0;
                    $editDom.val($writeValue).data('old', $writeValue);
                    break;
                case "select":
                    if (option.writeData[$editKey] != undefined) {
                        $editDom.val(option.writeData[$editKey]).data('old', option.writeData[$editKey]);
                    } else {
                        $editDom.find("option:first").prop('selected', true);
                    }
                    if ($editDom.attr('multiple') == 'multiple' || $editDom.next().hasClass('select2')) {
                        if (!option.writeData[$editKey]) {
                            $editDom.val("");
                            $editDom.find("option").prop('selected', false);
                        }
                    }
                    $editDom.trigger("change");
                    break;
                case "text":
                case "date":
                case "textarea":
                    $writeValue = option.writeData[$editKey] ? option.writeData[$editKey] : "";
                    $editDom.val($writeValue).data('old', $writeValue);
                    break;
            }
        });
    }

    /**
     * 检查必填元素
     */
    ypForm.checkSubmit = function(option) {
        params = {
            checkDom : {}
        }
        option = $.extend(params, option);
        var checkDiv = option.checkDom.parents("div[op=editFiled]");
        if (option.checkDom.val() == '' || option.checkDom.val() == null || option.checkDom.val() == 0) {
            checkDiv.addClass('error');
            return false;
        } else {
            checkDiv.removeClass('error');
            return true;
        }
    }

    /**
     * 必填元素失焦验证
     */
    function initFormBlurCheck() {
        $.each(formParams.checkParams, function(key, value) {
            var checkValue = $("#edit_" + value);
            checkValue.on('blur', function() {
                ypForm.checkSubmit({
                    checkDom : checkValue
                });
            });
        });
    }

    /**
     * 初始化表单提交
     */
    function initFormSubmit() {
        formParams.saveButtonDom.on('click', function() {
            formParams.saveButtonDom.button('loading');
            var saveParams = {}, checkStatus = true;

            // 必填元素验证
            $.each(formParams.editorDom.find("[id^='edit_']"), function(key, value) {
                var $editDom = $(value), $editId = $editDom.attr('id');
                var $editKey = $editId.split("_");
                $editKey = $editKey[1];
                saveParams[$editKey] = $editDom.val();
                if ($.inArray($editKey, formParams.checkParams) >= 0) {
                    if (!ypForm.checkSubmit({
                        checkDom : $editDom
                    })) {
                        checkStatus = false;
                    }
                }
            });
            if (!checkStatus) {
                formParams.editorDom.find("[op=editFiled].error:first").find("[id^='edit_']").focus();
                formParams.saveButtonDom.button('reset');
                return false;
            }
            saveParams = formParams.saveBefore(saveParams);
            if (!YP_RECORD_VARS.isChange) {
                formParams.modelDom.modal('hide');
                formParams.saveButtonDom.button('reset');
                return true;
            }
            var xhr = ajax.ajax({
                url : formParams.saveUrl,
                type : "POST",
                data : saveParams,
                cache : false,
                dataType : "json",
                timeout : 10000
            });
            xhr.done(function(data) {
                formParams.saveSuccess(data);
                formParams.modelDom.modal('hide');
                formParams.saveButtonDom.button('reset');
            }).fail(function(data) {
                formParams.saveFail(data);
                formParams.saveButtonDom.button('reset');
            });
        });
    }

    ypForm.makeRecord = function(params, recordId, recordTitle, insertId, logMsg) {
        if (recordId == 0) {
            recordLog = ypRecord.getCreateLog({
                value : recordTitle
            });
            if (insertId > 0) {
                params[YP_RECORD_VARS.recordPostId] = insertId;
            }
        } else {
            var editValue = [];
            $.each(params, function(key, value) {
                var editDom = $("#edit_" + key);
                if (editDom.length == 0 || (editDom.is(":hidden") && !editDom.next().hasClass('select2'))) {
                    return true;
                }
                var editType = editDom.attr('type'), editTagName = editDom.prop('tagName').toLowerCase();
                type = editTagName == 'input' ? editType : editTagName;
                type = (type == 'select') ? 'compareSelect' : 'compareText';
                var editData = eval("ypRecord." + type + "({domOb : editDom})");
                if (editData) {
                    editValue.push(editData);
                }
            });
            recordLog = ypRecord.getEditLog({
                value : editValue
            });
            params[YP_RECORD_VARS.recordPostId] = insertId ? insertId : recordId;
        }
        if (recordLog) {
            logMsg = logMsg ? logMsg : '';
            YP_RECORD_VARS.isChange = 1;
            params[YP_RECORD_VARS.recordPostVar] = logMsg + recordLog;
        }
        return params;
    }

    return ypForm;
})(jQuery);