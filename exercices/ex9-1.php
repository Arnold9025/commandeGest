<?php
function showTitle($title)
{
    echo "<h2>&#9830; $title</h2>";
    echo '<hr/>';
}


showTitle('Exercise 00 timestamp actuel, nombre de secondes depuis 1er janvier 1970 (votre réponse sera différente de celle ci-dessous)');
echo $time_actual = time();

showTitle('Exercise 01 Créer le timestamp pour 20h:25min:10s le 10 janvier 2019 avec 2 méthodes: mktime() et strtotime()');
echo $time_10Jan2019 = mktime(20, 25, 10, 1, 10, 2019);
echo '<br/>';
echo $time_10Jan2019 = strtotime('10 january 2019 20 hours 25 minutes 10 seconds');


showTitle('Exercice 1 Date et heure au complet en format DATE_RFC2822');
echo date(DATE_RFC2822, $time_10Jan2019);

showTitle('Exercice 2 Le jour du mois seulement');
echo date('M', $time_10Jan2019);

showTitle('Exercice 3 Le mois en chiffre et en texte complet');
echo date('m F', $time_10Jan2019);

showTitle('Exercice 4 Année seulement');
echo date('Y', $time_10Jan2019);

showTitle('Exercice 5 Date en format 10,January,2019');
echo date('d,F,Y', $time_10Jan2019);

showTitle('Exercice 6 Ajoute 1 mois à la date avec strtotime(), et affichage complet');
echo date(DATE_RFC2822, strtotime('10th january 2019 20 hours 25 minutes 10 seconds + 1 month'));


showTitle('Exercice 7 Nombre de jours écoulés entre le 10 janvier 2019 et le 31 décembre 1973');
echo (strtotime('10 january 2019') - strtotime('31 december 1973')) / 86400;
showTitle('Exercice 8 Date en format Thursday, 10 January 2019');
echo date('l, d F Y', $time_10Jan2019);
