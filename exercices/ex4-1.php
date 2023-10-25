<?php
function showTitle($title)
{
    echo "<h2>&#9830; $title</h2>";
    echo '<hr/>';
}
function str_word_count_utf8($str)
{
    return count(preg_split('~[^\p{L}\p{N}\']+~u', $str));
}

$phrase = 'Maître corbeau sur un arbre perché, tenait en son bec un fromage.
maître renard par l’odeur alléché, lui tint à peu près ce langage:
Et bonjour, Monsieur du corbeau.';

showTitle('Exercice 1: nombre de caractères avec mb_strlen()');
echo mb_strlen($phrase);

showTitle('Exercice 2: nombre de mots avec str_word_count_utf8()');
echo str_word_count_utf8($phrase);

showTitle('Exercice 3: en majuscule avec strtoupper()');
echo strtoupper($phrase);

showTitle('Exercice 4: première lettre de chaque mot en majuscule avec ucwords()');
echo ucwords($phrase);

showTitle('Exercice 5: nombre de caractères sans les espaces avec substr_count()');
echo substr_count($phrase, 'b');

showTitle('Exercice 6: changer corbeau pour corbeille, bonjour par bonsoir, avec strtr()');
$replace = ['corbeau' => 'corbeille'];
echo strtr($phrase, $replace);
