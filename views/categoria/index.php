<h1>Gestionar categorias</h1>

<a href="<?= URL_BASE; ?>categoria/crear" class="btn btn-small">Nueva categoria</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $query = $pdo->query("SELECT id, nombre FROM categorias");
        $categorias = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categorias as $cat): ?>
            <tr>
                <td><?= $cat['id']; ?></td>
                <td><?= $cat['nombre']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>