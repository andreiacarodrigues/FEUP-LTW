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
				_("unamestatus").innerHTML = newResponseText;
			}
        };
        xmlhttp.open("GET","database/UserExists.php?username="+u,true);
        xmlhttp.send();
}
	
function goback()
{
	window.location = 'index.php';
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
	
	var re =/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var validated = re.test(e);
  
	if(u == "" || n == "" || e == "" || p1 == "" || p2 == "" || b == "" || pass1 == "" || pass2 == "" ){
		status.innerHTML = "Fill out all of the form data";
		
	} else if((p1.length != 4) || (p2.length != 3) || (!p1.match(/^[0-9]+$/)) || (!p2.match(/^[0-9]+$/)))
	{
		status.innerHTML = "Invalid postcode.";
	}		
	else if(pass1 != pass2){
		status.innerHTML = "Your password fields do not match.";
		
	} 
	else if(!validated)
	{
		status.innerHTML = "Invalid e-mail.";
		
	}
	else 
	{
		status.innerHTML = "";
		var postCode = p1 + "-" + p2;
		
		if(pic == "")
			pic = "NULL";
		
		
		if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
		
		xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				goback();
			}
        };
        xmlhttp.open("GET","database/AddUser.php?username="+u + "&name="+n+"&email="+e+"&postCode="+postCode+"&birthdate="+b+"&password="+pass1+"&pic="+pic,true);
        xmlhttp.send();
	}
}


</script>

<h2>SignUp</h2>
<div class="signUp">
    <form>
        <label>Username:
            <input type="text" name="username" id="username" onblur="checkUsername();" onkeyup="restrict('username');" maxlength="16">
        </label>
		<br>
		<span id="unamestatus"></span>
        <br>
        <label>Name:
            <input type="text" name="name" id="name" onfocus="emptyElement('status');" maxlength="88">
        </label>
        <br>
        <label>Email:
            <input type="email" name="email" id="email" placeholder="me@example.com" onfocus="emptyElement('status');" maxlength="30" >
        </label>
		<br>
        <label>PostCode:
            <input type="text" maxlength="4" name="postCode1"  id="postCode1" > 
            <label> -
                <input type="text" maxlength="3" name="postCode2" id="postCode2" onfocus="emptyElement('status');" >
            </label>
        </label>
		<br>
        <label>Birthdate:
            <input type="date" name="birthdate"  id="birthdate" onfocus="emptyElement('status');">
        </label>
		<br>
        <label>Password:
            <input type="password" name="password" id="password" onfocus="emptyElement('status');" maxlength="16">
        </label>
        <br>
        <label>Confirm Password:
            <input type="password" name="confirmPassword"  id="confirmPassword" onfocus="emptyElement('status');" maxlength="16">
        </label>
		<br>
        <label>Profile Picture:
            <input type="file" name="profilePic" id="profilePic">
        </label>
		<p id="status"></p>
		<br>
        <button type="button" onclick="signup()"> Send
        <button type="button" onclick="goback()"> Cancel
    </form>
</div>