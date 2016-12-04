<?php
	if (isset ( $_GET ["username"] )) 
		$username = $_GET ["username"];
    else if (isset ( $_SESSION ["userid"] )) 
       $username = $_SESSION ["userid"];
    else
      die();
?>

<script language="JavaScript">
	function _(x){
		return document.getElementById(x);
	}

	function getInfo(){
			if (window.XMLHttpRequest) {
			 xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var info = eval("(" + this.responseText + ")"); // get's the php array
				
				_("username").innerHTML = username;
				_("name").innerHTML = info[0];
				_("email").innerHTML = info[1];
				_("birthdate").innerHTML = info[2];
				_("postCode").innerHTML = info[3];
				_("picId").innerHTML = info[4];
			}
		};
		var username = <?php echo json_encode($username) ?>;
		xmlhttp.open("GET","database/UserInfo.php?username="+ username,true);
		xmlhttp.send();
	}
</script>

<section id="Main" >
   <!-- <img src="vaiBuscarBD.jpg" alt="User photo"> <!-- aqui é ver se a photo é null => display de uma foto default ou se tenho de ir buscar uma foto da pessoa -->
    <ul id="informacoes">
        <li id= "username"></li>
		<li id= "name"></li>
        <!-- mostrar isto deve ser opcional -->
		<li id= "email"></li>
		<li id= "birthdate"></li>
		<li id= "postCode"></li>
		<li id= "picId" style="display: none"></li>
    </ul>
	<a id ="link1" href=""></a>;
    <?php
    if (isUserLoggedIn ()){   ?>
		<script language="JavaScript">
			getInfo();
			var sessionUsername = <?php echo json_encode($_SESSION ["userid"]) ?>;
			console.log(sessionUsername);
			console.log(username != sessionUsername);
			if(username != sessionUsername)
			{
				$("#link1").attr('href', "#");
				//$("#link1").outerHTML = "Adicionar Amigo";  <!-- eu vejo isto amanhã!! não tou  conseguir encontrar como tirar o nome de display
                // do link -->
			}
			else
            {
				$("#link1").attr('href', "../userProfileEdit.php");
				//$("#link1").outerHTML = "Editar"; 
			}
				
		</script>
	 <?php  }   ?>

</section>
<section id="Dashboard" >
    <ul>
        <li id="History"> History
            <div>
                <?php
                    try {
                        $reviews = getAllReviews($username);
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }
                    foreach ($reviews as $review) {
                        try {
                            $restaurant = getRestaurantInfo($review['restaurantId']);
                        } catch (PDOException $e) {
                            die($e->getMessage());
                        }
                        ?>
                    <h3><?=$restaurant['name']?></h3>
                <?php
                        include("review.php");
                    }
                ?>
            </div>
        </li>
       <!-- <li id="Friends">
            <!-- nome dos amigos todos 
            <!-- tem de dar para eliminar amigos 
            <div>
                <!-- isto vai estar num foreach cada amigo
               <!-- <img src="vaiBuscarBD.jpg" alt="User photo"> 
                <h3>Nome</h3>
            </div>
        </li>-->
        <li id="VisitedPlaces"> VisitedPlaces
            <!-- nome dos restaurantes que foi feita uma review -->
            <!-- tem de dar para selecionar e ir para a sua pagina (FALTA)-->
            <div>
                <?php
                foreach ($reviews as $review) {
                    try {
                        $restaurant = getRestaurantInfo($review['restaurantId']);
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }
                    include("restaurant.php");
                }
                ?>
            </div>
        </li>
        <li id="ManageRestaurants"> ManageRestaurants
            <div>
                <?php
                try {
                    $restaurants = getAllRestaurantsOwner($username);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
                foreach ($restaurants as $restId) {
                    try {
                        $restaurant = getRestaurantInfo($restId);
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }

                    include("restaurant.php");
                }
                ?>
            </div>
        </li>
    </ul>
</section>

<section id="Menu" >
    <ul>
        <a href="#History">Histórico</a>
        <br>
        <!--<a href="#Friends">Amigos</a>
        <br>-->
        <a href="#VisitedPlaces">Sítios Visitados</a>
        <br>
        <?php
        if(isOwner($username)) {
            ?>
            <a href="#ManageRestaurants">Restaurantes</a>
            <br>
            <?php
        }
        ?>
    </ul>
</section>