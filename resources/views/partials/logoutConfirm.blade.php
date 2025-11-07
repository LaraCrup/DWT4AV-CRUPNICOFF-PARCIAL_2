<div id="logoutModal" class="logoutModal">
    <div class="logoutModalContent">
        <h2 class="fontTitle">¿Estás seguro de que deseas salir?</h2>
        <div class="logoutModalActions">
            <button type="button" class="btn" onclick="closeLogoutConfirm()">Cancelar</button>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btnPrimary">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</div>

<script>
function openLogoutConfirm() {
    document.getElementById('logoutModal').classList.add('show');
}

function closeLogoutConfirm() {
    document.getElementById('logoutModal').classList.remove('show');
}

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('logoutModal');
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeLogoutConfirm();
        }
    });
});
</script>
