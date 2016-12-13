<?php
if (isset ( $_GET ["restaurant"] ))
{
    $restaurant = trim(strip_tags($_GET["restaurant"]));

    if (isset ( $_SESSION ["userid"] ))
        $username = $_SESSION ["userid"];
    else
    {
        echo "ACCESS DENIED : you must be logged in to acess this page";
        die();
    }
}
else
{
    echo "ACCESS DENIED : you can't acess this page";
    die();
}

?>

<script language="JavaScript">

    var username = <?php echo json_encode($username) ?>;
    var restaurant = <?php echo json_encode($restaurant) ?>;

    //coloca a informaçao na página
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

                var owner = info[11];

                if(owner != username) // nao o deixa aceder a pagina
                    goBack();

                _("name").innerHTML = restaurant;
                $('#r_name').attr("placeholder", restaurant);
                $('#r_id').attr("value", info[0]);
                if(info[1] == null) info[1] = "";
                $('#r_description').attr("placeholder", info[1]);
                if(info[2] == null) info[2] = "";
                $('#r_location').attr("placeholder", info[2]);

                if(info[12] == null)
                    info[12] = "";
                else
                {
                    var res = info[12].split("-");
                    $('#r_postCode1').attr("placeholder",res[0]);
                    $('#r_postCode2').attr("placeholder",res[1]);
                }

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

                $.get('./database/restaurantPhotos.php',  {restaurant: restaurant}, function(data)
                    {
                        var info = new String(data);
                        info = info.trim();

                        if(info == "ERROR") {
                            alert("ERROR : some variables are not defined");
                            return false;
                        }
                        else if(info != "INVALID")
                        {
                            var photos = eval("(" + data + ")");
                            for(var i = 0; i < photos.length; i++)
                            {
                                if(photos[i] != null)
                                {
                                    $('#restaurantPhotos').append('<img src="./css/images/'+ photos[i] + '"alt="Photo of the restaurant"><br>');
                                    $('#restaurantPhotos').append('<form action="./database/deleteRP.php" method="post"><input id="val" type="hidden" name="val" value="' + photos[i] + '"/><input type="hidden" name="restaurant" value="' + restaurant + '"/><input type="submit" value="Delete Photo"></form><br>');
                                }
                            }
                        }
                    }
                );
                return true;
            }
        };

        xmlhttp.open("GET","database/restaurantInfo.php?restaurant="+ restaurant,true);
        xmlhttp.send();
    }

    function observationsPopUpAnimation() {
        var popup = document.getElementById('myPopup');
        popup.classList.toggle('show');
    }

    function submitChanges()
    {
        var name, description, location, postCode1, postCode2, postCode, contact, avgPrice, schedule, observations;
        var status = _("status");

        name = getVar("r_name");
        description = getVar("r_description");
        location = getVar("r_location");
        postCode1 = getVar("r_postCode1");
        postCode2 = getVar("r_postCode2");
        postCode = postCode1 +"-" +postCode2;
        contact = getVar("r_contact");
        avgPrice = getVar("r_avgPrice");
        schedule = getVar("r_schedule");
        if($('#r_observations').val() == null)
            observations = $('#r_observations').attr("placeholder");
        else
            observations = getVar("r_observations");

        //avaliacao com expressoes regulares dos valores atribuidos
        if(!is_name(name))
            status.innerHTML = "Invalid name.";
        else if(!is_postCode(postCode))
            status.innerHTML = "Invalid postcode.";
        else if(!is_price(avgPrice))
            status.innerHTML = "Invalid average price.";
        else if(!is_phone_number(contact))
            status.innerHTML = "Invalid contact.";
        else {
            $.get('./database/updateRI.php', {
                    id: $('#r_id').attr("value"),
                    name: name,
                    description: description,
                    location: location,
                    contact: contact,
                    avgPrice: avgPrice,
                    schedule: schedule,
                    observation: observations,
                    postCode: postCode
                }, function (data) {
                    var info = new String(data);
                    info = info.trim();

                    if(info == "ERROR") {
                        alert("ERROR : some variables are not defined");
                        return false;
                    }
                    if (info == "0")
                        console.log("Error updating restaurant information.");
                    else
                        window.location = "restaurantProfileEdit.php?restaurant=" + restaurant;
                }
            );
            return true;
        }
        return false;
    }

</script>

<section id="sectionBody">
<section id="resEdit">
<section id="main" >
    <form id="updateRestaurantPicture" action="./database/uploadPicture.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="method" value="2"/>
        <input id="val" type="hidden" name="val" value=""/>
		<input type="file" name="image" id="file1" class="inputfile" />
		<label for="file1">Choose a file</label>
        <input type="submit" value="Change Restaurant Photo">
    </form>
    <form id="updateRestaurantPicture" action="./database/deletePP.php" method="post">
        <input type="hidden" name="method" value="2"/>
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
                    <label>PostCode: <input type="text" maxlength="4" name="postCode1"  id="r_postCode1" >
                       -<input type="text" maxlength="3" name="postCode2" id="r_postCode2" > </label>
                    </label> <br>
                    <label>Schedule:<input id="r_schedule" type="text" name="schedule"></label><br>
                    <label>Average Price Per Person(€):<input id="r_avgPrice" type="text" name="cost" maxlength="4"></label> <br>
                    <label>Contact:<input id="r_contact" type="text" name="number" maxlength="9"></label> <br>
                    <label>Observations: <textarea id="r_observations" name="review" cols="60" rows="2"></textarea>
                    <div class="popup" onclick="observationsPopUpAnimation()"> ?
                        <span class="popuptext" id="myPopup">You can allow your customers to know if your restaurant has: wi-fi, takeAway, live music, vegan menu options, wheelchair access, bar, etc.</span>
                    </div><br></label>
                    <span id="status"></span>
                    <br>
                    <input type="button" onclick="submitChanges()"/ value="Submit Changes">
                    <input type="button" onclick="goBack()" value="Cancel"/>
                </form>
            </div>
        </li>
        <li  id="menu">
            <a href="#menu">Menu</a>
            <div id="menuPhoto"> </div>
            <div>
                <form id="updateRestaurantMenu" action="./database/uploadPicture.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="method" value="5"/>
                    <input id="val" type="hidden" name="val" value=""/>
                    <input type="file" name="image" id="file2" class="inputfile" />
					<label for="file2">Choose a file</label>
                    <input type="submit" value="Upload New Menu Photo">
                </form>
            </div>
        </li>
        <li  id="photos">
            <a href="#photos">Photos</a>
            <div id="restaurantPhotos"> </div>
            <div>
                <form id="updateRestaurantPhotos" action="./database/uploadPicture.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="method" value="4"/>
                    <input id="val" type="hidden" name="val" value=""/>
                     <input type="file" name="image" id="file3" class="inputfile" />
					<label for="file3">Choose a file</label>
                    <input type="submit" value="Upload New Photo">
                </form>
            </div>
        </li>
    </ul>
</section>
</section>
</section>

<script language="JavaScript">
    $(document).ready(getInfo());
</script>