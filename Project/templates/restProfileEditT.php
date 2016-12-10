<?php
if (isset ( $_GET ["restaurant"] ))
{
    $restaurant = $_GET ["restaurant"];

    if (isset ( $_SESSION ["userid"] ))
        $username = $_SESSION ["userid"];
    else
        $username = "NULL";
}
else
    die();
?>

<script language="JavaScript">

    var username = <?php echo json_encode($username) ?>;
    var restaurant = <?php echo json_encode($restaurant) ?>;

    function getInfo(){
        $('#updateRestaurantPicture #val').attr("value", restaurant);
        $('#updateRestaurantMenu #val').attr("value", restaurant);
        $('#updateRestaurantPhotos #val').attr("value", restaurant);

        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var info = new String(this.responseText);
                info = info.trim();

                if(info == "INVALID")
                    return false;
                else
                    info = eval("(" + this.responseText + ")");

                _("name").innerHTML = restaurant;
                $('#r_name').attr("placeholder", restaurant);
				$('#r_id').attr("value", info[0]);
				if(info[1] == null) info[1] = "";
                $('#r_description').attr("placeholder", info[1]);
				if(info[2] == null) info[2] = "";
                $('#r_location').attr("placeholder", info[2]);
				if(info[3] == null) info[3] = "";
                $('#r_contact').attr("placeholder", info[3]);
				if(info[4] == null) info[4] = "";
                $('#r_avgPrice').attr("placeholder", info[4]);
				if(info[5] == null) info[5] = "";
                $('#r_schedule').attr("placeholder", info[5]);
				if(info[6] == null) info[6] = "";
                $('#r_observations').attr("placeholder", info[6]);

                var menuId = info[7];
                var photoId = info[8];

                if(photoId != null)
                {
                    getPhoto(parseInt(photoId), false, '#main','#menuPhoto', './css/images/');
                }
                else
                    $('#main').prepend('<img src="./css/images/1.jpg" alt="Photo that represents the restaurant">');

                if(menuId != null)
                {
                    getPhoto(parseInt(menuId) , true, '#main','#menuPhoto', './css/images/');
                }
                else
                    $('#menuPhoto').html('<img src="./css/Images/defaultRestaurant.jpg" alt="Restaurant\'s Menu">');

                $.get('./database/RestaurantPhotos.php',  {restaurant: restaurant}, function(data)
                    {
						var info = new String(data);
						info = info.trim();

                        if(info != "INVALID")
                        {
                            var photos = eval("(" + data + ")");
                            for(var i = 0; i < photos.length; i++)
                            {
								if(photos[i] != null)
								{
									$('#restaurantPhotos').append('<img src="./css/images/'+ photos[i] + '"alt="Photo of the restaurant"><br>');
									$('#restaurantPhotos').append('<form action="./database/DeleteRP.php" method="post"><input id="val" type="hidden" name="val" value="' + photos[i] + '"/><input type="hidden" name="restaurant" value="' + restaurant + '"/><input type="submit" value="Delete Photo"></form><br>');
								}
                            }
                        }
                    }
                );
                return true;
            }
        };

        xmlhttp.open("GET","database/RestaurantInfo.php?restaurant="+ restaurant,true);
        xmlhttp.send();
    }

    function observationsPopUpAnimation() {
        var popup = document.getElementById('myPopup');
        popup.classList.toggle('show');
    }
	
	function is_phone_number(element) {
		return /^\d{9}|\d{3}-\d{3}-\d{3}$/.test(element);
	}
	
	function is_name(element) {
		return "[^0-9\\|!&quot;@#£$§%&/()=?{[\]}'«»*+]+".test(element);
	}

	function is_username(element)
	{
		return "[a-zA-Z][\w]{3,8}[a-zA-Z]" .test(element);
	}
	
	function is_postCode(element)
	{
		return "[0-9]{4}-[0-9]{3}|[0-9]{4}".test(element);
	}
	
	function is_password(element)
	{
		return "(?=.*[0-9].*[0-9])(?=.*[;\.:].*[;\.:])([\w;\.:])[\w;\.:]{4,}(?!\1)[\w;\.:]".test(element);
	}
	function submitChanges()
	{	
		var name, description, location, contact, avgPrice, schedule, observations;
		
		if($('#r_name').val() == "")
			name = $('#r_name').attr("placeholder");
		else
			name = $('#r_name').val();
	
		
		if($('#r_description').val() == "")
			description = $('#r_description').attr("placeholder");
		else
			description = $('#r_description').val();
		
		if($('#r_location').val() == "")
			location = $('#r_location').attr("placeholder");
		else
			location = $('#r_location').val();
		
		if($('#r_contact').val() == "")
			contact = $('#r_contact').attr("placeholder");
		else
			contact = $('#r_contact').val();
		
		if($('#r_avgPrice').val() == "")
			avgPrice = $('#r_avgPrice').attr("placeholder");
		else
			avgPrice = $('#r_avgPrice').val();
		
		if($('#r_schedule').val() == "")
			schedule = $('#r_schedule').attr("placeholder");
		else
			schedule = $('#r_schedule').val();
		
		if(($('#r_observations').val() == "")||($('#r_observations').val() == null))
			observation = $('#r_observations').attr("placeholder");
		else
			observation = $('#r_observations').val();
		
		
		$.get('./database/UpdateRI.php',  {id: $('#r_id').attr("value"), name: name , description: description, location: location, contact: contact, avgPrice: avgPrice, schedule: schedule, observation: observation}, function(data) 
		{
			var info = new String(data);
			info = info.trim();

			if(info == "0")
				console.log("Error updating restaurant information.");
			else
				window.location = "restaurantProfileEdit.php?restaurant=" + restaurant;
		}
		);
	}
	
	function goBack()
	{
		window.location = window.history.back();
	}
	

