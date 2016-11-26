
<?php>
include_once('Connection.php');

echo "<script type='text/javascript'>alert('heyyyy');</script>";

	$username = $_POST["username"];
	$name = $_POST["name"];
	$email = $_POST["email"];
	$postCode = $_POST["postCode"];
	$birthdate = $_POST["birthdate"];
	$password = $_POST["password"];
	$profilePic = $_POST["profilePic"];

	echo("hello");
	//echo "<script type='text/javascript'>alert('$username');</script>";

	// Insert Message
	$stmt = $dbh->prepare("INSERT INTO user VALUES (null, ?, ?, ?, ?, ? ,?, ?)");
	$stmt->execute(array($name, $email, $birthdate, $postCode,$username, $password , $profilePic));
	
	//$stmt = $dbh->prepare("SELECT * FROM user");
	 //$stmt->execute();
	 //$messages = $stmt->fetchAll();
	  //echo json_encode($messages);

?>