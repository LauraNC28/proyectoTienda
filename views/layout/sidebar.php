<aside id="lateral">
    <div id="carrito" class="block_aside">
        <h3>Carrito</h3>
        <ul>
            <li><a href="carrito/index">Productos </a></li>
			<li><a href="carrito/index">Total: </a></li>
			<li><a href="carrito/index">Ver el carrito</a></li>
        </ul>
    </div>

    <div id="login" class="block_aside">
        <?php if (!isset($_SESSION['identidad'])): ?>
            <h3>Entrar a la web</h3>
            <form action="<?= URL_BASE; ?>Usuario/login" method="POST" class="entrar">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password">
                <button type="submit">Ingresar</button>
            </form>
            <ul>
                <li><a href="<?= URL_BASE; ?>usuario/registro">Registrarse</a></li>
            </ul>
        <?php else: ?>
            <h3><?= $_SESSION['identidad']->nombre; ?> <?= $_SESSION['identidad']->apellidos; ?></h3>
        <?php endif; ?>

        <ul>
            <?php if (isset($_SESSION['admin'])): ?>
                <li><a href="categoria/index">Gestionar categorias</a></li>
				<li><a href="producto/gestion">Gestionar productos</a></li>
				<li><a href="pedido/gestion">Gestionar pedidos</a></li>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['identidad'])): ?>
                <li><a href="pedido/misPedidos">Mis pedidos</a></li>
                <li><a href="usuario/logout">Cerrar sessión</a></li>
                <?php else: ?> 
				<li><a href="<?=URL_BASE?>usuario/registro">Registrese</a></li>
			<?php endif; ?> 
        </ul>
    </div>
</aside>

<div id="principal">