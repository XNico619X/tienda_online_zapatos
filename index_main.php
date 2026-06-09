<?php
require_once 'config.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ProductController.php';

$authController = new AuthController();
$productController = new ProductController();
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? '';

if ($action === 'logout') {
    $authController->logout();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'login') {
        $response = $authController->login($_POST);
        flash($response['success'] ? 'success' : 'error', $response['message']);
        header('Location: index.php?page=' . ($response['success'] ? (isAdmin() ? 'admin' : 'catalogo') : 'login'));
        exit;
    }

    if ($action === 'register') {
        $response = $authController->register($_POST);
        flash($response['success'] ? 'success' : 'error', $response['message']);
        header('Location: index.php?page=' . ($response['success'] ? 'login' : 'register'));
        exit;
    }

    if ($action === 'save_product') {
        requireAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id) {
            $response = $productController->update($id, $_POST, $_FILES['imagen'] ?? []);
        } else {
            $response = $productController->create($_POST, $_FILES['imagen'] ?? []);
        }
        flash($response['success'] ? 'success' : 'error', $response['message']);
        header('Location: index.php?page=admin');
        exit;
    }

    if ($action === 'delete_product') {
        requireAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $response = $productController->delete($id);
        flash($response['success'] ? 'success' : 'error', $response['message']);
        header('Location: index.php?page=admin');
        exit;
    }

    if ($action === 'buy') {
        requireLogin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $userId = $_SESSION['user']['id'] ?? 0;
        $response = $productController->buy($id, $userId);
        flash($response['success'] ? 'success' : 'error', $response['message']);
        header('Location: index.php?page=' . (isAdmin() ? 'admin' : 'catalogo'));
        exit;
    }
}

switch ($page) {
    case 'login':
        if (isLogged()) {
            header('Location: index.php?page=' . (isAdmin() ? 'admin' : 'catalogo'));
            exit;
        }
        require 'views/auth/login.php';
        break;

    case 'register':
        if (isLogged()) {
            header('Location: index.php?page=' . (isAdmin() ? 'admin' : 'catalogo'));
            exit;
        }
        require 'views/auth/register.php';
        break;

    case 'admin':
        requireAdmin();
        $productos = $productController->all();
        require 'views/admin/product_list.php';
        break;

    case 'product_form':
        requireAdmin();
        $producto = null;
        if (!empty($_GET['id'])) {
            $producto = $productController->find((int)$_GET['id']);
        }
        require 'views/admin/product_form.php';
        break;

    case 'catalogo':
        requireCliente();
        $productos = $productController->all();
        require 'views/client/catalog.php';
        break;

    default:
        if (isLogged()) {
            header('Location: index.php?page=' . (isAdmin() ? 'admin' : 'catalogo'));
        } else {
            header('Location: index.php?page=login');
        }
        exit;
}
