<?php

class Pedido {
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

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

    public function obtenerTodo() {
        $sql = "
        SELECT * FROM pedidos 
        ORDER BY id DESC;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

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

    public function guardar_linea() {
        $sql = "SELECT LAST_INSERT_ID() AS pedido_id;";
        
        $stmt = $this->db->query($sql);
        $pedido_id = $stmt->fetch(PDO::FETCH_OBJ)->pedido_id;
    
        // Recorrer los productos en el carrito
        foreach ($_SESSION['carrito'] as $value) {
            $producto = $value['producto'];
    
            // Insertar cada producto en la tabla lineas_pedidos
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