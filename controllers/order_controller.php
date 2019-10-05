<?php

/*----------------------------------------------------- Order insert (1) -----------------------------------------------
 * Tester si le formulaire d'insertion existe avec le bouton inserrer de la page gestion commandes.
 * Vérifier si toutes les données envoyées en post existent.
 * Verifier si variables ne sont pas de caractères blancs (vides).
 *  Récupère toutes les variables externes et les filtrer.
* --------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btnOrderInsert']) && isset($_POST['ordernumber']) && isset($_POST['date'])
    && isset($_POST['totalwt']) && isset($_POST['totalttc']) && isset($_SESSION['identity_site'])
    && isset($_SESSION['quote_reference']) && isset($_POST['provider'])) {

    if (ctype_space($_POST['ordernumber']) or ctype_space($_POST['date']) or ctype_space($_POST['totalwt'])
        or ctype_space($_POST['totalttc']) or ctype_space($_SESSION['identity_site']) or ctype_space($_POST['provider'])
        or ctype_space($_SESSION['quote_reference'])) {
        echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Veuillez verifier la saisie de données !</i> ';
    } else {
        $ordernumber = filter_input(INPUT_POST, 'ordernumber', FILTER_SANITIZE_NUMBER_INT);
        $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
        $totalwt = trim(filter_input(INPUT_POST, 'totalwt', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $totalttc = trim(filter_input(INPUT_POST, 'totalttc', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $idP = trim(filter_input(INPUT_POST, 'provider', FILTER_SANITIZE_NUMBER_INT));
        $idS = trim(filter_var($_SESSION['identity_site'], FILTER_SANITIZE_NUMBER_INT));

        // Instancier la class Orders
        $order = new Orders();
        $order->setOrdernumber($ordernumber);
        $order->setDate($date);
        $order->setTotalwt($totalwt);
        $order->setTotalttc($totalttc);
        $order->setSiteId($idS);
        $order->setProviderId($idP);

        // Verification si la commande existe dèja
        if ($order->isOrderExiste($order->getOrdernumber(), $order->getProviderId())) {
            echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Commande dèja enregistrée </i> ';
        } else {
            $order->addOrder();
        }
        // Destruction de la variable session
        unset($_SESSION['quote_reference'], $_SESSION['identity_site']);

    }/*---------------------------------------- End order insert (1) -------------------------------------------------*/

}/*----------------------------------------------------- Order update (2) ----------------------------------------------
 * Tester si le formulaire de modification existe avec le bouton modifer de la page gestion commandes.
 * Vérifier si toutes les données envoyées en post existent.
 * Verifier si variables ne sont pas de caractères blancs (vides).
 *  Récupère toutes les variables externes et les filtrer.
* --------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btnOrderUpdate']) && isset($_POST['ordernumber']) && isset($_POST['date'])
    && isset($_POST['totalwt']) && isset($_POST['totalttc']) && isset($_SESSION['idO']) && isset($_SESSION['idS'])
    && isset($_POST['provider'])) {

    if (ctype_space($_POST['ordernumber']) or ctype_space($_POST['date']) or ctype_space($_POST['totalwt'])
        or ctype_space($_POST['totalttc']) or ctype_space($_SESSION['idO']) or ctype_space($_SESSION['idS'])
        or ctype_space($_POST['provider'])) {
        echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Veuillez verifier la saisie de données !</i> ';
    } else {
        $ordernumber = filter_input(INPUT_POST, 'ordernumber', FILTER_SANITIZE_NUMBER_INT);
        $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
        $totalwt = trim(filter_input(INPUT_POST, 'totalwt', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $totalttc = trim(filter_input(INPUT_POST, 'totalttc', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $idP = trim(filter_input(INPUT_POST, 'provider', FILTER_SANITIZE_NUMBER_INT));
        $idO = trim(filter_var($_SESSION['idO'], FILTER_SANITIZE_NUMBER_INT));
        $idS = trim(filter_var($_SESSION['idS'], FILTER_SANITIZE_NUMBER_INT));

        // Instancier la class Orders
        $order = new Orders();
        $order->setOrdernumber($ordernumber);
        $order->setDate($date);
        $order->setTotalwt($totalwt);
        $order->setTotalttc($totalttc);
        $order->setSiteId($idS);
        $order->setProviderId($idP);
        $order->setIdO($idO);

        // Verification si la commande exist dèja
        if ($order->isOrderExiste($order->getOrdernumber(), $order->getProviderId())) {
            echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Commande dèja enregistrée </i> ';
        } else {

            $order->updateOrder();
        }
        // Destruction de la variable session
        unset($_SESSION['idS'], $_SESSION['idO'], $_SESSION['order_reference'], $_SESSION['order_date'],
            $_SESSION['order_totalwt'], $_SESSION['order_totalttc']);

    }/*---------------------------------------- End order update (2) -------------------------------------------------*/

} /*----------------------------------------------------- Order delete (3) ---------------------------------------------
 * Tester si le formulaire de suppression existe avec le bouton supprimer de la page gestion commandes.
 * Vérifier si toutes les données envoyées en post existent.
 * Verifier si variables ne sont pas de caractères blancs (vides).
 *  Récupère toutes les variables externes et les filtrer.
* --------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btnOrderDelete']) && isset($_POST['ordernumber']) && isset($_POST['date'])
    && isset($_POST['totalwt']) && isset($_POST['totalttc']) && isset($_SESSION['idO']) && isset($_SESSION['idS'])
    && isset($_POST['provider'])) {

    if (ctype_space($_POST['ordernumber']) or ctype_space($_POST['date']) or ctype_space($_POST['totalwt'])
        or ctype_space($_POST['totalttc']) or ctype_space($_SESSION['idO']) or ctype_space($_SESSION['idS'])
        or ctype_space($_POST['provider'])) {
        echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Veuillez verifier la saisie de données !</i> ';
    } else {
        $ordernumber = filter_input(INPUT_POST, 'ordernumber', FILTER_SANITIZE_NUMBER_INT);
        $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
        $totalwt = trim(filter_input(INPUT_POST, 'totalwt', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $totalttc = trim(filter_input(INPUT_POST, 'totalttc', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $idP = trim(filter_input(INPUT_POST, 'provider', FILTER_SANITIZE_NUMBER_INT));
        $idO = trim(filter_var($_SESSION['idO'], FILTER_SANITIZE_NUMBER_INT));
        $idS = trim(filter_var($_SESSION['idS'], FILTER_SANITIZE_NUMBER_INT));

        // Instancier la class Orders
        $order = new Orders();
        $order->setIdO($idO);
        $order->deleteOrder();

        // Destruction de la variable session
        unset($_SESSION['idS'], $_SESSION['idO'], $_SESSION['order_reference'], $_SESSION['order_date'],
            $_SESSION['order_totalwt'], $_SESSION['order_totalttc']);

    }/*------------------------------------- End order delete (3) -------------------------------------------------*/

}/*------------------------------------------------ Session variable declaration (4) -----------------------------------
 * Récuperation de formulaire depui la page chantier.
 * Tester si la methode GET existe , la reference devis et l'id de chantier aussi.
 * Déclaration de variables de session avec filtrage de données.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['idSiteOrder']) && isset($_GET['quotationnumber'])) {
    $_SESSION['identity_site'] = trim(filter_input(INPUT_GET, 'idSiteOrder', FILTER_SANITIZE_NUMBER_INT));
    $_SESSION['quote_reference'] = trim(filter_input(INPUT_GET, 'quotationnumber', FILTER_SANITIZE_NUMBER_INT));

    /*--------------------------------------------- End session variable declaration (4) --------------------------------*/

}/*---------------------------------------- Session variable declaration (5) -------------------------------------------
 * Tester si la methode GET existe , l'id et reference commande de la page gestion commandes.
 * Tester si les donneés recuperés ne sont pas vides.
 * Déclarer les donneés en variables de session.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['SelectOrderId']) && isset($_GET['ordernumber']) && isset($_GET['date'])
    && isset($_GET['totalwt']) && isset($_GET['totalttc']) && isset($_GET['site_id'])) {

    if (!empty($_GET['SelectOrderId']) && !empty($_GET['ordernumber']) && !empty($_GET['date'])
        && !empty($_GET['totalwt']) && !empty($_GET['totalttc']) && !empty($_GET['site_id'])) {
        $_SESSION['idS'] = filter_input(INPUT_GET, 'site_id', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['idO'] = filter_input(INPUT_GET, 'SelectOrderId', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['order_reference'] = filter_input(INPUT_GET, 'ordernumber', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['order_date'] = trim(filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING));
        $_SESSION['order_totalwt'] = trim(filter_input(INPUT_GET, 'totalwt', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $_SESSION['order_totalttc'] = trim(filter_input(INPUT_GET, 'totalttc', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));

    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veillez selectionner une commande avant !</i> ';
    }
}/*------------------------------------ End session variable declaration (5) -------------------------------------*/