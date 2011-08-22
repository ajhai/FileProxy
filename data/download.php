<?php
#
# @author  ajhai
# @license MIT License
#
	include "../config/connect.php";
	
	$id = strip_tags($_GET['id']);
	
	if(strlen($id) == 0)
	{
		print "Invalid URL";
	}
	else
	{
		$query = "select `files`.`final_fname` as `final_fname`, `files`.`downloaded` as `downloaded`, `files`.`fname` as `fname` from `downloads`, `files` where `downloads`.`fid` = `files`.`fid` and `hash` = '$id'";
		$result = mysql_query($query) or die("Failed to query" . mysql_error());
		if(mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_array($result);
			
			if($row[downloaded] == 1)
			{
				$file = $row[final_fname];
				$filesize = filesize($file);
				$offset = 0;
				$length = $filesize;
				$chunk_size = 4;
				if ( isset($_SERVER['HTTP_RANGE']) ) {
				        // if the HTTP_RANGE header is set we're dealing with partial content

				        $partialContent = true;

				        // find the requested range
				        // this might be too simplistic, apparently the client can request
				        // multiple ranges, which can become pretty complex, so ignore it for now
				        preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches);

				        $offset = intval($matches[1]);
				        $length = intval($matches[2]) - $offset;
				} else {
				        $partialContent = false;
				}

				$fp = fopen($file, 'rb');

				// seek to the requested offset, this is 0 if it's not a partial content request
				fseek($fp, $offset);

				

				if ( $partialContent ) {
				        // output the right headers for partial content

				        header('HTTP/1.1 206 Partial Content');

				        header('Content-Range: bytes ' . $offset . '-' . ($offset + $length) . '/' . $filesize);
				}
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$ctype = finfo_file($finfo, $row[final_fname]);
				// output the regular HTTP headers
				header('Content-Type: ' . $ctype);
				header('Content-Length: ' . $filesize);
				header('Content-Disposition: attachment; filename="' . $row[fname] . '"');
				header('Accept-Ranges: bytes');

				// don't forget to send the data too
				while(!feof($fp))
				{
					//reset time limit for big files
					set_time_limit(0);
					print(fread($fp, 1024*8));
					flush();
					ob_flush();
				}
				fclose($fp);
				
			}
			else
			print "Preparing your download. Please check back in sometime. Sorry for the inconvenience";
		}
		else
		print "Invalid URL";
	}
?>