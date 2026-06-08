<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductController
{
    private Producto $productoModel;

    public function __construct()
    {
        $this->productoModel = new Producto();
    }

    public function all(): array
    {
        return $this->productoModel->all();
    }

    public function find(int $id): ?array
    {
        return $this->productoModel->find($id);
    }

    private function storeImage(array $file, ?string $currentImage = null): string
    {
        if (empty($file['name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return $currentImage ?? '';
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $allowed, true)) {
            return '';
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            return '';
        }

        $filename = uniqid('shoe_', true) . '.' . $extension;
        $destination = UPLOAD_DIR . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return '';
        }

        return $filename;
    }

    public function create(array $data, array $file): array
    {
        $nombre = sanitize($data['nombre'] ?? '');
        $precio = filter_var($data['precio'] ?? 0, FILTER_VALIDATE_FLOAT);
        $stock = filter_var($data['stock'] ?? 0, FILTER_VALIDATE_INT);
        $imagen = $this->storeImage($file, '');

        if (empty($nombre) || $precio === false || $stock === false) {
            return ['success' => false, 'message' => 'Completa todos los campos correctamente.'];
        }

        if ($imagen === '') {
            return ['success' => false, 'message' => 'Selecciona una imagen válida (jpg, png, gif).'];
        }

        $created = $this->productoModel->create($nombre, $precio, $stock, $imagen);
        return $created
            ? ['success' => true, 'message' => 'Producto creado correctamente.']
            : ['success' => false, 'message' => 'Error al guardar el producto.'];
    }

    public function update(int $id, array $data, array $file): array
    {
        $producto = $this->find($id);
        if (!$producto) {
            return ['success' => false, 'message' => 'Producto no encontrado.'];
        }

        $nombre = sanitize($data['nombre'] ?? '');
        $precio = filter_var($data['precio'] ?? 0, FILTER_VALIDATE_FLOAT);
        $stock = filter_var($data['stock'] ?? 0, FILTER_VALIDATE_INT);
        $imagen = $producto['imagen'];

        if (!empty($file['name'])) {
            $uploaded = $this->storeImage($file, $producto['imagen']);
            if ($uploaded === '') {
                return ['success' => false, 'message' => 'Selecciona una imagen válida (jpg, png, gif).'];
            }
            $imagen = $uploaded;
        }

        if (empty($nombre) || $precio === false || $stock === false) {
            return ['success' => false, 'message' => 'Completa todos los campos correctamente.'];
        }

        $updated = $this->productoModel->update($id, $nombre, $precio, $stock, $imagen);
        return $updated
            ? ['success' => true, 'message' => 'Producto actualizado con éxito.']
            : ['success' => false, 'message' => 'Error al actualizar el producto.'];
    }

    public function delete(int $id): array
    {
        $producto = $this->find($id);
        if (!$producto) {
            return ['success' => false, 'message' => 'Producto no encontrado.'];
        }

        $deleted = $this->productoModel->delete($id);
        return $deleted
            ? ['success' => true, 'message' => 'Producto eliminado correctamente.']
            : ['success' => false, 'message' => 'Error al eliminar el producto.'];
    }

    public function buy(int $id): array
    {
        $producto = $this->find($id);
        if (!$producto) {
            return ['success' => false, 'message' => 'Producto no encontrado.'];
        }

        if ((int)$producto['stock'] <= 0) {
            return ['success' => false, 'message' => 'No hay stock disponible para este producto.'];
        }

        $updated = $this->productoModel->reduceStock($id);
        return $updated
            ? ['success' => true, 'message' => 'Compra simulada. Stock actualizado.']
            : ['success' => false, 'message' => 'Error al procesar la compra.'];
    }
}
