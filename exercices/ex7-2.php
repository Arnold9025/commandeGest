<?php
/* Tableau des mois de l'année */
$moisCouleurs = [
    'Janvier' => 'blue',
    'Février' => 'white',
    'Mars' => 'Red',
    'Avril' => 'Yellow',
    'Mai' => 'Grey',
    'Juin' => 'Lime',
    'Juillet' => 'lightblue',
    'Août' => 'fuchsia',
    'Septembre' => 'lightgrey',
    'Octobre' => 'olive',
    'Novembre' => 'pink',
    'Décembre' => 'purple',
];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Exercice 7-2 Tableau mois</title>
    <style>
        .container {
            width: 80%;
            border: 1px solid brown;
            margin: 10px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <header>
            <h1>Tableau mois</h1>
        </header>
        <main>
            <div class="container">
                <!--Première table -->
                <table>
                    <?php
                    foreach ($moisCouleurs as $mois => $couleurs) {
                        echo '<tr><td style="background-color:' . $couleurs . '"' . '>' . $mois . '</td></tr>';
                    }
                    ?>
                    <!-- votre code ici -->
                </table>
            </div>
            <div class="container">
                <!--Seconde table -->
                <table>
                    <tr>
                        <?php
                        foreach ($moisCouleurs as $mois => $couleurs) {
                            echo '<td style="background-color:' . $couleurs . '"' . '>' . $mois . '</td>';
                        }
                        ?>
                    </tr>
                    <!-- votre code ici -->
                </table>
            </div>
        </main>
        <footer>
        </footer>
    </div>
</body>

</html>