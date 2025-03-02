<h1>Detalle del pedido</h1>

<?php
// Verifica si la variable $pedido está definida.
if (isset($pedido)) : ?>
    <?php
    // Verifica si el usuario es administrador.
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
        <!-- Formulario para cambiar el estado del pedido (solo para administradores). -->
        <h3>Cambiar estado del pedido</h3>
        <form action="<?= URL_BASE; ?>pedido/estado" method="POST">
            <!-- Campo oculto para enviar el ID del pedido. -->
            <input type="hidden" value="<?= $pedido->id; ?>" name="pedido_id">
            <!-- Select para elegir el estado del pedido. -->
            <select name="estado">
                <option value="pendiente" <?= $pedido->estado == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="preparacion" <?= $pedido->estado == 'preparacion' ? 'selected' : ''; ?>>En preparación</option>
                <option value="preparado" <?= $pedido->estado == 'preparado' ? 'selected' : ''; ?>>Preparado para enviar</option>
                <option value="enviado" <?= $pedido->estado == 'enviado' ? 'selected' : ''; ?>>Enviado</option>
            </select>
            <!-- Botón para guardar el cambio de estado. -->
            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>

    <br/>

    <!-- Sección de datos del envío. -->
    <h3>Datos del envío</h3>

    <br/>

    <!-- Muestra la provincia, localidad y dirección de envío. -->
    <p>Provincia: <strong><?= $pedido->provincia; ?></strong></p>
    <p>Localidad: <strong><?= $pedido->localidad; ?></strong></p>
    <p>Dirección: <strong><?= $pedido->direccion; ?></strong></p>
    
    <br/>

    <!-- Sección de datos del pedido. -->
    <h3>Datos del pedido</h3>

    <br/>

    <!-- Muestra el estado, número y costo total del pedido. -->
    <p>Estado del pedido: <strong><?= Utils::mostrarEstado($pedido->estado); ?></strong></p>
    <p>Número del pedido: <strong><?= $pedido->id; ?></strong></p>
    <p>Total a pagar: <strong>$<?= $pedido->coste; ?></strong></p>
    
    <br/>

    <!-- Título para la sección de detalles de los productos. -->
    <p>Detalles de los productos:</p>

    <br/>

    <!-- Tabla para mostrar los productos del pedido. -->
    <table>
        <thead>
            <tr>
                <th>Imagen</th> <!-- Columna para la imagen del producto. -->
                <th>Nombre</th> <!-- Columna para el nombre del producto. -->
                <th>Unidades</th> <!-- Columna para la cantidad de unidades. -->
                <th>Precio</th> <!-- Columna para el precio del producto. -->
            </tr>
        </thead>

        <tbody>
            <?php
            // Verifica si hay productos en el pedido.
            if (!empty($productos)): ?>
                <?php
                // Recorre cada producto en el pedido.
                foreach ($productos as $producto): ?>
                    <tr>
                    <td>
                        <?php
                        // Verifica si el producto tiene una imagen.
                        if ($producto->imagen != null) : ?>
                            <!-- Muestra la imagen del producto si está disponible. -->
                            <img src="<?= URL_BASE; ?>imagenesSubidas/<?= $producto->imagen; ?>" class="img_carrito">
                        <?php else : ?>
                            <!-- Muestra una imagen por defecto si no hay imagen disponible. -->
                            <img src="<?= URL_BASE; ?>assets/imagenes/pulsera1.jpg" class="img_carrito">
                        <?php endif; ?>
                    </td>
                    
                    <td>
                        <!-- Enlace para ver los detalles del producto. -->
                        <a href="<?= URL_BASE; ?>producto/ver&id=<?= $producto->id; ?>">
                        <?= $producto->nombre; ?>
                        </a>
                    </td>
                    
                    <!-- Muestra la cantidad de unidades del producto. -->
                    <td><?= $producto->unidades; ?></td>
                    <!-- Muestra el precio del producto. -->
                    <td><?= $producto->precio; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Muestra un mensaje si no hay productos en el pedido. -->
                <tr>
                    <td>No hay productos en este pedido.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
<?php endif; ?>