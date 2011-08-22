<?php
#
# @author  ajhai
# @license MIT License
#
	include "config/connect.php";
	include "includes/functions.php";
	include "login.php";
	
	$uname = $_SESSION['username'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<!-- Head includes -->
<?php
	include "includes/header.php";
?>
<title><?php echo SITE_TITLE;?></title>

<script language="javascript" src="js/md5.js"></script>
<script language="javascript" src="js/functions.js"></script>
<link rel="stylesheet" type="text/css" href="css/styles.css" />

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
    <?php 	
		if($logged_in == false)
    	print "<hr noshade color='#CCCCCC' size='1'/>";
	?>
  <div id="wrapper">
    <div id="content">
		<?php
			print "<strong>Forgot Login ID</strong><hr><br>";
			if(isset($_POST['submit']))
			{
				$email = strip_tags($_POST['email']);
				
				if(strlen($email) == 0)
				{
					print "* All fields are mandatory<br><br>";
					print "<form method='post' action=''><b>Your Email address</b>&nbsp;<input type='text' name='email'>&nbsp;&nbsp;<input type='submit' name='submit' value='Request Login ID'></form>";
				}
				else
				{
					$query = "select * from `users` where `email` = '$email'";
					$result = mysql_query($query);
					if(mysql_num_rows($result) > 0)
					{
						$row = mysql_fetch_array($result);

						$subject = "Your Login ID";
						$from = SITE_TITLE . " <no-reply@" . $_SERVER['SERVER_NAME'] . ">";
						$message = "<html><body>Hi,<br>&nbsp;&nbsp;Your login ID is <b>$row[uname]</b>.<br>Thanks,<br>Admin</body></html>";
									
									
						$headers = "From: $from\r\n";				
				
						$headers  .= "Content-type: text/html; charset=iso-8859-1rn";	
									
						mail($row['email'], $subject, $message, $headers);		
						
						print "<br><br>Your login ID is mailed to the email address you provided";

					}
					else
					{
						print "* Invalid email address<br><br>";
						print "<form method='post' action=''><b>Your Email address</b>&nbsp;<input type='text' name='email'>&nbsp;&nbsp;<input type='submit' name='submit' value='Request Login ID'></form>";
					}
				}
			}
			else
			{
				print "<form method='post' action=''><b>Your Email address</b>&nbsp;<input type='text' name='email'>&nbsp;&nbsp;<input type='submit' name='submit' value='Request Login ID'></form>";
			}
		?>
	</div>
  </div>
<!-- Footer includes -->
  <?php
  	include "includes/footer.php";
  ?>
<!-- Footer includes -->
</div>
</body>
</html>