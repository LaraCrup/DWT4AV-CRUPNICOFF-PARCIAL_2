<?php

namespace App\Http\Controllers;

use App\Models\Torta;
use App\Models\Categoria;
use Illuminate\Http\Request;

class TortaController extends Controller
{
    /**
     * Display a listing of all tortas (catálogo)
     */
    public function index()
    {
        // Obtener todas las tortas con relaciones
        $tortas = Torta::with(['categoria', 'tamanos'])->paginate(12);

        // Obtener todas las categorías para filtrado opcional
        $categorias = Categoria::all();

        return view('tortas.index', compact('tortas', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource (detalle de la torta)
     */
    public function show(string $id)
    {
        // Obtener la torta con sus relaciones
        $torta = Torta::with(['categoria', 'tamanos'])->findOrFail($id);

        // Obtener tortas relacionadas de la misma categoría
        $relacionadas = Torta::where('categoria_id', $torta->categoria_id)
                            ->where('id', '!=', $id)
                            ->with(['categoria', 'tamanos'])
                            ->limit(4)
                            ->get();

        return view('tortas.show', compact('torta', 'relacionadas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
