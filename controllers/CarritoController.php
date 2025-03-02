<?php

// Incluye el archivo del modelo 'Producto' para poder utilizar la clase Producto.
require_once 'models/producto.php';

// Define la clase CarritoController, que maneja las acciones relacionadas con el carrito de compras.
class CarritoController {
    // Método para mostrar la vista del carrito.
    public function index() {
        // Si la sesión 'carrito' no está definida pero existe una cookie 'carrito', se restaura la sesión
        if (!isset($_SESSION['carrito']) && isset($_COOKIE['carrito'])) {
            // Decodificar el contenido de la cookie 'carrito' (convertir de JSON a array)
            $_SESSION['carrito'] = json_decode($_COOKIE['carrito'], true);
        }
        
        // Incluye la vista que muestra el contenido del carrito.
        require_once 'views/carrito/index.php';
    }

    // Método para agregar un producto al carrito.
    public function agregar() {
        // Verifica si se ha pasado un ID de producto por GET.
        if (isset($_GET['id'])) {
            $pro_id = $_GET['id']; // Obtiene el ID del producto.
        } else {
            // Si no se proporciona un ID, redirige a la página principal.
            header('Location:' . URL_BASE);
            exit();
        }

        // Si no existe la variable de sesión 'carrito', la inicializa como un array vacío.
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        
        $cont = 0; // Contador para verificar si el producto ya está en el carrito.

        // Recorre los productos en el carrito.
        foreach ($_SESSION['carrito'] as $clave => $valor) {
            // Si el producto ya está en el carrito, incrementa la cantidad.
            if ($valor['id_producto'] == $pro_id) {
                $_SESSION['carrito'][$clave]['unidades']++;
                $cont++; // Incrementa el contador.
            }
        }

        // Si el producto no está en el carrito, lo agrega.
        if (!isset($cont) || $cont == 0) {
            // Crea una instancia del modelo Producto y obtiene los detalles del producto.
            $producto = new Producto();
            $producto->setId($pro_id);
            $producto = $producto->obtenerUno();
            
            // Si el producto es válido, lo agrega al carrito.
            if (is_object($producto)) {
                $_SESSION['carrito'][] = array(
                'id_producto' => $producto->id, // ID del producto.
                'precio' => $producto->precio, // Precio del producto.
                'unidades' => 1, // Cantidad inicial.
                'producto' => $producto // Objeto completo del producto.
                );
            }
        }

        // Establecer una cookie llamada 'carrito' con el contenido del carrito de la sesión
        setcookie(
            'carrito', // Nombre de la cookie
            json_encode($_SESSION['carrito']), // Valor de la cookie (convierte el carrito en formato JSON)
            time() + (7 * 86400), // Expiración: 7 días desde el momento actual
            "/", // Ruta de la cookie (disponible en todo el sitio)
            "", // Dominio (vacío para el dominio actual)
            false, // No usar HTTPS (true si solo debe enviarse en conexiones seguras)
            true // Habilitar la bandera HttpOnly (evita acceso a la cookie desde JavaScript)
        );

        // Redirige a la página del carrito.
        header('Location:' . URL_BASE . 'carrito/index'); 
        exit(); 
    }

    // Método para quitar un producto del carrito.
    public function quitar() {
        // Verifica si se ha pasado un índice por GET.
        if (isset($_GET['index'])) {
            $index = $_GET['index']; // Obtiene el índice del producto en el carrito.
            unset($_SESSION['carrito'][$index]); // Elimina el producto del carrito.

            // Establecer una cookie llamada 'carrito' con el contenido del carrito de la sesión
            setcookie(
                'carrito', // Nombre de la cookie
                json_encode($_SESSION['carrito']), // Valor de la cookie (convierte el carrito en formato JSON)
                time() + (7 * 86400), // Expiración: 7 días desde el momento actual
                "/", // Ruta de la cookie (disponible en todo el sitio)
                "", // Dominio (vacío para el dominio actual)
                false, // No usar HTTPS (true si solo debe enviarse en conexiones seguras)
                true // Habilitar la bandera HttpOnly (evita acceso a la cookie desde JavaScript)
            );
        }

        // Redirige a la página del carrito.
        header('Location:' . URL_BASE . 'carrito/index');
        exit();
    }

    // Método para incrementar la cantidad de un producto en el carrito.
    public function mas() {
        // Verifica si se ha pasado un índice por GET.
        if (isset($_GET['index'])) {
            $index = $_GET['index']; // Obtiene el índice del producto en el carrito.
            $_SESSION['carrito'][$index]['unidades']++; // Incrementa la cantidad.
        
            // Establecer una cookie llamada 'carrito' con el contenido del carrito de la sesión
            setcookie(
            'carrito', // Nombre de la cookie
            json_encode($_SESSION['carrito']), // Valor de la cookie (convierte el carrito en formato JSON)
            time() + (7 * 86400), // Expiración: 7 días desde el momento actual
            "/", // Ruta de la cookie (disponible en todo el sitio)
            "", // Dominio (vacío para el dominio actual)
            false, // No usar HTTPS (true si solo debe enviarse en conexiones seguras)
            true // Habilitar la bandera HttpOnly (evita acceso a la cookie desde JavaScript)
            );
        }

        // Redirige a la página del carrito.
        header('Location:' . URL_BASE . 'carrito/index');
        exit();
    }

    // Método para reducir la cantidad de un producto en el carrito.
    public function menos() {
        // Verifica si se ha pasado un índice por GET.
        if (isset($_GET['index'])) {
            $index = $_GET['index']; // Obtiene el índice del producto en el carrito.
            $_SESSION['carrito'][$index]['unidades']--; // Reduce la cantidad.

            // Si la cantidad llega a 0, elimina el producto del carrito.
            if ($_SESSION['carrito'][$index]['unidades'] == 0) {
                unset($_SESSION['carrito'][$index]);
            }

            // Establecer una cookie llamada 'carrito' con el contenido del carrito de la sesión
            setcookie(
                'carrito', // Nombre de la cookie
                json_encode($_SESSION['carrito']), // Valor de la cookie (convierte el carrito en formato JSON)
                time() + (7 * 86400), // Expiración: 7 días desde el momento actual
                "/", // Ruta de la cookie (disponible en todo el sitio)
                "", // Dominio (vacío para el dominio actual)
                false, // No usar HTTPS (true si solo debe enviarse en conexiones seguras)
                true // Habilitar la bandera HttpOnly (evita acceso a la cookie desde JavaScript)
            );
        }

        // Redirige a la página del carrito.
        header('Location:' . URL_BASE . 'carrito/index');
        exit();
    }

    // Método para eliminar todos los productos del carrito.
    public function eliminarTodo() {
        // Elimina la variable de sesión 'carrito'.
        unset($_SESSION['carrito']);

        // Establecer una cookie llamada 'carrito' con el contenido del carrito de la sesión
        setcookie(
            'carrito', // Nombre de la cookie
            json_encode($_SESSION['carrito']), // Valor de la cookie (convierte el carrito en formato JSON)
            time() + (7 * 86400), // Expiración: 7 días desde el momento actual
            "/", // Ruta de la cookie (disponible en todo el sitio)
            "", // Dominio (vacío para el dominio actual)
            false, // No usar HTTPS (true si solo debe enviarse en conexiones seguras)
            true // Habilitar la bandera HttpOnly (evita acceso a la cookie desde JavaScript)
        );

        // Redirige a la página del carrito.
        header('Location:' . URL_BASE . 'carrito/index'); 
        exit();
    }
}

?>