@extends('layouts.admin')

@section('content')
<section>
    <h1 class="fontTitle">Editar usuario</h1>
    <form class="formContainer fontBody" action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" id="editUserForm">
        @csrf
        @method('PUT')

        <div class="formInputs">
            <div class="formGroup">
                <label for="nombre">Nombre completo</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    required
                    placeholder="Nombre y apellido"
                    value="{{ old('nombre', $usuario->nombre) }}"
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
                    value="{{ old('email', $usuario->email) }}"
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
                    placeholder="Dejar en blanco para mantener la actual"
                    class="@error('password') is-invalid @enderror"
                >
                <small class="helperText">Deja este campo en blanco si no deseas cambiar la contraseña.</small>
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
                    <option value="" disabled>Seleccionar rol</option>
                    <option value="admin" {{ old('rol', $usuario->rol) === 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="usuario" {{ old('rol', $usuario->rol) === 'usuario' ? 'selected' : '' }}>Usuario regular</option>
                </select>
                @error('rol')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="formGroup">
                <label>Información adicional</label>
                <div class="infoGroup fontBody">
                    <p><strong>ID de usuario:</strong> {{ $usuario->id }}</p>
                    <p><strong>Fecha de registro:</strong> {{ $usuario->created_at->format('d/m/Y') }}</p>
                    <p><strong>Compras realizadas:</strong> {{ $usuario->cantidad_compras ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="formButtons">
            <button type="submit" class="btn btnPrimary">Guardar cambios</button>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btnSecondary">Cancelar</a>
        </div>
    </form>
</section>
@endsection
