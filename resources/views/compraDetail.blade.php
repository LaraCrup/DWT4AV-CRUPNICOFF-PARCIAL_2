@extends('layouts.app')

@section('title', 'Detalles de Compra #' . $compra->id)

@section('styles')
    <link rel="stylesheet" href="/styles/cartStyles.css">
@endsection

@section('content')
    <section class="cartSection">
        <h1 class="fontTitle">Detalles de la Compra #{{ $compra->id }}</h1>

        <div class="purchaseDetailsContainer">
            <div class="purchaseHeader">
                <div>
                    <p class="fontBody"><strong>Fecha:</strong> {{ $compra->fecha_compra->format('d/m/Y') }}</p>
                    <p class="fontBody"><strong>Cliente:</strong> {{ $compra->usuario->nombre ?? $compra->usuario->name }}</p>
                </div>
                <div class="purchaseTotal">
                    <p class="fontTitle" style="font-size: 1.5rem;">${{ number_format($compra->total, 2) }}</p>
                </div>
            </div>

            <div class="purchaseItemsDetail">
                <h2 class="fontTitle">Productos</h2>

                @foreach($compra->tortas as $torta)
                    <div class="purchaseItemDetail fontBody">
                        <div class="itemInfo">
                            @if($torta->imagen)
                                <img src="/storage/products/{{ $torta->imagen }}" alt="{{ $torta->nombre }}">
                            @else
                                <div class="imagePlaceholder">Sin imagen</div>
                            @endif
                            <div class="itemDetails">
                                <h3>{{ $torta->nombre }}</h3>
                                @if($torta->pivot->tamano)
                                    <p><strong>Tamaño:</strong> {{ $torta->pivot->tamano->nombre }}</p>
                                @endif
                                <p><strong>Cantidad:</strong> {{ $torta->pivot->cantidad }}</p>
                                <p><strong>Precio unitario:</strong> ${{ number_format($torta->pivot->precio_unitario, 2) }}</p>
                            </div>
                        </div>
                        <div class="itemSubtotal">
                            <p class="fontTitle">${{ number_format($torta->pivot->precio_unitario * $torta->pivot->cantidad, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="purchaseActions">
                <a href="{{ route('profile') }}" class="btn btnPrimary">Volver al perfil</a>
            </div>
        </div>
    </section>
@endsection