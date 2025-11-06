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

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->rol_id == 1) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Sesión iniciada correctamente');
            } else {
                return redirect()->route('home')
                    ->with('success', 'Sesión iniciada correctamente');
            }
        }

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
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'date' => 'required|date|before:today',
            'password' => 'required|string|min:6|regex:/[a-zA-Z]/|regex:/[0-9]/|confirmed',
        ], [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser texto',
            'name.max' => 'El nombre no puede exceder 50 caracteres',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'email.unique' => 'Este email ya está registrado',
            'date.required' => 'La fecha de nacimiento es requerida',
            'date.date' => 'La fecha de nacimiento no es válida',
            'date.before' => 'La fecha de nacimiento no puede ser posterior a hoy',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.regex' => 'La contraseña debe contener al menos una letra y un número',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'fecha_nacimiento' => $validated['date'],
                'password' => Hash::make($validated['password']),
                'fecha_registro' => now(),
                'rol_id' => 2,
            ]);

            Auth::login($user);

            return redirect()->route('home')
                ->with('registration_success', 'Registro exitoso. Bienvenido a Tortas Manuela');
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

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Sesión cerrada correctamente');
    }
}
