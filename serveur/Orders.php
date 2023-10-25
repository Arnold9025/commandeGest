<?php
include_once "db_pdo.php";

class Orders
{





    public static function list()
    {
        $DB = new db_pdo();
        $DB->connect();
        if (isset($_REQUEST['search'])) {
            $query = "SELECT *  FROM orders WHERE id LIKE '%" . $_REQUEST['search'] . "%' OR status LIKE '%" . $_REQUEST['search'] . "%' OR comments LIKE '%" . $_REQUEST['search'] . "%' OR customerId LIKE '%" . $_REQUEST['search'] . "%'";
        } else {
            $query = 'SELECT *  FROM orders ';
        }
        //    SELECT products.name, orders.id, orderdetails.priceEach, orderdetails.quantity FROM orderdetails INNER JOIN products, orders
        $orders = $DB->querySelect($query);
        $rendu = '';
        $rendu .= '<div><h1></h1></div>';
        $rendu .= '<div class= "containertable">';
        $rendu .= '<h1>Liste des commandes</h1>';
        $rendu .= '<form action= "index.php?op=200" class= "search-bar" method="POST">';
        $rendu .= '<input type="search" name="search" id="search" required autocomplete="off" placeholder="search">';
        $rendu .= '<button class = "search-button" type= "submit">';
        $rendu .= '<span>Search</span>';
        $rendu .= '</button>   <a href="index.php?op=202"><img class = "addIcon"src="products_images/add.png"></a>';
        $rendu .= '</form>';
        $rendu .= '<table class= "orderTable">';
        $rendu .=  '<thead><tr>';

        foreach ($orders[0] as $un_nom_de_colonne => $une_ligne) {
            $rendu .= '<th>' . $un_nom_de_colonne . '</th>';
        }
        // $rendu .= ' <th> Produits </th>';
        $rendu .= ' <th> Actions </th></tr></thead>';
        $rendu .=  '<tbody>';

        foreach ($orders as $une_ligne) {
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
            $rendu .= '<td><a href= "index.php?op=201&id=' . $une_ligne['id'] . ' " ><img class= "ordersicons"  src="products_images/icons/details.png" alt="" ></a><a href= "index.php?op=202&id=' . $une_ligne['id'] . '"><img class= "ordersicons"  src="products_images/icons/edit.png" alt=""></a><a href= "index.php?op=205&id=' . $une_ligne['id'] . '"><img class= "ordersicons"  src="products_images/icons/remove.png" alt=""></a></td></tr>';
        }

        $rendu .=  '</tbody>';
        $rendu .= '</table>';
        $rendu .= '</div>';

        return $rendu;
    }
    public static function display()
    {
        $DB = new db_pdo();
        $DB->connect();
        $query = "SELECT * FROM orders WHERE id=" . $_REQUEST['id'];
        $orders = $DB->querySelect($query);
        $products = $DB->querySelect('SELECT products.id, products.name AS "Nom du produit", orderdetails.quantity AS "Quantite", orderdetails.priceEach AS "Prix U",(orderdetails.quantity*orderdetails.priceEach) AS "Prix T" FROM orderdetails INNER JOIN products ON orderdetails.productId = products.id INNER JOIN orders ON orderdetails.orderId = orders.id WHERE orders.id = ' . $orders[0]['id']);
        $customer = $DB->querySelect('SELECT customers.name AS "Nom du Client" FROM orders INNER JOIN customers ON orders.customerId = customers.id WHERE orders.id = ' . $orders[0]['id']);
        $statusclassImg = '';
        $statusclassColor = '';
        if ($orders[0]['status'] == 'Shipped') {
            $statusclassImg = 'Shipped';
            $statusclassColor = 'ShippedColor';
        } else if ($orders[0]['status'] == 'Cancelled') {
            $statusclassImg = 'Cancelled';
            $statusclassColor = 'CancelledColor';
        } else if ($orders[0]['status'] == 'On Hold') {
            $statusclassImg = 'On_Hold';
            $statusclassColor = 'Other_Color';
        } else if ($orders[0]['status'] == 'In Process') {
            $statusclassImg = 'In_Process';
            $statusclassColor = 'Other_Color';
        } else if ($orders[0]['status'] == 'panier') {
            $statusclassImg = 'panier';
            $statusclassColor = 'Other_Color';
        }
        $html = "";
        $html .= '<div class="containerDisplay">';
        $html .= '<div class="' . $statusclassImg . '"></div>';
        $html .= '<h1>' . $orders[0]['id'] . '</h1>';
        $html .= '<h3> Nom du Client: ' . $customer[0]['Nom du Client'] . '</h1>';

        $html .= '<p>Date: ' . $orders[0]['date'] . '</p>';
        $html .= '<p>Shipped Date: ' . $orders[0]['shippedDate'] . '</p>';
        $html .= '<p>RequireDate: ' . $orders[0]['requiredDate'] . '</p>';
        $html .= '<p class="' . $statusclassColor . '">Status: ' . $orders[0]['status']  . '</p>';


        $html .= '<h3>PRODUITS DE LA COMMANDE</h3>';
        $html .= '<table class= "productTable">';
        $html .=  '<thead><tr>';
        if (isset($products[0])) {


            foreach ($products[0] as $un_nom_de_colonne => $une_ligne) {
                $html .= '<th>' . $un_nom_de_colonne . '</th>';
            }
        } else {
            foreach ($products as  $une_ligne) {
                $html .= '<th>' . $une_ligne . '</th>';
            }
        }

        $html .= '</tr></thead><tbody>';
        $total = 0;
        foreach ($products as $une_ligne) {
            $total += $une_ligne['Quantite'] * $une_ligne['Prix U'];
            $html .= '<tr>';
            foreach ($une_ligne as $une_valeur) {
                $html .=  '<td>' . $une_valeur . '</td>';
            }
        }
        // $rendu .= ' <th> Produits </th>';
        $html .=  '</tbody>';
        $html .=  '</table>';
        $html .= '<p> Total = ' . $total . '</p>';
        $html .= '</div>';

        return $html;
    }
    public static function edit($msg = "", $data = [])
    {
        $html = "";

        $DB = new db_pdo();
        $DB->connect();
        $status = $DB->querySelect("SELECT DISTINCT orders.status FROM orders");
        $query = "SELECT customers.id, customers.name FROM customers";
        $customers = $DB->querySelect($query);
        $id_modif_permit = "";

        if ($data == []) {
            if (isset($_REQUEST['id'])) {
                $DB = new db_pdo();
                $DB->connect();
                $query = "SELECT * FROM orders WHERE id=" . $_REQUEST['id'];

                $orders = $DB->querySelect($query);
                $data = $orders[0];
                $id_modif_permit = "readonly";
                if ($data == []) {
                    http_response_code(404);
                    exit("erreur id inexistant");
                }
            } else {
                $data = [
                    'id' => -1,
                    'date' => "",
                    'requiredDate' => "",
                    'shippedDate' => "",
                    'comments' => "",

                ];
            }
        } else {
        }
        $html .= '<div class="edit_container">';
        $html .= '<div class="edit_form_container">';
        $html .= '<form action="index.php?op=210" method="post">';
        $html .= '<p class = "errorMsg">' . $msg . '</p>';
        $html .= '<div><input type="text" name="id" id="id" value=' . $data['id'] . ' ' . $id_modif_permit . '  ></div>';
        $html .= '<div><input type="date" name="date" id="date" required value="' . $data['date'] . '"></div>';
        $html .= '<div><input type="date" name="requiredDate" id="requiredDate" required value="' . $data['requiredDate'] . '"></div>';
        $html .= '<div><input type="date" name="shippedDate" id="shippedDate" required value="' . $data['shippedDate'] . '"></div>';
        $html .= '<div><select name= "status" id = "status">';
        foreach ($status as $unstat) {
            $html .= '<option value="' . $unstat['status'] . '">' . $unstat['status'] . '</option>';
        }
        $html .= '</select></div>';
        $html .= '<div><textarea name="comments" id="comments" cols="30" rows="10" >' . $data['comments'] . '</textarea></div>';
        $html .= '<div><select name= "customerId" required >';
        foreach ($customers as $une_ligne) {
            $html .= '<option value=' . $une_ligne['id'] . '>' . $une_ligne['name'] . '</option>';
        }
        $html .= '</select></div>';
        $html .= '<div><input type="submit" value="Valider"></div>';
        if (isset($_REQUEST['id'])) {
            $html .= '<a href="index.php?op=203&id=' . $data['id'] . '">Ajouter Produits</a>';
        }
        $html .= '</form>';

        $html .= '</div>';
        $html .= '<div class="edit_image_container"><img src="products_images/just_holder.jpg"></div>';

        $html .= '</div>';



        return $html;
    }
    public static function save()
    {
        $errmsg = "";

        if (!isset($_POST['date']) || !isset($_POST['requiredDate']) || $_POST['id'] < 10100) {
            $errmsg = "required field missed";
            self::edit($errmsg, $_REQUEST);
        } else {
            $date = date('Y-m-d', strtotime($_POST['date']));
            $dateR = date('Y-m-d', strtotime($_POST['requiredDate']));
            $dateS = date('Y-m-d', strtotime($_POST['shippedDate']));
            $DB = new db_pdo();
            $DB->connect();
            $query = "SELECT * FROM orders WHERE id =" . $_POST['id'];

            $idVerify = $DB->querySelect($query);

            var_dump($idVerify);
            if ($idVerify !== []) {
                $query = "UPDATE orders SET date = '" . $date . "', requiredDate = '" . $dateR . "' , shippedDate = '" . $dateS . "' , status = '" .  $_POST['status']  . "' , comments = '" . $_POST['comments'] . " ', customerId =" . $_POST['customerId'] . " WHERE id = " . $_POST['id'];
            } else {
                $query = "INSERT INTO orders(id,date,requiredDate,shippedDate,status,comments,customerId) VALUES(" . $_POST['id'] . ",'" . $date . "','" . $dateR . "','" . $dateS . "','" . $_POST['status'] . "','" . $_POST['comments'] . "'," . $_POST['customerId'] . ")";
            }
            $DB->query($query);
            var_dump($query);

            header('location: index.php?op=200');
        }
    }
    public static function listJson()
    {
        $DB = new db_pdo;
        $DB->connect();
        $orders = $DB->querySelect("SELECT * FROM orders");
        $ordersJSON = json_encode($orders, JSON_PRETTY_PRINT);
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200);
        echo $ordersJSON;
    }
    public static function editOrders($msg = "", $data = [])
    {
        $DB = new db_pdo();
        $DB->connect();
        $queryProductsToAdd = "SELECT products.id, products.name, products.cost, products.quantityInStock FROM products";
        $productsToAdd = $DB->query($queryProductsToAdd);
        $query = "SELECT * FROM orders WHERE id= " . $_REQUEST['id'];
        $orders = $DB->querySelect($query);
        $products = $DB->querySelect('SELECT orderdetails.id AS "id", products.id AS "product ID", products.name AS "Nom du produit", orderdetails.quantity AS "Quantite", orderdetails.priceEach AS "Prix U",(orderdetails.quantity*orderdetails.priceEach) AS "Prix T" FROM orderdetails INNER JOIN products ON orderdetails.productId = products.id INNER JOIN orders ON orderdetails.orderId = orders.id WHERE orders.id = ' . $orders[0]['id']);
        $customer = $DB->querySelect('SELECT customers.name AS "Nom du Client" FROM orders INNER JOIN customers ON orders.customerId = customers.id WHERE orders.id = ' . $orders[0]['id']);
        $statusclassImg = '';
        $statusclassColor = '';
        if ($orders[0]['status'] == 'Shipped') {
            $statusclassImg = 'Shipped';
            $statusclassColor = 'ShippedColor';
        } else if ($orders[0]['status'] == 'Cancelled') {
            $statusclassImg = 'Cancelled';
            $statusclassColor = 'CancelledColor';
        } else if ($orders[0]['status'] == 'On Hold') {
            $statusclassImg = 'On_Hold';
            $statusclassColor = 'Other_Color';
        } else if ($orders[0]['status'] == 'In Process') {
            $statusclassImg = 'In_Process';
            $statusclassColor = 'Other_Color';
        } else if ($orders[0]['status'] == 'panier') {
            $statusclassImg = 'panier';
            $statusclassColor = 'Other_Color';
        }
        $html = "<p class = 'errorMsg'>" . $msg . "</p>";
        $html .= '<div class="containerDisplay">';
        $html .= '<div class="' . $statusclassImg . '"></div>';
        $html .= '<h1>' . $orders[0]['id'] . '</h1>';
        $html .= '<h3> Nom du Client: ' . $customer[0]['Nom du Client'] . '</h1>';

        $html .= '<p>Date: ' . $orders[0]['date'] . '</p>';
        $html .= '<p>Shipped Date: ' . $orders[0]['shippedDate'] . '</p>';
        $html .= '<p>RequireDate: ' . $orders[0]['requiredDate'] . '</p>';
        $html .= '<p class="' . $statusclassColor . '">Status: ' . $orders[0]['status']  . '</p>';


        $html .= '<h3>PRODUITS DE LA COMMANDE</h3>';
        $html .= '<table class= "productTable">';
        $html .=  '<thead><tr>';
        if (isset($products[0])) {


            foreach ($products[0] as $un_nom_de_colonne => $une_ligne) {
                $html .= '<th>' . $un_nom_de_colonne . '</th>';
            }
        } else {
            foreach ($products as  $une_ligne) {
                $html .= '<th>' . $une_ligne . '</th>';
            }
        }
        $html .= '<th>Rmv</th>';
        $html .= '</tr></thead><tbody>';
        $total = 0;
        foreach ($products as $une_ligne) {
            $total += $une_ligne['Quantite'] * $une_ligne['Prix U'];
            $html .= '<tr>';
            foreach ($une_ligne as $une_valeur) {
                $html .=  '<td>' . $une_valeur . '</td>';
            }
            $html .= '<td><a href= "index.php?op=206&id=' . $une_ligne['id'] . '&orderId=' . $_REQUEST['id'] . '"><img class= "ordersicons"  src="products_images/icons/remove.png" alt=""></a></td></tr>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        $html .= '<form action="index.php?op=204&id=' . $_REQUEST['id'] . '" method="post">';
        $html .= '<div><select name= "productId" required >';
        foreach ($productsToAdd as $une_ligne) {
            $html .= '<option value=' . $une_ligne['id'] . '>' . $une_ligne['name'] . '</option>';
        }
        $html .= '</select></div>';
        $html .= '<input type="number" name="quantite" id="quantite" required>';
        $html .= '<input type="submit" value="Valider">';
        $html .= '</form></div>';
        return $html;
    }
    public static function saveOrders()
    {
        $DB = new db_pdo();
        $DB->connect();
        $queryProductsToAdd = "SELECT  products.id, products.cost, products.quantityInStock FROM products WHERE id='" . $_POST['productId'] . "'";
        $productsToAdd = $DB->querySelect($queryProductsToAdd);
        var_dump($productsToAdd);
        $errmsg = " ";
        $html = " ";
        if (!isset($_POST['quantite'])) {
            $errmsg = "quantity must be set";
            $html .= self::editOrders($errmsg, $_REQUEST);
        } elseif ($_POST['quantite'] > $productsToAdd[0]['quantityInStock']) {
            $errmsg = "quantity more than possible";
            $html .= self::editOrders($errmsg, $_REQUEST);
        } else {
            $queryAddProduct = "INSERT INTO orderdetails(orderId,productId,quantity,priceEach,orderLineNumber) VALUES(" . $_REQUEST['id'] . ",'" . $_POST['productId'] . "','" . $_POST['quantite'] . "','" . $productsToAdd[0]['cost'] . "'," . 7 . ")";
            $querySetQty = "UPDATE products SET products.quantityInStock = " . $productsToAdd[0]['quantityInStock'] - $_POST['quantite'] . " WHERE id= '" . $productsToAdd[0]['id'] . "'";
            $DB->query($queryAddProduct);
            $DB->query($querySetQty);
            var_dump($querySetQty);
            header('location: index.php?op=203&id=' . $_REQUEST['id']);
        }
        return $html;
    }
    public static function delete()
    {
        $DB = new db_pdo();
        $DB->connect();
        $deleteorders = "DELETE FROM orders WHERE id=" . $_REQUEST['id'];
        $deleteordersdetails = "DELETE FROM orderdetails WHERE orderId=" . $_REQUEST['id'];

        $DB->query($deleteordersdetails);
        $DB->query($deleteorders);
        header('location: index.php?op=200');
    }
    public static function deleteproduct()
    {
        $DB = new db_pdo();
        $DB->connect();
        $deleteordersdetails = "DELETE FROM orderdetails WHERE id=" . $_REQUEST['id'];

        $DB->query($deleteordersdetails);
        header('location: index.php?op=203&id=' . $_REQUEST['orderId']);
    }
}
