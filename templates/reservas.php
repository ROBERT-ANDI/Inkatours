<?php
$title = "Proceso de Reserva - InkaTours";
$active_page = 'reservas';
include 'header.php';
?>

    <section class="page-hero">
        <div class="container">
            <h1>Proceso de Reserva</h1>
            <p>Completa tu reserva de forma sencilla y segura</p>
        </div>
    </section>

    <section class="reservation-process">
        <div class="container">
            <div class="pasos-reserva">
                <div class="paso activo" data-paso="1">
                    <span>1</span>
                    <p class="paso-label">Carrito</p>
                </div>
                <div class="paso" data-paso="2">
                    <span>2</span>
                    <p class="paso-label">Datos Personales</p>
                </div>
                <div class="paso" data-paso="3">
                    <span>3</span>
                    <p class="paso-label">Pago</p>
                </div>
                <div class="paso" data-paso="4">
                    <span>4</span>
                    <p class="paso-label">Confirmación</p>
                </div>
            </div>

            <div class="contenido-reserva">
                <!-- Paso 1: Carrito -->
                <div class="paso-contenido activo" id="paso-1">
                    <h2>Tu Carrito de Compras</h2>
                    <div id="carrito-items">
                        <div class="carrito-item">
                            <div class="carrito-info">
                                <h3>Tour Machu Picchu - Día Completo</h3>
                                <div class="carrito-detalles">
                                    <div class="detalle-item">
                                        <strong>Guía:</strong> Guía Especializado
                                    </div>
                                    <div class="detalle-item">
                                        <strong>Fecha:</strong> 15 de Noviembre, 2023
                                    </div>
                                    <div class="detalle-item">
                                        <strong>Participantes:</strong> 2 adultos
                                    </div>
                                </div>
                            </div>
                            <div class="carrito-precio">
                                <div class="precio-total">$150.00</div>
                                <div class="precio-persona">$75.00 por persona</div>
                            </div>
                        </div>
                        
                        <div class="carrito-item">
                            <div class="carrito-info">
                                <h3>Transporte Privado</h3>
                                <p>Recogida en hotel y traslado a estación</p>
                            </div>
                            <div class="carrito-precio">
                                <div class="precio-total">$50.00</div>
                            </div>
                        </div>
                    </div>
                    <div class="reserva-acciones">
                        <div class="carrito-total">
                            <h3>Total: $<span id="total-carrito">200.00</span></h3>
                        </div>
                        <button class="btn-continuar" id="siguiente-paso-1">
                            Continuar <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Paso 2: Datos Personales -->
                <div class="paso-contenido" id="paso-2">
                    <h2>Datos Personales</h2>
                    <form id="form-datos-personales">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="nombre">Nombre completo *</label>
                                <input type="text" id="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono *</label>
                                <input type="tel" id="telefono" required>
                            </div>
                            <div class="form-group">
                                <label for="pais">País *</label>
                                <select id="pais" required>
                                    <option value="">Selecciona tu país</option>
                                    <option value="peru">Perú</option>
                                    <option value="argentina">Argentina</option>
                                    <option value="chile">Chile</option>
                                    <option value="colombia">Colombia</option>
                                    <option value="mexico">México</option>
                                    <option value="espana">España</option>
                                    <option value="eeuu">Estados Unidos</option>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion">
                        </div>
                        <div class="form-group">
                            <label for="comentarios">Comentarios adicionales</label>
                            <textarea id="comentarios" rows="3"></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" id="anterior-paso-2">Atrás</button>
                            <button type="submit" class="btn-continuar">Continuar al Pago</button>
                        </div>
                    </form>
                </div>

                <!-- Paso 3: Pago -->
                <div class="paso-contenido" id="paso-3">
                    <h2>Método de Pago</h2>
                    <div class="metodos-pago">
                        <div class="metodo-pago activo" data-metodo="tarjeta">
                            <i class="fas fa-credit-card"></i>
                            <span>Tarjeta de Crédito/Débito</span>
                        </div>
                        <div class="metodo-pago" data-metodo="paypal">
                            <i class="fab fa-paypal"></i>
                            <span>PayPal</span>
                        </div>
                    </div>
                    
                    <form id="form-pago-tarjeta" class="form-pago">
                        <div class="form-group">
                            <label>Número de tarjeta *</label>
                            <input type="text" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Fecha de expiración *</label>
                                <input type="text" placeholder="MM/AA" required>
                            </div>
                            <div class="form-group">
                                <label>CVV *</label>
                                <input type="text" placeholder="123" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nombre en la tarjeta *</label>
                            <input type="text" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" id="anterior-paso-3">Atrás</button>
                            <button type="submit" class="btn-continuar">Pagar $<span id="total-pago">200.00</span></button>
                        </div>
                    </form>
                </div>

                <!-- Paso 4: Confirmación -->
                <div class="paso-contenido" id="paso-4">
                    <div class="confirmacion-reserva">
                        <div class="confirmacion-icono">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2>¡Reserva Confirmada!</h2>
                        <p>Tu reserva ha sido procesada exitosamente. Recibirás un email de confirmación en los próximos minutos.</p>
                        <div class="numero-reserva">
                            <strong>Número de reserva: </strong>
                            <span>INK-2023-<span id="numero-reserva">0001</span></span>
                        </div>
                        <div class="confirmacion-actions">
                            <button class="btn-continuar" onclick="window.print()">
                                <i class="fas fa-print"></i> Imprimir Comprobante
                            </button>
                            <a href="index.php" class="btn-secondary">Volver al Inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>