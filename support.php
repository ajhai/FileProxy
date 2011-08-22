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
    <li><a href="account.php" title="">Account</a></li>
    <li><a href="download.php" title="">Download</a></li>
    <li><a href="history.php" title="">History</a></li>
    <li><a href="extend_account.php" title="">Extend Account</a></li>
    <li><a href="support.php" title="" class="current">Support</a></li>
    </ul>
    </div>
    <div id="content">
		<?php
			
			if(isset($_POST['submit']))
			{
				$sub = strip_tags($_POST['sub']);
				$desc = strip_tags($_POST['desc']);
				
				if(strlen($sub) == 0 || strlen($desc) == 0)
				{
					print "* All fields are mandatory<br><br>";
					print "<form method='post' action=''><table cellpadding='10px'><tr><td><b>Regarding</b></td><td><input type='text' name='sub' size='51'></td></tr><tr><td><b>Description</b></td><td><textarea name='desc' rows='10' cols='40'></textarea></td></tr><tr><td></td><td><input type='submit' name='submit' value='Submit'></td></tr></table></form>";
				}
				else
				{
					$query = "select * from `users` where `uname` = '$uname'";
					$result = mysql_query($query) or die(mysql_error());
					
					if(mysql_num_rows($result) > 0)
					$row = mysql_fetch_row($result);
					
					$query = "insert into `support` (`uid`, `sub`, `desc`) values ('$uname', '$sub', '$desc')";
					mysql_query($query) or die(mysql_error());
					
					$subject = "Your request is logged";
					$from = SITE_TITLE . " <no-reply@" . $_SERVER['SERVER_NAME'] . ">";
					$message = "<html><body>Hi,<br>&nbsp;&nbsp;Your request is logged into our system. We will respond shortly.<br>Thanks,<br>Admin</body></html>";
								
								
					$headers = "From: $from\r\n";				
			
					$headers  .= "Content-type: text/html; charset=iso-8859-1rn";	
								
					mail($row['email'], $subject, $message, $headers);			
					
					$subject = "$uname contacted support";
					$from = SITE_TITLE . " <no-reply@" . $_SERVER['SERVER_NAME'] . ">";
					$message = "<html><body><b>Subject:</b>&nbsp;&nbsp;$sub<br><b>Description:</b>&nbsp;&nbsp;$desc</body></html>";
								
								
					$headers = "From: $from\r\n";				
			
					$headers  .= "Content-type: text/html; charset=iso-8859-1rn";	
								
					mail(ADMIN_EMAIL, $subject, $message, $headers);		
					
					print "<br><br>Thanks for contacting us. We will get back to you on your request at the earliest.";
				}
			}
			else
			{
				print "<form method='post' action=''><table cellpadding='10px'><tr><td><b>Regarding</b></td><td><input type='text' name='sub' size='51'></td></tr><tr><td><b>Description</b></td><td><textarea name='desc' rows='10' cols='40'></textarea></td></tr><tr><td></td><td><input type='submit' name='submit' value='Submit'></td></tr></table></form>";
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
