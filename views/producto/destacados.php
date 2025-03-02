<h1>Algunos de nuestros productos destacados</h1>

<?php 
// Crea una nueva instancia de la clase Producto
$producto = new Producto();

// Obtiene 2 productos aleatorios
$productos = $producto->productoRandom(2);

// Verifica si hay productos disponibles y si la cantidad es mayor a 0
if ($productos && count($productos) > 0):
    // Recorre cada producto y muestra su información
    foreach ($productos as $pro) : ?>
    
    <div id="products">
        <!-- Enlace al detalle del producto -->
        <a href="<?= URL_BASE; ?>producto/ver&id=<?= htmlspecialchars($pro['id']); ?>">
        
        <!-- Muestra la imagen del producto si existe, si no, usa una imagen por defecto -->
        <?php if (!empty($pro['imagen'])) : ?>
            <img src="<?= URL_BASE; ?>imagenesSubidas/<?= htmlspecialchars($pro['imagen']); ?>">
        <?php else : ?>
            <img src="<?= URL_BASE; ?>assets/imagenes/bolso1.jpeg">
        <?php endif; ?>
        
        <!-- Muestra el nombre del producto -->
        <h2><?= htmlspecialchars($pro['nombre']); ?></h2>
        </a>

        <!-- Muestra el precio del producto con formato adecuado -->
        <p><?= number_format($pro['precio'], 2, '.', ','); ?>€</p>

        <!-- Botón para agregar el producto al carrito -->
        <a href="<?= URL_BASE; ?>carrito/agregar&id=<?= htmlspecialchars($pro['id']); ?>" class="btn">Comprar</a>
    </div>
    
    <?php endforeach; 
else:
    // Si no hay productos disponibles, muestra un mensaje
    echo "<p>No se encontraron productos.</p>";
endif;
?>