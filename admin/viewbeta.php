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
<li style="margin-left: 1px"  id="current"><a href="viewbeta.php" title="View Beta requests">View Beta requests</a></li>
<li><a href="viewusers.php" title="View Users">View Users</a></li>
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

	$grant = strip_tags($_GET['grant']);
	$restrict = strip_tags($_GET['restrict']);
	
	if($grant)
	{
		$r = '';
		for($i=0; $i<6; $i++)
			$r .= chr(rand(0, 25) + ord('a'));
			
		$pass = md5($r);
			
		$query = "insert into `users` (`password`, `email`, `created_on`) values ('$pass', '$grant', NOW())";
		mysql_query($query) or die(mysql_error());
		$id = mysql_insert_id();
		
						$subject = "Your private Beta access to Dwnld4me";
						$from = SITE_TITLE . " <no-reply@" . SITE_HOST . ">";
						$message = "<html><body>Hi,<br><p>Thanks for your interest in Download4me. Please find your login details below. <br>Your Login id is <b>$id</b><br>Your password is <b>$r</b>.</p><br>Thanks,<br>Admin<br><a href='" . SITE_DOMAIN . "' target='_blank'>" . SITE_TITLE . "</a></body></html>";
									
									
						$headers = "From: $from\r\n";				
				
						$headers  .= "Content-type: text/html; charset=iso-8859-1rn";	
									
						mail($grant, $subject, $message, $headers);	
						
		

		
		$query = "update `beta` set `active` = '1' where `email` = '$grant' limit 1";
		$result = mysql_query($query) or die(mysql_error());
		
		print "For $grant, Login id is $id and password is $r.<br>";
		
	}
	
	if($restrict)
	{
		$query = "update `beta` set `active` = '-1' where `email` = '$restrict' limit 1";
		$result = mysql_query($query) or die(mysql_error());
		
		print "$restrict is ignored<br>";
	}
	

	$query = "select * from `beta` where `active` = 0 order by `requested_on` asc";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) > 0)
	{
		print "<table cellpadding='5px' cellspacing='5px'><tr><td><b>Email</b></td><td><b>GRANT access</b></td><td><b>Decline access</b></td></tr>";
		while($row = mysql_fetch_array($result))
		print "<tr><td>$row[email]</td><td><a href='viewbeta.php?grant=$row[email]'><b>GRANT Access</b></a></td><td><a href='viewbeta.php?restrict=$row[email]'><b>Restrict Access</b></a></td></tr>";
		print "<table>";
	}
	else
	print "No beta requests to process";

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