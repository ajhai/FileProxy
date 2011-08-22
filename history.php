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
    <li><a href="history.php" title="" class="current">History</a></li>
    <li><a href="extend_account.php" title="">Extend Account</a></li>
    <li><a href="support.php" title="">Support</a></li>
    </ul>
    </div>
    <div id="content">
		<?php
		
			$query = "select `downloads`.`hash` as `hash`, `files`.`url` as `url`, `downloads`.`on` as `on` from `downloads`, `files` where `downloads`.`fid` = `files`.`fid` and `downloads`.`uid` = '$uname' order by `downloads`.`on` desc";
			$result = mysql_query($query) or die(mysql_error());
			if(mysql_num_rows($result) > 0)
			{
				print "<table cellspacing='5px' style='text-align:left' width='100%'><tr><td><strong>Link</strong></td><td style='text-align:center'><strong>Downloaded on</strong></td><td style='text-align:center'><strong>Download again</strong></td></tr>";
				while($row = mysql_fetch_array($result))
				{
					print "<tr><td>$row[url]</td><td style='text-align:center'>$row[on]</td><td style='text-align:center'><a href='data/download.php?id=$row[hash]' target='_blank' style='text-decoration:underline'>Download</a></td></tr>";
				}
				print "</table>";
			}
			else
			{
				print "No downloads yet";
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
