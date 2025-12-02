<?php
$title = "InkaTours - Predicciones de Afluencia";
$active_page = 'predicciones';
include 'header.php';
?>

    <!-- Modal de Login/Registro -->
    <div class="modal" id="auth-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-tabs">
                <div class="modal-tab active" data-tab="login">Iniciar Sesión</div>
                <div class="modal-tab" data-tab="register">Registrarse</div>
            </div>
            
            <div class="tab-content active" id="login-tab">
                <form id="login-form">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="login-email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="login-password" required>
                    </div>
                    <button type="submit" class="btn-primary">Ingresar</button>
                </form>
                <p style="margin-top: 1rem; text-align: center;">¿No tienes cuenta? <a href="#" id="show-register">Regístrate aquí</a></p>
            </div>
            
            <div class="tab-content" id="register-tab">
                <form id="register-form">
                    <div class="form-group">
                        <label for="name">Nombre completo</label>
                        <input type="text" id="register-name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="register-email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="register-password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirmar contraseña</label>
                        <input type="password" id="confirm-password" required>
                    </div>
                    <button type="submit" class="btn-primary">Registrarse</button>
                </form>
                <p style="margin-top: 1rem; text-align: center;">¿Ya tienes cuenta? <a href="#" id="show-login">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>

    <!-- Dashboard de Afluencia -->
    <section class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard de Afluencia Turística</h1>
            <div class="date-selector">
                <select id="date-range">
                    <option value="today">Hoy</option>
                    <option value="tomorrow">Mañana</option>
                    <option value="weekend">Este fin de semana</option>
                    <option value="nextweek">Próxima semana</option>
                </select>
                <input type="date" id="custom-date" style="display: none;">
            </div>
        </div>
        
        <div class="dashboard-grid">
            <!-- Tarjeta de Predicción de Afluencia -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h2 class="card-title">Predicción de Afluencia</h2>
                    <i class="fas fa-chart-line card-icon"></i>
                </div>
                <p>Pronóstico de visitantes para los principales sitios turísticos</p>
                <div class="prediction-chart">
                    <canvas id="predictionChart"></canvas>
                </div>
            </div>
            
            <!-- Tarjeta de Alertas -->
            <div class="dashboard-card alert-card">
                <div class="card-header">
                    <h2 class="card-title">Alertas de Saturación</h2>
                    <i class="fas fa-exclamation-triangle card-icon"></i>
                </div>
                <p>Sitios con alta afluencia esperada</p>
                <ul class="alert-list">
                    <li class="alert-item">
                        <i class="fas fa-exclamation-circle alert-icon"></i>
                        <div class="alert-content">
                            <h4>Machu Picchu</h4>
                            <p>Alta saturación esperada entre 10:00 - 14:00 (85% capacidad)</p>
                        </div>
                    </li>
                    <li class="alert-item">
                        <i class="fas fa-exclamation-circle alert-icon"></i>
                        <div class="alert-content">
                            <h4>Montaña 7 Colores</h4>
                            <p>Capacidad casi completa entre 8:00 - 10:00 (78% capacidad)</p>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Tarjeta de Recomendaciones -->
            <div class="dashboard-card recommendation-card">
                <div class="card-header">
                    <h2 class="card-title">Horarios Recomendados</h2>
                    <i class="fas fa-clock card-icon"></i>
                </div>
                <p>Mejores momentos para visitar sitios populares</p>
                <ul class="recommendation-list">
                    <li class="recommendation-item">
                        <i class="fas fa-check-circle recommendation-icon"></i>
                        <div class="recommendation-content">
                            <h4>Machu Picchu</h4>
                            <p>Mejor horario: Antes de las 10:00 o después de las 14:00</p>
                        </div>
                    </li>
                    <li class="recommendation-item">
                        <i class="fas fa-check-circle recommendation-icon"></i>
                        <div class="recommendation-content">
                            <h4>Valle Sagrado</h4>
                            <p>Ideal para visitar durante todo el día</p>
                        </div>
                    </li>
                    <li class="recommendation-item">
                        <i class="fas fa-check-circle recommendation-icon"></i>
                        <div class="recommendation-content">
                            <h4>Montaña 7 Colores</h4>
                            <p>Mejor después de las 11:00 para evitar multitudes</p>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Tarjeta de Estado de Sitios -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h2 class="card-title">Estado de Sitios</h2>
                    <i class="fas fa-map-marker-alt card-icon"></i>
                </div>
                <p>Nivel actual de afluencia en tiempo real</p>
                <ul class="site-list">
                    <li class="site-item">
                        <div class="site-info">
                            <h4>Machu Picchu</h4>
                            <p>Capacidad: 2,500 visitantes/día</p>
                        </div>
                        <div class="site-status">
                            <div class="status-indicator status-high"></div>
                            <span>Alta</span>
                        </div>
                    </li>
                    <li class="site-item">
                        <div class="site-info">
                            <h4>Valle Sagrado</h4>
                            <p>Capacidad: 3,000 visitantes/día</p>
                        </div>
                        <div class="site-status">
                            <div class="status-indicator status-medium"></div>
                            <span>Media</span>
                        </div>
                    </li>
                    <li class="site-item">
                        <div class="site-info">
                            <h4>Montaña 7 Colores</h4>
                            <p>Capacidad: 800 visitantes/día</p>
                        </div>
                        <div class="site-status">
                            <div class="status-indicator status-high"></div>
                            <span>Alta</span>
                        </div>
                    </li>
                    <li class="site-item">
                        <div class="site-info">
                            <h4>Moray</h4>
                            <p>Capacidad: 1,200 visitantes/día</p>
                        </div>
                        <div class="site-status">
                            <div class="status-indicator status-low"></div>
                            <span>Baja</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Mapa de Afluencia -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Mapa de Afluencia</h2>
                <i class="fas fa-map card-icon"></i>
            </div>
            <p>Visualización de la afluencia en sitios turísticos de Cusco</p>
            <div class="dashboard-map" id="crowdMap"></div>
        </div>
        
        <!-- Alternativas Sostenibles -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Alternativas Sostenibles</h2>
                <i class="fas fa-leaf card-icon"></i>
            </div>
            <p>Destinos menos congestionados con experiencias auténticas</p>
            
            <div class="alternative-card">
                <img src="https://www.alpacaexpeditions.com/wp-content/uploads/road-choquequirao.jpg" alt="Choquequirao" class="alternative-image">
                <div class="alternative-info">
                    <h4>Choquequirao</h4>
                    <p>Conocida como la "hermana sagrada" de Machu Picchu, esta ciudadela inca ofrece una experiencia más íntima y menos concurrida.</p>
                    <div class="alternative-meta">
                        <span><i class="fas fa-hiking"></i> Dificultad: Alta</span>
                        <span><i class="fas fa-clock"></i> 4 días</span>
                        <span><i class="fas fa-users"></i> Grupos pequeños</span>
                    </div>
                </div>
                <button class="btn-alternative">Ver detalles</button>
            </div>
            
            <div class="alternative-card">
                <img src="https://cuscoperu.b-cdn.net/wp-content/uploads/2024/06/Vista-del-valle-Ollantaytambo-cel.jpg" alt="Ollantaytambo" class="alternative-image">
                <div class="alternative-info">
                    <h4>Ollantaytambo</h4>
                    <p>Pueblo inca viviente con impresionante fortaleza y menos afluencia que otros sitios del Valle Sagrado.</p>
                    <div class="alternative-meta">
                        <span><i class="fas fa-hiking"></i> Dificultad: Moderada</span>
                        <span><i class="fas fa-clock"></i> 1 día</span>
                        <span><i class="fas fa-users"></i> Grupos pequeños</span>
                    </div>
                </div>
                <button class="btn-alternative">Ver detalles</button>
            </div>
            
            <div class="alternative-card">
                <img src="https://www.libertrekperutravel.com/wp-content/uploads/2023/10/exploring-cuscos-south-valley-9_wUtMKf4.jpg" alt="Valle Sur" class="alternative-image">
                <div class="alternative-info">
                    <h4>Valle Sur de Cusco</h4>https://www.libertrekperutravel.com/wp-content/uploads/2023/10/exploring-cuscos-south-valley-9_wUtMKf4.jpg
                    <p>Ruta menos conocida que incluye Tipón, Pikillacta y Andahuaylillas, con arquitectura inca y colonial.</p>
                    <div class="alternative-meta">
                        <span><i class="fas fa-hiking"></i> Dificultad: Fácil</span>
                        <span><i class="fas fa-clock"></i> 1 día</span>
                        <span><i class="fas fa-users"></i> Grupos pequeños</span>
                    </div>
                </div>
                <button class="btn-alternative">Ver detalles</button>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>