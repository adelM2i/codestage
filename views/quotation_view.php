<!DOCTYPE html>
<html>
<title><?= ucfirst($page) ?></title>
<!--======== head =========-->
<?php include_once('views/includes/head.php'); ?>
<body class="bg-light">
<!--======== header =========-->
<?php include_once 'views/includes/header_admin.php' ?>
<!--======== quotation insert =========-->
<div class="hidden-print container">
    <h1 align="center" class="title" style="font-size: 20pt; padding-bottom: 5px">Gestion devis</h1>
    <div class="page"
         style="padding: 0 15px; background-color: #c4d7d9 ; border-radius: 10px 10px 10px 10px;">
        <form action="" method="post">
            <span><a href="#impression" class="scroll"><h4 class="lnr lnr-arrow-down-circle">Impression</h4></a></span>
            <br/>
            <div class="row">
                <div align="center" class="col-md-4 mb-3">
                    <label for="Customernumber">Id devis :
                        <mark><?php if (isset($_SESSION['idQuotation'])) echo " ", $_SESSION['idQuotation']; ?></mark>
                    </label>
                </div>
                <div align="center" class="col-md-6 mb-3">
                    <label for="Customernumber">Référence client :
                        <mark><?php if (isset($_SESSION['Customernumber'])) echo " ", $_SESSION['Customernumber']; ?></mark>
                    </label>
                </div>
                <hr/>
            </div>
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="Work object">Object de travaux</label>
                    <input type="text" name="workobject" class="form-control" id="exampleInputEmail3"
                           placeholder="object de travaux" required
                           value="<?php if (isset($_SESSION['editworkobject'])) echo $_SESSION['editworkobject']; ?>">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="Vat rate">Taux de TVA (%)</label>
                    <input type="number" name="vatrate" class="form-control" id="exampleInputEmail3"
                           placeholder="20" required
                           value="<?php if (isset($_SESSION['editvatrate'])) echo $_SESSION['editvatrate']; ?>">
                </div>
            </div>
            <br>
            <div class="row">
                <label for="Message">Votre petit mot pour le client :</label>
                <input class="form-control" rows="4" style="" size="50" maxlength="1000" required
                       name="message" id="invoice_footer_1"
                       value="<?php if (isset($_SESSION['editmessage'])) echo $_SESSION['editmessage']; ?>"
                       placeholder="En votre aimable règlement...."/>

            </div>
            <hr/>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <button name="btnQuotationInsert" type="submit" class="btn btn-primary btn-yellow" value="insert"
                            style="width: 100%;"><B>Confirmer ce devis</B>
                    </button>
                </div>
                <div class="col-md-6 mb-3">
                    <button name="btnQuotationUpdate" type="submit" class="btn btn-primary btn-yellow" value="update"
                            style="width: 100%;"><B>Modifier ce devis</B>
                    </button>
                </div>
            </div>
            <br/>
        </form>
    </div>
    <br/>
