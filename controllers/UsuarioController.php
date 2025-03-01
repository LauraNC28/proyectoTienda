<?php

require_once 'models/usuario.php';

class UsuarioController {
    public function index() {
		echo "Controlador Usuarios, Acción index";
	}
    
    public function registro() {
        require_once 'views/usuario/formregistro.php';
    }

    public function guardar() {
        if (isset($_POST)) {
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;

			$errores = [];

			if (empty($nombre)) {
				$errores[] = "El nombre es obligatorio.";
			}

			if (empty($apellidos)) {
				$errores[] = "Los apellidos son obligatorios.";
			}

			if (empty($email)) {
				$errores[] = "El correo electrónico es obligatorio.";
			} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errores[] = "El correo electrónico no tiene un formato válido.";
			}

			if (empty($password)) {
				$errores[] = "La contraseña es obligatoria.";
			} elseif (strlen($password) < 8) {
				$errores[] = "La contraseña debe tener al menos 8 caracteres.";
			}

			if (count($errores) > 0) {
				$_SESSION['registro'] = 'falla';
				$_SESSION['errores'] = $errores;
				
                header("Location: " . URL_BASE . "usuario/registro");
				exit; 
			}

                $usuario = new Usuario();
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setEmail($email);
                $usuario->setPassword($password);

                $guardar = $usuario->guardarBase();

                if ($guardar) {
                    $_SESSION['registro'] = 'completado';
                } else {
                    $_SESSION['registro'] = 'falla';
                }

            } else {
                $_SESSION['registro'] = 'falla';
            }

        header('Location:' . URL_BASE . 'usuario/registro');
    }

    public function login() {
        if (isset($_POST)) {
            $usuario = new Usuario();
            $usuario->setEmail($_POST['email']);
            $usuario->setPassword($_POST['password']);

            $identificacion = $usuario->login();

            if ($identificacion) {
                $_SESSION['identidad'] = $identificacion;

                if ($identificacion->rol == 'admin') {
                    $_SESSION['admin'] = true;
                }

            } else {
                $_SESSION['error_login'] = 'Identificación fallida';
            }
      }

        header('Location:' . URL_BASE);
    }

    public function logout() {
        if (isset($_SESSION['identidad'])) {
            $_SESSION['identidad'] = null;
            unset($_SESSION['identidad']);
        }

        if (isset($_SESSION['admin'])) {
            $_SESSION['admin'] = null;
            unset($_SESSION['admin']);
        }

        header('Location:' . URL_BASE);
    }
}

?>