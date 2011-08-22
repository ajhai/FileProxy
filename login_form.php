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

			displayLogin();

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