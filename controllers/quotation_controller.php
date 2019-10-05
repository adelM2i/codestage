<?php

/*---------------------------------------------------------- Insert quotation (1) --------------------------------------
 * Tester si le formulaire d'insertion existe avec le bouton valider de la page gestion devis.
 * Tester la reférence client existe .
 * Vérifier si les données ne sont pas des espaces vides.
 * Récupère toutes les variables externes et les filtrer.
 *--------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btnQuotationInsert']) && isset($_POST['workobject'])
    && isset($_POST['vatrate']) && isset($_POST['message'])) {
    if ($_SESSION['Customernumber']) {
        if (ctype_space($_POST['workobject']) or ctype_space($_POST['vatrate']) or ctype_space($_POST['message'])
            or ctype_space($_SESSION['Customernumber'])) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez vérifier les données saisies !</i> ';
        } else {
            $workobject = filter_input(INPUT_POST, 'workobject', FILTER_SANITIZE_STRING);
            $vatrate = filter_input(INPUT_POST, 'vatrate', FILTER_SANITIZE_NUMBER_INT);
            $message = ucfirst(trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING)));
            $customernumber = filter_var($_SESSION['Customernumber'], FILTER_SANITIZE_NUMBER_INT);
            $totalwt = 0;
            $vat = 0;
            $totalttc = 0;
            // Récuperer le plus grand  Quotation id
            $requete = $db->query('SELECT MAX(idQ) FROM quotation');
            $donnee = intval($requete->fetchColumn());

            //Initilisation du quotationnumber
            $quotationnumber = $customernumber . ($donnee + 1);

            // Récuperation id client
            $customer = new  Customers();
            $idC = $customer->recupCustomerId($customernumber);

            // Instancier la class quotation
            $quotation = new Quotation();
            $quotation->setWorkobject(ucfirst($workobject));
            $quotation->setQuotationnumber($quotationnumber);
            $quotation->setTotalwt($totalwt);
            $quotation->setVatrate($vatrate);
            $quotation->setVat($vat);
            $quotation->setTotalttc($totalttc);
            $quotation->setCustomerId($idC);
            $quotation->setMessage($message);
            $quotation->addQuotation();

            echo '<i style="color:#1b6d85;font-size:30px;font-family:calibri ;">Le devis N° : '
                . $quotationnumber . ' est bien crée veuillez le chiffrer</i> ';
            // Destruction de la variable session
            unset($_SESSION['Customernumber']);
        }
    } else {
        echo '<i style="color:#852f08;font-size:30px;font-family:calibri ;">
        Veuillez selectionner un client avant !</i> ';
    }/*------------------------------------------------ End Insert quotation (1) -------------------------------------*/

} /*---------------------------------------------- Update befor quotation (2) ------------------------------------------
 * Tester si le formulaire de modification existe avec le bouton valider de la page gestion devis.
 * Tester l'existance de l'id client .
 * Vérifier si les données ne sont pas des espaces vides.
 * Récupère toutes les variables externes et les filtrer.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnQuotationUpdate']) && isset($_POST['workobject'])
    && isset($_POST['vatrate']) && isset($_POST['message'])) {
    if (isset($_SESSION['Customernumber'])) {
        if (ctype_space($_POST['workobject']) or ctype_space($_POST['vatrate']) or ctype_space($_POST['message'])
            or ctype_space($_SESSION['Customernumber'])) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez vérifier les données saisies !</i> ';
        } else {
            $idQ = filter_var($_SESSION['idQuotation'], FILTER_SANITIZE_NUMBER_INT);
            $workobject = ucfirst(filter_input(INPUT_POST, 'workobject', FILTER_SANITIZE_STRING));
            $vatrate = filter_input(INPUT_POST, 'vatrate', FILTER_SANITIZE_NUMBER_INT);
            $message = trim(ucfirst(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING)));

            // Instancier la class devis
            $quotation = new Quotation();
            $quotation->setIdQ($idQ);
            $quotation->setWorkobject($workobject);
            $quotation->setVatrate($vatrate);
            $quotation->setMessage($message);

            // Modification de devis.
            $quotation->updateBeforQuotation();

            // Destruction de la variable session
            unset($_SESSION['idQuotation'], $_SESSION['Customernumber'], $_SESSION['editworkobject'],
                $_SESSION['editvatrate'], $_SESSION['editmessage']);
        }
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veillez selectionner un devis avant !</i> ';
    }/*------------------------------------------------ End update quotation (2) -------------------------------------*/

} /*---------------------------------------------------- Delete quotation (3) ------------------------------------------
* Tester si le formulaire de suppression existe avec le bouton valider de la page gestion devis.
* Tester si la variable contenant l'id à supprimer n'est pas vide.
*---------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Deletequote']) && !empty($_GET['Deletequote'])) {
    $idQ = trim(filter_input(INPUT_GET, 'Deletequote', FILTER_SANITIZE_NUMBER_INT));
    // Vérification si le devis est lié à un chantier
    $site = new Sites();
    $req = $site->countSitesquotationId($idQ);
    if ($req > 0) {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Suppression impossible liaison avec chantier</i> ';
        // Destruction de la variable session
        unset($_SESSION['idQuotation'], $_SESSION['Customernumber'], $_SESSION['editworkobject'],
            $_SESSION['editvatrate'], $_SESSION['editmessage']);
    } else {
        // Suppression les details du devis .
        $quotedetail = new Quote_details();
        $quotedetail->DeletAllQuotedetails($_GET['Deletequote']);

        // Supression du devis
        $quotation = new Quotation();
        $quotation->setIdQ($_GET['Deletequote']);
        $quotation->deleteQuotation();

        // Destruction de la variable session
        unset($_SESSION['idQuotation'], $_SESSION['Customernumber'], $_SESSION['editworkobject'],
            $_SESSION['editvatrate'], $_SESSION['editmessage']);
    }/*----------------------------------------------- End delete quotation (3) --------------------------------------*/


}/*------------------------------------------------------ Print quotation (4) ------------------------------------------
 * Tester si la methode GET et l'id du devis existent.
 * Tester si la varible contenant l'id n'est pas vide.
 * Filtrer toutes les données recuperées
 * Déclaration de variables de session.
 * Redirection vers la page précédente pour impression.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Idquotation']) && isset($_GET['quotationnumber']) && isset($_GET['customernumber'])) {
    if (!empty($_GET['Idquotation']) && !empty($_GET['quotationnumber']) && !empty($_GET['customernumber'])) {
        $idQ = trim(filter_input(INPUT_GET, 'Idquotation', FILTER_SANITIZE_NUMBER_INT));
        $quotationnumber = trim(filter_input(INPUT_GET, 'quotationnumber', FILTER_SANITIZE_NUMBER_INT));
        $customernumber = trim(filter_input(INPUT_GET, 'customernumber', FILTER_SANITIZE_NUMBER_INT));
        $_SESSION['idQ'] = $idQ;
        $_SESSION['quotationnumber'] = $quotationnumber;
        $_SESSION['customernumber'] = $customernumber;

        // Instancier la class quotedetails
        $quotedetail = new Quote_details();
        $total = $quotedetail->calculateSumColone($idQ);
        $somme = $total->fetchColumn();

        // Istancier la class devis pour recuperer et mettre à jour les données
        $quotation = new Quotation();
        $req = $quotation->recupQuotationdetails($idQ);
        $donnee = $req->fetch();
        $vat = $somme * ($donnee['vatrate'] / 100);
        $totalttc = $somme + $vat;

        // déclaration variable de session
        $_SESSION['objet'] = $donnee['workobject'];
        $_SESSION['totalwt'] = $somme;
        $_SESSION['vat'] = $vat;
        $_SESSION['message'] = $donnee['message'];
        $_SESSION['totalttc'] = $totalttc;

        // Instancier la class client pour recuperer l'id puis les données correspondantes
        $customer = new Customers();
        $requete = $customer->recupCustomerId($customernumber);
        $var = $customer->recupCustomerdetails($requete);
        $donnee = $var->fetch();
        $_SESSION['sexe'] = $donnee['sexe'];
        $_SESSION['name'] = $donnee['name'];
        $_SESSION['firstname'] = $donnee['firstname'];
        $_SESSION['society'] = $donnee['society'];

        // Instancier la class adresse pour recuperer les données correspondantes à l'id
        $address = new Address();
        $req = $address->recupAddressdetails($donnee['address_id']);
        $donnee = $req->fetch();
        $_SESSION['way'] = $donnee['way'];
        $_SESSION['postalcode'] = $donnee['postalcode'];
        $_SESSION['city'] = $donnee['city'];

        // Redirection vers page impression
        header("Location: http://localhost/Slimproject/quotation");
    } else {
        echo "Veuillez selectionner un devis";
    }/*----------------------------------------------- End print quotation (4) ---------------------------------------*/

}/*------------------------------------------- Before you edit or delete a quote (5) -----------------------------------
 * Tester si la methode GET existe , la reference client et l'id de devis aussi.
 * Déclaration de variables de session avec filtrage de données.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Selectquotation']) && isset($_GET['customernumber'])) {
    $_SESSION['idQuotation'] = trim(filter_input(INPUT_GET, 'Selectquotation', FILTER_SANITIZE_NUMBER_INT));
    $_SESSION['Customernumber'] = trim(filter_input(INPUT_GET, 'customernumber', FILTER_SANITIZE_NUMBER_INT));

    // Récuperation données de devis
    $quotation = new Quotation();
    $var = $quotation->recupQuotationdetails($_SESSION['idQuotation']);
    $donnee = $var->fetch();
    $_SESSION['editworkobject'] = $donnee['workobject'];
    $_SESSION['editvatrate'] = $donnee['vatrate'];
    $_SESSION['editmessage'] = $donnee['message'];
    /*------------------------------------- End before you edit or delete a quote (5) --------------------------------*/

}/*-------------------------------------------- Session variable declaration (6) ---------------------------------------
 * Tester si la methode GET existe et la reference client aussi.
 * Tester si la vaiable référence client n'est pas vide.
 * Déclarer la référence client en variable de session.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Customernumber'])) {
    if (!empty($_GET['Customernumber'])) {
        $_SESSION['Customernumber'] = $_GET['Customernumber'];

        // Redirection à la page quotation
        header("Location: http://localhost/Slimproject/quotation");
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veillez selectionner un client avant !</i> ';
    }/*------------------------------------ End Session variable declaration (6) -------------------------------------*/

}/*----------------------------------------- Before adding details (7) -------------------------------------------------
 * Tester si le formulaire demande ajout details exite de la page gestion devis.
 * Vérifier si l'id du devis ,la référence du devis et la référence du client existent et ne sont pas vides.
 * Vérifier si le devis n'est pas valider pour un chantier.
 * Déclaration de variables de sessions pour les affichier sur la page ajout détails.
 * Redirection à la page ajout details devis.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['Insertdetails'])) {
    if ($_GET['customernumber'] && $_GET['quotationnumber']) {
        if (!empty($_GET['customernumber']) && !empty($_GET['quotationnumber'])) {

            // Instancier la class sites (chanier)
            $site = new Sites();
            $var = $site->countSitesquotationId($_GET['Insertdetails']);
            if ($var > 0) {
                echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;"> Attention ce devis est validé pour un chantier à ne pas modifier !</i> ';
            } else {
                $_SESSION['idQ'] = filter_input(INPUT_GET, 'Insertdetails', FILTER_SANITIZE_NUMBER_INT);
                $_SESSION['customernumber'] = filter_input(INPUT_GET, 'customernumber', FILTER_SANITIZE_NUMBER_INT);
                $_SESSION['quotationnumber'] = filter_input(INPUT_GET, 'quotationnumber', FILTER_SANITIZE_NUMBER_INT);
                header("Location: http://localhost/Slimproject/quotedetails");
            }

        } else {
            $error = "Vous devez selectionner une action !";
        }

    } else {
        $error = "Une erreur s'est produite. Reessayez !";
    }
}/*----------------------------------------- End before adding details (7) ---------------------------------------------