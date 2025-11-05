@extends('layouts.admin')

@section('pageTitle', 'Detalles del Usuario')

@section('content')
<section class="relative">
    <h1 class="fontTitle">Detalle de usuario</h1>
    <a href="{{ route('admin.usuarios.index') }}" class="goBack fontBody">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
            <path fill="#f8f7ff" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/>
        </svg>
        Volver a usuarios
    </a>
    <div class="profileCard">
        <h2 class="fontTitle">Datos personales</h2>
        <div class="profileInfo fontBody">
            <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
            <p><strong>Email:</strong> {{ $usuario->email }}</p>
            <p><strong>Fecha de registro:</strong> {{ $usuario->created_at->format('d/m/Y') }}</p>
        </div>
    </div>
</section>

<section>
    <h2 class="fontTitle">Historial de Compras</h2>
    <div class="tableContainer">
        <table class="dataTable fontBody">
            <thead>
                <tr>
                    <th>ID Compra</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Tamaño</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuario->compras ?? [] as $compra)
                <tr>
                    <td>#{{ $compra->id }}</td>
                    <td>{{ $compra->created_at->format('d/m/Y') }}</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>${{ number_format($compra->total ?? 0, 0, ',', '.') }}</td>
                    <td>
                        <span class="statusPending">Compra registrada</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        <p class="fontBody">No hay compras registradas para este usuario</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
