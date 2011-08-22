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
			
			if(isset($_POST['submit']))
			{
				$oldpassword = strip_tags($_POST['opass']);
				$newpassword = strip_tags($_POST['npass']);
				$cpassword = strip_tags($_POST['cpass']);
				
				if(strcmp($newpassword, $cpassword) == 0)
				{
					if(strlen($newpassword) < 6)
					{
						print "Error: Password should be a minimum of 6 characters";
					}
					else
					{
						$query = "select * from `users` where `uname` = '$uname'";
						$result = mysql_query($query) or die(mysql_error());
						
						if(mysql_num_rows($result) > 0)
						{
							$row = mysql_fetch_array($result);
							if(strcmp(md5($oldpassword), $row['password']) == 0)
							{
								$nps = md5($newpassword);
								$query = "update `users` set `password` = '$nps' where `uname` = '$uname' limit 1";
								mysql_query($query) or die(mysql_error());
								
								$subject = "Password changed";
								$from = SITE_TITLE . " <no-reply@" . $_SERVER['SERVER_NAME'] . ">";
								$message = "<html><body>Hi,<br><br>&nbsp;&nbsp;Your password is changed.<br><br>Thanks,<br>Admin</body></html>";
								
								
								$headers = "From: $from\r\n";				
			
								$headers  .= "Content-type: text/html; charset=iso-8859-1rn";	
								
								mail($row['email'], $subject, $message, $headers);
								
								print "Your password is changed successfully.";
								
							}
							else
							print "Your old password did not match";
						}
						else
						print "Error: Invalid user";
					}
				}
				else
				print "Error: Password donot match.";
			}
			else
			print "Error..";
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
