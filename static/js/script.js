// ===== MÓDULO PRINCIPAL DE LA APLICACIÓN =====
const InkaToursApp = (() => {
    let state = {
        user: null,
        cart: JSON.parse(localStorage.getItem('inkatours_cart')) || [],
        language: 'es'
    };

    const init = () => {
        // Inicializar sistemas
        initMultiIdioma();
        initEventListeners();
        initMapa();
        initGraficos();
        initFiltros();
        
        console.log('InkaTours App inicializada correctamente');
    };

    const initMultiIdioma = () => {
        // Inicializar sistema de idiomas si existe
        if (typeof MultiIdioma !== 'undefined') {
            MultiIdioma.init();
        }
    };

    const initEventListeners = () => {
        // Navegación móvil
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('nav-menu');
        
        if (hamburger && navMenu) {
            hamburger.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                hamburger.classList.toggle('active');
            });
        }

        // Modal de autenticación
        const loginBtn = document.getElementById('login-btn');
        const authModal = document.getElementById('auth-modal');
        const closeModal = document.querySelector('.close-modal');
        
        if (loginBtn && authModal) {
            loginBtn.addEventListener('click', () => {
                authModal.style.display = 'block';
            });
        }
        
        if (closeModal) {
            closeModal.addEventListener('click', () => {
                if (authModal) authModal.style.display = 'none';
            });
        }

        // Cerrar modal al hacer clic fuera
        window.addEventListener('click', (e) => {
            const authModal = document.getElementById('auth-modal');
            if (e.target === authModal) {
                authModal.style.display = 'none';
            }
        });

        // Formularios de login/registro
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        
        if (loginForm) {
            loginForm.addEventListener('submit', handleLogin);
        }
        
        if (registerForm) {
            registerForm.addEventListener('submit', handleRegister);
        }

        // Botones de detalles de destinos
        const detailButtons = document.querySelectorAll('.btn-secondary');
        detailButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const card = e.target.closest('.destination-card');
                if (card) {
                    const title = card.querySelector('h3').textContent;
                    mostrarNotificacion(`Ver detalles de: ${title}`, 'info');
                }
            });
        });

        // Botón de búsqueda en hero
        const searchBtn = document.querySelector('.hero-search button');
        if (searchBtn) {
            searchBtn.addEventListener('click', handleBusqueda);
        }

        // Tabs de actividades
        const tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const category = e.target.getAttribute('data-tab');
                filtrarActividades(category);
            });
        });

        // Selector de idioma
        const languageSelect = document.getElementById('language-select');
        if (languageSelect) {
            languageSelect.addEventListener('change', (e) => {
                if (typeof MultiIdioma !== 'undefined') {
                    MultiIdioma.cambiarIdioma(e.target.value);
                }
            });
        }

        // User dropdown toggle
        const userInfo = document.querySelector('.user-info');
        const userDropdown = document.querySelector('.user-dropdown');

        if (userInfo && userDropdown) {
            userInfo.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent click from immediately closing the dropdown
                userDropdown.classList.toggle('show');
            });

            // Close dropdown if clicked outside
            window.addEventListener('click', (e) => {
                if (!userInfo.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('show');
                }
            });
        }
    };

    const initMapa = () => {
        const mapElement = document.getElementById('map');
        if (!mapElement) return;

        try {
            // Coordenadas de Cusco
            const cusco = [-13.53195, -71.96746];
            
            // Crear mapa
            const map = L.map('map').setView(cusco, 10);
            
            // Añadir capa de mapa
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Añadir marcadores para destinos populares
            const destinations = [
                { name: "Machu Picchu", coords: [-13.1631, -72.5450], price: 150 },
                { name: "Valle Sagrado", coords: [-13.3333, -72.0833], price: 120 },
                { name: "Montaña de 7 Colores", coords: [-13.6114, -71.7036], price: 100 },
                { name: "Ciudad del Cusco", coords: [-13.53195, -71.96746], price: 80 },
                { name: "Moray", coords: [-13.3297, -72.1972], price: 90 },
                { name: "Salineras de Maras", coords: [-13.3039, -72.1567], price: 85 }
            ];
            
            destinations.forEach(dest => {
                L.marker(dest.coords)
                    .addTo(map)
                    .bindPopup(`
                        <b>${dest.name}</b><br>
                        <p>Precio: S/ ${dest.price}</p>
                        <button class="btn-secondary" onclick="InkaToursApp.agregarAlCarritoDesdeMapa('${dest.name}', ${dest.price}, 'destino')">
                            Agregar al Carrito
                        </button>
                        <button class="btn-secondary" onclick="InkaToursApp.verDetallesDestino('${dest.name}')">
                            Ver detalles
                        </button>
                    `);
            });
            
            // Botón para localizar al usuario
            const locateBtn = document.getElementById('locate-me');
            if (locateBtn) {
                locateBtn.addEventListener('click', function() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            const userLocation = [position.coords.latitude, position.coords.longitude];
                            map.setView(userLocation, 13);
                            L.marker(userLocation)
                                .addTo(map)
                                .bindPopup('Tu ubicación actual')
                                .openPopup();
                        }, function(error) {
                            mostrarNotificacion('No se pudo obtener tu ubicación', 'error');
                        });
                    } else {
                        mostrarNotificacion('Tu navegador no soporta geolocalización', 'error');
                    }
                });
            }
        } catch (error) {
            console.error('Error al inicializar el mapa:', error);
        }
    };

    const initGraficos = () => {
        const chartElement = document.getElementById('crowdChart');
        if (!chartElement) return;

        try {
            const ctx = chartElement.getContext('2d');
            
            // Datos de ejemplo para la predicción de afluencia
            const crowdChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                    datasets: [
                        {
                            label: 'Machu Picchu',
                            data: [85, 78, 92, 88, 95, 98, 90],
                            borderColor: '#f44336',
                            backgroundColor: 'rgba(244, 67, 54, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Valle Sagrado',
                            data: [65, 70, 68, 72, 75, 80, 78],
                            borderColor: '#ff9800',
                            backgroundColor: 'rgba(255, 152, 0, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Montaña 7 Colores',
                            data: [45, 50, 55, 60, 65, 75, 70],
                            borderColor: '#4caf50',
                            backgroundColor: 'rgba(76, 175, 80, 0.1)',
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Afluencia (%)'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Predicción de Afluencia - Próxima Semana'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error al inicializar gráficos:', error);
        }
    };

    const initFiltros = () => {
        // Filtros de actividades
        const filterOptions = document.querySelectorAll('.filter-options input');
        filterOptions.forEach(option => {
            option.addEventListener('change', filtrarMapa);
        });
    };

    const handleLogin = (e) => {
        e.preventDefault();
        const email = document.getElementById('login-email')?.value;
        const password = document.getElementById('login-password')?.value;
        
        if (email && password) {
            // Simular autenticación exitosa
            mostrarNotificacion('¡Inicio de sesión exitoso!', 'success');
            document.getElementById('auth-modal').style.display = 'none';
        } else {
            mostrarNotificacion('Por favor, completa todos los campos', 'error');
        }
    };

    const handleRegister = (e) => {
        e.preventDefault();
        const name = document.getElementById('register-name')?.value;
        const email = document.getElementById('register-email')?.value;
        const password = document.getElementById('register-password')?.value;
        const confirmPassword = document.getElementById('confirm-password')?.value;
        
        if (!name || !email || !password || !confirmPassword) {
            mostrarNotificacion('Por favor completa todos los campos', 'error');
            return;
        }
        
        if (password !== confirmPassword) {
            mostrarNotificacion('Las contraseñas no coinciden', 'error');
            return;
        }
        
        if (password.length < 6) {
            mostrarNotificacion('La contraseña debe tener al menos 6 caracteres', 'error');
            return;
        }
        
        mostrarNotificacion('¡Registro exitoso! Por favor inicia sesión.', 'success');
        
        // Cambiar a pestaña de login
        const loginTab = document.querySelector('.modal-tab[data-tab="login"]');
        if (loginTab) loginTab.click();
    };

    const handleBusqueda = () => {
        const searchTerm = document.querySelector('.hero-search input')?.value;
        if (searchTerm && searchTerm.trim()) {
            mostrarNotificacion(`Buscando: ${searchTerm}`, 'info');
        }
    };

    const filtrarActividades = (category) => {
        const activityCards = document.querySelectorAll('.activity-card');
        const tabButtons = document.querySelectorAll('.tab-button');
        
        // Actualizar botones activos
        tabButtons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        // Filtrar actividades
        activityCards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    };

    const filtrarMapa = () => {
        mostrarNotificacion('Filtros aplicados al mapa', 'info');
    };

    const mostrarNotificacion = (mensaje, tipo = 'info') => {
        // Crear elemento de notificación
        const notificacion = document.createElement('div');
        notificacion.className = `notification ${tipo}`;
        notificacion.innerHTML = `
            <span>${mensaje}</span>
            <button onclick="this.parentElement.remove()">&times;</button>
        `;
        
        document.body.appendChild(notificacion);
        
        // Remover después de 4 segundos
        setTimeout(() => {
            if (notificacion.parentElement) {
                notificacion.style.opacity = '0';
                setTimeout(() => {
                    if (notificacion.parentElement) {
                        notificacion.parentElement.removeChild(notificacion);
                    }
                }, 300);
            }
        }, 4000);
    };

    const agregarAlCarrito = (item) => {
        state.cart.push({
            id: Date.now(),
            ...item,
            fechaAgregado: new Date().toISOString()
        });
        
        localStorage.setItem('inkatours_cart', JSON.stringify(state.cart));
        mostrarNotificacion(`${item.nombre} agregado al carrito`, 'success');
        
        return state.cart.length;
    };

    const eliminarDelCarrito = (index) => {
        const item = state.cart[index];
        state.cart.splice(index, 1);
        localStorage.setItem('inkatours_cart', JSON.stringify(state.cart));
        mostrarNotificacion(`${item.nombre} eliminado del carrito`, 'info');
        
        return state.cart.length;
    };

    const vaciarCarrito = () => {
        state.cart = [];
        localStorage.setItem('inkatours_cart', JSON.stringify(state.cart));
        mostrarNotificacion('Carrito vaciado', 'info');
    };

    const obtenerCarrito = () => {
        return [...state.cart];
    };

    const calcularTotal = () => {
        return state.cart.reduce((total, item) => total + (item.precio || 0), 0);
    };

    // Métodos públicos
    return {
        init,
        agregarAlCarrito,
        eliminarDelCarrito,
        vaciarCarrito,
        obtenerCarrito,
        calcularTotal,
        
        addToCart: (id) => {
            const destinations = [
                { id: 1, name: "Machu Picchu", precio: 150 },
                { id: 2, name: "Valle Sagrado", precio: 120 },
                { id: 3, name: "Montaña de 7 Colores", precio: 100 }
            ];
            const destination = destinations.find(d => d.id === id);
            if (destination) {
                agregarAlCarrito({
                    tipo: 'destino',
                    nombre: destination.name,
                    precio: destination.precio,
                    fecha: new Date().toISOString().split('T')[0]
                });
            }
        },
        
        agregarAlCarritoDesdeMapa: (nombre, precio, tipo) => {
            agregarAlCarrito({
                tipo: tipo,
                nombre: nombre,
                precio: precio,
                fecha: new Date().toISOString().split('T')[0]
            });
        },
        
        verDetallesDestino: (nombreDestino) => {
            mostrarNotificacion(`Viendo detalles de: ${nombreDestino}`, 'info');
        },
        
        // Para compatibilidad con código existente
        mostrarNotificacion
    };
})();

// ===== INICIALIZACIÓN =====
document.addEventListener('DOMContentLoaded', () => {
    InkaToursApp.init();
});

// Hacer disponible globalmente para HTML
window.InkaToursApp = InkaToursApp;
window.MultiIdioma = typeof MultiIdioma !== 'undefined' ? MultiIdioma : null;