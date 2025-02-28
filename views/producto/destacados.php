<h1>Algunos de nuestros productos destacados</h1>

<?php while ($pro = $productos->fetch(PDO::FETCH_OBJ)) : ?>
    <div id="products">
        <a href="<?= URL_BASE; ?>producto/ver&id=<?= $pro->id; ?>">
        <?php if ($pro->imagen != null) : ?>
            <img src="<?= URL_BASE; ?>subidas/imagenes/<?= $pro->imagen; ?>">
        <?php else : ?>
            <img src="<?= URL_BASE; ?>assets/img/camiseta.png">
        <?php endif; ?>
        <h2><?= $pro->nombre; ?></h2>
        </a>
        <p>$<?= $pro->precio; ?></p>
        <a href="<?= URL_BASE; ?>carrito/agregar&id=<?= $pro->id; ?>" class="btn">Comprar</a>
    </div>
<?php endwhile; ?>