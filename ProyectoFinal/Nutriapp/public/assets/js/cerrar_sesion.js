function confirmarLogout(event) {
    event.preventDefault(); // Evita cualquier comportamiento extraño del botón

    Swal.fire({
        title: '¿Cerrar sesión?',
        text: 'Tu sesión se cerrará y tendrás que volver a introducir tus credenciales para acceder.',
        icon: 'question', // Usamos el icono de pregunta en lugar de peligro/advertencia
        showCancelButton: true,
        confirmButtonColor: '#52b788', // El verde claro esmeralda que elegimos
        cancelButtonColor: '#ff5f5f',  // Rojo suave para cancelar
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar',
        background: 'rgba(255, 255, 255, 0.95)',
        customClass: {
            popup: 'logout-popup-box' // Por si en el futuro quieres meterle estilos personalizados
        }
    }).then((result) => {
        // Si el usuario hace clic en el botón verde de confirmación
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}