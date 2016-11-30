<?php
include_once ("includes/autentication.php");

    if (isset ( $_POST ['username'] ) && isset ( $_POST ['password'] ))
    {
        echo "chegou aqui";
        login ( $_POST ['username'], $_POST ['password'] );
    }
?>

<h2>Login</h2>
<div class="login">
    <form action="./index.php" method="post"><!-- isto depois não pode ser assim (ainda nao esta feito) -->
        <label>Username:
            <input type="text" name="username" placeholder="Insert your username..">
        </label>
        <br>
        <label>Password:
            <input type="password" name="password" placeholder="Insert your password..">
        </label>
        <br>
        <input type="checkbox" name="remember_username" value="Remember_Username">Remember me
        <br>
        <input type="submit" value="Login">
        <input type="button" value="Cancel"><!-- ?? -->
    </form>
</div>