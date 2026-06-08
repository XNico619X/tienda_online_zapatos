<?php
// Encabezado común para todas las páginas y barra de navegación.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online de Zapatos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <div>
            <a class="brand" href="index.php">Zapateria MVC</a>
            <p class="subtitle">Sistema sencillo de venta y gestión de productos</p>
        </div>
        <nav class="nav-menu">
            <?php if (isLogged()): ?>
                <?php if (isAdmin()): ?>
                    <a href="index.php?page=admin">Inventario</a>
                <?php else: ?>
                    <a href="index.php?page=catalogo">Catálogo</a>
                <?php endif; ?>
                <a href="index.php?action=logout" class="button small">Salir</a>
            <?php else: ?>
                <a href="index.php?page=login">Ingresar</a>
                <a href="index.php?page=register">Registrarse</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container">
    <?php if ($flash = flash('success')): ?>
        <div class="alert success"><?= $flash ?></div>
    <?php endif; ?>
    <?php if ($flash = flash('error')): ?>
        <div class="alert error"><?= $flash ?></div>
    <?php endif; ?>
