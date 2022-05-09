<?php
include("./classloader.php");

if (!$_GET) { // si pas de GET ou que le commentaire existe pas, on retourne sur l'index!
    echo "<script>window.location.href='index.php'</script>";
} else if (!$commentairesManager->get($_GET["id"])) {
    echo "<script>window.location.href='index.php'</script>";
}
if ($_POST) { // recupere les données du form et update le commentaire
    $donnees = [
        "id" => $_GET["id"],
        "id_article" => $_GET["id_article"],
        "title" => $_POST["title"],
        "content" => $_POST["content"],
        "created_at" => date("Y-m-d H:i:s")
    ];
    $commentairesManager->update(new Commentaire($donnees));
    echo "<script>window.location.href='read.php?id={$_GET["id_article"]}'</script>"; // redirige sur la page de lecture de l'article
}
?>

<body>
    <form method="post" class="container"> <!-- encore un form... -->
        <br>
        <div align="center">
            <div class="titre">
                <input type="text" name="title" id="title" class="form-control" aria-describedby="passwordHelpInline" placeholder="Titre de l'Article" value=<?= $commentairesManager->get($_GET["id"])->getTitle() ?> required>
            </div>
        </div>
        <br>
        <div class="content">
            <div class="col-auto">
                <textarea class="form-control" name="content" id="content" placeholder="Contenu de l'Article" required><?= $commentairesManager->get($_GET["id"])->getContent() ?></textarea>
            </div>
        </div>
        <br>
        <div align="center">
            <input type="submit" value="Mettre à jour le Commentaire" class="btn btn-primary">
        </div>
    </form>
</body>
