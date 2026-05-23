// Cierra un toast manualmente al pulsar el botón de cerrar.
// Aplica la animación de salida y elimina el elemento del DOM tras completarse
function closeToast(btn) {
    const toast = btn.closest('.toast');
    toast.style.animation = 'slideOut 0.3s ease forwards';
    setTimeout(() => toast.remove(), 300);
}

// Recorre todos los toasts visibles y los cierra automáticamente tras 5 segundos,
// siempre que sigan presentes en el DOM en ese momento
document.querySelectorAll('.toast').forEach(toast => {
    setTimeout(() => {
        if (toast.isConnected) {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
});