<?php

require_once 'models/producto.php';

class ProductoController {
    public function index() {
        $producto = new Producto();
        $productos = $producto->productoRandom(6);

        require_once 'views/producto/destacados.php';
    }

    public function gestion() {
        Utils::esAdmin();

        $producto = new Producto();
        $productos = $producto->obtenerTodo();

        require_once 'views/producto/gestion.php';
    }

    public function crear()  {
        Utils::esAdmin();

        require_once __DIR__ . 'views/producto/crear.php';
    }

    public function guardar() {
        Utils::esAdmin();
      
        if (isset($_POST)) {
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
            $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
            $stock = isset($_POST['stock']) ? $_POST['stock'] : false;
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;

            if ($nombre && $descripcion && $precio && $stock && $categoria) {
                $producto = new Producto();
                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setPrecio($precio);
                $producto->setStock($stock);
                $producto->setCategoria_id($categoria);

                $producto->setOferta(0);

                $producto->setFecha(date('Y-m-d H:i:s'));

                if (isset($_FILES['imagen'])) {
                    $archivo = $_FILES['imagen'];
                    $archivo_nombre = $archivo['name'];
                    $tipo_archivo = $archivo['type'];
                    
                    if ($tipo_archivo == 'image/jpg' || $tipo_archivo == 'image/jpeg' || $tipo_archivo == 'image/png' || $tipo_archivo == 'image/gif') {
                    
                        if (!is_dir('imagenesSubidas')) {
                            mkdir('imagenesSubidas', 0777, true);
                        }
                        
                        $producto->setImagen($archivo_nombre);
                        move_uploaded_file($archivo['tmp_name'], 'imagenesSubidas/' . $archivo_nombre);
                        
                    }
                }

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $producto->setId($id);
                    $guardar = $producto->editar();
                } else {
                    $guardar = $producto->guardar();
                }

                if ($producto->$guardar()) {
                    $_SESSION['producto'] = 'completado';
                } else {
                    $_SESSION['producto'] = 'falla';
                }

            } else {
                $_SESSION['producto'] = 'falla';
            }

        } else {
            $_SESSION['producto'] = 'falla';
        }

        header('Location:' . URL_BASE . 'producto/gestion');
        exit;
    }

    public function editar() {
        Utils::esAdmin();
      
        if (isset($_GET['id'])) {
            $editar = true;
            $producto = new Producto();
            $producto->setId($_GET['id']);

            $pro = $producto->obtenerUno();

            require_once __DIR__ . 'views/productos/crear.php';
        } else {
            header('Location:' . URL_BASE . 'producto/gestion');
        }
    }

    public function eliminar() {
        Utils::esAdmin();
      
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = new Producto();
            $producto->setId($id);
            
            $borrar = $producto->eliminar();

            if ($borrar) {
            $_SESSION['borrar'] = 'completado';
            } else {
            $_SESSION['borrar'] = 'falla';
            }
        } else {
            $_SESSION['borrar'] = 'falla';
        }

        header('Location:' . URL_BASE . 'producto/gestion');
    }
}   

?>