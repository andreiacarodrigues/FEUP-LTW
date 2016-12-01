<?php
// If user is logged in, header them away
if(isset($_SESSION["username"])){
	header("location: index.php");
    exit();
}
?>

<script language="JavaScript">
function _(x){
	return document.getElementById(x);
}

function restrict(elem){
	var tf = _(elem);
	console.log(tf);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "username"){
		rx = /[^a-z0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
	_(x).innerHTML = "";
}

function checkUsername(){
	var u = _("username").value;
	if(u != ""){
		_("unamestatus").innerHTML = 'Checking...';
	}
	if(userExists(u))
		_("unamestatus").innerHTML = 'Username accepted!';
	else
		_("unamestatus").innerHTML = 'Username already used!';
}
	
function signup(){
	var u = _("username").value;
	var n = _("name").value;
	var e = _("email").value;
	var p1 = _("postCode1").value;
	var p2 = _("postCode2").value;
	var b = _("birthdate").value;
	var pass1 = _("password").value;
	var pass2 = _("confirmPassword").value;
	var pic = _("profilePic").value;
	var status = _("status");
	if(u == "" || n == "" || e == "" || p1 == "" || p2 == "" || b == "" || pass1 == "" || pass2 == "" ){
		status.innerHTML = "Fill out all of the form data";
	} else if(pass1 != pass2){
		status.innerHTML = "Your password fields do not match";
	} 
	else if(!userExists(u))
	{
		status.innerHTML = "Username already used";
	}
	else 
	{
		var postCode = p1 + "-" + p2;
		
		if(pic == "")
			pic = "NULL";
		
		addUser(u, n, e, postCode, b, p1, pic);
		status.innerHTML = "Submited";
	}
}

</script>

<h2>SignUp</h2>
<div class="signUp">
    <form action="./index.php">
        <label>Username:
            <input type="text" name="username" id="username" onblur="checkUsername()" onkeyup="restrict('username')" maxlength="16">
        </label>
		<br>
		<span id="unamestatus"></span>
        <br>
        <label>Name:
            <input type="text" name="name" id="name" onfocus="emptyElement('status')" maxlength="88">
        </label>
        <br>
        <label>Email:
            <input type="e-mail" name="email" id="email" onfocus="emptyElement('status')" onkeyup="restrict('email')" maxlength="30" >
        </label>
        <br>
        <label>PostCode:
            <input type="text" maxlength="4" name="postCode1"  id="postCode1" > 
            <label> -
                <input type="text" maxlength="3" name="postCode2" id="postCode2" onfocus="emptyElement('status')" >
            </label>
        </label>
        <br>
        <label>Birthdate:
            <input type="date" name="birthdate"  id="birthdate" onfocus="emptyElement('status')">
        </label>
        <br>
        <label>Password:
            <input type="password" name="password" id="password" onfocus="emptyElement('status')" maxlength="16">
        </label>
        <br>
        <label>Confirm Password:
            <input type="password" name="confirmPassword"  id="confirmPassword" onfocus="emptyElement('status')" maxlength="16">
        </label>
        <br>
        <label>Profile Picture:
            <input type="file" name="profilePic" id="profilePic">
        </label>
		<p id="status"></p>
		<br>
        <input type="submit" onclick="signup()" value="Send">
        <input type="button" value="Cancel">
    </form>
</div>