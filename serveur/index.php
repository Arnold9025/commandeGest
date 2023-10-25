<?php
require_once "globals.php";
require_once "outils.php";
require_once "Products_Type.php";
require_once "view/Web_Page.php";
require_once 'users.php';
require_once 'db_pdo.php';
require_once 'Orders.php';
require_once 'professeurs.php';
session_start();
// $_SESSION['nbTent'] = 0;
// $_SESSION['email'] = "";
// $_SESSION['pw'] = "";



function main()
{


    if (!isset($_GET['op'])) {
        $op = 'homepage';
    } else {
        $op = $_GET['op'];
    }
    switch ($op) {
        case 'ProductList':

            $List = new Web_Page;
            $List->title = "Liste des Produits";
            $List->count = 'Views = ' . $List->ViewCount('log/listCount.txt');
            $List->content =  Products_Type::productList();

            $List->render();
            break;
        case 'ProductCatalog':
            $Catalog = new Web_Page;
            $Catalog->title = "Catalogue des Produits";
            $Catalog->count = 'Views = ' . $Catalog->ViewCount('log/catalogCount.txt');
            $Catalog->content =  Products_Type::productCatalog();

            $Catalog->render();
            break;
        case 50:
            header('Content-Type: application/pdf');
            // le nom du fichier sera un_fichier.pdf, navigateur peut demander permission
            header('Content-Disposition: attachment; filename="products_images/doc/unfichier.pdf"');
            // ok envoyer le fichier, lire et envoyer directement avec readfile()
            readfile('products_images/doc/unfichier.pdf');
            break;
        case 51:
            header('location: http://www.timhortons.ca');
            break;
        case 1:
            $login = new Web_Page;
            $login->title = "login";
            $login->count = 'Views = ' . $login->ViewCount('log/login.txt');
            $login->content =  Users::login();

            $login->render();
            break;
        case 2:
            $loginV = new Web_Page;
            $loginV->title = "login";
            $loginV->count = 'Views = ' . $loginV->ViewCount('log/login.txt');
            $loginV->content = Users::loginVerify();
            $loginV->render();
            break;
        case 3:
            $register = new Web_Page;
            $register->title = "login";
            $register->count = 'Views = ' . $register->ViewCount('log/login.txt');
            $register->content =  Users::register();
            $register->render();
            break;
        case 4:
            $registerV = new Web_Page;
            $registerV->title = "Register";
            $registerV->count = 'Views = ' .  $registerV->ViewCount('log/login.txt');
            $registerV->content = Users::registerVerify();
            $registerV->render();
            break;
        case 5:
            Users::logout();
            break;
        case 200:
            $commandes = new Web_Page;
            $commandes->title = "Commandes";
            $commandes->content = Orders::list();
            $commandes->render();
            break;
        case 201:
            $display = new Web_Page;
            $display->title = "Details";
            $display->content = Orders::display();
            $display->render();
            break;
        case 202:
            $edit = new Web_Page;
            $edit->title = "Modifier Commande";
            $edit->content = Orders::edit();
            $edit->render();
            break;
        case 203:
            $edit = new Web_Page;
            $edit->title = "Modifier Details Commande";
            $edit->content = Orders::editOrders();
            $edit->render();
            break;
        case 204:
            $edit = new Web_Page;
            $edit->title = "Modifier Details Commande";
            $edit->content = Orders::saveOrders();
            $edit->render();
            break;
        case 205:
            Orders::delete();
            break;
        case 206:
            Orders::deleteproduct();
            break;
        case 210:
            Orders::save();
            break;
        case 245:
            Orders::listJson();
            break;
        case 1200:
            $prof = new Web_Page;
            $prof->title = "Liste des professeurs";
            $prof->content = Professeur::list();
            $prof->render();
            break;
        default:
            $Acceuil = new Web_Page;
            $Acceuil->title = "Home Page";
            $Acceuil->description = "Bienvenue - Page Acceuil";
            $Acceuil->count = 'Views = ' . $Acceuil->ViewCount('log/home.txt');
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $cookie_visite_name = 'dateDerniereVisite';
            $cookie_visite_value = time();
            setcookie($cookie_visite_name, $cookie_visite_value, time() + (86400 * 30 * 6), "/");
            $cookie_nom_name = 'nom';
            $cookie_nom_value = 'Dude';
            setcookie($cookie_nom_name, $cookie_nom_value, time() + (86400 * 30 * 6), "/");
            if ($lang == 'en') {
                $Acceuil->title = "Home Page";
                $Acceuil->description = "Welcome - Home Page";
                $Acceuil->content = 'Hello World';
            } elseif ($lang == 'fr') {
                if (!isset($_COOKIE[$cookie_visite_name])) {
                    $Acceuil->title = "Page d'accueil";
                    $Acceuil->description = "Bienvenue - Page d'accueil";
                    $Acceuil->content =  '<h1 class="homeword">Bienvenue</h1><p> c\'est votre premiere visite</p><div><img class= "background" src="products_images/world.jpg"></div>';
                } else {
                    $Acceuil->title = "Page d'accueil";
                    $Acceuil->description = "Bienvenue - Page d'accueil";
                    $Acceuil->content =  '<h1 class="homeword">Rebienvenue</h1><h3>' . $_COOKIE[$cookie_nom_name] . "</h3><p> Vous avez visite le site le " . date("D-M-Y h:i:s", $_COOKIE[$cookie_visite_name]) . "</p><div><img class= 'background' src='products_images/world.jpg'></div>";
                }
            } else {
                $Acceuil->content =  'Choisir français ou anglais:';
                // afficher formulaire pour choisir
            }
            $Acceuil->render();
            logVisitor();

            header("HTTP/1.0 404 fichier introuvable"); // affiché dans console client
    }
}

main();
