<?php
/*
 +-------------------------------------------------------------------------+
 | Copyright (C) 2004-2014 The Cacti Group                                 |
 |                                                                         |
 | This program is free software; you can redistribute it and/or           |
 | modify it under the terms of the GNU General Public License             |
 | as published by the Free Software Foundation; either version 2          |
 | of the License, or (at your option) any later version.                  |
 |                                                                         |
 | This program is distributed in the hope that it will be useful,         |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           |
 | GNU General Public License for more details.                            |
 +-------------------------------------------------------------------------+
 | Cacti: The Complete RRDTool-based Graphing Solution                     |
 +-------------------------------------------------------------------------+
 | This code is designed, written, and maintained by the Cacti Group. See  |
 | about.php and/or the AUTHORS file for specific developer information.   |
 +-------------------------------------------------------------------------+
 | http://www.cacti.net/                                                   |
 +-------------------------------------------------------------------------+
*/

include("./include/auth.php");

global $config;

api_plugin_hook('logout_pre_session_destroy');

/* Clear session */
setcookie(session_name(),"",time() - 3600,"/");
session_destroy();

api_plugin_hook('logout_post_session_destroy');

/* Check to see if we are using Web Basic Auth */
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'timeout') {
	print "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>\n";
	print "<html>\n";
	print "<head>\n";
	print "\t<title>Logout of Cacti</title>\n";
	print "\t<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>\n";
	print "\t<link href='" . $config['url_path'] . "include/themes/" . read_config_option('selected_theme') . "/main.css' type='text/css' rel='stylesheet'>\n";
	print "\t<link href='" . $config['url_path'] . "images/favicon.ico' rel='shortcut icon'>\n";
	print "</head>\n";
	print "<body>\n";
	print "\t<table align='center'>\n";
	print "\t\t<tr>\n";
	print "\t\t\t<td><img src='images/auth_logout.gif' border='0' alt=''></td>\n";
	print "\t\t</tr><tr>\n";
	print "\t\t\t<td><br>You have been logged out of Cacti due to a session timeout.<br>Please close your browser or <a href='index.php'>Login again</a>.</td>\n";
	print "\t\t</tr>\n";
	print "\t</table>\n";
	print "</body>\n";
	print "</html>\n";
}elseif (read_config_option("auth_method") == "2") {
	if (api_plugin_hook_function('custom_logout_message', OPER_MODE_NATIVE) == OPER_MODE_RESKIN) {
		exit;
	}

	print "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>\n";
	print "<html>\n";
	print "<head>\n";
	print "\t<title>Logout of Cacti</title>\n";
	print "\t<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>\n";
	print "\t<link href='" . $config['url_path'] . "include/themes/" . read_config_option('selected_theme') . "/main.css' type='text/css' rel='stylesheet'>\n";
	print "\t<link href='" . $config['url_path'] . "images/favicon.ico' rel='shortcut icon'>\n";
	print "</head>\n";
	print "<body>\n";
	print "\t<table align='center'>\n";
	print "\t\t<tr>\n";
	print "\t\t\t<td><img src='images/auth_logout.gif' border='0' alt=''></td>\n";
	print "\t\t</tr><tr>\n";
	print "\t\t\t<td><br>To end your Cacti session please close your web browser or <a href='index.php'>Return to Cacti</a></td>\n";
	print "\t\t</tr>\n";
	print "\t</table>\n";
	print "</body>\n";
	print "</html>\n";
}else{
	/* Default action */
	header("Location: index.php");
	exit;
}

?>
