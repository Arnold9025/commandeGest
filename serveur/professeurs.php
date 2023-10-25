<?php
class Professeur
{





    public static function list()
    {
        $DB = new db_pdo();
        $DB->connect();
        $professeurs = [];
        if (isset($_REQUEST['search'])) {
            $query = "SELECT professeurs.id, professeurs.Nom, professeurs.College, professeurs.Region  FROM professeurs WHERE id = ? ";
            $professeurs = $DB->querySelectParam($query, [$_REQUEST['search']]);
        } else if (isset($_REQUEST['order'])) {
            $query = 'SELECT professeurs.id, professeurs.Nom, professeurs.College, professeurs.Region   FROM professeurs ORDER BY ' . $_REQUEST['order'] . ' ASC';
            $professeurs = $DB->querySelect($query);
        } else {
            $query = 'SELECT professeurs.id, professeurs.Nom, professeurs.College, professeurs.Region   FROM professeurs';
            $professeurs = $DB->querySelect($query);
        }
        $rendu = '';
        $rendu .= '<div><h1></h1></div>';
        $rendu .= '<div class= "productTable">';
        $rendu .= '<h1>Liste des professeurs</h1>';
        $rendu .= '<form action= "index.php?op=1200" class= "search-bar" method="POST">';
        $rendu .= '<input type="search" name="search" id="search" required autocomplete="off" placeholder="search">';
        $rendu .= '<button class = "search-button" type= "submit">';
        $rendu .= '<span>Search</span>';
        $rendu .= '</button>   ';
        $rendu .= '</form>';
        $rendu .= '<table class= "orderTable">';
        $rendu .=  '<thead><tr>';
        $rendu .= '<p> Nombre de professeurs trouves: ' . count($professeurs) . '</p>';
        foreach ($professeurs[0] as $un_nom_de_colonne => $une_ligne) {
            $rendu .= '<th><a href="index.php?op=1200&order=' . $un_nom_de_colonne . '">' . $un_nom_de_colonne . '</a></th>';
        }
        // $rendu .= ' <th> Produits </th>';
        $rendu .= '</tr></thead>';
        $rendu .=  '<tbody>';

        foreach ($professeurs as $une_ligne) {
            $rendu .=  '<tr>';
            foreach ($une_ligne as $une_valeur) {
                $rendu .=  '<td>' . $une_valeur . '</td>';
            }
            // $products = $DB->querySelect('SELECT products.name FROM orderdetails INNER JOIN products ON orderdetails.productId = products.id INNER JOIN orders ON orderdetails.orderId = orders.id WHERE orders.id = ' . $une_ligne['id']);
            // $rendu .= '<td>';
            // foreach ($products as $p) {
            //     $rendu .= '- ' . $p['name'] . '<br/>';
            // }
            $rendu .= '</td>';
        }

        $rendu .=  '</tbody>';
        $rendu .= '</table>';
        $rendu .= '</div>';

        return $rendu;
    }
}
