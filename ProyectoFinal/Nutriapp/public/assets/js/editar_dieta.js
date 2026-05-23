// Abre el modal de edición de la dieta y rellena sus campos
// con el nombre y el objetivo calórico actuales
function abrirModalEditarDieta(nombreActual, objetivoActual) {
    document.getElementById('modal-dieta-nombre').value = nombreActual;
    document.getElementById('modal-dieta-objetivo').value = objetivoActual;

    // Muestra el modal
    document.getElementById('modal-editar-dieta').style.display = 'flex';
}

// Oculta el modal de edición de la dieta
function cerrarModalEditarDieta() {
    document.getElementById('modal-editar-dieta').style.display = 'none';
}

// Cierra el modal al hacer clic fuera de él (sobre el fondo oscuro)
document.addEventListener('DOMContentLoaded', function() {
    const modalDieta = document.getElementById('modal-editar-dieta');
    if (modalDieta) {
        modalDieta.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalEditarDieta();
        });
    }
});