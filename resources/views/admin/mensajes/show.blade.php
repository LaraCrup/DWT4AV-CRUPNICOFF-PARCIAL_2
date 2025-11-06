@extends('layouts.admin')

@section('pageTitle', 'Detalles de Mensaje')

@section('content')

<section class="relative">
    <div class="sectionHeader">
        <h1 class="fontTitle">Detalle de mensaje</h1>
        <a href="{{ route('admin.mensajes.index') }}" class="goBack fontBody">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                <path fill="#f8f7ff" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
            </svg>
            Volver a mensajes
        </a>
    </div>

    <div class="messageDetail">
        <div class="infoGroup">
            <div class="messageInfo fontBody">
                <p><strong>Usuario:</strong> {{ $mensaje->usuario->name ?? 'Usuario desconocido' }}</p>
                <p><strong>Email:</strong> {{ $mensaje->usuario->email ?? 'N/A' }}</p>
                <p><strong>Fecha de envío:</strong> {{ $mensaje->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="infoGroup">
            <h2 class="fontTitle">{{ $mensaje->titulo }}</h2>
            <div class="messageContent fontBody">
                {{ $mensaje->mensaje }}
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
    <style>
        .messageDetail{
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
        }

        .infoGroup{
            width: 100%;
            max-width: 800px;
        }

        .infoGroup h2{
            margin-bottom: 1rem;
        }
    </style>
@endpush