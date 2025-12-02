document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reserva-form');
    if (!form) return;

    const pasos = document.querySelectorAll('.paso');
    const contenidosPasos = document.querySelectorAll('.paso-contenido');
    const botonesSiguiente = document.querySelectorAll('.btn-continuar');
    const botonesAtras = document.querySelectorAll('.btn-atras');

    let pasoActual = 1;

    const navegarA = (numeroPaso) => {
        // Ocultar contenido actual y desactivar paso
        contenidosPasos.forEach(c => c.classList.remove('activo'));
        pasos.forEach(p => p.classList.remove('activo'));

        // Mostrar nuevo contenido y activar paso
        document.getElementById(`contenido-paso-${numeroPaso}`).classList.add('activo');
        document.getElementById(`paso-${numeroPaso}`).classList.add('activo');
        
        pasoActual = numeroPaso;
        window.scrollTo(0, 0); // Scroll to top
    };

    const validarPaso = (numeroPaso) => {
        const contenido = document.getElementById(`contenido-paso-${numeroPaso}`);
        const inputs = contenido.querySelectorAll('input[required], select[required]');
        let esValido = true;
        inputs.forEach(input => {
            if (!input.value || (input.type === 'number' && input.value < 1)) {
                esValido = false;
                // Simple visual feedback, can be improved
                input.style.borderColor = 'red'; 
            } else {
                input.style.borderColor = '';
            }
        });
        return esValido;
    };

    const actualizarResumen = () => {
        document.getElementById('resumen-fecha').textContent = document.getElementById('fecha_experiencia').value;
        document.getElementById('resumen-participantes').textContent = document.getElementById('participantes').value;
        document.getElementById('resumen-nombre').textContent = document.getElementById('nombre_completo').value;
        document.getElementById('resumen-email').textContent = document.getElementById('email').value;
        document.getElementById('resumen-total').textContent = document.getElementById('total-estimado').textContent;
    };

    botonesSiguiente.forEach(boton => {
        boton.addEventListener('click', () => {
            if (validarPaso(pasoActual)) {
                const siguientePaso = parseInt(boton.dataset.siguientePaso);
                if (siguientePaso === 4) {
                    actualizarResumen();
                }
                navegarA(siguientePaso);
            }
        });
    });

    botonesAtras.forEach(boton => {
        boton.addEventListener('click', () => {
            const pasoAnterior = parseInt(boton.dataset.pasoAnterior);
            navegarA(pasoAnterior);
        });
    });

    // Live calculation for total price
    const precioUnitarioInput = document.getElementById('precio_unitario');
    const participantesInput = document.getElementById('participantes');
    const totalEstimadoSpan = document.getElementById('total-estimado');
    const precioDisplaySpan = document.getElementById('precio-display');

    const actualizarTotal = () => {
        const precioUnitario = parseFloat(precioUnitarioInput.value);
        const numParticipantes = parseInt(participantesInput.value);
        if (!isNaN(precioUnitario) && !isNaN(numParticipantes) && numParticipantes > 0) {
            const total = precioUnitario * numParticipantes;
            totalEstimadoSpan.textContent = `$${total.toFixed(0)}`;
        } else {
            totalEstimadoSpan.textContent = `$${precioUnitario.toFixed(0)}`;
        }
    };

    if (participantesInput && precioUnitarioInput) {
        participantesInput.addEventListener('input', actualizarTotal);
    }
});
