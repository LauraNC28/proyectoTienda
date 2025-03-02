<h1>Gestionar categorias</h1>

<a href="<?= URL_BASE; ?>categoria/crear" class="btn btn-small">Nueva categoria</a>

<?php if (!empty($categorias)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?= $categoria['id']; ?></td>
                    <td><?= $categoria['nombre']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay categorías disponibles.</p>
<?php endif; ?>