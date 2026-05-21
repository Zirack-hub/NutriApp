function abrirModalEditarDieta(nombreActual, objetivoActual) {
    document.getElementById('modal-dieta-nombre').value = nombreActual;
    document.getElementById('modal-dieta-objetivo').value = objetivoActual;
    document.getElementById('modal-editar-dieta').style.display = 'flex';
}

function cerrarModalEditarDieta() {
    document.getElementById('modal-editar-dieta').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const modalDieta = document.getElementById('modal-editar-dieta');
    if (modalDieta) {
        modalDieta.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalEditarDieta();
        });
    }
});