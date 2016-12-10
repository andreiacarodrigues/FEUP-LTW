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
        echo 'ACCESS DENIED : you do not have permission to see this page';
        die();
    }
}
else{
    echo 'ACCESS DENIED : the user must be logged in';
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

        $('#updateProfilePhoto #val').attr("value", username);

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

                console.log("Informacaoes : ");
                console.log(info);

                $('#username').attr("placeholder",username);
                $('#name').attr("placeholder",info[0]);
                $('#email').attr("placeholder",info[1]);

                var date = info[2].split("-");
                _("birthdate").valueAsDate = new Date(date[2],date[1]-1,date[0]);

                var res = info[3].split("-");
                $('#postcode1').attr("placeholder",res[0]);
                $('#postcode2').attr("placeholder",res[1]);

                var photoId = info[4];
                if(photoId != null)
                {
                    getPhoto(parseInt(photoId), false, '#main','', './css/images/');
                }
                else
                    $('#main').prepend('<img src="./css/images/1.jpg" alt="Photo that represents the restaurant">');

                _("cancel_btn1").onclick = function() {
                    window.location = 'userProfile.php?username='+username;
                };
                _("cancel_btn2").onclick = function() {
                    window.location = 'userProfileEdit.php?username='+username;
                };
            }
        };

        xmlhttp.open("GET","database/UserInfo.php?username="+ username,true);
        xmlhttp.send();
    }

    function getVar(id) {

        var myVar = _(id).value;
        if(myVar == "")
            myVar = _(id).placeholder;

        return myVar;
    }

    function save(){
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                var status = _("status");

                var u = getVar("username");
                var n = getVar("name");
                var e = getVar("email");

                var re =/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                var validated = re.test(e);
                if(!validated)
                    status.innerHTML = "Invalid e-mail.";

                var p1 = getVar("postcode1");
                var p2 = getVar("postcode2");

                if((p1.length != 4) || (p2.length != 3) || (!p1.match(/^[0-9]+$/)) || (!p2.match(/^[0-9]+$/)))
                    status.innerHTML = "Invalid postcode.";

                var b = _("birthdate").value;

                window.location = 'userProfile.php?username='+username; //u
            }
        };

        xmlhttp.open("GET","database/UpdateUser.php?username="+ username,true); //not sure se é assim
        xmlhttp.send();
    }

    function savePassword(){
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                var pass1 = _("new_pass").value;
                var pass2 = _("confirm_pass").value;
                if(pass1 != pass2)
                    status.innerHTML = "Your password fields do not match.";

                window.location = 'userProfile.php?username='+username; //u
            }
        };

        xmlhttp.open("GET","database/UpdateUserPassword.php?username="+ username,true); //not sure se é assim
        xmlhttp.send();
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
        <li id="UserInformations">
            <div>
                <form>
                    <label>Username:
                        <input id="username" type="text" name="username" onblur="checkUsername();" onkeyup="restrict('username');" maxlength="16">
                    </label>
                    <br>
                    <span id="unamestatus"></span>
                    <br>
                    <!-- <br>
                     <label>My information:
                         <textarea id="my_info" name="info" cols="40" rows="5"></textarea>
                     </label>-->
                    <br>
                    <label>Name:
                        <input id="name" type="text" name="name" maxlength="88">
                    </label>
                    <br>
                    <label>Email:
                        <input id="email" type="e-mail" name="email" maxlength="30">
                    </label>
                    <br>
                    <label>PostCode:
                        <input id="postcode1" type="text" maxlength="4"  name="postCode1"> <!-- javascript tem de ver se é numero -->
                        <label> -
                            <input id="postcode2" type="text" maxlength="3" name="postCode2">
                        </label>
                    </label>
                    <br>
                    <label>Birthdate:
                        <input id="birthdate" type="date" name="birthdate">
                    </label>
                    <br>
                    <p id="status"></p>
                    <a href="#ChangePassword">Mudar Pass</a><br>   <!-- clica e abre a opcao de mudar a password, no entanto pertence ao mesmo form-->
                    <button type="button" onclick="save();"> Send</button>
                    <button id="cancel_btn1" type="button"> Cancel</button>
                </form>
            </div>
        </li>
        <li id="ChangePassword">
            <div>
                <form>
                    <label>Actual Password:
                        <input id="password" type="password" name="password" placeholder="Insert your password.." onblur="checkPassword();" maxlength="30">
                    </label>
                    <br>
                    <span id="passstatus"></span>
                    <br>
                    <label>New Password:
                        <input id="new_pass" type="password" name="password" placeholder="Insert new password.." maxlength="30">
                    </label>
                    <br>
                    <label>Confirm Password:
                        <input id="confirm_pass" type="password" name="confirmPassword" placeholder="Insert again you new password.." maxlength="30">
                    </label>
                    <br>
                    <button type="button" onclick="savePassword();">Send</button>
                    <button id="cancel_btn2" type="button" >Cancel</button>
                </form>
            </div>
        </li>
    </ul>
</section>

<script language="JavaScript">
    $(document).ready(getInfo());
</script>