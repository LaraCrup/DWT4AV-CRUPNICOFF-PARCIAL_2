@extends('layouts.app')

@section('title', 'Ingresar')

@section('styles')
    <link rel="stylesheet" href="/styles/formsStyles.css">
@endsection

@section('content')
    <section>
        <h1 class="fontTitle">Iniciar sesión</h1>

        @if (session('error'))
            <div class="errorGeneral fontBody">
                {{ session('error') }}
            </div>
        @endif

        <form class="formContainer fontBody" action="{{ route('login.store') }}" method="post" id="loginForm">
            @csrf
            <div class="formInputs">
                <div class="formGroup">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" required
                        placeholder="Ingresa tu correo electrónico" value="{{ old('email') }}">
                    @error('email')
                        <span class="errorMessage">{{ $message }}</span>
                    @enderror
                </div>
                <div class="formGroup">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        placeholder="Ingresa tu contraseña">
                    @error('password')
                        <span class="errorMessage">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btnPrimary">Iniciar sesión</button>
        </form>
        <div class="otherOptions">
            <p class="fontBody">¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="./scripts/formValidation.js"></script>
@endsection
