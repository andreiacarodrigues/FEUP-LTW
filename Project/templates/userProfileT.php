<?php
if (isset ( $_GET ["username"] )) {
    $username = $_GET ["username"];
}
else if (isset ( $_SESSION ["userid"] )) {
    $username = $_SESSION ["userid"];
}
else {
    echo 'ACCESS DENIED : you must be logged in to acess this page';
    die();
}
?>

<script language="JavaScript">

    var username = <?php echo json_encode($username) ?>;
	var sessionUsername = <?php echo json_encode($_SESSION ["userid"]) ?>;
	
    function getInfo(){
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

                _("username").innerHTML = username;
                _("name").innerHTML = info[0];
                _("email").innerHTML = info[1];
                _("birthdate").innerHTML = info[2];
                _("postCode").innerHTML = info[3];

                var photoId = info[4];
                if(photoId != null)
                    getPhoto(parseInt(photoId), false, '#main', '', './css/Images/');
                else
                    $('#main').prepend('<img src="./css/Images/1.jpg" alt="Photo that represents the user">');

                //qualquer pessoa pode ver as minhas reviews, os restaurantes que visitei, e os restaurantes que eu sou dono
                if(info[5])
                    getReviews(username);
                else
                    getReviews(null);

                getVisited();
                getMyRestaurants();
				getFriends();
				
				if(username != sessionUsername)
				{
					 $.get('./database/CheckFriends.php',  {sessionUsername: sessionUsername, username: username}, function(data){
						var info = new String(data);
						info = info.trim();

						if(info == "YES")
							document.getElementById("addFriend").style.display = "none";
						else
							document.getElementById("deleteFriend").style.display = "none";
						
					 });
				}
            }
        };

        xmlhttp.open("GET","database/UserInfo.php?username="+ username,true);
        xmlhttp.send();
    }

    function getReviews(owner)
    {
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

                console.log("reviews : ");
                console.log(info);

                for(var i = 0; i < info.length; i++)
                {
                    var jsonString = JSON.stringify(info[i]);
                    $.get('./templates/review.php',  {info: jsonString, owner: owner , username: username}, function(data)
                        {
                            $('#history').append(data);
                        }
                    );
                }
                return true;
            }
        };

        xmlhttp.open("GET","database/UserReviews.php?username="+ username,true);
        xmlhttp.send();
    }

    function getVisited(){
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

                for (var i = 0; i < info.length; i++)
                {
                    var name = info[i][0];
                    $('#visitedPlaces').append('<article>\n<ul>' +
                        '\n<a href="./restaurantProfile.php?restaurant='+ name +'">'+ name+'</a><br>' +
                        '\n<label>Rating: <li id="vis_rating">' + info[i][1] + '</li></label>' +
                        '\n<label>Location: <li id="vis_local">' + info[i][2] + '</li></label>\n' );

                    var photo = info[i][3];
                    if(photo != null){
                        $('#visitedPlaces').append('<img src="./css/images_small/'+photo+'" alt="Photo that represents the restaurant">');
                    }
                    else{
                        $('#visitedPlaces').append('<img src="./css/images_small/defaultRestaurant.jpg" alt="Photo that represents the restaurant">');
                    }
                }
            }
        };

        xmlhttp.open("GET","database/UserVisitedRest.php?username="+username,true);
        xmlhttp.send();
    }

    function getMyRestaurants(){
		
		if(username != sessionUsername)
		{
			var elements = document.getElementsByClassName("justForOwner");
			
			for (var i = 0; i < elements.length; i++) {
				elements[i].style.display = "none";
			}
			console.log("hello");
			return;
		}
		
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

                console.log("my restaurants : ");
                console.log(info);

                for (var i = 0; i < info.length; i++)
                {
                    var name = info[i][0];
                    $('#manageRestaurants').append('<article>\n<ul>' +
                        '\n<a href="./restaurantProfile.php?restaurant='+ name +'">'+ name+'</a><br>' +
                        '\n<label>Rating: <li id="my_rating">' + info[i][1] + '</li></label>' +
                        '\n<label>Location: <li id="my_local">' + info[i][2] + '</li></label>' +
                        '\n<li id="my_photo">\n</li>\n</ul>\n</article>\n');

                    var photo = info[i][3];
                    if(photo != null){
                        $('#manageRestaurants').append('<img src="./css/images_small/'+photo+'" alt="Photo that represents the restaurant">');
                    }
                    else{
                        $('#manageRestaurants').append('<img src="./css/images_small/defaultRestaurant.jpg" alt="Photo that represents the restaurant">');
                    }
                }
				
				$('#manageRestaurants').append ('<br><a href="addRestaurant.php">Add Restaurant');
            }
        };

        xmlhttp.open("GET","database/OwnerRestaurants.php?username="+username,true);
        xmlhttp.send();
    }

	function getFriends()
	{
		 $.get('./database/GetFriends.php',  {username: username}, function(data){
			  var info = new String(data);
              info = info.trim();

                if(info == "NO FRIENDS")
                    return false;
                else
				{
                    info = eval("(" + info + ")");
					
					for(var i = 0; i < info.length; i++)
					{
						 $('#friends').append('<a href="./userProfile.php?username='+ info[i] +'">'+ info[i]+'</a><br>');
					}
				}
		 });
	}
	

