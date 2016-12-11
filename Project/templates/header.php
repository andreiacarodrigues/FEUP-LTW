<?php
include_once ('includes/autentication.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="css/stars.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="scripts/script.js"></script>
    <title>My WebPage</title>
</head>
<body>
    <header>
        <h1><a href="./index.php">My WebPage</a></h1>
        <?php
		
            if (isUserLoggedIn()) {
        ?>
        <div class="nav">
            <ul id>
				<li><a href="./index.php">Home</a></li>
                <li><a href="./userProfile.php">Perfil</a></li>
				 <li><a href="./Logout.php">LogOut</a></li>
            </ul>
        </div>
                <?php
            }else{
        ?>
		 <div class="nav">
            <ul id>
				<li><a href="./index.php">Home</a></li>
                <li><a href="./logIn.php">LogIn</a></li>
                <li><a href="./signUp.php">SignUp</a></li>
            </ul>
        </div>
       
        <?php
        }
        ?>
    </header>
<?php
?>