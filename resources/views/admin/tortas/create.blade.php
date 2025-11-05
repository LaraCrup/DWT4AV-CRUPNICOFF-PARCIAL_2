@extends('layouts.admin')

@section('pageTitle', 'Agregar Producto')

@section('content')
    <section>
        <h1 class="fontTitle">Agregar nuevo producto</h1>

        @if ($errors->any())
            <div class="alertError fontBody" style="background-color: #fee; border: 1px solid #fcc; border-radius: 4px; padding: 1rem; margin-bottom: 1rem; color: #c33;">
                <h3 style="margin: 0 0 0.5rem 0; color: #c33;">Errores en el formulario:</h3>
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="formContainer fontBody" action="{{ route('admin.tortas.store') }}" method="post" enctype="multipart/form-data" id="createProductForm" novalidate>
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
                            <span>Precio</span>
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizePorcion" name="tamanos[]" value="1" {{ in_array('1', old('tamanos', [])) ? 'checked' : '' }}>
                                <label for="sizePorcion">Porción</label>
                            </div>
                            <input type="number" name="precios[1]" placeholder="Precio" min="0" step="0.01" value="{{ old('precios.1') }}" class="tamano-precio">
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizeChica" name="tamanos[]" value="2" {{ in_array('2', old('tamanos', [])) ? 'checked' : '' }}>
                                <label for="sizeChica">Chica</label>
                            </div>
                            <input type="number" name="precios[2]" placeholder="Precio" min="0" step="0.01" value="{{ old('precios.2') }}" class="tamano-precio">
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizeMediana" name="tamanos[]" value="3" {{ in_array('3', old('tamanos', [])) ? 'checked' : '' }}>
                                <label for="sizeMediana">Mediana</label>
                            </div>
                            <input type="number" name="precios[3]" placeholder="Precio" min="0" step="0.01" value="{{ old('precios.3') }}" class="tamano-precio">
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizeGrande" name="tamanos[]" value="4" {{ in_array('4', old('tamanos', [])) ? 'checked' : '' }}>
                                <label for="sizeGrande">Grande</label>
                            </div>
                            <input type="number" name="precios[4]" placeholder="Precio" min="0" step="0.01" value="{{ old('precios.4') }}" class="tamano-precio">
                        </div>
                    </div>
                    @error('tamanos')
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
                        <span class="error">{{ $message }}</span>
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

            </div>

            <div class="formButtons">
                <button type="submit" class="btn btnPrimary">Crear producto</button>
                <a href="{{ route('admin.tortas.index') }}" class="btn btnSecondary">Cancelar</a>
            </div>
        </form>
    </section>

    <script>
        const form = document.getElementById('createProductForm');

        // Actualizar nombre del archivo seleccionado
        document.getElementById('imagen').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No hay archivo seleccionado';
            document.getElementById('selectedFileName').textContent = fileName;
        });

        // Habilitar/deshabilitar campos según checkbox de tamaños
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
            // Inicializar estado
            precioInput.disabled = !checkbox.checked;
        });

        // Validación personalizada del formulario
        form.addEventListener('submit', function(e) {
            let hasErrors = false;

            // Limpiar errores previos
            document.querySelectorAll('.formGroup .error').forEach(el => el.remove());
            document.querySelectorAll('.formGroup input, .formGroup select, .formGroup textarea').forEach(el => {
                el.classList.remove('is-invalid');
                el.style.borderColor = '';
                el.style.backgroundColor = '';
            });

            // Validar nombre
            const nombre = document.getElementById('nombre').value.trim();
            if (!nombre) {
                const nombreGroup = document.getElementById('nombre').closest('.formGroup');
                const errorSpan = document.createElement('span');
                errorSpan.className = 'error';
                errorSpan.style.cssText = 'color: #dc3545; font-size: 0.875rem;';
                errorSpan.textContent = 'El nombre del producto es requerido';
                nombreGroup.appendChild(errorSpan);
                document.getElementById('nombre').classList.add('is-invalid');
                hasErrors = true;
            }

            // Validar categoría
            const categoria = document.getElementById('categoria_id').value;
            if (!categoria) {
                const categoriaGroup = document.getElementById('categoria_id').closest('.formGroup');
                const errorSpan = document.createElement('span');
                errorSpan.className = 'error';
                errorSpan.style.cssText = 'color: #dc3545; font-size: 0.875rem;';
                errorSpan.textContent = 'Debe seleccionar una categoría';
                categoriaGroup.appendChild(errorSpan);
                document.getElementById('categoria_id').classList.add('is-invalid');
                hasErrors = true;
            }

            // Validar que al menos un tamaño esté seleccionado
            const tamanosSeleccionados = Array.from(checkboxes).some(cb => cb.checked);
            if (!tamanosSeleccionados) {
                const tamanosGroup = document.querySelector('input[name="tamanos[]"]').closest('.formGroup');
                const errorSpan = document.createElement('span');
                errorSpan.className = 'error';
                errorSpan.style.cssText = 'color: #dc3545; font-size: 0.875rem; display: block; margin-top: 0.5rem;';
                errorSpan.textContent = 'Debe seleccionar al menos un tamaño';
                tamanosGroup.appendChild(errorSpan);
                hasErrors = true;
            }

            // Validar que los tamaños seleccionados tengan precio
            let preciosFaltantes = false;
            checkboxes.forEach((checkbox, index) => {
                if (checkbox.checked && !preciosInputs[index].value) {
                    preciosFaltantes = true;
                }
            });
            if (preciosFaltantes) {
                const tamanosGroup = document.querySelector('input[name="tamanos[]"]').closest('.formGroup');
                if (!tamanosGroup.querySelector('.error-precios')) {
                    const errorSpan = document.createElement('span');
                    errorSpan.className = 'error error-precios';
                    errorSpan.style.cssText = 'color: #dc3545; font-size: 0.875rem; display: block; margin-top: 0.5rem;';
                    errorSpan.textContent = 'Todos los tamaños seleccionados deben tener un precio';
                    tamanosGroup.appendChild(errorSpan);
                }
                hasErrors = true;
            }

            // Validar imagen
            const imagen = document.getElementById('imagen').files;
            if (imagen.length === 0) {
                const imagenGroup = document.getElementById('imagen').closest('.formGroup');
                const errorSpan = document.createElement('span');
                errorSpan.className = 'error';
                errorSpan.style.cssText = 'color: #dc3545; font-size: 0.875rem;';
                errorSpan.textContent = 'Debe seleccionar una imagen';
                imagenGroup.appendChild(errorSpan);
                document.getElementById('imagen').classList.add('is-invalid');
                hasErrors = true;
            }

            // Validar descripción
            const descripcion = document.getElementById('descripcion').value.trim();
            if (!descripcion) {
                const descripcionGroup = document.getElementById('descripcion').closest('.formGroup');
                const errorSpan = document.createElement('span');
                errorSpan.className = 'error';
                errorSpan.style.cssText = 'color: #dc3545; font-size: 0.875rem;';
                errorSpan.textContent = 'La descripción es requerida';
                descripcionGroup.appendChild(errorSpan);
                document.getElementById('descripcion').classList.add('is-invalid');
                hasErrors = true;
            }

            // Validar valoración
            const valoracionChecked = document.querySelector('input[name="valoracion"]:checked');
            if (!valoracionChecked) {
                const valoracionGroup = document.querySelector('.ratingContainer').closest('.formGroup');
                const errorSpan = document.createElement('span');
                errorSpan.className = 'error';
                errorSpan.style.cssText = 'color: #dc3545; font-size: 0.875rem; display: block; margin-top: 0.5rem;';
                errorSpan.textContent = 'Debe seleccionar una valoración';
                valoracionGroup.appendChild(errorSpan);
                hasErrors = true;
            }

            // Si hay errores, prevenimos el envío
            if (hasErrors) {
                e.preventDefault();
                window.scrollTo(0, 0);
            }
        });
    </script>
@endsection
