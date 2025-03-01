<?php

class Producto {
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;
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

    public function getCategoria_id() {
        return $this->categoria_id;
    }

    public function setCategoria_id($categoria_id) {
        $this->categoria_id = $categoria_id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    
    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }
    
    public function getOferta() {
        return $this->oferta;
    }

    public function setOferta($oferta) {
        $this->oferta = $oferta;
    }
    
    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;

    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function obtenerTodo() {
        $sql = "
        SELECT * FROM productos 
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

    /*public function obtenerTodoCategoria() {
        $sql = "
        SELECT p.*, c.nombre AS 'catnombre'
        FROM productos p
        INNER JOIN categorias c ON c.id = p.categoria_id
        WHERE p.categoria_id = {$this->getCategoria_id()}
        ORDER BY id DESC; 
        ";

        $producto = $this->db->query($sql);

        return $producto;
    }*/

    public function obtenerUno() {
        $sql = "
        SELECT * FROM productos
        WHERE id = {$this->id};
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

    public function productoRandom($limite) {
        $sql = "SELECT * FROM productos ORDER BY RAND() LIMIT :limite";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function guardar() {
        $sql = "
        INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen)
        VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen);
        ";
        
        try {
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':categoria_id', $this->categoria_id);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->bindParam(':precio', $this->precio);
            $stmt->bindParam(':stock', $this->stock);
            $stmt->bindParam(':oferta', $this->oferta);
            $stmt->bindParam(':fecha', $this->fecha);
            $stmt->bindParam(':imagen', $this->imagen);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error al guardar el producto: " . $e->getMessage();
            return false; 
        }
    }

    public function eliminar() {
        try {
            $sql = "DELETE FROM productos WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id', $this->id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al eliminar el producto: " . $e->getMessage();
            return false;
        }
    }

    public function editar() {
        try {
            
            $sql = "
            UPDATE productos 
            SET nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, categoria_id = :categoria_id
            ";

            if ($this->getImagen() != null) {
                $sql .= ", imagen = :imagen";
            }

            $sql .= " WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->bindParam(':precio', $this->precio);
            $stmt->bindParam(':stock', $this->stock);
            $stmt->bindParam(':categoria_id', $this->categoria_id);
            $stmt->bindParam(':id', $this->id);

            if ($this->getImagen() != null) {
                $stmt->bindParam(':imagen', $this->imagen);
            }

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al actualizar producto: " . $e->getMessage();
            return false;
        }
    }
}

?>