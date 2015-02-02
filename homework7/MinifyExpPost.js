$(".tn-board-head, .tn-board-foot").remove();
$("*").each(function (idx, ele) {
    for (var i in ele.attributes)
        if (i == parseInt(i)) {
            var currName = ele.attributes[i].name;
            if (currName != "style")
                ele.attributes.removeNamedItem(currName);
        }
}).promise().done(function () {
    var full = $("body > div");
    $("body").html($("<textarea></textarea>").val($("body > div")[0].outerHTML));
})