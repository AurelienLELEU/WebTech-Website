<?php
$_GET['page'] = "login";
include("./classloader.php");
if ($_POST) { // recuperation et verification des données et creation du compte
    $userData = [
        "username" => $_POST['username'],
        "password" => $_POST['password'],
        "email" => $_POST['email']
    ];
    $existingAccount = False;

    $users = $usersManager->getAll();

    if (empty($userData['username'])) { ?> <!-- verifie que la case a bien été saisie -->
        <script>
            alert("Name is required")
        </script>
    <?php $existingAccount = True;
    }
    if (!preg_match("/^[a-zA-Z-' ]*$/", $userData['username'])) { ?> <!-- empeche les injections -->
        <script>
            alert("Only letters and white spaces allowed")
        </script>
    <?php $existingAccount = True;
    }
    if (empty($userData['email'])) { ?><!-- verifie que la case a bien été saisie -->
        <script>
            alert("Email is required")
        </script>
    <?php $existingAccount = True;
    }
    if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) { ?><!-- empeche les injections -->
        <script>
            alert("Invalid email format")
        </script>
        <?php $existingAccount = True;
    }
    if (empty($userData['password'])) { ?><!-- verifie que la case a bien été saisie -->
        <script>
            alert("Password is required")
        </script>
    <?php $existingAccount = True;
    }
    foreach ($users as $user) { // verifie que l'username existe pas deja
        if ($user->getUsername() == $userData['username']) { ?>
            <script>
                alert("This username is already taken !")
            </script>
        <?php $existingAccount = True;
            break;
        }
        if ($user->getEmail() == $userData['email'] && $existingAccount == False) { ?>
            <script>
                alert("This email address is already taken !")
            </script>
<?php $existingAccount = True;
            break;
        }
    }
    if ($existingAccount == False) { // si le compte existe pas deja, on le cré
        $usersManager->add(new User($userData));
        session_destroy();
        echo "<script>window.location.href='index.php'</script>";
    }
}
?>

<body>
    <div> <!-- vous connaissez la chanson... -->
        <form method="post" class="container">
            <br>
            <div align="center">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" maxlength="50" required />
            </div>
            <br>
            <div align="center">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" maxlength="50" required />

            </div>
            <br>
            <div align="center">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" maxlength="50" required />
                <label for="password">Must be 8-50 characters long</label>
            </div>
            <br>
            <div align="center">
                <button type="submit" class="btn btn-light btn-lg">Sign up</button>
            </div>
        </form>
    </div>
</body>