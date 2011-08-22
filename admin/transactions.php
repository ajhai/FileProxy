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
			$uid = strip_tags($_GET['user_id']);
			?>
				
				
				
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Transactions</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style/nav.css" rel="stylesheet" type="text/css">
<link href="style/main.css" rel="stylesheet" type="text/css">
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
<li><a href="news.php" title="Users">News</a></li>	
<li><a href="newsletter.php" title="News Letter">NewsLetters</a></li>	
<li style="margin-left: 1px"  id="current"><a href="transactions.php" title="Transactions">Transactions</a></li>	
<li><a href="support.php" title="Support">Support</a></li>
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

	if($uid > 0)
	{
			$query = "select * from transactions where user_id = $uid order by tid desc";
			$result = mysql_query($query) or die("Couldn't read transaction table" . mysql_error());
			
			if(mysql_num_rows($result) > 0)
			{
				print "<table cellpadding='5px' cellspacing='5px' width='100%'><tr><td><b>For</b></td><td><b>Description</b></td><td><b>Amount</b></td><td><b>Transaction Date</b></td></tr>";
				while($row = mysql_fetch_array($result))
				{
					$desc = str_replace("index.php?product_id","../index.php?product_id",$row['description']);
					print "<tr><td><a href='viewProfile.php?userid_id=$row[user_id]'>View User</a></td><td>$desc</td><td>$row[amount]</td><td>$row[dated]</td></tr>";
				}
				print "</table>";
			}
			else
			print "No transactions Yet";
	}
	else
	{
			$query = "select * from transactions order by tid desc";
			$result = mysql_query($query) or die("Couldn't read transaction table" . mysql_error());
			
			if(mysql_num_rows($result) > 0)
			{				
				print "<table cellpadding='5px' cellspacing='5px' width='100%'><tr><td><b>For</b></td><td><b>Description</b></td><td><b>Amount</b></td><td><b>Transaction Date</b></td></tr>";
				while($row = mysql_fetch_array($result))
				{
					$desc = str_replace("index.php?product_id","../index.php?product_id",$row['description']);
					print "<tr><td><a href='viewProfile.php?userid_id=$row[user_id]'>View User</a></td><td>$desc</td><td>$row[amount]</td><td>$row[dated]</td></tr>";
				}
				print "</table>";
			}
			else
			print "No transactions Yet";
		
	}

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