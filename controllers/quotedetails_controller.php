<?php


/*----------------------------------------------- Insertion details of a quote (1) -------------------------------------
 * Tester si le formulaire d'insertion existe avec le bouton valider de la page ajout details devis.
 * Récupère toutes les variables externes .
 * Vérifier si les variables ne sont pas des espaces vides.
 * Filter toutes les variables.
 *--------------------------------------------------------------------------------------------------------------------*/
if (!empty($_POST) && isset($_POST['btnQuoteDetailInsert']) && isset($_POST['designation']) && isset($_POST['unit'])
    && isset($_POST['amount']) && isset($_POST['unitprice']) && isset($_POST['koefficient'])) {

    if (ctype_space($_POST['designation']) or ctype_space($_POST['unit']) or ctype_space($_POST['amount'])
        or ctype_space($_POST['unitprice']) or ctype_space($_POST['koefficient'])) {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez vérifier les données saisies !</i> ';
    } else {
        $designation = ucfirst(trim(filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_STRING)));
        $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $unit = ucfirst(trim(filter_input(INPUT_POST, 'unit', FILTER_SANITIZE_STRING)));
        $unitprice = filter_input(INPUT_POST, 'unitprice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $koefficient = filter_input(INPUT_POST, 'koefficient', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        // $Customernumber = intval($_SESSION['Customernumber']);
        $idQ = filter_var($_SESSION['idQ'], FILTER_SANITIZE_NUMBER_INT);

        // Instancier la class quote_details
        $quotedetail = new Quote_details();
        $quotedetail->setDesignation($designation);
        $quotedetail->setUnit($unit);
        $quotedetail->setAmount($amount);
        $quotedetail->setUnitprice($unitprice);
        $quotedetail->setKoefficient($koefficient);
        $totaluwt = $unitprice * $koefficient * $amount;
        $quotedetail->setTotaluwt($totaluwt);
        $quotedetail->setQuotationId($idQ);
        $quotedetail->addQuoteDetails();
        $total = $quotedetail->calculateSumColone($idQ);
        $somme = $total->fetchColumn();

        // Istancier la class devis pour mettre à jour les données
        $quotation = new Quotation();
        $req = $quotation->recupQuotationdetails($idQ);
        $donnee = $req->fetch();
        $vat = $somme * ($donnee['vatrate'] / 100);
        $totalttc = $somme + $vat;
        $quotation->setTotalwt($somme);
        $quotation->setVat($vat);
        $quotation->setTotalttc($vat + $somme);
        $quotation->setIdQ($idQ);
        $quotation->updateQuotation();
    }/*-------------------------------------- End insertion details of a quote (1) -----------------------------------*/

}/*--------------------------------------------------- Update details of a quote (2) -----------------------------------
 * Tester si le formulaire d'update existe avec le bouton valider de la page ajout details devis.
 * Récupère toutes les variables externes .
 * Vérifier l'existance de l'id en variable de session.
 * Vérifier si toutes les variables ne sont pas des espaces vides.
 * Filtrer toutes les variables.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnQuoteDetailUpdate']) && isset($_POST['designation']) && isset($_POST['unit'])
    && isset($_POST['amount']) && isset($_POST['unitprice']) && isset($_POST['koefficient'])) {
    if (isset($_SESSION['idQd']) && isset($_SESSION['idQ'])) {
        if (ctype_space($_POST['designation']) or ctype_space($_POST['unit']) or ctype_space($_POST['amount'])
            or ctype_space($_POST['unitprice']) or ctype_space($_POST['koefficient']) or ctype_space($_SESSION['idQ'])) {
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez vérifier les données saisies !</i> ';
        } else {
            $designation = ucfirst(trim(filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_STRING)));
            $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $unit = ucfirst(trim(filter_input(INPUT_POST, 'unit', FILTER_SANITIZE_STRING)));
            $unitprice = filter_input(INPUT_POST, 'unitprice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $koefficient = filter_input(INPUT_POST, 'koefficient', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $idQ = filter_var($_SESSION['idQ'],FILTER_SANITIZE_NUMBER_INT);

            // Instancier la class quote_details
            $quotedetail = new Quote_details();
            $quotedetail->setDesignation($designation);
            $quotedetail->setAmount($amount);
            $quotedetail->setUnit($unit);
            $quotedetail->setUnitprice($unitprice);
            $quotedetail->setKoefficient($koefficient);
            $totaluwt = $unitprice * $koefficient * $amount;
            $quotedetail->setTotaluwt($totaluwt);
            $quotedetail->setIdQd($_SESSION['idQd']);
            $quotedetail->updateQuotedetails();
            $total = $quotedetail->calculateSumColone($idQ);
            $somme = $total->fetchColumn();

            // Istancier la class devis pour mettre à jour les données
            $quotation = new Quotation();
            $req = $quotation->recupQuotationdetails($idQ);
            $donnee = $req->fetch();
            $vat = $somme * ($donnee['vatrate'] / 100);
            $totalttc = $somme + $vat;
            $quotation->setTotalwt($somme);
            $quotation->setVat($vat);
            $quotation->setTotalttc($vat + $somme);
            $quotation->setIdQ($idQ);
            $quotation->updateQuotation();


            // Destruction de la variable session
            unset($_SESSION['idQd'], $_SESSION['designation'], $_SESSION['amount'], $_SESSION['unit']
                , $_SESSION['unitprice'], $_SESSION['koefficient']);
        }
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veillez selectionner un article avant !</i> ';
    }/*----------------------------------------- End update details of a quote (2) -----------------------------------*/

}/*-------------------------------------------- Delete details of a quote (3) ------------------------------------------
 * Tester si le formulaire de delete existe avec le bouton valider de la page ajout details devis.
 * Tester l'existance de toutes les variables .
 * Tester si ces variables ne sont pas vides.
 * Filtrer toutes les variables.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_POST) && isset($_POST['btnQuoteDetailDelete']) && isset($_POST['designation']) && isset($_POST['unit'])
    && isset($_POST['amount']) && isset($_POST['unitprice']) && isset($_POST['koefficient'])) {
    if (isset($_SESSION['idQd']) && isset($_SESSION['idQ'])) {
        if (ctype_space($_POST['designation']) or ctype_space($_POST['unit']) or ctype_space($_POST['amount'])
            or ctype_space($_POST['unitprice']) or ctype_space($_POST['koefficient']) or ctype_space($_SESSION['idQ'])){
            echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veuillez vérifier les données saisies !</i> ';
        } else {
            $designation = ucfirst(trim(filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_STRING)));
            $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $unit = ucfirst(trim(filter_input(INPUT_POST, 'unit', FILTER_SANITIZE_STRING)));
            $unitprice = filter_input(INPUT_POST, 'unitprice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $koefficient = filter_input(INPUT_POST, 'koefficient', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $idQ = filter_var($_SESSION['idQ'],FILTER_SANITIZE_NUMBER_INT);

            // Suppresion du detail
            $quotedetail = new Quote_details();
            $quotedetail->setIdQd($_SESSION['idQd']);
            $quotedetail->deleteQuotedetails();
            $total = $quotedetail->calculateSumColone($idQ);
            $somme = $total->fetchColumn();

            // Istancier la class devis pour mettre à jour les données
            $quotation = new Quotation();
            $req = $quotation->recupQuotationdetails($idQ);
            $donnee = $req->fetch();
            $vat = $somme * ($donnee['vatrate'] / 100);
            $totalttc = $somme + $vat;
            $quotation->setTotalwt($somme);
            $quotation->setVat($vat);
            $quotation->setTotalttc($vat + $somme);
            $quotation->setIdQ($idQ);
            $quotation->updateQuotation();

            // Destruction de la variable session
            unset($_SESSION['idQd'], $_SESSION['designation'], $_SESSION['amount'], $_SESSION['unit']
                , $_SESSION['unitprice'], $_SESSION['koefficient']);
        }
    } else {
        echo '<i style="color:#85171f;font-size:30px;font-family:calibri ;">Veillez selectionner un article avant !</i> ';
    }/*-------------------------------------------- End delete details of a quote (3) --------------------------------*/

}/*-------------------------------------- Before editing or deleting an article (4) ------------------------------------
 * Tester si le formulaire demande details existe.
 * Vérification si les données du devis existent.
 * Les declarer en variables de session avec filtrage.
 * Retour à la page précedente.
 *--------------------------------------------------------------------------------------------------------------------*/
elseif (!empty($_GET) && isset($_GET['idDetailQuote'])) {
    if (isset($_GET['designation']) && isset($_GET['unit'])
        && isset($_GET['amount']) && isset($_GET['unitprice']) && isset($_GET['koefficient'])) {

        $_SESSION['idQd'] = filter_input(INPUT_GET, 'idDetailQuote', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['designation'] = ucfirst(trim(filter_input(INPUT_GET, 'designation', FILTER_SANITIZE_STRING)));
        $_SESSION['amount'] = filter_input(INPUT_GET, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $_SESSION['unit'] = ucfirst(trim(filter_input(INPUT_GET, 'unit', FILTER_SANITIZE_STRING)));
        $_SESSION['unitprice'] = filter_input(INPUT_GET, 'unitprice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $_SESSION['koefficient'] = filter_input(INPUT_GET, 'koefficient', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $_SESSION['totaluwt'] = filter_input(INPUT_GET, 'totaluwt', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $_SESSION['quotation_id'] = filter_input(INPUT_GET, 'quotation_id', FILTER_SANITIZE_NUMBER_INT);
        header("Location: $_SERVER[HTTP_REFERER]");
    }/*------------------------------------- End before editing or deleting an article (4) ---------------------------*/
}