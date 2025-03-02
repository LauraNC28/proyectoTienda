<?php

// Define la clase Usuario, que representa un usuario en la base de datos.
class Usuario {
    // Propiedades privadas de la clase.
    private $id; // Almacena el ID del usuario.
    private $nombre; // Almacena el nombre del usuario.
    private $apellidos; // Almacena los apellidos del usuario.
    private $email; // Almacena el correo electrónico del usuario.
    private $password; // Almacena la contraseña del usuario.
    private $rol; // Almacena el rol del usuario (por ejemplo, 'user' o 'admin').
    private $imagen; // Almacena la ruta de la imagen de perfil del usuario.
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

    // Método para guardar un nuevo usuario en la base de datos.
    public function guardarBase() {
        $sql = "
        INSERT INTO usuarios (nombre, apellidos, email, password, rol, imagen) 
        VALUES (:nombre, :apellidos, :email, :password, 'user', :imagen)
        ";
        
        try {
            $stmt = $this->db->prepare($sql);

            // Asocia los parámetros de la consulta con las propiedades de la clase.
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->getPassword()); // Guarda la contraseña hasheada.
            $stmt->bindParam(':imagen', $this->imagen);

            $stmt->execute();

            return true; // Retorna true si la operación fue exitosa.
        } catch (PDOException $e) {
            echo "Error al guardar usuario: " . $e->getMessage();
            return false; // Retorna false si ocurre un error.
        }
    }

    // Método para autenticar a un usuario (login).
    public function login() {
        $result = false; // Inicializa el resultado como false.
        $email = $this->email; // Obtiene el email del usuario.
        $password = $this->password; // Obtiene la contraseña del usuario.

        try {
            // Consulta SQL para obtener el usuario por su email.
            $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
    
            // Verifica si se encontró un usuario con el email proporcionado.
            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch(PDO::FETCH_OBJ);

                // Verifica si la contraseña proporcionada coincide con la contraseña hasheada.
                if (password_verify($password, $usuario->password)) {
                    $result = $usuario; // Si coincide, retorna el objeto usuario.
                }
            }
        } catch (PDOException $e) {
            echo "Error en el login: " . $e->getMessage();
        }
    
        return $result; // Retorna el resultado del login.
    }
}

?>