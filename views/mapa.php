<?php require_once 'partials/header.php'; ?>

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
                <p><strong>Destinos mostrados: </strong><span id="contador-destinos">0</span></p>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('mapa-completo').setView([-13.53195, -71.96746], 10); // Centered in Cusco

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var locations = <?php echo $data['locations']; ?>;
            var markers = [];

            if (locations) {
                locations.forEach(function (location) {
                    var marker = L.marker([location.lat, location.lng]).addTo(map);
                    marker.bindPopup(
                        '<div class="map-popup">' +
                        '<h3>' + location.nombre + '</h3>' +
                        '<p>' + location.descripcion_corta + '</p>' +
                        '<a href="/mi%20proyecto/destinos/show/' + location.id + '" class="btn-primary btn-sm">Ver detalles</a>' +
                        '</div>'
                    );
                    markers.push(marker);
                });
                document.getElementById('contador-destinos').textContent = locations.length;
            }

            let userMarker = null;
            let watchId = null;

            const locateBtn = document.getElementById('ubicacion-actual');
            if (locateBtn) {
                locateBtn.addEventListener('click', function() {
                    // If we are already watching, turn it off
                    if (watchId !== null) {
                        navigator.geolocation.clearWatch(watchId);
                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }
                        userMarker = null;
                        watchId = null;
                        locateBtn.innerHTML = '<i class="fas fa-location-arrow"></i> Mi ubicación';
                        return;
                    }

                    // Start watching position
                    if (navigator.geolocation) {
                        watchId = navigator.geolocation.watchPosition(function(position) {
                            const userLocation = [position.coords.latitude, position.coords.longitude];
                            
                            if (userMarker === null) {
                                // Create marker if it doesn't exist
                                userMarker = L.marker(userLocation).addTo(map);
                                userMarker.bindPopup('<b>Tu ubicación</b>').openPopup();
                                map.setView(userLocation, 16); // Zoom in closer on first find
                            } else {
                                // Just update position
                                userMarker.setLatLng(userLocation);
                            }
                            locateBtn.innerHTML = '<i class="fas fa-stop-circle"></i> Detener seguimiento';

                        }, function() {
                            alert('No se pudo obtener tu ubicación. Por favor, asegúrate de haber concedido los permisos.');
                        }, {
                            enableHighAccuracy: true, // Request more accurate position
                            timeout: 5000,
                            maximumAge: 0
                        });
                    } else {
                        alert('Tu navegador no soporta geolocalización.');
                    }
                });
            }
        });
    </script>

<?php require_once 'partials/footer.php'; ?>