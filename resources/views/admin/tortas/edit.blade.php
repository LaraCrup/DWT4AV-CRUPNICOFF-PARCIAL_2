@extends('layouts.admin')

@section('pageTitle', 'Editar Producto')

@section('content')
    <section>
        <h1 class="fontTitle">Editar producto</h1>

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

        <form class="formContainer fontBody" action="{{ route('admin.tortas.update', $torta->id) }}" method="post" enctype="multipart/form-data" id="editProductForm" novalidate>
            @csrf
            @method('PUT')
            <div class="formInputs">
                <div class="formGroup">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Nombre del producto" value="{{ old('nombre', $torta->nombre) }}">
                    @error('nombre')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label for="categoria_id">Categoría</label>
                    <select id="categoria_id" name="categoria_id" required>
                        <option value="" selected disabled>Seleccionar categoría</option>
                        @foreach($categorias ?? [] as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $torta->categoria_id) == $categoria->id ? 'selected' : '' }}>
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
                        @php
                            $tamanosPreciosMap = [];
                            foreach ($torta->tamanos as $tam) {
                                $tamanosPreciosMap[$tam->id] = $tam->pivot->precio;
                            }
                        @endphp
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizePorcion" name="tamanos[]" value="1" {{ in_array('1', old('tamanos', array_keys($tamanosPreciosMap))) ? 'checked' : '' }}>
                                <label for="sizePorcion">Porción</label>
                            </div>
                            <input type="number" name="precios[1]" placeholder="Precio" min="0" step="0.01" value="{{ old('precios.1', isset($tamanosPreciosMap[1]) ? (float)$tamanosPreciosMap[1] : '') }}" class="tamano-precio">
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizeChica" name="tamanos[]" value="2" {{ in_array('2', old('tamanos', array_keys($tamanosPreciosMap))) ? 'checked' : '' }}>
                                <label for="sizeChica">Chica</label>
                            </div>
                            <input type="number" name="precios[2]" placeholder="Precio" min="0" step="0.01" value="{{ old('precios.2', isset($tamanosPreciosMap[2]) ? (float)$tamanosPreciosMap[2] : '') }}" class="tamano-precio">
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizeMediana" name="tamanos[]" value="3" {{ in_array('3', old('tamanos', array_keys($tamanosPreciosMap))) ? 'checked' : '' }}>
                                <label for="sizeMediana">Mediana</label>
                            </div>
                            <input type="number" name="precios[3]" placeholder="Precio" min="0" step="0.01" value="{{ old('precios.3', isset($tamanosPreciosMap[3]) ? (float)$tamanosPreciosMap[3] : '') }}" class="tamano-precio">
                        </div>
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="sizeGrande" name="tamanos[]" value="4" {{ in_array('4', old('tamanos', array_keys($tamanosPreciosMap))) ? 'checked' : '' }}>
                                <label for="sizeGrande">Grande</label>
                            </div>
                            <input type="number" name="precios[4]" placeholder="Precio" min="0" step="0.01" value="{{ old('precios.4', isset($tamanosPreciosMap[4]) ? (float)$tamanosPreciosMap[4] : '') }}" class="tamano-precio">
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
                            <input type="file" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div id="selectedFileName" class="selectedFileName">
                            @if($torta->imagen ?? false)
                                {{ basename($torta->imagen) }}
                            @else
                                No hay archivo seleccionado
                            @endif
                        </div>
                        <small class="helperText">Deja este campo vacío si no deseas cambiar la imagen actual.</small>
                    </div>
                    @if($torta->imagen ?? false)
                        <div class="currentImage fontLight">
                            <p><strong>Imagen actual:</strong></p>
                            @php
                                $imagenPath = str_starts_with($torta->imagen, 'storage/') ? '/' . $torta->imagen : '/storage/products/' . basename($torta->imagen);
                            @endphp
                            <img src="{{ $imagenPath }}" alt="{{ $torta->nombre }}" width="100">
                        </div>
                    @endif
                    @error('imagen')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label>Alérgenos</label>
                    <div class="checkboxGroup">
                        @php
                            $alergenios = [];
                            if ($torta->alergeno) {
                                $alergenios = array_map('trim', explode(',', $torta->alergeno));
                            }
                            $allergenOptions = ['Gluten', 'Lácteos', 'Huevo', 'Frutos secos', 'Colorantes'];
                        @endphp
                        @foreach($allergenOptions as $allergen)
                            <div class="checkboxItem">
                                <input type="checkbox" id="allergen{{ str_replace(' ', '', $allergen) }}" name="alergenios[]" value="{{ $allergen }}" {{ in_array($allergen, $alergenios) || in_array($allergen, old('alergenios', [])) ? 'checked' : '' }}>
                                <label for="allergen{{ str_replace(' ', '', $allergen) }}">{{ $allergen }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="formGroup">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Descripción del producto" rows="4">{{ old('descripcion', $torta->descripcion) }}</textarea>
                    @error('descripcion')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="formGroup">
                    <label for="star5">Calificación</label>
                    <div class="ratingContainer">
                        <div class="rating">
                            <input type="radio" id="star5" name="calificacion" value="5" {{ old('calificacion', $torta->calificacion) == '5' ? 'checked' : '' }}>
                            <label for="star5">★</label>
                            <input type="radio" id="star4" name="calificacion" value="4" {{ old('calificacion', $torta->calificacion) == '4' ? 'checked' : '' }}>
                            <label for="star4">★</label>
                            <input type="radio" id="star3" name="calificacion" value="3" {{ old('calificacion', $torta->calificacion) == '3' ? 'checked' : '' }}>
                            <label for="star3">★</label>
                            <input type="radio" id="star2" name="calificacion" value="2" {{ old('calificacion', $torta->calificacion) == '2' ? 'checked' : '' }}>
                            <label for="star2">★</label>
                            <input type="radio" id="star1" name="calificacion" value="1" {{ old('calificacion', $torta->calificacion) == '1' ? 'checked' : '' }}>
                            <label for="star1">★</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="additionalInfo fontLight">
                <div class="infoItem">
                    <span class="infoLabel">ID:</span>
                    <span class="infoValue">#{{ $torta->id }}</span>
                </div>
                <div class="infoItem">
                    <span class="infoLabel">Fecha de creación:</span>
                    <span class="infoValue">{{ $torta->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="infoItem">
                    <span class="infoLabel">Última actualización:</span>
                    <span class="infoValue">{{ $torta->updated_at->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="formButtons">
                <button type="submit" class="btn btnPrimary">Guardar cambios</button>
                <a href="{{ route('admin.tortas.index') }}" class="btn btnSecondary">Cancelar</a>
            </div>
        </form>
    </section>

    <script>
        const form = document.getElementById('editProductForm');

        // Actualizar nombre del archivo seleccionado
        document.getElementById('imagen').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : (document.getElementById('selectedFileName').textContent || 'No hay archivo seleccionado');
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

            // Validar calificación
            const calificacionChecked = document.querySelector('input[name="calificacion"]:checked');
            if (!calificacionChecked) {
                const calificacionGroup = document.querySelector('.ratingContainer').closest('.formGroup');
                const errorSpan = document.createElement('span');
                errorSpan.className = 'error';
                errorSpan.style.cssText = 'color: #dc3545; font-size: 0.875rem; display: block; margin-top: 0.5rem;';
                errorSpan.textContent = 'Debe seleccionar una calificación';
                calificacionGroup.appendChild(errorSpan);
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
