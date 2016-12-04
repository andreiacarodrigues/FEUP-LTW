<article>
    <!-- <img src="" alt="user foto"> <!-- foto da pessoa que fez a review-->
    <h4>Nome : <?=$username?></h4>
    <h4>Avalicao : <?=$review['rating']?></h4>
    <p><?=$review['text']?></p>

    <!-- todas as fotos colocadas pelo utilizador no restaurante -->
    <?php
        $photos = getPhotoFromUserToRest($review['restaurantId'],$review['username']);  //da me todos os id's das fotos
        foreach ($photos as $photo) {
            ?>
           <img src="<?$photo?>" alt="user foto of restaurant">
    <?php
        }
    ?>

    <footer>
        <!-- efeito acordeão para ver os comentarios e para abrir a textarea -->
        <a href="#comments">Comments</a>
        <?php
        if(isOwner($username)) {
            ?>
            <a href="#review">Responder</a>
            <?php
        }
        ?>
        <span class="date">@May 5th 2014</span> <!-- a data ainda nao esta implementada -->
    </footer>
</article>

<section id="comments">
    <!-- discutir como é que vamos lidar com comentarios na bd -->
</section>

<section id="review">
    <form action="save_review.php" method="post"><!-- formulario vai para um sitio que cria uma nova review associada a inicial-->

        <label>
            Opinião:
            <textarea name="newReview" cols="40" rows="5"></textarea>
        </label>

        <input type="button" value="Cancelar"> <!-- cancelar fecha o efeito acordeao -->
        <input type="button" value="Submeter">
    </form>
</section>