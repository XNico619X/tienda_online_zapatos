<?php
require_once __DIR__ . '/../layout/header.php';
$editing = !empty($producto);
?>
<section class="section-top">
    <div class="section-header">
        <div>
            <h1><?= $editing ? 'Editar producto' : 'Agregar nuevo zapato' ?></h1>
            <p class="description">Mantén tu inventario actualizado con información de stock y precio.</p>
        </div>
        <a href="index.php?page=admin" class="button outline">Volver al inventario</a>
    </div>
</section>

<section class="card card-form">
    <form action="index.php?action=save_product<?= $editing ? '&id=' . $producto['id'] : '' ?>" method="post" enctype="multipart/form-data" class="form-grid">
        <label>
            Nombre del zapato
            <input type="text" name="nombre" required value="<?= $editing ? sanitize($producto['nombre']) : '' ?>">
        </label>
        <label>
            Precio
            <input type="number" step="0.01" name="precio" required value="<?= $editing ? sanitize($producto['precio']) : '' ?>">
        </label>
        <label>
            Cantidad en stock
            <input type="number" name="stock" required value="<?= $editing ? sanitize($producto['stock']) : '' ?>">
        </label>
        <label>
            Imagen del producto
            <input type="file" name="imagen" <?= $editing ? '' : 'required' ?> accept="image/jpeg,image/png,image/gif">
        </label>
        <?php if ($editing && !empty($producto['imagen'])): ?>
            <div class="image-preview">
                <img src="<?= UPLOAD_URL . sanitize($producto['imagen']) ?>" alt="Imagen actual">
            </div>
        <?php endif; ?>
        <button type="submit" class="button primary"><?= $editing ? 'Actualizar zapato' : 'Guardar zapato' ?></button>
    </form>
</section>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
