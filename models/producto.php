<?php

// Define la clase Producto, que representa un producto en la base de datos.
class Producto {
    // Propiedades privadas de la clase.
    private $id; // Almacena el ID del producto.
    private $categoria_id; // Almacena el ID de la categoría a la que pertenece el producto.
    private $nombre; // Almacena el nombre del producto.
    private $descripcion; // Almacena la descripción del producto.
    private $precio; // Almacena el precio del producto.
    private $stock; // Almacena la cantidad de unidades en stock.
    private $oferta; // Almacena si el producto está en oferta (por ejemplo, 'si' o 'no').
    private $fecha; // Almacena la fecha de creación o registro del producto.
    private $imagen; // Almacena la ruta de la imagen del producto.
    private $db; // Almacena la conexión a la base de datos.

    // Constructor de la clase.
    public function __construct() {
        // Obtiene la conexión a la base de datos utilizando el patrón Singleton.
        $this->db = Database::getInstance()->getConnection();
    }

    // Métodos getter y setter para las propiedades de la clase.
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

    // Método para obtener todos los productos de la base de datos, ordenados por ID de forma descendente.
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
            echo "Error al obtener productos: " . $e->getMessage();
            return false;
        }
    }

    // Método para obtener todos los productos de una categoría específica.
    public function obtenerTodoCategoria() {
        try {
            $sql = "
            SELECT p.*, c.nombre AS 'catnombre' FROM productos p 
            "
            . "
            INNER JOIN categorias c ON c.id = p.categoria_id 
            "
            . "
            WHERE p.categoria_id = :categoria_id 
            "
            . "
            ORDER BY p.id DESC
            ";

            $stmt = $this->db->prepare($sql);

            $categoria_id = $this->getCategoria_id(); 

            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);  
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        } catch (PDOException $e) {
            echo "Error al obtener productos por categoría: " . $e->getMessage();
            return false;
        }
    }

    // Método para obtener un producto específico por su ID.
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
            echo "Error al obtener el producto: " . $e->getMessage();
            return false;
        }
    }

    // Método para obtener un número aleatorio de productos.
    public function productoRandom($limite) {
        $sql = "SELECT * FROM productos ORDER BY RAND() LIMIT :limite";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para guardar un nuevo producto en la base de datos.
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

    // Método para eliminar un producto de la base de datos.
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

    // Método para editar un producto existente en la base de datos.
    public function editar() {
        try {
            $sql = "
            UPDATE productos 
            SET nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, categoria_id = :categoria_id
            ";

            // Si se proporciona una nueva imagen, se actualiza el campo de la imagen.
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