<?php
$_GET['page'] = "read";
include("./classloader.php");

if (!$_GET['id']) { // si pas d'id d'article en GET, on retourne sur l'index
    echo "<script>window.location.href='index.php'</script>";
} else if (!$articlesManager->get($_GET['id'])) { // pareil, si l'id d'article joint en get ne correspond a aucun article existant, on retourne sur l'index
    echo "<script>window.location.href='index.php'</script>";
} else if ($_GET) { // si c'est bon , on recupere l'article correspondant à l'id
    $article = $articlesManager->get($_GET['id']);
}
?>
<script> //fonction tout droit sortie des enfers pour afficher ou non les commentaires
    function toggleComments() {
        var x = document.getElementById("commentaire");
        if (x.style.display === "none") {
            x.style.display = "flex";
        } else {
            x.style.display = "none";
        }
    }
</script>

<body>
    <div class="card-read">
        <?php if ($article->getId_image()) { ?>
            <img src="<?= $imagesManager->get($article->getId_image())->getImage() ?>" class="card-img-top" alt="...">
        <?php } ?>
        <div class="card-body">
            <h4 class="card-title"><?= $article->getTitle() ?></h4>
            <p class="card-text"><?= $article->getContent() ?></p>
            <small class="text-muted">Last updated on <?= $article->getCreated_at() ?> by <?php if ($article->getAuthor() != NULL) {
                                                                                                echo $article->getAuthor();
                                                                                            } else {
                                                                                                echo "Unknown";
                                                                                            } ?></small>
            <br>
        </div>
        <div class="card-footer">
            <p>
                <a href="create_comment.php?id_article=<?= $article->getId() ?>" class="btn btn-primary">Create Comment</a>
                <?php if ($_SESSION) {
                    if ($_SESSION["username"] == $article->getAuthor()) { ?>
                        <a href="update.php?id=<?= $article->getId() ?>" class="btn btn-primary">Update Article</a><?php } ?>
                    <?php if ($_SESSION["username"] == $article->getAuthor() || $_SESSION["username"] == "admin") { ?>
                        <a href="delete.php?id=<?= $article->getId() ?>" class="btn btn-primary">Delete Article</a>
                <?php }
                } ?>
            </p>
        </div>
        <div id="commentaire" style="display:flex; flex-wrap: wrap;">
            <?php foreach ($commentairesManager->getAll() as $commentaire) {
                if ($commentaire->getId_article() == $article->getId()) { ?>
                    <div class="card-comment">
                        <div class="card-body">
                            <h5 class="card-title"><?= $commentaire->getTitle() ?></h5>
                            <p class="card-text"><?= $commentaire->getContent() ?></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated on <?= $commentaire->getCreated_at() ?> by <?php if ($commentaire->getAuthor() != NULL) {
                                                                                                                    echo $commentaire->getAuthor();
                                                                                                                } else {
                                                                                                                    echo "Unknown";
                                                                                                                } ?></small>
                            <p>
                                <?php if ($_SESSION) {
                                    if ($_SESSION["username"] == $commentaire->getAuthor()) { ?>
                                        <a href="update_comment.php?id=<?= $commentaire->getId() ?>&id_article=<?= $commentaire->getId_article() ?>" class="btn btn-primary">Update Comment</a><?php } ?>
                                    <?php if ($_SESSION["username"] == $article->getAuthor() || $_SESSION["username"] == $commentaire->getAuthor() || $_SESSION["username"] == "admin") { ?>
                                        <a href="delete_comment.php?id=<?= $commentaire->getId() ?>" class="btn btn-primary">Delete Comment</a>
                                <?php }
                                } ?>
                            </p>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</body>