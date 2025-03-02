<h1>Carrito de la compra</h1>

<?php 
// Verifica si el carrito existe en la sesión y si tiene al menos un producto.
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1) : ?>
    <table>
        <thead>
        <tr>
            <th>Imagen</th> <!-- Columna para la imagen del producto. -->
            <th>Nombre</th> <!-- Columna para el nombre del producto. -->
            <th>Unidades</th> <!-- Columna para la cantidad de unidades. -->
            <th>Precio</th> <!-- Columna para el precio del producto. -->
            <th>Eliminar</th> <!-- Columna para eliminar el producto del carrito. -->
        </tr>
        </thead>
    
        <tbody>
        <?php
        // Recorre cada producto en el carrito.
        foreach ($carrito as $clave => $valor) :
            $producto = $valor['producto']; // Obtiene el objeto producto.
            ?>
            <tr>
            <td>
                <?php
                // Muestra la imagen del producto si está disponible.
                if ($producto->imagen != null) : ?>
                    <img src="<?= URL_BASE; ?>imagenesSubidas/<?= $producto->imagen; ?>" class="img_carrito">
                <?php else : ?>
                    <!-- Muestra una imagen por defecto si no hay imagen disponible. -->
                    <img src="<?= URL_BASE; ?>assets/imagenes/colgante1.jpg" class="img_carrito">
                <?php endif; ?>
            </td>
            
            <td>
                <!-- Enlace para ver los detalles del producto. -->
                <a href="<?= URL_BASE; ?>producto/ver&id=<?= $producto->id; ?>">
                <?= $producto->nombre; ?>
                </a>
            </td>
            
            <td>
                <?= $valor['unidades']; ?> <!-- Muestra la cantidad de unidades del producto. -->
                <div class="unidades">
                <!-- Botones para aumentar o disminuir la cantidad de unidades. -->
                <a href="<?= URL_BASE; ?>carrito/mas&index=<?= $clave; ?>" class="btn">+</a>
                <a href="<?= URL_BASE; ?>carrito/menos&index=<?= $clave; ?>" class="btn btn-accion-eliminar">-</a>
                </div>
            </td>
            
            <td>$<?= $producto->precio; ?></td> <!-- Muestra el precio del producto. -->
            <td>
                <!-- Botón para eliminar el producto del carrito. -->
                <a href="<?= URL_BASE; ?>carrito/quitar&index=<?= $clave; ?>" class="btn btn-accion-eliminar">Quitar</a>
            </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    
    <br/>
    
    <?php
    // Obtiene las estadísticas del carrito (total de productos y precio total).
    $estado = Utils::estadisticaCarrito(); ?>
        <h3 class="total">Precio total: $<?= $estado['total']; ?></h3> <!-- Muestra el precio total del carrito. -->
        
        <!-- Botón para confirmar el pedido. -->
        <a href="<?= URL_BASE; ?>pedido/hacer" class="btn btn-pedido">Confirmar pedido</a>
        
        <!-- Botón para vaciar el carrito. -->
        <a href="<?= URL_BASE; ?>carrito/eliminarTodo" class="btn btn-accion-eliminar btn-pedido" style="float: left">Vaciar carrito</a>
    <?php else : ?>
        <!-- Mensaje que se muestra si el carrito está vacío. -->
        <p>El Carrito está vacío, puedes añadir algún producto.</p>

<?php endif; ?>