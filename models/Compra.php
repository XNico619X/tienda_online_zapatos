<?php
require_once __DIR__ . '/Database.php';

class Compra
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function create(int $usuarioId, int $productoId, int $cantidad, float $precioUnitario): bool
    {
        $total = $precioUnitario * $cantidad;
        $stmt = $this->conn->prepare('INSERT INTO compras (usuario_id, producto_id, cantidad, precio_unitario, total) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('iiidd', $usuarioId, $productoId, $cantidad, $precioUnitario, $total);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function findByUser(int $usuarioId): array
    {
        $stmt = $this->conn->prepare(
            'SELECT c.*, p.nombre AS producto_nombre, p.imagen AS producto_imagen
             FROM compras c
             JOIN productos p ON p.id = c.producto_id
             WHERE c.usuario_id = ?
             ORDER BY c.created_at DESC'
        );
        $stmt->bind_param('i', $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $stmt->close();
        return $items;
    }
}
