<?php

// Incluye el archivo del modelo 'Pedido' para poder utilizar la clase Pedido.
require_once 'models/pedido.php';
require_once 'helpers/email.php';

// Define la clase PedidoController, que maneja las acciones relacionadas con los pedidos.
class PedidoController {
    // Método para mostrar la vista de realizar un pedido.
    public function hacer() {
        // Incluye la vista que permite al usuario realizar un pedido.
        require_once 'views/pedido/hacer.php';
    }

    // Método para agregar un pedido a la base de datos.
    public function agregar()  {
        // Verifica si el usuario está autenticado.
        if (isset($_SESSION['identidad'])) {
            $usuario_id = $_SESSION['identidad']->id; // Obtiene el ID del usuario autenticado.
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false; // Obtiene la provincia del formulario.
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false; // Obtiene la localidad del formulario.
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false; // Obtiene la dirección del formulario.

            // Obtiene estadísticas del carrito (por ejemplo, el coste total).
            $estad = Utils::estadisticaCarrito();
            $coste = $estad['total'];

            // Verifica que todos los campos necesarios estén presentes.
            if ($provincia && $localidad && $direccion) {
                // Crea una instancia del modelo Pedido.
                $pedido = new Pedido();
                $pedido->setUsuario_id($usuario_id); // Asigna el ID del usuario.
                $pedido->setProvincia($provincia); // Asigna la provincia.
                $pedido->setLocalidad($localidad); // Asigna la localidad.
                $pedido->setDireccion($direccion); // Asigna la dirección.
                $pedido->setCoste($coste); // Asigna el coste total.

                // Guarda el pedido en la base de datos.
                $guardar = $pedido->guardar();
                // Guarda las líneas del pedido (productos asociados).
                $guardar_linea = $pedido->guardar_linea();

                // Verifica si el pedido y las líneas se guardaron correctamente.
                if ($guardar && $guardar_linea) {
                    $_SESSION['pedido'] = 'Completo'; // Establece un mensaje de éxito.
                } else {
                    $_SESSION['pedido'] = 'Error'; // Establece un mensaje de error.
                }
            } else {
                $_SESSION['pedido'] = 'Error'; // Establece un mensaje de error si faltan datos.
            }

            // Redirige a la página de confirmación del pedido.
            header('Location:' . URL_BASE . 'pedido/confirmado');

        } else {
            // Si el usuario no está autenticado, redirige a la página principal.
            header('Location:' . URL_BASE);
        }
    }

    // Método para mostrar la vista de confirmación del pedido.
    public function confirmado() {
        // Verifica si el usuario está autenticado.
        if (isset($_SESSION['identidad'])) {
            $identidad = $_SESSION['identidad']; // Obtiene los datos del usuario autenticado.
            $pedido = new Pedido();
            $pedido->setUsuario_id($identidad->id); // Asigna el ID del usuario.

            // Obtiene el último pedido realizado por el usuario.
            $pedido = $pedido->obtenerUnoPorUsuario();

            // Si el pedido existe, obtiene los productos asociados.
            if ($pedido) {
                $pedido_productos = new Pedido();
                $productos = $pedido_productos->productosPorPedido($pedido->id);

                $detallesPedido = [
                'productos' => [],
                'total' => $pedido->coste
                ];

                foreach ($productos as $producto) {
                    $detallesPedido['productos'][] = [
                    'nombre' => $producto->nombre,
                    'cantidad' => $producto->unidades,
                    'precio' => $producto->precio
                    ];
                }

                $resultadoCorreo = enviarCorreoPedido($identidad->email, $identidad->nombre, $detallesPedido);

                if ($resultadoCorreo === true) {
                    $_SESSION['mensaje'] = "Pedido realizado con éxito. Te hemos enviado un correo.";
                } else {
                    $_SESSION['error'] = "Error al enviar el correo: " . $resultadoCorreo;
                }
            }
        }

        // Incluye la vista de confirmación del pedido.
        require_once 'views/pedido/confirmado.php';
    }

    // Método para mostrar los pedidos del usuario autenticado.
    public function misPedidos() {
        // Verifica si el usuario está autenticado.
        Utils::login();

        $usuario_id = $_SESSION['identidad']->id; // Obtiene el ID del usuario autenticado.
        $pedido = new Pedido();
        $pedido->setUsuario_id($usuario_id); // Asigna el ID del usuario.
        $pedidos = $pedido->obtenerTodoPorUsuario(); // Obtiene todos los pedidos del usuario.

        // Incluye la vista que muestra los pedidos del usuario.
        require_once 'views/pedido/misPedidos.php';
    }

    // Método para mostrar los detalles de un pedido específico.
    public function detalle()  {
        // Verifica si el usuario está autenticado.
        Utils::login();

        // Verifica si se ha proporcionado un ID de pedido por GET.
        if (isset($_GET['id'])) {
            $id = $_GET['id']; // Obtiene el ID del pedido.

            $pedido = new Pedido();
            $pedido->setId($id); // Asigna el ID del pedido.
            $pedido = $pedido->obtenerUnoPorUsuario(); // Obtiene los detalles del pedido.

            $pedido_productos = new Pedido();
            $productos = $pedido_productos->productosPorPedido($id); // Obtiene los productos del pedido.

            // Incluye la vista que muestra los detalles del pedido.
            require_once 'views/pedido/detalle.php';
        } else {
            // Si no se proporciona un ID, redirige a la lista de pedidos del usuario.
            header('Location:' . URL_BASE . 'pedido/misPedidos');
        }
    }

    // Método para gestionar los pedidos (solo para administradores).
    public function gestion() {
        // Verifica si el usuario es administrador.
        Utils::esAdmin();

        $gestion = true; // Indica que se está en modo de gestión.
        $pedido = new Pedido();
        $pedidos = $pedido->obtenerTodo(); // Obtiene todos los pedidos.

        // Incluye la vista que muestra la lista de pedidos (modo administrador).
        require_once 'views/pedido/misPedidos.php';
    }

    // Método para actualizar el estado de un pedido (solo para administradores).
    public function estado() {
        // Verifica si el usuario es administrador.
        Utils::esAdmin();

        // Verifica si se han enviado el ID del pedido y el nuevo estado por POST.
        if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
            $id = $_POST['pedido_id']; // Obtiene el ID del pedido.
            $estado = $_POST['estado']; // Obtiene el nuevo estado.

            $pedido = new Pedido();
            $pedido->setId($id); // Asigna el ID del pedido.
            $pedido->setEstado($estado); // Asigna el nuevo estado.
            $pedido->actualizarUnPedido(); // Actualiza el estado del pedido.

            // Redirige a la página de detalles del pedido actualizado.
            header('Location:' . URL_BASE . 'pedido/detalle&id=' . $id);
        } else {
            // Si no se proporcionan datos, redirige a la página principal.
            header('Location:' . URL_BASE);
        }
        
    }
}

?>