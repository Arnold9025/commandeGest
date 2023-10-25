<?php
define('COMPANY_NAME', 'ManchesterUnited.com');

define('COMPANY_STREET_ADDRESS', '5340 St-Laurent');

define('COMPANY_CITY', 'Montréal');

define('COMPANY_PROVINCE', 'QC');

define('COMPANY_COUNTRY', 'Canada');

define('COMPANY_POSTAL_CODE', 'J0P 1T0');

define('COMPANY_NUMBER', '514-123-4567');

define('COMPANY_MAIL', 'info@manchesterunited.com');
$lang = 'fr-CA';
$title = 'manchesterUnited.com - Acceuil';
$description = 'Le plus vaste de choix de modèles réduits - Voitures - Camions - Avions - Motos et plus';
$author = 'Votre nom ici';
$icon = 'web_site_icon.jpg';
$content = '';
$count = '';
$products = [
    [
        'id' => 0,
        'name' => 'Red Jersey',
        'description' => 'Manchester United Home Jersey, red, sponsored by Chevrolet',
        'price' => 59.99,
        'pic' => 'red_jersey.jpg',
        'qty_in_stock' => 200,
    ],
    [
        'id' => 1,
        'name' => 'White Jersey',
        'description' => 'Manchester United Away Jersey, white, sponsored by Chevrolet',
        'price' => 49.99,
        'pic' => 'white_jersey.jpg',
        'qty_in_stock' => 133,
    ],
    [
        'id' => 2,
        'name' => 'Black Jersey',
        'description' => 'Manchester United Extra Jersey, black, sponsored by Chevrolet',
        'price' => 54.99,
        'pic' => 'black_jersey.jpg',
        'qty_in_stock' => 544,
    ],
    [
        'id' => 3,
        'name' => 'Blue Jacket',
        'description' => 'Blue Jacket for cold and raniy weather',
        'price' => 129.99,
        'pic' => 'blue_jacket.jpg',
        'qty_in_stock' => 14,
    ],
    [
        'id' => 4,
        'name' => 'Snapback Cap',
        'description' => 'Manchester United New Era Snapback Cap- Adult',
        'price' => 24.99,
        'pic' => 'cap.jpg',
        'qty_in_stock' => 655,
    ],
    [
        'id' => 5,
        'name' => 'Champion Flag',
        'description' => 'Manchester United Champions League Flag',
        'price' => 24.99,
        'pic' => 'champion_league_flag.jpg',
        'qty_in_stock' => 321,
    ],
];
function ViewCount($filename)
{
    $count = 0;

    if (!file_exists($filename)) {
        $count = 0;
    } else {
        $count = (int)file_get_contents($filename);
        $count++;
        file_put_contents($filename, $count);
    }
    return (int)file_get_contents($filename);
}
function productList(array $prod)
{
    $html = '';
    $html .= '<table>';
    $html .=  '<thead><tr>';
    foreach ($prod[0] as $un_nom_de_colonne => $une_valeur) {
        $html .= '<th>' . $un_nom_de_colonne . '</th>';
    }
    $html .= '</tr></thead>';
    $html .=  '<tbody>';

    foreach ($prod as $une_ligne) {
        $html .=  '<tr>';
        foreach ($une_ligne as $une_valeur) {
            $html .=  '<td>' . $une_valeur . '</td>';
        }
        $html .= '</tr>';
        $html .= '</tr>';
    }

    $html .=  '</tbody>';
    $html .= '</table>';
    return $html;
}
function productCatalog(array $prod)
{
    $html = '';
    foreach ($prod as $un_produit) {
        $html .= '<div class = "product">';
        $html .= '<img src="products_images/' . $un_produit['pic'] . '" alt="product picture">';
        $html .= '<p class = "name">' . $un_produit['name'] . '</p>';
        $html .= '<p class = "description">' . $un_produit['description'] . '</p>';
        $html .= '<p class = "price">' . $un_produit['price'] . '$</p>';
        $html .= '</div>';
    }
    return $html;
}
logVisitor();
if (isset($_GET['op'])) {
    $op = $_GET['op'];
    if ($op == 'ProductList') {
        $content = productList($products);
        $count = 'Views = ' . ViewCount('log/listCount.txt');
    } elseif ($op == 'ProductCatalog') {
        $content = productCatalog($products);
        $count = 'Views = ' . ViewCount('log/catalogCount.txt');
    }
} else {
    $content = 'Bienvenue chez' . COMPANY_NAME;
    $count = 'Views = ' . ViewCount('log/home.txt');
    logVisitor();
}

function logVisitor()
{
    $record = date(DATE_RFC822) . PHP_EOL;
    file_put_contents("log/visitors.log", $record, FILE_APPEND);
}
?>

<!DOCTYPE html>
<html lang=<?php $lang; ?>>

<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <meta name="DESCRIPTION">
    <meta name=<?php echo $author; ?>>
    <!-- web site icon -->
    <LINK REL="icon" href=<?php echo $icon; ?>>

    <!--IMPORTANT pour responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        th,
        td {
            border: 2px solid black;
        }

        /* product div */
        .product {
            width: 200px;
            height: 320px;
            overflow: auto;
            border: 1px solid black;
            text-align: center;
            display: inline-block;
            margin: 10px;
        }

        .product:hover {
            background-color: #c0c0c0;
        }

        /* product image */
        .product img {
            width: 100%;
        }

        /* product name */
        .product .name {
            font-size: 24px;
            margin: 0;
        }

        /* product description */
        .product .description {
            margin: 0;
        }

        /* product price */
        .product .price {
            font-size: 24px;
            color: red;
            font-weight: bold;
            margin: 0;
        }
    </style>
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
        <a href='ex7-8.php'>Acceuil</a>
        <a href='ex7-8.php?op=ProductList'>Product List</a>
        <a href='ex7-8.php?op=ProductCatalog'>Product Catalogue</a>
    </nav>

    <!-- CONTENT -->
    <?php echo $content ?>

    <!-- FOOTER -->
    <footer style="background-color:black;color:white;padding:10px">
        Exercice par <?php echo $author; ?> &copy;
        <p><?php echo COMPANY_STREET_ADDRESS . " " . COMPANY_CITY . " " . COMPANY_PROVINCE . " " . COMPANY_COUNTRY . " " . COMPANY_POSTAL_CODE ?></p>
        <p><?php echo COMPANY_NUMBER . " " ?><a href="mailto:adadjisso.arnold@gmail.com" style="color: blue;"><?php echo COMPANY_MAIL ?></a></p>
        <?php echo $count ?>

    </footer>
    </div>
</body>


</html>