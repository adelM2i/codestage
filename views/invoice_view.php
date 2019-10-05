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
    <h1 align="center" class="title" style="font-size: 20pt; padding-bottom: 5px">Gestion de Factures</h1>
    <div class="page"
         style="padding: 0 15px; background-color: #b9def0 ; border-radius: 10px 10px 10px 10px;">
        <form action="" method="post">
            <span><a href="#impression" class="scroll"><h4 class="lnr lnr-arrow-down-circle">Impression</h4></a></span>
            <br>
            <p align="center"><U>Données recuperées pour valider la Facture</U></p>
            <div class="row">
                <div class="col-sm-4">
                    <label class="text-left" for="SiteId">Id Chantier :
                        <?php if (isset($_SESSION['identity_site'])) echo " ", $_SESSION['identity_site']; ?>
                    </label>
                </div>
                <div class="col-sm-4">
                    <label class="text-center" for="Quotationnumber">Référence devis :
                        <?php if (isset($_SESSION['quote_reference'])) echo " ", $_SESSION['quote_reference']; ?>
                    </label>
                </div>
                <div class="col-sm-4">
                    <label class="text-right" for="Customernumber">Référence client :
                        <?php if (isset($_SESSION['client_reference'])) echo " ", $_SESSION['client_reference']; ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <label class="text-center" for="Vat rate">Taux de TVA :
                        <?php if (isset($_SESSION['VAT_rate'])) echo $_SESSION['VAT_rate']; ?>
                    </label>
                </div>
                <div class="col-sm-4">
                    <label class="text-right" for="Total TTC">Montant initial :
                        <?php if (isset($_SESSION['initial_amount'])) echo $_SESSION['initial_amount']; ?>
                    </label>
                </div>
            </div>
            <hr/>
            <p align="center"><U>Pour la modification il faut avoir appraitre l'ident et la référence de facture</U></p>
            <div class="row">
                <div class="col-sm-4"><label for="Message">Votre petit mot pour le client :</label></div>
                <div class="col-sm-4"><label for="Message">Ident facture :
                        <?php if (isset($_SESSION['invoice_identifier'])) echo $_SESSION['invoice_identifier']; ?>
                    </label></div>
                <div class="col-sm-4">
                    <label for="Message">Rérérence facture :
                        <?php if (isset($_SESSION['invoice_reference'])) echo $_SESSION['invoice_reference']; ?>
                    </label>
                </div>
                <div>
                    <input class="form-control" name="message" placeholder="En votre aimable règlement...." required
                           value="<?php if (isset($_SESSION['invoice_message'])) echo $_SESSION['invoice_message']; ?>"/>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-1 mb-1"></div>
                    <div class="col-md-4 mb-4">
                        <button name="btnInvoiceInsert" type="submit" class="btn btn-primary btn-yellow" value="insert"
                                style="width: 100%;"><B>Confirmer votre message de facture</B>
                        </button>
                    </div>
                    <div class="col-md-2 mb-2"></div>
                    <div class="col-md-4 mb-4">
                        <button name="btnInvoiceUpdate" type="submit" class="btn btn-primary btn-yellow" value="update"
                                style="width: 100%;"><B>Modifier le message de la facture</B>
                        </button>
                    </div>
                    <div class="col-md-1 mb-1"></div>
                </div>
                <br/>
            </div>
        </form>
    </div>
    <br/>
