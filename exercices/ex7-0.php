<?php $produits = [
    [
        'id' => 'td1234',
        'nom' => 'tondeuse',
        'prix' => 199.99,
        'poidsKg' => 50,
    ],
    [
        'id' => 'ra9xfg',
        'nom' => 'râteau',
        'prix' => 19.99,
        'poidsKg' => 5,
    ],
    [
        'id' => 'pe4532',
        'nom' => 'pelle',
        'prix' => 19.99,
        'poidsKg' => 5,
    ],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        th,
        td {
            border: 2px solid black;
        }
    </style>
</head>

<body>
    <?php
    echo '<table>';
    echo '<tr><th>id</th><th>nom</th><th>prix</th><th>poidsKg</th></tr>';
    foreach ($produits as $prd) {
        echo '<tr><td>' . $prd['id'] . '</td><td>' . $prd['nom'] . '</td><td>' . $prd['prix'] . '</td><td>' . $prd['poidsKg'] . '</td></tr>';
    }
    ?>
</body>

</html>