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
        $tortas = Torta::with(['categoria', 'tamanos'])->paginate(12);

        $categorias = Categoria::all();

        return view('tortas.index', compact('tortas', 'categorias'));
    }

    /**
     * Display the specified resource (detalle de la torta)
     */
    public function show(string $id)
    {
        $torta = Torta::with(['categoria', 'tamanos'])->findOrFail($id);

        $relacionadas = Torta::where('categoria_id', $torta->categoria_id)
                            ->where('id', '!=', $id)
                            ->with(['categoria', 'tamanos'])
                            ->limit(4)
                            ->get();

        return view('tortas.show', compact('torta', 'relacionadas'));
    }

}
