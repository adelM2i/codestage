<!DOCTYPE html>
<html>
<title><?= ucfirst($page) ?></title>
<!--======== head =========-->
<?php include_once('views/includes/head.php'); ?>
<body class="bg-light">
<!--======== header =========-->
<?php include_once 'views/includes/header_admin.php' ?>
<!--======== Quote details insert =========-->
<div class="container">
    <h1 align="center" class="title" style="font-size: 20pt; padding-bottom: 5px">Ajout détails pour la facture
        référencée ci-dessous </h1>
    <div class="page"
         style="padding: 0 15px; background-color: rgba(161,175,204,0.6); border-radius: 10px 10px 10px 10px;">
        <form action="" method="post">
            <br/>
            <div class="row">
                <div align="center" class="col-md-4 mb-3">
                    <label for="Identifiant">Identifiant chantier
                        :<?php if (isset($_SESSION['idsite'])) echo " ", $_SESSION['idsite']; ?></label>
                </div>
                <div align="center" class="col-md-4 mb-3">
                    <label for="Customernumber">Référence facture
                        :<?php if (isset($_SESSION['invoicenumber'])) echo " ", $_SESSION['invoicenumber']; ?></label>
                </div>
                <div align="center" class="col-md-4 mb-3">
                    <label for="Customernumber">Référence client
                        :<?php if (isset($_SESSION['customernumber'])) echo " ", $_SESSION['customernumber']; ?></label>
                </div>
                <hr/>
            </div>
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="Designation">Désignation</label>
                    <input type="text" name="designation" class="form-control" id="exampleInputEmail3"
                           placeholder="type de travaux"
                           value="<?php if (isset($_SESSION['designation'])) echo $_SESSION['designation']; ?>"
                           required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="Unite">Unité</label>
                    <input type="text" name="unit" class="form-control" id="exampleInputEmail3"
                           placeholder="m ,m² , H, ..."
                           value="<?php if (isset($_SESSION['unit'])) echo $_SESSION['unit']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 mb-3">
                    <label for="Amount">Quantité</label>
                    <input type="number" step="any" name="amount" class="form-control" id="exampleInputEmail3"
                           placeholder="00,00"
                           value="<?php if (isset($_SESSION['amount'])) echo $_SESSION['amount']; ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="Unit price">Prix unitaire</label>
                    <input type="number" step="any" name="unitprice" class="form-control" id="exampleInputEmail3"
                           placeholder="00,00 €"
                           value="<?php if (isset($_SESSION['unitprice'])) echo $_SESSION['unitprice']; ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="Unit price">Total chiffré</label>
                    <input type="number" step="any" name="totaluwt" class="form-control" id="exampleInputEmail3"
                           placeholder="00,00 €"
                           value="<?php if (isset($_SESSION['totaluwt'])) echo $_SESSION['totaluwt']; ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="koefficient">Pourcentage demandé</label>
                    <input type="number" step="any" name="percentage" class="form-control" id="exampleInputEmail3"
                           placeholder="exp : 20"
                           value="" required>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <button name="btninvoice_detail_Insert" type="submit" class="btn btn-success btn-yellow"
                            value="insert"
                            style="width: 100%;"><span class="lnr lnr-file-add"></span> Ajouter un article
                    </button>
                </div>
            </div>
            <br/>
        </form>
    </div>
    <br/>
</div>
<!--======== End quote details insert =========-->
<!--======== quote details liste =========-->
<div class="container">
    <h2 align="center">Les détails du devis
        :<?php if (isset($_SESSION['quotationnumber'])) echo " ", $_SESSION['quotationnumber']; ?> </h2>
    <table class="table table-striped table-bordered">
        <tr class='bg-color'>
            <th scope='col'>Ident</th>
            <th scope='col'>Désignation</th>
            <th scope='col'>Unité</th>
            <th scope='col'>Quantité</th>
            <th scope='col'>Prix unitaire</th>
            <th scope='col'>Koefficient</th>
            <th scope='col'>Total U.HT</th>
            <th colspan="2" scope='col'>Action</th>
        </tr>
        <!----------- Boucle affichage details devis ------------>
        <?php
        // Instance of quote_details class
        $quotedetails = new Quote_details();
        $quotedetailListe = $quotedetails->getAllQuotedetails($_SESSION['idQ']);
        // Loop display all quotedetails
        while ($donnee = $quotedetailListe->fetch()) {
            ?>
            <tr>
                <td>  <?php echo $donnee['idQd']; ?>       </td>
                <td>  <?php echo $donnee['designation']; ?></td>
                <td>  <?php echo $donnee['unit']; ?>       </td>
                <td>  <?php echo $donnee['amount']; ?>     </td>
                <td>  <?php echo $donnee['unitprice']; ?>  </td>
                <td>  <?php echo $donnee['koefficient']; ?></td>
                <td>  <?php echo $donnee['totaluwt']; ?>   </td>
                <td align="center">
                    <a class="btn btn-info btn-sm"
                       href='index.php?page=invoice_details&idDetailQuote=<?php echo $donnee['idQd']; ?>&designation=<?php echo $donnee['designation'] ?>
                    &unit=<?php echo $donnee['unit'] ?>&amount=<?php echo $donnee['amount'] ?>&unitprice=<?php echo $donnee['unitprice'] ?>
                    &koefficient=<?php echo $donnee['koefficient'] ?>&totaluwt=<?php echo $donnee['totaluwt'] ?>&quotation_id=<?php echo $donnee['quotation_id'] ?>'>Selectionner
                    </a>
                </td>
                </td></tr>
        <?php } ?>
    </table>
    <br>
</div>
<!--======== end quote details liste =========-->
<!--======== invoice details liste =========-->
<div class="container">
    <h2 align="center">Les détails de la facture
        :<?php if (isset($_SESSION['invoicenumber'])) echo " ", $_SESSION['invoicenumber']; ?> </h2>
    <table class="table table-striped table-bordered">
        <tr class='bg-color'>
            <th scope='col'>Ident</th>
            <th scope='col'>Désignation</th>
            <th scope='col'>Unité</th>
            <th scope='col'>Quantité</th>
            <th scope='col'>Total U.Initial</th>
            <th scope='col'>pourcetange</th>
            <th scope='col'>Total U.Facturé</th>
            <th colspan="2" scope='col'>Action</th>
        </tr>
        <!----------- Boucle affichage l'ajout de details pour la facture ------------>
        <?php
        // Instance of quote_details class
        $invoicedetail = new Invoices_details();
        $invoiceListe = $invoicedetail->getAllInvoice_Details($_SESSION['idI']);
        // Loop display all quotedetails
        while ($donnee = $invoiceListe->fetch()) {
            ?>
            <tr>
                <td>  <?php echo $donnee['idId']; ?>       </td>
                <td>  <?php echo $donnee['designation']; ?></td>
                <td>  <?php echo $donnee['unit']; ?>       </td>
                <td>  <?php echo $donnee['amount']; ?>     </td>
                <td>  <?php echo $donnee['totaluwt']; ?>  </td>
                <td>  <?php echo $donnee['percentage']; ?></td>
                <td>  <?php echo $donnee['equivalent']; ?>   </td>
                <td align="center">
                    <a class="btn btn-danger btn-sm"
                       href='index.php?page=invoice_details&idDeletedetailinvoice=<?php echo $donnee['idId']; ?>'>
                        <span class="lnr lnr-trash"></span>
                    </a>
                </td>
                </td></tr>
        <?php } ?>
    </table>
    <br>
</div>
</body>
</html>