@extends('layouts.app')

@section('title', 'Registrarse')

@section('styles')
    <link rel="stylesheet" href="/styles/formsStyles.css">
@endsection

@section('content')
    <section>
        <h1 class="fontTitle">Registrarse</h1>

        @if (session('error'))
            <div class="alert alert-danger fontBody" style="padding: 15px; margin-bottom: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24;">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success fontBody" style="padding: 15px; margin-bottom: 20px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; color: #155724;">
                {{ session('success') }}
            </div>
        @endif

        <form class="formContainer fontBody" action="{{ route('register.store') }}" method="post" id="registerForm">
            @csrf
            <div class="formInputs">
                <div class="formGroup">
                    <label for="name">Nombre completo</label>
                    <input type="text" id="name" name="name" required
                        placeholder="Ingresa tu nombre completo"
                        value="{{ old('name') }}"
                        class="@error('name') is-invalid @enderror">
                    @error('name')
                        <span class="error" style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="formGroup">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" required
                        placeholder="Ingresa tu correo electrónico"
                        value="{{ old('email') }}"
                        class="@error('email') is-invalid @enderror">
                    @error('email')
                        <span class="error" style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="formGroup">
                    <label for="date">Fecha de nacimiento</label>
                    <input type="date" id="date" name="date" required
                        value="{{ old('date') }}"
                        class="@error('date') is-invalid @enderror">
                    @error('date')
                        <span class="error" style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="formGroup">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        placeholder="Ingresa tu contraseña"
                        class="@error('password') is-invalid @enderror">
                    @error('password')
                        <span class="error" style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="formGroup">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        placeholder="Confirma tu contraseña"
                        class="@error('password_confirmation') is-invalid @enderror">
                    @error('password_confirmation')
                        <span class="error" style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btnPrimary">Registrate</button>
        </form>
        <div class="otherOptions">
            <p class="fontBody">¿Ya tienes una cuenta? <a href="{{ route('login') }}">Ingresá</a></p>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="./scripts/formValidation.js"></script>
@endsection
