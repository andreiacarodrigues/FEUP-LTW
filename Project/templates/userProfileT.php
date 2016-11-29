<section id="Main" >
    <img src="vaiBuscarBD.jpg" alt="User photo">
    <ul id="informacoes">   <!-- vao ser colocadas com php -->
        <li>Username : </li>
        <li>Descrição : </li>
        <li>Nome : </li>        <!-- mostrar isto deve ser opcional -->
        <li>Email : </li>
        <li>Data de nascimento : </li>
        <li>Código de postal : </li>
    </ul>           <!-- vai ser mudadado pela bd -->
    <a href="#">Editar</a>          <!-- opcao apenas para owners -->
    <a href="#">Adicionar Amigo</a>          <!-- opcao caso nao seja o seu proprio perfil -->
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