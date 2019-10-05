<!DOCTYPE html>
<html>
<title><?= ucfirst($page) ?></title>
<!--======== head =========-->
<?php include_once('views/includes/head.php'); ?>
<body class="bg-light">
<!--======== header =========-->
<?php include_once 'views/includes/header_admin.php' ?>
<!--======== deposit insert =========-->
<div class="hidden-print container">
    <h1 align="center" class="title" style="font-size: 20pt; padding-bottom: 5px">Gestion de paiements acomptes</h1>
    <div class="page"
         style="padding: 0 15px; background-color: #ebd9db; border-radius: 10px 10px 10px 10px;">
        <form action="" method="post">
            <br>
            <p align="center"><U>Données recuperées pour valider le paeiment</U></p>
            <div class="row">
                <div class="col-sm-4">
                    <label class="text-left" for="SiteId">Id Chantier :
                        <?php if (isset($_SESSION['identity_Site'])) echo " ", $_SESSION['identity_Site']; ?>
                    </label>
                </div>
                <div class="col-sm-4">
                    <label class="text-center" for="depositnumber">La Référence :
                        <?php if (isset($_SESSION['the_deposit_reference']) or isset($_SESSION['the_invoice_reference']))
                            echo " ", $_SESSION['the_deposit_reference'] , $_SESSION['the_invoice_reference'] ; ?>
                    </label>
                </div>
                <div class="col-sm-4">
                    <label class="text-right" for="totalttc">Le montant total HT :
                        <?php if (isset($_SESSION['deposit_totalwt']) or isset($_SESSION['invoice_totalwt']))
                            echo " ", $_SESSION['deposit_totalwt'] , $_SESSION['invoice_totalwt'] ;?>
                    </label>
                </div>
            </div>

            <hr/>
            <h4 align="center"><B>Note : </B>Une fois la confirmation faite il n'est plus possible de la modifier.
            </h4>
            <div class="row">

                <hr/>
                <div class="row">
                    <div class="col-md-1 mb-3"></div>
                    <div class="col-md-4 mb-3" align="center">
                        <label class="">Confirmer le paeiment</label>
                        <button name="btnValidatePayment" type="submit" class="btn btn-success btn-md"
                                value="insert"
                                style="width: 100%;"><B><span class="lnr lnr-file-add"></span> Valider</B>
                        </button>
                    </div>
                    <div class="col-md-2 mb-3">
                      <span><a href="#liste" class="scroll">
                              <h4 class="lnr lnr-arrow-down-circle">Liste de paiements</h4></a>
                      </span>
                    </div>
                    <div class="col-md-4 mb-3" align="center">
                        <label class="">Annuler le paeiment</label>
                        <button name="btnCancelPayment" type="submit" class="btn btn-info btn-md" value="cancel"
                                style="width: 100%;"><B>Annuler</B>
                        </button>
                    </div>
                    <div class="col-md-1 mb-3"></div>
                </div>
                <br/>
            </div>
        </form>
    </div>
    <br/>
</div>
<!--======== End deposit insert ============-->
<!--======== deposit details liste =========-->
<div id="liste" class="hidden-print container">
    <h2 align="center">Liste de Paeiments validés</h2>
    <table class="table table-striped table-bordered col-md-3">

        <tr>
            <th colspan="5" ></th>
            <th class='bg-color'>Chiffre d'affaires : </th>
            <?php
            // Instance of deposit class
            $payment = new Payment_validated();
            $turnover = $payment->SumTotalturnover();
            $total = $turnover->fetchColumn();
            ?>
            <th><?php echo $total," €" ?></th>
        </tr>
        <tr class='bg-color'>
            <th scope='col'>Ident P</th>
            <th scope='col'>Réf. Acc ou Fac</th>
            <th scope='col'>Total reçu</th>
            <th scope='col'>Date de creation</th>
            <th scope='col'>Chantier</th>
            <th scope='col'>Monatant intial</th>
            <th scope='col'>Reste à payer</th>
        </tr>
        <?php
        // Instance of deposit class
        $payment = new Payment_validated();
        $paymentListe = $payment->getAllSitePaymentvalidated();
        // Loop display all dposit
        while ($donnee = $paymentListe->fetch()) {
            ?>
            <tr>
                <td>  <?php echo $donnee['idPv']; ?>                   </td>
                <td>  <?php echo $donnee['reference']; ?>                   </td>
                <td>  <?php echo $donnee['total_turnover'], "€"; ?>               </td>
                <td>  <?php echo $donnee['date']; ?>                  </td>
                <td>  <?php echo $donnee['site_id']; ?>         </td>
                <td>  <?php echo $donnee['initialmonatant'], " €"; ?>             </td>
                <td>  <?php echo $donnee['remainingbalance'], " €"; ?>        </td>
            </tr>
        <?php }
        ?>
    </table>
    <br>
</div>
<!--========== end deposit liste ======-->

<!--============ footer =========-->
<?php include_once 'views/includes/footer_admin.php' ?>
<!--======== end footer =========-->
</body>
</html>