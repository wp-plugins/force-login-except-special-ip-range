<?php
# define here the array $ignore_pages
# all pages that are allowed to be called independend from the ip range 
# and if the user is logged in or not.
# At least wp-login.php is necessary - without you will run into an 
# endless redirect loop.

  $ignore_pages[]="wp-login.php";
  $ignore_pages[]="xmlrpc.php";
?>
