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

    function getHistory(){
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var reviews = eval("(" + this.responseText + ")"); // get's the php array

                console.log("reviews : ");
                console.log(reviews);

                for (var i = 0; i < reviews.length; i++) {
                    var info = reviews[i];

                    _("restName").innerHTML = info[1];
                    _("rating").innerHTML = info[2];
                    _("opinion").innerHTML = info[3];

                    var allPhotos = "<br>";
                    for (var j = 0; j < info[4].length; j++)  //info[4] é um array de filenames de fotos para colocar depois do text
                        allPhotos += "<img src=" + info[4][j] + ">";
                    document.getElementById("photos").innerHTML = allPhotos;
                }
            }
        };

        var username = <?php echo json_encode($username) ?>;
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
            if (this.readyState == 4 && this.status == 200) {
                var restaurants = eval("(" + this.responseText + ")"); // get's the php array whit all the reviews

                console.log("visited : ");
                console.log(restaurants);

                for (var i = 0; i < restaurants.length; i++) {
                    var info = restaurants[i];

                    //document.getElementById("restPhoto").innerHTML = "<img src=" + info[3] + ">"
                    _("rating").innerHTML = info[1];
                    _("restName").innerHTML = info[0];
                    _("location").innerHTML = info[2];
                }
            }
        };
        var username = <?php echo json_encode($username) ?>;
        xmlhttp.open("GET","database/UserVisitedRest.php?username="+username,true);
        xmlhttp.send();
    }

    function getMyRestaurants(){
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var restaurants = eval("(" + this.responseText + ")"); // get's the php array whit all the reviews

                console.log("My restaurants : ");
                console.log(restaurants);

                for (var i = 0; i < restaurants.length; i++)
                {
                    var info = restaurants[i];

                    document.getElementById("restPhoto").innerHTML = "<img src=" + info[3] + ">";
                    _("rating").innerHTML = info[1];
                    _("restName").innerHTML = info[0];
                    _("location").innerHTML = info[2];
                }
            }
        };
        var username = <?php echo json_encode($username) ?>;
        xmlhttp.open("GET","database/OwnerRestaurants.php?username="+username,true);
        xmlhttp.send();
    }

</script>

<section class="profile">

    <section id="main" >
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
                getHistory();
                getVisited();
                getMyRestaurants(); //só se for owner e se for o proprio perfil

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

    <section id="dashboard" >
        <ul>
            <li id="History">
                <div>
                    <?php
                    include("review.php");
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
            <li id="VisitedPlaces">
                <!-- nome dos restaurantes que foi feita uma review -->
                <!-- tem de dar para selecionar e ir para a sua pagina (FALTA)-->
                <?php
                //include("restaurant.php");
                ?>
                <ul>
                    <li id= "restName"></li>
                    <li id= "restPhoto"></li>
                    <li id="rating"></li>
                    <li id="location"></li>
                </ul>
            </li>
            <li id="ManageRestaurants">
                <div>
                    <?php
                    include("restaurant.php");
                    ?>
                </div>
            </li>
        </ul>
    </section>

    <section id="menuProfile" >
        <ul>
            <a href="#History">Histórico</a>
            <br>
            <!--<a href="#Friends">Amigos</a>
            <br>-->
            <a href="#VisitedPlaces">Sítios Visitados</a>
            <br>
            <a href="#ManageRestaurants">Restaurantes</a> <!-- so deve aparecer se o user for owner -->
            <br>
        </ul>
    </section>
</section>