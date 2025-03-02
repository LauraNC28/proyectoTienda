<?php if (isset($_SESSION['pedido']) && $_SESSION['pedido'] == 'Completo') : ?>
    <h1>Pedido confirmado</h1>
    <p>Tu pedido a sido confirmado, y una vez que haga la transferencia bancaria con el total del pedido, será procesado y enviado a tu dirección.</p>
  
    <br/>

    <?php if (isset($pedido)) : ?>
        <h3>Datos del pedido</h3>
        
        <br/>

        <p>Número del pedido: <strong><?= $pedido->id; ?></strong></p>
        <p>Total a pagar: <strong>$<?= $pedido->coste; ?></strong></p>
        
        <br/>

        <p>Detalles de los productos:</p>

        <br/>

        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Unidades</th>
                    <th>Precio</th>
                </tr>
            </thead>
        
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td>
                            <?php if ($producto->imagen != null) : ?>
                                <img src="<?= URL_BASE; ?>imagenesSubidas/<?= $producto->imagen; ?>" class="img_carrito">
                            <?php else : ?>
                                <img src="<?= URL_BASE; ?>assets/imagenes/bolso1.jpeg" class="img_carrito">
                            <?php endif; ?>
                        </td>
                        
                        <td>
                            <a href="<?= URL_BASE; ?>producto/ver&id=<?= $producto->id; ?>">
                            <?= $producto->nombre; ?>
                            </a>
                        </td>
                        
                        <td><?= $producto->unidades; ?></td>
                        <td><?= $producto->precio; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    <?php endif; ?>

<?php elseif (isset($_SESSION['pedido']) && $_SESSION['pedido'] != 'Completo') : ?>
    <h1>Hubo un problema</h1>
    <p>Lamentablemente tu pedido no ha podido ser confirmado. Por favor, vuelva a intentarlo.</p>
<?php endif; ?>