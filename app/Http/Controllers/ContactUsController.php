<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function show()
    {
        return view('contactUs');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string|max:5000'
        ], [
            'titulo.required' => 'El campo título es obligatorio.',
            'titulo.string' => 'El título debe ser un texto válido.',
            'titulo.max' => 'El título no debe exceder los 255 caracteres.',
            'mensaje.required' => 'El campo mensaje es obligatorio.',
            'mensaje.string' => 'El mensaje debe ser un texto válido.',
            'mensaje.max' => 'El mensaje no debe exceder los 5000 caracteres.'
        ]);

        $request->user()->mensajes()->create($validated);

        return redirect()->route('formReceived')->with('success', 'Mensaje enviado correctamente');
    }
}