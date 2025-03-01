<?php

require_once __DIR__ . '/../models/categoria.php';

class CategoriaController {
    public function index() {
        $categoria = new Categoria();
        $categorias = $categoria->obtenerTodo();

        require_once __DIR__ . '/../views/categoria/index.php';
    }

    public function crear() {
        Utils::esAdmin();

        require_once __DIR__ . '/../views/categoria/crear.php';
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