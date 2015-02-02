<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Homework 9</title>
    <link href="/stylesheets/Global.css" rel="stylesheet" />
    <link rel="stylesheet" href="/stylesheets/prettify.css" type="text/css" />
    <style type="text/css">
        #banner {
            width: auto;
            margin: 0;
        }

        .lfixed {
            float: left;
            width: 25%;
            height: 500px;
        }

        .center {
            float: left;
            width: 75%;
            padding: 20px;
        }
        
        table.general.lfloat {
            width: auto;
            max-width: 50%;
            margin-right: 20px;
        }

        table.general.lfloat td {
            min-width: 50px;
        }

        .form-inline {
            margin-bottom: 20px;
        }

        .form-inline input, .form-inline select, .form-inline a.btn {
            float: none !important;
        }
    </style>
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js" type="text/javascript"></script>
    <script src="/javascripts/FormValidation_json.js" type="text/javascript"></script>
    <script src="/javascripts/prettify/prettify.js" type="text/javascript"></script>
    <script type="text/javascript">
        function Toggle(selector) {
            var curr = $(selector);
            $(".current").removeClass("current").fadeOut(function () {
                curr.fadeIn().addClass("current");
                if (curr.hasClass("load-survey"))
                    LoadResults();
            });
        }

        // 表单提交设定
        var confSendSurvey = new FormConfig({
            method: "post",
            action: "index.php/guestbook/new"
        });
        var confDeleteItems = new FormConfig({
            method: "post",
            action: "index.php/guestbook/delete",
            onSuccess: LoadResults
        });

        function LoadResults() {
            $.get("index.php/guestbook/all", { action: "get" }, function (data) {
                var table = $("#tabResults");
                table.find("tr:gt(0)").remove();
                table.append(data.tablerows);
                table.find("input[type=checkbox]:eq(0)")[0].checked = false;
            }, "json");
        }

        function ToggleAll(ctrl) {
            if (ctrl.checked)
                $(ctrl).closest("table").find("input[type=checkbox]:gt(0)").each(function () { this.checked = true; });
            else
                $(ctrl).closest("table").find("input[type=checkbox]:gt(0)").each(function () { this.checked = false; });
        }

        $(document).ready(function () {
            prettyPrint();
        });
    </script>
</head>
<body>
    <!-- 页面顶端浮动导航栏 -->
    <div id="navigation-bar">
        <a href="http://162.105.146.183/b2evolution/blogs/index.php/zhouhy" id="btnGotoBlog"></a>
        <span class="splitter"></span>
        <a href="http://162.105.146.180:8079/">HOME</a>
        <span class="splitter"></span>
        <a href="http://net.pku.edu.cn/~zt/wst/">HOME OF WST</a>
        <span class="rfloat">Created by 周昊宇 / 1200012823</span>
    </div>
    <!-- 页首 -->
    <div id="banner" class="basic-layout">
        <p class="title">
            Homework 9 by 周昊宇<br />
            <small>- Web Application Server & Programming Frameworks Introduction -</small>
        </p>
    </div>
    <!-- 左中右块框 -->
    <div id="container" class="wrapfloat">
        <div id="lcolumn" class="lfixed padding basic-layout">
            <p><b>Contents:</b></p>
            <ol>
                <li><a href="javascript:;" onclick="Toggle('#dAsHomework')"><b>(For TAs)</b> How I achieved all the goals set for this homework</a></li>
                <li><a href="javascript:;" onclick="Toggle('#frmSurvey')">Partipicate in the survey NOW</a></li>
                <li><a href="javascript:;" onclick="Toggle('#dManage')">View results and manage</a></li>
            </ol>
        </div>
        <div class="center basic-layout">
            <div id="dAsHomework" class="current">
                <h2><b>[WORKLOAD BALANCING] NOTE: THIS PAGE IS SERVED ON APACHE SERVER #1</b></h2>
                <h2><b>(For TAs)</b> How I achieved all the goals set for this homework</h2>
                <ul>
                    <li>
                        <p><b>Homework 1</b> is completed as you can see this survey(guestbook) provided in PHP Laravel Framework.</p>
                        <b>Brief description to my MVC code:</b>
                        <p>
                            Laravel provides an elegant MVC framework, in which I only need to fill in little code.
                            <ul>
                                <li>
                                    <b>Model</b> I created a Guest model for accessing database. Only a few lines that I can list it here.
                                    <h3>app/models/Guest.php</h3>
                                    <pre class="prettyprint roundbound">
