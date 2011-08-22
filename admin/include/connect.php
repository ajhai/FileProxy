<?php
#
# @author  ajhai
# @license MIT License
#
include('config/config.php');

mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error());			// Connect to server
mysql_select_db($db_name) or die(mysql_error());							// Connect to database	
?>