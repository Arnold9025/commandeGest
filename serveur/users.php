<?php
class Users
{
    // public const users = [
    //     ['id' => 0, 'email' => 'Yannick@gmail.com', 'pw' => '12345678'],
    //     ['id' => 1, 'email' => 'Victor@test.com', 'pw' => '11111111'],
    //     ['id' => 2, 'email' => 'Christian@victoire.ca', 'pw' => '22222222'],
    // ];

    public static function login($msg = "", $data = [])
    {
        $html = '';
        if (!isset($_SESSION['nbTent'])) {
            $_SESSION['nbTent'] = 0;
        } else if ($_SESSION['nbTent'] <= 3) {
            if ($data == []) {
                $data['email'] = "";
                $data['mdp'] = "";
            }
            $html .= '<p class = "errorMsg">' . $msg . '</p>';
            $html .= '<div class= "loginContainer">';
            $html .= '<div class = "imageContainer">';
            $html .= '</div>';
            $html .= '<div class = "formContainer">';
            $html .= '<div class = "loginIcon"></div>';
            $html .= '<form action="index.php?op=2" method="POST">';
            $html .= '<div>';
            $html .= '<label for="email" >Email</label>';
            $html .= '<input type="email" name="email" id="email" value= "' . $data['email'] . '">';
            $html .= '</div>';
            $html .= '<div>';
            $html .= '<label for="mdp">Mot de Passe</label>';
            $html .= '<input type="password" name="mdp" id="mdp" value= "' . $data['mdp'] . '">';
            $html .= '</div>';
            $html .= '<div>';
            $html .= '<input type="submit" value="Continuez">';
            $html .= '</div>';

            $html .= '</form>';
            $html .= '</div>';

            $html .= '</div>';
        } else {
            $html .= '<h1>Veuillez reessayer plus tard</h1>';
        }

        return $html;
    }
    public static function loginVerify()
    {

        $DB = new db_pdo();
        $DB->connect();
        $query = 'SELECT * FROM users';
        $users = $DB->querySelect($query);
        $index = 0;
        $err_msg = '';
        $html = '';

        if (!isset($_POST['email'])) {
            $err_msg .= "l'email est manquant dans le formulaire";
            $html .= self::login($err_msg);
            $_SESSION['nbTent']++;
        } else {
            $email = $_POST['email'];
            $email = htmlspecialchars($email); //voir plus loin
            if (strlen($email) == 0) {
                $err_msg .= "L'email est obligatoire, ne peut être vide-";
                $_SESSION['nbTent']++;
                $html .= self::login($err_msg);
            } elseif (strlen($email) > 126) {
                $err_msg .= "L'email doit avoir max 40 caractères-";
                $_SESSION['nbTent']++;
                $html .= self::login($err_msg);
            } else {
                while ($index <= count($users) - 1  && $email != $users[$index]['email']) {
                    $index++;
                }
                if ($index <= count($users) - 1) {
                    if (password_verify($_POST['mdp'], $users[$index]['pw'])) {
                        $err_msg = 'vous etes connecte ' . $users[$index]['email'];
                        header('location:index.php');
                        if (!isset($_SESSION['email']) && !isset($_SESSION['pw'])) {
                            $_SESSION['email'] = $_POST['email'];
                            $_SESSION['fullname'] = $users[$index]['fullname'];
                        }
                    } else {
                        $err_msg = 'mot de passe invalide';
                        $_SESSION['nbTent']++;
                        $html .= self::login($err_msg, $_REQUEST);
                    }
                } else if ($index >= count($users) - 1) {
                    $err_msg = 'identifiant invalide';
                    $_SESSION['nbTent']++;

                    $html .= self::login($err_msg, $_REQUEST);
                }
            }
        }
        return $html;
    }
    public static function register($msg = "", $data = [])
    {
        if ($data == []) {
            if (isset($_REQUEST['id'])) {
                // edit un existant
                $DB = new db_pdo;
                $DB->connect();
                $data = $DB->querySelectParam("SELECT * FROM users WHERE id=?", [$_REQUEST['id']]);
                if ($data == []) {
                    // user inexistant
                    http_response_code(404);
                    exit("erreur id inexistant");
                }
                $data = $data[0]; //premiere ligne de la table car juste 1 de toute façon
            } else {
                // ajoute un nouveau usager
                $data = [
                    'id' => -1, //nouveau
                    'fullname' => "",
                    'email' => "",
                    'pw' => "",
                    'level' => 'client',
                    'lang' => '',
                    'spam_ok' => 1
                ];
            }
        }
        $html = '';
        $pays = [
            [1, 'CA', 'Canada'],
            [2, 'US', 'États-Unis'],
            [3, 'MX', 'Mexique'],
            [4, 'FR', 'France'],
            [5, 'AU', 'Autre']
        ];
        $html .= '<p class = "errorMsg">' . $msg . '</p>';
        $html .= '<div class= "container">';
        $html .= '<form action="index.php?op=4" method="POST">';
        $html .= ' <div><input type="text" name="id" id="id" value="' . $data['id'] . '" readonly ></div>';
        $html .= ' <div><input type="text" name="fullname" id="fullname" value="' . $data['fullname'] . '" required maxlength="50" placeholder="nom et Prenom"></div>';
        $html .= '<div><select name="country" id="country">';
        foreach ($pays as $unPays) {
            $html .= '<option value="' . $unPays[1] . '">' . $unPays[2] . '</option>';
        }
        $html .= '</select></div>';
        $html .= '<div><label for="">Selectionnez une langue</label></div>';
        $html .= '<div><input type="radio" name="lang" id="fr" value="fr" required maxlength="25"><label for="fr"> Francais</label></div>';
        $html .= '<div><input type="radio" name="lang" id="en" value="en" required maxlength="25"><label for="en"> Anglais</label></div>';
        $html .= '<div><input type="radio" name="lang" id="en" value="other" required maxlength="25"><label for="other"> Autre</label></div>';
        $html .= '<div><input type="email" name="email" id="email" required maxlength="126" placeholder="couriel"></div>';
        $html .= '<div><input type="password" name="pw" id="pw" required maxlength="8" placeholder="password"></div>';
        $html .= '<div><input type="password" name="pw2" id="pw2" required maxlength ="8"placeholder="password"></div>';
        $html .= '<div><input type="checkbox" name="spam_ok" value="1" id="spam_ok" checked><label>Je desire periodiquement recevoir des news</label></div>';
        $html .= '<input type="submit" value="S\'enregistrer">';
        $html .= '</form>';
        $html .= '</div>';
        return $html;
    }
    public static function registerVerify()
    {
        $html = "";
        //verifier les données
        $errMsg = '';

        //verifier fullname est reçu et 50 char max et nettoyer
        $fullname = htmlspecialchars($_REQUEST['fullname']);

        // verifer langue est reçue et 25 char mas

        // verifier email est reçu, ressemble à email et 126 char max

        // spam_ok
        if (isset($_REQUEST['spam_ok'])) {
            $spam_ok = 1;
        } else {
            $spam_ok = 0;
        }

        // verifier pw est reçu et 8 char max et même que pw2
        if (!isset($_REQUEST['pw']) or !isset($_REQUEST['pw2'])) {
            $errMsg .= 'Entrez un mot de passe et répétez le.';
        } elseif (strlen($_REQUEST['pw']) > 8) {
            $errMsg .= 'Mot de passe trop long, max 8 caractères.';
        } elseif ($_REQUEST['pw'] != $_REQUEST['pw2']) {
            $errMsg .= "Les 2 mots de passe ne sont pas identiques.";
        } else {
            //verifier que le email n'est pas déjà utilisé
            $DB = new db_pdo;
            $DB->connect();
            $user = $DB->querySelectParam("SELECT email FROM users WHERE email=?", [$_REQUEST['email']]);
            if (count($user) != 0) {
                //email deja en usage
                $errMsg = "Email déjà utilisé, login ou choisir un autre email.";
            }
        }

        if ($errMsg != '') {
            // reaffiche le formulaire
            $html .= self::register($errMsg, $_REQUEST);
        } else {
            // TOUT OK
            if ($_REQUEST['id'] == -1) {
                // inérer un nouvel usager
                $DB = new db_pdo;
                $DB->connect();
                $DB->queryParam(
                    "INSERT INTO users (fullname,language,email,pw,spam_ok) VALUES (?,?,?,?,?)",
                    [
                        $fullname,
                        $_REQUEST['lang'],
                        $_REQUEST['email'],
                        password_hash($_REQUEST['pw'], PASSWORD_DEFAULT),
                        $spam_ok
                    ]
                );
                echo "OK";
            }
        }
        return $html;
    }

    public static function logout()
    {
        $_SESSION['email'] = null;
        $_SESSION['pw'] = null;
        $_SESSION['nbTent'] = 0;
        header('location:index.php');
    }
}
