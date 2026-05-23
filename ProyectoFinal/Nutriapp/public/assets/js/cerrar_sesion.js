// Muestra un diálogo de confirmación con SweetAlert2 antes de cerrar la sesión.
// Se llama desde el botón de logout en lugar de enviar el formulario directamente
function confirmarLogout(event) {
    event.preventDefault(); // Evita que el botón ejecute cualquier acción por defecto

    Swal.fire({
        title: '¿Cerrar sesión?',
        text: 'Tu sesión se cerrará y tendrás que volver a introducir tus credenciales para acceder.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#52b788',
        cancelButtonColor: '#ff5f5f',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar',
        background: 'rgba(255, 255, 255, 0.95)',
        customClass: {
            popup: 'logout-popup-box' // Clase CSS personalizada por si se quieren añadir estilos extra
        }
    }).then((result) => {
        // Si el usuario confirma, envía el formulario de logout de Laravel
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}