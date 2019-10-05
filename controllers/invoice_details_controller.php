<?php

/* ------------------------------------------------------ Insert invoice_details (1) -----------------------------------
 * Tester si le formulaire d'insertion existe avec le bouton valider de la page ajout details pour facture.
 * Vérifier si toutes les variables externes existent.
 * Vérifier si les variables ne sont pas des espaces vides.
 * Filter toutes les variables et les recuperer.
 *--------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btninvoice_detail_Insert']) && isset($_POST['designation']) && isset($_POST['unit'])
    && isset($_POST['amount']) && isset($_POST['totaluwt']) && isset($_POST['percentage'])
    && isset ($_SESSION['idI']) && isset ($_SESSION['idsite']) && isset ($_SESSION['customernumber'])) {
    if (ctype_space($_SESSION['idI']) or ctype_space($_SESSION['idsite']) or ctype_space($_SESSION['customernumber'])
        or ctype_space($_POST['designation']) or ctype_space($_POST['unit']) or ctype_space($_POST['amount'])
        or ctype_space($_POST['totaluwt']) or ctype_space($_POST['percentage'])) {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez vérifier les données saisies !</i> ';
    } else {
        $designation = ucfirst(trim(filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_STRING)));
        $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $unit = ucfirst(trim(filter_input(INPUT_POST, 'unit', FILTER_SANITIZE_STRING)));
        $unitprice = filter_var($_SESSION['unitprice'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $totaluwt = filter_input(INPUT_POST, 'totaluwt', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $percentage = filter_input(INPUT_POST, 'percentage', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $idI = filter_var($_SESSION['idI'], FILTER_SANITIZE_NUMBER_INT);
        $idS = filter_var($_SESSION['idsite'], FILTER_SANITIZE_NUMBER_INT);
        $customernumber = filter_var($_SESSION['customernumber'], FILTER_SANITIZE_NUMBER_INT);

        // Instancier la class deposit_invoice_details
        $invoicedetail = new Invoices_details();
        $invoicedetail->setDesignation($designation);
        $invoicedetail->setUnit($unit);
        $invoicedetail->setAmount($amount);
        $invoicedetail->setUnitprice($unitprice);
        $invoicedetail->setTotaluwt($totaluwt);
        $invoicedetail->setPercentage($percentage);
        $somme = ($totaluwt * $percentage) / 100;
        $invoicedetail->setEquivalent($somme);
        $invoicedetail->setInvoiceId($idI);
        $invoicedetail->addIvoiceDetails();

        // Instancier la class sites pour recuperation de donneés
        $site = new Sites();
        $listesite = $site->recupSitedetails($idS);
        $donneesite = $listesite->fetch();
        $invoice_totalwt = $donneesite['initialmonatant'] - $donneesite['totalpayments'];

        // Istancier la class devis pour la récupération de données
        $quotation = new Quotation();
        $var = $quotation->recupQuotationdetails($donneesite['quotation_id']);
        $data = $var->fetch();

        // Instancier la class accompte pour la récuperation et mettre à jour de données
        $invoice = new Invoices();
        $invoice->setTotalwt($invoice_totalwt);
        $vat = ($invoice_totalwt * $data['vatrate']) / 100;
        $invoice->setVat($vat);
        $invoice->setTotalttc($invoice_totalwt + $vat);
        $invoice->setIdI($idI);
        $invoice->updateTotalInvoice();
    }/*-------------------------------------- End insert invoice_details (1) -----------------------------------------*/

}/* ---------------------------------------------- Delete invoice_details (2) ------------------------------------------
 * Tester si le formulaire de delete existe avec le bouton valider de la page ajout details invoice.
 * Tester l'existance de toutes les variables .
 * Tester si ces variables ne sont pas vides.
 * Filtrer toutes les variables.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['idDeletedetailinvoice']) && isset($_SESSION['idI']) && isset($_SESSION['idsite'])) {
    if (ctype_space($_GET['idDeletedetailinvoice']) or ctype_space($_SESSION['idI']) or ctype_space($_SESSION['idsite'])) {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez vérifier les données saisies !</i> ';
    } else {
        $idId = trim(filter_input(INPUT_GET, 'idDeletedetailinvoice', FILTER_SANITIZE_NUMBER_INT));
        $idI = filter_var($_SESSION['idI'], FILTER_SANITIZE_NUMBER_INT);
        $idS = filter_var($_SESSION['idsite'], FILTER_SANITIZE_NUMBER_INT);

        // Suppresion de l'article
        $invoicedetail = new Invoices_details();
        $invoicedetail->setIdId($idId);
        $invoicedetail->deleteInvoivedetails();
        $somme = $invoicedetail->calculateSumInvoice($idI);
        $equivalent = $somme->fetchColumn();

        // Instancier la class sites (chanier)
        $site = new Sites();
        $var = $site->recupSitedetails($idS);
        $donnee = $var->fetch();

        // Istancier la class devis pour la récupération de données
        $quotation = new Quotation();
        $var = $quotation->recupQuotationdetails($donnee['quotation_id']);
        $data = $var->fetch();

        // Instancier la class accompte pour la récuperation et mettre à jour de données
        $invoice = new Invoices();
        $invoice->setTotalwt($equivalent);
        $vat = ($equivalent * $data['vatrate']) / 100;
        $invoice->setVat($vat);
        $invoice->setTotalttc($equivalent + $vat);
        $invoice->setIdI($idI);
        $invoice->updateTotalInvoice();

        // Destruction de la variable session
        unset($_SESSION['designation'], $_SESSION['amount'], $_SESSION['unit']
            , $_SESSION['unitprice'], $_SESSION['totaluwt']);
    }/*---------------------------------------- End delete invoice_details (2) ---------------------------------------*/


}/* --------------------------------------- Declaration of session variables (3) ---------------------------------------
 * Tester si le formulaire demande details existe.
 * Vérification si les données du devis existent.
 * Les declarer en variables de session avec filtrage.
 * Retour à la page précedente.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['idDetailQuote'])) {

    if (isset($_GET['designation']) && isset($_GET['unit'])
        && isset($_GET['amount']) && isset($_GET['unitprice']) && isset($_GET['koefficient'])) {
        $_SESSION['designation'] = ucfirst(trim(filter_input(INPUT_GET, 'designation', FILTER_SANITIZE_STRING)));
        $_SESSION['amount'] = filter_input(INPUT_GET, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $_SESSION['unit'] = ucfirst(trim(filter_input(INPUT_GET, 'unit', FILTER_SANITIZE_STRING)));
        $_SESSION['unitprice'] = filter_input(INPUT_GET, 'unitprice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $_SESSION['totaluwt'] = filter_input(INPUT_GET, 'totaluwt', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }/*--------------------------------- End declaration of session variables (3) ------------------------------------*/
}