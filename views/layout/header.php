<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tienda de Accesorios</title>
    <link rel="stylesheet" href="<?= URL_BASE; ?>./assets/css/estilos.css">
</head>

<body>
    <div id="container">
        <header>
        <div id="logo">
            <img src="<?= URL_BASE; ?>./assets/imagenes/logoTienda.webp" alt="Logo de la tienda">
            <a href="<?= URL_BASE; ?>">Tienda de accesorios</a>
        </div>
    </header>

    
    <nav>
        <ul>
            <?php $categorias = Utils::mostrarCategorias(); ?>
            <li><a href="<?= URL_BASE; ?>">Inicio</a></li>
            <?php foreach ($categorias as $categoria): ?>
			    <div class="categoria-item">
				    <li> <a href=""><?php echo $categoria['nombre']; ?></a></li>
				</div>
			<?php endforeach; ?>
        </ul>
    </nav>

    <main>