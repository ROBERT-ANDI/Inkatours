<?php require_once 'partials/header.php'; ?>

<?php $reserva = $data['reserva']; ?>

<section class="page-hero">
    <div class="container">
        <h1>¡Reserva Exitosa!</h1>
        <p>Gracias por confiar en InkaTours para tu próxima aventura.</p>
    </div>
</section>

<section class="confirmation-container">
    <div class="container">
        <div class="confirmation-box">
            <div class="confirmation-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>¡Gracias, <?php echo htmlspecialchars(explode(' ', $reserva['usuario_nombre'])[0]); ?>! Tu reserva está confirmada.</h2>
            <p>Hemos enviado un email de confirmación a <strong><?php echo htmlspecialchars($reserva['usuario_email']); ?></strong> con todos los detalles de tu viaje.</p>
            
            <div class="reserva-summary">
                <h3>Resumen de tu Reserva</h3>
                <p><strong>Número de Reserva:</strong> <?php echo htmlspecialchars($reserva['numero_reserva']); ?></p>
                <p><strong>Destino:</strong> <?php echo htmlspecialchars($reserva['destino_nombre']); ?></p>
                <p><strong>Fecha de la Experiencia:</strong> <?php echo date('d/m/Y', strtotime($reserva['fecha_experiencia'])); ?></p>
                <p><strong>Participantes:</strong> <?php echo htmlspecialchars($reserva['participantes']); ?></p>
                <p><strong>Total Pagado:</strong> $<?php echo number_format($reserva['total'], 2); ?> <?php echo htmlspecialchars($reserva['moneda']); ?></p>
            </div>

            <div class="confirmation-actions">
                <a href="/mi%20proyecto/reservas/comprobante/<?php echo htmlspecialchars($reserva['numero_reserva']); ?>" class="btn-primary" target="_blank"><i class="fas fa-file-pdf"></i> Descargar Comprobante en PDF</a>
                <a href="/mi%20proyecto/perfil" class="btn-secondary">Ir a Mi Perfil</a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'partials/footer.php'; ?>
