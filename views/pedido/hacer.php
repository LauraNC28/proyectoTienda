<?php if (isset($_SESSION['identidad'])) : ?>
    
    <h1>Hacer pedido</h1>
    <br/>
    <h3>Dirección para el envío</h3>
    <form action="<?= URL_BASE; ?>pedido/agregar" method="POST">
        <label>Provincia: <input type="text" name="provincia" required></label>
        <label>Localidad: <input type="text" name="localidad" required></label>
        <label>Dirección: <input type="text" name="direccion" required></label>
        <button type="submit">Confirmar pedido</button>
        <p><a href="<?= URL_BASE ?>carrito/index">Ver los productos y el precio del pedido</a></p>
    </form>
    
<?php else : ?>
    <h1>Inicie Sesión</h1>
    <p>Necesita iniciar sesión para realizar el pedido.</p>
<?php endif; ?>