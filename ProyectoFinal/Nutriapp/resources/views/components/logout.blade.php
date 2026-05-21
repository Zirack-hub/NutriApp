<button type="button" class="nav-logout"
        onclick="document.getElementById('logout-overlay').style.display='flex'">
    Cerrar sesión
</button>

<div id="logout-overlay" class="logout-overlay">
  <div class="logout-modal">

    <div class="logout-modal-icon">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0F6E56" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 8v-2a2 2 0 0 0-2-2h-7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2"/>
        <path d="M9 12h12m0 0l-3-3m3 3l-3 3"/>
      </svg>
    </div>

    <p class="logout-modal-title">¿Cerrar sesión?</p>
    <p class="logout-modal-text">Tu sesión se cerrará y tendrás que volver a iniciar sesión para acceder.</p>

    <div class="logout-modal-actions">
      <button class="logout-btn-cancel"
              onclick="document.getElementById('logout-overlay').style.display='none'">
        Cancelar
      </button>
      <button class="logout-btn-confirm"
              onclick="document.getElementById('logout-form').submit()">
        Sí, cerrar sesión
      </button>
    </div>

  </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="GET" style="display:none;"></form>