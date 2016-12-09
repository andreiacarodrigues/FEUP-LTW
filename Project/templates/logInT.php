<?php
include_once ("includes/autentication.php");

if (isset ( $_POST ['username'] ) && isset ( $_POST ['password'] ))
{
    echo "chegou aqui";
    login ( $_POST ['username'], $_POST ['password'] );
}
?>

<script language="JavaScript">

    function login()
    {
        var u = _("username").value;
        var p = _("password").value;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var newResponseText = new String(this.responseText);
                var newResponseText = newResponseText.trim();

                if(newResponseText == "VALID")
                    window.location = 'index.php';
                else
                    _("status").innerHTML = newResponseText;
            }
        };
        xmlhttp.open("GET","database/Login.php?username="+u + "&password="+p,true);
        xmlhttp.send();
    }
</script>

<h2>Login</h2>
<div class="login">
    <form action="./index.php" method="post"><!-- isto depois não pode ser assim (ainda nao esta feito) -->
        <label>Username:
            <input type="text" name="username" id="username" placeholder="Insert your username..">
        </label>
        <br>
        <label>Password:
            <input type="password" name="password" id="password" placeholder="Insert your password..">
        </label>
        <br>
        <p id="status"></p>
        <button type="button" onclick="login()">Login
            <button type="button">Cancel
    </form>
</div>