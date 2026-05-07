    document.addEventListener('DOMContentLoaded', function() {
        // --- 2. SINCRONIZAR CLASES ---
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

        // --- 3. LÓGICA DE ELIMINACIÓN (SweetAlert2) ---
        document.querySelectorAll('.form-eliminar').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "El alimento se eliminará de la lista.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#56ab2f',
                    cancelButtonColor: '#ff5f5f',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    background: 'rgba(255, 255, 255, 0.95)'
                }).then((result) => {
                    if (result.isConfirmed) this.submit();
                });
            });
        });
    });

    // --- 4. FUNCIÓN TOGGLE (ABRIR / CERRAR) ---
    function toggleSeccion(tipo) {
        const body = document.getElementById('seccion-' + tipo);
        let seccionesAbiertas = JSON.parse(localStorage.getItem('secciones_activas')) || [];

        // Por seguridad, si existía un estilo temporal de la precarga, lo borramos al hacer click
        const tempStyle = document.getElementById('temp-style-' + tipo);
        if (tempStyle) tempStyle.remove();

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

        // Guardar estado actualizado
        localStorage.setItem('secciones_activas', JSON.stringify(seccionesAbiertas));
    }