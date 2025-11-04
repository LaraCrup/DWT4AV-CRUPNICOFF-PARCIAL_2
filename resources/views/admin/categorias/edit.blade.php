@extends('layouts.admin')

@section('content')
    <section>
        <h1 class="fontTitle">Editar categoría</h1>
        <form class="formContainer fontBody" action="{{ route('admin.categorias.update', $categoria->id) }}" method="post" id="editCategoryForm">
            @csrf
            @method('PUT')
            <div class="formInputs">
                <div class="formGroup">
                    <label for="nombre">Nombre de la Categoría</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Nombre de la categoría" value="{{ old('nombre', $categoria->nombre) }}">
                    @error('nombre')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label>Visibilidad</label>
                    <div class="radioGroup">
                        <div class="radioItem">
                            <input type="radio" id="activa" name="activa" value="1" {{ old('activa', $categoria->activa ?? 1) == 1 ? 'checked' : '' }}>
                            <label for="activa">Activa</label>
                        </div>
                        <div class="radioItem">
                            <input type="radio" id="inactiva" name="activa" value="0" {{ old('activa', $categoria->activa ?? 1) == 0 ? 'checked' : '' }}>
                            <label for="inactiva">Oculta</label>
                        </div>
                    </div>
                    @error('activa')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="formGroup">
                    <label>Información adicional</label>
                    <div class="infoGroup fontBody">
                        <p><strong>ID de categoría:</strong> {{ $categoria->id }}</p>
                        <p><strong>Productos vinculados:</strong> {{ $categoria->tortas_count ?? $categoria->tortas->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="formButtons">
                <button type="submit" class="btn btnPrimary">Guardar cambios</button>
                <a href="{{ route('admin.categorias.index') }}" class="btn btnSecondary">Cancelar</a>
            </div>
        </form>
    </section>
@endsection
