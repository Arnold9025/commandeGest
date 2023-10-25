<?php
// Exercise 10-0
//1.Afficher le répertoire de travail courant (current working directory)
echo getcwd();
echo '<br>';
//2.verifier que le fichier ex10-0_text.txt existe dans le répertoire courant, sinon afficher un message "le fichier n'existe pas"
if (file_exists('ex10-0_text.txt')) {
} else {
    echo "le fichier n'existe pas";
}
echo '<br>';

//3.Afficher la taille du fichier ex10-0_text.txt en octets (bytes)

echo filesize('ex10-0_text.txt');
echo '<br>';

//4.Lire tout le contenu du fichier ex10-0_text.txt dans une variable. Afficher le contenu sur à l'écran
echo file_get_contents('ex10-0_text.txt');
echo '<br>';

//5.copier le fichier ex10-0_text.txt vers HELLO.txt
copy('ex10-0_text.txt', 'HELLO.txt');
echo '<br>';

//6.Remplacer tout le contenu de HELLO.txt par le texte "Hello World"
file_put_contents('HELLO.txt', 'Hello world');
echo '<br>';

//7.Renommer HELLO.TXT pour HELLO2.txt
rename('HELLO.txt', 'HELLO2.txt');
echo '<br>';

//8.Effacer le fichier HELLO2.txt
unlink('HELLO2.txt');
echo '<br>';
