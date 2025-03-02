<?php

// Define la clase Categoria, que representa una categoría de productos en la base de datos.
class Categoria {
    // Propiedades privadas de la clase.
    private $id; // Almacena el ID de la categoría.
    private $nombre; // Almacena el nombre de la categoría.
    private $db; // Almacena la conexión a la base de datos.

    // Constructor de la clase.
    public function __construct() {
        // Obtiene la conexión a la base de datos utilizando el patrón Singleton.
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener el ID de la categoría.
    public function getId() {
        return $this->id;
    }

    // Método para establecer el ID de la categoría.
    public function setId($id) {
        $this->id = $id;
    }

    // Método para obtener el nombre de la categoría.
    public function getNombre() {
        return $this->nombre;
    }

    // Método para establecer el nombre de la categoría.
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    // Método para obtener todas las categorías de la base de datos.
    public function obtenerTodo() {
        // Define la consulta SQL para obtener todas las categorías, ordenadas por ID de forma descendente.
        $sql = "
        SELECT * FROM categorias
        ORDER BY id DESC;
        ";

        try {
            // Prepara la consulta SQL.
            $stmt = $this->db->prepare($sql);

            // Ejecuta la consulta.
            $stmt->execute();

            // Retorna todos los resultados como un array asociativo.
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si ocurre un error, lo muestra y retorna false.
            echo "Error al obtener categorías: " . $e->getMessage();
            return false;
        }
    }

    // Método para obtener una categoría específica por su ID.
    public function obtenerUno() {
        // Define la consulta SQL para obtener una categoría por su ID.
        $sql = "
        SELECT * FROM categorias
        WHERE id = :id;
        ";

        try {
            // Prepara la consulta SQL.
            $stmt = $this->db->prepare($sql);

            // Asocia el parámetro :id con el valor de la propiedad $id de la clase.
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            // Ejecuta la consulta.
            $stmt->execute();

            // Retorna el resultado como un objeto.
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            // Si ocurre un error, lo muestra y retorna false.
            echo "Error al obtener categoría: " . $e->getMessage();
            return false;
        }
    }

    // Método para guardar una nueva categoría en la base de datos.
    public function guardarBase() {
        // Define la consulta SQL para insertar una nueva categoría.
        $sql = "
        INSERT INTO categorias (nombre)
        VALUES (:nombre);
        ";

        try {
            // Prepara la consulta SQL.
            $stmt = $this->db->prepare($sql);

            // Asocia el parámetro :nombre con el valor de la propiedad $nombre de la clase.
            $stmt->bindParam(':nombre', $this->nombre);

            // Ejecuta la consulta.
            $stmt->execute();

            // Retorna true si la operación fue exitosa.
            return true;
        } catch (PDOException $e) {
            // Si ocurre un error, lo muestra y retorna false.
            echo "Error al guardar usuario: " . $e->getMessage();
            return false;
        }
    }
}

?>