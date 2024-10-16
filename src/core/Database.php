<?php

namespace App\core;

use PDO;
use PDOException;

class Database{

    private $connection;
    private $config;

    public function __construct($config){
        $this->config = $config;
    }

    public function connect(){
        $this->connection = null;
        $dsn = 'mysql:' . http_build_query($this->config, '', ';');
        
        try{
            $this->connection = new PDO($dsn, $username = 'root', $password = '');
            $this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            throw new PDOException('Connection failed: ' . $e->getMessage());
        }

        return $this->connection;
    }

    public function getConnection() {
        return $this->connection;
    }
}
