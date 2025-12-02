<?php require_once 'partials/header.php'; ?>

<!-- Dashboard Turístico Inteligente -->
<section class="tourist-dashboard">
    <!-- Hero Section con Búsqueda -->
    <div class="hero-search">
        <div class="hero-content">
            <h1>Planifica tu Aventura Andina con Inteligencia</h1>
            <p class="hero-subtitle">Evita multitudes, descubre joyas ocultas y vive experiencias auténticas</p>
            
            <div class="search-box">
                <div class="search-tabs">
                    <button class="search-tab active" data-tab="destinos">Destinos</button>
                    <button class="search-tab" data-tab="actividades">Actividades</button>
                    <button class="search-tab" data-tab="fechas">Por Fecha</button>
                </div>
                
                <div class="search-content active" id="destinos-search">
                    <div class="search-row">
                        <div class="search-group">
                            <label for="destination-type"><i class="fas fa-map-marker-alt"></i> Tipo de Experiencia</label>
                            <select id="destination-type" class="search-select">
                                <option value="">Todos los destinos</option>
                                <option value="cultural">Cultural e Histórico</option>
                                <option value="nature">Naturaleza y Aventura</option>
                                <option value="community">Turismo Comunitario</option>
                                <option value="trekking">Trekking</option>
                            </select>
                        </div>
                        
                        <div class="search-group">
                            <label for="crowd-level"><i class="fas fa-users"></i> Nivel de Congestión</label>
                            <select id="crowd-level" class="search-select">
                                <option value="">Cualquier nivel</option>
                                <option value="low">Baja (Menos del 30%)</option>
                                <option value="medium">Moderada (30-60%)</option>
                                <option value="high">Alta (61-80%)</option>
                                <option value="avoid">Evitar (>80%)</option>
                            </select>
                        </div>
                        
                        <button class="btn-primary btn-search" id="search-destinations">
                            <i class="fas fa-search"></i> Buscar Destinos
                        </button>
                    </div>
                </div>
                
                <div class="search-content" id="actividades-search">
                    <div class="search-row">
                        <div class="search-group">
                            <label for="activity-type"><i class="fas fa-hiking"></i> Tipo de Actividad</label>
                            <select id="activity-type" class="search-select">
                                <option value="">Todas las actividades</option>
                                <option value="trekking">Trekking y Senderismo</option>
                                <option value="cultural">Cultural y Educativa</option>
                                <option value="adventure">Aventura Extrema</option>
                                <option value="community">Experiencia Comunitaria</option>
                            </select>
                        </div>
                        
                        <div class="search-group">
                            <label for="difficulty"><i class="fas fa-mountain"></i> Dificultad</label>
                            <select id="difficulty" class="search-select">
                                <option value="">Cualquier dificultad</option>
                                <option value="easy">Fácil</option>
                                <option value="moderate">Moderada</option>
                                <option value="difficult">Difícil</option>
                            </select>
                        </div>
                        
                        <button class="btn-primary btn-search" id="search-activities">
                            <i class="fas fa-search"></i> Buscar Actividades
                        </button>
                    </div>
                </div>
                
                <div class="search-content" id="fechas-search">
                    <div class="search-row">
                        <div class="search-group">
                            <label for="visit-date"><i class="fas fa-calendar-alt"></i> Fecha de Visita</label>
                            <input type="date" id="visit-date" class="search-input" value="<?php echo date('Y-m-d', strtotime('+3 days')); ?>">
                        </div>
                        
                        <div class="search-group">
                            <label for="preferred-time"><i class="fas fa-clock"></i> Hora Preferida</label>
                            <select id="preferred-time" class="search-select">
                                <option value="">Cualquier hora</option>
                                <option value="early">Temprano (6:00 - 9:00)</option>
                                <option value="morning">Mañana (9:00 - 12:00)</option>
                                <option value="afternoon">Tarde (12:00 - 15:00)</option>
                                <option value="late">Tarde-Noche (15:00+)</option>
                            </select>
                        </div>
                        
                        <button class="btn-primary btn-search" id="search-by-date">
                            <i class="fas fa-search"></i> Ver Predicciones
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alertas en Tiempo Real -->
    <div class="real-time-alerts">
        <div class="alert-header">
            <h2><i class="fas fa-bell"></i> Alertas en Tiempo Real</h2>
            <div class="alert-timestamp">Actualizado: <?php echo date('H:i'); ?></div>
        </div>
        
        <div class="alert-scroll">
            <?php if (isset($data['alertas_tiempo_real']) && !empty($data['alertas_tiempo_real'])): ?>
                <?php foreach ($data['alertas_tiempo_real'] as $alerta): ?>
                    <div class="live-alert alert-<?php echo $alerta['nivel']; ?>">
                        <div class="alert-icon">
                            <?php if ($alerta['nivel'] == 'critical'): ?>
                                <i class="fas fa-exclamation-triangle"></i>
                            <?php elseif ($alerta['nivel'] == 'warning'): ?>
                                <i class="fas fa-exclamation-circle"></i>
                            <?php else: ?>
                                <i class="fas fa-info-circle"></i>
                            <?php endif; ?>
                        </div>
                        <div class="alert-content">
                            <strong><?php echo $alerta['titulo']; ?></strong>
                            <span><?php echo $alerta['mensaje']; ?></span>
                        </div>
                        <div class="alert-time"><?php echo $alerta['tiempo']; ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="live-alert alert-info">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <strong>Condiciones normales</strong>
                        <span>Todos los destinos están operando dentro de parámetros normales</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Mapa Interactivo de Congestión -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2><i class="fas fa-map-marked-alt"></i> Mapa de Congestión en Tiempo Real</h2>
            <div class="map-controls">
                <button class="btn-map-control" id="refresh-map"><i class="fas fa-sync-alt"></i> Actualizar</button>
                <button class="btn-map-control" id="toggle-traffic"><i class="fas fa-users"></i> Mostrar Tráfico</button>
                <button class="btn-map-control" id="show-alternatives"><i class="fas fa-leaf"></i> Alternativas</button>
            </div>
        </div>
        
        <div class="crowd-map-container">
            <div class="map-sidebar">
                <div class="map-legend">
                    <h4>Leyenda de Congestión</h4>
                    <div class="legend-items">
                        <div class="legend-item">
                            <span class="legend-dot dot-free"></span>
                            <span class="legend-label">Libre (0-30%)</span>
                            <span class="legend-count"><?php echo $data['estadisticas']['libre'] ?? 8; ?> destinos</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot dot-moderate"></span>
                            <span class="legend-label">Moderado (31-60%)</span>
                            <span class="legend-count"><?php echo $data['estadisticas']['moderado'] ?? 12; ?> destinos</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot dot-busy"></span>
                            <span class="legend-label">Ocupado (61-80%)</span>
                            <span class="legend-count"><?php echo $data['estadisticas']['ocupado'] ?? 5; ?> destinos</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot dot-crowded"></span>
                            <span class="legend-label">Congestionado (>80%)</span>
                            <span class="legend-count"><?php echo $data['estadisticas']['congestionado'] ?? 3; ?> destinos</span>
                        </div>
                    </div>
                </div>
                
                <div class="peak-hours">
                    <h4>Horas Pico para Hoy</h4>
                    <div class="peak-chart">
                        <canvas id="peakHoursChart" height="120"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="map-main">
                <div class="map-placeholder">
                    <!-- En producción, aquí iría un mapa interactivo como Google Maps o Mapbox -->
                    <div class="map-simulation">
                        <?php if (isset($data['destinos_mapa']) && !empty($data['destinos_mapa'])): ?>
                            <?php foreach ($data['destinos_mapa'] as $destino): ?>
                                <div class="map-point point-<?php echo $destino['nivel']; ?>" 
                                     style="top: <?php echo $destino['pos_y']; ?>%; left: <?php echo $destino['pos_x']; ?>%;"
                                     data-destino="<?php echo $destino['nombre']; ?>"
                                     data-congestion="<?php echo $destino['congestion']; ?>%"
                                     data-recommendation="<?php echo $destino['recomendacion']; ?>">
                                    <div class="point-tooltip">
                                        <h5><?php echo $destino['nombre']; ?></h5>
                                        <p>Congestión: <?php echo $destino['congestion']; ?>%</p>
                                        <p>Mejor hora: <?php echo $destino['mejor_hora']; ?></p>
                                        <a href="#" class="btn-sm">Ver detalles</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div class="map-overlay">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/Peru_location_map.svg/800px-Peru_location_map.svg.png" alt="Mapa de Cusco" class="map-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Predicciones Inteligentes por Día -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2><i class="fas fa-calendar-check"></i> Predicciones de Congestión por Día</h2>
            <div class="day-navigation">
                <button class="btn-day-nav" id="prev-week"><i class="fas fa-chevron-left"></i></button>
                <div class="current-week" id="current-week-range">
                    <?php 
                    $startWeek = date('d M', strtotime('monday this week'));
                    $endWeek = date('d M', strtotime('sunday this week'));
                    echo "$startWeek - $endWeek";
                    ?>
                </div>
                <button class="btn-day-nav" id="next-week"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        
        <div class="daily-predictions">
            <?php 
            $days = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
            $today = date('N') - 1; // 0-6 para lunes-domingo
            ?>
            
            <?php foreach ($days as $index => $day): ?>
                <?php 
                $dayDate = date('Y-m-d', strtotime("monday this week +$index days"));
                $isToday = ($index == $today);
                ?>
                
                <div class="day-card <?php echo $isToday ? 'today' : ''; ?>">
                    <div class="day-header">
                        <div class="day-name"><?php echo $day; ?></div>
                        <div class="day-date"><?php echo date('d/m', strtotime($dayDate)); ?></div>
                        <?php if ($isToday): ?>
                            <span class="day-badge">Hoy</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="day-weather">
                        <i class="fas fa-sun"></i>
                        <span class="weather-temp">22°C</span>
                    </div>
                    
                    <div class="day-prediction">
                        <div class="prediction-bar">
                            <?php 
                            $prediction = $data['predicciones_semana'][$index] ?? rand(40, 90);
                            $barClass = '';
                            if ($prediction < 40) $barClass = 'low';
                            elseif ($prediction < 70) $barClass = 'medium';
                            elseif ($prediction < 85) $barClass = 'high';
                            else $barClass = 'very-high';
                            ?>
                            <div class="prediction-fill fill-<?php echo $barClass; ?>" style="height: <?php echo $prediction; ?>%"></div>
                        </div>
                        <div class="prediction-value"><?php echo $prediction; ?>%</div>
                    </div>
                    
                    <div class="day-recommendation">
                        <?php 
                        $recommendations = [
                            'Excelente día para visitar',
                            'Buena opción',
                            'Considerar horas tempranas',
                            'Buscar alternativas'
                        ];
                        $recIndex = floor($prediction / 25);
                        ?>
                        <span class="rec-text"><?php echo $recommendations[$recIndex]; ?></span>
                    </div>
                    
                    <button class="btn-day-details" data-date="<?php echo $dayDate; ?>">
                        <i class="fas fa-info-circle"></i> Detalles
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Recomendaciones Inteligentes -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2><i class="fas fa-lightbulb"></i> Recomendaciones Inteligentes para Ti</h2>
            <div class="recommendation-filter">
                <button class="filter-btn active" data-filter="all">Todas</button>
                <button class="filter-btn" data-filter="low-crowd">Baja Congestión</button>
                <button class="filter-btn" data-filter="authentic">Auténticas</button>
                <button class="filter-btn" data-filter="family">Familia</button>
            </div>
        </div>
        
        <div class="recommendations-grid">
            <!-- Joyas Ocultas (Baja Congestión) -->
            <div class="recommendation-card category-low-crowd">
                <div class="rec-badge"><i class="fas fa-gem"></i> Joya Oculta</div>
                <img src="https://www.libertrekperutravel.com/wp-content/uploads/2023/10/exploring-cuscos-south-valley-9_wUtMKf4.jpg" alt="Valle Sur" class="rec-image">
                <div class="rec-content">
                    <h3 class="rec-title">Valle Sur de Cusco</h3>
                    <p class="rec-description">Ruta menos conocida con sitios arqueológicos impresionantes y pocos turistas.</p>
                    
                    <div class="rec-metrics">
                        <div class="rec-metric">
                            <i class="fas fa-users"></i>
                            <span class="metric-value">25%</span>
                            <span class="metric-label">Congestión</span>
                        </div>
                        <div class="rec-metric">
                            <i class="fas fa-star"></i>
                            <span class="metric-value">4.8</span>
                            <span class="metric-label">Rating</span>
                        </div>
                        <div class="rec-metric">
                            <i class="fas fa-clock"></i>
                            <span class="metric-value">1 día</span>
                            <span class="metric-label">Duración</span>
                        </div>
                    </div>
                    
                    <div class="rec-actions">
                        <button class="btn-primary btn-sm">Ver detalles</button>
                        <button class="btn-outline btn-sm"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>
            
            <!-- Experiencias Auténticas -->
            <div class="recommendation-card category-authentic">
                <div class="rec-badge"><i class="fas fa-hands-helping"></i> Experiencia Comunitaria</div>
                <img src="https://www.cuscoperu.com/wp-content/uploads/2021/02/chinchero-peru.jpg" alt="Chinchero" class="rec-image">
                <div class="rec-content">
                    <h3 class="rec-title">Taller de Tejidos en Chinchero</h3>
                    <p class="rec-description">Aprende técnicas ancestrales de tejido directamente de maestras quechuas.</p>
                    
                    <div class="rec-metrics">
                        <div class="rec-metric">
                            <i class="fas fa-users"></i>
                            <span class="metric-value">35%</span>
                            <span class="metric-label">Congestión</span>
                        </div>
                        <div class="rec-metric">
                            <i class="fas fa-leaf"></i>
                            <span class="metric-value">100%</span>
                            <span class="metric-label">Sostenible</span>
                        </div>
                        <div class="rec-metric">
                            <i class="fas fa-clock"></i>
                            <span class="metric-value">4 hrs</span>
                            <span class="metric-label">Duración</span>
                        </div>
                    </div>
                    
                    <div class="rec-actions">
                        <button class="btn-primary btn-sm">Reservar ahora</button>
                        <button class="btn-outline btn-sm"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>
            
            <!-- Alternativas a Destinos Populares -->
            <div class="recommendation-card">
                <div class="rec-badge"><i class="fas fa-exchange-alt"></i> Alternativa Recomendada</div>
                <img src="https://www.alpacaexpeditions.com/wp-content/uploads/road-choquequirao.jpg" alt="Choquequirao" class="rec-image">
                <div class="rec-content">
                    <h3 class="rec-title">Choquequirao en lugar de Machu Picchu</h3>
                    <p class="rec-description">La "hermana sagrada" con la misma magia pero sin las multitudes.</p>
                    
                    <div class="rec-comparison">
                        <div class="comparison-item">
                            <span class="comp-destination">Machu Picchu</span>
                            <span class="comp-crowd crowded">85%</span>
                        </div>
                        <div class="comparison-item">
                            <span class="comp-destination">Choquequirao</span>
                            <span class="comp-crowd low">30%</span>
                        </div>
                    </div>
                    
                    <div class="rec-actions">
                        <button class="btn-primary btn-sm">Comparar</button>
                        <button class="btn-outline btn-sm">Planificar ruta</button>
                    </div>
                </div>
            </div>
            
            <!-- Mejores Horarios -->
            <div class="recommendation-card">
                <div class="rec-badge"><i class="fas fa-clock"></i> Horario Óptimo</div>
                <div class="rec-content">
                    <h3 class="rec-title">Machu Picchu - Horas Recomendadas</h3>
                    <p class="rec-description">Evita las multitudes visitando en estos horarios:</p>
                    
                    <div class="time-slots">
                        <div class="time-slot good">
                            <span class="slot-time">6:00 - 8:00 AM</span>
                            <span class="slot-crowd">40% congestión</span>
                            <span class="slot-reason">Amanecer mágico</span>
                        </div>
                        <div class="time-slot moderate">
                            <span class="slot-time">3:00 - 5:00 PM</span>
                            <span class="slot-crowd">60% congestión</span>
                            <span class="slot-reason">Luz dorada para fotos</span>
                        </div>
                        <div class="time-slot avoid">
                            <span class="slot-time">10:00 AM - 2:00 PM</span>
                            <span class="slot-crowd">90% congestión</span>
                            <span class="slot-reason">Horas pico</span>
                        </div>
                    </div>
                    
                    <div class="rec-actions">
                        <button class="btn-primary btn-sm">Ver disponibilidad</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Widget de Predicción Personalizada -->
    <div class="personalized-widget">
        <div class="widget-header">
            <h3><i class="fas fa-user-cog"></i> Planificador Personalizado</h3>
            <p>Cuéntanos tus preferencias para recomendaciones precisas</p>
        </div>
        
        <div class="widget-form">
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-user-friends"></i> Tipo de Viaje</label>
                    <select class="form-select" id="trip-type">
                        <option value="">Seleccionar</option>
                        <option value="solo">Solo viajero</option>
                        <option value="couple">Pareja</option>
                        <option value="family">Familia</option>
                        <option value="friends">Grupo de amigos</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Fechas de Viaje</label>
                    <input type="text" class="form-input date-range-input" placeholder="Seleccionar fechas">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-mountain"></i> Intereses Principales</label>
                    <div class="interest-tags">
                        <label class="tag-option">
                            <input type="checkbox" name="interests" value="history">
                            <span class="tag-label">Historia y Cultura</span>
                        </label>
                        <label class="tag-option">
                            <input type="checkbox" name="interests" value="nature">
                            <span class="tag-label">Naturaleza</span>
                        </label>
                        <label class="tag-option">
                            <input type="checkbox" name="interests" value="adventure">
                            <span class="tag-label">Aventura</span>
                        </label>
                        <label class="tag-option">
                            <input type="checkbox" name="interests" value="food">
                            <span class="tag-label">Gastronomía</span>
                        </label>
                        <label class="tag-option">
                            <input type="checkbox" name="interests" value="photography">
                            <span class="tag-label">Fotografía</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-users"></i> Preferencia de Multitudes</label>
                    <div class="crowd-preference">
                        <div class="preference-slider">
                            <input type="range" min="0" max="100" value="30" class="slider" id="crowd-preference">
                            <div class="slider-labels">
                                <span>Evitar multitudes</span>
                                <span>No me importa</span>
                                <span>Buscar ambiente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="btn-primary btn-lg" id="generate-plan">
                <i class="fas fa-magic"></i> Generar Plan Personalizado
            </button>
        </div>
    </div>
