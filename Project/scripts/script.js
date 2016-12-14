var small_path = "css/images_small/";
var medium_path = "css/images_medium/";
var normal_path = "css/images/";

var default_user = "css/images_small/1.jpg";
var default_restaurant = "css/images_small/2.jpg";
var default_menu = "css/images_small/3.jpg";

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
                $(idMenu).append('<img src="' + path + trimmedFilename + '"alt="Photo that represents the restaurant">');
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
    return /^[a-zA-Z][\w]{3,20}[a-zA-Z]$/.test(element);
}

function is_postCode(element)
{
    return /^[0-9]{4}-[0-9]{3}|[0-9]{4}$/.test(element);
}

function is_password(element)
{
    return /^[a-zA-Z0-9]{6,}$/.test(element);
}

function is_text(element)
{
    return /^[a-zA-Z0-9\s\n\\\.\?\!\+\(\)\;\:\,\-]+$/.test(element);
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

function openChangePassword()
{
    var style = document.getElementById("changePassword").style.display;

    if(!(style == "") && !(style == "inline"))
        document.getElementById("changePassword").style.display = "inline";
    else
        document.getElementById("changePassword").style.display = "none";
}

function initMap(myadress)
{
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        'address': myadress
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var myOptions = {
                zoom: 16,
                center: results[0].geometry.location,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }

            var map = new google.maps.Map(_("map"), myOptions);

            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
        }
    });
}


/*

 //codigo para saber a localizacao atual

 function initMap() {
 // Create a map object and specify the DOM element for display.
 var uluru = {lat: -25.363, lng: 131.044};
 var map = new google.maps.Map(document.getElementById('map'), {
 zoom: 12,
 center: uluru
 });
 var marker = new google.maps.Marker({
 position: uluru,
 map: map
 });
 var infoWindow = new google.maps.InfoWindow({map: map});

 // Try HTML5 geolocation.
 if (navigator.geolocation) {
 navigator.geolocation.getCurrentPosition(function(position) {
 var pos = {
 lat: position.coords.latitude,
 lng: position.coords.longitude
 };

 infoWindow.setPosition(pos);
 infoWindow.setContent('Location found.');
 map.setCenter(pos);
 }, function() {
 handleLocationError(true, infoWindow, map.getCenter());
 });
 } else {
 // Browser doesn't support Geolocation
 handleLocationError(false, infoWindow, map.getCenter());
 }
 }

 function handleLocationError(browserHasGeolocation, infoWindow, pos) {
 infoWindow.setPosition(pos);
 infoWindow.setContent(browserHasGeolocation ?
 'Error: The Geolocation service failed.' :
 'Error: Your browser doesn\'t support geolocation.');
 }
 */
