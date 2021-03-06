<?php
// If user is logged in, header them away
if(isset($_SESSION["userid"])){
    header("location: index.php");
    die();
}
?>

<script language="JavaScript">

    function signup(){
        var u = _("username").value;
        var n = _("name").value;
        var e = _("email").value;
        var p1 = _("postCode1").value;
        var p2 = _("postCode2").value;
        var postCode = p1+"-"+p2;
		var l = _("location").value;
        var b = _("birthdate").value;
        var pass1 = _("password").value;
        var pass2 = _("confirmPassword").value;
        var status = _("status");

        //validacoes regex
        if(u == "" || n == "" || e == "" || p1 == "" || p2 == "" || b == "" || pass1 == "" || pass2 == "" )
            status.innerHTML = "Fill out all of the form data";
        else if(!is_username(u))
            status.innerHTML = "Invalid username.";
        else if(!is_name(n))
            status.innerHTML = "Invalid name.";
        else if(!is_email(e))
            status.innerHTML = "Invalid email.";
        else if(!is_postCode(postCode))
            status.innerHTML = "Invalid postcode.";
        else if(!is_password(pass1) || !is_password(pass2))
            status.innerHTML = "Invalid password. " +
                "Passwords must have at least 6 alphanumeric characters.";
        else if(pass1 != pass2)
            status.innerHTML = "Your password fields do not match.";
		 else if(!is_text(l))
            status.innerHTML = "Invalid location.";
        else
        {
            status.innerHTML = "";
            var postCode = p1 + "-" + p2;

            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    goHomePage();
                }
            };
            xmlhttp.open("GET","database/addUser.php?username="+u + "&name="+n+"&email="+e+"&postCode="+postCode+"&location="+l+"&birthdate="+b+"&password="+pass1,true);
            xmlhttp.send();

            return true;
        }
        return false;
    }
	

</script>

<section id="sectionBody">
	<h2>SignUp</h2>
	<div class="signUp">
		<form>
			<label>Username:<input type="text" name="username" id="username" onblur="checkUsername();" onkeyup="restrict('username');" maxlength="20"> </label> <br>
			<p id="unamestatus"></p> <br>
			<label>Name: <input type="text" name="name" id="name" onfocus="emptyElement('status');" maxlength="88"></label> <br>
			<label>Email:<input type="email" name="email" id="email" placeholder="" onfocus="emptyElement('status');" maxlength="30" > </label><br>
			<label>PostCode: <input type="text" maxlength="4" name="postCode1"  id="postCode1" > -<input type="text" maxlength="3" name="postCode2" id="postCode2" onfocus="emptyElement('status');" > </label>
			</label> <br>
			<label>Location: <input type="text" name="location" id="location" onfocus="emptyElement('status');" maxlength="88"></label> <br>
			<label>Birthdate:<input type="date" name="birthdate"  id="birthdate" onfocus="emptyElement('status');"></label> <br>
			<label>Password:<input type="password" name="password" id="password" onfocus="emptyElement('status');" maxlength="30"></label><br>
			<label>Confirm Password: <input type="password" name="confirmPassword"  id="confirmPassword" onfocus="emptyElement('status');" maxlength="30"> </label><br>
			<p id="status"></p><br>
			<div id="buttons">
				<input type="button" onclick="signup()" value="Submit Info">
				<input type="button" onclick="goHomePage()" value="Cancel">
			</div>
		</form>
	</div>
</section>