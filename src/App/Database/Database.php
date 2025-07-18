<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private $servername = '127.0.0.1';
    private $username = 'root';
    private $password = 'root';
    private $dbname = 'php_react_db';
    private $port = 8889;

    public function connect()
    {
        try {
            $db = new PDO("mysql:host=". $this->servername .";port=". $this->port .";dbname=" .$this->dbname,
                        $this->username,
                        $this->password
                    );

            $db->exec("set names utf8");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo "Connection failed ". $e->getMessage();
        }
    }

}