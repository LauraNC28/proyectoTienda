<h1>Carrito de la compra</h1>

<?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1) : ?>
    <table>
        <thead>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Unidades</th>
            <th>Precio</th>
            <th>Eliminar</th>
        </tr>
        </thead>
    
        <tbody>
        <?php foreach ($carrito as $clave => $valor) :
            $producto = $valor['producto'];?>
            <tr>
            <td>
                <?php if ($producto->imagen != null) : ?>
                    <img src="<?= URL_BASE; ?>imagenesSubidas/<?= $producto->imagen; ?>" class="img_carrito">
                <?php else : ?>
                    <img src="<?= URL_BASE; ?>assets/imagenes/colgante1.jpg" class="img_carrito">
                <?php endif; ?>
            </td>
            
            <td>
                <a href="<?= URL_BASE; ?>producto/ver&id=<?= $producto->id; ?>">
                <?= $producto->nombre; ?>
                </a>
            </td>
            
            <td>
                <?= $valor['unidades']; ?>
                <div class="unidades">
                <a href="<?= URL_BASE; ?>carrito/mas&index=<?= $clave; ?>" class="btn">+</a>
                <a href="<?= URL_BASE; ?>carrito/menos&index=<?= $clave; ?>" class="btn btn-accion-eliminar">-</a>
                </div>
            </td>
            
            <td>$<?= $producto->precio; ?></td>
            <td><a href="<?= URL_BASE; ?>carrito/quitar&index=<?= $clave; ?>" class="btn btn-accion-eliminar">Quitar</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
    
    <br/>
    
    <?php $estado = Utils::estadisticaCarrito(); ?>
        <h3 class="total">Precio total: $<?= $estado['total']; ?></h3>
        <a href="<?= URL_BASE; ?>pedido/hacer" class="btn btn-pedido">Confirmar pedido</a>
        <a href="<?= URL_BASE; ?>carrito/eliminarTodo" class="btn btn-accion-eliminar btn-pedido" style="float: left">Vaciar carrito</a>
    <?php else : ?>
        <p>El Carrito esta vacío, puedes añadir algún producto.</p>

<?php endif; ?>