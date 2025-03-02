<h1>Crear nuevos productos</h1>

<?php 
// Verifica si estamos en modo edición y si existe un objeto producto válido
if (isset($editar) && isset($pro) && is_object($pro)): ?>
    <h1>Editar producto: <?php echo $pro->nombre ?></h1>
    <?php $url = URL_BASE . 'producto/guardar&id=' . $pro->id; // Define la URL para actualizar el producto ?>
<?php else: ?>
    <h1>Agregar nuevo producto</h1>
    <?php $url = URL_BASE . 'producto/guardar'; // Define la URL para guardar un nuevo producto ?>
<?php endif; ?>

<!-- Formulario para agregar o editar un producto -->
<form action="<?= $url ?>" method="POST" enctype="multipart/form-data">
    
    <!-- Campo para el nombre del producto -->
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" 
           value="<?= isset($pro) && is_object($pro) ? htmlspecialchars($pro->nombre) : ''; ?>" 
           required>

    <!-- Campo para la descripción del producto -->
    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion" cols="30" rows="10" required>
        <?= isset($pro) && is_object($pro) ? htmlspecialchars($pro->descripcion) : ''; ?>
    </textarea>

    <!-- Campo para el precio del producto -->
    <label for="precio">Precio:</label>
    <input type="text" name="precio" id="precio" 
           value="<?= isset($pro) && is_object($pro) ? htmlspecialchars($pro->precio) : ''; ?>" 
           required>

    <!-- Campo para el stock del producto -->
    <label for="stock">Stock:</label>
    <input type="number" name="stock" id="stock" 
           value="<?= isset($pro) && is_object($pro) ? htmlspecialchars($pro->stock) : ''; ?>" 
           required>

    <!-- Selector de categoría del producto -->
    <label for="categoria">Categoría:</label>
    <?php $categorias = Utils::mostrarCategorias(); ?>
    <select name="categoria">
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id'] ?>" 
                <?= isset($pro) && is_object($pro) && $pro->categoria_id == $categoria['id'] ? 'selected' : ''; ?>>
                <?= htmlspecialchars($categoria['nombre']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Campo para subir imagen del producto -->
    <label for="imagen">Imagen:</label>
    <?php if (isset($pro) && is_object($pro) && !empty($pro->imagen)): ?>
        <!-- Muestra la imagen actual si existe -->
        <img src="<?= URL_BASE; ?>imagenesSubidas/<?= htmlspecialchars($pro->imagen); ?>" class="miniatura"> <br/>
    <?php endif; ?>
    <input type="file" name="imagen">

    <!-- Botón para enviar el formulario -->
    <button type="submit">Guardar</button>
</form>