<?php
require_once __DIR__ . '/../layout/header.php';
?>
<section class="section-top">
    <div class="section-header">
        <div>
            <h1>Catálogo de zapatos</h1>
            <p class="description">Explora los productos disponibles y simula una compra con un clic.</p>
        </div>
    </div>
</section>

<section class="card-grid">
    <?php if (empty($productos)): ?>
        <div class="empty-state">
            <p>No hay productos para mostrar en este momento.</p>
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
                <p class="stock">Stock disponible: <?= sanitize($producto['stock']) ?></p>
            </div>
            <div class="card-footer">
                <form action="index.php?action=buy&id=<?= $producto['id'] ?>" method="post">
                    <button type="submit" class="button primary" <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>Comprar</button>
                </form>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
