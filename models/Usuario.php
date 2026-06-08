<?php
require_once __DIR__ . '/Database.php';

class Usuario
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function register(string $nombre, string $email, string $password, string $rol = 'cliente'): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare('INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $nombre, $email, $hash, $rol);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->conn->prepare('SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare('SELECT id, nombre, email, rol FROM usuarios WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user ?: null;
    }

    public function verifyCredentials(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }
        return null;
    }
}
