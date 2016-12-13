<?php

if (isUserLoggedIn ())
{
    //primeiro, decobrir o username
    if (isset ( $_GET ["username"] )) {
        $username = trim(strip_tags($_GET["username"]));
    }
    else if (isset ( $_SESSION ["userid"] )) {
        $username = $_SESSION ["userid"];
    }
    else {
        die();
    }

    //segundo verificar se o utilizador corresponde ao que fez login, só assim pode editar o seu perfil
    if($username != $_SESSION ["userid"]){
        echo 'ACCESS DENIED : you do not have permission to acess this page';
        die();
    }
}
else{
    echo 'ACCESS DENIED : you must be logged in to acess this page';
    die();
}

?>

<script language="JavaScript">

    var username = <?php echo json_encode($username) ?>;

    function checkPassword(){
        var p = _("password").value;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                var newResponseText = new String(this.responseText);
                var newResponseText = newResponseText.trim();

                if(newResponseText == "ERROR") {
                    alert("ERROR : some variables are not defined");
                    return false;
                }

                _("passstatus").innerHTML = newResponseText;
            }
        };

        xmlhttp.open("GET","database/userPassword.php?username="+username+"&password="+p,true);
        xmlhttp.send();
    }

    function getInfo(){

        $('#updateProfilePicture #val').attr("value", username);

        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                var info = new String(this.responseText);
                info = info.trim();

                if(info == "ERROR") {
                    alert("ERROR : some variables are not defined");
                    return false;
                }
                else if(info == "INVALID")
                    return false;
                else
                    info = eval("(" + this.responseText + ")");

                $('#username').attr("placeholder",username);
                $('#name').attr("placeholder",info[0]);
                $('#email').attr("placeholder",info[1]);

                var date = info[2].split("-");
                _("birthdate").valueAsDate = new Date(date[0],date[1]-1,date[2]);

                var res = info[3].split("-");
                $('#postCode1').attr("placeholder",res[0]);
                $('#postCode2').attr("placeholder",res[1]);

                var photoId = info[4];
                if(photoId != null)
                {
                    getPhoto(parseInt(photoId), false, '#main','', './css/images/');
                }
                else
                    $('#main').prepend('<img src="./css/images/1.jpg" alt="Photo that represents the restaurant">');
            }
        };

        xmlhttp.open("GET","database/userInfo.php?username="+ username,true);
        xmlhttp.send();
    }

    function submitInfo(){

        var previousUsername = username;
        var u = getVar("username");
        var n =  getVar("name");
        var e = getVar("email");
        var p1 = getVar("postCode1");
        var p2 = getVar("postCode2");
        var postcode = p1+"-"+p2;
        var b = getVar("birthdate");
        var status = _("status");

		console.log(_("unamestatus").innerHTML == "");
        //regex validations
        if(!is_username(u) || !((_("unamestatus").innerHTML == "Username accepted!") || (_("unamestatus").innerHTML == "")))
            status.innerHTML = "Invalid username.";
        else if(!is_name(n))
            status.innerHTML = "Invalid name.";
        else if(!is_email(e))
            status.innerHTML = "Invalid email.";
        else if(!is_postCode(postcode))
            status.innerHTML = "Invalid postcode.";
        else
        {
            status.innerHTML = "";
            var postCode = p1 + "-" + p2;

            $.get('./database/updateUI.php',  {username: u, name: n, email: e, postCode: postCode, birthdate: b, previousUsername: previousUsername}, function(data)
                {
                    var info = new String(data);
                    info = info.trim();

                    if(info == "ERROR") {
                        alert("ERROR : some variables are not defined");
                        return false;
                    }

                    console.log(data);
                    if(info == "0")
                        console.log("Error updating username information.");
                    else
                    {
                        window.location = 'userProfile.php?username='+u;
                    }
                }
            );
            return true;
        }
        return false;
    }

    function submitPassword()
    {
        var status = _("p_status");

        var currentPass = _("password").value;
        var newPass = _("new_pass").value;
        var confirmNewPass = _("confirm_pass").value;

        // Vê se algum dos campos é vazio
        if((currentPass == "") || (newPass == "") || (confirmNewPass == ""))
            status.innerHTML = "Fill out all of the passworld form data";
        else if(!is_password(newPass) || !is_password(confirmNewPass) || !is_password(currentPass))
            status.innerHTML = "Invalid password. Passwords must have at least 6 alphanumeric characters.";
        else
        {
            // Vê se já aceitou a password atual
            if(_("passstatus").innerHTML == "Password correct") {
                // Verifica se as duas novas passwords são iguais
                if (newPass != confirmNewPass)
                    status.innerHTML = "Your new password and the confirmation don't match!";
                else {
                    // Altera a password para a nova password introduzida
                    $.get('./database/updateUP.php', {username: username, password: newPass}, function (data) {
                            var info = new String(data);
                            info = info.trim();

                            if(info == "ERROR") {
                                alert("ERROR : some variables are not defined");
                                return false;
                            }

                            console.log(data);
                            if (info == "0")
                                console.log("Error updating username information.");
                            else {
                                window.location = 'userProfile.php?username=' + username;
                            }
                        }
                    );
                    return true;
                }
            }
        }
        return false;
    }

	function deleteAccount()
	{
		 $.get('./database/deleteUser.php',  {username: username}, function(data)
                {
                    var info = new String(data);
                    info = info.trim();

                    if(info == "0")
                        alert("Error deleting username information.");
                    else
                    {
                       window.location = "logout.php";
                    }
                }
            );
	}

