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
			
			$fail = 0;
			
			if(isset($_POST['submit']))
			{
				$email = strip_tags($_POST['email']);
				$captcha = strip_tags($_POST['captcha']);
				
				if(strlen($email) == 0 || strlen($captcha) == 0)
				{
					print "<br><b>All fields are mandatory</b><br>";
					$fail = 1;
				}
				
				if(!IsEmail($email))
				{
					print "<br><b>Please enter a valid email address</b><br>";
					$fail = 1;
				}
				
				if(md5($captcha) != $_SESSION['image_random_value'])
				{
					print "<br><b>Captcha response is incorrect, please try again</b><br>";
					$fail = 1;
				}
				
				if($fail == 0)
				{
					$query = "select * from `beta` where `email` = '$email'";
					$result = mysql_query($query);
					
					if(mysql_num_rows($result) > 0)
					{
						print "<br><b>Beta access already requested with this email address. Try another email address</b><br>";
						$fail = 1;
					}
					else
					{
						$query = "insert into `beta` (`email`) values ('$email')";
						mysql_query($query) or die(mysql_error());
						
						print "<br><b>Thanks for your interest in us. We'll update you by email when you have beta access.</b><br>";
					}
				}
				
				
				if($fail == 1)
				{
					?>
                    <form method="post" action="signup.php" enctype="multipart/form-data">
                          <table id="login_signup_forms" cellpadding="0px" cellspacing="5px">
                          <tr><td><font style="font-size:18px; font-weight:600; color:#F60">Request Beta access</font></td></tr>
                          <tr><td>&nbsp;</td></tr>
                          <tr><td class="title">Email</td></tr>
                          <tr><td><input type="text" name="email" size="50" class="field" value="<?php echo $_SESSION['email'];?>"></td></tr>
                          <tr><td>&nbsp;</td></tr>
                          <tr><td class="title">Type the word</td></tr>
                          <tr><td><img src="captcha/verify.php" width="80" height="40" alt="Visual CAPTCHA" align="left" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="captcha" size="33" class="field" style="height:35px;"></td></tr>
                          <tr><td class="hints">We try to keep the bots away</td></tr>
                          <tr><td>&nbsp;</td></tr>      
                          <tr><td><input type="submit" name="submit" src="i/signup.gif" value="Sign Up" style="outline:none"></td></tr>
                          </table>
                    </form>                     
                    <?php
				}
				
			}
			else
			{
		?>
        	
        <form method="post" action="signup.php" enctype="multipart/form-data">
              <table id="login_signup_forms" cellpadding="0px" cellspacing="5px">
              <tr><td><font style="font-size:18px; font-weight:600; color:#F60">Request Beta access</font></td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td class="title">Email</td></tr>
              <tr><td><input type="text" name="email" size="50" class="field" value="<?php echo $_SESSION['email'];?>"></td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td class="title">Type the word</td></tr>
              <tr><td><img src="captcha/verify.php" width="80" height="40" alt="Visual CAPTCHA" align="left" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="captcha" size="33" class="field" style="height:35px;"></td></tr>
              <tr><td class="hints">We try to keep the bots away</td></tr>
              <tr><td>&nbsp;</td></tr>      
              <tr><td><input type="submit" name="submit" src="i/signup.gif" value="Sign Up" style="outline:none"></td></tr>
              </table>
        </form>            
        
        <?php
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