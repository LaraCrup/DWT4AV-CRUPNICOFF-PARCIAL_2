@extends('layouts.app')

@section('title', 'Ingresar')

@section('styles')
    <link rel="stylesheet" href="/styles/formsStyles.css">
@endsection

@section('content')
    <section>
        <h1 class="fontTitle">Iniciar sesión</h1>

        @if ($errors->any())
            <div class="alert alert-danger fontBody" style="padding: 15px; margin-bottom: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger fontBody" style="padding: 15px; margin-bottom: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24;">
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
                        <span class="error-message" style="color: #dc3545; font-size: 0.875rem; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="formGroup">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        placeholder="Ingresa tu contraseña">
                    @error('password')
                        <span class="error-message" style="color: #dc3545; font-size: 0.875rem; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btnPrimary">Iniciar sesión</button>
        </form>
        <div class="otherOptions">
            <p class="fontBody">¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
            <p class="fontBody">¿Sos un usuario administrador? <a href="{{ route('admin.login') }}">Haz click aquí.</a></p>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="./scripts/formValidation.js"></script>
@endsection
