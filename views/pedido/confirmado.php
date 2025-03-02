<?php
// Verifica si la sesión 'pedido' está definida y si su valor es 'Completo'.
if (isset($_SESSION['pedido']) && $_SESSION['pedido'] == 'Completo') : ?>
    <!-- Muestra un mensaje de confirmación del pedido. -->
    <h1>Pedido confirmado</h1>
    <p>Tu pedido ha sido confirmado, y una vez que hagas la transferencia bancaria con el total del pedido, será procesado y enviado a tu dirección.</p>
  
    <br/>

    <?php
    // Verifica si la variable $pedido está definida.
    if (isset($pedido)) : ?>
        <!-- Muestra los datos del pedido. -->
        <h3>Datos del pedido</h3>
        
        <br/>

        <!-- Muestra el número del pedido. -->
        <p>Número del pedido: <strong><?= $pedido->id; ?></strong></p>
        <!-- Muestra el total a pagar. -->
        <p>Total a pagar: <strong>$<?= $pedido->coste; ?></strong></p>
        
        <br/>

        <!-- Título para la sección de detalles de los productos. -->
        <p>Detalles de los productos:</p>

        <br/>

        <!-- Tabla para mostrar los detalles de los productos del pedido. -->
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
                                <img src="<?= URL_BASE; ?>assets/imagenes/bolso1.jpeg" class="img_carrito">
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
            </tbody>
        </table>
    <?php endif; ?>

<?php
// Verifica si la sesión 'pedido' está definida pero su valor no es 'Completo'.
elseif (isset($_SESSION['pedido']) && $_SESSION['pedido'] != 'Completo') : ?>
    <!-- Muestra un mensaje de error si el pedido no pudo ser confirmado. -->
    <h1>Hubo un problema</h1>
    <p>Lamentablemente tu pedido no ha podido ser confirmado. Por favor, vuelve a intentarlo.</p>
<?php endif; ?>