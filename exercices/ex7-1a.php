<?php
$Pays = ['CA' => 'Canada', 'US' => 'USA', 'MX' => 'Mexique', 'FR' => 'France', 'AU' => 'Autre'];
?>
<!DOCTYPE html>
<html lang="fr-CA">

<head>
    <meta charset="UTF-8">
    <title>Exercice 7-1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <select name="pays">
        <?php
        foreach ($Pays as $pays_ab => $pays) {
            echo '<option value="' . $pays_ab . '"' . '>' . $pays . '</option>';
        }
        ?>
    </select>
</body>

</html>