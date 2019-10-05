<?php

/*----------------------------------------------------- Insert site (1) ------------------------------------------------
 * Tester si le formulaire d'insertion existe avec le bouton valider de la page gestion chantier.
 *  Récupère la réference de devis et la filtrer.
 *--------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btnsiteInsert']) && isset($_POST['quotationnumber'])) {
    $quotationnumber = trim(filter_input(INPUT_POST, 'quotationnumber', FILTER_SANITIZE_NUMBER_INT));

    // vérifier si la réference saisie existe.
    $quotation = new Quotation();
    $var = $quotation->recupQuotationId($quotationnumber);
    if ($var == "") {
        echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Référence erronée , veuillez vérifier ! </i> ';
    } else {
        // Instancier la class devis
        $quotation = new Quotation();
        // Récperer l'id correspondant à la réference
        $var = $quotation->recupQuotationId($quotationnumber);
        // Récuperer les données de cet id
        $requete = $quotation->recupQuotationdetails($var);
        $donnee = $requete->fetch();
        // Instancier la class Sites
        $site = new Sites();
        // Vérifier si un chantier lié à cette id
        $req = $site->countSitesquotationId($var);
        if ($req > 0) {
            echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                On ne peut pas demarrer un deuxieme chantier avec le même devis ! </i> ';
        } else {
            // Isertion de chantier
            $site->setInitialmonatant($donnee['totalwt']);
            $site->setTotalpayments(0);
            $site->setRemainingbalance($donnee['totalwt']);
            $site->setQuotationId($var);
            $site->addSites();
        }
    } // Destruction de la variable session
    unset($_SESSION['idS'], $_SESSION['quotationnumber']);
    /*------------------------------------------- end insert site (1) ------------------------------------------------*/

} /*------------------------------------------------ Update site (2) ---------------------------------------------------
* Tester si le formulaire d'update existe avec le bouton valider de la page gestion chantier.
* Vérifier si toutes les données envoyées en post existent.
* Récupère  l'id en session et le filtrer.
*---------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnsiteUpdate']) && isset($_SESSION['idS'])
    && isset($_POST['quotationnumber']) && isset($_GET['SelectSiteId'])) {
    $idS = filter_var($_SESSION['idS']);
    $quotationnumber = trim(filter_input(INPUT_POST, 'quotationnumber', FILTER_SANITIZE_NUMBER_INT));
    // vérifier si la réference saisie existe.
    $quotation = new Quotation();
    $var = $quotation->recupQuotationId($quotationnumber);
    if ($var == "") {
        echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Référence erronée , veuillez vérifier ! </i> ';
    } else {
        // Vérifier si un accompte lié au chantier
        $deposit = new Deposit();
        $var = $deposit->countDepositSiteId($idS);
        if ($var > 0) {
            echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
               Pas possible liaison accompte ! </i> ';
        } else {
            // Instancier la class devis
            $quotation = new Quotation();
            // Récperer l'id correspondant à la réference
            $var = $quotation->recupQuotationId($quotationnumber);
            // Récuperer les données de cet id
            $requete = $quotation->recupQuotationdetails($var);
            $donnee = $requete->fetch();
            // Instancier la class Sites
            $site = new Sites();
            // Vérifier si un chantier lié à cette id
            $req = $site->countSitesquotationId($var);
            if ($req > 0) {
                echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                On ne peut pas demarrer un deuxieme chantier avec le même devis ! </i> ';
            } else {
                // Isertion de chantier
                $site = new Sites();
                $site->setInitialmonatant($donnee['totalwt']);
                $site->setTotalpayments(0);
                $site->setRemainingbalance($donnee['totalwt']);
                $site->setQuotationId($var);
                $site->setIdS($idS);
                $site->updateSites();
            }
        }
    } // Destruction de la variable session
    unset($_SESSION['idS'], $_SESSION['quotationnumber']);
    /*---------------------------------------------------- End update site (2) ---------------------------------------*/

}/*--------------------------------------------------- Delete site (3) -------------------------------------------------
* Tester si le formulaire d'delete existe avec le bouton valider de la page gestion chantier.
* Vérifier si toutes les données envoyées en post existent.
* Récupère  l'id en session et le filtrer.
*---------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnsiteDelete']) && isset($_SESSION['idS'])
    && isset($_SESSION['quotationnumber']) && isset($_GET['SelectSiteId'])) {
    $quotationnumber = trim(filter_input(INPUT_POST, 'quotationnumber', FILTER_SANITIZE_NUMBER_INT));
    $idS = filter_var($_SESSION['idS']);
    // vérifier si la réference saisie existe.
    $quotation = new Quotation();
    $var = $quotation->recupQuotationId($quotationnumber);
    if ($var == "") {
        echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
                Référence erronée , veuillez vérifier ! </i> ';
    } else {
        // Vérifier si un accompte lié au chantier
        $deposit = new Deposit();
        $var = $deposit->countDepositSiteId($idS);
        if ($var > 0) {
            echo '<i style="color:#850008;font-size:30px;font-family:calibri ;">
               Pas possible liaison accompte ! </i> ';
        } else {
            // Instanciation classe chantier et supprimer le chantier
            $site = new Sites();
            $site->setIdS($idS);
            $site->deleteSites();
        }
    }// Destruction de la variable session
    unset($_SESSION['idS'], $_SESSION['quotationnumber']);
    /*------------------------------------------------ End delete site (3) -------------------------------------------*/

}/*------------------------------------------------ Session variable declaration (4) -----------------------------------
 * Tester si la methode GET existe , la reference devis et l'id de devis aussi.
 * Déclaration de variables de session avec filtrage de données.
 */
elseif (!empty($_GET) && isset($_GET['SelectSiteId']) && isset($_GET['quotationnumber'])) {
    $_SESSION['idS'] = trim(filter_input(INPUT_GET, 'SelectSiteId', FILTER_SANITIZE_NUMBER_INT));
    $_SESSION['quotationnumber'] = trim(filter_input(INPUT_GET, 'quotationnumber', FILTER_SANITIZE_NUMBER_INT));
}/*--------------------------------------------- End session variable declaration (4) --------------------------------*/
