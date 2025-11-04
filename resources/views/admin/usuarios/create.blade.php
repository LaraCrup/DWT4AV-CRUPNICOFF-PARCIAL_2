@extends('layouts.admin')

@section('content')
<section>
    <h1 class="fontTitle">Agregar nuevo usuario</h1>
    <form class="formContainer fontBody" action="{{ route('admin.usuarios.store') }}" method="POST" id="createUserForm">
        @csrf

        <div class="formInputs">
            <div class="formGroup">
                <label for="nombre">Nombre completo</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    required
                    placeholder="Nombre y apellido"
                    value="{{ old('nombre') }}"
                    class="@error('nombre') is-invalid @enderror"
                >
                @error('nombre')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="formGroup">
                <label for="email">Correo electrónico</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    placeholder="ejemplo@correo.com"
                    value="{{ old('email') }}"
                    class="@error('email') is-invalid @enderror"
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="formGroup">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="Contraseña"
                    class="@error('password') is-invalid @enderror"
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="formGroup">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    placeholder="Confirmar contraseña"
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
                    <option value="" selected disabled>Seleccionar rol</option>
                    <option value="admin" {{ old('rol') === 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="usuario" {{ old('rol') === 'usuario' ? 'selected' : '' }}>Usuario regular</option>
                </select>
                @error('rol')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="formButtons">
            <button type="submit" class="btn btnPrimary">Crear usuario</button>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btnSecondary">Cancelar</a>
        </div>
    </form>
</section>
@endsection
