<?php

session_start();

require_once 'autoload.php';
require_once './config/database.php';
require_once './lib/utilidades.php';
require_once './config/config.php';
require_once './views/layout/header.php';
require_once './views/layout/sidebar.php';

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