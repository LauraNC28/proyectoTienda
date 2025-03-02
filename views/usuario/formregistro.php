<h1>Registrarse</h1>

<?php 
// Verifica si la variable de sesión 'registro' está definida y si su valor es 'completado'
if (isset($_SESSION['registro']) && $_SESSION['registro'] == 'completado'): ?>
    <!-- Muestra un mensaje de éxito si el registro fue completado -->
    <strong class="alerta-ok">Registro exitoso</strong>

<?php 
// Verifica si la variable de sesión 'registro' está definida y si su valor es 'falla'
elseif (isset($_SESSION['registro']) && $_SESSION['registro'] == 'falla'): ?>
    <!-- Muestra un mensaje de error si hubo un problema con el registro -->
    <strong class="alerta-error">Error al registrar, ingrese bien los datos</strong>

<?php endif; ?>

<?php 
// Elimina la variable de sesión 'registro' para que el mensaje no se muestre de nuevo al recargar la página
Utils::eliminarSession('registro');
?>

<!-- Formulario de registro -->
<form action="<?= URL_BASE ?>/usuario/guardar" method="POST">
    <!-- Campo para el nombre -->
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required>

    <!-- Campo para los apellidos -->
    <label for="apellidos">Apellidos:</label>
    <input type="text" name="apellidos" id="apellidos" required>

    <!-- Campo para el email -->
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <!-- Campo para la contraseña -->
    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password" required>

    <!-- Botón para enviar el formulario -->
    <button type="submit">Registrarse</button>
</form>