<?php
#
# @author  ajhai
# @license MIT License
#
include('include/connect.php');

if(isset($_COOKIE['admin_ID_my_site'])){
	
	$username = $_COOKIE['admin_ID_my_site'];
	$pass = $_COOKIE['admin_Key_my_site'];
	$check = mysql_query("SELECT * FROM admins WHERE admin_id = '$username'")or die(mysql_error());
	while($info = mysql_fetch_array( $check )){
		if ($pass != $info['admin_pass']){
			header("Location: index.php");
		}
		else{
			$del = strip_tags($_GET['del']);
			?>
				
				
				
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Admin Section</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style/nav.css" rel="stylesheet" type="text/css">
<link href="style/main.css" rel="stylesheet" type="text/css">
</head>

<body id="page">
<div id="wrapper">

<!-- navigation starts here-->
<div id="modernbricksmenu">
<ul>
<li><a href="index.php" title="Home">Home</a></li>
<li><a href="viewbeta.php" title="View Beta requests">View Beta requests</a></li>
<li style="margin-left: 1px"  id="current"><a href="viewusers.php" title="View Users">View Users</a></li>
</ul>
</div>
<div id="modernbricksmenuline">&nbsp;</div>
<!-- navigation ends here-->
<div id="content">

<div id="right">
Hi <?php echo($username); ?><br>
<a href="logout.php">Logout</a>

</div>
<div id = "main">



<?php

	$uid = strip_tags($_GET['uid']);
	$did = strip_tags($_GET['did']);

function convertBytes($bytes)
{
	$tag = "B";
	
	if($bytes > 1024)
	{
		$bytes = (float)($bytes / 1024);
		if($bytes > 1024)
		{
			$bytes = (float)($bytes / 1024);
			if($bytes > 1024)
			{
				$bytes = (float)($bytes / 1024);
				return round($bytes, 3) . " GB";
			}
			else
			return round($bytes, 3) . " MB";
		}
		else
		return round($bytes, 3) . " KB";
	}
	return round($bytes, 3) . " B";
}



	if($uid)
	{
			$query = "select * from `downstats` where `uid` = '$uid'";
			$result = mysql_query($query) or die(mysql_error());
			
			if(mysql_num_rows($result) > 0)
			{
				print "<table cellpadding='5px' cellspacing='5px'><tr><td colspan='2'><strong>Usage details for $uid</strong></td></tr><tr><td><strong>Host</strong></td><td><strong>Volume</strong></td></tr>";
				while($row = mysql_fetch_array($result))
				{
					$usage = convertBytes($row['volume']);
					print "<tr><td>$row[domain_name]</td><td>$usage</td></tr>";
				}
				print "</table>";
			}
			else
			print "Invalid UID";
		
	}

	if($did)
	{
			$query = "select `t1`.`fname` as `fname`, `t1`.`url` as `url`, `t1`.`size` as `size`, `t2`.`on` as `on` from `downloads` as `t2`, `files` as `t1` where `t1`.`fid` = `t2`.`fid` and `t2`.`uid` = '$did'";
			$result = mysql_query($query) or die(mysql_error());
			
			if(mysql_num_rows($result) > 0)
			{
				print "<table cellspacing='2px'><tr><td colspan='2'><strong>Download details for $did</strong></td></tr><tr><td><strong>Filename</strong></td><td><strong>Size</strong></td><td><strong>On</strong></td><td><strong>URL</strong></td></tr>";
				while($row = mysql_fetch_array($result))
				{
					$usage = convertBytes($row['size']);
					print "<tr><td>$row[fname]</td><td>$usage</td><td>$row[on]</td><td>$row[url]</td></tr>";
				}
				print "</table>";
			}
			else
			print "Invalid UID";
		
	}


	print "<br><br><br>";
	
	$query = "select * from `users`";
	$result = mysql_query($query) or die(mysql_error());
	if(mysql_num_rows($result) > 0)
	{
		print "<table width='100%' cellspacing='5px' cellpadding='5px'><tr style='text-align:center'><td><strong>User id</strong></td><td><strong>Email id</strong></td><td><strong>Member since</strong></td><td><strong>Total data used</strong></td><td><strong>Download stats</strong></td><td><strong>Downloads</strong></td></tr>";
		while($row = mysql_fetch_array($result))
		{
			$usage = convertBytes($row['volume']);
			print "<tr><td>$row[uname]</td><td>$row[email]</td><td>$row[created_on]</td><td>$usage</td><td><a href='viewusers.php?uid=$row[uname]'>Volume</a></td><td><a href='viewusers.php?did=$row[uname]'>Downloads</a></td></tr>";
		}
		print "</table>";
	}
	else
	print "No users yet";
	
	
?>

</div>
</div>

</div>


</body>
</html>
				<?php


		}
	}
}

else
	header("Location: index.php");
?>