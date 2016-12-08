<?php
if (isset ( $_GET ["username"] )) {
    $username = $_GET ["username"];
}
else if (isset ( $_SESSION ["userid"] )) {
    $username = $_SESSION ["userid"];
}
else {
    die();
}
?>

<script language="JavaScript">

    var username = <?php echo json_encode($username) ?>;

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

                //verificar aqui se é owner ?

                //document.getElementById("pic").innerHTML = "<img src=" + info[4] + ">"; //foto da pessoa

                getReviews();
                getVisited();
                getMyRestaurants(); //só se for owner e se for o proprio perfil
            }
        };

        xmlhttp.open("GET","database/UserInfo.php?username="+ username,true);
        xmlhttp.send();
    }

    function getReviews() // Reviews section and all photos taken by costumers go automatically to the Photos section
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
                    $('#history').append('<article id=' + info[i][0] + '>\n<ul>\n<li id="rev_restaurant">' + info[i][1] +
                        '</li>\n<label>Rating: <li id="rev_rating">' + info[i][2] +
                        '</li></label>\n<label>Review: <li id="rev_opinion">' + info[i][3] +
                        '</li>\n<li id="rev_photos">\n</li>\n</ul>\n');

                    /*var photos = info[i][4];
                     for(var j = 0; j < photos.length; j++)
                     {
                     var photoInsertText = '<img src="'+ photos[j] + '"alt="Review Photo">';
                     $('#reviews > #' + info[i][0] + ' #rev_photos').append(photoInsertText);
                     $('#photos').append(photoInsertText);
                     }*/

                    $('#history').append('<footer>');
                    //$('#history').append('<span class="date">' + info[i][5] + '</span><br>'); // date


                    $('#history').append('</footer>\n</article>\n');

                }
                console.log($('#history').html());
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

                console.log("visited : ");
                console.log(info);

                for (var i = 0; i < info.length; i++)
                {
                    $('#visitedPlaces').append('<article>\n<ul>\n<label>Restaurant : <li id="vis_restaurant">' + info[i][0] +
                        '</li></label>\n<label>Rating: <li id="vis_rating">' + info[i][1] +
                        '</li></label>\n<label>Location: <li id="vis_opinion">' + info[i][2] +
                        '</li>\n<li id="vis_photos">\n</li>\n</ul>\n');

                    document.getElementById("vis_photos").innerHTML = "<img src=" + info[i][3] + ">"
                }
            }
        };

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
                    $('#manageRestaurants').append('<article>\n<ul>\n<label>Restaurant : <li id="my_restaurant">' + info[i][0] +
                        '</li></label>\n<label>Rating: <li id="my_rating">' + info[i][1] +
                        '</li></label>\n<label>Location: <li id="my_opinion">' + info[i][2] +
                        '</li>\n<li id="my_photos">\n</li>\n</ul>\n');

                    document.getElementById("my_photos").innerHTML = "<img src=" + info[i][3] + ">"
                }
            }
        };

        xmlhttp.open("GET","database/OwnerRestaurants.php?username="+username,true);
        xmlhttp.send();
    }

</script>

<section class="profile">

    <section id="main" >
        <!-- <img src="vaiBuscarBD.jpg" alt="User photo"> <!-- aqui é ver se a photo é null => display de uma foto default ou se tenho de ir buscar uma foto da pessoa -->
        <ul id="informacoes">
            <li id= "picId" style="display: none"></li>
            <label>Username: <li id= "username"></li> </label>
            <label>Name : <li id= "name"></li> </label>
            <!-- mostrar isto deve ser opcional -->
            <label>Email :<li id= "email"></li></label>
            <label>Birthday : <li id= "birthdate"></li></label>
            <label>Post-code : <li id= "postCode"></li></label>
        </ul>
        <a id ="link1" href=""></a>;
        <?php
        if (isUserLoggedIn ()){   ?>
            <script language="JavaScript">

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
            <li id="history"></li>
            <!-- <li id="Friends">
                 <!-- nome dos amigos todos
                 <!-- tem de dar para eliminar amigos
                 <div>
                     <!-- isto vai estar num foreach cada amigo
                    <!-- <img src="vaiBuscarBD.jpg" alt="User photo">
                     <h3>Nome</h3>
                 </div>
             </li>-->
            <li id="visitedPlaces">
                <!-- nome dos restaurantes que foi feita uma review -->
                <!-- tem de dar para selecionar e ir para a sua pagina (FALTA)-->
            </li>
            <li id="manageRestaurants"></li>
        </ul>
    </section>

    <section id="menuProfile" >
        <ul>
            <a href="#history">Histórico</a>
            <br>
            <!--<a href="#Friends">Amigos</a>
            <br>-->
            <a href="#visitedPlaces">Sítios Visitados</a>
            <br>
            <a href="#manageRestaurants">Restaurantes</a> <!-- so deve aparecer se o user for owner -->
            <br>
        </ul>
    </section>
</section>

<script language="JavaScript">
    $(document).ready(getInfo());
</script>