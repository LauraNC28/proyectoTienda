<h1>Gestión de productos</h1>

<!-- Botón para crear un nuevo producto -->
<a href="<?= URL_BASE; ?>producto/crear" class="btn btn-small">Nuevo producto</a>

<!-- Mensaje de confirmación o error al agregar un producto -->
<?php if (isset($_SESSION['producto']) && $_SESSION['producto'] == 'completado'): ?>
    <strong class="alerta-ok">El nuevo producto se agregó correctamente.</strong>
<?php elseif (isset($_SESSION['producto']) && $_SESSION['producto'] != 'completado'): ?>
    <strong class="alerta-error">Error al agregar el producto.</strong>
<?php endif; ?>

<!-- Eliminar la sesión 'producto' después de mostrar el mensaje -->
<?php Utils::eliminarSession('producto'); ?>

<!-- Mensaje de confirmación o error al eliminar un producto -->
<?php if (isset($_SESSION['borrar']) && $_SESSION['borrar'] == 'completado'): ?>
    <strong class="alerta-ok">Producto eliminado.</strong>
<?php elseif (isset($_SESSION['borrar']) && $_SESSION['borrar'] != 'completado'): ?>
    <strong class="alerta-error">Error al eliminar.</strong>
<?php endif; ?>

<!-- Eliminar la sesión 'borrar' después de mostrar el mensaje -->
<?php Utils::eliminarSession('borrar'); ?>

<!-- Tabla para mostrar la lista de productos -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acción</th>
        </tr>
    </thead>

    <tbody>
    <?php if (!empty($productos)): ?> 
        <!-- Verifica si hay productos disponibles -->
        <?php foreach ($productos as $pro): ?> 
            <!-- Recorre cada producto y muestra sus datos -->
            <tr>
                <td><?= $pro['id']; ?></td>
                <td><?= $pro['nombre']; ?></td>
                <td><?= $pro['precio']; ?></td>
                <td><?= $pro['stock']; ?></td>
                <td>
                    <!-- Enlace para editar el producto -->
                    <a href="<?= URL_BASE; ?>producto/editar&id=<?= $pro['id']; ?>" class="btn btn-accion">Editar</a>
                    <!-- Enlace para eliminar el producto -->
                    <a href="<?= URL_BASE; ?>producto/eliminar&id=<?= $pro['id']; ?>" class="btn btn-accion-eliminar">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Mensaje en caso de que no haya productos -->
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
    </tbody>
</table>