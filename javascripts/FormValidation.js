// 作者：周昊宇 / 1200012823
// 用于表单验证

// 以下函数返回【真】表示【出错】！
var validateFunctions = {
    dummy: function () { },
    nonnull: function (val) {
        if (!val || val.length == 0)
            return true;
        return null;
    },
    shorterthan20: function (val) {
        if (val.length >= 20)
            return true;
        return null;
    },
    email: function (val) {
        if (!/^[-._A-Za-z0-9]+@[-._A-Za-z0-9]+$/.test(val))
            return true;
        return null;
    },
    numeric: function (val) {
        if (!/^[0-9]+$/.test(val))
            return true;
        return null;
    },
    age: function (val) {
        if (parseInt(val) <= 5 || parseInt(val) >= 150)
            return true;
        return null;
    },
    name: function (val) {
        if (val.length <= 2 || val.length >= 20)
            return true;
        return null;
    },
    idnumber: function (val) {
        if (val.length <= 10 || val.length >= 20)
            return true;
        if (!/^([0-9]|[Xx])+$/g.test(val))
            return true;
        return null;
    }
};

function FormConfig(argu) { // 是构造函数
    for (var i in argu)
        this[i] = argu[i];
}

function ValidateCtrl(ctrl, validateFunc) {
    if (!(ctrl instanceof jQuery))
        ctrl = $(ctrl);
    var funcs = validateFunc.split(" ");
    for (var i = 0; i < funcs.length; i++)
        if (validateFunctions[funcs[i]](ctrl.val())) {
            ctrl.addClass("error");
            return false;
        }
    ctrl.removeClass("error");
    return true;
}

function ValidateAndSubmit(form, config) {
    if (!(form instanceof jQuery))
        form = $(form);
    var result = true, data = new Object();
    form.find("[data-validatefunc]").each(function (i, ele) {
        ele = $(ele);
        if (ValidateCtrl(ele, ele.data("validatefunc"))) {
            var name = ele.attr("name");
            if (name && name.length > 0) {
                if (ele.attr("type") == "checkbox" && !ele[0].checked)
                    return;
                if (ele.attr("type") == "radio" && !ele[0].checked)
                    return;
                if (data[name])
                    if (data[name] instanceof Array)
                        data[name].push(ele.val());
                    else
                        data[name] = [data[name], ele.val()];
                else
                    data[name] = ele.val();
            }
        } else {
            result = false;
        }
    });
    if (result) {
        form.find("input[type=submit]").attr("disabled", "disabled");
        $[config.method](config.action, data, function (recvData) {
            form.find("input[type=submit]").removeAttr("disabled");
            if (config.onSuccess && config.onSuccess instanceof Function)
                config.onSuccess(recvData);
            else
                alert("Submission successful.");
        }).fail(function (jqXHR, textStatus, errorThrown) {
            form.find("input[type=submit]").removeAttr("disabled");
            alert("We encountered an error while submitting: " + errorThrown);
        });
    }
}

$(document).ready(function () {
    // 自动表单验证
    $("[data-validatefunc]").blur(function () {
        var me = $(this);
        ValidateCtrl(me, me.data("validatefunc"));
    });
})