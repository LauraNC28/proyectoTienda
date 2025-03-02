<?php

// Incluye los archivos de los modelos 'Categoria' y 'Producto' para poder utilizar sus clases.
require_once 'models/categoria.php';
require_once "models/producto.php";

// Define la clase CategoriaController, que maneja las acciones relacionadas con las categorías.
class CategoriaController {
    // Método para mostrar la lista de todas las categorías.
    public function index() {
        // Crea una instancia del modelo Categoria.
        $categoria = new Categoria();
        // Obtiene todas las categorías de la base de datos.
        $categorias = $categoria->obtenerTodo();

        // Incluye la vista que muestra la lista de categorías.
        require_once 'views/categoria/index.php';
    }

    // Método para mostrar el formulario de creación de una nueva categoría.
    public function crear() {
        // Verifica si el usuario es administrador. Si no lo es, redirige a otra página.
        Utils::esAdmin();

        // Incluye la vista del formulario de creación de categorías.
        require_once 'views/categoria/crear.php';
    }

    // Método para guardar una nueva categoría en la base de datos.
    public function guardar() {
        // Verifica si el usuario es administrador. Si no lo es, redirige a otra página.
        Utils::esAdmin();

        // Verifica si se ha enviado el formulario y si se ha proporcionado un nombre para la categoría.
        if (isset($_POST) && isset($_POST['nombre'])) {
            // Crea una instancia del modelo Categoria.
            $categoria = new Categoria();
            // Asigna el nombre de la categoría enviado por el formulario.
            $categoria->setNombre($_POST['nombre']);

            // Guarda la categoría en la base de datos.
            $categoria->guardarBase();
        }

        // Redirige a la página de lista de categorías.
        header('Location:' . URL_BASE . 'categoria/index');
    }

    // Método para ver los detalles de una categoría y los productos asociados a ella.
    public function ver(){
        // Verifica si se ha pasado un ID de categoría por GET.
        if (isset($_GET['id'])) {
            // Crea una instancia del modelo Categoria.
            $categoria = new Categoria();
            // Asigna el ID de la categoría enviado por GET.
            $categoria->setId($_GET['id']);
            // Obtiene los detalles de la categoría.
            $categoria = $categoria->obtenerUno();

            // Crea una instancia del modelo Producto.
            $producto = new Producto();
            // Asigna el ID de la categoría para obtener los productos asociados.
            $producto->setCategoria_id($_GET['id']);
            // Obtiene todos los productos de la categoría.
            $producto = $producto->obtenerTodoCategoria();
        }

        // Incluye la vista que muestra los detalles de la categoría y sus productos.
        require_once 'views/categorias/ver.php';
    }
}

?>