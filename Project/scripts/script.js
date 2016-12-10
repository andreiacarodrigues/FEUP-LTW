function getPhoto(id, isMenu, idPhoto, idMenu, path)
{
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var filename = new String(this.responseText);
            filename = filename.trim();

            if(filename == "INVALID")
                return false;

            var trimmedFilename =  filename.slice(1, -1);
            if(isMenu)
                $(idMenu).html('<img src="' + path + trimmedFilename + '"alt="Photo that represents the restaurant">');
            else
                $(idPhoto).prepend('<img src="' + path + trimmedFilename + '"alt="Photo that represents the restaurant">');

            return true;
        }
    };

    xmlhttp.open("GET","database/GetPhoto.php?id="+ id,true);
    xmlhttp.send();
}

function _(x){
    return document.getElementById(x);
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

function getVar(id) {

   var myVar = _(id).value;
   if(myVar == "")
       myVar = _(id).placeholder;

    return myVar;
}

function goBack()
{
	window.location = window.history.back();
}
	