</script>
<section id="sectionBody">
<h2> Edit User Profile </h2>
<section id="userEdit" >
<section id="main" >
    <form id="updateProfilePicture" action="./database/uploadPicture.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="method" value="1"/>
        <input id="val" type="hidden" name="val" value=""/>
        <input type="file" name="image" id="file1" class="inputfile" />
		<label for="file1">Choose a file</label>
        <input type="submit" value="Upload New Photo">
    </form>
    <form id="updateProfilePicture" action="./database/deletePP.php" method="post">
        <input id="val" type="hidden" name="val" value=""/>
		 <input type="hidden" name="method" value="1"/>
        <input name="mode" type="hidden" value="0"/>
        <input type="submit" value="Delete Photo">
    </form>
</section>

<section id="dashboard" >
    <ul>
        <li id="userInformations">
            <div>
                <form>
                   <label for="username">Username:<input id="username" type="text" name="username" onblur="checkUsername();" onkeyup="restrict('username');" maxlength="16"></label> <br>
                    <p id="unamestatus"></p>
                    <br>
                    <label for="name">Name:<input id="name" type="text" name="name" maxlength="88"></label><br>
                    <label for="email">Email: <input id="email" type="email" name="email" maxlength="30"> </label> <br>
                    <label for="postCode1">PostCode: <input id="postCode1" type="text" maxlength="4"  name="postCode1"> -<input id="postCode2" type="text" maxlength="3" name="postCode2"></label>
                    </label><br>
                    <label for="birthdate">Birthdate:<input id="birthdate" type="date" name="birthdate"></label><br>
                    <input type="button" onclick="submitInfo();" value="Submit Information">
                    <input type="button" onclick="goBack();" value="Cancel">
                    <p id="status"></p>
                </form>
            </div>
            
        </li>
		<a href="#changePassword" onclick="openChangePassword()">Change Password</a> 
        <li id="changePassword" style="display: none">
            <div>
                <form>
                    <label>Current Password:<input id="password" type="password" name="password" placeholder="" onblur="checkPassword();" maxlength="30"></label><br>
                    <span id="passstatus"></span><br>
                    <label>New Password:<input id="new_pass" type="password" name="password" placeholder="" maxlength="30"></label><br>
                    <label>Confirm New Password:<input id="confirm_pass" type="password" name="confirmPassword" placeholder="" maxlength="30"></label><br>
                    <input type="button" onclick="submitPassword();" value="Submit New Password">
                    <input type="button" onclick="openChangePassword();" value="Cancel">
                    <p id="p_status"></p>
                </form>
            </div>
        </li>
		<li> <input type="button" onclick="deleteAccount();" value="Delete Account"> <li>
    </ul>
</section>
</section>
</section>
<script language="JavaScript">
    $(document).ready(getInfo());
</script>