<?php require_once 'config/parametros.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tienda de Accesorios</title>
    <link rel="stylesheet" href="<?= URL_BASE; ?>./assets/css/estilos.css">
</head>

<body>
    <!-- Contenedor principal de la página. -->
    <div id="container">
        <!-- Encabezado de la página. -->
        <header>
            <div id="logo">
                <!-- Logo de la tienda. -->
                <img src="<?= URL_BASE; ?>./assets/imagenes/logoTienda.webp" alt="Logo de la tienda">
                <!-- Enlace al inicio de la tienda. -->
                <a href="<?= URL_BASE; ?>">Tienda de accesorios</a>
            </div>
        </header>

        <!-- Barra de navegación. -->
        <nav>
            <ul>
                <!-- Obtiene las categorías desde la base de datos utilizando el método Utils::mostrarCategorias(). -->
                <?php $categorias = Utils::mostrarCategorias(); ?>
                <!-- Enlace a la página de inicio. -->
                <li><a href="<?= URL_BASE; ?>">Inicio</a></li>
                <!-- Recorre cada categoría y la muestra en la barra de navegación. -->
                <?php foreach ($categorias as $categoria): ?>
                    <div class="categoria-item">
                        <li>
                            <!-- Enlace a la categoría. -->
                            <a href="<?= URL_BASE; ?>categoria/ver&id=<?= $categoria['id'] ?>"><?php echo $categoria['nombre']; ?></a>
                        </li>
                    </div>
                <?php endforeach; ?>
            </ul>
        </nav>
        
        <!-- Contenido principal de la página. -->
        <main>