(function() {
            try {
                const abiertas = JSON.parse(localStorage.getItem('secciones_activas')) || [];
                abiertas.forEach(tipo => {
                    const style = document.createElement('style');
                    style.id = 'temp-style-' + tipo;
                    style.innerHTML = `#seccion-${tipo} { display: block !important; opacity: 1 !important; }`;
                    document.head.appendChild(style);
                });
            } catch (e) { console.error("Error en pre-carga", e); }
        })();