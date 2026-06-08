<?php
require_once __DIR__ . '/../layout/header.php';
?>
<section class="auth-panel">
    <div class="card auth-card">
        <h1>Crear cuenta</h1>
        <p class="description">Regístrate como cliente para ver el catálogo y comprar.</p>
        <form action="index.php?action=register" method="post" class="form-grid">
            <label>
                Nombre completo
                <input type="text" name="nombre" required placeholder="Tu nombre">
            </label>
            <label>
                Correo electrónico
                <input type="email" name="email" required placeholder="usuario@correo.com">
            </label>
            <label>
                Contraseña
                <input type="password" name="password" required placeholder="********">
            </label>
            <label>
                Confirmar contraseña
                <input type="password" name="confirm_password" required placeholder="********">
            </label>
            <button type="submit" class="button primary">Registrarse</button>
        </form>
        <p class="form-note">¿Ya tienes cuenta? <a href="index.php?page=login">Inicia sesión</a></p>
    </div>
</section>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
