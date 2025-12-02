<?php
$title = "Mapa Interactivo - InkaTours";
$active_page = 'mapa';
include 'header.php';
?>

    <section class="fullscreen-map">
        <div id="mapa-completo"></div>
        <div class="map-controls-panel">
            <h3>Filtros del Mapa</h3>
            <div class="filter-options">
                <label><input type="checkbox" checked data-categoria="cultural"> Cultural</label>
                <label><input type="checkbox" checked data-categoria="naturaleza"> Naturaleza</label>
                <label><input type="checkbox" checked data-categoria="aventura"> Aventura</label>
                <label><input type="checkbox" checked data-categoria="sostenible"> Sostenible</label>
            </div>
            <button class="btn-primary" id="ubicacion-actual">
                <i class="fas fa-location-arrow"></i> Mi ubicación
            </button>
            <div class="map-stats">
                <p><strong>Destinos mostrados: </strong><span id="contador-destinos">5</span></p>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>