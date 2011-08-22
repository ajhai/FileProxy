<?php
#
# @author  ajhai
# @license MIT License
#

/**
 * Checks whether or not the given username is in the
 * database, if so it checks if the given password is
 * the same password in the database for that user.
 * If the user doesn't exist or if the passwords don't
 * match up, it returns an error code (1 or 2). 
 * On success it returns 0.
 */
function confirmUser($username, $password){
   /* Add slashes if necessary (for query) */
   if(!get_magic_quotes_gpc()) {
	$username = addslashes($username);
   }

   /* Verify that user is in database */
   $q = "select `password` from `users` where `uname` = '$username'";
   $result = mysql_query($q);
   if(!$result || (mysql_numrows($result) < 1)){
      return 1; //Indicates username failure
   }

   /* Retrieve password from result, strip slashes */
   $dbarray = mysql_fetch_array($result);
   $dbarray['password']  = stripslashes($dbarray['password']);
   $password = stripslashes($password);

   /* Validate that password is correct */
   if($password == $dbarray['password']){
      return 0; //Success! Username and password confirmed
   }
   else{
      return 2; //Indicates password failure
   }
}

/**
 * checkLogin - Checks if the user has already previously
 * logged in, and a session with the user has already been
 * established. Also checks to see if user has been remembered.
 * If so, the database is queried to make sure of the user's 
 * authenticity. Returns true if the user has logged in.
 */
function checkLogin(){
   /* Check if user has been remembered */
   if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
      $_SESSION['username'] = $_COOKIE['cookname'];
      $_SESSION['password'] = $_COOKIE['cookpass'];
   }

   /* Username and password have been set */
   if(isset($_SESSION['username']) && isset($_SESSION['password'])){
      /* Confirm that username and password are valid */
      if(confirmUser($_SESSION['username'], $_SESSION['password']) != 0){
         /* Variables are incorrect, user not logged in */
         unset($_SESSION['username']);
         unset($_SESSION['password']);
         return false;
      }
      return true;
   }
   /* User not logged in */
   else{
      return false;
   }
}

/**
 * Determines whether or not to display the login
 * form or to show the user that he is logged in
 * based on if the session variables are set.
 */
function displayLogin(){
   global $logged_in;
   if($logged_in){
      echo "<br/>Welcome <b>$_SESSION[username]</b>, you are currently logged in. <a href=\"logout.php\" class='options'>Logout</a>";
   }
   else{
?>
<form action="" method="post" name="login">
<table id="login_signup_forms" cellpadding="0px" cellspacing="5px" style="width:350px">
<tr><td><font>Log in to your account</font> &nbsp;or <a href="signup.php" class="options">Sign up</a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td class="title">Username <a href="forgot_uname.php" class="options" style="float:right; font-size:14px">I forgot my username</a></td></tr>
<tr><td><input type="text" name="user_temp" maxlength="30" size="52" class="field"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td class="title">Password <a href="forgot_pass.php" class="options" style="float:right; font-size:14px">I forgot my password</a></td></tr>
<tr><td><input type="password" name="pass_temp" maxlength="30" size="52" class="field"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><input type="checkbox" name="remember" />&nbsp;Remember me on this computer</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><input onClick="passResponse(); return false;" type="image" name="sublogin" value="Login" src="i/login.gif" style="outline:none"></td></tr>
</table>
</form>
<form action="" METHOD="POST" name="hform">
<input type="hidden" name="user">
<input type="hidden" name="pass">
<input type="hidden" name="sublogin">
</form>
<?php
   }
}


/**
 * Checks to see if the user has submitted his
 * username and password through the login form,
 * if so, checks authenticity in database and
 * creates session.
 */
if(isset($_POST['sublogin'])){
   /* Check that all fields were typed in */
   if(!$_POST['user'] || !$_POST['pass']){
      print "<script>  alert(\"You didn\'t fill in a required field.\"); </script>";
   }
   /* Spruce up username, check length */
   $_POST['user'] = trim($_POST['user']);
   if(strlen($_POST['user']) > 30){
      print "<script>  alert(\"Sorry, the username is longer than 30 characters, please shorten it.\"); </script>";
   }

   /* Checks that username is in database and password is correct */
   $md5pass = $_POST['pass'];
   $result = confirmUser($_POST['user'], $md5pass);
   /* Check error codes */
   if($result == 1){
      print "<script>  alert(\"Username or the password are incorrect.\"); </script>";
   }
   else if($result == 2){
      print "<script>  alert(\"Username or the password are incorrect.\"); </script>";
   }

   /* Username and password correct, register session variables */
   $_POST['user'] = stripslashes($_POST['user']);
   $_SESSION['username'] = $_POST['user'];
   $_SESSION['password'] = $md5pass;

   /**
    * This is the cool part: the user has requested that we remember that
    * he's logged in, so we set two cookies. One to hold his username,
    * and one to hold his md5 encrypted password. We set them both to
    * expire in 100 days. Now, next time he comes to our site, we will
    * log him in automatically.
    */
   if(isset($_POST['remember'])){
      setcookie("cookname", $_SESSION['username'], time()+60*60*24*100, "/");
      setcookie("cookpass", $_SESSION['password'], time()+60*60*24*100, "/");
   }

   /* Quick self-redirect to avoid resending data on refresh */
   
   if(checkLogin())
   echo "<meta http-equiv=\"Refresh\" content=\"0;url=download.php\">";
   return;
}

/* Sets the value of the logged_in variable, which can be used in your code */
$logged_in = checkLogin();

?>