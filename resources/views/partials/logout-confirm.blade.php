<!-- Logout Confirmation Modal -->
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

<style>
.logoutModal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    animation: fadeIn 0.3s ease;
}

.logoutModal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.logoutModalContent {
    max-width: 500px;
    width: 90%;
    background-color: var(--color-light);
    text-align: center;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    padding: 2rem;
    animation: slideUp 0.3s ease;
}

.logoutModalContent h2 {
    margin-bottom: 1rem;
    color: var(--color-dark);
}

.logoutModalContent p {
    margin-bottom: 2rem;
    color: var(--color-dark);
}

.logoutModalActions {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1rem;
}

.logoutModalActions .btn {
    color: var(--color-primary);
    background-color: transparent;
    border: 1px solid var(--color-primary);
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0.75rem 1.5rem;
}

.logoutModalActions .btn:hover {
    background-color: var(--color-dark);
    border: 1px solid var(--color-dark);
    color: var(--color-light);
}

.logoutModalActions .btn.btnPrimary {
    background-color: var(--color-primary);
    color: var(--color-light);
    border: none;
}

.logoutModalActions .btn.btnPrimary:hover {
    opacity: 0.9;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

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
