<?php
// Verifica si la variable $categoria está definida y no es nula.
if (isset($categoria)) : ?>
    <!-- Muestra el nombre de la categoría como título. -->
    <h1><?= $categoria->nombre; ?></h1>
    
    <?php
    // Verifica si no hay productos en la categoría.
    if (empty($productos)): ?>
        <!-- Muestra un mensaje si no hay productos disponibles. -->
        <p>No hay productos para mostrar.</p>
    <?php else: ?>
        <!-- Recorre cada producto en la categoría. -->
        <?php foreach ($productos as $pro): ?>
            <div id="products">
                <!-- Enlace para ver los detalles del producto. -->
                <a href="<?= URL_BASE; ?>producto/ver&id=<?= $pro->id; ?>">
                
                <?php
                // Verifica si el producto tiene una imagen.
                if ($pro->imagen != null) : ?>
                    <!-- Muestra la imagen del producto si está disponible. -->
                    <img src="<?= URL_BASE; ?>imagenesSubidas/<?= $pro->imagen; ?>">
                <?php else : ?>
                    <!-- Muestra una imagen por defecto si no hay imagen disponible. -->
                    <img src="<?= URL_BASE; ?>assets/imagenes/bolso1.jpeg">
                <?php endif; ?>
                
                <!-- Muestra el nombre del producto. -->
                <h2><?= $pro->nombre; ?></h2>
                </a>

                <!-- Muestra el precio del producto. -->
                <p>$<?= $pro->precio; ?></p>
                
                <!-- Enlace para agregar el producto al carrito. -->
                <a href="<?= URL_BASE; ?>carrito/agregar&id=<?= $pro->id; ?>" class="btn">Comprar</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

<?php else : ?>
    <!-- Muestra un mensaje si la categoría no existe. -->
    <h1>La categoría no existe</h1>
<?php endif; ?>