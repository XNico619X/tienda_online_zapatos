<?php
require_once __DIR__ . '/../layout/header.php';
?>
<section class="section-top">
    <div class="section-header">
        <div>
            <h1>Inventario de zapatos</h1>
            <p class="description">Administra productos, edita stock y simula ventas sobre este catálogo.</p>
        </div>
        <a href="index.php?page=product_form" class="button primary">Agregar nuevo zapato</a>
    </div>
</section>

<section class="card-grid">
    <?php if (empty($productos)): ?>
        <div class="empty-state">
            <p>No hay productos registrados todavía.</p>
        </div>
    <?php endif; ?>

    <?php foreach ($productos as $producto): ?>
        <article class="card product-card">
            <div class="card-image">
                <img src="<?= !empty($producto['imagen']) ? UPLOAD_URL . sanitize($producto['imagen']) : 'https://via.placeholder.com/340x220?text=Sin+imagen' ?>" alt="<?= sanitize($producto['nombre']) ?>">
            </div>
            <div class="card-body">
                <h2><?= sanitize($producto['nombre']) ?></h2>
                <p class="price">$<?= number_format($producto['precio'], 0, ',', '.') ?></p>
                <p class="stock">Stock: <?= sanitize($producto['stock']) ?></p>
            </div>
            <div class="card-footer">
                <a href="index.php?page=product_form&id=<?= $producto['id'] ?>" class="button secondary">Editar</a>
                <form action="index.php?action=delete_product&id=<?= $producto['id'] ?>" method="post" class="inline-form" onsubmit="return confirm('¿Eliminar este producto?');">
                    <button type="submit" class="button danger">Eliminar</button>
                </form>
                <form action="index.php?action=buy&id=<?= $producto['id'] ?>" method="post" class="inline-form">
                    <button type="submit" class="button outline">Vender</button>
                </form>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
