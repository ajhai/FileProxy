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
<!-- Head includes -->
<?php
	include "includes/header.php";
?>
<title><?php echo SITE_TITLE;?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<script type="text/javascript" src="js/md5.js"></script>
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
  <br>
  <?php
  	if($logged_in)
	{
	?>
  <div id="navigation">
    <ul id="menu">
    <li><a href="account.php" title="">Account</a></li>
    <li><a href="download.php" title="">Download</a></li>
    <li><a href="history.php" title="">History</a></li>
    <li><a href="extend_account.php" title="">Extend Account</a></li>
    <li><a href="support.php" title="">Support</a></li>
    </ul>
    </div>
   <?php
	}
	else
	print "<hr>";
	?>
    <div id="content">
      <p><strong>Q. What is this service about?</strong></p>
      <p><strong>A</strong>. We are a file mirroring site. Means that we download the files that you want from premium download servers and then allow you to download those files from our server at a maximum speed</p>
      <p>&nbsp;</p>
      <p><strong>Q. What are all premium file hosting servers that we can dowload the files from?</strong></p>
      <p><strong>A.</strong> For the time being we support downloads from Hotfile, Megaupload and rapidshare</p>
      <p>&nbsp;</p>
      <p><strong>Q. How much do you charge for this service?</strong></p>
      <p><strong>A.</strong> We are still in private beta. We will put up a cost table when once we're open to public. But be assured that the price will be less</p>
      <p>&nbsp;</p>
      <p><strong>Q. Do you support JDownloader?</strong></p>
      <p><strong>A.</strong> Yes. We do support JDownloader. Please check for JDownloader link below the direct download links</p>
      <p>&nbsp;</p>
      <p><strong>Q. What do i do if my files are not downloaded properly or if i don't get a download link?</strong></p>
      <p><strong>A.</strong> Try redownloading the link again by going to the download page. If that doesn't work, please write to us using the support page. We'll get back to you as fast as we can</p>
      <p>&nbsp;</p>
      <p><strong>Q. How do i get access to private beta?</strong></p>
      <p><strong>A.</strong> Please click on the image that is being displayed on the main page and submit your email address in the form provided. We'll provide you with beta access</p>
    </div>
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
