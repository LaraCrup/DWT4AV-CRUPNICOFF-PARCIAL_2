@extends('layouts.app')

@section('title', $torta->nombre . ' - Tortas Manuela')

@section('styles')
    <link rel="stylesheet" href="/styles/productDetailStyles.css">
@endsection

@section('content')
    <main>
        <section>
            <div>
                <div class="breadcrumbs breadcrumbsMobile fontBody">
                    <a href="{{ route('tortas.index') }}">Todas</a>
                    <span>></span>
                    @if($torta->categoria)
                        <a href="{{ route('tortas.index') }}">{{ $torta->categoria->nombre }}</a>
                        <span>></span>
                    @endif
                    <p>{{ $torta->nombre }}</p>
                </div>
                @if($torta->imagen)
                    <img src="/storage/products/{{ $torta->imagen }}" alt="{{ $torta->nombre }}">
                @else
                    <div class="imagePlaceholder">
                        <span>Sin imagen disponible</span>
                    </div>
                @endif
            </div>
            <div class="productInfo">
                <div class="breadcrumbs breadcrumbsDesktop fontBody">
                    <a href="{{ route('tortas.index') }}">Todas</a>
                    <span>></span>
                    @if($torta->categoria)
                        <a href="{{ route('tortas.index') }}">{{ $torta->categoria->nombre }}</a>
                        <span>></span>
                    @endif
                    <p>{{ $torta->nombre }}</p>
                </div>
                <h1 class="fontTitle">{{ $torta->nombre }}</h1>
                <div class="princeRating">
                    @if($torta->tamanos->count() > 0)
                        <p class="price fontBody">${{ number_format($torta->tamanos->min('pivot.precio'), 2) }}</p>
                    @endif
                    @if($torta->valoracion)
                        <p class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $torta->valoracion)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </p>
                    @endif
                </div>
                @if($torta->tamanos->count() > 0)
                    <div class="sizesContainer">
                        <p class="fontTitle">Tamaño</p>
                        <div>
                            @foreach($torta->tamanos as $tamano)
                                <button class="sizeBtn" data-size-id="{{ $tamano->id }}" data-price="{{ $tamano->pivot->precio }}">
                                    {{ $tamano->nombre }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
                <button id="addToCart" class="btn btnPrimary">Añadir al carrito</button>
                @if($torta->alergeno)
                    <div class="allergens">
                        <p class="fontBody"><strong>Contiene:</strong> {{ $torta->alergeno }}</p>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="/scripts/product.js"></script>
@endsection