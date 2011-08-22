<?php
#
# @author  ajhai
# @license MIT License
#
        print "<table cellpadding='0px' cellspacing='15px' border='0px' class='nav'><tr>";
        
        if($logged_in)
        {
			print "<td><a href='index.php'>Home</a></td>";
			print "<td><a href='faq.php'>FAQ</a></td>";
            print "<td><a href='logout.php'>Log Out</a></td>";
        }
        else
        {
            print "<td><a href='index.php'>Home</a></td>";
			print "<td><a href='faq.php'>FAQ</a></td>";
            print "<td><a href='login_form.php'>Login</a></td>";        
        }
        print "</tr></table>";
?>