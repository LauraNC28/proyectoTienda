<h1>Gestionar categorias</h1>

<!-- Enlace para crear una nueva categoría. -->
<a href="<?= URL_BASE; ?>categoria/crear" class="btn btn-small">Nueva categoría</a>

<?php
// Verifica si hay categorías disponibles.
if (!empty($categorias)): ?>
    <!-- Tabla para mostrar las categorías. -->
    <table>
        <thead>
            <tr>
                <th>ID</th> <!-- Columna para el ID de la categoría. -->
                <th>Nombre</th> <!-- Columna para el nombre de la categoría. -->
            </tr>
        </thead>
        
        <tbody>
            <?php
            // Recorre cada categoría y muestra sus datos en la tabla.
            foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?= $categoria['id']; ?></td> <!-- Muestra el ID de la categoría. -->
                    <td><?= $categoria['nombre']; ?></td> <!-- Muestra el nombre de la categoría. -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <!-- Mensaje que se muestra si no hay categorías disponibles. -->
    <p>No hay categorías disponibles.</p>
<?php endif; ?>