<%@ page language="java" import="java.util.*, java.sql.*" %>
<%
	Connection con;
	try { Class.forName("com.mysql.jdbc.Driver").newInstance(); }
	catch (Exception e) { out.print(e); }
	String uri = "jdbc:mysql://localhost:3306/db_2014_79";
	con = DriverManager.getConnection(uri, "usr_2014_79", "phone:2836231");
%>