<? echo str_replace('<', '&lt;', file_get_contents('../app/models/Guest.php')) ?>
                                    </pre>
                                </li>
                                <li>
                                    <b>View</b> I used AJAX for form submission, there I only need to send partial HTML code. A blade template is created for this purpose.
                                    <h3>app/views/guestbooktable.blade.php</h3>
                                    <pre class="prettyprint roundbound">
<? echo str_replace('<', '&lt;', file_get_contents('../app/views/guestbooktable.blade.php')) ?>
                                    </pre>
                                </li>
                                <li>
                                    <b>Controller</b> Main logic here, including fetch, create and delete. I also set up routes for this controller.
                                    <h3>app/routes.php</h3>
                                    <pre class="prettyprint roundbound">
<? echo str_replace('<', '&lt;', file_get_contents('../app/routes.php')) ?>
                                    </pre>
                                    <h3>app/controllers/GuestbookController.php</h3>
                                    <pre class="prettyprint roundbound">
<? echo str_replace('<', '&lt;', file_get_contents('../app/controllers/GuestbookController.php')) ?>
                                    </pre>
                                </li>
                            </ul>
                        </p>
                    </li>
                    <li>
                        <p>
                            <b>Homework 2</b> is finished cause this page is located at the Apache VHost on <a href="http://162.105.146.180:9279/">port 9279</a>
                            (9079 has conflict, therefore I shifted it a little...), and I set up a reverse proxy redirecting requests to path /homework9 to port 9279.
                        </p>
                        <p>The reverse proxy server is the same server (as a VHost) serving these contents, which means I set it up attaching new modules to this apache server.</p>
                    </li>
                    <li>
                        <p>
                            <b>Homework 3(Extra)</b> The two separated apache server instances are funning on port 9279 and port 9579. I balanced them when receiving requests to /homework9.
                        </p>
                    </li>
                </ul>
                <p>
                    <a href="http://jigsaw.w3.org/css-validator/check/referer">
                        <img style="border:0;width:88px;height:31px"
                             src="http://jigsaw.w3.org/css-validator/images/vcss"
                             alt="Valid CSS!" />
                    </a><br />
                    <b>By the way, this page was successfully checked as HTML5 but w3.org does not provide any icon to display here...</b>
                </p>
            </div>
            <form id="frmSurvey" onsubmit="return false" style="display: none">
                <h2>Welcome to guest book, please fill in the form below!</h2>
                <input type="hidden" name="action" value="new" data-validatefunc="dummy" />
                <div class="wrapfloat">
                    <label for="txtName">Name</label>
                    <input id="txtName" name="name" type="text" data-validatefunc="nonnull shorterthan20" />
                </div>
                <div class="wrapfloat">
                    <label for="txtAge">Age</label>
                    <input id="txtAge" name="age" type="text" data-validatefunc="nonnull numeric" />
                </div>
                <div class="wrapfloat">
                    <label for="cmbGender">Gender</label>
                    <select id="cmbGender" name="gender" data-validatefunc="dummy">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="wrapfloat">
                    <label for="txtEmail">Email</label>
                    <input id="txtEmail" name="email" type="email" data-validatefunc="nonnull email" />
                </div>
                <div class="wrapfloat">
                    <label></label>
                    <input type="submit" class="btn" value="Submit!" onclick="ValidateAndSubmit($('#frmSurvey'), confSendSurvey)" />
                </div>
            </form>
            <!-- 内联样式 -->
            <div id="dManage" style="display: none" class="load-survey">
                <input type="hidden" name="action" value="delete" data-validatefunc="dummy" />
                <table id="tabResults" class="general">
                    <tr><th><input type="checkbox" onchange="ToggleAll(this)" /></th><th>Name</th><th>Age</th><th>Gender</th><th>Email</th></tr>
                </table>
                <a href="javascript:;" onclick="LoadResults()" class="btn">Refresh</a>
                <a href="javascript:;" onclick="ValidateAndSubmit($('#dManage'), confDeleteItems)" class="btn rfloat">Delete checked items</a>
            </div>
        </div>
    </div>
    <!-- 页脚 -->
    <!-- 内联样式 -->
    <div id="footer" class="basic-layout">
        <hr />
        <div style="color: #777; text-align: center">All rights reserved 2014 Zhou Haoyu, Peking University.</div>
    </div>
</body>
</html>