</script>

<section id="main" >
    <form id="updateRestaurantPicture" action="./database/UploadPicture.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="method" value="2"/>
        <input id="val" type="hidden" name="val" value=""/>
        <input type="file" name="image"/>
        <input type="submit" value="Change Restaurant Photo">
    </form>
    <form id="updateRestaurantPicture" action="./database/DeleteRPP.php" method="post">
        <input id="val" type="hidden" name="val" value=""/>
        <input type="submit" value="Delete Photo">
    </form>
    <h2 id="name">Restaurant Name</h2>
</section>
<section id="details">
    <ul id="tabs">
        <li id="informations">
            <a href="#informations">Informations</a>
            <div>
                <form>
					<input id="r_id" type="hidden" value="" maxlength="6">
                    <label>Restaurant Name: <input id="r_name" type="text" maxlength="60"> </label><br>
                    <label>Description: <textarea  id="r_description"name="description" cols="60" rows="2"></textarea> </label> <br>
                    <label>Location:<input id="r_location" type="text" name="location" maxlength="80"></label><br>
                    <label>Schedule:<input id="r_schedule" type="text" name="schedule"></label><br>
                    <label>Average Price Per Person(€):<input id="r_avgPrice" type="text" name="cost" maxlength="4"></label> <br>
                    <label>Contact:<input id="r_contact" type="tel" name="number" maxlength="9"></label> <br>
                    <label>Observations: <textarea id="r_observations" name="review" cols="60" rows="2"></textarea></label>
                    <div class="popup" onclick="observationsPopUpAnimation()">?
                        <span class="popuptext" id="myPopup">You can allow your customers to know if your restaurant has: wi-fi, takeAway, live music, vegan menu options, wheelchair access, bar, etc.</span>
                    </div><br>
                    <input type="button" onclick="submitChanges()"/ value="Submit Changes">
                    <input type="button" onclick="goBack()" value="Cancel"/>
                </form>
            </div>
        </li>
        <li  id="menu">
            <a href="#menu">Menu</a>
            <div id="menuPhoto"> </div>
            <div>
                <form id="updateRestaurantMenu" action="./database/UploadPicture.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="method" value="5"/>
                    <input id="val" type="hidden" name="val" value=""/>
                    <input type="file" name="image"/>
                    <input type="submit" value="Upload New Menu Photo">
                </form>
            </div>
        </li>
        <li  id="photos">
            <a href="#photos">Photos</a>
            <div id="restaurantPhotos"> </div>
            <div>
                <form id="updateRestaurantPhotos" action="./database/UploadPicture.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="method" value="4"/>
                    <input id="val" type="hidden" name="val" value=""/>
                    <input type="file" name="image"/>
                    <input type="submit" value="Upload New Photo">
                </form>
            </div>
        </li>
    </ul>
</section>

<script language="JavaScript">
    $(document).ready(getInfo());
</script>