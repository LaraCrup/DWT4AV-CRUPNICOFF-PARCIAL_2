@extends('layouts.admin')

@section('pageTitle', 'Detalles de Categoría')

@section('content')
    <section class="relative">
        <div class="sectionHeader">
            <h1 class="fontTitle">Detalle de categoría</h1>
            <a href="{{ route('admin.categorias.index') }}" class="goBack fontBody">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#f8f7ff" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/>
                </svg>
                Volver a categorías
            </a>
        </div>
        
        <div class="categoryDetail">
            <div class="infoGroup">
                <h2 class="fontTitle">{{ $categoria->nombre }}</h2>
                <div class="categoryInfo fontBody">
                    <p><strong>ID:</strong> {{ $categoria->id }}</p>
                    <p><strong>Fecha de creación:</strong> {{ $categoria->created_at->format('d/m/Y') }}</p>
                    <p><strong>Última actualización:</strong> {{ $categoria->updated_at->format('d/m/Y') }}</p>
                    <p><strong>Cantidad de productos:</strong> {{ $categoria->tortas_count ?? $categoria->tortas->count() }}</p>
                </div>
            </div>
            
            <div class="infoGroup">
                <h3 class="fontTitle">Productos en esta categoría</h3>
                <div class="productsList">
                    @forelse($categoria->tortas ?? [] as $torta)
                        <div class="categoryProduct">
                            <img src="{{ $torta->imagen ?? '/images/placeholder.webp' }}" alt="{{ $torta->nombre ?? $torta->name }}">
                            <p class="fontBody">{{ $torta->nombre ?? $torta->name }}</p>
                        </div>
                    @empty
                        <p class="fontBody" style="text-align: center; padding: 20px;">No hay productos en esta categoría</p>
                    @endforelse
                </div>
            </div>
            
            <div class="actionButtons">
                <a href="{{ route('admin.categorias.edit', $categoria->id) }}" class="btn btnPrimary">Editar categoría</a>
                <button class="btn btnDelete" id="deleteBtn">Eliminar categoría</button>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modalContent">
            <div class="modalHeader">
                <h2 class="fontTitle">Confirmar eliminación</h2>
                <button class="closeModalBtn">&times;</button>
            </div>
            <div class="modalBody fontBody">
                <p>¿Estás seguro que deseas eliminar esta categoría?</p>
                <p id="deleteItemInfo">La categoría "{{ $categoria->nombre }}" será eliminada permanentemente.</p>
            </div>
            <div class="modalFooter">
                <button id="cancelDeleteBtn" class="btn btnSecondary">Cancelar</button>
                <form id="deleteForm" method="POST" action="{{ route('admin.categorias.destroy', $categoria->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btnDelete">Eliminar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Abrir modal de eliminación
        document.getElementById('deleteBtn').addEventListener('click', function() {
            document.getElementById('deleteModal').style.display = 'flex';
        });

        // Cerrar modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        document.querySelector('.closeModalBtn').addEventListener('click', closeDeleteModal);
        document.getElementById('cancelDeleteBtn').addEventListener('click', closeDeleteModal);

        // Cerrar modal al hacer click fuera de él
        document.getElementById('deleteModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
