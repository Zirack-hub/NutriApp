// Abre el modal de edición de un alimento dentro de una dieta y rellena sus campos
// con los valores actuales del alimento seleccionado
function abrirModalEditar(idAlimento, tipo, pesoBruto, pesoNeto, medidasCaseras) {
    // Guarda el id original del alimento para poder identificarlo al actualizar
    document.getElementById('modal-input-id-viejo').value = idAlimento;

    // Establece el tipo de comida (desayuno, comida, cena...)
    document.getElementById('modal-input-tipo').value = tipo;

    // Selecciona el alimento en el desplegable del modal
    document.getElementById('modal-select-alimento').value = idAlimento;

    // Rellena los campos de pesos y medidas con los valores actuales
    document.getElementById('modal-input-bruto').value = pesoBruto;
    document.getElementById('modal-input-neto').value = pesoNeto;
    document.getElementById('modal-input-medidas').value = medidasCaseras;

    // Muestra el modal
    document.getElementById('modal-editar-alimento').style.display = 'flex';
}

// Oculta el modal de edición de alimento
function cerrarModalEditar() {
    document.getElementById('modal-editar-alimento').style.display = 'none';
}

// Cierra el modal al hacer clic fuera de él (sobre el fondo oscuro)
document.addEventListener('DOMContentLoaded', function() {
    const modalEditar = document.getElementById('modal-editar-alimento');
    if (modalEditar) {
        modalEditar.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalEditar();
        });
    }
});