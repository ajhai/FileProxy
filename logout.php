<?php
#
# @author  ajhai
# @license MIT License
#
session_start(); 
include("config/connect.php");
include("login.php");

/**
 * Delete cookies - the time must be in the past,
 * so just negate what you added when creating the
 * cookie.
 */
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
   setcookie("cookname", "", time()-60*60*24*100, "/");
   setcookie("cookpass", "", time()-60*60*24*100, "/"); 
}

?>

<html>
<title>Logging Out</title>
<body>

<?php

if(!$logged_in){
   echo "<h1>Error!</h1>\n";
   echo "You are not currently logged in, logout failed. Back to <a href=\"main.php\">main</a>";
}
else{
   /* Kill session variables */
   unset($_SESSION['username']);
   unset($_SESSION['password']);
   $_SESSION = array(); // reset session array
   session_destroy();   // destroy session.

   echo "<font style='background-color:#FF0000; color:#FFFFFF; font-size: 16px; font-weight: 600'>Logging Out</font>\n";
   print "<script>self.location = 'index.php';</script>";
}

?>

</body>
</html>