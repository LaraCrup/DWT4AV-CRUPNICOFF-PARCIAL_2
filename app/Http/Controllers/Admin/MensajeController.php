<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mensaje;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mensajes = Mensaje::with('usuario')->paginate(15);
        return view('admin.mensajes.index', compact('mensajes'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mensaje = Mensaje::with('usuario')->findOrFail($id);
        return view('admin.mensajes.show', compact('mensaje'));
    }
}
