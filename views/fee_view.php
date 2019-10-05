<!DOCTYPE html>
<html>
<title><?= ucfirst($page) ?></title>
<!--======== head =========-->
<?php include_once 'views/includes/head.php'; ?>

<body class="bg-light">
<!--======== header =========-->
<?php include_once 'views/includes/header_admin.php' ?>

<!--======== Insert Update Delete fee =========-->
<div class="container" style="padding: 0 15px; background-color: #d9d6b7; border-radius: 10px 10px 10px 10px;">
    <div class="py-5 text-center">
        <h2>Gestion de frais de chantiers</h2>
        <i class="lead"><small>Ajouter , modifier et supprimer frais</small></i>
    </div>
    <div align="center">
        <form action="" method="POST">
            <table><!-- Debut tableau de saisie -->
                <tr>
                    <th>Ident. Chantier :</th>
                    <td><?php if (isset($_SESSION['fee_idS'])) echo "", $_SESSION['fee_idS']; ?></i></label></td>
                    <th>Devis N° :</th>
                    <td><?php if (isset($_SESSION['fee_quotationnumber'])) echo "", $_SESSION['fee_quotationnumber']; ?></td>
                </tr>

                <tr>
                    <th>Montant TTC :</th>
                    <td><input type="number" step="any" name="amount" class="form-control" placeholder="0000.00 €"
                               required
                               value="<?php if (isset($_SESSION['fee_amount'])) echo $_SESSION['fee_amount']; ?>">
                    </td>
                    <th>Date de facture :</th>
                    <td><input type="text" name="date" class="form-control" id="exampleInputEmail3"
                               placeholder="02-03-2019" required
                               value="<?php if (isset($_SESSION['fee_date'])) echo $_SESSION['fee_date']; ?>">
                    </td>
                </tr>
                <tr>
                    <th>La nature :</th>
                    <td colspan="3"><input type="text" step="any" name="nature" class="form-control"
                                           placeholder="exp : transport" required
                                           value="<?php if (isset($_SESSION['fee_nature'])) echo $_SESSION['fee_nature']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="btn btn-success btn-block" type="submit" value="insert" name="btnFeeInsert">
                            <span class="lnr lnr-file-add"></span> Inserrer
                        </button>
                    </td>
                    <td>
                        <span>
                            <a href="#liste" class="scroll"><h4 align="center"
                                                                class="lnr lnr-arrow-down-circle">Liste</h4></a>
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-info btn-block" type="submit" value="update" name="btnFeeUpdate">
                            <span class="lnr lnr-pencil"></span> Modifier
                        </button>
                    </td>
                    <td></td>
                    <td>
                        <button class="btn btn-danger btn-block" type="submit" value="delete" name="btnFeeDelete">
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
<!--======== Fee liste =========-->
<div id="liste" class="container">
    <h2 align="center">Liste de tout les frais</h2>
    <table class="table table-striped table-bordered">
        <tr class='bg-color'>
            <th scope='col'>Ident</th>
            <th scope='col'>Libelle</th>
            <th scope='col'>Date</th>
            <th scope='col'>Total TTC</th>
            <th scope='col'>Chantier</th>
            <th scope='col'>Montant de chantier</th>
            <th scope='col'>Reste à payer</th>
            <th colspan="2" scope='col'>Action</th>
        </tr>
        <?php
        // Instance of fees class
        $fee = new Fees();
        $feeListe = $fee->getAllsiteFee();
        // Loop display all fees
        while ($donnee = $feeListe->fetch()) {
            ?>
            <tr align="center">
                <td>  <?php echo $donnee['idF']; ?>             </td>
                <td>  <?php echo $donnee['nature']; ?>          </td>
                <td>  <?php echo $donnee['date']; ?>            </td>
                <td><B><?php echo $donnee['amount']; ?>     </B></td>
                <td>  <?php echo $donnee['site_id']; ?>         </td>
                <td>  <?php echo $donnee['initialmonatant']; ?> </td>
                <td>  <?php echo $donnee['remainingbalance']; ?></td>
                <td align="center">
                    <a name="select" class="btn btn-info btn-sm"
                       href='index.php?page=fee&SelectFeeId=<?php echo $donnee['idF']; ?>
                       &nature=<?php echo $donnee['nature'] ?>&amount=<?php echo $donnee['amount'] ?>
                       &site_id=<?php echo $donnee['site_id'] ?>&date=<?php echo $donnee['date'] ?>'>
                        <span class="lnr lnr-pointer-left"></span>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br>
</div>
<!--======== End fee liste =========-->
</body>
</html>
<!--======== footer =========-->
<?php include_once 'views/includes/footer_admin.php' ?>
<!--======== end footer =========-->