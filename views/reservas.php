<?php require_once 'partials/header.php'; ?>

<section class="page-hero">
    <div class="container">
        <h1>Proceso de Reserva</h1>
        <p>Completa tu reserva de forma sencilla y segura en 4 simples pasos.</p>
    </div>
</section>

<section class="reservation-process">
    <div class="container">
        <!-- Indicador de Pasos -->
        <div class="pasos-reserva">
            <div class="paso activo" id="paso-1">
                <span>1</span>
                <div class="paso-label">Detalles</div>
            </div>
            <div class="paso" id="paso-2">
                <span>2</span>
                <div class="paso-label">Tus Datos</div>
            </div>
            <div class="paso" id="paso-3">
                <span>3</span>
                <div class="paso-label">Pago</div>
            </div>
            <div class="paso" id="paso-4">
                <span>4</span>
                <div class="paso-label">Confirmación</div>
            </div>
        </div>

        <?php if (isset($data['item'])): ?>
            <form id="reserva-form" action="/mi%20proyecto/reservas/guardar" method="post">
                <!-- Campos ocultos que se necesitan en el POST final -->
                <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($data['tipo']); ?>">
                <input type="hidden" name="elemento_id" value="<?php echo htmlspecialchars($data['item']->id); ?>">
                <input type="hidden" name="precio_unitario" id="precio_unitario" value="<?php echo htmlspecialchars($data['item']->precio_base ?? $data['item']->precio); ?>">

                <!-- Paso 1: Detalles de la Reserva -->
                <div class="paso-contenido activo" id="contenido-paso-1">
                    <h2><i class="fas fa-calendar-alt"></i> 1. Detalles de la Reserva</h2>
                    <div class="carrito-item">
                        <div class="carrito-info">
                            <h3><?php echo htmlspecialchars($data['item']->nombre); ?></h3>
                            <p><?php echo htmlspecialchars($data['item']->descripcion_corta); ?></p>
                        </div>
                        <div class="carrito-precio">
                            <div class="precio-total" id="precio-display">$<?php echo htmlspecialchars($data['item']->precio_base ?? $data['item']->precio); ?></div>
                            <div class="precio-persona">por persona</div>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="fecha_experiencia">Fecha de la Experiencia *</label>
                            <input type="date" id="fecha_experiencia" name="fecha_experiencia" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="participantes">Número de Participantes *</label>
                            <input type="number" id="participantes" name="participantes" class="form-control" value="1" min="1" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notas">Notas Adicionales (opcional)</label>
                        <textarea name="notas" id="notas" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="reserva-total">
                        Total Estimado: <span id="total-estimado">$<?php echo htmlspecialchars($data['item']->precio_base ?? $data['item']->precio); ?></span>
                    </div>
                    <div class="reserva-acciones">
                        <button type="button" class="btn-continuar" data-siguiente-paso="2">Siguiente <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Paso 2: Tus Datos -->
                <div class="paso-contenido" id="contenido-paso-2">
                    <h2><i class="fas fa-user"></i> 2. Tus Datos Personales</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nombre_completo">Nombre Completo *</label>
                            <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono *</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control" required>
                        </div>
                    </div>
                    <div class="reserva-acciones">
                        <button type="button" class="btn-atras" data-paso-anterior="1"><i class="fas fa-arrow-left"></i> Atrás</button>
                        <button type="button" class="btn-continuar" data-siguiente-paso="3">Siguiente <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Paso 3: Pago -->
                <div class="paso-contenido" id="contenido-paso-3">
                    <h2><i class="fas fa-credit-card"></i> 3. Método de Pago</h2>
                    <div class="metodos-pago">
                        <div class="metodo-pago activo"><i class="fab fa-cc-visa"></i> Tarjeta de Crédito</div>
                    </div>
                    <div class="form-group">
                        <label for="nombre_tarjeta">Nombre en la Tarjeta *</label>
                        <input type="text" id="nombre_tarjeta" name="nombre_tarjeta" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="numero_tarjeta">Número de Tarjeta *</label>
                        <input type="text" id="numero_tarjeta" name="numero_tarjeta" class="form-control" placeholder="XXXX XXXX XXXX XXXX" required>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="fecha_exp">Fecha de Exp. *</label>
                            <input type="text" id="fecha_exp" name="fecha_exp" class="form-control" placeholder="MM/YY" required>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV *</label>
                            <input type="text" id="cvv" name="cvv" class="form-control" placeholder="123" required>
                        </div>
                    </div>
                    <div class="reserva-acciones">
                        <button type="button" class="btn-atras" data-paso-anterior="2"><i class="fas fa-arrow-left"></i> Atrás</button>
                        <button type="button" class="btn-continuar" data-siguiente-paso="4">Siguiente <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Paso 4: Confirmación -->
                <div class="paso-contenido" id="contenido-paso-4">
                    <h2><i class="fas fa-check-circle"></i> 4. Confirmar y Reservar</h2>
                    <div class="resumen-reserva">
                        <h3>Resumen de tu Aventura</h3>
                        <p><strong>Destino:</strong> <?php echo htmlspecialchars($data['item']->nombre); ?></p>
                        <p><strong>Fecha:</strong> <span id="resumen-fecha"></span></p>
                        <p><strong>Participantes:</strong> <span id="resumen-participantes"></span></p>
                        <p><strong>Titular:</strong> <span id="resumen-nombre"></span></p>
                        <p><strong>Email:</strong> <span id="resumen-email"></span></p>
                        <div class="resumen-total">
                            Total a Pagar: <span id="resumen-total"></span>
                        </div>
                    </div>
                    <div class="reserva-acciones">
                        <button type="button" class="btn-atras" data-paso-anterior="3"><i class="fas fa-arrow-left"></i> Atrás</button>
                        <button type="submit" class="btn-continuar">Confirmar y Pagar</button>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="no-results" style="text-align: center; padding: 40px 0;">
                <i class="fas fa-map-signs" style="font-size: 4rem; color: #6c757d; margin-bottom: 20px;"></i>
                <h3 style="margin-bottom: 15px; color: #333;">No has seleccionado un item para reservar</h3>
                <p style="margin-bottom: 30px; color: #666; font-size: 1.1rem;">Por favor, regresa a nuestros destinos o actividades y selecciona una opción.</p>
                <div style="margin-top: 40px;">
                    <a href="/mi%20proyecto/destinos" class="btn btn-primary">Ver Destinos</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script src="/mi%20proyecto/static/js/reservas.js"></script>
<?php require_once 'partials/footer.php'; ?>