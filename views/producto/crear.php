<h1>Crear nuevos productos</h1>

<?php if (isset($editar) && isset($pro) && is_object($pro)):?>
    <h1>Editar producto: <?php echo $pro->nombre ?></h1>
    <?php $url = URL_BASE . 'producto/guardar&id=' . $pro->id;?>
<?php else: ?>
    <h1>Agregar nuevo producto</h1>
    <?php $url = URL_BASE . 'producto/guardar';?>
<?php endif; ?>


<form action="<?= $url ?>" method="POST" enctype="multipart/form-data">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?= isset($pro) && is_object($pro) ? $pro->nombre : ''; ?>" required>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion" cols="30" rows="10" required><?= isset($pro) && is_object($pro) ? $pro->descripcion : ''; ?></textarea>

    <label for="precio">Precio:</label>
    <input type="text" name="precio" id="precio" value="<?= isset($pro) && is_object($pro) ? $pro->precio : ''; ?>" required>

    <label for="stock">Stock:</label>
    <input type="number" name="stock" id="stock" value="<?= isset($pro) && is_object($pro) ? $pro->stock : ''; ?>" required>

    <label for="categoria">Categoria:</label>
    <?php $categorias = Utils::mostrarCategorias(); ?>
    <select name="categoria">
        <?php foreach ($categorias as $categoria): ?>
		    <option value="<?=$categoria['id']?>" <?= isset($pro) && is_object($pro) && $pro->categoria_id == $categoria['id'] ? 'selected' : ''; ?>>
                <?php echo $categoria['nombre']; ?>
            </option>
	    <?php endforeach; ?>
    </select>

    <label for="imagen">Imagen:</label>
    <?php if (isset($pro) && is_object($pro) && !empty($pro->imagen)): ?>
        <img src="<?= URL_BASE; ?>imagenesSubidas/<?= $pro->imagen; ?>" class="miniatura"> <br/>
    <?php endif; ?>
    <input type="file" name="imagen">

    <button type="submit">Guardar</button>
</form>