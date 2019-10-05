<?php

/*======================================================================================================================
                                           (I)   Deposit processing
======================================================================================================================*/
/*----------------------------------------------- Insert deposit payment (1) -------------------------------------------
 * Tester si la methode POST et le formulaire d'insertion existent depuis la page gestion paiement accompte.
 * Tester si les variables de session existent et ne sont pas vides.
 * Filtrer toutes les variables recuperées
 *--------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btnValidatePayment']) && isset($_SESSION['cashdeposit'])
    && isset($_SESSION['the_deposit_reference']) && isset($_SESSION['deposit_totalwt']) && isset($_SESSION['identity_Site'])) {
    if (!empty($_SESSION['cashdeposit']) && !empty($_SESSION['the_deposit_reference'])
        && !empty($_SESSION['deposit_totalwt']) && !empty($_SESSION['identity_Site']) and $_SESSION['deposit_totalwt'] != 0) {
        $cashdeposit = trim(filter_var($_SESSION['cashdeposit'], FILTER_SANITIZE_NUMBER_INT));
        $depositnumber = trim(filter_var($_SESSION['the_deposit_reference'], FILTER_SANITIZE_NUMBER_INT));
        $totalwt = trim(filter_var($_SESSION['deposit_totalwt'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $idS = trim(filter_var($_SESSION['identity_Site'], FILTER_SANITIZE_NUMBER_INT));

        // Vérification si ce depositnumber est validé
        $payment = new Payment_validated();
        $var = $payment->countPaymentDepositId($cashdeposit);
        if ($var > 0) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Ce paiement est déja validé !</i> ';
        } else {
            // Instancier la class payment et inserrer le nouveau paiement
            $payment->setReference($depositnumber);
            $payment->setTotalTurnover($totalwt);
            $payment->setSiteId($idS);
            $payment->setDepositId($cashdeposit);
            $payment->addPayment();
            $sommePayment = $payment->SumTotalturnoverSite($idS);
            $somme = $sommePayment->fetchColumn();

            // Instancier la class chantier pour mettre à jour les données
            $site = new Sites();
            $listeSite = $site->recupSitedetails($idS);
            $donnee = $listeSite->fetch();
            $site->setTotalpayments($somme);
            $site->setRemainingbalance($donnee['initialmonatant'] - $somme);
            $site->setIdS($idS);
            $site->updateTotalSites();

            echo '<i style="color:#0d8553;font-size:30px;font-family:calibri ;">Votre paiement est bien enregistré !</i> ';
        }

    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez selectionner un accompte avant !</i> ';
    }// Destruction de variables de session
    unset($_SESSION['cashdeposit'], $_SESSION['the_deposit_reference'], $_SESSION['deposit_totalwt'], $_SESSION['identity_Site']);
    /*---------------------------------------- End insert deposit payment (1) ----------------------------------------*/

}/*------------------------------------------- Payment deposit cancellation (2) ----------------------------------------
 * Tester si la methode POST et le formulaire d'annulation existent depuis la page gestion paiement accompte.
 * Tester si les variables de session existent .
 * Redirection vers la page d'accompte.
 * Déstruction variables de session.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnCancelPayment']) && isset($_SESSION['cashdeposit'])
    && isset($_SESSION['the_deposit_reference']) && isset($_SESSION['deposit_totalwt']) && isset($_SESSION['identity_Site'])) {
    unset($_SESSION['cashdeposit'], $_SESSION['the_deposit_reference'], $_SESSION['deposit_totalwt'], $_SESSION['identity_Site']);
    header("Location:index.php?page=deposit");
    /*------------------------------------ End Payment deposit cancellation (2) --------------------------------------*/


    /*==================================================================================================================
                                                (II)   Invoice processing
    ==================================================================================================================*/
}/*---------------------------------------------- Insert invoice payment (4) -------------------------------------------
 * Tester si la methode POST et le formulaire d'insertion existent depuis la page gestion paiement facture.
 * Tester si les variables de session existent et ne sont pas vides.
 * Filtrer toutes les variables recuperées
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnValidatePayment']) && isset($_SESSION['cashinvoice'])
    && isset($_SESSION['the_invoice_reference']) && isset($_SESSION['invoice_totalwt']) && isset($_SESSION['identity_Site'])) {

    if (!empty($_SESSION['cashinvoice']) && !empty($_SESSION['the_invoice_reference'])
        && !empty($_SESSION['invoice_totalwt']) && !empty($_SESSION['identity_Site']) and $_SESSION['invoice_totalwt'] != 0) {
        $cashinvoice = trim(filter_var($_SESSION['cashinvoice'], FILTER_SANITIZE_NUMBER_INT));
        $invoicenumber = trim(filter_var($_SESSION['the_invoice_reference'], FILTER_SANITIZE_NUMBER_INT));
        $totalwt = trim(filter_var($_SESSION['invoice_totalwt'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $idS = trim(filter_var($_SESSION['identity_Site'], FILTER_SANITIZE_NUMBER_INT));

        // Vérification si ce depositnumber est validé
        $payment = new Payment_validated();
        $var = $payment->countPaymentInvoiceId($cashinvoice);
        if ($var > 0) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Ce paiement est déja validé !</i> ';
        } else {
            // Instancier la class payment et inserrer le nouveau paiement
            $payment->setReference($invoicenumber);
            $payment->setTotalTurnover($totalwt);
            $payment->setSiteId($idS);
            $payment->setInvoiceId($cashinvoice);
            $payment->addPayment();
            $sommePayment = $payment->SumTotalturnoverSite($idS);
            $somme = $sommePayment->fetchColumn();

            // Instancier la class chantier pour mettre à jour les données
            $site = new Sites();
            $listeSite = $site->recupSitedetails($idS);
            $donnee = $listeSite->fetch();
            $site->setTotalpayments($somme);
            $site->setRemainingbalance($donnee['initialmonatant'] - $somme);
            $site->setIdS($idS);
            $site->updateTotalSites();

            echo '<i style="color:#0d8553;font-size:30px;font-family:calibri ;">Votre paiement est bien enregistré !</i> ';
        }

    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez selectionner une facture avant !</i> ';
    }// Destruction de variables de session
    unset($_SESSION['cashinvoice'], $_SESSION['the_invoice_reference'], $_SESSION['invoice_totalwt'], $_SESSION['identity_Site']);

    /*-------------------------------------- End insert invoice payment (4) ------------------------------------------*/

}/*------------------------------------------- Payment invoice cancellation (5) ----------------------------------------
 * Tester si la methode POST et le formulaire d'annulation existent depuis la page gestion paiement.
 * Tester si les variables de session existent .
 * Redirection vers la page de facture.
 * Déstruction variables de session.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnCancelPayment']) && isset($_SESSION['cashinvoice'])
    && isset($_SESSION['the_invoice_reference']) && isset($_SESSION['invoice_totalwt']) && isset($_SESSION['identity_Site'])) {
    unset($_SESSION['cashinvoice'], $_SESSION['the_invoice_reference'], $_SESSION['invoice_totalwt'], $_SESSION['identity_Site']);

    header("Location:index.php?page=invoice");
    /*------------------------------------ End Payment invoice cancellation (5) --------------------------------------*/
}