@extends('layouts.admin')

@section('pageTitle', 'Editar Producto')

@section('content')
    <section>
        <h1 class="fontTitle">Editar producto</h1>

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
                        @foreach($categorias as $categoria)
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
                        @foreach($tamanos as $tamano)
                        <div class="sizeRow">
                            <div class="checkboxItem">
                                <input type="checkbox" id="size{{ $tamano->id }}" name="tamanos[]" value="{{ $tamano->id }}" {{ in_array((string)$tamano->id, old('tamanos', array_keys($tamanosPreciosMap))) ? 'checked' : '' }}>
                                <label for="size{{ $tamano->id }}">{{ $tamano->nombre }}</label>
                            </div>
                            <input type="number" name="precios[{{ $tamano->id }}]" placeholder="Precio" min="0" step="0.01" value="{{ old('precios.' . $tamano->id, isset($tamanosPreciosMap[$tamano->id]) ? (float)$tamanosPreciosMap[$tamano->id] : '') }}" class="tamano-precio">
                        </div>
                        @endforeach
                    </div>
                    @error('tamanos')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    @error('precios.*')
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
                            <img src="/storage/products/{{ $torta->imagen }}" alt="{{ $torta->nombre }}" width="100">
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
                    <label for="star5">Valoración</label>
                    <div class="ratingContainer">
                        <div class="rating">
                            @php
                                $valoracionActual = old('valoracion', $torta->valoracion ?? null);
                            @endphp
                            <input type="radio" id="star5" name="valoracion" value="5" {{ (int)$valoracionActual === 5 ? 'checked' : '' }}>
                            <label for="star5">★</label>
                            <input type="radio" id="star4" name="valoracion" value="4" {{ (int)$valoracionActual === 4 ? 'checked' : '' }}>
                            <label for="star4">★</label>
                            <input type="radio" id="star3" name="valoracion" value="3" {{ (int)$valoracionActual === 3 ? 'checked' : '' }}>
                            <label for="star3">★</label>
                            <input type="radio" id="star2" name="valoracion" value="2" {{ (int)$valoracionActual === 2 ? 'checked' : '' }}>
                            <label for="star2">★</label>
                            <input type="radio" id="star1" name="valoracion" value="1" {{ (int)$valoracionActual === 1 ? 'checked' : '' }}>
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
        document.getElementById('imagen').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : (document.getElementById('selectedFileName').textContent || 'No hay archivo seleccionado');
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
