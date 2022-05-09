<?php
$_GET['page'] = "create";
include("./classloader.php");

if ($_POST) { // creation de l'article
    $id_image = NULL;
    $valid = True;

    if (!is_dir("upload/")) { // verif si le dossier "upload" existe deja, sinnon il le cré
        mkdir("upload/");
    }
    $fileName = $_FILES["image"]["name"]; //nommage et placement de l'image dans le fichier "upload"
    $targetFile = "upload/$fileName" . date("Y-m-d");
    $fileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $imagesManager->add(new Image(["name" => $fileName . date("Y-m-d"), "image" => $targetFile])); //ajout des images dans la base de données
        $id_image = $imagesManager->getLastImageId(); //recup l'id de l'image pour le setup à la creation de l'article
    }

    $donnees = [
        "id_image" => $id_image,
        "title" => $_POST["title"],
        "content" => $_POST["content"],
        "created_at" => date("Y-m-d H:i:s"),
        "author" => $usersManager->get($_SESSION['id'])->getUsername() //recupere l'username du user connecté
    ];

    if (empty($donnees['title'])) { ?>
        <!-- on sait jamais -->
        <script href="javascript:;">
            alert("Vous ne m'aurez pas! Mettez un titre svp")
        </script>
<?php $valid = False;
    }
    if ($valid) { // si tout est niquel ca cré l'article
        if (strpos(strtolower($_SESSION["username"]), "chris") !== true) {
            $articlesManager->add(new Article($donnees));
        }
        echo "<script>window.location.href='index.php'</script>";
    }
} ?>

<script>
    function chris() { // c'etait plus fort que moi
        open('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        location.href = ('index.php');
    }
</script>

<body>
    <div>
        <?php if ($_SESSION) { ?>
            <!-- form classique, avec verif que l'user est bien connecté -->
            <form method="post" enctype="multipart/form-data" class="container">
                <br>
                <div align="center">
                    <input type="file" class="form-control" name="image" id="image">
                </div>
                <br>
                <div align="center">
                    <div class="titre">
                        <input type="text" name="title" id="title" class="form-control" aria-describedby="passwordHelpInline" placeholder="Titre de l'Article" required>
                    </div>
                </div>
                <br>
                <div class="content">
                    <div class="col-auto">
                        <textarea class="form-control" name="content" id="content" placeholder="Contenu de l'Article"></textarea>
                    </div>
                </div>
                <br>
                <?php if (strpos(strtolower($_SESSION["username"]), "chris") !== false) { ?>
                    <div align="center">
                        <a onclick="chris()" class="btn btn-primary" target="_blank">Créer l'Article</a>
                    </div>
                <?php } else { ?>
                    <div align="center">
                        <input type="submit" value="Créer l'Article" class="btn btn-primary">
                    </div> <?php } ?>
            </form>
        <?php } else { // si personne n'est connecté, retour à l'index
        ?><script>
                alert("Please, Login first!")
            </script>
        <?php
            echo "<script>window.location.href='./index.php'</script>";
        } ?>
    </div>
</body>