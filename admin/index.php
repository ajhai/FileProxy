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
		}
		else{
			header("Location: members.php");
		}
	}
}

if (isset($_POST['submit'])) {
	if(!$_POST['admin_id'] | !$_POST['admin_pass'])
		die('You did not fill in a required field.');
	

	
	$check = mysql_query("SELECT * FROM admins WHERE admin_id = '".$_POST['admin_id']."'")or die(mysql_error());
	$check2 = mysql_num_rows($check);
	
	if ($check2 == 0)
		die('Access Denied !!!');
	
	while($info = mysql_fetch_array( $check )){
		$_POST['admin_pass'] = stripslashes($_POST['admin_pass']);
		$info['admin_pass'] = stripslashes($info['admin_pass']);
		$_POST['admin_pass'] = md5($_POST['admin_pass']);

		//gives error if the password is wrong
		if ($_POST['admin_pass'] != $info['admin_pass']){
			echo($info['admin_pass']);
			die('Incorrect password, please try again.');
		}
		else{

			// if login is ok then we add a cookie
			$_POST['admin_id'] = stripslashes($_POST['admin_id']);
			$hour = time() + 3600;
			setcookie(admin_ID_my_site, $_POST['admin_id'], $hour);
			setcookie(admin_Key_my_site, $_POST['admin_pass'], $hour);

			$ip = $_SERVER['REMOTE_ADDR'];
			$query = "insert into history (ip) values ('$ip')";			
			mysql_query($query) or die(mysql_error());

			//then redirect them to the members area
			header("Location: members.php");
		}
	}
}

else{

	// if they are not logged in
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style/nav.css" rel="stylesheet" type="text/css">
<link href="style/main.css" rel="stylesheet" type="text/css">
</head>

<body id="page">
<div id="wrapper">

<div id="content">
<div class="loginback"><font size="+2"><b>Administrator Login</b></font></div><br>
<center>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<table border="0">
	<tr><td>Username:</td><td>
	<input type="text" name="admin_id" maxlength="40"> &nbsp;
	</td></tr>
	<tr><td>Password:</td><td>
	<input type="password" name="admin_pass" maxlength="50">
	</td></tr>
	<tr><td colspan="2" align="right">
	<input type="submit" name="submit" value="Login">
	</td></tr>
	</table>
	</form>
	</center>
</div>

</div>


</body>
</html>

<?php
}

?> 

