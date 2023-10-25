<?php

function showTitle($title)
{
    echo "<br/><b>&#9830; $title</b><br/>";
    echo '<hr/>';
}

$colors = [
    'rouge',
    'bleu',
    'noir',
    'vert',
    'gris',
];

//----------------------
showTitle('Exercice 0 Faire un fonction tableauAffiche() pour afficher le tableau comme sur la maquette dans Moodle');

function tableauAffiche($tableau)
{
    echo '<table>';
    echo '<tr><th style="border:1px solid black">indice/clé</th><th style="border:1px solid black">valeur</th></tr>';
    foreach ($tableau as $cle => $valeur) {
        echo '<tr><td style="border:1px solid black">' . $cle . '</td><td style="border:1px solid black">' . $valeur . '</td></tr>';
    }
    echo '</table>';
}

tableauAffiche($colors); //appel de la fonction

//-------------------------
showTitle('Exercice 1 Afficher le tableau en ordre alphabétique avec sort()');
sort($colors);
tableauAffiche($colors);
//-------------------------
showTitle('Exercice 2.0 Convertir le texte tout en majuscule avec une boucle foreach() et strtoupper()');
$colorsUpper = [];
foreach ($colors as $uneCouleur) {
    $colorsUpper[] = strtoupper($uneCouleur);
}
tableauAffiche($colorsUpper);
showTitle('Exercice 2.1 Même chose, convertir le texte tout en majuscule, mais avec array_map() et strtoupper()');
$colorsUpperByarrayMap = array_map('strtoupper', $colors);
tableauAffiche($colorsUpperByarrayMap);
//------------------------
showTitle('Exercice 3 Ajouter le tableau $otherColors au tableau $colors avec array_merge(). Ensuite avec implode() afficher le tableau complet comme une chaîne de caractère avec un espace entre chaque item');

$otherColors = [
    'vert',
    'bleu',
    'noir',
];
$all = array_merge($colors, $otherColors);
$strAll = implode(' ', $all);
echo $strAll;
