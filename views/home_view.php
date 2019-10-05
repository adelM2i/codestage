<?php
unset($_SESSION['admin']);
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <!--======== head =========-->
    <?php include_once 'views/includes/head.php' ?>

    <title><?= ucfirst($page) ?></title>
</head>
<body>
<!--======== header =========-->
<?php include_once "views/includes/header.php"; ?>
<!--======== Acceuil = Home =========-->
<section class="intro">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>
                <h1 align="center">Bienvenue chez MYELEC</h1>
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <div class="intro-content text-center">
                            <h1>PRE-CABLAGE ELECTRIQUE</h1>
                            <p>Vous avez un projet de câblage arremoires electriques , changer un TGBT ou renover
                                votre installation electrique? Nous mettons toute notre expérience à votre service
                                pour étudier, concevoir et réaliser selon les normes tous vos travaux.</p>
                            <a class="btn btn-default" href="contact.php" role="button">Plus de
                                renseignements<i class="lnr lnr-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="intro-content text-center">
                            <h1>PRE-CABLAGE INFORMATIQUE</h1>
                            <p>Vous avez un projet de câblage informatique RJ45 ou fibre optique ? Nous mettons
                                toute notre expérience à votre service pour étudier, concevoir et réaliser selon
                                les règles de l'art votre câblage informatique RJ45 et fibre optique.</p>
                            <a class="btn btn-default" href="contact.php" role="button">Plus de
                                renseignements<i class="lnr lnr-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="intro-content text-center">
                            <h1>CONTROLE D’ACCES</h1>
                            <p>Toutes les entreprises aujourd'huit sont equipées d'un systeme pour contrôler
                                qui , Où, Quand et comment accéder dans les différentes zones de l'établissementest.
                                Avec notre experience ,nous somme à la hauteur pour telle installation</p>
                            <a class="btn btn-default" href="contact.php" role="button">Plus de
                                renseignements<i class="lnr lnr-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="intro-content text-center">
                            <h1>DETECTION INCENDIE</h1>
                            <p>Les réglementations et les normes relatives à la sécurité incendie sont établies en
                                fonction des différents types de bâtiments auxquels elles s'appliquent.Nous vous
                                accompagne pour l'installation de systemes securité incendie conforme aux normes.</p>
                            <a class="btn btn-default" href="contact.php" role="button">Plus de
                                renseignements<i class="lnr lnr-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="intro-content text-center">
                            <h1>ALARME D’INTRUSION</h1>
                            <p>L’efficacité d’une alarme intrusion dépend en grande partie de la qualité de son
                                installation.L’installation d’une alarme anti-intrusion exige aussi une phase de
                                paramétrage qui simplifiera par la suite l’utilisation du système au quotidien.</p>
                            <a class="btn btn-default" href="contact.php" role="button">Plus de
                                renseignements<i class="lnr lnr-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="intro-content text-center">
                            <h1>VIDEO SURVEILLANCE</h1>
                            <p>La video surveillance est un moyen très efficace pour lutter contre l'incécurité en
                                genérale.En fonction de vos besoins nous realisons l'installation en s'adaptent avec
                                le type de technologie designé par le cahier de charge (IP et / ou analogique).</p>
                            <a class="btn btn-default" href="contact.php" role="button">Plus de
                                renseignements<i class="lnr lnr-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== fin Acceuil = end Home  =========-->
