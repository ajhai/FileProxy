<?php
#
# @author  ajhai
# @license MIT License
#
$past = time() - 100;
//this makes the time in the past to destroy the cookie
setcookie(admin_ID_my_site, gone, $past);
setcookie(admin_Key_my_site, gone, $past);
header("Location: index.php");
?> 