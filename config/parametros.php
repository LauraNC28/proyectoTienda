<?php

// Define la URL base de la aplicación.
// Esta constante se utiliza para construir enlaces absolutos en la aplicación.
// En este caso, la URL base es "http://localhost/dashboard/app/".
define("URL_BASE","http://localhost/dashboard/app/");

// Define el controlador predeterminado que se ejecutará cuando no se especifique un controlador en la URL.
// En este caso, el controlador predeterminado es 'ProductoController'.
define('CONTROLLER_DEFAULT', 'ProductoController');

// Define la acción predeterminada que se ejecutará cuando no se especifique una acción en la URL.
// En este caso, la acción predeterminada es 'index', que generalmente es el método principal del controlador.
define('ACCION_DEFAULT', 'index'); 

?>