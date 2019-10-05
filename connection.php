<!doctype html>
<html lang="en">
<head>
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/bootstrap/css/signin.css" rel="stylesheet">
</head>
<body class="bg-light">
<form class="form-signin" method="post">
    <div class="row">
        <img class="img-rounded col-lg-12" src="./assets/images/logo-soc.png" alt="" width="450" height="100">
    </div>
    <h1 align="center" class="h3 mb-3 font-weight-normal">Veuillez vous connecter</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="email" class="form-control" placeholder="Addresse email">
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password">
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnconnection">Valider</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2019-2020</p>
    <a class="btn btn-xs" href="update_coordinates.php">Mot de pass oublié</a>
    <?php
    // Inclusion des fichiers principaux
    include_once '_config/config.php';
    include_once '_classes/Users.php';
    /*------------------------------------------------ Form of connection ----------------------------------------------
     * Tester si la methode post existe le formulaire de connection existe avec le bouton valider de la page connection.
     * Tester si les donées existent .
     * Vérifier si les données ne sont pas des espaces vides.
     * Récupère toutes les variables externes et les filtrer.
     *----------------------------------------------------------------------------------------------------------------*/
    if (!empty($_POST) && isset($_POST['btnconnection']) && isset($_POST['email']) && isset($_POST['password'])) {
        if (ctype_space($_POST['email']) or ctype_space($_POST['password'])) {
            echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
        Veuillez verifier la saisie de données !</i> ';
        } else {
            // Récuperation de données
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

            // Instancier la class Users
            $user = new Users();
            $user->setEmail($email);
            $listeUser = $user->getAllUsers();
            $donnee = $listeUser->fetch();

            // Verification si l'email correspend et le mot de pass aussi
            if ($user->isUserExiste($user->getEmail()) and password_verify($password, $donnee['password'])) {
                // Declaration variable de session pour connection
                $_SESSION['admin'] = $donnee['firstname'];

                // Redirection vers page deposit_details
                header("Location: http://localhost/Slimproject/index.php?page=admin");
            } else {
                echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
        Identifiants incorrects !</i> ';
            }
        }
    }
    ?>
</form>
</body>
</html>
