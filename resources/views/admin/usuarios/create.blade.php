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
                    class="@error('name') is-invalid @enderror"
                >
                @error('name')
                    <span class="error" style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
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
                    class="@error('email') is-invalid @enderror"
                >
                @error('email')
                    <span class="error" style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
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
                    class="@error('password') is-invalid @enderror"
                >
                @error('password')
                    <span class="error" style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
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
                <label for="rol">Rol de usuario</label>
                <select
                    id="rol"
                    name="rol"
                    required
                    class="@error('rol') is-invalid @enderror"
                >
                    <option value="" selected disabled>Selecciona un rol</option>
                    <option value="admin" {{ old('rol') === 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="usuario" {{ old('rol') === 'usuario' ? 'selected' : '' }}>Usuario regular</option>
                </select>
                @error('rol')
                    <span class="error" style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
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
