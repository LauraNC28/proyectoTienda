<?php 
// Verifica si la variable de sesión 'identidad' está definida, lo que indica que el usuario ha iniciado sesión.
if (isset($_SESSION['identidad'])) : ?>
    
    <!-- Muestra un título para la sección de hacer pedido -->
    <h1>Hacer pedido</h1>
    <br/>
    
    <!-- Muestra un subtítulo para la sección de dirección de envío -->
    <h3>Dirección para el envío</h3>
    
    <!-- Formulario para capturar la dirección de envío. La acción del formulario apunta a la URL para agregar el pedido -->
    <form action="<?= URL_BASE; ?>pedido/agregar" method="POST">
        
        <!-- Campo para ingresar la provincia -->
        <label>Provincia: <input type="text" name="provincia" required></label>
        
        <!-- Campo para ingresar la localidad -->
        <label>Localidad: <input type="text" name="localidad" required></label>
        
        <!-- Campo para ingresar la dirección -->
        <label>Dirección: <input type="text" name="direccion" required></label>
        
        <!-- Botón para confirmar el pedido -->
        <button type="submit">Confirmar pedido</button>
        
        <!-- Enlace para ver los productos y el precio del pedido en el carrito -->
        <p><a href="<?= URL_BASE ?>carrito/index">Ver los productos y el precio del pedido</a></p>
    </form>
    
<?php else : ?>
    <!-- Si el usuario no ha iniciado sesión, muestra un mensaje indicando que necesita iniciar sesión para realizar el pedido -->
    <h1>Inicie Sesión</h1>
    <p>Necesita iniciar sesión para realizar el pedido.</p>
<?php endif; ?>