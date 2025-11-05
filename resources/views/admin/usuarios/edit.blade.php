@extends('layouts.admin')

@section('pageTitle', 'Editar Usuario')

@section('content')
<section>
    <h1 class="fontTitle">Editar usuario</h1>
    <form class="formContainer fontBody" action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" id="editUserForm">
        @csrf
        @method('PUT')

        <div class="formInputs">
            <div class="formGroup">
                <label for="name">Nombre completo</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    placeholder="Nombre y apellido"
                    value="{{ old('name', $usuario->name) }}"
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
                    placeholder="ejemplo@correo.com"
                    value="{{ old('email', $usuario->email) }}"
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
                    placeholder="Dejar en blanco para mantener la actual"
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
                    placeholder="Confirma tu contraseña"
                >
            </div>

            <div class="formGroup">
                <label for="rol_id">Rol de usuario</label>
                <select
                    id="rol_id"
                    name="rol_id"
                    required
                    class="@error('rol_id') is-invalid @enderror"
                >
                    <option value="" disabled>Selecciona un rol</option>
                    <option value="1" {{ old('rol_id', $usuario->rol_id) == 1 ? 'selected' : '' }}>Administrador</option>
                    <option value="2" {{ old('rol_id', $usuario->rol_id) == 2 ? 'selected' : '' }}>Usuario regular</option>
                </select>
                @error('rol_id')
                    <span class="error" style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="formGroup">
                <label>Información adicional</label>
                <div class="infoGroup fontBody">
                    <p><strong>ID de usuario:</strong> {{ $usuario->id }}</p>
                    <p><strong>Fecha de registro:</strong> {{ $usuario->created_at->format('d/m/Y') }}</p>
                    <p><strong>Compras realizadas:</strong> {{ $usuario->compras()->count() }}</p>
                </div>
            </div>
        </div>

        <div class="formButtons">
            <button type="submit" class="btn btnPrimary">Guardar cambios</button>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btnSecondary">Cancelar</a>
        </div>
    </form>
</section>

@section('scripts')
    <script src="/scripts/formValidation.js"></script>
@endsection
@endsection
