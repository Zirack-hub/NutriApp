document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. SINCRONIZAR CLASES (Precarga de acordeones) ---
    const abiertas = JSON.parse(localStorage.getItem('secciones_activas')) || [];
    abiertas.forEach(tipo => {
        const el = document.getElementById('seccion-' + tipo);
        if (el) {
            el.classList.add('abierto');
            const tempStyle = document.getElementById('temp-style-' + tipo);
            if (tempStyle) tempStyle.remove();
        }
    });

    // --- 2. LÓGICA DE ELIMINACIÓN DINÁMICA (SweetAlert2) ---
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Frena el envío automático
            
            const boton = this.querySelector('button[type="submit"]');
            
            // Valores por defecto globales
            let tituloAlerta = "¿Estás seguro de eliminar este registro?";
            let textoAlerta = "El elemento se eliminará de la lista.";

            if (boton) {
                const nombreData = boton.getAttribute('data-nombre');
                const tipoData = boton.getAttribute('data-tipo');
                
                // Personalización estricta por tipos de datos
                if (tipoData === 'usuario') {
                    tituloAlerta = `¿Estás seguro de eliminar al usuario "${nombreData}"?`;
                    textoAlerta = "El usuario y todos sus datos asociados se eliminarán de forma permanente.";
                } else if (tipoData === 'alimento') {
                    tituloAlerta = `¿Estás seguro de eliminar el alimento "${nombreData}"?`;
                    textoAlerta = "El alimento se eliminará por completo de tu lista.";
                } else if (tipoData === 'dieta') {
                    // ¡NUEVO! Mensaje personalizado para la Dieta Actual
                    tituloAlerta = `¿Estás seguro de eliminar la dieta "${nombreData}"?`;
                    textoAlerta = "Se borrarán la configuración de la dieta, todos sus alimentos planificados y sus recetas de manera irreversible.";
                } else if (nombreData) {
                    tituloAlerta = `¿Estás seguro de eliminar "${nombreData}"?`;
                }
            }
            
            Swal.fire({
                title: tituloAlerta,
                text: textoAlerta,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#52b788', // El verde esmeralda claro
                cancelButtonColor: '#ff5f5f',  // El rojo suave
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                background: 'rgba(255, 255, 255, 0.95)'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Envía el formulario si acepta
                }
            });
        });
    });
});

// --- 3. FUNCIÓN TOGGLE (Mantén tu función original aquí abajo) ---
function toggleSeccion(tipo) {
    const body = document.getElementById('seccion-' + tipo);
    let seccionesAbiertas = JSON.parse(localStorage.getItem('secciones_activas')) || [];
    if (!body) {
        seccionesAbiertas = seccionesAbiertas.filter(item => item !== tipo);
        localStorage.setItem('secciones_activas', JSON.stringify(seccionesAbiertas));
        return;
    }
    const tempStyle = document.getElementById('temp-style-' + tipo);
    if (tempStyle) tempStyle.remove();

    if (body.classList.contains('abierto')) {
        body.classList.remove('abierto');
        seccionesAbiertas = seccionesAbiertas.filter(item => item !== tipo);
    } else {
        body.classList.add('abierto');
        if (!seccionesAbiertas.includes(tipo)) {
            seccionesAbiertas.push(tipo);
        }
    }
    localStorage.setItem('secciones_activas', JSON.stringify(seccionesAbiertas));
}