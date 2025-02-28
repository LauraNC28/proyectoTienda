<?php

class Usuario {
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;
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

        return $this;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return password_hash($this->password, PASSWORD_BCRYPT, ["cost" => 4]);
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function guardarBase() {
        $sql = "
        INSERT INTO usuarios (nombre, apellidos, email, password, rol, imagen) 
        VALUES (:nombre, :apellidos, :email, :password, 'user', :imagen)
        ";
        
        try {
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':imagen', $this->imagen);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error al guardar usuario: " . $e->getMessage();
            return false; 
        }
    }

    public function login() {
        $resul = false;
        $email = $this->email;
        $password = $this->password;

        try {
            $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch(PDO::FETCH_OBJ);

                if (password_verify($password, $usuario->password)) {
                    $result = $usuario;
                }
            }
        } catch (PDOException $e) {
            echo "Error en el login: " . $e->getMessage();
        }
    
        return $result;
    }
}

?>