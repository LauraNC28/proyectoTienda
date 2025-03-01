<?php if (isset($categoria)) : ?>
    <h1><?= $categoria->nombre; ?></h1>
    
    <?php if ($productos->num_rows == 0) : ?>
        <p>No hay productos para mostrar.</p>
    <?php else : ?>
        <?php while ($pro = $productos->fetch_object()) : ?>
            <div id="products">
                <a href="<?= URL_BASE; ?>producto/ver&id=<?= $pro->id; ?>">
                
                <?php if ($pro->imagen != null) : ?>
                    <img src="<?= URL_BASE; ?>subidas/imagenes/<?= $pro->imagen; ?>">
                <?php else : ?>
                    <img src="<?= URL_BASE; ?>assets/imagenes/bolso1.jpeg">
                <?php endif; ?>
                
                <h2><?= $pro->nombre; ?></h2>
                </a>

                <p>$<?= $pro->precio; ?></p>
                <a href="<?= URL_BASE; ?>carrito/agregar&id=<?= $pro->id; ?>" class="btn">Comprar</a>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>

<?php else : ?>
    <h1>La categoria no existe</h1>
<?php endif; ?>