<?php

class Database {
    private static $instance = null;
    private $pdo;

    // Constructor privado para evitar instanciación directa
     function __construct() {
        try {
            $dsn = 'mysql:host=localhost;dbname=tienda;charset=utf8';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            // Crear una instancia de PDO
            $this->pdo = new PDO($dsn, 'root', '', $options);
            
            // Verificar la conexión
       
    
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }
    

    // Método estático para obtener la instancia única de la clase
    public static function getInstance() {
        if (self::$instance === null) {
            // Si no existe la instancia, la creamos
            self::$instance = new Database();
        }
        return self::$instance; // Devolvemos la instancia única
    }

    // Método para obtener la conexión PDO
    public function getConnection() {
        return $this->pdo;
    }

    // Evitar clonación de la instancia (patrón Singleton)
}

?>