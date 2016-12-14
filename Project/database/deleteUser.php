<?php
//Profile Photo

include_once('my_database/user.php');

if (isset ($_GET["username"] ))
{
    $username = trim(strip_tags($_GET["username"]));
	if(!is_username($username))
		die('ERROR');
	
	deleteUser($username);
}
else
{
    die('ERROR');
}

?>
