document.addEventListener('DOMContentLoaded', function() {

    // --- 1. SINCRONIZAR CLASES (Precarga de acordeones) ---
    // Recupera del localStorage las secciones que estaban abiertas y les añade
    // la clase 'abierto' para restaurar su estado antes de que se pinte la página
    const abiertas = JSON.parse(localStorage.getItem('secciones_activas')) || [];
    abiertas.forEach(tipo => {
        const el = document.getElementById('seccion-' + tipo);
        if (el) {
            el.classList.add('abierto');
            // Elimina el estilo temporal de precarga si existe para evitar conflictos
            const tempStyle = document.getElementById('temp-style-' + tipo);
            if (tempStyle) tempStyle.remove();
        }
    });

    // --- 2. LÓGICA DE ELIMINACIÓN DINÁMICA (SweetAlert2) ---
    // Intercepta el envío de todos los formularios con clase 'form-eliminar'
    // y muestra un diálogo de confirmación personalizado antes de proceder
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Frena el envío automático del formulario

            const boton = this.querySelector('button[type="submit"]');

            // Textos por defecto si no se encuentran atributos específicos en el botón
            let tituloAlerta = "¿Estás seguro de eliminar este registro?";
            let textoAlerta = "El elemento se eliminará de la lista.";

            if (boton) {
                const nombreData = boton.getAttribute('data-nombre');
                const tipoData = boton.getAttribute('data-tipo');

                // Personaliza el mensaje según el tipo de dato que se va a eliminar
                if (tipoData === 'usuario') {
                    tituloAlerta = `¿Estás seguro de eliminar al usuario "${nombreData}"?`;
                    textoAlerta = "El usuario y todos sus datos asociados se eliminarán de forma permanente.";
                } else if (tipoData === 'alimento') {
                    tituloAlerta = `¿Estás seguro de eliminar el alimento "${nombreData}"?`;
                    textoAlerta = "El alimento se eliminará por completo de tu lista.";
                } else if (tipoData === 'dieta') {
                    tituloAlerta = `¿Estás seguro de eliminar la dieta "${nombreData}"?`;
                    textoAlerta = "Se borrarán la configuración de la dieta, todos sus alimentos planificados y sus recetas de manera irreversible.";
                } else if (nombreData) {
                    // Fallback genérico si hay nombre pero no tipo reconocido
                    tituloAlerta = `¿Estás seguro de eliminar "${nombreData}"?`;
                }
            }

            // Muestra el diálogo de confirmación con SweetAlert2
            Swal.fire({
                title: tituloAlerta,
                text: textoAlerta,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#52b788',
                cancelButtonColor: '#ff5f5f',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                background: 'rgba(255, 255, 255, 0.95)'
            }).then((result) => {
                // Solo envía el formulario si el usuario confirma la acción
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
});

// --- 3. FUNCIÓN TOGGLE (Abrir/cerrar secciones de acordeón) ---
// Alterna la visibilidad de una sección por su tipo y persiste el estado en localStorage
// para que se mantenga al recargar la página
function toggleSeccion(tipo) {
    const body = document.getElementById('seccion-' + tipo);
    let seccionesAbiertas = JSON.parse(localStorage.getItem('secciones_activas')) || [];

    // Si el elemento no existe en el DOM, lo elimina del estado guardado y sale
    if (!body) {
        seccionesAbiertas = seccionesAbiertas.filter(item => item !== tipo);
        localStorage.setItem('secciones_activas', JSON.stringify(seccionesAbiertas));
        return;
    }

    // Elimina el estilo temporal de precarga si aún existe
    const tempStyle = document.getElementById('temp-style-' + tipo);
    if (tempStyle) tempStyle.remove();

    // Alterna la clase y actualiza el array de secciones abiertas
    if (body.classList.contains('abierto')) {
        body.classList.remove('abierto');
        seccionesAbiertas = seccionesAbiertas.filter(item => item !== tipo);
    } else {
        body.classList.add('abierto');
        if (!seccionesAbiertas.includes(tipo)) {
            seccionesAbiertas.push(tipo);
        }
    }

    // Persiste el estado actualizado en localStorage
    localStorage.setItem('secciones_activas', JSON.stringify(seccionesAbiertas));
}