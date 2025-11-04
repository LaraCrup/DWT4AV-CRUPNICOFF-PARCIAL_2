@extends('layouts.admin')

@section('content')
    <section>
        <h1 class="fontTitle">Agregar nuevo producto</h1>
        <form class="formContainer fontBody" action="{{ route('admin.tortas.store') }}" method="post" enctype="multipart/form-data" id="createProductForm">
            @csrf
            <div class="formInputs">
                <div class="formGroup">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Nombre del producto" value="{{ old('nombre') }}">
                    @error('nombre')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label for="categoria_id">Categoría</label>
                    <select id="categoria_id" name="categoria_id" required>
                        <option value="" selected disabled>Seleccionar categoría</option>
                        @foreach($categorias ?? [] as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label>Tamaños disponibles</label>
                    <div class="sizeGroup fontBody">
                        <div class="sizeHeader">
                            <span>Tamaño</span>
                            <span>Porciones</span>
                            <span>Precio</span>
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizeGrande" name="tamanios_nombres[]" value="Grande" {{ in_array('Grande', old('tamanios_nombres', [])) ? 'checked' : '' }}>
                                <label for="sizeGrande">Grande</label>
                            </div>
                            <input type="number" name="tamanios_porciones[]" placeholder="N° porciones" min="1" value="{{ old('tamanios_porciones.0') }}">
                            <input type="number" name="tamanios_precios[]" placeholder="Precio" min="0" step="0.01" value="{{ old('tamanios_precios.0') }}">
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizeMediana" name="tamanios_nombres[]" value="Mediana" {{ in_array('Mediana', old('tamanios_nombres', [])) ? 'checked' : '' }}>
                                <label for="sizeMediana">Mediana</label>
                            </div>
                            <input type="number" name="tamanios_porciones[]" placeholder="N° porciones" min="1" value="{{ old('tamanios_porciones.1') }}">
                            <input type="number" name="tamanios_precios[]" placeholder="Precio" min="0" step="0.01" value="{{ old('tamanios_precios.1') }}">
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizeChica" name="tamanios_nombres[]" value="Chica" {{ in_array('Chica', old('tamanios_nombres', [])) ? 'checked' : '' }}>
                                <label for="sizeChica">Chica</label>
                            </div>
                            <input type="number" name="tamanios_porciones[]" placeholder="N° porciones" min="1" value="{{ old('tamanios_porciones.2') }}">
                            <input type="number" name="tamanios_precios[]" placeholder="Precio" min="0" step="0.01" value="{{ old('tamanios_precios.2') }}">
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizePorcion" name="tamanios_nombres[]" value="Porción" {{ in_array('Porción', old('tamanios_nombres', [])) ? 'checked' : '' }}>
                                <label for="sizePorcion">Porción</label>
                            </div>
                            <input type="number" name="tamanios_porciones[]" value="1" readonly>
                            <input type="number" name="tamanios_precios[]" placeholder="Precio" min="0" step="0.01" value="{{ old('tamanios_precios.3') }}">
                        </div>
                    </div>
                    @error('tamanios_nombres')
                        <span class="error">{{ $message }}</span>
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
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label>Alérgenos</label>
                    <div class="checkboxGroup">
                        <div class="checkboxItem">
                            <input type="checkbox" id="allergenGluten" name="alergenios[]" value="Gluten" {{ in_array('Gluten', old('alergenios', [])) ? 'checked' : '' }}>
                            <label for="allergenGluten">Gluten</label>
                        </div>
                        <div class="checkboxItem">
                            <input type="checkbox" id="allergenDairy" name="alergenios[]" value="Lácteos" {{ in_array('Lácteos', old('alergenios', [])) ? 'checked' : '' }}>
                            <label for="allergenDairy">Lácteos</label>
                        </div>
                        <div class="checkboxItem">
                            <input type="checkbox" id="allergenEgg" name="alergenios[]" value="Huevo" {{ in_array('Huevo', old('alergenios', [])) ? 'checked' : '' }}>
                            <label for="allergenEgg">Huevo</label>
                        </div>
                        <div class="checkboxItem">
                            <input type="checkbox" id="allergenNuts" name="alergenios[]" value="Frutos secos" {{ in_array('Frutos secos', old('alergenios', [])) ? 'checked' : '' }}>
                            <label for="allergenNuts">Frutos secos</label>
                        </div>
                        <div class="checkboxItem">
                            <input type="checkbox" id="allergenColorants" name="alergenios[]" value="Colorantes" {{ in_array('Colorantes', old('alergenios', [])) ? 'checked' : '' }}>
                            <label for="allergenColorants">Colorantes</label>
                        </div>
                    </div>
                </div>

                <div class="formGroup">
                    <label for="star5">Popularidad</label>
                    <div class="ratingContainer">
                        <div class="rating">
                            <input type="radio" id="star5" name="calificacion" value="5" {{ old('calificacion') == '5' ? 'checked' : '' }}>
                            <label for="star5">★</label>
                            <input type="radio" id="star4" name="calificacion" value="4" {{ old('calificacion') == '4' ? 'checked' : '' }}>
                            <label for="star4">★</label>
                            <input type="radio" id="star3" name="calificacion" value="3" {{ old('calificacion') == '3' ? 'checked' : '' }}>
                            <label for="star3">★</label>
                            <input type="radio" id="star2" name="calificacion" value="2" {{ old('calificacion') == '2' ? 'checked' : '' }}>
                            <label for="star2">★</label>
                            <input type="radio" id="star1" name="calificacion" value="1" {{ old('calificacion') == '1' ? 'checked' : '' }}>
                            <label for="star1">★</label>
                        </div>
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
        // Actualizar nombre del archivo seleccionado
        document.getElementById('imagen').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No hay archivo seleccionado';
            document.getElementById('selectedFileName').textContent = fileName;
        });

        // Habilitar/deshabilitar campos según checkbox
        const checkboxes = document.querySelectorAll('input[name="tamanios_nombres[]"]');
        const porcionesInputs = document.querySelectorAll('input[name="tamanios_porciones[]"]');
        const preciosInputs = document.querySelectorAll('input[name="tamanios_precios[]"]');

        checkboxes.forEach((checkbox, index) => {
            checkbox.addEventListener('change', function() {
                porcionesInputs[index].disabled = !this.checked;
                preciosInputs[index].disabled = !this.checked;
            });
            // Inicializar estado
            porcionesInputs[index].disabled = !checkbox.checked;
            preciosInputs[index].disabled = !checkbox.checked;
        });
    </script>
@endsection
