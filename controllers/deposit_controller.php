<?php

/*---------------------------------------------------- Insert deposit (1) ----------------------------------------------
 * Tester si le formulaire d'insertion existe avec le bouton valider de la page gestion accompte.
 * Tester l'id du chantier , la reférence devis et la référence client existent .
 * Vérifier si les données ne sont pas des espaces vides.
 * Récupère toutes les variables externes et les filtrer.
 *--------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btnDepositInsert']) && isset($_POST['message'])) {
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
            $requete = $db->query('SELECT MAX(idD) FROM deposit');
            $donnee = intval($requete->fetchColumn());

            //Initilisation du depositnumber
            $depositnumber = $quotationnumber . ($donnee + 1);

            // Récuperation id client
            $customer = new  Customers();
            $idC = $customer->recupCustomerId($customernumber);

            // Instancier la class deposit
            $deposit = new Deposit();
            $deposit->setDepositnumber($depositnumber);
            $deposit->setTotalwt($totalwt);
            $deposit->setVat($vat);
            $deposit->setTotalttc($totalttc);
            $deposit->setMessage($message);
            $deposit->setSiteId($idS);
            $deposit->addDeposit();
            echo '<i style="color:#1b6d85;font-size:30px;font-family:calibri ;">L\'accompte N° : '
                . $depositnumber . ' est bien crée veuillez le chiffrer</i> ';
        }
    } else {
        echo '<i style="color:#852f08;font-size:30px;font-family:calibri ;">
        Veuillez selectionner un chantier avant !</i> ';
    }// Destruction de la variable session
    unset($_SESSION['identity_site'], $_SESSION['client_reference'], $_SESSION['quote_reference'],
        $_SESSION['VAT_rate'], $_SESSION['initial_amount']);
    /*------------------------------------- End insert deposit (1) ---------------------------------------------------*/

}/*-------------------------------------------- Update befor message deposit (2) ---------------------------------------
 * Tester si le formulaire de modification existe avec le bouton valider de la page gestion accompte.
 * Tester l'id du chantier , la reférence devis et la référence client existent .
 * Vérifier si les données ne sont pas des espaces vides.
 * Récupère toutes les variables externes et les filtrer.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnDepositUpdate']) && isset($_POST['message'])) {
    if (isset($_SESSION['account_identifier']) && isset($_SESSION['deposit_reference']) && isset($_SESSION['idsite'])) {
        if (ctype_space($_POST['message']) or ctype_space($_SESSION['idsite']) or ctype_space($_SESSION['deposit_reference'])
            or ctype_space($_SESSION['account_identifier'])) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez vérifier les données !</i> ';
        } else {
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
            $idD = filter_var($_SESSION['account_identifier'], FILTER_SANITIZE_NUMBER_INT);

            // Instancier la class deposit
            $deposit = new Deposit();
            $deposit->setMessage($message);
            $deposit->setIdD($idD);
            $deposit->updateMessageDeposit();
        }
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veillez selectionner un accompte avant !</i> ';
    }// Destruction de la variable session
    unset($_SESSION['account_identifier'], $_SESSION['deposit_reference'], $_SESSION['idsite'], $_SESSION['deposit_message']);
    /*--------------------------------------- End message update (2) -------------------------------------------------*/

}/*---------------------------------------------- Delete deposit (3) ---------------------------------------------------
  * Tester si le formulaire de suppression existe avec le bouton valider de la page gestion accompte.
  * Tester si la variable contenant l'id à supprimer n'est pas vide.
  *-------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Deletedeposit']) && isset($_GET['depositnumber']) && isset($_GET['idsite'])) {
    $idD = trim(filter_input(INPUT_GET, 'Deletedeposit', FILTER_SANITIZE_NUMBER_INT));

    // Vérification si l'accompte est payé.
    $payment = new Payment_validated();
    $req = $payment->countPaymentDepositId($idD);
    if ($req > 0) {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Suppression impossible liaison avec paiement</i> ';
    } else {
        // Suppression de details d'accompte
        $depositdetails = new Deposit_details();
        $depositdetails->DeletAllDepositdetails($idD);
        // Supression d'accompte
        $deposit = new Deposit();
        $deposit->setIdD($idD);
        $deposit->deleteDeposit();
    }/*------------------------------------------------ End delete deposit (3) ---------------------------------------*/

}/*------------------------------------------------------- Print deposit (4) -------------------------------------------
 * Tester si la methode GET et l'id d'accompte existent depuis la page gestion accompte.
 * Tester si la varible contenant l'id n'est pas vide.
 * Filtrer toutes les données recuperées
 * Déclaration de variables de session.
 * Redirection vers la page précédente pour impression.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Iddeposit']) && isset($_GET['depositnumber']) && isset($_GET['idsite'])) {
    if (!empty($_GET['Iddeposit']) && !empty($_GET['depositnumber']) && !empty($_GET['idsite'])) {
        $iddeposit = trim(filter_input(INPUT_GET, 'Iddeposit', FILTER_SANITIZE_NUMBER_INT));
        $depositnumber = trim(filter_input(INPUT_GET, 'depositnumber', FILTER_SANITIZE_NUMBER_INT));
        $idsite = trim(filter_input(INPUT_GET, 'idsite', FILTER_SANITIZE_NUMBER_INT));
        $_SESSION['bill_of_deposit'] = $depositnumber;

        // Instancier la class sites pour recuperation de données
        $site = new Sites();
        $siteListe = $site->recupSitedetails($idsite);
        $donneesite = $siteListe->fetch();
        $_SESSION['received_deposit'] = $donneesite['totalpayments'];

        // Istancier la class devis pour la récupération de données
        $quotation = new Quotation();
        $var = $quotation->recupQuotationdetails($donneesite['quotation_id']);
        $data = $var->fetch();
        $_SESSION['vatrate'] = $data['vatrate'];
        $_SESSION['initialtotalttc'] = $data['totalwt'];
        $_SESSION['objet'] = $data['workobject'];
        $_SESSION['quote_number'] = $data['quotationnumber'];

        // Instancier la class client pour la récupération de données
        $customer = new Customers();
        $var = $customer->recupCustomerdetails($data['customer_id']);
        $persone = $var->fetch();
        $_SESSION['society'] = $persone['society'];
        $_SESSION['customer_number'] = $persone['customernumber'];
        $_SESSION['sex'] = $persone['sex'];
        $_SESSION['name'] = $persone['name'];
        $_SESSION['firstname'] = $persone['firstname'];

        // Instancier la class adresse pour la récuperation de données
        $address = new Address();
        $var = $address->recupAddressdetails($persone['address_id']);
        $requete = $var->fetch();
        $_SESSION['way'] = $requete['way'];
        $_SESSION['postalcode'] = $requete['postalcode'];
        $_SESSION['city'] = $requete['city'];

        // Instancier la class accompte pour la récuperation et mettre à jour de données
        $deposit = new Deposit();
        $var = $deposit->recupDepositdetails($iddeposit);
        $depositListe = $var->fetch();
        $_SESSION['deposit_hortva'] = $depositListe['totalwt'];
        $_SESSION['deposit_totalvat'] = $depositListe['vat'];
        $_SESSION['vat_deposit'] = $depositListe['totalttc'];
        $_SESSION['deposit_message'] = $depositListe['message'];
        $_SESSION['iddeposit'] = $iddeposit;

    } else {
        echo "Veuillez selectionner un devis";

    }/*------------------------------------------ End print deposit (4) ----------------------------------------------*/


}/*---------------------------------------- Session variable declaration (5) -------------------------------------------
 * Tester si la methode GET existe et la reference accompte aussi depuis la page gestion accompte.
 * Tester si la vaiable référence accompte n'est pas vide.
 * Déclarer la référence accompte en variable de session.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Selectdeposit']) && isset($_GET['depositnumber']) && isset($_GET['idsite'])) {
    if (!empty($_GET['Selectdeposit']) && !empty($_GET['depositnumber']) && !empty($_GET['idsite'])) {
        $_SESSION['account_identifier'] = filter_input(INPUT_GET, 'Selectdeposit', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['deposit_reference'] = filter_input(INPUT_GET, 'depositnumber', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['idsite'] = filter_input(INPUT_GET, 'idsite', FILTER_SANITIZE_NUMBER_INT);
        $deposit = new Deposit();
        $requete = $deposit->recupDepositdetails($_SESSION['account_identifier']);
        $donnee = $requete->fetch();
        $_SESSION['deposit_message'] = $donnee['message'];
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veillez selectionner un accompte avant !</i> ';
    }/*------------------------------------ End session variable declaration (5) -------------------------------------*/

}/*------------------------------------------------ Session variable declaration (6) -----------------------------------
 * Récuperation de formulaire depui la page chantier.
 * Tester si la methode GET existe , la reference client et l'id de devis aussi.
 * Déclaration de variables de session avec filtrage de données.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['idSiteDeposit']) && isset($_GET['quotationnumber'])) {
    $_SESSION['identity_site'] = trim(filter_input(INPUT_GET, 'idSiteDeposit', FILTER_SANITIZE_NUMBER_INT));
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

}/*------------------------------------ Declaration of session variables (7) -------------------------------------------
 * Tester si le formulaire demande ajout details exite de la page gestion accompte .
 * Vérifier si l'id du devis ,la référence d'accompte et l'identifiant du chantier existent
 * et ne sont pas vides.
 * les déclarer en variables de sessions pour les affichier sur la page ajout détails accompte apres filtrage.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Insertdepositdetails']) && isset($_GET['depositnumber']) && isset($_GET['idsite'])) {
    if (!empty($_GET['Insertdepositdetails']) && !empty($_GET['depositnumber']) && !empty($_GET['idsite'])) {

        $_SESSION['idD'] = filter_input(INPUT_GET, 'Insertdepositdetails', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['depositnumber'] = filter_input(INPUT_GET, 'depositnumber', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['idsite'] = filter_input(INPUT_GET, 'idsite', FILTER_SANITIZE_NUMBER_INT);

        // Récupération de l'id de devis
        $site = new Sites();
        $requete = $site->recupSitedetails($_SESSION['idsite']);
        $donnee = $requete->fetch();
        if ($donnee['remainingbalance'] <= 0) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Cet accompte est déja  encaissée !</i> ';
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
            $deposit = new Deposit();
            $_SESSION['idD'] = $deposit->recupDepositId($_SESSION['depositnumber']);

            // Redirection vers page deposit_details
            header("Location: http://localhost/Slimproject/deposit_details");
        }

    } else {
        $error = "Une erreur s'est produite. Reessayez !";
    }/*--------------------------------- End declaration of session variables (7) ------------------------------------*/

}/*---------------------------------------- Session variable deposit declaration (8) -----------------------------------
 * Récuperation de formulaire depui la page accompte.
 * Tester si la methode GET existe , l'id d'accompte , sa référence , le total TTC et l'id du chantier
 * Vérifier si le chantier est payé.
 * Déclaration de variables de session avec filtrage de données.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Cashdeposit']) && isset($_GET['depositnumber'])
    && isset($_GET['totalwt']) && isset($_GET['idsite'])) {
    if (!empty($_GET['Cashdeposit']) && !empty($_GET['depositnumber'])
        && !empty($_GET['totalwt']) && !empty($_GET['idsite']) and $_GET['totalwt'] != 0) {
        // Récupération de l'id de devis
        $site = new Sites();
        $requete = $site->recupSitedetails($_GET['idsite']);
        $donnee = $requete->fetch();
        if ($donnee['remainingbalance'] <= 0) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Cet accompte est déja  encaissée !</i> ';
        } else {
            $_SESSION['cashdeposit'] = trim(filter_input(INPUT_GET, 'Cashdeposit', FILTER_SANITIZE_NUMBER_INT));
            $_SESSION['the_deposit_reference'] = trim(filter_input(INPUT_GET, 'depositnumber', FILTER_SANITIZE_NUMBER_INT));
            $_SESSION['deposit_totalwt'] = trim(filter_input(INPUT_GET, 'totalwt', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
            $_SESSION['identity_Site'] = trim(filter_input(INPUT_GET, 'idsite', FILTER_SANITIZE_NUMBER_INT));

            // Redirection vers page deposit_details
            header("Location: http://localhost/Slimproject/payment_validated");
        }
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez detailler l\'accompte avant !</i> ';
    }
}/*------------------------------- End session variable deposit declaration (8) -----------------------------------*/