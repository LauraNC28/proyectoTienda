<?php

class Categoria {
    private $id;
    private $nombre;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function obtenerTodo() {
        $sql = "
        SELECT * FROM categorias
        ORDER BY id DESC;
        ";

        try {
            $stmt = $this->db->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener categorías: " . $e->getMessage();
            return false;
        }
    }

    public function guardarBase() {
        $sql = "
            INSERT INTO categorias (nombre)
            VALUES (:nombre);
        ";

        try {
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->execute();

            return true; 
        } catch (PDOException $e) {
            echo "Error al guardar usuario: " . $e->getMessage();
            return false; 
        }
    }
}

?>