<?php

/*---------------------------------------------------- Insert Invoice (1) ----------------------------------------------
 * Tester si le formulaire d'insertion existe avec le bouton valider de la page gestion facture.
 * Tester l'id du chantier , la reférence devis et la référence client existent .
 * Vérifier si les données ne sont pas des espaces vides.
 * Récupère toutes les variables externes et les filtrer.
 *--------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btnInvoiceInsert']) && isset($_POST['message'])) {
    if (isset($_SESSION['identity_site']) && isset($_SESSION['quote_reference']) && isset($_SESSION['client_reference'])
        && isset($_SESSION['VAT_rate']) && isset($_SESSION['initial_amount'])) {
        if (ctype_space($_POST['message']) or ctype_space($_SESSION['identity_site']) or ctype_space($_SESSION['quote_reference'])
            or ctype_space($_SESSION['client_reference'])) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez vérifier les données !</i> ';
        } else {
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
            $idS = filter_var($_SESSION['identity_site'], FILTER_SANITIZE_NUMBER_INT);
            $quotationnumber = filter_var($_SESSION['quote_reference'], FILTER_SANITIZE_NUMBER_INT);
            $customernumber = filter_var($_SESSION['client_reference'], FILTER_SANITIZE_NUMBER_INT);
            // Déclaration des varibles
            $totalwt = 0;
            $vat = 0;
            $totalttc = 0;

            // Récuperer le plus grand Deposit id
            $requete = $db->query('SELECT MAX(idI) FROM invoices');
            $donnee = intval($requete->fetchColumn());

            //Initilisation du depositnumber
            $invoicenumber = $quotationnumber . ($donnee + 1);

            // Récuperation id client
            $customer = new  Customers();
            $idC = $customer->recupCustomerId($customernumber);

            // Instancier la class deposit
            $invoice = new Invoices();
            $invoice->setInvoicenumber($invoicenumber);
            $invoice->setTotalwt($totalwt);
            $invoice->setVat($vat);
            $invoice->setTotalttc($totalttc);
            $invoice->setMessage($message);
            $invoice->setSiteId($idS);
            $invoice->addInvoice();

            echo '<i style="color:#1b6d85;font-size:30px;font-family:calibri ;">La facture N° : '
                . $invoicenumber . ' est bien crée veuillez le chiffrer</i> ';
        }
    } else {
        echo '<i style="color:#852f08;font-size:30px;font-family:calibri ;">
        Veuillez selectionner un chantier avant !</i> ';
    }// Destruction de la variable session
    unset($_SESSION['identity_site'], $_SESSION['client_reference'], $_SESSION['quote_reference'],
        $_SESSION['VAT_rate'], $_SESSION['initial_amount']);
    /*------------------------------------- End insert invoice (1) ---------------------------------------------------*/

}/*-------------------------------------------- Update befor message invoice (2) ---------------------------------------
 * Tester si le formulaire de modification existe avec le bouton valider de la page gestion facture.
 * Tester l'id du chantier , la reférence devis et la référence client existent .
 * Vérifier si les données ne sont pas des espaces vides.
 * Récupère toutes les variables externes et les filtrer.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnInvoiceUpdate']) && isset($_POST['message'])) {
    if (isset($_SESSION['invoice_identifier']) && isset($_SESSION['invoice_reference']) && isset($_SESSION['idsite'])) {
        if (ctype_space($_POST['message']) or ctype_space($_SESSION['idsite']) or ctype_space($_SESSION['invoice_reference'])
            or ctype_space($_SESSION['invoice_identifier'])) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez vérifier les données !</i> ';
        } else {
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
            $idI = filter_var($_SESSION['invoice_identifier'], FILTER_SANITIZE_NUMBER_INT);

            // Instancier la class invoices
            $invoice = new Invoices();
            $invoice->setMessage($message);
            $invoice->setIdI($idI);
            $invoice->updateMessageInvoice();
        }
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veillez selectionner une facture avant !</i> ';
    }// Destruction de la variable session
    unset($_SESSION['invoice_identifier'], $_SESSION['invoice_reference'], $_SESSION['idsite'], $_SESSION['invoice_message']);
    /*--------------------------------------- End message update (2) -------------------------------------------------*/

}/*---------------------------------------------- Delete invoice (3) ---------------------------------------------------
  * Tester si le formulaire de suppression existe avec le bouton valider de la page gestion facture.
  * Tester si la variable contenant l'id à supprimer n'est pas vide.
  *-------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Deleteinvoice']) && isset($_GET['invoicenumber']) && isset($_GET['idsite'])) {
    $idI = trim(filter_input(INPUT_GET, 'Deleteinvoice', FILTER_SANITIZE_NUMBER_INT));

    // Vérification si la facture est payée.
    $payment = new Payment_validated();
    $req = $payment->countPaymentInvoiceId($idI);
    if ($req > 0) {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Suppression impossible liaison avec paiement</i> ';
    } else {
        // Suppression de details de la facture
        $invoicedetails = new Invoices_details();
        $invoicedetails->DeletAllInvoicedetails($idI);

        // Supression de facture
        $invoice = new Invoices();
        $invoice->setIdI($idI);
        $invoice->deleteInvoices();
    }/*------------------------------------------------ End delete invoice (3) ---------------------------------------*/

}/*------------------------------------------------------- Print invoice (4) -------------------------------------------
 * Tester si la methode GET et l'id de la facture existent depuis la page gestion facture.
 * Tester si la varible contenant l'id n'est pas vide.
 * Filtrer toutes les données recuperées
 * Déclaration de variables de session.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Idinvoice']) && isset($_GET['invoicenumber']) && isset($_GET['idsite'])) {
    if (!empty($_GET['Idinvoice']) && !empty($_GET['invoicenumber']) && !empty($_GET['idsite'])) {
        $idinvoice = trim(filter_input(INPUT_GET, 'Idinvoice', FILTER_SANITIZE_NUMBER_INT));
        $invoicenumber = trim(filter_input(INPUT_GET, 'invoicenumber', FILTER_SANITIZE_NUMBER_INT));
        $idsite = trim(filter_input(INPUT_GET, 'idsite', FILTER_SANITIZE_NUMBER_INT));
        $_SESSION['bill_of_invoice'] = $invoicenumber;
        $_SESSION['idinvoice'] = $idinvoice;

        // Instancier la class sites (chanier)
        $site = new Sites();
        $var = $site->recupSitedetails($idsite);
        $donnee = $var->fetch();

        // Istancier la class devis pour la récupération de données
        $quotation = new Quotation();
        $var = $quotation->recupQuotationdetails($donnee['quotation_id']);
        $data = $var->fetch();
        $_SESSION['vatrate'] = $data['vatrate'];
        $_SESSION['initialtotalttc'] = $data['totalwt'];
        $_SESSION['objet'] = $data['workobject'];
        $_SESSION['quote_number'] = $data['quotationnumber'];
        $vatrate = $data['vatrate'];

        // Instancier la class client pour la récupération de données
        $customer = new Customers();
        $var = $customer->recupCustomerdetails($data['customer_id']);
        $persone = $var->fetch();
        $_SESSION['society'] = $persone['society'];
        $_SESSION['customer_number'] = $persone['customernumber'];
        $_SESSION['sexe'] = $persone['sexe'];
        $_SESSION['name'] = $persone['name'];
        $_SESSION['firstname'] = $persone['firstname'];

        // Instancier la class adresse pour la récuperation de données
        $address = new Address();
        $var = $address->recupAddressdetails($persone['address_id']);
        $requete = $var->fetch();
        $_SESSION['way'] = $requete['way'];
        $_SESSION['postalcode'] = $requete['postalcode'];
        $_SESSION['city'] = $requete['city'];

        // Instancier la class facture pour récuperation de données
        $invoice = new Invoices();
        $requete = $invoice->recupInvoicedetails($idinvoice);
        $invoiceListe = $requete->fetch();
        $_SESSION['invoice_hortva'] = $invoiceListe['totalwt'];/*------- Total facture HT -------*/
        $_SESSION['invoice_totalvat'] = $invoiceListe['vat'];/*------- Total TVA -------*/
        $_SESSION['vat_invoice'] = $invoiceListe['totalttc'];/*----- Total facture TTC -----*/
        $_SESSION['invoice_message'] = $invoiceListe['message'];/*------- Message dessou facture -------*/
        $_SESSION['received_deposit'] = $donnee['totalpayments'];/*------- Total accompte reçus -------*/

    } else {
        echo "Veuillez selectionner un devis";
    }/*------------------------------------------ End print invoice (4) ----------------------------------------------*/

}/*---------------------------------------- Session variable declaration (5) -------------------------------------------
 * Tester si la methode GET existe et la reference accompte aussi depuis la page gestion accompte.
 * Tester si la vaiable référence accompte n'est pas vide.
 * Déclarer la référence accompte en variable de session.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Selectinvoice']) && isset($_GET['invoicenumber']) && isset($_GET['idsite'])) {
    if (!empty($_GET['Selectinvoice']) && !empty($_GET['invoicenumber']) && !empty($_GET['idsite'])) {

        $_SESSION['invoice_identifier'] = filter_input(INPUT_GET, 'Selectinvoice', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['invoice_reference'] = filter_input(INPUT_GET, 'invoicenumber', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['idsite'] = filter_input(INPUT_GET, 'idsite', FILTER_SANITIZE_NUMBER_INT);
        $invoice = new Invoices();
        $requete = $invoice->recupInvoicedetails($_SESSION['invoice_identifier']);
        $donnee = $requete->fetch();
        $_SESSION['invoice_message'] = $donnee['message'];
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veillez selectionner une facture avant !</i> ';
    }/*------------------------------------ End session variable declaration (5) -------------------------------------*/

}/*------------------------------------------------ Session variable declaration (6) -----------------------------------
 * Récuperation de formulaire depui la page chantier.
 * Tester si la methode GET existe , la reference client et l'id de devis aussi.
 * Déclaration de variables de session avec filtrage de données.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['idSiteInvoice']) && isset($_GET['quotationnumber'])) {
    $_SESSION['identity_site'] = trim(filter_input(INPUT_GET, 'idSiteInvoice', FILTER_SANITIZE_NUMBER_INT));
    $_SESSION['quote_reference'] = trim(filter_input(INPUT_GET, 'quotationnumber', FILTER_SANITIZE_NUMBER_INT));

    // Récuperation données de devis
    $quotation = new Quotation();
    $idQ = $quotation->recupQuotationId($_SESSION['quote_reference']);
    $var = $quotation->recupQuotationdetails($idQ);
    $donnee = $var->fetch();

    // Récupération données client
    $customer = new Customers();
    $requete = $customer->recupCustomerdetails($donnee['customer_id']);
    $data = $requete->fetch();
    $_SESSION['client_reference'] = $data['customernumber'];
    $_SESSION['VAT_rate'] = $donnee['vatrate'];
    $_SESSION['initial_amount'] = $donnee['totalttc'];
    /*--------------------------------------------- End session variable declaration (6) --------------------------------*/

}/*----------------------------- Before inserting the details of the invoice (7) ---------------------------------------
 * Tester si le formulaire demande ajout details exite de la page gestion facture .
 * Vérifier si l'id du devis ,la référence de la facture et l'identifiant du chantier existent
 * et ne sont pas vides.
 * les déclarer en variables de sessions pour les affichier sur la page ajout détails facture apres filtrage.
 * Vérifier si le chantier est déja payé.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Insertinvoicedetails']) && isset($_GET['invoicenumber']) && isset($_GET['idsite'])) {
    if (!empty($_GET['Insertinvoicedetails']) && !empty($_GET['invoicenumber']) && !empty($_GET['idsite'])) {

        $_SESSION['idI'] = filter_input(INPUT_GET, 'Insertinvoicedetails', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['invoicenumber'] = filter_input(INPUT_GET, 'invoicenumber', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['idsite'] = filter_input(INPUT_GET, 'idsite', FILTER_SANITIZE_NUMBER_INT);

        // Récupération de l'id de devis
        $site = new Sites();
        $requete = $site->recupSitedetails($_SESSION['idsite']);
        $donnee = $requete->fetch();
        if ($donnee['remainingbalance'] <= 0) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Cette facture est déja payée !</i> ';
        } else {
            $_SESSION['idQ'] = $donnee['quotation_id'];

            // Récupération de référence de devis
            $quotation = new Quotation();
            $req = $quotation->recupQuotationdetails($donnee['quotation_id']);
            $data = $req->fetch();
            $_SESSION['quotationnumber'] = $data['quotationnumber'];

            // Récuperation de référence de client
            $customer = new Customers();
            $var = $customer->recupCustomerdetails($data['customer_id']);
            $personne = $var->fetch();
            $_SESSION['customernumber'] = $personne['customernumber'];

            // Récuperation de l'id de l'accompte
            $invoice = new Invoices();
            $_SESSION['idI'] = $invoice->recupInvoiceId($_SESSION['invoicenumber']);

            // Redirection vers page deposit_details
            header("Location: http://localhost/Slimproject/invoice_details");
        }
    } else {
        $error = "Une erreur s'est produite. Reessayez !";
    }/*------------------------------- End before inserting the details of the invoice (7) ---------------------------*/

}/*---------------------------------- Before validating the payment of the invoice (8) ---------------------------------
 * Récuperation de formulaire depui la page facture.
 * Tester si la methode GET existe , l'id de la facture , sa référence , le total TTC et l'id du chantier.
 * Vérifier si le chantier est payé.
 * Déclaration de variables de session avec filtrage de données.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Cashinvoice']) && isset($_GET['invoicenumber'])
    && isset($_GET['totalwt']) && isset($_GET['idsite'])) {
    if (!empty($_GET['Cashinvoice']) && !empty($_GET['invoicenumber'])
        && !empty($_GET['totalwt']) && !empty($_GET['idsite']) and $_GET['totalwt'] != 0) {
        // Récupération de l'id de devis
        $site = new Sites();
        $requete = $site->recupSitedetails($_GET['idsite']);
        $donnee = $requete->fetch();
        if ($donnee['remainingbalance'] <= 0) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Cette facture est déja payée !</i> ';
        } else {
            $_SESSION['cashinvoice'] = trim(filter_input(INPUT_GET, 'Cashinvoice', FILTER_SANITIZE_NUMBER_INT));
            $_SESSION['the_invoice_reference'] = trim(filter_input(INPUT_GET, 'invoicenumber', FILTER_SANITIZE_NUMBER_INT));
            $_SESSION['invoice_totalwt'] = trim(filter_input(INPUT_GET, 'totalwt', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
            $_SESSION['identity_Site'] = trim(filter_input(INPUT_GET, 'idsite', FILTER_SANITIZE_NUMBER_INT));

            // Redirection vers page payment_validated
            header("Location: http://localhost/Slimproject/payment_validated");
        }
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez detailler la facture avant !</i> ';
    }
    /*------------------------ End before validating the payment of the invoice (8) ----------------------------------*/
}
