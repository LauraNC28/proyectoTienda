<?php

require_once './models/categoria.php';
require_once './models/producto.php';

class CategoriaController {
    public function index() {
        Utils::esAdmin();
        $categoria = new Categoria();
        $categorias = $categoria->obtenerTodo();

        require_once './views/categoria/index.php';
    }

    public function ver() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Conseguir categoria
            $categoria = new Categoria();
            $categoria->setId($id);
            //$categoria = $categoria->obtenerUno();

            // Conseguir productos
            $producto = new Producto();
            $producto->setCategoria_id($id);
            $productos = $producto->obtenerTodoCategoria();
        }

        require_once './views/categoria/ver.php';
    }

    public function crear() {
        Utils::esAdmin();

        require_once './views/categoria/crear.php';
    }

    public function guardar() {
        Utils::esAdmin();

        if (isset($_POST) && isset($_POST['nombre'])) {
            $categoria = new Categoria();
            $categoria->setNombre($_POST['nombre']);

            $categoria->guardarBase();
        }

        header('Location:' . URL_BASE . 'categoria/index');
    }
}

?>