<!--========  la façon de procéder = how to proceed =========-->
<section id="what-we-do" class="what-we-do">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                <p class="small-tag">Pour vos travaux</p>
                <h2 class="section-title">Comment on procede</h2>
                <div class="border"><span class="border-l-r"><i class="lnr lnr-diamond"></i></span></div>
                <p class="section-para">Lorem ipsum dolor sit amet, consectetuer adiping elit agrel. Donec odio.
                    Quisque volutpat mattis eros. Nullam malesuada urna nibh viverra non.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="do-box text-center">
                            <i class="lnr lnr-construction"></i>
                            <h3>Travaux d'électricité</h3>
                            <p>Lorem Ipsum adalah text contoh dikan didalam industri pencet typesetting. Apabila
                                pencetak yang
                                kurang terkenal mengambil sebuah galeri cetak dan merobak.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="do-box bg-color text-center">
                            <i class="lnr lnr-database"></i>
                            <h3>Cablage informatique</h3>
                            <p>Lorem Ipsum adalah text contoh dikan didalam industri pencet typesetting. Apabila
                                pencetak yang
                                kurang terkenal mengambil sebuah galeri cetak dan merobak.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="do-box text-center">
                            <i class="lnr lnr-leaf"></i>
                            <h3>Travaux divers</h3>
                            <p>Lorem Ipsum adalah text contoh dikan didalam industri pencet typesetting. Apabila
                                pencetak yang
                                kurang terkenal mengambil sebuah galeri cetak dan merobak.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== fin la façon de procéder = end how to proceed =========-->
<!--======== galerie =========-->
<section id="galerie" class="about-us">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-xs-12 p-l-r-0">
                <div id="about" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="<?= PATH ?>assets/images/galerie/image (1).jpg" width="100%" alt=""/>
                        </div>
                        <div class="item">
                            <img src="<?= PATH ?>assets/images/galerie/image (3).jpg" width="100%" alt=""/>
                        </div>
                        <div class="item">
                            <img src="<?= PATH ?>assets/images/galerie/image (4).jpg" width="100%" alt=""/>
                        </div>
                        <div class="item">
                            <img src="<?= PATH ?>assets/images/galerie/image (10).jpg" width="100%" alt=""/>
                        </div>
                        <div class="item">
                            <img src="<?= PATH ?>assets/images/galerie/image (12).jpg" width="100%" alt=""/>
                        </div>
                        <div class="item">
                            <img src="<?= PATH ?>assets/images/galerie/image (17).jpg" width="100%" alt=""/>
                        </div>
                        <div class="item">
                            <img src="<?= PATH ?>assets/images/galerie/image (8).jpg" width="100%" alt=""/>
                        </div>
                        <div class="item">
                            <img src="<?= PATH ?>assets/images/galerie/image (6).jpg" width="100%" alt=""/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="about-content">
                    <h2 class="section-title">Notre galerie</h2>
                    <p>Pour réaliser , rénover une installation électrique totale ou partielle pour une maison individuelle ,
                        un appartement , un local commercial ou des bureau, la pose d’armoires et de tableaux électriques,
                        de chauffage électrique, de domotique (interphone, automatismes, alarme, et autres), contrôle d’accès ,
                        réseau informatique ,tout travaux courant faible , la mise aux normes qui est nécessaire si
                        votre réseau est ancien ou si vos besoins électriques évoluent à la hausse.</p>
                    <p>Notre qualité de service et notre savoir-faire ont séduit des grandes entreprises .
                        Ils nous ont fait confiance pour des travaux complexes, d’autres pour l’entretien toute l’année.
                        Votre installation électrique ne doit pas être faite n’importe comment parce que votre confort
                        dépend énormément .il faudra confier cette tache à un professionnel talque Slim Électricité.
                        Notre société vous conseille et intervient pour tous travaux que vous lui confier.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== fin galerie = end galerie=========-->
