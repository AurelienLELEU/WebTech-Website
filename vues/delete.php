<?php
include("./classloader.php");
// pareil que delete_comment.php sauf que la c'est pour les articles, rien de compliqué, ca verifie que l'user qui veut delete un article est bien l'auteur de ce dernier 

if ($_POST) {
    if ($_SESSION["username"] == $articlesManager->get($_POST['id'])->getAuthor() || $_SESSION["username"] == "admin") {
    $articlesManager->delete($_POST['id']);
}}

if ($_GET['id']) {
    if ($_SESSION["username"] == $articlesManager->get($_GET['id'])->getAuthor() || $_SESSION["username"] == "admin") {
    $articlesManager->delete($_GET['id']);
}}

echo "<script>window.location.href='index.php'</script>";
