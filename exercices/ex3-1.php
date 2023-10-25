<?php
/* propriétés d'une page web */
define('COMPANY_NAME', 'ClassicModels.com');

define('COMPANY_STREET_ADDRESS', '5340 St-Laurent');

define('COMPANY_CITY', 'Montréal');

define('COMPANY_PROVINCE', 'QC');

define('COMPANY_COUNTRY', 'Canada');

define('COMPANY_POSTAL_CODE', 'J0P 1T0');

define('COMPANY_NUMBER', '514-123-4567');

define('COMPANY_MAIL', 'info@scooterelectrique.com');
$lang = 'fr-CA';
$title = 'ClassicModels.com - Acceuil';
$description = 'Le plus vaste de choix de modèles réduits - Voitures - Camions - Avions - Motos et plus';
$author = 'Votre nom ici';
$icon = 'web_site_icon.jpg';
$content = 'bla bla bla bla bla ceci est le contenu de la page';

?>
<!DOCTYPE html>
<html lang=<?php $lang; ?>>

<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <meta name="DESCRIPTION" content=<?php echo $content; ?>>
    <meta name=<?php echo $author; ?> content=<?php echo $content; ?>>
    <!-- web site icon -->
    <LINK REL="icon" href=<?php echo $icon; ?>>

    <!--IMPORTANT pour responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>

    <!-- PAGE HEADER -->
    <header>
        <h2 style="background-color:black;color:white;padding:10px">
            <?php echo $title; ?>
        </h2>
    </header>

    <!-- BARRE DE NAVIGATION -->
    <nav style="background-color:gray;color:white;padding:10px">
        <a href='page.php'>Acceuil</a>
    </nav>

    <!-- CONTENT -->
    <?php echo $content; ?>

    <!-- FOOTER -->
    <footer style="background-color:black;color:white;padding:10px">
        Exercice par <?php echo $author; ?> &copy;
        <p><?php echo COMPANY_STREET_ADDRESS . " " . COMPANY_CITY . " " . COMPANY_PROVINCE . " " . COMPANY_COUNTRY . " " . COMPANY_POSTAL_CODE ?></p>
        <p><?php echo COMPANY_NUMBER . " " ?><a href="mailto:adadjisso.arnold@gmail.com" style="color: blue;"><?php echo COMPANY_MAIL ?></a></p>
    </footer>
    </div>
</body>

</html>