<h1>Algunos de nuestros productos destacados</h1>

<?php $producto = new Producto();

$productos = $producto->productoRandom(2);

if ($productos && count($productos) > 0):
    foreach ($productos as $pro) : ?>
    <div id="products">
        <a href="<?= URL_BASE; ?>producto/ver&id=<?= htmlspecialchars($pro['id']); ?>">
        
        <?php if (!empty($pro['imagen'])) : ?>
            <img src="<?= URL_BASE; ?>imagenesSubidas/<?= htmlspecialchars($pro['imagen']); ?>">
        <?php else : ?>
            <img src="<?= URL_BASE; ?>assets/imagenes/bolso1.jpeg">
        <?php endif; ?>
        
        <h2><?= htmlspecialchars($pro['nombre']); ?></h2>
        </a>

        <p><?= number_format($pro['precio'], 2, '.', ','); ?>€</p>
        <a href="<?= URL_BASE; ?>carrito/agregar&id=<?= htmlspecialchars($pro['id']); ?>" class="btn">Comprar</a>
    </div>
    <?php endforeach; 
else:
    echo "<p>No se encontraron productos.</p>";
endif;?>