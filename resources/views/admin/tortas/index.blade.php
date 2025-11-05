@extends('layouts.admin')

@section('pageTitle', 'Productos')

@section('content')
<section>
    <div class="sectionHeader">
        <h1 class="fontTitle">Administrar Productos</h1>
        <a href="{{ route('admin.tortas.create') }}" class="btn btnPrimary">Agregar Producto</a>
    </div>

    <div class="tableContainer">
        <table class="fontBody">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Tamaños y precios</th>
                    <th>Alérgenos</th>
                    <th>Popularidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tortas as $torta)
                <tr>
                    <td>{{ $torta->id }}</td>
                    <td>
                        <img src="{{ asset('storage/products/' . $torta->imagen) }}" alt="{{ $torta->nombre }}" width="100%">
                    </td>
                    <td>{{ $torta->nombre }}</td>
                    <td>{{ $torta->categoria->nombre }}</td>
                    <td>
                        @foreach($torta->tamanos as $tamano)
                        <p>{{ $tamano->nombre }}: ${{ $tamano->pivot->precio }}</p>
                        @endforeach
                    </td>
                    <td>{{ $torta->alergeno ?? 'Sin alérgenos' }}</td>
                    <td class="starsTable">
                        @for($i = 0; $i < intval($torta->valoracion); $i++)
                            ★
                            @endfor
                            @for($i = intval($torta->valoracion); $i < 5; $i++)
                                ☆
                            @endfor
                    </td>
                    <td>
                        <div>
                            <a href="{{ route('admin.tortas.show', $torta->id) }}" class="btn btnSee">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="#f8f7ff" d="M12 16q1.875 0 3.188-1.312T16.5 11.5t-1.312-3.187T12 7T8.813 8.313T7.5 11.5t1.313 3.188T12 16m0-1.8q-1.125 0-1.912-.788T9.3 11.5t.788-1.912T12 8.8t1.913.788t.787 1.912t-.787 1.913T12 14.2m0 4.8q-3.35 0-6.113-1.8t-4.362-4.75q-.125-.225-.187-.462t-.063-.488t.063-.488t.187-.462q1.6-2.95 4.363-4.75T12 4t6.113 1.8t4.362 4.75q.125.225.188.463t.062.487t-.062.488t-.188.462q-1.6 2.95-4.362 4.75T12 19m0-2q2.825 0 5.188-1.487T20.8 11.5q-1.25-2.525-3.613-4.012T12 6T6.813 7.488T3.2 11.5q1.25 2.525 3.613 4.013T12 17" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.tortas.edit', $torta->id) }}" class="btn btnPrimary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="#f8f7ff"
                                        d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                                </svg>
                            </a>
                            <button class="btn btnDelete deleteBtn" data-id="{{ $torta->id }}" data-nombre="{{ $torta->nombre }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="#f8f7ff"
                                        d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zm-7 11q.425 0 .713-.288T11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17m4 0q.425 0 .713-.288T15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17M7 6v13z" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="noRecords">
                        <p>No hay productos disponibles.</p>
                        <a href="{{ route('admin.tortas.create') }}">Crear uno nuevo</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@include('partials.deleteModal', [
    'route' => route('admin.tortas.destroy', ':id'),
    'itemName' => 'producto'
])
@endsection