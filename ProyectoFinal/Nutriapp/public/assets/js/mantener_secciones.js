// Se ejecuta de forma inmediata antes de que el DOM termine de pintarse (IIFE).
// Su objetivo es evitar el parpadeo visual que ocurre cuando una sección acordeón
// estaba abierta, se recarga la página y tarda en volver a abrirse.
// Para ello inyecta estilos temporales inline que fuerzan la visibilidad de las
// secciones que estaban abiertas según el localStorage, y que se eliminan en
// cuanto el script principal (mensaje_borrado.js) sincroniza las clases reales
(function() {
    try {
        const abiertas = JSON.parse(localStorage.getItem('secciones_activas')) || [];
        abiertas.forEach(tipo => {
            // Crea un <style> temporal que fuerza la visibilidad de la sección
            const style = document.createElement('style');
            style.id = 'temp-style-' + tipo;
            style.innerHTML = `#seccion-${tipo} { display: block !important; opacity: 1 !important; }`;
            document.head.appendChild(style);
        });
    } catch (e) {
        console.error("Error en pre-carga", e);
    }
})();