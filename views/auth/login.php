<?php
require_once __DIR__ . '/../layout/header.php';
?>
<section class="auth-panel">
    <div class="card auth-card">
        <h1>Iniciar sesión</h1>
        <p class="description">Accede como administrador o cliente para continuar.</p>
        <form action="index.php?action=login" method="post" class="form-grid">
            <label>
                Correo electrónico
                <input type="email" name="email" required placeholder="admin@tienda.com">
            </label>
            <label>
                Contraseña
                <input type="password" name="password" required placeholder="********">
            </label>
            <button type="submit" class="button primary">Ingresar</button>
        </form>
        <p class="form-note">¿No tienes cuenta? <a href="index.php?page=register">Regístrate</a></p>
    </div>
</section>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
