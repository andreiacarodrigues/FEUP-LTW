<?php
//Profile Photo

include_once('my_database/user.php');

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    $username = NULL;

if($username != NULL)
	echo deleteUser($username);

?>
