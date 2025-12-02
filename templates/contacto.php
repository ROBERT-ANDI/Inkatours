<?php
$title = "Contacto - InkaTours";
$active_page = 'contacto';
include 'header.php';
?>

    <section class="page-hero">
        <div class="container">
            <h1>Contáctanos</h1>
            <p>Estamos aquí para ayudarte a planificar tu viaje sostenible perfecto</p>
        </div>
    </section>

    <section class="contacto-contenido">
        <div class="container">
            <div class="contacto-grid">
                <div class="contacto-info">
                    <h2>Información de Contacto</h2>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Dirección</h3>
                            <p>Plaza de Armas, Cusco, Perú</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Teléfono</h3>
                            <p>+51 984 123 456</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email</h3>
                            <p>info@inkatours.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h3>Horario de Atención</h3>
                            <p>Lunes a Viernes: 8:00 - 18:00<br>Sábados: 9:00 - 14:00</p>
                        </div>
                    </div>
                    
                    <div class="mapa-contacto">
                        <h3>Ubícanos</h3>
                        <div class="mapa-miniatura">
                            <!-- Mapa estático como placeholder -->
                            <div style="background: #e9ecef; height: 200px; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; color: var(--gray);">
                                <i class="fas fa-map" style="font-size: 2rem; margin-right: 1rem;"></i>
                                <span>Mapa interactivo de Cusco</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contacto-formulario">
                    <h2>Envíanos un Mensaje</h2>
                    <form id="form-contacto">
                        <div class="form-group">
                            <label for="nombre-contacto">Nombre completo *</label>
                            <input type="text" id="nombre-contacto" required>
                        </div>
                        <div class="form-group">
                            <label for="email-contacto">Email *</label>
                            <input type="email" id="email-contacto" required>
                        </div>
                        <div class="form-group">
                            <label for="asunto-contacto">Asunto *</label>
                            <select id="asunto-contacto" required>
                                <option value="">Selecciona un asunto</option>
                                <option value="reserva">Consulta sobre reservas</option>
                                <option value="info">Información general</option>
                                <option value="sostenibilidad">Consultas sobre sostenibilidad</option>
                                <option value="grupos">Viajes en grupo</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mensaje-contacto">Mensaje *</label>
                            <textarea id="mensaje-contacto" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Enviar Mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>