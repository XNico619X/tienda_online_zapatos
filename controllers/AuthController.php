<?php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    private Usuario $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }

    public function register(array $data): array
    {
        $nombre = sanitize($data['nombre'] ?? '');
        $email = sanitize($data['email'] ?? '');
        $password = trim($data['password'] ?? '');
        $confirm = trim($data['confirm_password'] ?? '');

        if (empty($nombre) || empty($email) || empty($password) || empty($confirm)) {
            return ['success' => false, 'message' => 'Por favor completa todos los campos.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'El correo electrónico no es válido.'];
        }

        if ($password !== $confirm) {
            return ['success' => false, 'message' => 'Las contraseñas no coinciden.'];
        }

        if ($this->usuarioModel->findByEmail($email)) {
            return ['success' => false, 'message' => 'Este correo ya está registrado.'];
        }

        $created = $this->usuarioModel->register($nombre, $email, $password);
        if ($created) {
            return ['success' => true, 'message' => 'Registro realizado con éxito. Ya puedes iniciar sesión.'];
        }

        return ['success' => false, 'message' => 'Ocurrió un error al registrar el usuario.'];
    }

    public function login(array $data): array
    {
        $email = sanitize($data['email'] ?? '');
        $password = trim($data['password'] ?? '');

        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Ingresa correo y contraseña.'];
        }

        $user = $this->usuarioModel->verifyCredentials($email, $password);
        if (!$user) {
            return ['success' => false, 'message' => 'Correo o contraseña incorrectos.'];
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'nombre' => $user['nombre'],
            'email' => $user['email'],
            'rol' => $user['rol'],
        ];

        return ['success' => true, 'message' => 'Bienvenido, ' . $user['nombre'] . '.'];
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
