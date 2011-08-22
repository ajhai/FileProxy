<?php
session_start();

// make a string with all the characters that we 
// want to use as the verification code
//$alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
//$rand = substr(shuffle($alphanum), 0, 5);

function RandomArray($min,$max,$num) {
$ret = array();
// as long as the array contains $num numbers loop
while (count($ret) <$num) {
do {
$a = rand($min,$max);
}
while (in_array($a,$ret));
$ret[] = $a;
}
return($ret);
}

$ret = randomArray(65,89,6);
$rand=chr($ret[0])."".chr($ret[1])."".chr($ret[2])."".chr($ret[3])."".chr($ret[4])."".chr($ret[5]);

// choose one of four background images
//$bgNum = rand(1, 4);

// create an image object using the chosen background
//$image = imagecreatefromjpeg("background$bgNum.jpg");
$image = imagecreatefromjpeg("2.jpg");

$textColor = imagecolorallocate ($image, 0, 0, 0); 

// write the code on the background image
imagestring ($image, 5, 5, 8,  $rand, $textColor); 
	

// create the hash for the verification code
// and put it in the session
$_SESSION['image_random_value'] = md5($rand);
	
// send several headers to make sure the image is not cached	
// taken directly from the PHP Manual
	
// Date in the past 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 

// always modified 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 

// HTTP/1.1 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false); 

// HTTP/1.0 
header("Pragma: no-cache"); 	


// send the content type header so the image is displayed properly
header('Content-type: image/jpeg');

// send the image to the browser
imagejpeg($image);

// destroy the image to free up the memory
imagedestroy($image);
?>