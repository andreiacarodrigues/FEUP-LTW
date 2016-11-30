<?php
//PASSAR TUDO PARA ID'S
//este username é o username do utilizador a que pertence a pagina (FALTA enviar este username)
    if (isset ( $_GET ["username"] )) {
        $userId = getUserID ();

        $username = $_GET ["username"];
        $info = getUserInfo($username);
        $filename = getUserPhoto($username);

        $reviews = getAllReviews($userId);
    }
    else{
        die();
    }
?>

<section id="Main" >

    <img src="vaiBuscarBD.jpg" alt="User photo"> <!-- FALTA -->
    <ul id="informacoes">
        <li> $info ["username"] </li>
        <!-- <li> $idUser ["description"] </li> -->

        <!-- mostrar isto deve ser opcional -->

        <li> $info ["name"] </li>
        <li> $info ["username"] </li>
        <li> $info ["birthdate"] </li>
        <li> $info ["postCode"] </li>
    </ul>
    <?php
    if (isUserLoggedIn ()){
        $idTempUser = getUserID ();
        if($idTempUser !== idUser)  //opcao caso nao seja o seu proprio perfil
        {
            echo '<a href="#">Adicionar Amigo</a>';
        }
        else
        {
            echo ' <a href="../userProfileEdit.php">Editar</a> ';
        }
    }
    ?>
</section>
<section id="Dashboard" >
    <ul>
        <li id="History">
            <div>
                <!-- historico das reviews todas -->
                <!-- review esta no ficheiro review.php -->
            </div>
        </li>
        <li id="Friends">
            <!-- nome dos amigos todos -->
            <!-- tem de dar para eliminar amigos -->
            <div>
                <!-- isto vai estar num foreach cada amigo -->
                <img src="vaiBuscarBD.jpg" alt="User photo">
                <h3>Nome</h3>
            </div>
        </li>
        <li id="VisitedPlaces">
            <!-- nome dos restaurantes que foi feita uma review -->
            <!-- tem de dar para selecionar e ir para a sua pagina -->
            <div>
                <!-- isto vai estar num foreach cada restaurante -->
                <!-- o restuarante esta no templates/retaurant.php -->
            </div>
        </li>
        <li id="ManageRestaurants">
            <div>
                <!-- isto vai estar num foreach para cada restaurante -->
                <!-- o restaurante esta no templates/retaurant.php -->
            </div>
        </li>
    </ul>
</section>
<section id="Menu" >
    <ul>
        <a href="#History">Histórico</a>
        <br>
        <a href="#Friends">Amigos</a>
        <br>
        <a href="#VisitedPlaces">Sítios Visitados</a>
        <br>
        <a href="#ManageRestaurants">Restaurantes</a>   <!-- opcao apenas se for owner -->
        <br>
    </ul>
</section>