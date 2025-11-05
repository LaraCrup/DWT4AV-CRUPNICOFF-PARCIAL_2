@extends('layouts.admin')

@section('pageTitle', 'Agregar Categoría')

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
                        <span class="errorMessage">{{ $message }}</span>
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
