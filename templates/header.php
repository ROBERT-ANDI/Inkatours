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
    <link rel="stylesheet" href="../static/css/style.css">
</head>
<body>
    <!-- Header y Navegación -->
    <header class="header">
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-logo">
                    <a href="index.php" class="logo-link">
                        <span class="logo-icon">🏔️</span>
                        <span class="logo-text">InkaTours</span>
                    </a>
                </div>
                
                <div class="nav-menu" id="nav-menu">
                    <ul class="nav-list">
                        <li class="nav-item"><a href="index.php" class="nav-link <?php echo ($active_page == 'index') ? 'active' : ''; ?>">Inicio</a></li>
                        <li class="nav-item"><a href="destinos.php" class="nav-link <?php echo ($active_page == 'destinos') ? 'active' : ''; ?>">Destinos</a></li>
                        <li class="nav-item"><a href="actividades.php" class="nav-link <?php echo ($active_page == 'actividades') ? 'active' : ''; ?>">Actividades</a></li>
                        <li class="nav-item"><a href="mapa.php" class="nav-link <?php echo ($active_page == 'mapa') ? 'active' : ''; ?>">Mapa</a></li>
                        <li class="nav-item"><a href="predicciones.php" class="nav-link <?php echo ($active_page == 'predicciones') ? 'active' : ''; ?>">Predicciones</a></li>
                        <li class="nav-item"><a href="reservas.php" class="nav-link <?php echo ($active_page == 'reservas') ? 'active' : ''; ?>">Reservas</a></li>
                        <li class="nav-item"><a href="blog.php" class="nav-link <?php echo ($active_page == 'blog') ? 'active' : ''; ?>">Blog</a></li>
                        <li class="nav-item"><a href="contacto.php" class="nav-link <?php echo ($active_page == 'contacto') ? 'active' : ''; ?>">Contacto</a></li>
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
                    <button class="btn-login" id="login-btn">
                        <i class="fas fa-user"></i> Iniciar Sesión
                    </button>
                    <div class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </div>
                    <div class="hamburger" id="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </nav>
    </header>