<?php 
// Verifica si la variable $pedidos está definida y si contiene al menos un elemento.
if (isset($pedidos) && count($pedidos) > 0): ?>
    
    <!-- Muestra un título para la sección de "Mis pedidos" -->
    <h1>Mis pedidos</h1>

    <!-- Crea una tabla para mostrar la lista de pedidos -->
    <table>
        <!-- Encabezado de la tabla -->
        <thead>
            <tr>
                <th>N° de pedido</th> <!-- Columna para el número de pedido -->
                <th>Coste</th> <!-- Columna para el coste del pedido -->
                <th>Fecha</th> <!-- Columna para la fecha del pedido -->
                <th>Estado</th> <!-- Columna para el estado del pedido -->
            </tr>
        </thead>
  
        <!-- Cuerpo de la tabla -->
        <tbody>
            <!-- Itera sobre cada pedido en la lista de pedidos -->
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <!-- Muestra el número de pedido como un enlace a la página de detalles del pedido -->
                    <td>
                        <a href="<?= URL_BASE; ?>pedido/detalle&id=<?= $pedido->id; ?>">
                            <?= $pedido->id; ?>
                        </a>
                    </td>
                    
                    <!-- Muestra el coste del pedido -->
                    <td><?= $pedido->coste; ?>€</td>
                    
                    <!-- Muestra la fecha del pedido -->
                    <td><?= $pedido->fecha; ?></td>
                    
                    <!-- Muestra el estado del pedido, utilizando un método estático de la clase Utils para formatear el estado -->
                    <td><?= Utils::mostrarEstado($pedido->estado); ?></td>
                </tr>
            <?php endforeach; ?> <!-- Fin del bucle foreach -->
        </tbody>
    </table>

<?php else: ?>
    <!-- Si no hay pedidos registrados, muestra un mensaje indicando que no hay pedidos -->
    <p>No hay pedidos registrados.</p>
<?php endif; ?>