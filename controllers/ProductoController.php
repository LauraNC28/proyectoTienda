<?php

// Incluye el archivo del modelo 'Producto' para poder utilizar la clase Producto.
require_once 'models/producto.php';

// Define la clase ProductoController, que maneja las acciones relacionadas con los productos.
class ProductoController {
    // Método para mostrar productos destacados en la página principal.
    public function index() {
        // Crea una instancia del modelo Producto.
        $producto = new Producto();
        // Obtiene un número aleatorio de productos destacados (en este caso, 6).
        $producto->productoRandom(4);

        // Incluye la vista que muestra los productos destacados.
        require_once 'views/producto/destacados.php';
    }

    // Método para gestionar los productos (solo para administradores).
    public function gestion() {
        // Crea una instancia del modelo Producto.
        $producto = new Producto();
        // Obtiene todos los productos de la base de datos.
        $producto = $producto->obtenerTodo();

        // Incluye la vista que muestra la lista de productos para su gestión.
        require_once 'views/producto/gestion.php';
    }

    // Método para mostrar el formulario de creación de un nuevo producto (solo para administradores).
    public function crear()  {
        // Verifica si el usuario es administrador.
        Utils::esAdmin();

        // Incluye la vista del formulario de creación de productos.
        require_once 'views/producto/crear.php';
    }

    // Método para guardar un nuevo producto o editar uno existente (solo para administradores).
    public function guardar() {
        // Verifica si el usuario es administrador.
        Utils::esAdmin();

        // Verifica si se ha enviado el formulario.
        if (isset($_POST)) {
            // Obtiene los datos del formulario.
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
            $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
            $stock = isset($_POST['stock']) ? $_POST['stock'] : false;
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;

            // Verifica que todos los campos obligatorios estén presentes.
            if ($nombre && $descripcion && $precio && $stock && $categoria) {
                // Crea una instancia del modelo Producto.
                $producto = new Producto();
                $producto->setNombre($nombre); // Asigna el nombre del producto.
                $producto->setDescripcion($descripcion); // Asigna la descripción.
                $producto->setPrecio($precio); // Asigna el precio.
                $producto->setStock($stock); // Asigna el stock.
                $producto->setCategoria_id($categoria); // Asigna la categoría.

                $producto->setOferta(0); // Establece la oferta como 0 (sin oferta).

                $producto->setFecha(date('Y-m-d H:i:s')); // Asigna la fecha actual.

                // Verifica si se ha subido una imagen.
                if (isset($_FILES['imagen'])) {
                    $archivo = $_FILES['imagen']; // Obtiene el archivo de imagen.
                    $archivo_nombre = $archivo['name']; // Obtiene el nombre del archivo.
                    $tipo_archivo = $archivo['type']; // Obtiene el tipo de archivo.

                    // Verifica que el archivo sea una imagen válida.
                    if ($tipo_archivo == 'image/jpg' || $tipo_archivo == 'image/jpeg' || $tipo_archivo == 'image/png' || $tipo_archivo == 'image/gif') {
                        // Si no existe el directorio para guardar las imágenes, lo crea.
                        if (!is_dir('imagenesSubidas')) {
                            mkdir('imagenesSubidas', 0777, true);
                        }

                        // Asigna el nombre de la imagen al producto.
                        $producto->setImagen($archivo_nombre);
                        // Mueve la imagen subida al directorio de imágenes.
                        move_uploaded_file($archivo['tmp_name'], 'imagenesSubidas/' . $archivo_nombre);
                    }
                }

                // Verifica si se está editando un producto existente.
                if (isset($_GET['id'])) {
                    $id = $_GET['id']; // Obtiene el ID del producto.
                    $producto->setId($id); // Asigna el ID al producto.
                    $guardar = $producto->editar(); // Llama al método para editar el producto.
                } else {
                    $guardar = $producto->guardar(); // Llama al método para guardar un nuevo producto.
                }

                // Verifica si la operación de guardar o editar fue exitosa.
                if ($guardar) {
                    $_SESSION['producto'] = 'completado'; // Establece un mensaje de éxito.
                } else {
                    $_SESSION['producto'] = 'falla'; // Establece un mensaje de error.
                }
            } else {
                $_SESSION['producto'] = 'falla'; // Establece un mensaje de error si faltan datos.
            }
        } else {
            $_SESSION['producto'] = 'falla'; // Establece un mensaje de error si no se envió el formulario.
        }

        // Redirige a la página de gestión de productos.
        header('Location:' . URL_BASE . 'producto/gestion');
        exit();
    }

    // Método para mostrar el formulario de edición de un producto (solo para administradores).
    public function editar() {
        // Verifica si el usuario es administrador.
        Utils::esAdmin();

        // Verifica si se ha proporcionado un ID de producto por GET.
        if (isset($_GET['id'])) {
            $editar = true; // Indica que se está en modo de edición.
            $producto = new Producto();
            $producto->setId($_GET['id']); // Asigna el ID del producto.

            // Obtiene los detalles del producto.
            $pro = $producto->obtenerUno();

            // Incluye la vista del formulario de creación/edición de productos.
            require_once 'views/productos/crear.php';
        } else {
            // Si no se proporciona un ID, redirige a la página de gestión de productos.
            header('Location:' . URL_BASE . 'producto/gestion');
        }
    }

    // Método para eliminar un producto (solo para administradores).
    public function eliminar() {
        // Verifica si el usuario es administrador.
        Utils::esAdmin();

        // Verifica si se ha proporcionado un ID de producto por GET.
        if (isset($_GET['id'])) {
            $id = $_GET['id']; // Obtiene el ID del producto.
            $producto = new Producto();
            $producto->setId($id); // Asigna el ID al producto.

            // Llama al método para eliminar el producto.
            $borrar = $producto->eliminar();

            // Verifica si la eliminación fue exitosa.
            if ($borrar) {
                $_SESSION['borrar'] = 'completado'; // Establece un mensaje de éxito.
            } else {
                $_SESSION['borrar'] = 'falla'; // Establece un mensaje de error.
            }
        } else {
            $_SESSION['borrar'] = 'falla'; // Establece un mensaje de error si no se proporciona un ID.
        }

        // Redirige a la página de gestión de productos.
        header('Location:' . URL_BASE . 'producto/gestion');
    }
}   

?>