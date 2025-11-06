<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Torta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TortaController extends Controller
{
    /**
     * Display a listing of all resources.
     */
    public function index()
    {
        $tortas = Torta::with(['categoria', 'tamanos'])->paginate(15);
        return view('admin.tortas.index', compact('tortas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        $tamanos = \App\Models\Tamano::all();
        return view('admin.tortas.create', compact('categorias', 'tamanos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:50',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'valoracion' => 'required|integer|min:1|max:5',
            'alergenios' => 'nullable|array',
            'descripcion' => 'required|string',
            'destacada' => 'nullable|boolean',
            'tamanos' => 'required|array|min:1',
            'tamanos.*' => 'exists:tamanos,id',
            'precios' => 'required|array',
            'precios.*' => 'required|numeric|min:0.01'
        ], [
            'categoria_id.required' => 'La categoría es requerida.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'nombre.required' => 'El nombre del producto es requerido.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede exceder 50 caracteres.',
            'imagen.required' => 'La imagen es requerida.',
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif, webp.',
            'imagen.max' => 'La imagen no puede pesar más de 2MB.',
            'valoracion.required' => 'La valoración es requerida.',
            'valoracion.numeric' => 'La valoración debe ser un número.',
            'valoracion.min' => 'La valoración debe ser al menos 1.',
            'valoracion.max' => 'La valoración no puede ser mayor a 5.',
            'descripcion.required' => 'La descripción es requerida.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',
            'tamanos.required' => 'Debe seleccionar al menos un tamaño.',
            'tamanos.array' => 'Los tamaños deben ser un array.',
            'tamanos.min' => 'Debe seleccionar al menos un tamaño.',
            'tamanos.*.exists' => 'Uno de los tamaños seleccionados no existe.',
            'precios.required' => 'Los precios son requeridos.',
            'precios.array' => 'Los precios deben ser un array.',
            'precios.*.required' => 'Debe ingresar un precio para cada tamaño seleccionado.',
            'precios.*.numeric' => 'Los precios deben ser números válidos.',
            'precios.*.min' => 'Los precios no pueden ser menores a 0.01.',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('products', 'public');
            $validated['imagen'] = basename($path);
        }

        if (!empty($validated['alergenios'])) {
            $validated['alergeno'] = implode(', ', $validated['alergenios']);
        } else {
            $validated['alergeno'] = null;
        }
        unset($validated['alergenios']);

        $validated['destacada'] = isset($validated['destacada']) ? (bool)$validated['destacada'] : false;

        $torta = Torta::create($validated);

        $tamanos = $request->input('tamanos', []);
        $precios = $request->input('precios', []);

        foreach ($tamanos as $tamanoId) {
            $precio = $precios[$tamanoId] ?? 0;
            if ($precio > 0) {
                $torta->tamanos()->attach($tamanoId, ['precio' => $precio]);
            }
        }

        return redirect()->route('admin.tortas.index')->with('success', 'Torta creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $torta = Torta::with(['categoria', 'tamanos'])->findOrFail($id);
        return view('admin.tortas.show', compact('torta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $torta = Torta::with('tamanos')->findOrFail($id);
        $categorias = Categoria::all();
        $tamanos = \App\Models\Tamano::all();
        return view('admin.tortas.edit', compact('torta', 'categorias', 'tamanos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $torta = Torta::findOrFail($id);

        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:50',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'valoracion' => 'required|integer|min:1|max:5',
            'alergenios' => 'nullable|array',
            'descripcion' => 'nullable|string',
            'destacada' => 'nullable|boolean',
            'tamanos' => 'required|array|min:1',
            'tamanos.*' => 'exists:tamanos,id',
            'precios' => 'required|array',
            'precios.*' => 'required|numeric|min:0.01'
        ], [
            'categoria_id.required' => 'La categoría es requerida.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'nombre.required' => 'El nombre del producto es requerido.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede exceder 50 caracteres.',
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif.',
            'imagen.max' => 'La imagen no puede pesar más de 2MB.',
            'valoracion.required' => 'La valoración es requerida.',
            'valoracion.numeric' => 'La valoración debe ser un número.',
            'valoracion.min' => 'La valoración debe ser al menos 1.',
            'valoracion.max' => 'La valoración no puede ser mayor a 5.',
            'tamanos.required' => 'Debe seleccionar al menos un tamaño.',
            'tamanos.array' => 'Los tamaños deben ser un array.',
            'tamanos.min' => 'Debe seleccionar al menos un tamaño.',
            'tamanos.*.exists' => 'Uno de los tamaños seleccionados no existe.',
            'precios.required' => 'Los precios son requeridos.',
            'precios.array' => 'Los precios deben ser un array.',
            'precios.*.required' => 'Debe ingresar un precio para cada tamaño seleccionado.',
            'precios.*.numeric' => 'Los precios deben ser números válidos.',
            'precios.*.min' => 'Los precios no pueden ser menores a 0.01.',
        ]);

        if ($request->hasFile('imagen')) {
            if (Storage::disk('public')->exists('products/' . $torta->imagen)) {
                Storage::disk('public')->delete('products/' . $torta->imagen);
            }
            $path = $request->file('imagen')->store('products', 'public');
            $validated['imagen'] = basename($path);
        }

        if (!empty($validated['alergenios'])) {
            $validated['alergeno'] = implode(', ', $validated['alergenios']);
        } else {
            $validated['alergeno'] = null;
        }
        unset($validated['alergenios']);

        $validated['destacada'] = isset($validated['destacada']) ? (bool)$validated['destacada'] : false;

        $torta->update($validated);

        $tamanos = $request->input('tamanos', []);
        $precios = $request->input('precios', []);

        $tamanoData = [];
        foreach ($tamanos as $tamanoId) {
            $precio = $precios[$tamanoId] ?? 0;
            if ($precio > 0) {
                $tamanoData[$tamanoId] = ['precio' => $precio];
            }
        }
        $torta->tamanos()->sync($tamanoData);

        return redirect()->route('admin.tortas.index')->with('success', 'Torta actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $torta = Torta::findOrFail($id);
        $torta->delete();

        return redirect()->route('admin.tortas.index')->with('success', 'Torta eliminada exitosamente');
    }
}
