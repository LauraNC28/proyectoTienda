<?php
// Verifica si existe una variable de sesión 'usuario' y si su valor es 'completo'.
// Esto se usa para mostrar un mensaje de éxito cuando un usuario se actualiza correctamente.
if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'completo'): ?>
    <!-- Muestra un mensaje de éxito con la clase CSS 'alerta-ok'. -->
    <p class="alerta-ok">Usuario actualizado correctamente.</p>

<?php
// Verifica si existe una variable de sesión 'usuario' y si su valor es 'fallo'.
// Esto se usa para mostrar un mensaje de error cuando falla la actualización del usuario.
elseif (isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'fallo'): ?>
    <!-- Muestra un mensaje de error con la clase CSS 'alerta-error'. -->
    <p class="alerta-error">Ha ocurrido un error al actualizar el usuario.</p>
<?php endif; ?>

<!-- Título de la sección de gestión de usuarios -->
<h1>Gestión de Usuarios</h1>

<!-- Tabla para mostrar la lista de usuarios -->
<table>
    <!-- Encabezados de la tabla -->
    <tr>
        <th>ID</th>        <!-- Columna para el ID del usuario -->
        <th>Nombre</th>    <!-- Columna para el nombre completo del usuario -->
        <th>Email</th>     <!-- Columna para el email del usuario -->
        <th>Rol</th>       <!-- Columna para el rol del usuario (usuario o administrador) -->
        <th>Acciones</th>  <!-- Columna para las acciones disponibles (editar) -->
    </tr>

    <?php
    // Itera sobre la lista de usuarios recibida en la variable $usuarios.
    foreach ($usuarios as $usuario): ?>
        <!-- Fila de la tabla para cada usuario -->
        <tr>
            <!-- Muestra el ID del usuario -->
            <td><?= $usuario->id ?></td>

            <!-- Muestra el nombre completo del usuario (nombre + apellidos) -->
            <td><?= $usuario->nombre ?> <?= $usuario->apellidos ?></td>

            <!-- Muestra el email del usuario -->
            <td><?= $usuario->email ?></td>

            <!-- Muestra el rol del usuario -->
            <td><?= $usuario->rol ?></td>

            <!-- Columna de acciones: enlace para editar el usuario -->
            <td>
                <!-- Enlace para editar el usuario. Redirige a la URL de edición con el ID del usuario. -->
                <a href="<?= URL_BASE; ?>usuario/editarUsuario&id=<?= $usuario->id ?>">Editar</a>
            </td>
        </tr>
    <?php endforeach; // Fin del bucle foreach ?>
</table>