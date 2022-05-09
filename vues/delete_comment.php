<?php
include("./classloader.php");
// rien de compliqué, ca delete l'id passé en get ou en post, ca verifie que l'user qui veut delete un commentaire est bien l'auteur de ce dernier
if ($_POST) {
    if ($_SESSION["username"] == $articlesManager->get($commentairesManager->get($_POST['id'])->getId_article())->getAuthor() || $_SESSION["username"] == $commentairesManager->get($_POST['id'])->getAuthor() || $_SESSION["username"] == "admin") {
        $article = $commentairesManager->get($_POST['id'])->getId_article();
        $commentairesManager->delete($_POST['id']);
        echo "<script>window.location.href='read.php?id={$article}'</script>";
    }
}
if ($_GET) {
    if ($_SESSION["username"] == $articlesManager->get($commentairesManager->get($_GET['id'])->getId_article())->getAuthor() || $_SESSION["username"] == $commentairesManager->get($_GET['id'])->getAuthor() || $_SESSION["username"] == "admin") {
        $article = $commentairesManager->get($_GET['id'])->getId_article();
        $commentairesManager->delete($_GET['id']);
        echo "<script>window.location.href='read.php?id={$article}'</script>";
    }
}
