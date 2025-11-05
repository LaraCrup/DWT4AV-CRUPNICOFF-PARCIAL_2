@extends('layouts.admin')

@section('pageTitle', 'Detalles de Categoría')

@section('content')

<section class="relative">
    <div class="sectionHeader">
        <h1 class="fontTitle">Detalle de categoría</h1>
        <a href="{{ route('admin.categorias.index') }}" class="goBack fontBody">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                <path fill="#f8f7ff" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
            </svg>
            Volver a categorías
        </a>
    </div>

    @if ($message = Session::get('error'))
    <div class="errorGeneral fontBody">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="categoryDetail">
        <div class="infoGroup">
            <h2 class="fontTitle">{{ $categoria->nombre }}</h2>
            <div class="categoryInfo fontBody">
                <p><strong>ID:</strong> {{ $categoria->id }}</p>
                <p><strong>Fecha de creación:</strong> {{ $categoria->created_at->format('d/m/Y') }}</p>
                <p><strong>Última actualización:</strong> {{ $categoria->updated_at->format('d/m/Y') }}</p>
                <p><strong>Cantidad de productos:</strong> {{ $categoria->tortas->count() }}</p>
            </div>
        </div>

        <div class="infoGroup">
            <h3 class="fontTitle">Productos en esta categoría</h3>
            <div class="productsList">
                @forelse($categoria->tortas as $torta)
                <div class="categoryProduct">
                    <img src="{{ asset('storage/products/' . $torta->imagen) }}" alt="{{ $torta->nombre }}">
                    <p class="fontBody">{{ $torta->nombre }}</p>
                </div>
                @empty
                <p class="fontBody noRecords ">No hay productos en esta categoría</p>
                @endforelse
            </div>
        </div>

        <div class="actionButtons">
            <a href="{{ route('admin.categorias.edit', $categoria->id) }}" class="btn btnPrimary">Editar categoría</a>
            @if($categoria->tortas->count() === 0)
                <button class="btn btnDelete deleteBtn" data-id="{{ $categoria->id }}" data-nombre="{{ $categoria->nombre }}">Eliminar categoría</button>
            @else
                <div class="alertInfo">
                    <p class="fontBody">
                        Esta categoría tiene {{ $categoria->tortas->count() }} producto(s) asociado(s) y no puede ser eliminada hasta que todos los productos sean removidos.
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>

@include('partials.deleteModal', [
    'route' => route('admin.categorias.destroy', ':id'),
    'itemName' => 'categoría'
])
@endsection