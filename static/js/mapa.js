// ===== SISTEMA DE MAPA INTERACTIVO =====

// Variables globales
let mapa;
let marcadores = [];
let userMarker = null;

// Datos de destinos para el mapa
const destinosMapa = [
    {
        id: 1,
        nombre: "Machu Picchu",
        tipo: "cultural",
        coordenadas: [-13.1631, -72.5450],
        descripcion: "Ciudadela Inca Patrimonio de la Humanidad, explorada con prácticas sostenibles.",
        sostenible: true,
        icono: "🏔️",
        precio: 120,
        duracion: "1 día"
    },
    {
        id: 2,
        nombre: "Valle Sagrado",
        tipo: "naturaleza",
        coordenadas: [-13.3333, -72.0833],
        descripcion: "Valle fértil con pueblos tradicionales y mercados artesanales.",
        sostenible: true,
        icono: "🌄",
        precio: 80,
        duracion: "1 día"
    },
    {
        id: 3,
        nombre: "Montaña de 7 Colores",
        tipo: "aventura",
        coordenadas: [-13.6114, -71.7036],
        descripcion: "Montaña con bandas de colores naturales, ideal para el senderismo responsable.",
        sostenible: true,
        icono: "🌈",
        precio: 65,
        duracion: "1 día"
    },
    {
        id: 4,
        nombre: "Ciudad del Cusco",
        tipo: "cultural",
        coordenadas: [-13.53195, -71.96746],
        descripcion: "Capital histórica del Imperio Inca, rica en cultura y tradiciones.",
        sostenible: true,
        icono: "🏛️",
        precio: 45,
        duracion: "Medio día"
    },
    {
        id: 5,
        nombre: "Laguna Humantay",
        tipo: "naturaleza",
        coordenadas: [-13.3994, -72.5992],
        descripcion: "Laguna turquesa en las alturas de los Andes, accesible mediante caminatas ecológicas.",
        sostenible: true,
        icono: "💧",
        precio: 55,
        duracion: "1 día"
    },
    {
        id: 6,
        nombre: "Moray",
        tipo: "cultural",
        coordenadas: [-13.3297, -72.1972],
        descripcion: "Sitio arqueológico único con terrazas circulares incas.",
        sostenible: true,
        icono: "🌱",
        precio: 40,
        duracion: "Medio día"
    },
    {
        id: 7,
        nombre: "Salineras de Maras",
        tipo: "cultural",
        coordenadas: [-13.3039, -72.1567],
        descripcion: "Minas de sal tradicionales que han sido explotadas desde la época inca.",
        sostenible: true,
        icono: "⛰️",
        precio: 35,
        duracion: "Medio día"
    }
];

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    inicializarMapa();
    configurarEventos();
    console.log('Sistema de mapa interactivo inicializado');
});

function inicializarMapa() {
    // Coordenadas de Cusco
    const cuscoCoords = [-13.53195, -71.96746];
    
    try {
        // Inicializar el mapa
        mapa = L.map('mapa-completo').setView(cuscoCoords, 10);
        
        // Añadir capa de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18
        }).addTo(mapa);
        
        // Crear marcadores para cada destino
        crearMarcadores();
        
        // Asegurar que el mapa se redimensiona correctamente
        setTimeout(() => {
            mapa.invalidateSize();
        }, 100);
        
    } catch (error) {
        console.error('Error al inicializar el mapa:', error);
        mostrarErrorMapa();
    }
}

function crearMarcadores() {
    destinosMapa.forEach(destino => {
        // Crear icono personalizado
        const iconoPersonalizado = L.divIcon({
            html: `
                <div style="
                    background: ${obtenerColorPorTipo(destino.tipo)}; 
                    color: white; 
                    padding: 10px; 
                    border-radius: 50%; 
                    font-size: 16px;
                    border: 3px solid white;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 40px;
                    height: 40px;
                ">${destino.icono}</div>
            `,
            className: 'marker-personalizado',
            iconSize: [40, 40],
            iconAnchor: [20, 20]
        });
        
        // Crear marcador
        const marcador = L.marker(destino.coordenadas, { icon: iconoPersonalizado })
            .addTo(mapa)
            .bindPopup(crearPopupContenido(destino));
        
        // Guardar referencia al destino
        marcador.destino = destino;
        marcadores.push(marcador);
    });
    
    // Actualizar contador inicial
    actualizarContadorDestinos();
}

