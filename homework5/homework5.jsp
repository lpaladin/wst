<%@ page language="java" import="java.util.Scanner, java.io.FileInputStream" %>
<%!
	String readFile(String absPath) {
		try {
			Scanner s = new Scanner(new FileInputStream(absPath), "UTF-8");
			StringBuilder sb = new StringBuilder();
			for (String line = s.nextLine(); s.hasNextLine(); line = s.nextLine())
				sb.append(line).append('\n');
			return sb.toString().replace("<", "&lt;").replace(">", "&gt;");
		} catch (Exception ex) {
			return "ERROR" + ex.getMessage();
		}
	}
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Homework 5</title>
    <link href="/stylesheets/Global.css" rel="stylesheet" />
    <link rel="stylesheet" href="/stylesheets/prettify.css" type="text/css" />
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js" type="text/javascript"></script>
    <script src="/javascripts/AutoFloat.js" type="text/javascript"></script>
    <script src="/javascripts/prettify/prettify.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            prettyPrint();
        });
    </script>
</head>
<body>
    <div id="navigation-bar">
        <a href="http://162.105.146.183/b2evolution/blogs/index.php/zhouhy" id="btnGotoBlog"></a>
        <span class="splitter"></span>
        <a href="/">HOME</a>
        <span class="splitter"></span>
        <a href="http://net.pku.edu.cn/~zt/wst/">HOME OF WST</a>
        <span class="rfloat">Created by 周昊宇 / 1200012823</span>
    </div>
    <div id="banner">
        <p class="title">
            Homework 5 by 周昊宇
        </p>
        <p class="subtitle">
            <small>-- For <em>Web Software &amp; Technology</em> Course</small>
        </p>
    </div>
    <div class="content wrapfloat">
        <div class="divide-2of3 padding">
            <a id="homework"></a>
            <h2>Basic Goals (Modifying a java program)</h2>
            <ul>
                <li>
                    <b>Snapshots for the java programs:</b><br />
                    <img src="/images/week5-snapshot-1.png" width="500" style="margin: 20px;" alt="Snapshot1"/><br />
                    <img src="/images/week5-snapshot-2.png" width="500" style="margin: 20px;" alt="Snapshot2"/><br />
                </li>
                <li>
                    <b>Source code for RunSample.java:</b>
                    <pre class="prettyprint roundbound"><%=readFile(application.getRealPath("./RunSample.java"))%></pre>
                </li>
                <li>
                    <b>Source code for Sample.java:</b>
                    <pre class="prettyprint roundbound"><%=readFile(application.getRealPath("./Sample.java"))%></pre>
                </li>
            </ul>
            <a id="homework-bonus"></a>
            <h2>Bonus (Handling java programs on server)</h2>
            <ul>
                <li>
                    <b>A tomcat server and a AJP connector are set up for JSP handling.</b><br />
                    You can find out my tomcat <a href="http://162.105.146.180:10079">HERE</a>
                </li>
                <li style="margin-bottom: 10px;">
                    <b>This page is composed dynamically using JSP.</b><br />
                    A server-side generated timestamp is here to prove: <em class="roundbound"><%=new java.util.Date()%></em>
                </li>
                <li>
                    <b>What's more, the source code listed above is read from file system in real-time using JSP.</b><br />
                    To prove that, here's the source code of this JSP page.(Also read in real-time..)<br />
                    <pre class="prettyprint roundbound lang-html"><%=readFile(application.getRealPath("./homework5.jsp"))%></pre>
                </li>
            </ul>
        </div>
        <div class="divide-1of3 lmargin padding contents">
            <p>Contents:</p>
            <ol>
                <li><a href="#homework">Basic Goals (Modifying a java program)</a></li>
                <li><a href="#homework-bonus">Bonus (Handling java programs on server)</a></li>
            </ol>
            <p>
                <a href="http://validator.w3.org/check?uri=referer">
                    <img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
                </a>
            </p>
        </div>
    </div>
    <div id="footer">
        <hr />
        <div style="color: #777; text-align: center">All rights reserved 2014 Zhou Haoyu, Peking University.</div>
    </div>
</body>
</html>
