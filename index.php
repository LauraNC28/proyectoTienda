<?php

session_start();

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . './lib/database.php';
require_once __DIR__ . './helpers/utilidades.php';
require __DIR__ . './vendor/autoload.php';
require_once __DIR__ . './config/config.php';
require_once __DIR__ . './config/parametros.php';
require_once __DIR__ . './views/layout/header.php';
require_once __DIR__ . './views/layout/sidebar.php';


use Controllers\ErrorController;

$db = new Database();

function mostrarError() {
    $error = new ErrorController();
    $error->index();
}
  
if (isset($_GET['controller'])) {
    $nombre_controlador = $_GET['controller'] . 'Controller';
} elseif (!isset($_GET['controller']) && !isset($_GET['accion'])) {
    $nombre_controlador = CONTROLLER_DEFAULT;
} else {
    mostrarError();
    exit();
}

if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();
    
    if (isset($_GET['accion']) && method_exists($controlador, $_GET['accion'])) {
        $accion = $_GET['accion'];
        $controlador->$accion();
    } elseif (!isset($_GET['controller']) && !isset($_GET['accion'])) {
        $accion_index = ACCION_DEFAULT;
        $controlador->$accion_index();
    }
    else {
        mostrarError();
    }
} else {
    mostrarError();
}

require_once './views/layout/footer.php';

?>