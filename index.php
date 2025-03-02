<?php

session_start();

require_once 'autoload.php';
require_once 'lib/database.php';
require_once 'config/parametros.php';
require_once 'helpers/utilidades.php';
require_once 'views/layout/header.php';
require_once 'views/layout/sidebar.php';


$db = new Database();

function mostrarError() {
    $error = new ErrorController();
    $error->index();
}
  
// Obtener el controlador y la acción desde la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;

// Si no se especifica un controlador, usar el controlador por defecto
if (empty($controller)) {
    $nombre_controlador = CONTROLLER_DEFAULT;
} else {
    $nombre_controlador = ucfirst($controller) . 'Controller';
}

// Verificar si el controlador existe
if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();

    // Si no se especifica una acción, usar la acción por defecto
    if (empty($action)) {
        $action = ACCION_DEFAULT;
    }

    // Verificar si la acción existe en el controlador
    if (method_exists($controlador, $action)) {
        $controlador->$action();
    } else {
        mostrarError();
    }
} else {
    mostrarError();
}

require_once 'views/layout/footer.php';

?>