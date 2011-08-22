<?php
#
# @author  ajhai
# @license MIT License
#
	include "config/connect.php";
	include "includes/functions.php";
	include "login.php";
	
	if($logged_in)
	{
		$uname = $_SESSION['username'];
	}
	else
	echo "<meta http-equiv=\"Refresh\" content=\"0;url=login_form.php\">";
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<!-- Head includes -->
<?php
	include "includes/header.php";
?>
<title><?php echo SITE_TITLE;?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<script type="text/javascript" src="js/md5.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
</head>
<body>
<div id="container">
    <div id="header">
        <a href="<?php echo SITE_DOMAIN;?>"><img src="i/logo.png" class="logo" alt="<?php echo SITE_TITLE;?>" align="left"></a>
        <div id="nav">
	    <?php
        
			include "includes/nav.php";
		
		?>        
		</div>
    </div>
  <div id="wrapper">
  <div id="navigation">
    <ul id="menu">
    <li><a href="account.php" title="" class="current">Account</a></li>
    <li><a href="download.php" title="">Download</a></li>
    <li><a href="history.php" title="">History</a></li>
    <li><a href="extend_account.php" title="">Extend Account</a></li>
    <li><a href="support.php" title="">Support</a></li>
    </ul>
    </div>
    <div id="content">
		<?php
			
			$query = "select * from `users` where `uname` = '$uname'";
			$result = mysql_query($query) or die(mysql_error());
			
			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result);
				print "<strong>Account Information</strong><hr>";
				print "<table cellspacing='10px'><tr><td><b>Login ID</b></td><td>$uname</td></tr><tr><td><b>Email</b></td><td>$row[email]</td></tr><tr><td><b>Account created on</b></td><td>$row[created_on]</td></tr><tr><td><b>Account expires on</b></td><td>$row[expires_on]&nbsp;&nbsp;&nbsp;<strong><i><a href='extend_account.php'>_Extend account_</a></i></strong></td></tr></table><br><br>";
				print "<strong>Change Password</strong><hr>";
				print "<form method='post' action='cpassword.php'><table cellspacing='10px'><tr><td><b>Old Password</b></td><td><input type='password' name='opass' /></td></tr><tr><td><b>New Password</b></td><td><input type='password' name='npass' /></td></tr><tr><td><b>Confirm Password</b></td><td><input type='password' name='cpass' /></td></tr><tr><td></td><td><input type='submit' name='submit' value='Change Password' /></td></tr></table></form><br><br>";
			}
			else
			{
				print "Invalid user";
			}
			
		?>
    </div>
  <!-- Footer includes -->
  <?php
  	include "includes/footer.php";
  ?>
<!-- Footer includes -->
</div>
</div>
</body>
</html>
