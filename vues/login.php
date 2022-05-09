<?php
$_GET['page'] = "login";
include("./classloader.php");

if ($_POST) { //verification des infos de login
    $userData = [
        "password" => $_POST['password'],
        "email" => $_POST['email']
    ];
    $email = True;
    $alert = False;
    $existingAccount = False;

    if (!$userData['email']) { ?> <!-- pas pratique de se co sans mail -->
        <script>
            alert("Email is required")
        </script>
    <?php $email = False;
        $alert = True;
    }

    if ((!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) && ($email)) { ?> <!-- verifie que le mail join est bien un mail (et pas une injection (au hasard)) -->
        <script>
            alert("Invalid email format")
        </script>
    <?php $alert = True;
    }

    foreach ($usersManager->getAll() as $user) { // recup tous les utilisateurs et verifie qu'il en existe bien un avec le meme mdp et mail
        if ($user->getEmail() == $userData['email'] && $existingAccount == False) {
            if ($user->getPassword() == $userData['password']) {
                $existingAccount = True;
            }
            break;
        }
    }

    if ($existingAccount) { // si l'user existe et que le mdp est bon, on setup la $_SESSION et on retourne au index.php
        $_SESSION["username"] = $user->getUsername();
        $_SESSION["id"] = $user->getId();
        echo "<script>window.location.href= './index.php'</script>";
    } else if (!$alert) { ?> <!-- si un truc est faux, on le signal à l'utilisateur et il reessaie -->
        <script>
            alert("Email or Password is incorrect!")
        </script>
<?php }
}
?>

<body>
    <div>
        <form method="post" class="container"> <!-- form classique -->
            <br>
            <div align="center">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" maxlength="50" required />

            </div>
            <br>
            <div align="center">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" maxlength="50" />
            </div>
            <br>
            <div align="center">
                <button type="submit" class="btn btn-primary">Log in</button>
            </div>
            <br>
            <div align="center">
                <a href="signup.php" name="signup" id="signup" class="btn btn-light btn-lg">No account?</a>
            </div>
        </form>
    </div>
</body>