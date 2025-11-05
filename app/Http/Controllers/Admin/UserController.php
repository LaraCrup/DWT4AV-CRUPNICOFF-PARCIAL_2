<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of all users (Admin)
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string',
            'rol_id' => 'required|in:1,2'
        ]);

        // Validate password match
        if ($validated['password'] !== $request->input('password_confirmation')) {
            return redirect()->back()
                ->withErrors(['password_confirmation' => 'Las contraseñas no coinciden'])
                ->withInput();
        }

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Remove password_confirmation from validated data
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'password_confirmation' => 'nullable|string',
            'rol_id' => 'required|in:1,2'
        ]);

        // Validate password match if password is provided
        if (!empty($validated['password']) && $validated['password'] !== $request->input('password_confirmation')) {
            return redirect()->back()
                ->withErrors(['password_confirmation' => 'Las contraseñas no coinciden'])
                ->withInput();
        }

        // Only hash password if provided
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
