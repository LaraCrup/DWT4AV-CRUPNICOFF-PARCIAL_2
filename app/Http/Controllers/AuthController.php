<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Procesa el login del usuario
     */
    public function login(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|regex:/[a-zA-Z]/|regex:/[0-9]/',
        ], [
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.regex' => 'La contraseña debe contener al menos una letra y un número',
        ]);

        // Intentar autenticar
        if (Auth::attempt($validated)) {
            // Regenerar sesión para evitar session fixation
            $request->session()->regenerate();

            return redirect()->route('home')
                ->with('success', 'Sesión iniciada correctamente');
        }

        // Si fallan las credenciales
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Las credenciales no coinciden con nuestros registros');
    }

    /**
     * Muestra el formulario de registro
     */
    public function showRegister()
    {
        return view('register');
    }

    /**
     * Procesa el registro del usuario
     */
    public function register(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'date' => 'required|date',
            'password' => 'required|string|min:6|regex:/[a-zA-Z]/|regex:/[0-9]/|confirmed',
        ], [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser texto',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'email.unique' => 'Este email ya está registrado',
            'date.required' => 'La fecha de nacimiento es requerida',
            'date.date' => 'La fecha de nacimiento no es válida',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.regex' => 'La contraseña debe contener al menos una letra y un número',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        try {
            // Crear el usuario con rol_id = 2 (Usuario normal)
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'fecha_nacimiento' => $validated['date'],
                'password' => Hash::make($validated['password']),
                'fecha_registro' => now(),
                'rol_id' => 2,
            ]);

            // Autenticar al usuario inmediatamente después del registro
            Auth::login($user);

            return redirect()->route('home')
                ->with('success', 'Registro exitoso. Bienvenido a Tortas Manuela');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al registrar el usuario: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidar la sesión
        $request->session()->invalidate();

        // Regenerar token CSRF
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Sesión cerrada correctamente');
    }
}
