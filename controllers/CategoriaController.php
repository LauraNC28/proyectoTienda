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
        require_once 'views/categoria/ver.php';
    }

    public function eliminar() {
        // Verifica si el usuario es administrador llamando al método estático 'esAdmin' de la clase Utils.
        // Si no es administrador, se redirigirá o se lanzará un error.
        Utils::esAdmin(); 
    
        // Verifica si se ha recibido un parámetro 'id' a través de la URL (GET).
        if (isset($_GET['id'])) {
            // Crea una nueva instancia de la clase Categoria.
            $categoria = new Categoria();
    
            // Asigna el ID recibido por GET al objeto Categoria.
            $categoria->setId($_GET['id']);
    
            // Intenta eliminar la categoría llamando al método 'borrar' del objeto Categoria.
            // El método 'borrar' devuelve un valor booleano que indica si la operación fue exitosa.
            $eliminado = $categoria->borrar();
          
            // Si la categoría se eliminó correctamente, se establece un mensaje de éxito en la sesión.
            if ($eliminado) {
                $_SESSION['mensaje'] = "Categoría eliminada correctamente.";
            } else {
                // Si no se pudo eliminar la categoría, se establece un mensaje de error en la sesión.
                $_SESSION['error'] = "No se pudo eliminar la categoría.";
            }
        }
      
        // Redirige al usuario a la página de listado de categorías (index) después de realizar la operación.
        // 'URL_BASE' es una constante que define la URL base de la aplicación.
        header("Location: " . URL_BASE . "categoria/index");
    
        // Finaliza la ejecución del script para evitar que se siga ejecutando código después de la redirección.
        exit();
    }
}

?>