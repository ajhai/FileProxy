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
				$cid = strip_tags($_GET['cid']);
			?>
				
				
				
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Admin Section</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style/nav.css" rel="stylesheet" type="text/css">
<link href="style/main.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="scripts/wysiwyg.js"></script>
<script type="text/javascript" src="scripts/wysiwyg-settings.js"></script>

</head>

<body id="page">
<div id="wrapper">

<!-- navigation starts here-->
<div id="modernbricksmenu">
<ul>
<li><a href="index.php" title="Home">Home</a></li>
<li><a href="viewitems.php" title="View Items">View Items</a></li>
<li><a href="winners.php" title="Winners">Winners</a></li>
<li><a href="add-item.php" title="Add Item">Add Item</a></li>	
<li><a href="viewProfile.php" title="Users">View Users</a></li>	
<li><a href="news.php" title="News">News</a></li>	
<li><a href="newsletter.php" title="News Letter">NewsLetters</a></li>	
<li><a href="transactions.php" title="Transactions">Transactions</a></li>
<li style="margin-left: 1px"  id="current"><a href="support.php" title="Support">Support</a></li>
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
	
		if(isset($_POST['sendletter']))
		{
		$subject = strip_tags($_POST['subject']);
		$body = $_POST['body'];
		$cid = strip_tags($_POST['cid']);
		$from = "SmartBod Team <support@smartbod.com>";
		$headers = "From: $from\r\n";				
		$headers  .= "Content-type: text/html; charset=iso-8859-1rn";
		
	$query = "select * from contact where cid = $cid";
	$result = mysql_query($query) or die(mysql_error());
	
	
	if(mysql_num_rows($result)>0)
	{
	while($row = mysql_fetch_array($result))
	{	
	mail($row[email], $subject, $body, $headers);																	
	}	
	}		
	
		print "<h3>Reply sent to the user.<br/></h3>";
		$cid = 0;
	}
	if($cid > 0)
	{?>
    <script type='text/javascript'>
									WYSIWYG.attach('textarea1', full);
									</script>
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                    <b>Enter Subject: </b>&nbsp;&nbsp;<input type="text" name="subject"> <input type="hidden" name="cid" value="<?php echo $cid; ?>"><br><br>
                                    <b>Enter the Content: </b>&nbsp;&nbsp;<textarea id="textarea1" name="body"></textarea>
                                    <br><input type="submit" name="sendletter" value='Send Reply'>
                                    </form>
    
    <?php
	}
	
	print "<br/>";
	$query = "select * from support order by sip desc";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) > 0)
	{
		print "<table cellspacing='5px' cellpadding='5px' width='100%' style='color:#000000'><tr><td><b>NAME</b></td><td><b>EMAIL</b></td><td><b>SUBJECT</b></td><td><b>BODY</b></td><td><b>ADDED ON</b></td><td><b>REPLY</b></td></tr>";
		while($row = mysql_fetch_array($result))
		{
			print "<tr><td>$row[uid]</td><td>$row[email]</td><td>$row[sub]</td><td>$row[desc]</td><td>$row[added_on]</td><td><a href='support.php?cid=$row[sip]'>CLICK TO REPLY</a></td></tr>";
		}
		print "</table>";
	}
	else
	print "No support requested.";

	

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