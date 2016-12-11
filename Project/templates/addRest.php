<?php
if (isset ( $_SESSION ["userid"] ))
{
    $username = $_SESSION ["userid"];

    if (isset ( $_GET ["restaurant"] ))
        $restaurant = $_GET ["restaurant"];
    else
        $restaurant = "NULL";
}
else
{
    echo "ACCESS DENIED : you must be logged in to acess this page";
    die();
}
?>

<script language="JavaScript">
    var username = <?php echo json_encode($username) ?>;
    var restaurant = <?php echo json_encode($restaurant) ?>;

    function observationsPopUpAnimation() {
        var popup = document.getElementById('myPopup');
        popup.classList.toggle('show');
    }

    function goback()
    {
        window.location = 'userProfile.php?username=' + username;
    }

    function submitInfo()
    {
        console.log(restaurant);
        console.log(username);
        var name = _("r_name").value;
        var description = _("r_description").value;
        var location = _("r_location").value;
        var postCode = _("r_postCode").value;
        var schedule = _("r_schedule").value;
        var avgPrice = _("r_avgPrice").value;
        var contact = _("r_contact").value;
        var observations = _("r_observations").value;

        var status = _("status");

        //verificacaoes com expresoes regulares
        if(!is_name(name))
            status.innerHTML = "Invalid name.";
        else if(!is_postCode(postCode))
            status.innerHTML = "Invalid postcode.";
        else if(!is_price(avgPrice))
            status.innerHTML = "Invalid average price.";
        else if(!is_phone_number(contact))
            status.innerHTML = "Invalid contact.";
        else
        {
            //passou todas as expressoes regulares, adiciona o restaurante
            status.innerHTML = "";

            $.get('./database/AddRestaurant.php',  {name: name , description: description, location: location, postCode: postCode, contact: contact, avgPrice: avgPrice, schedule: schedule, observation: observations, owner: username}, function(data)
                {
                    var info = new String(data);
                    info = info.trim();
                    if(info == "INVALID")
                        console.log("Restaurant with that name already exists.");
                    if(info == "0")
                        console.log("Error inserting restaurant information.");
                    else
                    {
                        restaurant = name;
                        window.location = "addRestaurant.php?restaurant=" + restaurant;
                    }
                }
            );
            return true;
        }
        return false;
    }

    function getInfo(){
        if(restaurant == "NULL")
            return;

        $('#updateRestaurantPicture #val').attr("value", restaurant);
        $('#updateRestaurantMenu #val').attr("value", restaurant);
        $('#updateRestaurantPhotos #val').attr("value", restaurant);
    }

    function restaurantExists()
    {
        var name = _("r_name").value;
        $.get('./database/RestaurantExists.php',  {name: name}, function(data)
        {
            var info = new String(data);
            info = info.trim();
            _("n_span").innerHTML = info;
        });
    }

</script>

<h2>Add Restaurant</h2>
<section id="informations">
    <form>
        <label>Restaurant Name: <input id="r_name" type="text" onblur="restaurantExists();" maxlength="60" onfocus="emptyElement('n_span');" required> </label><br>
        <span id="n_span"></span><br>
        <label>Description: <textarea  id="r_description"name="description" cols="60" rows="2"></textarea> </label> <br>
        <label>Location:<input id="r_location" type="text" name="location" maxlength="80" onfocus="emptyElement('status');"></label>
        <label>PostCode: <input type="text" maxlength="8" name="postCode" id="r_postCode" onfocus="emptyElement('status');" ></label><br>
        <label>Schedule:<input id="r_schedule" type="text" name="schedule"></label><br>
        <label>Average Price Per Person(€):<input id="r_avgPrice" type="text" name="cost" maxlength="6" onfocus="emptyElement('status');"></label> <br>
        <label>Contact:<input id="r_contact" type="tel" name="number" maxlength="9" onfocus="emptyElement('status');"></label> <br>
        <label>Observations: <textarea id="r_observations" name="review" cols="60" rows="2"></textarea></label>
        <div class="popup" onclick="observationsPopUpAnimation()">?
            <span class="popuptext" id="myPopup">You can allow your customers to know if your restaurant has: wi-fi, takeAway, live music, vegan menu options, wheelchair access, bar, etc.</span>
        </div><br>
        <span id="status"></span>
        <br>
        <input type="button" onclick="submitInfo()" value="Submit Informations">
        <input type="button" onclick="goback()" value="Cancel">
    </form>
</section>
<p id="info"> Only upload images after making sure you submited the previous required information. </p>
<section id="restaurantPhoto">
    <form id="updateRestaurantPicture" action="./database/UploadPicture.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="method" value="2"/>
        <input id="val" type="hidden" name="val" value="NULL"/>
        <input type="file" name="image"/>
        <input type="submit" value="Upload Representative Restaurant Photo">
    </form>
</section>
<section id="menu">
    <div id="menuPhoto"> </div>
    <div>
        <form id="updateRestaurantMenu" action="./database/UploadPicture.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="method" value="5"/>
            <input id="val" type="hidden" name="val" value="NULL"/>
            <input type="file" name="image"/>
            <input type="submit" value="Upload Menu Photo">
        </form>
    </div>
</section>
<section id="photos">
    <div id="restaurantPhotos"> </div>
    <div>
        <form id="updateRestaurantPhotos" action="./database/UploadPicture.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="method" value="4"/>
            <input id="val" type="hidden" name="val" value="NULL"/>
            <input type="file" name="image"/>
            <input type="submit" value="Upload Restaurant Photo">
        </form>
    </div>
</section>

<script language="JavaScript">
    $(document).ready(getInfo());
</script>