<?php
include_once ('includes/autentication.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
   
    <title>My WebPage</title>
</head>
<body>
    <header>
        <h1><a href="./index.php">My WebPage</a></h1>
        <?php
		
            if (isUserLoggedIn()) {
        ?>
        <nav>
            <ul>
                <li><a href="./userProfile.php">Perfil</a></li>
                <li><a href="./Logout.php">LogOut</a></li>
            </ul>
        </nav>
                <?php
            }else{
        ?>
		 <nav>
            <ul>
                <li><a href="./logIn.php">LogIn</a></li>
                <li><a href="./signUp.php">SignUp</a></li>
            </ul>
        </nav>
       
        <?php
        }
        ?>
    </header>
<?php
?>