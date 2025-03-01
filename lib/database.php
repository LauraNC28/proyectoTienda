<?php

class Database {
    private static $instance = null;
    private $pdo;

    public function __construct() {
        try {
            $dsn = 'mysql:host=localhost;dbname=tienda;charset=utf8';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->pdo = new PDO($dsn, 'root', '', $options);
       
    
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance; 
    }

    public function getConnection() {
        return $this->pdo;
    }
}

?>