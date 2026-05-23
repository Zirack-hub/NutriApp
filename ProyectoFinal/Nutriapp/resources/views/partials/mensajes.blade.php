<div class="toast-container" id="toastContainer">
    @if(session('success'))
        <div class="toast toast-success">
            <span class="toast-icon">✅</span>
            <div class="toast-body">
                <div class="toast-title">¡Éxito!</div>
                <div class="toast-message">{{ session('success') }}</div>
            </div>
            <button class="toast-close" onclick="closeToast(this)">✕</button>
        </div>
    @endif
    @if(session('error'))
        <div class="toast toast-error">
            <span class="toast-icon">❌</span>
            <div class="toast-body">
                <div class="toast-title">Error</div>
                <div class="toast-message">{{ session('error') }}</div>
            </div>
            <button class="toast-close" onclick="closeToast(this)">✕</button>
        </div>
    @endif
    @if($errors->any())
        <div class="toast toast-error">
            <span class="toast-icon">⚠️</span>
            <div class="toast-body">
                <div class="toast-title">Corrige los siguientes errores</div>
                <ul class="toast-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button class="toast-close" onclick="closeToast(this)">✕</button>
        </div>
    @endif
</div>
<script src="{{ asset('assets/js/mensaje_animacion.js') }}"></script>