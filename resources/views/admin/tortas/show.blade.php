@extends('layouts.admin')

@section('pageTitle', 'Detalles del Producto')

@push('styles')
    <link rel="stylesheet" href="/styles/productViewStyles.css">
@endpush

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
                <img src="{{ asset('storage/products/' . $torta->imagen) }}" alt="{{ $torta->nombre }}" class="productImage">
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
                        <span class="starsTable">
                            @for($i = 0; $i < intval($torta->valoracion); $i++)
                                ★
                            @endfor
                            @for($i = intval($torta->valoracion); $i < 5; $i++)
                                ☆
                            @endfor
                        </span> <span>({{ $torta->valoracion }}/5)</span> 
                    </div>
                </div>

                <div class="infoGroup">
                    <h3 class="fontTitle">Alérgenos</h3>
                    <div class="allergensList fontBody">
                        @if($torta->alergeno)
                            @php
                                $alergenios = explode(',', $torta->alergeno);
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
                    @if($torta->tamanos && count($torta->tamanos) > 0)
                        <table class="dataTable fontBody" style="margin-top: 0.5rem;">
                            <thead>
                                <tr>
                                    <th>Tamaño</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($torta->tamanos as $tamano)
                                    <tr>
                                        <td>{{ $tamano->nombre }}</td>
                                        <td>${{ $tamano->pivot->precio }}</td>
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
                    <button class="btn btnDelete deleteBtn" data-id="{{ $torta->id }}" data-nombre="{{ $torta->nombre }}">Eliminar producto</button>
                </div>
            </div>
        </div>
    </section>

    @include('partials.deleteModal', [
        'route' => route('admin.tortas.destroy', ':id'),
        'itemName' => 'producto'
    ])

@endsection