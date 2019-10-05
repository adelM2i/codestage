<!DOCTYPE html>
<html>
<title><?= ucfirst($page) ?></title>
<!--======== head =========-->
<?php include_once('views/includes/head.php'); ?>
<body class="bg-light">
<!--======== header =========-->
<?php include_once 'views/includes/header_admin.php' ?>
<!--======== Insert Sites =========-->
<section class="container">
    <h1 align="center" class="title" style="font-size: 20pt; padding-bottom: 5px">Gestion de chantier</h1>
    <div class="page"
         style="padding: 0 15px; background-color: rgba(201,201,191,0.71); border-radius: 10px 10px 10px 10px;">
        <form action="" method="post">
            <br/>
            <div class="row">
                <div class="col-md-offset-4">
                    <h5><i>Vous demarrez un nouveau chantier :</i></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 md-3">
                    <label for="quotationNumber">Référence devis :</label>
                </div>
                <div class="col-md-3 md-3">
                    <input type="number" step="any" name="quotationnumber" class="form-control" id="exampleInputEmail3"
                           placeholder="exp : 7500000"
                           value="<?php if (isset($_SESSION['quotationnumber'])) echo $_SESSION['quotationnumber']; ?>">
                </div>
                <div class="col-md-4 md-3"></div>
                <div class="col-md-3 md-3">
                    <button name="btnsiteInsert" type="submit" class="btn btn-success " value="insert"
                            style="width: 100%;"><span class="lnr lnr-file-add"></span> Valider
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="pied text-center">
                    <span><i><B>Veuillez saisir une référence devis valide.</B>
                    Toute ces référence sont listées sur la page devis.</i></span>
                    <span>
                        <a href="##liste" class="scroll"><h3 class="lnr lnr-arrow-down-circle">Liste de chantiers</h3></a>
                    </span>
                </div>
            </div>
    </div>
    <div class="page"
         style="padding: 0 15px; background-color: rgba(201,201,191,0.71); border-radius: 10px 10px 10px 10px;">
        <hr/>
        <div class="row">
            <div align="center" class="col-md-3 mb-4">
                <label for="Identifiant"><U>Ident chantier :</U>
                    <mark><?php if (isset($_SESSION['idS'])) echo " ", $_SESSION['idS']; ?></mark>
                </label>
            </div>
            <div align="center" class="col-md-4 mb-4">
                <label for="Quotationnumber"><U>Référence devis client :</U>
                    <mark><?php if (isset($_SESSION['quotationnumber'])) echo " ", $_SESSION['quotationnumber']; ?></mark>
                </label>
            </div>
            <div class="col-md-2 md-2"></div>
            <div class="col-md-2 mb-3">
                <button name="btnsiteUpdate" type="submit" class="btn btn-info " value="update"
                        style="width: 100%;"><span class="lnr lnr-pencil"></span> Modifier
                </button>
            </div>
            <div class="col-md-1 mb-2"></div>
            <div class="col-md-1 mb-2">
                <button name="btnsiteDelete" type="submit" class="btn btn-danger " value="delete"
                        style="width: 100%;"><span class="lnr lnr-trash"></span>
                </button>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6 col-lg-offset-2">
                <label for="Designation"><h5 align="center"><I>Ici , vous pouvez choisir ce que vous voulez gérer
                            pour ce chantier
                            référencé ci-dessus , ajouter et enregistrer , les commandes de matériels ,
                            les acomptes , les factures et les frais.
                        </I></h5>
                    <h4 align="center"><I><U><B>Note :</B></U> bien verifier si vous avez choisi la bonne référence
                            de devis. </I></h4>
                </label>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="index.php?page=deposit&idSiteDeposit=<?php echo $_SESSION['idS']; ?>&quotationnumber=<?php echo $_SESSION['quotationnumber']; ?>"
                   type="submit" class="btn btn-primary btn-yellow"
                   style="width: 100%;">Demande acompte
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="index.php?page=order&idSiteOrder=<?php echo $_SESSION['idS']; ?>&quotationnumber=<?php echo $_SESSION['quotationnumber']; ?>"
                   type="submit" class="btn btn-primary btn-yellow"
                   style="width: 100%;">Commande materiels
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="index.php?page=invoice&idSiteInvoice=<?php echo $_SESSION['idS']; ?>&quotationnumber=<?php echo $_SESSION['quotationnumber']; ?>"
                   type="submit" class="btn btn-primary btn-yellow"
                   style="width: 100%;">Facturation
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="index.php?page=fee&idSitefee=<?php echo $_SESSION['idS']; ?>&quotationnumber=<?php echo $_SESSION['quotationnumber']; ?>"
                   type="submit" class="btn btn-primary btn-yellow"
                   style="width: 100%;">Gestion de frais
                </a>
            </div>
        </div>
        <br/>
    </div>
</section>
<!--======== End choose action =========-->
<!--======== sites liste =========-->
<section id="#liste" class="container">
    <h2 align="center">Liste de chantiers</h2>
    <table class="table table-striped table-bordered">
        <tr class='bg-color'>
            <th scope='col'>Ident</th>
            <th scope='col'>Référence devis</th>
            <th scope='col'>Nature de travaux</th>
            <th scope='col'>Montant intial HT</th>
            <th scope='col'>Total acomptes HT</th>
            <th scope='col'>Solde restant HT</th>
            <th colspan="2">Action</th>
        </tr>
        <!----------- Boucle affichage l'ajout et la situation des chantiers ------------>
        <?php
        // Instance of sites class
        $site = new Sites();
        $siteListe = $site->getAllSites();
        // Loop display all quotedetails
        while ($donnee = $siteListe->fetch()) {
            ?>
            <tr>
                <td>  <?php echo $donnee['idS']; ?>                       </td>
                <td>  <?php echo $donnee['quotationnumber']; ?>           </td>
                <td>  <?php echo $donnee['workobject']; ?>                </td>
                <td><B><?php echo $donnee['initialmonatant'], " €"; ?></B></td>
                <td>  <?php echo $donnee['totalpayments'], " €"; ?>       </td>
                <td>  <?php echo $donnee['remainingbalance'], " €"; ?>    </td>
                <td align="center">
                    <a class="btn btn-info btn-sm"
                       href="index.php?page=site&SelectSiteId=<?php echo $donnee['idS']; ?>&quotationnumber=<?php echo $donnee['quotationnumber']; ?>">Selectionner</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br>
</section>
<!--======== End sites liste =========-->

</body>
</html>
<!--======== footer =========-->
<?php include_once 'views/includes/footer_admin.php' ?>
<!--======== end footer =========-->