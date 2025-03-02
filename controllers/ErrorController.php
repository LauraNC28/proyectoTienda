<?php

// Define la clase ErrorController, que maneja las acciones relacionadas con errores en la aplicación.
class ErrorController {
    // Método para mostrar una página de error cuando no se encuentra una ruta o recurso.
    public function index() {
        // Muestra un mensaje de error en la página.
        echo '<h1>Error: Página no encontrada</h1>';
    }
}

?>