
<?php>
include_once('database/connection.php');

echo "<script type='text/javascript'>alert('heyyyy');</script>";
/*if (isset($_GET['username']) && isset($_GET['name']) && isset($_GET['email']) && isset($_GET['postCode']) && isset($_GET['birthdate']) && isset($_GET['password']) && isset($_GET['profilePic']) ) 
{
	$username = $_GET["username"];
	$name = $_GET["name"];
	$email = $_GET["email"];
	$postCode = $_GET["postCode"];
	$birthdate = $_GET["birthdate"];
	$password = $_GET["password"];
	$profilePic = $_GET["profilePic"];

	echo("hello");
	//echo "<script type='text/javascript'>alert('$username');</script>";

	// Insert Message
	$stmt = $dbh->prepare("INSERT INTO user VALUES (null, ?, ?, ?, ?, ? ,?, ?)");
	$stmt->execute(array($name, $email, $birthdate, $postCode,$username, $password , $profilePic));
	
	//$stmt = $dbh->prepare("SELECT * FROM user");
	 //$stmt->execute();
	 //$messages = $stmt->fetchAll();
	  //echo json_encode($messages);
}*/
?>