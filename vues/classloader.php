<!-- Rien de special à noter dans ce fichier, il sert juste à precharger mes controlleurs et managers, les initialiser, et il contient toutes les nav-bar -->

<?php
function loadClass($class)
{
    if (str_contains($class, 'Manager')) {
        require "../manager/$class.php";
    } else {
        require "../controlleur/$class.php";
    }
}
spl_autoload_register("loadClass");
session_start();
$imagesManager = new ImagesManager();
$articlesManager = new ArticlesManager();
$commentairesManager = new CommentairesManager();
$usersManager = new UsersManager();
?>

<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>HexaNews</title>
</head>

<body>
    <?php
    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case "create": ?>
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
                    <?php if ($_SESSION) { ?> <a class="navbar-brand" href="logout.php">Logout</a> <?php } else { ?> <a class="navbar-brand" href="login.php">Login</a> <?php } ?>
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse " id="navb">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item active">
                                <?php if ($_SESSION) { ?>
                                    <a class="nav-link" href="create.php">Create Article</a>
                                <?php } else { ?>
                                    <a class="nav-link disabled" href="create.php">Create Article</a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </nav>

            <?php break;
            case "login": ?>

                <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
                    <?php if ($_SESSION) { ?>
                        <a class="navbar-brand" href="logout.php">Logout</a>
                    <?php } else { ?>
                        <a class="navbar-brand" href="login.php">Login</a>
                    <?php } ?>
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse " id="navb">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <?php if ($_SESSION) { ?>
                                    <a class="nav-link" href="create.php">Create Article</a>
                                <?php } else { ?>
                                    <a class="nav-link disabled" href="create.php">Create Article</a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </nav>

            <?php break;
            case "index": ?>

                <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
                    <?php if ($_SESSION) { ?>
                        <a class="navbar-brand" href="logout.php">Logout</a>
                    <?php } else { ?>
                        <a class="navbar-brand" href="login.php">Login</a>
                    <?php } ?>
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse " id="navb">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <?php if ($_SESSION) { ?>
                                    <a class="nav-link" href="create.php">Create Article</a>
                                <?php } else { ?>
                                    <a class="nav-link disabled" href="create.php">Create Article</a>
                                <?php } ?>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0 " action="index.php" method="GET">
                            <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search">
                            <button class="btn btn-success my-2 my-sm-0" type="submit">Search</4button>
                        </form>
                    </div>
                </nav>

            <?php break;
            case "read": ?>
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
                    <?php if ($_SESSION) { ?>
                        <a class="navbar-brand" href="logout.php">Logout</a>
                    <?php } else { ?>
                        <a class="navbar-brand" href="login.php">Login</a>
                    <?php } ?>
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse " id="navb">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <?php if ($_SESSION) { ?>
                                    <a class="nav-link" href="create.php">Create Article</a>
                                <?php } else { ?>
                                    <a class="nav-link disabled" href="create.php">Create Article</a>
                                <?php } ?>
                            </li>
                        </ul>
                        <div class="sort">
                            <div class=togglecomments>
                                <button class="btn btn-light btn-sm" onclick="toggleComments()"> Afficher/Masquer les commentaires </button>
                            </div>
                        </div>
                    </div>
                </nav>

            <?php break;
            default: ?>

                <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
                    <?php if ($_SESSION) { ?>
                        <a class="navbar-brand" href="logout.php">Logout</a>
                    <?php } else { ?>
                        <a class="navbar-brand" href="login.php">Login</a>
                    <?php } ?>
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse " id="navb">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <?php if ($_SESSION) { ?>
                                    <a class="nav-link" href="create.php">Create Article</a>
                                <?php } else { ?>
                                    <a class="nav-link disabled" href="create.php">Create Article</a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </nav>
        <?php break;
        }
    } else { ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <?php if ($_SESSION) { ?>
                <a class="navbar-brand" href="logout.php">Logout</a>
            <?php } else { ?>
                <a class="navbar-brand" href="login.php">Login</a>
            <?php } ?>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navb">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <?php if ($_SESSION) { ?>
                            <a class="nav-link" href="create.php">Create Article</a>
                        <?php } else { ?>
                            <a class="nav-link disabled" href="create.php">Create Article</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php } ?>
</body>