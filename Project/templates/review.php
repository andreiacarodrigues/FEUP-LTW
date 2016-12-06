<article>
    <!-- <img src="" alt="user foto"> <!-- foto da pessoa que fez a review-->
    <ul>
        <li id= "name"></li>    <!-- se for no historico do user, name = restaurantName ; se for no historico do restaurante, name = username -->
        <li id= "rating"></li>
        <li id= "opinion"></li>
        <li id= "photos"></li> <!-- todas as fotos colocadas pelo utilizador no restaurante -->
    </ul>
    <footer>
        <!-- efeito acordeão para ver os comentarios e para abrir a textarea -->
        <span class="date">@May 5th 2014</span><br> <!-- a data ainda nao esta implementada -->
        <a href="#comments">Comentários</a>
        <a href="#review">Responder</a> <!-- deve verificar se é ownwer -->
    </footer>
</article>

<section id="comments">
    <!-- discutir como é que vamos lidar com comentarios na bd -->
</section>

<section id="review">
    <form action="save_review.php" method="post"> <!-- formulario vai para um sitio que cria uma nova review associada a inicial-->

        <label>
            Opinião:
            <textarea name="newReview" cols="40" rows="5"></textarea>
        </label>

        <input type="button" value="Cancelar"> <!-- cancelar fecha o efeito acordeao -->
        <input type="button" value="Submeter">
    </form>
</section>


<form id="reply">
	<textarea name="newReview" cols="40" rows="5"></textarea>
	<input type="button" onclick="" value="Submeter">
	<input type="button" onclick="" value="Cancelar">
</form>