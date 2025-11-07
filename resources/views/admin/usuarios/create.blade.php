@extends('layouts.admin')

@section('pageTitle', 'Agregar Usuario')

@section('content')
<section>
    <h1 class="fontTitle">Agregar nuevo usuario</h1>
    <form class="formContainer fontBody" action="{{ route('admin.usuarios.store') }}" method="POST" id="createUserForm">
        @csrf

        <div class="formInputs">
            <div class="formGroup">
                <label for="name">Nombre completo</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    placeholder="Ingresa el nombre completo"
                    value="{{ old('name') }}"
                >
                @error('name')
                    <span class="errorMessage">{{ $message }}</span>
                @enderror
            </div>

            <div class="formGroup">
                <label for="email">Correo electrónico</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    placeholder="Ingresa el correo electrónico"
                    value="{{ old('email') }}"
                >
                @error('email')
                    <span class="errorMessage">{{ $message }}</span>
                @enderror
            </div>

            <div class="formGroup">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input
                    type="date"
                    id="fecha_nacimiento"
                    name="fecha_nacimiento"
                    value="{{ old('fecha_nacimiento') }}"
                >
                @error('fecha_nacimiento')
                    <span class="errorMessage">{{ $message }}</span>
                @enderror
            </div>

            <div class="formGroup">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="Ingresa una contraseña"
                >
                @error('password')
                    <span class="errorMessage">{{ $message }}</span>
                @enderror
            </div>

            <div class="formGroup">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    placeholder="Confirma tu contraseña"
                >
            </div>

            <div class="formGroup">
                <label for="rol_id">Rol de usuario</label>
                <select
                    id="rol_id"
                    name="rol_id"
                    required
                >
                    <option value="" disabled>Selecciona un rol</option>
                    <option value="1" {{ old('rol_id') == 1 ? 'selected' : '' }}>Administrador</option>
                    <option value="2" {{ old('rol_id') == 2 ? 'selected' : '' }}>Usuario regular</option>
                </select>
                @error('rol_id')
                    <span class="errorMessage">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="formButtons">
            <button type="submit" class="btn btnPrimary">Crear usuario</button>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btnSecondary">Cancelar</a>
        </div>
    </form>
</section>

@section('scripts')
    <script src="/scripts/formValidation.js"></script>
@endsection
@endsection
