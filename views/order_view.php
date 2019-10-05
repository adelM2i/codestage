<!DOCTYPE html>
<html>
<title><?= ucfirst($page) ?></title>
<!--======== head =========-->
<?php include_once 'views/includes/head.php'; ?>

<body class="bg-light">
<!--======== header =========-->
<?php include_once 'views/includes/header_admin.php' ?>

<!--======== Insert Update Delete order =========-->
<div class="container" style="padding: 0 15px; background-color: #bad9cc; border-radius: 10px 10px 10px 10px;">
    <div class="py-5 text-center">
        <h2>Gestion de commandes materiels</h2>
        <i class="lead"><small>Ajouter , modifier et supprimer commande</small></i>
        <marquee scrollamount="9" id='messagedefilent' style="background: #b9d8cb">
            <I><U><B>Note :</B></U> Avant de commencer l'insertion de la commande, il faut s'assurer
                que le fournisseur figure dans liste page fournisseurs ,si non il faut l'enregistrer avant ! </I>
        </marquee>
    </div>
    <div align="center">
        <form action="" method="POST">
            <table><!-- Debut tableau de saisie -->
                <tr>
                    <th>Ident. Chantier :</th>
                    <td><mark><?php if (isset($_SESSION['identity_site'])) echo "", $_SESSION['identity_site']; ?></mark></td>
                    <th>Devis N° :</th>
                    <td><mark><?php if (isset($_SESSION['quote_reference'])) echo "", $_SESSION['quote_reference']; ?></mark></td>
                </tr>
                <tr>
                    <th>Choisir le fournisseur :</th>
                    <td>
                        <select name="provider">
                            <?php
                            $provider = new Providers();
                            $prviderListe = $provider->getAllProviders();
                            while ($donnee = $prviderListe->fetch()) {
                                ?>
                                <option value="<?php echo $donnee['idP']; ?>"><?php echo "Fournisseur N° : ", $donnee['idP'], " -", $donnee['society']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Numéro de facture :</th>
                    <td><input type="number" name="ordernumber" class="form-control"
                               placeholder="exp : 54210" required
                               value="<?php if (isset($_SESSION['order_reference'])) echo $_SESSION['order_reference']; ?>">
                    </td>
                    <th>Date de facture :</th>
                    <td><input type="text" name="date" class="form-control" id="exampleInputEmail3"
                               placeholder="02-03-2019" required
                               value="<?php if (isset($_SESSION['order_date'])) echo $_SESSION['order_date']; ?>">
                    </td>
                </tr>
                <tr>
                    <th>Monatnt HT :</th>
                    <td><input type="number" step="any" name="totalwt" class="form-control"
                               placeholder="0000.00 €" required
                               value="<?php if (isset($_SESSION['order_totalwt'])) echo $_SESSION['order_totalwt']; ?>">
                    </td>
                    <th>Montant TTC :</th>
                    <td><input type="number" step="any" name="totalttc" class="form-control"
                               placeholder="0000.00 €" required
                               value="<?php if (isset($_SESSION['order_totalttc'])) echo $_SESSION['order_totalttc']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="btn btn-success btn-block" type="submit" value="insert" name="btnOrderInsert">
                            <span class="lnr lnr-file-add"></span> Inserrer
                        </button>
                    </td>
                    <td>
                        <span><a href="#liste" class="scroll"><h4 align="center" class="lnr lnr-arrow-down-circle">Liste</h4></a></span>
                    </td>
                    <td>
                        <button class="btn btn-info btn-block" type="submit" value="update" name="btnOrderUpdate">
                            <span class="lnr lnr-pencil"></span> Modifier
                        </button>
                    </td>
                    <td></td>
                    <td>
                        <button class="btn btn-danger btn-block" type="submit" value="delete" name="btnOrderDelete">
                            <span class="glyphicon glyphicon-trash"></span> Supprimer
                        </button>
                    </td>
                </tr>
            </table><!-- Fin tableau de saisie -->
            <br>
        </form>
    </div>
</div>
<br>
<!--======== End Insert Update Delete order =========-->
<!--======== order liste =========-->
<div id="liste" class="container">
    <h2 align="center">Liste de toutes les commandes</h2>
    <table class="table table-striped table-bordered">
        <tr class='bg-color'>
            <th scope='col'>Ident</th>
            <th scope='col'>Réference</th>
            <th scope='col'>Date</th>
            <th scope='col'>Total HT</th>
            <th scope='col'>Total TTC</th>
            <th scope='col'>Chantier</th>
            <th scope='col'>Fournisseur</th>
            <th scope='col'>Email</th>
            <th scope='col'>N° Tel</th>
            <th colspan="2" scope='col'>Action</th>
        </tr>
        <?php
        // Instance of orders class
        $order = new Orders();
        $orderListe = $order->getAllsiteOrders();
        // Loop display all orders
        while ($donnee = $orderListe->fetch()) {
            ?>
            <tr>
                <td>  <?php echo $donnee['idO']; ?>        </td>
                <td>  <?php echo $donnee['ordernumber']; ?></td>
                <td>  <?php echo $donnee['date']; ?></td>
                <td>  <?php echo $donnee['totalwt']; ?>    </td>
                <td>  <?php echo $donnee['totalttc']; ?>   </td>
                <td>  <?php echo $donnee['site_id']; ?>    </td>
                <td>  <?php echo $donnee['society']; ?>    </td>
                <td>  <?php echo $donnee['email']; ?>      </td>
                <td>  <?php echo $donnee['phone']; ?>      </td>
                <td align="center">
                    <a name="select" class="btn btn-info btn-sm"
                       href='index.php?page=order&SelectOrderId=<?php echo $donnee['idO']; ?>&ordernumber=<?php echo $donnee['ordernumber'] ?>
                       &totalwt=<?php echo $donnee['totalwt'] ?>&totalttc=<?php echo $donnee['totalttc'] ?>
                       &site_id=<?php echo $donnee['site_id'] ?>&date=<?php echo $donnee['date'] ?>'>
                        <span class="lnr lnr-pointer-left"></span>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br>
</div>
<!--======== end customer liste =========-->
</body>
</html>
<!--======== footer =========-->
<?php include_once 'views/includes/footer_admin.php' ?>
<!--======== end footer =========-->