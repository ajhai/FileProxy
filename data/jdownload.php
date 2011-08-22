<html>
<head>
</head>
<body>
<?php
	include "../config/connect.php";
	include "../config/config.php";
	
	$id = strip_tags($_GET['id']);
	
	if(strlen($id) == 0)
	{
		print "Invalid URL";
	}
	else
	{
		$query = "select * from `downloads` where `jhash` = '$id'";
		$result = mysql_query($query) or die("Failed to query" . mysql_error());
		if(mysql_num_rows($result) > 0)
		{
			$i = 0;
			while($row = mysql_fetch_array($result))
			{
				$i++;
				print "<a href='directhttp://" . SITE_DOMAIN . "/data/download.php?id=$row[hash]'>" . SITE_DOMAIN . "/data/download.php?id=$row[hash]</a><br>";
			}
		}
		else
		print "Invalid URL";
	}
?>
</body>
</html>