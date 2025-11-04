@extends('layouts.admin')

@section('content')
    <section>
        <h1 class="fontTitle">Agregar nueva categoría</h1>
        <form class="formContainer fontBody" action="{{ route('admin.categorias.store') }}" method="post" id="createCategoryForm">
            @csrf
            <div class="formInputs">
                <div class="formGroup">
                    <label for="nombre">Nombre de la Categoría</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Nombre de la categoría" value="{{ old('nombre') }}">
                    @error('nombre')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label>Visibilidad</label>
                    <div class="radioGroup">
                        <div class="radioItem">
                            <input type="radio" id="activa" name="activa" value="1" {{ old('activa', '1') == '1' ? 'checked' : '' }}>
                            <label for="activa">Activa</label>
                        </div>
                        <div class="radioItem">
                            <input type="radio" id="inactiva" name="activa" value="0" {{ old('activa') == '0' ? 'checked' : '' }}>
                            <label for="inactiva">Oculta</label>
                        </div>
                    </div>
                    @error('activa')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="formButtons">
                <button type="submit" class="btn btnPrimary">Crear categoría</button>
                <a href="{{ route('admin.categorias.index') }}" class="btn btnSecondary">Cancelar</a>
            </div>
        </form>
    </section>
@endsection