</section>

<!-- Modal de Detalles de Destino -->
<div class="modal" id="destination-modal">
    <div class="modal-content modal-lg">
        <span class="close-modal">&times;</span>
        <div id="destination-detail-content">
            <!-- Contenido cargado dinámicamente -->
        </div>
    </div>
</div>

<!-- Estilos CSS -->
<style>
    .tourist-dashboard {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .hero-search {
        background: linear-gradient(135deg, #2A9D8F 0%, #264653 100%);
        border-radius: 15px;
        padding: 40px;
        margin-bottom: 30px;
        color: white;
    }
    
    .hero-content h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
        color: white;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 30px;
    }
    
    .search-box {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .search-tabs {
        display: flex;
        border-bottom: 2px solid #eee;
        margin-bottom: 20px;
    }
    
    .search-tab {
        padding: 12px 24px;
        background: none;
        border: none;
        font-size: 1rem;
        color: #666;
        cursor: pointer;
        position: relative;
    }
    
    .search-tab.active {
        color: #2A9D8F;
        font-weight: 600;
    }
    
    .search-tab.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: #2A9D8F;
    }
    
    .search-content {
        display: none;
    }
    
    .search-content.active {
        display: block;
    }
    
    .search-row {
        display: flex;
        gap: 15px;
        align-items: flex-end;
    }
    
    .search-group {
        flex: 1;
    }
    
    .search-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
    }
    
    .search-select, .search-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
    }
    
    .btn-search {
        padding: 12px 30px;
        height: 44px;
    }
    
    .real-time-alerts {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        border-left: 4px solid #2A9D8F;
    }
    
    .alert-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .alert-timestamp {
        color: #666;
        font-size: 0.9rem;
    }
    
    .alert-scroll {
        max-height: 200px;
        overflow-y: auto;
    }
    
    .live-alert {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin-bottom: 8px;
        border-radius: 6px;
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .alert-critical {
        border-left: 4px solid #E74C3C;
        background: #FDEDEC;
    }
    
    .alert-warning {
        border-left: 4px solid #F39C12;
        background: #FEF9E7;
    }
    
    .alert-info {
        border-left: 4px solid #3498DB;
        background: #EBF5FB;
    }
    
    .alert-icon {
        margin-right: 15px;
        font-size: 1.2rem;
    }
    
    .alert-content {
        flex: 1;
    }
    
    .alert-content strong {
        display: block;
        margin-bottom: 3px;
    }
    
    .alert-content span {
        color: #666;
        font-size: 0.9rem;
    }
    
    .dashboard-section {
        margin-bottom: 40px;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .crowd-map-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 20px;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .map-sidebar {
        background: #f8f9fa;
        padding: 20px;
    }
    
    .map-legend {
        margin-bottom: 30px;
    }
    
    .legend-items {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        padding: 8px;
        border-radius: 6px;
        background: white;
    }
    
    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 10px;
    }
    
    .dot-free { background: #27AE60; }
    .dot-moderate { background: #F39C12; }
    .dot-busy { background: #E74C3C; }
    .dot-crowded { background: #8B0000; }
    
    .legend-label {
        flex: 1;
        font-size: 0.9rem;
    }
    
    .legend-count {
        background: #eee;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
    }
    
    .map-main {
        position: relative;
        min-height: 500px;
    }
    
    .map-simulation {
        position: relative;
        width: 100%;
        height: 500px;
        background: #e9f5e9;
        border-radius: 0 10px 10px 0;
        overflow: hidden;
    }
    
    .map-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.7;
    }
    
    .map-point {
        position: absolute;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 3px solid white;
        cursor: pointer;
        transform: translate(-50%, -50%);
        transition: transform 0.3s;
    }
    
    .map-point:hover {
        transform: translate(-50%, -50%) scale(1.3);
        z-index: 100;
    }
    
    .point-tooltip {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        padding: 12px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        min-width: 200px;
        display: none;
        z-index: 1000;
    }
    
    .map-point:hover .point-tooltip {
        display: block;
    }
    
    .point-free { background: #27AE60; }
    .point-moderate { background: #F39C12; }
    .point-busy { background: #E74C3C; }
    .point-crowded { background: #8B0000; }
    
    .daily-predictions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
    }
    
    .day-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        transition: transform 0.3s;
    }
    
    .day-card:hover {
        transform: translateY(-5px);
    }
    
    .day-card.today {
        border: 2px solid #2A9D8F;
        background: #f0f9f7;
    }
    
    .day-header {
        margin-bottom: 15px;
    }
    
    .day-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2C3E50;
    }
    
    .day-date {
        font-size: 0.9rem;
        color: #7F8C8D;
        margin-top: 5px;
    }
    
    .day-badge {
        background: #2A9D8F;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.7rem;
        margin-top: 5px;
        display: inline-block;
    }
    
    .day-prediction {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin: 20px 0;
    }
    
    .prediction-bar {
        width: 20px;
        height: 100px;
        background: #eee;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }
    
    .prediction-fill {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        border-radius: 10px;
        transition: height 0.5s ease;
    }
    
    .fill-low { background: #27AE60; }
    .fill-medium { background: #F39C12; }
    .fill-high { background: #E74C3C; }
    .fill-very-high { background: #8B0000; }
    
    .prediction-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #2C3E50;
    }
    
    .recommendations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .recommendation-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s;
    }
    
    .recommendation-card:hover {
        transform: translateY(-5px);
    }
    
    .rec-badge {
        background: #2A9D8F;
        color: white;
        padding: 8px 15px;
        font-size: 0.8rem;
        display: inline-block;
        border-radius: 0 0 8px 0;
    }
    
    .rec-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    
    .rec-content {
        padding: 20px;
    }
    
    .rec-title {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #2C3E50;
    }
    
    .rec-description {
        color: #666;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }
    
    .rec-metrics {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    
    .rec-metric {
        text-align: center;
    }
    
    .rec-metric i {
        color: #2A9D8F;
        font-size: 1.2rem;
        display: block;
        margin-bottom: 5px;
    }
    
    .metric-value {
        display: block;
        font-weight: bold;
        font-size: 1.1rem;
    }
    
    .metric-label {
        font-size: 0.8rem;
        color: #666;
    }
    
    .rec-comparison {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .comparison-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    
    .comparison-item:last-child {
        border-bottom: none;
    }
    
    .comp-crowd {
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 0.9rem;
    }
    
    .comp-crowd.low { background: #d5f4e6; color: #27AE60; }
    .comp-crowd.crowded { background: #fadbd8; color: #E74C3C; }
    
    .time-slots {
        margin: 20px 0;
    }
    
    .time-slot {
        display: flex;
        justify-content: space-between;
        padding: 12px;
        margin-bottom: 8px;
        border-radius: 6px;
        align-items: center;
    }
    
    .time-slot.good {
        background: #d5f4e6;
        border-left: 4px solid #27AE60;
    }
    
    .time-slot.moderate {
        background: #fef9e7;
        border-left: 4px solid #F39C12;
    }
    
    .time-slot.avoid {
        background: #fadbd8;
        border-left: 4px solid #E74C3C;
    }
    
    .slot-reason {
        font-size: 0.85rem;
        color: #666;
    }
    
    .personalized-widget {
        background: linear-gradient(135deg, #264653 0%, #2A9D8F 100%);
        border-radius: 15px;
        padding: 40px;
        color: white;
        margin-top: 40px;
    }
    
    .widget-form {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 30px;
        margin-top: 20px;
    }
    
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .form-group {
        flex: 1;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 10px;
        color: rgba(255, 255, 255, 0.9);
    }
    
    .form-select, .form-input {
        width: 100%;
        padding: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 1rem;
    }
    
    .form-select option {
        color: #333;
    }
    
    .interest-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .tag-option {
        cursor: pointer;
    }
    
    .tag-option input {
        display: none;
    }
    
    .tag-label {
        display: block;
        padding: 8px 16px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        transition: all 0.3s;
    }
    
    .tag-option input:checked + .tag-label {
        background: white;
        color: #2A9D8F;
    }
    
    .crowd-preference {
        padding: 20px 0;
    }
    
    .preference-slider {
        position: relative;
    }
    
    .slider {
        width: 100%;
        height: 6px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
        outline: none;
        -webkit-appearance: none;
    }
    
    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 24px;
        height: 24px;
        background: white;
        border-radius: 50%;
        cursor: pointer;
    }
    
    .slider-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.8);
    }
    
    @media (max-width: 768px) {
        .search-row {
            flex-direction: column;
        }
        
        .crowd-map-container {
            grid-template-columns: 1fr;
        }
        
        .daily-predictions {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .form-row {
            flex-direction: column;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tabs de búsqueda
    document.querySelectorAll('.search-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            document.querySelectorAll('.search-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            document.querySelectorAll('.search-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(`${tabId}-search`).classList.add('active');
        });
    });
    
    // Gráfico de horas pico
    const peakCtx = document.getElementById('peakHoursChart');
    if (peakCtx) {
        new Chart(peakCtx, {
            type: 'bar',
            data: {
                labels: ['6-8', '8-10', '10-12', '12-14', '14-16', '16-18'],
                datasets: [{
                    label: 'Congestión %',
                    data: [40, 85, 90, 80, 65, 45],
                    backgroundColor: ['#27AE60', '#E74C3C', '#E74C3C', '#F39C12', '#27AE60', '#27AE60'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, max: 100, title: { display: true, text: '% Congestión' } },
                    x: { title: { display: true, text: 'Horas' } }
                }
            }
        });
    }
    
    // Navegación semanal
    let currentWeek = 0;
    const weekRange = document.getElementById('current-week-range');
    
    if(document.getElementById('prev-week')) {
        document.getElementById('prev-week').addEventListener('click', function() {
            currentWeek--;
            updateWeekDisplay();
        });
    }

    if(document.getElementById('next-week')) {
        document.getElementById('next-week').addEventListener('click', function() {
            currentWeek++;
            updateWeekDisplay();
        });
    }
    
    function updateWeekDisplay() {
        const startDate = new Date();
        startDate.setDate(startDate.getDate() + (currentWeek * 7) - (startDate.getDay() + 6) % 7);
        const endDate = new Date(startDate);
        endDate.setDate(startDate.getDate() + 6);
        
        const options = { day: 'numeric', month: 'short' };
        const startStr = startDate.toLocaleDateString('es-ES', options);
        const endStr = endDate.toLocaleDateString('es-ES', options);
        
        if (weekRange) {
            weekRange.textContent = `${startStr} - ${endStr}`;
        }
    }
    
    // Modal
    const modal = document.getElementById('destination-modal');
    const modalContent = document.getElementById('destination-detail-content');
    const closeModalBtn = document.querySelector('.close-modal');

    function showModal(title, content) {
        if (modal && modalContent) {
            modalContent.innerHTML = `<h2>${title}</h2>${content}`;
            modal.style.display = 'block';
        }
    }

    function loadDayDetails(date) {
        const content = `<p>Mostrando detalles para la fecha: <strong>${date}</strong>. Aquí se podría cargar información detallada sobre los destinos y actividades recomendados para este día, incluyendo horarios con menor congestión, eventos especiales, etc.</p>`;
        showModal(`Detalles para ${date}`, content);
    }
    
    if(closeModalBtn) {
        closeModalBtn.addEventListener('click', () => modal.style.display = 'none');
    }

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Botones de detalles del día
    document.querySelectorAll('.btn-day-details').forEach(btn => {
        btn.addEventListener('click', function() {
            const date = this.dataset.date;
            loadDayDetails(date);
        });
    });
    
    // Filtros de recomendaciones
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterRecommendations(filter);
        });
    });
    
    function filterRecommendations(filter) {
        const allCards = document.querySelectorAll('.recommendation-card');
        if (filter === 'all') {
            allCards.forEach(card => card.style.display = 'flex');
        } else {
            allCards.forEach(card => {
                card.style.display = card.classList.contains(`category-${filter}`) ? 'flex' : 'none';
            });
        }
    }
    
    // Generar plan personalizado
    const generatePlanBtn = document.getElementById('generate-plan');
    if(generatePlanBtn) {
        generatePlanBtn.addEventListener('click', function() {
            // ... (código existente para el plan)
            alert('Funcionalidad de "Generar Plan" en desarrollo.');
        });
    }

    // --- Implementación de botones sin funcionalidad ---

    // 1. Búsqueda de Destinos
    const searchDestBtn = document.getElementById('search-destinations');
    if (searchDestBtn) {
        searchDestBtn.addEventListener('click', function() {
            const type = document.getElementById('destination-type').value;
            const crowd = document.getElementById('crowd-level').value;
            // Redirección a la página de destinos con parámetros
            window.location.href = `/mi%20proyecto/destinos?tipo=${type}&congestion=${crowd}`;
        });
    }

    // 2. Búsqueda de Actividades
    const searchActBtn = document.getElementById('search-activities');
    if (searchActBtn) {
        searchActBtn.addEventListener('click', function() {
            const type = document.getElementById('activity-type').value;
            const difficulty = document.getElementById('difficulty').value;
            // Redirección a la página de actividades con parámetros
            window.location.href = `/mi%20proyecto/actividades?tipo=${type}&dificultad=${difficulty}`;
        });
    }

    // 3. Búsqueda por Fecha
    const searchDateBtn = document.getElementById('search-by-date');
    if (searchDateBtn) {
        searchDateBtn.addEventListener('click', function() {
            const date = document.getElementById('visit-date').value;
            const time = document.getElementById('preferred-time').value;
            // Podríamos mostrar resultados en un modal o filtrar la vista actual
            loadDayDetails(date);
        });
    }

    // 4. Controles del Mapa
    const refreshMapBtn = document.getElementById('refresh-map');
    if (refreshMapBtn) {
        refreshMapBtn.addEventListener('click', () => alert('Mapa actualizado (simulación).'));
    }

    // 5. Botones de tarjetas de recomendación
    document.querySelectorAll('.rec-actions button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Evita que los enlaces '#' naveguen
            const action = this.textContent.trim();
            const cardTitle = this.closest('.rec-content').querySelector('.rec-title').textContent;
            
            if (action.includes('Ver detalles') || action.includes('Comparar')) {
                const content = `<p>Mostrando detalles para <strong>${cardTitle}</strong>. Aquí iría la información completa del destino o la comparación.</p>`;
                showModal(`Detalles de ${cardTitle}`, content);
            } else {
                alert(`Acción "${action}" para "${cardTitle}" está en desarrollo.`);
            }
        });
    });

    // 6. Tooltips del mapa
    document.querySelectorAll('.map-point').forEach(point => {
        point.addEventListener('click', function() {
            const destino = this.dataset.destino;
            const congestion = this.dataset.congestion;
            const recommendation = this.dataset.recommendation;
            
            const content = `
                <div class="destination-stats">
                    <div class="stat-card">
                        <i class="fas fa-users"></i><h3>Congestión</h3><div class="stat-value">${congestion}</div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-clock"></i><h3>Mejor Hora</h3><div class="stat-value">${this.dataset.mejor_hora}</div>
                    </div>
                </div>
                <div class="destination-recommendation">
                    <h3><i class="fas fa-lightbulb"></i> Recomendación</h3><p>${recommendation}</p>
                </div>
            `;
            showModal(destino, content);
        });
    });
});
</script>

<?php require_once 'partials/footer.php'; ?>