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
			?>
				
				
				
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Update News</title>
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
<li style="margin-left: 1px"  id="current"><a href="news.php" title="Users">News</a></li>	
<li><a href="newsletter.php" title="News Letter">NewsLetters</a></li>	
<li><a href="transactions.php" title="Transactions">Transactions</a></li>
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

	$nid = strip_tags($_GET['delete']);
	
	if($nid > 0)
	{
		$query = "delete from news where nid = $nid limit 1";
		mysql_query($query) or die(mysql_error());
		print "<h3>Deleted News Item.</br></h3>";
		
	}
	
	if(isset($_POST['addNews']))
	{
		$title = strip_tags($_POST['title']);
		$news = strip_tags($_POST['news']);
		
		if(strlen($title)==0 || strlen($news)==0)
		{
			print "News Item cannot be blank";
		}
		else
		{
		
		$query = "insert into news (title, news) values ('$title','$news')";
		mysql_query($query) or die(mysql_error());
		
		print "<h3>Succesfully Added News Item</h3>";
		}
	}?>
    <script type='text/javascript'>
									WYSIWYG.attach('textarea1', full);
									</script>
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                    <b>Enter Title: </b>&nbsp;&nbsp;<input type="text" name="title"> <br><br>
                                    <b>Enter the news item: </b>&nbsp;&nbsp;<textarea id="textarea1" name="news"></textarea>
                                    <br><input type="submit" name="addNews" value='Add News'>
                                    </form>
    <?php
	
	$query = "select * from news order by nid desc";
	$result = mysql_query($query);
	print "<table width='100%' cellspacing='5px' cellpadding='5px' style='color:#000000'><tr><td><b>TITLE</b></td><td><b>NEWS</b></td><td><b>ADDED ON</b></td><td><b>DELETE</b></td></tr>";
	while($row = mysql_fetch_array($result))
	{
		$desc = nl2br($row[news]);
		print "<tr><td>$row[title]</td><td>$desc</td><td>$row[added_on]</td><td><a href='news.php?delete=$row[nid]'>DELETE this item</a></td></tr>";
	}
	print "</table>";


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