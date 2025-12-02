<?php
$title = "InkaTours - Turismo Sostenible en Cusco";
$active_page = 'index';
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

    <!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Descubre Cusco de Forma Sostenible</h1>
        <p>Explora la magia de los Andes con respeto por la cultura local y el medio ambiente</p>
        <div class="hero-search">
            <input type="text" id="search-input" placeholder="Buscar destinos, actividades...">
            <button type="button" id="search-btn">
                <i class="fas fa-search" style="font-size: 0.9rem; margin-right: 0.3rem;"></i>
                Buscar
            </button>
        </div>
        <div class="search-suggestions" id="search-suggestions" style="display: none;">
            <!-- Las sugerencias aparecerán aquí -->
        </div>
    </div>
    <div class="hero-stats">
        <div class="stat">
            <span class="stat-number">150+</span>
            <span class="stat-label">Destinos Sostenibles</span>
        </div>
        <div class="stat">
            <span class="stat-number">4.8</span>
            <span class="stat-label">Valoración Promedio</span>
        </div>
        <div class="stat">
            <span class="stat-number">5000+</span>
            <span class="stat-label">Viajeros Satisfechos</span>
        </div>
    </div>
</section>

    <!-- Sección de Destinos Destacados -->
    <section class="featured-destinations">
        <div class="container">
            <h2>Destinos Destacados</h2>
            <div class="destinations-grid">
                <!-- Destino 1 -->
                <div class="destination-card">
                    <div class="card-image">
                        <img src="https://images.unsplash.com/photo-1587595431973-160d0d94add1?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Machu Picchu">
                        <span class="sustainable-badge">Sello Verde</span>
                    </div>
                    <div class="card-content">
                        <h3>Machu Picchu</h3>
                        <div class="card-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating">4.9 (1245)</span>
                        </div>
                        <p>La ciudadela inca más famosa del mundo, explorada con prácticas sostenibles.</p>
                        <div class="card-details">
                            <span><i class="fas fa-hiking"></i> Moderada</span>
                            <span><i class="fas fa-clock"></i> 1 día</span>
                            <span><i class="fas fa-users"></i> Grupos pequeños</span>
                        </div>
                        <div class="card-footer">
                            <span class="price">Desde $120</span>
                            <button class="btn-secondary">Ver detalles</button>
                        </div>
                    </div>
                </div>
                
                <!-- Destino 2 -->
                <div class="destination-card">
                    <div class="card-image">
                        <img src="https://www.boletomachupicchu.com/gutblt/wp-content/images/cusco-sacred-valley-incas.jpg" alt="Valle Sagrado">
                        <span class="sustainable-badge">Sello Verde</span>
                    </div>
                    <div class="card-content">
                        <h3>Valle Sagrado</h3>
                        <div class="card-rating">
                            <span class="stars">★★★★☆</span>
                            <span class="rating">4.7 (892)</span>
                        </div>
                        <p>Un recorrido por los pueblos andinos y mercados artesanales del valle.</p>
                        <div class="card-details">
                            <span><i class="fas fa-hiking"></i> Fácil</span>
                            <span><i class="fas fa-clock"></i> 1 día</span>
                            <span><i class="fas fa-users"></i> Grupos pequeños</span>
                        </div>
                        <div class="card-footer">
                            <span class="price">Desde $80</span>
                            <button class="btn-secondary">Ver detalles</button>
                        </div>
                    </div>
                </div>
                
                <!-- Destino 3 -->
                <div class="destination-card">
                    <div class="card-image">
                        <img src="https://vivedestinos.com/wp-content/uploads/2024/06/4-1024x538.jpg" alt="Montaña de 7 Colores">
                        <span class="sustainable-badge">Sello Verde</span>
                    </div>
                    <div class="card-content">
                        <h3>Montaña de 7 Colores</h3>
                        <div class="card-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating">4.8 (756)</span>
                        </div>
                        <p>Una caminata espectacular hacia una de las maravillas naturales del Perú.</p>
                        <div class="card-details">
                            <span><i class="fas fa-hiking"></i> Difícil</span>
                            <span><i class="fas fa-clock"></i> 1 día</span>
                            <span><i class="fas fa-users"></i> Grupos pequeños</span>
                        </div>
                        <div class="card-footer">
                            <span class="price">Desde $65</span>
                            <button class="btn-secondary">Ver detalles</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-footer">
                <a href="destinos.php" class="btn-outline">Ver todos los destinos</a>
            </div>
        </div>
    </section>
    
    <!-- Sección de Mapa Interactivo -->
    <section class="interactive-map">
        <div class="container">
            <h2>Explora Nuestros Destinos en el Mapa</h2>
            <div class="map-container">
                <div id="map"></div>
                <div class="map-controls">
                    <h3>Filtrar por:</h3>
                    <div class="filter-options">
                        <label><input type="checkbox" checked> Sostenibles</label>
                        <label><input type="checkbox" checked> Culturales</label>
                        <label><input type="checkbox" checked> Aventura</label>
                        <label><input type="checkbox" checked> Naturaleza</label>
                    </div>
                    <button class="btn-primary" id="locate-me">
                        <i class="fas fa-location-arrow"></i> Mi ubicación
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Actividades Sostenibles -->
    <section class="sustainable-activities">
        <div class="container">
            <h2>Actividades con Impacto Positivo</h2>
            <div class="activities-tabs">
                <button class="tab-button active" data-tab="all">Todas</button>
                <button class="tab-button" data-tab="cultural">Cultural</button>
                <button class="tab-button" data-tab="adventure">Aventura</button>
                <button class="tab-button" data-tab="nature">Naturaleza</button>
                <button class="tab-button" data-tab="community">Comunitario</button>
            </div>
            <div class="activities-grid">
                <!-- Actividad 1 -->
                <div class="activity-card" data-category="cultural">
                    <div class="activity-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3>Turismo Comunitario</h3>
                    <p>Convivir con comunidades locales y apoyar su economía directamente.</p>
                    <span class="impact-badge">+Impacto</span>
                </div>
                
                <!-- Actividad 2 -->
                <div class="activity-card" data-category="adventure">
                    <div class="activity-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Senderismo Ecológico</h3>
                    <p>Rutas que minimizan el impacto ambiental y promueven la conservación.</p>
                    <span class="impact-badge">+Impacto</span>
                </div>
                
                <!-- Actividad 3 -->
                <div class="activity-card" data-category="nature">
                    <div class="activity-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3>Reforestación</h3>
                    <p>Participa en programas de reforestación de especies nativas.</p>
                    <span class="impact-badge">+Impacto</span>
                </div>
                
                <!-- Actividad 4 -->
                <div class="activity-card" data-category="community">
                    <div class="activity-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3>Comercio Justo</h3>
                    <p>Compra directa de artesanías a productores locales a precios justos.</p>
                    <span class="impact-badge">+Impacto</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Predicción de Afluencia -->
    <section class="crowd-prediction">
        <div class="container">
            <h2>Predicción de Afluencia Turística</h2>
            <div class="prediction-content">
                <div class="prediction-chart">
                    <canvas id="crowdChart"></canvas>
                </div>
                <div class="prediction-info">
                    <h3>Recomendaciones para Hoy</h3>
                    <div class="recommendation">
                        <div class="rec-level high">
                            <span>Machu Picchu: Alta afluencia</span>
                            <p>Mejor horario: Antes de las 10am o después de las 2pm</p>
                        </div>
                        <div class="rec-level medium">
                            <span>Valle Sagrado: Afluencia media</span>
                            <p>Ideal para visitar durante todo el día</p>
                        </div>
                        <div class="rec-level low">
                            <span>Moray: Baja afluencia</span>
                            <p>Excelente opción para evitar multitudes</p>
                        </div>
                    </div>
                    <button class="btn-primary" onclick="window.location.href='predicciones.php'">
                    Ver predicción completa
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Testimonios -->
    <section class="testimonials">
        <div class="container">
            <h2>Lo que Dicen Nuestros Viajeros</h2>
            <div class="testimonials-slider">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="stars">★★★★★</div>
                        <p>"InkaTours me permitió conocer Cusco de una manera auténtica y responsable. La atención a la sostenibilidad es impresionante."</p>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="María González">
                            <div>
                                <strong>María González</strong>
                                <span>España</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="stars">★★★★☆</div>
                        <p>"La aplicación de predicción de afluencia fue increíblemente útil para planificar nuestras visitas y evitar las multitudes."</p>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="John Smith">
                            <div>
                                <strong>John Smith</strong>
                                <span>Estados Unidos</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="stars">★★★★★</div>
                        <p>"El enfoque en el turismo comunitario hizo que nuestro viaje fuera más significativo. ¡Volveremos!"</p>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/67.jpg" alt="Ana Silva">
                            <div>
                                <strong>Ana Silva</strong>
                                <span>Brasil</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>