<h1>Crear nueva categoria</h1>

<!-- Formulario para crear una nueva categoría. -->
<form action="<?= URL_BASE; ?>categoria/guardar" method="POST">
    <!-- Campo para ingresar el nombre de la categoría. -->
    <label for="nombre">Nombre de la categoría:</label>
    <input type="text" name="nombre" id="nombre" required> <!-- El campo es obligatorio (required). -->

    <!-- Botón para enviar el formulario. -->
    <button type="submit">Crear</button>
</form>