</div>
<!--======== End quotation insert ============-->
<!--======== quotation details liste =========-->
<div class="hidden-print container-fluid">
    <h2 align="center">Liste de devis</h2>
    <marquee scrollamount="9" id='messagedefilent' style="background: #c4d7d9">
        <I><U><B>Note :</B></U> Pour mettre à jour le devis cliquer sur le bouton référence devis.
            Le devis detaillé est page impression en dessous </I>
    </marquee>
    <table class="table table-striped table-bordered">
        <tr class='bg-color'>
            <th scope='col'>Ident</th>
            <th scope='col'>Réference devis</th>
            <th scope='col'>Ident client</th>
            <th scope='col'>Object travaux</th>
            <th scope='col'>Date de création</th>
            <th scope='col'>Total HT</th>
            <th scope='col'>TVA à 20%</th>
            <th scope='col'>Total TTC</th>
            <th colspan="3" scope='col'>Action</th>
        </tr>
        <?php
        // Instance of quotation class
        $quotation = new Quotation();
        $quotationListe = $quotation->getAllquotation();
        // Loop display all quotation
        while ($donnee = $quotationListe->fetch()) {
            ?>
            <tr>
                <td>  <?php echo $donnee['idQ']; ?>                  </td>
                <td align="center">
                    <a class="btn btn-info btn-sm"
                       href='index.php?page=quotation&Idquotation=<?php echo $donnee['idQ']; ?>&quotationnumber=<?php echo $donnee['quotationnumber'] ?>&customernumber=<?php echo $donnee['customernumber'] ?>'>
                        <span class="glyphicon glyphicon-refresh"></span> <?php echo $donnee['quotationnumber']; ?> </a>
                </td>
                <td>  <?php echo $donnee['customernumber']; ?>        </td>
                <td>  <?php echo $donnee['workobject']; ?>            </td>
                <td>  <?php echo $donnee['date']; ?>                  </td>
                <td>  <?php echo $donnee['totalwt'], " €"; ?>         </td>
                <td>  <?php echo $donnee['vat'], " €"; ?>             </td>
                <td>  <?php echo $donnee['totalttc'], " €"; ?>        </td>
                <td align="center">
                    <a class="btn btn-info btn-sm"
                       href='index.php?page=quotation&Insertdetails=<?php echo $donnee['idQ']; ?>&customernumber=<?php echo $donnee['customernumber'] ?>&quotationnumber=<?php echo $donnee['quotationnumber'] ?>'>
                        Chiffrage
                    </a>
                </td>
                <td align="center">
                    <a class="btn btn-info btn-sm"
                       href='index.php?page=quotation&Selectquotation=<?php echo $donnee['idQ']; ?>&customernumber=<?php echo $donnee['customernumber'] ?>'>
                        <span class="lnr lnr-pointer-left"></span>
                    </a>
                </td>
                <td align="center">
                    <a class="btn btn-danger btn-sm"
                       href='index.php?page=quotation&Deletequote=<?php echo $donnee['idQ']; ?>'><span
                                class="lnr lnr-trash"></span>
                    </a
                </td>
            </tr>
        <?php }
        ?>
    </table>
    <br>
</div>
<!--========== end quotation liste ======-->
<!--======== Print quotation and details =========-->
<div id="impression" class="container">
    <div class="row" style="padding: 0 15px; background-color: #c4d7d9; border-radius: 10px 10px 10px 10px;">
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
                        <h3 class="title" style="">Devis N° :
                            <B><?php if (isset($_SESSION['quotationnumber'])) echo " ", $_SESSION['quotationnumber']; ?> </B>
                        </h3>
                        <h4 class="title" style="">Référence client :
                            <B><?php if (isset($_SESSION['customernumber'])) echo " ", $_SESSION['customernumber']; ?>
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
                            <th scope='col'>Prix unitaire</th>
                            <th scope='col'>Total U.HT</th>
                        </tr>
                        <!----------- Boucle affichage tout les details de devis ------------>
                        <?php
                        // Instance of quote_details class
                        $quotedetails = new Quote_details();
                        $quotedetailListe = $quotedetails->getAllQuotedetails($_SESSION['idQ']);
                        // Loop display all quotedetails
                        while ($donnee = $quotedetailListe->fetch()) {
                            ?>
                            <tr>
                                <td>  <?php echo $donnee['designation']; ?>    </td>
                                <td>  <?php echo $donnee['unit']; ?>           </td>
                                <td>  <?php echo $donnee['amount']; ?>         </td>
                                <td>  <?php echo $donnee['unitprice'], " €"; ?></td>
                                <td><B><?php echo $donnee['totaluwt'], " €"; ?></B></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td><h4>Total HT :</h4></td>
                                    <td><h4><?php echo $_SESSION['totalwt'], " €"; ?></h4></td>
                                </tr>
                                <tr>
                                    <td><h4>Total TVA :</h4></td>
                                    <td><h4><?php echo $_SESSION['vat'], " €"; ?></h4></td>
                                </tr>
                                <tr>
                                    <td><h4><B>Total TTC :</B></h4></td>
                                    <td><h4><B><?php echo $_SESSION['totalttc'], " €"; ?></B></h4></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Récupération de message didié au client -->
                    <div class="col-xs-12 form-group well">
                        <h5><i><?php if (isset($_SESSION['message'])) echo " ", $_SESSION['message']; ?></i></h5>
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
<!--======== End print quotation and details =========-->
<!--============ footer =========-->
<?php include_once 'views/includes/footer_admin.php' ?>
<!--======== end footer =========-->
</body>
</html>