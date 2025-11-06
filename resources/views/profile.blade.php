@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('styles')
    <link rel="stylesheet" href="/styles/profileStyles.css">
@endsection

@section('content')
    <section class="profileSection">
        <h2 class="fontTitle">Datos personales</h2>
        <div class="profileCard">
            <img src="/storage/shared/profile.png" alt="Foto de perfil" class="profilePic">
            <div>
                <div class="profileHeader">
                    <h3 class="fontTitle">Información personal</h3>
                </div>
                <div class="fontBody profileInfo">
                    <p><strong>Nombre:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Fecha de nacimiento:</strong> {{ $user->fecha_nacimiento ? \Carbon\Carbon::parse($user->fecha_nacimiento)->format('d/m/Y') : 'No especificada' }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="historySection">
        <h2 class="fontTitle">Historial de Compras</h2>

        @php
            $compras = auth()->user()->compras()->with('tortas')->orderBy('fecha_compra', 'desc')->get();
        @endphp

        @if($compras->count() > 0)
            <div class="purchasesContainer">
                @foreach($compras as $compra)
                    <div class="purchaseCard fontBody">
                        <div class="purchaseInfo">
                            <div>
                                <p><strong>Compra #{{ $compra->id }}</strong></p>
                                <p>Fecha: {{ $compra->fecha_compra->format('d/m/Y') }}</p>
                            </div>
                            <div class="purchaseTotal">
                                <p class="fontTitle">${{ number_format($compra->total, 2) }}</p>
                            </div>
                        </div>
                        <div class="purchaseItems">
                            <ul>
                                @foreach($compra->tortas as $torta)
                                    <li>
                                        {{ $torta->nombre }}
                                        @if($torta->pivot->tamano)
                                            ({{ $torta->pivot->tamano->nombre }})
                                        @endif
                                        - Cantidad: {{ $torta->pivot->cantidad }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <a href="{{ route('compras.show', $compra->id) }}" class="btn btnPrimary btnSmall">Ver detalle</a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="emptyState">
                <p class="fontBody">Aún no has realizado ninguna compra.</p>
                <a href="{{ route('tortas.index') }}" class="btn btnPrimary">Ir a comprar</a>
            </div>
        @endif
    </section>
@endsection

@section('scripts')
    <script src="./scripts/profile.js"></script>
@endsection
