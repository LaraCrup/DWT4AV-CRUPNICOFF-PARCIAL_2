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
                    <button id="editProfileBtn" class="btn btnPrimary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                            <path fill="#f8f7ff" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14zm12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                        </svg>
                    </button>
                </div>
                <div id="profileViewMode" class="fontBody profileInfo">
                    <p><strong>Nombre:</strong> Lara Crupnicoff</p>
                    <p><strong>Email:</strong> lara.crupnicoff@davinci.edu.ar</p>
                    <p><strong>Fecha de nacimiento:</strong> 19/08/2003</p>
                </div>
                <div id="profileEditMode" class="profileInfo hidden fontBody">
                    <div class="formGroup">
                        <label for="userName"><strong>Nombre:</strong></label>
                        <input type="text" id="userName" value="Lara Crupnicoff">
                    </div>
                    <div class="formGroup">
                        <label for="userEmail"><strong>Email:</strong></label>
                        <input type="email" id="userEmail" value="lara.crupnicoff@davinci.edu.ar">
                    </div>
                    <div class="formGroup">
                        <label for="userBirth"><strong>Fecha de nacimiento:</strong></label>
                        <input type="date" id="userBirth" value="2003-08-19">
                    </div>
                    <div class="editActions">
                        <button id="saveProfileBtn" class="btn btnPrimary">Guardar</button>
                        <button id="cancelEditBtn" class="btn cancelButton">Cancelar</button>
                    </div>
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