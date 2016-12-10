<?php

if (isUserLoggedIn ())
{
    //primeiro, decobrir o username
    if (isset ( $_GET ["username"] )) {
        $username = $_GET ["username"];
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

                _("passstatus").innerHTML = newResponseText;
            }
        };

        xmlhttp.open("GET","database/UserPassword.php?username="+username+"&password="+p,true);
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

                if(info == "INVALID")
                    return false;
                else
                    info = eval("(" + this.responseText + ")");
				
                $('#username').attr("placeholder",username);
                $('#name').attr("placeholder",info[0]);
                $('#email').attr("placeholder",info[1]);

                var date = info[2].split("-");
                _("birthdate").valueAsDate = new Date(date[2],date[1]-1,date[0]);

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

        xmlhttp.open("GET","database/UserInfo.php?username="+ username,true);
        xmlhttp.send();
    }

    function submitInfo(){
		
		var previousUsername = username;
		var u = getVar("username");
        var n =  getVar("name");
        var e = getVar("email");
        var p1 = getVar("postCode1");
        var p2 = getVar("postCode2");
        var b =  getVar("birthdate");
        var status = _("status");

        var re =/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var validated = re.test(e);

       if((p1.length != 4) || (p2.length != 3) || (!p1.match(/^[0-9]+$/)) || (!p2.match(/^[0-9]+$/)))
            status.innerHTML = "Invalid postcode.";
        else if(!validated)
            status.innerHTML = "Invalid e-mail.";
		else
			if(_("unamestatus").innerHTML != "Username accepted!")
				 status.innerHTML = "Invalid username.";
        else
        {
            status.innerHTML = "";
            var postCode = p1 + "-" + p2;

			$.get('./database/UpdateUI.php',  {username: u, name: n, email: e, postCode: postCode, birthdate: b, previousUsername: previousUsername}, function(data) 
			{
				var info = new String(data);
				info = info.trim();

				console.log(data);
				if(info == "0")
					console.log("Error updating username information.");
				else
				{
					window.location = 'userProfile.php?username='+u; 
				}
			}
			);
		}
    }

   function submitPassword(){
	    var status = _("p_status");
	    
		 var currentPass = _("password").value;
		 
		 var newPass = _("new_pass").value;
		 var confirmNewPass = _("confirm_pass").value;
		 
		 // Vê se algum dos campos é vazio
		 if((currentPass == "") || (newPass == "") || (confirmNewPass == ""))
			 status.innerHTML = "Fill out all of the passworld form data";
		 else
		 {
			// Vê se já aceitou a password atual
			if(_("passstatus").innerHTML == "Password correct")
			{
				// Verifica se as duas novas passwords são iguais
				if(newPass != confirmNewPass)
				{
					status.innerHTML = "Your new password and the confirmation don't match!";
				}
				else
				{
					// Altera a password para a nova password introduzida
					$.get('./database/UpdateUP.php',  {username: username, password: newPass}, function(data) 
					{
						var info = new String(data);
						info = info.trim();

						console.log(data);
						if(info == "0")
							console.log("Error updating username information.");
						else
						{
							window.location = 'userProfile.php?username='+username; 
						}
					}
					);
				}
			}
		}
   }
 

</script>

<section id="main" >
    <form id="updateProfilePicture" action="./database/UploadPicture.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="method" value="1"/>
        <input id="val" type="hidden" name="val" value=""/>
        <input type="file" name="image"/>
        <input type="submit" value="Upload New Photo">
    </form>
    <form id="updateProfilePicture" action="./database/DeleteUPP.php" method="post">
        <input id="val" type="hidden" name="val" value=""/>
        <input type="submit" value="Delete Photo">
    </form>
</section>

<section id="dashboard" >
    <ul>
        <li id="userInformations">
            <div>
                <form>
                    <label>Username:<input id="username" type="text" name="username" onblur="checkUsername();" onkeyup="restrict('username');" maxlength="16"></label> <br>
                    <span id="unamestatus"></span>
                    <br>
                    <!-- <br>
                     <label>My information:
                         <textarea id="my_info" name="info" cols="40" rows="5"></textarea>
                     </label>-->
                    <br>
                    <label>Name:<input id="name" type="text" name="name" maxlength="88"></label><br>
                    <label>Email: <input id="email" type="e-mail" name="email" maxlength="30"> </label> <br>
                    <label>PostCode: <input id="postCode1" type="text" maxlength="4"  name="postCode1"> <!-- javascript tem de ver se é numero -->
                        <label> -<input id="postCode2" type="text" maxlength="3" name="postCode2"></label>
					</label><br>
                    <label>Birthdate:<input id="birthdate" type="date" name="birthdate"></label><br>
                    <input type="button" onclick="submitInfo();" value="Submit Information">
                    <input type="button" onclick="goBack();" value="Cancel">
					<p id="status"></p>
                </form>
            </div>
		<a href="#changePassword">Change Password</a><br>   <!-- clica e abre a opcao de mudar a password, no entanto pertence ao mesmo form-->
        </li>
        <li id="changePassword">
            <div>
                <form>
                    <label>Current Password:<input id="password" type="password" name="password" placeholder="Insert your current password.." onblur="checkPassword();" maxlength="30"></label><br>
                    <span id="passstatus"></span><br>
                    <label>New Password:<input id="new_pass" type="password" name="password" placeholder="Insert new password.." maxlength="30"></label><br>
                    <label>Confirm New Password:<input id="confirm_pass" type="password" name="confirmPassword" placeholder="Insert again you new password.." maxlength="30"></label><br>
                    <input type="button" onclick="submitPassword();" value="Submit New Password">
                    <input type="button" onclick="goBack();" value="Cancel">
					<p id="p_status"></p>
                </form>
            </div>
        </li>
    </ul>
</section>

<script language="JavaScript">
    $(document).ready(getInfo());
</script>