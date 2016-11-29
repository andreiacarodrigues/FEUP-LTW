<section id="Main" >
    <img src="vaiBuscarBD.jpg" alt="Photo that represents the restaurant">
    <h2>Nome do restaurante</h2>    <!-- vai ser mudadado pela bd -->
    <h3>Pontuação</h3>              <!-- vai ser mudadado pela bd -->
    <ul>
        <li><a href="#">Editar</a></li>           <!-- opcao apenas para owners -->
        <li><a href="#LeaveReview">Deixar Opinião</a></li> <!-- envia para a section Reviews -->
        <li><a href="#">Avaliar</a></li>    <!-- pop up para escolher uma pontucao ? -->
    </ul>
</section>
<section id="Details">
    <ul id="tabs">
        <li id="Informations">
            <a href="#Informations">Informações</a>
            <div>
                <ul id="Base">
                    <li>Número de telefone : </li>
                    <li>Tipo de cozinha : </li>
                    <li>Morada : </li>
                    <li>Custo : </li>
                    <li>Horário : </li>
                </ul>
                <ul id="RequirementsAchived">
                    <!-- lista de requisitos alcançados interpretados pela bd -->
                </ul>
                <ul id="OwnerView">
                    <!-- Lista de destaques do utilizador -->
                </ul>
            </div>
        </li>
        <li  id="Menu">
            <a href="#Menu">Menu</a>
            <div>
                <!-- vai conter várias imagens em miniatura que vêm da bd-->
            </div>
        </li>
        <li  id="Reviews">
            <a href="#Reviews">Opiniões</a>
            <div>
                <!-- lista de todas as revies -->
                <!-- review esta no ficheiro review.php -->
            </div>
        </li>
        <li  id="Photos">
            <a href="#Photos">Fotos</a>
            <div>
                <!-- vai conter várias imagens em miniatura que vêm da bd-->
            </div>
        </li>
    </ul>
</section>
<section id="LeaveReview">
    <form>
        <label>Avaliação:
            <input type="text" name="Avaliacao">
        </label>
        <label>
            Opinião:
            <textarea name="review" cols="40" rows="5"></textarea>
        </label>
        <input type="button" value="Adicionar fotos">
        <input type="button" value="Submeter">
    </form>
</section>