<!--======== Nos services = our service =========-->
<section id="service" class="our-service">
    <div class="ccontainer">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                <p class="small-tag">What we offer</p>
                <h2 class="section-title">Nos Services</h2>
                <div class="border"><span class="border-l-r"><i class="lnr lnr-diamond"></i></span></div>
                <p class="section-para">Lorem ipsum dolor sit amet, consectetuer adiping elit agrel. Donec odio.
                    Quisque volutpat mattis eros. Nullam malesuada urna nibh viverra non.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="four-slide">
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/electricite (1).jpg">
                        <div class="service-overflow text-center">
                            <h3>Électricité</h3>
                            <p>En partant de la source d’alimentation principale,nous s’occuppons intégralement de
                                l’installation de l’ensemble du précâblage électrique.De la distribution aux postes
                                de travail en circuit normal et/ou circuit ondulé selon vos besoins, à la mise en œuvre
                                d’appareils et de commandes d’éclairage, en passant par la distribution de toutes les
                                alimentations électriques associées .Nouvelle installation, depannage et mise en
                                confirmité ,vous pouvez nous faire confiance</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/informatique (1).jpg">
                        <div class="service-overflow text-center">
                            <h3>Pré-cablage informatique</h3>
                            <p>Aujourd'huit avec l'évolution des équipements, le pré-cablage et câblage informatique
                                se doit lui aussi être évolutif. Facilement modifiable, Il doit permettre un débit
                                d'information toujours plus performant.Les équipements de distribution téléphonique ont
                                considérablement évolué durant les dernières années : le câblage qui leur est associé
                                est aujourd'hui similaire au câblage informatique.</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/c-acce (1).jpg">
                        <div class="service-overflow text-center">
                            <h3>Contrôle d'accès</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit agrel.
                                Donec odio. Quisque volutpat mattis eros. Rerat ut turpis.</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/intrusion (2).jpg">
                        <div class="service-overflow text-center">
                            <h3>Alarme d'intrusion</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit agrel.
                                Donec odio. Quisque volutpat mattis eros. Rerat ut turpis.</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/incendie (1).jpg">
                        <div class="service-overflow text-center">
                            <h3>Alarme d'incendie</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit agrel.
                                Donec odio. Quisque volutpat mattis eros. Rerat ut turpis.</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/video (1).jpg">
                        <div class="service-overflow text-center">
                            <h3>Vidéo surveillance</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit agrel.
                                Donec odio. Quisque volutpat mattis eros. Rerat ut turpis.</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/electricite (2).jpg">
                        <div class="service-overflow text-center">
                            <h3>Électricité</h3>
                            <p>En partant de la source d’alimentation principale,nous s’occuppons intégralement de
                                l’installation de l’ensemble du précâblage électrique.De la distribution aux postes
                                de travail en circuit normal et/ou circuit ondulé selon vos besoins, à la mise en œuvre
                                d’appareils et de commandes d’éclairage, en passant par la distribution de toutes les
                                alimentations électriques associées .Nouvelle installation, depannage et mise en
                                confirmité ,vous pouvez nous faire confiance</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/informatique (2).jpg">
                        <div class="service-overflow text-center">
                            <h3>Pré-cablage informatique</h3>
                            <p>Aujourd'huit avec l'évolution des équipements, le pré-cablage et câblage informatique
                                se doit lui aussi être évolutif. Facilement modifiable, Il doit permettre un débit
                                d'information toujours plus performant.Les équipements de distribution téléphonique ont
                                considérablement évolué durant les dernières années : le câblage qui leur est associé
                                est aujourd'hui similaire au câblage informatique.</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/c-acce (2).jpg">
                        <div class="service-overflow text-center">
                            <h3>Contrôle d'accès</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit agrel.
                                Donec odio. Quisque volutpat mattis eros. Rerat ut turpis.</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/intrusion (3).jpg">
                        <div class="service-overflow text-center">
                            <h3>Alarme d'intrusion</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit agrel.
                                Donec odio. Quisque volutpat mattis eros. Rerat ut turpis.</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/incendie (4).jpg">
                        <div class="service-overflow text-center">
                            <h3>Alarme d'incendie</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit agrel.
                                Donec odio. Quisque volutpat mattis eros. Rerat ut turpis.</p>
                        </div>
                    </div>
                    <div class="single-slide"><img src="<?= PATH ?>assets/images/services/video (3).jpg">
                        <div class="service-overflow text-center">
                            <h3>Vidéo surveillance</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit agrel.
                                Donec odio. Quisque volutpat mattis eros. Rerat ut turpis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--========  fin Nos services = end our services =========-->
