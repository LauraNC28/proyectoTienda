<?php

function controllers_autoload($clase) {
  $clase = str_replace("\\", "/", $clase);
  $archivo = __DIR__ . '../app/controllers/' . $clase . '.php';
  
  if (file_exists($archivo)) {
    require_once $archivo;
  } else {
    die("No se pudo cargar la clase: $clase en $archivo");
  }
}

spl_autoload_register('controllers_autoload');

?>