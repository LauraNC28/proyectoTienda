<h1>Gestión de productos</h1>

<a href="<?= URL_BASE; ?>producto/crear" class="btn btn-small">Nuevo producto</a>

<?php if (isset($_SESSION['producto']) && $_SESSION['producto'] == 'completado'): ?>
    <strong class="alerta-ok">El nuevo producto se agrego correctamente.</strong>

<?php elseif (isset($_SESSION['producto']) && $_SESSION['producto'] != 'completado'): ?>
    <strong class="alerta-error">Error al agregar el producto.</strong>
<?php endif; ?>

<?php Utils::eliminarSession('producto'); ?>

<?php if (isset($_SESSION['borrar']) && $_SESSION['borrar'] == 'completado'): ?>
    <strong class="alerta-ok">Producto eliminado.</strong>
<?php elseif (isset($_SESSION['borrar']) && $_SESSION['borrar'] != 'completado'): ?>
    <strong class="alerta-error">Error al eliminar.</strong>
<?php endif; ?>

<?php Utils::eliminarSession('borrar'); ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Accion</th>
        </tr>
    </thead>

    <tbody>
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $pro): ?>
            <tr>
                <td><?= $pro['id']; ?></td>
                <td><?= $pro['nombre']; ?></td>
                <td><?= $pro['precio']; ?></td>
                <td><?= $pro['stock']; ?></td>
                <td>
                    <a href="<?= URL_BASE; ?>producto/editar&id=<?= $pro['id']; ?>" class="btn btn-accion">Editar</a>
                    <a href="<?= URL_BASE; ?>producto/eliminar&id=<?= $pro['id']; ?>" class="btn btn-accion-eliminar">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay categorías disponibles.</p>
    <?php endif; ?>
    </tbody>
  
</table>