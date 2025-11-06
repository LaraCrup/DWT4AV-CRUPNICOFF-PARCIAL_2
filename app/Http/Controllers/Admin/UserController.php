<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of all resources.
     */
    public function index()
    {
        $usuarios = User::paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string',
            'rol_id' => 'required|in:1,2'
        ], [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser texto',
            'name.max' => 'El nombre no puede exceder 50 caracteres',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'email.unique' => 'Este email ya está registrado',
            'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser posterior a hoy',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'rol_id.required' => 'El rol es requerido',
            'rol_id.in' => 'El rol seleccionado no es válido',
        ]);

        if ($validated['password'] !== $request->input('password_confirmation')) {
            return redirect()->back()
                ->withErrors(['password_confirmation' => 'Las contraseñas no coinciden'])
                ->withInput();
        }

        $validated['password'] = Hash::make($validated['password']);

        unset($validated['password_confirmation']);

        User::create($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'fecha_nacimiento' => 'nullable|date|before:today',
            'password' => 'nullable|string|min:6',
            'password_confirmation' => 'nullable|string',
            'rol_id' => 'required|in:1,2'
        ], [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser texto',
            'name.max' => 'El nombre no puede exceder 50 caracteres',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'email.unique' => 'Este email ya está registrado',
            'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser posterior a hoy',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'rol_id.required' => 'El rol es requerido',
            'rol_id.in' => 'El rol seleccionado no es válido',
        ]);

        if (!empty($validated['password']) && $validated['password'] !== $request->input('password_confirmation')) {
            return redirect()->back()
                ->withErrors(['password_confirmation' => 'Las contraseñas no coinciden'])
                ->withInput();
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente');
    }
}
