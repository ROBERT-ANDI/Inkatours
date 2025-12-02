<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'InkaTours'; ?></title>
    
    <!-- Hojas de estilo externas -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Tu hoja de estilo local -->
    <link rel="stylesheet" href="/mi%20proyecto/static/css/style.css">
    <script src="/mi%20proyecto/static/js/busqueda.js" defer></script>
</head>
<body>
    <!-- Header y Navegación -->
    <header class="header">
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-logo">
                    <a href="/mi%20proyecto/" class="logo-link">
                        <span class="logo-icon">🏔️</span>
                        <span class="logo-text">InkaTours</span>
                    </a>
                </div>
                
                <div class="nav-menu" id="nav-menu">
                    <ul class="nav-list">
                        <li class="nav-item"><a href="/mi%20proyecto/" class="nav-link <?php echo ($active_page == 'index') ? 'active' : ''; ?>" data-i18n="inicio">Inicio</a></li>
                        <li class="nav-item"><a href="/mi%20proyecto/destinos" class="nav-link <?php echo ($active_page == 'destinos') ? 'active' : ''; ?>" data-i18n="destinos">Destinos</a></li>
                        <li class="nav-item"><a href="/mi%20proyecto/actividades" class="nav-link <?php echo ($active_page == 'actividades') ? 'active' : ''; ?>" data-i18n="actividades">Actividades</a></li>
                        <li class="nav-item"><a href="/mi%20proyecto/mapa" class="nav-link <?php echo ($active_page == 'mapa') ? 'active' : ''; ?>" data-i18n="mapa">Mapa</a></li>
                        <li class="nav-item"><a href="/mi%20proyecto/predicciones" class="nav-link <?php echo ($active_page == 'predicciones') ? 'active' : ''; ?>" data-i18n="predicciones">Predicciones</a></li>
                        <li class="nav-item"><a href="/mi%20proyecto/reservas" class="nav-link <?php echo ($active_page == 'reservas') ? 'active' : ''; ?>" data-i18n="reservas">Reservas</a></li>
                        <li class="nav-item"><a href="/mi%20proyecto/blog" class="nav-link <?php echo ($active_page == 'blog') ? 'active' : ''; ?>" data-i18n="blog">Blog</a></li>
                        <li class="nav-item"><a href="/mi%20proyecto/contacto" class="nav-link <?php echo ($active_page == 'contacto') ? 'active' : ''; ?>" data-i18n="contacto">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="nav-actions">
                    <div class="language-selector">
                        <select id="language-select">
                            <option value="es">ES</option>
                            <option value="en">EN</option>
                            <option value="qu">QU</option>
                            <option value="pt">PT</option>
                        </select>
                    </div>
                    <?php if(isset($_SESSION['user_id'])) : ?>
                        <div class="user-menu">
                            <div class="user-info user-dropdown-toggle">
                                <div class="user-avatar">U</div>
                                <span><?php echo $_SESSION['user_name']; ?></span>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                                <div class="user-dropdown">
                                    <a href="/mi%20proyecto/perfil">Mi Perfil</a>
                                    <a href="/mi%20proyecto/iniciosesion/logout">Salir</a>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <a href="/mi%20proyecto/iniciosesion" class="btn-login" id="login-btn" data-i18n="iniciar_sesion">
                            <i class="fas fa-user"></i> Iniciar Sesión
                        </a>
                    <?php endif; ?>
                    <div class="hamburger" id="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </nav>
    </header>