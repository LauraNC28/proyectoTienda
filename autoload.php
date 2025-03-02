<?php

// Función para cargar automáticamente los controladores
function controllers_autoload($classname){
    // Incluye el archivo del controlador correspondiente a la clase
    include 'controllers/' . $classname . '.php';
}

// Registra la función de autoload para que PHP la use cuando se intente cargar una clase
spl_autoload_register('controllers_autoload');