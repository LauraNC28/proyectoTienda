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

    public function actualizar() {
        // Define la consulta SQL para actualizar los datos de un usuario en la base de datos.
        $sql = "
        UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email WHERE id = :id
        ";
    
        // Prepara la consulta SQL para su ejecución.
        $stmt = $this->db->prepare($sql);
    
        // Asocia los valores de las propiedades del objeto a los parámetros de la consulta SQL.
        $stmt->bindParam(':nombre', $this->nombre);       // Asocia el nombre del usuario.
        $stmt->bindParam(':apellidos', $this->apellidos); // Asocia los apellidos del usuario.
        $stmt->bindParam(':email', $this->email);         // Asocia el email del usuario.
        $stmt->bindParam(':id', $this->id);               // Asocia el ID del usuario.
    
        // Ejecuta la consulta SQL y retorna true si la actualización fue exitosa, o false si falló.
        return $stmt->execute();
    }

    public function obtenerUno() {
        // Define la consulta SQL para obtener un usuario específico por su ID.
        $sql = "
        SELECT * FROM usuarios WHERE id = :id LIMIT 1
        ";
        
        // Prepara la consulta SQL para su ejecución.
        $stmt = $this->db->prepare($sql);
    
        // Asocia el valor de la propiedad $this->id al parámetro :id en la consulta SQL.
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    
        // Ejecuta la consulta SQL.
        $stmt->execute();
    
        // Verifica si se encontró al menos un registro.
        if ($stmt->rowCount() > 0) {
            // Retorna el resultado como un objeto anónimo.
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
    
        // Retorna null si no se encontró ningún registro.
        return null;
    }

    public function obtenerTodo() {
        // Define la consulta SQL para obtener todos los usuarios de la base de datos.
        $sql = "
        SELECT id, nombre, apellidos, email, rol FROM usuarios
        "; 
    
        // Prepara la consulta SQL para su ejecución.
        $stmt = $this->db->prepare($sql);
        
        // Ejecuta la consulta SQL.
        $stmt->execute();
    
        // Retorna todos los resultados como un array de objetos anónimos.
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }
}

?>