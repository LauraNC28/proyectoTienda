<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Accesorios</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>
    <div id="container">
        <header>
            <div id="logo">
                <img src="assets/imagenes/logoTienda.webp" alt="Logo de la tienda">
                <a href="index.php">Tienda de accesorios</a>
            </div>
        </header>

        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Categoria 1</a></li>
                <li><a href="#">Categoria 2</a></li>
                <li><a href="#">Categoria 3</a></li>
                <li><a href="#">Categoria 4</a></li>
            </ul>
        </nav>

        <main>
            <aside id="lateral">
                <div id="login" class="block_aside">
                    <h3>Entrar a la web</h3>
                    <form action="" method="POST">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email">
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password" id="password">
                        <button type="submit">Ingresar</button>
                    </form>
                    <ul>
                        <li><a href="#">Mis pedidos</a></li>
                        <li><a href="#">Gestionar pedidos</a></li>
                        <li><a href="#">Gestionar categorias</a></li>
                    </ul>
                </div>
            </aside>

            <div id="principal">
                <h1>Productos destacados</h1>
                <div id="products">
                    <img src="assets/imagenes/bolso1.jpeg">
                    <h2>Camiseta azul ancha</h2>
                    <p>$10.000</p>
                    <a href="" class="btn">Comprar</a>
                </div>
                
                <div id="products">
                    <img src="assets/imagenes/colgante1.jpg">
                    <h2>Camiseta azul ancha</h2>
                    <p>$10.000</p>
                    <a href="" class="btn">Comprar</a>
                </div>
                
                <div id="products">
                    <img src="assets/imagenes/pulsera1.jpg">
                    <h2>Camiseta azul ancha</h2>
                    <p>$10.000</p>
                <a href="" class="btn">Comprar</a>
            </div>
        </main>

        <footer>
            <p>&copy; Desarrollado por Laura Nievas Coca | <?= date('Y'); ?></p>
        </footer>
    </div>
</body>

</html>