<?php

// Importa la clase Dotenv de la biblioteca vlucas/phpdotenv
use Dotenv\Dotenv;

// Crea una instancia de Dotenv para cargar las variables de entorno desde el archivo .env
// __DIR__ es una constante mágica que devuelve el directorio del archivo actual
// '/../' indica que el archivo .env está en el directorio padre del directorio actual
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

// Carga las variables de entorno definidas en el archivo .env
$dotenv->load();

// Define constantes de configuración de la base de datos usando las variables de entorno cargadas
// DB_HOST es la dirección del servidor de la base de datos
define('DB_HOST', $_ENV['DB_HOST']);

// DB_NAME es el nombre de la base de datos
define('DB_NAME', $_ENV['DB_NAME']);

// DB_USER es el nombre de usuario para conectarse a la base de datos
define('DB_USER', $_ENV['DB_USER']);

// DB_PASSWORD es la contraseña para conectarse a la base de datos
define('DB_PASSWORD', $_ENV['DB_PASS']);

?>