function abrirModalEditar(idAlimento, tipo, pesoBruto, pesoNeto, medidasCaseras) {
    document.getElementById('modal-input-id-viejo').value = idAlimento;
    document.getElementById('modal-input-tipo').value = tipo;
    
    document.getElementById('modal-select-alimento').value = idAlimento;
    
    document.getElementById('modal-input-bruto').value = pesoBruto;
    document.getElementById('modal-input-neto').value = pesoNeto;
    document.getElementById('modal-input-medidas').value = medidasCaseras;

    document.getElementById('modal-editar-alimento').style.display = 'flex';
}

function cerrarModalEditar() {
    document.getElementById('modal-editar-alimento').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const modalEditar = document.getElementById('modal-editar-alimento');
    if (modalEditar) {
        modalEditar.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalEditar();
        });
    }
});