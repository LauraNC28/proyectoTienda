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

        $producto = $this->db->query($sql);

        return $producto;
    }

    /*public function obtenerUno() {
        $sql = "
        SELECT * FROM pedidos
        WHERE id = {$this->getId()};
        ";

        $producto = $this->db->query($sql);

        return $producto->fetch_object();
    }*/

    /*public function obtenerUnoPorUsuario() {
        $sql = "
        SELECT id, coste FROM pedidos
        WHERE usuario_id = {$this->getUsuario_id()}
        ORDER BY id DESC LIMIT 1;
        ";

        $pedido = $this->db->query($sql);

        return $pedido->fetch_object();
    }*/

    /*public function obtenerTodoPorUsuario() {
        $sql = "
        SELECT * FROM pedidos
        WHERE usuario_id = {$this->getUsuario_id()}
        ORDER BY id DESC;
        ";

        $pedido = $this->db->query($sql);

        return $pedido;
    }*/

    public function productosPorPedido($id) {
      // $sql = "
      //   SELECT * FROM productos
      //   WHERE id IN 
      //   (SELECT producto_id FROM lineas_pedidos WHERE pedido_id = {$id});
      // ";
        $sql = "
        SELECT pr.*, lp.unidades FROM productos pr
        INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id
        WHERE lp.pedido_id = {$id};
        ";

        $productos = $this->db->query($sql);

        return $productos;
    }

    public function guardar() {
        $sql = "
        INSERT INTO pedidos
        VALUES (null, '{$this->getUsuario_id()}', '{$this->getProvincia()}', '{$this->getLocalidad()}', '{$this->getDireccion()}', {$this->getCoste()}, 'Confirmado', CURDATE(), CURTIME());
        ";
      
        $guardar = $this->db->query($sql);
        $resul = false;

        if ($guardar) {
            $resul = true;
        }

        return $resul;
    }

    public function guardar_linea() {
        try {
            // Iniciar una transacción
            $this->db->beginTransaction();
    
            // Obtener el último ID insertado en la tabla de pedidos
            $sql = "SELECT LAST_INSERT_ID() AS pedido;";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $pedido_id = $stmt->fetch(PDO::FETCH_ASSOC)['pedido'];
    
            // Recorrer los productos en el carrito
            foreach ($_SESSION['carrito'] as $value) {
                $producto = $value['producto'];
    
                // Insertar cada producto en la tabla lineas_pedidos
                $insertar = "
                INSERT INTO lineas_pedidos
                VALUES (null, :pedido_id, :producto_id, :unidades);
                ";
    
                $stmt = $this->db->prepare($insertar);
                $stmt->execute([
                    'pedido_id' => $pedido_id,
                    'producto_id' => $producto->id,
                    'unidades' => $value['unidades']
                ]);
            }
    
            // Confirmar la transacción
            $this->db->commit();
            return true; // Éxito
        } catch (PDOException $e) {
            // Revertir la transacción en caso de error
            $this->db->rollBack();
            echo "Error: " . $e->getMessage(); // Manejar el error
            return false; // Fallo
        }
    }
}

?>