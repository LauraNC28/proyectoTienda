<!-- Barra lateral (aside) que contiene el carrito y el formulario de inicio de sesión. -->
<aside id="lateral">
    <!-- Sección del carrito de compras. -->
    <div id="carrito" class="block_aside">
        <h3>Carrito</h3> <!-- Título de la sección del carrito. -->
        <ul>
            <?php $estadis = Utils::estadisticaCarrito(); ?>
            <!-- Enlaces relacionados con el carrito. -->
            <li>Total productos: <?= $estadis['cont']; ?></li> <!-- Enlace para ver los productos en el carrito. -->
            <li>Total precio: $<?= $estadis['total']; ?></li> <!-- Enlace para ver el total del carrito (falta el valor dinámico). -->
            <li><a href="<?= URL_BASE; ?>carrito/index">Ver carrito</a></li> <!-- Enlace para ver el carrito completo. -->
        </ul>
    </div>

    <!-- Sección de inicio de sesión y gestión de usuario. -->
    <div id="login" class="block_aside">
        <?php
        // Verifica si el usuario no ha iniciado sesión.
        if (!isset($_SESSION['identidad'])): ?>
            <h3>Entrar a la web</h3> <!-- Título del formulario de inicio de sesión. -->
            <!-- Formulario para iniciar sesión. -->
            <form action="<?= URL_BASE; ?>usuario/login" method="POST" class="entrar">
                <label for="email">Email:</label> <!-- Etiqueta para el campo de email. -->
                <input type="email" name="email" id="email"> <!-- Campo para ingresar el email. -->
                <label for="password">Contraseña:</label> <!-- Etiqueta para el campo de contraseña. -->
                <input type="password" name="password" id="password"> <!-- Campo para ingresar la contraseña. -->
                <button type="submit">Ingresar</button> <!-- Botón para enviar el formulario. -->
            </form>
            <ul>
                <!-- Enlace para registrarse. -->
                <li><a href="<?= URL_BASE; ?>usuario/registro">Registrarse</a></li>
            </ul>
        <?php else: ?>
            <!-- Si el usuario ha iniciado sesión, muestra su nombre y apellidos. -->
            <h3><?= $_SESSION['identidad']->nombre; ?> <?= $_SESSION['identidad']->apellidos; ?></h3>
        <?php endif; ?>

        <ul>
            <?php
            // Verifica si el usuario es administrador.
            if (isset($_SESSION['admin'])): ?>
                <!-- Enlaces para gestionar categorías, productos y pedidos (solo para administradores). -->
                <li><a href="<?= URL_BASE; ?>categoria/index">Gestionar categorias</a></li>
                <li><a href="<?= URL_BASE; ?>producto/gestion">Gestionar productos</a></li>
                <li><a href="<?= URL_BASE; ?>pedido/gestion">Gestionar pedidos</a></li>
            <?php endif; ?>
            
            <?php
            // Verifica si el usuario ha iniciado sesión.
            if (isset($_SESSION['identidad'])): ?>
                <!-- Enlaces para ver los pedidos del usuario y cerrar sesión. -->
                <li><a href="<?= URL_BASE; ?>pedido/misPedidos">Mis pedidos</a></li>
                <li><a href="<?= URL_BASE; ?>usuario/logout">Cerrar sessión</a></li>
            <?php endif; ?>
        </ul>
    </div>
</aside>

<!-- Contenedor principal de la página. -->
<div id="principal">