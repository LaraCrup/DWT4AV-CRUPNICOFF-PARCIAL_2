@extends('layouts.app')

@section('title', 'Paga los items de tu carrito')

@section('content')
    <section class="confirmationContainer">
        <div class="successIcon">✓</div>
        <h1 class="fontTitle">¡Pago confirmado!</h1>
        <p class="fontBody">Hemos recibido el pago de tu compra correctamente.</p>
        <p class="fontBody">Recibirás la confirmación y el detalle de envío por correo electrónico.</p>
        <a href="{{ route('tortas.index') }}" class="btn btnPrimary btnReturn">Seguir comprando</a>
    </section>
@endsection

@section('scripts')
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