function crearPopupContenido(destino) {
    return `
        <div style="min-width: 250px;">
            <h3 style="margin: 0 0 10px 0; color: var(--primary); font-family: 'Poppins', sans-serif;">
                ${destino.nombre}
            </h3>
            <p style="margin: 0 0 10px 0; color: #666; line-height: 1.4;">
                ${destino.descripcion}
            </p>
            <div style="display: flex; gap: 5px; margin-bottom: 10px; flex-wrap: wrap;">
                <span style="background: #27AE60; color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                    Sostenible
                </span>
                <span style="background: ${obtenerColorPorTipo(destino.tipo)}; color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                    ${obtenerTextoPorTipo(destino.tipo)}
                </span>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 15px; font-size: 12px;">
                <div style="text-align: center;">
                    <strong>Duración</strong><br>
                    ${destino.duracion}
                </div>
                <div style="text-align: center;">
                    <strong>Precio</strong><br>
                    $${destino.precio}
                </div>
            </div>
            <button onclick="reservarDestino(${destino.id})" 
                    style="background: var(--primary); color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; width: 100%; font-weight: 600; transition: all 0.3s;"
                    onmouseover="this.style.background='var(--primary-dark)'; this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.background='var(--primary)'; this.style.transform='translateY(0)'">
                Reservar Tour
            </button>
        </div>
    `;
}

function obtenerColorPorTipo(tipo) {
    const colores = {
        'cultural': '#2A9D8F',
        'naturaleza': '#27AE60',
        'aventura': '#E76F51'
    };
    return colores[tipo] || '#6C757D';
}

function obtenerTextoPorTipo(tipo) {
    const textos = {
        'cultural': 'Cultural',
        'naturaleza': 'Naturaleza',
        'aventura': 'Aventura'
    };
    return textos[tipo] || tipo;
}

function configurarEventos() {
    // Botón de geolocalización
    const btnUbicacion = document.getElementById('ubicacion-actual');
    if (btnUbicacion) {
        btnUbicacion.addEventListener('click', obtenerUbicacionUsuario);
    }
    
    // Filtros del mapa
    const checkboxes = document.querySelectorAll('.filter-options input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filtrarMarcadores);
    });
}

function obtenerUbicacionUsuario() {
    if (!navigator.geolocation) {
        mostrarNotificacion('Tu navegador no soporta geolocalización', 'error');
        return;
    }
    
    const btnUbicacion = document.getElementById('ubicacion-actual');
    const textoOriginal = btnUbicacion.innerHTML;
    
    // Mostrar estado de carga
    btnUbicacion.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Buscando...';
    btnUbicacion.disabled = true;
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            
            // Remover marcador anterior si existe
            if (userMarker) {
                mapa.removeLayer(userMarker);
            }
            
            // Crear marcador de ubicación actual
            userMarker = L.marker([userLat, userLng])
                .addTo(mapa)
                .bindPopup('<strong>¡Estás aquí!</strong><br>Tu ubicación actual')
                .openPopup();
            
            // Crear círculo de precisión
            L.circle([userLat, userLng], {
                color: '#3498db',
                fillColor: '#3498db',
                fillOpacity: 0.1,
                radius: position.coords.accuracy
            }).addTo(mapa);
            
            // Centrar mapa en la ubicación del usuario
            mapa.setView([userLat, userLng], 13);
            
            // Restaurar botón
            btnUbicacion.innerHTML = textoOriginal;
            btnUbicacion.disabled = false;
            
            mostrarNotificacion('Ubicación encontrada correctamente', 'success');
        },
        function(error) {
            // Restaurar botón
            btnUbicacion.innerHTML = textoOriginal;
            btnUbicacion.disabled = false;
            
            let mensajeError = 'No se pudo obtener tu ubicación. ';
            
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    mensajeError += 'Permiso de ubicación denegado.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    mensajeError += 'Información de ubicación no disponible.';
                    break;
                case error.TIMEOUT:
                    mensajeError += 'Tiempo de espera agotado.';
                    break;
                default:
                    mensajeError += 'Error desconocido.';
            }
            
            mostrarNotificacion(mensajeError, 'error');
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000
        }
    );
}

