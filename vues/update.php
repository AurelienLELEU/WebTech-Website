<?php
include("./classloader.php");

if ((!$_GET['id']) || (!$articlesManager->get($_GET['id']))) {// verifie que l'article à update existe bien 
    echo "<script>window.location.href='index.php'</script>";
}
$articleToUpdate = $articlesManager->get($_GET['id']); //recupere l'article
if ($_POST) { //recupere les données et update l'article
    $donnees = [
        "id" => $_GET['id'],
        "title" => $_POST["title"],
        "content" => $_POST["content"],
        "created_at" => date("Y-m-d H:i:s"),
        "author" => $usersManager->get($_SESSION['id'])->getUsername()
    ];
    $articlesManager->update(new Article($donnees));
    echo "<script>window.location.href='read.php?id={$articleToUpdate->getId()}'</script>";// retourne sur la page de lecture de l'article
}
?>

<body>
    <form method="post" class="container"> <!-- vous devinerez jamais... -->
        <br>
        <div align="center">
            <div class="titre">
                <input type="text" name="title" id="title" class="form-control" aria-describedby="passwordHelpInline" placeholder="Titre de l'Article" value="<?= $articleToUpdate->getTitle() ?>" required>
            </div>
        </div>
        <br>
        <div class="content">
            <div class="col-auto">
                <textarea class="form-control" name="content" id="content" placeholder="Contenu de l'Article" required><?= $articleToUpdate->getContent() ?></textarea>
            </div>
        </div>
        <br>
        <div align="center">
            <input type="submit" value="Mettre à jour" class="btn btn-primary">
        </div>
    </form>
</body>
