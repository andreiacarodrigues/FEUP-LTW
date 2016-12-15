<?php
include_once('my_database/user.php');

if (isset ($_GET["username"] ))
    $username = trim(strip_tags($_GET["username"]));
else
    die('Invalid Name.');

if(!is_username($username))
	die('Invalid Name. Mininum required username size is 5 and only characters are allowed.');

$info = getUserInfo($username);

if(!empty($info))
    echo 'Username already used!';
else
    echo 'Username accepted!';

?>