</div>
<!--======== End deposit insert ============-->
<!--======== deposit details liste =========-->
<div class="hidden-print container">
    <h2 align="center">Liste de dix dernières factures</h2>
    <marquee scrollamount="9" id='messagedefilent' style="background: #b9def0">
        <I><U><B>Note :</B></U> Pour mettre à jour la facture cliquer sur le bouton référence facture.
            La facture detaillé est page impression en dessous </I>
    </marquee>
    <table class="table table-striped table-bordered">
        <tr class='bg-color'>
            <th scope='col'>Ident</th>
            <th scope='col'>Réf. Facture</th>
            <th scope='col'>Chanier</th>
            <th scope='col'>Date de creation</th>
            <th scope='col'>Total HT</th>
            <th scope='col'>TVA</th>
            <th scope='col'>Total TTC</th>
            <th colspan="4" scope='col'>Chiffrage - Selectionner - Paiement - Supprimer</th>
        </tr>
        <?php
        // Instance of invoice class
        $invoice = new Invoices();
        $invoiceListe = $invoice->getAllInvoices();
        // Loop display all invoice
        while ($donnee = $invoiceListe->fetch()) {
            ?>
            <tr>
                <td>  <?php echo $donnee['idI']; ?>                   </td>
                <td align="center">
                    <a class="btn btn-info btn-sm"
                       href='index.php?page=invoice&Idinvoice=<?php echo $donnee['idI']; ?>&invoicenumber=<?php echo $donnee['invoicenumber'] ?>&idsite=<?php echo $donnee['site_id'] ?>'>
                        <span class="glyphicon glyphicon-refresh"></span> <?php echo $donnee['invoicenumber']; ?></a></td>
                <td>  <?php echo $donnee['site_id']; ?>               </td>
                <td>  <?php echo $donnee['date']; ?>                  </td>
                <td>  <?php echo $donnee['totalwt'], " €"; ?>         </td>
                <td>  <?php echo $donnee['vat'], " €"; ?>             </td>
                <td><B><?php echo $donnee['totalttc'], " €"; ?>   </B></td>
                <td align="center">
                    <a class="btn btn-info btn-sm"
                       href='index.php?page=invoice&Insertinvoicedetails=<?php echo $donnee['idI']; ?>&invoicenumber=<?php echo $donnee['invoicenumber'] ?>&idsite=<?php echo $donnee['site_id'] ?>'>
                        Chiffrage
                    </a>
                </td>
                <td align="center">
                    <a class="btn btn-info btn-sm"
                       href='index.php?page=invoice&Selectinvoice=<?php echo $donnee['idI']; ?>&invoicenumber=<?php echo $donnee['invoicenumber'] ?>&idsite=<?php echo $donnee['site_id'] ?>'>
                        <span class="lnr lnr-pointer-left"></span>
                    </a>
                </td>
                <td align="center">
                    <a class="btn btn-info btn-sm"
                       href='index.php?page=invoice&Cashinvoice=<?php echo $donnee['idI']; ?>&invoicenumber=<?php echo $donnee['invoicenumber'] ?>&totalwt=<?php echo $donnee['totalwt'] ?>&idsite=<?php echo $donnee['site_id'] ?>'>
                        Banck
                    </a>
                </td>
                <td align="center">
                    <a class="btn btn-danger btn-sm"
                       href='index.php?page=invoice&Deleteinvoice=<?php echo $donnee['idI']; ?>&invoicenumber=<?php echo $donnee['invoicenumber'] ?>&idsite=<?php echo $donnee['site_id'] ?>'>
                        <span class="lnr lnr-trash"></span>
                    </a
                </td>
            </tr>
        <?php }
        ?>
    </table>
    <br>
