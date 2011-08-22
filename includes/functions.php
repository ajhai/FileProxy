<?php
#
# @author  ajhai
# @license MIT License
#
	function IsEMail($email)
	{
		if(eregi("^[a-zA-Z0-9]+[_a-zA-Z0-9-]*(\.[_a-z0-9-]+)*@[a-zöäüÖÄÜ0-9]+(-[a-zöäüÖÄÜ0-9]+)*(\.[a-zöäüÖÄÜ0-9-]+)*(\.[a-z]{2,4})$", $email))
		{
			return true;
		}
		return false;
	}
	
	function generateHash($email)
	{
		$hash = $email . time();
		$hash = md5($hash);
		return $hash;
	}
	
?>