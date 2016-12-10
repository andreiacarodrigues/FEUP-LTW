<?php
include_once('Connection.php');

	global $db;
	
	$sessionUsername = $_GET["sessionUsername"];
	$username = $_GET["username"];
	
	$stmt = $db->prepare("SELECT username2 FROM Friend WHERE username1 = ?");
	$stmt->execute(array($sessionUsername));
	$result = $stmt->fetchAll();
	if(!empty($result))
	{
		foreach($result as $row) {
			if($username == $row['username2'])
			{
				echo "YES";
				exit;
			}
		}
		
	}
	else
		echo "NO";
?>