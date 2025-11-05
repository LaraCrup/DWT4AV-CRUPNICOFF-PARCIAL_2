{{--
    Modal reutilizable para confirmación de eliminación

    @param string $route - Nombre de la ruta (ej: 'admin.categorias.destroy')
    @param string $itemName - Nombre del item a mostrar (ej: 'categoría', 'usuario', 'producto')
    @param string $buttonSelector - Selector CSS de los botones de delete (default: '.deleteBtn')
--}}

<div id="deleteModal" class="modal">
    <div class="modalContent">
        <div class="modalHeader">
            <h2 class="fontTitle">Confirmar eliminación</h2>
            <button class="closeModalBtn" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modalBody fontBody">
            <p>¿Estás seguro que deseas eliminar este elemento?</p>
            <p id="deleteItemInfo">Esta acción no se puede deshacer.</p>
        </div>
        <div class="modalFooter">
            <button id="cancelDeleteBtn" class="btn btnSecondary" onclick="closeDeleteModal()">Cancelar</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btnDelete">Eliminar</button>
            </form>
        </div>
    </div>
</div>

<script>
    const deleteModalConfig = {
        route: "{{ $route }}",
        itemName: "{{ $itemName ?? 'elemento' }}",
        buttonSelector: "{{ '.deleteBtn' }}"
    };

    document.querySelectorAll(deleteModalConfig.buttonSelector).forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const itemName = deleteModalConfig.itemName.charAt(0).toUpperCase() + deleteModalConfig.itemName.slice(1);

            document.getElementById('deleteItemInfo').textContent = `${itemName}: "${nombre}" será eliminada permanentemente.`;
            document.getElementById('deleteForm').action = deleteModalConfig.route.replace(':id', id);
            document.getElementById('deleteModal').style.display = 'flex';
        });
    });

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    document.querySelector('.closeModalBtn').addEventListener('click', closeDeleteModal);
    document.getElementById('cancelDeleteBtn').addEventListener('click', closeDeleteModal);

    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
</script>
