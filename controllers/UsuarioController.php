<?php

// Incluye el archivo del modelo 'Usuario' para poder utilizar la clase Usuario.
require_once 'models/usuario.php';

// Define la clase UsuarioController, que maneja las acciones relacionadas con los usuarios.
class UsuarioController {
    // Método para mostrar la página principal del controlador de usuarios.
    public function index() {
		// Muestra un mensaje simple indicando que se está en la acción index del controlador de usuarios.
        echo "Controlador de usuarios, acción index";
	}
    
    // Método para mostrar el formulario de registro de usuarios.
    public function registro() {
        // Incluye la vista del formulario de registro.
        require_once 'views/usuario/formregistro.php';
    }

    // Método para guardar un nuevo usuario en la base de datos.
    public function guardar() {
        // Verifica si se ha enviado el formulario de registro.
        if (isset($_POST)) {
            // Obtiene los datos del formulario.
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;

            // Array para almacenar errores de validación.
            $errores = [];

            // Validación del campo nombre.
            if (empty($nombre)) {
                $errores[] = "El nombre es obligatorio.";
            }

            // Validación del campo apellidos.
            if (empty($apellidos)) {
                $errores[] = "Los apellidos son obligatorios.";
            }

            // Validación del campo email.
            if (empty($email)) {
                $errores[] = "El correo electrónico es obligatorio.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El correo electrónico no tiene un formato válido.";
            }

            // Validación del campo password.
            if (empty($password)) {
                $errores[] = "La contraseña es obligatoria.";
            } elseif (strlen($password) < 8) {
                $errores[] = "La contraseña debe tener al menos 8 caracteres.";
            }

            // Si hay errores de validación, se almacenan en la sesión y se redirige al formulario de registro.
            if (count($errores) > 0) {
                $_SESSION['registro'] = 'falla'; // Indica que el registro falló.
                $_SESSION['errores'] = $errores; // Almacena los errores en la sesión.

                // Redirige al formulario de registro.
                header("Location: " . URL_BASE . "/usuario/registro");
                exit;
            }

            // Si no hay errores, se procede a guardar el usuario en la base de datos.
            $usuario = new Usuario();
            $usuario->setNombre($nombre); // Asigna el nombre.
            $usuario->setApellidos($apellidos); // Asigna los apellidos.
            $usuario->setEmail($email); // Asigna el email.
            $usuario->setPassword($password); // Asigna la contraseña.

            // Guarda el usuario en la base de datos.
            $guardar = $usuario->guardarBase();

            // Verifica si el guardado fue exitoso.
            if ($guardar) {
                $_SESSION['registro'] = 'completado'; // Indica que el registro fue exitoso.
            } else {
                $_SESSION['registro'] = 'falla'; // Indica que el registro falló.
            }
        } else {
            $_SESSION['registro'] = 'falla'; // Indica que el registro falló si no se envió el formulario.
        }

        // Redirige al formulario de registro.
        header('Location:' . URL_BASE . '/usuario/registro');
    }

    // Método para manejar el inicio de sesión de un usuario.
    public function login() {
        // Verifica si se ha enviado el formulario de inicio de sesión.
        if (isset($_POST)) {
            $usuario = new Usuario();
            $usuario->setEmail($_POST['email']); // Asigna el email.
            $usuario->setPassword($_POST['password']); // Asigna la contraseña.

            // Intenta autenticar al usuario.
            $identificacion = $usuario->login();

            // Si la autenticación es exitosa, se almacena la información del usuario en la sesión.
            if ($identificacion) {
                $_SESSION['identidad'] = $identificacion; // Almacena los datos del usuario.

                // Si el usuario es administrador, se establece una sesión especial para él.
                if ($identificacion->rol == 'admin') {
                    $_SESSION['admin'] = true;
                }

                // Establecer una cookie llamada 'usuario' con el valor del email del usuario identificado
                setcookie(
                'usuario', // Nombre de la cookie
                $identificacion->email, // Valor de la cookie (el email del usuario)
                time() + (7 * 86400), // Expiración: 7 días desde el momento actual
                "/", // Ruta de la cookie (disponible en todo el sitio)
                "", // Dominio (vacío para el dominio actual)
                false, // No usar HTTPS (true si solo debe enviarse en conexiones seguras)
                true // Habilitar la bandera HttpOnly (evita acceso a la cookie desde JavaScript)
                );

            } else {
                // Si la autenticación falla, se almacena un mensaje de error en la sesión.
                $_SESSION['error_login'] = 'Identificación fallida';
            }
        }

        // Redirige a la página principal.
        header('Location:' . URL_BASE);
    }

    // Método para cerrar la sesión de un usuario.
    public function logout() {
        // Elimina la información del usuario de la sesión.
        if (isset($_SESSION['identidad'])) {
            unset($_SESSION['identidad']);
        }

        // Elimina la sesión de administrador si existe.
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }

        // Redirige a la página principal.
        header('Location:' . URL_BASE);
    }
}

?>