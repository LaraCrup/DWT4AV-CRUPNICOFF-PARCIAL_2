@extends('layouts.app')

@section('title', 'Mensaje Recibido - Tortas Manuela')

@section('content')
    <section class="confirmationContainer">
        <div class="successIcon">✓</div>
        <h1 class="fontTitle">¡Mensaje recibido!</h1>
        <p class="fontBody">Gracias <span id="userName" class="name-display"></span> por contactarnos. Hemos recibido tu mensaje correctamente.</p>
        <p class="fontBody">Nos pondremos en contacto contigo a la brevedad posible a través del correo electrónico proporcionado.</p>
        <a href="{{ route('home') }}" class="btn btnPrimary btnReturn">Volver al inicio</a>
    </section>
@endsection

@section('scripts')
    <script src="./scripts/formReceived.js"></script>
@endsection

@push('styles')
    <style>
        .confirmationContainer {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            text-align: center;
        }

        .successIcon {
            color: var(--color-accent);
            font-size: 60px;
        }

        .btnReturn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            text-decoration: none;
        }

        .name-display {
            font-weight: bold;
        }
    </style>
@endpush
