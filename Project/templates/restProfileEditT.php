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
                $('#r_description').attr("placeholder", info[1]);
                $('#r_location').attr("placeholder", info[2]);
                $('#r_contact').attr("placeholder", info[3]);
                $('#r_avgPrice').attr("placeholder", info[4]);
                $('#r_schedule').attr("placeholder", info[5]);
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

                        if(data != "INVALID")
                        {
                            var photos = eval("(" + data + ")");
                            for(var i = 0; i < photos.length; i++)
                            {
                                $('#restaurantPhotos').append('<img src="./css/images/'+ photos[i] + '"alt="Photo of the restaurant"><br>');
                                $('#restaurantPhotos').append('<form action="./database/DeleteRP.php" method="post"><input id="val" type="hidden" name="val" value="' + photos[i] + '"/><input type="submit" value="Delete Photo"></form><br>');
                                console.log($('#restaurantPhotos').html());
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
                    <label>Restaurant Name: <input id="r_name" type="text" maxlength="60"> </label><br>
                    <label>Description: <textarea  id="r_description"name="description" cols="60" rows="2"></textarea> </label> <br>
                    <label>Location:<input id="r_location" type="text" name="adress" maxlength="80"></label><br>
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
                    <input type="hidden" name="method" value="5"/>
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