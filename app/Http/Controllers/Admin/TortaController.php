<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Torta;
use App\Models\Categoria;
use Illuminate\Http\Request;

class TortaController extends Controller
{
    /**
     * Display a listing of all tortas (Admin)
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
        return view('admin.tortas.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'valoracion' => 'required|numeric|min:1|max:5',
            'alergenios' => 'nullable|array',
            'descripcion' => 'required|string',
            'tamanos' => 'required|array|min:1',
            'tamanos.*' => 'exists:tamanos,id',
            'precios' => 'required|array',
            'precios.*' => 'nullable|numeric|min:0'
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('products', 'public');
            $validated['imagen'] = basename($path);
        }

        // Convertir alérgenos de array a string separado por comas
        if (!empty($validated['alergenios'])) {
            $validated['alergeno'] = implode(', ', $validated['alergenios']);
        } else {
            $validated['alergeno'] = null;
        }
        unset($validated['alergenios']);

        // Crear la torta
        $torta = Torta::create($validated);

        // Asociar tamaños con precios
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
        return view('admin.tortas.edit', compact('torta', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $torta = Torta::findOrFail($id);

        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'calificacion' => 'required|numeric|min:1|max:5',
            'alergenios' => 'nullable|array',
            'descripcion' => 'nullable|string',
            'tamanos' => 'required|array|min:1',
            'tamanos.*' => 'exists:tamanos,id',
            'precios' => 'required|array',
            'precios.*' => 'nullable|numeric|min:0'
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('tortas', 'public');
            $validated['imagen'] = $path;
        }

        // Convertir alérgenos de array a string separado por comas
        if (!empty($validated['alergenios'])) {
            $validated['alergeno'] = implode(', ', $validated['alergenios']);
        } else {
            $validated['alergeno'] = null;
        }
        unset($validated['alergenios']);

        $torta->update($validated);

        // Asociar tamaños con precios
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
