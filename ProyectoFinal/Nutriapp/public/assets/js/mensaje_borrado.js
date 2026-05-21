document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // 1. SINCRONIZAR CLASES (Precarga de acordeones)
    // ==========================================
    const abiertas = JSON.parse(localStorage.getItem('secciones_activas')) || [];
    abiertas.forEach(tipo => {
        const el = document.getElementById('seccion-' + tipo);
        if (el) {
            el.classList.add('abierto');
            // Una vez puesta la clase, quitamos el estilo temporal de la cabecera
            const tempStyle = document.getElementById('temp-style-' + tipo);
            if (tempStyle) tempStyle.remove();
        }
    });

    // ==========================================
    // 2. LÓGICA DE ELIMINACIÓN DINÁMICA (SweetAlert2)
    // ==========================================
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Detiene el envío inmediato del formulario
            
            // Buscamos el botón submit dentro de este formulario específico
            const boton = this.querySelector('button[type="submit"]');
            
            // Valores por defecto en caso de que no existan atributos de datos
            let tituloAlerta = "¿Estás seguro de eliminar este registro?";
            let textoAlerta = "El elemento se eliminará de la lista.";

            if (boton) {
                const nombreData = boton.getAttribute('data-nombre');
                const tipoData = boton.getAttribute('data-tipo');
                
                // Adaptamos la gramática del título y el texto según el tipo de elemento
                if (tipoData === 'usuario') {
                    tituloAlerta = `¿Estás seguro de eliminar al usuario "${nombreData}"?`;
                    textoAlerta = "El usuario y todos sus datos asociados se eliminarán de forma permanente.";
                } else if (tipoData === 'alimento') {
                    tituloAlerta = `¿Estás seguro de eliminar el alimento "${nombreData}"?`;
                    textoAlerta = "El alimento se eliminará por completo de tu lista.";
                } else if (nombreData) {
                    tituloAlerta = `¿Estás seguro de eliminar "${nombreData}"?`;
                }
            }
            
            // Lanzamos la alerta personalizada
            Swal.fire({
                title: tituloAlerta,
                text: textoAlerta,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#52b788', // Verde corporativo de la barra de navegación
                cancelButtonColor: '#ff5f5f',  // Rojo para la cancelación
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                background: 'rgba(255, 255, 255, 0.95)'
            }).then((result) => {
                // Si el usuario hace clic en el botón de confirmación, enviamos el formulario
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
});

// ==========================================
// 3. FUNCIÓN TOGGLE (Abrir / Cerrar Secciones)
// ==========================================
function toggleSeccion(tipo) {
    const body = document.getElementById('seccion-' + tipo);
    let seccionesAbiertas = JSON.parse(localStorage.getItem('secciones_activas')) || [];
    
    // Si la sección no existe en el HTML actual, la limpiamos del localStorage por seguridad
    if (!body) {
        seccionesAbiertas = seccionesAbiertas.filter(item => item !== tipo);
        localStorage.setItem('secciones_activas', JSON.stringify(seccionesAbiertas));
        return;
    }
    
    // Si existía un estilo temporal de la precarga para evitar parpadeos, lo eliminamos
    const tempStyle = document.getElementById('temp-style-' + tipo);
    if (tempStyle) tempStyle.remove();

    // Alternamos el estado de la sección
    if (body.classList.contains('abierto')) {
        // CERRAR
        body.classList.remove('abierto');
        seccionesAbiertas = seccionesAbiertas.filter(item => item !== tipo);
    } else {
        // ABRIR
        body.classList.add('abierto');
        if (!seccionesAbiertas.includes(tipo)) {
            seccionesAbiertas.push(tipo);
        }
    }

    // Guardamos el estado actualizado en el almacenamiento local
    localStorage.setItem('secciones_activas', JSON.stringify(seccionesAbiertas));
}