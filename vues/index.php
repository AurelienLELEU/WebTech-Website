<?php
$_GET['page'] = "index";
if (!isset($_GET['search'])) {
    $_GET['search'] = "";
}
if (!preg_match("/^[a-zA-Z-' ]*$/", $_GET['search'])) { ?> <!--Verif d'injections dans la barre search-->
    <script>
        alert("Lettres ou espaces uniquement!")
    </script>
<?php $_GET['search'] = "";
}

include("./classloader.php");
$articlescount = 0;
?>

<!-- <script>
    function toggleComments() {
        let Comment = document.getElementsByClassName('commentaire');
        for (i = 0; i < Comment.length; i++) {
            if (Comment[i].style.display == "none") {
                Comment[i].style.display = "none";
            } else {
                Comment[i].style.display = "flex";
            }
        }
    }
</script> -->

<body>
    <div class="sortbar"> <!-- Deuxième barre avec le tri par date/titre -->
        <form class="form-inline my-2 my-lg-0 " method="POST" id="sortselect">
            <label class="col-form-label-lg" style="color: white; padding-left:10px;">Trier par : </label>
            <select class="custom-select-lg " name="sort">
                <?php if (isset($_POST['sort'])) { // verifies quel tri est en cours et le pré selectionne
                ?><option selected="selected" value=<?= $_POST['sort'] ?>><?= ucfirst($_POST['sort']) ?></option>
                <?php }
                if ((!isset($_POST['sort'])) || (($_POST['sort'] == "titre"))) { ?> <option value="date">Date</option>
                <?php }
                if ((!isset($_POST['sort'])) || (($_POST['sort'] == "date"))) { ?> <option value="titre">Titre</option>
                <?php } ?>
            </select><button type="submit" class="btn btn-light btn-lg" form="sortselect">Trier ! </button>
        </form>
        <!-- <div class=togglecomments>
            <button class="btn btn-light btn-sm" onclick="toggleComments()"> Afficher/Masquer les commentaires </button>
        </div> -->
    </div>

    <div class="d-flex" style="width: 100%; padding: 10px; justify-content: space-between; display: flex; flex-wrap: wrap;">
        <?php
        if (isset($_POST['sort'])) {
            if ($_POST['sort'] == "date") {
                foreach ($articlesManager->getAll($_GET['search']) as $article) { //gros truc compliqué pour afficher mes articles avec les commentaires et tout
                    $articlescount++; ?>
                    <div class="card">
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
                            <a href="read.php?id=<?= $article->getId() ?>" class="btn btn-primary">Read Article</a>
                        </div>
                        <div class="commentaire" style="display:flex; flex-wrap: wrap;">
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
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                <?php
                }
                if ($articlescount == 0) { // au cas où il n'y a pas d'articles, on previens l'utilisateur
                    echo ("No articles yet! Do not hesitate to create an account / login and createone!");
                }
            } else {

                foreach ($articlesManager->getAllTitle($_GET['search']) as $article) { //pareil
                    $articlescount++; ?>
                    <div class="card">
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
                            <a href="read.php?id=<?= $article->getId() ?>" class="btn btn-primary">Read Article</a>
                        </div>
                        <div class="commentaire">
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
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                <?php
                }
                if ($articlescount == 0) {
                    echo ("No articles matching your research yet! Do not hesitate to create an account / login and create one!");
                }
            }
        } else {
            foreach ($articlesManager->getAll($_GET['search']) as $article) { //pareil
                $articlescount++; ?>
                <div class="card">
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
                        <a href="read.php?id=<?= $article->getId() ?>" class="btn btn-primary">Read Article</a>
                    </div>
                    <div class="commentaire">
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
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
        <?php
            }
            if ($articlescount == 0) {
                echo ("No articles yet! Do not hesitate to create an account / login and createone!");
            }
        } ?>
    </div>
</body>