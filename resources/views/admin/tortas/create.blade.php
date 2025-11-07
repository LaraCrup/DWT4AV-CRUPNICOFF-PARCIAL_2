@extends('layouts.admin')

@section('pageTitle', 'Agregar Producto')

@section('content')
    <section>
        <h1 class="fontTitle">Agregar nuevo producto</h1>

        <form class="formContainer fontBody" action="{{ route('admin.tortas.store') }}" method="post" enctype="multipart/form-data" id="createProductForm" novalidate>
            @csrf
            <div class="formInputs">
                <div class="formGroup">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Nombre del producto" value="{{ old('nombre') }}">
                    @error('nombre')
                        <span class="errorMessage">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label for="categoria_id">Categoría</label>
                    <select id="categoria_id" name="categoria_id" required>
                        <option value="" disabled>Seleccionar categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <span class="errorMessage">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label>Tamaños disponibles</label>
                    <div class="sizeGroup fontBody">
                        <div class="sizeHeader">
                            <span>Tamaño</span>
                            <span>Precio</span>
                        </div>
                        @foreach($tamanos as $tamano)
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="size{{ $tamano->id }}" name="tamanos[]" value="{{ $tamano->id }}" {{ in_array((string)$tamano->id, old('tamanos', [])) ? 'checked' : '' }}>
                                <label for="size{{ $tamano->id }}">{{ $tamano->nombre }}</label>
                            </div>
                            <input type="number" name="precios[{{ $tamano->id }}]" placeholder="Precio" min="0" step="0.01" value="{{ old('precios.' . $tamano->id) }}" class="tamano-precio">
                        </div>
                        @endforeach
                    </div>
                    @error('tamanos')
                        <span class="errorMessage">{{ $message }}</span>
                    @enderror
                    @error('precios.*')
                        <span class="errorMessage">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label for="imagen">Imagen del producto</label>
                    <div class="imageUploadContainer">
                        <div class="customFileInput">
                            <input type="file" id="imagen" name="imagen" accept="image/*" required>
                        </div>
                        <div id="selectedFileName" class="selectedFileName">No hay archivo seleccionado</div>
                    </div>
                    @error('imagen')
                        <span class="errorMessage">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label>Alérgenos</label>
                    <div class="checkboxGroup">
                        @php
                            $allergenOptions = ['Gluten', 'Lácteos', 'Huevo', 'Frutos secos', 'Colorantes'];
                        @endphp
                        @foreach($allergenOptions as $allergen)
                            <div class="checkboxItem">
                                <input type="checkbox" id="allergen{{ str_replace(' ', '', $allergen) }}" name="alergenios[]" value="{{ $allergen }}" {{ in_array($allergen, old('alergenios', [])) ? 'checked' : '' }}>
                                <label for="allergen{{ str_replace(' ', '', $allergen) }}">{{ $allergen }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="formGroup">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Descripción del producto" rows="4" required>{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <span class="errorMessage">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label for="star5">Valoración</label>
                    <div class="ratingContainer">
                        <div class="rating">
                            <input type="radio" id="star5" name="valoracion" value="5" {{ old('valoracion') == '5' ? 'checked' : '' }}>
                            <label for="star5">★</label>
                            <input type="radio" id="star4" name="valoracion" value="4" {{ old('valoracion') == '4' ? 'checked' : '' }}>
                            <label for="star4">★</label>
                            <input type="radio" id="star3" name="valoracion" value="3" {{ old('valoracion') == '3' ? 'checked' : '' }}>
                            <label for="star3">★</label>
                            <input type="radio" id="star2" name="valoracion" value="2" {{ old('valoracion') == '2' ? 'checked' : '' }}>
                            <label for="star2">★</label>
                            <input type="radio" id="star1" name="valoracion" value="1" {{ old('valoracion') == '1' ? 'checked' : '' }}>
                            <label for="star1">★</label>
                        </div>
                    </div>
                </div>

                <div class="formGroup">
                    <div class="checkboxItem">
                        <input type="checkbox" id="destacada" name="destacada" value="1" {{ old('destacada') ? 'checked' : '' }}>
                        <label for="destacada">Destacar este producto</label>
                    </div>
                </div>

            </div>

            <div class="formButtons">
                <button type="submit" class="btn btnPrimary">Crear producto</button>
                <a href="{{ route('admin.tortas.index') }}" class="btn btnSecondary">Cancelar</a>
            </div>
        </form>
    </section>

    <script>
        document.getElementById('imagen').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No hay archivo seleccionado';
            document.getElementById('selectedFileName').textContent = fileName;
        });

        const checkboxes = document.querySelectorAll('input[name="tamanos[]"]');
        const preciosInputs = document.querySelectorAll('.tamano-precio');

        checkboxes.forEach((checkbox, index) => {
            const precioInput = preciosInputs[index];
            checkbox.addEventListener('change', function() {
                precioInput.disabled = !this.checked;
                if (!this.checked) {
                    precioInput.value = '';
                }
            });
            precioInput.disabled = !checkbox.checked;
        });
    </script>
@endsection
