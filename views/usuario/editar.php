<?php
// Verifica si la variable $datos está definida y no es nula.
// Esto asegura que el formulario solo se muestre si hay datos del usuario disponibles.
if (isset($datos)): ?>
    
    <!-- Título del formulario -->
    <h1>Editar Usuario</h1>

    <!-- Formulario para editar un usuario. La acción apunta a la URL de actualización de usuario. -->
    <form action="<?= URL_BASE; ?>usuario/actualizarUsuario" method="POST">
        <!-- Campo oculto para enviar el ID del usuario. -->
        <input type="hidden" name="id" value="<?= $datos->id ?>" />
        
        <!-- Campo para el nombre del usuario -->
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?= $datos->nombre ?>" required />
        
        <!-- Campo para los apellidos del usuario -->
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" value="<?= $datos->apellidos ?>" required />
        
        <!-- Campo para el email del usuario -->
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= $datos->email ?>" required />
        
        <!-- Campo para seleccionar el rol del usuario -->
        <label for="rol">Rol:</label>
        <select name="rol" required>
            <!-- Opción para el rol de usuario -->
            <option value="user" <?= ($datos->rol == 'user') ? 'selected' : ''; ?>>Usuario</option>
            <!-- Opción para el rol de administrador -->
            <option value="admin" <?= ($datos->rol == 'admin') ? 'selected' : ''; ?>>Administrador</option>
        </select>
        
        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Actualizar Usuario" />
    </form>
<?php else: ?>
    <!-- Mensaje que se muestra si no se encuentran datos del usuario -->
    <p>No se pudo encontrar el usuario.</p>
<?php endif; ?>