function filtrarMarcadores() {
    const checkboxes = document.querySelectorAll('.filter-options input[type="checkbox"]');
    const categoriasActivas = Array.from(checkboxes)
        .filter(cb => cb.checked)
        .map(cb => cb.getAttribute('data-categoria'));
    
    let contador = 0;
    
    marcadores.forEach(marcador => {
        const destino = marcador.destino;
        let mostrar = false;
        
        // Verificar cada categoría activa
        categoriasActivas.forEach(categoria => {
            if (categoria === 'cultural' && destino.tipo === 'cultural') mostrar = true;
            if (categoria === 'naturaleza' && destino.tipo === 'naturaleza') mostrar = true;
            if (categoria === 'aventura' && destino.tipo === 'aventura') mostrar = true;
            if (categoria === 'sostenible' && destino.sostenible) mostrar = true;
        });
        
        if (mostrar) {
            if (!mapa.hasLayer(marcador)) {
                marcador.addTo(mapa);
            }
            contador++;
        } else {
            if (mapa.hasLayer(marcador)) {
                mapa.removeLayer(marcador);
            }
        }
    });
    
    actualizarContadorDestinos(contador);
}

function actualizarContadorDestinos(contador) {
    const elementoContador = document.getElementById('contador-destinos');
    if (elementoContador) {
        elementoContador.textContent = contador !== undefined ? contador : marcadores.length;
    }
}

function mostrarErrorMapa() {
    const mapaContainer = document.getElementById('mapa-completo');
    if (mapaContainer) {
        mapaContainer.innerHTML = `
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; background: var(--light); color: var(--gray); text-align: center; padding: 2rem;">
                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 1rem; color: var(--secondary);"></i>
                <h3>Error al cargar el mapa</h3>
                <p>No se pudo inicializar el mapa interactivo. Por favor, intenta recargar la página.</p>
                <button onclick="location.reload()" class="btn-primary" style="margin-top: 1rem;">
                    <i class="fas fa-redo"></i> Recargar Página
                </button>
            </div>
        `;
    }
}

// Función global para reservar destinos
window.reservarDestino = function(id) {
    const destino = destinosMapa.find(d => d.id === id);
    if (destino) {
        const mensaje = `¡Perfecto! Has seleccionado:\n\n` +
                       `🏔️ ${destino.nombre}\n` +
                       `💰 Precio: $${destino.precio} por persona\n` +
                       `⏱️ Duración: ${destino.duracion}\n\n` +
                       `Serás redirigido al proceso de reserva.`;
        
        mostrarNotificacion(mensaje, 'success');
        
        // Redirigir a la página de reservas después de un breve delay
        setTimeout(() => {
            window.location.href = 'reservas.html';
        }, 2000);
    }
};

function mostrarNotificacion(mensaje, tipo = 'info') {
    // Usar MultiIdioma si está disponible, sino usar función local
    if (typeof MultiIdioma !== 'undefined' && MultiIdioma.mostrarNotificacion) {
        MultiIdioma.mostrarNotificacion(mensaje, tipo);
    } else if (typeof InkaToursApp !== 'undefined' && InkaToursApp.mostrarNotificacion) {
        InkaToursApp.mostrarNotificacion(mensaje, tipo);
    } else {
        // Implementación local básica
        alert(mensaje);
    }
}

// Hacer funciones disponibles globalmente
window.inicializarMapa = inicializarMapa;
window.filtrarMarcadores = filtrarMarcadores;