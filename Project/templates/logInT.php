<?php
if (isset ( $_SESSION ["userid"] ))
{
    echo "ACCESS DENIED : you are already logged in.";
    die();
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

                if(newResponseText == "ERROR") {
                    alert("ERROR : some variables are not defined");
                    return false;
                }
                if(newResponseText == "VALID")
                    window.location = 'index.php';
                else
                    _("status").innerHTML = newResponseText;
            }
        };
        xmlhttp.open("GET","database/login.php?username="+u + "&password="+p,true);
        xmlhttp.send();
    }
</script>


<section id="sectionBody">
	<h2>LogIn</h2>
	<div class="login">
		<form action="./index.php" method="post">
			<label>Username:
				<input type="text" name="username" id="username" placeholder="">
			</label>
			<br>
			<label>Password:
				<input type="password" name="password" id="password" placeholder="">
			</label>
			<br>
			<p id="status"></p>
			<br>
			<div id="buttons">
				<input type="button" value="Login" onclick="login()"/>
				<input type="button" value="Cancel" onclick="goHomePage()"/>
			</div>
		</form>
	</div>
</section>