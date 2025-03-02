<?php

// Define la clase Database, que maneja la conexión a la base de datos.
class Database {
    // Propiedad estática para almacenar la única instancia de la clase.
    private static $instance = null;
    // Propiedad para almacenar la conexión PDO a la base de datos.
    private $pdo;

    // Constructor privado para evitar la creación de instancias fuera de la clase.
    public function __construct() {
        try {
            // Define el DSN (Data Source Name) para la conexión a la base de datos.
            $dsn = 'mysql:host=localhost;dbname=tienda;charset=utf8';

            // Opciones de configuración para la conexión PDO.
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en caso de errores.
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Devuelve los resultados como arrays asociativos.
                PDO::ATTR_EMULATE_PREPARES => false, // Desactiva la emulación de prepared statements.
            ];
            
            // Crea una nueva instancia de PDO para establecer la conexión a la base de datos.
            $this->pdo = new PDO($dsn, 'root', '', $options);
       
    
        } catch (PDOException $e) {
            // Si ocurre un error, detiene la ejecución y muestra un mensaje de error.
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }
    
    // Método estático para obtener la única instancia de la clase.
    public static function getInstance() {
        // Si no existe una instancia, crea una nueva.
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        // Retorna la instancia existente o recién creada.
        return self::$instance;
    }

    // Método para obtener la conexión PDO a la base de datos.
    public function getConnection() {
        return $this->pdo;
    }
}

?>