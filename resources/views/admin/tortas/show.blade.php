@extends('layouts.admin')

@section('content')
    <section class="relative">
        <div class="sectionHeader">
            <h1 class="fontTitle">Detalle del producto</h1>
            <a href="{{ route('admin.tortas.index') }}" class="goBack fontBody">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#f8f7ff" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/>
                </svg>
                Volver a productos
            </a>
        </div>

        <div class="productDetail">
            <div class="productImageContainer">
                @if($torta->imagen ?? false)
                    <img src="{{ $torta->imagen }}" alt="{{ $torta->nombre }}" class="productImage">
                @else
                    <img src="/images/placeholder.webp" alt="Sin imagen" class="productImage">
                @endif
            </div>

            <div class="productInfo">
                <h2 class="fontTitle">{{ $torta->nombre }}</h2>

                <div class="infoGroup fontBody">
                    <p><strong>ID:</strong> #{{ $torta->id }}</p>
                    <p><strong>Categoría:</strong> {{ $torta->categoria->nombre ?? 'Sin categoría' }}</p>
                    <p><strong>Fecha de creación:</strong> {{ $torta->created_at->format('d/m/Y') }}</p>
                    <p><strong>Última actualización:</strong> {{ $torta->updated_at->format('d/m/Y') }}</p>
                </div>

                <div class="infoGroup">
                    <h3 class="fontTitle">Popularidad</h3>
                    <div class="starsContainer fontBody">
                        @if($torta->calificacion ?? false)
                            <span class="starsTable">
                                @for($i = 0; $i < intval($torta->calificacion); $i++)
                                    ★
                                @endfor
                                @for($i = intval($torta->calificacion); $i < 5; $i++)
                                    ☆
                                @endfor
                            </span> ({{ $torta->calificacion }}/5)
                        @else
                            Sin calificación
                        @endif
                    </div>
                </div>

                <div class="infoGroup">
                    <h3 class="fontTitle">Alérgenos</h3>
                    <div class="allergensList fontBody">
                        @if($torta->alergenios)
                            @php
                                $alergenios = is_array($torta->alergenios) ? $torta->alergenios : explode(',', $torta->alergenios);
                            @endphp
                            @foreach($alergenios as $alergenico)
                                <span class="allergenTag">{{ trim($alergenico) }}</span>
                            @endforeach
                        @else
                            <p>Sin alérgenos especificados</p>
                        @endif
                    </div>
                </div>

                <div class="infoGroup">
                    <h3 class="fontTitle">Tamaños y Precios</h3>
                    @if($torta->tamanios && is_array($torta->tamanios) && count($torta->tamanios) > 0)
                        <table class="dataTable fontBody">
                            <thead>
                                <tr>
                                    <th>Tamaño</th>
                                    <th>Porciones</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($torta->tamanios as $tamanio)
                                    <tr>
                                        <td>{{ $tamanio['nombre'] ?? '' }}</td>
                                        <td>{{ $tamanio['porciones'] ?? '0' }}</td>
                                        <td>${{ $tamanio['precio'] ?? '0' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="fontBody">No hay tamaños configurados</p>
                    @endif
                </div>

                <div class="actionButtons">
                    <a href="{{ route('admin.tortas.edit', $torta->id) }}" class="btn btnPrimary">Editar producto</a>
                    <button class="btn btnDelete" id="deleteBtn">Eliminar producto</button>
                </div>
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
                <p>¿Estás seguro que deseas eliminar este producto?</p>
                <p id="deleteItemInfo">El producto "{{ $torta->nombre }}" será eliminado permanentemente.</p>
            </div>
            <div class="modalFooter">
                <button id="cancelDeleteBtn" class="btn btnSecondary">Cancelar</button>
                <form id="deleteForm" method="POST" action="{{ route('admin.tortas.destroy', $torta->id) }}" style="display: inline;">
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
