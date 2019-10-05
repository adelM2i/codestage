<?php

/*----------------------------------------------------- Fee insert (1) -------------------------------------------------
 * Tester si le formulaire d'insertion existe avec le bouton inserrer de la page gestion de frais.
 * Vérifier si toutes les données envoyées en post existent.
 * Verifier si variables ne sont pas de caractères blancs (vides).
 *  Récupère toutes les variables externes et les filtrer.
* --------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btnFeeInsert']) && isset($_POST['amount']) && isset($_POST['date'])
    && isset($_POST['nature']) && isset($_SESSION['fee_idS']) && isset($_SESSION['fee_quotationnumber'])) {
    if (ctype_space($_POST['amount']) or ctype_space($_POST['date']) or ctype_space($_POST['nature'])
        or ctype_space($_SESSION['fee_idS']) or ctype_space($_SESSION['fee_qotationnumber'])) {
        echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Veuillez verifier la saisie de données !</i> ';
    } else {
        $nature = trim(filter_input(INPUT_POST, 'nature', FILTER_SANITIZE_STRING));
        $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
        $amount = trim(filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $idS = trim(filter_var($_SESSION['fee_idS'], FILTER_SANITIZE_NUMBER_INT));

        // Instancier la class Fees
        $fee = new Fees();
        $fee->setNature($nature);
        $fee->setAmount($amount);
        $fee->setDate($date);
        $fee->setSiteId($idS);

        // Verification si la note existe
        if ($fee->isFeeExiste($fee->getDate(), $fee->getNature(), $fee->getAmount(), $fee->getSiteId())) {
            echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Note de frais dèja enregistrée </i> ';
        } else {
            $fee->addfee();
        }
        // Destruction de la variable session
        unset($_SESSION['fee_idS'], $_SESSION['fee_quotationnumber'], $_SESSION['idS'], $_SESSION['quotationnumber']);
    }/*---------------------------------------- End fee insert (1) ---------------------------------------------------*/

}/*----------------------------------------------------- Fee update (2) ------------------------------------------------
 * Tester si le formulaire de modification existe avec le bouton modifer de la page gestion de frais.
 * Vérifier si toutes les données envoyées en post existent.
 * Verifier si variables ne sont pas de caractères blancs (vides).
 *  Récupère toutes les variables externes et les filtrer.
* --------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnFeeUpdate']) && isset($_POST['amount']) && isset($_POST['date'])
    && isset($_POST['nature']) && isset($_SESSION['idF']) && isset($_SESSION['fee_idS'])) {

    if (ctype_space($_POST['amount']) or ctype_space($_POST['date']) or ctype_space($_POST['nature'])
        or ctype_space($_SESSION['idF']) or ctype_space($_SESSION['fee_idS'])) {
        echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Veuillez verifier la saisie de données !</i> ';
    } else {
        $nature = trim(filter_input(INPUT_POST, 'nature', FILTER_SANITIZE_STRING));
        $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
        $amount = trim(filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $idS = trim(filter_var($_SESSION['fee_idS'], FILTER_SANITIZE_NUMBER_INT));
        $idF = trim(filter_var($_SESSION['idF'], FILTER_SANITIZE_NUMBER_INT));

        // Instancier la class Fees
        $fee = new Fees();
        $fee->setNature($nature);
        $fee->setAmount($amount);
        $fee->setDate($date);
        $fee->setSiteId($idS);
        $fee->setIdF($idF);

        // Verification si la note existe
        if ($fee->isFeeExiste($fee->getNature(), $fee->getDate(), $fee->getAmount(), $fee->getSiteId())) {
            echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Note de frais dèja enregistrée </i> ';
        } else {
            $fee->updateFee();
        }
        // Destruction de la variable session
        unset($_SESSION['idF'], $_SESSION['fee_date'], $_SESSION['fee_idS'], $_SESSION['fee_nature'],
            $_SESSION['fee_amount']);
    }/*------------------------------------------ End fee update (2) -------------------------------------------------*/

} /*----------------------------------------------------- Fee delete (3) -----------------------------------------------
 * Tester si le formulaire de suppression existe avec le bouton supprimer de la page gestion de frais.
 * Vérifier si toutes les données envoyées en post existent.
 * Verifier si variables ne sont pas de caractères blancs (vides).
 *  Récupère toutes les variables externes et les filtrer.
* --------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnFeeDelete']) && isset($_POST['amount']) && isset($_POST['date'])
    && isset($_POST['nature']) && isset($_SESSION['idF']) && isset($_SESSION['fee_idS'])) {

    if (ctype_space($_POST['amount']) or ctype_space($_POST['date']) or ctype_space($_POST['nature'])
        or ctype_space($_SESSION['idF']) or ctype_space($_SESSION['fee_idS'])) {
        echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Veuillez verifier la saisie de données !</i> ';
    } else {
        $idF = trim(filter_var($_SESSION['idF'], FILTER_SANITIZE_NUMBER_INT));
        // Instancier la class Fees
        $fee = new Fees();
        $fee->setIdF($idF);
        $fee->deleteFee();
        // Destruction de la variable session
        unset($_SESSION['idF'], $_SESSION['fee_date'], $_SESSION['fee_idS'], $_SESSION['fee_nature'],
            $_SESSION['fee_amount']);
    }/*------------------------------------------ End fee delete (3) -------------------------------------------------*/

}/*------------------------------------------------ Session variable declaration (4) -----------------------------------
 * Récuperation de formulaire depui la page chantier.
 * Tester si la methode GET existe , la reference devis et l'id de chantier aussi.
 * Déclaration de variables de session avec filtrage de données.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['idSitefee']) && isset($_GET['quotationnumber'])) {
    $_SESSION['fee_idS'] = trim(filter_input(INPUT_GET, 'idSitefee', FILTER_SANITIZE_NUMBER_INT));
    $_SESSION['fee_quotationnumber'] = trim(filter_input(INPUT_GET, 'quotationnumber', FILTER_SANITIZE_NUMBER_INT));

    /*------------------------------------------ End session variable declaration (4) --------------------------------*/

}/*---------------------------------------- Session variable declaration (5) -------------------------------------------
 * Tester si la methode GET existe , l'id et reference commande de la page gestion commandes.
 * Tester si les donneés recuperés ne sont pas vides.
 * Déclarer les donneés en variables de session.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['SelectFeeId']) && isset($_GET['amount']) && isset($_GET['date'])
    && isset($_GET['nature']) && isset($_GET['site_id'])) {
    if (!empty($_GET['SelectFeeId']) && !empty($_GET['amount']) && !empty($_GET['date'])
        && !empty($_GET['nature']) && !empty($_GET['site_id'])) {
        $_SESSION['idF'] = filter_input(INPUT_GET, 'SelectFeeId', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['fee_date'] = trim(filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING));
        $_SESSION['fee_idS'] = filter_input(INPUT_GET, 'site_id', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['fee_nature'] = trim(filter_input(INPUT_GET, 'nature', FILTER_SANITIZE_STRING));
        $_SESSION['fee_amount'] = trim(filter_input(INPUT_GET, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veillez selectionner une commande avant !</i> ';
    }
}/*---------------------------------------- End session variable declaration (5) -------------------------------------*/