</div>
<!--========== end deposit liste ======-->
<!--======== Print deposit and details =========-->
<div id="impression" class="container">
    <div class="row" style="padding: 0 15px; background-color: #b9def0; border-radius: 10px 10px 10px 10px;">
        <FONT face="Aller">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="page">
                    <div class="row"><br>
                        <div class="card text-center">
                            <div class="col-xs-4">
                                <B class="card-title">MYELEC</B><br>
                                <span class="card-text">11 Villa Saint Ange</span>
                                <span class="card-text"> 75017 Paris</span><br>
                                <span class="card-text">Tél : (33) 6 61 77 27 23 </span>
                                <span class="card-text">cheklamslimane@gmail.com</span>
                            </div>
                            <div class="col-xs-6">
                                <img src="<?= PATH ?>assets/images/logo-societe1.png" class="rounded">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Récupération la référence du devis , la référence du client et la date de chiffrage -->
                    <div id="block1" class="col-xs-6" align="center">
                        <h3 class="title" style="">Facture N° :
                            <B><?php if (isset($_SESSION['bill_of_invoice'])) echo " ", $_SESSION['bill_of_invoice']; ?> </B>
                        </h3>
                        <h4 class="title" style="">Devis N° :
                            <B><?php if (isset($_SESSION['quote_number'])) echo " ", $_SESSION['quote_number']; ?> </B>
                        </h4>
                        <h4 class="title" style="">Client N° :
                            <B><?php if (isset($_SESSION['customer_number'])) echo " ", $_SESSION['customer_number']; ?>
                                <br>
                                Paris le : <?php echo date("d-m-Y"); ?>
                            </B>
                        </h4>
                    </div>
                    <div id="block2" class="col-xs-6" align="center">
                        <!-- Récupération l'identité de client et son adresse -->

                        <h3 class="title" style="">
                            <B><?php if (isset($_SESSION['society'])) echo " ", $_SESSION['society']; ?></B>
                        </h3>
                        <h4 class="title" style="">A l’attention de
                            <?php if (isset($_SESSION['sexe'])) echo " ", $_SESSION['sexe'], " "; ?>
                            <?php if (isset($_SESSION['name'])) echo " ", $_SESSION['name'], " "; ?>
                            <?php if (isset($_SESSION['firstname'])) echo " ", $_SESSION['firstname']; ?><br>
                            <p><B><?php if (isset($_SESSION['way'])) echo " ", $_SESSION['way'], " "; ?><br>
                                    <?php if (isset($_SESSION['postalcode'])) echo " ", $_SESSION['postalcode'], " "; ?>
                                    <?php if (isset($_SESSION['city'])) echo " ", $_SESSION['city']; ?></B></p>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <!-- Récupération l'objet de travaux -->
                    <h4 class="title"><B>Object
                            :</B><?php if (isset($_SESSION['objet'])) echo " ", $_SESSION['objet']; ?>
                    </h4>
                </div>
                <div class="row">
                    <table class="table table-striped table-bordered">
                        <tr class='bg-color'>
                            <th scope='col'>Désignation</th>
                            <th scope='col'>Unité</th>
                            <th scope='col'>Quantité</th>
                            <th scope='col'>Effectué</th>
                            <th scope='col'>Total U.HT</th>
                            <th scope='col'>Total Facturé</th>
                        </tr>
                        <!----------- Boucle affichage tout les details de acoompte ------------>
                        <?php
                        // Instance of deposit_details class
                        $invoicedetails = new Invoices_details();
                        $invoicedetailListe = $invoicedetails->getAllInvoice_Details($_SESSION['idinvoice']);
                        // Loop display all invoicedetails
                        while ($donnee = $invoicedetailListe->fetch()) {
                            ?>
                            <tr>
                                <td>  <?php echo $donnee['designation']; ?>    </td>
                                <td>  <?php echo $donnee['unit']; ?>           </td>
                                <td>  <?php echo $donnee['amount']; ?>         </td>
                                <td>  <?php echo $donnee['percentage'], " %"; ?></td>
                                <td><B><?php echo $donnee['totaluwt'], " €"; ?></B></td>
                                <td>  <?php echo $donnee['equivalent'], " €"; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <div class="col-xs-6 form-group well"><!-- Récupération de message didié au client -->
                        <h5><i><?php if (isset($_SESSION['invoice_message'])) echo " ", $_SESSION['invoice_message']; ?></i></h5>
                    </div>
                    <div class="col-xs-6">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td><h5>Montant Initial HT :</h5></td>
                                <td><h5><?php echo $_SESSION['initialtotalttc'], " €"; ?></h5></td>
                                <td><h5>Taux TVA :</h5></td>
                                <td><h5><?php echo $_SESSION['vatrate'], " %"; ?></h5></td>
                            </tr>
                            <tr>
                                <td colspan="2"><h4>Total recus HT :</h4></td>
                                <td colspan="2"><h4><?php echo $_SESSION['received_deposit'], " €"; ?></h4></td>
                            </tr>
                            <tr>
                                <td colspan="2"><h4>Total HT :</h4></td>
                                <td colspan="2"><h4><?php echo $_SESSION['invoice_hortva'], " €"; ?></h4></td>
                            </tr>
                            <tr>
                                <td colspan="2"><h4>TVA :</h4></td>
                                <td colspan="2"><h4><?php echo $_SESSION['invoice_totalvat'], " €"; ?></h4></td>
                            </tr>
                            <tr>
                                <td colspan="2"><h4><B>Total TTC à payer :</B></h4></td>
                                <td colspan="2"><h4><B><?php echo $_SESSION['vat_invoice'], " €"; ?></B></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-xs-offset-8">
                    <h3>Date et signature :</h3><br><br>
                </div>
            </div>
            <div class="row">
                <div class="hidden-print col-xs-12 col-md-12 form-group">
                    <span><a OnClick="window.print()" class="scroll"><h3 class="lnr lnr-printer"></h3></a></span>
                </div>
            </div>
            <div class="row">
                <div class="pied text-center">
                    <hr/>
                    <p class="card-text">MYELEC : 11 Villa Saint Ange 75017 Paris</p>
                    <p> N° SIREN : 833.163.595 RCS PARIS</p>
                </div>
            </div>
        </FONT>
    </div>
</div>
<!--======== End print deposit and details =========-->
<!--============ footer =========-->
<?php include_once 'views/includes/footer_admin.php' ?>
<!--======== end footer =========-->
</body>
</html>