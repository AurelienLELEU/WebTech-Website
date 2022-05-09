<?php
include("./classloader.php");

if ($_SESSION) { //verifie si l'user est connecté à un compte ou non, auquel cas le commentaire sera publié par "unknown"
    $username = $_SESSION['username'];
} else {
    $username = "unknown";
}

if (!$_GET) { //au cas ou
    echo "<script>window.location.href='index.php'</script>";
}

if ($_POST) { // creation du commentaire
    $valid = true;
    $donnees = [
        "id_article" => $_GET["id_article"],
        "title" => $_POST["title"],
        "content" => $_POST["content"],
        "created_at" => date("Y-m-d H:i:s"),
        "author" => $username
    ];

    if (empty($donnees['title'])) { ?>
        <!-- verifie que le titre n'est pas vide -->
        <script href="javascript:;">
            alert("Vous ne m'aurez pas! Mettez un titre svp")
        </script>
<?php $valid = False;
    }
    if ($valid) {
        if (strpos(strtolower($_SESSION["username"]), "chris") !== true) { // mise en place de la sensure
            $commentairesManager->add(new Commentaire($donnees));
        }
        echo "<script>window.location.href='read.php?id={$_GET["id_article"]}'</script>";
    }
} ?>

<script>
    function chris() { // je suis navré
        open('https://www.youtube.com/watch?v=6elK8VI1rPs');
        location.href = ('index.php');
    }
</script>

<body>
    <div>
        <form method="post" class="container">
            <!-- un form basique, simple -->
            <br>
            <div align="center">
                <div class="titre">
                    <input type="text" name="title" id="title" class="form-control" aria-describedby="passwordHelpInline" placeholder="Titre du Commentaire" required>
                </div>
            </div>
            <br>
            <div class="content">
                <div class="col-auto">
                    <textarea class="form-control" name="content" id="content" placeholder="Contenu du Commentaire"></textarea>
                </div>
            </div>
            <br>
            <?php if (strpos(strtolower($_SESSION["username"]), "chris") !== false) { ?>
                <div align="center">
                    <a onclick="chris()" class="btn btn-primary" target="_blank">Créer le Commentaire</a>
                </div>
            <?php } else { ?>
                <div align="center">
                    <input type="submit" value="Créer le Commentaire" class="btn btn-primary">
                </div> <?php } ?>
        </form>
    </div>
</body>