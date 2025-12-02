<?php
$title = "Iniciar Sesión - InkaTours";
$active_page = ''; // No active page on login page
include 'header.php';
?>

    <!-- Modal de Inicio de Sesión -->
    <div class="modal-overlay" id="login-modal-overlay">
        <div class="login-modal">
            <div class="modal-header">
                <button class="modal-close" id="modal-close">&times;</button>
                <h2>Iniciar Sesión</h2>
                <p>Accede a tu cuenta de InkaTours</p>
            </div>
            <div class="modal-body">
                <form id="login-form">
                    <div class="form-group">
                        <label for="login-email">Correo Electrónico</label>
                        <input type="email" id="login-email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Contraseña</label>
                        <input type="password" id="login-password" required>
                    </div>
                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember-me">
                            <label for="remember-me">Recordarme</label>
                        </div>
                        <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                    </div>
                    <button type="submit" class="btn-login-modal">Iniciar Sesión</button>
                </form>
            </div>
            <div class="modal-footer">
                <p>¿No tienes una cuenta? <a href="#" id="register-link">Regístrate aquí</a></p>
            </div>
        </div>
    </div>

    <section class="page-hero">
        <div class="container">
            <h1>Bienvenido a InkaTours</h1>
            <p>Descubre la magia de Cusco con nosotros</p>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="user-welcome" id="user-welcome">
                <h2>¡Hola, <span id="welcome-name">Usuario</span>!</h2>
                <p>Es genial tenerte de vuelta. ¿Listo para planificar tu próxima aventura?</p>
            </div>
            
            <h2>Explora Nuestros Destinos</h2>
            <p>Descubre los lugares más increíbles que Cusco tiene para ofrecer.</p>
            <p>Para acceder a funciones exclusivas y realizar reservas, inicia sesión en tu cuenta.</p>
        </div>
    </section>

<?php include 'footer.php'; ?>