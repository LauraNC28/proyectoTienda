<?php if (isset($pedidos) && count($pedidos) > 0): ?>
    <h1>Mis pedidos</h1>

    <table>
        <thead>
            <tr>
                <th>N° de pedido</th>
                <th>Coste</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
  
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><a href="<?= URL_BASE; ?>pedido/detalle&id=<?= $pedido->id; ?>"><?= $pedido->id; ?></a></td>
                    <td><?= $pedido->coste; ?>€</td>
                    <td><?= $pedido->fecha; ?></td>
                    <td><?= Utils::mostrarEstado($pedido->estado); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
</table>

<?php else: ?>
    <p>No hay pedidos registrados.</p>
<?php endif; ?>