<!--======== extra featrue =========-->
<section class="extra-feature">
    <div class="container">
        <div class="row" align="center">
            <h2 class="section-title">Besion de nos services</h2>
            <span>Mieux nous connaitre</span>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit agrel.
                Donec odio. Quisque volutpat mattis eros. Rerat ut turpis.</p>
            <a class="btn btn-default" href="contact.php" role="button">Clicer ici<i
                        class="lnr lnr-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
<!--======== end extra featrue =========-->
<!--======== Nos clients = Our clients =========-->
<section id="clients" class="our-experts">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-6 col-xs-12" align="center">
                <h2 class="section-title">Ils nous ont fait confiances</h2>
                <p> En travaillant avec nous vous gagnez de la qualité . Avec beaucoup d’expérience dans le domaine
                    depuis 2001 ,satisfaire nos clients c'est notre premier objectif. Nos services seront à la hauteur
                    de vos attentes.</p>
            </div>
            <div class="col-md-8">
                <div class="three-slide">
                    <div class="single-slide"><img class="img-circle"
                                                   src="<?= PATH ?>assets/images/clients/assistance.jpg"></div>
                    <div class="single-slide"><img class="img-circle"
                                                   src="<?= PATH ?>assets/images/clients/Generali.jpg"></div>
                    <div class="single-slide"><img class="img-circle" src="<?= PATH ?>assets/images/clients/Atkearney.jpg">
                    </div>
                    <div class="single-slide"><img class="img-circle" src="<?= PATH ?>assets/images/clients/mncap.png">
                    </div>
                    <div class="single-slide"><img class="img-circle" src="<?= PATH ?>assets/images/clients/pigier.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== fin Nos clients = end Our clients =========-->
<!--======== à propos = about =========-->
<section id="talk" class="talk-about-us">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-xs-12 text-center">
                <img src="<?= PATH ?>assets/images/logo-about.png">
                <p class="small-tag">Notre entreprise</p>
                <h2 class="section-title">A propos de l'entrprise</h2>
                <div class="border"><span class="border-l-r"><i class="fa fa-quote-right"></i></span></div>
                <div id="talk-about-us" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#talk-about-us" data-slide-to="0" class="active"></li>
                        <li data-target="#talk-about-us" data-slide-to="1"></li>
                        <li data-target="#talk-about-us" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <p>Installée à paris, l’entreprise est à votre disposition pour effectuer toutes les taches
                                électrique en basses tentions, pose, maintenance et rénovation d'installations
                                électriques.
                                Particuliers ou professionnels dans l'ile de France vous pouvez compter sur nous.
                            </p>
                        </div>
                        <div class="item">
                            <p>Lorem ipsum dolor sit amet reprehenderit, enim eiusmod high life
                                accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard
                                dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Haccusamus terry richardson ad
                                squid.
                                Penon cupidatat skateboard.</p>
                        </div>
                        <div class="item">
                            <p>Lorem ipsum dolor sit amet reprehenderit, enim eiusmod high life
                                accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard
                                dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Haccusamus terry richardson ad
                                squid.
                                Penon cupidatat skateboard.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== fin à propos = end about =========-->
<!--======== Nos marques =  our brands ========-->
<section class="our-client">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-md-12">
                <div class="six-slide bg-primary">
                    <div class="single-slide text-center">Schneider</div>
                    <div class="single-slide text-center">Legrand</div>
                    <div class="single-slide text-center">ABB</div>
                    <div class="single-slide text-center">Siemens</div>
                    <div class="single-slide text-center">Hager</div>
                    <div class="single-slide text-center">Nexans</div>
                    <div class="single-slide text-center">Socomec</div>
                    <div class="single-slide text-center">WAGO</div>
                    <div class="single-slide text-center">Hilti</div>
                    <div class="single-slide text-center">Makita</div>
                    <div class="single-slide text-center">CDVI</div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</section>
<!--======== fin nos marques = end our brands =========-->
<?php include_once 'views/includes/footer.php' ?>
</body>
</html>