<section id="Main" >
    <img src="vaiBuscarBD.jpg" alt="Photo that represents the restaurant"> <!-- falta alterar esta imagem -->
    <h2>Nome do restaurante</h2>    <!-- vai ser mudadado pela bd -->
</section>
<section id="Details">
    <ul id="tabs">
        <li id="Informations">
            <a href="#Informations">Informações</a>
            <div>
                <form>
                    <label>Nome:
                        <input type="text" name="name">
                    </label>
                    <br>
                    <label>Descrição:
                        <textarea name="description" cols="60" rows="2"></textarea>
                    </label>
                    <br>
                    <label>Contacto:
                        <input type="tel" name="number">
                    </label>
                    <br>
                    <label>Tipos de cozinha: <!-- fazer inserts com isto na base de dados logo ao inicio. o "outro" insere um novo tipo na bd e passa a estar nesta lista-->
                        <select name="cuisine" multiple = "multiple">
                            <option value="portuguesa">Portuguesa</option>
                            <option value="mediterranica">Mediterrânica</option>
                            <option value="contemporanea">Contemporânea</option>
                            <option value="vegetariana">Vegetariana</option>
                            <option value="pizzaria">Pizzaria</option>
                            <option value="hamburgeria">Hamburgeria</option>
                            <option value="marisqueira">Marisqueira</option>
                            <option value="internacional">Internacional</option>
                            <option value="japonesa">Japonesa</option>
                            <option value="francesa">Francesa</option>
                            <option value="italiana">Italiana</option>
                            <option value="chinesa">Chinesa</option>
                            <option value="japonesa">Japonesa</option>
                        </select>
                        <label>Outro:
                            <input type="text" name="newCuisine">
                        </label>
                    </label>
                    <br>
                    <label>Localização:
                        <input type="text" name="adress">
                    </label>
                    <br>
                    <label>Custo médio por pessoa:
                        <input type="text" name="cost">
                    </label>
                    <br>
                    <label>Horário:
                        <input type="text" name="schedule">
                    </label>
                    <br>
                    <input type="button" value="Submeter alterações">
                </form>
                <ul id="RequirementsAchived">
                    <form>
                        <fieldset>
                            <legend>Informações sobre o restaurante</legend>
                            <label>
                                <input type="checkbox" name="info" value="WiFi">Wi-fi
                            </label>
                            <label>
                                <input type="checkbox" name="info" value="TakeAway">TakeAway
                            </label>
                            <label>
                                <input type="checkbox" name="info" value="LiveMusic">Atuações ao vivo
                            </label>
                            <label>
                                <input type="checkbox" name="info" value="Vegan">Opção vegetariana
                            </label>
                            <label>
                                <input type="checkbox" name="info" value="Welchair">Acesso cadeira de rodas
                            </label>
                            <label>
                                <input type="checkbox" name="info" value="Outside">Esplanada
                            </label>
                            <label>
                                <input type="checkbox" name="info" value="Bar">Bar
                            </label>
                        </fieldset>
                        <input type="button" value="Submeter alterações">
                    </form>
                </ul>
                <ul id="OwnerView">
                    <!-- Lista de destaques do restaurante -->
                    <form>
                        <label>Observações:
                            <textarea name="review" cols="60" rows="2"></textarea>
                        </label>
                        <input type="button" value="Submeter alterações">
                    </form>
                </ul>
            </div>
        </li>
        <li  id="Menu">
            <a href="#Menu">Menu</a>
            <div>
                <!-- <form action="upload.php" method="post" enctype="multipart/form-data">
                  Select image to upload:
                  <input type="file" name="fileToUpload" id="fileToUpload">
                  <input type="submit" value="Upload Image" name="submit">
              </form>-->
                <!-- pode eliminar as suas imagens ou adicionar novas-->
            </div>
        </li>
        <li  id="Photos">
            <a href="#Photos">Fotos</a>
            <div>
                <!-- <form action="upload.php" method="post" enctype="multipart/form-data">
                     Select image to upload:
                     <input type="file" name="fileToUpload" id="fileToUpload">
                     <input type="submit" value="Upload Image" name="submit">
                 </form>-->

                <!-- pode eliminar as suas imagens ou adicionar novas-->
            </div>
        </li>
    </ul>
</section>