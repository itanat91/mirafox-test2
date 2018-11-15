<?php

namespace app\components;

use PDO;

final class DB {
    private $connection;
    private static $instance;

    public static function getInstance(array $config){
        if(!self::$instance) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    private function __construct(array $config) {
        try{
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->connection = new PDO($config['dsn'], $config['username'], $config['password'], $opt);
        }catch(\PDOException $e){
            die('Something went wrong');
        }
    }

    private function __clone(){

    }

    public function getConnection(){
        return $this->connection;
    }
}