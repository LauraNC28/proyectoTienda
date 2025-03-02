<h1>Detalle del pedido</h1>

<?php if (isset($pedido)) : ?>
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
        <h3>Cambiar estado del pedido</h3>
        <form action="<?= URL_BASE; ?>pedido/estado" method="POST">
            <input type="hidden" value="<?= $pedido->id; ?>" name="pedido_id">
            <select name="estado">
                <option value="pendiente" <?= $pedido->estado == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="preparacion" <?= $pedido->estado == 'preparacion' ? 'selected' : ''; ?>>En preparación</option>
                <option value="preparado" <?= $pedido->estado == 'preparado' ? 'selected' : ''; ?>>Preparado para enviar</option>
                <option value="enviado" <?= $pedido->estado == 'enviado' ? 'selected' : ''; ?>>Enviado</option>
            </select>
            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>

    <br/>

    <h3>Datos del envío</h3>

    <br/>

    <p>Provincia: <strong><?= $pedido->provincia; ?></strong></p>
    <p>Localidad: <strong><?= $pedido->localidad; ?></strong></p>
    <p>Dirección: <strong><?= $pedido->direccion; ?></strong></p>
    
    <br/>

    <h3>Datos del pedido</h3>

    <br/>

    <p>Estado del pedido: <strong><?= Utils::mostrarEstado($pedido->estado); ?></strong></p>
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
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                    <td>
                        <?php if ($producto->imagen != null) : ?>
                            <img src="<?= URL_BASE; ?>imagenesSubidas/<?= $producto->imagen; ?>" class="img_carrito">
                        <?php else : ?>
                            <img src="<?= URL_BASE; ?>assets/imagenes/pulsera1.jpg" class="img_carrito">
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
            <?php else: ?>
                <tr>
                    <td>No hay productos en este pedido.</td>
                </tr>
            <?php endif; ?>
        </tbody>

    </table>
    
<?php endif; ?>