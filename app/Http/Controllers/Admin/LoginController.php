<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show()
    {
        return view('admin.login');
    }

    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'El correo electrónico debe ser válido',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ]);

        // TODO: Implementar autenticación real con la base de datos
        // Por ahora, redirige al dashboard
        return redirect()->route('admin.dashboard')->with('success', 'Sesión iniciada correctamente');
    }
}
