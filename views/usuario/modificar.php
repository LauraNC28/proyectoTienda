<h1>Modificar cuenta</h1>

<?php
// Verifica si existe una variable de sesión 'error'.
// Esto se usa para mostrar mensajes de error cuando la validación del formulario falla.
if (isset($_SESSION['error'])): ?>
    <!-- Contenedor para mostrar los errores -->
    <div class="error">
        <!-- Lista no ordenada para mostrar los errores -->
        <ul>
            <?php
            // Itera sobre los errores almacenados en la variable de sesión 'error'.
            foreach ($_SESSION['error'] as $error): ?>
                <!-- Muestra cada error como un elemento de la lista -->
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php
// Verifica si existe una variable de sesión 'correcto'.
// Esto se usa para mostrar un mensaje de éxito cuando la modificación es exitosa.
if (isset($_SESSION['correcto'])): ?>
    <!-- Contenedor para mostrar el mensaje de éxito -->
    <div class="success">
        <!-- Muestra el mensaje de éxito -->
        <p><?= $_SESSION['correcto'] ?></p>
    </div>
<?php endif; ?>

<!-- Formulario para modificar los datos de la cuenta -->
<form action="<?= URL_BASE; ?>usuario/modificar" method="POST">
    <!-- Campo para el nombre -->
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" value="<?= $_SESSION['identidad']->nombre ?>" required />

    <!-- Campo para los apellidos -->
    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" value="<?= $_SESSION['identidad']->apellidos ?>" required />

    <!-- Campo para el correo electrónico -->
    <label for="email">Correo electrónico</label>
    <input type="email" name="email" value="<?= $_SESSION['identidad']->email ?>" required />

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Guardar cambios" />
</form>