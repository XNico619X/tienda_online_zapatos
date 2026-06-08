<?php
require_once __DIR__ . '/Database.php';

class Producto
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function all(): array
    {
        $result = $this->conn->query('SELECT * FROM productos ORDER BY id DESC');
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $result->free();
        return $items;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->conn->prepare('SELECT * FROM productos WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        $stmt->close();
        return $item ?: null;
    }

    public function create(string $nombre, float $precio, int $stock, string $imagen): bool
    {
        $stmt = $this->conn->prepare('INSERT INTO productos (nombre, precio, stock, imagen) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('sdis', $nombre, $precio, $stock, $imagen);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update(int $id, string $nombre, float $precio, int $stock, string $imagen): bool
    {
        $stmt = $this->conn->prepare('UPDATE productos SET nombre = ?, precio = ?, stock = ?, imagen = ? WHERE id = ?');
        $stmt->bind_param('sdisi', $nombre, $precio, $stock, $imagen, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM productos WHERE id = ?');
        $stmt->bind_param('i', $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function reduceStock(int $id, int $cantidad = 1): bool
    {
        $producto = $this->find($id);
        if (!$producto || $producto['stock'] <= 0) {
            return false;
        }

        $nuevoStock = max(0, $producto['stock'] - $cantidad);
        $stmt = $this->conn->prepare('UPDATE productos SET stock = ? WHERE id = ?');
        $stmt->bind_param('ii', $nuevoStock, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
