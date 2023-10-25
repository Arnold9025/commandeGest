<?php

use LDAP\Result;

class db_pdo
{
    //Local connexion
    private const DB_SERVER_TYPE = 'mysql'; // MySQL or MariaDB server
    private const DB_HOST = '127.0.0.1'; // local server on my laptop
    private const DB_PORT = 3307; // optional, default 3306, use 3307 for MariaDB
    private const DB_NAME = 'classicmodels'; // for Database classicmodels
    private const DB_CHARSET = 'utf8mb4'; // pour français correct
    private const DB_USER_NAME = 'site_web_classic_models'; // if not root it must have been previously created on DB server
    private const DB_PASSWORD = '12345678';

    //host connexion

    // private const DB_SERVER_TYPE = 'mysql'; // MySQL or MariaDB server
    // private const DB_HOST = 'sql306.epizy.com'; // local server on my laptop
    // private const DB_PORT = 3306; // optional, default 3306, use 3307 for MariaDB
    // private const DB_NAME = 'epiz_33462403_classicmodels'; // for Database classicmodels
    // private const DB_CHARSET = 'utf8mb4'; // pour français correct
    // private const DB_USER_NAME = 'epiz_33462403'; // if not root it must have been previously created on DB server
    // private const DB_PASSWORD = '59BDkxRzMB';
    private const DB_OPTIONS = [
        // throw exception on SQL errors
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // return records with associative keys only, no numeric index
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        //Enables or disables emulation of prepared statements.
        // Some drivers do not support native prepared statements or have .
        //(if FALSE) to try to use native prepared statements
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    private $connection = null;
    public function connect()
    {
        try {
            $DSN = self::DB_SERVER_TYPE . ':host=' . self::DB_HOST . ';port=' . self::DB_PORT . ';dbname=' . self::DB_NAME . ';charset=' . self::DB_CHARSET;
            $this->connection = new PDO($DSN, self::DB_USER_NAME, self::DB_PASSWORD, self::DB_OPTIONS);
        } catch (PDOException $e) {
            http_response_code(500);
            exit('DB connection Error : ' . $e->getMessage());
        }
    }
    public function disconnect()
    {
        $this->connection = null;
    }
    public function query($sql)
    {
        try {
            $result = $this->connection->query($sql);
        } catch (PDOException $e) {
            http_response_code(500);
            echo "erreur requete SQL: " . $e->getMessage();
            $result = null;
        }
        return $result;
    }
    public function querySelect($sql)
    {
        try {
            $result = $this->connection->query($sql);
            return $result->fetchAll();
        } catch (PDOException $e) {
            http_response_code(500);
            echo "erreur requete SQL: " . $e->getMessage();
            return null;
        }
    }
    public function querySelectParam($sql_str, $params)
    {
        try {
            $stmt = $this->connection->prepare($sql_str);
            $stmt->execute($params);
            $records = $stmt->fetchAll();
        } catch (\PDOException $e) {
            // SQL syntax error for example
            http_response_code(500);
            exit("SQL Query Error : " . $e->getMessage());
        }
        return $records;
    }
    public function queryParam($sql_str, $params)
    {
        try {
            $stmt = $this->connection->prepare($sql_str);
            $stmt->execute($params);
        } catch (\PDOException $e) {
            // SQL syntax error for example
            http_response_code(500);
            exit("SQL Query Error : " . $e->getMessage());
        }
        return $stmt;
    }
}
