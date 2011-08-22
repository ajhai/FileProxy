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
<li style="margin-left: 1px"  id="current"><a href="index.php" title="Home">Home</a></li>
<li><a href="viewbeta.php" title="View Beta requests">View Beta requests</a></li>
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

	if(isset($_POST['passChange']))
	{
		$uname = strip_tags($_POST['uname']);
		$oldpass = strip_tags($_POST['oldpass']);
		$npass = strip_tags($_POST['npass']);
		$rpass = strip_tags($_POST['rpass']);
		
		if(strlen($oldpass)==0 || strlen($npass)==0 || strlen($rpass)==0 || strlen($uname)==0)
		print "<b>[Error]  FIelds Cannot be left blank.</b><br>";		
		else if(strcmp($npass,$rpass)!=0)
		print "<b>[Error]  Passwords do not match.</b><br>";		
		else
		{
			$query = "select * from admins where admin_id='$uname'";
			$result = mysql_query($query) or die(mysql_error());
			$oldpass = md5($oldpass);
			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result);
				if(strcmp($oldpass,$row[admin_pass])==0)
				{
					$npass = md5($npass);
					$query = "update admins set admin_pass = '$npass' where admin_id = '$uname' limit 1";
					mysql_query($query) or die(mysql_error());
					print "<b>Succesfully changed Password </b><br>";
				}
				else
				print "<b>Error with username or password. Please go back and try again.</b>";
			}
			else
			print "<b>Error with username or password. Please go back and try again.</b>";
		}
	}

	if($del==1)	
	{
		?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
	<table cellpadding="5px" cellspacing="5px" width="100%">
	<tr><td><b>Type Username</b></td><td><input type="text" name="uname"></td></tr>
	<tr><td><b>Type Old Password</b></td><td><input type="password" name="oldpass"></td></tr>
    <tr><td><b>Type New Password</b></td><td><input type="password" name="npass"></td></tr>
    <tr><td><b>Re-Enter New Password</b></td><td><input type="password" name="rpass"></td></tr>
    <tr><td></td><td><input type="submit" name="passChange" value="Change Password"></td></tr>
    </table>
    </form>    
        
        <?php
	}
	print "<h4>Welcome Admin. <a href='members.php?del=1'>Click here</a> if you want to change your password.<br/></h4>";

	$query = "select * from history order by hno desc";
	$result = mysql_query($query) or die(mysql_error());
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$query1 = "select * from history where ip = '$ip' order by hno desc";
	$result1 = mysql_query($query1);
	if(mysql_num_rows($result)>0)
	{
	$row1 = mysql_fetch_array($result1);	
	print "You are logged in since <b><i>$row1[on]</i></b> with the IP address <b><i>$row1[ip]</i></b>";
	}

	if(mysql_num_rows($result)>1)
	{
		print "<br /><br /><br /><table cellpadding='5px' cellspacing='5px'><tr><td colspan='2' style='color:#000000'><b>LOGIN HISTORY</b></td></tr><tr><td><b>IP Address</b></td><td><b>Time</b></td></tr>";
		while($row=mysql_fetch_array($result))
		{
			print "<tr><td>$row[ip]</td><td>$row[on]</td></tr>";
		}		
		print "</table>";
	}	

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