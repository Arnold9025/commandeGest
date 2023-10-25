<?php
class Products_Type
{
    const products = [
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

    public function __construct()
    {
    }
    public function __destruct()
    {
    }
    static function productCatalog()
    {
        $html = '';
        foreach (self::products as $un_produit) {
            $html .= '<div class = "product">';
            $html .= '<img src="products_images/' . $un_produit['pic'] . '" alt="product picture">';
            $html .= '<p class = "name">' . $un_produit['name'] . '</p>';
            $html .= '<p class = "description">' . $un_produit['description'] . '</p>';
            $html .= '<p class = "price">' . $un_produit['price'] . '$</p>';
            $html .= '</div>';
        }
        return $html;
    }
    static function productList()
    {
        $html = '';
        $html .= '<table>';
        $html .=  '<thead><tr>';
        foreach (self::products[0] as $un_nom_de_colonne => $une_valeur) {
            $html .= '<th>' . $un_nom_de_colonne . '</th>';
        }
        $html .= '</tr></thead>';
        $html .=  '<tbody>';

        foreach (self::products as $une_ligne) {
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
}
