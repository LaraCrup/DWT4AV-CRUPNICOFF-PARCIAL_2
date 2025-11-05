@extends('layouts.admin')

@section('pageTitle', 'Editar Producto')

@section('content')
    <section class="relative">
        <div class="sectionHeader">
            <h1 class="fontTitle">Editar producto</h1>
            <a href="{{ route('admin.tortas.index') }}" class="goBack fontBody">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#f8f7ff" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/>
                </svg>
                Volver a productos
            </a>
        </div>

        <form class="formContainer fontBody" action="{{ route('admin.tortas.update', $torta->id) }}" method="post" enctype="multipart/form-data" id="editProductForm">
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
                        <option value="" disabled>Seleccionar categoría</option>
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
                            <span>Porciones</span>
                            <span>Precio</span>
                        </div>
                        @php
                            $tamanios = $torta->tamanios ?? [];
                            $tamaniosMap = [];
                            foreach($tamanios as $tm) {
                                $tamaniosMap[$tm['nombre']] = $tm;
                            }
                            $sizes = ['Grande', 'Mediana', 'Chica', 'Porción'];
                        @endphp
                        @foreach($sizes as $index => $size)
                            @php
                                $tamanio = $tamaniosMap[$size] ?? null;
                                $isChecked = isset($tamanio);
                                $porciones = old("tamanios_porciones.$index", $tamanio['porciones'] ?? '');
                                $precio = old("tamanios_precios.$index", $tamanio['precio'] ?? '');
                            @endphp
                            <div class="sizeRow">
                                <div class="checkboxItem">
                                    <input type="checkbox" id="size{{ ucfirst(strtolower($size)) }}" name="tamanios_nombres[]" value="{{ $size }}" {{ $isChecked || in_array($size, old('tamanios_nombres', [])) ? 'checked' : '' }}>
                                    <label for="size{{ ucfirst(strtolower($size)) }}">{{ $size }}</label>
                                </div>
                                @if($size === 'Porción')
                                    <input type="number" name="tamanios_porciones[]" placeholder="N° porciones" min="1" value="{{ $porciones }}" readonly>
                                @else
                                    <input type="number" name="tamanios_porciones[]" placeholder="N° porciones" min="1" value="{{ $porciones }}">
                                @endif
                                <input type="number" name="tamanios_precios[]" placeholder="Precio" min="0" step="0.01" value="{{ $precio }}">
                            </div>
                        @endforeach
                    </div>
                    @error('tamanios_nombres')
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
                            <img src="{{ $torta->imagen }}" alt="{{ $torta->nombre }}" width="100">
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
                            $alergenios = $torta->alergenios ?? [];
                            if (is_string($alergenios)) {
                                $alergenios = array_map('trim', explode(',', $alergenios));
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
                    <label for="star5">Popularidad</label>
                    <div class="ratingContainer">
                        <div class="rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="calificacion" value="{{ $i }}" {{ old('calificacion', $torta->calificacion) == $i ? 'checked' : '' }}>
                                <label for="star{{ $i }}">★</label>
                            @endfor
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
                const tamanosGroup = document.querySelector('input[name="tamanios_nombres[]"]').closest('.formGroup');
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
                const tamanosGroup = document.querySelector('input[name="tamanios_nombres[]"]').closest('.formGroup');
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
                errorSpan.textContent = 'Debe seleccionar una popularidad';
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
