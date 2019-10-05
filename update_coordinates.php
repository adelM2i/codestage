<!doctype html>
<html>
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
    <h2 align="center" class="h3 mb-3 font-weight-normal">Vous avez oublié votre mot de pass ou vous vouler le
        changer.</h2>
    <div>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" class="form-control" placeholder="Address email">

        <label for="friend" class="sr-only">Le prenom du 1er amis</label>
        <input type="text" name="friend" class="form-control" placeholder="Le prenom de votre premier ami">

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password1" class="form-control" placeholder="Votre nouveau mot de pass">

        <a for="inputPassword" class="sr-only">Password</a>
        <input type="password" name="password" class="form-control" placeholder="Le saisir de nouveau">
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnUserUpdate">Valider</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2019-2020</p>
    <?php

    // Inclusion des fichiers principaux
    include_once '_config/config.php';
    include_once '_classes/Users.php';
    /*------------------------------------------------ Password reset form ---------------------------------------------
     * Tester si la methode post existe le formulaire de chager mot de pass existe avec le bouton valider
     * de la page connection.
     * Tester si les donées existent .
     * Vérifier si les données ne sont pas des espaces vides.
     * Récupère toutes les variables externes et les filtrer.
     *----------------------------------------------------------------------------------------------------------------*/
    if (!empty($_POST) && isset($_POST['btnUserUpdate']) && isset($_POST['email']) && isset($_POST['friend'])
        && isset($_POST['password1']) && isset($_POST['password1'])) {
        if (ctype_space($_POST['email']) or ctype_space($_POST['friend']) or ctype_space($_POST['password1'])
            or ctype_space($_POST['password'])) {
            echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">Veuillez verifier la saisie de données !</i> ';
        } else {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $friend = strtolower(trim(filter_input(INPUT_POST, 'friend', FILTER_SANITIZE_STRING)));
            $password1 = trim(filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING));
            $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

            // Vérification la saisie de nouveau mot de pass
            if ($password1 == $password) {

                // Instancier la class Users
                $user = new Users();
                $user->setEmail($email);
                $user->setFriends($friend);
                if ($user->isExactUserData($user->getEmail(), $user->getFriends())) {
                    $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
                    $user->updateUser();
                    echo '<i style="color:#393785;font-size:30px;font-family:calibri ;">
        Votre mot de pass est bien modifié .</i> ';
                } else {
                    echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
        Veuillez verifier la saisie de vos données !</i> ';
                }
            } else {
                echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
        Veuillez verifier la saisie de mot de pass !</i> ';
            }
        }
    }
    ?>
</form>
</body>
</html>