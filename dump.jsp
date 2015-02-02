<%@ page import = "java.util.Map" %>
<%
Map<String, String[]> parameters = request.getParameterMap();
for (Entry<String, String[]> e : parameters.entrySet()) {
	out.println("[" + e.getKey() + "]:");
	for (String v : e.getValue())
		out.println(v);
}