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

    xmlhttp.open("GET","database/getPhoto.php?id="+ id,true);
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
    xmlhttp.open("GET","database/userExists.php?username="+u,true);
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

function is_price(element) {
    return /^-?\d+\.?\d*$/.test(element);
}

function is_phone_number(element) {
    return /^\d{9}|\d{3}-\d{3}-\d{3}$/.test(element);
}

function is_name(element) {
    return /^[^0-9\\|!&;@#£$§%&/()=?{[\]}'«»*+]+$/.test(element);
}

function is_username(element)
{
    return /^[a-zA-Z][\w]{3,8}[a-zA-Z]$/.test(element);
}

function is_postCode(element)
{
    return /^[0-9]{4}-[0-9]{3}|[0-9]{4}$/.test(element);
}

function is_password(element)
{
    return /^[a-zA-Z0-9]{6,}$/.test(element);
}

function is_email(element) {
    var re =/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(element);
}

function goHomePage()
{
	window.location = "index.php";
}

function openComments(index)
{
	var style = document.getElementById("comments"+ index).style.display;
	
	if(!(style == "") && !(style == "inline"))
		document.getElementById("comments"+ index).style.display = "inline";
	else
		document.getElementById("comments"+ index).style.display = "none";		
}

function openTab(tab)
{
	for(var i=0; i < tabList.length; i++)
	{
		if(tabList[i] != tab)
			document.getElementById(tabList[i]).style.display = "none";
	}
	document.getElementById(tab).style.display = "inline";	
}	

function openReply(index)
{
	var style = document.getElementById("reply"+ index).style.display;
	
	if(!(style == "") && !(style == "inline"))
		document.getElementById("reply"+ index).style.display = "inline";
	else
		document.getElementById("reply"+ index).style.display = "none";		
}