</script>

<section id="profile">

    <section id="main" >
        <ul id="informacoes">
            <label>Username: <li id= "username"></li> </label>
            <label>Name : <li id= "name"></li> </label>
            <!-- mostrar isto deve ser opcional -->
            <label>Email :<li id= "email"></li></label>
            <label>Birthday : <li id= "birthdate"></li></label>
            <label>Post-code : <li id= "postCode"></li></label>
            <div id="addFriend"></div>
			<div id="deleteFriend"></div>
            <div id="edit"></div>
        </ul>
        <?php
        if (isUserLoggedIn ()){   ?>
            <script language="JavaScript">

                var sessionUsername = <?php echo json_encode($_SESSION ["userid"]) ?>;

                if(username != sessionUsername)
                {
					 _("addFriend").innerHTML = "<a href=\"./database/AddFriend.php?username="+username+"&sessionUsername=" + sessionUsername +"\">Follow</a><br>";
					 _("deleteFriend").innerHTML = "<a href=\"./database/DeleteFriend.php?username="+username+"&sessionUsername=" + sessionUsername +"\">Unfollow</a><br>";
                }
                else
                {
                    _("edit").innerHTML = "<a href=\"./userProfileEdit.php?username="+username+"\">Edit Profile</a><br>"; //foto do restaurant
                }

            </script>
        <?php  }   ?>
    </section>

    <section id="dashboard" >
        <ul>
            <li id="history"></li>  <!-- conjunto das reviews feitas pelo utilizador -->
            <!-- <li id="Friends">
                 <!-- nome dos amigos todos
                 <!-- tem de dar para eliminar amigos
                 <div>
                     <!-- isto vai estar num foreach cada amigo
                    <!-- <img src="vaiBuscarBD.jpg" alt="User photo">
                     <h3>Nome</h3>
                 </div>
             </li>-->
            <li id="visitedPlaces"></li>    <!-- nome dos restaurantes que foi feita uma review -->
            <li class="justForOwner" id="manageRestaurants"></li>    <!-- restaurantes que pertencem ao utilizador -->
			<li id="friends"></li>
        </ul>
    </section>

    <section id="menuProfile" >
        <ul>
            <a href="#history">History</a>
            <br>
            <!--<a href="#Friends">Amigos</a>
            <br>-->
            <a href="#visitedPlaces">Visited Restaurants</a>
            <br>
			<a href="#friends">Followers</a> 
			<br>
            <a class="justForOwner" href="#manageRestaurants">Manage Restaurants</a>
            <br>
        </ul>
    </section>
</section>

<script language="JavaScript">
    $(document).ready(getInfo());
</script>