function closeToast(btn) {
        const toast = btn.closest('.toast');
        toast.style.animation = 'slideOut 0.3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    }

    document.querySelectorAll('.toast').forEach(toast => {
        setTimeout(() => {
            if (toast.isConnected) {
                toast.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    });