<?php if (isset($pro)) : ?> 
<!-- Verifica si la variable $pro está definida para mostrar la información del producto -->
    
    <h1><?= $pro->nombre; ?></h1> 
    <!-- Muestra el nombre del producto -->

    <div id="detalle-producto">
        <div class="imagen-producto">
            <?php if ($pro->imagen != null) : ?> 
                <!-- Si el producto tiene una imagen asociada, la muestra -->
                <img src="<?= URL_BASE; ?>imagenesSubidas/<?= $pro->imagen; ?>">
            <?php else : ?> 
                <!-- Si no tiene imagen, muestra una imagen por defecto -->
                <img src="<?= URL_BASE; ?>assets/imagenes/colgante1.jpg">
            <?php endif; ?>
        </div>

        <div class="datos-producto">
            <p class="descripcion">
                <strong>Descripción del producto:</strong> <br/>
                <?= $pro->descripcion; ?> 
                <!-- Muestra la descripción del producto -->
            </p>

            <p class="precio">$<?= $pro->precio; ?></p> 
            <!-- Muestra el precio del producto -->

            <a href="<?= URL_BASE; ?>carrito/index&id=<?= $pro->id; ?>" class="btn">Comprar</a> 
            <!-- Enlace para añadir el producto al carrito -->
        </div>
    </div>

<?php else : ?>
    <!-- Si la variable $pro no está definida, muestra un mensaje de error -->
    <h1>El producto no existe</h1>
<?php endif; ?>