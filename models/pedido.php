<?php

// Define la clase Pedido, que representa un pedido en la base de datos.
class Pedido {
    // Propiedades privadas de la clase.
    private $id; // Almacena el ID del pedido.
    private $usuario_id; // Almacena el ID del usuario que realizó el pedido.
    private $provincia; // Almacena la provincia de entrega del pedido.
    private $localidad; // Almacena la localidad de entrega del pedido.
    private $direccion; // Almacena la dirección de entrega del pedido.
    private $coste; // Almacena el coste total del pedido.
    private $estado; // Almacena el estado actual del pedido.
    private $fecha; // Almacena la fecha en que se realizó el pedido.
    private $hora; // Almacena la hora en que se realizó el pedido.
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
        return $this;
    }

    public function getUsuario_id() {
        return $this->usuario_id;
    }

    public function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
        return $this;
    }

    public function getProvincia() {
        return $this->provincia;
    }

    public function setProvincia($provincia) {
        $this->provincia = $provincia;
        return $this;
    }

    public function getLocalidad() {
        return $this->localidad;
    }

    public function setLocalidad($localidad) {
        $this->localidad = $localidad;
        return $this;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
        return $this;
    }

    public function getCoste() {
        return $this->coste;
    }

    public function setCoste($coste) {
        $this->coste = $coste;
        return $this;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
        return $this;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
        return $this;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setHora($hora) {
        $this->hora = $hora;
        return $this;
    }

    // Método para obtener todos los pedidos de la base de datos, ordenados por ID de forma descendente.
    public function obtenerTodo() {
        $sql = "
        SELECT * FROM pedidos 
        ORDER BY id DESC;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Método para obtener un pedido específico por su ID.
    public function obtenerUno() {
        $sql = "
        SELECT * FROM pedidos
        WHERE id = :id;
        ";

        $stmt = $this->db->prepare($sql);

        $id = $this->getId();

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Método para obtener el último pedido realizado por un usuario específico.
    public function obtenerUnoPorUsuario() {
        $usuario_id = $this->getUsuario_id();

        if (is_null($usuario_id)) {
            echo "Error: El ID del usuario es nulo.";
            return false; 
        }

        $sql = "
        SELECT p.id, p.coste FROM pedidos p
        WHERE p.usuario_id = :usuario_id
        ORDER BY id DESC LIMIT 1;
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        return $resultado;
    }

    // Método para obtener todos los pedidos realizados por un usuario específico.
    public function obtenerTodoPorUsuario() {
        $usuario_id = $this->getUsuario_id();
        
        $sql = "
        SELECT * FROM pedidos
        WHERE usuario_id = :usuario_id
        ORDER BY id DESC;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Método para obtener los productos asociados a un pedido específico.
    public function productosPorPedido($id) {
        $sql = "
        SELECT pr.*, lp.unidades FROM productos pr
        "
        . "
        INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id
        "
        . "
        WHERE lp.pedido_id = :pedido_id;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':pedido_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Método para guardar un nuevo pedido en la base de datos.
    public function guardar() {
        $sql = "
        INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora)
        "
        . "
        VALUES (:usuario_id, :provincia, :localidad, :direccion, :coste, 'confirm', CURDATE(), CURTIME())
        ";
      
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':usuario_id', $this->getUsuario_id(), PDO::PARAM_INT);
        $stmt->bindParam(':provincia', $this->getProvincia(), PDO::PARAM_STR);
        $stmt->bindParam(':localidad', $this->getLocalidad(), PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $this->getDireccion(), PDO::PARAM_STR);
        $stmt->bindParam(':coste', $this->getCoste(), PDO::PARAM_STR);

        $result = $stmt->execute();

        return $result;
    }

    // Método para guardar las líneas de pedido (productos asociados a un pedido).
    public function guardar_linea() {
        $sql = "SELECT LAST_INSERT_ID() AS pedido_id;";
        
        $stmt = $this->db->query($sql);
        $pedido_id = $stmt->fetch(PDO::FETCH_OBJ)->pedido_id;
    
        // Recorrer los productos en el carrito.
        foreach ($_SESSION['carrito'] as $value) {
            $producto = $value['producto'];
    
            // Insertar cada producto en la tabla lineas_pedidos.
            $insertar = "
            INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades)
            "
            . "
            VALUES (:pedido_id, :producto_id, :unidades)
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':pedido_id', $pedido_id, PDO::PARAM_INT);
            $stmt->bindParam(':producto_id', $producto->id, PDO::PARAM_INT);
            $stmt->bindParam(':unidades', $value['unidades'], PDO::PARAM_INT);
            $stmt->execute();
        }
        return true;
    }

    // Método para actualizar el estado de un pedido.
    public function actualizarUnPedido() {
        $sql = "UPDATE pedidos SET estado = :estado WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':estado', $this->getEstado(), PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_INT);
        
        $result = $stmt->execute();
        
        return $result;
    }
}

?>