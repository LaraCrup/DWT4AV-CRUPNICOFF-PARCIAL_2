@extends('layouts.app')

@section('title', 'Registrarse')

@section('styles')
    <link rel="stylesheet" href="/styles/formsStyles.css">
@endsection

@section('content')
    <section>
        <h1 class="fontTitle">Registrarse</h1>
        <form class="formContainer fontBody" action="{{ route('register') }}" method="post" id="registerForm">
            @csrf
            <div class="formInputs">
                <div class="formGroup">
                    <label for="name">Nombre completo</label>
                    <input type="text" id="name" name="name" required
                        placeholder="Ingresa tu nombre completo">
                </div>
                <div class="formGroup">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" required
                        placeholder="Ingresa tu correo electrónico">
                </div>
                <div class="formGroup">
                    <label for="date">Fecha de nacimiento</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="formGroup">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        placeholder="Ingresa tu contraseña">
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
