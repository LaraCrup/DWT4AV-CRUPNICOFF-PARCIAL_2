@extends('layouts.app')

@section('title', 'Nuestras Tortas - Tortas Manuela')

@section('styles')
    <link rel="stylesheet" href="/styles/productsStyles.css">
@endsection

@section('content')
    <section class="hero">
        <h1 class="fontTitle">Nuestros productos</h1>
        <p class="fontBody">Descubre la deliciosa variedad de tortas que ofrecemos para cada ocasión especial.</p>
    </section>
    <section class="productsSection">
        <div class="filters">
            <button type="button" class="btn" onclick="document.getElementById('filters-content').classList.toggle('show')">
                Filtros
            </button>
            <div id="filters-content" style="display:none;">
                <h2 class="fontTitle">Filtros</h2>
                <div>
                    <span class="fontTitle">Categoría</span>
                    @forelse($categorias as $categoria)
                        <label><input type="checkbox" name="categoria" value="{{ $categoria->id }}" data-category-id="{{ $categoria->id }}"> {{ $categoria->nombre }}</label>
                    @empty
                        <p class="fontBody">Sin categorías disponibles</p>
                    @endforelse
                </div>
                <div>
                    <label for="precio-max" class="fontTitle">Precio máximo</label>
                    <input type="range" id="precio-max" name="precio-max" min="0" max="10000" step="100" value="10000" oninput="document.getElementById('precio-max-value').textContent = this.value">
                    <span id="precio-max-value">10000</span>
                </div>
                <div>
                    <span class="fontTitle">Popularidad</span>
                    <label><input type="checkbox" name="valoracion" value="alta" data-min="4"> Alta (4+)</label>
                    <label><input type="checkbox" name="valoracion" value="media" data-min="2"> Media (2+)</label>
                    <label><input type="checkbox" name="valoracion" value="baja" data-min="0"> Baja (0+)</label>
                </div>
            </div>
        </div>
        <div class="products" id="products">
            @forelse($tortas as $torta)
                <div class="productCard" data-id="{{ $torta->id }}" data-category="{{ $torta->categoria_id }}" data-price="{{ $torta->tamanos->min('pivot.precio') ?? 0 }}" data-rating="{{ $torta->valoracion ?? 0 }}">
                    <div class="productImage">
                        @if($torta->imagen)
                            <img src="/storage/products/{{ $torta->imagen }}" alt="{{ $torta->nombre }}">
                        @else
                            <div class="imagePlaceholder">
                                <span>Sin imagen</span>
                            </div>
                        @endif
                    </div>
                    <div class="productInfo">
                        <h3 class="fontTitle">{{ $torta->nombre }}</h3>

                        @if($torta->categoria)
                            <p class="productCategory fontBody">{{ $torta->categoria->nombre }}</p>
                        @endif

                        @if($torta->valoracion)
                            <div class="productRating fontBody">
                                <span>⭐ {{ number_format($torta->valoracion, 1) }}/5</span>
                            </div>
                        @endif

                        @if($torta->tamanos->count() > 0)
                            <p class="productPrice fontBody">
                                Desde ${{ number_format($torta->tamanos->min('pivot.precio'), 2) }}
                            </p>
                        @endif

                        @if($torta->alergeno)
                            <p class="productAlergeno fontBody" title="Contiene alérgenos">
                                ⚠️ {{ $torta->alergeno }}
                            </p>
                        @endif

                        <a href="{{ route('tortas.show', $torta->id) }}" class="btn btnPrimary">
                            Ver detalle
                        </a>
                    </div>
                </div>
            @empty
                <div class="noProducts">
                    <p class="fontTitle">No hay tortas disponibles</p>
                </div>
            @endforelse
        </div>
    </section>

    @if($tortas->hasPages())
        <div class="paginationContainer">
            {{ $tortas->links() }}
        </div>
    @endif
@endsection

@section('scripts')
    <script src="/scripts/productsFilter.js"></script>
@endsection
