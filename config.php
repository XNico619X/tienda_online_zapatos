<?php
// Configuración general y funciones de ayuda para todo el proyecto.
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'tienda_zapatos');
define('DB_USER', 'root');
define('DB_PASS', '');

define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', 'uploads/');

function db_connect(): mysqli
{
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($connection->connect_errno) {
        die('Error de conexión: ' . $connection->connect_error);
    }
    $connection->set_charset('utf8');
    return $connection;
}

function sanitize(string $value): string
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function isLogged(): bool
{
    return !empty($_SESSION['user']);
}

function isAdmin(): bool
{
    return isLogged() && ($_SESSION['user']['rol'] ?? '') === 'admin';
}

function isCliente(): bool
{
    return isLogged() && ($_SESSION['user']['rol'] ?? '') === 'cliente';
}

function requireLogin(): void
{
    if (!isLogged()) {
        header('Location: index.php?page=login');
        exit;
    }
}

function requireAdmin(): void
{
    requireLogin();
    if (!isAdmin()) {
        header('Location: index.php?page=catalogo');
        exit;
    }
}

function requireCliente(): void
{
    requireLogin();
    if (!isCliente()) {
        header('Location: index.php?page=admin');
        exit;
    }
}

function flash(string $name, ?string $message = null): ?string
{
    if ($message === null) {
        $value = $_SESSION['flash'][$name] ?? null;
        unset($_SESSION['flash'][$name]);
        return $value;
    }

    $_SESSION['flash'][$name] = $message;
    return null;
}
