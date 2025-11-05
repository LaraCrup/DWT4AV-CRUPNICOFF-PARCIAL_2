<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::with('tortas')->paginate(15);
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50|unique:categorias,nombre'
        ],[
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.unique' => 'El nombre de la categoría ya existe. Por favor, elige otro nombre.',
            'nombre.max' => 'El nombre de la categoría no debe exceder los 50 caracteres.'
        ]);

        Categoria::create($validated);

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = Categoria::with('tortas')->findOrFail($id);
        return view('admin.categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = Categoria::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:50|unique:categorias,nombre,' . $id
        ],[
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.unique' => 'El nombre de la categoría ya existe. Por favor, elige otro nombre.',
            'nombre.max' => 'El nombre de la categoría no debe exceder los 50 caracteres.'
        ]);

        $categoria->update($validated);

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->tortas()->count() > 0) {
            return redirect()->route('admin.categorias.show', $id)->with('error', 'No se puede eliminar una categoría que tiene productos asociados. Por favor, elimina los productos primero.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada exitosamente');
    }
}
